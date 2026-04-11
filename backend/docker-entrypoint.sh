#!/bin/bash

# Generate APP_KEY if not set
if [ -z "$APP_KEY" ] || [ "$APP_KEY" = "base64:change_this_to_generated_key" ]; then
  echo "Generating APP_KEY..."
  php artisan key:generate --force
fi

# Run migrations with retries built-in
echo "Attempting migrations..."
php artisan migrate --force

# Clear caches
php artisan config:clear
php artisan cache:clear
php artisan view:clear

# Start PHP-FPM
php artisan serve --host=0.0.0.0 --port=8000
