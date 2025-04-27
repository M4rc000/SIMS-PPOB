FROM php:8.1-apache

# Install extension cURL
RUN docker-php-ext-install curl

# Aktifkan mod_rewrite untuk dukungan pretty URLs
RUN a2enmod rewrite

# Salin seluruh kode aplikasi
COPY . /var/www/html/

WORKDIR /var/www/html/

# Install Composer dependencies
RUN curl -sS https://getcomposer.org/installer | php -- --install-dir=/usr/local/bin --filename=composer && \
    composer install --no-dev --optimize-autoloader

# Pastikan konfigurasi Apache sesuai untuk Railway; Anda mungkin perlu menyesuaikan VirtualHost agar menggunakan $PORT
# Railway menginjeksi PORT, namun Apache default mendengarkan port 80; Anda dapat menambahkan konfigurasi dinamis jika diperlukan

CMD ["apache2-foreground"]
