<?php
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once './classes/form_class.php';

$funzioni_admin = new funzioni_admin();
$campaign = new campaign_class();
$form = new form_class();

include_once("./classes/access_user/access_user_class.php");
$page_protect = new Access_user;
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $page_protect->log_out(); // the method to log off
}
if (isset($_POST['invio_form'])) {
    $campaign->set_filter_session();
}
include('action.php');
$radici_list = $campaign->radici_list;
$url = "";
$titolo = "Pianificazione";

if (isset($_GET['tipo_pian'])) {
    if ($_GET['tipo_pian'] == 'effettiva') {
        $url = "&tipo_pian=effettiva";
        $titolo = "Pianificazione effettiva";
        $lista_ext1 = $campaign->get_channel_ext1();
        if ($lista_ext1) {
            foreach ($lista_ext1 as $key_lista => $value_lista) {
                ?>
                <script language="JavaScript" type="text/javascript">
                    $(window).load(function () {
                        $('table').on('scroll', function () {
                            $("table > *").width($("table").width() + $("table").scrollLeft());
                        });
                        pianificazione_sms();
                    });
                    function pianificazione_sms() {
                <?php
                $list = $funzioni_admin->get_list_id('channels');
                $radice = 'channel' . "_";
                $campaign->set_filter_session_single($value_lista, "channels", "channel");
                foreach ($list as $key => $value) {
                    //document.getElementById("myCheck").disabled = true;
                    if ($value['id'] != $value_lista) {
                        $_SESSION[$radice . $value['id']] = 0;
                        //echo "alert('prova');";
                        echo "document.getElementById(\"" . $radice . $value['id'] . "\").disabled = true;";
                        //echo "$(\"#" . $radice . $value['id'] . "\").attr(\"disabled\", \"disabled\");\n";
                    } else
                        $_SESSION[$radice . $value['id']] = 1;
                }
                ?>
                    }
                </script>
                <?php
            }
        }
    }
}
?>

<script language="JavaScript" type="text/javascript">

    function seleziona(riga) {
        riga.className = "selezionata";
    }

    function deseleziona(riga) {
        riga.className = "bianco";
    }
    function selectFiltroAll(seme) {

<?php
foreach ($radici_list as $key_table => $value_table) {
    $valore = false;

    echo "if(seme=='$key_table'){\n";
    if (isset($_POST[$key_table . "_filter"])) {
        if ($_POST[$key_table . "_filter"] == true) {
            $valore = false;
            echo $key_table . "_filter=false";
        } else {
            $valore = true;
            echo $key_table . "_filter=true";
        }
    } else {
        echo $key_table . "_filter=false";
    }
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n document.getElementById('$radice" . $value['id'] . "').checked = " . $key_table . "_filter; ";
    }
    echo "\n" . $key_table . "_filter=!" . $key_table . "_filter; ";
    echo "\n var hiddenField = document.createElement(\"input\"); ";

    echo "\n hiddenField.setAttribute(\"type\", \"hidden\");";
    echo "\n hiddenField.setAttribute(\"name\", \"" . $key_table . "_filter\");";
    echo "\n hiddenField.setAttribute(\"value\", \"" . $valore . "\");";
    echo "\n document.formSelezionaMese.appendChild(hiddenField);";
    echo "\n document.formSelezionaMese.submit();"
    . "} \n";
}
?>
    }

    function conferma(stato, permesso_elimina) {
        if (permesso_elimina == 0) {
            alert("Non hai i permessi per eliminare la campagna!");
            return false;
        }
        if (stato == 0) {
            alert("La campagna non è in uno stato eliminabile");
            return false;
        }
        if (!(confirm('Confermi eliminazione?'))) {
            return false;
        } else {
            return true;
        }
    }
    function duplica() {
        if (!(confirm('Confermi di voler duplicare la campagna?')))
        {
            return false;
        }
        else {
            return true;
        }
    }

    function inserisci() {
        permesso_inserisci = 1;
        if (permesso_inserisci != 1)
            alert("Non hai i permessi per inserire una campagna");
        else
            document.location.href = './index.php?page=inserisciCampagna';
    }


    function reset_filtri() {
<?php
foreach ($radici_list as $key_radice_list => $value_radice_list) {

    $list = $funzioni_admin->get_list_id($value_radice_list);
    $radice = $key_radice_list . "_";
    foreach ($list as $key => $value) {
        $nome_variabile = "\"$radice" . $value['id'] . "\"";
        echo "\n document.getElementById($nome_variabile).checked = true;";
    }
}
?>
        document.getElementById("formSelezionaMese").submit();
    }


