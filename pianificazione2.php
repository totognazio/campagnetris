<style type="text/css">
            
                tr:hover {
                background-color: lightgreen;
                color: black;
                }
 </style>  
<!-- bootstrap-daterangepicker -->
<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
<?php $random=  rand(); ?>
<script type="text/javascript" src="javascript_controlla_form_insert.js<?php echo "?".$random; ?>"></script>    

<?php
include_once './classes/form_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';

$form = new form_class();
$funzione = new funzioni_admin();
$campaign = new campaign_class();

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
// print_r($_POST); 

?>

                    <br>
                   
                        
                            <div class="well" style="overflow: auto">
                                
                      <div class="col-md-8"><h4>Date Range</h4>
                        <div id="reportrange_right" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                          <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                          <span id="datarange">December 30, 2014 - January 28, 2015</span> <b class="caret"></b>
                        </div>
                      </div>
                               
                      <div class="col-md-4"><h4>Sprint</h4>
                    
                        <!--<label class="control-label col-md-3 col-sm-3 col-xs-12">Categoria  <span class="required">*</span></label>-->
                        <?php #print_r($stacks); ?>
                        <div class="col-md-12 col-sm-12 col-xs-12">
                            <select id="cate_ins" name="select_cate[]" class="select2_single form-control" required="required">        
                              <option value=""></option>
                            <?php 
                            foreach ($sprints as $key => $value) {
                                echo '<option value="'.$key.'">'.$value['name'].'</option>';
                            }                                                  
                            ?>  
                          </select>
                        </div>
                      
                      </div>
              
                                
                                
                            </div>
                    <div class="col-md-12">
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Stacks</h4>
                                <select id="stacks" name="select_stacks[]" multiple="multiple">
                                   <?php
                                   echo $campaign->multiselect_session($stacks, $_SESSION['filter']['stacks']);
                                    ?>
                                </select>
                            </div>


                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Squads</h4>
                                <select id="squads" name="select_squads[]" multiple="multiple">
                                   <?php
                                   echo $campaign->multiselect_session($squads, $_SESSION['filter']['squads']);
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Channels</h4>
                                <select id="channels" name="selct_channels[]" multiple="multiple">
                                   <?php
                                   echo $campaign->multiselect_session($channels, $_SESSION['filter']['channels']);
                                    ?>
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>States</h4>
                                <select id="states" name="select_states[]" multiple="multiple">
                                   <?php
                                    echo $campaign->multiselect_session($states, $_SESSION['filter']['states']);
                                    ?>                                 
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-2 col-xs-12">
                                <h4>Typlogies</h4>
                                <select id="typologies" name="select_typologies[]" multiple="multiple">
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
<div class="col-md-12 col-sm-12 col-xs-12" id="content_response">


</div>

<?php $form->close_page(); ?> 

    