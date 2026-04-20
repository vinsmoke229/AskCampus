#!/bin/bash

echo "🔍 DEBUG: PORT variable = $PORT"
echo "🔍 DEBUG: All environment variables with PORT:"
env | grep -i port || echo "No PORT variables found"

# Migrations et seeding
php artisan migrate:fresh --force
php artisan db:seed --force

# FORCER le port Railway
if [ -z "$PORT" ]; then
    FINAL_PORT=8080
else
    FINAL_PORT=$PORT
fi

echo "🚀 Starting server on port: $FINAL_PORT"

# Démarrer le serveur
exec php artisan serve --host=0.0.0.0 --port=$FINAL_PORT