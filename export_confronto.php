<?php

require_once 'classes/PHPExcel.php';
require_once 'classes/PHPExcel/IOFactory.php';
require_once("db_config.php");

function connect_db() {
    mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    mysql_select_db(DB_NAME); // if there are problems with the tablenames inside the config file use this row
//echo DB_SERVER." - ". DB_USER." - ". DB_PASSWORD." - ". DB_NAME;
}

connect_db();
$filtro = $_GET['filtro'];

$objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("H3G")
        ->setLastModifiedBy("TH")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setCategory("LSoc");
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("25");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("35");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth("30");

$objWorksheet->setCellValue('A1', "ID");
$objWorksheet->setCellValue('B1', "Description");

$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00BFBFBF');
$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A2:Z300')
->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:Z300')
->getAlignment()->setWrapText(true);


if (isset($_GET['telefoni'])) {

    #$telefoni = explode(";", base64_decode($_GET['telefoni']));
    $telefoni = unserialize(base64_decode($_GET['telefoni']));
    #unset($telefono_base[0]);
    //print_r($telefono_base);
    #$telefoni=array($telefono_base[1],$telefono_base[2]);
    rsort($telefoni);
    $col = 2;
    for ($i = 0; $i < count($telefoni); $i++)
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, $telefoni[$i]);

    $query3 = "";
    $query3 = $query3 . "SELECT `dati_requisiti`.id,`dati_requisiti`.descrizione_requisito,`dati_requisiti`.ordine, `dati_requisiti`.nome_requisito,`dati_requisiti`.descrizione_requisito,`dati_requisiti`.summary, `dati_valori_requisiti_temp`.valore_requisito as valore_requisito_0 ";
    for ($i = 1; $i < count($telefoni); $i++) {
        $query3 = $query3 . " ,`dati_valori_requisiti_temp$i`.valore_requisito as valore_requisito_$i";
    }
    $query3 = $query3 . " FROM `dati_requisiti` left JOIN (select * From `dati_valori_requisiti` where nome_tel='" . $telefoni[0] . "') as  dati_valori_requisiti_temp
			ON `dati_valori_requisiti_temp`.`id_requisito` = `dati_requisiti`.`id`  ";
    for ($i = 1; $i < count($telefoni); $i++) {
        $query3 = $query3 . " left JOIN ( select * From `dati_valori_requisiti` where nome_tel='" . $telefoni[$i] . "') as  dati_valori_requisiti_temp$i ON `dati_valori_requisiti_temp$i`.`id_requisito` = `dati_requisiti`.`id`";
    }
    
    $query3 = $query3 ." where `dati_requisiti`.stato=1 order by ordine  ";
    
    #echo $query3;

    $result3 = mysql_query($query3) or die($query3 . " - " . mysql_error());
    $riga = 2;
    while ($obj3 = mysql_fetch_array($result3)) {

        $nome_requisito = $obj3['id'];
        $descrizione_requisito = $obj3['descrizione_requisito'];
        $summary_value = $obj3['summary'];
        
      if ($filtro == 'summary'){
        if($summary_value == 1) {
          $objWorksheet->setCellValueByColumnAndRow(0, $riga, $nome_requisito);  
          $objWorksheet->setCellValueByColumnAndRow(1, $riga, $descrizione_requisito);

        $col = 1;
        foreach ($telefoni as $key => $value) {
            $col++;
            $valore_req = trim($obj3['valore_requisito_' . $key]);
            $objWorksheet->setCellValueByColumnAndRow($col, $riga, $valore_req);
        }
        $riga++;
        }
      }
      //Extended
      else {
          $objWorksheet->setCellValueByColumnAndRow(0, $riga, $nome_requisito);
          $objWorksheet->setCellValueByColumnAndRow(1, $riga, $descrizione_requisito);

        $col = 1;
        foreach ($telefoni as $key => $value) {
            $col++;
            $valore_req = trim($obj3['valore_requisito_' . $key]);
            $objWorksheet->setCellValueByColumnAndRow($col, $riga, $valore_req);
        }
        $riga++;
      }
    }

    $today = date("y_m_d");
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="confronto_LSoC_'.$filtro.'-' . $today . '.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;
}
?>
