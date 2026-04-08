<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création des utilisateurs
        $moderator = User::factory()->create([
            'name' => 'Modérateur',
            'email' => 'mod@askcampus.com',
            'reputation' => 1000,
        ]);

        $users = User::factory(9)->create();
        $allUsers = $users->push($moderator);

        // Création des tags
        $tags = collect([
            ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Framework PHP moderne pour le développement web'],
            ['name' => 'PHP', 'slug' => 'php', 'description' => 'Langage de programmation côté serveur'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Langage de programmation pour le web'],
            ['name' => 'Économie', 'slug' => 'economie', 'description' => 'Questions sur la microéconomie et macroéconomie'],
            ['name' => 'Algorithmique', 'slug' => 'algorithmique', 'description' => 'Structures de données et algorithmes'],
        ])->map(fn($tag) => Tag::create($tag));

        // Création des questions avec tags
        $questions = collect();
        for ($i = 0; $i < 20; $i++) {
            $question = Question::factory()->create([
                'user_id' => $allUsers->random()->id,
            ]);

            // Attacher 1 à 3 tags aléatoires
            $question->tags()->attach(
                $tags->random(rand(1, 3))->pluck('id')
            );

            $questions->push($question);
        }

        // Création des réponses
        $answers = collect();
        foreach ($questions as $question) {
            // Chaque question reçoit entre 1 et 5 réponses
            $questionAnswers = Answer::factory(rand(1, 5))->create([
                'question_id' => $question->id,
                'user_id' => $allUsers->random()->id,
            ]);

            $answers = $answers->merge($questionAnswers);

            // Marquer aléatoirement une réponse sur trois comme acceptée
            if ($questionAnswers->count() > 0 && rand(1, 3) === 1) {
                $acceptedAnswer = $questionAnswers->random();
                $acceptedAnswer->update(['is_accepted' => true]);
                $question->update(['is_solved' => true]);
            }
        }

        // Création des votes pour les questions
        foreach ($questions as $question) {
            // Chaque question reçoit entre 0 et 10 votes
            $voteCount = rand(0, 10);
            
            for ($i = 0; $i < $voteCount; $i++) {
                try {
                    Vote::create([
                        'user_id' => $allUsers->random()->id,
                        'votable_type' => Question::class,
                        'votable_id' => $question->id,
                        'value' => rand(0, 1) ? 1 : -1, // 50/50 upvote/downvote
                    ]);
                } catch (\Exception $e) {
                    // Ignorer les doublons (contrainte unique)
                    continue;
                }
            }
        }

        // Création des votes pour les réponses
        foreach ($answers as $answer) {
            // Chaque réponse reçoit entre 0 et 8 votes
            $voteCount = rand(0, 8);
            
            for ($i = 0; $i < $voteCount; $i++) {
                try {
                    Vote::create([
                        'user_id' => $allUsers->random()->id,
                        'votable_type' => Answer::class,
                        'votable_id' => $answer->id,
                        'value' => rand(0, 1) ? 1 : -1, // 50/50 upvote/downvote
                    ]);
                } catch (\Exception $e) {
                    // Ignorer les doublons (contrainte unique)
                    continue;
                }
            }
        }

        $this->command->info('✅ Base de données peuplée avec succès !');
        $this->command->info("📊 Statistiques :");
        $this->command->info("   - Utilisateurs : " . User::count());
        $this->command->info("   - Tags : " . Tag::count());
        $this->command->info("   - Questions : " . Question::count());
        $this->command->info("   - Réponses : " . Answer::count());
        $this->command->info("   - Votes : " . Vote::count());
    }
}
