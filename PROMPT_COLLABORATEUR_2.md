# 🤖 PROMPT POUR AGENT IA - COLLABORATEUR 2 (Frontend)

## 📋 CONTEXTE DU PROJET

Tu travailles sur **AskCampus**, un clone de Stack Overflow développé en Laravel 11. Le projet est à **85% complété** et tu dois implémenter les **4 fonctionnalités frontend restantes** pour atteindre 95%.

**Architecture actuelle** :
- Laravel 11 + Blade + Tailwind CSS
- Base de données : MySQL
- Authentification : Laravel Breeze
- Design : Stack Overflow exact (couleurs, typographie, layout)

**Modèles existants** :
- `User` (name, email, reputation, is_moderator)
- `Question` (title, body, user_id, is_solved, views, is_closed)
- `Answer` (body, question_id, user_id, is_accepted)
- `Tag` (name, slug, description)
- `Vote` (user_id, votable_id, votable_type, value)

**Relations** :
- Question belongsTo User, belongsToMany Tag, hasMany Answer/Vote
- Answer belongsTo User/Question, morphMany Vote
- User hasMany Question/Answer/Vote, belongsToMany Question (follows)

---

## 🎯 TES 4 TÂCHES À IMPLÉMENTER

### ✅ TÂCHE 1 : SearchController dédié

**Objectif** : Créer un contrôleur dédié pour séparer la logique de recherche du QuestionController.

**Étapes** :
1. Créer le contrôleur : `php artisan make:controller SearchController`
2. Implémenter 4 méthodes :
   - `index()` - Recherche globale (questions + users + tags)
   - `questions()` - Recherche dans questions seulement
   - `users()` - Recherche d'utilisateurs par nom
   - `tags()` - Recherche de tags par nom
3. Ajouter la route : `Route::get('/search', [SearchController::class, 'index'])->name('search');`
4. Créer la vue : `resources/views/search/index.blade.php`

**Logique de recherche** :
- Questions : `WHERE title LIKE %query% OR body LIKE %query%`
- Users : `WHERE name LIKE %query% OR email LIKE %query%`
- Tags : `WHERE name LIKE %query% OR description LIKE %query%`

**Interface** : Style Stack Overflow avec onglets (Questions, Users, Tags) et résultats paginés.

---

### ✅ TÂCHE 2 : Système de notifications

**Objectif** : Implémenter des notifications pour les événements importants.

**Étapes** :
1. Créer la table : `php artisan notifications:table && php artisan migrate`
2. Créer 3 notifications :
   ```bash
   php artisan make:notification AnswerAccepted
   php artisan make:notification VoteReceived  
   php artisan make:notification NewAnswerOnFollowedQuestion
   ```
3. Implémenter la logique dans chaque notification (via, toArray, etc.)
4. Déclencher les notifications dans les contrôleurs appropriés
5. Créer `NotificationController` pour afficher/marquer comme lues
6. Ajouter l'icône de notification dans la navbar avec compteur

**Événements à notifier** :
- Réponse acceptée → Auteur de la réponse
- Vote reçu → Auteur du contenu voté
- Nouvelle réponse → Utilisateurs qui suivent la question

---

### ✅ TÂCHE 3 : Amélioration interface tags

**Objectif** : Enrichir la page `/tags` existante avec de nouvelles fonctionnalités.

**Fichier à modifier** : `resources/views/tags/index.blade.php`

**Améliorations à ajouter** :
1. **Icônes pour tags** : Ajouter des icônes SVG selon le type (💻 pour tech, 🎨 pour design, etc.)
2. **Graphiques de popularité** : Barres de progression montrant l'usage relatif
3. **Filtres par catégorie** : Boutons Frontend, Backend, Database, Mobile, etc.
4. **Tri par activité** : Option "Récemment utilisés" en plus de "Populaire" et "Nom"
5. **Statistiques avancées** : Questions cette semaine, utilisateurs actifs par tag

**Design** : Garder le style Stack Overflow, grille responsive, cartes avec hover effects.

---

### ✅ TÂCHE 4 : Page utilisateurs

**Objectif** : Créer une page complète listant tous les utilisateurs.

**Fichiers à créer** :
- `resources/views/users/index.blade.php`
- Améliorer `app/Http/Controllers/UserController.php` (méthode `index()` existe déjà)

**Fonctionnalités** :
1. **Liste paginée** : Tous les utilisateurs avec pagination (30 par page)
2. **Tri multiple** : Réputation (DESC), Date inscription, Dernière activité
3. **Recherche** : Par nom d'utilisateur (AJAX en temps réel)
4. **Cartes utilisateur** : Avatar coloré, nom, réputation, badges, stats (questions/réponses)
5. **Filtres** : Modérateurs, Nouveaux (< 7 jours), Actifs (connectés récemment)

**Design** : Grille 3-4 colonnes responsive, style Stack Overflow, hover effects.

---

## 🎨 CONTRAINTES DE DESIGN

**Couleurs Stack Overflow à respecter** :
- Bleu principal : `#0074cc` (liens)
- Bleu hover : `#0a95ff`
- Orange : `#f48225` (badges, accents)
- Gris texte : `#232629` (titres), `#6a737c` (texte), `#9fa6ad` (meta)
- Bordures : `#e3e6e8`, `#d6d9dc`, `#babfc4`
- Tags : `#e1ecf4` (fond), `#39739d` (texte)
- Succès : `#5eba7d`
- Erreur : `#d93025`

