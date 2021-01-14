<?php
include_once './classes/funzioni_admin.php';


class Class_lsoc extends funzioni_admin {

    
    function numero_requisiti_telefono($modello) {
        $query3 = "select count(id) as numero_requisiti from dati_valori_requisiti where nome_tel='$modello'";
        //echo $query3;
        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3);
        if (isset($obj3['numero_requisiti']))
            return $obj3['numero_requisiti'];
        else
            return 0;
    }

    function cerca_telefoni($criterio, $lista_valori) {
        $query4 = "SELECT * FROM   `dati_requisiti` WHERE  `id` =$criterio";
        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
        $obj4 = mysqli_fetch_array($result4);
        echo "<table><thead><tr><th style='width:240px'>Lista valori " . $obj4['devicetype'] . "  </th><tr>";
        //$all = false;
        $query3 = "SELECT *  FROM `dati_valori_requisiti` join dati_requisiti on dati_requisiti.id=`dati_valori_requisiti`.id_requisito WHERE id_requisito='$criterio'";
        $filtro = "";
        $all = false;
        foreach ($lista_valori as $key => $value) {
            echo "<tr><td>" . $obj4['devicetype'] . " - " . $value . "</td></tr>";
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
        $query3 = $query3 . $filtro;
        //echo "<br>" . $query3 . "<br>";

        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        $temp = 0;
        while ($obj3 = mysqli_fetch_array($result3)) {
            $risultati[$temp][1] = $obj3['nome_tel'];
            $risultati[$temp][2] = $obj3['valore_requisito'];
            $temp++;
        }
        // }
        echo "</table>";
        echo "<table><thead><tr><th style='width:240px'>Modelli</th><tr>";
        if (isset($risultati) && count($risultati) > 0)
            foreach ($risultati as $value) {
                $valore = "<td>" . $value[2] . "<td>";
                echo "<tr><td>" . $value[1] . "</td>$valore</tr>";
            }
        else
            echo "<tr><td>Non ci sono risultati che corrispondono ad i seguenti criteri</td></tr>";

        echo "</table>";
    }

    function stampa_profilo_telefono($telefono) {
        $query3 = "SELECT `dati_requisiti`.*, `dati_valori_requisiti`.*
                            FROM `dati_valori_requisiti`
                            JOIN  `dati_requisiti` ON `dati_valori_requisiti`.`id_requisito` = `dati_requisiti`.`id`
                            where nome_tel='" . $_POST['model'] . "'
                                            ";
        // echo $query3;
        echo "<table border='1'>";

        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        while ($obj3 = mysqli_fetch_array($result3)) {
            echo "<tr>";
            echo "<td><p>" . $obj3['descrizione_requisito'] . "</p></td>" . "<td><p>" . $obj3['valore_requisito'] . "</p></td>";

            echo "</tr>";
        }
        echo "</table>";
    }

    function stampa_tabella_pivot($telefono, $tipo_table = 1) {
        echo "<table>";
        $query = "SELECT * FROM `tabella_pivot`";
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        while ($obj = mysqli_fetch_array($result)) {
            echo "<tr><td>" . $obj['nome_campo'] . "</td><td>";
            $query2 = "SELECT `tabella_pivot_value`.*,dati_valori_requisiti.*
                    FROM `tabella_pivot_value` join dati_valori_requisiti ON dati_valori_requisiti.id_requisito= `tabella_pivot_value`.id_requisito
                    WHERE nome_tel='$telefono' and `id_valore` =" . $obj['id'] . " ORDER BY `tabella_pivot_value`.`ordine` ASC";
            $result2 = mysqli_query($this->mysqli,$query2) or die($query2 . " - " . mysql_error());
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
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
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


            $result2 = mysqli_query($this->mysqli,$query2) or die($query2 . " - " . mysql_error());
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

    function stampa_tabella_pivot_confronto_summary($telefono, $tipo_table = 1) {

        error_reporting(E_ALL);
        echo "<table>";

        //echo '<td>Feature Table</td>';



        $query = "SELECT * FROM `tabella_pivot` order by ordine";
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
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
                            FROM `tabella_pivot_value` join dati_valori_requisiti ON dati_valori_requisiti.id_requisito= `tabella_pivot_value`.id_requisito  join   `dati_requisiti` ON `tabella_pivot_value`.id_requisito=`dati_requisiti`.id
                            WHERE   nome_tel='$value' and `id_valore` =" . $obj['id'] . " ORDER BY `tabella_pivot_value`.`ordine` ASC";
                //echo $query2."<br>";
                $result2 = mysqli_query($this->mysqli,$query2) or die($query2 . " - " . mysql_error());
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
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
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
                $result2 = mysqli_query($this->mysqli,$query2) or die($query2 . " - " . mysql_error());
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

    function modify_form($nome_tel) {
        $query3 = "SELECT `temp` . * , `dati_requisiti` . *
            FROM  `dati_requisiti`
            left JOIN (

            SELECT nome_tel,valore_requisito,id_requisito
            FROM `dati_valori_requisiti`
            WHERE nome_tel = '$nome_tel'
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id`";

        echo " <form name=\"form1\" enctype=\"multipart/form-data\" method=\"post\" action=\"index.php?page=grafici&tipo_grafico=aggiorna_info_modello&amp;operazioni=insert\">";
        // echo $query3;
        echo "<input type=\"hidden\" name=\"model\" value=\"$nome_tel\">";
        echo "<input type=\"hidden\" name=\"tipo_operazione\" value=\"modify\">";
        echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"aggiorna_info_modello\">";
        echo "<table border='1'>";

        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        while ($obj3 = mysqli_fetch_array($result3)) {
            echo "<tr>";
            echo "<td><p>" . $obj3['devicetype'] . "</p></td>" . "<td><p><input  type=\"text\" name=\"" . $obj3['id'] . "\" size=\"20\" value='" . $obj3['valore_requisito'] . "' ></p></td>";

            echo "</tr>";
        }
        echo "</table>";
        echo "<input style=\"margin-left:120px;\" type=\"submit\" name=\"Submit_TD\" value=\"Submit_TD\">";
    }

    function modify_td($nome_tel) {
        delete_td($nome_tel);
        $query = "Select * from  `dati_requisiti`";
        $result3 = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        while ($obj3 = mysqli_fetch_array($result3)) {
            if (isset($_POST[$obj3['id']])) {
                $query4 = "INSERT INTO   `dati_valori_requisiti` (`id` ,`id_requisito` ,`nome_tel`,valore_requisito)
                                            VALUES (NULL ,  '" . $obj3['id'] . "',  '" . $nome_tel . "','" . $_POST[$obj3['id']] . "');";
                //echo "<br>" . $query4;
                $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
            }
        }
    }

    function delete_td($telefoni) {
        $query3 = "DELETE FROM  `dati_valori_requisiti` WHERE `dati_valori_requisiti`.`nome_tel` = '$telefoni'";
        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        //$obj3 = mysqli_fetch_array($result3);
    }

    function stampa_profilo_confronto($telefoni) {//verificato
        echo "<br><table align=center ><thead><tr><th style='width:240px'>Requisito</th>";
        for ($i = 0; $i < count($telefoni); $i++) {
            echo " <th>" . $telefoni[$i] . "</th>";
        }
        echo "<tr></thead><tbody>";
        $query3 = "";
        $query3 = $query3 . "SELECT `dati_requisiti`.nome_requisito,`dati_requisiti`.devicetype, `dati_valori_requisiti_temp`.valore_requisito as valore_requisito_0 ";
        for ($i = 1; $i < count($telefoni); $i++) {
            $query3 = $query3 . " ,`dati_valori_requisiti_temp$i`.valore_requisito as valore_requisito_$i";
        }
        $query3 = $query3 . " FROM  `dati_requisiti` left JOIN (select * From `dati_valori_requisiti` where nome_tel='" . $telefoni[0] . "') as  dati_valori_requisiti_temp
                            ON `dati_valori_requisiti_temp`.`id_requisito` = `dati_requisiti`.`id`  ";
        for ($i = 1; $i < count($telefoni); $i++) {
            $query3 = $query3 . " left JOIN ( select * From `dati_valori_requisiti` where nome_tel='" . $telefoni[$i] . "') as  dati_valori_requisiti_temp$i ON `dati_valori_requisiti_temp$i`.`id_requisito` = `dati_requisiti`.`id`";
        }

        //echo "<br>".$query3."<br>";
        //echo "<table border='1'>";

        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        while ($obj3 = mysqli_fetch_array($result3)) {
            echo "<tr>";
            echo "<th align=\"left\"><p>" . $obj3['devicetype'] . "</p></th>";
            foreach ($telefoni as $key => $value) {
                echo "<td  align=\"center\"><p>" . $obj3['valore_requisito_' . $key] . "</p></td>";
            }
            echo "</tr>";
        }
        echo "</tbody></table>";
    }

    function insertRecord($idCampo) {
        if (isset($_GET['cid']))
            $cid = $_GET['cid'];
        else
            $cid = "";
        
        if (isset($_POST['nome_requisito']))
            $nome_requisito = $_POST['nome_requisito'];
        if (isset($_POST['descrizione_requisito']))
            $descrizione_requisito = mysqli_real_escape_string($this->mysqli,stripslashes($_POST['descrizione_requisito']));
        if (isset($_POST['label']))
            $label = mysqli_real_escape_string($this->mysqli,stripslashes($_POST['label']));    
        if (isset($_POST['devicetype']))
            $devicetype = $_POST['devicetype'];
        if (isset($_POST['stato']))
            $stato = $_POST['stato'];
        if (isset($_POST['mandatoryoptional']))
            $mandatoryoptional = $_POST['mandatoryoptional'];
        if (isset($_POST['opzioni_requisito']))
            $opzioni_requisito = $_POST['opzioni_requisito'];
            #$opzioni_requisito = mysqli_query($this->mysqli,$opzioni_requisito);

        if (isset($_POST['lista_req']))
            $lista_req = stripslashes($_POST['lista_req']);
        if (isset($_POST['sheet_name']))
            $sheet_name = $_POST['sheet_name']; 
        if (isset($_POST['summary']))
            $summary = $_POST['summary'];
        if (isset($_POST['area_name']))
            $area_name = $_POST['area_name'];
        if (isset($_POST['linecolor']))
            $linecolor = $_POST['linecolor'];
        if (isset($_POST['example']))
            $example = $_POST['example'];
        if (isset($_POST['description_mdm']))
            $description_mdm = $_POST['description_mdm'];
        if (isset($_POST['ordine']))
            $ordine = $_POST['ordine'];
        
        $today = date("Y-m-d"); 
        $nome_requisito = date("Ymds")."newreq"; 

        if ($cid != "")
            $query = "UPDATE dati_requisiti SET  descrizione_requisito='$descrizione_requisito', label='$label', summary='$summary', stato='$stato',mandatoryoptional='$mandatoryoptional',devicetype='$devicetype',opzioni_requisito='$opzioni_requisito',sheet_name='$sheet_name', area_name='$area_name', lista_req='$lista_req',linecolor='$linecolor',example='$example',description_mdm='$description_mdm',ordine='$ordine'  WHERE id='$cid'";
        else {
            if ($cid == "") {
                #$query = "INSERT INTO dati_requisiti (nome_requisito,descrizione_requisito,stato,mandatoryoptional,devicetype,opzioni_requisito) VALUES ('$nome_requisito','$descrizione_requisito','$stato','$mandatoryoptional','$devicetype','$opzioni_requisito') ";
            
                $query = "INSERT INTO `dati_requisiti`(`id`, `nome_requisito`, `descrizione_requisito`, `label`, `summary`, `stato`, `data`, `mandatoryoptional`, `devicetype`, `opzioni_requisito`, `sheet_name`, `area_name`, `lista_req`,`linecolor`,`example`,`description_mdm`,`ordine`) VALUES 
                                                   (NULL,'$nome_requisito','$descrizione_requisito','$label','$summary','$stato','$today','$mandatoryoptional','$devicetype','$opzioni_requisito','$sheet_name','$area_name','$lista_req','$linecolor','$example','$description_mdm','$ordine') ";
                
            }
        }
        #echo $query;
        if (mysqli_query($this->mysqli,$query)) { 
            echo "<p class=\"titoloNews\"><b>L'inserimento &egrave; avvenuto correttamente</b></p><br/> ";
        } else {
            echo "L'inserimento non &egrave; riuscito<br/>" . mysql_error();
        }
    }

    function archivioRecord_old() {
        echo"<table align=\"center\" width=\"100%\" border=\"0\" style=\"	border:1px solid #ffffff;padding:20px 20px 20px 20px;\"><caption><b>Lista completa Requisiti</b></caption>";
        echo "<tr><th align=\"left\">ID Requisito</th><th align=\"left\">ID Nome</th><th align=\"left\">Descrizione Requisito</th><th align=\"left\">Mandatory(Optional)</th><th align=\"left\">Ingestion MDM</th><th align=\"left\">Stato</th><th align=\"left\">Modifica</th><th align=\"left\">Elimina</th</tr>";
        
        $query = "SELECT * FROM dati_requisiti order by  `sheet_name`, `nome_requisito` ";
      
        $risultato = mysqli_query($this->mysqli,$query) or die("Query non valida: " . mysql_error());
        // Stampa dati su schermo
        $area_first = "";
        
        while ($result = mysqli_fetch_array($risultato)) {

            
            $area_name = $result['area_name'];
            
            if ( $area_first != $area_name ) {
                echo "<tr style=\"width: 100%;font-weight:bold;\"><td colspan=\"7\" style=\"font-size:15px; color: white; background-color:#666666\">" . $result['area_name'] ."-".$result['sheet_name']. "</td>"; 
            }
                    $nome_requisito = stripslashes($result['nome_requisito']);
                    $descrizione_requisito = stripslashes($result['descrizione_requisito']);
                    $devicetype = stripslashes($result['devicetype']);
                       
                    
                    echo "<tr><td>" . $result['id'] . "</td><td style=\"width: 130px;\">" . $result['nome_requisito'] . "</td>";
                    echo "<td style=\"width: 200px;\"><textarea readonly style=\"background-color:#eeeeee\">" . $result['descrizione_requisito'] . "</textarea></td>";
                    echo "<td align=\"center\">" . $result['mandatoryoptional'] . "</td>";
                    echo "<td>" . $result['summary'] . "</td>";
                    if ($result['stato'] == 1)
                        $stato = "Attivo";
                    else
                        $stato = "Non Attivo";
                    echo "<td>" . $stato . "</td>";
                    echo "<td><a class=asottomenu href=\"index.php?page=gestioneLSoc/gestore_lsoc&funzione=form&cid=$result[id]\">modifica</a></td>
                          <td><a class=asottomenu href=\"index.php?page=gestioneLSoc/gestore_lsoc&funzione=elimina&cid=$result[id]\">elimina</a></td></tr>";
            
            $area_first = $area_name; 
            
        }
        echo"</table>";
    }
    
   function archivioRecord() {
        ?>
        <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
                    <thead>
        <?php
        #echo"<table align=\"center\" width=\"100%\" border=\"0\" style=\"	border:1px solid #ffffff;padding:20px 20px 20px 20px;\"><caption><b>Lista completa Requisiti</b></caption>";
        #<th tabindex="0" aria-controls="datatable-fixed-header" rowspan="1" colspan="1" aria-label="Position: activate to sort column descending" aria-sort="ascending" style="width: 10px;">N.</th>

        
        
        echo "<tr><th tabindex=\"0\" aria-controls=\"datatable-fixed-header\" "
                 . "rowspan=\"1\" colspan=\"1\" aria-label=\"Position: activate to sort column descending\" aria-sort=\"ascending\" align=\"left\">MDM description</th><th align=\"left\">ID </th><th align=\"left\">Descrizione Requisito</th><th align=\"left\">Mandatory(Optional)</th><th align=\"left\">Ingestion MDM</th><th align=\"left\">Stato</th><th align=\"left\">Action</th><th align=\"left\">Ordine</th</tr>";
        echo'</thead>';
        $query = "SELECT * FROM dati_requisiti order by  `ordine`, `nome_requisito` ASC ";
      
        $risultato = mysqli_query($this->mysqli,$query) or die("Query non valida: " . mysql_error());
        // Stampa dati su schermo
        $area_first = "";
        
        while ($result = mysqli_fetch_array($risultato)) {

            
            $area_name = $result['area_name'];
            
            if ( $area_first != $area_name ) {
                echo "<tr style=\"width: 100%;font-weight:bold;\"><td colspan=\"8\" style=\"font-size:15px; color: white; background-color:#666666\">" . $result['area_name'] ."</td>"; 
            }
                    $nome_requisito = stripslashes($result['nome_requisito']);
                    $descrizione_requisito = stripslashes($result['descrizione_requisito']);
                    $devicetype = stripslashes($result['devicetype']);
                       
                    echo "<tr><td style=\"width: 100px;\"><a name=". $result['id'] . ">" .$result['description_mdm']. "</td><td style=\"width: 130px;\">" . $result['id'] . "</td>";
                    #echo "<tr><td>" . $result['id'] . "</td><td style=\"width: 130px;\">" . $result['nome_requisito'] . "</td>";
                    echo "<td style=\"width: 200px;\"><textarea readonly style=\"background-color:#eeeeee\">" . $result['descrizione_requisito'] . "</textarea></td>";
                    echo "<td align=\"center\">" . $result['mandatoryoptional'] . "</td>";
                    echo "<td>" . $result['summary'] . "</td>";
                    if ($result['stato'] == 1)
                        $stato = "Attivo";
                    else
                        $stato = "Non Attivo";
                    echo "<td>" . $stato . "</td>";
                    echo "<td><a class=asottomenu href=\"index.php?page=gestioneLSoc/gestore_lsoc&funzione=form&cid=$result[id]\">modifica</a><br>
                            <a class=asottomenu href=\"index.php?page=gestioneLSoc/gestore_lsoc&funzione=elimina&cid=$result[id]\">elimina</a>
                          </td>
                          <td>".$result['ordine']."</td></tr>";
            
            $area_first = $area_name; 
            
        }
        echo"</table>";
    }
    
    // -----------------------------------------------------------------
    function eliminaRecord() {
        if (isset($_GET['cid']))
            $cid = $_GET['cid'];

        $query = "SELECT * FROM dati_requisiti WHERE id='$cid'";

        $risultato = mysqli_query($this->mysqli,$query) or die("Query non valida: " . mysql_error());
        // Stampa dati su schermo


        $result = mysqli_fetch_array($risultato);
        $req = $result['nome_requisito'];

        if (isset($_GET['conferma'])) {
            if ($_GET['conferma'] == 'true') {
                if ($cid != "")
                    $query = "DELETE FROM `dati_requisiti` WHERE (id=$cid)";
                //echo $query;
                $risultato = mysqli_query($this->mysqli,$query) or die("Query non valida: " . mysql_error());
                echo "<table><tr><td class=header align=\"center\"> L'eliminazione &egrave; avvenuta con successo</td></tr>";
                echo"</table>";
            }
        } else {
            echo"<p class=\"titoloNews\">Il requisito con ID <b>$req</b> verr&agrave; eliminato dal template LSoc&nbsp;&nbsp;";

            echo "<a href=\"./index.php?page=gestioneLSoc/gestore_lsoc&funzione=elimina&cid=$cid&amp;conferma=true\">Conferma eliminazione</a></p>";
        }
    }

    // -------------------------------------------------------
    function formRecord() {
        if (isset($_GET['cid'])) {
            $cid = $_GET['cid'];
            $query = "SELECT * FROM dati_requisiti WHERE id=$cid";
            $risultato = mysqli_query($this->mysqli,$query) or die("Query non valida: " . mysql_error());
            $result = mysqli_fetch_array($risultato);
            #print_r($result);
            $nome_requisito = stripslashes($result['nome_requisito']);
            $descrizione_requisito = mysqli_real_escape_string($this->mysqli,stripslashes($result['descrizione_requisito']));
            $label = mysqli_real_escape_string($this->mysqli,stripslashes($result['label']));
            $mandatoryoptional = stripslashes($result['mandatoryoptional']);
            $devicetype = stripslashes($result['devicetype']);
            $stato = stripslashes($result['stato']);
            #$stato = 1;
            $opzioni_requisito = stripslashes($result['opzioni_requisito']);
            $lista_req = stripslashes($result['lista_req']);
            $sheet_name = stripslashes($result['sheet_name']);
            $area_name = stripslashes($result['area_name']);
            $summary = $result['summary'];
            $linecolor = $result['linecolor'];
            $example = mysqli_real_escape_string($this->mysqli,stripslashes($result['example']));
            $description_mdm = stripslashes($result['description_mdm']);
            $ordine = stripslashes($result['ordine']);
        }
        if (!isset($_GET['cid'])) {
            $stato = 1;
            $mandatoryoptional = "M";
            $devicetype = "Phone";
            $title = "Inserisci nuovo Requisito";
        }
        ?>

        <form method="post" action="index.php?page=gestioneLSoc/gestore_lsoc&funzione=insert<?php
        if (isset($_GET['cid'])) {
            echo"&cid=$cid";
            $title = "Modifica Requisito";
        }
        ?>#!/gestione">
            <table align="center" width="50%" border="0" style=" border:1px solid #ffffff;padding:20px 20px 20px 20px;"><caption><b><?php echo $title ?></b></caption>
            <!--<table border="0" align="center" cellpadding="4" cellspacing="4" width="450px">-->
                <tr><font face="Verdana" color="#800000"><th>ID Requisito</th>
                    <td placeholder="<?php echo $cid; ?>"><input type="text" name="id" value="<?php
                            if (isset($_GET['cid']))
                                echo $cid;
                                ?>">
                    </td>
                </tr>
                <tr><th>Nome requisito or Bands (5G EN-DC List)</th>
                    <td><input type="text" size="25" name="descrizione_requisito" disabled="disabled" value="<?php
                            if (isset($_GET['cid']))
                                echo $nome_requisito
                                ?>">
                    </td>
                </tr>
                <tr><th>Description or Downlink (5G EN-DC List)</th>
                    <td><input type="text" size="25" name="descrizione_requisito" value="<?php
                            if (isset($_GET['cid']))
                                echo $descrizione_requisito
                                ?>">
                    </td>
                </tr>
                <tr><th>Label or Order (5G EN-DC List)</th><font face="Verdana" color="#800000">
                    <td><input type="text" size="25" name="label" value="<?php
                        if (isset($_GET['cid']))
                            echo $label
                            ?>">
                    </td>
                </tr>
                <tr><font face="Verdana" color="#800000"><th>Mandatory(Optional)</th>
                    <td><select name="mandatoryoptional">
                            <option value="M"<?php if ($mandatoryoptional == "M") echo 'selected="selected"' ?>>M</option>
                            <option value="O"<?php if ($mandatoryoptional == "O") echo 'selected="selected"' ?>>O</option>
                        </select>
                    </td>
                </tr>
                <tr><th>DeviceType or Uplink (5G EN-DC List)</th>
                    <td><input type="text" placeholder="DeviceType or Uplink 5G EN-DC List"  size="25" name="devicetype" value="<?php
                        if (isset($devicetype))
                            echo $devicetype;
                        else
                            echo "";
                        ?>">
                    </td>  
                    
                </tr>
                    
                    
                    <tr><th>Stato</th>
                                        <td><select name="stato">
                            <option value="1" <?php if ($stato == 1) echo 'selected="selected"' ?>>Attivo</option>
                            <option value="0" <?php if ($stato == 0) echo 'selected="selected"' ?>>Non Attivo</option>
                        </select>
                    </td>
                    </tr>
                    
                    
                    <tr><th>Answer Options ( Separate by ; )</th><font face="Verdana" color="#800000">
                       <td><input type="text"  size="25" name="opzioni_requisito" value="<?php
                        if (isset($opzioni_requisito))
                            echo $opzioni_requisito;
                        else
                            echo "";
                        ?>">
                    </td>
                    </tr>
  
                    <tr><th>Lista device ( Separate by " " )</th><font face="Verdana" color="#800000">
                        <td><input type="text"  size="25" name="lista_req" value="<?php
                        if (isset($lista_req))
                            echo $lista_req;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    
                    <tr><th>Sheet name</th><font face="Verdana" color="#800000">
                        <td><input type="text"  size="25" name="sheet_name" value="<?php
                        if (isset($sheet_name))
                            echo $sheet_name;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    
                    <tr><th>Area name or Type (5G EN-DC List)</th><font face="Verdana" color="#800000">
                        <td><input type="text"  size="25" name="area_name" value="<?php
                        if (isset($area_name))
                            echo $area_name;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    
                   <tr><th>Summary</th><font face="Verdana" color="#800000">
                        <td><input type="text"  size="25" name="summary" value="<?php
                        if (isset($summary))
                            echo $summary;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    <tr><th>Excel line Color</th><font face="Verdana" color="#800000">
                    
                        <td><input type="text"  size="25" name="linecolor" value="<?php
                        if (isset($linecolor))
                            echo $linecolor;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    <tr><th>Esempio valore</th><font face="Verdana" color="#800000">
                    
                        <td><input type="text"  size="25" name="example" value="<?php
                        if (isset($example))
                            echo $example;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    <tr><th>MDM Description</th><font face="Verdana" color="#800000">
                    
                        <td><input type="text"  size="25" name="description_mdm" value="<?php
                        if (isset($description_mdm))
                            echo $description_mdm;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    <tr><th>Ordine requisito</th><font face="Verdana" color="#800000">
                    
                        <td><input type="text"  size="25" name="ordine" value="<?php
                        if (isset($ordine))
                            echo $ordine;
                        else
                            echo "";
                        ?>">
                        </td>
                    </tr>
                    
                    <tr>
                    <td colspan="2" align="center"><input type="submit" value="Invia"></td>
                    </tr>
            </table>
        </form>
        <br/>
        <?php
    }
    
    function modify_formLSoc() {
        if (isset($_GET['cid'])) {
            $cid = $_GET['cid'];
            $nome_tel = $_GET['nome_tel'];
            $valore_req = $_GET['val'];
            $nota_req = $_GET['not'];
            
            $query = "SELECT * FROM dati_requisiti WHERE id=$cid";
            $risultato = mysqli_query($this->mysqli,$query) or die("Query non valida: " . mysql_error());
            $result = mysqli_fetch_array($risultato);
            #print_r($result);
            $nome_requisito = stripslashes($result['nome_requisito']);
            $descrizione_requisito = stripslashes($result['descrizione_requisito']);
            $label = stripslashes($result['label']);
            $mandatoryoptional = stripslashes($result['mandatoryoptional']);
            $devicetype = stripslashes($result['devicetype']);
            $stato = stripslashes($result['stato']);
            #$stato = 1;
            $opzioni_requisito = stripslashes($result['opzioni_requisito']);
        }
        if (!isset($_GET['cid'])) {
            $stato = 1;
            $mandatoryoptional = "M";
            $devicetype = "Phone";
            $title = "Inserisci nuovo Requisito";
        }
        ?>

        <form method="post" action="index.php?page=gestioneLSoc/gestore_lsoc&funzione=insert<?php
        if (isset($_GET['cid'])) {
            echo"&cid=$cid";
            $title = "Modifica Requisito";
        }
        ?>#!/gestione">
            <table align="center" width="50%" border="0" style=" border:1px solid #ffffff;padding:20px 20px 20px 20px;"><caption><b><?php echo $title ?></b></caption>
            <!--<table border="0" align="center" cellpadding="4" cellspacing="4" width="450px">-->
                <tr><font face="Verdana" color="#800000"><th>ID Requisito</th><th>Description</th><th>Label</th></tr>
                 <tr><font face="Verdana" color="#800000">
                    <td><input type="text" name="nome_requisito" value="<?php
                        if (isset($_GET['cid']))
                            echo $nome_requisito
                            ?>"></td>


                    <td><input type="text" size="25" name="descrizione_requisito" value="<?php
                        if (isset($_GET['cid']))
                            echo $descrizione_requisito
                            ?>"></td>
                   <td><input type="text" size="25" name="label" value="<?php
                        if (isset($_GET['cid']))
                            echo $label
                            ?>"></td>
            </tr></table>
            <table align="center" width="50%" border="0" style=" border:1px solid #ffffff;padding:20px 20px 20px 20px;">
            
            
                <tr><font face="Verdana" color="#800000"><th>Mandatory(Optional)</th><th>Device Type</th><th>Stato</th><th>Answer Options ( Separate by ; )</th><th></th></tr>
            
                 <tr><font face="Verdana" color="#800000">
                    <td><select name="mandatoryoptional">
                            <option value="M"<?php if ($mandatoryoptional == "M") echo 'selected="selected"' ?>>M</option>
                            <option value="O"<?php if ($mandatoryoptional == "O") echo 'selected="selected"' ?>>O</option>
                        </select>
                    </td>
                    <td><select name="devicetype">
                            <option value="Phone" <?php if ($devicetype == "Phone") echo 'selected="selected"' ?>>Phone</option>
                            <option value="Datacard"<?php if ($devicetype == "Datacard") echo 'selected="selected"' ?>>Datacard</option>
                            <option value="Router"<?php if ($devicetype == "Router") echo 'selected="selected"' ?>>Router</option>
                            <option value="Tablet"<?php if ($devicetype == "Tablet") echo 'selected="selected"' ?>>Tablet</option>
                        </select>
                    </td>




                    <td><select name="stato">
                            <option value="1" <?php if ($stato == 1) echo 'selected="selected"' ?>>Attivo</option>
                            <option value="0" <?php if ($stato == 0) echo 'selected="selected"' ?>>Non Attivo</option>
                        </select>
                    </td>
                    <td><input type="text"  size="25" name="opzioni_requisito" value="<?php
                        if ($opzioni_requisito != "")
                            echo $opzioni_requisito;
                        else
                            echo "";
                        ?>">

                    </td>

                    <td><input type="submit" value="Invia"></td>
                </tr>
            </table>
        </form>
        <br/>
        <?php
    }
    
###########NON usata vedi analoga in funzioni_profilo.php 
    function insert_profilo_telefono($full_path, $modello, $update = false) {
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

                $query3 = "SELECT id,count(id)as numero_record  FROM `dati_requisiti` WHERE `nome_requisito` LIKE '" . $data->sheets[$m]['cells'][$i][1] . "'";

                $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
                $obj3 = mysqli_fetch_array($result3);
                $data_inserimento = date("Y-m-d");

                if ($obj3['numero_record'] == 1) {
                  
                        $value = preg_replace('/[^(\x20-\x7F)]*/', '', $data->sheets[$m]['cells'][$i][6]);
                        $note = preg_replace('/[^(\x20-\x7F)]*/', '', $data->sheets[$m]['cells'][$i][7]);
                    if ($update == false) {
                        $query4 = "INSERT INTO   `dati_valori_requisiti` (`id` ,`id_requisito` ,`nome_tel`,`valore_requisito`,`data_inserimento`,`note`) VALUES (NULL ,  '" . $obj3['id'] . "',  '" . $modello . "','" . $value . "','" . $data_inserimento . "','" . $note . "')";
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                    } else {
                        if ($value != "") {
                            $query4 = "UPDATE   `dati_valori_requisiti` SET  `valore_requisito` =  '" . $value . "',`data_inserimento` =  '" . $data_inserimento . "', `note` =  '" . $note . "' WHERE  nome_tel='" . $modello . "' and id_requisito='" . $obj3['id'] . "'";
                            $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                            $numero_inserimenti++;
                        }
                    }
                    // echo "<br>".$query4;
                }
            }
        }
        echo "<h2>Sono stati inseriti $numero_inserimenti requisiti con successo</h2>";
    }

    function insert_update_template_lsoc($full_path, $modello, $update) {

        if (!file_exists($full_path)) {
            exit("File non pervenuto." . EOL);
        }


        $numero_inserimenti = 0;
        $numero_modifiche = 0;

        $inputFileName = $full_path;

        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel_reader = $objReader->load($inputFileName);
        $objPHPExcel_reader->getActiveSheet(0);
        $date = date("Y-m-d");
        //foreach ($objPHPExcel_reader->getWorksheetIterator() as $worksheet) 
        for ($i = 0; $i < $objPHPExcel_reader->getSheetCount(); $i++) {
            $riga = 2;
            //echo $i;

            $worksheet = $objPHPExcel_reader->getSheet($i);
            $title_sheet = $worksheet->getTitle();

            $area = "";
            foreach ($worksheet->getRowIterator() as $row) {

                $id_req = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();

                $description = mysqli_real_escape_string($this->mysqli,$worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue());
                $label = mysqli_real_escape_string($this->mysqli,$worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue());
                $mand_opt = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
                $devicetype  = $worksheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
                #$devicetype  = "CommonReq";
                $tipo_entry = $worksheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue();
                $options_validation = $worksheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
                $options = str_replace("\"", "", str_replace(",", ";", $options_validation));
                
                #$label = $worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue();
                $summary = $worksheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue();
                

                if ($description == "") {
                    $area = $id_req;
                    //echo $area."<bR>";
                    $riga++;
                } elseif (($mand_opt == 'M') || ($mand_opt == 'O')) {
                                   
                //Verifica esistenza Requisito
                $query1 = "SELECT nome_requisito FROM `dati_requisiti` WHERE `nome_requisito` = '".$id_req."'";
                $result = mysqli_query($this->mysqli,$query1) or die($query1);
                $req_exist = mysql_num_rows($result);
                #echo $req_exist."<br>";    
                    if (($tipo_entry == "New") && ($req_exist == 0)) {
                        $query4 = "INSERT INTO   `dati_requisiti` (
                                                            `id` ,
                                                            `nome_requisito` ,
                                                            `descrizione_requisito` ,
                                                            `label` ,
                                                            `summary` ,
                                                            `stato` ,
                                                            `data`,
                                                            `mandatoryoptional`,
                                                            `devicetype`,`opzioni_requisito`,`sheet_name`,`area_name`,`lista_req`
                                                            )
                                                            VALUES (
                                                            NULL ,  '" . $id_req . "',
                                                                            '$description',
                                                                            '$label','',
                                                                            1,
                                                                            '" . $date . "',
                                                                            '$mand_opt'	,	
                                                                            '$devicetype',	
                                                                            '$options','$title_sheet','$area','$devicetype'
                                                                            );";
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                        
                        
                    } else if (($tipo_entry == "Modified") && ($req_exist == 1)) {
                        
                        //Verifica lista di apparteneza
                        $query1 = "SELECT `lista_req` FROM `dati_requisiti` WHERE `nome_requisito` = '".$id_req."'";
                        $result = mysqli_query($this->mysqli,$query1) or die($query1);
                        $lista_req = mysql_result($result,0); echo $lista_req."<br>";
                        $pieces = explode(" ", $lista_req);
                        if (!(in_array($devicetype, $pieces))) {
                                $lista_req = implode(" ", $pieces);
                                $lista_req = $lista_req ." ".$devicetype; 
                        }
                        
                        
                        $query4 = "UPDATE `dati_requisiti` SET  `descrizione_requisito` =  '$description',`label` =  '$label',
                                                            `stato` =  1,
                                                            `data` =  '$date',
                                                            `mandatoryoptional` =  '$mand_opt' , `devicetype` =  '$devicetype' , sheet_name=  '$title_sheet' ,area_name=  '$area', lista_req=  '$lista_req'
                                                      WHERE  `dati_requisiti`.`nome_requisito` = '$id_req';";
                        $query5 = "UPDATE `dati_requisiti` SET `label` =  '$label',`summary` =  '$summary'
                                    
                                                      WHERE  `dati_requisiti`.`nome_requisito` = '$id_req';";
                        
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_modifiche++;
                        
                    }
                    else "Il seguente Requisito --> ".$id_req." non é stato modificato";
                    $riga++;
                }
            }
        }
        echo "<br><p><h3>Requisiti aggiunti $numero_inserimenti</h3></p>";
        echo "<p><h3>Requisiti modificati $numero_modifiche</h3></p>";
    }

    function insert_update_template_lsoc2($full_path, $modello, $update) {

        require_once ("./Excel/reader.php");
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('ISO-8859-1//IGNORE'); // Set output Encoding.
        $data->read($full_path);
        error_reporting(E_ALL ^ E_NOTICE);
        //connect_db();
        //echo "<table border='1'>";
        $numero_inserimenti = 0;
        $date = date("Y-m-d");
        for ($m = 0; $m < 34; $m++) {
            for ($i = 1; $i <= $data->sheets[$m]['numRows']; $i++) {

                //$query3 = "SELECT id,count(id)as numero_record  FROM `dati_requisiti` WHERE `nome_requisito` LIKE '" . $data->sheets[$m]['cells'][$i][1] . "'";
                //	$result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
                //$obj3 = mysqli_fetch_array($result3);
                //if ($obj3['numero_record'] == 1) {
                if (($data->sheets[$m]['cells'][$i][3] == "M") || ($data->sheets[$m]['cells'][$i][3] == "O")) {
                    if ($data->sheets[$m]['cells'][$i][6] == "Actived")
                        $stato = 1;
                    else
                        $stato = 0;
                    if (($data->sheets[$m]['cells'][$i][7] == "New")) {
                        $query4 = "INSERT INTO   `dati_requisiti` (
                                                            `id` ,
                                                            `nome_requisito` ,
                                                            `descrizione_requisito` ,
                                                            `label` ,
                                                            `summary` ,
                                                            `stato` ,
                                                            `data`,
                                                            `mandatoryoptional`,
                                                            `devicetype`,`opzioni_requisito`
                                                            )
                                                            VALUES (
                                                            NULL ,  '" . $data->sheets[$m]['cells'][$i][1] . "',
                                                                            '" . addslashes($data->sheets[$m]['cells'][$i][2]) . "',
                                                                            '','',
                                                                            '" . $stato . "',
                                                                            '" . $date . "',
                                                                            '" . $data->sheets[$m]['cells'][$i][3] . "'	,	
                                                                            '" . $data->sheets[$m]['cells'][$i][4] . "',	
                                                                            '" . $data->sheets[$m]['cells'][$i][5] . "'
                                                                            );";
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                    } else if (($data->sheets[$m]['cells'][$i][7] == "Modified")) {

                        $query4 = "UPDATE  `dati_requisiti` SET  `descrizione_requisito` =  '" . addslashes($data->sheets[$m]['cells'][$i][2]) . "',
                                                            `stato` =  '" . $stato . "',
                                                            `data` =  '" . $date . "',
                                                            `mandatoryoptional` =  '" . $data->sheets[$m]['cells'][$i][3] . "' ,
                                                            `devicetype` =  '" . $data->sheets[$m]['cells'][$i][4] . "' ,
                                                            `opzioni_requisito` =  '" . $data->sheets[$m]['cells'][$i][5] . "'
                                                      WHERE  `dati_requisiti`.`nome_requisito` = '" . $data->sheets[$m]['cells'][$i][1] . "';";
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                    }
                }
            }
        }
        echo "<h2>Sono stati inseriti/modificati $numero_inserimenti requisiti con successo</h2>";
    }

    function parsing_and_export($full_path, $filename, $update) {

        /** Error reporting 
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);

        define('EOL', (PHP_SAPI == 'cli') ? PHP_EOL : '<br />');

        date_default_timezone_set('Europe/London');

        */
        if (!file_exists($full_path)) {
            exit("File non pervenuto." . EOL);
        }

#################### new excel #####################################
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("TemplateLSoc");
        $objPHPExcel->setActiveSheetIndex(0);




#############################################################################



        $inputFileName = $full_path;

        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel_reader = $objReader->load($inputFileName);
        $objPHPExcel_reader->getActiveSheet(0);

        //foreach ($objPHPExcel_reader->getWorksheetIterator() as $worksheet) 
        for ($i = 0; $i < $objPHPExcel_reader->getSheetCount(); $i++) {
            $riga = 2;
            //echo $i;

            $worksheet = $objPHPExcel_reader->getSheet($i);
            $title_sheet = $worksheet->getTitle();
            $newSheet = new PHPExcel_Worksheet($objPHPExcel, $title_sheet);
            $objPHPExcel->addSheet($newSheet, $i);

            //$objPHPExcel->setActiveSheetIndex(0);
            $objPHPExcel->getSheetByName($title_sheet);
            $objPHPExcel->setActiveSheetIndex($i);
            $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                    ->setCellValue('B1', "Description")
                    ->setCellValue('C1', "Mandatory (Optional)")
                    ->setCellValue('D1', "Device type")
                    ->setCellValue('E1', "Answer options")
                    ->setCellValue('F1', "Status")
                    ->setCellValue('G1', "Update requirement");
            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("22");
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("25");
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("22");
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("20");
            
            foreach ($worksheet->getRowIterator() as $row) {

                $id_req = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
                //echo $id_req . "<br>";
                $description = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                $mand_opt = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
                $options_validation = $worksheet->getCellByColumnAndRow(5, $row->getRowIndex())->getDataValidation();
                $options = $options_validation->getFormula1();
                #echo 'valore colonna 2 '.$worksheet->getCellByColumnAndRow(2,$row->getRowIndex())->getValue();
                if (($mand_opt == 'M') || ($mand_opt == 'O')) {
                    //echo $id_req . "<br>";
                    #echo 'valore colonna 2 '.$worksheet->getCellByColumnAndRow(2,$row->getRowIndex())->getValue();

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_req)
                            ->setCellValue('B' . $riga, $description)
                            ->setCellValue('C' . $riga, $mand_opt)
                            ->setCellValue('D' . $riga, "")
                            ->setCellValue('E' . $riga, $options)
                            ->setCellValue('F' . $riga, "")
                            ->setCellValue('G' . $riga, "New");
                    #$objPHPExcel->getActiveSheet()->setCellValueByColumnAndRow(2, $riga, 'Some value');
                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $riga)->getDataValidation();
                    $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Input error');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please select a value from the drop-down list.');
                    $objValidation->setFormula1('"New,Modified,Not Modified"');

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                    $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Input error');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please select a value from the drop-down list.');
                    $objValidation->setFormula1('"M,O"');

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $riga)->getDataValidation();
                    $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Input error');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please select a value from the drop-down list.');
                    $objValidation->setFormula1('"Actived,Disabled"');

                    $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $riga)->getDataValidation();
                    $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                    $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                    $objValidation->setAllowBlank(false);
                    $objValidation->setShowInputMessage(true);
                    $objValidation->setShowErrorMessage(true);
                    $objValidation->setShowDropDown(true);
                    $objValidation->setErrorTitle('Input error');
                    $objValidation->setError('Value is not in list.');
                    $objValidation->setPromptTitle('Pick from list');
                    $objValidation->setPrompt('Please select a value from the drop-down list.');
                    $objValidation->setFormula1('"Phone,Datacard,Router,Tablet"');
                    $riga++;
                } else if (($id_req != "") && ($description != "") && ($mand_opt == "")) {
                    $objPHPExcel->getActiveSheet()->getStyle($riga . ':' . $riga)->getFill()
                            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                            ->getStartColor()->setARGB('00BFBFBF');
                    $objPHPExcel->getActiveSheet()->getStyle($riga . ':' . $riga)->getFont()->setBold(true);

                    $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $description);
                    $riga++;
                }
            }
        }

        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        #header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        #header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="create_TemplateLSoc.xls"');
        #header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
        $objWriter->save('php://output');
        exit;
    }

    function export_LSoc_OLD($tipo_terminale) {

        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc");


        $objPHPExcel->setActiveSheetIndex(0);



        $query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";

        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);

            if ($sheet != $row['sheet_name']) {
                //creare un nuvo sheet e stampa la prima riga di intestazione
                $riga = 0;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);

                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Mandatory (Optional)")
                        ->setCellValue('D1', "Answers")
                        ->setCellValue('E1', "Notes");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("22");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("25");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("22");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
            
            
            
            if ($area != $row['area_name']) {
                $riga++;
                $objPHPExcel->getActiveSheet()->getStyle($riga . ':' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle($riga . ':' . $riga)->getFont()->setBold(true);

                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $riga++;
                $area = $row['area_name'];
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['nome_requisito'])
                    ->setCellValue('B' . $riga, $row['descrizione_requisito'])
                    ->setCellValue('C' . $riga, $row['mandatoryoptional'])
                    ->setCellValue('D' . $riga, '')
                    ->setCellValue('E' . $riga, "");

            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }


            $riga++;
        }
        

        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_' . $tipo_terminale . '_LSoc.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }
    
    function export_LSoc_specifica($nome_terminale, $devicetype) {

        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc");


        $objPHPExcel->setActiveSheetIndex(0);

        #$query1 = "SELECT * FROM  `dati_requisiti` WHERE  `lista_req` LIKE  '%".$devicetype."%' ORDER BY sheet_name ASC"; 
/*        
SELECT dati_requisiti.id, dati_requisiti.nome_requisito, dati_requisiti.descrizione_requisito, dati_requisiti.label, dati_requisiti.summary, dati_requisiti.stato, data, dati_requisiti.mandatoryoptional, dati_requisiti.devicetype, dati_requisiti.opzioni_requisito, dati_requisiti.sheet_name, dati_requisiti.area_name, dati_requisiti.lista_req, dati_valori_requisiti.id, dati_valori_requisiti.id_requisito, dati_valori_requisiti.nome_tel, dati_valori_requisiti.valore_requisito, dati_valori_requisiti.data_inserimento, dati_valori_requisiti.note, dati_valori_requisiti.data_accettazione, dati_valori_requisiti.market, dati_valori_requisiti.vendor, dati_valori_requisiti.devicetype
FROM dati_requisiti
LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito
AND dati_valori_requisiti.nome_tel =  "inq_Router_Test*" )  where dati_requisiti.lista_req LIKE  '%Router%'
 * 
 */
        #$query2 = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";

         
        $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$nome_terminale."' )  where (dati_requisiti.lista_req LIKE   '%".$devicetype."%' and dati_requisiti.stato = 1)";
        
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);

            if ($sheet != $row['sheet_name']) {
                //creare un nuvo sheet e stampa la prima riga di intestazione
                $riga = 0;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
                
               $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "O/M")
                        ->setCellValue('D1', "Answers")
                        ->setCellValue('E1', "Notes");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("22");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("5");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("40");
                    
                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
                
                
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
            
            
            
            if ($area != $row['area_name']) {
                $riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['nome_requisito'])
                    ->setCellValue('B' . $riga, $row['descrizione_requisito'])
                    ->setCellValue('C' . $riga, $row['mandatoryoptional'])
                    ->setCellValue('D' . $riga, $row['valore_requisito'])
                    ->setCellValue('E' . $riga, $row['note'])
                    
                    ->setCellValue('F' . $riga, $row['summary']) ///Indicazione temporanea Da eliminare
                    ;
            
            ############ Elimino protezione sulle due colonne #########################
            $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
            
            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }


            $riga++;
        }
        

        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="export_' . $nome_terminale . '_LSoc.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    function export_template_LSoc() {

        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("TemplateLSoc");


        $objPHPExcel->setActiveSheetIndex(0);
        $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                ->setCellValue('B1', "Description")
                ->setCellValue('C1', "Mandatory (Optional)")
                ->setCellValue('D1', "Device type")
                ->setCellValue('E1', "Options")
                ->setCellValue('F1', "Status")
                ->setCellValue('G1', "Update requirement")
                ->setCellValue('H1', "Label")
                ->setCellValue('I1', "Lista")
                ->setCellValue('J1', "Example")
                ->setCellValue('K1', "Description_MDM")
                ->setCellValue('L1', "Area name")
                ->setCellValue('M1', "Sheet name");


        $query = "SELECT * FROM dati_requisiti";

        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $riga = 2;

        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($row['stato'] == 1)
                $stato = "Actived";
            else
                $stato = "Not Actived";
            if (isset($row['opzioni_requisito']))
                $options = $row['opzioni_requisito'];
            else
                $options = "";
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['nome_requisito'])
                    ->setCellValue('B' . $riga, $row['descrizione_requisito'])
                    ->setCellValue('C' . $riga, $row['mandatoryoptional'])
                    ->setCellValue('D' . $riga, $row['devicetype'])
                    ->setCellValue('E' . $riga, $options)
                    ->setCellValue('F' . $riga, $stato)
                    ->setCellValue('G' . $riga, "Not Modified")
                    ->setCellValue('H' . $riga, $row['label'])
                    ->setCellValue('I' . $riga, $row['lista_req'])
            ->setCellValue('J' . $riga, $row['example'])
            ->setCellValue('K' . $riga, $row['description_mdm'])
            ->setCellValue('L' . $riga, $row['area_name'])
            ->setCellValue('M' . $riga, $row['sheet_name']);
            

            $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("22");
            $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("25");
            $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("22");
            $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");
            $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("20");
            $objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("20");
            
            
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('G' . $riga)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"New,Modified,Not Modified"');

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"Mandatory,Optional"');
            /*
              if(isset($row['options'])) {
              $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $riga)->getDataValidation();
              $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
              $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
              $objValidation->setAllowBlank(false);
              $objValidation->setShowInputMessage(true);
              $objValidation->setShowErrorMessage(true);
              $objValidation->setShowDropDown(true);
              $objValidation->setErrorTitle('Input error');
              $objValidation->setError('Value is not in list.');
              $objValidation->setPromptTitle('Pick from list');
              $objValidation->setPrompt('Please pick a value from the drop-down list.');
              $objValidation->setFormula1($row['options']);
              } */
            $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $riga)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"Active,Disabled"');

            $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $riga)->getDataValidation();
            $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
            $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
            $objValidation->setAllowBlank(false);
            $objValidation->setShowInputMessage(true);
            $objValidation->setShowErrorMessage(true);
            $objValidation->setShowDropDown(true);
            $objValidation->setErrorTitle('Input error');
            $objValidation->setError('Value is not in list.');
            $objValidation->setPromptTitle('Pick from list');
            $objValidation->setPrompt('Please pick a value from the drop-down list.');
            $objValidation->setFormula1('"Smartphone,Featurephone,Datacard,Router,Tablet"');

            $riga++;
        }

        $objPHPExcel->setActiveSheetIndex(0);

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="exportTemplateLSoc.xlsx"');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }

    function insert_update_lsoc2($full_path, $modello, $update) {

        require_once ("./Excel/reader.php");
        $data = new Spreadsheet_Excel_Reader();
        $data->setOutputEncoding('ISO-8859-1//IGNORE'); // Set output Encoding.
        $data->read($full_path);
        error_reporting(E_ALL ^ E_NOTICE);
        //connect_db();
        //echo "<table border='1'>";
        $numero_inserimenti = 0;
        $date = date("Y-m-d");
        for ($m = 0; $m < 34; $m++) {
            for ($i = 1; $i <= $data->sheets[$m]['numRows']; $i++) {

                $query3 = "SELECT id FROM `dati_requisiti` WHERE `nome_requisito` LIKE '" . $data->sheets[$m]['cells'][$i][1] . "'";
                $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
                $obj3 = mysqli_fetch_array($result3);
                
                $data_inserimento = data(Y-m-d);
                
                if (($data->sheets[$m]['cells'][$i][3] == "M") || ($data->sheets[$m]['cells'][$i][3] == "O")) {

                    
                        $query4 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`)
                                                            VALUES (
                                                            NULL ,  '" . $obj3['id'] . "',
                                                                            '" . addslashes($data->sheets[$m]['cells'][$i][2]) . "',
                                                                            '" . $modello . "'	,	
                                                                            '" . $data->sheets[$m]['cells'][$i][6] . "',	
                                                                            '" . $data_inserimento . "'	,
                                                                            '" . $data->sheets[$m]['cells'][$i][7] . "'
                                                                            );";
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                    } 
                  /*  else if (($data->sheets[$m]['cells'][$i][7] == "Modified")) {

                        $query4 = "UPDATE  `dati_requisiti` SET  `descrizione_requisito` =  '" . addslashes($data->sheets[$m]['cells'][$i][2]) . "',
                                                            `stato` =  '" . $stato . "',
                                                            `data` =  '" . $date . "',
                                                            `mandatoryoptional` =  '" . $data->sheets[$m]['cells'][$i][3] . "' ,
                                                            `devicetype` =  '" . $data->sheets[$m]['cells'][$i][4] . "' ,
                                                            `opzioni_requisito` =  '" . $data->sheets[$m]['cells'][$i][5] . "'
                                                      WHERE  `dati_requisiti`.`nome_requisito` = '" . $data->sheets[$m]['cells'][$i][1] . "';";
                        $result4 = mysqli_query($this->mysqli,$query4) or die($query4 . " - " . mysql_error());
                        $numero_inserimenti++;
                    }  */
                }
            }
            echo "<h2>Sono stati inseriti/modificati $numero_inserimenti requisiti con successo</h2>";
        }
    
    function export_LSoc($tipo_terminale, $devicename, $device_vendor ="") {

        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        
        if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `ordine`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `ordine`";
        
            $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $row['sheet_name'] = "All Requirements";
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
            }
            else {
                $valore_requisito = '';
                $note = '';
            }
            if ($sheet != $row['sheet_name']) {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Answers")
                        ->setCellValue('D1', "Notes")
                        ->setCellValue('E1', "AP Status")
                        ->setCellValue('F1', "Example");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("60");
                
                $objPHPExcel->getActiveSheet()->getStyle('A2:F350')
                ->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A2:F350')
                ->getAlignment()->setWrapText(true);
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
                
            if ($area != $row['area_name']) {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['id'])
                    ->setCellValue('B' . $riga, $row['label'])
                    ->setCellValue('C' . $riga, $valore_requisito)
                    ->setCellValue('D' . $riga, $note)
                    ->setCellValue('F' . $riga, $row['example']);
                    
            
            ############ Elimino protezione sulle due colonne #########################
            $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
            

            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }
           if ($row['summary'] == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $riga, $row['label']);
                $url = 'sheet://\''.$row['label'].'\'!A1';
                $objPHPExcel->getActiveSheet()->getCell('C'.$riga)->getHyperlink()->setUrl($url);
            }
            
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1('" ,Open,Closed"');
           
            //yellow row highlighting
            if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                $linecolor = $row['linecolor'];
                $color =  str_replace('#','00',$linecolor);                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
            }
            
            $riga++;
        }
        
        
        ########################################################################
        ################## Sheet requisiti speciali con summary = 2 ############
        ########################################################################
        /*
        $query8= "SELECT count(*) as requisiti_speciali FROM  `dati_requisiti` WHERE  `lista_req` LIKE  '%".$tipo_terminale."%' AND`summary` = 2 ";
        $result8 = mysqli_query($this->mysqli,$query8) or die($query8 . " - " . mysql_error());
        $result8 = mysqli_query($this->mysqli,$query8) or die($query8 . " - " . mysql_error());
        $row = mysqli_fetch_array($result8);
        
        if ($row['requisiti_speciali'] > 0){
        
        $query6 = "SELECT * FROM  `requisiti_speciali`  ORDER BY  `requisiti_speciali`.`sheet` ASC ";          
        $result6 = mysqli_query($this->mysqli,$query6) or die($query6 . " - " . mysql_error());
        
        $sheet = "";
        #$area = "";
        
        while ($row = mysqli_fetch_array($result6)) {
            #print_r($row);
            
            $cella = trim($row['cella']);
            $nome = $row['nome'];
            
            if ($sheet != $row['sheet']) {
                //creare un nuvo sheet e stampa la prima riga di intestazione
                #$riga = 0;
                #echo "$cella --- $nome --";
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet']);
                $objPHPExcel->setActiveSheetIndex($i);
                
                $objPHPExcel->getActiveSheet()->setCellValue($cella, $nome);
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                #$objPHPExcel->getActiveSheet()->getCell("$cella")->setValue("hello\nworld");
                
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getAlignment()->setWrapText(true);
               
               $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("30");
               

                ################## Proteggo intero sheet ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
                
                 
                 
                $sheet = $row['sheet'];
                $i++;
            }
            elseif ($sheet == $row['sheet']){
                $objPHPExcel->getActiveSheet()->setCellValue($cella, $nome);
                $objPHPExcel->getActiveSheet()->getStyle('A3:K25')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                
                
            }

            
            ############ Elimino protezione sulle due colonne #########################
            #$objPHPExcel->getActiveSheet()->getStyle('B3:K25')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            #$objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
        }        
        }
        
       
        if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `nome_requisito`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `nome_requisito`";
        
            $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $trhee_rfi[$row['nome_requisito']] = $row['valore_requisito'];
            }
        }
        
        
        $newSheet = new PHPExcel_Worksheet($objPHPExcel, 'wind');
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName('wind');
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "Capability name")
                        ->setCellValue('B1', "Vendor Answer");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
            
            //associo i valori dei requisiti tre a quelli di wind    
            $query_wind = "SELECT * FROM `wind_template_all` WHERE 1";
            $result_wind = mysqli_query($this->mysqli,$query_wind) or die($query_wind . " - " . mysql_error());
            $sheet = "wind";
            
            $riga = 1;
            $color = 'ffff00';
            $wind_array = array();
            
            while ($row = mysql_fetch_assoc($result_wind)) {
                #per tabella wind_template
                #$wind_array[$row['Capability']]['Formula'] = $row['Formula']; 
                //sostituisco il ? con = per avere la formula excel
                #$vendor_answer = str_replace('?','=',$row['Vendor_Answer']);
                $wind_array[$row['Capability_name']]['Formula'] = $row['Formula'];
                
                $wind_array[$row['Capability_name']]['Capability_name'] = $row['Capability_name'];
               
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
                
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $wind_array[$row['Capability_name']]['Capability_name'])
                    ->setCellValueExplicit('B' . $riga, $row['Formula']);
                
                $riga++;
                
                
            }
        * 
        */
        
        
        
        
        if ($devicename != false) $filename = "RFI_" . $tipo_terminale."_".$device_vendor."_".$devicename. ".xlsx";
            else $filename = "Template_RFI_". $tipo_terminale. ".xlsx";
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }   
    
    function get_projects($id){       
       $query = "Select * FROM `projects` WHERE id = '$id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
       $obj = mysqli_fetch_assoc($result); 
       
       return $obj;      
    }
    
    
    function exportRFI ($tipo_terminale, $devicename, $device_vendor ="", $id_project=null) {   
        
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("WindTre")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc")
                ->setKeywords("newProtection_STYLE_STOP");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        if($tipo_terminale=='Featurephone'){
            $tipo_terminale = 'phone';
        }
        elseif ((strcasecmp($tipo_terminale, 'MBB') == 0) or (strcasecmp($tipo_terminale, 'Router') == 0) or (strcasecmp($tipo_terminale, 'Datacard') == 0) ){
            $tipo_terminale = 'Router';
        }
        if (isset($id_project))
            $query = "SELECT dati_requisiti.*,dati_valori_requisiti.valore_requisito,dati_valori_requisiti.note FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project =  '".$id_project."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `ordine`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `ordine` ";
        
            #$result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
            $result = mysqli_query($this->mysqli, $query) or die($query . " - " . $this->mysqli->error);    

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        
        while ($row = mysqli_fetch_array($result)) {
            //$row['sheet_name'] = "All Requirements";
            $id_requisito = $row['id'];
            #print_r($row['descrizione_requisito']);
            if (isset($id_project)){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
                
            }
            else {
                $valore_requisito = '';
                $note = '';
               
            }

            
            if ($sheet != $row['sheet_name'] and $row['sheet_name']!='EN-DC List') {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Answers")
                        ->setCellValue('D1', "Notes")
                        ->setCellValue('E1', "Example");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("60");                
                
                $objPHPExcel->getActiveSheet()->getStyle('A2:E350')
                ->getAlignment()->setWrapText(true);
                
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;
            }
            
            //inizio intestazione nuovo Sheet
            elseif($sheet != $row['sheet_name'] and $row['sheet_name'] =='EN-DC List') {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $bands = '';
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Type")
                        ->setCellValue('C1', "LTE Bands")
                        ->setCellValue('D1', "NR Bands")
                        ->setCellValue('E1', "Order")
                        ->setCellValue('F1', "Downlink")
                        ->setCellValue('G1', "Uplink")
                        ->setCellValue('H1', "Support (True/False)")
                        ->setCellValue('I1', "Comments");
                        

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("15");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");       
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");  
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("25");  
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("20");     
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("40"); 
                $objPHPExcel->getActiveSheet()->getStyle('A1:I269')
                ->getAlignment()->setWrapText(true);
                
                
                
                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:I1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;
                
            }
            
                
            if ($area != $row['area_name']  and $sheet!='EN-DC List') {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            elseif ($area != $row['area_name']  and  $sheet=='EN-DC List') {
                #$riga++;
                $objPHPExcel->getActiveSheet()->getStyle('B'.$riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');

                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':I' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':I' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':I' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':G' . $riga)->getFont()->setBold(true);
                //$riga++;
                $area = $row['area_name'];
            }
            
            
            
            if ($sheet!='EN-DC List') {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                        ->setCellValue('B' . $riga, $row['label'])
                        ->setCellValue('C' . $riga, $valore_requisito)
                        ->setCellValue('D' . $riga, $note)
                        ->setCellValue('E' . $riga, $row['example']);


                ############ Elimino protezione sulle due colonne #########################
                $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                // $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                ###########################################################################
                
                if ($row['opzioni_requisito'] != "") {
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                        // $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                        $objValidation->setAllowBlank(false);
                        $objValidation->setShowInputMessage(true);
                        $objValidation->setShowErrorMessage(true);
                        $objValidation->setShowDropDown(true);
                        $objValidation->setErrorTitle('Input error');
                        $objValidation->setError('Value is not in list.');
                        $objValidation->setPromptTitle('Pick from list');
                        $objValidation->setPrompt('Please pick a value from the drop-down list.');
                        $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                        //$objValidation->setFormula1($row['opzioni_requisito']);
                    }

                        //yellow row highlighting
                        if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                            $linecolor = $row['linecolor'];
                            $color =  str_replace('#','00',$linecolor);                
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB(''.$color.'');
                        }
            }
            
            //inizio Righe nuovo Sheet 5G Bands 
            elseif ($sheet=='EN-DC List') {
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                        ->setCellValue('B' . $riga, $row['area_name'])
                         ->setCellValue('C' . $riga, $row['nome_requisito'])
                        ->setCellValue('D' . $riga, $row['example'])  
                        ->setCellValue('E' . $riga, $row['label'])                      
                        ->setCellValue('F' . $riga, $row['descrizione_requisito'])
                        ->setCellValue('G' . $riga, $row['devicetype'])
                        ->setCellValue('H' . $riga, $valore_requisito)
                        ->setCellValue('I' . $riga, $note);



                ############ Elimino protezione sulle due colonne #########################
                $objPHPExcel->getActiveSheet()->getStyle('H'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                // $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                ###########################################################################
            
                   if ($row['opzioni_requisito'] != "") {
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $riga)->getDataValidation();
                        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                        // $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                        $objValidation->setAllowBlank(false);
                        $objValidation->setShowInputMessage(true);
                        $objValidation->setShowErrorMessage(true);
                        $objValidation->setShowDropDown(true);
                        $objValidation->setErrorTitle('Input error');
                        $objValidation->setError('Value is not in list.');
                        $objValidation->setPromptTitle('Pick from list');
                        $objValidation->setPrompt('Please pick a value from the drop-down list.');
                        $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                        //$objValidation->setFormula1($row['opzioni_requisito']);
                    }

                //$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             
                
                if($bands != $row['nome_requisito']){
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':I' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK); 
                    $bands = $row['nome_requisito'];
                }
                
                //ultime due colonne in giallo
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$riga . ':I' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00ffff00'); 
                
            }
           
            $riga++;
         
       }
       
        //rimozione sheet Worksheet 
        $objPHPExcel->removeSheetByIndex(
            $objPHPExcel->getIndex(
                $objPHPExcel->getSheetByName('Worksheet')
            )
        );
        $objPHPExcel->setActiveSheetIndex(0);
        
        

        if ($devicename != false) $filename = "RFI_" . $tipo_terminale."_".$device_vendor."_".$devicename. ".xlsx";
            else $filename = "Template_RFI_". $tipo_terminale. ".xlsx";
       
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }   
    
    
function exportRFItestValue ($tipo_terminale, $devicename, $device_vendor ="", $id_project) {
        
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("WindTre")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc")
                ->setKeywords("newProtection_STYLE_STOP");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        if($tipo_terminale=='Featurephone'){
            $tipo_terminale = 'phone';
        }
        elseif ((strcasecmp($tipo_terminale, 'MBB') == 0) or (strcasecmp($tipo_terminale, 'Router') == 0) or (strcasecmp($tipo_terminale, 'Datacard') == 0) ){
            $tipo_terminale = 'Router';
        }
        if (isset($id_project)){
            //$query = "SELECT dati_requisiti.*,dati_valori_requisiti.valore_requisito,dati_valori_requisiti.note FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project =  '".$id_project."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `ordine`";    
            $query = "SELECT dati_requisiti.*,dati_valori_requisiti.valore_requisito,dati_valori_requisiti.note,dati_valori_requisiti_test.valore_requisito as valore_test,dati_valori_requisiti_test.id_usermodify as user_test, dati_valori_requisiti_test.data_modifica,dati_valori_requisiti_test.sw_version,dati_valori_requisiti_test.history FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project = '".$id_project."' ) left JOIN dati_valori_requisiti_test ON ( dati_requisiti.id = dati_valori_requisiti_test.id_requisito AND dati_valori_requisiti_test.id_project = '".$id_project."' ) where (dati_requisiti.lista_req LIKE '%".$tipo_terminale."%' and dati_requisiti.stato = 1) order by `sheet_name`, `ordine`";
            
        }
            #$result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
            $result = mysqli_query($this->mysqli, $query) or die($query . " - " . $this->mysqli->error);    

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        include_once(__DIR__.'/access_user/access_user_class.php');
        $my_access = New Access_user();
        
        while ($row = mysqli_fetch_array($result)) {
            //$row['sheet_name'] = "All Requirements";
            $id_requisito = $row['id'];
            #print_r($row['descrizione_requisito']);
            if (isset($id_project)){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
                $valore_test = $row['valore_test'];
                $user_test_id = $row['user_test'];
                $data_modifica_test = $row['data_modifica'];
                $sw_version = $row['sw_version'];
                $history_test = ''; 
                if(count(explode('|',$row['history'])) > 1){
                    $history_test = $row['history']; 
                }  
                
                 
                if($user_test_id > 0){
                   $user_test = $my_access->get_ForeignUser($user_test_id);
                   $user_test = 'SW['.$sw_version.'] '.$user_test.' '.$data_modifica_test; 
                } 
                else {
                    $user_test = '';
                }
                
            }
            else {
                $valore_requisito = '';
                $note = '';
               
            }

            
            if ($sheet != $row['sheet_name'] and $row['sheet_name']!='EN-DC List') {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:H1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Answers")
                        ->setCellValue('D1', "Notes")
                        ->setCellValue('E1', "Example")
                        ->setCellValue('F1', "Test Log Result (last entry)")
                        ->setCellValue('G1', "Tester User (last entry)")
                        ->setCellValue('H1', "History Results");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("60");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("20");  
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("40");  
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("400");  
                
                $objPHPExcel->getActiveSheet()->getStyle('A1:H350')
                ->getAlignment()->setWrapText(true);
                
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;
            }
            
            //inizio intestazione nuovo Sheet
            elseif($sheet != $row['sheet_name'] and $row['sheet_name'] =='EN-DC List') {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $bands = '';
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()
                        ->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Type")
                        ->setCellValue('C1', "LTE Bands")
                        ->setCellValue('D1', "NR Bands")
                        ->setCellValue('E1', "Order")
                        ->setCellValue('F1', "Downlink")
                        ->setCellValue('G1', "Uplink")
                        ->setCellValue('H1', "Support (True/False)")
                        ->setCellValue('I1', "Comments")
                        ->setCellValue('J1', "Test Log Result (last entry)")
                        ->setCellValue('K1', "Tester User (last entry)")
                        ->setCellValue('L1', "History Results");
                        

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("15");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("25");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("15");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("15");       
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");  
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("25");  
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("20");     
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("40"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("20");     
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("40"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("400"); 
                $objPHPExcel->getActiveSheet()->getStyle('A1:K600')
                ->getAlignment()->setWrapText(true);
                
                
                
                $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:L1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:l1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;
                
            }
            
                
            if ($area != $row['area_name']  and $sheet!='EN-DC List') {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('F'.$riga . ':H' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00809FDF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            elseif ($area != $row['area_name']  and  $sheet=='EN-DC List') {
                #$riga++;
                $objPHPExcel->getActiveSheet()->getStyle('B'.$riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');

                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':K' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                //$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':K' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':K' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':G' . $riga)->getFont()->setBold(true);
                //$riga++;
                $area = $row['area_name'];
            }
            
            
            
            if ($sheet!='EN-DC List') {
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                        ->setCellValue('B' . $riga, $row['label'])
                        ->setCellValue('C' . $riga, $valore_requisito)
                        ->setCellValue('D' . $riga, $note)
                        ->setCellValue('E' . $riga, $row['example'])
                        ->setCellValue('F' . $riga, $valore_test)
                        ->setCellValue('G' . $riga, $user_test)
                        ->setCellValue('H' . $riga, $history_test);


                ############ Elimino protezione sulle due colonne #########################
                $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                // $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                ###########################################################################
                
                if ($row['opzioni_requisito'] != "") {
                        $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                        // $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                        $objValidation->setAllowBlank(false);
                        $objValidation->setShowInputMessage(true);
                        $objValidation->setShowErrorMessage(true);
                        $objValidation->setShowDropDown(true);
                        $objValidation->setErrorTitle('Input error');
                        $objValidation->setError('Value is not in list.');
                        $objValidation->setPromptTitle('Pick from list');
                        $objValidation->setPrompt('Please pick a value from the drop-down list.');
                        $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                        //$objValidation->setFormula1($row['opzioni_requisito']);
                    }

                        //yellow row highlighting
                        if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                            $linecolor = $row['linecolor'];
                            $color =  str_replace('#','00',$linecolor);                
                            $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB(''.$color.'');
                            $objPHPExcel->getActiveSheet()->getStyle('F'.$riga . ':H' . $riga)->getFill()
                                    ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                                    ->getStartColor()->setARGB('00809FDF');
                        }
            }
            
            //inizio Righe nuovo Sheet 5G Bands 
            elseif ($sheet=='EN-DC List') {
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                        ->setCellValue('B' . $riga, $row['area_name'])
                         ->setCellValue('C' . $riga, $row['nome_requisito'])
                        ->setCellValue('D' . $riga, $row['example'])  
                        ->setCellValue('E' . $riga, $row['label'])                      
                        ->setCellValue('F' . $riga, $row['descrizione_requisito'])
                        ->setCellValue('G' . $riga, $row['devicetype'])
                        ->setCellValue('H' . $riga, $valore_requisito)
                        ->setCellValue('I' . $riga, $note)
                        ->setCellValue('J' . $riga, $valore_test)
                        ->setCellValue('K' . $riga, $user_test)
                        ->setCellValue('L' . $riga, $history_test);



                ############ Elimino protezione sulle due colonne #########################
                $objPHPExcel->getActiveSheet()->getStyle('H'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                $objPHPExcel->getActiveSheet()->getStyle('I'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                
                // $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                ###########################################################################
            
                   if ($row['opzioni_requisito'] != "") {
                        $objPHPExcel->getActiveSheet()->getStyle('H'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                        $objValidation = $objPHPExcel->getActiveSheet()->getCell('H' . $riga)->getDataValidation();
                        $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                        // $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                        $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                        $objValidation->setAllowBlank(false);
                        $objValidation->setShowInputMessage(true);
                        $objValidation->setShowErrorMessage(true);
                        $objValidation->setShowDropDown(true);
                        $objValidation->setErrorTitle('Input error');
                        $objValidation->setError('Value is not in list.');
                        $objValidation->setPromptTitle('Pick from list');
                        $objValidation->setPrompt('Please pick a value from the drop-down list.');
                        $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                        //$objValidation->setFormula1($row['opzioni_requisito']);
                    }

                //$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$objPHPExcel->getActiveSheet()->getStyle($cell)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                //$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':H' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('B'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('F'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('G'.$riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
             
                
                if($bands != $row['nome_requisito']){
                    $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':L' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK); 
                    $bands = $row['nome_requisito'];
                }
                
                //ultime due colonne in giallo
                    $objPHPExcel->getActiveSheet()->getStyle('H'.$riga . ':I' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00ffff00'); 
                    $objPHPExcel->getActiveSheet()->getStyle('J'.$riga . ':L' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00809FDF'); 
                
            }
           
            $riga++;
         
       }
       
        //rimozione sheet Worksheet 
        $objPHPExcel->removeSheetByIndex(
            $objPHPExcel->getIndex(
                $objPHPExcel->getSheetByName('Worksheet')
            )
        );
        $objPHPExcel->setActiveSheetIndex(0);
        
        

        if ($devicename != false) $filename = "RFI_" . $tipo_terminale."_".$device_vendor."_".$devicename. ".xlsx";
            else $filename = "Template_RFI_". $tipo_terminale. ".xlsx";
       
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }   
    
    
    
    function exportRFI_last ($tipo_terminale, $devicename, $device_vendor ="", $id_project=null) {
        
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("WindTre")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc")
                ->setKeywords("newProtection_STYLE_STOP");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        if($tipo_terminale=='Featurephone'){
            $tipo_terminale = 'phone';
        }
        elseif ((strcasecmp($tipo_terminale, 'MBB') == 0) or (strcasecmp($tipo_terminale, 'Router') == 0) or (strcasecmp($tipo_terminale, 'Datacard') == 0) ){
            $tipo_terminale = 'Router';
        }
        if (isset($id_project))
            $query = "SELECT dati_requisiti.*,dati_valori_requisiti.valore_requisito,dati_valori_requisiti.note FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project =  '".$id_project."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `ordine`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `ordine`";
        
            #$result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
            $result = mysqli_query($this->mysqli, $query) or die($query . " - " . $this->mysqli->error);    

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $row['sheet_name'] = "All Requirements";
            $id_requisito = $row['id'];
            #print_r($row['descrizione_requisito']);
            if (isset($id_project)){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
                
            }
            else {
                $valore_requisito = '';
                $note = '';
               
            }
            if ($sheet != $row['sheet_name']) {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Answers")
                        ->setCellValue('D1', "Notes")
                        ->setCellValue('E1', "Example");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("60");                
                
                $objPHPExcel->getActiveSheet()->getStyle('A2:E350')
                ->getAlignment()->setWrapText(true);
                
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
                
            if ($area != $row['area_name']) {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                    ->setCellValue('B' . $riga, $row['label'])
                    ->setCellValue('C' . $riga, $valore_requisito)
                    ->setCellValue('D' . $riga, $note)
                    ->setCellValue('E' . $riga, $row['example']);
                    
            
            ############ Elimino protezione sulle due colonne #########################
            $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            // $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
            

            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                // $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidation->setErrorStyle( PHPExcel_Cell_DataValidation::STYLE_INFORMATION );
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Please pick a value from the drop-down list.');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }
            /*
           if ($row['summary'] == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $riga, $row['label']);
                $url = 'sheet://\''.$row['label'].'\'!A1';
                $objPHPExcel->getActiveSheet()->getCell('C'.$riga)->getHyperlink()->setUrl($url);
            }
             * 
             
            
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1('" ,Open,Closed"');
           */
            //yellow row highlighting
            if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                $linecolor = $row['linecolor'];
                $color =  str_replace('#','00',$linecolor);                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':E' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
            }
            
            $riga++;
        }
        
        
        ########################################################################
        ################## Sheet requisiti speciali con summary = 2 ############
        ########################################################################
        /*
        $query8= "SELECT count(*) as requisiti_speciali FROM  `dati_requisiti` WHERE  `lista_req` LIKE  '%".$tipo_terminale."%' AND`summary` = 2 ";
        $result8 = mysqli_query($this->mysqli,$query8) or die($query8 . " - " . mysql_error());
        $result8 = mysqli_query($this->mysqli,$query8) or die($query8 . " - " . mysql_error());
        $row = mysqli_fetch_array($result8);
        
        if ($row['requisiti_speciali'] > 0){
        
        $query6 = "SELECT * FROM  `requisiti_speciali`  ORDER BY  `requisiti_speciali`.`sheet` ASC ";          
        $result6 = mysqli_query($this->mysqli,$query6) or die($query6 . " - " . mysql_error());
        
        $sheet = "";
        #$area = "";
        
        while ($row = mysqli_fetch_array($result6)) {
            #print_r($row);
            
            $cella = trim($row['cella']);
            $nome = $row['nome'];
            
            if ($sheet != $row['sheet']) {
                //creare un nuvo sheet e stampa la prima riga di intestazione
                #$riga = 0;
                #echo "$cella --- $nome --";
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet']);
                $objPHPExcel->setActiveSheetIndex($i);
                
                $objPHPExcel->getActiveSheet()->setCellValue($cella, $nome);
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                #$objPHPExcel->getActiveSheet()->getCell("$cella")->setValue("hello\nworld");
                
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getAlignment()->setWrapText(true);
               
               $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("30");
               

                ################## Proteggo intero sheet ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
                
                 
                 
                $sheet = $row['sheet'];
                $i++;
            }
            elseif ($sheet == $row['sheet']){
                $objPHPExcel->getActiveSheet()->setCellValue($cella, $nome);
                $objPHPExcel->getActiveSheet()->getStyle('A3:K25')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                
                
            }

            
            ############ Elimino protezione sulle due colonne #########################
            #$objPHPExcel->getActiveSheet()->getStyle('B3:K25')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            #$objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
        }        
        }
        
       
        if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `nome_requisito`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `nome_requisito`";
        
            $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $trhee_rfi[$row['nome_requisito']] = $row['valore_requisito'];
            }
        }
        
        
        $newSheet = new PHPExcel_Worksheet($objPHPExcel, 'wind');
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName('wind');
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "Capability name")
                        ->setCellValue('B1', "Vendor Answer");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
            
            //associo i valori dei requisiti tre a quelli di wind    
            $query_wind = "SELECT * FROM `wind_template_all` WHERE 1";
            $result_wind = mysqli_query($this->mysqli,$query_wind) or die($query_wind . " - " . mysql_error());
            $sheet = "wind";
            
            $riga = 1;
            $color = 'ffff00';
            $wind_array = array();
            
            while ($row = mysql_fetch_assoc($result_wind)) {
                #per tabella wind_template
                #$wind_array[$row['Capability']]['Formula'] = $row['Formula']; 
                //sostituisco il ? con = per avere la formula excel
                #$vendor_answer = str_replace('?','=',$row['Vendor_Answer']);
                $wind_array[$row['Capability_name']]['Formula'] = $row['Formula'];
                
                $wind_array[$row['Capability_name']]['Capability_name'] = $row['Capability_name'];
               
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
                
                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $wind_array[$row['Capability_name']]['Capability_name'])
                    ->setCellValueExplicit('B' . $riga, $row['Formula']);
                
                $riga++;
                
                
            }
        * 
        */
        
        
        
        
        if ($devicename != false) $filename = "RFI_" . $tipo_terminale."_".$device_vendor."_".$devicename. ".xlsx";
            else $filename = "Template_RFI_". $tipo_terminale. ".xlsx";
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }   
    
    function exportRFI_bkp ($tipo_terminale, $devicename, $device_vendor ="", $id_project) {
        $now = date("YmdHis");  
                /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("WindTre")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc")
                ->setKeywords("newProtection_STYLE_STOP");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        if($tipo_terminale=='Featurephone'){
            $tipo_terminale = 'phone';
        }
        elseif ((strcasecmp($tipo_terminale, 'MBB') == 0) or (strcasecmp($tipo_terminale, 'Router') == 0) or (strcasecmp($tipo_terminale, 'Datacard') == 0) ){
            $tipo_terminale = 'Router';
        }
        if (isset($id_project))
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project =  '".$id_project."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `ordine`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `ordine`";
        
            #$result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
            $result = mysqli_query($this->mysqli, $query) or die($sql . " - " . $this->mysqli->error);    

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            $row['sheet_name'] = "All Requirements";
            #print_r($row['descrizione_requisito']);
            if (isset($id_project)){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
                $id_requisito = $row['id_requisito'];
            }
            else {
                $valore_requisito = '';
                $note = '';
                $id_requisito = $row['id'];
            }
            if ($sheet != $row['sheet_name']) {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Answers")
                        ->setCellValue('D1', "Notes")
                        ->setCellValue('E1', "AP Status")
                        ->setCellValue('F1', "Example");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("60");
                
                $objPHPExcel->getActiveSheet()->getStyle('A2:F350')
                ->getAlignment()->setWrapText(true);
                
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
                
            if ($area != $row['area_name']) {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                    ->setCellValue('B' . $riga, $row['label'])
                    ->setCellValue('C' . $riga, $valore_requisito)
                    ->setCellValue('D' . $riga, $note)
                    ->setCellValue('F' . $riga, $row['example']);
                    
            
            ############ Elimino protezione sulle due colonne #########################
            $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
            

            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }
           if ($row['summary'] == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $riga, $row['label']);
                $url = 'sheet://\''.$row['label'].'\'!A1';
                $objPHPExcel->getActiveSheet()->getCell('C'.$riga)->getHyperlink()->setUrl($url);
            }
            
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1('" ,Open,Closed"');
           
            //yellow row highlighting
            if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                $linecolor = $row['linecolor'];
                $color =  str_replace('#','00',$linecolor);                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
            }
            
            $riga++;
        }           
        
        $filename = $now."_rfi_" . $tipo_terminale."_".$device_vendor."_".$devicename. ".xlsx";

        $objPHPExcel->setActiveSheetIndex(0); 
        
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('./BKPRFI/'.$filename);
        #exit;
    } 
    
   function export_MDM_ingestion( $project_id,$tipo_terminale,$devicename, $device_vendor) {
        
        if($tipo_terminale=='Featurephone'){
            $tipo_terminale = 'phone';
        }
        elseif ((strcasecmp($tipo_terminale, 'MBB') == 0) or (strcasecmp($tipo_terminale, 'Router') == 0) or (strcasecmp($tipo_terminale, 'Datacard') == 0) ){
            $tipo_terminale = 'Router';
        }
            
        //Vecchia query che utilizza dati_requisiti e dati_valori_requisiti
            #$query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project =  '".$project_id."' )  where ( dati_requisiti.stato = 1 and dati_requisiti.description_mdm<>'nomap' )  order by `ordine`";    
            
        //new query che utilizza la tabella mdn_list
            $query = "SELECT mdm_list.mdm_description, dati_valori_requisiti.valore_requisito FROM mdm_list LEFT JOIN dati_valori_requisiti ON ( mdm_list.id_requisito>0 and mdm_list.id_requisito = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project = '".$project_id."' ) where 1 order by `ordine`";

        
        
            #$result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
            $result = $this->mysqli->query($query) or die($query . " - " . $this->mysqli->error);
        
            #$query = $db->query("SELECT * FROM members ORDER BY id DESC");

if($result->num_rows > 0){
    $delimiter = ";";
    $filename = "MDM_ingestion_" . date('Y-m-d') . "_".$device_vendor."_".$devicename.".csv";
    
    //create a file pointer
    $f = fopen('php://memory', 'w');
    
    //set column headers
    #$fields = array('Description', 'Value');
    #fputcsv($f, $fields, $delimiter);
    
    //output each row of the data, format line as csv and write to file pointer
    while($row = $result->fetch_assoc()){
        #$status = ($row['status'] == '1')?'Active':'Inactive';
        if($row['valore_requisito']=='True' or $row['valore_requisito']=='False'){
            $row['valore_requisito'] = strtolower($row['valore_requisito'] );
        }
        
       
        $lineData = array($row['mdm_description'], trim($row['valore_requisito']));
        fputcsv($f, $lineData, $delimiter);
    }
    
    //move back to beginning of file
    fseek($f, 0);
    
    //set headers to download file rather than displayed
    header('Content-Type: text/csv');
    header('Content-Disposition: attachment; filename="' . $filename . '";');
    
    //output all remaining data on a file pointer
    fpassthru($f);
}
            
           
        exit;
    }  
    
    
    function export_LSoc_with_windslide($tipo_terminale, $devicename) {
        $devicename = base64_decode($devicename);
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        
        if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `nome_requisito`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `nome_requisito`";
        
            $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
            }
            else {
                $valore_requisito = '';
                $note = '';
            }
            if ($sheet != $row['sheet_name']) {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "O/M")
                        ->setCellValue('D1', "Answers")
                        ->setCellValue('E1', "Notes")
                        ->setCellValue('F1', "AP Status");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("5");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("10");
                
                $objPHPExcel->getActiveSheet()->getStyle('A2:E150')
                ->getAlignment()->setWrapText(true);
                $objPHPExcel->getActiveSheet()->getStyle('A2:E150')
                ->getAlignment()->setWrapText(true);
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
                
            if ($area != $row['area_name']) {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['nome_requisito'])
                    ->setCellValue('B' . $riga, $row['descrizione_requisito'])
                    ->setCellValue('C' . $riga, $row['mandatoryoptional'])
                    ->setCellValue('D' . $riga, $valore_requisito)
                    ->setCellValue('E' . $riga, $note);
            
            ############ Elimino protezione sulle due colonne #########################
            $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('F'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
            

            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('D' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }
           if ($row['summary'] == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue('D' . $riga, $row['label']);
                $url = 'sheet://\''.$row['label'].'\'!A1';
                $objPHPExcel->getActiveSheet()->getCell('D'.$riga)->getHyperlink()->setUrl($url);
            }
            
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('F' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_INFORMATION);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1('" ,Open,Closed"');
           
            //yellow row highlighting
            if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                $linecolor = $row['linecolor'];
                $color =  str_replace('#','00',$linecolor);                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
            }
            
            $riga++;
        }
        
        
        ########################################################################
        ################## Sheet requisiti speciali con summary = 2 ############
        ########################################################################
        
        $query8= "SELECT count(*) as requisiti_speciali FROM  `dati_requisiti` WHERE  `lista_req` LIKE  '%".$tipo_terminale."%' AND`summary` = 2 ";
        $result8 = mysqli_query($this->mysqli,$query8) or die($query8 . " - " . mysql_error());
        $result8 = mysqli_query($this->mysqli,$query8) or die($query8 . " - " . mysql_error());
        $row = mysqli_fetch_array($result8);
        
        if ($row['requisiti_speciali'] > 0){
        
        $query6 = "SELECT * FROM  `requisiti_speciali`  ORDER BY  `requisiti_speciali`.`sheet` ASC ";          
        $result6 = mysqli_query($this->mysqli,$query6) or die($query6 . " - " . mysql_error());
        
        $sheet = "";
        #$area = "";
        
        while ($row = mysqli_fetch_array($result6)) {
            #print_r($row);
            
            $cella = trim($row['cella']);
            $nome = $row['nome'];
            
            if ($sheet != $row['sheet']) {
                //creare un nuvo sheet e stampa la prima riga di intestazione
                #$riga = 0;
                #echo "$cella --- $nome --";
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet']);
                $objPHPExcel->setActiveSheetIndex($i);
                
                $objPHPExcel->getActiveSheet()->setCellValue($cella, $nome);
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                #$objPHPExcel->getActiveSheet()->getCell("$cella")->setValue("hello\nworld");
                
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getAlignment()->setWrapText(true);
               
               $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A2:K2')->getFont()->setBold(true);
                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("30");
               

                ################## Proteggo intero sheet ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
                
                 
                 
                $sheet = $row['sheet'];
                $i++;
            }
            elseif ($sheet == $row['sheet']){
                $objPHPExcel->getActiveSheet()->setCellValue($cella, $nome);
                $objPHPExcel->getActiveSheet()->getStyle('A3:K25')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
                #$objPHPExcel->getActiveSheet()->getStyle($cella)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_PROTECTED);
                
                
            }

            
            ############ Elimino protezione sulle due colonne #########################
            #$objPHPExcel->getActiveSheet()->getStyle('B3:K25')->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            #$objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
        }        
        }
        
       /*
        if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `nome_requisito`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `nome_requisito`";
        
            $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $trhee_rfi[$row['nome_requisito']] = $row['valore_requisito'];
            }
        }
        
        
        $newSheet = new PHPExcel_Worksheet($objPHPExcel, 'wind');
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName('wind');
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                

                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "Capability name")
                        ->setCellValue('B1', "Vendor Answer");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getStyle('A1:B160')
                ->getAlignment()->setWrapText(true);
                #$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setAutoSize();
                #$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setAutoSize();

                ################## Proteggo intero sheet ####################
                #$objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                #$objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                #$objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                #$objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                #$objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                #############################################################
            
            //associo i valori dei requisiti tre a quelli di wind    
            $query_wind = "SELECT * FROM `wind_template` WHERE 1";
            $result_wind = mysqli_query($this->mysqli,$query_wind) or die($query_wind . " - " . mysql_error());
            $sheet = "wind";
            
            $riga = 2;
            $color = 'ffff00';
            $wind_array = array();
            
            while ($row = mysql_fetch_assoc($result_wind)) {
                #per tabella wind_template
                #$wind_array[$row['Capability']]['Formula'] = $row['Formula']; 
                //sostituisco il ? con = per avere la formula excel
                #$vendor_answer = str_replace('?','=',$row['Vendor_Answer']);
                $wind_array[$row['Capability']]['Formula'] = $row['Formula'];
                
                $wind_array[$row['Capability']]['Capability'] = $row['Capability'];
               
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
                
                
                #$internalFormula = PHPExcel_Calculation::getInstance()->translateFormulaToEnglish($row['Formula']);
                #$internalFormula = str_replace ("SE", "IF", $row['Formula']);
                #$locale = 'en';
                #$validLocale = PHPExcel_Settings::setLocale($locale);

                
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $wind_array[$row['Capability']]['Capability'])
                    ->setCellValueExplicit('B' . $riga, $row['Formula']);
                //->setCellValue('B' . $riga, "".$internalFormula."");
                
                
                #$formula  = '=\'General Information\'!D10';
                
                #$formulaa = '=SE(\'General Information\'!D10=\"\";\"\";)';
                #$objPHPExcel->getActiveSheet()->setCellValueExplicit('C' . $riga, $formula);
                #$objPHPExcel->getActiveSheet()->setCellValue('D'. $riga, $formula);
                
                $riga++;                
                
            } 
        * 
        */



            

        if ($devicename != false) $filename = "export_LSoC_" . $tipo_terminale."_".$devicename. ".xlsx";
            else $filename = "Template_LSoC_". $tipo_terminale. ".xlsx";
        $objPHPExcel->setActiveSheetIndex(0);
        
                
        //Leggo lo sheet Wind con le formule di Daniele e lo aggiungo alla fine della LSO    
        $objPHPExcel1 = PHPExcel_IOFactory::load("Template_LSoC_Phone_2H2017_prefinal_v3.xlsx");
        $sheetTocopy = 'Wind';
        $sheet = $objPHPExcel1->getSheetByName($sheetTocopy);
        $sheet->setTitle($sheetTocopy);
        $objPHPExcel->addExternalSheet($sheet);
        unset($sheet);
        
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }   
    
    
    function export_LSoc_Wind($tipo_terminale, $devicename) {
        /*
         * 1. Usare il template vuoto excel solo rfi wind da riempire
         * 2. Creare Tabella nel DB con gli rfi Wind e la dipendenza con requisiti 3
         * 3. Select degli RFI di 3 dello specifico device
         * 4. Parsing del valore ed inserimento nel file excel template di Wind
         * 
         * 
         * 
         */
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/London');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("H3G")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc");
        
        
        $objPHPExcel->setActiveSheetIndex(0);
                        ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('THingegneria2013');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
        
        if ($devicename != false)
            $query = "SELECT * FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.nome_tel =  '".$devicename."' )  where (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%' and dati_requisiti.stato = 1)  order by `sheet_name`, `nome_requisito`";    
        else 
            $query = "SELECT * FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_requisiti.stato = 1) order by `sheet_name`, `nome_requisito`";
        
            $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";

        $trhee_rfi = array();
        while ($row = mysqli_fetch_array($result)) {
            #print_r($row['descrizione_requisito']);
            if ($devicename != false){
                $trhee_rfi[$row['nome_requisito']] = $row['valore_requisito'];
                $trhee_rfi[$row['note']] = $row['note'];
                
            }
      
        }
            /*
                echo'<pre>';
                print_r($trhee_rfi);
                echo'</pre>';
             * 
             */
                $i = 0;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, 'wind');
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName('wind');
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "Capability name")
                        ->setCellValue('B1', "Vendor Answer");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("30");
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
            
            //associo i valori dei requisiti tre a quelli di wind    
            $query_wind = "SELECT * FROM `wind_template` WHERE 1";
            $result_wind = mysqli_query($this->mysqli,$query_wind) or die($query_wind . " - " . mysql_error());
            $sheet = "wind";
            
            $riga = 2;
            $color = 'ffff00';
            $wind_array = array();
            
            while ($row = mysql_fetch_assoc($result_wind)) {
                #per tabella wind_template
                #$wind_array[$row['Capability']]['Formula'] = $row['Formula']; 
                $wind_array[$row['Capability']]['Capability'] = $row['Capability'];
                $wind_array[$row['Capability']]['Formula'] = $row['Formula'];
                $wind_array[$row['Capability']]['Vendor_Answer'] = $row['Vendor_Answer'];
                $wind_array[$row['Capability']]['value'] = null;
                #$objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                 #       ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                  #      ->getStartColor()->setARGB(''.$color.'');
                
                //function wind_rfi_value($wind_rfi_id, $three_rfi)
                
                if($wind_array[$row['Capability']]['Capability'] == 'tac') 
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['GEN-INFO-PDG-13.03'];
                
                if($wind_array[$row['Capability']]['Capability'] == 'device_make') 
                    $wind_array[$row['Capability']]['value']=$trhee_rfi['GEN-INFO-PDG-01.01.01'];
                
                if($wind_array[$row['Capability']]['Capability'] == 'device_model')
                   $wind_array[$row['Capability']]['value'] = $trhee_rfi['GEN-INFO-PDG-01.01'];
                
                if($wind_array[$row['Capability']]['Capability'] == '3g'){
                    //se data_capability_class contiene 3G 
                    if (strstr($trhee_rfi['HW-INFO-PDG-02.12'], '3g')) {
                        $wind_array[$row['Capability']]['value'] = 'True';}
                    else  {
                        $wind_array[$row['Capability']]['value'] = 'False';                    
                    }                      
                }
                
                if ($wind_array[$row['Capability']]['Capability'] == 'audio')
                    $wind_array['audio']['value'] = '';
               if ($wind_array[$row['Capability']]['Capability'] == 'audio_player')
                    $wind_array['audio_player']['value'] = '';
                
                if ($wind_array[$row['Capability']]['Capability'] == 'audio_formats'){
                    //MEDIA-PDG-2.1 --> TD988_M-Table-MEDIA-PDG-3.1
                    if (!empty ($trhee_rfi['MEDIA-PDG-2.1']['note'])) {
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['MEDIA-PDG-3.1']['note'];
                        $wind_array['audio']['value'] = 'True';
                        $wind_array['audio_player']['value'] = 'True';  
                    }
                }   

                if ($wind_array[$row['Capability']]['Capability'] == 'battery_gsm_standby_time')
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-02.08'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'battery_gsm_talk_time')
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-04.04'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'battery_umts_wcdma_standby_time')
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-04.03'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'bluetooth'){
                    if(!empty($trhee_rfi['HW-INFO-PDG-11.02.02'])) 
                        $wind_array[$row['Capability']]['value'] = 'True';
                    else $wind_array[$row['Capability']]['value'] = 'False';
                }
                     
                if ($wind_array[$row['Capability']]['Capability'] == 'bluetooth_profiles')
                    $wind_array[$row['Capability']]['value'] = null;
                
                if ($wind_array[$row['Capability']]['Capability'] == 'bluetooth_version')
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-11.02.02'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'browser'){
                    if(!empty ($trhee_rfi['BRWS-PDG-01.01'])) 
                        $wind_array[$row['Capability']]['value'] = 'True';
                    else $wind_array[$row['Capability']]['value'] = 'False';
                }    
                
                if ($wind_array[$row['Capability']]['Capability'] == 'browser_type')
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['BRWS-PDG-01.01'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'browser_version')
                    $wind_array[$row['Capability']]['value'] = null;
                
                if ($wind_array[$row['Capability']]['Capability'] == 'browser_features')
                    //Da verificare
                    $wind_array[$row['Capability']]['value'] = null;
                
                if ($wind_array[$row['Capability']]['Capability'] == 'memory_built_in_memory')
                    $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-03.03'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'cpu_clock_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-02.04'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'cpu_type')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-02.01'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'cpu_unit_count')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-02.04'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary_resolution')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.02'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.02'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary_digital_zoom')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.02.02'];
                
                #if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary_features')
                 #       $wind_array[$row['Capability']]['value'] = $trhee_rfi[''];
                if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary_optical_zoom')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.02.10'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary_sensor_type')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.02.11'];
                
                if ($wind_array[$row['Capability']]['Capability'] == 'camera_primary_video_zoom')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.02.12'];
                
                if($wind_array[$row['Capability']]['Capability'] == 'camera_secondary')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi[''];
                        $wind_array[$row['Capability']]['value'] =
                                ((!empty ($trhee_rfi['HW-INFO-PDG-13.03']))? $wind_array[$row['Capability']]['value'] = 'True' : $wind_array[$row['Capability']]['value'] = 'False');
                
                if($wind_array[$row['Capability']]['Capability'] == 'camera_secondary_resolution')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['HW-INFO-PDG-13.03'];
                
                if($wind_array[$row['Capability']]['Capability'] == 'display_primary_color')
                    $wind_array[$row['Capability']]['value'] =
                         ((!empty ($trhee_rfi['HW-INFO-PDG-13.03']))? $wind_array[$row['Capability']]['value'] = 'True' : $wind_array[$row['Capability']]['value'] = 'False');

                 
                if($wind_array[$row['Capability']]['Capability'] == 'drm')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.09'];
                
                if($wind_array[$row['Capability']]['Capability'] == 'drm_delivery_method')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];

                
                if($wind_array[$row['Capability']]['Capability'] == 'drm_oma_drm_features')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];    
                
                if($wind_array[$row['Capability']]['Capability'] == 'drm_windows_media_drm')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];                
                if($wind_array[$row['Capability']]['Capability'] == 'drm_windows_media_drm_support')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'data_capable')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'data_capability_class')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'data_capability_type')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'data_capability_segment')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'device_type')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'device_hierarchy_class')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'device_hierarchy_group')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'device_hierarchy_type')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'device_provisioning_features')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'dimensions_device_height')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'dimensions_device_length')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'dimensions_device_shape')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'dimensions_device_weight')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'dimensions_device_width')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'display_primary')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'display_primary_color_depth')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'display_primary_resolution_height')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'display_primary_resolution_width')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'display_primary_touch_screen')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary_color')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary_color_depth')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary_resolution_height')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary_resolution_width')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary_size')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'display_secondary_touch_screen')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'documents')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'documents_formats')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'dual_sim')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];                   if($wind_array[$row['Capability']]['Capability'] == 'drm_delivery_method')
            
                if($wind_array[$row['Capability']]['Capability'] == 'email')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'edge_maximum_upload_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'email_features')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'drm_delivery_method')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'hardware_extra_features')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'fm_radio')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'gprs_maximum_download_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'gprs_maximum_upload_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'gprs_class')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'drm_delivery_method')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'gps')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'gsm_voice_call')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'graphics_formats')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'hsdpa_maximum_download_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'hsdpa_category')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                
                if($wind_array[$row['Capability']]['Capability'] == 'hsupa_maximum_upload_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'hsupa_category')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'infrared')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'input_methods')
                    
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'hardware_extra_features')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'fm_radio')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'gprs_maximum_download_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'gprs_maximum_upload_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'gprs_class')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'drm_delivery_method')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'gps')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'gsm_voice_call')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'graphics_formats')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];   
                if($wind_array[$row['Capability']]['Capability'] == 'hsdpa_maximum_download_rate')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];              
                if($wind_array[$row['Capability']]['Capability'] == 'hsdpa_category')
                        $wind_array[$row['Capability']]['value'] = $trhee_rfi['SEC-PDG-05.11'];                 
                
                
                    
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $wind_array[$row['Capability']]['Capability'])
                    ->setCellValue('B' . $riga, $wind_array[$row['Capability']]['value']);

                $riga++;
             
            }
        
   
          
        if ($devicename != false) $filename = "export_LSoC_" . $tipo_terminale."_".$devicename . ".csv";
            else $filename = "Template_LSoC_". $tipo_terminale. ".csv";
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
   
       
       
       /*
                echo'<pre>';
                print_r($wind_array);
                echo'</pre>';
        * 
        */
       
        
    

       
        
    }
    
    function exportRFIOldProject ($tipo_terminale, $devicename, $device_vendor ="", $id_project=null) {
        
        /** Error reporting */
        error_reporting(E_ALL);
        ini_set('display_errors', TRUE);
        ini_set('display_startup_errors', TRUE);
        date_default_timezone_set('Europe/Rome');

        if (PHP_SAPI == 'cli')
            die('This example should only be run from a Web Browser');
        $objPHPExcel = new PHPExcel();
        $objPHPExcel->getProperties()->setCreator("WindTre")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("LSoc")
                ->setKeywords("newProtection_STYLE_STOP");


        $objPHPExcel->setActiveSheetIndex(0);
       
        #if (isset($_GET['colorline'])) $colorline = $_GET['colorline'];
        #else $colorline = false;
        //export sempre con righe gialle
        $colorline="yellow";
        
        #$query = "SELECT * FROM dati_requisiti where stato=1 and devicetype='$tipo_terminale' order by sheet_name, area_name,nome_requisito";
        if($tipo_terminale=='Featurephone'){
            $tipo_terminale = 'phone';
        }
        elseif ((strcasecmp($tipo_terminale, 'MBB') == 0) or (strcasecmp($tipo_terminale, 'Router') == 0) or (strcasecmp($tipo_terminale, 'Datacard') == 0) ){
            $tipo_terminale = 'Router';
        }
        if (isset($id_project))
            $query = "SELECT dati_requisiti.*,dati_valori_requisiti.valore_requisito,dati_valori_requisiti.note FROM dati_requisiti LEFT JOIN dati_valori_requisiti ON ( dati_requisiti.id = dati_valori_requisiti.id_requisito AND dati_valori_requisiti.id_project =  '".$id_project."' )  WHERE  (dati_requisiti.lista_req LIKE   '%".$tipo_terminale."%') and ((dati_valori_requisiti.valore_requisito !='' and dati_valori_requisiti.valore_requisito IS NOT NULL) OR (dati_valori_requisiti.note IS NOT NULL AND dati_valori_requisiti.note !='') OR  dati_requisiti.stato = 1 ) order by `ordine`";    
        else 
            exit('ID_Project cannnot be NULL !!');
            #$query = "SELECT dati_requisiti.*,dati_valori_requisiti.valore_requisito,dati_valori_requisiti.note FROM `dati_requisiti` WHERE (`lista_req` LIKE '%".$tipo_terminale."%') and (dati_valori_requisiti.valore_requisito is NOT null  OR dati_valori_requisiti.note IS NOT NULL OR dati_requisiti.stato = 1 ) order by `ordine`";
        
            #$result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
            $result = mysqli_query($this->mysqli, $query) or die($query . " - " . $this->mysqli->error);    

        #echo "<tr><td>ID REQUISITO</td><td> DESCRIZIONE REQUISITO </td><td> MANDATORY (Optional)</td><td> ETICHETTA</td><td> DATA (Optional) </td><td> RISPOSTA </td><tr>";
        $sheet = "";
        $area = "";
        $i = 0;
        while ($row = mysqli_fetch_array($result)) {
            
            #if($row['stato']==1 || ($row['valore_requisito'])
            $row['sheet_name'] = "All Requirements";
            $id_requisito = $row['id'];
            #print_r($row['descrizione_requisito']);
            if (isset($id_project)){
                $valore_requisito = $row['valore_requisito'];
                $note = $row['note'];
                
            }
            else {
                $valore_requisito = '';
                $note = '';
             
            }
            if ($sheet != $row['sheet_name']) {
                //creare un nuovo sheet e stampa la prima riga di intestazione
                $riga = 1;
                $newSheet = new PHPExcel_Worksheet($objPHPExcel, $row['sheet_name']);
                $objPHPExcel->addSheet($newSheet, $i);

                //$objPHPExcel->setActiveSheetIndex(0);
                $objPHPExcel->getSheetByName($row['sheet_name']);
                $objPHPExcel->setActiveSheetIndex($i);
 
               
               $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                $objPHPExcel->getActiveSheet()->getStyle('A1:F1')->getFont()->setBold(true);
                
                $objPHPExcel->getActiveSheet()->setCellValue('A1', "ID")
                        ->setCellValue('B1', "Description")
                        ->setCellValue('C1', "Answers")
                        ->setCellValue('D1', "Notes")
                        ->setCellValue('E1', "AP Status")
                        ->setCellValue('F1', "Example");

                $objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("15"); 
                $objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("40");
                $objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("10");
                $objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("60");
                
                $objPHPExcel->getActiveSheet()->getStyle('A2:F650')
                ->getAlignment()->setWrapText(true);
                
                
                /*
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                $objPHPExcel->getActiveSheet()->getStyle('A1:E1')->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THICK);
                */

                ################## Proteggo intero documento ####################
                $objPHPExcel->getActiveSheet()->getProtection()->setPassword('ingegneria2017');
                $objPHPExcel->getActiveSheet()->getProtection()->setSheet(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setSort(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setInsertRows(true);
                $objPHPExcel->getActiveSheet()->getProtection()->setFormatCells(true);
                ###########################################################
   
                $sheet = $row['sheet_name'];
                $i++;
                $riga++;

            }
                
            if ($area != $row['area_name']) {
                #$riga++;
                $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $row['area_name']);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB('00BFBFBF');
                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getTop()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getBottom()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getLeft()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getBorders()->getRight()->setBorderStyle(PHPExcel_Style_Border::BORDER_THIN);
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFont()->setBold(true);
                $riga++;
                $area = $row['area_name'];
            }
            
            
            
            
            $objPHPExcel->getActiveSheet()->setCellValue('A' . $riga, $id_requisito)
                    ->setCellValue('B' . $riga, $row['label'])
                    ->setCellValue('C' . $riga, $valore_requisito)
                    ->setCellValue('D' . $riga, $note)
                    ->setCellValue('F' . $riga, $row['example']);
                    
            
            ############ Elimino protezione sulle due colonne #########################
            $objPHPExcel->getActiveSheet()->getStyle('C'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('D'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            $objPHPExcel->getActiveSheet()->getStyle('E'.$riga)->getProtection()->setLocked(PHPExcel_Style_Protection::PROTECTION_UNPROTECTED);
            ###########################################################################
            

            if ($row['opzioni_requisito'] != "") {
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('C' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1(str_replace(";", ",", "\"" . $row['opzioni_requisito'] . "\""));
                //$objValidation->setFormula1($row['opzioni_requisito']);
            }
           if ($row['summary'] == 2) {
                $objPHPExcel->getActiveSheet()->setCellValue('C' . $riga, $row['label']);
                $url = 'sheet://\''.$row['label'].'\'!A1';
                $objPHPExcel->getActiveSheet()->getCell('C'.$riga)->getHyperlink()->setUrl($url);
            }
            
                $objValidation = $objPHPExcel->getActiveSheet()->getCell('E' . $riga)->getDataValidation();
                $objValidation->setType(PHPExcel_Cell_DataValidation::TYPE_LIST);
                $objValidation->setErrorStyle(PHPExcel_Cell_DataValidation::STYLE_STOP);
                $objValidation->setAllowBlank(false);
                $objValidation->setShowInputMessage(true);
                $objValidation->setShowErrorMessage(true);
                $objValidation->setShowDropDown(true);
                $objValidation->setErrorTitle('Input error');
                $objValidation->setError('Value is not in list.');
                $objValidation->setPromptTitle('Pick from list');
                $objValidation->setPrompt('Allowed input');
                $objValidation->setFormula1('" ,Open,Closed"');
           
            //yellow row highlighting
            if ($colorline != FALSE && $row['linecolor'] != NULL ) {
                $linecolor = $row['linecolor'];
                $color =  str_replace('#','00',$linecolor);                
                $objPHPExcel->getActiveSheet()->getStyle('A'.$riga . ':F' . $riga)->getFill()
                        ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
                        ->getStartColor()->setARGB(''.$color.'');
            }
            
            
        
            $riga++;
        }
        
        
  
        
        if ($devicename != false) $filename = "OldRFI_" . $tipo_terminale."_".$device_vendor."_".$devicename. ".xlsx";
            else $filename = "Template_RFI_". $tipo_terminale. ".xlsx";
        $objPHPExcel->setActiveSheetIndex(0);
        
        
        
        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= '.$filename.'');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save('php://output');
        exit;
    }   
    
    function export_query2csv($query, $filename) {
            #$today = date("Ymd");
            header("Content-Disposition: attachment; filename=\"". $filename . ".csv\"");
            header("Content-Type: application/csv");


            $flag = false;
            $query3 = base64_decode($query);
        //echo $query3;

        //echo $query3;
            $result3 = mysqli_query($this->mysqli, $query3) or die($query3 . " - " . $this->mysqli->error);  
            #$result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
            $num_campi = mysqli_num_fields($result3);

            for ($i = 0; $i < $num_campi; $i++){
                #echo mysql_field_name($result3, $i) . ';';
                $colObj = mysqli_fetch_field_direct($result3,$i);                            
                $col = $colObj->name;
                echo $col. ';';
            }

            echo "\n";


            while ($obj3 = mysqli_fetch_array($result3)) {
                //print_r($obj3);
                for ($i = 0; $i < count($obj3) / 2; $i++)
                    echo trim($obj3[$i]) . ";";
                echo "\n";
            }
    }
    

    function export_pianificazione($list, $tot_volume, $list_day){
        include_once './classes/campaign_class.php';
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
$objPHPExcel->getActiveSheet()->mergeCells('A1:e1');
$objPHPExcel->getActiveSheet()->mergeCells('A2:e2');
$objPHPExcel->getActiveSheet()->setCellValue('A1', 'Pianificazione Campagne - Campaign Management');
$objPHPExcel->getActiveSheet()->setCellValue('A2', 'Data inizio e data fine periodo');
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

/*
foreach ($list as $key => $value) {
    
            $tot_volume['totale'] = $tot_volume['totale'] + $value['volume'];
        $volume_giorno = $campaign->day_volume($value);   

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
*/

// Rename worksheet
$objPHPExcel->getActiveSheet()->setTitle('Export');


// Set active sheet index to the first sheet, so Excel opens this as the first sheet
$objPHPExcel->setActiveSheetIndex(0);


    }


    

}
