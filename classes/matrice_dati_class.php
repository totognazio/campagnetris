<?php
include_once 'funzioni.php';


echo "<script type=\"text/javascript\" src=\"/js/1.8.2/jquery.min.js\"></script>
            <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
            <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";

class matrice_dati_class {

    var $db_link;

    function matrice_dati_class() {
        $this->db_link = $this->connect_db_li();
    }

    function connect_db_li() {
        //$conn_str = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        $conn_str = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die("Error " . mysqli_error($conn_str));
        //   var_dump($conn_str);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        return $conn_str;
    }

    
    function windtable_net($month) { 
        $pieces = explode("_", $month);
        $mese_rete = $pieces[0]."_rete_".$pieces[1];
        return $mese_rete;
    }  
    function multi_axes_multi2($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false, $tariffa = "") {
    connect_db();
    //echo $tipo_terminale;
    include_once 'dati_class.php';
    $dati = new dati_class();
    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    $riga = 0;
    $matrice_risultati = array();

    if ($piano == NULL)
        $piano = "S";
    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( n_modello2 )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;
        case "numero_ter":

            $unita_misura = "k";
            $ordinata = "# devices";
            $matrice_risultati = $dati->numero_terminali($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;

        case "numero_ter_LTE":

            $unita_misura = "k";
            $ordinata = "# devices";

            $matrice_risultati = $dati->numero_terminali_LTE($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;

        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            $matrice_risultati = $dati->usage_voce($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;

        case "PDP":

            $unita_misura = "";
            $ordinata = "PDP (numero)";
            echo $parametro_di_ricerca;


            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                        $pdp_sum_fullroamers_tot = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "chiamate_non_risposte":

            $unita_misura = "";
            $ordinata = "Chiamate non risposte (numero)";
            $pdp_sum_fullroamers_tot = 0;

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                            $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                        else
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            $matrice_risultati = $dati->voce_totale($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";
            $matrice_risultati = $dati->usage_dati($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);

            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            $matrice_risultati = $dati->usage_voce($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;


        case "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
            $unita_misura = "T";
            $ordinata = "data traffic";
            $matrice_risultati = $dati->dati_totale($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);

            break;

        default:
            break;
    }
    ?>
    <div class="charts">
        <div class="col-md-12 stats-info  widget-shadow">
    <?php
    echo "
        <script src=\"https://code.highcharts.com/highcharts.js\"></script>
<script src=\"https://code.highcharts.com/modules/exporting.js\"></script>";
    echo "<script type=\"text/javascript\">";

    echo "var chart;
$(document).ready(function() {
    chart = new Highcharts.Chart({
        chart: {
        marginTop: 50,
        marginLeft: 80,

            renderTo: 'container',
            defaultSeriesType: 'line',
            type: 'line',
            zoomType: 'xy'

        },
        credits: {
            enabled: false
        },
		colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
        title: {
            text: ''
        },
        xAxis: [{
            labels: {
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },categories: [";
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "'$value'";
            if ($key < count($lista_nomi_visualizzati) - 1)
                echo ",";
        }
    } else
    // print_r (_nome_mese($lista_nomi));
        echo "<th>$lista_nomi_visualizzati</th>";



    echo "]}],
      yAxis: {
			marginTop: 10,
         title: {
		    align: 'high',
            offset: -60,
            rotation: 0,
            y: -20,
            text: '$ordinata'
         },$minimo
         labels: {
            formatter: function() {
               return this.value + '$unita_misura';
            },style: {
			fontSize: '14px',
			fontWeight:'bold'
            }
         },
         plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
         }]
      },
      tooltip: {
         formatter: function() {
                   return '<b>'+ this.series.name +'</b><br/>'+
               this.x +': '+ this.y + '$unita_misura';
         }
      },
      legend: {
		style: {
			fontSize: '16px',
			fontWeight:'bold'
         },
		y:20,
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        borderWidth: 0,
		floating:false
      },
      series: [";

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        echo "{type: 'spline',name: '";

        echo $matrice_risultati[$riga][0] . "',
          data: [";

        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    echo round($matrice_risultati[$riga][$colonna] * 100, 2) . "";
                    break;
                case "numero_ter":
                    echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
                    break;
                case "numero_ter_LTE":
                    echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
                    break;
                case "roaming":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "voce":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
                    echo round($matrice_risultati[$riga][$colonna], 0) . "";
                    break;

                case "voce_totale":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "chiamate_non_risposte":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "PDP":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                default:
                    break;
            }

            if ($colonna < count($lista_nomi))
                echo ",";
        }
        echo "]
      }";
        if ($riga < count($matrice_risultati) - 1)
            echo",";
    }
    echo" ]});});</script>";
    ?>

            <div id="container" style="width: 900px; height: 500px; margin: 0 auto"></div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <?php
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    $riga = count($matrice_risultati);

    echo "<div class=\"tables\">";
    $dati->stampa_matrice($matrice_risultati, $lista_nomi_visualizzati);
    $dati->stampa_incremento($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "</div>";
    echo "</div>";
}
   
    function multi_axes_multi3($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false, $tariffa = "") {
    connect_db();
    //echo $tipo_terminale;
    include_once 'dati_class.php';
    $dati = new dati_class();
    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    $riga = 0;
    $matrice_risultati = array();

    if ($piano == NULL)
        $piano = "S";
    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( n_modello2 )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;
        case "numero_ter":

            $unita_misura = "k";
            $ordinata = "# devices";
            $matrice_risultati = $dati->numero_terminali($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;

        case "numero_ter_LTE":

            $unita_misura = "k";
            $ordinata = "# devices";

            $matrice_risultati = $dati->numero_terminali_LTE($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;

        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            $matrice_risultati = $dati->usage_voce($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;

        case "PDP":

            $unita_misura = "";
            $ordinata = "PDP (numero)";
            echo $parametro_di_ricerca;


            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                        $pdp_sum_fullroamers_tot = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "chiamate_non_risposte":

            $unita_misura = "";
            $ordinata = "Chiamate non risposte (numero)";
            $pdp_sum_fullroamers_tot = 0;

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                            $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                        else
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            $matrice_risultati = $dati->voce_totale($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";
            $matrice_risultati = $dati->usage_dati($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);

            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            $matrice_risultati = $dati->usage_voce($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);
            break;


        case "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
            $unita_misura = "T";
            $ordinata = "data traffic";
            $matrice_risultati = $dati->dati_totale($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo, $limit, $lista_condizioni, $parametro_di_ricerca, $minimo, $marca, $tipo_grafico, $piano, false, $citta, false, $tariffa);

            break;

        default:
            break;
    }
    ?>
    <div class="charts">
        <div class="col-md-12 stats-info  widget-shadow">
    <?php
    echo "
        <script src=\"https://code.highcharts.com/highcharts.js\"></script>
<script src=\"https://code.highcharts.com/modules/exporting.js\"></script>";
    echo "<script type=\"text/javascript\">";

    echo "var chart;
$(document).ready(function() {
    chart = new Highcharts.Chart({
        chart: {
        marginTop: 50,
        marginLeft: 80,

            renderTo: 'container',
            defaultSeriesType: 'line',
            type: 'line',
            zoomType: 'xy'

        },
        credits: {
            enabled: false
        },
		colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
        title: {
            text: ''
        },
        xAxis: [{
            labels: {
                style: {
                    fontSize: '14px',
                    fontWeight: 'bold'
                }
            },categories: [";
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "'$value'";
            if ($key < count($lista_nomi_visualizzati) - 1)
                echo ",";
        }
    } else
    // print_r (_nome_mese($lista_nomi));
        echo "<th>$lista_nomi_visualizzati</th>";



    echo "]}],
      yAxis: {
			marginTop: 10,
         title: {
		    align: 'high',
            offset: -60,
            rotation: 0,
            y: -20,
            text: '$ordinata'
         },$minimo
         labels: {
            formatter: function() {
               return this.value + '$unita_misura';
            },style: {
			fontSize: '14px',
			fontWeight:'bold'
            }
         },
         plotLines: [{
            value: 0,
            width: 1,
            color: '#808080'
         }]
      },
      tooltip: {
         formatter: function() {
                   return '<b>'+ this.series.name +'</b><br/>'+
               this.x +': '+ this.y + '$unita_misura';
         }
      },
      legend: {
		style: {
			fontSize: '16px',
			fontWeight:'bold'
         },
		y:20,
        layout: 'vertical',
        align: 'right',
        verticalAlign: 'top',
        borderWidth: 0,
		floating:false
      },
      series: [";

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        echo "{type: 'spline',name: '";

        echo $matrice_risultati[$riga][0] . "',
          data: [";

        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    echo round($matrice_risultati[$riga][$colonna] * 100, 2) . "";
                    break;
                case "numero_ter":
                    echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
                    break;
                case "numero_ter_LTE":
                    echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
                    break;
                case "roaming":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "voce":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
                    echo round($matrice_risultati[$riga][$colonna], 0) . "";
                    break;

                case "voce_totale":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "chiamate_non_risposte":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "PDP":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                default:
                    break;
            }

            if ($colonna < count($lista_nomi))
                echo ",";
        }
        echo "]
      }";
        if ($riga < count($matrice_risultati) - 1)
            echo",";
    }
    echo" ]});});</script>";
    ?>

            <div id="container" style="width: 900px; height: 500px; margin: 0 auto"></div>
        </div>
        <div class="clearfix"> </div>
    </div>
    <?php
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    $riga = count($matrice_risultati);

    echo "<div class=\"tables\">";
    $dati->stampa_matrice($matrice_risultati, $lista_nomi_visualizzati);
    $dati->stampa_incremento($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "</div>";
    echo "</div>";
}    
    function multi_axes_multi($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false, $titolo = "", $sottotitolo = "") {
    connect_db();
    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    $riga = 0;
    $matrice_risultati = array();
    if ($piano == NULL)
        $piano = "S";
    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_S )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;  
        case "numero_ter":

            $unita_misura = "k";
            $ordinata = "# devices";

            //print_r($lista_condizioni);

            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;
                    //echo $tipo_terminale . "<br>";

                    $sum = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "numero_ter_LTE":

            $unita_misura = "k";
            $ordinata = "# devices";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "")) {
                    $ricerca = " tipo is Null ";
                } else
                    $ricerca = " $parametro_di_ricerca='" . $value1 . "' ";
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numeroLTE_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numeroLTE_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numeroLTE_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( numeroLTE_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $verifica_citta = true;
                            echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_sum_fullroamers = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers )+sum(Voce_in_on_net_" . $piano . "_FullRoamers )+sum(Voce_out_roaming_" . $piano . "_FullRoamers )+sum(Voce_in_roaming_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $voce_sum_fullroamers_tot = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers )+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $voce_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_voce = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);


                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($sum - $sum_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round(($sum_voce - $voce_sum_fullroamers) / ($sum - $sum_fullroamers), 0);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($voce_tutti_terminali - $voce_sum_fullroamers_tot) - ($sum_voce - $voce_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)), 0);
                        }
                    }

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "PDP":

            $unita_misura = "";
            $ordinata = "PDP (numero)";
            echo $parametro_di_ricerca;


            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                        $pdp_sum_fullroamers_tot = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "chiamate_non_risposte":

            $unita_misura = "";
            $ordinata = "Chiamate non risposte (numero)";
            $pdp_sum_fullroamers_tot = 0;

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                            $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                        else
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            $unita_di_misura = 1000000;
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $ordinata = "voice totale ( Milion minutes)";
                            $verifica_citta = true;
                            $unita_di_misura = 1000000;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    //if ($numero_terminali_prov > 100) {
                    $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;

                    if ($fullroamers == TRUE) {
                        $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($tot - $tot_FR) / $unita_di_misura, 2);
                    }
                    //} else
                    //  $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";


            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $vol_tutti_terminali = 0;
                    $tot_tutti_terminali = 0;
                    $sum_fullroamers = 0;
                    $num_fullroamers = 0;
                    $sum_fullroamers_tot = 0;
                    $num_fullroamers_tot = 0;
                    $num_ter = 0;

                    if ($ITA) {
                        $vol_tutti_terminali = _valori($value, "sum(volume_Dati_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( volume_Dati_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        $num_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( volume_Dati_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                            $num_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers_tot = 0;
                        $num_fullroamers_tot = 0;
                    }

                    $sum = _valori($value, "sum( volume_Dati_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                    $num_ter = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($num_ter - $num_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round((($sum - $sum_fullroamers) / ($num_ter - $num_fullroamers)) / 1000, 2);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round(((($vol_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) /
                                    (($tot_tutti_terminali - $num_fullroamers_tot) - ($num_ter - $num_fullroamers))) / 1000, 2);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;
        case "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
            if ($tipo_grafico == "dati_totale")
                $seme = "volume_Dati";
            else if ($tipo_grafico == "dati_totale_LTE")
                $seme = "volume_Dati_LTE";
            else if ($tipo_grafico == "dati_totale_3g_di_device_LTE_mag_0")
                $seme = "traffico3G_terminaliLTE";



            $unita_misura = "T";
            $ordinata = "data traffic";
            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(" . $seme . "_" . $piano_totale . ")", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( " . $seme . "_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( " . $seme . "_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( " . $seme . "_" . $piano . " )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($sum - $sum_fullroamers) / 1024 / 1024 / 1024, 0);
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) / 1024 / 1024 / 1024, 0);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;

        default:
            break;
    }

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] * 100, 2);
                    break;
                case "numero_ter":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "numero_ter_LTE":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "roaming":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "voce":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 0);
                    break;

