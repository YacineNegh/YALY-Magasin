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