<?php


function stampa_profilo_telefono($telefono) {
    $db_link = connect_db_li();
    $query3 = "SELECT `dati_requisiti`.*, `dati_valori_requisiti`.*
			FROM `dati_valori_requisiti`
			JOIN `socmanager`.`dati_requisiti` ON `dati_valori_requisiti`.`id_requisito` = `dati_requisiti`.`id`
			where nome_tel='" . $_POST['model'] . "'
					";
    // echo $query3;
    echo "<table border='1'>";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_array($result3)) {
        echo "<tr>";
        echo "<td><p>" . $obj3['descrizione_requisito'] . "</p></td>" . "<td><p>" . $obj3['valore_requisito'] . "</p></td>";
        echo "</tr>";
    }
    echo "</table>";
}


function stampa_tabella_pivot($telefono, $tipo_table = 1) {
    $db_link = connect_db_li();
    echo "<table>";
    $query = "SELECT * FROM `tabella_pivot`";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    while ($obj = mysqli_fetch_array($result)) {
        echo "<tr><td>" . $obj['nome_campo'] . "</td><td>";
        $query2 = "SELECT `tabella_pivot_value`.*,dati_valori_requisiti.*
		FROM `tabella_pivot_value` join dati_valori_requisiti ON dati_valori_requisiti.id_requisito= `tabella_pivot_value`.id_requisito
		WHERE nome_tel='$telefono' and `id_valore` =" . $obj['id'] . " ORDER BY `tabella_pivot_value`.`ordine` ASC";
        $result2 = mysqli_query($db_link,$query2) or die($query2 . " - " . mysql_error());
        while ($obj2 = mysqli_fetch_array($result2)) {
            if ($obj2['nome_campo'] != "")
                $nome_campo = $obj2['nome_campo'] . "=";
            else
                $nome_campo = "";

            if ($obj2['valore_requisito'] == "Yes") {
                $nome_campo = "";
                $valore_requisito = $obj2['nome_campo'] . ";";
            } else if ($obj2['valore_requisito'] == "No") {
                $nome_campo = "";
                $valore_requisito = "";
            } else {

                $valore_requisito = $obj2['valore_requisito'] . ";";
            }
            echo $nome_campo . $valore_requisito;
        }
        echo "</td></tr>";
    }
    echo "</table>";
}

function stampa_tabella_pivot_powerpoint($telefono, $tipo_table = 1) {
    $db_link = connect_db_li();
    $today = date("y_m_d");
    //header("Content-Disposition: attachment; filename=\"" . $today . "_Soc_summary.ppt\"");
    //header("Content-Type: application/vnd.ms-powerpoint");
    //header("Content-disposition: attachment; filename= 'Soc_summary.pptx'");
    //header('Content-type: application/vnd.ms-powerpoint');

    error_reporting(E_ALL);

    /** Include path * */
    set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');

    /** PHPPowerPoint */
    include_once 'newPHPClass.php';
    include_once 'funzioni.php';


    // Create new PHPPowerPoint object
    //echo date('H:i:s') . " Create new PHPPowerPoint object\n";
    $objPHPPowerPoint = new PHPPowerPoint();

    // Set properties
    // echo date('H:i:s') . " Set properties\n";
    $objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 PPTX Test Document")
            ->setSubject("Office 2007 PPTX Test Document")
            ->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

    // Create slide
    // echo date('H:i:s') . " Create slide\n";
    $currentSlide = $objPHPPowerPoint->getActiveSlide();
    $shape = $currentSlide->createRichTextShape()
            ->setHeight(200)
            ->setWidth(600)
            ->setOffsetX(20)
            ->setOffsetY(30);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
    $textRun = $shape->createTextRun('Feature Table');
    //
    $textRun->getFont()->setBold(false)
            ->setSize(38)
            ->setColor(new PHPPowerPoint_Style_Color('000000'));

    // Create a shape (table)
    //echo date('H:i:s') . " Create a shape (table)\n";
    $shape = $currentSlide->createTableShape(2);
    $shape->setHeight(600);
    $shape->setWidth(900);
    $shape->setOffsetX(30);
    $shape->setOffsetY(150);

    // Add row
    // echo date('H:i:s') . " Add row\n";
    $row = $shape->createRow();
    $row->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_SOLID)
            ->setStartColor(new PHPPowerPoint_Style_Color('00B0F0'));
    $cell = $row->nextCell();
    $cell->setWidth(300);
    $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));

    $cell->createTextRun('Funtions')->getFont()->setBold(true)
            ->setColor(new PHPPowerPoint_Style_Color('FFFFFF'))
            ->setSize(16);
    $cell = $row->nextCell()->setWidth(600);
    $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));

    $cell->createTextRun('')->getFont()->setBold(true)
            ->setColor(new PHPPowerPoint_Style_Color('FF0000'))
            ->setSize(16);

    // Add row



    $query = "SELECT * FROM `tabella_pivot` order by ordine";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $righe_x_pagina = 0;
    $righe_alternata = 0;

    while ($obj = mysqli_fetch_array($result)) {
        // echo date('H:i:s') . " Add row\n";
        if ($righe_x_pagina == 12) {
            $currentSlide = $objPHPPowerPoint->createSlide();
            $shape = $currentSlide->createRichTextShape()
                    ->setHeight(200)
                    ->setWidth(600)
                    ->setOffsetX(20)
                    ->setOffsetY(30);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
            $textRun = $shape->createTextRun('Feature Table');
            $textRun->getFont()->setBold(false)
                    ->setSize(38)
                    ->setColor(new PHPPowerPoint_Style_Color('000000'));
            // Create a shape (table)
            //echo date('H:i:s') . " Create a shape (table)\n";
            $shape = $currentSlide->createTableShape(2);
            $shape->setHeight(600);
            $shape->setWidth(900);
            $shape->setOffsetX(30);
            $shape->setOffsetY(150);
            $righe_x_pagina = 0;
        }
        $row = $shape->createRow();
        if ($righe_alternata == 0) {
            $colore_riempimento = "CBE4F9";
            $righe_alternata++;
        } else {
            $colore_riempimento = "E7F2FC";
            $righe_alternata = 0;
        }
        $row->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_GRADIENT_LINEAR)
                ->setStartColor(new PHPPowerPoint_Style_Color($colore_riempimento))
                ->setEndColor(new PHPPowerPoint_Style_Color($colore_riempimento));

        $righe_x_pagina++;
        $cell = $row->nextCell();
        $cell->setWidth(300)->createTextRun($obj['nome_campo'])->getFont()->setBold(true)->setSize(16);
        $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));

        $query2 = "SELECT `tabella_pivot_value`.*,dati_valori_requisiti.*
		FROM `tabella_pivot_value` join dati_valori_requisiti ON dati_valori_requisiti.id_requisito= `tabella_pivot_value`.id_requisito
		WHERE nome_tel='$telefono' and `id_valore` =" . $obj['id'] . " ORDER BY `tabella_pivot_value`.`ordine` ASC";


        $result2 = mysqli_query($db_link,$query2) or die($query2 . " - " . mysql_error());
        $valore_cella = "";
        while ($obj2 = mysqli_fetch_array($result2)) {
            if ($obj2['nome_campo'] != "" && $obj2['valore_requisito'] != "")
                $nome_campo = $obj2['nome_campo'] . "=";
            else
                $nome_campo = "";

            if ($obj2['valore_requisito'] == "Yes") {
                $nome_campo = "";
                $valore_requisito = $obj2['nome_campo'] . "; ";
            } else if ($obj2['valore_requisito'] == "No") {
                $nome_campo = "";
                $valore_requisito = "";
            } else if ($obj2['valore_requisito'] == "") {
                $valore_requisito = "";
            } else {

                $valore_requisito = $obj2['valore_requisito'] . "; ";
            }
            $valore_cella = $valore_cella . $nome_campo . $valore_requisito;
            //
        }
        if (substr($valore_cella, -2) == "; ")
            $valore_cella = substr($valore_cella, 0, -2);
        $cell = $row->nextCell();
        $cell->setWidth(600)->createTextRun($valore_cella)->getFont()->setSize(12);
        $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    }
    // Save PowerPoint 2007 file
    // echo date('H:i:s') . " Write to PowerPoint2007 format\n";
    $objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');    
    $today = date("y_m_d");
    $filename = 'Soc_summary_' . $today . '.pptx';
    $objWriter->save($filename);
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=" . $filename);
    ob_clean();
    flush();
    readfile($filename);
    exit;

    // Echo memory peak usage
    //echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
    // Echo done
    // echo date('H:i:s') . " Done writing file.\r\n";
}

