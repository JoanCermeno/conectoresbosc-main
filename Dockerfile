# Usa una imagen base de PHP oficial con Apache (o Nginx, si lo prefieres)
FROM php:8.2-apache

# Instala extensiones de PHP necesarias (ajusta según tus necesidades)
RUN docker-php-ext-install pdo_mysql opcache

# Instala las herramientas del sistema necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*


# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . .

# Instala las dependencias de Composer
RUN composer install --no-dev --optimize-autoloader

# Configura los permisos de almacenamiento y caché
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# Instala Node.js y npm (si tu aplicación usa Vite/Webpack)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

# Instala las dependencias de Node.js y compila los assets
RUN npm install \
    && npm run build

# Expone el puerto 80 para Apache
EXPOSE 80

# Comando para iniciar Apache (ya es el comando predeterminado para php:8.2-apache)
# CMD ["apache2-foreground"]