                case "voce_totale":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "chiamate_non_risposte":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "PDP":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                default:
                    break;
            }
        }
    }

    include_once 'graph_class.php';
    $grafico = new graph_class();  
    $grafico->print_graph($matrice_risultati, $lista_nomi, $ordinata, $minimo, $unita_misura, $titolo, $sottotitolo);
    
    include_once 'matrice_dati_class.php';
    $matrice = new matrice_dati_class();
    
    if (isset($matrice_risultati)) {
        $lista_nomi_visualizzati = _nome_mese($lista_nomi);
        $matrice->stampa_matrice($matrice_risultati, $lista_nomi_visualizzati, false, $titolo, $sottotitolo, true, $unita_misura);
            $matrice_incremento = $matrice->matrice_incremento($matrice_risultati, $lista_nomi_visualizzati);
        $matrice->stampa_matrice($matrice_incremento, $lista_nomi_visualizzati, false, " Incremento percentuale rispetto al mese di " . $lista_nomi_visualizzati[0],"", true, "");
            $matrice_carg = $matrice->matrice_carg($matrice_risultati, $lista_nomi_visualizzati);
        $matrice->stampa_matrice($matrice_carg, $lista_nomi_visualizzati, false, " Carg rispetto al mese di " . $lista_nomi_visualizzati[0]);
    }
    
    /*
      echo "<script type=\"text/javascript\" src=\"./js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
      <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
      echo "<script type=\"text/javascript\">";

      echo "var chart;
      $(document).ready(function() {
      chart = new Highcharts.Chart({
      chart: {
      marginTop: 50,
      marginLeft: 80,

      renderTo: 'container',
      defaultSeriesType: 'line',
      type: 'line',
      zoomType: 'xy'

      },
      credits: {
      enabled: false
      },
      colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
      title: {
      text: ''
      },
      xAxis: [{
      labels: {
      style: {
      fontSize: '14px',
      fontWeight: 'bold'
      }
      },categories: [";
      $lista_nomi_visualizzati = _nome_mese($lista_nomi);
      if (count($lista_nomi_visualizzati) > 1) {
      foreach ($lista_nomi_visualizzati as $key => $value) {
      echo "'$value'";
      if ($key < count($lista_nomi_visualizzati) - 1)
      echo ",";
      }
      } else
      // print_r (_nome_mese($lista_nomi));
      echo "<th>$lista_nomi_visualizzati</th>";



      echo "]}],
      yAxis: {
      marginTop: 10,
      title: {
      align: 'high',
      offset: -60,
      rotation: 0,
      y: -20,
      text: '$ordinata'
      },$minimo
      labels: {
      formatter: function() {
      return this.value + '$unita_misura';
      },style: {
      fontSize: '14px',
      fontWeight:'bold'
      }
      },
      plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
      }]
      },
      tooltip: {
      formatter: function() {
      return '<b>'+ this.series.name +'</b><br/>'+
      this.x +': '+ this.y + '$unita_misura';
      }
      },
      legend: {
      style: {
      fontSize: '16px',
      fontWeight:'bold'
      },
      y:20,
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'top',
      borderWidth: 0,
      floating:false
      },
      series: [";

      for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
      echo "{type: 'spline',name: '";

      echo $matrice_risultati[$riga][0] . "',
      data: [";

      for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
      switch ($tipo_grafico) {
      case "drop":
      echo round($matrice_risultati[$riga][$colonna] * 100, 2) . "";
      break;
      case "numero_ter":
      echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
      break;
      case "numero_ter_LTE":
      echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
      break;
      case "roaming":
      echo round($matrice_risultati[$riga][$colonna], 2) . "";
      break;
      case "voce":
      echo round($matrice_risultati[$riga][$colonna], 2) . "";
      break;
      case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
      echo round($matrice_risultati[$riga][$colonna], 0) . "";
      break;

      case "voce_totale":
      echo round($matrice_risultati[$riga][$colonna], 2) . "";
      break;
      case "chiamate_non_risposte":
      echo round($matrice_risultati[$riga][$colonna], 2) . "";
      break;
      case "PDP":
      echo round($matrice_risultati[$riga][$colonna], 2) . "";
      break;
      default:
      break;
      }

      if ($colonna < count($lista_nomi))
      echo ",";
      }
      echo "]
      }";
      if ($riga < count($matrice_risultati) - 1)
      echo",";
      }
      echo" ]});});</script>";

      echo "<div id=\"container\" style=\"width: 900px; height: 500px; margin: 0 auto\"></div>";
      echo "<br><br>";
     */
    #$lista_nomi_visualizzati = _nome_mese($lista_nomi);
    #$riga = count($matrice_risultati);
    
    #return ($matrice_risultati);
    /*
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><br>" . stampa_matrice($matrice_risultati, $lista_nomi_visualizzati) . "</p>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Tabella incremento</h2><br>";
    stampa_incremento($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Stampa tabella carg</h2><br>";
    stampa_carg_2($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Tabella incremento TIPO 2</h2><br>";
    //stampa_incremento_tipo2($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
     * 
     */
}
    
    
    

    function matrice_numnero_terminali($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
      
        
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $matrice_risultati = array();
        if ($piano == NULL)
            $piano = "S";


        $unita_misura = "k";
        $ordinata = "# devices";

        //print_r($lista_condizioni);

        foreach ($lista_condizioni as $key1 => $value1) {
            $ricerca = "";
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;

            if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                $ricerca = " tipo is Null or ";
            } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                $ricerca = " classe_throughput is Null or ";
            } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                $ricerca = " Tecnologia is Null or ";
            }
            $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        $verifica_citta = true;
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";

                if ($imeisv) {
                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_imeisv";
                        $verifica_citta = true;
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";
                $sum_fullroamers_tot = 0;


                if ($ITA) {
                    $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                } else
                    $sum_fullroamers = 0;
                //echo $tipo_terminale . "<br>";
                //
//////////////////////////////////////////////////////////////////
 //////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        $sum = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                }      
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'Count_IMEI';
                    $mese = $this->windtable_net($value);
                    $sum = _valori($mese, "sum( $tac_counter )", $ricerca . $filtro_citta, $tipo_terminale);
                    
                }
