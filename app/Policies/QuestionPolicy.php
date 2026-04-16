<?php

namespace App\Policies;

use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class QuestionPolicy
{
    /**
     * Détermine si l'utilisateur peut voir toutes les questions
     */
    public function viewAny(?User $user): bool
    {
        // Tout le monde peut voir les questions (même les guests)
        return true;
    }

    /**
     * Détermine si l'utilisateur peut voir une question
     */
    public function view(?User $user, Question $question): bool
    {
        // Tout le monde peut voir une question
        return true;
    }

    /**
     * Détermine si l'utilisateur peut créer une question
     */
    public function create(User $user): bool
    {
        // Tout utilisateur authentifié peut créer une question
        return true;
    }

    /**
     * Détermine si l'utilisateur peut mettre à jour une question
     */
    public function update(User $user, Question $question): Response
    {
        // Seul le propriétaire ou un modérateur peut éditer
        return $user->id === $question->user_id || $user->isModerator()
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas éditer cette question.');
    }

    /**
     * Détermine si l'utilisateur peut supprimer une question
     */
    public function delete(User $user, Question $question): Response
    {
        // Seul le propriétaire ou un modérateur peut supprimer
        return $user->id === $question->user_id || $user->isModerator()
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas supprimer cette question.');
    }

    /**
     * Détermine si l'utilisateur peut fermer une question
     */
    public function close(User $user, Question $question): Response
    {
        // Seuls les modérateurs peuvent fermer
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Seuls les modérateurs peuvent fermer une question.');
    }

    /**
     * Détermine si l'utilisateur peut rouvrir une question
     */
    public function reopen(User $user, Question $question): Response
    {
        // Seuls les modérateurs peuvent rouvrir
        return $user->isModerator()
            ? Response::allow()
            : Response::deny('Seuls les modérateurs peuvent rouvrir une question.');
    }
}
