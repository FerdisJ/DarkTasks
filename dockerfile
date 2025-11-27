# -----------------------------
# STAGE 1: Build de Node (Assets)
# -----------------------------
FROM node:20-alpine AS node_builder

WORKDIR /app

# Copiamos package.json + lock
COPY package*.json ./

# Instalamos dependencias
RUN npm ci

# Copiamos todo el proyecto
COPY . .

# Compilamos assets de Vite
RUN npm run build


# -----------------------------
# STAGE 2: PHP Dependencies (Composer)
# -----------------------------
FROM composer:2 AS composer_builder

WORKDIR /app

# Copiamos todos los archivos + assets ya compilados
COPY --from=node_builder /app /app

# Instalamos dependencias de PHP sin dev (producción)
RUN composer install \
    --no-dev \
    --prefer-dist \
    --optimize-autoloader \
    --no-interaction


# -----------------------------
# STAGE 3: Final image (PHP-FPM + Extensions)
# -----------------------------
FROM php:8.2-fpm-alpine

# Instalar paquetes necesarios
RUN set -eux; \
    apk update; \
    apk add --no-cache \
        icu sqlite-libs git unzip oniguruma; \
    apk add --no-cache --virtual .build-deps \
        $PHPIZE_DEPS icu-dev sqlite-dev oniguruma-dev libzip-dev; \
    docker-php-ext-configure intl; \
    docker-php-ext-install -j"$(nproc)" pdo_sqlite bcmath intl mbstring; \
    docker-php-ext-enable opcache; \
    apk del .build-deps;

WORKDIR /var/www/html

# Copiamos la aplicación completa
COPY --from=composer_builder /app /var/www/html

# Crear .env si no existe y generar clave de Laravel
RUN if [ ! -f .env ]; then cp .env.example .env; fi && \
    php artisan key:generate && \
    php artisan config:cache && \
    php artisan route:cache && \
    php artisan view:cache

# IMPORTANTE:
# NO ejecutamos migraciones en la imagen
# Esto debe hacerse en runtime, no en build:
# php artisan migrate --force

# Ajustamos permisos
RUN chown -R www-data:www-data /var/www/html && \
    chmod -R 775 storage bootstrap/cache

# Usuario seguro
USER www-data

EXPOSE 9000

CMD ["php-fpm"]
