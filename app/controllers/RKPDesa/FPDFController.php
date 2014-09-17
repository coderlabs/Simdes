<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 6/18/2014
 * Time: 13:15
 */

namespace RKPDesa;


use Anouar\Fpdf\Fpdf;

/**
 * Class FPDFController
 * @package RKPDesa
 */
class FPDFController extends Fpdf{

    /**
     *
     */
    public function Header(){
        // Select Arial bold 15
        $this->SetFont('Arial','B',15);
        // Move to the right
        $this->Cell(80);
        // Framed title
        $this->Cell(30,10,'Ini adalah Header',1,0,'C');
        // Line break
        $this->Ln(20);
    }


    /**
     *
     */
    public function Footer()
    {
        // Go to 1.5 cm from bottom
        $this->SetY(-15);
        // Select Arial italic 8
        $this->SetFont('Arial','I',8);
        // Print centered page number
        $this->Cell(0,10,'Page '.$this->PageNo(),0,0,'C');
    }
}