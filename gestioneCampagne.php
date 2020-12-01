  <!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<?php
include_once './classes/form_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';

$form = new form_class();
$campaign = new campaign_class();

$funzioni_admin = new funzioni_admin();
$page_protect = new Access_user;
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$livello_accesso = $page_protect->get_job_role();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $page_protect->log_out(); // the method to log off
}
include('action.php');

$radici_list = $campaign->radici_list;
print_r($_SESSION);
?>
<script type="text/javascript">
 
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
    seleziona();
    }
    function selectFiltroAll(seme){

<?php
foreach ($radici_list as $key_table => $value_table) {
    echo "if(seme=='$key_table'){\n";
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n document.getElementById('$radice" . $value['id'] . "').checked = " . $key_table . "_filter; ";
    }
    echo "\n" . $key_table . "_filter=!" . $key_table . "_filter;\n";
    echo "\n check_filtro();check_totali();}\n";
}
?>
    }
function check_totali() {
        <?php
        $flex_options = "";
        $stringa_result = "";
        $stringa_result = $stringa_result . "var totali= data.totali;$(\"#totali\").html(totali);"
                . "$(\"#totali\").html(totali);\n";
        foreach ($radici_list as $key_table => $value_table) {
            $list = $funzioni_admin->get_list_id($value_table);
            $radice = $key_table . "_";
            foreach ($list as $key => $value) {
                echo "\n var $radice" . $value['id'] . ";";
                echo "\n if(document.getElementById(\"$radice" . $value['id'] . "\").checked) $radice" . $value['id'] . "=\"1\"; else $radice" . $value['id'] . "=\"0\";";
                $flex_options = "\n \"&$radice" . $value['id'] . "=\" + $radice" . $value['id'] . " + " . $flex_options;
                $stringa_result = $stringa_result . "$(\"#num_" . $radice . $value['id'] . "\").html(data.num_" . $radice . $value['id'] . ");"
                        . "$(\"#tot_" . $radice . $value['id'] . "\").html(data.tot_" . $radice . $value['id'] . ");\n";
            }
        }

$flex_options = substr($flex_options, 0, -2);
        ?>


    $.ajax({
    type: "POST",
            url: "queryTotale.php",
            data: "selectAnno=" + document.getElementById("selectAnno").value + "&selectMese=" + document.getElementById("selectMese").value + "&data=" + data + <?php echo $flex_options; ?>,
            dataType: "json",
            success: function (data)
            {<?php echo $stringa_result; ?>
            },
            error: function (){}
    }); 
    
    }
    
    





    function flex() {
            anno = document.getElementById("selectAnno").value;
                    mese = document.getElementById("selectMese").value;
                    mese = parseInt(mese) + 1;
                    if (mese < 10)
                    mese = '0' + mese;
                    if (mese == 13)
                    mese = "";
                    data = anno + '-' + mese;
                    if (mese == 15)
                    dataSelezionata = 'Campagne della settimana in corso';
                    else
                    dataSelezionata = 'Campagne ' + meseLett(mese) + ' ' + anno;
                    check_totali();
<?php
$flex_options = "";
foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n var $radice" . $value['id'] . ";";
        echo "\n if(document.getElementById(\"$radice" . $value['id'] . "\").checked) $radice" . $value['id'] . "=\"1\"; else $radice" . $value['id'] . "=\"0\";";
        $flex_options = "\n{name: '$radice" . $value['id'] . "', value: $radice" . $value['id'] . "}," . $flex_options;
    }
}
//print_r($_SESSION);
?>
            $("#flex1").flexigrid({
            url: 'post2.php',
                    dataType: 'json',
                    colModel: [
                    {display: 'Azione', name: '', width: 50, sortable: false, align: 'center', hide: false},
                    {display: 'N', name: 'N', width: 35, sortable: false, align: 'center', hide: false},                    
                    {display: 'Stack', name: 'gruppo_campagna', width: 130, sortable: true, align: 'left'},
                    {display: 'Squad', name: 'dipartimento', width: 80, sortable: true, align: 'left', hide: false},
                    {display: 'Nome campagna', name: 'nome_campagna', width: 200, sortable: true, align: 'left', process: visualizzaCampagna},
                    {display: 'Tipo Camapagna', name: 'tipo_campagna', width: 80, sortable: true, align: 'left'},                    
                    {display: 'Cod_Campagna', name: 'cod_campagna', width: 80, sortable: true, align: 'left', hide: false},
                    {display: 'Cod_Comunicazione', name: 'cod_comunicazione', width: 80, sortable: true, align: 'left', hide: false},
                    //{display: 'Ottimiz.', name: 'ottimizzazione', width: 40, sortable: true, align: 'center'},
                    {display: 'Username', name: 'username', width: 70, sortable: true, align: 'left', hide: true},
                    {display: 'Sender', name: 'nome_sender', width: 70, sortable: false, align: 'left'},
                    {display: 'Canale', name: 'canale', width: 70, sortable: true, align: 'left', hide: false},
                    {display: 'Mod. invio', name: 'modalita_invio', width: 60, sortable: true, align: 'left', hide: false},
                    {display: 'Data inizio', name: 'data_inizio', width: 60, sortable: true, align: 'center'},
                    {display: 'Data fine', name: 'data_fine', width: 60, sortable: true, align: 'center'},
                    {display: 'Durata', name: 'durata_campagna', width: 35, sortable: true, align: 'center'},
                    {display: 'Trial', name: 'trial', width: 35, sortable: true, align: 'center', hide: true},
                    {display: 'Data trial', name: 'data_trial', width: 60, sortable: true, align: 'center', hide: true},
                    {display: 'Storic.', name: 'storicizzazione_legale', width: 40, sortable: true, align: 'center', hide: true},
                    {display: 'Stato', name: 'nome_stato', width: 90, sortable: true, align: 'center'},
                    {display: 'Data inserimento', name: 'data_inserimento', width: 100, sortable: true, align: 'center', hide: false},
                    {display: 'Vol. (k)', name: 'volume_totale', width: 45, sortable: true, align: 'center'}],
                    buttons: [
<?php
if ($livello_accesso > 1) {
    echo "{name: 'Add', bclass: 'add', onpress: test},{name: 'XLS', bclass: 'xls', onpress: esportaXLS},";
}
#elseif ($livello_accesso = 4) {
#    echo "{name: 'XLS', bclass: 'xls', onpress: esportaXLS},";
#}
?>

                    {name: 'Filtro', bclass: 'filtro', onpress: filtro},
                    {separator: true},
                    {name: 'A', onpress: sortAlpha},
                    {name: 'B', onpress: sortAlpha},
                    {name: 'C', onpress: sortAlpha},
                    {name: 'D', onpress: sortAlpha},
                    {name: 'E', onpress: sortAlpha},
                    {name: 'F', onpress: sortAlpha},
                    {name: 'G', onpress: sortAlpha},
                    {name: 'H', onpress: sortAlpha},
                    {name: 'I', onpress: sortAlpha},
                    {name: 'J', onpress: sortAlpha},
                    {name: 'K', onpress: sortAlpha},
                    {name: 'L', onpress: sortAlpha},
                    {name: 'M', onpress: sortAlpha},
                    {name: 'N', onpress: sortAlpha},
                    {name: 'O', onpress: sortAlpha},
                    {name: 'P', onpress: sortAlpha},
                    {name: 'Q', onpress: sortAlpha},
                    {name: 'R', onpress: sortAlpha},
                    {name: 'S', onpress: sortAlpha},
                    {name: 'T', onpress: sortAlpha},
                    {name: 'U', onpress: sortAlpha},
                    {name: 'V', onpress: sortAlpha},
                    {name: 'W', onpress: sortAlpha},
                    {name: 'X', onpress: sortAlpha},
                    {name: 'Y', onpress: sortAlpha},
                    {name: 'Z', onpress: sortAlpha},
                    {name: 'ALL', onpress: sortAlpha}

                    ],
                    searchitems: [
                    {display: 'Nome campagna', name: 'nome_campagna', isdefault: true},
                    {display: 'Stack', name: 'gruppo_nome'},
                    {display: 'Tipo', name: 'tipo_nome'},
                    {display: 'Squad', name: 'dipartimento_nome'},
                    {display: 'Username', name: 'username'},
                    {display: 'Sender', name: 'nome_sender'},
                    {display: 'Stato', name: 'nome_stato'}
                    ],
                    sortname: "data_inizio",
                    sortorder: "desc",
                    usepager: true,
                    title: 'Campagne',
                    useRp: true,
                    rp: 40,
                    showTableToggleBtn: true,
                    width: 'auto',
                    height: 300, params: [
<?php echo $flex_options; ?>,
                    {name: 'data', value: data},
                    {name: 'selectAnno', value: document.getElementById("selectAnno").value},
                    {name: 'selectMese', value: document.getElementById("selectMese").value}]
            });
            };
    function post(path, params, method) {
            method = method || "post"; // Set method to post by default if not specified.

                    // The rest of this code assumes you are not using a library.
                    // It can be made less wordy if you use one.
                    var form = document.createElement("form");
                    form.setAttribute("method", method);
                    form.setAttribute("action", path);
                    for (var key in params) {
            if (params.hasOwnProperty(key)) {
            var hiddenField = document.createElement("input");
                    hiddenField.setAttribute("type", "hidden");
                    hiddenField.setAttribute("name", key);
                    hiddenField.setAttribute("value", params[key]);
                    form.appendChild(hiddenField);
            }
            }
            document.body.appendChild(form);
                    form.submit();
            }

    function visualizzaCampagna(celDiv, id) {
    $(celDiv).click(function () {
    //alert(id);
    post('index.php?page=inserisciCampagna', {'idCampagna': id});
    });
    }

    function meseLett(mese) {

    switch (mese) {
    case '01':
            mese = "GENNAIO";
            break;
            case '02':
            mese = "FEBBRAIO";
            break;
            case '03':
            mese = "MARZO";
            break;
            case '04':
            mese = "APRILE";
            break;
            case '05':
            mese = "MAGGIO";
            break;
            case '06':
            mese = "GIUGNO";
            break;
            case '07':
            mese = "LUGLIO";
            break;
            case '08':
            mese = "AGOSTO";
            break;
            case '09':
            mese = "SETTEMBRE";
            break;
            case 10:
            mese = "OTTOBRE";
            break;
            case 11:
            mese = "NOVEMBRE";
            break;
            case 12:
            mese = "DICEMBRE";
            break;
    }

    return mese;
    }



    function check_filtro() {
<?php
$flex_options = "";
foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n var $radice" . $value['id'] . ";";
        echo "\n if(document.getElementById(\"$radice" . $value['id'] . "\").checked) $radice" . $value['id'] . "=\"1\"; else $radice" . $value['id'] . "=\"0\";";
        $flex_options = "\n{name: '$radice" . $value['id'] . "', value: $radice" . $value['id'] . "}," . $flex_options;
    }
}
?>

    jQuery('#flex1').flexOptions({newp: 1, params: [
<?php echo $flex_options; ?>,
    {name: 'data', value: data},
    {name: 'selectAnno', value: document.getElementById("selectAnno").value},
    {name: 'selectMese', value: document.getElementById("selectMese").value}]});
            jQuery("#flex1").flexReload();
    }


    function seleziona() {

    anno = document.getElementById("selectAnno").value;
            mese = document.getElementById("selectMese").value;
            mese = parseInt(mese) + 1;
            if (mese < 10)
            mese = '0' + mese;
            data = anno + '-' + mese;
            if (mese == 15)
            dataSelezionata = 'Campagne della settimana in corso';
            else if (mese == 16)
            dataSelezionata = 'Campagne pianificate per Domani';
            else if (mese == 14)
            dataSelezionata = 'Campagne pianificate per ieri';
            else if (mese == 13)
            dataSelezionata = 'Campagne pianificate per oggi';
            else if (mese == 17)
            dataSelezionata = 'Tutte le campagne del ' + anno;
			else if (mese == 18)
            dataSelezionata = 'Campagne della settimana prossima';
            else
            dataSelezionata = 'Campagne ' + meseLett(mese) + ' ' + anno;
            check_totali();
<?php
$flex_options = "";
foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n var $radice" . $value['id'] . ";";
        echo "\n if(document.getElementById(\"$radice" . $value['id'] . "\").checked) $radice" . $value['id'] . "=\"1\"; else $radice" . $value['id'] . "=\"0\";";
        $flex_options = "\n{name: '$radice" . $value['id'] . "', value: $radice" . $value['id'] . "}," . $flex_options;
    }
}
?>

    $(".ftitle").text(dataSelezionata);
            jQuery('#flex1').flexOptions({newp: 1, params: [
<?php echo $flex_options; ?>,
    {name: 'data', value: data},
    {name: 'selectAnno', value: document.getElementById("selectAnno").value},
    {name: 'selectMese', value: document.getElementById("selectMese").value}]});
            jQuery("#flex1").flexReload();
    }

    function sortAlpha(com){
    anno = document.getElementById("selectAnno").value;
            mese = document.getElementById("selectMese").value;
            mese = parseInt(mese) + 1;
            if (mese < 10)
            mese = '0' + mese;
            if (mese == 13)
            mese = "";
            data = anno + '-' + mese;
<?php
$flex_options = "";
foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n var $radice" . $value['id'] . ";";
        echo "\n if(document.getElementById(\"$radice" . $value['id'] . "\").checked) $radice" . $value['id'] . "=\"1\"; else $radice" . $value['id'] . "=\"0\";";
        $flex_options = "\n{name: '$radice" . $value['id'] . "', value: $radice" . $value['id'] . "}," . $flex_options;
    }
}
?>

    jQuery('#flex1').flexOptions({newp: 1, params: [<?php echo $flex_options; ?>,
    {name: 'letter_pressed', value: com},
    {name: 'qtype', value: $('select[name=qtype]').val()},
    {name: 'data', value: data},
    {name: 'selectAnno', value: document.getElementById("selectAnno").value},
    {name: 'selectMese', value: document.getElementById("selectMese").value}]});
            jQuery("#flex1").flexReload();
    }

    function test(com, grid) {
    if (com == 'Delete')
    {
    if ($('.trSelected', grid).length > 0) {
    if (confirm('Delete ' + $('.trSelected', grid).length + ' items?')) {
    var items = $('.trSelected', grid);
            var itemlist = '';
            for (i = 0; i < items.length; i++) {
    itemlist += items[i].id.substr(3) + ",";
    }
    $.ajax({
    type: "POST",
            dataType: "json",
            url: "delete.php",
            data: "items=" + itemlist,
            success: function (data) {
            alert("Query: " + data.query + " - Total affected rows: " + data.total);
                    $("#flex1").flexReload();
            }
    });
    }
    } else {
    return false;
    }
    }
    else if (com == 'Add')
    {
    //alert('Add New Item Action');
    permesso_inserisci = 1;
            if (permesso_inserisci != 1)
            alert("Non hai i permessi per inserire una campagna");
            else
            document.location.href = './index.php?page=inserisciCampagna';
    }
    }


    function filtro(com) {

    if (com == 'Filtro') {
    if (document.getElementById("filtro").style.display == "none") {
    document.getElementById("filtro").style.display = "block";
    } else {
    document.getElementById("filtro").style.display = "none";
    }
    }
    document.getElementById("filtro").style.display = "block";
    }


    function esportaXLS(com) {

    if (com == 'XLS')
    {

<?php
$flex_options = "";
foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        echo "\n var $radice" . $value['id'] . ";";
        echo "\n if(document.getElementById(\"$radice" . $value['id'] . "\").checked) $radice" . $value['id'] . "=\"1\"; else $radice" . $value['id'] . "=\"0\";";
        $flex_options = "\n '$radice" . $value['id'] . "': $radice" . $value['id'] . "," . $flex_options;
    }
}
?>

    anno = document.getElementById("selectAnno").value;
            mese = document.getElementById("selectMese").value;
            //mese= parseInt(mese) + 1;
            if (mese < 10)
            mese = '0' + mese;
            post('export_excel_gestione.php', {<?php echo $flex_options; ?> 'rp': 40, 'annoSelez': anno, 'meseSelez': mese, 'sortname':'data_inizio', 'sortorder':'desc'}, 'post');
    }
    }
    
        $(document).ready(
        function(){
            
            flex(); 
    
        }
    );
    
    $(window).on('load', function(){
    document.getElementById("filtro").style.display = "block";
            seleziona();
            stack_filter = false;
            channel_filter = false;
            state_filter = false;
            squad_filter = false;
            type_filter = false;
            //check_filtro();
    });</script>

