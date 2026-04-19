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
            'is_moderator' => true,
        ]);

        $users = User::factory(9)->create();
        $allUsers = $users->push($moderator);

        // Création des tags adaptés à la vie étudiante
        $tags = collect([
            // Matières académiques
            ['name' => 'Mathématiques', 'slug' => 'mathematiques', 'description' => 'Algèbre, analyse, géométrie, statistiques'],
            ['name' => 'Économie', 'slug' => 'economie', 'description' => 'Microéconomie, macroéconomie, économétrie'],
            ['name' => 'Droit', 'slug' => 'droit', 'description' => 'Droit civil, pénal, administratif, constitutionnel'],
            ['name' => 'Physique', 'slug' => 'physique', 'description' => 'Mécanique, thermodynamique, électromagnétisme'],
            ['name' => 'Chimie', 'slug' => 'chimie', 'description' => 'Chimie organique, inorganique, analytique'],
            ['name' => 'Biologie', 'slug' => 'biologie', 'description' => 'Biologie cellulaire, génétique, écologie'],
            ['name' => 'Histoire', 'slug' => 'histoire', 'description' => 'Histoire moderne, contemporaine, médiévale'],
            ['name' => 'Philosophie', 'slug' => 'philosophie', 'description' => 'Métaphysique, éthique, logique'],
            ['name' => 'Littérature', 'slug' => 'litterature', 'description' => 'Analyse littéraire, poésie, roman'],
            ['name' => 'Langues', 'slug' => 'langues', 'description' => 'Anglais, espagnol, allemand, chinois'],
            
            // Informatique et technologies
            ['name' => 'Informatique', 'slug' => 'informatique', 'description' => 'Programmation, algorithmes, bases de données'],
            ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Framework PHP moderne pour le développement web'],
            ['name' => 'PHP', 'slug' => 'php', 'description' => 'Langage de programmation côté serveur'],
            ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Langage de programmation pour le web'],
            ['name' => 'Python', 'slug' => 'python', 'description' => 'Langage polyvalent pour data science et web'],
            ['name' => 'Java', 'slug' => 'java', 'description' => 'Langage orienté objet pour applications'],
            ['name' => 'C++', 'slug' => 'cpp', 'description' => 'Langage système et programmation bas niveau'],
            ['name' => 'SQL', 'slug' => 'sql', 'description' => 'Langage de requêtes pour bases de données'],
            ['name' => 'Algorithmique', 'slug' => 'algorithmique', 'description' => 'Structures de données et algorithmes'],
            
            // Gestion et commerce
            ['name' => 'Comptabilité', 'slug' => 'comptabilite', 'description' => 'Comptabilité générale, analytique, financière'],
            ['name' => 'Finance', 'slug' => 'finance', 'description' => 'Finance d\'entreprise, marchés financiers'],
            ['name' => 'Marketing', 'slug' => 'marketing', 'description' => 'Marketing digital, stratégique, opérationnel'],
            ['name' => 'Management', 'slug' => 'management', 'description' => 'Gestion d\'équipe, stratégie d\'entreprise'],
            ['name' => 'Ressources-Humaines', 'slug' => 'ressources-humaines', 'description' => 'GRH, recrutement, formation'],
            
            // Vie étudiante
            ['name' => 'Vie-étudiante', 'slug' => 'vie-etudiante', 'description' => 'Bourses, logement, vie associative'],
            ['name' => 'Orientation', 'slug' => 'orientation', 'description' => 'Choix de filière, parcours, débouchés'],
            ['name' => 'Stage', 'slug' => 'stage', 'description' => 'Recherche de stage, rapport, convention'],
            ['name' => 'Mémoire', 'slug' => 'memoire', 'description' => 'Rédaction, méthodologie, soutenance'],
            ['name' => 'Examens', 'slug' => 'examens', 'description' => 'Préparation, révisions, conseils'],
            ['name' => 'Méthodologie', 'slug' => 'methodologie', 'description' => 'Méthodes de travail, organisation, efficacité'],
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
