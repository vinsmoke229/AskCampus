<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Vote;
use Illuminate\Http\Request;

class VoteController extends Controller
{
    /**
     * Handle voting (upvote/downvote) with toggle functionality.
     */
    public function vote(VoteRequest $request)
    {
        $userId = auth()->id();
        $votableType = $request->votable_type;
        $votableId = $request->votable_id;
        $value = $request->value;

        // Vérifier si un vote existe déjà
        $existingVote = Vote::where('user_id', $userId)
            ->where('votable_type', $votableType)
            ->where('votable_id', $votableId)
            ->first();

        if ($existingVote) {
            // Si le vote est identique, on le supprime (toggle)
            if ($existingVote->value == $value) {
                $existingVote->delete();
                $message = 'Vote retiré.';
            } else {
                // Sinon, on met à jour le vote
                $existingVote->update(['value' => $value]);
                $message = 'Vote mis à jour.';
            }
        } else {
            // Créer un nouveau vote
            Vote::create([
                'user_id' => $userId,
                'votable_type' => $votableType,
                'votable_id' => $votableId,
                'value' => $value,
            ]);
            $message = 'Vote enregistré.';
        }

        return back()->with('success', $message);
    }
}
