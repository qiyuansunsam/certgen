/**
 * Certificate Generator - Main JavaScript
 * Handles form submissions and certificate verification
 */

class CertificateGenerator {
    constructor() {
        this.init();
    }

    init() {
        this.bindEvents();
    }

    bindEvents() {
        // Form submission with loading
        const certificateForm = document.getElementById('certificateForm');
        if (certificateForm) {
            certificateForm.addEventListener('submit', this.handleFormSubmit.bind(this));
        }

        // Certificate verification
        const verifyForm = document.getElementById('verifyForm');
        if (verifyForm) {
            verifyForm.addEventListener('submit', this.handleVerifySubmit.bind(this));
        }
    }

    handleFormSubmit(e) {
        this.showLoading();
    }

    handleVerifySubmit(e) {
        e.preventDefault();
        
        const certNumber = document.getElementById('verifyCertNumber').value.trim();
        
        if (!certNumber) {
            alert('Please enter a certificate number');
            return;
        }

        this.verifyCertificate(certNumber);
    }

    async verifyCertificate(certNumber) {
        try {
            const response = await fetch('index.php', {
                method: 'POST',
                headers: {'Content-Type': 'application/x-www-form-urlencoded'},
                body: 'action=verify&certificate_number=' + encodeURIComponent(certNumber)
            });

            if (!response.ok) {
                throw new Error('Network response was not ok');
            }

            const data = await response.json();
            this.displayVerificationResult(data);
        } catch (error) {
            console.error('Error verifying certificate:', error);
            this.displayError('An error occurred while verifying the certificate. Please try again.');
        }
    }

    displayVerificationResult(data) {
        const resultDiv = document.getElementById('verifyResult');
        
        if (data.error) {
            resultDiv.innerHTML = '<div class="alert alert-danger">Certificate not found</div>';
        } else {
            resultDiv.innerHTML = `
                <div class="alert alert-success">
                    <h4>Valid Certificate</h4>
                    <p><strong>Recipient:</strong> ${this.escapeHtml(data.recipient_name)}</p>
                    <p><strong>Course:</strong> ${this.escapeHtml(data.course_name)}</p>
                    <p><strong>Issue Date:</strong> ${this.escapeHtml(data.issue_date)}</p>
                </div>`;
        }
    }

    displayError(message) {
        const resultDiv = document.getElementById('verifyResult');
        resultDiv.innerHTML = `<div class="alert alert-danger">${this.escapeHtml(message)}</div>`;
    }

    showLoading() {
        const loading = document.getElementById('loading');
        if (loading) {
            loading.classList.add('show');
        }
    }

    hideLoading() {
        const loading = document.getElementById('loading');
        if (loading) {
            loading.classList.remove('show');
        }
    }

    escapeHtml(text) {
        const map = {
            '&': '&amp;',
            '<': '&lt;',
            '>': '&gt;',
            '"': '&quot;',
            "'": '&#039;'
        };
        return text.replace(/[&<>"']/g, function(m) { return map[m]; });
    }
}

// Initialize when DOM is loaded
document.addEventListener('DOMContentLoaded', function() {
    new CertificateGenerator();
});
