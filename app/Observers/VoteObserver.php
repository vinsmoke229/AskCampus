<?php

namespace App\Observers;

use App\Models\Vote;

class VoteObserver
{
    /**
     * Événement déclenché lors de la création d'un vote
     */
    public function created(Vote $vote): void
    {
        $this->updateReputation($vote, 'add');
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
    }

    /**
     * Événement déclenché lors de la suppression d'un vote
     */
    public function deleted(Vote $vote): void
    {
        $this->updateReputation($vote, 'remove');
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

        // Calculer le changement de réputation
        // Vote positif : +10 points
        // Vote négatif : -2 points
        $reputationChange = $value > 0 ? 10 : -2;

        // Appliquer ou retirer la réputation
        if ($action === 'add') {
            $author->increment('reputation', $reputationChange);
        } else {
            $author->decrement('reputation', $reputationChange);
        }
    }
}