function stampa_tabella_pivot_confronto_summary($telefono, $tipo_table = 1) {
    $db_link = connect_db_li();

    error_reporting(E_ALL);
    echo "<table>";

    //echo '<td>Feature Table</td>';



    $query = "SELECT * FROM `tabella_pivot` order by ordine";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $righe_x_pagina = 0;
    $righe_alternata = 0;
    echo "<tr>";
    echo '<td style="width: 200px; background-color:#00B0F0"><b>Feature Table</b></td>';
    foreach ($telefono as $value) {
        // $larghezza_colonna = 600 / count($telefono);
        echo "<td style=\"width: 300px; background-color:#00B0F0\"><b>$value</b></td>";
    }
    echo "</tr>";
    while ($obj = mysqli_fetch_array($result)) {
        // echo date('H:i:s') . " Add row\n";

        echo "<tr>";

        if ($righe_alternata == 0) {
            $colore_riempimento = "#CBE4F9";
            $righe_alternata++;
        } else {
            $colore_riempimento = "#E7F2FC";
            $righe_alternata = 0;
        }
        echo "<td style=\"background-color:$colore_riempimento\"><b>" . $obj['nome_campo'] . "</b></td>";
        foreach ($telefono as $key => $value) {


            $query2 = "SELECT `tabella_pivot_value`.*,dati_valori_requisiti.* , `dati_requisiti`.*
			FROM `tabella_pivot_value` join dati_valori_requisiti ON dati_valori_requisiti.id_requisito= `tabella_pivot_value`.id_requisito  join  `socmanager`.`dati_requisiti` ON `tabella_pivot_value`.id_requisito=`dati_requisiti`.id
			WHERE   nome_tel='$value' and `id_valore` =" . $obj['id'] . " ORDER BY `tabella_pivot_value`.`ordine` ASC";
            //echo $query2."<br>";
            $result2 = mysqli_query($db_link,$query2) or die($query2 . " - " . mysql_error());
            $valore_cella = "";

            while ($obj2 = mysqli_fetch_array($result2)) {
                if ($obj2['nome_campo'] != "" && $obj2['valore_requisito'] != "")
                    $nome_campo = trim($obj2['nome_campo']) . "=";
                else
                    $nome_campo = "";

                if ($obj2['valore_requisito'] == "Yes") {
                    $nome_campo = "";
                    $valore_requisito = trim($obj2['nome_campo']) . " ";
                } else if ($obj2['valore_requisito'] == "No") {
                    if ($obj2['negativo'] != "") {
                        $nome_campo = "";
                        $valore_requisito = $obj2['negativo'];
                    } else {
                        $nome_campo = "";
                        $valore_requisito = "";
                    }
                } else if ($obj2['valore_requisito'] == "") {
                    $valore_requisito = "";
                } else {
                    $valore_requisito = trim($obj2['valore_requisito']);
                }
                $valore_cella = "<p>" . $valore_cella . $nome_campo . $valore_requisito . "</p>";
            }
            if (substr($valore_cella, -2) == "; ")
                $valore_cella = substr($valore_cella, 0, -2);

            echo "<td style=\"background-color:$colore_riempimento\">$valore_cella</td>";
        }
    }
    echo "</tr>";
    echo "</table>";
}

function stampa_tabella_pivot_powerpoint_confronto($telefono, $tipo_table = 1) {
    $db_link = connect_db_li();
    $today = date("y_m_d");
    //header("Content-Disposition: attachment; filename=\"" . $today . "_Soc_summary.ppt\"");
    //header("Content-Type: application/vnd.ms-powerpoint");
    //header("Content-disposition: attachment; filename= 'Soc_summary.pptx'");
    //header('Content-type: application/vnd.ms-powerpoint');

    error_reporting(E_ALL);

    /** Include path * */
    set_include_path(get_include_path() . PATH_SEPARATOR . './Classes/');

    /** PHPPowerPoint */
    include 'PHPPowerPoint.php';


    // Create new PHPPowerPoint object
    //echo date('H:i:s') . " Create new PHPPowerPoint object\n";
    $objPHPPowerPoint = new PHPPowerPoint();

    // Set properties
    // echo date('H:i:s') . " Set properties\n";
    $objPHPPowerPoint->getProperties()->setCreator("Maarten Balliauw")
            ->setLastModifiedBy("Maarten Balliauw")
            ->setTitle("Office 2007 PPTX Test Document")
            ->setSubject("Office 2007 PPTX Test Document")
            ->setDescription("Test document for Office 2007 PPTX, generated using PHP classes.")
            ->setKeywords("office 2007 openxml php")
            ->setCategory("Test result file");

    // Create slide
    // echo date('H:i:s') . " Create slide\n";
    $currentSlide = $objPHPPowerPoint->getActiveSlide();
    $shape = $currentSlide->createRichTextShape()
            ->setHeight(120)
            ->setWidth(600)
            ->setOffsetX(20)
            ->setOffsetY(30);
    $shape->getActiveParagraph()->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
    $textRun = $shape->createTextRun('Feature Table');
    //
    $textRun->getFont()->setBold(false)
            ->setSize(38)
            ->setColor(new PHPPowerPoint_Style_Color('000000'));

    // Create a shape (table)
    //echo date('H:i:s') . " Create a shape (table)\n";
    $shape = $currentSlide->createTableShape(count($telefono) + 1);
    $shape->setHeight(600);
    $shape->setWidth(900);
    $shape->setOffsetX(30);
    $shape->setOffsetY(130);

    // Add row
    // echo date('H:i:s') . " Add row\n";
    $row = $shape->createRow();
    $row->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_SOLID)
            ->setStartColor(new PHPPowerPoint_Style_Color('00B0F0'));
    $cell = $row->nextCell();
    $cell->setWidth(300);
    $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
    $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));

    $cell->createTextRun('Funtions')->getFont()->setBold(true)
            ->setColor(new PHPPowerPoint_Style_Color('FFFFFF'))
            ->setSize(16);
    foreach ($telefono as $value) {
        $larghezza_colonna = 600 / count($telefono);
        $cell = $row->nextCell()->setWidth($larghezza_colonna);
        $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->createTextRun($value)->getFont()->setBold(true)
                ->setColor(new PHPPowerPoint_Style_Color('FFFFFF'))
                ->setSize(16);
    }

    $query = "SELECT * FROM `tabella_pivot` order by ordine";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $righe_x_pagina = 0;
    $righe_alternata = 0;

    while ($obj = mysqli_fetch_array($result)) {
        // echo date('H:i:s') . " Add row\n";
        if ($righe_x_pagina == (10 - count($telefono))) {
            $currentSlide = $objPHPPowerPoint->createSlide();
            $shape = $currentSlide->createRichTextShape()
                    ->setHeight(200)
                    ->setWidth(600)
                    ->setOffsetX(20)
                    ->setOffsetY(30);
            $shape->getActiveParagraph()->getAlignment()->setHorizontal(PHPPowerPoint_Style_Alignment::HORIZONTAL_LEFT);
            $textRun = $shape->createTextRun('Feature Table');
            $textRun->getFont()->setBold(false)
                    ->setSize(38)
                    ->setColor(new PHPPowerPoint_Style_Color('000000'));
            // Create a shape (table)
            //echo date('H:i:s') . " Create a shape (table)\n";
            $shape = $currentSlide->createTableShape(count($telefono) + 1);
            $shape->setHeight(600);
            $shape->setWidth(900);
            $shape->setOffsetX(30);
            $shape->setOffsetY(150);
            $righe_x_pagina = 0;
            $row = $shape->createRow();
            $row->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_SOLID)
                    ->setStartColor(new PHPPowerPoint_Style_Color('00B0F0'));
            $cell = $row->nextCell();
            $cell->setWidth(300);
            $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
            $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
            $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
            $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));

            $cell->createTextRun('Funtions')->getFont()->setBold(true)
                    ->setColor(new PHPPowerPoint_Style_Color('FFFFFF'))
                    ->setSize(16);
            foreach ($telefono as $value) {
                $larghezza_colonna = 600 / count($telefono);
                $cell = $row->nextCell()->setWidth($larghezza_colonna);
                $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
                $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
                $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
                $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
                $cell->createTextRun($value)->getFont()->setBold(true)
                        ->setColor(new PHPPowerPoint_Style_Color('FFFFFF'))
                        ->setSize(16);
            }
        }
        $row = $shape->createRow();
        if ($righe_alternata == 0) {
            $colore_riempimento = "CBE4F9";
            $righe_alternata++;
        } else {
            $colore_riempimento = "E7F2FC";
            $righe_alternata = 0;
        }
        $row->getFill()->setFillType(PHPPowerPoint_Style_Fill::FILL_GRADIENT_LINEAR)
                ->setStartColor(new PHPPowerPoint_Style_Color($colore_riempimento))
                ->setEndColor(new PHPPowerPoint_Style_Color($colore_riempimento));

        $righe_x_pagina++;
        $cell = $row->nextCell();
        $cell->setWidth(300)->createTextRun($obj['nome_campo'])->getFont()->setBold(true)->setSize(16);
        $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        foreach ($telefono as $key => $value) {


            $query2 = "SELECT `tabella_pivot_value`.*,dati_valori_requisiti.*
			FROM `tabella_pivot_value` join dati_valori_requisiti ON dati_valori_requisiti.id_requisito= `tabella_pivot_value`.id_requisito
			WHERE nome_tel='$value' and `id_valore` =" . $obj['id'] . " ORDER BY `tabella_pivot_value`.`ordine` ASC";
            //echo $query2."<br>";
            $result2 = mysqli_query($db_link,$query2) or die($query2 . " - " . mysql_error());
            $valore_cella = "";
            while ($obj2 = mysqli_fetch_array($result2)) {
                if ($obj2['nome_campo'] != "" && $obj2['valore_requisito'] != "")
                    $nome_campo = trim($obj2['nome_campo']) . "=";
                else
                    $nome_campo = "";

                if ($obj2['valore_requisito'] == "Yes") {
                    $nome_campo = "";
                    $valore_requisito = trim($obj2['nome_campo']) . "; ";
                } else if ($obj2['valore_requisito'] == "No") {
                    if ($obj2['negativo'] != "") {
                        $nome_campo = "";
                        $valore_requisito = $obj2['negativo'];
                    } else {
                        $nome_campo = "";
                        $valore_requisito = "";
                    }
                } else if ($obj2['valore_requisito'] == "") {
                    $valore_requisito = "";
                } else {
                    $valore_requisito = trim($obj2['valore_requisito']) . "\n";
                }
                $valore_cella = $valore_cella . $nome_campo . $valore_requisito;
            }
            if (substr($valore_cella, -2) == "; ")
                $valore_cella = substr($valore_cella, 0, -2);
            $cell = $row->nextCell();
            $cell->setWidth(300)->createTextRun(trim($valore_cella))->getFont()->setSize(12);
            $cell->getBorders()->getBottom()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
            $cell->getBorders()->getTop()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
            $cell->getBorders()->getLeft()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
            $cell->getBorders()->getRight()->setLineWidth(2)->setLineStyle(PHPPowerPoint_Style_Border::LINE_SINGLE)->setColor(new PHPPowerPoint_Style_Color('FFFFFF'));
        }
    }
    // Save PowerPoint 2007 file
    // echo date('H:i:s') . " Write to PowerPoint2007 format\n";
    $objWriter = PHPPowerPoint_IOFactory::createWriter($objPHPPowerPoint, 'PowerPoint2007');
    $filename = 'Soc_summary_' . $today . '.pptx';
    $objWriter->save($filename);
    header("Pragma: no-cache");
    header("Expires: 0");
    header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
    header("Content-Type: application/force-download");
    header("Content-Type: application/octet-stream");
    header("Content-Type: application/download");
    header("Content-Disposition: attachment;filename=" . $filename);
    ob_clean();
    flush();
    readfile($filename);

    // Echo memory peak usage
    //echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
    // Echo done
    // echo date('H:i:s') . " Done writing file.\r\n";
}

