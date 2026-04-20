# 🚀 Déploiement AskCampus sur Render

## 🌟 **Pourquoi Render ?**
- ✅ **Gratuit** : Apps web + PostgreSQL
- ✅ **Pas de sleep** : Toujours en ligne
- ✅ **SSL automatique** : HTTPS inclus
- ✅ **Builds rapides** : Optimisé pour Laravel

## 📋 **Étapes Render**

### 1. **Créer le Service Web**
1. Aller sur [render.com](https://render.com)
2. **"New +"** → **"Web Service"**
3. Connecter votre repo GitHub AskCampus
4. Configurer :
   - **Name :** `askcampus`
   - **Environment :** `Docker`
   - **Build Command :** `composer install --no-dev && npm run build`
   - **Start Command :** `php artisan serve --host=0.0.0.0 --port=$PORT`

### 2. **Ajouter PostgreSQL**
1. **"New +"** → **"PostgreSQL"**
2. **Name :** `askcampus-db`
3. Copier l'URL de connexion

### 3. **Variables d'Environnement**
```env
APP_NAME=AskCampus
APP_ENV=production
APP_DEBUG=false
APP_URL=https://askcampus.onrender.com

DATABASE_URL=postgresql://user:pass@host:port/db
DB_CONNECTION=pgsql

SESSION_DRIVER=database
CACHE_STORE=database
```

### 4. **Déployer**
- Push vers GitHub = déploiement automatique
- Render build et déploie automatiquement
- URL : `https://askcampus.onrender.com`

## ⚡ **Avantages Render**
- Pas de limite de temps (pas de sleep)
- SSL automatique
- Logs détaillés
- Rollback facile