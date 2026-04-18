<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use App\Notifications\VoteReceived;
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    /**
     * Règles de réputation par action
     */
    private const REP = [
        'upvote'   => 10,   // reçoit un vote positif
        'downvote' => -2,   // reçoit un vote négatif
    ];

    /**
     * Gère le vote sur une question ou une réponse (polymorphe)
     */
    public function vote(VoteRequest $request)
    {
        $userId      = auth()->id();
        $votableType = $request->votable_type;
        $votableId   = $request->votable_id;
        $value       = (int) $request->value;   // +1 ou -1

        // Récupérer l'entité votable (Question ou Answer)
        $votable = $votableType::findOrFail($votableId);

        // Propriétaire du contenu (celui qui reçoit/perd de la réputation)
        $contentOwner = $votable->user;

        // Vérifier les autorisations via Policy
        if ($votableType === Question::class) {
            Gate::authorize('voteOnQuestion', $votable);
        } else {
            Gate::authorize('voteOnAnswer', $votable);
        }

        // Chercher si un vote existe déjà
        $existingVote = Vote::where('user_id', $userId)
            ->where('votable_type', $votableType)
            ->where('votable_id', $votableId)
            ->first();

        if ($existingVote) {
            if ($existingVote->value == $value) {
                // Même vote → on retire (toggle)
                $existingVote->delete();
                // Annuler la réputation accordée
                $rep = $value === 1 ? -self::REP['upvote'] : -self::REP['downvote'];
                $contentOwner?->increment('reputation', $rep);
                $message = 'Vote retiré.';
            } else {
                // Vote opposé → on remplace
                $oldRep = $existingVote->value === 1 ? -self::REP['upvote'] : -self::REP['downvote'];
                $newRep = $value === 1 ?  self::REP['upvote'] :  self::REP['downvote'];
                $existingVote->update(['value' => $value]);
                $contentOwner?->increment('reputation', $oldRep + $newRep);
                $message = 'Vote mis à jour.';
            }
        } else {
            // Nouveau vote
            Vote::create([
                'user_id'      => $userId,
                'votable_type' => $votableType,
                'votable_id'   => $votableId,
                'value'        => $value,
            ]);
            $rep = $value === 1 ? self::REP['upvote'] : self::REP['downvote'];
            $contentOwner?->increment('reputation', $rep);

            // Notifier le propriétaire du contenu (sauf si c'est lui-même qui vote)
            if ($contentOwner && $contentOwner->id !== $userId) {
                $typeLabel   = $votableType === Question::class ? 'question' : 'réponse';
                $title       = $votable instanceof Question ? $votable->title : $votable->question->title;
                $questionId  = $votable instanceof Question ? $votable->id : $votable->question_id;
                $contentOwner->notify(new VoteReceived($typeLabel, $votableId, $title, $value, $questionId));
            }

            $message = 'Vote enregistré.';
        }

        return back()->with('success', $message);
    }
}
