<?php
/**
 * Header file
*/
use PhpOffice\PhpPresentation\Autoloader;
use PhpOffice\PhpPresentation\Settings;
use PhpOffice\PhpPresentation\IOFactory;
use PhpOffice\PhpPresentation\Slide;
use PhpOffice\PhpPresentation\PhpPresentation;
use PhpOffice\PhpPresentation\AbstractShape;
use PhpOffice\PhpPresentation\DocumentLayout;
use PhpOffice\PhpPresentation\Shape\Drawing;
use PhpOffice\PhpPresentation\Shape\RichText;
use PhpOffice\PhpPresentation\Shape\RichText\BreakElement;
use PhpOffice\PhpPresentation\Shape\RichText\TextElement;
use PhpOffice\PhpPresentation\Style\Alignment;
use PhpOffice\PhpPresentation\Style\Bullet;
use PhpOffice\PhpPresentation\Style\Color;
use PhpOffice\PhpPresentation\Style\Border;
use PhpOffice\PhpPresentation\Style\Fill;

error_reporting(E_ALL);
define('CLI', (PHP_SAPI == 'cli') ? true : false);
define('EOL', CLI ? PHP_EOL : '<br />');
define('SCRIPT_FILENAME', basename($_SERVER['SCRIPT_FILENAME'], '.php'));
define('IS_INDEX', SCRIPT_FILENAME == 'index');

require_once __DIR__ . '/PHPPresentation-master/src/PhpPresentation/Autoloader.php';
\PhpOffice\PhpPresentation\Autoloader::register();
require_once __DIR__ . '/PHPPresentation-master/src/Common/Autoloader.php';
\PhpOffice\Common\Autoloader::register();



//$color == 'FF21B8C6' carta da zucchero
//$color == 'FF21B8C6'
// FF0070C0 blu scuro 


class phpPowerClass {

    var $color = array();
    var $objPHPPowerPoint;
    

    function __construct() {
        $this->objPHPPowerPoint = new PhpPresentation();
        $this->objPHPPowerPoint->getLayout()->setDocumentLayout(DocumentLayout::LAYOUT_WIND3, true);
        /*
        $this->objPHPPowerPoint->getProperties()->setCreator("DevicePerformances")
                ->setLastModifiedBy("Ignazio Toto")
                ->setTitle("Wind3 device performances")
                ->setSubject("Office 2007 PPTX Test Document")
                ->setDescription("Test document for Office 2007 PPTX, generated by DevicePerformances.")
                ->setKeywords("Statistiche")
                ->setCategory("Test result file");
                #->setHeight(14,28*38)
                #->setWidth(25,4*38);
         * 
         */
        $this->objPHPPowerPoint->removeSlideByIndex(0);
        #$this->color = Array('smartphone'=>'FF00B0F0', 'featurephone'=>'FF0066ff', 'phablet'=>'FF7030A0', 'tablet'=>'FFFF9900', 'datacard'=>'FF33CC33', 'router'=>'FFBF0000', 'samsung'=>'FF003B89', 'other'=>'FF7F7F7F', 'apple'=>'FFD9D9D9', 'smartphone'=>'FFA6C96A', 'huawei'=>'FFFF0000', 'wiko'=>'FF009900');
        $this->color = Array('FF00B0F0', 'FF0066ff', 'FF7030A0', 'FFFF9900', 'FF33CC33', 'FFBF0000', 'FF003B89', 'FF7F7F7F', 'FFD9D9D9', 'FFA6C96A');
    }

    
    
    function createFirstSlide() {
        $slide = $this->objPHPPowerPoint->createSlide();
        
          // Add logo
        /*
          $slide->createDrawingShape()
          ->setName('PHPPowerPoint logo')
          ->setDescription('PHPPowerPoint logo')
          ->setPath('./images/wind3_logo.jpg')
          ->setHeight(40)
          ->setOffsetX(10)
          ->setOffsetY(720 - 10 - 40);
        */
          
        // Return slide
        return $slide;
    }
    