function modify_formLSoc($nome_tel, $access_level) {
    $db_link = connect_db_li();
    
   
    if ($access_level < 6) {
        $disabled = "disabled;"; 
        $visibility = 'visibility:hidden;';
        $display_none = 'style="display: none;"';
    }
    else {
        $disabled = '';
        $visibility = '';
        $display_none = '';
    }
    #$nome_tel = $_GET['nome_tel']; 
    if (isset($_POST["vendor"]) && ($_POST["vendor"] != null)) {
        $vendor = $_POST["vendor"];
        $query5 = "UPDATE `socmanager`.`dati_valori_requisiti` SET `vendor` = '" . $vendor . "' WHERE ( `nome_tel` = '" . $nome_tel . "') ";
        mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
    }
    if (isset($_POST["accettazione"]) && ($_POST["accettazione"] != ' -- Select Date --')) {
        $data_accettazione = $_POST["accettazione"];
        $query5 = "UPDATE `socmanager`.`dati_valori_requisiti` SET `data_accettazione` = '" . $data_accettazione . "' WHERE ( `nome_tel` = '" . $nome_tel . "') ";
        mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
    }
    if (isset($_POST["market"]) && ($_POST["market"] != null) ) {
        $market = $_POST["market"];
        $query5 = "UPDATE `socmanager`.`dati_valori_requisiti` SET `market` = '" . $market . "' WHERE ( `nome_tel` = '" . $nome_tel . "') ";
        mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
    }

    if (isset($_POST["devicename"])) {
        $devicename = $_POST["devicename"];
        $query5 = "UPDATE `socmanager`.`dati_valori_requisiti` SET `nome_tel` = '" . $devicename . "' WHERE ( `nome_tel` = '" . $nome_tel . "')";
        mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
        $nome_device = base64_encode($devicename);
        header('Location: ' . $_SERVER['SCRIPT_NAME']."?page=grafici&update_lsoc&nome_tel=$nome_device");
                #$rest = substr($row['nome_tel'], -1);
       
        #index.php?page=grafici&update_lsoc&nome_tel
    }
    
    $query1 = "Select DISTINCT data_accettazione,market,vendor,devicetype FROM `dati_valori_requisiti` WHERE nome_tel = '$nome_tel' ";
    $result1 = mysqli_query($db_link,$query1) or die($query1 . " - " . mysql_error());
    $obj1 = mysqli_fetch_array($result1);
    
    if (isset($_POST['submit'])) {
        #echo"<pre>" . print_r($_POST) . "</pre>";
        $data_update = date("Y-m-d");
        
        foreach ($_POST['valore_req'] as $id => $s) {
         
            $valore_req = mysql_real_escape_string(trim($_POST['valore_req'][$id]));
            $nota_req = mysql_real_escape_string(trim($_POST['nota'][$id]));
            
            $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  nome_tel='" . $nome_tel . "' and id_requisito='" . $id . "'";
            $result_check = mysqli_query($db_link,$query_check) or die($query_check . " - " . mysql_error());
            $obj_check = mysqli_fetch_array($result_check);

            if (($obj_check['Num'] == 0)) {
                $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`) VALUES (NULL,'" . $id . "','" . $nome_tel . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $obj1['data_accettazione'] . "','" . $obj1['market'] . "','" . $obj1['vendor'] . "','" . $obj1['devicetype'] . "')";
                mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
            } else {
                $query5 = "UPDATE `socmanager`.`dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' WHERE ( `id_requisito`='" . $id . "' and `nome_tel` = '" . $nome_tel . "')";
                mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
            }
        }
 
        $riga = array_keys($_POST['submit']);
        $anchor = $riga[0];       
        header('Location:'.$_SERVER['PHP_SELF'].'?'.$_SERVER['QUERY_STRING'].'#'.$anchor);
        exit;
        
        #echo"<pre>" . print_r($_POST['valore_req']) . "</pre>";
        #echo"<pre>" . print_r($_POST['nota']) . "</pre>";
    }
    
    
    $query3 = "SELECT `temp` . * , `dati_requisiti` . *
	FROM `socmanager`.`dati_requisiti`
	left JOIN (

	SELECT nome_tel,valore_requisito,id_requisito,note
	FROM `dati_valori_requisiti`
	WHERE nome_tel = '$nome_tel'
	) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.`lista_req` LIKE '%".$obj1['devicetype']."%' order by sheet_name, nome_requisito";
    
    
    #$query3 = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$nome_tel."' )  where (dati_requisiti.lista_req LIKE   '%".$obj1['devicetype']."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `area_name`, `nome_requisito`";    
    
    $query5 = "SELECT * FROM `dati_valori_requisiti` WHERE nome_tel = '$nome_tel'";
    #$query5 = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$nome_tel."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `area_name`";    
    #$query5 = "SELECT * FROM  `dati_valori_requisiti` AS A JOIN  `dati_requisiti` AS B WHERE (A.nome_tel = '$nome_tel' AND (B.lista_req LIKE  '%".$obj1['devicetype']."%'))";
    $result5 = mysqli_query($db_link,$query5) or die($query5 . " - " . mysql_error());
    $obj5 = mysqli_fetch_array($result5);
   
   ///// Conteggio dei requisiti summary da compilare
    /*
    $query8 = "SELECT COUNT( dati_valori_requisiti.id_requisito ) FROM  `dati_valori_requisiti` RIGHT JOIN  `dati_requisiti` ON dati_valori_requisiti.id_requisito = dati_requisiti.id WHERE (summary =1 AND  `nome_tel` =  '$nome_tel' AND )";
    $result8 = mysqli_query($db_link,$query8) or die($query8 . " - " . mysql_error());
    $ob = mysqli_fetch_array($result8);
    */
    
    $data_accettazione = $obj5['data_accettazione'];
    
   
    $parse_date = date_parse($data_accettazione);
    if  ($parse_date["warning_count"] == 0) $background_col_data = "#eeeeee;";
    elseif ($parse_date["warning_count"] == 1) $background_col_data = "#FFEBE0;";
    #echo var_dump($parse_date) ."<br>";
    
    
    $market = $obj5['market'];
    if (empty($market)) $background_col_market = "#FFEBE0;"; else $background_col_market = "#eeeeee;";
    
    $vendor = $obj5['vendor'];
    $selected_open = "";
    $selected_customized = "";
    $device_tipo = $obj1['devicetype'];
    
    if ($device_tipo == "Phone") $device_stamp = "Handset"; else $device_stamp = $device_tipo;
    
    
    echo "<div style=\"clear: both; display:inline; float:left; width: 100%; height:50px;border:0px solid red;\">
        
            <p style=\"float:left;display:inline;\"><a class=\"puno\" title=\"Back\"  href=\"index.php?page=gestioneLSoc/admin_lsoc\">Back</a></p>
            <p style=\"float:left; margin-left:200px; font-weight: bold;\">Light SoC &nbsp;&nbsp;$device_stamp&nbsp;---&nbsp;<i>$nome_tel</i>&nbsp---</p>
            <p style=\"float:right;display:inline;\">
                <a style=\"margin-top:0px;background-color:#EEEEEE;border-color:#EEEEEE;\" title=\"Excel Download\"  href=\"export_file_excel.php?funzione=export_LSoc&devicetype=$device_tipo&nomedevice=$nome_tel&vendordevice=$vendor\"><img style=\"border-color:#EEEEEE;margin-top:0px;\" src=\"excel-icon.png\" title=\"Export Light Soc\" /></a> 
            </p>        
                    
        ";
    
    if ($access_level > 7) {
        echo "<a style=\"float:right; margin-top:0px;margin-right:50px; background-color:#EEEEEE;border-color:#EEEEEE;\" onclick=\"return confirm('Stai per eliminare la presente Light SoC. Confermi ?');\" href=\"index.php?page=grafici&elimina_lsoc&vendor=".base64_encode($vendor)."&devicename=".base64_encode($nome_tel)."\"><img style=\"border-color:#EEEEEE;margin-top:0px;\" src=\"delete-icon.png\" title=\"Elimina Light SoC\" /></a>";
        $href_image = "href=\"manage_foto_device.php?nomedevice=".base64_encode($nome_tel)."\"";
        $title = "Upload foto del device";
    }
    else {
        $href_image = "";
        $title = "Foto del device";
    }
    // Immagine Phone
    if (file_exists("./device_images/".base64_encode($nome_tel).".jpg")) $src_image = "./device_images/".base64_encode($nome_tel).".jpg";
    elseif($device_tipo == 'Phone') $src_image = "./device_images/default.jpg";
    elseif($device_tipo == 'Datacard') $src_image = "./device_images/default_datacard.jpg";
    elseif($device_tipo == 'Router') $src_image = "./device_images/default_router.jpg";
    elseif($device_tipo == 'Tablet') $src_image = "./device_images/default_tablet.jpg";
            
    echo "</div>";
    
    echo "<div style=\"float:left; border:0px solid red; margin-top:5px; margin-bottom:5px; width:100%;\">
        
        <table border=1 align=\"left\">";
    echo "<tr class=\"hover\" align=\"left\"><th>Data ccettazione</th><td>$data_accettazione </td>
        <form name=\"form1\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&update_lsoc&nome_tel=" . base64_encode($nome_tel) . "\">
        <td $display_none><input style=\"width: 170px; background-color: $background_col_data\" type=\"text\" name=\"accettazione\" value=\" -- Select Date --\" onclick=\"Calendar.show(this, '%Y-%m-%d', false)\" onfocus=\"Calendar.show(this, '%d/%m/%Y', false)\" onblur=\"Calendar.hide()\"/>
        ";

        echo "</td>
           <td $display_none>  
           <input type=\"submit\"  $disabled value=\"Modify\"></td>
            </form> 
        </tr>";
    echo "<tr class=\"hover\" align=\"left\"><th>Tipo Software</th>
                 <form name=\"form1\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&update_lsoc&nome_tel=" . base64_encode($nome_tel) . "\">
           
                    <td>$market </td><td $display_none>";
    if ($market == "OpenMarket")
        $selected_open = "selected";
    else
        $selected_customized = "selected";
    echo"
         <select style=\"width: 175px;  background-color:$background_col_market\" name = \"market\">
            <option value=\"\"> -- Select Software --</option>
            <option value=\"OpenMarket\">OpenMarket</option>
            <option value=\"Customized\">Customized</option>
         </select></td>
           <td $display_none><input type=\"submit\"  $disabled value=\"Modify\"></td>
        </form>  
       
        </tr>";
    
   ############### Vendor #############################
    if (strcasecmp($vendor, 'SONY Mobile Communications') == 0)  $vendor_stamp = "Sony Mobile Comm."; else $vendor_stamp = $vendor;
    
    echo "<tr class=\"hover\" align=\"left\"><th>Vendor</th>
                 <form name=\"form1\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&update_lsoc&nome_tel=" . base64_encode($nome_tel) . "\">
           
                    <td>$vendor_stamp</td><td $display_none>
    
        <select  style=\"width: 175px; background-color:#eeeeee;\" name=\"vendor\">
        
                
       <option value=\"\">-- Select Vendor --</option>";
        connect_db();
        //$q = mysqli_query($db_link,"SELECT * FROM dati_tacid Group by Marca");
        $query = mysqli_query($db_link,"SELECT * FROM lista_tabelle order by ordine desc") or die(mysql_error());
        $row = mysqli_fetch_assoc($query);
        $ultima_tabella = $row['nome_tabella'];
        $q = mysqli_query($db_link,"select sum(n_modello2) as numero, dati_tacid.Modello, dati_tacid.Marca, Tac1
    from $ultima_tabella inner join dati_tacid on $ultima_tabella.Tac1=dati_tacid.TacId  group by Marca order by Marca ASC");
        
        $q = mysqli_query($db_link,"SELECT DISTINCT `Marca` FROM `dati_tacid` where 1 order by Marca ASC");
        
        while ($row = mysqli_fetch_assoc($q)) {
            echo '<option style=\"background-color: lightyellow;\" value="' . $row['Marca'] . '">' . $row['Marca'] . '</option>';
        }
        
       echo" </select>
   
        </td>
           <td $display_none><input type=\"submit\"  $disabled value=\"Modify\"></td>
        </form>  
       
        </tr>";
    ################### Modifica nome tel #############################
    //if (substr($nome_tel, -1, 1) == '*') {
    /*
       echo "<tr align=\"left\"><th style='width:140px'>Nome del Device</th><td>$nome_tel</td>
            <form name=\"form1\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&update_lsoc&nome_tel=" . base64_encode($nome_tel) . "\">        
               <td> <input type=\"text\" name=\"devicename\"> </td>
        
            <td>  
           <input type=\"submit\"  $disabled value=\"Modify\"></td>
            </form> 
        </tr>";
     */   
    
    echo "<tr class=\"hover\" align=\"left\"><th>Nome device</th>
                 <form name=\"form1\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&update_lsoc&nome_tel=" . base64_encode($nome_tel) . "\">
           
                    <td>$nome_tel</td><td $display_none>
    
        <select  style=\"width: 175px; background-color: #FFEBE0;\" name=\"devicename\">
        
                
       <option value=\"\">-- Select Model --</option>";
        connect_db();
        //$q = mysqli_query($db_link,"SELECT * FROM dati_tacid Group by Marca");
        $query = mysqli_query($db_link,"SELECT * FROM lista_tabelle order by ordine desc") or die(mysql_error());
        $row = mysqli_fetch_assoc($query);
        $ultima_tabella = $row['nome_tabella'];
        #$q = mysqli_query($db_link,"select sum(n_modello2) as numero, dati_tacid.Modello, dati_tacid.Marca, Tac1
    #from $ultima_tabella inner join dati_tacid on $ultima_tabella.Tac1=dati_tacid.TacId  group by Marca order by numero desc");
        #$q = mysqli_query($db_link,"select sum(n_modello2) as numero, dati_tacid.Modello, dati_tacid.Marca, Tac1 from $ultima_tabella inner join dati_tacid on $ultima_tabella.Tac1=dati_tacid.TacId  WHERE marca = '$vendor' group by Modello order by Modello ASC ") or die(mysql_error());
        $q = mysqli_query($db_link,"SELECT * FROM `dati_tacid` WHERE Marca='$vendor' group by Modello order by Modello ASC ") or die(mysql_error());
        while ($row = mysqli_fetch_assoc($q)) {
            echo '<option style=\"background-color: lightyellow;\" value="' . $row['Modello'] . '">' . $row['Modello'] . '</option>';
        }
        
       echo" </select></td>
           <td $display_none><input type=\"submit\"  $disabled value=\"Modify\"></td>
        </form>  
        </tr>
        ";
   //}
   
    echo "</table>";
 
 $q1 = "SELECT `temp` . * , `dati_requisiti` . *, count(*) as tot 
	FROM `socmanager`.`dati_requisiti`
	left JOIN (
	SELECT nome_tel,valore_requisito,id_requisito,note
	FROM `dati_valori_requisiti`
	WHERE nome_tel = '$nome_tel' AND vendor = '$vendor'
	) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.`lista_req` LIKE '%".$obj1['devicetype']."%' AND  `dati_requisiti`.`summary` >0 ";
 
 $q1 = mysqli_query($db_link,$q1) or die(mysql_error());
 $r1 = mysqli_fetch_assoc($q1);
 $tot_mand = $r1['tot'];
 
 $q2 = mysqli_query($db_link,"SELECT *, count(*) as tot FROM `dati_requisiti` WHERE `lista_req` like '%".$obj1['devicetype']."%'") or die(mysql_error());
 $r2 = mysqli_fetch_assoc($q2);
 $tot = $r2['tot'];
 
 $q3 = "SELECT `temp` . * , `dati_requisiti` . *, count(*) as tot 
	FROM `socmanager`.`dati_requisiti`
	left JOIN (
	SELECT nome_tel,valore_requisito,id_requisito,note
	FROM `dati_valori_requisiti`
	WHERE nome_tel = '$nome_tel' AND vendor = '$vendor'
	) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.`lista_req` LIKE '%".$obj1['devicetype']."%' AND  `dati_requisiti`.`summary` >0 AND ((`valore_requisito` = '' OR `valore_requisito` IS NULL) AND (`note` = '' OR `note` IS NULL))";

 $res = mysqli_query($db_link,$q3);
 $r3 = mysqli_fetch_assoc($res);
 $tot_mand_empty = $r3['tot'];
 if ($tot_mand_empty > 0) $box_tr_color = "background-color:#B5C0CF;"; else $box_tr_color = '';
 echo "
       <div style=\"float:right; background-color:whitesmoke; width:200px; height:100px; border:1px solid white; $visibility\">
            <table border='1' align=\"center\">
            <tr align=\"left\"><th style='width:140px;'>Totale Requisiti</th><td>$tot</td></tr>
            <tr align=\"left\"><th style='width:140px;'>Requisiti mandatori</th><td>$tot_mand</td></tr>
            <tr align=\"left\" style='width:140px; $box_tr_color'><th style='width:140px;'>Req. mandatori vuoti</th><td>$tot_mand_empty</td></tr>
            </table>
        </div>
        <a $href_image><img style=\"border-color:white;margin-left:60px;margin-bottom:10px; width:auto; height:auto; max-height: 193px; \" src=$src_image   title=\"$title\" /></a>
    
 </div>";

########################################################################## 
################################### inizio LSoC ##########################
##########################################################################

 echo "<div class=\"pagination\"><form name=\"formLSOC\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&update_lsoc&nome_tel=" . base64_encode($nome_tel) ."\" />";
    echo "<table border='1' align=\"center\" title=\"Modifica Light SoC \">";
    echo "<tr align=\"left\"><th style='width:240px'>ID Requisito</th><th style='width:240px'>Descrizione Requisito</th>";
    
    ########### Label ############################
    #echo"<th style='width:240px'>Label</th>";
    
    echo"<th style='width:240px'>Risposta</th><th style='width:240px'>Nota</th><th $display_none></th></tr>";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $area_first = "";
    while ($obj3 = mysqli_fetch_array($result3)) {
        
        $area_name = $obj3['area_name'];
        // colore sfondo summary o extended ///////////
        if ($obj3['summary'] == 1)
            #$color_tr = 'style="background-color: #B5C0CF;";';
            $color_tr = 'class="summary_uno"';
            #$color_tr = '#B5C0CF;';
            #$color_tr = '#eeeeee';
        else
            #$color_tr = 'whitesmoke;';
        $color_tr = 'class="hover"';
        if ($obj3['summary'] == 1 && empty($obj3['valore_requisito']) && empty($obj3['note'])) {
            $color_text = 'blue';
            $background = '#FFEBE0;';
        } elseif (($obj3['summary'] != 1) && (empty($obj3['valore_requisito']))) {
            $color_text = 'blue';
            $background = 'white;';
        } else {
            $color_text = 'black';
            $background = 'white;';
        }
        if (empty($obj3['note'])) $color_textnote = 'blue;'; else $color_textnote = 'black;';
        
        ////////////////////////////////////////////
           if ( $area_first != $area_name ) {
            echo "<tr style=\"font-size:15px; color: white; background-color:#666666\"><td colspan=\"4\" ><b>$area_name</b></td><td style=\"font-size:15px; color: black; background-color:#666666\" $display_none >"
                    . "<INPUT TYPE='submit'  $disabled  name=\"submit[".$obj3['id']."]\"  VALUE='Modify' onClick=\"this.form.submit();\"></td></tr>";
           }
        
        echo "<tr $color_tr >";
        echo "<td><a name=\"".$obj3['id']. "\"><textarea readonly style=\"width: 185px; height:38px; background-color:#eeeeee\">" . $obj3['nome_requisito'] . "</textarea></td>" .
             "<td><textarea readonly style=\"width: 185px; height:38px; background-color:#eeeeee\">" . $obj3['label'] . "</textarea></td>";
        
        ######## LABEL ############
        #echo "<td><textarea  style=\"background-color:#eeeeee\" NAME=\"valore_label\">" . $obj3['label'] . "</textarea></td>";
        
        
        if ($obj3['opzioni_requisito'] != "") {#echo $obj3['opzioni_requisito'];
            echo "<td><select name=\"valore_req[".$obj3['id']."]\" style=\"width: 190px; height:43px; background-color: $background\">";
            $pieces = explode(';', trim($obj3['opzioni_requisito']));
            #echo "<option value=\"$pieces[$i]\"></option>";
            for ($i = 0; $i < count($pieces); $i++) {
                $selected = "";
                if (($pieces[$i] == $obj3['valore_requisito']) && ($pieces[$i] != ""))
                    $selected = "selected";
                #$val_select = "val_select_" . $obj3['id'];
                echo "<option  value=\"$pieces[$i]\"  $selected>$pieces[$i]</option>";
                #echo substr_compare($obj3['opzioni_requisito'], $obj3['valore_requisito'], 1)."<br>".$obj3['valore_requisito']."--".$obj3['opzioni_requisito']."<br>";
            }
            echo "</select></td>";
        }
        
        /////////////////////////////////////////
        // Requisiti speciali legati ad uno sheet
        elseif ($obj3['summary'] == 2 ){
            echo "<td><textarea readonly style=\"width: 185px; height:38px; background-color:#eeeeee\" name=\"valore_req[".$obj3['id']."]\">"  . $obj3['label'] . "</textarea></td>";
        }
        /////////////////////////////////////////
        else
            echo "<td><textarea style=\"width: 185px; height:38px; color: $color_text; background-color: $background\" name=\"valore_req[".$obj3['id']."]\">" . $obj3['valore_requisito'] . "</textarea></td>";

        echo "<td><textarea  style=\"width: 185px; height:38px; color: $color_text; background-color: $background\" name=\"nota[".$obj3['id']."]\">" . $obj3['note'] . "</textarea></td>" .
             "<td $display_none></td></tr>";

        #echo "<input type=\"hidden\" name=\"aggiorna\"></tr> ";
    
       $area_first = $area_name;
       }
    echo "</table></form></div>";
}

function modify_td($nome_tel) {
    $db_link = connect_db_li();
    #delete_td($nome_tel);
    $query = "Select * from  `dati_requisiti`";
    $result3 = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_array($result3)) {

        if (isset($_POST[$obj3['id']])) {
            #$i = $_POST[$obj3['id']] ;
            #$note = $_POST[$note];
            $query4 = "INSERT INTO  `socmanager`.`dati_valori_requisiti` (`id` ,`id_requisito` ,`nome_tel`,`valore_requisito`,`data_inserimento`,`note` )
                VALUES (NULL ,  '" . $obj3['id'] . "',  '" . $nome_tel . "','" . $_POST[$obj3['id']] . "','" . date("Y-m-d") . "','" . date("Y-m-d") . "')";
            //echo "<br>" . $query4;
            #		$result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
            #$_POST[$obj3['id']];
            #print_r($_POST[$obj3['id']]);
            echo '<br>note<br>';
            #print_r($note);
        }
    }
}

