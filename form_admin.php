<?php
include_once './classes/form_class.php';
#include_once 'dati_tacid_class.php';

function form_head($titolo=null, $sottotitolo=null) {
    echo'<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>';
    echo $titolo . '<small>' . $sottotitolo . '</small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>';
}

function form_bottom() {
    echo'</div></div></div></div>';
}

function form_lista_device() {
    $result = mysql_query("SELECT DISTINCT nome_tel FROM dati_valori_requisiti");
#$result = mysql_query("SELECT DISTINCT  `vendor`,`nome_tel` FROM dati_valori_requisiti order by `vendor` ASC");

    while ($row = mysql_fetch_array($result)) {
        echo "<p style=\"font-size:20px\">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<a href=\"index.php?page=grafici&update_lsoc&nome_tel=" . $row['nome_tel'] . "\">" . $row['nome_tel'] . "</a></p>";
    }
}

function form_terminale($funzione) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo "<table class=\"form_table\" border=0><tr><td>";
    $javascript = "onchange='document.getElementById(\"textbox2\").value=document.getElementById(\"textbox1\").value;' ";
    $ultimo_mese = ultimo_mese();

    stampa_select("old_name", "select * from(
  select sum(n_modello2) as numero_datacard, dati_tacid.Modello ,dati_tacid.Marca, Tac1
  from $ultimo_mese  inner join dati_tacid on $ultimo_mese.Tac1=dati_tacid.TacId    group by Modello) as lista_datacard  order by numero_datacard desc LIMIT 0 , 2000", "Modello", FALSE, "", "", "", $javascript);
    echo "</td>";

    echo "<td><input id=\"textbox2\" type=\"text\" name=\"new_name\" size=\"50\" value=\"\"/><br/>";
    echo "</td><td>";
    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "<input type='image' src=\"./image/btn_Invia.png\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr></table></form>";
    echo "</div>";
}

function form_selezione_multi_telefoni($funzione, $disabled_user) {
    #echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo'<div class="form-group">';
    echo "<form  method=\"post\" action=\"" . $_SERVER['REQUEST_URI'] . "\">";
    /* echo "<table class=\"form_table\">
      <tr style=\"clear: both;\"></tr>
      <tr style=\"clear: both; height: 200px;\"><td>";
     * 
     */
    #$ultimo_mese = ultimo_mese();
    if (isset($_POST['telefoni']))
        $selezionati = $_POST['telefoni'];      
    else
        $selezionati = "";
    if ($funzione != "confronto_modelli") {
        $var_select = "telefoni";
        $multi = FALSE;
    } else {
        $var_select = "telefoni[]";
        $multi = TRUE;
    }

// Seleziona il tipo device al primo caricamento della pagina
    
    if (isset($_POST['devicetype']))
        $devicetype = $_POST['devicetype'];
    else
        $devicetype = 'All';

    if ($devicetype == 'All')
        $query1 = "SELECT  DISTINCT `id_project`, projects.vendor, `nome_tel`,projects.model,projects.vendor,projects.devicetype,projects.data_inserimento  FROM `dati_valori_requisiti`  left join projects on projects.id=dati_valori_requisiti.id_project  WHERE 1 order by `vendor` ASC";
    else
        $query1 = "SELECT  DISTINCT `id_project`, projects.vendor, `nome_tel`,projects.model,projects.vendor,projects.devicetype,projects.data_inserimento  FROM `dati_valori_requisiti`  left join projects on projects.id=dati_valori_requisiti.id_project  WHERE 1 order by `vendor` ASC";
        //$query1 = "SSELECT  DISTINCT `vendor`, `model` as nome_tel  FROM `projects` WHERE  `devicetype` like '%$devicetype%' order by `vendor` ASC";

    if ($devicetype == 'Phone')
        $selected_phone = "selected";
    else
        $selected_phone = "";
    if ($devicetype == 'Datacard')
        $selected_datacard = "selected";
    else
        $selected_datacard = "";
    if ($devicetype == 'Router')
        $selected_router = "selected";
    else
        $selected_router = "";
    if ($devicetype == 'All')
        $selected_all = "selected";
    else
        $selected_all = "";
    if ($devicetype == 'Tablet')
        $selected_tablet = "selected";
    else
        $selected_tablet = "";

    $checked_summary = "";
    $checked_extended = "";
#stampa_select($var_select, "SELECT * FROM `dati_valori_requisiti` GROUP BY nome_tel", 'nome_tel', $multi, NULL, "", $selezionati, "");

    echo'<div class="col-md-9 col-sm-4 col-xs-12"><h4>Select Devices</h4>';
    stampa_select_requisiti($var_select, $query1, 'nome_tel', $multi, NULL, "", $selezionati, "");
    #stampa_select_requisiti($nome_variabile, $query, $nome_campo, $multi = false, $id_campo = NULL, $messaggio = "", $selected = NULL, $javascript = "style=\"clear: both; width: 400px; height: 200px;\"") {
    echo'</div>';
    /*
    if (isset($_POST['tipo']) && ($_POST['tipo'] == 'summary'))
        $checked_summary = "checked";
    elseif (isset($_POST['tipo']) && ($_POST['tipo'] == 'extended'))
        $checked_extended = "checked";
    else
        $checked_summary = "checked";
    #echo "</td></div>";
#if (isset($_POST['devicetype'])) echo "siiii";ONCHANGE=\"window.location.href+='&funzione=$funzione&devicetype='+this.options[this.selectedIndex].value;\">
    #echo "</div>";
    echo'<div class="col-md-3 col-sm-4 col-xs-12"><h4>Select Type</h4>';
    echo "<form  method=\"post\" action=\"" . $_SERVER['REQUEST_URI'] . "\">";
    echo"<select name=\"devicetype\"  onchange=\"this.form.submit()\"> 
                <option $selected_all value=\"All\">All</option>
                <option $selected_phone value=\"Phone\">Handset</option>
                <option $selected_tablet value=\"Tablet\">Tablet</option>
                <option $selected_datacard value=\"Datacard\">Datacard</option>
                <option $selected_router value=\"Router\">Router</option>
            </select>
            <input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">
        ";
    echo "</div>";
    echo'<div class="col-md-3 col-sm-4 col-xs-12"><h4>SOC Type</h4>';

    echo "Summary <input checked type=\"radio\" $checked_summary name=\"tipo\" value=\"summary\"/>";
    echo "<br>Extended <input type=\"radio\"  $disabled_user  $checked_extended name=\"tipo\" value=\"extended\"/>";
    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "</div>";
     * 
     */
    echo'<div class="col-md-12 col-sm-12 col-xs-12"><br><br><br><br>
                        
                                        <center><button type="submit" class="btn btn-primary" name="Submit" value="Submit">Submit</button></center>
         </div>';
    echo "</form>";
    echo "</div>";
}

