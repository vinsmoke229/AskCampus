<?php

namespace Database\Factories;

use App\Models\Answer;
use App\Models\Question;
use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Vote>
 */
class VoteFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        // Choisir aléatoirement entre Question et Answer
        $votableType = fake()->randomElement([Question::class, Answer::class]);
        
        return [
            'user_id' => User::factory(),
            'votable_type' => $votableType,
            'votable_id' => $votableType::factory(),
            'value' => fake()->randomElement([1, -1]), // Upvote ou downvote
        ];
    }

    /**
     * Vote sur une question spécifique
     */
    public function forQuestion(Question $question): static
    {
        return $this->state(fn (array $attributes) => [
            'votable_type' => Question::class,
            'votable_id' => $question->id,
        ]);
    }

    /**
     * Vote sur une réponse spécifique
     */
    public function forAnswer(Answer $answer): static
    {
        return $this->state(fn (array $attributes) => [
            'votable_type' => Answer::class,
            'votable_id' => $answer->id,
        ]);
    }

    /**
     * Upvote (+1)
     */
    public function upvote(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => 1,
        ]);
    }

    /**
     * Downvote (-1)
     */
    public function downvote(): static
    {
        return $this->state(fn (array $attributes) => [
            'value' => -1,
        ]);
    }
}
