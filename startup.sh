#!/bin/bash

# Startup script for Laravel on Azure App Service Linux
# This makes Laravel's public folder the document root

# Create .env from example if not exists
if [ ! -f /home/site/wwwroot/.env ]; then
    cp /home/site/wwwroot/.env.example /home/site/wwwroot/.env
fi

# Move Laravel's public content to wwwroot so it becomes the document root
# Azure serves from /home/site/wwwroot by default
if [ -d /home/site/wwwroot/public ]; then
    cd /home/site/wwwroot
    # Copy public content to current directory (excluding public folder itself)
    cp -r public/* . 2>/dev/null
    cp public/.* . 2>/dev/null
fi

# Run Laravel migrations
cd /home/site/wwwroot
php artisan migrate --force 2>/dev/null
php artisan storage:link --force 2>/dev/null
