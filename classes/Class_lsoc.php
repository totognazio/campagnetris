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
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
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
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)
                ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
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
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, round($tot_volume['totale']/1000,1));
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn(11)->setWidth(8);
            $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow(11, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

        
            $colonna = 11;
        foreach($daterange as $key=>$daytimestamp){
            $colonna++;
            $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(8);
            $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER);

            //$string .= "<td><small><strong>".$campaign->round_volume($tot_volume[$daytimestamp])."</strong></small></td>";
            if($tot_volume[$daytimestamp]>0){
                $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow($colonna, $riga, round($tot_volume[$daytimestamp]/1000));
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

function export_gestione($list,$filter){ 
        
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
        $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Gestione Campagne');
        $objPHPExcel->getActiveSheet()->setCellValue('A2', 'Dal '.$filter['startDate'].' Al '.$filter['endDate']);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setName('Candara');
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setSize(20);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setBold(true);
        //$objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->setUnderline(PHPExcel_Style_Font::UNDERLINE_SINGLE);
        $objPHPExcel->getActiveSheet()->getStyle('A1')->getFont()->getColor()->setARGB(PHPExcel_Style_Color::COLOR_BLACK);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()->getStartColor()->setARGB('FFFFA500');
        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFill()->setFillType(PHPExcel_Style_Fill::FILL_SOLID);
        $objPHPExcel->getActiveSheet()->getStyle('A2:E2')->getFill()->getStartColor()->setARGB('FFDDDDDD');

    $riga = 3;
    $colonna = 0;

    $titolo = array('N', 'Stack', 'Sprint', 'Squad', 'Nome Campagna','Tipologia', 'Cod. campagna','Cod. comunicazione', 'Modalità','Priorità','Descrizione Attività','Ropz','Popz','Canale','Tipo', 'Data inizio Campagna','Data Fine Campagna','Volume','Stato','Username','Data Inserimento Campagna', 'Stato','Tipo Offerta','Tipo Contratto','Consenso','Mercato','Frodatori','Altri Criteri','Indicatore Dinamico','Call guide','Control Group');

    $tot_colonne = count($titolo) - 1;

    foreach ($titolo as $key => $value) {
    
        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setAutoSize(true);
        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)
                ->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_LEFT);
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
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
    $colonna = 0;
//print_r($list);
    foreach ($list as $key => $row) {

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $riga, $key+1);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $riga, $row['stacks_nome']);    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $riga, $campaign->sprint_find($row['data_inizio']));        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $riga, $row['squads_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $riga, $row['pref_nome_campagna']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $riga, $row['tipo_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $riga, $row['cod_campagna']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $riga, $row['cod_comunicazione']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, $riga, $row['modality_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, $riga, $row['priority']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $riga, $row['descrizione_target']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, $row['cod_opz']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, $riga, $row['cod_ropz']);            
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(13, $riga, $campaign->tableChannelLabel($row));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(14, $riga, $row['tipo_leva']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(15, $riga, $row['data_inizio']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(16, $riga, $row['data_fine_validita_offerta']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(17, $riga, round($row['volume']/1000));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(18, $riga, $row['campaign_stato_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(19, $riga, $row['username']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(20, $riga, $row['data_inserimento']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(21, $riga, $campaign->getCriteri($row,'stato'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(22, $riga, $campaign->getCriteri($row,'tipo_offerta'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(23, $riga, $campaign->getCriteri($row,'tipo_contratto'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(24, $riga, $campaign->getCriteri($row,'consenso'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(25, $riga, $campaign->getCriteri($row,'mercato'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(26, $riga, $campaign->getCriteri($row,'frodatori'));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(27, $riga, $row['altri_criteri']);    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(28, $riga, $row['indicatore_dinamico']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(29, $riga, $row['redemption']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(30, $riga, $campaign->getCriteri($row,'control_group'));

            $riga++;

        }
        

    $objPHPExcel->getActiveSheet(0)->getStyleByColumnAndRow(0, $riga, $tot_colonne, $riga)->applyFromArray(
            array(
                'font' => array(
                    'bold' => true
                ),
                'alignment' => array(
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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



function export_gestione_old($list, $filter){ 
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
            $objPHPExcel->getActiveSheet()->setCellValue('A1', 'Gestione Campagne');
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

        $riga = 4;
        $colonna = 0;


        $titolo = array('N', 'Stack', 'Sprint', 'Squad', 'Nome Campagna','Tipologia', 'Cod. campagna','Cod. comunicazione', 'Modalità','Priorità','Descrizione Target','leva/Offerta','Opzione','Canale','Tipo Leva', 'Data inizio Campagna','Data Fine Campagna','Volume','Stato','Username','Data Inserimento Campagna', 'Stato','Tipo Offerta','Tipo Contratto','Consenso','Mercato','Frodatori','Altri Criteri','Indicatore Dinamico','Call guide','Control Group');

        //$tot_colonne = count($titolo) - 1;

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
        foreach ($list as $key => $row) {
            
                                  
                    //$objPHPExcel->getActiveSheet()->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setWrapText(true);

                    if ($colonna != 1) {
                        $objPHPExcel->getActiveSheet()->getColumnDimensionByColumn($colonna)->setWidth(20);
                        $objPHPExcel->setActiveSheetIndex(0)->getStyleByColumnAndRow($colonna, $riga)->getAlignment()->setVertical(PHPExcel_Style_Alignment::VERTICAL_CENTER)
                                ->setHorizontal(PHPExcel_Style_Alignment::HORIZONTAL_CENTER)->setWrapText(true);
                        ;
                    }
        $titolo = array('N', 'Stack', 'Sprint', 'Squad', 'Nome Campagna','Tipologia', 'Cod. campagna','Cod. comunicazione', 'Modalità','Priorità','Descrizione Target','leva/Offerta','Opzione','Canale','Tipo Leva', 'Data inizio Campagna','Data Fine Campagna','Volume','Stato','Username','Data Inserimento Campagna', 'Stato','Tipo Offerta','Tipo Contratto','Consenso','Mercato','Frodatori','Altri Criteri','Indicatore Dinamico','Call guide','Control Group');

            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(0, $riga, $key+1);        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(1, $riga, $row['stacks_nome']);    
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(2, $riga, $campaign->sprint_find($row['data_inizio']));        
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(3, $riga, $row['squads_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(4, $riga, $row['pref_nome_campagna']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(5, $riga, $row['tipo_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(6, $riga, $row['cod_campagna']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $riga, $row['cod_comunicazione']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $riga, $row['modality_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(7, $riga, $row['priority']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(8, $riga, $campaign->tableChannelLabel($row));
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(9, $riga, $row['data_inizio']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $riga, $row['campaign_stato_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, round($row['volume']/1000));


            
            
                //$colonna = 0;
                $riga++;
            
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

//$titolo = array('N', 'Stack','Sprint','Squad','Tipologia', 'Modalità', 'Categoria', 'Offerta',	'Canale',	'Volume Stimato (K)',	'Data Output',	'Data Inizio Offerta', 'Data Fine Offerta',	'Stato','Note operative');
$titolo = array('N', 'Stack','Sprint','Squad','Tipologia', 'Modalità', 'Categoria', 'Offerta',	'Canale',	'Volume Stimato (K)',	'Data Output','Stato','Note operative');
$tot_colonne = count($titolo) - 1;


foreach ($titolo as $key => $value) {

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
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
                    'horizontal' => PHPExcel_Style_Alignment::HORIZONTAL_LEFT,
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
            /*
            if(strtotime($row['data_inizio_validita_offerta'])<0){
                $row['data_inizio_validita_offerta'] = '1970-01-01';
            }
            if(strtotime($row['data_fine_validita_offerta'])<0){
                $row['data_fine_validita_offerta'] = '1970-01-01';
            }
            */

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
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(10, $riga, $row['data_inizio']);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, $row['data_inizio_validita_offerta']);
            //$objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, $riga, $row['data_fine_validita_offerta']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(11, $riga, $row['campaign_stato_nome']);
            $objPHPExcel->setActiveSheetIndex(0)->setCellValueByColumnAndRow(12, $riga, $row['note_operative']);
            
            
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