</script>



<style type="text/css"> 
    div.bottone:hover{
        padding: 0px 2px;
        border-left: 1px solid #fff;
        border-top: 1px solid #fff;
        border-right: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
    }

    div.bottone{
        background: url(images/xls.gif) no-repeat center left; height:16px; float: left; display: block; cursor: pointer; margin-left:5px; padding: 1px; width:40px;
    }

    div.bottoneAdd:hover{
        padding: 0px 2px;
        border-left: 1px solid #fff;
        border-top: 1px solid #fff;
        border-right: 1px solid #ccc;
        border-bottom: 1px solid #ccc;
    }

    div.bottoneAdd{
        background: url(images/Inserisci.png) no-repeat center left; height:16px; float: left; display: block; cursor: pointer; margin-left:5px; padding: 1px; width:40px;
    }
</style>

<?php $form->head_page("Pianificazione", $titolo); ?>
<div class="container" style="width:100%;">
    <div class="content" id="content">
         <div class="finestra" id="finestra" style="width:97%; min-height:400px;  padding:5px; overflow-y:auto; overflow-x:scroll;">
            <div class="wufoo" >

                <?php
                if (isset($result)) {
                    echo "<div class=\"info\">";
                    echo "<h2 style=\"color: #ff0000\">" . $result . "</h2>";
                    echo "</div>";
                }
                ?>
            </div>
            <form name="formSelezionaMese" id="formSelezionaMese" action="./index.php?page=pianificazione<?php echo $url; ?>" method="post">
                <div style="float:left;width:150px; height:50px;">
                    <div style="float:left; width: 120px; height:50px;">
                        <div style="width:30%; margin-top:10px;">
                            <select name="selectMese" id="selectMese" onchange="submit();">
                                <?php
                                #$lista = array("0" => "Gennaio", "1" => "Febbraio", "2" => "Marzo", "3" => "Aprile", "4" => "Maggio", "5" => "Giugno", "6" => "Luglio", "7" => "Agosto", "8" => "Settembre", "9" => "Ottobre", "10" => "Novembre", "11" => "Dicembre", "12" => "Oggi", "13" => "Ieri", "14" => "Settimana corrente", "15" => "Domani");
                                $lista = array("0" => "Gennaio", "1" => "Febbraio", "2" => "Marzo", "3" => "Aprile", "4" => "Maggio", "5" => "Giugno", "6" => "Luglio", "7" => "Agosto", "8" => "Settembre", "9" => "Ottobre", "10" => "Novembre", "11" => "Dicembre", "12" => "Oggi", "13" => "Ieri", "14" => "Settimana corrente", "15" => "Domani", "17" => "Settimana prossima");
                                  foreach ($lista as $key => $value) {
                                    if (isset($_SESSION['selectMese'])) {
                                        if ($_SESSION['selectMese'] == $key) {
                                            $valore_check = " selected=\"selected\" ";
                                        } else
                                            $valore_check = "";
                                    } else
                                        $valore_check = "";

                                    echo "<option value=\"$key\" $valore_check  >$value</option>";
                                }
                                ?>
                            </select>
                        </div>
                    </div>

                    <div style="height:50px; width:200px;">
                        <div style="width:30%; margin-top:10px;float:left;">
                            <select name="selectAnno" id="selectAnno" onchange="submit();">
                                <?php
                                $lista = $campaign->arrayYears();
                                foreach ($lista as $key => $value) {
                                    if (isset($_SESSION['selectAnno'])) {
                                        if ($_SESSION['selectAnno'] == $key) {
                                            $valore_check = " selected=\"selected\" ";
                                        } else
                                            $valore_check = "";
                                    } else
                                        $valore_check = "";
                                    echo "<option value=\"$key\" $valore_check  >$value</option>";
                                }
                                ?>
                            </select>
                        </div>

                    </div>
                    <div style="float:left;height:50px; width:200px;">
                        <div style="width:30%; margin-top:10px;float:left;">
                            <input type="submit" value="Cancella filtro" onclick="reset_filtri();"></div>
                    </div>
                </div>

                <div class="col-md-12 col-sm-12 col-xs-12">                  
                    <!--Stack-->
                    <div style="float:left; width:150px; height:200px;  margin-left:10px;">
                        <label><a href="#" onclick="selectFiltroAll('stack');
                                ;">Stack:</a></label>
                            <?php
                            $list = $funzioni_admin->get_list_id('campaign_stacks');
                            $radice = "stack_";
                            $flex_options = "";
                            foreach ($list as $key => $value) {
                                if (isset($_SESSION[$radice . $value['id']])) {
                                    if ($_SESSION[$radice . $value['id']] == 1) {
                                        $valore_check = "checked=\"checked\"";
                                    } else
                                        $valore_check = "";
                                } else
                                    $valore_check = "";
                                echo "<label for=\"$radice" . $value['id'] . "\">"
                                . "<input value=1  type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"$radice" . $value['id'] . "\"  $valore_check  onclick=\"submit();\"/>"
                                . "<span>" . $value['name'] . " </span></label>";
                            }
                            ?>
                    </div>
                     <!--Squad-->
                    <div style="float:left; width:150px; height:200px; margin-left:10px;">
                        <label><a href="#" onclick="selectFiltroAll('squad');
                                ;">Squad:</a></label>
                            <?php
                            $list = $funzioni_admin->get_list_id('squads');
                            $radice = "squad_";
                            $flex_options = "";
							$count=0;
                            foreach ($list as $key => $value) {
								    $count++;
                                    if ($count >11) {
                                        echo"</div><div style=\"float:left; width:150px; height:200px; margin-left:2px;\"><br>";
                                        $count =0;
                                    }
                                if (isset($_SESSION[$radice . $value['id']])) {
                                    if ($_SESSION[$radice . $value['id']] == 1) {
                                        $valore_check = "checked=\"checked\"";
                                    } else
                                        $valore_check = "";
                                } else
                                    $valore_check = "";
                                echo "<label for=\"$radice" . $value['id'] . "\">"
                                . "<input  value=1 type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"$radice" . $value['id'] . "\"  $valore_check  onclick=\"submit();\"/>"
                                . "<span>" . $value['name'] . " </span></label>";
                            }
                            ?>
                    </div>
                      <!--Canale-->
                    <div style="float:left;width:150px; height:200px;margin-left:10px;">
                        <label><a href="#" onclick="selectFiltroAll('channel');">Canale:</a></label>
                        <div class="checkboxes">
                            <?php
                            $list = $funzioni_admin->get_list_id('channels');
                            $radice = "channel_";
                            $flex_options = "";
                            foreach ($list as $key => $value) {
                                if (isset($_SESSION[$radice . $value['id']])) {
                                    if ($_SESSION[$radice . $value['id']] == 1) {
                                        $valore_check = "checked=\"checked\"";
                                    } else
                                        $valore_check = "";
                                } else
                                    $valore_check = "";

                                echo "<label for=\"$radice" . $value['id'] . "\">"
                                . "<input value=1 type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"$radice" . $value['id'] . "\"  $valore_check  onclick=\"submit();\"/>"
                                . "<span>" . $value['name'] . " </span></label>";
                            }
                            ?>
                        </div>
                    </div>             
                    <!--Stato-->
                    <div style="float:left; width:150px; height:200px; margin-left:10px;">
                        <label><a href="#" onclick="selectFiltroAll('state');
                                ;">Stato:</a></label>
                            <?php
                            $list = $funzioni_admin->get_list_id('campaign_states');
                            $radice = "state_";
                            $flex_options = "";
                            foreach ($list as $key => $value) {
                                if (isset($_SESSION[$radice . $value['id']])) {
                                    if ($_SESSION[$radice . $value['id']] == 1) {
                                        $valore_check = "checked=\"checked\"";
                                    } else
                                        $valore_check = "";
                                } else
                                    $valore_check = "";
                                echo "<label for=\"$radice" . $value['id'] . "\">"
                                . "<input value=1  type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"$radice" . $value['id'] . "\"  $valore_check  onclick=\"submit();\"/>"
                                . "<span>" . $value['name'] . " </span></label>";
                            }
                            ?>

                        <input type="hidden" id="invio_form" name="invio_form" value="1" /> 
                        </form>
                    </div>
                     <!--Tipologia-->
                     <div style="float:left; width:150px; height:200px;  margin-left:10px;">
                        <label><a href="#" onclick="selectFiltroAll('type');
                                ;">Tipologia:</a></label>
                            <?php
                            $list = $funzioni_admin->get_list_id('campaign_types');
                            $radice = "type_";
                            $flex_options = "";
                            foreach ($list as $key => $value) {
                                if (isset($_SESSION[$radice . $value['id']])) {
                                    if ($_SESSION[$radice . $value['id']] == 1) {
                                        $valore_check = "checked=\"checked\"";
                                    } else
                                        $valore_check = "";
                                } else
                                    $valore_check = "";
                                echo "<label for=\"$radice" . $value['id'] . "\">"
                                . "<input  value=1 type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"$radice" . $value['id'] . "\"  $valore_check  onclick=\"submit();\"/>"
                                . "<span>" . $value['name'] . " </span></label>";
                            }
                            ?>
                    </div>

                </div>     

                </div>
        </div>
    </div><!-- end .content -->
