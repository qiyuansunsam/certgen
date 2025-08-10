<?php
// Database initialization script
echo "Initializing Certificate Generator Database...\n";

// Create necessary directories
$directories = [
    'database',
    'storage/certificates',
    'vendor',
    'public',
    'templates',
    'config'
];

foreach ($directories as $dir) {
    if (!file_exists($dir)) {
        mkdir($dir, 0777, true);
        echo "Created directory: $dir\n";
    }
}

// Initialize database
require_once __DIR__ . '/config/database.php';
$db = new Database();
$conn = $db->getConnection();

// Add sample data
$sampleCertificates = [
    ['CERT-SAMPLE001', 'Jane Smith', 'Web Development Bootcamp', 'Dr. Michael Chen', '2024-01-15'],
    ['CERT-SAMPLE002', 'Robert Johnson', 'Data Science Fundamentals', 'Prof. Sarah Williams', '2024-01-20'],
    ['CERT-SAMPLE003', 'Emily Davis', 'UI/UX Design Masterclass', 'Alex Thompson', '2024-01-25'],
];

$stmt = $conn->prepare("INSERT OR IGNORE INTO certificates (certificate_number, recipient_name, course_name, instructor_name, issue_date) VALUES (?, ?, ?, ?, ?)");

foreach ($sampleCertificates as $cert) {
    $stmt->execute($cert);
}

echo "Database initialized successfully!\n";
echo "Sample certificates added.\n";

// Check if vendor directory exists (for Render deployment)
if (!file_exists('vendor/autoload.php')) {
    echo "\nNote: Run 'composer install' to install dependencies.\n";
}

echo "\nSetup complete! You can now run the application.\n";