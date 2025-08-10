<?php

namespace App\Services;

use Dompdf\Dompdf;
use Dompdf\Options;

class PdfGenerator
{
    private $dompdf;
    private $options;

    public function __construct()
    {
        $this->options = new Options();
        $this->options->set('isHtml5ParserEnabled', true);
        $this->options->set('isPhpEnabled', true);
        $this->options->set('isRemoteEnabled', true);
        $this->options->set('defaultFont', 'serif');
        
        $this->dompdf = new Dompdf($this->options);
    }

    /**
     * Generate PDF certificate
     */
    public function generate(array $data)
    {
        // Extract variables for template
        extract($data);
        
        // Load and process template
        ob_start();
        include __DIR__ . '/../../templates/certificate_template.php';
        $html = ob_get_clean();
        
        // Generate PDF
        $this->dompdf->loadHtml($html);
        $this->dompdf->setPaper('A4', 'landscape');
        $this->dompdf->render();
        
        return $this->dompdf->output();
    }

    /**
     * Set custom options
     */
    public function setOptions(array $options)
    {
        foreach ($options as $key => $value) {
            $this->options->set($key, $value);
        }
        
        // Recreate dompdf with new options
        $this->dompdf = new Dompdf($this->options);
    }

    /**
     * Set paper size and orientation
     */
    public function setPaper($size = 'A4', $orientation = 'landscape')
    {
        $this->dompdf->setPaper($size, $orientation);
    }
}