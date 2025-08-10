#!/bin/bash
set -e

echo "🚀 Building Certificate Generator for Render..."

# Change to certificate-generator directory
cd certificate-generator

# Install Composer
echo "📦 Installing Composer..."
curl -sS https://getcomposer.org/installer | php
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