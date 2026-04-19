# 👥 TÂCHES POUR LES 2 COLLABORATEURS

## 📊 STATUT ACTUEL DU PROJET
- **Complété**: 85% ✅
- **Fonctionnalités critiques**: Toutes implémentées ✅
- **Interface**: 100% Stack Overflow style ✅
- **Reste à faire**: 15% (fonctionnalités secondaires + tests)

---

## 🎯 RÉPARTITION DES TÂCHES

### 👨‍💻 **COLLABORATEUR 1** - Backend & Tests
**Durée estimée**: 2-3 jours

#### 🔴 PRIORITÉ HAUTE (Critique pour production)

##### 1. **Tests automatisés** ⚠️ URGENT
```bash
# Créer les tests de base
php artisan make:test AuthenticationTest
php artisan make:test QuestionTest
php artisan make:test VoteTest
php artisan make:test ReputationTest
```

**Tests à implémenter**:
- ✅ Test authentification (login/register/logout)
- ✅ Test CRUD questions (create/read/update/delete)
- ✅ Test système de votes (vote positif/négatif/changement)
- ✅ Test calcul réputation (vote reçu, réponse acceptée)
- ✅ Test policies (autorisations edit/delete)

**Fichiers à créer**:
- `tests/Feature/AuthenticationTest.php`
- `tests/Feature/QuestionTest.php`
- `tests/Feature/VoteTest.php`
- `tests/Feature/ReputationTest.php`

##### 2. **Ajustement système de réputation** 🔧
**Problème**: Actuellement vote question = +10 (comme réponse)
**Solution**: Vote question = +5, Vote réponse = +10

**Fichier à modifier**: `app/Observers/VoteObserver.php`
```php
// Ligne 45-50 environ
// Distinguer Question vs Answer
if ($votable instanceof Question) {
    $reputationChange = $value > 0 ? 5 : -2;  // Question: +5/-2
} else {
    $reputationChange = $value > 0 ? 10 : -2; // Answer: +10/-2
}
```

##### 3. **Pénalité vote négatif** 🔧
**Ajout**: Celui qui vote négativement perd -1 point
**Fichier**: `app/Observers/VoteObserver.php`
```php
// Ajouter après la mise à jour de réputation de l'auteur
if ($value < 0) {
    // Pénalité pour celui qui vote négativement
    $voter = User::find($vote->user_id);
    if ($voter) {
        $voter->decrement('reputation', 1);
    }
}
```

---

### 👩‍💻 **COLLABORATEUR 2** - Frontend & Fonctionnalités
**Durée estimée**: 2-3 jours

#### 🟡 PRIORITÉ MOYENNE (Amélioration UX)

##### 1. **SearchController dédié** 🔍
**Objectif**: Séparer la logique de recherche du QuestionController

**Fichiers à créer**:
```bash
php artisan make:controller SearchController
```

**Méthodes à implémenter**:
- `index()` - Recherche globale
- `questions()` - Recherche dans questions
- `users()` - Recherche d'utilisateurs
- `tags()` - Recherche de tags

**Route à ajouter**:
```php
Route::get('/search', [SearchController::class, 'index'])->name('search');
```

##### 2. **Système de notifications** 🔔
**Fonctionnalités**:
- Notification quand réponse acceptée (+20 réputation)
- Notification quand question/réponse votée
- Notification quand nouvelle réponse sur question suivie

**Fichiers à créer**:
```bash
php artisan make:notification AnswerAccepted
php artisan make:notification VoteReceived
php artisan make:notification NewAnswerOnFollowedQuestion
```

**Migration**:
```bash
php artisan notifications:table
php artisan migrate
```

##### 3. **Amélioration interface tags** 🏷️
**Page**: `resources/views/tags/index.blade.php`

**Améliorations**:
- Ajout d'icônes pour chaque tag
- Graphique de popularité (barres)
- Filtre par catégorie (Frontend, Backend, Database, etc.)
- Tri par activité récente

##### 4. **Page utilisateurs** 👥
**Créer**: `resources/views/users/index.blade.php`

**Fonctionnalités**:
- Liste tous les utilisateurs
- Tri par réputation, date d'inscription, activité
- Recherche par nom
- Cartes utilisateur avec avatar, réputation, badges

**Route existante**: `/users` (déjà définie)

---

## 🟢 PRIORITÉ BASSE (Nice to have)

### **COLLABORATEUR 1** - Fonctionnalités avancées

##### 5. **Modération avancée** 🛡️
- Système de signalement (flag) des questions/réponses
- Historique des actions de modération
- Queue de modération