function delete_td($telefoni) {
    $db_link = connect_db_li();
    $query3 = "DELETE FROM `socmanager`.`dati_valori_requisiti` WHERE `dati_valori_requisiti`.`nome_tel` = '$telefoni'";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "<br>Device $telefoni eliminato con successo<br><br><a class=\"puno\" href=\"index.php?page=gestioneLSoc/admin_lsoc\">Back</a>";
    //$obj3 = mysqli_fetch_array($result3);    
}

function elimina_lsoc( $vendor, $devicename) {
    $db_link = connect_db_li();
    $query3 = "DELETE FROM `socmanager`.`dati_valori_requisiti` WHERE (`dati_valori_requisiti`.`nome_tel` = '$devicename')  and (`dati_valori_requisiti`.`vendor` = '$vendor')";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "<br>La Light SoC del device<b> $devicename </b>&egrave; stata eliminato con successo<br><br><a class=\"puno\" href=\"index.php?page=gestioneLSoc/admin_lsoc\">Back</a>";
    //$obj3 = mysqli_fetch_array($result3);
}

function stampa_profilo_confronto($telefoni, $tipofiltro, $devicetype_filter) {//verificato
    #print_r($_POST);
    $db_link = connect_db_li();
    if ($tipofiltro == 'extended') {
        $summary_value = array(0, 1);
    } elseif ($tipofiltro == 'summary') {
        $summary_value = array(1);
    }

    $telefoni = $_POST['telefoni'];
    $temp = "";
    /*  if (count($telefoni) > 3)
      $limite = 3;
      else
      $limite = count($telefoni); */
    for ($i = 0; $i < count($telefoni); $i++) {
        $temp = $temp . ";" .$telefoni[$i];
    }
    ?>
                 
        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "RFI Comparison"; ?><small><?php #echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                        
                       <?php echo "<li><a target=\"_blank\" href=export_confronto.php?telefoni=" . base64_encode(serialize($_POST['telefoni'])) . "&filtro=" . $tipofiltro . "><img  src=\"excel-icon.png\" alt=\"Export confronto\" /></a></li>"; ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                
                
                
                
                <div class="x_content">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        
                    
                        <thead>
                            <tr>
                           <th>n°</th><th>Area</th><th>Requirement Description</th>

<?php

        
    /////// Stampa immagini Device

    for ($i = 0; $i < count($telefoni); $i++) {
     
        echo "<th>" . $telefoni[$i] . "</th>";
    }
    
    echo "</tr></thead><tbody>";
   
    $query3 = "";
    $query3 = $query3 . "SELECT `dati_requisiti`.id,`dati_requisiti`.area_name,`dati_requisiti`.descrizione_requisito,`dati_requisiti`.ordine, `dati_requisiti`.stato, `dati_requisiti`.nome_requisito,`dati_requisiti`.label,`dati_requisiti`.summary, `dati_requisiti`.lista_req, `dati_valori_requisiti_temp`.valore_requisito as valore_requisito_0 ";
    for ($i = 1; $i < count($telefoni); $i++) {
        $query3 = $query3 . " ,`dati_valori_requisiti_temp$i`.valore_requisito as valore_requisito_$i";
    }
    $query3 = $query3 . " FROM `dati_requisiti` left JOIN (select * From `dati_valori_requisiti` where nome_tel='" . $telefoni[0] . "') as  dati_valori_requisiti_temp
			ON `dati_valori_requisiti_temp`.`id_requisito` = `dati_requisiti`.`id`  ";
    for ($i = 1; $i < count($telefoni); $i++) {
        $query3 = $query3 . " left JOIN ( select * From `dati_valori_requisiti` where  nome_tel='" . $telefoni[$i] . "') as  dati_valori_requisiti_temp$i ON `dati_valori_requisiti_temp$i`.`id_requisito` = `dati_requisiti`.`id`  ";
    }
    
    $query3 = $query3 ." where `dati_requisiti`.stato=1 order by ordine ";
    
    #echo "<br>".$query3."<br>";
    #echo "<table border='1'>"; 
    $count = 1;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_array($result3)) {
        
        #print_r($obj3);
        #if (in_array($obj3['summary'], $summary_value) and (strpos($obj3['lista_req'],$devicetype_filter) !== false) || ($devicetype_filter == "All") ) {
            echo "<tr>";
            echo "<td>$count</td><td>" . $obj3['area_name'] . "</td><td>" . $obj3['descrizione_requisito'] . "</td>";
            #$temp = "";
            #$order = array("\r\n", "\n", "\r");
            
            foreach ($telefoni as $key => $value) {
                $valore_req = $obj3['valore_requisito_' . $key];
                #$valore_req = str_replace($order, '', trim($obj3['valore_requisito_' . $key]));
                #if (($temp == str_replace($order, '', trim($valore_req))) && ($count > 1) && ($temp != ""))
                   #echo "<td  align=\"center\" ><textarea disabled rows=\"2\" style=\"background:#CCCCCC;\">" . $valore_req . "</textarea></td>";
                        echo "<td>" . $valore_req . "</td>";
                #else
                #    echo "<td>" . $valore_req . "</td>";
                #$temp = str_replace($order, '', trim($valore_req));
                
            }
            echo "</tr>";
            $count++;
        #}
    }
    echo "</tbody></table>";
    echo "</div></div></div></div>";
}

