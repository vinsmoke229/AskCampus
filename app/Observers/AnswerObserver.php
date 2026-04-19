<?php

namespace App\Observers;

use App\Models\Answer;
use App\Notifications\AnswerAccepted;
use App\Notifications\NewAnswerOnFollowedQuestion;

class AnswerObserver
{
    /**
     * Handle the Answer "created" event.
     */
    public function created(Answer $answer): void
    {
        // Notifier les utilisateurs qui suivent cette question
        $question = $answer->question;
        
        if (!$question) {
            return;
        }

        // Récupérer tous les utilisateurs qui suivent cette question
        $followers = $question->followers()
            ->where('user_id', '!=', $answer->user_id) // Exclure l'auteur de la réponse
            ->get();

        // Envoyer une notification à chaque follower
        foreach ($followers as $follower) {
            $follower->notify(new NewAnswerOnFollowedQuestion(
                questionId: $question->id,
                questionTitle: $question->title,
                answerAuthor: $answer->user->name,
                answerId: $answer->id
            ));
        }
    }

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

            // Si la réponse est acceptée
            if ($answer->is_accepted) {
                // Ajouter +15 de réputation à l'auteur de la réponse
                $author->increment('reputation', 15);

                // Ajouter +2 de réputation à l'auteur de la question
                $questionAuthor = $answer->question->user;
                if ($questionAuthor && $questionAuthor->id !== $author->id) {
                    $questionAuthor->increment('reputation', 2);
                }

                // Envoyer notification à l'auteur de la réponse
                $author->notify(new AnswerAccepted(
                    questionId: $answer->question_id,
                    questionTitle: $answer->question->title,
                    answerId: $answer->id
                ));
            } else {
                // Si la réponse est désacceptée, retirer la réputation
                $author->decrement('reputation', 15);

                $questionAuthor = $answer->question->user;
                if ($questionAuthor && $questionAuthor->id !== $author->id) {
                    $questionAuthor->decrement('reputation', 2);
                }
            }
        }
    }
}