function form_andamento_csi($funzione, $condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo "<table class=\"form_table\" border=0><tr><td>";
    if (isset($_POST['tabella_name']))
        $selezionati = $_POST['tabella_name'];
    else
        $selezionati = "";
    if ($funzione == "andamento_csi_mese") {
        $multi_modello = true;
        $multi_mese = false;
    } else {
        $multi_modello = false;
        $multi_mese = true;
    }
    stampa_select("tabella_name[]", "select * from lista_tabelle where csi=1 order by ordine asc", "nome_tabella", $multi_mese, "", "", $selezionati, "style=\"height:200px\"");

    echo "</td><td>";
    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";

    $ultimo_mese = ultimo_mese_csi();


//echo $ultimo_mese;
    stampa_select($lista_terminali, "select * from(
  SELECT count( csi_" . $ultimo_mese . ".MSISDN) as numero_datacard, dati_tacid.Modello ,dati_tacid.Tecnologia ,dati_tacid.Marca,dati_tacid.OS,dati_tacid.Tipo, Tac
  from csi_" . $ultimo_mese . "  inner join dati_tacid on Tac=dati_tacid.TacId  $condizione_tipo_terminale group by $paramentro_di_gruppo) as lista_datacard  order by numero_datacard desc ", $paramentro_di_gruppo, $multi_modello, "", "", $selezionati2, "style=\"width: 430px;height:200px\"");
    echo "</td><td style=\"width:220px\">";
    if (isset($_POST['filtro_piano'])) {
        $filtro_piano = $_POST['filtro_piano'];
    } else
        $filtro_piano = NULL;
    echo "<p style=\"height: 25px;\">
        <select name=\"filtro_piano\">
    <option value='S'";
    if ($filtro_piano == "S") {
        echo " selected ";
    }
    echo ">TOT</option>
    <option value='S_PRE'";
    if ($filtro_piano == "S_PRE") {
        echo " selected ";
    }
    echo " >TOT PRE (*)</option>
    <option value='S_POST'";
    if ($filtro_piano == "S_POST") {
        echo " selected ";
    }
    echo " >TOT POST (*)</option>
    </select></p>";
    if (isset($_POST['dato'])) {
        $dato = $_POST['dato'];
    } else
        $dato = NULL;
    echo "<p style=\"height: 25px;\"><select name=\"dato\">
    <option value='numero_ter'";
    if ($dato == "numero_ter") {
        echo " selected ";
    }
    echo "># TERMINALI</option>
    <option value='roaming'";
    if ($dato == "roaming") {
        echo " selected ";
    }
    echo " >ROAMING</option>
    <option value='voce'";
    if ($dato == "voce") {
        echo " selected ";
    }
    echo " >VOCE</option>
    </select></p>";

    echo "</td><td>";

    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr><tr><td colspan=4>(*)sono riferiti solo alle statistiche Totali, Roaming e voce</td></tr></table></form>";
    echo "</div>";
}

function form_analisi_terminale($funzione, $condizione_tipo_terminale, $lista = TRUE) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo "<table class=\"form_table\" border=0><tr><td>";
    if ($funzione != "aggiorna_info_modello")
        stampa_select("tabella_name[]", "select * from lista_tabelle order by ordine asc", "nome_tabella", TRUE);
    echo "</td><td>";
    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";
//stampa_select($lista_terminali, "select * from(  select sum(n_modello2) as numero_datacard, dati_tacid.Modello ,dati_tacid.Marca, Tac1  from luglio2011  inner join dati_tacid on Tac1=dati_tacid.TacId inner join tac_h3g on dati_tacid.TacId=id_tac  $condizione_tipo_terminale group by Modello) as lista_datacard   order by numero_datacard desc LIMIT 0 , 2000", "Modello", $lista);
    echo "</td><td>";
    ?>
    <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
    <script type="text/javascript">

        $(document).ready(function () {
            $('#loader').hide();
            $('#model').hide();
            $('#model_label').hide();
            $('#type').change(function () {

                $('#model').fadeOut();
                $('#loader').fadeOut();
                $('#model_label').show();
                $.post("./modello.php", {
                    type: $('#type').val()
                }, function (response) {
                    setTimeout("finishAjax('model', '" + escape(response) + "')", 400);
                });
                return false;
            });

        });

        function finishAjax(id, response) {
            $('#loader').hide();
            $('#' + id).html(unescape(response));
            $('#' + id).fadeIn();
        }
    </script>
    <div id="loader"><strong>Loading...</strong></div>
    <label align='left' for="type">Vendor:</label>
    <select id="type" name="type">
        <?php
        echo '<option value="">-- Select Vendor --</option>';
        connect_db();
        //$q = mysql_query("SELECT * FROM dati_tacid Group by Marca");
        $query = mysql_query("SELECT * FROM lista_tabelle order by ordine desc") or die(mysql_error());
        $row = mysql_fetch_assoc($query);
        $ultima_tabella = $row['nome_tabella'];
        $q = mysql_query("select sum(n_modello2) as numero, dati_tacid.Modello, dati_tacid.Marca, Tac1
    from $ultima_tabella inner join dati_tacid on $ultima_tabella.Tac1=dati_tacid.TacId  group by Marca order by numero desc");
        while ($row = mysql_fetch_assoc($q)) {
            echo '<option value="' . $row['Marca'] . '">' . $row['Marca'] . '</option>';
        }
        ?>
    </select>
    <?php
#echo "SELECT * FROM dati_tacid ORDER BY t_id ASC Group by Marca";
    ?>
    <br><br><label align='left' id="model_label">&nbsp;&nbsp;Model:</label>
    <select id="model" name="model">
        <option value="">-- Select Model --</option>
    </select>
    <?php
//echo "<label for=\"male\">Inserisci il Terminalle da ricercare</label><input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
//echo "<input type=\"text\" name=\"nome_parziale\" >";

    echo "</td></tr><tr> <td colspan=3><input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\"><input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr></table></form>";
    echo "</div>";
}