function stampa_requisiti_confronto($requisiti, $tipofiltro, $devicetype_filter) {//verificato
    #print_r($_POST);
    $db_link = connect_db_li();
    if ($tipofiltro == 'extended') {
        $summary_value = array(0, 1);
    } elseif ($tipofiltro == 'summary') {
        $summary_value = array(1);
    }

    $requisiti = $_POST['table_terminali'];
    $temp = "";

    
     reset($requisiti);
        $lista_IN_query = '';
        while (list($key, $value) = each($requisiti)) {

            if($key > 0){
               $lista_IN_query = $lista_IN_query." ,'$value'"; 
            }
            else
                $lista_IN_query = $lista_IN_query." '$value'";
                
        }
    $query_req = "SELECT dati_requisiti.id,dati_valori_requisiti.id_project,dati_valori_requisiti.devicetype,dati_valori_requisiti.vendor,dati_valori_requisiti.nome_tel,dati_requisiti.nome_requisito,dati_requisiti.descrizione_requisito,dati_requisiti.label,dati_valori_requisiti.valore_requisito, dati_valori_requisiti.note,dati_valori_requisiti.market,dati_valori_requisiti.data_inserimento FROM `dati_valori_requisiti` LEFT join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito where dati_requisiti.id IN ($lista_IN_query)  Group BY id_project ORDER BY id_project, dati_requisiti.id ASC";   
    
    ?>
                 
        <div class="col-md-12 col-sm-12 col-xs-12"> 
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "RFI Comparison"; ?><small><?php #echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                        
                       <?php #echo "<li><a target=\"_blank\" href=export_confronto.php?telefoni=" . base64_encode(serialize($_POST['telefoni'])) . "&filtro=" . $tipofiltro . "><img  src=\"excel-icon.png\" alt=\"Export confronto\" /></a></li>"; ?>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                
                
                
                
                <div class="x_content">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        
                    
                        <thead>
                            <tr>
                           <th>n°</th><th>Area</th><th>Requirement Description</th>

<?php

        
    /////// Stampa immagini Device

    for ($i = 0; $i < count($requisiti); $i++) {
     
        echo "<th>" . $requisiti[$i] . "</th>";
    }
    
    echo "</tr></thead><tbody>";
   
    $query3 = "";
    $query3 = $query3 . "SELECT `dati_requisiti`.id,`dati_requisiti`.area_name,`dati_requisiti`.descrizione_requisito,`dati_requisiti`.ordine, `dati_requisiti`.stato, `dati_requisiti`.nome_requisito,`dati_requisiti`.label,`dati_requisiti`.summary, `dati_requisiti`.lista_req, `dati_valori_requisiti_temp`.valore_requisito as valore_requisito_0 ";
    for ($i = 1; $i < count($requisiti); $i++) {
        $query3 = $query3 . " ,`dati_valori_note_temp$i`.note as note_$i ,`dati_valori_requisiti_temp$i`.valore_requisito as valore_requisito_$i";
    }
    $query3 = $query3 . " FROM `dati_requisiti` left JOIN (select * From `dati_valori_requisiti` where id_requisito='" . $requisiti[0] . "') as  dati_valori_requisiti_temp
			ON `dati_valori_requisiti_temp`.`id_requisito` = `dati_requisiti`.`id`  ";
    for ($i = 1; $i < count($requisiti); $i++) {
        $query3 = $query3 . " left JOIN ( select * From `dati_valori_requisiti` where  id_requisito='" . $requisiti[$i] . "') as  dati_valori_requisiti_temp$i ON `dati_valori_requisiti_temp$i`.`id_requisito` = `dati_requisiti`.`id`  ";
    }
    
    $query3 = $query3 ." where `dati_requisiti`.stato=1 order by ordine ";
    
    echo "<br>".$query3."<br>";
    #echo "<table border='1'>"; 
    $count = 1;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_assoc($result3)) {
        
        print_r($obj3);
        #if (in_array($obj3['summary'], $summary_value) and (strpos($obj3['lista_req'],$devicetype_filter) !== false) || ($devicetype_filter == "All") ) {
            echo "<tr>";
            echo "<td>$count</td><td>" . $obj3['area_name'] . "</td><td>" . $obj3['id'] . "</td><td>" . $obj3['descrizione_requisito'] . "</td>";
            #$temp = "";
            #$order = array("\r\n", "\n", "\r");
            
            foreach ($requisiti as $key => $value) {
                $valore_req = $obj3['valore_requisito_' . $key];
                #$valore_req = str_replace($order, '', trim($obj3['valore_requisito_' . $key]));
                #if (($temp == str_replace($order, '', trim($valore_req))) && ($count > 1) && ($temp != ""))
                   #echo "<td  align=\"center\" ><textarea disabled rows=\"2\" style=\"background:#CCCCCC;\">" . $valore_req . "</textarea></td>";
                        echo "<td>" . $valore_req . "</td>";
                #else
                #    echo "<td>" . $valore_req . "</td>";
                #$temp = str_replace($order, '', trim($valore_req));
                
            }
            echo "</tr>";
            $count++;
        #}
    }
    echo "</tbody></table>";
    echo "</div></div></div></div>";
}

