<?php

$today = date("y_m_d");


ini_set('display_errors', TRUE);
ini_set('display_startup_errors', TRUE);
date_default_timezone_set('Europe/London');

if (PHP_SAPI == 'cli')
    die('This example should only be run from a Web Browser');

/** Include PHPExcel */
require_once dirname(__FILE__) . './PHPExcel-1.8/Classes/PHPExcel.php';


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
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Campaign Management');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Periodo: ' . $intervallo['giorno_start'] . "/" . $intervallo['mese_start'] . "/" . $intervallo['anno_start'] . "  -  "
        . $intervallo['giorno_end'] . "/" . $intervallo['mese_end'] . "/" . $intervallo['anno_end']);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Candara');
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
$objPHPExcel->getActiveSheet()->mergeCells('A3:m3');
$objPHPExcel->getActiveSheet()->setCellValue('A3', 'Attributi Campagna');
$objPHPExcel->getActiveSheet()->mergeCells('n3:q3');
$objPHPExcel->getActiveSheet()->setCellValue('n3', 'Attributi Comunicazione');
$objPHPExcel->getActiveSheet()->mergeCells('r3:af3');
$objPHPExcel->getActiveSheet()->setCellValue('r3', 'Attributi Canale');
$objPHPExcel->getActiveSheet()->mergeCells('ag3:bb3');
$objPHPExcel->getActiveSheet()->setCellValue('ag3', 'Criteri');
$riga = 4;
$colonna = 0;
/*
$titolo = array('N', 'Nome Campagna', 'Gruppo', 'Tipo', 'Dipartimento', 'Cod. campagna','Cod. comunicazione','Username', 'Ottimizzazione', 'Priorità PM', 'Data Inizio validità Offerta',
    'Data Fine validità Offerta', 'Leva', 'Descrizione leva', 'Stato', 'Lista preview', 'Lista civetta', 'Control group',
    'Perc. control group', 'Canale', 'Mod. invio', 'Sender', 'Storic.', 'Testo sms', 'Link', 'Durata sms', 'Data inizio',
    'Data fine', 'Durata campagna', 'Trial', 'Data trial', 'Volume trial', 'Perc. scostamento', 'Volume', 'Attivi', 'Sospesi',
    'Consumer', 'Business', 'Prepagato', 'Postpagato', 'Cons. profilazione', 'Cons. commerciale', 'checkboxAdesso3', 'Voce',
    'Dati', 'No frodi', 'No collection', 'ETF', 'VIP', 'Dipendenti', 'Trial', 'Parlanti ultimo/i', 'Profilo Rischio GA',
    'Profilo Rischio Standard', 'Profilo Rischio High Risk', 'Altri criteri');
 * 
 */
$titolo = array('N', 'Nome Campagna', 'Gruppo', 'Tipo', 'Dipartimento', 'Cod. campagna','Cod. comunicazione','Username', 'Priorità PM', 'Data Inizio validità Offerta',
    'Data Fine validità Offerta', 'Leva', 'Descrizione leva', 'Stato', 'Lista preview', 'Lista civetta', 'Control group',
    'Perc. control group', 'Canale', 'Mod. invio', 'Sender', 'Storic.', 'Testo sms', 'Link', 'Durata sms', 'Data inizio',
    'Data fine', 'Durata campagna', 'Trial', 'Data trial', 'Volume trial', 'Perc. scostamento', 'Volume', 'Attivi', 'Sospesi',
    'Consumer', 'Business', 'Prepagato', 'Postpagato', 'Cons. profilazione', 'Cons. commerciale', 'checkboxAdesso3', 'Voce',
    'Dati', 'No frodi', 'No collection', 'ETF', 'VIP', 'Dipendenti', 'Trial', 'Parlanti ultimo/i', 'Profilo Rischio GA',
    'Profilo Rischio Standard', 'Profilo Rischio High Risk', 'Altri criteri');

foreach ($titolo as $key => $value) {
    //$objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setAutoSize(true);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)
            ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
            ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
    $objPHPExcel->setActiveSheetIndex(0)
            ->setCellValueByColumnAndRow($colonna, $riga, $value);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
    $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB('FFDDDDDD');
    $colonna++;
}

$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 0, count($titolo), 2)->applyFromArray(
        array(
            'font' => array(
                'bold' => true
            ),
            'alignment' => array(
                'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_CENTER,
            ),
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFDDDDDD'
                )
            )
        )
);
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 3, 55, 4)->applyFromArray(
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
            )
        )
);
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(0, 3, 12, 4)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFFFA500'
                )
            )
        )
);
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(13, 3, 16, 4)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FFFFFF00'
                )
            )
        )
);
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(17, 3, 31, 4)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FF00FF00'
                )
            )
        )
);
$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow(32, 3, 55, 4)->applyFromArray(
        array(
            'fill' => array(
                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                'color' => array(
                    'argb' => 'FF00FFFF'
                )
            )
        )
);


$riga = 5;
$colonna = 0;
foreach ($data_output as $key => $value) {
    if (count($value) > 1) {
        foreach ($value as $key_record => $value_record) {
            
            
            $objPHPExcel->setActiveSheetIndex(0)
                    ->setCellValueByColumnAndRow($colonna, $riga, $value_record);
            //$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setWrapText(true);

            if ($colonna != 1) {
                $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(20);
                $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                        ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                ;
            }
            $colonna++;
        }
        $colonna = 0;
        $riga++;
    }
}
$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
$objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(120);
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(80);
$objPHPExcel->getActiveSheet()->setTitle('Export');
$objPHPExcel->setActiveSheetIndex(0);

// Redirect output to a client’s web browser (Excel2007)
header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
header('Content-Disposition: attachment;filename="' . $today . '_Export_gestione.xlsx"');
header('Cache-Control: max-age=0');
// If you're serving to IE 9, then the following may be needed
header('Cache-Control: max-age=1');

// If you're serving to IE over SSL, then the following may be needed
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT'); // Date in the past
header('Last-Modified: ' . gmdate('D, d M Y H:i:s') . ' GMT'); // always modified
header('Cache-Control: cache, must-revalidate'); // HTTP/1.1
header('Pragma: public'); // HTTP/1.0

$objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
$objWriter->save('php://output');
exit;

//echo json_encode($data_output);
?>
