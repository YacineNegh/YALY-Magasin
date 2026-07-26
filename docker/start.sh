set -e

# Default port for Render
export PORT=${PORT:-10000}

# Substitute port in Nginx config if the template exists
if [ -f /etc/nginx/http.d/default.conf.template ]; then
    envsubst '${PORT}' < /etc/nginx/http.d/default.conf.template > /etc/nginx/http.d/default.conf
fi

# The Dockerfile sets the working directory to /var/www/html
cd /var/www/html

echo "Starting deployment setup..."

# Ensure .env exists – copy from example if missing
if [ ! -f .env ]; then
    echo "No .env found, copying from .env.example..."
    cp .env.example .env
fi

# Override critical settings for production
sed -i 's/APP_ENV=local/APP_ENV=production/' .env
sed -i 's/APP_DEBUG=true/APP_DEBUG=false/' .env

# Generate APP_KEY if not set
if ! grep -q 'APP_KEY=base64' .env; then
    echo "Generating APP_KEY..."
    php artisan key:generate --force
fi

# Run package discovery (important since we skip scripts during build)
php artisan package:discover --ansi

# Setup the database and seed it on every boot
echo "Setting up SQLite database..."
touch database/database.sqlite
php artisan migrate:fresh --force --seed || php artisan migrate --force

# Cache configuration for production performance
echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

echo "Starting Supervisor..."
exec supervisord -c /etc/supervisord.conf