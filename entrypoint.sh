#!/bin/bash

# Espera un momento para asegurar que la base de datos esté lista
# Esto es opcional y puede ajustarse o quitarse si no es necesario para tu setup
# sleep 10 

echo "Running Laravel migrations..."
#generandoo el key de la aplicacion

php artisan migrate --force --no-interaction

echo "Starting Apache..."
exec apache2-foreground