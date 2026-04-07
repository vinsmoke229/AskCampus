# 🎓 AskCampus

<div align="center">

![Laravel](https://img.shields.io/badge/Laravel-12.x-FF2D20?style=for-the-badge&logo=laravel&logoColor=white)
![PHP](https://img.shields.io/badge/PHP-8.2+-777BB4?style=for-the-badge&logo=php&logoColor=white)
![Tailwind CSS](https://img.shields.io/badge/Tailwind_CSS-3.x-38B2AC?style=for-the-badge&logo=tailwind-css&logoColor=white)
![MySQL](https://img.shields.io/badge/MySQL-8.0-4479A1?style=for-the-badge&logo=mysql&logoColor=white)

**Une plateforme d'entraide académique moderne pour les étudiants**

[Fonctionnalités](#-fonctionnalités-clés) • [Installation](#-installation) • [Stack Technique](#-stack-technique) • [Modèle de données](#-modèle-de-données) • [Équipe](#-équipe)

</div>

---

## 📖 Présentation du projet

**AskCampus** est une plateforme collaborative d'entraide académique conçue pour faciliter l'apprentissage et le partage de connaissances entre étudiants. Inspirée de StackOverflow, cette application offre un environnement structuré où les étudiants peuvent poser des questions, partager leurs connaissances et construire leur réputation académique.

### 🎯 Objectifs

- Créer une communauté d'entraide entre étudiants
- Faciliter la résolution de problèmes académiques
- Encourager le partage de connaissances via un système de réputation
- Organiser les questions par domaines d'études (tags)

### 👥 Public cible

- **Étudiants** : Posent des questions, répondent et gagnent en réputation
- **Modérateurs** : Supervisent le contenu et maintiennent la qualité des échanges
- **Enseignants** : Peuvent suivre les difficultés récurrentes des étudiants

---

## ✨ Fonctionnalités clés

### 🔐 Système d'authentification
- Inscription et connexion sécurisées
- Gestion de profil utilisateur
- Système de réputation dynamique

### 📝 Gestion des questions
- **Création de questions** avec titre, description détaillée et tags
- **Recherche avancée** par mots-clés (titre et contenu)
- **Filtrage par tags** pour une navigation ciblée
- **Compteur de vues** pour mesurer l'intérêt
- **Statut de résolution** (résolu/non résolu)

### 💬 Système de réponses
- Réponses multiples par question
- **Acceptation de réponse** par l'auteur de la question
- Tri intelligent : réponses acceptées en premier, puis par score de votes
- Mise en évidence visuelle des réponses acceptées

### 🗳️ Système de votes polymorphe
- Vote positif (+1) ou négatif (-1) sur questions et réponses
- **Système de toggle** : re-voter annule le vote
- Impact direct sur la réputation de l'auteur
- Prévention des votes multiples (contrainte unique)

### 🏆 Système de réputation
- **+10 points** par vote positif reçu
- **-10 points** par vote négatif reçu
- **+20 points** pour une réponse acceptée
- Barre de progression vers le prochain niveau
- Badges et réalisations débloquables

### 🏷️ Système de tags
- Catégorisation des questions par domaine
- Tags avec slug unique pour URLs propres
- Badges colorés pour une identification rapide
- Filtrage des questions par tag

### 📊 Dashboard étudiant
- Vue d'ensemble de l'activité (questions, réponses, acceptations)
- Score de réputation avec progression visuelle
- Historique des questions récentes
- Badges et réalisations

### 🎨 Interface utilisateur moderne
- Design épuré inspiré de StackOverflow
- Interface responsive (mobile-first)
- Composants réutilisables avec Tailwind CSS
- Expérience utilisateur optimisée

---

## 🛠️ Stack Technique

### Backend
- **Framework** : Laravel 12.x
- **Langage** : PHP 8.2+
- **Base de données** : MySQL 8.0
- **ORM** : Eloquent
- **Authentification** : Laravel Breeze

### Frontend
- **CSS Framework** : Tailwind CSS 3.x
- **Build Tool** : Vite
- **JavaScript** : Alpine.js (pour les interactions)
- **Template Engine** : Blade

### Outils de développement
- **Gestionnaire de dépendances** : Composer & NPM
- **Version Control** : Git
- **Environnement** : Laravel Sail (Docker) ou WAMP/XAMPP

---

## 🚀 Installation

### Prérequis

Assurez-vous d'avoir installé sur votre machine :

- PHP >= 8.2
- Composer
- Node.js >= 18.x & NPM
- MySQL >= 8.0
- Git

### Étapes d'installation

#### 1️⃣ Cloner le repository

```bash
git clone https://github.com/votre-username/askcampus.git
cd askcampus
```

#### 2️⃣ Installer les dépendances PHP

```bash
composer install
```

#### 3️⃣ Configurer l'environnement

Copiez le fichier d'exemple et configurez vos variables d'environnement :

```bash
cp .env.example .env
```

Éditez le fichier `.env` et configurez votre base de données :

```env
DB_CONNECTION=mysql
DB_HOST=127.0.0.1
DB_PORT=3306
DB_DATABASE=askcampus
DB_USERNAME=root
DB_PASSWORD=votre_mot_de_passe
```

#### 4️⃣ Générer la clé d'application

```bash
php artisan key:generate
```

#### 5️⃣ Créer la base de données

Créez une base de données MySQL nommée `askcampus` :

```sql
CREATE DATABASE askcampus CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci;
```

#### 6️⃣ Exécuter les migrations

```bash
php artisan migrate
```

#### 7️⃣ (Optionnel) Peupler la base de données

```bash
php artisan db:seed
```

#### 8️⃣ Installer les dépendances frontend

```bash
npm install
```

#### 9️⃣ Compiler les assets

Pour le développement :

```bash
npm run dev
```

Pour la production :

```bash
npm run build
```

#### 🔟 Lancer le serveur de développement

```bash
php artisan serve
```

L'application sera accessible à l'adresse : **http://localhost:8000**

---

## 🗄️ Modèle de données

### Architecture de la base de données

Le projet utilise une architecture relationnelle avec des relations polymorphes pour optimiser la flexibilité du système de votes.

#### Tables principales

- **users** : Utilisateurs avec système de réputation
- **questions** : Questions posées par les étudiants
- **answers** : Réponses aux questions
- **tags** : Catégories pour organiser les questions
- **votes** : Système de votes polymorphe
- **question_tag** : Table pivot pour la relation many-to-many

### 🔗 Relations Eloquent

```
User
├── hasMany → Questions
├── hasMany → Answers
└── hasMany → Votes

Question
├── belongsTo → User
├── hasMany → Answers
├── belongsToMany → Tags
└── morphMany → Votes

Answer
├── belongsTo → Question
├── belongsTo → User
└── morphMany → Votes

Tag
└── belongsToMany → Questions

Vote
├── belongsTo → User
└── morphTo → Votable (Question ou Answer)
```

### 🎯 Relation polymorphe des votes

Le système de votes utilise une **relation polymorphe** pour permettre de voter sur différents types de contenu (questions et réponses) avec une seule table.

#### Structure de la table `votes`

```php
Schema::create('votes', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->unsignedBigInteger('votable_id');    // ID de l'entité votée
    $table->string('votable_type');              // Type: Question ou Answer
    $table->tinyInteger('value');                // 1 (upvote) ou -1 (downvote)
    $table->timestamps();
    
    // Contrainte unique pour empêcher les votes doubles
    $table->unique(['user_id', 'votable_id', 'votable_type']);
});
```

#### Avantages de cette approche

✅ **Flexibilité** : Un seul système pour voter sur plusieurs types d'entités  
✅ **Maintenabilité** : Code DRY (Don't Repeat Yourself)  
✅ **Évolutivité** : Facile d'ajouter de nouveaux types votables (commentaires, etc.)  
✅ **Performance** : Index unique pour éviter les doublons et optimiser les requêtes  

#### Utilisation dans le code

```php
// Voter sur une question
$question->votes()->create([
    'user_id' => auth()->id(),
    'value' => 1
]);

// Voter sur une réponse
$answer->votes()->create([
    'user_id' => auth()->id(),
    'value' => -1
]);

// Récupérer le score total
$score = $question->votes->sum('value');
```

### 📊 Système de réputation automatique

Le système utilise des **Observers** pour mettre à jour automatiquement la réputation :

- **VoteObserver** : Gère les points lors de la création/modification/suppression de votes
- **AnswerObserver** : Ajoute +20 points lors de l'acceptation d'une réponse

---

## 📸 Captures d'écran

### Page d'accueil
> Liste des questions avec filtres et recherche

### Page de question
> Question détaillée avec réponses et système de votes

### Dashboard étudiant
> Statistiques personnelles et progression de réputation

---

## 🧪 Tests

Pour exécuter les tests :

```bash
php artisan test
```

---

## 📝 Roadmap

- [ ] Système de commentaires sur les réponses
- [ ] Notifications en temps réel
- [ ] Messagerie privée entre étudiants
- [ ] API RESTful pour application mobile
- [ ] Système de modération avancé
- [ ] Gamification avec niveaux et badges
- [ ] Export de questions en PDF
- [ ] Intégration d'éditeur Markdown

---

## 👨‍💻 Équipe

<table>
  <tr>
    <td align="center">
      <img src="https://via.placeholder.com/100" width="100px;" alt=""/><br />
      <sub><b>[Nom Membre 1]</b></sub><br />
      <sub>Lead Developer</sub>
    </td>
    <td align="center">
      <img src="https://via.placeholder.com/100" width="100px;" alt=""/><br />
      <sub><b>[Nom Membre 2]</b></sub><br />
      <sub>Backend Developer</sub>
    </td>
    <td align="center">
      <img src="https://via.placeholder.com/100" width="100px;" alt=""/><br />
      <sub><b>[Nom Membre 3]</b></sub><br />
      <sub>Frontend Developer</sub>
    </td>
    <td align="center">
      <img src="https://via.placeholder.com/100" width="100px;" alt=""/><br />
      <sub><b>[Nom Membre 4]</b></sub><br />
      <sub>UI/UX Designer</sub>
    </td>
  </tr>
</table>

---

## 📄 Licence

Ce projet est sous licence MIT. Voir le fichier [LICENSE](LICENSE) pour plus de détails.

---

## 🤝 Contribution

Les contributions sont les bienvenues ! Pour contribuer :

1. Forkez le projet
2. Créez une branche pour votre fonctionnalité (`git checkout -b feature/AmazingFeature`)
3. Committez vos changements (`git commit -m 'Add some AmazingFeature'`)
4. Poussez vers la branche (`git push origin feature/AmazingFeature`)
5. Ouvrez une Pull Request

---

## 📧 Contact

Pour toute question ou suggestion, n'hésitez pas à nous contacter :

- **Email** : contact@askcampus.com
- **GitHub** : [github.com/askcampus](https://github.com/askcampus)

---

<div align="center">

**Fait avec ❤️ par l'équipe AskCampus**

⭐ N'oubliez pas de mettre une étoile si ce projet vous plaît !

</div>
