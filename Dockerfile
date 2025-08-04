# Etapa 1: Build de Composer + NPM
FROM php:8.2-fpm as build

# Instala dependencias del sistema
RUN apt-get update && apt-get install -y \
    git curl zip unzip libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

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

# Permisos para Laravel
RUN chmod -R 775 storage bootstrap/cache

# Etapa 2: Producción
FROM php:8.2-fpm

# Instala extensiones necesarias
RUN apt-get update && apt-get install -y \
    libpng-dev libonig-dev libxml2-dev libzip-dev libpq-dev \
    && docker-php-ext-install pdo pdo_mysql zip

# Copia desde el build anterior
COPY --from=build /var/www /var/www

# Establece directorio de trabajo
WORKDIR /var/www

# Exponer el puerto que usará Artisan Serve (opcional)
EXPOSE 9000

# Comando de inicio
CMD ["php", "artisan", "serve", "--host=0.0.0.0", "--port=9000"]
