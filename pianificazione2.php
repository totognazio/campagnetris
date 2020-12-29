<style type="text/css">
            
                tr:hover {
                background-color: lightgreen;
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
$sprints = $funzione->get_sprints();
// print_r($sprints);
$form->head_page("Pianificazione Campagne", "Filtro");
//print_r($_SESSION);  
//print_r($_POST); 
                
                if (isset($result)) {
                    echo "<div class=\"info\">";
                    echo "<h2 style=\"color: #ff0000\">" . $result . "</h2>";
                    echo "</div>";
                }
              

?>
                    <br>
                  <div class="well" style="overflow: auto">
                                
                      <div class="col-md-6 col-sm-6 col-xs-12"><h4>Date Range</h4>
                        <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          <span id="datarange">December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                      </div>
                     <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Sprint</h4>
                             <select id="sprints" name="sprints" class="select2_single form-control">        
                              <option value=""></option>
                            <?php 
                            foreach ($sprints as $key => $value) {
                                echo '<option value="'.$key.'">'.$value['name'].'</option>';
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
                            </div>
               
 
                    <br><br>
<div class="loader"></div>                       
                    
<?php 
$form->close_row();
$form->open_row("Campagne", "Filtrate");
?>
<!--button add new campaign -->
                <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaNew"> 
                            <input type="hidden" name="azione" value="new" />  
                            <input type="hidden" name="id" value="0" />                                                              
                </form> 
<button class="btn btn btn-xs btn-success" type="submit" onclick="manageCamp('','new');" data-placement="top" data-toggle="tooltip" data-original-title="Inserisci nuova Campagna"><i class="fa fa-plus-square"></i> Nuova Campagna</button>
<!--button add new campaign -->
<div class="col-md-12 col-sm-12 col-xs-12" id="content_response">


</div>

<?php $form->close_page(); ?> 

<script>
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