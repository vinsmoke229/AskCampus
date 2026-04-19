# 🤖 PROMPT POUR AGENT IA - COLLABORATEUR 1 (Backend)

## 📋 CONTEXTE DU PROJET

Tu travailles sur **AskCampus**, un clone de Stack Overflow développé en Laravel 11. Le projet est à **85% complété** et tu dois corriger le **système de réputation** pour qu'il soit conforme aux standards Stack Overflow.

**Architecture actuelle** :
- Laravel 11 + MySQL
- Authentification : Laravel Breeze
- Système de votes polymorphe (Questions + Answers)
- Observers pour calcul automatique de réputation

**Modèles existants** :
- `User` (name, email, reputation, is_moderator)
- `Question` (title, body, user_id, is_solved, views, is_closed)
- `Answer` (body, question_id, user_id, is_accepted)
- `Vote` (user_id, votable_id, votable_type, value) - value = 1 ou -1

**Observer actuel** : `app/Observers/VoteObserver.php` gère la réputation automatiquement.

---

## 🎯 TES 2 TÂCHES À CORRIGER

### ✅ TÂCHE 1 : Ajustement système de réputation

**Problème actuel** : 
- Vote sur question = +10 points (incorrect)
- Vote sur réponse = +10 points (correct)
- Pas de distinction entre Question et Answer

**Solution Stack Overflow** :
- Vote positif sur **question** = **+5 points**
- Vote positif sur **réponse** = **+10 points**
- Vote négatif = **-2 points** (pour les deux)

**Fichier à modifier** : `app/Observers/VoteObserver.php`

**Code à changer** (ligne 45-50 environ) :
```php
// AVANT (incorrect)
$reputationChange = $value > 0 ? 10 : -2;

// APRÈS (correct)
if ($votable instanceof \App\Models\Question) {
    $reputationChange = $value > 0 ? 5 : -2;  // Question: +5/-2
} else {
    $reputationChange = $value > 0 ? 10 : -2; // Answer: +10/-2
}
```

---

### ✅ TÂCHE 2 : Pénalité vote négatif

**Problème actuel** : 
- Seul l'auteur du contenu voté perd/gagne de la réputation
- Le voteur n'a aucune conséquence

**Solution Stack Overflow** :
- Celui qui vote **négativement** perd **-1 point** de réputation
- Cela décourage les votes négatifs abusifs

**Fichier à modifier** : `app/Observers/VoteObserver.php`

