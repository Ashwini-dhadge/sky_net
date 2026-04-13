<?php
defined('BASEPATH') or exit('No direct script access allowed');

use Dompdf\Adapter\CPDF;
use Dompdf\Dompdf;
use Dompdf\Exception;

require_once(dirname(__FILE__) . '/dompdf/autoload.inc.php');

class Pdf
{
    function createPDF($html, $filename = '', $download = TRUE, $paper = 'A4', $orientation = 'portrait')
    {
        //   $dompdf = new Dompdf\DOMPDF(array('enable_remote' => true));
        define("DOMPDF_ENABLE_REMOTE", false);
        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();
        if ($download)
            $dompdf->stream($filename . '.pdf', array('Attachment' => 1));
        else
            $dompdf->stream($filename . '.pdf', array('Attachment' => 0));
    }

    //  function savePDF($html, $filename='', $download=TRUE, $paper='A4', $orientation='portrait'){
    //  //   $dompdf = new Dompdf\DOMPDF(array('enable_remote' => true));
    //     define("DOMPDF_ENABLE_REMOTE", false);
    //     $dompdf = new Dompdf(array('enable_remote' => true));
    //     $dompdf->load_html($html);
    //     $dompdf->set_paper($paper, $orientation);
    //     $dompdf->render();


    //     $pdfFilePath =COURSE_CERTIFICATE_MAIL."CERTI".time().".pdf"; 
    //     //save the pdf file on the server

    //     file_put_contents($pdfFilePath, $dompdf->output()); 
    //     $download_link=FCPATH.$pdfFilePath;
    //   //  FCPATH.'/cv_uploads/'.$pdfFilePath;
    //     return $download_link; 
    // }

    #By omkar - 2024-06-17
    function savePDF($html, $filename = '', $paper = 'A4', $orientation = 'landscape')
    {

        $dompdf = new Dompdf(array('enable_remote' => true));
        $dompdf->load_html($html);
        $dompdf->set_paper($paper, $orientation);
        $dompdf->render();

        // ✅ Define folder
        $folder = FCPATH . 'uploads/certificates/';

        // ✅ Create folder if not exists
        if (!is_dir($folder)) {
            mkdir($folder, 0777, true);
        }

        // ✅ Full path to save
        $full_path = $folder . $filename . '.pdf';

        // ✅ Save file
        file_put_contents($full_path, $dompdf->output());

        // ✅ Return relative path (important for DB)
        return 'uploads/certificates/' . $filename . '.pdf';
    }
}