function form_andamento_imeisv($funzione, $condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo "<table class=\"form_table\" border=0><tr><td>";
    if (isset($_POST['tabella_name']))
        $selezionati = $_POST['tabella_name'];
    else
        $selezionati = "";


    $multi_modello = false;
    $multi_mese = true;
    stampa_select("tabella_name[]", "select * from lista_tabelle where imeisv=1 order by ordine asc", "nome_tabella", $multi_mese, "", "", $selezionati, "style=\"height:200px\"");

    echo "</td><td>";
    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";

    $ultimo_mese = ultimo_mese_imeisv();


//echo $ultimo_mese;

    stampa_select($lista_terminali, "select * from(
  SELECT sum( " . $ultimo_mese . "_imeisv.n_modello2) as numero, dati_tacid.Modello ,dati_tacid.Tecnologia ,dati_tacid.Marca,dati_tacid.OS,dati_tacid.Tipo, Tac1
  from " . $ultimo_mese . "_imeisv  inner join dati_tacid on Tac1=dati_tacid.TacId  $condizione_tipo_terminale group by $paramentro_di_gruppo) as lista  order by numero desc ", $paramentro_di_gruppo, $multi_modello, "", "", $selezionati2, "style=\"width: 430px;height:200px\"");
    echo "</td><td style=\"width:220px\">";
    if (isset($_POST['filtro_piano'])) {
        $filtro_piano = $_POST['filtro_piano'];
    } else
        $filtro_piano = NULL;
    echo "<p style=\"height: 25px;\">
        <select name=\"filtro_piano\">
    <option value='S'";
    if ($filtro_piano == "S") {
        echo " selected ";
    }
    echo ">TOT</option>
    <option value='3ITA'";
    if ($filtro_piano == "3ITA") {
        echo " selected ";
    }
    echo " >3ITA (*)</option>
    </select></p>";
    if (isset($_POST['dato'])) {
        $dato = $_POST['dato'];
    } else
        $dato = NULL;
    echo "<p style=\"height: 25px;\"><select name=\"dato\">
    <option value='numero_ter'";
    if ($dato == "numero_ter") {
        echo " selected ";
    }
    echo "># TERMINALI</option>
    <option value='roaming'";
    if ($dato == "roaming") {
        echo " selected ";
    }
    echo " >ROAMING</option>
    <option value='drop'";
    if ($dato == "drop") {
        echo " selected ";
    }
    echo " >DROP</option>
    <option value='voce_totale'";
    if ($dato == "voce_totale") {
        echo " selected ";
    }
    echo " >VOCE TOTALE</option>
    <option value='voce'";
    if ($dato == "voce") {
        echo " selected ";
    }
    echo " >USAGE VOCE</option>
	<option value='dati_totale'";
    if ($dato == "dati_totale") {
        echo " selected ";
    }
    echo " >DATI TOTALE</option>
	<option value='dati'";
    if ($dato == "dati") {
        echo " selected ";
    }
    echo " >USAGE DATI</option> 
    </select></p>";
    echo "<p><input type=\"checkbox\" name=\"fullroamers\" value=\"TRUE\"";
    if (isset($_POST['fullroamers'])) {
        echo " checked ";
    }
    echo "/>Senza FullRoamers (*)</p>";
    echo "</td><td>";


    echo "</td><td>";

    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr></table></form>";
    echo "</div>";
}

function form_andamento_imeisv_2($condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"" . $_SERVER['REQUEST_URI'] . "\">";
    echo "<table class=\"form_table\" border=0><tr><td>";
    if (isset($_POST['tabella_name']))
        $selezionati = $_POST['tabella_name'];
    else
        $selezionati = "";


    $multi_modello = false;
    $multi_mese = true;
    stampa_select("tabella_name[]", "select * from lista_tabelle where citta=1 order by ordine asc", "nome_tabella", $multi_mese, "", "", $selezionati, "style=\"height:200px\"");

    echo "</td><td>";
    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";

    $ultimo_mese = ultimo_mese();


//echo $ultimo_mese;
    ?>
    <script>
        function showUser(str) {
            if (str == "") {
                document.getElementById("txtHint").innerHTML = "";
                return;
            } else {
                if (window.XMLHttpRequest) {
                    // code for IE7+, Firefox, Chrome, Opera, Safari
                    xmlhttp = new XMLHttpRequest();
                } else {
                    // code for IE6, IE5
                    xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
                }
                xmlhttp.onreadystatechange = function () {
                    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
                        document.getElementById("txtHint").innerHTML = xmlhttp.responseText;
                    }
                }

                xmlhttp.open("POST", "getsoftware_version.php", true);
                xmlhttp.setRequestHeader("Content-type", "application/x-www-form-urlencoded");
                xmlhttp.send("modello=" + str);
            }
        }
    </script>
    <?php
    stampa_select($lista_terminali, "select * from(
  SELECT sum( " . $ultimo_mese . "_imeisv.n_modello2) as numero, dati_tacid.Modello ,dati_tacid.Tecnologia ,dati_tacid.Marca,dati_tacid.OS,dati_tacid.Tipo, Tac1
  from " . $ultimo_mese . "_imeisv  inner join dati_tacid on Tac1=dati_tacid.TacId  $condizione_tipo_terminale group by $paramentro_di_gruppo) as lista  order by numero desc ", $paramentro_di_gruppo, $multi_modello, "", " seleziona device", $selezionati2, "style=\"width: 430px;\" onchange=\"showUser(this.value)\" onload=\"showUser(this.value)\"");
    echo "<br>";
    echo "<div id=\"txtHint\"><b>List SW version will be listed here...</b></div>";
    echo "</td><td style=\"width:220px\">";
    if (isset($_POST['filtro_piano'])) {
        $filtro_piano = $_POST['filtro_piano'];
    } else
        $filtro_piano = NULL;
    echo "<p style=\"height: 25px;\">
        <select name=\"filtro_piano\">
    <option value='S'";
    if ($filtro_piano == "S") {
        echo " selected ";
    }
    echo ">TOT</option>
    <option value='3ITA'";
    if ($filtro_piano == "3ITA") {
        echo " selected ";
    }
    echo " >3ITA (*)</option>
    </select></p>";
    if (isset($_POST['dato'])) {
        $dato = $_POST['dato'];
    } else
        $dato = NULL;
    echo "<p style=\"height: 25px;\"><select name=\"dato\">
    <option value='numero_ter'";
    if ($dato == "numero_ter") {
        echo " selected ";
    }
    echo "># TERMINALI</option>
    <option value='roaming'";
    if ($dato == "roaming") {
        echo " selected ";
    }
    echo " >ROAMING</option>
    <option value='drop'";
    if ($dato == "drop") {
        echo " selected ";
    }
    echo " >DROP</option>
    
    <option value='dati_totale'";
    if ($dato == "dati_totale") {
        echo " selected ";
    }
    echo " >DATI TOTALE</option>
    <option value='voce_totale'";
    if ($dato == "voce_totale") {
        echo " selected ";
    }
    echo " >VOCE TOTALE</option>
	<option value='dati'";
    if ($dato == "dati") {
        echo " selected ";
    }
    echo " >USAGE DATI</option> 
    <option value='voce'";
    if ($dato == "voce") {
        echo " selected ";
    }
    echo " >USAGE VOCE</option>"
    . "<option value='PDP'";
    if ($dato == "PDP") {
        echo " selected ";
    }
    echo " >PDP</option>"
    . "<option value='chiamate_non_risposte'";
    if ($dato == "chiamate_non_risposte") {
        echo " selected ";
    }
    echo " >chiamate non risposte</option>"
    . "
    </select></p>";
    echo "<p><input type=\"checkbox\" name=\"fullroamers\" value=\"TRUE\"";
    if (isset($_POST['fullroamers'])) {
        echo " checked ";
    }
    echo "/>Senza FullRoamers (*)</p>";
    echo "</td><td>";


    echo "</td><td>";

    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr></table></form>";
    echo "</div>";
}

