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
table.dataTable.compact thead th, table.dataTable.compact thead td {
    padding-left: 2px;
    font-size: 11px;
}

table.dataTable.compact tr td, table.dataTable.compact tr td {
    font-size: 11px;
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
//$sprints = $funzione->get_sprints();
$sprints = $funzione->get_list_select('sprints'); 
//print_r($sprints);
$form->head_page("Gestione Campagne", "Filtro");
//print_r($_SESSION);  
//print_r($_POST); 
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
                <form action="index.php?page=gestioneCampagne2" method="post" id="nofilter">
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
                                   if(!empty($_SESSION['filter']['sprint'])){
                                       $sp = $funzione->get_sprint($_SESSION['filter']['sprint']);
                                       echo '<option value="' . $sp['id'] . '" selected>' . $sp['name'] . '</option>';
                                   }
                                   elseif(!empty($_POST['sprint'])){
                                       $sp = $funzione->get_sprint($_POST['sprint']);
                                       echo '<option value="' . $sp['id'] . '" selected>' . $sp['name'] . '</option>';
                                   }
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


$livello_accesso = $page_protect->get_job_role();
if ($livello_accesso > 1) {
    ?>
                <!--button add new campaign -->
                <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaNew">
                            <input type="hidden" name="azione" value="new" />
                            <input type="hidden" name="id" value="0" />
                </form>
                
                <?php }
if ($livello_accesso > 0) {
    ?>

                <form action="export_file_excel.php" method="post" id="exportgestione">
                        <input type="hidden" name="funzione" value="export_gestione">
                </form>
                <div style="margin-left: 10px;">
                <!--button Excel -->
<?php }
if ($livello_accesso > 1) {
    ?>
<button class="btn btn btn-xs btn-warning" type="submit" onclick="manageCamp('','new');" data-placement="top" data-toggle="tooltip" data-original-title="Inserisci nuova Campagna"><i class="fa fa-plus-square"></i> Nuova Campagna</button>
<?php } 
if ($livello_accesso > 1) {
    ?>
<!--<button class="btn btn btn-xs btn-success" id="createXLSX"  data-placement="top" data-toggle="tooltip" data-original-title="Export Gestione"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>-->
<button class="btn btn btn-xs btn-success" onclick="manageCamp('','exportgestione');" data-placement="top" data-toggle="tooltip" data-original-title="Export Gestione"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>

<?php }?>
</div>
<div class="loader"></div>
        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaModifica">		     
            <input type="hidden" name="azione" value="modifica">
        </form>      
        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaDuplica">            
            <input type="hidden" name="azione" value="duplica">
        </form>
                        <form action="index.php?page=pianificazione2"  method="post" id="campagnaElimina">                             
                            <input type="hidden" name="azione" value="elimina" />                                                                
                        </form>     
                                                 <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaOpen"> 
                        
                            <input type="hidden" name="azione" value="open" />                                                                
                        </form>  
<div class="col-md-12 col-sm-12 col-xs-12" id="content_response">
<!--<div  id="content_response" style="clear:both;min-height: 450px; max-height: 600px; width: 100%;overflow: auto;">-->


</div>

<?php 

$form->close_page(); ?> 

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
            document.location.href = './index.php?page=inserisciCampagna2';
    }
  </script>