////////////////////////////////////////////////////////////////////
                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                } else {
                    $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                    }
                }
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }
        for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
            for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {

                $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
            }
        }
        return $matrice_risultati;
    }

    function matrice_numnero_terminali_LTE($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        $unita_misura = "k";
        $ordinata = "# devices";
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $matrice_risultati = array();
        if ($piano == NULL)
            $piano = "S";
        foreach ($lista_condizioni as $key1 => $value1) {
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;

            if (($parametro_di_ricerca == 'Tipo') && ($value1 == "")) {
                $ricerca = " tipo is Null ";
            } else
                $ricerca = " $parametro_di_ricerca='" . $value1 . "' ";
            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        $verifica_citta = true;
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";

                $sum_fullroamers_tot = 0;


                if ($ITA) {
                    $tot_tutti_terminali = _valori($value, "sum(numeroLTE_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( numeroLTE_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( numeroLTE_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                } else
                    $sum_fullroamers = 0;
                
                

                
                #$sum = _valori($value, "sum( numeroLTE_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                //////////////////////////////////////////////////////////////////
 //////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        $sum = _valori($value, "sum( numeroLTE_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                }      
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'Count_IMEI';
                    $mese = $this->windtable_net($value);
                    $sum = _valori($mese, "sum( $tac_counter )", $ricerca . $filtro_citta, $tipo_terminale);
                    
                }
////////////////////////////////////////////////////////////////////
                
                
                
                
                
                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                } else {
                    $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                    }
                }
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }
        return $matrice_risultati;
    }

    function matrice_voce_totale($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $unita_di_misura = 1000000;
        $matrice_risultati = array();
        foreach ($lista_condizioni as $key1 => $value1) {
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = $value1;
            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        $ordinata = "voice totale ( Milion minutes)";
                        $verifica_citta = true;
                        $unita_di_misura = 1000000;
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";
                

                //if ($numero_terminali_prov > 100) {

                
//////////////////////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);    
                    $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;
                }      
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'Count_IMEI';
                    $mese = $this->windtable_net($value);
                    if ($_POST['dato'] == "voce_totale")
                                $data_count = "(sum(`MLN_min_ChiamateGSM`)+sum(`MLN_min_ChiamateUMTS`))/60";
                    else if ($_POST['dato'] == "voce_tre_g")
                                $data_count = "(sum(`MLN_min_ChiamateUMTS`))/60";
                    else if ($_POST['dato'] == "voce_due_g")
                                $data_count = "(sum(`MLN_min_ChiamateGSM`))/60";   
                    else if ($_POST['dato'] == "voce_chiamate")
                                $data_count = " sum(`NumeroChiamate`) "; 
                    
                    $numero_terminali_prov = _valori($mese, "sum( $tac_counter )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot = _valori($mese, $data_count, " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;
                    
                }
////////////////////////////////////////////////////////////////////
                

                if ($fullroamers == TRUE) {
                    $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                }

                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                } else {
                    $matrice_risultati[$riga][$colonna] = round(($tot - $tot_FR) / $unita_di_misura, 2);
                }
                //} else
                //  $matrice_risultati[$riga][$colonna] = 0;
                $colonna++;
            }
            $riga++;
            //echo "<br>";
        }
        return $matrice_risultati;
    }
    function matrice_voce_totale2($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $unita_di_misura = 1000000;
        $matrice_risultati = array();
        foreach ($lista_condizioni as $key1 => $value1) {
            $colonna = 0;
            #$matrice_risultati[$riga][$colonna] = $value1;
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;


            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;
            
            
            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        $ordinata = "voice totale ( Milion minutes)";
                        $verifica_citta = true;
                        $unita_di_misura = 1000000;
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";
                

                //if ($numero_terminali_prov > 100) {

                
//////////////////////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        
                    #$numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);    
                    $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;

                }      
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'Count_IMEI';
                    $mese = $this->windtable_net($value);
                    if ($_POST['dato'] == "voce_totale")
                                $data_count = "(sum(`MLN_min_ChiamateGSM`)+sum(`MLN_min_ChiamateUMTS`))/60";
                    else if ($_POST['dato'] == "voce_tre_g")
                                $data_count = "(sum(`MLN_min_ChiamateUMTS`))/60";
                    else if ($_POST['dato'] == "voce_due_g")
                                $data_count = "(sum(`MLN_min_ChiamateGSM`))/60";   
                    else if ($_POST['dato'] == "voce_chiamate")
                                $data_count = " sum(`NumeroChiamate`) "; 
                    
                    #$numero_terminali_prov = _valori($mese, "sum( $tac_counter )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot = _valori($mese, $data_count, " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;
                    
                }
