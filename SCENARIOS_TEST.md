# 🧪 SCÉNARIOS DE TEST COMPLETS - AskCampus

## 📋 GUIDE D'UTILISATION

Ce document contient tous les scénarios de test à exécuter manuellement pour valider le fonctionnement complet de l'application.

**Prérequis**:
- Serveur Laravel lancé: `php artisan serve`
- Base de données migrée: `php artisan migrate:fresh --seed`
- 3 comptes utilisateurs créés (voir section Préparation)

---

## 🔧 PRÉPARATION DES DONNÉES DE TEST

### Étape 1: Créer les utilisateurs de test

```bash
php artisan tinker
```

```php
// Créer un utilisateur guest (pour tester sans connexion)
// Pas besoin de créer, juste ne pas se connecter

// Créer un utilisateur student
$student = User::create([
    'name' => 'Student Test',
    'email' => 'student@test.com',
    'password' => bcrypt('password'),
    'reputation' => 1,
    'is_moderator' => false,
]);

// Créer un deuxième student
$student2 = User::create([
    'name' => 'Student 2',
    'email' => 'student2@test.com',
    'password' => bcrypt('password'),
    'reputation' => 1,
    'is_moderator' => false,
]);

// Créer un modérateur
$moderator = User::create([
    'name' => 'Moderator Test',
    'email' => 'moderator@test.com',
    'password' => bcrypt('password'),
    'reputation' => 100,
    'is_moderator' => true,
]);

// Créer quelques tags
$tags = [
    ['name' => 'Laravel', 'slug' => 'laravel', 'description' => 'Framework PHP'],
    ['name' => 'PHP', 'slug' => 'php', 'description' => 'Langage de programmation'],
    ['name' => 'JavaScript', 'slug' => 'javascript', 'description' => 'Langage web'],
    ['name' => 'Vue.js', 'slug' => 'vuejs', 'description' => 'Framework JavaScript'],
];

foreach ($tags as $tag) {
    Tag::create($tag);
}
```

---

## ✅ SCÉNARIO 1: UTILISATEUR GUEST (Non connecté)

### Objectif
Vérifier que les utilisateurs non connectés ont un accès en lecture seule.

### Actions

#### 1.1 - Accéder à la page d'accueil
- **URL**: `http://127.0.0.1:8000/`
- **Résultat attendu**: Redirection vers `/questions`
- **✅ PASS** / **❌ FAIL**

#### 1.2 - Voir la liste des questions
- **URL**: `http://127.0.0.1:8000/questions`
- **Résultat attendu**: 
  - Liste des questions visible
  - Filtres visibles (recherche, tags, statut)
  - Bouton "Poser une question" visible
- **✅ PASS** / **❌ FAIL**

#### 1.3 - Voir le détail d'une question
- **URL**: `http://127.0.0.1:8000/questions/1`
- **Résultat attendu**:
  - Question affichée avec titre, body, tags
  - Réponses affichées
  - Compteur de vues incrémenté
  - Boutons de vote visibles mais non fonctionnels (redirection login)
- **✅ PASS** / **❌ FAIL**

#### 1.4 - Tenter de voter (sans connexion)
- **Action**: Cliquer sur flèche de vote (haut ou bas)
- **Résultat attendu**: Redirection vers `/login`
- **✅ PASS** / **❌ FAIL**

#### 1.5 - Tenter d'accéder à "Poser une question"
- **URL**: `http://127.0.0.1:8000/questions/create`
- **Résultat attendu**: Redirection vers `/login`
- **✅ PASS** / **❌ FAIL**

#### 1.6 - Tenter d'accéder au dashboard
- **URL**: `http://127.0.0.1:8000/dashboard`
- **Résultat attendu**: Redirection vers `/login`
- **✅ PASS** / **❌ FAIL**

#### 1.7 - Tenter d'accéder au profil
- **URL**: `http://127.0.0.1:8000/mon-profil`
- **Résultat attendu**: Redirection vers `/login`
- **✅ PASS** / **❌ FAIL**

---

## ✅ SCÉNARIO 2: UTILISATEUR STUDENT (Connecté)

