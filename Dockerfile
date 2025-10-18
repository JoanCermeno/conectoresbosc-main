# --- IMAGEN ÚNICA: PHP, Apache y Node.js ---
FROM php:8.2-apache

# Establecer variables de entorno para la configuración de Node.js
ENV NODE_VERSION 18.x

# 1. Instalar dependencias de PHP y del sistema (incluyendo Node.js y npm)
RUN apt-get update && apt-get install -y \
    # Dependencias de PHP/Sistema
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    # Dependencias de Node.js (necesarias para la compilación)
    curl \
    # Limpieza de cache
    && rm -rf /var/lib/apt/lists/*

# Instalar Node.js 18.x
RUN curl -sL https://deb.nodesource.com/setup_$NODE_VERSION | bash - \
    && apt-get install -y nodejs \
    # Limpieza después de la instalación de Node
    && rm -rf /var/lib/apt/lists/*

# Instalar extensiones de PHP
RUN docker-php-ext-install pdo_mysql opcache bcmath gd

# Instalar Composer globalmente
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Define el directorio de trabajo
WORKDIR /var/www/html

# 2. Copia y Configuración de Laravel
# Copia TODOS los archivos de tu aplicación Laravel.
# ¡IMPORTANTE! Copiamos y damos permisos antes de instalar dependencias.
COPY --chown=www-data:www-data . .

# 3. Instalación y Compilación
# Instala las dependencias de Node.js
RUN npm ci

# Ejecuta el build de Vite para generar los archivos compilados
RUN npm run build

# Instala las dependencias de PHP (solo producción para un inicio más limpio)
RUN composer install --no-dev --optimize-autoloader

# 4. Configuración Final y Permisos
# Configura los permisos correctos para Laravel y los assets generados.
# La carpeta 'public/build' ahora es de www-data.
RUN chown -R www-data:www-data storage bootstrap/cache public/build \
    && chmod -R 775 storage bootstrap/cache public/build

# Copia tu configuración personalizada de Apache
COPY apache-conf.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo 'rewrite' de Apache
RUN a2enmod rewrite && a2ensite 000-default.conf

# Copia y da permisos de ejecución a tu script de entrada
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Expone el puerto y define el comando de inicio
EXPOSE 80
CMD ["/usr/local/bin/entrypoint.sh"]