////////////////////////////////////////////////////////////////////
                $tot_S = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                if ($fullroamers==TRUE and $ITA==False) {
                    $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $matrice_risultati[$riga][$colonna] = round(($tot - $tot_FR) / $unita_di_misura, 2);
                }
                else if ($ITA==True and $fullroamers==False) {
                        $tot_NO3ita = $tot_S - $tot;
                        $matrice_risultati[$riga][$colonna] = round(($tot) / $unita_di_misura, 2);
                        $matrice_risultati[$riga++][$colonna] = round(($tot_NO3ita) / $unita_di_misura, 2);
                }
                else if ($ITA==True and $fullroamers==True) {
                        $tot_3ita_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        
                        $tot_NO3ita_FR = $tot_S - $tot_3ita_FR;
                        $matrice_risultati[$riga][$colonna] = round(($tot_3ita_FR) / $unita_di_misura, 2);
                        $matrice_risultati[$riga++][$colonna] = round(($tot_NO3ita_FR) / $unita_di_misura, 2);
                }
                

                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                } 
                
                //} else
                //  $matrice_risultati[$riga][$colonna] = 0;
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 1;
            } else
                $riga++;
            //echo "<br>";
        }

        return $matrice_risultati;
    } 
    function matrice_dati_usage($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;

        foreach ($lista_condizioni as $key1 => $value1) {
            $ricerca = "";
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;

            if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                $ricerca = " tipo is Null or ";
            } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                $ricerca = " classe_throughput is Null or ";
            } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                $ricerca = " Tecnologia is Null or ";
            }
            $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        $verifica_citta = true;
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";

                $sum_fullroamers_tot = 0;
                $vol_tutti_terminali = 0;
                $tot_tutti_terminali = 0;
                $sum_fullroamers = 0;
                $num_fullroamers = 0;
                $sum_fullroamers_tot = 0;
                $num_fullroamers_tot = 0;
                $num_ter = 0;

                if ($ITA) {
                    $vol_tutti_terminali = _valori($value, "sum(volume_Dati_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( volume_Dati_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                    $num_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( volume_Dati_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        $num_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                } else {
                    $sum_fullroamers_tot = 0;
                    $num_fullroamers_tot = 0;
                }

                //////////////////////////////////////////////////////////////////
 //////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        $sum = _valori($value, "sum( volume_Dati_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                        $num_ter = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                }      
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'CONTEGGIO_SERVIZI';
                    #$mese = $this->windtable_net($value);
                    #$sum = _valori($mese, "sum( $tac_counter )", $ricerca . $filtro_citta, $tipo_terminale);
                    
                    $sum = _valori($value, "(sum(`KBYTES_MOBILE_2G`)+sum(`KBYTES_MOBILE_3G`)+sum(`KBYTES_MOBILE_4G`))*1024", $ricerca . $filtro_citta, $tipo_terminale);
                    $num_ter = _valori($value, "sum( $tac_counter )", $ricerca . $filtro_citta, $tipo_terminale);
                    
                }
