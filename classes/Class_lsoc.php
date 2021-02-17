<?php
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';


class Class_lsoc extends funzioni_admin { 

    

    

function export_pianificazione($list, $tot_volume, $list_day, $filter){ 
        
        $campaign = new campaign_class();
             /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
 
        $objPHPExcel = new PHPExcel();   
        // Set document properties
$objPHPExcel->getProperties()->setCreator("Tool Campaign")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Pianificazione Campagne');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dal '.$filter['startDate'].' Al '.$filter['endDate']);
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
    $titolo = array('N', 'Stack', 'Sprint', 'Squad', 'Nome Campagna','Tipologia', 'Cod. campagna','Cod. comunicazione', 'Canale', 'Data inizio', 'Stato', 'Vol.(k)');
    $tot_colonne = count($list_day) + count($titolo) - 1;

    foreach ($titolo as $key => $value) {
    if ($colonna < 11)
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)
                ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga, $value);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB('FFDDDDDD');
        //$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->getStartColor()->setARGB('FFDDDDDD');
        $colonna++;
        
    }

    //tutta la riga 3
    $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow(0, 3, $tot_colonne, 3)->applyFromArray(
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

    $riga = 3;
    $colonna = 12;
    foreach ($list_day as $key => $value) {
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(8);
        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($colonna);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga, strtoupper($value));
        $colonna++;
    }
    //stampa valori campagne
    //print_r($output_colore);
    $riga = 4;
    $colonna = 0;

    //array riga volume totale
    $tot_volume = $campaign->tot_volume();
    $tot_volume['totale'] = 0;


    foreach ($list as $key => $row) {
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $riga, $key+1);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $riga, $row['stacks_nome']);    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $riga, $campaign->sprint_find($row['data_inizio']));        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $riga, $row['squads_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $riga, $row['pref_nome_campagna']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $riga, $row['tipo_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $riga, $row['cod_campagna']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $riga, $row['cod_comunicazione']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, $riga, $campaign->tableChannelLabel($row));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, $riga, $row['data_inizio']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $riga, $row['campaign_stato_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, round($row['volume']/1000));

            
            $tot_volume['totale'] = $tot_volume['totale'] + $row['volume'];
            $volume_giorno = $campaign->day_volume($row);        
            $daterange = $campaign->daterange();
            //print_r($volume_giorno);
            //print_r($daterange);
        $colonna = 11;
            foreach($daterange as $key=>$daytimestamp){
                    $colonna++;
                    if(array_key_exists($daytimestamp, $volume_giorno)){                   
                        //$string .= "<td  class=\"valore\" bgcolor=\"".$row['colore']."\"><small><strong><font color=\"black\">".$campaign->round_volume($volume_giorno[$daytimestamp])."<font></strong><small></td>";                   
                        //manca il coloreeeee
                        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(8);
                        $objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($colonna);
                        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga, round($volume_giorno[$daytimestamp]/1000));
                        $tot_volume[$daytimestamp] =  $tot_volume[$daytimestamp] + $volume_giorno[$daytimestamp];
                        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB('FFDDDDDD');
                        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB(str_replace("#", "FF", $row['colore']));
                        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga,$colonna, $riga)->getFill()->getStartColor()->setARGB(str_replace("#", "FF", $row['colore']));
                        $colore = ''.str_replace("#", "FF", $row['colore']).'';
                        $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow($colonna, $riga, $colonna, $riga)->applyFromArray(
                                array(

                                    'fill' => array(
                                        'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                        'color' => array(
                                            'argb' => $colore
                                        )
                                    )
                                )
                        );
                        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB('FFDDDDDD');
                    } 
                    else {
                        //$string .= "<td" .$campaign->bgcolor($daytimestamp)."><small></small></td>";
                        //manca il coloreeeee                    
                        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga,'');
                        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB($campaign->bgcolorExcel($daytimestamp));
                        if($campaign->bgcolor_sun($daytimestamp)){
                                $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow($colonna, $riga, $colonna, $riga)->applyFromArray(
                                array(

                                            'fill' => array(
                                                'type' => PHPExcel_Style_Fill::FILL_SOLID,
                                                'color' => array(
                                                    'argb' => 'FF808080' //gray
                                                )
                                            )
                                        )
                                );

                        }


                    }
            }
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(8)->setAutoSize(true);
            $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow(8, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
    
            $riga++;

        }
        
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $riga, $riga);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $riga, 'Totale');
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, round($tot_volume['totale']/100,1));
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(8);
            $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow(11, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
            $colonna = 11;
        foreach($daterange as $key=>$daytimestamp){
            $colonna++;
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(8);
            $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //$string .= "<td><small><strong>".$campaign->round_volume($tot_volume[$daytimestamp])."</strong></small></td>";
            if($tot_volume[$daytimestamp]>0){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga, round($tot_volume[$daytimestamp]/1000,1));
            }
            
        }
        



    $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow(0, $riga, $tot_colonne, $riga)->applyFromArray(
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


    // Rename worksheet
    $objPHPExcel->getActiveSheet()->setTitle('Export');


    // Set active sheet index to the first sheet, so Excel opens this as the first sheet
    $objPHPExcel->setActiveSheetIndex(0);
    $today = date("Ymd");

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $today . '_Export_PianificazioneCampagne.xlsx"');
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
    
}


