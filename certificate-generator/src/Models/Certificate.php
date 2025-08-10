<?php

namespace App\Models;

use PDO;
use PDOException;

class Certificate
{
    private $db;

    public function __construct()
    {
        // Use the existing Database class
        require_once __DIR__ . '/../../config/database.php';
        $database = new \Database();
        $this->db = $database->getConnection();
        
        if (!$this->db) {
            throw new Exception('Database connection failed');
        }
    }

    /**
     * Create a new certificate
     */
    public function create(array $data)
    {
        $sql = "INSERT INTO certificates (certificate_number, recipient_name, course_name, instructor_name, issue_date) 
                VALUES (?, ?, ?, ?, ?)";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            $data['certificate_number'],
            $data['recipient_name'],
            $data['course_name'],
            $data['instructor_name'],
            $data['issue_date']
        ]);
    }

    /**
     * Find certificate by certificate number
     */
    public function findByCertificateNumber($certNumber)
    {
        $sql = "SELECT * FROM certificates WHERE certificate_number = ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$certNumber]);
        
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    /**
     * Get total certificate count
     */
    public function getTotalCount()
    {
        $sql = "SELECT COUNT(*) as total FROM certificates";
        $stmt = $this->db->query($sql);
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        
        return (int) $result['total'];
    }

    /**
     * Get all certificates (with pagination)
     */
    public function getAll($limit = 50, $offset = 0)
    {
        $sql = "SELECT * FROM certificates ORDER BY created_at DESC LIMIT ? OFFSET ?";
        $stmt = $this->db->prepare($sql);
        $stmt->execute([$limit, $offset]);
        
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    /**
     * Delete a certificate
     */
    public function delete($id)
    {
        $sql = "DELETE FROM certificates WHERE id = ?";
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([$id]);
    }

    /**
     * Update a certificate
     */
    public function update($id, array $data)
    {
        $sql = "UPDATE certificates 
                SET recipient_name = ?, course_name = ?, instructor_name = ?, issue_date = ?
                WHERE id = ?";
        
        $stmt = $this->db->prepare($sql);
        
        return $stmt->execute([
            $data['recipient_name'],
            $data['course_name'],
            $data['instructor_name'],
            $data['issue_date'],
            $id
        ]);
    }
}