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
  margin-left: 2px;
  margin-right: 2px;
  height: 5px;
}
table.dataTable th { 
    background-color: lightgreen;
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
$squads = $funzione->get_list_select('squads');
$states = $funzione->get_list_select('campaign_states'); 
//$sprints = $funzione->get_sprints();
$sprints = $funzione->get_list_select('sprints'); 
//print_r($sprints);
$form->head_page_compat("Pianificazione Campagne", "Filtro");
//print_r($_SESSION);  
//echo 'POSTTTTTTTT';
//print_r($_POST); 
                
                if (isset($result)&& is_string($result)) {
                    //echo "<div class=\"info\">";
                    //echo "<h2 style=\"color: #ff0000\">" . $result . "</h2>";
                    //echo "</div>";
                    echo '<div class="alert alert-info alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>'. $result .'</strong></div>                  
                    ';
                }
              
?>
                <form action="index.php?page=pianificazione2" method="post" id="nofilter">
                            <input type="hidden" name="nofiletr" value="nofiletr" />                            
                </form>
                 <!--<div class="well" style="overflow: auto">-->                                                
    <div class="well" style="overflow: auto">
                  <div class="col-md-6 col-sm-6 col-xs-12"><h4>Date Range</h4>
                        <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          <span id="datarange">December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                      </div>
                     <div class="col-md-2 col-sm-6 col-xs-12">
                                <h4>Sprints</h4>
                             <select id="sprints" name="sprints" class="select2_single form-control">        
                              
                            <?php 
                            foreach ($sprints as $key => $value) {
                                if(isset($_SESSION['filter']['sprint']) && $_SESSION['filter']['sprint']==$key)
                                echo '<option selected value="'.$key.'">'.$value.'</option>';
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
$form->open_row("Pianificazione Campagne", "Filtrate");
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
                <form action="export_file_excel.php" method="post" id="exportpianificazione">
                        <input type="hidden" name="funzione" value="export_pianificazione">
                </form>
                <form action="export_file_excel.php" method="post" id="exportgestione">
                        <input type="hidden" name="funzione" value="export_gestione">
                </form>
                <form action="export_file_excel.php" method="post" id="exportcapacity">
                        <input type="hidden" name="funzione" value="export_capacity">
                </form>
               <!-- 
                <form action="export_excel_pianificazione.php" method="post" id="exportpianificazione">
                        <input type="hidden" name="funzione" value="export_pianificazione">
                </form>-->
                <!--button Excel -->
<?php }

if ($livello_accesso > 1) { 
    ?>
<div class="col-md-12 col-sm-12 col-xs-12">
<div class="btn-group">    
<button class="btn btn btn-xs btn-warning" type="submit" onclick="manageCamp('','new');" data-placement="top" data-toggle="tooltip" data-original-title="Inserisci nuova Campagna"><i class="fa fa-plus-square"></i> Nuova Campagna</button>

</div>
<?php } 
if ($livello_accesso > 0) {
    ?>
<!--<button class="btn btn btn-xs btn-success" id="createXLSX"  data-placement="top" data-toggle="tooltip" data-original-title="Export Pianificazione"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>
<button class="btn btn btn-xs btn-success" onclick="manageCamp('','exportpianificazione');" data-placement="top" data-toggle="tooltip" data-original-title="Export Pianificazione"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Export</button>-->
                                            <div class="btn-group">
                                                <button type="button" class="btn btn-success btn-xs"><i class="fa fa-download"></i> Download </button>
                                                <button type="button" class="btn btn-success btn-xs dropdown-toggle" data-toggle="dropdown" aria-expanded="false">
                                                    <span class="caret"></span>
                                                    <span class="sr-only">Toggle Dropdown</span>
                                                </button>
                                                <ul class="dropdown-menu" role="menu">
                                                    <li> <a href="#" onclick="manageCamp('','exportpianificazione');" > Export Pianificazione</a> 
                                                    </li>
                                                    <?php 
                                                    if ($livello_accesso > 1) {
                                                    ?>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onclick="manageCamp('','exportgestione');" > Export Gestione</a>
                                                    </li>
                                                    <?php } ?>
                                                    <li class="divider"></li>
                                                    <li><a href="#" onclick="manageCamp('','exportcapacity');" > Export Campaign Proposal </a>
                                                    </li>
                                                </ul>                                            
                                                
                                            </div>
<?php }?>

</div>
<p style="padding-top: 32px;"></p>
<div class="loader"></div>
<div  style="overflow-y: scroll;max-height: 440px">
<?php

$campaign = new campaign_class();
// print_r($_POST);

$datatable ='pianificazione';
//$filter = $campaign->getFilter();

//echo'prima del render campagne dopo il get_filter';
//print_r($filter);


       //$filter = $_SESSION['filter'];
//$filter = $campaign->reset_filter_session_new();
if(isset($_SESSION['filter'])){
            $filter = $_SESSION['filter'];     
            
            if($datatable=='pianificazione'){
                $list = $campaign->getCampaignsPianificazione($filter); 
            }
            else if($datatable=='gestione'){
                $list = $campaign->getCampaignsGestione($filter); 
            }
            else if($datatable=='gestioneStato'){
                $list = $campaign->getCampaignsGestione($filter); 
            }


            if(count($list)>0  && $datatable=='pianificazione'){
                echo "<script>$('.loader').hide();</script>";
                $campaign->tablePianificazione($list);
                
            }
            else if(count($list)>0  && $datatable=='gestione'){ 
                echo "<script>$('.loader').hide();</script>";
                $campaign->tableGestione($list);
            }
            else if(count($list)>0  && $datatable=='gestioneStato'){ 
                $campaign->tableGestioneStato($list);
            }
            else if(count($list)<=0  && $datatable=='gestione'){ 
                echo " <br><h2>Nessuna Campagna in Gestione !!!</h2><script>$('.loader').hide();</script>";
            }
            else if(count($list)<=0  && $datatable=='pianificazione'){    
                echo " <br><h2>Nessuna Campagna Pianificata !!!</h2><script>$('.loader').hide();</script>";
            }
            else { 
                echo " <br><h2>Nessuna Campagna !!!</h2><script>$('.loader').hide();</script>";
            }

      
        }
elseif(isset($_POST['filter'])){
             $filter = $_POST['filter'];
             if($datatable=='pianificazione'){
                $list = $campaign->getCampaignsPianificazione($filter); 
            }
            else if($datatable=='gestione'){
                $list = $campaign->getCampaignsGestione($filter); 
            }
            else if($datatable=='gestioneStato'){
                $list = $campaign->getCampaignsGestione($filter); 
            }


            if(count($list)>0  && $datatable=='pianificazione'){
                echo "<script>$('.loader').hide();</script>";
                $campaign->tablePianificazione($list);
                
            }
            else if(count($list)>0  && $datatable=='gestione'){ 
                $campaign->tableGestione($list);
            }
            else if(count($list)>0  && $datatable=='gestioneStato'){ 
                $campaign->tableGestioneStato($list);
            }
            else if(count($list)<=0  && $datatable=='gestione'){ 
                echo " <br><h2>Nessuna Campagna in Gestione !!!</h2><script>$('.loader').hide();</script>";
            }
            else if(count($list)<=0  && $datatable=='pianificazione'){    
                echo " <br><h2>Nessuna Campagna Pianificata !!!</h2><script>$('.loader').hide();</script>";
            }
            else { 
                echo " <br><h2>Nessuna Campagna !!!</h2><script>$('.loader').hide();</script>";
            }


        }  
 else{

    $filter2 = $campaign->reset_filter();
    //echo " --------------- Reset avvenuto  ------ ";
    //print_r($filter);   
    //print_r($_SESSION);
            $filter = $_SESSION['filter'];
            if($datatable=='pianificazione'){
                $list = $campaign->getCampaignsPianificazione($filter); 
            }
            else if($datatable=='gestione'){
                $list = $campaign->getCampaignsGestione($filter); 
            }
            else if($datatable=='gestioneStato'){
                $list = $campaign->getCampaignsGestione($filter); 
            }


            if(count($list)>0  && $datatable=='pianificazione'){
                echo "<script>$('.loader').hide();</script>";
                $campaign->tablePianificazione($list);
                
            }
            else if(count($list)>0  && $datatable=='gestione'){ 
                $campaign->tableGestione($list);
            }
            else if(count($list)>0  && $datatable=='gestioneStato'){ 
                $campaign->tableGestioneStato($list);
            }
            else if(count($list)<=0  && $datatable=='gestione'){ 
                echo " <br><h2>Nessuna Campagna in Gestione !!!</h2><script>$('.loader').hide();</script>";
            }
            else if(count($list)<=0  && $datatable=='pianificazione'){    
                echo " <br><h2>Nessuna Campagna Pianificata !!!</h2><script>$('.loader').hide();</script>";
            }
            else { 
                echo " <br><h2>Nessuna Campagna !!!</h2><script>$('.loader').hide();</script>";
            }
    //print_r($filter);
 }   
 
/*
        echo 'dentro Pianificazione DOPO RESET FILTER POST';
        print_r($_POST); 
        echo 'dentro Pianificazione DOPO RESET FILTER SESSION';
        print_r($_SESSION);
*/

//$filter = $campaign->getFilter3();


$righe = count($list)+1;

?>
</div>


<?php $form->close_page(); ?> 

<script>

$('.loader').hide();
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

  $(document).ready(function() {  
      
      //$('.loader').hide();
      
    //$('#datatable-pianificazione').DataTable({
        var table_pianificazione = $('#datatable-pianificazione').DataTable({
            processing: true,
            serverSide: true,
            //deferRender: true,  
            //scrollY: '50vh',
            paging: false,
            //scrollY: "430px",
            //scrollX: true,
            scrollCollapse: true,
            searching: false,
            dom: 'Bfrtip',    
            //deferRender: true,   
            
            ajax: function ( dataSrc, callback, settings ) {
            /*var out = [];
 
            for ( var i=data.start, ien=data.start+data.length ; i<ien ; i++ ) {
                out.push( [ i+'-1', i+'-2', i+'-3', i+'-4', i+'-5' ] );
            }
 */         
                  
            setTimeout( function () {
                callback( {
                    draw: <?php echo $righe; ?>,
                    recordsTotal: <?php echo $righe; ?>,
                    recordsFiltered: <?php echo $righe; ?>,
                } );
            });
            
        },
            buttons: [
           /*     
            {              
              extend: 'colvis',
              className: 'btn-xs btn-primary',
              text: '<i class="fa fa-table"></i> Vista Colonne', 
              titleAttr: 'Seleziona le colonne da visualizzare', 
            }
            */
          
          ],
            
            columnDefs: [
               {
                  className: "dt-head-left",
                },
            /*  
                { 
                    
                  targets: 0,
                  searchable: false,
                  orderable: false,              
                  //width: 35,
              },
              
              {      
                  targets: 1,                   
                  searchable: false,                  
                  orderable: false,
                  visible: false,
              },
              
              */
                         
            ],
          
            //order: [1, 'asc'],            
            //ordering: false,
            ordering: false,

          });
          /*
          $('#table_pianificazione').dataTable( {
              
              'drawCallback': function () {
                      //$( 'table_pianificazione tbody tr td' ).css( 'padding', '0px 0px 0px 0px' );
                    $( 'table_pianificazione tbody tr td' ).css( 'height', '4px');  
                  }
                  
          } );
    */
          //table_pianificazione.columns.adjust().responsive.recalc();
         
         // console.log(' conteggio righe '+ table_pianificazione.rows().count());
          
         
        //var tot_rows = parseInt(table_pianificazione.rows().count());
        var tot_rows = <?php echo $righe; ?>;
          if(tot_rows>0){
            tot_rows = tot_rows-1;
            if(document.getElementById('conteggio_righe')){
             document.getElementById('conteggio_righe').textContent = '   filtrate n°' + tot_rows + '';
             document.getElementById('datatable-pianificazione_info').textContent = ' Campagne filtrate n°' + tot_rows + '';
          }
        }         
         
            
        });

  </script>