        function createSlide() {
        $slide = $this->objPHPPowerPoint->createSlide();
        
          // Add logo
          $slide->createDrawingShape()
          ->setName('PHPPowerPoint logo')
          ->setDescription('PHPPowerPoint logo')
          ->setPath('./images/w3new.jpg') 
          ->setHeight(40)
          ->setOffsetX(10)
          ->setOffsetY(720 - 10 - 40);
        
          
        // Return slide
        return $slide;
    }
   
    
   function set_widescreen($slide) {
        $pptlayout = new DocumentLayout();
        $pptlayout->setDocumentLayout(DocumentLayout::LAYOUT_WIND3);
        $slide = $this->objPHPPowerPoint->setLayout($pptlayout);  
        return $slide;
   }            
    
    
    

    function add_photo($slide, $url_photo, $altezza, $offsetX, $offsetY) {
        $slide->createDrawingShape()
                ->setName('Wind3 logo')
                ->setDescription('Wind3 logo')
                ->setPath($url_photo)
                ->setHeight($altezza)
                ->setOffsetX($offsetX)
                ->setOffsetY($offsetY);
              return $slide;
    }

    function createBarChart3D($matrice, $serieDati) {
        $bar3DChart = new PHPPowerPoint_Shape_Chart_Type_Bar3D();

        for ($i = 0; $i < count($serieDati); $i++) {
            $series1 = new PHPPowerPoint_Shape_Chart_Series($serieDati[$i][0], $matrice[$i]);
            $series1->setShowSeriesName(false);
            $series1->getFont()->getColor()->setRGB($value[1]);

            //$series1->getDataPointFill(2)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color('FF00FF00'));
            $bar3DChart->addSeries($series1);
        }
        return $bar3DChart;
    }

