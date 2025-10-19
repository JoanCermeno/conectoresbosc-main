#!/bin/bash

# =======================================================
# ⚙️ SECCIÓN SSL: DESCARGA Y CONFIGURACIÓN DEL CERTIFICADO CA DE AIVEN
# =======================================================

# Define la ubicación del certificado CA dentro del contenedor
CA_PATH="/var/www/html/aiven-ca.pem"

echo "🔐 Verificando la variable de entorno AIVEN_CA_CERT..."

if [ -n "$AIVEN_CA_CERT" ]; then
    # Escribe el contenido de la variable de entorno en el archivo .pem
    echo "✍️ Escribiendo certificado CA de Aiven en $CA_PATH..."
    echo -e "$AIVEN_CA_CERT" > "$CA_PATH"
    
    # ⚠️ MUY IMPORTANTE: Se configura la variable de entorno de Laravel para que
    # apunte a la ruta del certificado recién creado.
    echo "🛠️ Configurando DB_SSL_CA en el entorno de ejecución..."
    export DB_SSL_CA="$CA_PATH"
    
    # Esto también sirve para configurar el driver en config/database.php
    export DB_SSL_MODE="REQUIRED"
    
    echo "✅ Certificado SSL configurado."
else
    echo "⚠️ ADVERTENCIA: La variable AIVEN_CA_CERT no está configurada."
    echo "    La conexión a la DB fallará si SSL es obligatorio."
fi

# =======================================================
# 🔧 SECCIÓN DE CONFIGURACIÓN Y MIGRACIONES DE LARAVEL
# =======================================================

# Espera un momento para asegurar que la base de datos esté lista
sleep 10

echo "📦 Instalando dependencias de desarrollo para Seeder (Faker)..."
# Ejecutamos una instalación completa para asegurar que Faker esté disponible para db:seed
composer install

echo "🔧 Ejecutando migraciones de Laravel..."
php artisan migrate --force --no-interaction
php artisan db:seed --force --no-interaction
php artisan storage:link     

# 🛠️ AÑADIMOS ESTA SECCIÓN PARA REFORZAR PERMISOS CRÍTICOS
echo "🔒 Aplicando permisos finales al almacenamiento y assets..."

# Permisos para storage y cache (lectura/escritura para www-data)
chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache
chmod -R 775 /var/www/html/storage /var/www/html/bootstrap/cache

# Permisos para los assets de Vite (lectura para www-data y el mundo)
chown -R www-data:www-data /var/www/html/public/build
chmod -R 755 /var/www/html/public/build

echo "✅ Permisos aplicados."


echo "🔍 Verificando existencia de manifest.json..."
if [ ! -f /var/www/html/public/build/manifest.json ]; then
    echo "❌ ERROR: No se encontró el archivo public/build/manifest.json"
    echo "👉 Asegúrate de que Vite haya generado correctamente los assets con 'npm run build'"
    exit 1
fi

echo "✅ manifest.json encontrado. Iniciando Apache..."
# Inicia Apache como el proceso principal
exec apache2-foreground
