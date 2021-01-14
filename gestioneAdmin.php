<style type="text/css">
            
                tr:hover {
                background-color: lightgrey;
                color: black;
                }
 </style>
<?php
//print_r($_POST);

include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();

if (isset($_GET['table']))
    $table_name = $_GET['table'];
elseif (isset($_POST['tabella']))
    $table_name = $_POST['tabella'];
else
    $table_name = 'job_roles';



if (isset($_POST['azione'])) {
    $table_name = $_POST['tabella'];


    if (!empty($_POST) && $_POST['azione'] == 'update') {
        $id = $_POST['id'];
        $new_name = $_POST['new_value'];

        $color = NULL;
        if (isset($_POST['color']))
            $color = $_POST['color'];

        $elimina = NULL;
        if (isset($_POST['elimina']))
            $elimina = $_POST['elimina'];

        $label = NULL;
        if (isset($_POST['label']))
            $label = $_POST['label'];

        $description = NULL;
        if (isset($_POST['description']))
            $description = $_POST['description'];

        if (isset($_POST['channel_id']))
            $channel_id = $_POST['channel_id'];
         
        $days = Null;
                if (isset($_POST['days']))
                    $days = $_POST['days'];
$data_inizio = Null;                
                    if (isset($_POST['data_inizio']))
                    $data_inizio = $_POST['data_inizio'];                
                $data_fine = Null;
                    if (isset($_POST['data_fine']))
                    $data_fine = $_POST['data_fine'];        
        
          
            //var_dump($_POST);
        if (!empty($new_name))
            $funzioni_admin->update_name($table_name, $id, $new_name, $color, $elimina, $label, $description, $days,$data_inizio,$data_fine);
        else
            echo '<script type="text/javascript">alert("Attenzione! Campo vuoto");</script>';
    }

    if (!empty($_POST) && $_POST['azione'] == 'elimina') {
        $id = $_POST['id'];
        $funzioni_admin->delete_name($table_name, $id);
    }
    if (!empty($_POST) && $_POST['azione'] == 'insert_new') {
        if ($table_name == 'campaign_types') {
            if (isset($_POST['new_name']) && !empty($_POST['new_name'])) {
                $new_name = $_POST['new_name'];
                $label = $_POST['label'];
            }
            $stack_id = $_POST['gruppo_id'];
            if (empty($new_name) || empty($stack_id))
                echo '<script type="text/javascript">alert("Attenzione! Nome campo non valorizzato.");</script>';
            else //if ($funzioni_admin->check_new_name($table_name, $new_name))
                $funzioni_admin->insert_new_campaigntype($new_name, $stack_id, $label);
        }
        elseif ($table_name == 'sprints') {
            if (isset($_POST['new_name']) && !empty($_POST['new_name'])) {
                $new_name = $_POST['new_name'];
                if(isset($_POST['days'])){
                     $days = $_POST['days'];                    
                }else{
                    $days = 14;
                }
            }
            $data_inizio = $_POST['data_inizio'];
            $data_fine =  $_POST['data_fine'];
            if (empty($new_name))
                echo '<script type="text/javascript">alert("Attenzione! Nome campo non valorizzato.");</script>';
            else //if ($funzioni_admin->check_new_name($table_name, $new_name))
                $funzioni_admin->insert_new_sprints($new_name, $days,$data_inizio, $data_fine);
        }
        elseif ($table_name == 'campaign_states') {
            if (isset($_POST['new_name']) && !empty($_POST['new_name']))
                $new_name = $_POST['new_name'];
            $color = $_POST['color'];
            $elimina = $_POST['elimina'];
            if (empty($new_name) || empty($color))
                echo '<script type="text/javascript">alert("Attenzione! Nome campo non valorizzato.");</script>';
            else
                $funzioni_admin->insert_new_campaignstatus($new_name, $color, $elimina);
        }elseif ($table_name == 'offers') {
            if (isset($_POST['new_name']) && !empty($_POST['new_name']))
                $new_name = $_POST['new_name'];
            $label = $_POST['label'];
            $description = $_POST['description'];
            if (empty($new_name) || empty($label) || empty($description))
                echo '<script type="text/javascript">alert("Attenzione! Alcuni campi non sono valorizzati.");</script>';
            else {
                $check_triplett = $funzioni_admin->check_triplette_offers($new_name, $label, $description);
                if ($check_triplett)
                    $funzioni_admin->insert_new_offers($new_name, $label, $description);
                else echo '<script type="text/javascript">alert("Attenzione! La tripletta \'Name\' \'Label\' \'Description\' è già esistente e non può essere duplicata!.");</script>';
            }
        }elseif ($table_name == 'senders') {
            if (isset($_POST['new_name']) && !empty($_POST['new_name']))
                $new_name = $_POST['new_name'];
            $channel_id = $_POST['channel_id'];
            #var_dump($_POST);
            if (empty($new_name) || empty($channel_id))
                echo '<script type="text/javascript">alert("Attenzione! Nome campo non valorizzato.");</script>';
            else
                $funzioni_admin->insert_new_senders($new_name, $channel_id);
        }else {
            if (isset($_POST['new_name']) && !empty($_POST['new_name']))
                $new_name = $_POST['new_name'];
            if (isset($_POST['label']))
                $label = $_POST['label'];
            else
                $label = "";
            #var_dump($_POST);
            if (empty($new_name))
                echo '<script type="text/javascript">alert("Attenzione! Nome campo non valorizzato.");</script>';
            elseif ($funzioni_admin->check_new_name($table_name, $new_name))
                $funzioni_admin->insert_name($table_name, $new_name, "", $label);
            else
                echo '<script type="text/javascript">alert("Attenzione! Nome già presente nella lista, occorre scegliere un nome univoco.");</script>';
        }
    }
    if (!empty($_POST) && $_POST['azione'] == 'upload_lista') {
        //include_once("./upload/upload_class.php"); //classes is the map where the class file is stored (one above the root)
        //$folder = "./upload/";
        //error_reporting(E_ALL);
        include_once("./upload_offer_list.php");
    }
}
$select_job_roles = '';
$select_squads = '';
$select_campaign_stacks = '';
$select_campaign_titolo_sottotitolo = '';
$select_campaign_cat_sott = '';
$select_campaign_types = '';
$select_campaign_states = '';
$select_sprints = '';
$select_senders = '';
$select_channels = '';
$select_offers = '';

