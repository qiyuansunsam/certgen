<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <style>
        @page {
            margin: 0;
            size: A4 landscape;
        }
        
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
        }
        
        body {
            font-family: 'Times New Roman', serif;
            background: white;
            width: 297mm;
            height: 210mm;
            position: relative;
            color: #2c3e50;
        }
        
        .certificate {
            width: 100%;
            height: 100%;
            position: relative;
            background: #ffffff;
            padding: 40px;
        }
        
        /* Border decoration */
        .border-frame {
            position: absolute;
            top: 20px;
            left: 20px;
            right: 20px;
            bottom: 20px;
            border: 3px solid #c9a961;
            background: white;
        }
        
        .inner-border {
            position: absolute;
            top: 30px;
            left: 30px;
            right: 30px;
            bottom: 30px;
            border: 1px solid #c9a961;
        }
        
        /* Content */
        .content {
            position: relative;
            z-index: 10;
            text-align: center;
            padding: 60px 80px;
            height: 100%;
            display: flex;
            flex-direction: column;
            justify-content: center;
        }
        
        .logo-section {
            margin-bottom: 30px;
        }
        
        .logo {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: #667eea;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: white;
            font-size: 36px;
            font-weight: bold;
        }
        
        .title {
            font-size: 42px;
            color: #2c3e50;
            margin-bottom: 20px;
            font-weight: normal;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        
        .subtitle {
            font-size: 18px;
            color: #7f8c8d;
            margin-bottom: 40px;
            font-style: italic;
        }
        
        .recipient-name {
            font-size: 48px;
            color: #2c3e50;
            margin: 30px 0;
            font-weight: bold;
            border-bottom: 2px solid #c9a961;
            display: inline-block;
            padding-bottom: 10px;
            letter-spacing: 1px;
        }
        
        .achievement-text {
            font-size: 20px;
            color: #5a6c7d;
            margin: 20px 0;
            line-height: 1.6;
        }
        
        .course-name {
            font-size: 32px;
            color: #34495e;
            margin: 20px 0;
            font-weight: bold;
            font-style: italic;
        }
        
        .date-section {
            margin-top: 40px;
            display: table;
            width: 100%;
        }
        
        .date-block, .instructor-block {
            display: table-cell;
            width: 50%;
            padding: 0 20px;
        }
        
        .signature-line {
            border-top: 2px solid #95a5a6;
            margin-top: 60px;
            padding-top: 10px;
        }
        
        .label {
            font-size: 14px;
            color: #7f8c8d;
            text-transform: uppercase;
            letter-spacing: 1px;
        }
        
        .value {
            font-size: 18px;
            color: #2c3e50;
            margin-top: 5px;
            font-weight: bold;
        }
        
        /* Decorative elements */
        .seal {
            position: absolute;
            bottom: 60px;
            right: 100px;
            width: 100px;
            height: 100px;
            background: #ffd700;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            box-shadow: 0 0 0 4px #c9a961, 0 0 0 6px #ffd700;
            font-size: 12px;
            font-weight: bold;
            color: #8b7500;
            text-align: center;
            z-index: 20;
        }
        
        
        .certificate-number {
            position: absolute;
            bottom: 40px;
            left: 50%;
            transform: translateX(-50%);
            font-size: 12px;
            color: #95a5a6;
            z-index: 20;
        }
        
        .stars {
            margin: 20px 0;
        }
        
        .star {
            display: inline-block;
            color: #ffd700;
            font-size: 24px;
            margin: 0 10px;
        }
    </style>
</head>
<body>
    <div class="certificate">
        <!-- Border elements -->
        <div class="border-frame"></div>
        <div class="inner-border"></div>
        
        
        <!-- Main content -->
        <div class="content">
            <!-- Logo -->
            <div class="logo-section">
                <div class="logo">CG</div>
            </div>
            
            <!-- Title -->
            <h1 class="title">Certificate of Achievement</h1>
            <p class="subtitle">This is to certify that</p>
            
            <!-- Recipient name -->
            <div class="recipient-name"><?php echo htmlspecialchars($recipient_name); ?></div>
            
            <!-- Stars decoration -->
            <div class="stars">
                <span class="star">★</span>
                <span class="star">★</span>
                <span class="star">★</span>
            </div>
            
            <!-- Achievement text -->
            <p class="achievement-text">has successfully completed the course</p>
            
            <!-- Course name -->
            <div class="course-name"><?php echo htmlspecialchars($course_name); ?></div>
            
            <p class="achievement-text">
                demonstrating exceptional dedication and mastery<br>
                of the subject matter
            </p>
            
            <!-- Date and Instructor -->
            <div class="date-section">
                <div class="date-block">
                    <div class="signature-line">
                        <div class="label">Date of Completion</div>
                        <div class="value"><?php echo date('F d, Y', strtotime($issue_date)); ?></div>
                    </div>
                </div>
                <div class="instructor-block">
                    <div class="signature-line">
                        <div class="label">Instructor</div>
                        <div class="value"><?php echo htmlspecialchars($instructor_name); ?></div>
                    </div>
                </div>
            </div>
        </div>
        
        <!-- Gold Seal -->
        <div class="seal">
            <div>
                VERIFIED<br>
                AUTHENTIC<br>
                ★
            </div>
        </div>
        
        <!-- Certificate Number -->
        <div class="certificate-number">
            Certificate No: <?php echo $cert_number; ?>
        </div>
    </div>
</body>
</html>