</div>                
                                
     <?php 
     
   print_r($_SESSION);  

                                $dataSelezionata = "";
                                if (isset($_SESSION['selectAnno']) && (isset($_SESSION['selectMese']))) {
                                    $mese = $_SESSION['selectMese'];
                                    $anno = $_SESSION['selectAnno'];
                                    if ($mese == 14)
                                        $dataSelezionata = 'Campagne della settimana in corso';
                                    else if ($mese == 15)
                                        $dataSelezionata = 'Campagne pianificate per Domani';
                                    else if ($mese == 13)
                                        $dataSelezionata = 'Campagne pianificate per ieri';
                                    else if ($mese == 12)
                                        $dataSelezionata = 'Campagne pianificate per oggi';
                                    else if ($mese == 16)
                                        $dataSelezionata = 'Campagne pianificate per l\'anno ' . $anno;
                                    else {

                                        $dataSelezionata = 'Campagne ' . date('M Y', mktime(0, 0, 0, $mese + 1, 1, $anno));
                                    }
                                    //$intervallo = $campaign->calcola_intervallo_mese();
                                } else {
                                    //$intervallo = $campaign->calcola_settimana_corrente();
                                    $dataSelezionata = 'Campagne della settimana in corso';
                                }
                               
     

     
     ?>   
                                
                                
                    <table id="table_pianificazione" class="table_pianificazione bordo" style="min-height:350px;overflow-x: scroll; overflow-y: scroll;  display: block;" class="bordo" cellspacing="0" cellpadding="0" border="0">
                        <tr style="height:18px; font-weight: bold; background: url(./images/wbg.gif) repeat-x 0px -1px;">

                            <th colspan="44">
                                
                                <span style="margin-left:10px;"><?php echo $dataSelezionata; ?></span>

                            </th>
                        </tr>

                        <tr style="height:18px; background-image: url(images/bg.gif);">
                            <th colspan="44">

                                  <?php
                                $livello_accesso = $page_protect->get_job_role();
                                if ($livello_accesso > 1) {
                                    ?> 

                            <div class="bottoneAdd" onclick="inserisci();"><span style="float: left; display: block; margin-left:16px; padding: 2px;">Add</span></div>
                            <?php } 
                            if ($livello_accesso > 0) {
                                    ?> 
                            <form name="pianificazioneXLS"  target="_blank" id="pianificazioneXLS" action="export_excel_pianificazione.php" method="post" style="margin: 0px;">
                                <div class="bottone" onclick="document.getElementById('pianificazioneXLS').submit();"><span style="float: left; display: block; margin-left:16px; padding: 2px;">XLS</span></div>
                            </form>
                         <?php } ?>
                        </th>
                        </tr>

                        <tr style="background-image: url(images/bg.gif);">
                            <th align="center"   height="18px" rowspan="2"  style="width: 5%;"><span style="margin-left:5px; margin-right:5px;">Azione</span></th>
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">N</span></th>
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Stack</span></th>                            
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="display:block;margin-left:5px; margin-right:5px;">Squad</span></th>
                            <th align="center"  style="width: 5%;" height="18px" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Nome&nbsp;campagna</span></th>
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Tipologia</span></th>
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="width: 70px;margin-left:5px; margin-right:5px;">Cod_Camp.</span></th>
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="width: 70px;margin-left:5px; margin-right:5px;">Cod_Com.</span></th>
                            
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Canale</span></th>
                            
                            
                            
                            <!--<th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Ottimizz.</span></th>-->
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Data&nbsp;inizio</span></th>
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Data&nbsp;fine</span></th>
                            
                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Stato</span></th>

                            <th align="center"  style="width: 5%;" rowspan="2"><span style="margin-left:5px; margin-right:5px;">Vol.&nbsp;(k)</span></th>

                            <?php
                            $filter = array();
                            $giorno_start = 1;
                            $giorno_end = 31;
                            $intervallo = array();
                            if (isset($_SESSION['selectAnno']) && (isset($_SESSION['selectMese']))) {
                                $intervallo = $campaign->calcola_intervallo_mese();
                            } else {
                                $intervallo = $campaign->calcola_settimana_corrente();
                            }
                            $data_start = $intervallo['anno_start'] . "-" . $intervallo['mese_start'] . "-" . $intervallo['giorno_start'];
                            $data_end = $intervallo['anno_end'] . "-" . $intervallo['mese_end'] . "-" . $intervallo['giorno_end'];
                            //print_r($filter);
                            $filter['data'] = " ("
                                    . "`data_inizio` <= '" . $data_end
                                    . "' AND  (`data_fine` >= '" . $data_start . "' )"
                                    . ")";
                            //controllo dipartimento
                            /* $job_role = $page_protect->get_job_role();
                              if ($job_role == 2) {
                              $squad_id = $page_protect->get_squad();
                              $filter['data'] = $filter['data'] . " and (campaigns.`squad_id` = $squad_id) ";
                              } */

                            $list_day = array();
                            $list_day_2 = array();
                            /* for ($d = 1; $d <= 31; $d++) {
                              $time = mktime(0, 0, 0, $intervallo['mese_end'], $d, $intervallo['anno_end']);
                              if (date('m', $time) == $intervallo['mese_end']) {
                              $list_day[$d] = date('D', $time);
                              $list_day_2[$d] = $time;
                              }
                              } */
                            $giorno = 0;
                            $mese = 0;
                            $anno = 0;
                            $conta_giorni = 0;

                            while (mktime(0, 0, 0, $intervallo['mese_end'], $intervallo['giorno_end'], $intervallo['anno_end']) > mktime(0, 0, 0, $mese, $giorno, $anno)) {
                                $giorno = date('d', mktime(0, 0, 0, $intervallo['mese_start'], $intervallo['giorno_start'] + $conta_giorni, $intervallo['anno_start']));
                                $mese = date('m', mktime(0, 0, 0, $intervallo['mese_start'], $intervallo['giorno_start'] + $conta_giorni, $intervallo['anno_start']));
                                $anno = date('Y', mktime(0, 0, 0, $intervallo['mese_start'], $intervallo['giorno_start'] + $conta_giorni, $intervallo['anno_start']));
                                $time = mktime(0, 0, 0, $mese, $giorno, $anno);
                                $list_day[$conta_giorni + 1] = date('D', $time);
                                $list_day_2[$conta_giorni + 1] = $time;
                                $conta_giorni++;
                            }
                            foreach ($list_day_2 as $key => $value) {
                                echo "<th align=\"center\" ><div style=\"display:block;  width: 40px; overflow: auto;\">" . date('d', $value) . "</div></th>";
                            }
                            $td_vuoti = 31 - count($list_day);
                            ?>
                            <th colspan="<?php echo $td_vuoti; ?>"></th>
                            <th align="center" colspan="2" width="1%" rowspan="2"></th></tr>

                        <tr style="background-image: url(images/bg.gif);">
                            <?php
                            foreach ($list_day as $key => $value) {
                                echo "<th style:\"min-width:40px;\" align=\"center\">" . strtoupper($value) . "</th>";
                            }
                            ?>
                        </tr>
                        <?php
                        $lista_filtri = array();
                        foreach ($radici_list as $key_table => $value_table) {
                            $list = $funzioni_admin->get_list_id($value_table);
                            $radice = $key_table . "_";
                            foreach ($list as $key => $value) {
                                if ($_SESSION[$radice . $value['id']] == 0) {
                                    $lista_filtri[] = " (" . $value_table . ".name not like '" . $value['name'] . "')";
                                }
                            }
                        }
                        $searchSql = " where 1 ";
                        if (count($filter) > 0) {

                            foreach ($filter as $key => $value) {
                                $searchSql = $searchSql . " and " . $value;
                            }
                        }
                        $channel_query = " ";
                        if (count($lista_filtri) > 0) {
                            foreach ($lista_filtri as $key => $value) {
                                $channel_query = $value . " and " . $channel_query;
                            }
                            $searchSql = $searchSql . " and " . "(" . substr($channel_query, 0, -5) . ")";
                        }


                        $list_campaign = $campaign->get_list_campaign($searchSql, ' order by data_inizio asc ');
                        
                        $totale_giorno = array();
                        $totale_giorno[0] = 0;
                        $contatore = 0;
                        $riga = 1;
                        foreach ($list_campaign as $key => $row) {
                            // print_r($row);
                            if ($row['sender_nome'] != NULL)
                                $sender_nome = $row['sender_nome'];
                            else
                            $sender_nome = "";
                            
                            $durata_campagna = $row['durata_campagna'];
                            $escludi_sabato = $row['escludi_sabato'];
                            $time = strtotime($row['data_inizio']);                            
                            $time_trial = strtotime($row['data_trial']);
                            $trial = $row['trial_campagna'];

                            $volume_giornaliero = array($row['volumeGiornaliero1'], $row['volumeGiornaliero2'], $row['volumeGiornaliero3'], $row['volumeGiornaliero4'], $row['volumeGiornaliero5'], $row['volumeGiornaliero6'], $row['volumeGiornaliero7']);
                            $volume_trial = $row['volume_trial'];

                            $giorni_campagna = $campaign->calcola_giorni_campagna($time, $durata_campagna, $escludi_sabato);
                            $volume_per_giorno = $campaign->volume_per_giorno($giorni_campagna, $volume_giornaliero);
                            if ($trial) {
                                $volume_per_giorno[$time_trial] = $volume_trial;
                            }
                            //print_r($giorni_campagna);

                            $numero_sms = 1;
                            if (isset($_GET['tipo_pian'])) {
                                if ($_GET['tipo_pian'] == 'effettiva') {
                                    if (strlen($row['testo_sms']) <= 160)
                                        $numero_sms = 1;
                                    else {
                                        $numero_sms = ceil(strlen($row['testo_sms']) / 153);
                                    }
                                }
                            }

                            $sms_per_giorno = round($row['volume'] / $row['durata_campagna'] / 1000, 0) * $numero_sms;

                            $nome_campagna_totale = substr(stripslashes($row['pref_nome_campagna']), 0);
                            if (strlen($nome_campagna_totale) > 0)
                                $nome_campagna_totale = $nome_campagna_totale . "_" . substr(stripslashes($row['nome_campagna']), 0);
                            else
                                $nome_campagna_totale = substr(stripslashes($row['nome_campagna']), 0);


                            $valore_riga = array("", $row['id'], "", $nome_campagna_totale, $row['gruppo_nome'], $row['tipo_nome'], $row['dipartimento_nome'], $row['optimization'], $row['data_inizio'], $row['campaign_stato_nome'], round($row['volume'] / 1000 * $numero_sms, 0));


                            //echo "<script>console.log(\"$searchSql\");</script>";
                            echo "<tr  id=\"riga" . $contatore . "\" onmouseover=\"seleziona(this);\" class=\"bianco\"  onmouseout=\"deseleziona(this);\" >";
                            $stato_elimina = $row['elimina'];
                            $permission = $page_protect->check_permission($row['squad_id']);
                            echo "
                        <td align=\"center\" style=\"display:block;  height:18px;padding-left:3px;width: 55px;\"   >   
                        <form action=\"./index.php?page=inserisciCampagna\" onsubmit=\"return modifica($permission);\" method=\"post\" style=\"float:left;margin-right:2px;\">
                            <input type=\"image\" alt=\"Modifica\" title=\"Modifica la campagna\" src=\"images/Modifica.png\" value=\"modifica\" name=\"modifica\" />
                            <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />"
                            . "<input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . $row['id'] . "\" />";
                            if ((isset($_POST['selectMese']))) {
                                echo "<input type=\"hidden\" id=\"id\" name=\"selectMese\" value=\"" . $_POST['selectMese'] . "\" />";
                            }
                            if ((isset($_POST['selectAnno']))) {
                                echo "<input type=\"hidden\" id=\"id\" name=\"selectAnno\" value=\"" . $_POST['selectAnno'] . "\" />";
                            }
                            echo "</form>";
                            $stato_elimina = $row['elimina'];
                            //$elimina_campaign_dipartimento = $page_protect->check_elimina_campaign($row['squad_id']);
                            echo "<form name=\"eliminaCampagna\" id=\"eliminaCampagna0\" action=\"./index.php?page=pianificazione" . $url . "\" "
                            . "onsubmit=\"return conferma(" . $stato_elimina . "," . $permission . ")\" method=\"post\"  style=\"float:left;margin-right:2px;\">
                            <input type=\"image\" alt=\"Elimina\" title=\"Elimina la campagna\" name=\"elimina\" src=\"images/Elimina.png\" value=\"elimina\" />
                            <input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . $row['id'] . "\" />";
                            if ((isset($_POST['selectMese']))) {
                                echo "<input type=\"hidden\" id=\"id\" name=\"selectMese\" value=\"" . $_POST['selectMese'] . "\" />";
                            }
                            if ((isset($_POST['selectAnno']))) {
                                echo "<input type=\"hidden\" id=\"id\" name=\"selectAnno\" value=\"" . $_POST['selectAnno'] . "\" />";
                            }
                            echo "</form>";
                            echo ""
                            . "<form action=\"./index.php?page=inserisciCampagna" . $url . "\"  onsubmit=\"return duplica($permission);\" method=\"post\"  style=\"float:left;margin-right:2px;\">
        <input type=\"image\" name=\"duplica\" alt=\"Duplica\" title=\"Duplica la campagna\" src=\"images/duplica.gif\"  style=\"width:14px; height:14px;\"  style=\"width:14px; height:14px;\"  value=\"duplica\" />
        <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" />";
                            if ((isset($_POST['selectMese']))) {
                                echo "<input type=\"hidden\" id=\"id\" name=\"selectMese\" value=\"" . $_POST['selectMese'] . "\" />";
                            }
                            if ((isset($_POST['selectAnno']))) {
                                echo "<input type=\"hidden\" id=\"id\" name=\"selectAnno\" value=\"" . $_POST['selectAnno'] . "\" />";
                            }
                            echo "</form>";
                            echo "</td>";
                            echo "<td align=\"center\" width=\"1%\" ><span style=\"margin-left:3px; margin-right:3px;\">" . $riga . "</span></td>";
                            echo "<td align=\"center\" width=\"1%\" ><span style=\"width: 90px;display:block;margin-left:3px; margin-right:3px;\">" . $row['gruppo_nome'] . "</span></td>";
                            echo "<td align=\"center\" width=\"8%\"><span style=\"width: 150px;display:block;margin-left:4px; margin-right:4px; \">" . $row['dipartimento_nome'] . "</span></td>";
                            echo "<td align=\"left\" width=\"1%\" >
                        <form id=\"formVisualizzaCampagna-$riga\" method=\"post\" action=\"index.php?page=inserisciCampagna\" style=\"margin:0px;\">
                            <a href=\"#\" onclick=\"document.getElementById('formVisualizzaCampagna-$riga').submit()\">
                            <span style=\"width: 450px;display:block;margin-left:3px; margin-right:3px;\" title=\"Clicca qui per visualizzare i dettagli della campagna selezionata\">" . $nome_campagna_totale . "</span>
                                </a>
                            <input type=\"hidden\" name=\"idCampagna\" value=\"" . $row['id'] . "\"/>  
                            <input type=\"hidden\" name=\"pagina\" value=\"pianificazione\" /> 
                        </form>
                    </td>";
                            echo "<td align=\"center\" width=\"1%\" id=\"canale0-0\"><span style=\"width: 90px;display:block;margin-left:3px; margin-right:3px;\">" . $row['tipo_nome'] . "</span></td>";
                            echo "<td align=\"center\" width=\"1%\"><span style=\"width: 60px;display:block;margin-left:3px; margin-right:3px;\">" . $row['cod_campagna'] . "</span></td>"
                            . "<td align=\"center\" width=\"1%\"><span style=\"width: 90px;display:block;margin-left:3px; margin-right:3px;\">" . $row['cod_comunicazione'] . "</span></td>";
                            
                    
                        echo"<td align=\"center\" width=\"1%\" id=\"canale0-0\"><span style=\"width: 90px;display:block;margin-left:3px; margin-right:3px;\">" . $row['channel_nome'] . "</span></td>";
                    
					
                            
                            if ($row['optimization'])
                                $optimization = "YES";
                            else
                                $optimization = "NO";

                            #echo "<td align=\"center\" width=\"1%\"><span style=\"margin-left:3px; margin-right:3px;\">" . $optimization . "</span></td>";
                            $_volume = $row['volume'] * $numero_sms / 1000;
                            if ($_volume < 1)
                                $_volume = number_format(round($_volume, 1), 1, ',', '.');
                            else
                                $_volume = number_format(round($_volume, 0), 0, ',', '.');
                            echo "<td align=\"center\" width=\"1%\"><span style=\"width: 70px;display:block;margin-left:3px; margin-right:3px;\">" . $campaign->data_eng_to_it_($row['data_inizio']) . "</span></td>";
                    echo "<td align=\"center\" width=\"1%\"><span style=\"width: 70px;display:block;margin-left:3px; margin-right:3px;\">" . $campaign->data_eng_to_it_($row['data_fine']) . "</span></td>";
                            echo"<td align=\"center\" width=\"1%\" title=\"" . $row['campaign_stato_nome'] . "\" ><span style=\"width: 70px;display:block;margin-left:3px; margin-right:3px;\">" . $row['campaign_stato_nome'] . "</span></td>
                    <td align=\"center\"  width=\"1%\" title=\"" . $row['volume'] * $numero_sms . "\"><span style=\"margin-left:3px; margin-right:3px;\">" . $_volume . "</span></td>";


                            $totale_giorno[0] = $totale_giorno[0] + round($row['volume'] * $numero_sms / 1000, 0);

                            $numero_giorni = 1;
                            echo '$volume_giornaliero';
                            print_r($volume_giornaliero);
                            echo '$list_day_2';
                            print_r($list_day_2);
                            foreach ($list_day_2 as $key => $value) {
                                if (array_key_exists($value, $volume_per_giorno)) {
                                    $r = $numero_sms * $volume_per_giorno[$value];
                                    if ($r / 1000 < 1) {
                                        $m = number_format($r / 1000, 1, ',', '.');
                                        $m_tot = round($r / 1000, 1);
                                    } else {
                                        $m = number_format(round($r / 1000, 0), 0, ',', '.');
                                        $m_tot = round($r / 1000, 0);
                                    }
                                    $m1 = number_format($r, 0, ',', '.');
                                    echo "<td align=\"center\"  style=\"min-width:40px;\"   title=\"$m1\"  bgcolor=\"" . $row['colore'] . "\" >"
                                    . "<span style=\"margin-left:3px; margin-right:3px;\">" . $m . "</span></td>";
                                    if (isset($totale_giorno[$key]))
                                        $totale_giorno[$key] = $totale_giorno[$key] + $m_tot;
                                    else
                                        $totale_giorno[$key] = $m_tot;
                                }else {

                                    if (date('D', $value) == "Sun") {
                                        echo "<td align=\"center\" style=\"min-width:40px;\" bgcolor=\"gray\" ></td>";
                                        $totale_giorno[$key] = "";
                                    } else {
                                        echo "<td align=\"center\" style=\"min-width:40px;\"  ></td>";
                                        if (isset($totale_giorno[$key]))
                                            $totale_giorno[$key] = $totale_giorno[$key];
                                        else
                                            $totale_giorno[$key] = 0;
                                    }
                                }
                            }
                            $livello_accesso = $page_protect->get_job_role();
                            echo "<td colspan=" . $td_vuoti . "></td>";
                            echo"</tr>";

                            $contatore++;
                            $riga++;
                        }
                        ?>

                        <tr  id="riga<?php echo $riga; ?>" onmouseover="seleziona(this);"  onmouseout="deseleziona(this);" class="bianco" >
                            <td  colspan="10"></td><td align="center" width="1%"><span style="text-align: center;font-weight: bold; margin-right:5px;">TOTALE</span></td>
                                <?php
                                $i = 0;
                                foreach ($totale_giorno as $key => $value) {
                                    if ($i == 0) {
                                        $add_style = 'margin-left:5px; margin-right:5px;';
                                    } else {
                                        $add_style = '';
                                    }
                                    if ($value > 0)
                                        $value = number_format($value, 0, ',', '.');
                                    else
                                        $value = 0;
                                    echo "<td align=\"center\" width=\"1%\"><span style=\"font-weight: bold; $add_style\" >" . $value . "</span></td>";
                                    $i++;
                                }
                                echo "<td colspan=" . $td_vuoti . "></td>";
                                echo "<td colspan=\"2\"></td>";
                                ?>
                        </tr>
                    </table>

<?php $form->close_page(); ?>

<script language="JavaScript" type="text/javascript">
    var h = window.innerHeight;
    var w = window.innerWidth;
    document.getElementById("table_pianificazione").style.height = (h - 500) + "px";
    document.getElementById("table_pianificazione").style.width = (w - 250) + "px";
    document.getElementById("content").style.height = (h - 150) + "px";
    document.getElementById("finestra").style.height = (h - 150) + "px";

</script>



