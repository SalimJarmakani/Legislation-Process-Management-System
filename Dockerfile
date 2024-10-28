# Use the PHP image with Apache
FROM php:7.4-apache

# Copy application files to the Apache document root
COPY ./src /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Set the working directory (optional)
WORKDIR /var/www/html

# Expose the Apache port

EXPOSE 80