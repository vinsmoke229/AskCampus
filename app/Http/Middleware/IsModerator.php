<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class IsModerator
{
    /**
     * Vérifie si l'utilisateur est modérateur
     */
    public function handle(Request $request, Closure $next): Response
    {
        // Vérifier si l'utilisateur est connecté et modérateur
        if (!auth()->check() || !auth()->user()->isModerator()) {
            abort(403, 'Accès réservé aux modérateurs.');
        }

        return $next($request);
    }
}

