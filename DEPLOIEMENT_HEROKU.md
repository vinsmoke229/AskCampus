# 🚀 Déploiement AskCampus sur Heroku

## 🌟 **Pourquoi Heroku ?**
- ✅ **Gratuit** : 550h/mois (avec carte)
- ✅ **Add-ons** : ClearDB MySQL gratuit
- ✅ **CLI puissante** : Heroku CLI
- ⚠️ **Sleep** : 30min d'inactivité

## 📋 **Étapes Heroku**

### 1. **Installation Heroku CLI**
```bash
# Windows
winget install Heroku.CLI

# Ou télécharger : https://devcenter.heroku.com/articles/heroku-cli
```

### 2. **Créer l'App**
```bash
heroku login
heroku create askcampus-votrenom
```

### 3. **Ajouter MySQL**
```bash
heroku addons:create cleardb:ignite
heroku config:get CLEARDB_DATABASE_URL
```

### 4. **Configurer Variables**
```bash
heroku config:set APP_NAME=AskCampus
heroku config:set APP_ENV=production
heroku config:set APP_DEBUG=false
heroku config:set APP_KEY=base64:9Rd6AgGejOwMoQi+L7eHm08zdkutcQZkySVkjuMMDks=
```

### 5. **Déployer**
```bash
git push heroku main
heroku run php artisan migrate:fresh --seed
```

## 🌐 **URL**
`https://askcampus-votrenom.herokuapp.com`