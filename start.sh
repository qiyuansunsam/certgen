#!/bin/bash
set -e

echo "🌟 Starting Certificate Generator..."

# Change to certificate-generator directory
cd certificate-generator

# Ensure database exists and has proper permissions
if [ -f "database/certificates.db" ]; then
    echo "✅ Database found"
    chmod 644 database/certificates.db
else
    echo "⚠️  Database not found, initializing..."
    php init.php
fi

# Check if composer dependencies are installed
if [ ! -f "vendor/autoload.php" ]; then
    echo "⚠️  Composer dependencies not found, installing..."
    composer install --no-dev --optimize-autoloader
fi

# Set runtime permissions
chmod -R 755 storage/
chmod -R 755 public/

# Determine port
PORT=${PORT:-8000}
echo "🔗 Starting server on port $PORT"

# Start PHP built-in server
echo "🚀 Server starting at http://0.0.0.0:$PORT"
exec php -S 0.0.0.0:$PORT -t public