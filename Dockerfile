# syntax=docker/dockerfile:1
#
# Production image for Coolify.
#
# Three stages so the final image carries neither Composer nor Node:
#   1. vendor  - PHP dependencies, no dev packages
#   2. assets  - Vite build (public/build is gitignored, so it MUST be built here)
#   3. runtime - FrankenPHP serving public/ over HTTP
#
# Build locally with:  docker build -t luka-portfolio .
# Run locally with:    docker run --rm -p 8011:80 --env-file .env.docker luka-portfolio

# ---------------------------------------------------------------- 1. vendor
FROM composer:2 AS vendor

WORKDIR /app

COPY composer.json composer.lock ./
# Enough of the app for an optimised autoloader (PSR-4 over app/, classmap
# over database/). Scripts are skipped: artisan needs env we do not have yet.
COPY app ./app
COPY bootstrap ./bootstrap
COPY config ./config
COPY database ./database
COPY routes ./routes

RUN composer install \
        --no-dev \
        --optimize-autoloader \
        --no-interaction \
        --no-progress \
        --no-scripts

# ---------------------------------------------------------------- 2. assets
FROM node:22-alpine AS assets

WORKDIR /app

COPY package.json package-lock.json ./
RUN npm ci --no-audit --no-fund

COPY vite.config.js postcss.config.js ./
COPY resources ./resources
COPY public ./public

# app.css names its @source paths explicitly, so only resources/ is needed -
# no vendor, and no dependence on .gitignore for source detection.
RUN npm run build

# --------------------------------------------------------------- 3. runtime
FROM dunglas/frankenphp:1-php8.4-alpine AS runtime

# opcache for throughput; mbstring/zip/intl are what Laravel expects present.
RUN install-php-extensions opcache mbstring zip intl \
    && apk add --no-cache curl

# Production PHP settings: opcache tuned for a codebase that never changes
# between deploys, and the PHP version kept out of the response headers.
COPY docker/php.ini /usr/local/etc/php/conf.d/zz-app.ini

WORKDIR /app

COPY . .
COPY --from=vendor /app/vendor ./vendor
COPY --from=assets /app/public/build ./public/build

# Caches are written at boot (see entrypoint), not baked in, because Coolify
# injects the environment at runtime.
RUN mkdir -p storage/framework/{cache/data,sessions,views} storage/logs bootstrap/cache \
    && chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

COPY docker/entrypoint.sh /usr/local/bin/entrypoint
RUN chmod +x /usr/local/bin/entrypoint

# FrankenPHP's bundled Caddyfile serves /app/public. Binding to :80 keeps
# Coolify's reverse proxy configuration trivial.
ENV SERVER_NAME=:80
EXPOSE 80

HEALTHCHECK --interval=30s --timeout=5s --start-period=20s --retries=3 \
    CMD curl -fsS http://127.0.0.1/ >/dev/null || exit 1

ENTRYPOINT ["entrypoint"]
CMD ["frankenphp", "run", "--config", "/etc/caddy/Caddyfile"]
