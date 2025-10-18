#!/bin/bash

# Espera un momento para asegurar que la base de datos esté lista
sleep 10

echo "🔧 Ejecutando migraciones de Laravel..."
php artisan migrate --force --no-interaction

echo "🔍 Verificando existencia de manifest.json..."
if [ ! -f /var/www/html/public/build/manifest.json ]; then
    echo "❌ ERROR: No se encontró el archivo public/build/manifest.json"
    echo "👉 Asegúrate de que Vite haya generado correctamente los assets con 'npm run build'"
    exit 1
fi

echo "✅ manifest.json encontrado. Iniciando Apache..."
exec apache2-foreground