<?php

namespace App\Policies;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class VotePolicy
{
    /**
     * Vérifie si l'utilisateur peut voter sur une question
     */
    public function voteOnQuestion(User $user, Question $question): Response
    {
        // Un utilisateur ne peut pas voter sur sa propre question
        return $question->user_id !== $user->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas voter sur votre propre question.');
    }

    /**
     * Vérifie si l'utilisateur peut voter sur une réponse
     */
    public function voteOnAnswer(User $user, Answer $answer): Response
    {
        // Un utilisateur ne peut pas voter sur sa propre réponse
        return $answer->user_id !== $user->id
            ? Response::allow()
            : Response::deny('Vous ne pouvez pas voter sur votre propre réponse.');
    }
}
