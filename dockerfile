FROM php:8.2-apache

# Install ekstensi PHP yang dibutuhkan
RUN apt-get update && apt-get install -y \
    libzip-dev zip unzip git libpng-dev libicu-dev \
    && docker-php-ext-install zip pdo pdo_mysql mysqli gd intl

# Aktifkan mod_rewrite dan set ServerName untuk hilangkan warning
RUN a2enmod rewrite \
 && echo "ServerName localhost" >> /etc/apache2/apache2.conf

# Salin semua file project ke dalam container
COPY . /var/www/html

# Atur document root ke folder public
ENV APACHE_DOCUMENT_ROOT=/var/www/html/public

# Update konfigurasi Apache agar root-nya ke /public
RUN sed -ri -e 's!/var/www/html!/var/www/html/public!g' /etc/apache2/sites-available/*.conf

# Beri hak akses ke folder writable (CI4)
RUN chown -R www-data:www-data /var/www/html/writable

