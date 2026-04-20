<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAnswerOnFollowedQuestion extends Notification
{
    use Queueable;

    public function __construct(
        public int    $questionId,
        public string $questionTitle,
        public string $answerAuthor,
        public int    $answerId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'           => 'new_answer',
            'message'        => "{$this->answerAuthor} a répondu à une question que vous suivez.",
            'question_id'    => $this->questionId,
            'question_title' => $this->questionTitle,
            'answer_id'      => $this->answerId,
            'answerer_name'  => $this->answerAuthor,
            'url'            => route('questions.show', $this->questionId),
        ];
    }
}
