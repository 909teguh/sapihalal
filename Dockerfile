FROM php:8.4-apache

# 1. Install system dependencies dan PHP extensions yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    libpng-dev \
    libjpeg-dev \
    libwebp-dev \
    zip \
    unzip \
    git \
    curl \
    && docker-php-ext-install pdo pdo_pgsql bcmath opcache pcntl gd \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 2. Install Node.js 20
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# 3. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 4. Konfigurasi OPcache untuk production
RUN { \
    echo 'opcache.enable=1'; \
    echo 'opcache.memory_consumption=128'; \
    echo 'opcache.interned_strings_buffer=8'; \
    echo 'opcache.max_accelerated_files=10000'; \
    echo 'opcache.revalidate_freq=0'; \
    echo 'opcache.validate_timestamps=0'; \
    echo 'opcache.fast_shutdown=1'; \
} > /usr/local/etc/php/conf.d/opcache.ini

# 5. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 6. Set working directory
WORKDIR /var/www/html

# 7. Copy semua file aplikasi
#    (vendor, node_modules, .env, dll sudah di-exclude oleh .dockerignore)
COPY . .

# 8. Buat .env sementara agar artisan bisa berjalan saat build
#    (akan dihapus setelah build; runtime menggunakan env vars dari Render)
RUN echo 'APP_KEY=base64:AAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAAA=' > .env

# 9. Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# 10. Install Node dependencies dan build frontend assets
RUN npm ci && npm run build

# 11. Hapus .env sementara; runtime pakai environment variables dari Render
RUN rm -f .env

# 12. Set permissions untuk folder penting Laravel
RUN chown -R www-data:www-data /var/www/html \
    && chmod -R 755 /var/www/html/storage \
    && chmod -R 755 /var/www/html/bootstrap/cache

# 13. Arahkan Apache DocumentRoot ke /public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf \
    && sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 14. Pastikan start.sh bisa dieksekusi
RUN chmod +x start.sh

EXPOSE 80

CMD ["./start.sh"]