<?php $form->head_page("Gestione Campagne", "Filtro"); ?>
<div class="content" id="content">
    <div id="nascondi" style="float:left; height:300px; width:1px;"><img src="images/comprimi.gif" alt="n" title="Clicca qui per la visualizzazione estesa della pagina" onclick="nascondi();" width="11px"/></div>
    <div id="visualizza" style="display: none; float:left; height:300px; width:1px;"><img src="images/espandi.gif" alt="n" title="Clicca qui per la visualizzazione ridotta della pagina" onclick="visualizza();" width="11px"/></div>
    <div class="finestra" style="width:97%; min-height:400px; padding:5px; overflow-x:scroll;">
        <div class="wufoo" style="margin-bottom:20px;">
            <div class="info">
                <h2>Gestione Campagne</h2>
                <div></div>
            </div>
        </div>
        <?php
        if (isset($result)) {
            echo "<div class=\"info\" style=\"margin-bottom: 20px;\">";
            echo "<h2 style=\"color: #ff0000\">" . $result . "</h2>";
            echo "</div><br />";
        }
        ?>
        <div style="margin-bottom:10px; width:100%; height:95px;">

            <div style="float:left; width: 120px; height:50px;">
                <div style="width:120px; margin-top:10px;">

                    <select name="selectMese" id="selectMese" onchange="seleziona();">
                        <?php                        
                        $lista = array("0" => "Gennaio", "1" => "Febbraio", "2" => "Marzo", "3" => "Aprile", "4" => "Maggio", "5" => "Giugno", "6" => "Luglio", "7" => "Agosto", "8" => "Settembre", "9" => "Ottobre", "10" => "Novembre", "11" => "Dicembre", "12" => "Oggi", "13" => "Ieri", "14" => "Settimana corrente", "15" => "Domani", "17" => "Settimana prossima", "16" => "TUTTO");
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

            <div style="float:left; height:50px; width:50px; ">
                <div style="width:30%; margin-top:10px;float:left;">
                    <select name="selectAnno" id="selectAnno" onchange="seleziona();">
                        <?php                        
                        $lista = $campaign->arrayYears();
                        // print_r($lista);
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
            <div style="float:left; height:50px; width:200px;">
                <div style="width:30%; margin-top:10px;float:left;">
                    <button type="button" onclick="reset_filtri();">Cancella filtro</button>
                </div>
            </div>
            <div id="totali" style="text-align:center; float:right; width:30%; border:1px solid orange; height:95px;">
                <img style="margin-top:15px;" src="images/caricamento.gif" alt="Caricamento dati..."/>
            </div>
        </div>

        <div id="filtro" style=" width:100%; height:220px;  display:none;">
         
    <!-- Stack -->
            <div style="float:left; width:150px; height:120px; margin-left:20px;">
                <label><a href="#" onclick="selectFiltroAll('stack');">Stack:</a></label>
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
                    echo "<span style=\"float:left; display:block; width:200px;\">
 <input type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"" . $radice . $value['id'] . "\" $valore_check onclick=\"check_filtro();check_totali();
 \" />" . $value['name'] . " (<span id=\"num_" . $radice . $value['id'] . "\"></span>/<span id=\"tot_" . $radice . $value['id'] . "\"></span>)</span>";
                }
                ?>
            </div>        
  
