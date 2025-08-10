<?php
session_start();
require_once __DIR__ . '/../vendor/autoload.php';
require_once __DIR__ . '/../config/database.php';

use Dompdf\Dompdf;
use Dompdf\Options;

// Initialize database
$db = new Database();
$conn = $db->getConnection();

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST' && isset($_POST['action'])) {
    
    if ($_POST['action'] === 'generate') {
        try {
            $recipient_name = $_POST['recipient_name'] ?? '';
            $course_name = $_POST['course_name'] ?? '';
            $instructor_name = $_POST['instructor_name'] ?? '';
            $issue_date = $_POST['issue_date'] ?? date('Y-m-d');
            
            // Generate unique certificate number
            $cert_number = 'CERT-' . strtoupper(uniqid());
            
            // Save to database
            $stmt = $conn->prepare("INSERT INTO certificates (certificate_number, recipient_name, course_name, instructor_name, issue_date) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$cert_number, $recipient_name, $course_name, $instructor_name, $issue_date]);
            
            // Generate PDF
            $options = new Options();
            $options->set('isHtml5ParserEnabled', true);
            $options->set('isPhpEnabled', true);
            $options->set('isRemoteEnabled', false);
            $options->set('defaultFont', 'sans-serif');
            
            $dompdf = new Dompdf($options);
            
            // Load certificate template
            ob_start();
            include __DIR__ . '/../templates/certificate_template.php';
            $html = ob_get_clean();
            
            $dompdf->loadHtml($html);
            $dompdf->setPaper('A4', 'landscape');
            $dompdf->render();
            
            // Output PDF
            header('Content-Type: application/pdf');
            header('Content-Disposition: attachment; filename="certificate_' . $cert_number . '.pdf"');
            echo $dompdf->output();
            exit;
        } catch (Exception $e) {
            $_SESSION['error'] = $e->getMessage();
            header('Location: index.php?error=1');
            exit;
        }
    }
    
    if ($_POST['action'] === 'verify') {
        $cert_number = $_POST['certificate_number'] ?? '';
        $stmt = $conn->prepare("SELECT * FROM certificates WHERE certificate_number = ?");
        $stmt->execute([$cert_number]);
        $certificate = $stmt->fetch(PDO::FETCH_ASSOC);
        
        header('Content-Type: application/json');
        echo json_encode($certificate ?: ['error' => 'Certificate not found']);
        exit;
    }
}