**Code à ajouter** (après la mise à jour de réputation de l'auteur) :
```php
// Pénalité pour celui qui vote négativement
if ($value < 0) {
    $voter = \App\Models\User::find($vote->user_id);
    if ($voter) {
        $voter->decrement('reputation', 1);
    }
}
```

---

## 📁 FICHIER À MODIFIER

**Fichier unique** : `app/Observers/VoteObserver.php`

**Structure actuelle** :
```php
<?php

namespace App\Observers;

use App\Models\Vote;

class VoteObserver
{
    public function created(Vote $vote): void
    {
        $this->updateReputation($vote, 'add');
    }

    public function updated(Vote $vote): void
    {
        // Logique de mise à jour
    }

    public function deleted(Vote $vote): void
    {
        $this->updateReputation($vote, 'remove');
    }

    private function updateReputation(Vote $vote, string $action, ?int $value = null): void
    {
        // C'EST ICI QU'IL FAUT MODIFIER LA LOGIQUE
    }
}
```

---

## 🔧 MODIFICATIONS DÉTAILLÉES

### Modification 1 : Distinction Question vs Answer

**Localiser** la ligne qui calcule `$reputationChange` (environ ligne 45-50) :
```php
// LIGNE À REMPLACER
$reputationChange = $value > 0 ? 10 : -2;
```

**Par ce code** :
```php
// Distinguer Question vs Answer pour le calcul de réputation
if ($votable instanceof \App\Models\Question) {
    // Vote sur question : +5 positif, -2 négatif
    $reputationChange = $value > 0 ? 5 : -2;
} else {
    // Vote sur réponse : +10 positif, -2 négatif  
    $reputationChange = $value > 0 ? 10 : -2;
}
```

### Modification 2 : Pénalité voteur négatif

**Localiser** la fin de la méthode `updateReputation()`, après :
```php
if ($action === 'add') {
    $author->increment('reputation', $reputationChange);
} else {
    $author->decrement('reputation', $reputationChange);
}
```

**Ajouter ce code** :
```php
// Pénalité pour celui qui vote négativement (-1 point)
if ($action === 'add' && $value < 0) {
    $voter = \App\Models\User::find($vote->user_id);
    if ($voter && $voter->id !== $author->id) {
        $voter->decrement('reputation', 1);
    }
}
```

---

## 🧪 TESTS À EFFECTUER

### Test 1 : Vote positif sur question
```bash
php artisan tinker

# Créer un vote positif sur question
$user1 = User::find(1);
$user2 = User::find(2);
$question = $user1->questions()->first();

# Réputation avant
echo "User1 avant: " . $user1->reputation;

# Voter
Vote::create([
    'user_id' => $user2->id,
    'votable_id' => $question->id,
    'votable_type' => 'App\Models\Question',
    'value' => 1
]);

# Réputation après (devrait être +5)
echo "User1 après: " . $user1->fresh()->reputation;
```

### Test 2 : Vote négatif avec pénalité
```bash
php artisan tinker

# Réputation avant
$voter = User::find(2);
$author = User::find(1);
echo "Voter avant: " . $voter->reputation;
echo "Author avant: " . $author->reputation;

# Vote négatif
Vote::create([
    'user_id' => $voter->id,
    'votable_id' => $question->id,
    'votable_type' => 'App\Models\Question',
    'value' => -1
]);

# Réputation après
echo "Voter après: " . $voter->fresh()->reputation; // -1
echo "Author après: " . $author->fresh()->reputation; // -2
```

### Test 3 : Vote sur réponse (doit rester +10)
```bash
php artisan tinker

$answer = Answer::first();
$author = $answer->user;
echo "Author avant: " . $author->reputation;

Vote::create([
    'user_id' => 2,
    'votable_id' => $answer->id,
    'votable_type' => 'App\Models\Answer',
    'value' => 1
]);

echo "Author après: " . $author->fresh()->reputation; // +10
```

---

## 📊 TABLEAU DE RÉPUTATION ATTENDU

| Action | Avant | Après |
|--------|-------|-------|
| Vote + sur question | +10 | **+5** ✅ |
| Vote + sur réponse | +10 | **+10** ✅ |
| Vote - sur question | -2 | **-2** ✅ |
| Vote - sur réponse | -2 | **-2** ✅ |
| Voter négativement | 0 | **-1** ✅ |

---

## 🚨 POINTS D'ATTENTION

### 1. Import des classes
Assure-toi que les imports sont corrects en haut du fichier :
```php
use App\Models\Vote;
use App\Models\User;
use App\Models\Question;
use App\Models\Answer;
```

### 2. Éviter les boucles infinies
Dans la pénalité voteur, vérifier que le voteur n'est pas l'auteur :
```php
if ($voter && $voter->id !== $author->id) {
    $voter->decrement('reputation', 1);
}
```

### 3. Gestion des méthodes updated/deleted
Les modifications doivent aussi s'appliquer dans `updated()` et `deleted()` pour gérer :
- Changement de vote (positif → négatif)
- Suppression de vote

---

## 🔄 GESTION DES CAS COMPLEXES

### Changement de vote (updated)
```php
public function updated(Vote $vote): void
{
    $oldValue = $vote->getOriginal('value');
    $newValue = $vote->value;

    // Retirer l'ancienne réputation
    $this->updateReputation($vote, 'remove', $oldValue);

    // Ajouter la nouvelle réputation
    $this->updateReputation($vote, 'add', $newValue);
}
```

### Suppression de vote (deleted)
```php
public function deleted(Vote $vote): void
{
    $this->updateReputation($vote, 'remove');
    
    // Rembourser la pénalité si c'était un vote négatif
    if ($vote->value < 0) {
        $voter = User::find($vote->user_id);
        if ($voter) {
            $voter->increment('reputation', 1);
        }
    }
}
```

---

## 🎯 OBJECTIF FINAL

Après tes modifications, le système de réputation doit être **100% conforme à Stack Overflow** :

✅ **Vote question** : +5/-2 points  
✅ **Vote réponse** : +10/-2 points  
✅ **Pénalité voteur négatif** : -1 point  
✅ **Gestion changements** : updated/deleted  

---

## 🚀 COMMANDES UTILES

```bash
# Réinitialiser les réputations pour tester
php artisan tinker
User::query()->update(['reputation' => 1]);

# Vérifier les votes existants
Vote::with('votable', 'user')->get();

# Tester le serveur
php artisan serve

# Vider le cache si nécessaire
php artisan optimize:clear
```

---

## 📞 VALIDATION

**Critères de réussite** :
1. Vote positif question = +5 (au lieu de +10)
2. Vote négatif = -1 pour le voteur
3. Vote réponse = +10 (inchangé)
4. Pas d'erreurs dans les logs
5. Tests manuels passent

**Fichier modifié** : `app/Observers/VoteObserver.php` uniquement

**Durée estimée** : 2-3 heures maximum