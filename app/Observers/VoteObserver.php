<?php

namespace App\Observers;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;

class VoteObserver
{
    /**
     * Handle the Vote "created" event.
     */
    public function created(Vote $vote): void
    {
        $this->updateReputation($vote, 'add');
    }

    /**
     * Handle the Vote "updated" event.
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
    }

    /**
     * Handle the Vote "deleted" event.
     */
    public function deleted(Vote $vote): void
    {
        $this->updateReputation($vote, 'remove');
    }

    /**
     * Update user reputation based on vote.
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

        // Calculer le changement de réputation (+10 pour upvote, -10 pour downvote)
        $reputationChange = $value * 10;

        // Appliquer ou retirer la réputation
        if ($action === 'add') {
            $author->increment('reputation', $reputationChange);
        } else {
            $author->decrement('reputation', $reputationChange);
        }
    }
}