function form_andamento_tel_tabl($lista, $paramentro_di_gruppo) {
    include_once 'dati_tacid_class.php';
    $dati_tacid = new dati_tacid_class();
    include_once 'form_class.php';
    $form = new form_class();
    ?>

    <div class="forms">
        <div class="row">
            <div class="form-three widget-shadow">
                <form class="form-horizontal"  method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">
                    <div class="form-group">
                        <?php
                        $form->get_indicatore();
                        $form->get_filtro_piano();
                        ?>
                    </div>
                    <div class="form-group">
                        <?php
                        $form->get_lista_Mesi();
                        ?>
                        <div class="col-sm-4">
                            <label class="control-label"><b>Nome device</b></label>
                            <br>
                            <?php
                            if ($lista)
                                $lista_terminali = "table_terminali[]";
                            else
                                $lista_terminali = "table_terminali";

                            if (isset($_POST['table_terminali']))
                                $selezionati2 = $_POST['table_terminali'];
                            else
                                $selezionati2 = "";

                            $condizione_tipo_terminale = $form->_condizione_tipo_terminale($paramentro_di_gruppo);
                            $checked_vendor = 'checked';
                            $checked_numero = ' ';
                            $checked_classeT = ' ';


                            if (!isset($_POST['filtro_r'])) {
                                $filtro_r = "vendor_select";
                            } else {
                                $filtro_r = $_POST['filtro_r'];
                            }
                            //print_r($filtro_r);

                            $vendor_select = "All";
                            $having_query = "";

                            if ($filtro_r == "vendor_select") {
                                if (isset($_POST['vendor_select'])) {
                                    $vendor_select = $_POST['vendor_select'];
                                    if ($vendor_select != "All") {
                                        $having_query = "Having dati_tacid.Marca=\"" . $vendor_select . "\"";
                                        $checked_vendor = 'checked';
                                        $checked_numero = ' ';
                                    } else {
                                        $having_query = " ";
                                    }
                                }
                                $lista_device_g = $dati_tacid->get_lista_device_group_by_marca($paramentro_di_gruppo, $having_query, $condizione_tipo_terminale);
                                $form->stampa_select_group($lista_terminali, $lista_device_g, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 150px;width: 300px;\"");
                            } elseif ($filtro_r == "classeT_select") {
                                $checked_classeT = 'checked';
                                $checked_vendor = '';
                                if (isset($_POST['classeT_select'])) {
                                    //echo "pippo";
                                    $classeT_select = $_POST['classeT_select'];
                                    if ($classeT_select != "All") {
                                        $having_query = "Having classe_throughput=\"" . $classeT_select . "\"";

                                        $checked_numero = ' ';
                                    }
                                }
                            } elseif ($filtro_r == "numero_select") {
                                $checked_numero = 'checked';
                                $checked_vendor = ' ';
                                $having_query = " order by numero_device desc ";
                                $lista_device = $dati_tacid->get_lista_device($paramentro_di_gruppo, $having_query, $condizione_tipo_terminale);
                                $form->stampa_select($lista_terminali, $lista_device, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 135px;width: 230px;\"");
                            }


                            ///$lista_device = $dati_tacid->get_lista_device($paramentro_di_gruppo, $having_query, $condizione_tipo_terminale);
                            //print_r($lista_device_g);
                            //$form->stampa_select($lista_terminali, $lista_device, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 135px;width: 230px;\"");
                            ?>
                        </div>
                        <div class="col-sm-6">
                            <?php
                            $form->get_tipo_device();
                            ?>
                            <div class="form-group">
                                <div class="col-sm-4 radio-inline"><label><input type="radio" onclick="this.form.submit()"  name="filtro_r"  <?php echo $checked_vendor; ?> value="vendor_select">Per Vendor</label></div>

                                <?php
                                if ($checked_vendor == "checked") {
                                    ?> 
                                    <div class="col-sm-4">
                                        <?php
                                        $form->get_lista_top_vendor();
                                        ?> 
                                    </div>
                                    <?php
                                }
                                ?>

                                <div class=" col-sm-4  radio-inline"><label><input type="radio" onclick="this.form.submit()"  name="filtro_r"  <?php echo $checked_numero; ?> value="numero_select">Per Numerosit&agrave;</label></div>
                            </div>


                            <?php
                            $form->get_piano_tariffario($condizione_tipo_terminale);
                            ?>
                            <?php
                            $form->get_webfamily();
                            ?>
                        </div>
                    </div>
                    <button type="submit" class="btn btn-default" name="Submit" value="Submit">Submit</button>
                </form>
            </div>
        </div>

    </div>
    <?php
}

