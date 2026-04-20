# 🚀 Déploiement AskCampus sur Railway

## 📋 Prérequis
- ✅ Compte GitHub avec votre code AskCampus
- ✅ Compte Railway (gratuit) : [railway.app](https://railway.app)

## 🎯 Étapes de Déploiement

### 1. **Créer le Projet Railway**
1. Aller sur [railway.app](https://railway.app)
2. Cliquer **"Start a New Project"**
3. Choisir **"Deploy from GitHub repo"**
4. Sélectionner votre repo **AskCampus**

### 2. **Ajouter Base de Données MySQL**
1. Dans votre projet Railway, cliquer **"+ New"**
2. Choisir **"Database"** → **"Add MySQL"**
3. Railway va créer automatiquement :
   - `MYSQLHOST`
   - `MYSQLPORT` 
   - `MYSQLDATABASE`
   - `MYSQLUSER`
   - `MYSQLPASSWORD`

### 3. **Configurer Variables d'Environnement**
Dans l'onglet **"Variables"** de votre service web, ajouter :

```env
APP_NAME=AskCampus
APP_ENV=production
APP_KEY=base64:9Rd6AgGejOwMoQi+L7eHm08zdkutcQZkySVkjuMMDks=
APP_DEBUG=false
APP_URL=https://your-app-name.up.railway.app

DB_CONNECTION=mysql
DB_HOST=${{MySQL.MYSQLHOST}}
DB_PORT=${{MySQL.MYSQLPORT}}
DB_DATABASE=${{MySQL.MYSQLDATABASE}}
DB_USERNAME=${{MySQL.MYSQLUSER}}
DB_PASSWORD=${{MySQL.MYSQLPASSWORD}}

SESSION_DRIVER=database
CACHE_STORE=database
QUEUE_CONNECTION=database

MAIL_MAILER=log
MAIL_FROM_ADDRESS=noreply@askcampus.app
MAIL_FROM_NAME=AskCampus
```

### 4. **Déployer**
1. Railway détecte automatiquement Laravel
2. Le build se lance automatiquement
3. Les migrations s'exécutent via `nixpacks.toml`
4. Votre app est en ligne ! 🎉

### 5. **Peupler la Base de Données**
Une fois déployé, dans le terminal Railway :
```bash
php artisan migrate:fresh --seed
```

## 🌐 **URL de votre App**
Votre AskCampus sera accessible sur :
`https://your-app-name.up.railway.app`

## 🔧 **Commandes Utiles**

### Redéployer après changements :
```bash
git add .
git commit -m "update: nouvelles fonctionnalités"
git push origin main
```

### Accéder au terminal Railway :
1. Aller dans votre projet Railway
2. Onglet **"Deployments"**
3. Cliquer sur le dernier déploiement
4. **"View Logs"** ou **"Connect"**

### Réinitialiser la base :
```bash
php artisan migrate:fresh --seed
```

## 💡 **Conseils**

### Performance
- ✅ Cache activé automatiquement
- ✅ Optimisation Composer
- ✅ Assets compilés

### Sécurité
- ✅ HTTPS automatique
- ✅ Variables d'environnement sécurisées
- ✅ APP_DEBUG=false en production

### Monitoring
- 📊 Logs en temps réel dans Railway
- 📈 Métriques de performance
- 🔔 Alertes de déploiement

## 🆘 **Dépannage**

### Erreur 500 ?
1. Vérifier les logs Railway
2. Vérifier `APP_KEY` configurée
3. Vérifier connexion base de données

### Base vide ?
```bash
php artisan migrate:fresh --seed
```

### Assets manquants ?
```bash
npm run build
git add public/build
git commit -m "fix: assets build"
git push
```

## 🎉 **Félicitations !**

Votre AskCampus est maintenant en ligne et accessible au monde entier !

**Partagez votre URL :**
- 👨‍🎓 Avec vos camarades étudiants
- 👨‍🏫 Avec vos professeurs
- 💼 Dans votre portfolio
- 📱 Sur vos réseaux sociaux

---

**Coût :** 0€ avec Railway gratuit (500h/mois)
**Temps de déploiement :** 5-10 minutes
**Maintenance :** Automatique