function insert_profilo_telefono($full_path, $modello, $update, $vendor, $devicetype, $tipo_lsoc) {
    $db_link = connect_db_li();

    if (!file_exists($full_path)) {
        exit("File non pervenuto." . EOL);
    }


    $numero_inserimenti = 0;
    $numero_modifiche = 0;
    $requisiti_letti = 0;

    $inputFileName = $full_path;

    /**  Identify the type of $inputFileName  * */
    $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
    /**  Create a new Reader of the type that has been identified  * */
    $objReader = PHPExcel_IOFactory::createReader($inputFileType);
    /**  Load $inputFileName to a PHPExcel Object  * */
    $objPHPExcel_reader = $objReader->load($inputFileName);
    $objPHPExcel_reader->getActiveSheet(0);
    $data_inserimento = date("Y-m-d");


    for ($i = 0; $i < $objPHPExcel_reader->getSheetCount(); $i++) {
        $worksheet = $objPHPExcel_reader->getSheet($i);

        foreach ($worksheet->getRowIterator() as $row) {

            $id_req = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
            $mandatory_optional = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
            
            if ($tipo_lsoc == 'newlsoc') { 
            ############################## New Light SoC 3ITA #################################################
            $answer = $worksheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
            $nota = $worksheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
            }
            elseif ($tipo_lsoc == 'oldlsoc') {
            ############################## Light SoC Glogal ###################################################
                $answer = $worksheet->getCellByColumnAndRow(5, $row->getRowIndex())->getValue();
                $nota = $worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue();
            ##################################################################################
            }
         
            #$options = str_replace("\"", "", str_replace(",", ";", $options_validation));
            
            ##### check id univoco
            $query3 = "SELECT id,count(id)as numero_record  FROM `dati_requisiti` WHERE (`nome_requisito` = '" . $id_req . "' AND `lista_req` LIKE '%".$devicetype."%')";
            $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
            $obj3 = mysqli_fetch_array($result3);
            ####### check valore univoco
            $query0 ="SELECT dati_requisiti.nome_requisito, dati_valori_requisiti.id_requisito, COUNT( dati_valori_requisiti.id_requisito ) AS num_id_requisito
                      FROM  `dati_valori_requisiti` left join dati_requisiti on dati_requisiti.id = dati_valori_requisiti.id_requisito
                      WHERE (dati_requisiti.nome_requisito = '".$id_req."' AND dati_valori_requisiti.nome_tel =  '".$modello."' AND dati_valori_requisiti.vendor =  '".$vendor."')";
                    
            $result0 = mysqli_query($db_link,$query0) or die($query0 . " - " . mysql_error());
            $obj0 = mysqli_fetch_array($result0);


            $value = mysql_real_escape_string($answer);
            $note = mysql_real_escape_string($nota);
            #$value = $answer;
            #$note = $nota;

            #echo "$note $value <br>";
            
            if ($obj3['numero_record'] == 1) {

                if (($mandatory_optional == "M") || ($mandatory_optional == "O") || ($mandatory_optional == "1") || ($mandatory_optional == "2") ) {
                    $requisiti_letti++;
                    #echo $obj0['num_id_requisito']."_";
                    if (($obj0['num_id_requisito']) == 0) {
                        $query4 = "INSERT INTO  `socmanager`.`dati_valori_requisiti` (`id` ,`id_requisito` ,`nome_tel`,`valore_requisito`,`data_inserimento`,`note`,`data_accettazione`,`vendor`,`devicetype`) VALUES (NULL ,  '" . $obj3['id'] . "',  '" . $modello . "','" . $value . "','" . $data_inserimento . "','" . $note . "','" . $data_inserimento . "','" . $vendor . "','" . $devicetype . "')";
                        $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                    } elseif ($obj0['num_id_requisito'] == 1){
                        
                            $query4 = "UPDATE  `socmanager`.`dati_valori_requisiti` SET  `valore_requisito` =  '" . $value . "',`data_inserimento` =  '" . $data_inserimento . "', `note` =  '" . $note . "',`data_accettazione` =  '" . $data_inserimento . "', `devicetype` =  '" . $devicetype . "' WHERE  nome_tel='" . $modello . "' and id_requisito='" . $obj3['id'] . "'";
                            $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
                            $numero_modifiche++;
                        
                    }
                    
                    // echo "<br>".$query4;
                }
            }
        }
    }
    #echo "<br><br><h5>File --> $inputFileName </h5>";
    echo "<br><br><h5>Inseriti $numero_inserimenti requisiti con successo</h5>";
    echo "<br><h5>Modificati $numero_modifiche requisiti con successo</h5>";
    echo "<br><h5>Totale Requisiti letti $requisiti_letti</h5>";
    echo "<br><h5><a href=\"index.php?page=gestioneLSoc/admin_lsoc\">Back</a></h5>";
}

