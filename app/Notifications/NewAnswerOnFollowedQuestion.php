<?php

namespace App\Notifications;

use App\Models\Answer;
use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class NewAnswerOnFollowedQuestion extends Notification
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
            'type'           => 'new_answer',
            'message'        => 'Une nouvelle réponse a été postée sur une question que vous suivez.',
            'question_id'    => $this->answer->question_id,
            'question_title' => $this->answer->question->title,
            'answer_id'      => $this->answer->id,
            'answerer_name'  => $this->answer->user->name,
            'url'            => route('questions.show', $this->answer->question_id),
        ];
    }
}
