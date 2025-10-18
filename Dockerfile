# --- ETAPA 1: BUILDER (Compilar assets) ---
# Esta etapa no cambia, está bien como la tenías
FROM node:18-alpine as builder
WORKDIR /app
COPY package.json package-lock.json ./
RUN npm ci
COPY . .
RUN npm run build

# --- ETAPA 2: PRODUCCIÓN FINAL ---
FROM php:8.2-apache

# ... (todas tus instalaciones de PHP, Composer, etc. van aquí) ...
RUN apt-get update && apt-get install -y \
        git unzip libpng-dev libjpeg-dev libzip-dev \
    && docker-php-ext-install pdo_mysql opcache bcmath gd \
    && rm -rf /var/lib/apt/lists/*
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

WORKDIR /var/www/html

# ¡¡AQUÍ ESTÁ EL CAMBIO IMPORTANTE!!
# 1. Copia PRIMERO solo lo necesario para instalar dependencias de PHP
COPY database/ composer.json composer.lock ./
COPY database/ ./database/
RUN composer install --no-dev --optimize-autoloader

# 2. AHORA copia el resto de tu aplicación
COPY . .

# 3. Y FINALMENTE, copia los assets compilados desde la etapa 'builder'.
#    Esto sobreescribe la carpeta 'public/build' local (que está vacía)
#    con la carpeta que contiene el manifest.json.
COPY --from=builder /app/public/build /var/www/html/public/build

# ... (El resto de tu Dockerfile: permisos, Apache, entrypoint, etc.) ...
RUN chown -R www-data:www-data storage bootstrap/cache public/build \
    && chmod -R 775 storage bootstrap/cache public/build

COPY apache-conf.conf /etc/apache2/sites-available/000-default.conf
RUN a2enmod rewrite && a2ensite 000-default.conf

EXPOSE 80
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh
CMD ["/usr/local/bin/entrypoint.sh"]