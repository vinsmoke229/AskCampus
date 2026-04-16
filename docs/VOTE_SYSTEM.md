# 🗳️ Système de Vote et Réputation - AskCampus

## Vue d'ensemble

Le système de vote d'AskCampus utilise une **relation polymorphe** pour permettre aux utilisateurs de voter sur les questions et les réponses avec un seul système unifié.

## 📊 Logique de Réputation

### Points attribués

| Action | Points |
|--------|--------|
| Vote positif reçu (+1) | **+10 points** |
| Vote négatif reçu (-1) | **-2 points** |
| Réponse acceptée | **+20 points** |

### Règles anti-triche

✅ Un utilisateur **ne peut pas** voter sur son propre contenu  
✅ Un utilisateur ne peut voter qu'**une seule fois** par contenu (contrainte unique)  
✅ Les votes sont vérifiés via **VotePolicy**

## 🔧 Architecture technique

### VoteController

```php
POST /vote
```

**Paramètres requis :**
- `votable_type` : `App\Models\Question` ou `App\Models\Answer`
- `votable_id` : ID de la question ou réponse
- `value` : `1` (upvote) ou `-1` (downvote)

**Comportement :**

1. **Nouveau vote** : Crée un vote et met à jour la réputation
2. **Vote identique** : Supprime le vote (toggle) et retire la réputation
3. **Vote différent** : Change le vote et ajuste la réputation

### VotePolicy

Vérifie les autorisations avant de voter :

```php
// Empêche de voter sur son propre contenu
public function voteOnQuestion(User $user, Question $question): Response
{
    return $question->user_id !== $user->id
        ? Response::allow()
        : Response::deny('Vous ne pouvez pas voter sur votre propre question.');
}
```

### VoteObserver

Gère automatiquement la réputation lors des événements :

- **`created`** : Ajoute la réputation à l'auteur
- **`updated`** : Retire l'ancienne et ajoute la nouvelle réputation
- **`deleted`** : Retire la réputation

```php
// Vote positif : +10 points
// Vote négatif : -2 points
$reputationChange = $value > 0 ? 10 : -2;
```

## 🎨 Interface utilisateur

### Composant Blade réutilisable

```blade
<x-vote-buttons :votable="$question" type="App\Models\Question" />
<x-vote-buttons :votable="$answer" type="App\Models\Answer" :question="$question" />
```

**Fonctionnalités :**
- ✅ Affiche les flèches de vote (haut/bas)
- ✅ Affiche le score total avec couleur (vert/rouge/gris)
- ✅ Highlight du vote de l'utilisateur connecté
- ✅ Désactive les boutons si l'utilisateur est l'auteur
- ✅ Bouton d'acceptation pour les réponses (si auteur de la question)
- ✅ Redirection vers login pour les visiteurs non connectés

### États visuels

| État | Apparence |
|------|-----------|
| Vote positif actif | Flèche verte + fond vert clair |
| Vote négatif actif | Flèche rouge + fond rouge clair |
| Score positif | Nombre en vert |
| Score négatif | Nombre en rouge |
| Score neutre | Nombre en gris |
| Propre contenu | Boutons désactivés |

## 📝 Méthodes des modèles

### Question & Answer

```php
// Calcule le score total
$question->vote_score; // Retourne la somme des votes

// Récupère le vote de l'utilisateur connecté
$question->userVote(); // Retourne 1, -1 ou null
```

## 🔄 Flux de vote complet

### 1. Utilisateur clique sur upvote

```
Vue Blade → POST /vote → VoteController
                            ↓
                    VotePolicy (vérification)
                            ↓
                    Vote créé/modifié/supprimé
                            ↓
                    VoteObserver déclenché
                            ↓
                    Réputation mise à jour
                            ↓
                    Redirection avec message
```

### 2. Exemples de scénarios

#### Scénario A : Premier vote positif
```
Action : User A vote +1 sur Question de User B
Résultat : 
  - Vote créé (value: 1)
  - User B gagne +10 points
  - Score de la question : +1
```

#### Scénario B : Toggle (retrait de vote)
```
Action : User A re-clique sur +1 (déjà voté +1)
Résultat :
  - Vote supprimé
  - User B perd -10 points
  - Score de la question : 0
```

#### Scénario C : Changement de vote
```
Action : User A clique sur -1 (avait voté +1)
Résultat :
  - Vote mis à jour (value: -1)
  - User B perd -10 points (ancien vote)
  - User B perd -2 points (nouveau vote)
  - Total : -12 points
  - Score de la question : -1
```

## 🛡️ Sécurité

### Validation (VoteRequest)

```php
'votable_type' => 'in:App\Models\Question,App\Models\Answer'
'votable_id' => 'exists:questions,id' ou 'exists:answers,id'
'value' => 'in:1,-1'
```

### Contrainte base de données

```sql
UNIQUE KEY (user_id, votable_id, votable_type)
```

Empêche les votes multiples du même utilisateur.

### Policy

```php
// Dans VoteController
$this->authorize('voteOnQuestion', $votable);
$this->authorize('voteOnAnswer', $votable);
```

## 🧪 Tests manuels

### Test 1 : Vote positif
```bash
# Connectez-vous avec un utilisateur
# Allez sur une question d'un autre utilisateur
# Cliquez sur la flèche du haut
# Vérifiez : score +1, réputation auteur +10
```

### Test 2 : Toggle
```bash
# Re-cliquez sur la même flèche
# Vérifiez : score 0, réputation auteur -10
```

### Test 3 : Anti-triche
```bash
# Créez une question
# Essayez de voter sur votre propre question
# Vérifiez : boutons désactivés
```

### Test 4 : Changement de vote
```bash
# Votez +1 sur une question
# Cliquez sur la flèche du bas
# Vérifiez : score -1, réputation ajustée
```

## 📈 Optimisations possibles

- [ ] Cache du score de votes (éviter SUM à chaque affichage)
- [ ] Queue pour les mises à jour de réputation
- [ ] Limitation de taux (rate limiting) pour éviter le spam
- [ ] Historique des votes pour analytics
- [ ] Badges basés sur la réputation

## 🎯 Utilisation dans les vues

### Vue questions/show.blade.php

```blade
<!-- Pour la question -->
<x-vote-buttons :votable="$question" type="App\Models\Question" />

<!-- Pour chaque réponse -->
@foreach($question->answers as $answer)
    <x-vote-buttons :votable="$answer" type="App\Models\Answer" :question="$question" />
@endforeach
```

### Affichage du score dans la liste

```blade
<div class="text-2xl font-bold">
    {{ $question->vote_score }}
</div>
```

## ✅ Checklist d'implémentation

- [x] VoteController avec logique toggle
- [x] VotePolicy pour anti-triche
- [x] VoteObserver pour réputation automatique
- [x] VoteRequest avec validation
- [x] Méthodes dans modèles (vote_score, userVote)
- [x] Composant Blade réutilisable
- [x] Mise à jour des vues
- [x] Routes configurées
- [x] Documentation complète

Le système de vote est maintenant **100% fonctionnel** ! 🎉
