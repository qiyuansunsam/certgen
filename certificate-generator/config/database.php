<?php
class Database {
    private $conn;
    private $db_file = __DIR__ . '/../database/certificates.db';
    
    public function __construct() {
        $this->connect();
    }
    
    private function connect() {
        try {
            // Create database directory if it doesn't exist
            $db_dir = dirname($this->db_file);
            if (!file_exists($db_dir)) {
                mkdir($db_dir, 0777, true);
            }
            
            // Connect to SQLite database
            $this->conn = new PDO('sqlite:' . $this->db_file);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Create tables if they don't exist
            $this->createTables();
            
        } catch(PDOException $e) {
            echo "Connection failed: " . $e->getMessage();
        }
    }
    
    private function createTables() {
        $sql = "
            CREATE TABLE IF NOT EXISTS certificates (
                id INTEGER PRIMARY KEY AUTOINCREMENT,
                certificate_number VARCHAR(50) UNIQUE NOT NULL,
                recipient_name VARCHAR(255) NOT NULL,
                course_name VARCHAR(255) NOT NULL,
                instructor_name VARCHAR(255) NOT NULL,
                issue_date DATE NOT NULL,
                created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
            );
            
            CREATE INDEX IF NOT EXISTS idx_cert_number ON certificates(certificate_number);
        ";
        
        $this->conn->exec($sql);
    }
    
    public function getConnection() {
        return $this->conn;
    }
}