switch ($table_name) {
    case "job_roles": $select_job_roles = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "squads": $select_squads = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "sprints": $select_sprints = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "campaign_stacks": $select_campaign_stacks = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "campaign_stacks": $select_campaign_titolo_sottotitolo = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
        case "campaign_stacks": $select_campaign_cat_sott = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;    
    case "campaign_types": $select_campaign_types = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "campaign_states": $select_campaign_states = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "senders": $select_senders = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "channels": $select_channels = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
    case "offers": $select_offers = 'style="background-color:#6F7D94;color: #FFF;" break';
        break;
}
?>

<script language="JavaScript" type="text/javascript">

    function seleziona(riga) {
        riga.className = "selezionata";
    }

    function deseleziona(riga) {
        riga.className = "bianco";
    }

    function conferma() {
        if (!(confirm('Confermi eliminazione?')))
        {
            return false;
        }
        else {
            return true;
        }
    }

    function seleziona_campo(campo) {
        campoSelezionato = document.getElementById(campo);
        campoSelezionato.style.background = "orange";
    }

    function deseleziona_campo(campo) {
        campoSelezionato = document.getElementById(campo);
        campoSelezionato.style.background = "white";
    }

</script>
<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
<link rel="stylesheet" href="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/themes/smoothness/jquery-ui.css" />
<script src="http://ajax.googleapis.com/ajax/libs/jqueryui/1.11.0/jquery-ui.min.js"></script>
<!--<script src="js/Hexagon-Color-Picker-Plugin-with-jQuery-jQuery-UI/src/jquery-hex-colorpicker.min.js"></script>
<link rel="stylesheet" href="js/Hexagon-Color-Picker-Plugin-with-jQuery-jQuery-UI/css/jquery-hex-colorpicker.css" />
<script type="text/javascript">
    jQuery(function () {
        jQuery("#color-picker1").hexColorPicker();
        jQuery(".color-picker").hexColorPicker({
            "container": "dialog",
        });
        jQuery("#color-picker2").hexColorPicker({
            "container": "dialog",
            "colorModel": "hsl",
            "pickerWidth": 400,
            "size": 15,
            "style": "box",
            "outputFormat": "<hexcode>",
        });
    });
