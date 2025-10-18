# Usa una imagen base de PHP oficial con Apache
FROM php:8.2-apache

# Instala extensiones de PHP necesarias
RUN docker-php-ext-install pdo_mysql opcache bcmath # Añadimos bcmath aquí

# Instala las herramientas del sistema necesarias
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libjpeg-dev \
    libzip-dev \
    && rm -rf /var/lib/apt/lists/*

# Instala extensiones GD (para manipulación de imágenes, si la necesitas)
RUN docker-php-ext-install gd

# Instala Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Configura el directorio de trabajo
WORKDIR /var/www/html

# Copia los archivos de la aplicación
COPY . .

# Instala las dependencias de Composer (sin dependencias de desarrollo para producción)
RUN composer install --no-dev --optimize-autoloader

# Instala Node.js y npm (si tu aplicación usa Vite/Webpack)
RUN curl -sL https://deb.nodesource.com/setup_18.x | bash - \
    && apt-get install -y nodejs

ENV NODE_ENV=production

# Instala las dependencias de Node.js y compila los assets
RUN npm install \
    && npm run build \
    && echo "✅ Vite build completado correctamente" \
    || (echo "❌ ERROR: El build de Vite falló. Revisa tu configuración." && exit 1)

# Verifica que los archivos se generaron
RUN ls -la public/build \
    || (echo "❌ ERROR: No se encontró la carpeta public/build después del build." && exit 1)


# Configura los permisos de almacenamiento y caché
RUN chown -R www-data:www-data storage bootstrap/cache \
    && chmod -R 775 storage bootstrap/cache

# === NUEVAS LÍNEAS PARA LA CONFIGURACIÓN DE APACHE ===
# Copia la configuración de Apache personalizada
COPY apache-conf.conf /etc/apache2/sites-available/000-default.conf

# Habilita el módulo rewrite y la configuración del sitio
RUN a2enmod rewrite && a2ensite 000-default.conf
# === FIN NUEVAS LÍNEAS ===

# Expone el puerto 80 para Apache
EXPOSE 80

# Crea un script de entrada para ejecutar las migraciones y luego el comando de inicio
COPY entrypoint.sh /usr/local/bin/entrypoint.sh
RUN chmod +x /usr/local/bin/entrypoint.sh

# Usa el script de entrada como CMD
CMD ["/usr/local/bin/entrypoint.sh"]