<!-- Suqad -->
        
            <div style="float:left; width:150px; height:200px; margin-left:20px; margin-bottom: 20px;">
                <label><a href="#" onclick="selectFiltroAll('squad');">Squad:</a></label>
                <?php
                $list = $funzioni_admin->get_list_id('squads');
                $radice = "squad_";
                $flex_options = "";
				$count=0;
                foreach ($list as $key => $value) {
                    $count++;
                    if ($count >11) {
                        echo"</div><div style=\"float:left; width:150px; height:120px; margin-left:0px;\"><br>";
                        $count =0;
                    }
                    if (isset($_SESSION[$radice . $value['id']])) {
                        if ($_SESSION[$radice . $value['id']] == 1) {
                            $valore_check = "checked=\"checked\"";
                        } else
                            $valore_check = "";
                    } else
                        $valore_check = "";
                    echo "<span style=\"float:left; display:block; width:190px;\">
 <input type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"" . $radice . $value['id'] . "\" $valore_check onclick=\"check_filtro();check_totali();
 \" />" . $value['name'] . " (<span id=\"num_" . $radice . $value['id'] . "\"></span>/<span id=\"tot_" . $radice . $value['id'] . "\"></span>)</span>";
                }
                ?>

            </div>    
            <!-- Canale -->          
            <div style="float:left; width:150px; height:200px; margin-left:20px;">

                <label><a href="#" onclick="selectFiltroAll('channel');">Canale:</a></label>
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
                    echo "<span style=\"float:left; display:block; width:180px;\">
 <input type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"" . $radice . $value['id'] . "\" $valore_check onclick=\"check_filtro();check_totali();
 \" />" . $value['name'] . " (<span id=\"num_" . $radice . $value['id'] . "\"></span>/<span id=\"tot_" . $radice . $value['id'] . "\"></span>)</span>";
                }
                ?>
            </div>
            
            
            <div style="float:left; width:150px; height:120px; margin-left:30px;">
                <label><a href="#" onclick="selectFiltroAll('state');">Stato:</a></label>
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
                    echo "<span style=\"float:left; display:block; width:190px;\">
 <input type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"" . $radice . $value['id'] . "\" $valore_check onclick=\"check_filtro();check_totali();
 \" />" . $value['name'] . " (<span id=\"num_" . $radice . $value['id'] . "\"></span>/<span id=\"tot_" . $radice . $value['id'] . "\"></span>)</span>";
                }
                ?>
            </div>

            <div style="float:left; width:150px; height:120px; margin-left:30px;">
                <label><a href="#" onclick="selectFiltroAll('type');">Tipologia:</a></label>
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
                    echo "<span style=\"float:left; display:block; width:190px;\">
 <input type=\"checkbox\" id=\"$radice" . $value['id'] . "\" name=\"" . $radice . $value['id'] . "\" $valore_check onclick=\"check_filtro();check_totali();
 \" />" . $value['name'] . " (<span id=\"num_" . $radice . $value['id'] . "\"></span>/<span id=\"tot_" . $radice . $value['id'] . "\"></span>)</span>";
                }
                ?>

            </div>


</div>

         
        
        
		<br><br>

<!--                
<div style="float:left;width:150px;">  
      <form class="demo-example">
        <label for="channels">Canale:</label>
        <select id="channels" name="channels" multiple>                   
                <?php
                /*
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
           
          echo'<option id="'. $radice . $value['id'] .'" value="'. $radice . $value['id'] .'" selected  onchange="check_filtro();check_totali();">'.$value['name'].'</option> ';         
               }
                 * 
                 */
                ?>
        </select>
      </form>
</div>
-->
          
</div> 

                <br><br>                
        <table id="flex1" style="display:none;"> 
        </table>



    </div>

</div><!-- end .content -->


