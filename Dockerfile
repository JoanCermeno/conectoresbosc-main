# --- ETAPA 1: BUILDER (Compila los assets de Vite) ---
# Se usa una imagen de Node para instalar dependencias y compilar.
# El resultado de esta etapa es solo la carpeta 'public/build'.
FROM node:18-alpine AS builder

# Define el directorio de trabajo
WORKDIR /app

# Copia los archivos de dependencias de Node
COPY package.json package-lock.json ./

# Instala TODAS las dependencias (incluyendo 'vite')
RUN npm ci

# Copia el resto de los archivos de tu aplicación
COPY . .

# Ejecuta el build de Vite para generar los archivos compilados
RUN npm run build


# --- ETAPA 2: PRODUCCIÓN FINAL ---
# Se usa una imagen limpia de PHP con Apache para el despliegue final.
# Esta imagen será más ligera porque no contiene Node.js.
FROM php:8.2-apache

# Instala las dependencias del sistema y las extensiones de PHP necesarias
RUN apt-get update && apt-get install -y \
        git \
        unzip \
        libpng-dev \
        libjpeg-dev \
        libzip-dev \
    && docker-php-ext-install pdo_mysql opcache bcmath gd \
    && rm -rf /var/lib/apt/lists/*

# Instala Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo de Apache
WORKDIR /var/www/html

# Copia TODOS los archivos de tu aplicación Laravel.
# Esto se hace ANTES de 'composer install' para que encuentre el archivo 'artisan'.
COPY --chown=www-data:www-data . .

# Instala las dependencias de PHP para producción.
RUN composer install --no-dev --optimize-autoloader

# ¡MAGIA! Copia solo los assets compilados desde la etapa 'builder' a la imagen final.
COPY --from=builder /app/public/build /var/www/html/public/build

# Configura los permisos correctos para Laravel y los assets.
RUN chown -R www-data:www-data storage bootstrap/cache public/build \
    && chmod -R 775 storage bootstrap/cache public/build

# Copia tu configuración personalizada de Apache
COPY apache-conf.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo 'rewrite' de Apache para las rutas de Laravel
RUN a2enmod rewrite && a2ensite 000-default.conf

# Expone el puerto 80 para que el servidor web sea accesible
EXPOSE 80

# Copia y da permisos de ejecución a tu script de entrada
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Define el script de entrada como el comando de inicio del contenedor
CMD ["/usr/local/bin/entrypoint.sh"]