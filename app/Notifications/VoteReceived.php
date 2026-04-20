<?php

namespace App\Notifications;

use Illuminate\Bus\Queueable;
use Illuminate\Notifications\Notification;

class VoteReceived extends Notification
{
    use Queueable;

    public function __construct(
        public string $votableType,
        public int    $votableId,
        public string $votableTitle,
        public int    $value,
        public int    $questionId,
    ) {}

    public function via(object $notifiable): array
    {
        return ['database'];
    }

    public function toArray(object $notifiable): array
    {
        $label = $this->value > 0 ? 'positif' : 'négatif';

        return [
            'type'          => 'vote_received',
            'message'       => "Vous avez reçu un vote {$label} sur votre {$this->votableType}.",
            'votable_type'  => $this->votableType,
            'votable_id'    => $this->votableId,
            'votable_title' => $this->votableTitle,
            'value'         => $this->value,
            'url'           => route('questions.show', $this->questionId),
        ];
    }
}