**Typographie** :
- Titres : 21px, font-weight 400
- Texte : 15px (contenu), 13px (UI), 12px (meta)
- Font-family : system fonts (Segoe UI, Arial, sans-serif)

**Layout** :
- Container max-width : 1264px
- Border-radius : 3px (pas de rounded-lg)
- Padding : 12px, 16px, 24px
- Gaps : 8px, 12px, 16px, 24px

---

## 📁 STRUCTURE DES FICHIERS

**Contrôleurs à créer/modifier** :
```
app/Http/Controllers/
├── SearchController.php          ← Créer
├── NotificationController.php    ← Créer  
├── UserController.php           ← Modifier (index method)
└── TagController.php            ← Modifier si nécessaire
```

**Vues à créer/modifier** :
```
resources/views/
├── search/
│   └── index.blade.php          ← Créer
├── notifications/
│   └── index.blade.php          ← Créer
├── users/
│   └── index.blade.php          ← Créer
├── tags/
│   └── index.blade.php          ← Modifier
└── layouts/
    └── app.blade.php            ← Modifier (ajouter icône notifications)
```

**Notifications à créer** :
```
app/Notifications/
├── AnswerAccepted.php           ← Créer
├── VoteReceived.php             ← Créer
└── NewAnswerOnFollowedQuestion.php ← Créer
```

---

## 🔧 COMMANDES À EXÉCUTER

```bash
# 1. Créer les contrôleurs
php artisan make:controller SearchController
php artisan make:controller NotificationController

# 2. Créer les notifications
php artisan make:notification AnswerAccepted
php artisan make:notification VoteReceived
php artisan make:notification NewAnswerOnFollowedQuestion

# 3. Créer la table notifications
php artisan notifications:table
php artisan migrate

# 4. Tester le serveur
php artisan serve
```

---

## 📋 ROUTES À AJOUTER

**Dans `routes/web.php`** :
```php
// Recherche
Route::get('/search', [SearchController::class, 'index'])->name('search');
Route::get('/search/questions', [SearchController::class, 'questions'])->name('search.questions');
Route::get('/search/users', [SearchController::class, 'users'])->name('search.users');
Route::get('/search/tags', [SearchController::class, 'tags'])->name('search.tags');

// Notifications (auth required)
Route::middleware('auth')->group(function () {
    Route::get('/notifications', [NotificationController::class, 'index'])->name('notifications.index');
    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.readAll');
});
```

---

## 🧪 TESTS À EFFECTUER

**Après chaque tâche** :
1. **SearchController** : Tester `/search?q=Laravel` → résultats questions/users/tags
2. **Notifications** : Accepter une réponse → notification créée et visible
3. **Tags améliorés** : Vérifier filtres, icônes, graphiques
4. **Users page** : Tester tri, recherche, pagination

**URLs à tester** :
- `http://127.0.0.1:8000/search`
- `http://127.0.0.1:8000/notifications`
- `http://127.0.0.1:8000/users`
- `http://127.0.0.1:8000/tags`

---

## 💡 CONSEILS D'IMPLÉMENTATION

### Pour SearchController :
- Utiliser `LIKE %query%` pour la recherche
- Paginer les résultats (15 par page)
- Ajouter des filtres (date, popularité)
- Interface avec onglets JavaScript

### Pour Notifications :
- Utiliser `toArray()` pour stocker en DB
- Ajouter timestamps et read_at
- Icône avec badge compteur dans navbar
- Marquer comme lues au clic

### Pour Tags améliorés :
- Icônes : utiliser des SVG ou emojis
- Graphiques : barres CSS avec width en %
- Filtres : JavaScript pour masquer/afficher
- AJAX pour recherche en temps réel

### Pour Users page :
- Avatars : couleurs basées sur hash du nom
- Stats : compter questions/réponses par user
- Recherche : debounce 300ms
- Tri : paramètres URL (?sort=reputation)

---

## 🚀 OBJECTIF FINAL

À la fin de tes 4 tâches, le projet doit avoir :
- ✅ Recherche globale fonctionnelle
- ✅ Système de notifications basique
- ✅ Interface tags enrichie
- ✅ Page utilisateurs complète
- 🎯 **95% de fonctionnalités complètes**

**Critères de réussite** :
- Toutes les URLs fonctionnent sans erreur
- Design respecte Stack Overflow
- Fonctionnalités testées manuellement
- Code propre et commenté en français

---

## 📞 RESSOURCES

**Fichiers de référence** :
- `routes/web.php` - Toutes les routes existantes
- `resources/views/questions/index.blade.php` - Exemple de liste avec filtres
- `resources/views/layouts/app.blade.php` - Layout principal
- `app/Http/Controllers/QuestionController.php` - Exemple de contrôleur

**Documentation Laravel** :
- Notifications : https://laravel.com/docs/11.x/notifications
- Pagination : https://laravel.com/docs/11.x/pagination
- Blade : https://laravel.com/docs/11.x/blade

**En cas de problème** :
- Vérifier les logs : `storage/logs/laravel.log`
- Tester en Tinker : `php artisan tinker`
- Vider le cache : `php artisan optimize:clear`