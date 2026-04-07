<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Models\Answer;
use App\Models\Question;
use Illuminate\Http\Request;

class AnswerController extends Controller
{
    /**
     * Store a newly created answer in storage.
     */
    public function store(StoreAnswerRequest $request, Question $question)
    {
        $answer = $question->answers()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Réponse ajoutée avec succès.');
    }

    /**
     * Mark an answer as accepted (only by question author).
     */
    public function accept(Answer $answer)
    {
        $question = $answer->question;

        // Vérifier que l'utilisateur est l'auteur de la question
        if ($question->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accepter cette réponse.');
        }

        // Désaccepter toutes les autres réponses de cette question
        $question->answers()->update(['is_accepted' => false]);

        // Accepter cette réponse
        $answer->update(['is_accepted' => true]);

        // Marquer la question comme résolue
        $question->update(['is_solved' => true]);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Réponse acceptée avec succès.');
    }
}
