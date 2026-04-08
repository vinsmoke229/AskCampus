<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Question>
 */
class QuestionFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Titres académiques réalistes
        $titles = [
            'Comment optimiser une requête Eloquent avec plusieurs jointures ?',
            'Aide pour un exercice sur les matrices en Python',
            'Différence entre let et const en JavaScript ?',
            'Comment implémenter l\'authentification JWT en Laravel ?',
            'Exercice sur les algorithmes de tri : quicksort vs mergesort',
            'Problème avec les migrations Laravel : erreur de clé étrangère',
            'Comment calculer la complexité temporelle d\'un algorithme ?',
            'Aide pour comprendre les closures en JavaScript',
            'Exercice d\'économie : calcul du PIB et de la croissance',
            'Comment utiliser les relations polymorphes dans Laravel ?',
            'Problème avec async/await en JavaScript',
            'Aide pour un exercice sur les graphes et parcours en largeur',
            'Comment sécuriser une API REST avec Laravel Sanctum ?',
            'Exercice de microéconomie : offre et demande',
            'Différence entre abstract class et interface en PHP ?',
            'Comment implémenter un système de cache avec Redis ?',
            'Aide pour comprendre les promesses en JavaScript',
            'Exercice sur les arbres binaires de recherche',
            'Comment gérer les transactions dans Laravel ?',
            'Problème avec les événements et listeners Laravel',
        ];

        return [
            'user_id' => User::factory(),
            'title' => fake()->randomElement($titles),
            'body' => fake()->paragraphs(3, true),
            'is_solved' => fake()->boolean(30), // 30% de chances d'être résolu
            'views' => fake()->numberBetween(0, 500),
            'is_closed' => fake()->boolean(5), // 5% de chances d'être fermé
        ];
    }
}
