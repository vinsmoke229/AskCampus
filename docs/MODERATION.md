# 🛡️ Système de Modération - AskCampus

## Vue d'ensemble

Le système de modération d'AskCampus permet aux modérateurs de maintenir la qualité du contenu et de gérer les questions/réponses inappropriées.

---

## 🔐 Architecture

### Middleware IsModerator

**Fichier** : `app/Http/Middleware/IsModerator.php`

```php
public function handle(Request $request, Closure $next): Response
{
    // Vérifier si l'utilisateur est connecté et modérateur
    if (!auth()->check() || !auth()->user()->isModerator()) {
        abort(403, 'Accès réservé aux modérateurs.');
    }
    return $next($request);
}
```

**Enregistrement** : `bootstrap/app.php`

```php
$middleware->alias([
    'moderator' => \App\Http\Middleware\IsModerator::class,
]);
```

### Modèle User

**Champ ajouté** : `is_moderator` (boolean, default: false)

```php
// Migration
$table->boolean('is_moderator')->default(false)->after('reputation');

// Cast dans le modèle
'is_moderator' => 'boolean',

// Méthode helper
public function isModerator(): bool
{
    return $this->is_moderator;
}
```

---

## 🎯 Actions de modération

### 1. Fermer une question

**Route** : `PATCH /questions/{question}/close`

**Contrôleur** : `QuestionController@close`

```php
public function close(Question $question)
{
    $question->update(['is_closed' => true]);
    return redirect()->route('questions.show', $question)
        ->with('success', 'Question fermée avec succès.');
}
```

**Effet** :
- La question ne peut plus recevoir de nouvelles réponses
- Badge rouge "🔒 Fermée" affiché
- Tentative de réponse → Message d'erreur

### 2. Rouvrir une question

**Route** : `PATCH /questions/{question}/reopen`

**Contrôleur** : `QuestionController@reopen`

```php
public function reopen(Question $question)
{
    $question->update(['is_closed' => false]);
    return redirect()->route('questions.show', $question)
        ->with('success', 'Question rouverte avec succès.');
}
```

**Effet** :
- La question accepte à nouveau des réponses
- Badge "Fermée" retiré

### 3. Supprimer une question

**Route** : `DELETE /questions/{question}`

**Contrôleur** : `QuestionController@destroy`

```php
public function destroy(Question $question)
{
    $question->delete();
    return redirect()->route('questions.index')
        ->with('success', 'Question supprimée avec succès.');
}
```

**Effet** :
- Question supprimée définitivement
- Réponses et votes supprimés en cascade (onDelete: cascade)
- Redirection vers la liste des questions

### 4. Supprimer une réponse

**Route** : `DELETE /answers/{answer}`

**Contrôleur** : `AnswerController@destroy`

```php
public function destroy(Answer $answer)
{
    $question = $answer->question;
    $answer->delete();
    return redirect()->route('questions.show', $question)
        ->with('success', 'Réponse supprimée avec succès.');
}
```

**Effet** :
- Réponse supprimée
- Votes associés supprimés en cascade
- Reste sur la page de la question

---

## 🎨 Interface utilisateur

### Boutons de modération (Question)

**Emplacement** : En haut à droite de la question

```blade
@if(auth()->user()->isModerator())
    <div class="flex items-center space-x-2">
        @if($question->is_closed)
            <form action="{{ route('questions.reopen', $question) }}" method="POST">
                <button class="bg-green-600">Rouvrir</button>
            </form>
        @else
            <form action="{{ route('questions.close', $question) }}" method="POST">
                <button class="bg-yellow-600">Fermer</button>
            </form>
        @endif
        
        <form action="{{ route('questions.destroy', $question) }}" method="POST" 
              onsubmit="return confirm('Êtes-vous sûr ?')">
            <button class="bg-red-600">Supprimer</button>
        </form>
    </div>
@endif
```

**Couleurs** :
- Vert : Rouvrir (action positive)
- Jaune : Fermer (action d'avertissement)
- Rouge : Supprimer (action destructive)

### Bouton de modération (Réponse)

**Emplacement** : En bas à gauche de chaque réponse

```blade
@if(auth()->user()->isModerator())
    <form action="{{ route('answers.destroy', $answer) }}" method="POST" 
          onsubmit="return confirm('Êtes-vous sûr ?')">
        <button class="bg-red-600">Supprimer</button>
    </form>
@endif
```

---

## 🔒 Sécurité

### Protection des routes

```php
// routes/web.php
Route::middleware(['auth', 'moderator'])->group(function () {
    Route::patch('/questions/{question}/close', [QuestionController::class, 'close']);
    Route::patch('/questions/{question}/reopen', [QuestionController::class, 'reopen']);
    Route::delete('/questions/{question}', [QuestionController::class, 'destroy']);
    Route::delete('/answers/{answer}', [AnswerController::class, 'destroy']);
});
```

### Vérifications

1. **Authentification** : Middleware `auth`
2. **Rôle modérateur** : Middleware `moderator`
3. **Confirmation** : JavaScript `onsubmit="return confirm()"`
4. **Messages** : Feedback utilisateur après chaque action

---

## 👤 Compte modérateur de test

**Email** : `mod@askcampus.com`  
**Mot de passe** : (défini lors du seeding)  
**Réputation** : 1000 points  
**Flag** : `is_moderator = true`

---

## 📊 Statistiques de modération

Pour ajouter un tableau de bord modérateur (future amélioration) :

```php
// Nombre de questions fermées
Question::where('is_closed', true)->count();

// Questions récemment modifiées
Question::latest('updated_at')->limit(10)->get();

// Utilisateurs avec réputation négative
User::where('reputation', '<', 0)->get();
```

---

## 🚀 Utilisation

### Devenir modérateur

**Via Tinker** :
```php
php artisan tinker
$user = User::find(1);
$user->is_moderator = true;
$user->save();
```

**Via Seeder** :
```php
User::factory()->create([
    'email' => 'mod@askcampus.com',
    'is_moderator' => true,
]);
```

### Tester la modération

1. Connectez-vous avec `mod@askcampus.com`
2. Naviguez vers n'importe quelle question
3. Les boutons de modération apparaissent automatiquement
4. Testez fermer/rouvrir/supprimer

---

## ✅ Checklist d'implémentation

- [x] Migration `is_moderator` sur table users
- [x] Middleware `IsModerator`
- [x] Méthode `isModerator()` dans User
- [x] Routes protégées par middleware
- [x] Méthodes de contrôleur (close, reopen, destroy)
- [x] Boutons dans les vues
- [x] Confirmations JavaScript
- [x] Messages de succès
- [x] Compte modérateur dans le seeder
- [x] Documentation complète

Le système de modération est opérationnel ! 🛡️
