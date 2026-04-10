#!/bin/bash

# Configuration
REMOTE_PATH=$1

echo "🚀 Starting post-deployment script in $REMOTE_PATH..."

cd $REMOTE_PATH

# Update environment if needed (manual step)
# cp .env.example .env

# Run Laravel tasks
echo "📦 Running migrations..."
php artisan migrate --force

echo "🧹 Clearing and optimizing cache..."
php artisan optimize:clear
php artisan optimize

echo "🔗 Ensuring storage link..."
php artisan storage:link || echo "Storage link already exists."

# Set permissions
echo "🔐 Setting folder permissions..."
chmod -R 775 storage bootstrap/cache

echo "✅ Deployment finished successfully!"
