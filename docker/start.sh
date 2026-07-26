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

# Cache configuration for production performance
echo "Caching Laravel configuration..."
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Start Supervisor (nginx + php-fpm) FIRST so Render detects the port
echo "Starting Supervisor in the background..."
supervisord -c /etc/supervisord.conf &
SUPERVISOR_PID=$!

# Give nginx a moment to bind the port
sleep 3

# NOW run migrations in the foreground (port is already open)
echo "Running database migrations and seeding..."
touch database/database.sqlite
php artisan migrate --force --seed

echo "Deployment complete! App is live."

# Wait for supervisor to keep the container running
wait $SUPERVISOR_PID