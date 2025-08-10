#!/bin/bash

# Certificate Generator Setup Script
echo "🚀 Setting up Certificate Generator Project..."

# Create project directory
PROJECT_NAME="certificate-generator"
mkdir -p $PROJECT_NAME
cd $PROJECT_NAME

# Create directory structure
echo "📁 Creating directory structure..."
mkdir -p {public,src,templates,assets/{css,js,images,fonts},config,vendor,database,storage/certificates}

# Create all PHP files (empty for now)
echo "📄 Creating PHP files..."

# Create main index.php file
touch public/index.php
echo "<?php // Main application file ?>" > public/index.php

# Create .htaccess
touch public/.htaccess

# Create certificate template
touch templates/certificate_template.php
echo "<?php // Certificate template ?>" > templates/certificate_template.php

# Create database configuration
touch config/database.php
echo "<?php // Database configuration ?>" > config/database.php

# Create initialization script
touch init.php
echo "<?php // Database initialization script ?>" > init.php

# Create composer.json
echo "📦 Creating composer.json..."
cat > composer.json << 'EOF'
{
    "name": "certificate/generator",
    "description": "PDF Certificate Generator with DOMPDF",
    "require": {
        "dompdf/dompdf": "^2.0",
        "vlucas/phpdotenv": "^5.5"
    },
    "autoload": {
        "psr-4": {
            "App\\": "src/"
        }
    }
}
EOF

# Create .env file
echo "🔐 Creating .env file..."
cat > .env << 'EOF'
APP_NAME="Certificate Generator"
APP_URL="https://your-app.onrender.com"
DB_CONNECTION=sqlite
DB_DATABASE=database/certificates.db
APP_ENV=production
EOF

# Create .gitignore
echo "📝 Creating .gitignore..."
cat > .gitignore << 'EOF'
vendor/
.env
*.log
.DS_Store
database/*.db
storage/certificates/*.pdf
node_modules/
EOF

# Create render.yaml
echo "🚀 Creating render.yaml..."
cat > render.yaml << 'EOF'
services:
  - type: web
    name: certificate-generator
    env: php
    buildCommand: |
      apt-get update && apt-get install -y libfreetype6-dev libjpeg62-turbo-dev libpng-dev
      composer install --no-dev --optimize-autoloader
      php init.php
    startCommand: php -S 0.0.0.0:$PORT -t public
    envVars:
      - key: APP_ENV
        value: production
      - key: PHP_VERSION
        value: 8.1
EOF

# Create README
echo "📖 Creating README.md..."
cat > README.md << 'EOF'
# Certificate Generator

A modern PDF certificate generator built with PHP and DOMPDF.

## Features
- Instant PDF generation
- Customizable templates
- QR code verification
- Mobile responsive
- No signup required

## Live Demo
[View Live Demo](https://your-app.onrender.com)

## Local Development
1. Install dependencies: `composer install`
2. Run init script: `php init.php`
3. Start server: `php -S localhost:8000 -t public`

## Deploy to Render
1. Push to GitHub
2. Connect to Render
3. Deploy with render.yaml

## Technologies
- PHP 8.1
- DOMPDF
- SQLite
- Bootstrap 5
- Vanilla JavaScript

## File Structure
```
certificate-generator/
├── public/
│   ├── index.php           # Main application entry
│   └── .htaccess           # Apache configuration
├── templates/
│   └── certificate_template.php  # PDF template
├── config/
│   └── database.php        # Database configuration
├── database/               # SQLite database directory
├── storage/
│   └── certificates/       # Generated PDFs (temporary)
├── assets/
│   ├── css/               # Stylesheets
│   ├── js/                # JavaScript files
│   ├── images/            # Images and logos
│   └── fonts/             # Custom fonts
├── src/                   # Source code (future use)
├── vendor/                # Composer dependencies
├── init.php              # Database initialization
├── composer.json         # PHP dependencies
├── render.yaml          # Render deployment config
├── .env                 # Environment variables
└── .gitignore          # Git ignore rules
```
EOF

# Create placeholder files for assets
echo "🎨 Creating asset placeholder files..."
touch assets/css/style.css
echo "/* Custom styles */" > assets/css/style.css