    function createTable($currentSlide, $matrice, $larghezza, $altezza, $offsetX, $offsetY, $dimensione_carattere = 14, $color = 'FF0070C0', $line = 7, $altezza_righe = 25, $text_align = 'ctr', $tipo_carattere = "Arial") {
        
        $shape = $currentSlide->createTableShape(count($matrice[0]));
        $shape->setHeight($altezza);
        $shape->setWidth($larghezza);
        $shape->setOffsetX($offsetX);
        $shape->setOffsetY($offsetY);
        $row = $shape->createRow();
        $row->setHeight($altezza_righe);

        if ($color == "none")
            $row->getFill()->setFillType(Fill::FILL_NONE)
                    ->setRotation(90);
        else
            $row->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
                    ->setRotation(90)
                    ->setStartColor(new Color($color))
                    ->setEndColor(new Color($color));
        //$row->

        for ($i = 0; $i < count($matrice[0]); $i++) {
            if (($color == 'FF00B0F0') || ($color == 'FF33CC33') || ($color == 'FF21B8C6')|| ($color == 'FF0070C0') )
                $cell = $row->nextCell()
                        ->createTextRun($matrice[0][$i])
                        ->getFont()
                        ->setBold(false)
                        ->setName($tipo_carattere)
                        ->setSize($dimensione_carattere)
                        ->setColor(new Color('ffffffff'));
            else
                $cell = $row->nextCell()
                        ->createTextRun($matrice[0][$i])
                        ->getFont()
                        ->setBold(false)
                        ->setName($tipo_carattere)
                        ->setSize($dimensione_carattere)
                        ->setColor(new Color('ff000000'));
        }
        foreach ($row->getCells() as $cell) {
            if ($color != "none") {
                $cell->getBorders()->getTop()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                $cell->getBorders()->getLeft()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                $cell->getBorders()->getRight()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                $cell->getBorders()->getBottom()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
            } else {
                $cell->getBorders()->getTop()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_NONE);
                $cell->getBorders()->getLeft()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_NONE);
                $cell->getBorders()->getRight()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_NONE);
                $cell->getBorders()->getBottom()->setLineWidth($line)
                        ->setLineStyle(Border::LINE_NONE);
            }
        }
        if (count($matrice)) {
            for ($righe = 1; $righe < count($matrice); $righe++) {
                $row = $shape->createRow();
                $row->setHeight($altezza_righe);
                $row->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
                        ->setStartColor(new Color('FFF2F2F2'))
                        ->setEndColor(new Color('FFF2F2F2'));
                for ($colonne = 0; $colonne < count($matrice[$righe]); $colonne++) {
                    $cell = $row->nextCell()
                            ->createTextRun($matrice[$righe][$colonne])
                            ->getFont()
                            ->setBold(false)
                            ->setName($tipo_carattere)
                            ->setSize($dimensione_carattere)
                            ->setColor(new Color('ff000000'));
                }
                foreach ($row->getCells() as $cell) {
                    $cell->getBorders()->getTop()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                    $cell->getBorders()->getLeft()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                    $cell->getBorders()->getRight()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                    $cell->getBorders()->getBottom()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                }
            }
        }
    }
    function createTableSummary($currentSlide, $matrice, $larghezza, $altezza, $offsetX, $offsetY, $dimensione_carattere = 14, $color = 'FF0070C0', $line = 7, $altezza_righe = 25, $text_align = 'ctr', $tipo_carattere = "Arial") {
        
        $shape = $currentSlide->createTableShape(count($matrice[0]));
        $shape->setHeight($altezza);
        $shape->setWidth($larghezza);
        $shape->setOffsetX($offsetX);
        $shape->setOffsetY($offsetY);
        #$row = $shape->createRow();

// Get the first cell
#$cellA1 = $row->getCell(0);
// Get the second cell
#$cellA2 = $row->getCell(1);

        
#$cellA1 = $row->nextCell();
#$cellA1->setWidth(100);
#$cellA2 = $row->nextCell();
#$cellA2->setWidth(100);
   
            for ($righe = 0; $righe < count($matrice); $righe++) {
                $row = $shape->createRow();
                $row->setHeight($altezza_righe);
                $row->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
                        ->setStartColor(new Color('FFF2F2F2'))
                        ->setEndColor(new Color('FFF2F2F2'));
                

                
                for ($colonne = 0; $colonne < count($matrice[$righe]); $colonne++) {

                    //prima colonna prende il colore parametro
                        if($colonne==0){
                                $cellA1 = $row->nextCell();
                                $cellA1->setWidth(200);
                                $cellA1->getActiveParagraph()->getAlignment()
                                            #->setMarginBottom(20)
                                            ->setMarginLeft(10)
                                            #->setMarginRight(60)
                                            ->setMarginTop(2);
                                $cellA1->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
                                ->setStartColor(new Color($color))
                                ->setEndColor(new Color($color));
                            $cellA1->createTextRun($matrice[$righe][0])
                                        ->getFont()
                                        ->setBold(true)
                                        ->setName($tipo_carattere)
                                        ->setSize($dimensione_carattere)
                                        ->setColor(new Color('ffffffff'));//colore font Bianco
                        }
                        //tutte le colonne dopo la prima hanno il colore di default
                        else{
                            $cell = $row->nextCell()
                                        ->setWidth(328)
                                        ->createTextRun($matrice[$righe][$colonne])
                                        ->getFont()
                                        ->setBold(false)
                                        ->setName($tipo_carattere)
                                        ->setSize($dimensione_carattere)
                                        ->setColor(new Color('ff000000'));//colore font nero
                        }   
 
                } 
                foreach ($row->getCells() as $cell) {
                    $cell->getBorders()->getTop()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                    $cell->getBorders()->getLeft()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                    $cell->getBorders()->getRight()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                    $cell->getBorders()->getBottom()->setLineWidth($line)
                            ->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
                }
            }

    }

    function createline3D($matrice, $serieDati) {
        $lineChart = new PHPPowerPoint_Shape_Chart_Type_Line();
        for ($i = 0; $i < count($serieDati); $i++) {
            $series1 = new PHPPowerPoint_Shape_Chart_Series($serieDati[$i][0], $matrice[$i]);
            $series1->setShowSeriesName(false);
            $lineChart->addSeries($series1);
        }
        return $lineChart;
    }

    function createline3D_addserie($matrice, $serie_name, $percentage = false, $y_format = '') {
        $line3D = new PHPPowerPoint_Shape_Chart_Type_Line();
        foreach ($serie_name as $key => $value) {
            $series1 = new PHPPowerPoint_Shape_Chart_Series($value, $matrice[$key]);
            $series1->setShowSeriesName(FALSE);
            $series1->setShowPercentage($percentage);
            $series1->setShowValue(false);
            $series1->setShowLeaderLines(true);
            //$series1->setLabelPosition('t');
            for ($i = 0; $i < count($serie_name); $i++) {
                $series1->getDataPointFill($i)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($this->color[$i]))->setEndColor(new Color($this->color[$i]));
            }
            $series1->getFont()->setBold(false)->setName('Arial')
                    ->setSize(10)
                    ->setColor(new Color('00000000'));
            $line3D->addSeries($series1);
        }
        return $line3D;
    }

    function create_scatter3D_addserie($matrice, $serie_name, $percentage = false, $y_format = '') {
        $scatter = new PHPPowerPoint_Shape_Chart_Type_Scatter();
        foreach ($serie_name as $key => $value) {
            $series1 = new PHPPowerPoint_Shape_Chart_Series($value, $matrice[$key]);
            $series1->setShowSeriesName(FALSE);
            $series1->setShowPercentage($percentage);
            $series1->setShowValue(false);
            $series1->setShowLeaderLines(true);
            //$series1->setLabelPosition('t');
            for ($i = 0; $i < count($serie_name); $i++) {
                $series1->getDataPointFill($i)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($this->color[$i]));
            }
            $series1->getFont()->setBold(false)->setName('Arial')
                    ->setSize(10)
                    ->setColor(new Color('00000000'));
            $scatter->addSeries($series1);
        }
        return $scatter;
    }

    function createPie3D_addserie($matrice, $serie_name) {
        $pie3DChart = new PHPPowerPoint_Shape_Chart_Type_Pie3D();
        $series1 = new PHPPowerPoint_Shape_Chart_Series($serie_name, $matrice);
        $series1->setShowSeriesName(false);
        $series1->setShowPercentage(TRUE);
        $series1->setShowValue(FALSE);
        $series1->setLabelPosition('inEnd');

        $series1->getFont()->setBold(false)->setName('Arial')
                ->setSize(12)
                ->setColor(new Color('ffffffff'));
        for ($i = 0; $i < count($matrice); $i++) {
            $series1->getDataPointFill($i)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($this->color[$i]));
        }
        $pie3DChart->addSeries($series1);
        return $pie3DChart;
    }
    
    function createPie_addserie($matrice, $serie_name) {
        $pieChart = new PHPPowerPoint_Shape_Chart_Type_Pie();
        $series1 = new PHPPowerPoint_Shape_Chart_Series($serie_name, $matrice);
        $series1->setShowSeriesName(false);
        $series1->setShowPercentage(TRUE);
        $series1->setShowValue(FALSE);
        $series1->setLabelPosition('inEnd');

        $series1->getFont()->setBold(false)->setName('Arial')
                ->setSize(12)
                ->setColor(new Color('ffffffff'));
        for ($i = 0; $i < count($matrice); $i++) {
            $series1->getDataPointFill($i)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($this->color[$i]));
        }
        $pieChart->addSeries($series1);
        return $pieChart;
    }

    function createBar3D_addserie($matrice, $serie_name, $percentage = false, $y_format = '') {
        $bar3DChart = new PHPPowerPoint_Shape_Chart_Type_Bar3D();
        $bar3DChart->setFormatCode($y_format);
        foreach ($serie_name as $key => $value) {
            $series1 = new PHPPowerPoint_Shape_Chart_Series($value, $matrice[$key]);
            $series1->setShowSeriesName(FALSE);
            $series1->setShowPercentage($percentage);
            $series1->setShowValue(true);
            $series1->setShowLeaderLines(true);

            //$series1->setLabelPosition('t');
            /* for ($i = 0; $i < count($serie_name); $i++) {
              $series1->getDataPointFill($i)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($this->color[$i]))->setEndColor(new Color($this->color[$i]));
              } */
            $series1->getFont()->setBold(false)->setName('Arial')
                    ->setSize(9)
                    ->setColor(new Color('00000000'));
            $bar3DChart->addSeries($series1);
        }
        /* $series1 = new PHPPowerPoint_Shape_Chart_Series($serie_name, $matrice);

          for ($i = 0; $i < count($matrice); $i++) {
          $series1->getDataPointFill($i)->setFillType(Fill::FILL_SOLID)->setStartColor(new Color($this->color[$i]));
          } */
        /*
          $series1 = array('Jan' => 133, 'Feb' => 99, 'Mar' => 191, 'Apr' => 205, 'May' => 167, 'Jun' => 201, 'Jul' => 240, 'Aug' => 226, 'Sep' => 255, 'Oct' => 264, 'Nov' => 283, 'Dec' => 293);
          $series2Data = array('Jan' => 266, 'Feb' => 198, 'Mar' => 271, 'Apr' => 305, 'May' => 267, 'Jun' => 301, 'Jul' => 340, 'Aug' => 326, 'Sep' => 344, 'Oct' => 364, 'Nov' => 383, 'Dec' => 379);
          $bar3DChart->addSeries(new PHPPowerPoint_Shape_Chart_Series('2009', $series1));
          $bar3DChart->addSeries(new PHPPowerPoint_Shape_Chart_Series('2010', $series2Data)); */
        return $bar3DChart;
    }

    function createChart($tipo_funzione, $currentSlide, $nome, $matrice, $serie_name, $larghezza, $altezza, $offsetX, $offsetY, $percentage = false, $y_format = '', $minValue = NULL, $legendPosition = 'r', $rapportoAltezza = 60, $legend_char = '10', $legend = true) {
        /* echo "<br>";
          print_r($matrice);
          echo "<br>";
          print_r($serie_name);
          echo "<br>";
         */
        $shape = $currentSlide->createChartShape();
        $shape->setName($nome)
                ->setResizeProportional(false)
                ->setHeight($altezza)
                ->setWidth($larghezza)
                ->setOffsetX($offsetX)
                ->setOffsetY($offsetY);
        $shape->getShadow()->setVisible(false)
                ->setDirection(45)
                ->setDistance(0);
        $shape->getTitle()->setVisible(false)->setText($nome);
        //$shape->getBorder()->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FF00B0F0'));
        if ($tipo_funzione == "Pie3D") {

            $shape->getPlotArea()->setType($this->createPie3D_addserie($matrice, $serie_name));
            $shape->getPlotArea()->getAxisX()->setFormatCode('0,0%');
            $shape->getPlotArea()->getAxisY()->setFormatCode('0,0%');
            $shape->getView3D()->setRotationX(90);
            $shape->getView3D()->setDepthPercent(90);
        }
        elseif ($tipo_funzione == "Pie") {

            $shape->getPlotArea()->setType($this->createPie_addserie($matrice, $serie_name));
            $shape->getPlotArea()->getAxisX()->setFormatCode('0,0%');
            $shape->getPlotArea()->getAxisY()->setFormatCode('0,0%');
            $shape->getView3D()->setRotationX(90);
            $shape->getView3D()->setDepthPercent(90);

        } elseif ($tipo_funzione == "Shape3D") {
            $shape->getView3D()->setRotationX(90);
            $shape->getView3D()->setDepthPercent(90);
            $shape->getPlotArea()->setType($this->create_scatter3D_addserie($matrice, $serie_name));
        } elseif ($tipo_funzione == "Bar3D") {
            $shape->getView3D()->setHeightPercent($rapportoAltezza);

            $shape->getPlotArea()->getAxisX()->setTitle('X Axis!')->setFormatCode($y_format);
            $shape->getPlotArea()->getAxisY()->setTitle('Y Axis!')->setFormatCode($y_format)->setMinValue($minValue);
            $shape->getPlotArea()->setType($this->createBar3D_addserie($matrice, $serie_name, $percentage, $y_format));
        } else {
            $shape->getView3D()->setRotationX(90);
            $shape->getView3D()->setDepthPercent(90);
            $shape->getPlotArea()->getAxisX()->setTitle('X Axis!')->setFormatCode($y_format);
            $shape->getPlotArea()->getAxisY()->setTitle('Y Axis!')->setFormatCode($y_format)->setMinValue($minValue);
            $shape->getPlotArea()->setType($this->createline3D_addserie($matrice, $serie_name, $percentage, $y_format));
        }


        $shape->getView3D()->setPerspective(0);

        $shape->getLegend()->getBorder()->setLineStyle(Border::LINE_SINGLE)->setColor(new Color('FFFFFFFF'));
        $shape->getLegend()->getFont()->setName('Arial')
                ->setSize($legend_char);
        $shape->getLegend()->setPosition($legendPosition);
        if (!$legend) {
            $shape->getLegend()->setVisible(false);
        }
        return $shape;
    }

    function save($mese = "") {

        $objWriter = IOFactory::createWriter($this->objPHPPowerPoint, 'PowerPoint2007');
        #$objWriter->setLayoutPack(new PHPPowerPoint_Writer_PowerPoint2007_LayoutPack_TemplateBased('./template.pptx'));

        $today = date("Ymd");
        $filename = 'Wind3-TH-' .$mese . ' Device performance_' . $today . '.pptx';
        $objWriter->save($filename);
        header("Pragma: no-cache");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Content-Type: application/force-download");
        //header("Content-Type: application/octet-stream");
        header("Content-Type: application/download");
        header("Content-Disposition: attachment;filename=" . $filename);
        ob_clean();
        flush();
        readfile($filename);
    }
    
    function save_new($title = "") {
        $today = date("Ymd");
        $filename = $title . '_' . $today . '.pptx';
// Redirect output to a client’s web browser
header('Content-Type: application/vnd.openxmlformats-officedocument.presentationml.presentation');
header('Content-Disposition: attachment;filename="' . $filename . '"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header ('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header ('Last-Modified: '.gmdate('D, d M Y H:i:s').' GMT'); // always modified
header ('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header ('Pragma: public'); // HTTP/1.0

$objWriter = IOFactory::createWriter($this->objPHPPowerPoint, 'PowerPoint2007');
$objWriter->save('php://output');
        
    }
    
    function save_template_summary($mese = "") {
        $pptReader = IOFactory::createReader('PowerPoint2007');
        $pptLoad = $phpPower->load('./template_summary.pptx');

        $objWriter = IOFactory::createWriter($this->objPHPPowerPoint, 'PowerPoint2007');
        #$objWriter->setLayoutPack(new PHPPowerPoint_Writer_PowerPoint2007_LayoutPack_TemplateBased('./template_summary.pptx'));
        
        #$pptReader = IOFactory::createReader('PowerPoint2007');
        #$pptLoad = $phpPower->load('pdf.pptx');
        
        $today = date("y_m_d");
        $filename = 'Wind3-TH-' . $mese . ' Device performance_' . $today . '.pptx';
        $objWriter->save($filename);
        
    }

    function create_title($titolo_slide, $current_slide, $dimensione_carattere = 36, $bold = false) {
        $shape = $current_slide->createRichTextShape();
        $shape->setHeight(cmTopixel(1,45))
                ->setWidth(cmTopixel(27,15))
                ->setOffsetX(cmTopixel(2,88))
                ->setOffsetY(cmTopixel(0,17));
        if (strlen($titolo_slide) > 40)
            $dimensione_carattere = $dimensione_carattere - 4;
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $textRun = $shape->createTextRun($titolo_slide);
        $textRun->getFont()->setBold($bold)->setName('Arial')
                ->setSize($dimensione_carattere)
                ->setColor(new Color('ff000000'));
    }

    function create_text_area($current_slide, $titolo_slide, $larghezza, $altezza, $offsetX, $offsetY, $dimensione_carattere = 14, $color_text = 'FF000000', $color_background = 'FFFFFFFF') {
        $shape = $current_slide->createRichTextShape();
        $shape->getFill()->setFillType(Fill::FILL_GRADIENT_LINEAR)
                ->setRotation(90)
                ->setStartColor(new Color($color_background))
                ->setEndColor(new Color($color_background));
        $shape->setHeight($altezza)
                ->setWidth($larghezza)
                ->setOffsetX($offsetX)
                ->setOffsetY($offsetY);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $textRun = $shape->createTextRun($titolo_slide);
        $textRun->getFont()->setBold(false)->setName('Arial')
                ->setSize($dimensione_carattere)
                ->setColor(new Color($color_text));
    }

    function insert_testo($testo, $current_slide, $dimensione, $larghezza, $altezza, $offsetX, $offsetY) {
        $shape = $current_slide->createRichTextShape();
        $shape->setHeight($altezza)
                ->setWidth($larghezza)
                ->setOffsetX($offsetX)
                ->setOffsetY($offsetY);
        $shape->getActiveParagraph()->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);

        $textRun = $shape->createTextRun($testo);
        $textRun->getFont()->setBold(false)->setName('Arial')
                ->setSize($dimensione)
                ->setColor(new Color('00000000'));
    }

}

?>