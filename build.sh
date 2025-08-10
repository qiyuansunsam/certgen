#!/bin/bash
set -e

echo "🚀 Building Certificate Generator for Render..."

# Change to certificate-generator directory
cd certificate-generator

# Download and install Composer (using existing PHP from Render)
echo "📦 Installing Composer..."
EXPECTED_CHECKSUM="$(php -r 'copy("https://composer.github.io/installer.sig", "php://stdout");')"
php -r "copy('https://getcomposer.org/installer', 'composer-setup.php');"
ACTUAL_CHECKSUM="$(php -r "echo hash_file('sha384', 'composer-setup.php');")"

if [ "$EXPECTED_CHECKSUM" != "$ACTUAL_CHECKSUM" ]; then
    >&2 echo 'ERROR: Invalid installer checksum'
    rm composer-setup.php
    exit 1
fi

php composer-setup.php --quiet
rm composer-setup.php

# Install Composer dependencies
echo "📚 Installing Composer dependencies..."
php composer.phar install --no-dev --optimize-autoloader --no-interaction

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