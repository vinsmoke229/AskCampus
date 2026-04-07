<?php

namespace App\Observers;

use App\Models\Answer;

class AnswerObserver
{
    /**
     * Handle the Answer "updated" event.
     */
    public function updated(Answer $answer): void
    {
        // Vérifier si is_accepted a changé
        if ($answer->isDirty('is_accepted')) {
            $author = $answer->user;

            if (!$author) {
                return;
            }

            // Si la réponse est acceptée, ajouter +20 de réputation
            if ($answer->is_accepted) {
                $author->increment('reputation', 20);
            } else {
                // Si la réponse est désacceptée, retirer -20 de réputation
                $author->decrement('reputation', 20);
            }
        }
    }
}