### Connexion
- **Email**: `student@test.com`
- **Password**: `password`

### Actions

#### 2.1 - Poser une question

**Étapes**:
1. Cliquer sur "Poser une question" dans la navbar
2. Remplir le formulaire:
   - **Titre**: "Comment implémenter l'authentification JWT en Laravel ?"
   - **Description**: "Je cherche à sécuriser mon API REST avec JWT. Quelle est la meilleure approche ?"
   - **Tags**: Sélectionner "Laravel" et "PHP"
3. Cliquer sur "Publier votre question"

**Résultats attendus**:
- ✅ Redirection vers `/questions/{id}`
- ✅ Question visible dans la liste
- ✅ Tags affichés
- ✅ Compteur de vues = 0 (car c'est l'auteur)
- ✅ Boutons "Éditer" et "Supprimer" visibles

**✅ PASS** / **❌ FAIL**

#### 2.2 - Éditer sa propre question

**Étapes**:
1. Accéder à la question créée en 2.1
2. Cliquer sur "Éditer"
3. Modifier le titre: "Comment implémenter JWT en Laravel 11 ?"
4. Cliquer sur "Mettre à jour la question"

**Résultats attendus**:
- ✅ Redirection vers `/questions/{id}`
- ✅ Titre modifié visible
- ✅ Message de succès affiché

**✅ PASS** / **❌ FAIL**

#### 2.3 - Tenter d'éditer la question d'un autre utilisateur

**Étapes**:
1. Se déconnecter
2. Se connecter avec `student2@test.com` / `password`
3. Créer une question (titre: "Question de Student 2")
4. Se déconnecter
5. Se reconnecter avec `student@test.com`
6. Accéder à la question de Student 2
7. Tenter d'accéder à `/questions/{id}/edit`

**Résultats attendus**:
- ✅ Erreur 403 "Vous ne pouvez pas éditer cette question"
- ✅ Bouton "Éditer" non visible sur la page

**✅ PASS** / **❌ FAIL**

#### 2.4 - Répondre à une question

**Étapes**:
1. Accéder à la question de Student 2
2. Remplir le formulaire de réponse:
   - **Réponse**: "Vous pouvez utiliser le package tymon/jwt-auth. Voici comment l'installer..."
3. Cliquer sur "Publier votre réponse"

**Résultats attendus**:
- ✅ Réponse affichée sous la question
- ✅ Nom de l'auteur (Student Test) visible
- ✅ Date "il y a quelques secondes"
- ✅ Score de votes = 0

**✅ PASS** / **❌ FAIL**

#### 2.5 - Voter positivement sur une question

**Étapes**:
1. Accéder à la question de Student 2
2. Cliquer sur la flèche HAUT (vote positif)