function form_andamento_citta_2($funzione, $lista, $paramentro_di_gruppo) {

//print_r($_POST);


    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";

    echo "<table class=\"form_table\" border=0><tr><td>";
    if (isset($_POST['tabella_name']))
        $selezionati = $_POST['tabella_name'];
    else
        $selezionati = "";
    stampa_select("tabella_name[]", "select * from lista_tabelle order by ordine asc", "nome_tabella", TRUE, "", "", $selezionati, "style=\"height:250px\"");
    echo "</td><td>";


    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";
    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";

    $ultimo_mese = ultimo_mese();
//echo $ultimo_mese;

    $checked_vendor = 'checked';
    $checked_numero = ' ';
    $checked_classeT = ' ';

    if (!isset($_POST['filtro_tipo'])) {
        $filtro_tipo = "select_handset";
        $condizione_tipo_terminale = "where (Tecnologia='Handset' or Tecnologia='Tablet' or Tecnologia='Phablet') ";
        $checked_handset = 'checked';
        $checked_MBB = ' ';
    } else {
        $filtro_tipo = $_POST['filtro_tipo'];
        if ($filtro_tipo == "select_MBB") {
            $condizione_tipo_terminale = "where (Tecnologia='MBB' or Tecnologia='Datacard') ";
            $checked_handset = '';
            $checked_MBB = ' checked ';
        } else {
            $condizione_tipo_terminale = "where (Tecnologia='Handset' or Tecnologia='Tablet' or Tecnologia='Phablet') ";
            $checked_handset = 'checked';
            $checked_MBB = ' ';
        }
    }

    if (!isset($_POST['filtro_r'])) {
        $filtro_r = "vendor_select";
    } else {
        $filtro_r = $_POST['filtro_r'];
    }
    print_r($filtro_r);

    $vendor_select = "All";
    $having_query = "";

    if ($filtro_r == "vendor_select") {
        if (isset($_POST['vendor_select'])) {
            $vendor_select = $_POST['vendor_select'];
            if ($vendor_select != "All") {
                $having_query = "Having dati_tacid.Marca=\"" . $vendor_select . "\"";
                $checked_vendor = 'checked';
                $checked_numero = ' ';
            }
        }
        stampa_select_tel_tab($lista_terminali, "select * from(
            select sum(n_modello2) as numero_datacard, dati_tacid.Modello,classe_throughput ,dati_tacid.Tecnologia ,dati_tacid.Marca,dati_tacid.OS,dati_tacid.Tipo, Tac1
            from $ultimo_mese  inner join dati_tacid on Tac1=dati_tacid.TacId  $condizione_tipo_terminale group by dati_tacid.Marca , $paramentro_di_gruppo $having_query) as lista_datacard     ", $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");
    } elseif ($filtro_r == "classeT_select") {
        $checked_classeT = 'checked';
        $checked_vendor = '';
        if (isset($_POST['classeT_select'])) {
//echo "pippo";
            $classeT_select = $_POST['classeT_select'];
            if ($classeT_select != "All") {
                $having_query = "Having classe_throughput=\"" . $classeT_select . "\"";

                $checked_numero = ' ';
            }
        }
        stampa_select_tel_tab($lista_terminali, "select * from(
            select sum(n_modello2) as numero_datacard, dati_tacid.Modello ,classe_throughput ,dati_tacid.Tecnologia ,dati_tacid.Marca,dati_tacid.OS,dati_tacid.Tipo, Tac1
            from $ultimo_mese  inner join dati_tacid on Tac1=dati_tacid.TacId  $condizione_tipo_terminale group by dati_tacid.Marca , $paramentro_di_gruppo $having_query) as lista_datacard   ", $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");
    } elseif ($filtro_r == "numero_select") {
        $checked_numero = 'checked';
        $checked_vendor = ' ';

        stampa_select($lista_terminali, "select * from(
            select sum(n_modello2) as numero_datacard, dati_tacid.Modello ,dati_tacid.Tecnologia ,dati_tacid.Marca,dati_tacid.OS,dati_tacid.Tipo, Tac1
            from $ultimo_mese  inner join dati_tacid on Tac1=dati_tacid.TacId  $condizione_tipo_terminale group by $paramentro_di_gruppo) as lista_datacard   order by numero_datacard desc ", $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");
    }

    echo "</td><td>";
#echo $vendor_select;
#echo $_POST['filtro'];


    echo "<p style=\"height:80px; border:0px solid red;\"><br>
                <input type=\"radio\" name=\"filtro_tipo\" value=\"select_handset\" onclick=\"this.form.submit()\" $checked_handset>Handset e Tablet<br>
                <input type=\"radio\" name=\"filtro_tipo\" value=\"select_MBB\" onclick=\"this.form.submit()\" $checked_MBB>Datacard e MBB";

    echo "<p style=\"height:100px; border:0px solid red;\">
                <input type=\"radio\" name=\"filtro_r\" value=\"vendor_select\" onclick=\"this.form.submit()\" $checked_vendor>Per Vendor&nbsp;&nbsp;                
                    <input type=\"radio\" name=\"filtro_r\" value=\"classeT_select\" onclick=\"this.form.submit()\" $checked_classeT>Per Classe throughtput&nbsp;&nbsp;
                <input type=\"radio\" name=\"filtro_r\" value=\"numero_select\" onclick=\"this.form.submit()\" $checked_numero>Per Numerosit&agrave;";


    if ($checked_vendor == "checked") {
        $query = "SELECT distinct `vendor` FROM `dati_valori_requisiti` order by `vendor` asc";
        $result = mysql_query($query) or die($query . " - " . mysql_error());
        echo "<br><br>Select Vendor <select style=\"width:100px;\" name=\"vendor_select\" onchange=\"this.form.submit()\">";
        if ($vendor_select == "All")
            echo "<option selected value=\"All\">---- All ----</option>";
        else
            echo "<option value=\"All\">---- All ----</option>";
        while ($obj = mysql_fetch_array($result)) {
            if ($vendor_select == $obj['vendor'])
                echo "<option selected value=\"" . $obj['vendor'] . "\" >" . $obj['vendor'] . "</option>";
            else
                echo "<option value=\"" . $obj['vendor'] . "\" >" . $obj['vendor'] . "</option>";
        }
        echo "</select></p>";
    }
    if ($checked_classeT == "checked") {
        $query = "SELECT  `classe_throughput` FROM  `dati_tacid` GROUP BY  `classe_throughput` ";
        $result = mysql_query($query) or die($query . " - " . mysql_error());
        echo "<br><br>Select classe throughtput <select style=\"width:100px;\" name=\"classeT_select\" onchange=\"this.form.submit()\">";
        if ($classeT_select == "All")
            echo "<option selected value=\"All\">---- All ----</option>";
        else
            echo "<option value=\"All\">---- All ----</option>";
        while ($obj = mysql_fetch_array($result)) {
            if ($classeT_select == $obj['classe_throughput'])
                echo "<option selected value=\"" . $obj['classe_throughput'] . "\" >" . $obj['classe_throughput'] . "</option>";
            else
                echo "<option value=\"" . $obj['classe_throughput'] . "\" >" . $obj['classe_throughput'] . "</option>";
        }
        echo "</select></p>";
    }