##### 6. **API REST** 🌐
- Endpoints pour mobile app
- Authentication JWT
- CRUD questions/answers via API

### **COLLABORATEUR 2** - Analytics & Stats

##### 7. **Statistiques avancées** 📊
- Graphiques d'évolution de réputation
- Statistiques par période (jour/semaine/mois)
- Dashboard analytics pour modérateurs

##### 8. **Gamification** 🎮
- Système de badges avancé
- Niveaux d'utilisateur
- Leaderboard mensuel

---

## 📋 CHECKLIST DE VALIDATION

### **COLLABORATEUR 1** - Backend
- [ ] Tests passent tous (`php artisan test`)
- [ ] Réputation question = +5 (au lieu de +10)
- [ ] Pénalité vote négatif = -1 pour voteur
- [ ] Coverage tests > 80%

### **COLLABORATEUR 2** - Frontend
- [ ] SearchController fonctionnel
- [ ] Notifications basiques implémentées
- [ ] Page tags améliorée
- [ ] Page utilisateurs créée

---

## 🚀 COMMANDES UTILES

### Tests
```bash
# Lancer tous les tests
php artisan test

# Test avec coverage
php artisan test --coverage

# Test spécifique
php artisan test --filter QuestionTest
```

### Base de données
```bash
# Reset complet pour tests
php artisan migrate:fresh --seed

# Vérifier données
php artisan tinker
User::all(['name', 'reputation']);
```

### Serveur
```bash
# Lancer serveur
php artisan serve

# Vider cache
php artisan optimize:clear
```

---

## 📁 STRUCTURE DES FICHIERS

### **COLLABORATEUR 1** touchera:
```
tests/
├── Feature/
│   ├── AuthenticationTest.php     ← Créer
│   ├── QuestionTest.php          ← Créer
│   ├── VoteTest.php              ← Créer
│   └── ReputationTest.php        ← Créer
app/
├── Observers/
│   └── VoteObserver.php          ← Modifier
└── Http/Controllers/
    └── SearchController.php      ← Créer
```

### **COLLABORATEUR 2** touchera:
```
resources/views/
├── tags/
│   └── index.blade.php           ← Améliorer
├── users/
│   ├── index.blade.php           ← Créer
│   └── show.blade.php            ← Améliorer
└── notifications/
    └── index.blade.php           ← Créer
app/
├── Notifications/                ← Créer dossier
│   ├── AnswerAccepted.php
│   ├── VoteReceived.php
│   └── NewAnswerOnFollowed.php
└── Http/Controllers/
    ├── SearchController.php      ← Créer
    └── NotificationController.php ← Créer
```

---

## ⏰ PLANNING SUGGÉRÉ

### **Jour 1**
- **Collaborateur 1**: Tests authentification + CRUD questions
- **Collaborateur 2**: SearchController + amélioration tags

### **Jour 2**
- **Collaborateur 1**: Tests votes + réputation + ajustements
- **Collaborateur 2**: Système notifications + page utilisateurs

### **Jour 3**
- **Collaborateur 1**: Tests policies + modération avancée
- **Collaborateur 2**: Finitions interface + gamification

---

## 🐛 BUGS CONNUS À CORRIGER

1. **Import manquant** ✅ CORRIGÉ
   - `BelongsToMany` dans User.php

2. **Réputation incorrecte** ⚠️ À CORRIGER
   - Vote question donne +10 au lieu de +5

3. **Pas de pénalité vote négatif** ⚠️ À CORRIGER
   - Voteur négatif devrait perdre -1 point

---

## 📞 CONTACT & SUPPORT

**En cas de problème**:
1. Vérifier `AUDIT_COMPLET.md` pour contexte
2. Utiliser `SCENARIOS_TEST.md` pour tester
3. Consulter les routes: `php artisan route:list`
4. Vérifier la DB: `php artisan tinker`

**Fichiers de référence**:
- `AUDIT_COMPLET.md` - État complet du projet
- `SCENARIOS_TEST.md` - 41 tests manuels
- `routes/web.php` - Toutes les routes
- `app/Models/` - Modèles avec relations

---

## ✅ OBJECTIF FINAL

**À la fin des 3 jours**:
- ✅ Tests automatisés complets (80%+ coverage)
- ✅ Système de réputation correct
- ✅ SearchController dédié
- ✅ Notifications basiques
- ✅ Interface tags/users améliorée
- 🚀 **Projet prêt pour production !**

**Score cible**: 95% de fonctionnalités complètes