**Résultats attendus**:
- ✅ Score de la question incrémenté (+1)
- ✅ Flèche HAUT colorée en orange (#f48225)
- ✅ Réputation de Student 2 augmentée de +10

**Vérification réputation**:
```bash
php artisan tinker
User::where('email', 'student2@test.com')->first()->reputation; // Devrait être 11
```

**✅ PASS** / **❌ FAIL**

#### 2.6 - Voter négativement sur une réponse

**Étapes**:
1. Créer une réponse avec Student 2 sur la question de Student 1
2. Se connecter avec Student 1
3. Cliquer sur la flèche BAS (vote négatif) sur la réponse de Student 2

**Résultats attendus**:
- ✅ Score de la réponse décrémenté (-1)
- ✅ Flèche BAS colorée en orange
- ✅ Réputation de Student 2 diminuée de -2

**Vérification réputation**:
```bash
php artisan tinker
User::where('email', 'student2@test.com')->first()->reputation; // Devrait être 9 (11 - 2)
```

**✅ PASS** / **❌ FAIL**

#### 2.7 - Tenter de voter sur sa propre question

**Étapes**:
1. Accéder à sa propre question (créée en 2.1)
2. Cliquer sur la flèche de vote

**Résultats attendus**:
- ✅ Message d'erreur "Vous ne pouvez pas voter sur votre propre question"
- ✅ Score non modifié
- ✅ Réputation non modifiée

**✅ PASS** / **❌ FAIL**

#### 2.8 - Accepter une réponse à sa question

**Étapes**:
1. Accéder à sa question qui a des réponses
2. Cliquer sur le bouton ✓ (check vert) d'une réponse

**Résultats attendus**:
- ✅ Réponse marquée "Acceptée" avec badge vert
- ✅ Réponse remontée en premier (tri)
- ✅ Fond vert clair sur la réponse
- ✅ Réputation de l'auteur de la réponse +20
- ✅ Question marquée `is_solved = true`

**Vérification**:
```bash
php artisan tinker
Answer::where('is_accepted', true)->first(); // Devrait exister
```

**✅ PASS** / **❌ FAIL**

#### 2.9 - Suivre une question

**Étapes**:
1. Accéder à une question d'un autre utilisateur
2. Cliquer sur "Suivre"

**Résultats attendus**:
- ✅ Bouton devient "Suivi" (texte + couleur bleue)
- ✅ Icône bookmark remplie
- ✅ Message "Vous suivez maintenant cette question"

**Vérification**:
```bash
php artisan tinker
$user = User::where('email', 'student@test.com')->first();
$user->followedQuestions; // Devrait contenir la question
```

**✅ PASS** / **❌ FAIL**

#### 2.10 - Ne plus suivre une question

**Étapes**:
1. Sur la question suivie en 2.9
2. Cliquer sur "Suivi"

**Résultats attendus**:
- ✅ Bouton redevient "Suivre"
- ✅ Icône bookmark vide
- ✅ Message "Vous ne suivez plus cette question"

**✅ PASS** / **❌ FAIL**

#### 2.11 - Partager une question

**Étapes**:
1. Accéder à une question
2. Cliquer sur "Partager"

**Résultats attendus**:
- ✅ Notification "Lien copié dans le presse-papier !"
- ✅ Lien copié dans le clipboard (tester avec Ctrl+V)

**✅ PASS** / **❌ FAIL**

#### 2.12 - Rechercher des questions

**Étapes**:
1. Dans la barre de recherche, taper "Laravel"
2. Appuyer sur Entrée

**Résultats attendus**:
- ✅ URL: `/questions?search=Laravel`
- ✅ Questions contenant "Laravel" dans titre ou body affichées
- ✅ Autres questions filtrées

**✅ PASS** / **❌ FAIL**

#### 2.13 - Filtrer par tag

**Étapes**:
1. Cliquer sur un tag "PHP" sur une question
2. OU accéder à `/tags` et cliquer sur un tag

**Résultats attendus**:
- ✅ URL: `/questions?tag=php`
- ✅ Seules les questions avec le tag PHP affichées

**✅ PASS** / **❌ FAIL**

#### 2.14 - Accéder au profil

**Étapes**:
1. Cliquer sur "Mon profil" dans le menu utilisateur

**Résultats attendus**:
- ✅ URL: `/mon-profil`
- ✅ Onglet "Profil" actif par défaut
- ✅ Stats affichées (réputation, atteint, réponses, questions)
- ✅ Section "About" vide
- ✅ Badges affichés
- ✅ Top tags affichés (si tags utilisés)

**✅ PASS** / **❌ FAIL**

#### 2.15 - Voir l'onglet Activité du profil

**Étapes**:
1. Sur la page profil, cliquer sur l'onglet "Activité"

**Résultats attendus**:
- ✅ Menu latéral gauche visible (Résumé, Réponses, Questions, Tags, etc.)
- ✅ Section "Résumé" affichée par défaut
- ✅ Cartes d'impact (personnes atteintes, publications)

**✅ PASS** / **❌ FAIL**

#### 2.16 - Tenter d'accéder au dashboard modérateur

**Étapes**:
1. Accéder à `/dashboard`

**Résultats attendus**:
- ✅ Affichage de la page d'accueil utilisateur (home.blade.php)
- ✅ PAS le dashboard de modération

**✅ PASS** / **❌ FAIL**

---

## ✅ SCÉNARIO 3: UTILISATEUR MODÉRATEUR

### Connexion
- **Email**: `moderator@test.com`
- **Password**: `password`

### Actions

#### 3.1 - Accéder au dashboard modérateur

**Étapes**:
1. Se connecter avec le compte modérateur
2. Cliquer sur "Accueil" ou accéder à `/dashboard`

**Résultats attendus**:
- ✅ Affichage du dashboard de modération (dashboard.blade.php)
- ✅ Statistiques visibles:
  - Total questions
  - Questions ouvertes
  - Questions fermées
  - Total réponses
  - Total utilisateurs
  - Total tags
- ✅ Liste des questions récentes
- ✅ Liste des réponses récentes
- ✅ Liste des utilisateurs récents

**✅ PASS** / **❌ FAIL**

#### 3.2 - Fermer une question

**Étapes**:
1. Accéder à une question ouverte
2. Cliquer sur le bouton "Fermer" (bouton modérateur orange)
3. Confirmer

**Résultats attendus**:
- ✅ Badge "🔒 Fermée" affiché
- ✅ Formulaire de réponse désactivé avec message
- ✅ Message "Cette question est fermée. Les nouvelles réponses ne sont pas acceptées."
- ✅ Bouton "Rouvrir" visible

**Vérification**:
```bash
php artisan tinker
Question::find(1)->is_closed; // Devrait être true
```

**✅ PASS** / **❌ FAIL**

#### 3.3 - Rouvrir une question

**Étapes**:
1. Sur la question fermée en 3.2
2. Cliquer sur "Rouvrir"

**Résultats attendus**:
- ✅ Badge "🔒 Fermée" disparu
- ✅ Formulaire de réponse réactivé
- ✅ Bouton "Fermer" visible à nouveau

**✅ PASS** / **❌ FAIL**

#### 3.4 - Supprimer une question (d'un autre utilisateur)

**Étapes**:
1. Accéder à une question d'un student
2. Cliquer sur "Supprimer" (bouton modérateur rouge)
3. Confirmer la suppression

**Résultats attendus**:
- ✅ Redirection vers `/questions`
- ✅ Message "Question supprimée avec succès"
- ✅ Question n'apparaît plus dans la liste

**Vérification**:
```bash
php artisan tinker
Question::find(1); // Devrait être null
```

**✅ PASS** / **❌ FAIL**

#### 3.5 - Supprimer une réponse

**Étapes**:
1. Accéder à une question avec réponses
2. Cliquer sur "Supprimer" sur une réponse (bouton modérateur)
3. Confirmer

**Résultats attendus**:
- ✅ Réponse disparaît immédiatement
- ✅ Compteur de réponses décrémenté

**✅ PASS** / **❌ FAIL**

#### 3.6 - Gérer les tags

**Étapes**:
1. Accéder à `/tags`
2. Vérifier que les boutons de gestion sont visibles (si implémentés)

**Résultats attendus**:
- ✅ Page tags accessible
- ✅ Liste des tags visible

**Note**: CRUD tags complet nécessite routes resource (déjà définies)

**✅ PASS** / **❌ FAIL**

---

## ✅ SCÉNARIO 4: SYSTÈME DE RÉPUTATION

### Objectif
Vérifier le calcul automatique de la réputation

### Préparation
```bash
php artisan tinker

// Réinitialiser les réputations
User::where('email', 'student@test.com')->update(['reputation' => 1]);
User::where('email', 'student2@test.com')->update(['reputation' => 1]);
```

### Tests

#### 4.1 - Vote positif sur question

**Étapes**:
1. Student 1 pose une question
2. Student 2 vote positivement

**Résultat attendu**:
- ✅ Réputation Student 1 = 1 + 10 = **11**

**Vérification**:
```bash
php artisan tinker
User::where('email', 'student@test.com')->first()->reputation;
```

**✅ PASS** / **❌ FAIL**

#### 4.2 - Vote négatif sur question

**Étapes**:
1. Moderator vote négativement sur la question de Student 1

**Résultat attendu**:
- ✅ Réputation Student 1 = 11 - 2 = **9**

**✅ PASS** / **❌ FAIL**

#### 4.3 - Réponse acceptée

**Étapes**:
1. Student 2 répond à la question de Student 1
2. Student 1 accepte la réponse

**Résultat attendu**:
- ✅ Réputation Student 2 = 1 + 20 = **21**

**✅ PASS** / **❌ FAIL**

#### 4.4 - Vote positif sur réponse

**Étapes**:
1. Moderator vote positivement sur la réponse de Student 2

**Résultat attendu**:
- ✅ Réputation Student 2 = 21 + 10 = **31**

**✅ PASS** / **❌ FAIL**

#### 4.5 - Désaccepter une réponse

**Étapes**:
1. Student 1 clique à nouveau sur le ✓ pour désaccepter

**Résultat attendu**:
- ✅ Réputation Student 2 = 31 - 20 = **11**
- ✅ Badge "Acceptée" disparu
- ✅ Fond vert disparu

**✅ PASS** / **❌ FAIL**

#### 4.6 - Changer de vote (positif → négatif)

**Étapes**:
1. Student 2 a voté positivement sur une question
2. Student 2 clique sur la flèche BAS

**Résultat attendu**:
- ✅ Ancien vote retiré (-10)
- ✅ Nouveau vote appliqué (-2)
- ✅ Changement net: -12 points

**✅ PASS** / **❌ FAIL**

---

## ✅ SCÉNARIO 5: RECHERCHE & FILTRAGE

### 5.1 - Recherche par mot-clé

**URL**: `http://127.0.0.1:8000/questions?search=Laravel`

**Résultat attendu**:
- ✅ Questions contenant "Laravel" dans titre ou body

**✅ PASS** / **❌ FAIL**

### 5.2 - Filtrage par tag

**URL**: `http://127.0.0.1:8000/questions?tag=php`

**Résultat attendu**:
- ✅ Seules les questions avec tag PHP

**✅ PASS** / **❌ FAIL**

### 5.3 - Filtrage par statut (résolues)

**URL**: `http://127.0.0.1:8000/questions?filter=solved`

**Résultat attendu**:
- ✅ Seules les questions avec `is_solved = true`

**✅ PASS** / **❌ FAIL**

### 5.4 - Filtrage par statut (non résolues)

**URL**: `http://127.0.0.1:8000/questions?filter=unsolved`

**Résultat attendu**:
- ✅ Seules les questions avec `is_solved = false`

**✅ PASS** / **❌ FAIL**

### 5.5 - Tri par activité

**URL**: `http://127.0.0.1:8000/questions?sort=active`

**Résultat attendu**:
- ✅ Questions avec réponses récentes en premier

**✅ PASS** / **❌ FAIL**

### 5.6 - Combinaison de filtres

**URL**: `http://127.0.0.1:8000/questions?search=Laravel&tag=php&filter=unsolved`

**Résultat attendu**:
- ✅ Questions Laravel + tag PHP + non résolues

**✅ PASS** / **❌ FAIL**

---

## 📊 RÉSUMÉ DES RÉSULTATS

### Scénario 1: Guest
- Total tests: 7
- Réussis: ___
- Échoués: ___

### Scénario 2: Student
- Total tests: 16
- Réussis: ___
- Échoués: ___

### Scénario 3: Modérateur
- Total tests: 6
- Réussis: ___
- Échoués: ___

### Scénario 4: Réputation
- Total tests: 6
- Réussis: ___
- Échoués: ___

### Scénario 5: Recherche
- Total tests: 6
- Réussis: ___
- Échoués: ___

### TOTAL GLOBAL
- **Total tests**: 41
- **Réussis**: ___
- **Échoués**: ___
- **Taux de réussite**: ___%

---

## 🐛 BUGS IDENTIFIÉS

| # | Scénario | Description | Priorité | Statut |
|---|----------|-------------|----------|--------|
| 1 |  |  |  |  |
| 2 |  |  |  |  |
| 3 |  |  |  |  |

---

## ✅ CONCLUSION

**Date du test**: ___________  
**Testeur**: ___________  
**Version**: 1.0.0

**Commentaires**:
_______________________________________
_______________________________________
_______________________________________
