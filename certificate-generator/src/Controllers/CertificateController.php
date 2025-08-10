<?php

namespace App\Controllers;

use App\Models\Certificate;
use App\Services\PdfGenerator;

class CertificateController
{
    private $certificateModel;
    private $pdfGenerator;

    public function __construct()
    {
        $this->certificateModel = new Certificate();
        $this->pdfGenerator = new PdfGenerator();
    }

    public function index()
    {
        $totalCertificates = $this->certificateModel->getTotalCount();
        
        // Load the view
        include __DIR__ . '/../../templates/index.php';
    }

    public function generate()
    {
        try {
            // Validate input
            $data = $this->validateInput();
            
            // Generate unique certificate number
            $certNumber = 'CERT-' . strtoupper(uniqid());
            $data['certificate_number'] = $certNumber;
            
            // Save to database
            $this->certificateModel->create($data);
            
            // Generate PDF
            $pdf = $this->pdfGenerator->generate($data);
            
            // Output PDF
            $this->outputPdf($pdf, $certNumber);
            
        } catch (Exception $e) {
            http_response_code(500);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    public function verify()
    {
        try {
            $certNumber = $_POST['certificate_number'] ?? '';
            
            if (empty($certNumber)) {
                throw new Exception('Certificate number is required');
            }
            
            $certificate = $this->certificateModel->findByCertificateNumber($certNumber);
            
            header('Content-Type: application/json');
            if ($certificate) {
                echo json_encode($certificate);
            } else {
                echo json_encode(['error' => 'Certificate not found']);
            }
            
        } catch (Exception $e) {
            header('Content-Type: application/json');
            http_response_code(400);
            echo json_encode(['error' => $e->getMessage()]);
        }
    }

    private function validateInput()
    {
        $required = ['recipient_name', 'course_name', 'instructor_name', 'issue_date'];
        $data = [];
        
        foreach ($required as $field) {
            $value = trim($_POST[$field] ?? '');
            if (empty($value)) {
                throw new Exception("Field {$field} is required");
            }
            $data[$field] = htmlspecialchars($value, ENT_QUOTES, 'UTF-8');
        }
        
        // Validate date
        if (!strtotime($data['issue_date'])) {
            throw new Exception('Invalid issue date');
        }
        
        return $data;
    }

    private function outputPdf($pdfContent, $certNumber)
    {
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="certificate_' . $certNumber . '.pdf"');
        header('Cache-Control: private, max-age=0, must-revalidate');
        header('Pragma: public');
        
        echo $pdfContent;
        exit;
    }
}