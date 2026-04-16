<?php

namespace App\Http\Controllers;

use App\Http\Requests\VoteRequest;
use App\Models\Answer;
use App\Models\Question;
use App\Models\Vote;
use Illuminate\Support\Facades\Gate;

class VoteController extends Controller
{
    /**
     * Gère le vote sur une question ou une réponse (polymorphe)
     */
    public function vote(VoteRequest $request)
    {
        $userId = auth()->id();
        $votableType = $request->votable_type;
        $votableId = $request->votable_id;
        $value = $request->value;

        // Récupérer l'entité votable (Question ou Answer)
        $votable = $votableType::findOrFail($votableId);

        // Vérifier les autorisations via Policy (anti-triche)
        if ($votableType === Question::class) {
            $this->authorize('voteOnQuestion', $votable);
        } else {
            $this->authorize('voteOnAnswer', $votable);
        }

        // Chercher si un vote existe déjà
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
                // Sinon, on change le vote (de +1 à -1 ou inversement)
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