touch assets/js/main.js
echo "// Main JavaScript file" > assets/js/main.js

# Create a sample logo SVG
cat > assets/images/logo.svg << 'EOF'
<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 100 100">
  <circle cx="50" cy="50" r="45" fill="#4F46E5"/>
  <text x="50" y="65" text-anchor="middle" font-size="40" fill="white">CG</text>
</svg>
EOF

# Create package.json for any future npm needs
echo "📦 Creating package.json..."
cat > package.json << 'EOF'
{
  "name": "certificate-generator",
  "version": "1.0.0",
  "description": "Certificate Generator Frontend Assets",
  "scripts": {
    "start": "php -S localhost:8000 -t public"
  }
}
EOF

# Create instructions file
echo "📋 Creating INSTRUCTIONS.md..."
cat > INSTRUCTIONS.md << 'EOF'
# Setup Instructions

## Step 1: Install PHP Dependencies
```bash
composer install
```

## Step 2: Initialize Database
```bash
php init.php
```

## Step 3: Run Locally
```bash
php -S localhost:8000 -t public
```
Visit: http://localhost:8000

## Step 4: Deploy to Render
1. Push this code to GitHub
2. Go to https://dashboard.render.com
3. Create New > Web Service
4. Connect your GitHub repo
5. Use these settings:
   - Environment: PHP
   - Build Command: (already in render.yaml)
   - Start Command: (already in render.yaml)
6. Click "Create Web Service"

## File Contents to Add:
- Copy the PHP code into respective files
- public/index.php - Main application
- templates/certificate_template.php - Certificate design
- config/database.php - Database setup
- init.php - Database initialization

## Testing:
1. Generate a test certificate
2. Verify it works with the verification system
3. Check PDF quality and design
EOF

# Create deployment checklist
echo "✅ Creating DEPLOY_CHECKLIST.md..."
cat > DEPLOY_CHECKLIST.md << 'EOF'
# Deployment Checklist

## Before Deployment:
- [ ] Update GitHub repository URL in README.md
- [ ] Update app URL in .env file
- [ ] Test locally with `composer install`
- [ ] Run `php init.php` to test database
- [ ] Generate test certificate locally

## GitHub Setup:
- [ ] Initialize git: `git init`
- [ ] Add files: `git add .`
- [ ] Commit: `git commit -m "Initial commit"`
- [ ] Create GitHub repository
- [ ] Add remote: `git remote add origin YOUR_REPO_URL`
- [ ] Push: `git push -u origin main`

## Render Deployment:
- [ ] Login to Render Dashboard
- [ ] Click "New +" > "Web Service"
- [ ] Connect GitHub repository
- [ ] Verify render.yaml settings
- [ ] Click "Create Web Service"
- [ ] Wait for deployment (3-5 minutes)
- [ ] Test live URL

## Post-Deployment:
- [ ] Test certificate generation
- [ ] Test certificate verification
- [ ] Update live URL in README
- [ ] Share with client
EOF

# Summary
echo ""
echo "✅ Project structure created successfully!"
echo ""
echo "📁 Project created in: $PROJECT_NAME/"
echo ""
echo "🔥 Quick Start:"
echo "1. cd $PROJECT_NAME"
echo "2. Add the PHP code to the respective files:"
echo "   - public/index.php"
echo "   - templates/certificate_template.php"
echo "   - config/database.php"
echo "   - init.php"
echo "3. Run: composer install"
echo "4. Run: php init.php"
echo "5. Start: php -S localhost:8000 -t public"
echo ""
echo "📚 Check INSTRUCTIONS.md for detailed setup"
echo "✅ Check DEPLOY_CHECKLIST.md before deploying"
echo ""
echo "🎉 Happy coding!"