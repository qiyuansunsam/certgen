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
