FROM php:8.3-apache

# 1. Install dependencies, library Postgres, dan Node.js untuk Vite/OpenStreetMap assets
RUN apt-get update && apt-get install -y \
    libpq-dev \
    zip \
    unzip \
    git \
    curl \
    && curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs \
    && docker-php-ext-install pdo pdo_pgsql

# 2. Aktifkan mod_rewrite Apache
RUN a2enmod rewrite

# 3. Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# 4. Set working directory & Copy file
WORKDIR /var/www/html
COPY . .

# 5. Install dependency PHP & Node.js, lalu build asset frontend
RUN composer install --no-dev --optimize-autoloader
RUN npm install
RUN npm run build

# 6. Set permission folder penting Laravel
RUN chown -R www-data:www-data storage bootstrap/cache

# 7. Arahkan DocumentRoot Apache ke folder /public
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# 8. Jadikan file start.sh bisa dieksekusi
RUN chmod +x start.sh

EXPOSE 80

# 9. Jalankan script start saat container hidup
CMD ["./start.sh"]