function export_gestione($list, $filter){ 
        // Set document properties
        $campaign = new campaign_class();
        $today = date("Ymd");

        $objPHPExcel = new PHPExcel();
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
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dal '.$filter['startDate'].' Al '.$filter['endDate']);
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

$titolo = array('N', 'Nome Campagna', 'Gruppo', 'Tipo', 'Dipartimento', 'Cod. campagna','Cod. comunicazione','Username', 'Priorità PM', 'Data Inizio validità Offerta',
    'Data Fine validità Offerta', 'Leva', 'Descrizione leva', 'Stato', 'Lista preview', 'Lista civetta', 'Control group',
    'Perc. control group', 'Canale', 'Mod. invio', 'Sender', 'Storic.', 'Testo sms', 'Link', 'Durata sms', 'Data inizio',
    'Data fine', 'Durata campagna', 'Trial', 'Data trial', 'Volume trial', 'Perc. scostamento', 'Volume', 'Attivi', 'Sospesi',
    'Consumer', 'Business', 'Prepagato', 'Postpagato', 'Cons. profilazione', 'Cons. commerciale', 'checkboxAdesso3', 'Voce',
    'Dati', 'No frodi', 'No collection', 'ETF', 'VIP', 'Dipendenti', 'Trial', 'Parlanti ultimo/i', 'Profilo Rischio GA',
    'Profilo Rischio Standard', 'Profilo Rischio High Risk', 'Altri criteri');

$titolo = array('N', 'Stack', 'Sprint', 'Squad', 'Nome Campagna','Tipologia', 'Cod. campagna','Cod. comunicazione', 'Canale', 'Data inizio', 'Stato', 'Vol.(k)');    
    $tot_colonne = count($titolo) - 1;

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
        foreach ($list as $key => $value) {
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
        header('Content-Disposition: attachment;filename="' . $today . '_Export_GestioneCampagne.xlsx"');
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

//echo json_encode($data_output);

    
}

function export_capacity($list, $filter){ 
        // Set document properties
        $campaign = new campaign_class();
        $today = date("Ymd");

        $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("Tool Campaign")
        ->setLastModifiedBy("Maarten Balliauw")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setSubject("Office 2007 XLSX Test Document")
        ->setDescription("Test document for Office 2007 XLSX, generated using PHP classes.")
        ->setKeywords("office 2007 openxml php")
        ->setCategory("Test result file");
    $objPHPExcel->getActiveSheet()->mergeCells('A1:E1');
    $objPHPExcel->getActiveSheet()->mergeCells('A2:E2');
    $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Capacity Plan');
    $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dal '.$filter['startDate'].' Al '.$filter['endDate']);
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

$titolo = array('N', 'Stack','Sprint','Squad','Tipologia', 'Modalità', 'Categoria', 'Offerta',	'Canale',	'Volume Stimato (K)',	'Data Output',	'Data Inizio', 'Data Fine',	'Stato',	'Nuova Pianificazione');

$tot_colonne = count($titolo) - 1;


foreach ($titolo as $key => $value) {
    if ($colonna < 13)
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)
                ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);
        $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga, $value);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        //$objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getFill()->getStartColor()->setARGB('FFDDDDDD');
        //$objPHPExcel->getActiveSheet()->getStyle('A2:I2')->getFill()->getStartColor()->setARGB('FFDDDDDD');
        $colonna++;
        
    }

    //tutta la riga 3
    $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow(0, 3, $tot_colonne, 3)->applyFromArray(
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
    $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow(13, 3, $tot_colonne, 3)->applyFromArray(
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
                        'argb' => 'FFFFA500'
                    )
                )
            )
    );


        $riga = 4;
        $colonna = 0;
        foreach ($list as $key => $row) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $riga, $key+1);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $riga, $row['stacks_nome']);    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $riga, $campaign->sprint_find($row['data_inizio']));        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $riga, $row['squads_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $riga, $row['tipo_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $riga, $row['modality_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $riga, $row['category_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $riga, $row['descrizione_offerta']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, $riga, $campaign->tableChannelLabel($row));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, $riga, round($row['volume']/1000));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $riga, $row['data_inserimento']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, $row['data_inizio']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, $riga, $row['data_fine']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, $riga, $row['campaign_stato_nome']);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, $riga, '');
      
            $riga++;
            
        }
        //$objPHPExcel->getActiveSheet()->getColumnDimension('V')->setWidth(80);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth(80);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('BB')->setWidth(120);
        //$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth(80);
        $objPHPExcel->getActiveSheet()->setTitle('Export');
        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header('Content-Disposition: attachment;filename="' . $today . '_Export_CapacityPlan.xlsx"');
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

//echo json_encode($data_output);

    
}


}

