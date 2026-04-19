<?php

namespace App\Notifications;

use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class AnswerAccepted extends Notification
{
    use Queueable;

    public function __construct(public Answer $answer) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        return [
            'type'        => 'answer_accepted',
            'message'     => 'Votre réponse a été acceptée !',
            'question_id' => $this->answer->question_id,
            'question_title' => $this->answer->question->title,
            'answer_id'   => $this->answer->id,
            'url'         => route('questions.show', $this->answer->question_id),
        ];
    }
}
