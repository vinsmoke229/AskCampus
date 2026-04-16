<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreAnswerRequest;
use App\Models\Answer;
use App\Models\Question;

class AnswerController extends Controller
{
    /**
     * Enregistre une nouvelle réponse
     */
    public function store(StoreAnswerRequest $request, Question $question)
    {
        // Vérifier que la question n'est pas fermée
        if ($question->is_closed) {
            return redirect()->route('questions.show', $question)
                ->with('error', 'Cette question est fermée et n\'accepte plus de réponses.');
        }

        // Créer la réponse
        $answer = $question->answers()->create([
            'user_id' => auth()->id(),
            'body' => $request->body,
        ]);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Réponse ajoutée avec succès.');
    }

    /**
     * Marque une réponse comme acceptée (uniquement par l'auteur de la question)
     */
    public function accept(Answer $answer)
    {
        $question = $answer->question;

        // Vérifier que l'utilisateur est l'auteur de la question
        if ($question->user_id !== auth()->id()) {
            abort(403, 'Vous n\'êtes pas autorisé à accepter cette réponse.');
        }

        // Si une version précédente de la réponse était déjà acceptée, annuler la réputation
        $previouslyAccepted = $question->answers()->where('is_accepted', true)->first();
        if ($previouslyAccepted) {
            $previouslyAccepted->user?->decrement('reputation', 15);
            $question->user?->decrement('reputation', 2);
        }

        // Désaccepter toutes les autres réponses
        $question->answers()->update(['is_accepted' => false]);

        // Accepter cette réponse
        $answer->update(['is_accepted' => true]);

        // Attribuer la réputation (+15 pour l'auteur de la réponse, +2 pour l'auteur de la question)
        $answer->user?->increment('reputation', 15);
        $question->user?->increment('reputation', 2);

        // Marquer la question comme résolue
        $question->update(['is_solved' => true]);

        return redirect()->route('questions.show', $question)
            ->with('success', 'Réponse acceptée avec succès.');
    }

    /**
     * Supprime une réponse (modérateur uniquement)
     */
    public function destroy(Answer $answer)
    {
        $question = $answer->question;
        $answer->delete();

        return redirect()->route('questions.show', $question)
            ->with('success', 'Réponse supprimée avec succès.');
    }
}