</script>-->

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Amministrazione</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <!--<div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>-->
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

                <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                   
                    <h2>Gestione <?php echo" > " . strtoupper($table_name) . "  "; ?><input title="In questa sezione è possibile aggiungere/modificare/eliminare i seguenti elementi" alt="Gestione Liste Preview SMS" type="image" src="images/informazione.jpg" style="margin:0px; height:20px;"/></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="content">         


    <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer nowrap" role="grid" aria-describedby="datatable-fixed-header_info">
        <tr style="height:25px; font-weight: bold; background: url(images/wbg.gif) repeat-x 0px -1px;">
            <td align="center" width="1%">N.</td>
            <?php if ($table_name == 'campaign_types') echo '<td>Stack</td>'; ?>
            <?php if ($table_name == 'senders') echo '<td>Channel</td>'; ?>

            <td align="center">Nome</td>
            <?php if ($table_name == 'offers' || $table_name == 'campaign_types' || $table_name == 'campaign_cat_sott' || $table_name == 'campaign_titolo_sottotitolo' || $table_name == 'campaign_stacks' || $table_name == 'channels' || $table_name == 'segments' || $table_name == 'campaign_categories' || $table_name == 'campaign_modalities') echo '<td align="center">Label</td>'; ?>
            <?php if ($table_name == 'offers') echo '<td>Description</td>'; ?>


            <?php if ($table_name == 'campaign_states') echo '<td>Colore</td>'; ?>
            <?php if ($table_name == 'campaign_states') echo '<td>Eliminabile</td>'; ?>
            <?php if ($table_name == 'sprints') echo '<td>Giorni</td>'; ?>
            <?php if ($table_name == 'sprints') echo '<td>Data Inizio</td>'; ?>
            <?php if ($table_name == 'sprints') echo '<td>Data Fine</td>'; ?>
            <td align="center" colspan="2" width="2%">
                <form name="inserisciListaPreview" action="./index.php?page=gestioneAdmin" method="post" style="margin:0px;">
                    <input alt="Aggiungi nuovo elemento" title="Aggiungi nuovo elemento" type="image" src="images/Inserisci.png" style="margin:0px"/>
                    <?php echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />"; ?>
                    <input type="hidden"  name="azione" value="aggiungi" />
                </form>
                <?php if ($table_name == 'offers') { ?>
                    <form name="upload" action="./index.php?page=gestioneAdmin" method="post" style="margin:0px;">
                        <input alt="Carica lista" title="Carica lista" type="image" src="images/upload.png" style="margin:0px"/>
                        <?php echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />"; ?>
                        <input type="hidden"  name="azione" value="upload_lista" />
                    </form>
                <?php }
                ?>
            </td>
        </tr>

        <?php
