#!/bin/bash

# Optimasi konfigurasi Laravel
php artisan optimize:clear
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan migrasi database
php artisan migrate --force

# Jalankan Apache di background (Foreground oleh Docker)
apache2-foreground