#else "<p style=\"height:20px;\"></p>";
#echo "</p>";
################################################    
    if (isset($_POST['filtro_piano'])) {
        $filtro_piano = $_POST['filtro_piano'];
    } else
        $filtro_piano = NULL;

    echo "<p style=\"height: 25px; margin-top:10px;\">
        <select name=\"filtro_piano\">
    <option value='S'";
    if ($filtro_piano == "S") {
        echo " selected ";
    }
    echo ">TOT</option>
    <option value='S_PRE'";
    if ($filtro_piano == "S_PRE") {
        echo " selected ";
    }
    echo " >TOT PRE (*)</option>
    <option value='S_POST'";
    if ($filtro_piano == "S_POST") {
        echo " selected ";
    }
    echo " >TOT POST (*)</option>
    <option value='3ITA'";
    if ($filtro_piano == "3ITA") {
        echo " selected ";
    }
    echo " >3ITA e NO-3ita(*)</option> 
    <option value='3ITA_PRE'";
    if ($filtro_piano == "3ITA_PRE") {
        echo " selected ";
    }
    echo " >PRE: 3ITA e NO-3ita(*)</option>
    <option value='3ITA_POST'";
    if ($filtro_piano == "3ITA_POST") {
        echo " selected ";
    }
    echo " >POST: 3ITA e NO-3ita(*)</option>";
    if ($funzione == "andamento_tecnologia") {
        echo "<option value='2G'";
        if ($filtro_piano == "2G") {
            echo " selected ";
        }
        echo " >2G</option>";
    }
    echo "</select></p>";
    if (isset($_POST['dato'])) {
        $dato = $_POST['dato'];
    } else
        $dato = NULL;
    echo "<p style=\"height: 25px;\"><select name=\"dato\">
    <option value='numero_ter'";
    if ($dato == "numero_ter") {
        echo " selected ";
    }
    echo "># TERMINALI</option>
    <option value='roaming'";
    if ($dato == "roaming") {
        echo " selected ";
    }
    echo " >ROAMING</option>
    <option value='drop'";
    if ($dato == "drop") {
        echo " selected ";
    }
    echo " >DROP</option>
    <option value='dati'";
    if ($dato == "dati") {
        echo " selected ";
    }
    echo " >DATI</option> 
    <option value='dati_totale'";
    if ($dato == "dati_totale") {
        echo " selected ";
    }
    echo " >DATI TOTALE</option>
    <option value='voce_totale'";
    if ($dato == "voce_totale") {
        echo " selected ";
    }
    echo " >VOCE TOTALE</option>
    <option value='voce'";
    if ($dato == "voce") {
        echo " selected ";
    }
    echo " >VOCE</option>
    </select></p>";
    echo "<p><input type=\"checkbox\" name=\"fullroamers\" value=\"TRUE\"";
    if (isset($_POST['fullroamers'])) {
        echo " checked ";
    }
    echo "/>Senza FullRoamers (*)</p>";
    echo "</td><td>";

    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\"></td></tr>";
    echo "<tr><td colspan=4><input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";

    echo "</td></tr><tr><td colspan=4>(*)sono riferiti solo alle statistiche Totali, Roaming e voce</td></tr></table></form>";
    echo "</div>";
}

