#!/bin/bash

echo "🔍 DEBUG: PORT variable = $PORT"
echo "🔍 DEBUG: All environment variables with PORT:"
env | grep -i port || echo "No PORT variables found"

# Migrations et seeding
php artisan migrate:fresh --force
php artisan db:seed --force

# Utiliser le port Railway ou 8080 par défaut
FINAL_PORT=${PORT:-8080}
echo "🚀 Starting server on port: $FINAL_PORT"

# Démarrer le serveur
php artisan serve --host=0.0.0.0 --port=$FINAL_PORT