#$table_name = 'campaign_stacks';
        if ($table_name == 'campaign_types') {
            $list = $funzioni_admin->get_all_list($table_name, 'ORDER BY `campaign_types`.`campaign_stack_id` ASC');
            $riga = 0;

            if (!empty($_POST) && $_POST['azione'] == 'aggiungi') {
                echo "<tr  id=\"" . $riga++ . "\"  style=\"height:25px;\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" >";
                echo "<form action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";


                $gruppo = $funzioni_admin->get_list_id("campaign_stacks");
                $option_list = "<option value=\"\" ></option>";
                foreach ($gruppo as $key => $value) {

                    $option_list = $option_list . "<option value=\"" . $value['id'] . "\" >" . $value['name'] . "</option>";
                }


                echo "<td align=\"center\">" . $riga . "</td>"
                . "<td><select name=\"gruppo_id\" id=\"new_value1\" onfocus=\"seleziona_campo('new_value1');\" onblur=\"deseleziona_campo('new_value1');\">" . $option_list . "</select></td>"
                . "<td><input type=\"text\" size=\"15\" id=\"new_value\" name=\"new_name\" value=\"\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                echo "<td><input type=\"text\"   size=\"10\" id=\"label\" name=\"label\"  onfocus=\"seleziona_campo('label');\" onblur=\"deseleziona_campo('label');\"/></td>";

                echo "<td align=\"center\"><input alt=\"Conferma\" title=\"Conferma\" type=\"image\" src=\"images/inserisci.jpg\" /></td>";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"insert_new\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "</form>";
                echo "<form action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";
                echo "<td align=\"center\"><input alt=\"Annula\" title=\"Annulla\" type=\"image\" src=\"images/annulla2.png\" /></td></td></tr>";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"annula\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" /></form>";
            }
            #print_r($list);
            foreach ($list as $key => $value) {
                //echo "\n". $value['id'] ." ". $value['name'] . "\n";
                $group_name = $funzioni_admin->get_list_id_where('campaign_stacks', 'id=' . $value['campaign_stack_id']);
                #print_r($group_name);
                echo "<tr  id=\"" . $riga++ . "\"  style=\"height:25px;\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" >";
                echo "<form name=\"modificaListaPreview0\" id=\"modificaListaPreview0\" action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";

                if (!empty($_POST) && $_POST['azione'] == 'modifica' && $_POST['id'] == $value['id'])
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td>" . $group_name[0]['name'] . "</td>"
                    . "<td><input type=\"text\"  id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>"
                    . "<td><input type=\"text\"  id=\"label\" name=\"label\" value=\"" . $value['label'] . "\" onfocus=\"seleziona_campo('label');\" onblur=\"deseleziona_campo('label');\"/></td>";
                else
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td>" . $group_name[0]['name'] . "</td>"
                    . "<td>" . $value['name'] . "</td>" . "<td>"
                    . $value['label'] . "</td>";

                echo "<td align=\"center\">";
                if (!empty($_POST) && $_POST['azione'] == 'modifica' && $_POST['id'] == $value['id']) {
                    echo "<input alt=\"Conferma\" title=\"Conferma\" type=\"image\" src=\"images/conferma.jpg\" />";
                    echo "<input type=\"hidden\"  name=\"azione\" value=\"update\" />";
                } else {
                    echo "<input alt=\"Modifica\" title=\"Modifica elemento\" type=\"image\" src=\"images/Modifica.png\" />";
                    echo "<input type=\"hidden\"  name=\"azione\" value=\"modifica\" />";
                }

                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "<input type=\"hidden\"  name=\"id\" value=\"" . $value['id'] . "\" />";
                echo "</form></td>";
                echo "<td align=\"center\"><form name=\"eliminaListaPreview0\" id=\"eliminaListaPreview0\" action=\"./index.php?page=gestioneAdmin\" onsubmit=\"return conferma()\" method=\"post\" style=\"margin:0px;\">";
                echo "<input type=\"image\" alt=\"Elimina\" title=\"Elimina elemento\" src=\"images/Elimina.png\" value=\"Elimina\" />";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"elimina\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "<input type=\"hidden\"  name=\"id\" value=\"" . $value['id'] . "\" /></form>";
                echo "</td></tr>";
            }
        } elseif ($table_name == 'senders') {
            $list = $funzioni_admin->get_all_list($table_name, 'ORDER BY `senders`.`channel_id` ASC');
            $riga = 0;
            if (!empty($_POST) && $_POST['azione'] == 'aggiungi') {
                echo "<tr  id=\"" . $riga++ . "\"  style=\"height:25px;\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" >";
                echo "<form action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";


                $gruppo = $funzioni_admin->get_list_id("channels");
                $option_list = "<option value=\"\" ></option>";
                foreach ($gruppo as $key => $value) {

                    $option_list = $option_list . "<option value=\"" . $value['id'] . "\" >" . $value['name'] . "</option>";
                }


                echo "<td align=\"center\">" . $riga . "</td>"
                . "<td><select name=\"channel_id\" id=\"new_value1\" onfocus=\"seleziona_campo('new_value1');\" onblur=\"deseleziona_campo('new_value1');\">" . $option_list . "</select></td>"
                . "<td><input type=\"text\"  id=\"new_value\" name=\"new_name\" value=\"\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";


                echo "<td align=\"center\"><input alt=\"Conferma\" title=\"Conferma\" type=\"image\" src=\"images/inserisci.jpg\" /></td>";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"insert_new\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "</form>";
                echo "<form action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";
                echo "<td align=\"center\"><input alt=\"Annula\" title=\"Annulla\" type=\"image\" src=\"images/annulla2.png\" /></td></td></tr>";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"annula\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" /></form>";
            }
            #print_r($list);
            foreach ($list as $key => $value) {
                //echo "\n". $value['id'] ." ". $value['name'] . "\n";
                $group_name = $funzioni_admin->get_list_id_where('channels', 'id=' . $value['channel_id']);
                #print_r($group_name);
                echo "<tr  id=\"" . $riga++ . "\"  style=\"height:25px;\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" >";
                echo "<form name=\"modificaListaPreview0\" id=\"modificaListaPreview0\" action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";

                if (!empty($_POST) && $_POST['azione'] == 'modifica' && $_POST['id'] == $value['id'])
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td>" . $group_name[0]['name'] . "</td>"
                    . "<td><input type=\"text\" size=\"15\" id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                else
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td>" . $group_name[0]['name'] . "</td>"
                    . "<td>" . $value['name'] . "</td>";

                echo "<td align=\"center\">";
                if (!empty($_POST) && $_POST['azione'] == 'modifica' && $_POST['id'] == $value['id']) {
                    echo "<input alt=\"Conferma\" title=\"Conferma\" type=\"image\" src=\"images/conferma.jpg\" />";
                    echo "<input type=\"hidden\"  name=\"azione\" value=\"update\" />";
                } else {
                    echo "<input alt=\"Modifica\" title=\"Modifica elemento\" type=\"image\" src=\"images/Modifica.png\" />";
                    echo "<input type=\"hidden\"  name=\"azione\" value=\"modifica\" />";
                }

                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "<input type=\"hidden\"  name=\"id\" value=\"" . $value['id'] . "\" />";
                echo "</form></td>";
                echo "<td align=\"center\"><form name=\"eliminaListaPreview0\" id=\"eliminaListaPreview0\" action=\"./index.php?page=gestioneAdmin\" onsubmit=\"return conferma()\" method=\"post\" style=\"margin:0px;\">";
                echo "<input type=\"image\" alt=\"Elimina\" title=\"Elimina elemento\" src=\"images/Elimina.png\" value=\"Elimina\" />";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"elimina\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "<input type=\"hidden\"  name=\"id\" value=\"" . $value['id'] . "\" /></form>";
                echo "</td></tr>";
            }
        } else {
            $list = $funzioni_admin->get_list_id($table_name);
            $riga = 0;
            if (!empty($_POST) && $_POST['azione'] == 'aggiungi') {
                echo "<tr  id=\"" . $riga++ . "\"  style=\"height:25px;\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" >";
                echo "<form action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";

                if ($table_name == 'campaign_states') {
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td><input type=\"text\"  id=\"new_value\" name=\"new_name\" value=\"\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                    echo "<td><input type=\"text\"  class=\"color-picker\" size=\"6\" id=\"color\" name=\"color\" value=\"\" onfocus=\"seleziona_campo('color');\" onblur=\"deseleziona_campo('color');\"/>";
                    echo "</td>";
                    echo "<td><input type=\"text\" size=\"2\" id=\"elimina\" name=\"elimina\" value=\"\" onfocus=\"seleziona_campo('elimina');\" onblur=\"deseleziona_campo('elimina');\"/></td>";
                } 
                
                elseif ($table_name == 'sprints') {
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td><input  type=\"text\" size=\"10\" id=\"new_value\" name=\"new_name\" value=\"\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                    echo "<td><input type=\"text\"  size=\"6\" id=\"days\" name=\"days\" value=\"\" onfocus=\"seleziona_campo('days');\" onblur=\"deseleziona_campo('days');\"/>";
                    echo "</td>";
                    echo "<td><input class=\"date-picker form-control\" required=\"required\" type=\"text\"  size=\"6\" id=\"data_inizio\" name=\"data_inizio\" value=\"\" onfocus=\"seleziona_campo('data_inizio');\" onblur=\"deseleziona_campo('data_inizio');\"/>";

                    echo "</td>";
                    echo "<td><input class=\"date-picker form-control\" required=\"required\" type=\"text\"  size=\"6\" id=\"data_fine\" name=\"data_fine\" value=\"\" onfocus=\"seleziona_campo('data_fine');\" onblur=\"deseleziona_campo('data_fine');\"/>";
                    echo "</td>";                    
                }
                elseif ($table_name == 'offers') {
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td><input type=\"text\" size=\"30\" id=\"new_value\" name=\"new_name\"  onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                    echo "<td><input type=\"text\"   size=\"30\" id=\"label\" name=\"label\"  onfocus=\"seleziona_campo('label');\" onblur=\"deseleziona_campo('label');\"/></td>";
                    echo "<td><textarea name=\"description\" cols=\"60\" rows=\"5\"  onfocus=\"seleziona_campo('description');\" onblur=\"deseleziona_campo('description');\"></textarea>";
                } elseif ($table_name == 'campaign_cat_sott' || $table_name == 'campaign_titolo_sottotitolo' || $table_name == 'campaign_modalities' || $table_name == 'campaign_categories' || $table_name == 'campaign_stacks' || $table_name == 'channels' || $table_name == 'segments') {
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td><input type=\"text\"  id=\"new_value\" name=\"new_name\" value=\"\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                    echo "<td><input type=\"text\"   id=\"label\" name=\"label\"  onfocus=\"seleziona_campo('label');\" onblur=\"deseleziona_campo('label');\"/></td>";
                } else {
                    echo "<td align=\"center\">" . $riga . "</td>"
                    . "<td><input type=\"text\"  id=\"new_value\" name=\"new_name\" value=\"\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                }

                echo "<td align=\"center\">";
                echo "<input alt=\"Conferma\" title=\"Conferma\" type=\"image\" src=\"images/inserisci.jpg\" /></td>";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"insert_new\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "</form>";
                echo "<form action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";
                echo "<td align=\"center\"><input alt=\"Annula\" title=\"Annulla\" type=\"image\" src=\"images/annulla2.png\" /></td></td></tr>";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"annula\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" /></form>";
            }
            foreach ($list as $key => $value) {
                //echo "\n". $value['id'] ." ". $value['name'] . "\n";
                echo "<tr  id=\"" . $riga++ . "\"  style=\"height:25px;\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" >";
                echo "<form name=\"modificaListaPreview0\" id=\"modificaListaPreview0\" action=\"./index.php?page=gestioneAdmin\" method=\"post\" style=\"margin:0px;\">";

                if (!empty($_POST) && $_POST['azione'] == 'modifica' && $_POST['id'] == $value['id']) {

                            if ($table_name == 'campaign_states') {
                                echo "<td align=\"center\">" . $riga . "</td>"
                                . "<td><input type=\"text\" size=\"13\" id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                                $colore = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "colore");
                                $elimina = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "elimina");
                                echo "<td><input type=\"text\"  class=\"color-picker\" size=\"6\" id=\"color\" name=\"color\" value=\"" . $colore . "\" onfocus=\"seleziona_campo('color');\" onblur=\"deseleziona_campo('color');\"/></td>";
                                echo "<td><input type=\"text\" size=\"2\" id=\"elimina\" name=\"elimina\" value=\"" . $elimina . "\" onfocus=\"seleziona_campo('elimina');\" onblur=\"deseleziona_campo('elimina');\"/></td>";
                            }  
                            elseif ($table_name == 'sprints') {
                                echo "<td align=\"center\">" . $riga . "</td>"
                                . "<td><input type=\"text\" size=\"10\" id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                                $days = $funzioni_admin->get_nome_campo($table_name, "id", $value['id'], "days");
                                $data_inizio = $funzioni_admin->get_nome_campo($table_name, "id", $value['id'], "data_inizio");
                                $data_fine = $funzioni_admin->get_nome_campo($table_name, "id", $value['id'], "data_fine");
                                echo "<td><input type=\"text\" size=\"2\" id=\"days\" name=\"days\" value=\"" . $days . "\" onfocus=\"seleziona_campo('days');\" onblur=\"deseleziona_campo('days');\"/></td>";                        
                                echo "<td>"
                                . "<input class=\"date-picker form-control\" required=\"required\" type=\"text\" size=\"8\" id=\"data_inizio\" name=\"data_inizio\" value=\"" . $data_inizio . "\" onfocus=\"seleziona_campo('data_inizio');\" onblur=\"deseleziona_campo('data_inizio');\"/>";


                                echo '</td>';
                                echo "<td><input class=\"date-picker form-control\" required=\"required\" type=\"text\" size=\"8\" id=\"data_fine\" name=\"data_fine\" value=\"" . $data_fine . "\" onfocus=\"seleziona_campo('data_fine');\" onblur=\"deseleziona_campo('data_fine');\"/></td>";
                            }

                            elseif ($table_name == 'offers') {
                                echo "<td align=\"center\">" . $riga . "</td>"
                                . "<td><input type=\"text\" size=\"30\" id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                                $description = $funzioni_admin->get_nome_campo($table_name, "id", $value['id'], "description");
                                $label = $funzioni_admin->get_nome_campo($table_name, "id", $value['id'], "label");
                                echo "<td><input type=\"text\"   size=\"30\" id=\"label\" name=\"label\" value=\"" . $label . "\" onfocus=\"seleziona_campo('label');\" onblur=\"deseleziona_campo('label');\"/></td>";
                                echo "<td><textarea name=\"description\" cols=\"60\" rows=\"5\"  onfocus=\"seleziona_campo('description');\" onblur=\"deseleziona_campo('description');\">$description</textarea>";
                            } elseif ($table_name == 'job_roles' || $table_name == 'squads') {
                                echo "<td align=\"center\">" . $riga . "</td>";
                                echo "<td><input type=\"text\" size=\"30\" id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                            } else {

                                echo "<td align=\"center\">" . $riga . "</td>";
                                echo "<td><input type=\"text\" size=\"30\" id=\"new_value\" name=\"new_value\" value=\"" . $value['name'] . "\" onfocus=\"seleziona_campo('new_value');\" onblur=\"deseleziona_campo('new_value');\"/></td>";
                                $label = $funzioni_admin->get_nome_campo($table_name, "id", $value['id'], "label");
                                echo "<td align=\"center\"><input type=\"text\"   size=\"10\" id=\"label\" name=\"label\" value=\"" . $label . "\" onfocus=\"seleziona_campo('label');\" onblur=\"deseleziona_campo('label');\"/></td>";
                            }
                } else {
                    echo "<td align=\"center\">" . $riga . "</td>";
                    echo "<td>" . $value['name'] . "</td>";
                    if ($table_name == 'campaign_states') {
                        $colore = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "colore");
                        $elimina = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "elimina");
                        echo "<td align=\"center\"  style=\"background-color:$colore;\" >" . $colore . "</td>";
                        echo "<td align=\"center\">" . $elimina . "</td>";
                    }
                    if ($table_name == 'offers') {
                        $description = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "description");
                        $label = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "label");
                        echo "<td align=\"center\"   >" . $label . "</td>";
                        echo "<td align=\"center\">" . $description . "</td>";
                    }
                    if ($table_name == 'sprints') {
                        $days = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "days");
                        $data_inizio = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "data_inizio");
                        $data_fine = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "data_fine");
                        echo "<td align=\"center\"   >" . $days . "</td>";
                        echo "<td align=\"center\"   >" . $data_inizio . "</td>";
                        echo "<td align=\"center\">" . $data_fine . "</td>";
                    }
                    if ($table_name == 'campaign_categories' || $table_name == 'campaign_modalities' || $table_name == 'campaign_titolo_sottotitolo' || $table_name == 'campaign_cat_sott' || $table_name == 'campaign_stacks' || $table_name == 'channels' || $table_name == 'segments') {
                        $label = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "label");
                        echo "<td align=\"center\"   >" . $label . "</td>";
                    }
                    /* if ($table_name == 'offers') {
                      $description = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "description");
                      $label = $funzioni_admin->get_nome_campo($table_name, "name", $value['name'], "label");
                      echo "<td align=\"center\"   >" . $label . "</td>";
                      echo "<td align=\"center\">" . $description . "</td>";
                      } */
                }

                echo "<td align=\"center\">";
                if (!empty($_POST) && $_POST['azione'] == 'modifica' && $_POST['id'] == $value['id']) {
                    echo "<input alt=\"Conferma\" title=\"Conferma\" type=\"image\" src=\"images/conferma.jpg\" />";
                    echo "<input type=\"hidden\"  name=\"azione\" value=\"update\" />";
                } else {
                    echo "<input alt=\"Modifica\" title=\"Modifica elemento\" type=\"image\" src=\"images/Modifica.png\" />";
                    echo "<input type=\"hidden\"  name=\"azione\" value=\"modifica\" />";
                }

                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "<input type=\"hidden\"  name=\"id\" value=\"" . $value['id'] . "\" />";
                echo "</form></td>";
                echo "<td align=\"center\"><form name=\"eliminaListaPreview0\" id=\"eliminaListaPreview0\" action=\"./index.php?page=gestioneAdmin\" onsubmit=\"return conferma()\" method=\"post\" style=\"margin:0px;\">";
                echo "<input type=\"image\" alt=\"Elimina\" title=\"Elimina elemento\" src=\"images/Elimina.png\" value=\"Elimina\" />";
                echo "<input type=\"hidden\"  name=\"azione\" value=\"elimina\" />";
                echo "<input type=\"hidden\"  name=\"tabella\" value=\"" . $table_name . "\" />";
                echo "<input type=\"hidden\"  name=\"id\" value=\"" . $value['id'] . "\" /></form>";
                echo "</td></tr>";
            }
        }
        ?>

    </table>

</div>



                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->



<script>
          //calcolo data inizio e fine del nuovo sprint in ADD
          $.ajax({
            url: "get_lastDataSprint.php",
            method: "POST",
            //data: {sprint: selected_sprint},
            //dataType:"html",    
            success: function (data)
            {
                console.log('dataaa ', JSON.stringify(data));
                console.log('dataaa parse ', JSON.parse(data).data_fine);
              var new_inizio = moment(JSON.parse(data).data_fine,"YYYY-MM-DD").add(1, 'day').format("YYYY-MM-DD");
              var new_fine = moment(JSON.parse(data).data_fine,"YYYY-MM-DD").add(15, 'day').format("YYYY-MM-DD");
              console.log('eccolaaa ', moment(JSON.parse(data).data_fine,"YYYY-MM-DD").add(1, 'day').format("YYYY-MM-DD")); 
              $('#data_inizio').val(new_inizio);
              $('#data_fine').val(new_fine);
              $('#days').val("14");
            
            
            }
          })

      
</script>