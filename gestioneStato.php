<style type="text/css">
                body {
                    overflow-y: auto;
                }
                a:hover {                    
                    color: black;
                }

table.dataTable thead th,
table.dataTable tr td,
table.dataTable tfoot th {
  text-align: left;
  padding-left: 2px;
  padding-right: 2px;
  margin-left: 0px;
  margin-right: 0px;
  height: 5px;
}
table.dataTable th { 
    background-color: lightseagreen;
    color: black;
}
table.dataTable tr:hover{
    background-color: lightgray;
    color: black; 
}

 </style>  
 

<?php
include_once './classes/form_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once './classes/access_user/access_user_class.php';

$page_protect = new Access_user;
$form = new form_class();
$funzione = new funzioni_admin();
$campaign = new campaign_class();
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $page_protect->log_out(); // the method to log off
}

//rename("file/5fd3a759daa6e","file/19572");
//copy ("file/5fd3a405b8b32","file/19573");
//unlink("file/5fd3a405b8b32");
include('action.php');

$channels = $funzione->get_list_select('channels');
$stacks = $funzione->get_list_select('campaign_stacks');
//print_r($stacks);
$typlogies = $funzione->get_list_select('campaign_types');
//$squads = $funzione->get_squads_gestione();
$squads = $funzione->get_list_select('squads');
$states = $funzione->get_list_select('campaign_states'); 
$sprints = $funzione->get_sprints();
// print_r($sprints);
$form->head_page("Gestione Campagne", "Filtro");
//print_r($_SESSION);  
//print_r($_POST); 
$livello_accesso = $page_protect->get_job_role();
            //Cambio di stato
            if (isset($_POST['cambiaStato'])) {
                $result = $campaign->update_kickoff($_POST['checkbox'], intval($_POST['selectNuovoStato']));
            }

                if (isset($result)) {
                    //echo "<div class=\"info\">";
                    //echo "<h2 style=\"color: #ff0000\">" . $result . "</h2>";
                    //echo "</div>";
                    echo '<div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>'. $result .'</strong></div>
                  </div>
                    ';
                }
              

?>
                <form action="index.php?page=gestioneStato" method="post" id="nofilter">
                            <input type="hidden" name="nofiletr" value="nofiletr" />                            
                </form>
                    <br>
                  <div class="well" style="overflow: auto">
                                
                      <div class="col-md-6 col-sm-6 col-xs-12"><h4>Date Range</h4>
                        <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          <span id="datarange">December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                      </div>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Sprints</h4>
                             <select id="sprints" name="sprints" class="select2_single form-control">        
                              
                            <?php 
                            //foreach ($sprints as $key => $value) {
                            //    echo '<option value="'.$key.'">'.$value['name'].'</option>';
                            //}                                                  
                            ?>  
                          </select>
                    </div>       
                     </div>          
                
                    <div class="col-md-12">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Stacks</h4>
                                <select id="stacks" name="stacks_id" multiple="multiple">
                                   <?php
                                   echo $campaign->multiselect_session($stacks, $_SESSION['filter']['stacks']);
                                    ?>
                                </select>
                            </div>


                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Squads</h4>
                                <select id="squads" name="squad_id" multiple="multiple">
                                   <?php
                                   echo $campaign->multiselect_session($squads, $_SESSION['filter']['squads']);
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Channels</h4>
                                <select id="channels" name="channel_id" multiple="multiple">
                                   <?php
                                   echo $campaign->multiselect_session($channels, $_SESSION['filter']['channels']);
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>States</h4>
                                <select id="states" name="campaign_state_id" multiple="multiple">
                                   <?php
                                    echo $campaign->multiselect_session($states, $_SESSION['filter']['states']);
                                    ?>                                 
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Typlogies</h4>
                                <select id="typologies" name="type_id" multiple="multiple">
                                   <?php      
                                    echo $campaign->multiselect_session($typlogies, $_SESSION['filter']['typologies']);
                                    ?>                                       
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <p><br><br>
                                    <button class="btn btn btn-sm btn-info" type="submit" onclick="manageCamp('','nofilter');" data-placement="top" data-toggle="tooltip" data-original-title="Cancella Filtro"><i class="fa fa-eraser"></i> Cancella Filtro</button>
                                </p>
                                
                            </div> 
                        </div>                    
                     
                    
