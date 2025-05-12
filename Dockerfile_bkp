# Use PHP FPM as base
FROM php:8.4-fpm

# Install system dependencies
RUN apt-get update && apt-get install -y \
    curl \
    git \
    unzip \
    gnupg \
    libpng-dev \
    libjpeg-dev \
    libfreetype6-dev \
    libzip-dev \
    libonig-dev \
    libxml2-dev \
    zip \
    gnupg2 \
    && docker-php-ext-configure gd --with-freetype --with-jpeg \
    && docker-php-ext-install pdo pdo_mysql bcmath gd zip \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Node.js v22
RUN curl -fsSL https://deb.nodesource.com/setup_22.x | bash - && \
    apt-get install -y nodejs && \
    node -v && npm -v

# Install Composer
RUN curl -sS https://getcomposer.org/installer | php && mv composer.phar /usr/local/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy everything including .env early
COPY . .

# Set ownership for copied files (after COPY)
RUN chown -R www-data:www-data /var/www/html/

# Install PHP dependencies
RUN composer install --no-dev --optimize-autoloader --no-interaction

# Install JS dependencies
RUN npm install

# Add the Vite legacy plugin
RUN npm install @vitejs/plugin-legacy --save-dev

# Clear Laravel caches to load correct .env
RUN php artisan config:clear && \
    php artisan view:clear && \
    php artisan route:clear

# Build Vite assets
RUN npm run build

# Set correct permissions for storage and cache
RUN chmod -R 777 storage bootstrap/cache && \
    chown -R www-data:www-data storage bootstrap/cache

# Set permissions for public/build
RUN chown -R www-data:www-data public/build && \
    chmod -R 755 public/build

# Expose PHP-FPM
EXPOSE 9000

# Run PHP-FPM
CMD ["php-fpm"]

