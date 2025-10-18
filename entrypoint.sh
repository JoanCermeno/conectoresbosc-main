#!/bin/bash

# Espera un momento para asegurar que la base de datos esté lista
sleep 10

echo "🔧 Ejecutando migraciones de Laravel..."
php artisan migrate --force --no-interaction

# 🛠️ AÑADIMOS ESTA SECCIÓN PARA REFORZAR PERMISOS CRÍTICOS
# Esto asegura que Apache (que corre como www-data) pueda leer todo lo necesario.
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