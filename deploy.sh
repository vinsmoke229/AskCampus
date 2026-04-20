#!/bin/bash

echo "🚀 Déploiement AskCampus sur Railway"
echo "=================================="

# 1. Vérifier que tout est commité
if [[ -n $(git status --porcelain) ]]; then
    echo "❌ Il y a des changements non commités. Commitez d'abord :"
    git status --short
    exit 1
fi

# 2. Optimiser pour la production
echo "📦 Optimisation pour la production..."
composer install --no-dev --optimize-autoloader --no-interaction
npm ci --production
npm run build

# 3. Créer le commit de déploiement
echo "📝 Création du commit de déploiement..."
git add .
git commit -m "deploy: optimisation pour production Railway" || echo "Rien à commiter"

# 4. Pousser vers Railway
echo "🚀 Déploiement vers Railway..."
git push origin main

echo ""
echo "✅ Déploiement terminé !"
echo "🌐 Votre app sera disponible sur : https://your-app-name.up.railway.app"
echo ""
echo "📋 Prochaines étapes :"
echo "1. Aller sur railway.app"
echo "2. Connecter votre repo GitHub"
echo "3. Ajouter une base MySQL"
echo "4. Configurer les variables d'environnement"
echo "5. Lancer le déploiement"