////////////////////////////////////////////////////////////////////
                


                
                
                
                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                } else {
                    if (($num_ter - $num_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round((($sum - $sum_fullroamers) / ($num_ter - $num_fullroamers)) / 1024, 2);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = round(((($vol_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) /
                                (($tot_tutti_terminali - $num_fullroamers_tot) - ($num_ter - $num_fullroamers))) / 1024, 2);
                    }
                }
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }

        return $matrice_risultati;
    }

    function matrice_dati_totale($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {

        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $seme = "volume_Dati";

        foreach ($lista_condizioni as $key1 => $value1) {
            $ricerca = "";
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;

            if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                $ricerca = " tipo is Null or ";
            } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                $ricerca = " classe_throughput is Null or ";
            } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                $ricerca = " Tecnologia is Null or ";
            }
            $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        $verifica_citta = true;
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";

                $sum_fullroamers_tot = 0;


                if ($ITA) {
                    $tot_tutti_terminali = _valori($value, "sum(" . $seme . "_" . $piano_totale . ")", $ricerca . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( " . $seme . "_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( " . $seme . "_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                } else
                    $sum_fullroamers = 0;

                #$sum = _valori($value, "sum( " . $seme . "_" . $piano . " )", $ricerca . $filtro_citta, $tipo_terminale);
                
                //////////////////////////////////////////////////////////////////
 //////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {                        
                        if ($_POST['dato'] == "dati_totale")
                            $seme = "volume_Dati";
                        else if ($_POST['dato'] == "dati_totale_LTE")
                            $seme = "volume_Dati_LTE";
                        else if ($_POST['dato'] == "dati_totale_3g_di_device_LTE_mag_0")
                            $seme = "traffico3G_terminaliLTE";
                        
                        $sum = _valori($value, "sum( " . $seme . "_" . $piano . " )", $ricerca . $filtro_citta, $tipo_terminale);
                }      
                if ($_SESSION['operator'] == 'wind')  {
                        #$tac_counter = 'Count_IMEI';
                        #$mese = $this->windtable_net($value);
                           if ($_POST['dato'] == "dati_totale")
                                $data_count = "(sum(`KBYTES_MOBILE_2G`)+sum(`KBYTES_MOBILE_3G`)+sum(`KBYTES_MOBILE_4G`))*1024"; 
                           else if ($_POST['dato'] == "dati_quattro_g")
                                $data_count = "(sum(`KBYTES_MOBILE_4G`))*1024"; 
                           else if ($_POST['dato'] == "dati_tre_g")
                                $data_count = "(sum(`KBYTES_MOBILE_3G`))*1024"; 
                           else if ($_POST['dato'] == "dati_due_g")
                                $data_count = "(sum(`KBYTES_MOBILE_2G`))*1024";                                          
                        
                        $sum = _valori($value, $data_count, $ricerca . $filtro_citta, $tipo_terminale);
                    
                }
////////////////////////////////////////////////////////////////////
                
                
                
                
                
                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                } else {
                    $matrice_risultati[$riga][$colonna] = round(($sum - $sum_fullroamers) / 1024 / 1024 / 1024, 0);
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = round((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) / 1024 / 1024 / 1024, 0);
                    }
                }
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }
        return $matrice_risultati;
    }
    
    function matrice_dati_voce($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }

        $riga = 0;

        foreach ($lista_condizioni as $key1 => $value1) {
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;


            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                if ($citta != '0') {

                    if (_check_citta($value)) {
                        $verifica_citta = true;
                        echo "<br>" . $citta . "<br>";
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";
                $sum_fullroamers_tot = 0;
                $voce_sum_fullroamers_tot = 0;
                if ($ITA) {
                    $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $voce_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $voce_sum_fullroamers = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers )+sum(Voce_in_on_net_" . $piano . "_FullRoamers )+sum(Voce_out_roaming_" . $piano . "_FullRoamers )+sum(Voce_in_roaming_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_sum_fullroamers_tot = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers )+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                } else {
                    $sum_fullroamers = 0;
                    $voce_sum_fullroamers = 0;
                }
                
//////////////////////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $sum_voce = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                }
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'Count_IMEI';
                    $mese = $this->windtable_net($value);
                    $data_count = "(sum(`MLN_min_ChiamateGSM`)+sum(`MLN_min_ChiamateUMTS`))/60";
                    if ($_POST['dato'] == "voce_totale")
                                $data_count = "(sum(`MLN_min_ChiamateGSM`)+sum(`MLN_min_ChiamateUMTS`))/60";
                    $sum = _valori($mese, "sum( $tac_counter)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_voce = _valori($mese, $data_count, " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                }
/////////////////////////////////////////////////////////////////////////////                    
                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                } else {
                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_voce - $voce_sum_fullroamers) / ($sum - $sum_fullroamers), 0);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = round((($voce_tutti_terminali - $voce_sum_fullroamers_tot) - ($sum_voce - $voce_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)), 0);
                    }
                }

                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }
        return $matrice_risultati;
    }

    function matrice_dati_PDP($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }

        $riga = 0;
        echo $parametro_di_ricerca;


        foreach ($lista_condizioni as $key1 => $value1) {
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;


            $colonna++;
            foreach ($lista_tabella as $key => $value) {

                if ($citta != '0') {

                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $table_citta = $value;
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                    } else {
                        $filtro_citta = "";
                        $table_citta = "";
                    }
                } else
                    $filtro_citta = "";
                if ($imeisv) {
                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_imeisv";
                        $verifica_citta = true;
                        $parametro_di_ricerca = "modello";
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";

                $sum_fullroamers_tot = 0;
                $voce_sum_fullroamers_tot = 0;
                //if (_check_citta($table_citta)) {
                if ($ITA) {
                    echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                    $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                } else {
                    $sum_fullroamers = 0;
                    $pdp_sum_fullroamers = 0;
                    $pdp_sum_fullroamers_tot = 0;
                }
                $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                if (($sum - $sum_fullroamers) > 0)
                    $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                else
                    $matrice_risultati[$riga][$colonna] = 0;
                if ($ITA) {
                    $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                }
                //} else {
                //    $matrice_risultati[$riga][$colonna] = 0;
                //    if ($ITA) {
                //        $matrice_risultati[$riga + 1][$colonna] = 0;
                //    }
                //}
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }


        return $matrice_risultati;
    }

    function matrice_chiamate_non_risposte($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }

        $riga = 0;
        $pdp_sum_fullroamers_tot = 0;

        foreach ($lista_condizioni as $key1 => $value1) {
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;


            $colonna++;
            foreach ($lista_tabella as $key => $value) {

                if ($citta != '0') {

                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $table_citta = $value;
                        $value = $value . "_citta";
                        $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                    } else {
                        $filtro_citta = "";
                        $table_citta = "";
                    }
                } else
                    $filtro_citta = "";

                $sum_fullroamers_tot = 0;
                $voce_sum_fullroamers_tot = 0;
                //if (_check_citta($table_citta)) {
                if ($ITA) {
                    $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                } else {
                    $sum_fullroamers = 0;
                    $pdp_sum_fullroamers = 0;
                }
                $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                if (($sum - $sum_fullroamers) > 0)
                    $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                else
                    $matrice_risultati[$riga][$colonna] = 0;
                if ($ITA) {
                    if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    else
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                }
                //} else {
                //    $matrice_risultati[$riga][$colonna] = 0;
                //    if ($ITA) {
                //        $matrice_risultati[$riga + 1][$colonna] = 0;
                //    }
                //}
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }



        return $matrice_risultati;
    }

    function stampa_matrice($matrice_risultati, $lista_nomi_visualizzati, $totale = false, $titolo = "", $sottotitolo = "", $search = false, $unita_misura = "") {
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "Tabella $titolo"; ?><small><?php echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table <?php if ($search) echo "id=\"datatable-buttons\""; ?> class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                <th></th>
        <?php
        $totali = array();
        if (count($lista_nomi_visualizzati) > 1) {
            foreach ($lista_nomi_visualizzati as $key => $value) {
                echo "<th>$value</th>";
            }
        } else
        // print_r (_nome_mese($lista_nomi));
            echo "<th>$lista_nomi_visualizzati</th>";
        ?>
                            </tr>
                        </thead>
                        <tbody>
                           
                            <?php
                            foreach ($matrice_risultati as $v1) {
                                $noprimacol = 0;
                                //print_r($v1);
                                echo "<tr>";
                                foreach ($v1 as $key => $v2) {
                                    echo "<td>" . str_replace(".", ",", $v2) . "</td>";
                                    if ($noprimacol > 0) {
                                        if (isset($totali[$key]))
                                            $totali[$key]+=$v2;
                                        else
                                            $totali[$key] = $v2;
                                    } else
                                        $totali[$key] = strtoupper("totale");
                                    $noprimacol++;
                                }
                                echo "</tr>";
                            }
                            ?>
                        </tbody>
                        <?php
                    if($totale){    
                        echo "<tfoot>";
                        foreach ($totali as $v2) {
                            echo "<td><b>" . str_replace(".", ",", $v2) . "</b></td>";
                        }
                        echo "</tfoot>";
                    }
                    ?>
                    </table>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <?php                   # print_r($matrice_risultati);
    }
    
    function stampa_tabella_requisitiOLD($lista_requisiti, $titolo = "", $sottotitolo = "") {
        include_once './classes/socmanager_class.php';
        $soc = new socmanager();
        //////////////////////////////
        #$id_project_RFInew = 'id_project>=242 OR id IN (100,94,95,190,188,189,1,184,198,179,92,93,186,185,187)';
        #
        $rfi_new = array(100,94,95,190,188,189,1,184,198,179,92,93,186,185,187);
        
        #/////////////////////////////
        #print_r($lista_requisiti);
        reset($lista_requisiti);
        $lista_IN_query = '';
        while (list($key, $value) = each($lista_requisiti)) {
            
            
            if($key > 0){
               $lista_IN_query = $lista_IN_query." ,'$value'"; 
            }
            else
                $lista_IN_query = $lista_IN_query." '$value'";
                
        }
        
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "Tabella $titolo"; ?><small><?php echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>

       
          
                                              <th>Project</th>
                                               <th>RFI type</th>
                                                <th>Input Date</th>
                                                <th>Type</th>
                                                <th>Vendor</th>
                                                <th>Device</th>                                               
                                             
                                                <th>Requirement</th>
                                                <th>Value</th>
                                                <th>Note</th>
                                              
                                                

                            </tr>
                        </thead>
                        <tbody>
                                <?php
                          
 
    $query_req = "SELECT dati_requisiti.id,dati_valori_requisiti.devicetype,dati_valori_requisiti.vendor,dati_valori_requisiti.nome_tel,dati_requisiti.nome_requisito,dati_requisiti.descrizione_requisito,dati_requisiti.label,dati_valori_requisiti.valore_requisito, dati_valori_requisiti.note,dati_valori_requisiti.market,dati_valori_requisiti.data_accettazione FROM `dati_valori_requisiti` LEFT join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito where dati_requisiti.id IN ($lista_IN_query)  ORDER BY id, dati_valori_requisiti.data_accettazione DESC";   
    #echo $query_req;
    $result = mysql_query($query_req);
    $count = 0;
     
    
    while ($row = mysql_fetch_array($result)) {
       
        $count++;

        $vendor_name = ucwords(mb_strtolower($row['vendor']));
               
        $rest = substr($row['nome_tel'], -1);
        $nome_device = base64_encode($row['nome_tel']);
        $tipo_device = ucwords(mb_strtolower($row['devicetype']));
        
        #$link_nome_device = "<a title=\"View LSOC\" class=\"btn btn-success btn-xs\" href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $nome_device . "\">Open</a>";
        #$button_download = "<a title=\"Download\" class=\"btn btn-success btn-xs\" href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $nome_device . "\">Download</a>";
        
        $nome_tel_decode = base64_decode($nome_device);
        
        
        if (($count % 2) == 0) 
            echo'<tr class="even pointer">';
        else 
            echo'<tr class="odd pointer">';

        echo"<td>".$row['data_accettazione']."</td>
            <td>" . $tipo_device . " </td>"
                . "<td>" . $vendor_name . "</td>"
                . "<td>" . $row['nome_tel'] . " </td>"
       
                . "<td>".$row['label']."</td>"
                . "<td>".$row['valore_requisito']."</td>"
                . "<td>".$row['note']."</td>"
          
                ;
        #echo"<td class=\" last\"><div class=\"btn-group\">$link_nome_device</div><div class=\"btn-group\">$button_download</div></td>";

        echo "</tr>";

    }
                                
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <?php
    }
    
    function stampa_tabella_requisiti($lista_requisiti, $titolo = "", $sottotitolo = "") {
        include_once './classes/socmanager_class.php';
        $soc = new socmanager();
        //////////////////////////////
        #$id_project_RFInew = 'id_project>=242 OR id IN (100,94,95,190,188,189,1,184,198,179,92,93,186,185,187)';
        #
        $rfi_new = array(100,94,95,190,188,189,1,184,198,179,92,93,186,185,187);
        
        #/////////////////////////////
        #print_r($lista_requisiti);
        reset($lista_requisiti);
        $lista_IN_query = '';
        while (list($key, $value) = each($lista_requisiti)) {

            if($key > 0){
               $lista_IN_query = $lista_IN_query." ,'$value'"; 
            }
            else
                $lista_IN_query = $lista_IN_query." '$value'";
                
        }                      
 
    $query_req = "SELECT dati_requisiti.id,dati_valori_requisiti.id_project,dati_valori_requisiti.devicetype,dati_valori_requisiti.vendor,dati_valori_requisiti.nome_tel,dati_requisiti.nome_requisito,dati_requisiti.descrizione_requisito,dati_requisiti.label,dati_valori_requisiti.valore_requisito, dati_valori_requisiti.note,dati_valori_requisiti.market,dati_valori_requisiti.data_inserimento FROM `dati_valori_requisiti` LEFT join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito where dati_requisiti.id IN ($lista_IN_query)  ORDER BY id_project, dati_requisiti.id ASC";   
    echo $query_req;
    $result = mysql_query($query_req);
    $count = 0;
    $matrice = array(); 
    
    while ($row = mysql_fetch_assoc($result)) {
       
        $count++;
        
        $project = $soc->get_projects($row['id_project']);
        
        if($row['id_project'] >= 242 or  in_array($row['id_project'], $rfi_new)){
            
          $rfi_type = "New RFI"; 
          $bckgcol = 'class="info"';
          
        }
        else {
            
            $rfi_type = "Old RFI"; 
            $bckgcol = 'class="danger"';
        }

       $tipo_device = ucwords(mb_strtolower($row['devicetype']));
       /* 
       echo "<tr $bckgcol>";
        echo"<td>".$row['id']."</td>";
        echo"<td>".$project['vendor']." - ".$project['model']."</td><td>".$rfi_type."</td>"
            . "<td>".$row['data_inserimento']."</td>
            <td>" . $tipo_device . " </td>"
                . "<td>" . $project['vendor'] . " </td>" 
                . "<td>" . $project['model']. " </td>"     
                . "<td>".$row['label']."</td>"
                . "<td>".$row['valore_requisito']."</td>"
                . "<td>".$row['note']."</td>"
          
                ;
        #echo"<td class=\" last\"><div class=\"btn-group\">$link_nome_device</div><div class=\"btn-group\">$button_download</div></td>";

        echo "</tr>";
        * 
        */
        
        $matrice[$count] = $row;
        
        
        
       

    }
                                
                                ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "Tabella $titolo"; ?><small><?php echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                             <?php #echo "<li><a target=\"_blank\" href=export_confronto.php?telefoni=" . serialize($lista_requisiti) . "&filtro=" . $tipofiltro . "><img  src=\"excel-icon.png\" alt=\"Export confronto\" /></a></li>"; ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                               <!--<th>Project Name</th>
                                               <th>RFI type</th>
                                                <th class='text-left col-md-1'>Input Date</th>
                                                <th>Type</th>-->
                                                <th>Vendor</th>
                                                <th>Device</th>
                          <?php    
                          reset($lista_requisiti);
           while (list($key, $value) = each($lista_requisiti)) {            
            echo "<th>Requirement ID " . $value . "</th>";
            echo "<th class=\'text-left col-md-3\'>Note ID " . $value . "</th>";
        }
        
        
        ?>
    }                                                       
                                                

                            </tr>
                        </thead>
                        <tbody>
        <?php
        while (list($id_key, $id_value) = each($matrice)) {   
            echo"<tr>";
            while (list($id_project, $project_value) = each($id_value)) { 
                echo"<td>".$project_value['vendor']."</td>";
                echo"<td>".$project_value['nome_tel']."</td>";
                
            }
            
        }
        
        
        ?>
        
        
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
       


        <?php
        
       print_r($matrice);
        
    }
    
    function stampa_tabella_requisitiBK($lista_requisiti, $titolo = "", $sottotitolo = "") {
        include_once './classes/socmanager_class.php';
        $soc = new socmanager();
        //////////////////////////////
        #$id_project_RFInew = 'id_project>=242 OR id IN (100,94,95,190,188,189,1,184,198,179,92,93,186,185,187)';
        #
        $rfi_new = array(100,94,95,190,188,189,1,184,198,179,92,93,186,185,187);
        
        #/////////////////////////////
        #print_r($lista_requisiti);
        reset($lista_requisiti);
        $lista_IN_query = '';
        while (list($key, $value) = each($lista_requisiti)) {

            if($key > 0){
               $lista_IN_query = $lista_IN_query." ,'$value'"; 
            }
            else
                $lista_IN_query = $lista_IN_query." '$value'";
                
        }
        
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "Tabella $titolo"; ?><small><?php echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                             <?php #echo "<li><a target=\"_blank\" href=export_confronto.php?telefoni=" . serialize($lista_requisiti) . "&filtro=" . $tipofiltro . "><img  src=\"excel-icon.png\" alt=\"Export confronto\" /></a></li>"; ?>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-buttons" class="table table-striped table-bordered">
                        <thead>
                            <tr>
                                    <th>Requirement name</th>
                                               <th>Project Name</th>
                                               <th>RFI type</th>
                                                <th class='text-left col-md-1'>Input Date</th>
                                                <th>Type</th>
                                                <th>Vendor</th>
                                                <th>Device</th>
                                             
                                                <th>Requirement</th>
                                                <th>Value</th>
                                                <th class='text-left col-md-3'>Note</th>
                                              
                                                

                            </tr>
                        </thead>
                        <tbody>
                                <?php
                          
 
    $query_req = "SELECT dati_requisiti.id,dati_valori_requisiti.id_project,dati_valori_requisiti.devicetype,dati_valori_requisiti.vendor,dati_valori_requisiti.nome_tel,dati_requisiti.nome_requisito,dati_requisiti.descrizione_requisito,dati_requisiti.label,dati_valori_requisiti.valore_requisito, dati_valori_requisiti.note,dati_valori_requisiti.market,dati_valori_requisiti.data_inserimento FROM `dati_valori_requisiti` LEFT join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito where dati_requisiti.id IN ($lista_IN_query) ORDER BY id_project, dati_requisiti.id ASC";   
    #echo $query_req;
    $result = mysql_query($query_req);
    $count = 0;
     
    
    while ($row = mysql_fetch_array($result)) {
       
        $count++;
        
        $project = $soc->get_projects($row['id_project']);
        
        if($row['id_project'] >= 242 or  in_array($row['id_project'], $rfi_new)){
            
          $rfi_type = "New RFI"; 
          $bckgcol = 'class="info"';
          
        }
        else {
            
            $rfi_type = "Old RFI"; 
            $bckgcol = 'class="danger"';
        }

        
        
        
        //$vendor_name = ucwords(mb_strtolower($row['vendor']));
        //$nome_device = ucwords(mb_strtolower($row['nome_tel']));
               
        #$rest = substr($row['nome_tel'], -1);
        #$nome_device = base64_encode($row['nome_tel']);
        $tipo_device = ucwords(mb_strtolower($row['devicetype']));
        
        #$link_nome_device = "<a title=\"View LSOC\" class=\"btn btn-success btn-xs\" href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $nome_device . "\">Open</a>";
        #$button_download = "<a title=\"Download\" class=\"btn btn-success btn-xs\" href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $nome_device . "\">Download</a>";
        
        //$nome_tel_decode = base64_decode($nome_device);
        
        /*
        if (($count % 2) == 0) 
            echo'<tr class="even pointer">';
        else 
            echo'<tr class="odd pointer">';
         * 
         */
        echo "<tr $bckgcol>";
        echo"<td>".$row['id']."</td>";
        echo"<td>".$project['vendor']." - ".$project['model']."</td><td>".$rfi_type."</td>"
            . "<td>".$row['data_inserimento']."</td>
            <td>" . $tipo_device . " </td>"
                . "<td>" . $project['vendor'] . " </td>" 
                . "<td>" . $project['model']. " </td>"     
                . "<td>".$row['label']."</td>"
                . "<td>".$row['valore_requisito']."</td>"
                . "<td>".$row['note']."</td>"
          
                ;
        #echo"<td class=\" last\"><div class=\"btn-group\">$link_nome_device</div><div class=\"btn-group\">$button_download</div></td>";

        echo "</tr>";

    }
                                
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <?php
    }
    

    
    function stampa_parsing_qxdmlog($data, $selezionati="", $titolo = "", $sottotitolo = "") {
        #print_r($lista_requisiti);
        #reset($lista_requisiti);
        
        /*
        $lista_IN_query = '';
        while (list($key, $value) = each($lista_requisiti)) {
            
            
            if($key > 0){
               $lista_IN_query = $lista_IN_query." ,'$value'"; 
            }
            else
                $lista_IN_query = $lista_IN_query." '$value'";
                
        }
         * 
         */
        
        ?>
        <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "Tabella $titolo"; ?><small><?php echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table <?php if (true) echo "id=\"datatable-buttons\""; ?> class="table table-striped table-bordered">
                        <thead>
                            <tr>

       
                                                <th>N.</th>
                                                <th>Field</th>
                                                <th>Value</th>

                                              
                                                

                            </tr>
                        </thead>
                        <tbody>
                                <?php
                          
 /*
    $query_req = "SELECT dati_requisiti.id,dati_valori_requisiti.devicetype,dati_valori_requisiti.vendor,dati_valori_requisiti.nome_tel,dati_requisiti.nome_requisito,dati_requisiti.descrizione_requisito,dati_requisiti.label,dati_valori_requisiti.valore_requisito, dati_valori_requisiti.note,dati_valori_requisiti.market,dati_valori_requisiti.data_accettazione FROM `dati_valori_requisiti` LEFT join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito where dati_requisiti.id IN ($lista_IN_query)  ORDER BY id, dati_valori_requisiti.data_accettazione DESC";   
    #echo $query_req;
    $result = mysql_query($query_req);
  * 
  */
    $count = 0;
    reset($data); 
    foreach ($data as $key => $value) {

        
        //skippo le prime due linee del log
        if($key>1){
            
        $count++;    
            if (($count % 2) == 0){ echo'<tr class="even pointer">';}
            else {echo'<tr class="odd pointer">';}

            echo "<td>".$count."</td>";
            echo "<td>".$value[0]."</td>";
            if(count($value)>1) {echo "<td>".$value[1]."</td>";} else {echo "<td> </td>";}  
        
        }
        echo "</tr>";
        
    /*
        $vendor_name = ucwords(mb_strtolower($row['vendor']));
               
        $rest = substr($row['nome_tel'], -1);
        $nome_device = base64_encode($row['nome_tel']);
        $tipo_device = ucwords(mb_strtolower($row['devicetype']));
        
        #$link_nome_device = "<a title=\"View LSOC\" class=\"btn btn-success btn-xs\" href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $nome_device . "\">Open</a>";
        #$button_download = "<a title=\"Download\" class=\"btn btn-success btn-xs\" href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $nome_device . "\">Download</a>";
        
        $nome_tel_decode = base64_decode($nome_device);
        
        
 

        echo"<td>".$row['data_accettazione']."</td>
            <td>" . $tipo_device . " </td>"
                . "<td>" . $vendor_name . "</td>"
                . "<td>" . $row['nome_tel'] . " </td>"
       
                . "<td>".$row['label']."</td>"
                . "<td>".$row['valore_requisito']."</td>"
                . "<td>".$row['note']."</td>"
          
                ;
        #echo"<td class=\" last\"><div class=\"btn-group\">$link_nome_device</div><div class=\"btn-group\">$button_download</div></td>";
* 
     */
        
     

    }
                                
                                ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>


        <div class="clearfix"></div>
        <?php
    }
    
    
    
    
    function matrice_incremento($matrice_risultati, $lista_nomi_visualizzati) {
        $matrice_result = array();
        foreach ($matrice_risultati as $key_i => $v1) {
            $matrice_result[$key_i][0] = $v1[0];
            $matrice_result[$key_i][1] = "100%";

            $inizio = $v1[1];

            foreach ($v1 as $key => $v2) {
                if ($key > 1) {
                    if (($v2 != 0) || ($inizio != 0))
                        if (($v2 != 0) && ($inizio != 0)) {
                            $risultato_calcolo = ($v2 / $inizio) - 1;
                        } else
                            $risultato_calcolo = 0;
                    else
                        $risultato_calcolo = 0;
                    $matrice_result[$key_i][$key] = str_replace(".", ",", round($risultato_calcolo * 100, 1)) . "%";
                }
            }
        }
        return $matrice_result;
    }

    function matrice_carg($matrice_risultati, $lista_nomi_visualizzati) {
        $matrice_result = array();
        foreach ($matrice_risultati as $key_i => $v1) {
            $matrice_result[$key_i][0] = $v1[0];
            $matrice_result[$key_i][1] = "100%";
            $inizio = $v1[1];
            foreach ($v1 as $key => $v2) {
                if ($key > 1) {
                    if (($v2 != 0) || ($inizio != 0))
                        if (($v2 != 0) && ($inizio != 0)) {
                            $risultato_calcolo = pow(($v2 / $inizio), (1 / ($key - 1))) - 1;
                        } else
                            $risultato_calcolo = 0;
                    else
                        $risultato_calcolo = 0;
                    $matrice_result[$key_i][$key] = str_replace(".", ",", round($risultato_calcolo * 100, 1)) . "%";
                }
            }
        }
        return $matrice_result;
    }

    function matrice_drop($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $matrice_risultati = array();
        if ($piano == NULL)
            $piano = "S";

        foreach ($lista_condizioni as $key1 => $value1) {
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = $value1;
            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $numero_terminali_prov = _valori($value, "sum( numero_S )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                if ($numero_terminali_prov > 400)
                    $matrice_risultati[$riga][$colonna] = round(_valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))*100", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale), 2);
                else
                    $matrice_risultati[$riga][$colonna] = 0;
                $colonna++;
            }
            $riga++;
        }
        $colonna = 0;
        $matrice_risultati[$riga][$colonna] = "National Average";
        for ($k = 0; $k < count($lista_tabella); $k++) {
            $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
            $colonna++;
            $matrice_risultati[$riga][$colonna] = round($temp[1], 2);
            //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
        }

        return $matrice_risultati;
    }
    
    
    function matrice_roaming($lista_tabella, $lista_nomi, $tipo_terminale, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false) {
        if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $matrice_risultati = array();
        if ($piano == NULL)
            $piano = "S";
        
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
        
        }

        
    function matrice_all_grafic($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false, $titolo = "", $sottotitolo = "") {
    connect_db();
            if ($lista_tabella[0] == "") {
            //echo "<br>";
            array_shift($lista_tabella);
        }
        if ($lista_nomi[0] == "") {
            //echo "<br>";
            array_shift($lista_nomi);
        }
        $riga = 0;
        $matrice_risultati = array();
        if ($piano == NULL)
            $piano = "S";


        $unita_misura = "k";
        $ordinata = "# devices";

    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_S )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;  
        case "numero_ter":

            $unita_misura = "k";
            $ordinata = "# devices";
       #print_r($lista_condizioni);

        foreach ($lista_condizioni as $key1 => $value1) {
            $ricerca = "";
            if (substr($piano, 0, 4) == "3ITA") {
                $ITA = TRUE;
            } else
                $ITA = FALSE;
            $colonna = 0;

            if ($ITA) {
                $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                $piano_totale = "S" . substr($piano, 4);
            } else
                $matrice_risultati[$riga][$colonna] = $value1;

            if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                $ricerca = " tipo is Null or ";
            } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                $ricerca = " classe_throughput is Null or ";
            } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                $ricerca = " Tecnologia is Null or ";
            }
            $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

            $colonna++;
            foreach ($lista_tabella as $key => $value) {
                $verifica_citta = false;
                    if ($citta != '0' && !empty($citta)) {
                        if (_check_citta($value)) {
                            #echo "<br>checkcitta " . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                if ($imeisv) {
                    if (_check_citta($value)) {
                        //echo "<br>" . $citta . "<br>";
                        $value = $value . "_imeisv";
                        $verifica_citta = true;
                    } else
                        $filtro_citta = "";
                } else
                    $filtro_citta = "";
                $sum_fullroamers_tot = 0;


                if ($ITA) {
                    $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                }
                if ($fullroamers == TRUE) {
                    $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                    if ($ITA) {
                        $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                } else
                    $sum_fullroamers = 0;
                //echo $tipo_terminale . "<br>";

                $sum = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                if (($citta != '0') && !$verifica_citta) {
                    $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                } else {
                    $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                    }
                }
                $colonna++;
            }
            if ($ITA) {
                $riga = $riga + 2;
            } else
                $riga++;
            //echo "<br>";
        }
        for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
            for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {

                $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
            }
        }
        #return $matrice_risultati;
    
            break;

        case "numero_ter_LTE":

            $unita_misura = "k";
            $ordinata = "# devices";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "")) {
                    $ricerca = " tipo is Null ";
                } else
                    $ricerca = " $parametro_di_ricerca='" . $value1 . "' ";
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numeroLTE_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numeroLTE_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numeroLTE_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( numeroLTE_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0' && !empty($citta)) {
                        if (_check_citta($value)) {
                            #echo "<br>checkcitta " . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    
                    if ($imeisv) {
                        if ($citta != '0' && !empty($citta)) {
                                if (_check_citta($value)) {
                                    //echo "<br>" . $citta . "<br>";
                                    $value = $value . "_imeisv";
                                    $verifica_citta = true;
                                    $parametro_di_ricerca = "modello";
                                } 
                            }        
                            else
                            $filtro_citta = "";
                    } 
                    #else  $filtro_citta = "";
                    
                    #$numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    #echo "sono qui $filtro_citta";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale." ".$filtro_citta);
                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
            break;
            
            
            
            
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $verifica_citta = true;
                            echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_sum_fullroamers = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers )+sum(Voce_in_on_net_" . $piano . "_FullRoamers )+sum(Voce_out_roaming_" . $piano . "_FullRoamers )+sum(Voce_in_roaming_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $voce_sum_fullroamers_tot = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers )+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $voce_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_voce = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);


                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($sum - $sum_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round(($sum_voce - $voce_sum_fullroamers) / ($sum - $sum_fullroamers), 0);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($voce_tutti_terminali - $voce_sum_fullroamers_tot) - ($sum_voce - $voce_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)), 0);
                        }
                    }

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "PDP":

            $unita_misura = "";
            $ordinata = "PDP (numero)";
            echo $parametro_di_ricerca;


            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                        $pdp_sum_fullroamers_tot = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "chiamate_non_risposte":

            $unita_misura = "";
            $ordinata = "Chiamate non risposte (numero)";
            $pdp_sum_fullroamers_tot = 0;

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                            $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                        else
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            $unita_di_misura = 1000000;
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $ordinata = "voice totale ( Milion minutes)";
                            $verifica_citta = true;
                            $unita_di_misura = 1000000;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    //if ($numero_terminali_prov > 100) {
                    $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;

                    if ($fullroamers == TRUE) {
                        $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($tot - $tot_FR) / $unita_di_misura, 2);
                    }
                    //} else
                    //  $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";


            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $vol_tutti_terminali = 0;
                    $tot_tutti_terminali = 0;
                    $sum_fullroamers = 0;
                    $num_fullroamers = 0;
                    $sum_fullroamers_tot = 0;
                    $num_fullroamers_tot = 0;
                    $num_ter = 0;

                    if ($ITA) {
                        $vol_tutti_terminali = _valori($value, "sum(volume_Dati_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( volume_Dati_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        $num_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( volume_Dati_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                            $num_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers_tot = 0;
                        $num_fullroamers_tot = 0;
                    }

                    $sum = _valori($value, "sum( volume_Dati_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                    $num_ter = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($num_ter - $num_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round((($sum - $sum_fullroamers) / ($num_ter - $num_fullroamers)) / 1000, 2);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round(((($vol_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) /
                                    (($tot_tutti_terminali - $num_fullroamers_tot) - ($num_ter - $num_fullroamers))) / 1000, 2);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;
        case "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
            if ($tipo_grafico == "dati_totale")
                $seme = "volume_Dati";
            else if ($tipo_grafico == "dati_totale_LTE")
                $seme = "volume_Dati_LTE";
            else if ($tipo_grafico == "dati_totale_3g_di_device_LTE_mag_0")
                $seme = "traffico3G_terminaliLTE";



            $unita_misura = "T";
            $ordinata = "data traffic";
            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(" . $seme . "_" . $piano_totale . ")", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( " . $seme . "_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( " . $seme . "_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( " . $seme . "_" . $piano . " )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($sum - $sum_fullroamers) / 1024 / 1024 / 1024, 0);
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) / 1024 / 1024 / 1024, 0);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;

        default:
            break;
    }

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] * 100, 2);
                    break;
                case "numero_ter":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "numero_ter_LTE":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "roaming":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "voce":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 0);
                    break;

                case "voce_totale":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "chiamate_non_risposte":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "PDP":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                default:
                    break;
            }
        }
    }
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    return ($matrice_risultati);
    
    
    #$riga = count($matrice_risultati);


}    
}
