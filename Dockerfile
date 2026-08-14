FROM php:8.2-cli

# Install dependencies yang dibutuhkan
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libpng-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    curl

# Install PHP extensions untuk Laravel & MySQL
RUN docker-php-ext-install pdo_mysql mbstring exif pcntl bcmath gd

# Copy Composer dari official image
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set folder kerja
WORKDIR /app

# Copy seluruh file project
COPY . .

# Install dependencies vendor tanpa dev
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Set permission storage
RUN chmod -R 777 storage bootstrap/cache

# Expose port yang digunakan Render
EXPOSE 10000

# Jalankan server Laravel
CMD php artisan serve --host=0.0.0.0 --port=10000