<?php 
$form->close_row();
$form->open_row("Lista Campagne", "Filtrate");

?>
</div>
<div class="col-md-12 col-sm-12 col-xs-12" id="content_response">


</div>

<?php 

$form->close_page(); 


?> 

<script>

  
/*
var btn = document.getElementById("createXLSX");
var fileName = "<?php //echo date("Ymd").'_export_gestione';?>";
var fileType = "xlsx";
btn.addEventListener("click", function () {
  var table = document.getElementById("datatable-pianificazione");
  var wb = XLSX.utils.table_to_book(table, { sheet: "Sheet JS", type:'binary', raw: false});

  return XLSX.writeFile(wb, null || fileName + "." + (fileType || "xlsx"));
});
*/





        function controllaform() {

        Errore = "Attenzione non hai compilato tutti i campi obbligatori:\n\n";

        if (document.getElementById('sel1').value == "") {
            Errore = Errore + "- data inizio\n";
        }
        if (document.getElementById('sel3').value == "") {
            Errore = Errore + "- data fine\n";
        }
        if (document.getElementById('selectStato').value == "") {
            Errore = Errore + "- stato\n";
        }

        if ((document.getElementById('sel1').value != "") && (document.getElementById('sel3').value != ""))
        {

            ctlDate = ctrlDate(document.getElementById('sel1').value, document.getElementById('sel3').value);

            if (ctlDate)
            {
                //alert('Attenzione: La data di inizio è antecedente la data fine');
                return false;

            }

        }

        if (Errore == "Attenzione non hai compilato tutti i campi obbligatori:\n\n") {

            return true;
        }
        else {
            alert(Errore);
            return false;
        }
    }
    function controllaform2() {

        Errore = "Attenzione non hai compilato tutti i campi obbligatori:\n\n";
        temp = true;
        if (document.getElementById('selectNuovoStato').value == "") {
            Errore = Errore + "- Nuovo Stato\n";
            temp = false;
        }
        if (temp) {

            return true;
        }
        else {
            alert(Errore);
            return false;
        }
    }
    function selectAll(num) {

        if (document.getElementById('checkboxTot').checked)
        {
            for (i = 0; i < num; i++)
                document.getElementById('checkbox' + i).checked = true;
        }
        else
        {
            for (i = 0; i < num; i++)
                document.getElementById('checkbox' + i).checked = false;
        }
    }

    function deselezionaCheckTot(num) {

        var nocheck = 0;

        for (i = 0; i < num; i++) {

            if (document.getElementById('checkbox' + i).checked == false)
                nocheck++;

        }

        if (nocheck == 0)
            document.getElementById('checkboxTot').checked = true;
        else
            document.getElementById('checkboxTot').checked = false;

    }

    function controllaStato(num) {

        var check = 0;

        for (i = 0; i < num; i++) {

            if (document.getElementById('checkbox' + i).checked == true)
                check++;

        }

        if (check == 0) {
            alert('Seleziona almeno una campagna'); // document.getElementById('checkboxTot').checked=true;
            return false;
        }


        stato = document.getElementById('selectStato').value;
        nuovoStato = document.getElementById('selectNuovoStato').value;

        if (nuovoStato == "")
        {
            alert("Inserisci il nuovo stato");
            return false;
        }
        else
        if (stato == nuovoStato)
        {
            alert("Il nuovo stato deve essere diverso dal vecchio stato!");
            return false;
        }
        else {
            return true;
        }

    }


  </script>