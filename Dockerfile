# Use official PHP image with Apache
FROM php:8.2-apache

# Enable mod_rewrite for Laravel pretty URLs
RUN a2enmod rewrite headers

# Install system dependencies
RUN apt-get update && apt-get install -y \
    git \
    unzip \
    libicu-dev \
    && docker-php-ext-install pdo_mysql intl

# Copy Composer binary
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy source files
COPY . /var/www/html

# Fix Git ownership warning in container
RUN git config --global --add safe.directory /var/www/html

# Create required Laravel directories and set permissions
RUN mkdir -p /var/www/html/bootstrap/cache && \
    chmod -R 777 /var/www/html/bootstrap/cache && \
    chmod -R 777 /var/www/html/storage

# Install Composer dependencies
RUN composer install --no-scripts --no-autoloader --no-dev

# Optional: Install Laravel Telescope (remove or comment if not needed)
# RUN composer require laravel/telescope --update-without-dev && \
#     php artisan telescope:install && \
#     php artisan config:clear && \
#     php artisan cache:clear

# Run autoloader and optimize
RUN composer dump-autoload --optimize

# Replace default Apache config to point to Laravel public folder
COPY 000-default.conf /etc/apache2/sites-available/000-default.conf

# Expose port 80
EXPOSE 80