// Get stats
$stmt = $conn->query("SELECT COUNT(*) as total FROM certificates");
$total_certificates = $stmt->fetch(PDO::FETCH_ASSOC)['total'];
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Professional Certificate Generator - Instant PDF Certificates</title>
    <meta name="description" content="Generate beautiful, professional PDF certificates instantly. No signup required. Customizable templates with QR verification.">
    
    <!-- Bootstrap 5 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.0/font/bootstrap-icons.css">
    
    <!-- Google Fonts -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Playfair+Display:wght@700&display=swap" rel="stylesheet">
    
    <style>
        :root {
            --primary: #4F46E5;
            --primary-dark: #4338CA;
            --secondary: #10B981;
            --dark: #1F2937;
            --light: #F9FAFB;
        }
        
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        body {
            font-family: 'Inter', sans-serif;
            color: var(--dark);
            line-height: 1.6;
        }
        
        .hero {
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
            color: white;
            padding: 100px 0 120px;
            position: relative;
            overflow: hidden;
        }
        
        .hero::before {
            content: '';
            position: absolute;
            top: 0;
            left: 0;
            right: 0;
            bottom: 0;
            background: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 1440 320"><path fill="%23ffffff" fill-opacity="0.1" d="M0,96L48,112C96,128,192,160,288,160C384,160,480,128,576,122.7C672,117,768,139,864,144C960,149,1056,139,1152,122.7C1248,107,1344,85,1392,74.7L1440,64L1440,320L1392,320C1344,320,1248,320,1152,320C1056,320,960,320,864,320C768,320,672,320,576,320C480,320,384,320,288,320C192,320,96,320,48,320L0,320Z"></path></svg>') no-repeat bottom;
            background-size: cover;
        }
        
        .hero h1 {
            font-size: 3.5rem;
            font-weight: 700;
            margin-bottom: 1.5rem;
            font-family: 'Playfair Display', serif;
        }
        
        .hero p {
            font-size: 1.25rem;
            opacity: 0.95;
            margin-bottom: 2rem;
        }
        
        .stats {
            background: rgba(255,255,255,0.1);
            backdrop-filter: blur(10px);
            border-radius: 15px;
            padding: 20px 40px;
            display: inline-block;
            margin-top: 20px;
        }
        
        .stats-number {
            font-size: 2rem;
            font-weight: 700;
            color: #FFD700;
        }
        
        .form-section {
            padding: 40px 0;
            background: var(--light);
        }
        
        .form-card {
            background: white;
            border-radius: 20px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.1);
            padding: 40px;
            position: relative;
            margin-top: 0px;
            z-index: 10;
        }
        
        .form-label {
            font-weight: 600;
            color: var(--dark);
            margin-bottom: 8px;
        }
        
        .form-control, .form-select {
            border: 2px solid #E5E7EB;
            border-radius: 10px;
            padding: 12px 15px;
            font-size: 16px;
            transition: all 0.3s;
        }
        
        .form-control:focus, .form-select:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(79, 70, 229, 0.1);
        }
        
        .btn-generate {
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            color: white;
            border: none;
            padding: 15px 40px;
            border-radius: 50px;
            font-size: 18px;
            font-weight: 600;
            transition: all 0.3s;
            box-shadow: 0 4px 15px rgba(79, 70, 229, 0.3);
        }
        
        .btn-generate:hover {
            transform: translateY(-2px);
            box-shadow: 0 6px 20px rgba(79, 70, 229, 0.4);
        }
        
        .preview-section {
            padding: 60px 0;
        }
        
        .preview-card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 5px 20px rgba(0,0,0,0.1);
            padding: 30px;
            border: 2px dashed #E5E7EB;
            min-height: 400px;
            display: flex;
            align-items: center;
            justify-content: center;
            position: relative;
            background-image: url('data:image/svg+xml,<svg xmlns="http://www.w3.org/2000/svg" width="100" height="100" viewBox="0 0 100 100"><rect width="100" height="100" fill="%23f9fafb"/><path d="M0 0L50 50L100 0L100 50L50 100L0 50Z" fill="%23f3f4f6" opacity="0.5"/></svg>');
        }
        
        .features {
            padding: 80px 0;
            background: white;
        }
        
        .feature-card {
            text-align: center;
            padding: 30px;
            border-radius: 15px;
            transition: all 0.3s;
            height: 100%;
        }
        
        .feature-card:hover {
            background: var(--light);
            transform: translateY(-5px);
        }
        
        .feature-icon {
            width: 70px;
            height: 70px;
            background: linear-gradient(135deg, var(--primary) 0%, var(--primary-dark) 100%);
            border-radius: 15px;
            display: flex;
            align-items: center;
            justify-content: center;
            margin: 0 auto 20px;
            font-size: 30px;
            color: white;
        }
        
        .verify-section {
            padding: 60px 0;
            background: var(--light);
        }
        
        .footer {
            background: var(--dark);
            color: white;
            padding: 40px 0;
            text-align: center;
        }
        
        
        @media (max-width: 768px) {
            .hero h1 { font-size: 2.5rem; }
            .form-card { margin-top: -50px; padding: 25px; }
        }
        
        .sample-cert {
            max-width: 100%;
            border-radius: 10px;
            box-shadow: 0 5px 15px rgba(0,0,0,0.2);
            transition: transform 0.3s;
        }
        
        .sample-cert:hover {
            transform: scale(1.05);
        }
    </style>
</head>
<body>


    <!-- Form Section -->
    <section class="form-section">
        <div class="container">
            <div class="form-card">
                <h2 class="text-center mb-4">Create Your Certificate</h2>
                
                <?php if (isset($_GET['error']) && isset($_SESSION['error'])): ?>
                    <div class="alert alert-danger mb-4">
                        <strong>Error:</strong> <?php echo htmlspecialchars($_SESSION['error']); ?>
                        <?php unset($_SESSION['error']); ?>
                    </div>
                <?php endif; ?>
                
                <form id="certificateForm" method="POST" action="">
                    <input type="hidden" name="action" value="generate">
                    
                    <div class="row">
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-person-fill me-2"></i>Recipient Name
                            </label>
                            <input type="text" class="form-control" name="recipient_name" required 
                                   placeholder="John Smith" id="recipientName">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-book-fill me-2"></i>Course Name
                            </label>
                            <input type="text" class="form-control" name="course_name" required 
                                   placeholder="Advanced Web Development" id="courseName">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-person-badge-fill me-2"></i>Instructor Name
                            </label>
                            <input type="text" class="form-control" name="instructor_name" required 
                                   placeholder="Dr. Jane Doe" id="instructorName">
                        </div>
                        
                        <div class="col-md-6 mb-3">
                            <label class="form-label">
                                <i class="bi bi-calendar-fill me-2"></i>Issue Date
                            </label>
                            <input type="date" class="form-control" name="issue_date" required 
                                   value="<?php echo date('Y-m-d'); ?>" id="issueDate">
                        </div>
                    </div>
                    
                    <div class="text-center mt-4">
                        <button type="submit" class="btn btn-generate">
                            <i class="bi bi-download me-2"></i>Generate Certificate
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </section>



    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // No loading animation
    </script>
</body>
</html>