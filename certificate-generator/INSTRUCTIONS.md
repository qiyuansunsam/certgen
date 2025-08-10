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
