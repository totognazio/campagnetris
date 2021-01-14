<?php

print_r($_SESSION);
$limit = ini_get('memory_limit');
ini_set('memory_limit', -1);
$today = date("y_m_d");

error_reporting(E_ALL);


include_once (__DIR__.'/db_config.php');
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once './classes/access_user/access_user_class.php';
include_once './classes/PHPExcel.php';
include_once './classes/PHPExcel/IOFactory.php';
/** PHPExcel_Cell_AdvancedValueBinder */
include_once './classes/PHPExcel/Cell/AdvancedValueBinder.php';

$funzioni_admin = new funzioni_admin();
$campaign = new campaign_class();
$page_protect = new Access_user;
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $page_protect->log_out(); // the method to log off
}


$filter = $_SESSION['filter'];

#echo'prima del render campagne dopo il get_filter';

$list = $campaign->getCampaigns($filter); 
    $tot_volume = $campaign->tot_volume();
    $tot_volume['totale'] = 0;
     
        $list_day = $campaign->daterange();

$totale = array();

ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');




// Create new PHPExcel object
$objPHPExcel = new PHPExcel();

// Set document properties
$objPHPExcel->getProperties()->setCreator("Tool Campaign")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
$objPHPExcel->getActiveSheet()->mergeCells('A1:e1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:e2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Pianificazione Campagne - Campaign Management');
$objPHPExcel->getActiveSheet()->setCellValue('A2', $dataSelezionata);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
//$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FF538DD5');
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
$objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFill()->getStartColor()->setARGB('FFDDDDDD');
$riga = 3;
$colonna = 0;


foreach ($list as $key => $value) {
    
            $tot_volume['totale'] = $tot_volume['totale'] + $row['volume'];
        $volume_giorno = $campaign->day_volume($row);   

    if ($colonna < 11)
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setAutoSize(true);;
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)
            ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow($colonna, $riga, $value);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB('FFDDDDDD');
    $colonna++;
}

$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 3, count($list_day) + 11, 4)->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ), 'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ), 'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ), 'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFDDDDDD'
                )
            )
        )
);
$riga = 4;
$colonna = 12;
foreach ($list_day as $key => $value) {
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(8);
    $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($colonna);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow($colonna, $riga, strtoupper($value));
    $colonna++;
}
//stampa valori campagne
//print_r($output_colore);
$riga = 5;
$colonna = 0;
$data_output = $output;
foreach ($data_output as $key => $value) {
    if (count($value) > 1) {
        foreach ($value as $key_record => $value_record) {
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow($colonna, $riga, $value_record);
            if ($colonna != 1) {
                $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                //echo $output_colore[$key][$key_record]."-----";
                //echo str_replace("#", "FF", $output_colore[$key][$key_record]);
                if ($output_colore[$key][$key_record] != '') {
                    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
                    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB(str_replace("#", "FF", $output_colore[$key][$key_record]));
                }
            }
            $colonna++;
        }
        $colonna = 0;
        $riga++;
    }
}

$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setAutoSize(true);
$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow(8, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

$objPHPExcel->setActiveSheetIndex(0)
        ->setCellValueByColumnAndRow(10, $riga, "TOTALE");
$colonna = 11;
foreach ($totale_giorno as $key => $value) {
    $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(8);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow($colonna, $riga, $value);
    $colonna++;
}

$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, $riga, count($list_day) + 11, $riga)->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'borders' => array(
                'top' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ), 'left' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ), 'right' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                ), 'bottom' => array(
                    'style' => PHPExcel_Style_Border::BORDER_THIN
                )
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFDDDDDD'
                )
            )
        )
);

//rimozione colonna Ottimizzazione
$objPHPExcel->getActiveSheet()->removeColumn('I');

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Export');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= export.xlsx');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;



//echo json_encode($data_output);
?>