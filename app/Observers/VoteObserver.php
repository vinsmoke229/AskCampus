<?php

namespace App\Observers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use App\Models\Vote;
use App\Notifications\VoteReceived;

class VoteObserver
{
    /**
     * Événement déclenché lors de la création d'un vote
     */
    public function created(Vote $vote): void
    {
        $this->updateReputation($vote, 'add');
        $this->sendNotification($vote);
    }

    /**
     * Événement déclenché lors de la mise à jour d'un vote
     */
    public function updated(Vote $vote): void
    {
        // Récupérer l'ancienne valeur du vote
        $oldValue = $vote->getOriginal('value');
        $newValue = $vote->value;

        // Retirer l'ancienne réputation
        $this->updateReputation($vote, 'remove', $oldValue);

        // Ajouter la nouvelle réputation
        $this->updateReputation($vote, 'add', $newValue);

        // Envoyer notification pour le nouveau vote
        $this->sendNotification($vote);
    }

    /**
     * Événement déclenché lors de la suppression d'un vote
     */
    public function deleted(Vote $vote): void
    {
        $this->updateReputation($vote, 'remove');

        // Rembourser la pénalité si c'était un vote négatif
        if ($vote->value < 0) {
            $voter = User::find($vote->user_id);
            if ($voter) {
                $voter->increment('reputation', 1);
            }
        }
    }

    /**
     * Envoie une notification à l'auteur du contenu voté
     */
    private function sendNotification(Vote $vote): void
    {
        $votable = $vote->votable;
        
        if (!$votable || !$votable->user) {
            return;
        }

        // Ne pas notifier si l'utilisateur vote sur son propre contenu
        if ($vote->user_id === $votable->user->id) {
            return;
        }

        // Déterminer le type et récupérer la question
        if ($votable instanceof Question) {
            $votableType = 'question';
            $questionId = $votable->id;
            $title = $votable->title;
        } else {
            $votableType = 'réponse';
            $questionId = $votable->question_id;
            $title = $votable->question->title;
        }

        // Envoyer la notification
        $votable->user->notify(new VoteReceived(
            votableType: $votableType,
            votableId: $votable->id,
            votableTitle: $title,
            value: $vote->value,
            questionId: $questionId
        ));
    }

    /**
     * Met à jour la réputation de l'auteur du contenu voté
     */
    private function updateReputation(Vote $vote, string $action, ?int $value = null): void
    {
        $value = $value ?? $vote->value;

        // Récupérer l'entité votée (Question ou Answer)
        $votable = $vote->votable;

        if (!$votable) {
            return;
        }

        // Récupérer l'auteur du contenu voté
        $author = $votable->user;

        if (!$author) {
            return;
        }

        // Distinguer Question vs Answer pour le calcul de réputation
        if ($votable instanceof Question) {
            // Vote sur question : +5 positif, -2 négatif
            $reputationChange = $value > 0 ? 5 : -2;
        } else {
            // Vote sur réponse : +10 positif, -2 négatif
            $reputationChange = $value > 0 ? 10 : -2;
        }

        // Appliquer ou retirer la réputation à l'auteur
        if ($action === 'add') {
            $author->increment('reputation', $reputationChange);
        } else {
            $author->decrement('reputation', $reputationChange);
        }

        // Pénalité pour celui qui vote négativement (-1 point)
        if ($action === 'add' && $value < 0) {
            $voter = User::find($vote->user_id);
            if ($voter && $voter->id !== $author->id) {
                $voter->decrement('reputation', 1);
            }
        }
    }
}
