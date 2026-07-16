#!/usr/bin/env bash

# Jalankan migrasi database otomatis (pakai --force karena ini environment production)
php artisan migrate --force

# Optimasi cache agar aplikasi lebih cepat
php artisan config:cache
php artisan route:cache
php artisan view:cache

# Jalankan Apache di foreground
apache2-foreground