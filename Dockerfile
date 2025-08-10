# Use official PHP image with Apache
FROM php:8.1-apache

# Install required system packages and PHP extensions
RUN apt-get update && apt-get install -y \
    git \
    zip \
    unzip \
    && docker-php-ext-install pdo pdo_mysql \
    && apt-get clean \
    && rm -rf /var/lib/apt/lists/*

# Install Composer
COPY --from=composer:latest /usr/bin/composer /usr/bin/composer

# Set working directory
WORKDIR /var/www/html

# Copy your application
COPY . /var/www/html/

# Run your build script
RUN bash build.sh

# Configure Apache to serve from the right directory
RUN echo '<VirtualHost *:80>\n\
    DocumentRoot /var/www/html/certificate-generator/public\n\
    <Directory /var/www/html/certificate-generator/public>\n\
        AllowOverride All\n\
        Require all granted\n\
    </Directory>\n\
</VirtualHost>' > /etc/apache2/sites-available/000-default.conf

# Enable Apache modules
RUN a2enmod rewrite

# Use the PORT environment variable that Render provides
RUN sed -i 's/80/${PORT}/g' /etc/apache2/sites-available/000-default.conf
RUN sed -i 's/80/${PORT}/g' /etc/apache2/ports.conf

# Start command
CMD ["bash", "start.sh"]