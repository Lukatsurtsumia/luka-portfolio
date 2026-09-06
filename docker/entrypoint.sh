#!/bin/sh
set -e

# Coolify injects the environment at container start, so the config and route
# caches are built here rather than at image build time - baking them into the
# image would freeze whatever values happened to exist on the build machine.

if [ -z "$APP_KEY" ]; then
    echo "FATAL: APP_KEY is not set. Generate one with 'php artisan key:generate --show'" >&2
    echo "       and add it to this application's environment variables in Coolify." >&2
    exit 1
fi

# storage/ may be a mounted volume that starts empty.
mkdir -p \
    storage/framework/cache/data \
    storage/framework/sessions \
    storage/framework/views \
    storage/logs

chown -R www-data:www-data storage bootstrap/cache 2>/dev/null || true

php artisan config:cache
php artisan route:cache
php artisan view:cache

exec "$@"
