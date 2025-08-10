<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Certificate Generator</title>
    <link rel="stylesheet" href="assets/css/style.css">
</head>
<body>
    <!-- Loading Overlay -->
    <div class="loading" id="loading">
        <div class="spinner"></div>
    </div>

    <div class="container">
        <div class="form-card">
            <form id="certificateForm" method="POST" action="">
                <input type="hidden" name="action" value="generate">
                
                <div class="form-group">
                    <label class="form-label" for="recipient_name">Recipient Name</label>
                    <input type="text" class="form-control" id="recipient_name" name="recipient_name" required 
                           placeholder="John Smith">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="course_name">Course Name</label>
                    <input type="text" class="form-control" id="course_name" name="course_name" required 
                           placeholder="Web Development">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="instructor_name">Instructor Name</label>
                    <input type="text" class="form-control" id="instructor_name" name="instructor_name" required 
                           placeholder="Dr. Jane Doe">
                </div>
                
                <div class="form-group">
                    <label class="form-label" for="issue_date">Issue Date</label>
                    <input type="date" class="form-control" id="issue_date" name="issue_date" required 
                           value="<?php echo date('Y-m-d'); ?>">
                </div>
                
                <button type="submit" class="btn-generate">Generate Certificate</button>
            </form>
        </div>
    </div>

    <script src="assets/js/main.js"></script>
</body>
</html>