function insert_profilo_vuoto($modello, $vendor, $devicetype, $tipo_lsoc) {
    $db_link = connect_db_li();

    if ( $tipo_lsoc != "nolsoc") {
        exit("Inserimento Fallito!!!");
    }

    $data_inserimento = date("Y-m-d");

     ##### check Device esistente
            $query3 = "SELECT id,count(id)as numero_record  FROM `dati_valori_requisiti` WHERE (`nome_tel` = '" . $modello . "' AND `devicetype` = '".$devicetype."%' AND `vendor` = '" . $vendor . "' )";
            $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
            $obj3 = mysqli_fetch_array($result3);
    
    if ($obj3['numero_record'] == 0) {
    
    $query4 = "INSERT INTO  `socmanager`.`dati_valori_requisiti` (`id` ,`id_requisito` ,`nome_tel`,`valore_requisito`,`data_inserimento`,`note`,`data_accettazione`,`vendor`,`devicetype`) VALUES (NULL ,  '11025', '" . $modello . "',' ','" . $data_inserimento . "',' ','" . $data_inserimento . "','" . $vendor . "','" . $devicetype . "')";
    
    
    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
    
    
    }
    
    
    echo "<br><br><h5>Inserito device $vendor  $modello  con successo</h5>";
    echo "<br><h5><a href=\"index.php?page=gestioneLSoc/admin_lsoc\">Back</a></h5>";
}


function insert_update_template_lsoc($full_path, $modello, $update = false) {
    $db_link = connect_db_li();
    require_once 'Excel/reader.php';
    $data = new Spreadsheet_Excel_Reader();
    $data->setOutputEncoding('ISO-8859-1//IGNORE'); // Set output Encoding.
    $data->read($full_path);
    error_reporting(E_ALL ^ E_NOTICE);
    connect_db();
    //echo "<table border='1'>";
    $numero_inserimenti = 0;
    for ($m = 0; $m < 34; $m++) {
        for ($i = 1; $i <= $data->sheets[$m]['numRows']; $i++) {

            //$query3 = "SELECT id,count(id)as numero_record  FROM `dati_requisiti` WHERE `nome_requisito` LIKE '" . $data->sheets[$m]['cells'][$i][1] . "'";
            //	$result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
            //$obj3 = mysqli_fetch_array($result3);
            //if ($obj3['numero_record'] == 1) {
            if ($data->sheets[$m]['cells'][$i][3] == "M") {
                if (($data->sheets[$m]['cells'][$i][4] == "New")) {
                    $query4 = "INSERT INTO  `socmanager`.`dati_requisiti` (
							`id` ,
							`nome_requisito` ,
							`descrizione_requisito` ,
							`label` ,
							`summary` ,
							`stato` ,
							`data`
							`mandatoryoptional`
							)
							VALUES (
							NULL ,  '" . $data->sheets[$m]['cells'][$i][1] . "',
									'" . $data->sheets[$m]['cells'][$i][2] . "',
									'','',
									'" . $data->sheets[$m]['cells'][$i][5] . "',
									'" . $data->sheets[$m]['cells'][$i][6] . "'
									'" . $data->sheets[$m]['cells'][$i][3] . "'		
									);";
                    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
                    $numero_inserimenti++;
                } else if (($data->sheets[$m]['cells'][$i][4] == "Modify")) {

                    $query4 = "UPDATE  `socmanager`.`dati_requisiti` SET  `descrizione_requisito` =  '" . $data->sheets[$m]['cells'][$i][2] . "',
							`stato` =  '" . $data->sheets[$m]['cells'][$i][5] . "',
									`data` =  '" . $data->sheets[$m]['cells'][$i][6] . "',
											`mandatoryoptional` =  '" . $data->sheets[$m]['cells'][$i][3] . "' WHERE  `dati_requisiti`.`nome_requisito` =" . $data->sheets[$m]['cells'][$i][1] . ";
													);";
                    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
                    $numero_inserimenti++;
                }
            }
        }
    }
    echo "<h2>Sono stati inseriti $numero_inserimenti requisiti con successo</h2>";
}

function export_tabella_specifiche() {
    $db_link = connect_db_li();

    connect_db();
    $today = date("y_m_d");
    header("Content-Disposition: attachment; filename=\"" . $today . "_Export_tabella_specifiche.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;
    $query3 = " select * from dati_requisiti";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "ID REQUISITO \t DESCRIZIONE REQUISITO \t ETICHETTA \t MANDATORIO (Optional) \t DATA (Optional)  \t RISPOSTA \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        echo trim($obj3['nome_requisito']) . "\t " . trim($obj3['descrizione_requisito']) . "\t " . trim($obj3['label']) . "\n";
    }
}

function numero_requisiti_telefono($modello) {
    $db_link = connect_db_li();
    $query3 = "select count(id) as numero_requisiti from dati_valori_requisiti where nome_tel='$modello'";
    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    if (isset($obj3['numero_requisiti']))
        return $obj3['numero_requisiti'];
    else
        return 0;
}

function cerca_telefoni($criterio, $lista_valori) {
    $db_link = connect_db_li();
    
    
    $query4 = "SELECT * FROM  `socmanager`.`dati_requisiti` WHERE  `id` =$criterio";
    #echo $query4;
    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
    $obj4 = mysqli_fetch_array($result4);
    
            echo '<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>Confronto tra tutti i Device<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br />';
    
    echo "<table><thead><tr align=left><th>Requisito  selezionato</th><th>Valore filtro</th></tr>";
    //$all = false;
    $query3 = "SELECT *  FROM `dati_valori_requisiti` join dati_requisiti on dati_requisiti.id=`dati_valori_requisiti`.id_requisito WHERE id_requisito='$criterio'";
    echo $query3;
    $filtro = "";
    $all = false;
    foreach ($lista_valori as $key => $value) {
        echo "<tr><td><textarea readonly style=\"font-weight: bold;background-color:lightyellow;\" rows=\"2\">" . $obj4['label'] . "</textarea></td><td><textarea readonly style=\"font-weight: bold;background-color:lightyellow;\" rows=\"2\">" . $value . "</textarea></td></tr>";
        if ($value == "All") {
            $all = true;
        }
        if ($key > 0)
            $and = " or";
        else
            $and = " and (";
        $filtro = $filtro . $and . "  valore_requisito='$value'";
        if ($key == count($lista_valori) - 1)
            $filtro = $filtro . ")";
    }
    if ($all == true) {
        $filtro = "";
    }
     echo "</table><br>";

        echo "<table border='1' align=\"center\" title=\"Modifica Light SoC \">";
    echo "<tr align=\"left\"><th style='width:240px'>Vendor</th><th style='width:240px'>Requisito Selezionato</th><th style='width:240px'>Note</th>";

    
    echo"</tr>";
	
    $query3 = $query3 . $filtro." order by dati_valori_requisiti.vendor";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $vendor_first = "";
    while ($obj3 = mysqli_fetch_array($result3)) {
        
        $vendor_name = ucfirst($obj3['vendor']);
	
	if ( $vendor_first != $vendor_name ) {
        
            echo "<tr><td colspan=\"1\" style=\"font-size:15px; color: white; background-color:#666666\"><b>$vendor_name</b></td><td colspan=\"1\" style=\"font-size:15px; color: white; background-color:#666666\"><b>".$obj4['label']."</b></td><td colspan=\"1\" style=\"font-size:15px; color: white; background-color:#666666\"><b>Note</b></td></tr>";
           }

           if ($obj3['valore_requisito'] == "" or $obj3['valore_requisito'] == null) {
                $obj3['valore_requisito'] = "Not Defined";
                $background_color = 'background-color:#FFEBE0;'; 
            }    
            else $background_color = ''; 
           
           $nome_device = base64_encode($obj3['nome_tel']);
           $link = "http://".$_SERVER['SERVER_ADDR']."/index.php?page=grafici&update_lsoc&nome_tel=".$nome_device;
           
           echo "<tr class=\"hover\"><td style=\"font-weight: bold;\"><a target=\"_blank\" href=\"http://".$_SERVER['SERVER_ADDR']."/index.php?page=grafici&update_lsoc&nome_tel=".$nome_device."\">   ". $obj3['nome_tel'] ." </a></td>" .
                   "<td style=\"$background_color\">" . $obj3['valore_requisito'] . "</td><td style=\"$background_color\">" . $obj3['note'] . "</td><tr>";

    
    $vendor_first = $vendor_name;       
           
           
    }
echo "</table>";
 echo "</div></div></div></div>";

}


