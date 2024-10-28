# Use the PHP image with Apache
FROM php:8.2-apache

# Copy application files to the Apache document root
COPY ./src /var/www/html

# Install necessary PHP extensions
RUN docker-php-ext-install mysqli pdo pdo_mysql

# Enable Apache mod_rewrite for .htaccess
RUN a2enmod rewrite

# Configure Apache to allow .htaccess overrides
RUN echo "<Directory /var/www/html>\n\
    AllowOverride All\n\
</Directory>\n" >> /etc/apache2/apache2.conf

# Set the working directory (optional)
WORKDIR /var/www/html

# Expose the Apache port
EXPOSE 80
