# 📝 Documentation d'implémentation - AskCampus

## ✅ Logique métier implémentée

### QuestionController

#### `index()` - Liste des questions
- ✅ Recherche par mots-clés avec `where` sur titre et `orWhere` sur body
- ✅ Filtrage par tag via le paramètre `?tag=slug`
- ✅ Filtrage par statut (résolu/non résolu) via `?filter=solved` ou `?filter=unsolved`
- ✅ Pagination (15 questions par page)
- ✅ Chargement eager des relations (user, tags, answers, votes)

**Exemple d'URLs :**
```
/questions                          → Toutes les questions
/questions?search=laravel          → Recherche "laravel"
/questions?tag=php                 → Questions avec tag PHP
/questions?filter=unsolved         → Questions non résolues
/questions?search=jwt&tag=laravel  → Combinaison de filtres
```

#### `create()` - Formulaire de création
- ✅ Affiche le formulaire avec la liste des tags disponibles
- ✅ Panneau latéral avec conseils UX

#### `store()` - Enregistrement d'une question
- ✅ Validation via `StoreQuestionRequest`
- ✅ Création de la question pour l'utilisateur connecté
- ✅ Attachement des tags sélectionnés
- ✅ Redirection vers la page de la question créée

#### `show()` - Affichage d'une question
- ✅ Incrémentation automatique du compteur de vues
- ✅ Chargement des réponses triées :
  - 1️⃣ Réponses acceptées en premier (`is_accepted DESC`)
  - 2️⃣ Puis par score de votes décroissant (`vote_score DESC`)
- ✅ Calcul du score de votes avec `COALESCE(SUM(value), 0)`

### AnswerController

#### `store()` - Enregistrement d'une réponse
- ✅ Validation via `StoreAnswerRequest`
- ✅ Vérification que la question n'est pas fermée
- ✅ Création de la réponse liée à la question
- ✅ Redirection vers la question avec message de succès

#### `accept()` - Acceptation d'une réponse
- ✅ Vérification que l'utilisateur est l'auteur de la question (403 sinon)
- ✅ Désacceptation de toutes les autres réponses
- ✅ Acceptation de la réponse sélectionnée
- ✅ Marquage de la question comme résolue

### Form Requests

#### StoreQuestionRequest
```php
'title' => min:10, max:255
'body' => min:20
'tags' => max:5 tags
```

#### StoreAnswerRequest
```php
'body' => min:10
```

- ✅ Messages de validation en français
- ✅ Règles de longueur minimale pour éviter le spam

## 🛣️ Routes configurées

### Routes publiques
```php
GET  /questions              → Liste des questions
GET  /questions/{question}   → Détail d'une question
```

### Routes protégées (auth)
```php
GET   /questions/create                  → Formulaire de création
POST  /questions                         → Enregistrer une question
POST  /questions/{question}/answers      → Ajouter une réponse
PATCH /answers/{answer}/accept           → Accepter une réponse
POST  /vote                              → Voter (à implémenter)
```

## 🔍 Requêtes SQL optimisées

### Tri des réponses
```sql
SELECT *, COALESCE(SUM(votes.value), 0) as vote_score
FROM answers
LEFT JOIN votes ON votes.votable_id = answers.id 
  AND votes.votable_type = 'App\Models\Answer'
GROUP BY answers.id
ORDER BY is_accepted DESC, vote_score DESC
```

### Recherche de questions
```sql
SELECT * FROM questions
WHERE (title LIKE '%search%' OR body LIKE '%search%')
  AND EXISTS (
    SELECT 1 FROM question_tag 
    JOIN tags ON tags.id = question_tag.tag_id
    WHERE question_tag.question_id = questions.id
      AND tags.slug = 'php'
  )
ORDER BY created_at DESC
```

## 📊 Commentaires dans le code

Tous les commentaires sont en français, courts et directs :
```php
// Recherche par mots-clés (titre ou contenu)
// Filtre par tag (slug)
// Incrémenter le compteur de vues
// Désaccepter toutes les autres réponses
```

## 🚀 Prochaines étapes

- [ ] Implémenter la logique de votes (VoteController)
- [ ] Tester l'interface utilisateur
- [ ] Ajouter des tests unitaires
- [ ] Optimiser les requêtes avec des index

## 🧪 Tests manuels

Pour tester l'implémentation :

```bash
# 1. Réinitialiser la base de données avec des données de test
php artisan migrate:fresh --seed

# 2. Lancer le serveur
php artisan serve

# 3. Tester les URLs
http://localhost:8000/questions
http://localhost:8000/questions?search=laravel
http://localhost:8000/questions?tag=php
http://localhost:8000/questions/1
```
