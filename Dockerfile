FROM php:8.2-fpm

WORKDIR /var/www

# Install dependencies
RUN apt-get update && apt-get install -y \
    git \
    curl \
    unzip \
    libzip-dev \
    nginx \
    && docker-php-ext-install pdo pdo_mysql zip

# Install composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Copy project
COPY . .

# Install Laravel dependencies
RUN composer install --no-dev --optimize-autoloader

# Laravel permissions
RUN chmod -R 775 storage bootstrap/cache

# Copy nginx config
COPY nginx.conf /etc/nginx/sites-enabled/default

EXPOSE 8080

CMD service nginx start && php-fpm