<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class AnswerPolicy
{
    /**
     * Détermine si l'utilisateur peut voir toutes les réponses
     */
    public function viewAny(?User $user): bool
    {
        // Tout le monde peut voir les réponses
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir une réponse
     */
    public function view(?User $user, Answer $answer): bool
    {
        // Tout le monde peut voir une réponse
        return true;
    }

    /**
     * Détermine si l'utilisateur peut créer une réponse
     */
    public function create(User $user): bool
    {
        // Tout utilisateur authentifié peut créer une réponse
        return true;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour une réponse
     */
    public function update(User $user, Answer $answer): Response
    {
        // Seul le propriétaire peut éditer sa réponse
        return $user->id === $answer->user_id
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas éditer cette réponse.');
    }

    /**
     * Détermine si l'utilisateur peut supprimer une réponse
     */
    public function delete(User $user, Answer $answer): Response
    {
        // Seul le propriétaire ou un modérateur peut supprimer
        return $user->id === $answer->user_id || $user->isModerator()
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas supprimer cette réponse.');
    }

    /**
     * Détermine si l'utilisateur peut accepter une réponse
     */
    public function accept(User $user, Answer $answer): Response
    {
        // Seul le propriétaire de la question peut accepter une réponse
        return $user->id === $answer->question->user_id
            ? Response::allow()
            : Response::deny('Seul le propriétaire de la question peut accepter une réponse.');
    }
}
