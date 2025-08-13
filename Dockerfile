# Etapa 1: Build de Composer + NPM
FROM php:8.2-fpm as build

# Instala dependencias del sistema (incluye SQLite)
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Instala Node.js y NPM (para Vite)
RUN curl -fsSL https://deb.nodesource.com/setup_18.x | bash - && \
    apt-get install -y nodejs

# Copia archivos del proyecto
WORKDIR /var/www
COPY . .

# Instala dependencias de Laravel
RUN composer install --no-interaction --prefer-dist --optimize-autoloader \
    && npm install && npm run build

# Crear archivo SQLite vacío y dar permisos
RUN mkdir -p database && touch database/database.sqlite && chmod 664 database/database.sqlite

# Permisos para Laravel
RUN chmod -R 775 storage bootstrap/cache

# Etapa 2: Producción
FROM php:8.2-fpm

# Instala extensiones necesarias (incluye SQLite)
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev sqlite3 libsqlite3-dev \
    && docker-php-ext-install pdo pdo_mysql pdo_sqlite zip

# Copia desde build
COPY --from=build /var/www /var/www

WORKDIR /var/www

# Crear script de entrada para inicializar SQLite y migraciones
RUN echo '#!/bin/sh\n\
mkdir -p database && touch database/database.sqlite && chmod -R 775 database\n\
php artisan config:clear\n\
php artisan cache:clear\n\
php artisan route:clear\n\
php artisan view:clear\n\
php artisan migrate --force\n\
exec "$@"' > /entrypoint.sh \
    && chmod +x /entrypoint.sh

EXPOSE 9000

ENTRYPOINT ["/entrypoint.sh"]
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