function form_andamento_os($funzione, $condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    $db_link = connect_db_li();
    $dati_tacid_new = new dati_tacid_class();
    $form = new form_class();


    echo'<div class="col-md-2 col-sm-4 col-xs-12"><h4>Select Months</h4>';
    #echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";    
    if ($funzione == 'andamento_classeT') {
        echo "<form  method=\"post\" action=\"index.php?sec=statistiche&pg=device_classeT\">";
    } elseif ('OS') {
        echo "<form  method=\"post\" action=\"index.php?sec=statistiche&pg=device_os\">";
    } elseif ('Tipo') {
        echo "<form  method=\"post\" action=\"index.php?sec=statistiche&pg=device_ff\">";
    }elseif ('Marca') {
        echo "<form  method=\"post\" action=\"index.php?sec=statistiche&pg=device_vendor\">";
    }



    $form->get_lista_Mesi();

    echo'</div>';



    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";
    $ultimo_mese = ultimo_mese();
//echo $ultimo_mese;

    if ($funzione == 'andamento_classeT') {
        $titolo = "Multiple Select";
    }
    echo'<div class="col-md-6 col-sm-4 col-xs-12"><h4>Multiple Select</h4>';
    
    $query_form_select = "
    select * from(select 
  sum(numero_S) as numero, 
  dati_tacid.Modello , 
  dati_tacid.Marca,
  if(dati_tacid.Tecnologia is NULL,'ND',dati_tacid.Tecnologia) as Tecnologia,
  if(dati_tacid.Tipo is NULL,'ND',dati_tacid.Tipo) as Tipo,
  if(dati_tacid.classe_throughput is NULL,'ND',dati_tacid.classe_throughput) as classe_throughput,
  if(dati_tacid.OS is NULL,'ND',dati_tacid.OS) as OS,
  Tac1
  from $ultimo_mese  left join dati_tacid on Tac1=dati_tacid.TacId $condizione_tipo_terminale group by $paramentro_di_gruppo) as temp  group by $paramentro_di_gruppo"
            . "  order by numero desc ";
    
    stampa_select($lista_terminali,$query_form_select, $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");


    echo'</div>';
    $form->checkbox_tipo_device();
    $form->stampa_select_tipouser();

    $form->stampa_select_tipodato();



    #echo "</td></tr><tr><td></td><td></td><td>";


    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\"></div>";
    #echo'<div class="col-md-12 col-sm-12 col-xs-12">';
    echo'<div class="col-md-12 col-sm-12 col-xs-12"><center><br><br><button type="submit" class="btn btn-primary" name="Submit" value="Submit">Submit</button></center></div>';
    #echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "<p>(*)sono riferiti solo alle statistiche Totali, Roaming e voce.</p></form>";
    echo "<p>Sono stati rimossi i Tablet e per il roaming e per le drop i telefoni 2G</p>";
    echo "</div></div>";
}


function form_andamento_device_vendor($funzione, $condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    #form_andamento_device_vendor('andamento_vendor', "where 1 ", TRUE, "Marca");
    $db_link = connect_db_li();
    $dati_tacid_new = new dati_tacid_class();
    $form = new form_class();


    echo'<div class="col-md-2 col-sm-4 col-xs-12"><h4>Select Months</h4>';
    echo "<form  method=\"post\" action=\"index.php?sec=statistiche&pg=device_vendor\">";

    $form->get_lista_Mesi();

    echo'</div>';



    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";
    $ultimo_mese = ultimo_mese();
//echo $ultimo_mese;

    echo'<div class="col-md-6 col-sm-4 col-xs-12"><h4>Multiple Select</h4>';
    $marca = $dati_tacid_new->get_lista_marca();
    $form->stampa_select($lista_terminali, $marca, TRUE, "", $selezionati2, " style=\"width: 430px;height:250px;\"");
    
    /*
    stampa_select($lista_terminali, "
    select * from(select 
  sum(numero_S) as numero, 
  dati_tacid.Modello , 
  dati_tacid.Marca,
  if(dati_tacid.Tecnologia is NULL,'n/a',dati_tacid.Tecnologia) as Tecnologia,
  if(dati_tacid.Tipo is NULL,'n/a',dati_tacid.Tipo) as Tipo,
  if(dati_tacid.classe_throughput is NULL,'n/a',dati_tacid_new.classe_throughput) as classe_throughput,
  if(dati_tacid.OS is NULL,'n/a',dati_tacid.OS) as OS,
  Tac1
  from $ultimo_mese  left join dati_tacid on Tac1=dati_tacid.TacId $condizione_tipo_terminale group by $paramentro_di_gruppo) as temp  group by $paramentro_di_gruppo"
            . "  order by numero desc ", $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");
   * 
     */

    echo'</div>';
  

    #$form->checkbox_tipo_device();
    #$form->stampa_select_tipouser();

    $form->stampa_select_tipodato();



    #echo "</td></tr><tr><td></td><td></td><td>";


    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\"></div>";
    #echo'<div class="col-md-12 col-sm-12 col-xs-12">';
    echo'<div class="col-md-12 col-sm-12 col-xs-12"><center><br><br><button type="submit" class="btn btn-primary" name="Submit" value="Submit">Submit</button></center></div>';
    #echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "<p>(*)sono riferiti solo alle statistiche Totali, Roaming e voce.</p></form>";
    echo "<p>Sono stati rimossi i Tablet e per il roaming e per le drop i telefoni 2G</p>";
    echo "</div></div>";
}



function form_andamento_ff($funzione, $condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    $db_link = connect_db_li();
    $dati_tacid_new = new dati_tacid_class();
    $form = new form_class();


    echo'<div class="col-md-2 col-sm-4 col-xs-12"><h4>Select Months</h4>';

    echo "<form  method=\"post\" action=\"index.php?sec=statistiche&pg=device_ff\">";




    $form->get_lista_Mesi();

    echo'</div>';



    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";
    $ultimo_mese = ultimo_mese();
//echo $ultimo_mese;


    echo'<div class="col-md-6 col-sm-4 col-xs-12"><h4>Multiple Select</h4>';
        $query_form_select = "
    select * from(select 
  sum(numero_S) as numero, 
  dati_tacid.Modello , 
  dati_tacid.Marca,
  if(dati_tacid.Tecnologia is NULL,'ND',dati_tacid.Tecnologia) as Tecnologia,
  if(dati_tacid.Tipo is NULL,'ND',dati_tacid.Tipo) as Tipo,
  if(dati_tacid.classe_throughput is NULL,'ND',dati_tacid.classe_throughput) as classe_throughput,
  if(dati_tacid.OS is NULL,'ND',dati_tacid.OS) as OS,
  Tac1
  from $ultimo_mese  left join dati_tacid on Tac1=dati_tacid.TacId $condizione_tipo_terminale group by $paramentro_di_gruppo) as temp  group by $paramentro_di_gruppo"
            . "  order by numero desc ";
    
    
    #stampa_select($lista_terminali, "SELECT DISTINCT `Tipo` FROM `dati_tacid` WHERE 1 ORDER BY `dati_tacid`.`Tipo` DESC", $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");
    stampa_select($lista_terminali, $query_form_select, $paramentro_di_gruppo, $lista, "", "", $selezionati2, "style=\"width: 430px;height:250px\"");

    echo'</div>';
    #$form->checkbox_tipo_device();
    $form->stampa_select_tipouser();

    $form->stampa_select_tipodato();

    echo'<div class="col-md-12 col-sm-12 col-xs-12"><center><br><br><button type="submit" class="btn btn-primary" name="Submit" value="Submit">Submit</button></center></div>';

    echo "<p>(*)sono riferiti solo alle statistiche Totali, Roaming e voce.</p></form>";
    echo "<p>Sono stati rimossi i Tablet e per il roaming e per le drop i telefoni 2G</p>";
    echo "</div></div>";
}

function form_andamento($funzione, $condizione_tipo_terminale, $lista, $paramentro_di_gruppo) {
    include_once 'dati_tacid_class.php';
    $dati_tacid = new dati_tacid_class();
    include_once 'form_class.php';
    $form = new form_class();
    ?>
    <div class="forms">
        <div class="row">
            <div class="form-three widget-shadow">
                <form class="form-horizontal"  method="post" action="index.php?page=grafici&tipo_grafico=<?php echo $funzione; ?>">
                    <div class="form-group">
    <?php
    $form->get_indicatore();
    $form->get_filtro_piano();
    ?>
                    </div>
                    <div class="form-group">
    <?php
    $form->get_lista_Mesi();
    ?>

                        <div class="col-sm-3">
                            <label class="control-label"><b>Tipologia device</b></label>
    <?php
    if ($lista)
        $lista_terminali = "table_terminali[]";
    else
        $lista_terminali = "table_terminali";

    if (isset($_POST['table_terminali']))
        $selezionati2 = $_POST['table_terminali'];
    else
        $selezionati2 = "";
    if ($paramentro_di_gruppo == "Marca") {
        $marca = $dati_tacid->get_lista_marca();
        $form->stampa_select($lista_terminali, $marca, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 135px;width: 250px;\"");
    } else {
        $tipo = $dati_tacid->get_tipo();
        $form->stampa_select($lista_terminali, $tipo, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 135px;width: 250px;\"");
    }
    ?>
                        </div>
                        <div class="col-sm-6">

                            <div class="col-sm-12">

                            <?php
                            $condizione_tipo_terminale = $form->_condizione_tipo_terminale($paramentro_di_gruppo);
                            if ($paramentro_di_gruppo == "Marca") {

                                $form->get_tipo_device();
                            }
                            $form->get_piano_tariffario($condizione_tipo_terminale);
                            ?>
                            </div>


                        </div>
   
                    </div>
                    <button type="submit" class="btn btn-default" name="Submit" value="Submit">Submit</button>
                </form>
            </div>
        </div>

    </div>
<?php
                        
}

function form_andamento_citta($condizione_tipo_terminale, $lista, $paramentro_di_gruppo, $condizione_lista_mesi = "") {
  include_once 'dati_tacid_class.php';
  $dati_tacid = new dati_tacid_class();
  include_once 'form_class.php';
  $form = new form_class();
  
  ?>
    <form class="form-horizontal"  method="post" action="<?php echo $_SERVER['REQUEST_URI']; ?>">

        <div class="form-group">
            <div class="col-md-2 col-sm-4 col-xs-12"><h4>Select Months</h4>
    <?php
    $form->get_lista_Mesi();
    $form->stampa_select_tidato();
    ?>
            </div>



                <?php
                if ($lista)
                    $lista_terminali = "table_terminali[]";
                else
                    $lista_terminali = "table_terminali";

                if (isset($_POST['table_terminali']))
                    $selezionati2 = $_POST['table_terminali'];
                else
                    $selezionati2 = "";
                if ($paramentro_di_gruppo == "COMUNE_PREVALENTE") {
                    $lista_citta = $dati_tacid->get_lista_citta();
                    $form->stampa_select($lista_terminali, $lista_citta, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 135px;width: 250px;\"");
                } else {
                    $tipo = $dati_tacid->get_lista_citta();
                    $form->stampa_select($lista_terminali, $tipo, TRUE, "", $selezionati2, " class=\"form-control1\" style=\"height: 135px;width: 250px;\"");
                }
                ?>
        </div>

        <                            <div class="col-md-12 col-sm-12 col-xs-12">

            <center><button type="submit" class="btn btn-primary" name="Submit" value="Submit">Submit</button></center>
        </div> 

    </div>
    </form>

    <?php
}

function form_andamento_vendor($funzione) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";

    echo "<form method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo "<table class=\"form_table\" border=0><tr><td>";
    if (isset($_POST['tabella_name']))
        $selezionati = $_POST['tabella_name'];
    else
        $selezionati = "";
    stampa_select("tabella_name[]", "select nome_tabella from lista_tabelle order by ordine asc", "nome_tabella", TRUE, "", "", $selezionati);
    echo "</td><td>";
    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr></table></form>";
    echo "</div>";
}

