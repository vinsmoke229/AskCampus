<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnswerAccepted extends Notification
{
    use Queueable;

    public function __construct(
        public int    $questionId,
        public string $questionTitle,
        public int    $answerId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'           => 'answer_accepted',
            'message'        => 'Votre réponse a été acceptée !',
            'question_id'    => $this->questionId,
            'question_title' => $this->questionTitle,
            'answer_id'      => $this->answerId,
            'url'            => route('questions.show', $this->questionId),
        ];
    }
}
