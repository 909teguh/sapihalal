#!/usr/bin/env bash
set -e

echo "==> Starting Siasuh application..."

# Generate APP_KEY jika belum di-set (fallback safety)
if [ -z "$APP_KEY" ]; then
    echo "==> APP_KEY tidak ditemukan, generating..."
    php artisan key:generate --force
fi

# Jalankan migrasi database (--force wajib di production)
echo "==> Running database migrations..."
php artisan migrate --force

# Buat symlink storage (untuk akses file upload)
echo "==> Creating storage symlink..."
php artisan storage:link --force 2>/dev/null || true

# Cache config, route, dan view untuk performa production
echo "==> Optimizing application..."
php artisan optimize

echo "==> Starting Apache..."

# Jalankan Apache di foreground
exec apache2-foreground