function form_mesi_confronto($funzione) {
    echo "<div class=\"box_Form_Generic\" style=\"clear: both;\">";
    echo "<form  method=\"post\" action=\"index.php?page=grafici&tipo_grafico=$funzione\">";
    echo "<table class=\"form_table\" border=0><tr><td><h4>Mese di partenza</h4>";
    if (isset($_POST['tabella_name1']))
        $selezionati1 = $_POST['tabella_name1'];
    else
        $selezionati1 = "";
    if (isset($_POST['tabella_name2']))
        $selezionati2 = $_POST['tabella_name2'];
    else
        $selezionati2 = "";
    stampa_select("tabella_name1", "select nome_tabella from lista_tabelle order by ordine desc", "nome_tabella", FALSE, "", "", $selezionati1);
    echo "</td><td><h4>Mese di arrivo</h4>";
    stampa_select("tabella_name2", "select nome_tabella from lista_tabelle order by ordine desc", "nome_tabella", FALSE, "", "", $selezionati2);
    echo "</td><td>";
    echo "<input type=\"hidden\" name=\"tipo_grafico\" value=\"$funzione\">";
    echo "<input type='image' src=\"./image/btn_Invia.png\"  type=\"submit\" name=\"Submit\" value=\"Submit\"/>";
    echo "</td></tr></table></form>";
    echo "</div>";
}

function form_cerca_profilo() { //confermato
    ?>
    <div class="box_Form_Generic" style="clear: both;width: 600px">
        <h3></h3>
        <form   method="post" action="index.php?page=grafici">

    <?php
    /* if (isset($_POST['criterio1_value'])) {
      $criterio1 = $_POST['criterio1'];
      $criterio1_value = $_POST['criterio1_value'];
      } else {
      $criterio1 = "";
      $criterio1_value = "";
      } */
    //stampa_select("criterio1", "SELECT * FROM  `dati_requisiti` ", "label", false, "id", "", $criterio1);
    ?>
            <script type="text/javascript" src="js/jquery-1.4.2.js"></script>
            <script type="text/javascript">


                                    $(document).ready(function () {
                                        $('#loader').hide();
                                        $('#model').hide();
                                        $('#model_label').hide();
                                        $('#type').change(function () {

                                            $('#model').fadeOut();
                                            $('#loader').fadeOut();
                                            $('#model_label').show();
                                            $.post("./criterio.php", {
                                                type: $('#type').val()
                                            }, function (response) {
                                                setTimeout("finishAjax('model', '" + escape(response) + "')", 400);
                                            });
                                            return false;
                                        });

                                    });

                                    function finishAjax(id, response) {
                                        $('#loader').hide();
                                        $('#' + id).html(unescape(response));
                                        $('#' + id).fadeIn();
                                    }
            </script>
            <div id="loader"><strong>Loading...</strong></div>
            <label for="type">Seleziona un Requisito:</label>
            <select id="type" name="type" >
    <?php
    echo '<option value=""></option>';
    connect_db();
    $ultima_tabella = $row['nome_tabella'];
    $q = mysql_query("SELECT * FROM  `dati_requisiti`");
    $first_group = '';
    $count = 0;
    while ($row = mysql_fetch_assoc($q)) {
        #$group_name = ucwords(mb_strtolower($row['area_name']));
        $group_name = $row['sheet_name'];
        if ((strcasecmp($first_group, $group_name) != 0) && ($count > 0))
            echo "</optgroup><optgroup label=\"$group_name\">";
        elseif ((strcasecmp($first_group, $group_name) != 0) && ($count == 0))
            echo "<optgroup label=\"$group_name\">";

        echo '<option value="' . $row['id'] . '">' . $row['label'] . '</option>';

        $first_group = $group_name;
        $count++;
    }
    ?>
            </select>
                <?php
//echo "SELECT * FROM dati_tacid ORDER BY t_id ASC Group by Marca";
                ?>
            <br><label id="model_label">Valori:</label>
            <select id="model" name="criterio1_value[]" multiple=\"true\" >
                <option value="">-- Select value --</option>
            </select>
            <input type="hidden" name="tipo_grafico" value="cerca_profilo">
            <input class="btn_Submit"  type="submit" name="Submit" value="Submit"/>
        </form>
    </div>

    <?php
}

function form_mese($funzione, $lista = FALSE, $condizione_lista_mesi = "") {
    include_once 'dati_tacid_class.php';
    $dati_tacid = new dati_tacid_class();
    include_once 'form_class.php';
    $form = new form_class();
    ?>
    <div class="forms">
        <div class="row">
            <div class="form-three widget-shadow">
                <form   method="post" action="index.php?page=grafici&tipo_grafico=<?php echo $funzione; ?>">
                    <div class="form-group">
    <?php
    $form->get_lista_Mesi($condizione_lista_mesi, $lista);
    ?>

                    </div>
                    <button type="submit" class="btn btn-default" name="Submit" value="Submit">Submit</button>
                </form>
            </div>
        </div>
    </div>

    <?php
}
?>
