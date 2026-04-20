<?php

namespace Database\Seeders;

use App\Models\Answer;
use App\Models\Question;
use App\Models\Tag;
use App\Models\User;
use App\Models\Vote;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // Création des utilisateurs avec mots de passe connus
        $admin = User::create([
            'name' => 'Administrateur',
            'email' => 'admin@askcampus.com',
            'password' => Hash::make('admin123'),
            'reputation' => 2000,
            'is_moderator' => true,
            'campus' => 'Administration',
        ]);

        $moderator = User::create([
            'name' => 'Modérateur Campus',
            'email' => 'mod@askcampus.com',
            'password' => Hash::make('mod123'),
            'reputation' => 1000,
            'is_moderator' => true,
            'campus' => 'Sciences',
        ]);

        // Utilisateurs de test avec mots de passe connus
        $testUser1 = User::create([
            'name' => 'Étudiant Test',
            'email' => 'etudiant@askcampus.com',
            'password' => Hash::make('etudiant123'),
            'reputation' => 150,
            'campus' => 'Économie',
        ]);

        $testUser2 = User::create([
            'name' => 'Marie Dupont',
            'email' => 'marie@askcampus.com',
            'password' => Hash::make('marie123'),
            'reputation' => 300,
            'campus' => 'Informatique',
        ]);

        // Votre compte personnel
        $yourAccount = User::create([
            'name' => 'Ellera',
            'email' => 'ellera072@gmail.com',
            'password' => Hash::make('ellera123'),
            'reputation' => 500,
            'is_moderator' => true,
            'campus' => 'Informatique',
        ]);

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

        // Création de quelques questions simples
        $question1 = Question::create([
            'user_id' => $testUser1->id,
            'title' => 'Comment optimiser une requête Eloquent avec plusieurs jointures ?',
            'body' => 'J\'ai une requête qui fait plusieurs jointures et elle est très lente. Comment puis-je l\'optimiser ?',
            'views' => 45,
        ]);
        $question1->tags()->attach($tags->where('slug', 'laravel')->first()->id);

        $question2 = Question::create([
            'user_id' => $testUser2->id,
            'title' => 'Aide pour un exercice sur les matrices en Python',
            'body' => 'Je dois multiplier deux matrices mais j\'ai des erreurs. Quelqu\'un peut m\'aider ?',
            'views' => 23,
        ]);
        $question2->tags()->attach($tags->where('slug', 'python')->first()->id);

        // Quelques réponses
        Answer::create([
            'question_id' => $question1->id,
            'user_id' => $admin->id,
            'body' => 'Vous pouvez utiliser eager loading avec `with()` pour éviter le problème N+1.',
            'is_accepted' => true,
        ]);

        Answer::create([
            'question_id' => $question2->id,
            'user_id' => $moderator->id,
            'body' => 'Utilisez numpy.dot() pour la multiplication de matrices en Python.',
        ]);

        // Marquer la première question comme résolue
        $question1->update(['is_solved' => true]);

        $this->command->info('✅ Base de données peuplée avec succès !');
        $this->command->info("📊 Statistiques :");
        $this->command->info("   - Utilisateurs : " . User::count());
        $this->command->info("   - Tags : " . Tag::count());
        $this->command->info("   - Questions : " . Question::count());
        $this->command->info("   - Réponses : " . Answer::count());
    }
}
