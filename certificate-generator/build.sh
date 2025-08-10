#!/bin/bash
set -e

echo "🚀 Building Certificate Generator for Render..."

# Update system packages
echo "📦 Updating system packages..."
apt-get update

# Install required PHP extensions and dependencies
echo "🔧 Installing PHP extensions..."
apt-get install -y \
    libfreetype6-dev \
    libjpeg62-turbo-dev \
    libpng-dev \
    libzip-dev \
    unzip \
    sqlite3 \
    php-sqlite3 \
    php-mbstring \
    php-dom

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