function summary_lsoc($devicename, $tipo_terminale) {
    $db_link = connect_db_li();
    $today = date("y_m_d");
    
    
    if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `nome_requisito`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `nome_requisito`";
        
            $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $lsoc[$row['nome_requisito']] = $row['valore_requisito'];
               
            }
       }
       print_r($lsoc);
    
    //header("Content-Disposition: attachment; filename=\"" . $today . "_Soc_summary.ppt\"");
    //header("Content-Type: application/vnd.ms-powerpoint");
    //header("Content-disposition: attachment; filename= 'Soc_summary.pptx'");
    //header('Content-type: application/vnd.ms-powerpoint');
    
      
       
    error_reporting(E_ALL);

    /** Include path * */
    #set_include_path('PPT/PHPPowerPoint-master/Classes/');
    #include_once 'PHPPowerPoint.php';

    /** PHPPowerPoint */
    include_once 'newPHPClass.php';
    include_once 'funzioni.php';


    // Create new PHPPowerPoint object
    //echo date('H:i:s') . " Create new PHPPowerPoint object\n";
    $phpPower = new phpPowerClass();
    
    #$phpPower = new phpPowerClass();
    
    #$pptReader = IOFactory::createReader('PowerPoint2007');
    #$pptLoad = $phpPower->load('pdf.pptx');

    
    #$oReader = IOFactory::createReader('PowerPoint2007');
    #$oReader->load(__DIR__ . '/template_summary.pptx');

    $current_slide = $phpPower->createSlide();
$phpPower->create_title('New devices description', $current_slide, '30');
/*
$lista_requisiti = array(
    'GEN-INFO-PDG-07.01', 'HW-INFO-PDG-01.01', 'HW-INFO-PDG-01.02',
    'HW-INFO-PDG-02.01', 'HW-INFO-PDG-02.03', 'HW-INFO-PDG-02.04',
    'HW-INFO-PDG-03.01', 'LS-RADIO-02.02', 'LS-RADIO-03.02',
    'HW-INFO-PDG-04.01', 'HW-INFO-PDG-05.01', 'HW-INFO-PDG-05.02',
    'HW-INFO-PDG-05.03', 'HW-INFO-PDG-12.01', 'HW-INFO-PDG-13.02',
    'HW-INFO-PDG-13.02.01', 'HW-INFO-PDG-13.03', 'HW-INFO-PDG-13.03.01', 'HW-INFO-PDG-15.01.05');
$lista_requisiti = array(
    'GEN-INFO-PDG-07.01', 'HW-INFO-PDG-01.01', 'HW-INFO-PDG-01.02',
    'HW-INFO-PDG-02.01', 'HW-INFO-PDG-02.03', 'HW-INFO-PDG-02.04',
    'HW-INFO-PDG-03.01', 'LS-RADIO-02.02', 'LS-RADIO-03.02',
    'HW-INFO-PDG-04.01', 'HW-INFO-PDG-05.01', 'HW-INFO-PDG-05.02',
    'HW-INFO-PDG-05.03', 'HW-INFO-PDG-12.01', 'HW-INFO-PDG-13.02',
    'HW-INFO-PDG-13.02.01', 'HW-INFO-PDG-13.03.01', 'HW-INFO-PDG-15.01.05');
$lista_requisiti = array(
    'GEN-INFO-PDG-07.01', 'HW-INFO-PDG-01.01', 'HW-INFO-PDG-01.02',
    'HW-INFO-PDG-03.01', 'LS-RADIO-02.02', 'LS-RADIO-03.02',
    'HW-INFO-PDG-04.01', 'HW-INFO-PDG-05.02',
    'HW-INFO-PDG-05.03', 'HW-INFO-PDG-12.01', 'HW-INFO-PDG-13.02',
    'HW-INFO-PDG-13.02.01', 'HW-INFO-PDG-13.03.01', 'HW-INFO-PDG-15.01.05');
$array_new_modelli_6 = lista_new_device($tabella_seme, 12, 6);
$array_telefoni_temp = array();
foreach ($array_new_modelli_6 as $key => $value) {
    $temp = explode('-', $value);
    $array_telefoni_temp[] = $temp[0];
}
$array_telefoni_temp_naz = $array_telefoni_temp;
$array_new_modelli_6_naz = $array_new_modelli_6;
$seriesData = array();
$seriesData[0][] = "Description";

foreach ($array_telefoni_temp_naz as $key => $value) {
    $seriesData[0][] = $value;
}

foreach ($lista_requisiti as $key_requisiti => $value_requisiti) {

    $seriesData[$key_requisiti + 1][] = _valori_generica('dati_requisiti', "`label` as risultato", "where `nome_requisito`='" . $lista_requisiti[$key_requisiti] . "' ", "", "");
    foreach ($array_new_modelli_6 as $key_telefoni => $value_telefoni) {
        $valore = _valori_generica('dati_valori_requisiti', "`valore_requisito` as risultato", " where nome_tel='" . $value_telefoni . "' and nome_requisito= '" . $lista_requisiti[$key_requisiti] . "'", "", " inner join `dati_requisiti` on `id_requisito`=`dati_requisiti`.id ");
        if ($valore != "") {
            $seriesData[$key_requisiti + 1][] = $valore;
        } else {
            $seriesData[$key_requisiti + 1][] = "n/a";
        }
        //$seriesData[$key_requisiti + 1][] = 0;
    }
}

//$phpPower->createTable($current_slide, $seriesData, cmTopixel(28,5), 200, 50, 130, 14, 'FF33CC33');
//$phpPower->createTable($current_slide, $seriesData, cmTopixel(28,5), 200, 50, 130);
$phpPower->createTable($current_slide, $seriesData, 900, 200, cmTopixel(5,56), 80, 7, 'FF00B0F0', 2);

//-----------------------------------------------------------------------------------------------------------
//---------------------------------------------------------------

    // Echo memory peak usage
    //echo date('H:i:s') . " Peak memory usage: " . (memory_get_peak_usage(true) / 1024 / 1024) . " MB\r\n";
    // Echo done
    // echo date('H:i:s') . " Done writing file.\r\n";
 * 
 */

    
    $phpPower->save_template_summary();
    
}


function summary_lsoc_new($devicename, $tipo_terminale) {
    error_reporting(E_ALL);
    require_once './Classes_new/vendor/phpoffice/phppresentation/src/PhpPresentation/Autoloader.php';
        \PhpOffice\PhpPresentation\Autoloader::register();
        require_once './Classes_new/vendor/phpoffice/common/src/Common/Autoloader.php';
        \PhpOffice\Common\Autoloader::register();
        
    $pptReader = IOFactory::createReader('PowerPoint2007');
    $oPHPPresentation = $pptReader->load('./template_summary.pptx');
    #$pptLoad = $phpPower->load('./template_summary.pptx');
    $property = $oPHPPresentation->getDocumentProperties();
    $slides = $oPHPPresentation->getAllSlides();
    echo 'eccolo';
    print_r($slides);
    foreach ($slides as $slide_k => $slide_v) {
        $shapes = $slides[$slide_k]->getShapeCollection();
        foreach ($shapes as $shape_k => $shape_v) {
          $shape = $shapes[$shape_k];
          echo get_class($shape).'</br>';

          if($shape instanceof PhpOffice\PhpPresentation\Shape\RichText){
             $paragraphs = $shapes[$shape_k]->getParagraphs();
             foreach ($paragraphs as $paragraph_k => $paragraph_v) {
               $text_elements = $paragraph_v->getRichTextElements();
               foreach ($text_elements as $text_element_k => $text_element_v) {
                 $text = $text_element_v->getText();
                 $new_text = str_replace('${name}', 'Esfera', $text);
                 $text_element_v->setText($new_text);
               }
             }
          }
        }
      }
      $oWriterPPTX = IOFactory::createWriter($oPHPPresentation);
      $oWriterPPTX->save("./template_summary_".date('YMis').".pptx");
      
}





