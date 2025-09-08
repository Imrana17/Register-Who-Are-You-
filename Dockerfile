# Use official PHP image with Apache
FROM php:8.2-apache

# Install system dependencies and Composer
RUN apt-get update && apt-get install -y \
    unzip \
    git \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:2 /usr/bin/composer /usr/bin/composer

# Copy project files
COPY . /var/www/html/

# Install PHP dependencies
WORKDIR /var/www/html
RUN composer install --no-dev --optimize-autoloader

# Open port 80
EXPOSE 80
