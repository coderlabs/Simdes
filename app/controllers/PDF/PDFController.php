<?php
/**
 * Email: edicyber@gmail.com
 * User: Edi Santoso
 * Date: 5/26/2014
 * Time: 21:38
 */

namespace PDF;


use Barryvdh\Snappy\Facades\SnappyPdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Input;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\View;
use Knp\Snappy\Pdf;

class PDFController extends \BaseController{
    private $pdf;
    private $snappyPdf;
    public function __construct(Pdf $pdf, SnappyPdf $snappyPdf){
        $this->pdf = $pdf;
        $this->snappyPdf = $snappyPdf;
    }
    
    public function rka(){
        $myProjectDirectory = '/path/to/my/project';

        $snappy = new Pdf($myProjectDirectory . '/vendor/h4cc/wkhtmltopdf-i386/bin/wkhtmltopdf-i386');

    }
    
    public function read(){
        
    }
    
    public function store(){
    
    }
    
    public function edit(){
    
    }
    
    public function update(){
    
    }
    
    public function destroy(){
    
    }
}