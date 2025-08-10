#!/bin/bash
set -e

echo "🚀 Building Certificate Generator for Render..."

# Change to certificate-generator directory
cd certificate-generator

# Install PHP and all required extensions
echo "📦 Installing PHP and all required libraries..."
apt-get update && apt-get install -y \
    php-cli \
    php-zip \
    php-mbstring \
    php-dom \
    php-sqlite3 \
    php-curl \
    php-gd \
    php-json \
    php-xml \
    php-pdo \
    php-pdo-sqlite \
    curl \
    unzip \
    sqlite3 \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev
curl -sS https://getcomposer.org/installer | php
chmod +x composer.phar
mv composer.phar /usr/local/bin/composer

# Install Composer dependencies
echo "📚 Installing Composer dependencies..."
composer install --no-dev --optimize-autoloader --no-interaction

# Create necessary directories
echo "📁 Creating directories..."
mkdir -p database
mkdir -p storage/certificates
mkdir -p public
chmod -R 755 storage/
chmod 644 database/

# Initialize database
echo "🗄️ Initializing database..."
php init.php

# Set proper permissions
echo "🔐 Setting permissions..."
chmod -R 755 public/
chmod -R 755 templates/
chmod -R 755 config/
chmod 644 database/certificates.db

echo "✅ Build completed successfully!"
echo "📋 Build summary:"
echo "   - Composer dependencies installed"
echo "   - Database initialized"
echo "   - Directories created with proper permissions"
echo "   - Application ready for deployment"