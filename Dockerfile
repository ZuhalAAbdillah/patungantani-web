FROM php:8.2-apache

# Install dependencies yang dibutuhkan Laravel, PostgreSQL & ext-gd (QR Code)
RUN apt-get update && apt-get install -y \
    libpq-dev \
    libzip-dev \
    unzip \
    git \
    curl \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && apt-get clean && rm -rf /var/lib/apt/lists/*

# Install PHP extensions
RUN docker-php-ext-install pdo pdo_mysql pdo_pgsql zip gd

# Install Node.js untuk build frontend (Vite & Tailwind CSS)
RUN curl -fsSL https://deb.nodesource.com/setup_20.x | bash - \
    && apt-get install -y nodejs

# Enable Apache mod_rewrite
RUN a2enmod rewrite

# Ganti DocumentRoot Apache ke folder public Laravel
ENV APACHE_DOCUMENT_ROOT /var/www/html/public
RUN sed -ri -e 's!/var/www/html!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/sites-available/*.conf
RUN sed -ri -e 's!/var/www/!${APACHE_DOCUMENT_ROOT}!g' /etc/apache2/apache2.conf /etc/apache2/conf-available/*.conf

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy semua file aplikasi ke container
COPY . .

# Install dependencies PHP (vendor)
RUN composer install --no-interaction --prefer-dist --optimize-autoloader

# Build Frontend (Tailwind/Vite)
RUN npm install && npm run build

# Beri permission ke folder storage dan cache
RUN chown -R www-data:www-data /var/www/html/storage /var/www/html/bootstrap/cache

# Fix masalah CRLF (format Windows) di file bash dan beri permission eksekusi
RUN sed -i 's/\r$//' /var/www/html/start.sh
RUN chmod +x /var/www/html/start.sh

CMD ["/var/www/html/start.sh"]
