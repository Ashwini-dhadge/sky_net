<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Mpdf\Mpdf;

class M_Pdf
{
    public function savePDF($html, $filename = '')
    {
        $CI = &get_instance();

        // 1. Create folder
        $folder = FCPATH . 'uploads/certificates/';

        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // 2. Full file path
        $full_path = $folder . $filename . '.pdf';

        // 3. mPDF config
        $mpdf = new Mpdf([
            'format' => 'A4-L',   // Landscape (like your certificate)
            'margin_top' => 10,
            'margin_bottom' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
        ]);

        // 4. Improve rendering quality
        $mpdf->useSubstitutions = true;
        $mpdf->simpleTables = true;
        $mpdf->packTableData = true;

        // 5. Write HTML
        $mpdf->WriteHTML($html);

        // 6. Save PDF to server
        $mpdf->Output($full_path, \Mpdf\Output\Destination::FILE);

        // 7. Return relative path (for DB)
        return 'uploads/certificates/' . $filename . '.pdf';
    }
}