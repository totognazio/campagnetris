<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'db_config.php';



class form_class { 

//put your code here
    var $mysqli;
    #var $dati_tacid;

    
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

function head_page($titolo=null, $sottotitolo=null ) {
        ?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $titolo; ?></h3>
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

            
        <!--Open Row page-->    
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2><?php echo $sottotitolo; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 
    <?php                  

} 

function head_page_compat($titolo=null, $sottotitolo=null ) {
        ?>
        <div class="right_col" role="main" >
          <div class="">


            <div class="clearfix"></div>

            
        <!--Open Row page-->    
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                <!--  <div class="x_title">
                    <h2><?php #echo $sottotitolo; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>-->
                  <div class="x_content"> 
    <?php                  

} 

function close_page(){
     ?>            
                    </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->
    <?php
}

function close_row(){
     ?>            
                    </div>
                </div>
              </div>
            </div>

    <?php
}

function open_row($titolo=null, $sottotitolo=null) {
        ?>

        <div class="clearfix"></div>            
        <!--Open Row page-->    
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                      <h2><?php echo $titolo; ?><small><?php echo $sottotitolo; ?></small></h2>

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                   </div>  

                   
                  <div class="x_content"> 
    <?php                  

} 


    
    function stampa_modal($title, $subtitle){
    
        
    ?> 
    <!-- Small modal -->
               <div class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true" style="display: block; padding-right: 17px;">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"><?php echo $subtitle; ?></h4>
                        </div>
                        <div class="modal-body">
                          <h4><?php echo $title; ?></h4>
                         
                          <p><?php echo $subtitle; ?></p>
                         
                          
                        </div>
                          
                        <div class="modal-footer">
                         <form  method="post" action="index.php" />    
                          <!--<button type="button" class="btn btn-default" data-dismiss="modal">Close</button>-->
                          <input type="submit" class="btn btn-primary" name="send" value="Go to Project" />                
                        </form> 
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  <!-- /modals -->
                  
                  
    
    <?php              
                  
    }  
    
    
    //only closed button to presente page
    function stampa_modal_popup($title, $subtitle){
    
        
    ?> 
    <!-- Small modal -->
               <div class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true" style="display: block; padding-right: 17px;">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"><?php echo $subtitle; ?></h4>
                        </div>
                        <div class="modal-body">
                          <h4><?php echo $title; ?></h4>
                         
                          <p><?php echo $subtitle; ?></p>
                         
                          
                        </div>
                          
                        <div class="modal-footer">

                         <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
           
                        </form> 
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  <!-- /modals -->
                  
                  
    
    <?php              
                  
    }  
    
    
    function stampa_modal_delete_project($title, $subtitle){

    ?> 
    <!-- Large modal -->
               <div class="modal fade bs-example-modal-lg in" tabindex="-1" role="dialog" aria-hidden="true" style="display: block; padding-right: 17px;">
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2"><?php echo $subtitle; ?></h4>
                        </div>
                        <div class="modal-body">
                          <h4><?php echo $title; ?></h4>
                         
                          <p><?php echo $subtitle; ?></p>
                         
                          
                        </div>
                          

                        <div class="modal-footer">
                          <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                          <button type="button" class="btn btn-primary">Save changes</button>
                        </div>

           
                        </div>
                      
                      </div>
                    </div>
                  </div>
                  <!-- /modals -->
    <?php              
                  
    } 
    

    function stampa_select($nome_variabile, $lista_variabili, $multi = false, $messaggio = "", $selected = NULL, $javascript = "", $group = "") {
        
        echo "<select   $javascript  name=$nome_variabile ";
        if ($multi)
            echo "  multiple=\"true\" ";
        echo ">";
        if ($messaggio != "")
            echo "<option value=\"\">$messaggio</option>";
        foreach ($lista_variabili as $key => $value) {
            echo "<option ";
            if ($selected != NULL) {
                echo "pippo";
                if (is_array($selected)) {

                    foreach ($selected as $key2 => $value2) {
                        if (strcasecmp($value2,$key) == 0)
                            echo " selected=selected ";
                    }
                } else if (strcasecmp($selected,$key )== 0)
                    echo " selected=selected ";
            }
            echo " value=\"" . $key . "\"> " . $value . " </option>";
        }
        echo "</select>";
    }

//lista variabili è una matrice dove chiave è marca mentre valore array del device
    function stampa_select_group($nome_variabile, $lista_variabili, $multi = false, $messaggio = "", $selected = NULL, $javascript = "", $group = "") {
#print_r($lista_variabili);
        echo "<select   id=textbox1 $javascript name=$nome_variabile";
        if ($multi)
            echo "  multiple=\"true\" ";
        echo ">";
        if ($messaggio != "")
            echo "<option value=\"\">$messaggio</option>";
        foreach ($lista_variabili as $key_marca => $value_marca) {

            echo "<optgroup label=\"" . $key_marca . "\">";
            foreach ($value_marca as $key => $value) {
                echo "<option ";
                if ($selected != NULL) {

                    foreach ($selected as $key2 => $value2) {
                        if ($value2 == $value)
                            echo " selected=selected ";
                    }
                }
                echo " value=\"" . $value . "\"> " . $value . " </option>";
            }
            echo "</optgroup>";
        }
        echo "</select>";
    }

        
    function stampa_select_model($selezione="",$vendor=null, $devicetype=null) {
        //$selezione = "";
        if (isset($_POST['model_select'])){
            $selezione = array($_POST['model_select']);
        }    
        $lista_modelli = $this->get_models($vendor, $devicetype);
        #print_r($lista_modelli);
        #$lista_top_vendor = array("All" => "All") + $lista_top_vendor;
        //array_unshift($lista_top_vendor, "All");
        $checked_newmodel = '';
        $value_new = '';
        if (isset($_POST['filtro_newmodel'])) {
            $checked_newmodel = 'checked';           
            if(isset($_POST['newmodel']) && !empty($_POST['newmodel'])) {
                $value_new = $_POST['newmodel'];
            } 
            #else $checked_newmodel = '';
        }    
        ?>
        <br>
        <h2>Select Model</h2><label><input type="checkbox" onclick="this.form.submit()" name="filtro_newmodel" <?php echo $checked_newmodel; ?>  value="1">Type temporary Model's name</label>
        
        <?php if (isset($_POST['filtro_newmodel'])){ ?>
          
        <input type="text" name="newmodel" size="40" class="form-control col-md-10" placeholder="type the temporary name here" value="<?php echo $value_new; ?>"/>
        <br><br>       
        <?php } else {
        #echo"<h2>Select Model</h2>";
        $this->stampa_select("model_select", $lista_modelli, false, "", $selezione, " required=\"required\"  class=\"select2_single form-control\" onchange=\"this.form.submit();\" ");
        }
        
      }
    
    //senza input type new_model  
    function stampa_select_model_basic($vendor=null, $devicetype=null) {
        $selezione = "";
        if (isset($_POST['model_select'])){
            $selezione = array($_POST['model_select']);
        }    
        $lista_modelli = $this->get_modelsByprojects($vendor, $devicetype);
        #print_r($lista_modelli);
        #$lista_top_vendor = array("All" => "All") + $lista_top_vendor;
        //array_unshift($lista_top_vendor, "All");
 
        ?>
        <br>
      
        <h2>Select Model</h2><label>
        <?php

        $this->stampa_select("model_select", $lista_modelli, false, "", $selezione, " class=\"select2_single form-control\" \" ");
    
     
    }  
    
    
    function stampaMultiSelect($nome_variabile, $query, $nome_campo,$id_campo = NULL, $messaggio = "", $selected = NULL, $js_name, $nome_group=NULL) {

    #echo "<select class=\"form-control\" style=\"clear: both; height:200px;\" id=textbox1 $javascript name=$nome_variabile";
    echo "<select id=\"$js_name\" name=\"$nome_variabile\" multiple=\"multiple\" >";

//$query="select nome_tabella from lista_tabelle";
    //echo $query;
    $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
    #echo "<option value=\"\">$messaggio</option>";
    $vendor_first = "";
    $count = 0;
    while ($obj3 = mysqli_fetch_array($result)) {

        if($nome_group != NULL){
            $vendor_name = ucwords(mb_strtolower($obj3[$nome_group]));
            if ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count > 0))
                echo "</optgroup><optgroup label=\"$vendor_name\">";
            elseif ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count == 0)) {
                echo "<optgroup label=\"$vendor_name\">";
            }
            $count++;
            $vendor_first = $vendor_name;
        }    

        if ($id_campo == NULL)
            $value = $nome_campo;
        else
            $value = $id_campo;

        echo "<option ";
        if ($selected != NULL) {

            if (count($selected) == 1) {
                if ($selected[0] == $obj3[$value])
                    echo " selected=selected ";
            } else
                for ($i = 0; $i < count($selected); $i++) {

                    if ($selected[$i] == $obj3[$value])
                        echo " selected=selected ";
                }
        }
        $campo = $obj3[$nome_campo];
        #$campo = ucwords(mb_strtolower($obj3[$nome_campo]));
        echo " value=\"" . $obj3[$value] . "\"> " . $campo . " </option>";

    }
    echo "</select></div></div>";
}


  function stampaMultiSelect2($nome_variabile, $array_select,$nome_campo,$id_campo = NULL, $messaggio = "", $selected = NULL, $js_name, $nome_group=NULL) {
    
    
    #echo "<select class=\"form-control\" style=\"clear: both; height:200px;\" id=textbox1 $javascript name=$nome_variabile";
    echo "<select id=\"$js_name\" name=\"$nome_variabile\" multiple=\"multiple\" >";

    /*
    
//$query="select nome_tabella from lista_tabelle";
    //echo $query;
    $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
    #echo "<option value=\"\">$messaggio</option>";
    $vendor_first = "";
    $count = 0;
    while ($obj3 = mysqli_fetch_array($result)) {

        if($nome_group != NULL){
            $vendor_name = ucwords(mb_strtolower($obj3[$nome_group]));
            if ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count > 0))
                echo "</optgroup><optgroup label=\"$vendor_name\">";
            elseif ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count == 0)) {
                echo "<optgroup label=\"$vendor_name\">";
            }
            $count++;
            $vendor_first = $vendor_name;
        }    

        if ($id_campo == NULL)
            $value = $nome_campo;
        else
            $value = $id_campo;

        echo "<option ";
        if ($selected != NULL) {

            if (count($selected) == 1) {
                if ($selected[0] == $obj3[$value])
                    echo " selected=selected ";
            } else
                for ($i = 0; $i < count($selected); $i++) {

                    if ($selected[$i] == $obj3[$value])
                        echo " selected=selected ";
                }
        }
        $campo = $obj3[$nome_campo];
        #$campo = ucwords(mb_strtolower($obj3[$nome_campo]));
        echo " value=\"" . $obj3[$value] . "\"> " . $campo . " </option>";

    }
    */
    echo "</select></div></div>";
     
    
}



    
    
    function stampa_page_title($title){
          echo'<div class="page-title">
              <div class="title_left">
                <h3>'.$title.'</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>
                </div>
              </div>
            </div>';  
    }
    
    
    function stampa_page_row($title){
        echo'<div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
                    <h2>'.$title.' <small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      
                      
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">
                    <br>';
    } 


    
    function stampa_widjetProjectTitle($subtitle, $title, $icon, $filter_rfi=null, $id_project=null){
        if(empty($icon)) {$icon = "fa fa-mobile";}   
        if(empty($subtitle)) {$subtitle = " ---- ";} 

        ?>
                       <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="<?php echo $icon; ?>"></i>
                          </div>
                            
                            <h1><center><b><?php echo $title; ?></b></center></h1>  
                            <h3><center><?php echo $subtitle ?></center></h3>
                          <?php #echo $title; 
                          
       if($filter_rfi) { 
        $checked_mdm = '';
        if (isset($_POST['filtro_mdm']) && $_POST['filtro_mdm']==1) {
            $checked_mdm = 'checked';
        }else $checked_mdm = '';
        
        $checked_5gBands = '';
        if (isset($_POST['filter_5gBands']) && $_POST['filter_5gBands']==1) {
            $checked_5gBands = 'checked';
        }else $checked_5gBands = '';
        
        
        
        ?>  <form id="form5" action="<?php echo $_SERVER['REQUEST_URI']; ?>" method="post" enctype="multipart/form-data" />
                <input type="hidden" name="pr" value="<?php echo $id_project;?>" />             
                
                <label class="col-md-6 col-sm-6 col-xs-6 control-label">View also 5G Bands combination requirements
                          <input type="checkbox" class="js-switch" onclick="this.form.submit()" name="filter_5gBands" <?php echo $checked_5gBands; ?>  value="1">
                </label> 
                <label class="col-md-6 col-sm-6 col-xs-6 control-label">MDM Requirements Only
                          <input type="checkbox" class="js-switch" onclick="this.form.submit()" name="filtro_mdm" <?php echo $checked_mdm; ?>  value="1">
                </label> 

            </form>    
        <?php  
        }
                          
                          
                          ?>
                          
                        </div>
                      </div>
    

        <?php        
    }
    
    function stampa_widjetProjectProgressBKP ($owner, $userVendor, $icon, $project, $tot_mandatory, $tot_mandatoryEmpty){
        if(isset($tot_mandatory) and isset($tot_mandatoryEmpty)){
           $tot_filled = $tot_mandatory-$tot_mandatoryEmpty; 
        }
        
        if(!isset($icon)) {$icon = "fa fa-user";}       
        if(!isset($owner))$owner = "No owner";
        if(!isset($userVendor))$userVendor = "Not assigned";
        ?>
                       <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="<?php echo $icon; ?>"></i>
                          </div>
                            <div class="count"><?php echo $userVendor; ?>
                            

                            
                            </div>

                          <h3><?php echo $owner; ?>                            
                          </h3><span id="progresscount"><?php  echo $tot_filled.'/'.$tot_mandatory ?></span>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                            <div class="progress progress_wide">
                              <div id="progressbar" class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php  echo $project['progress']; ?>" aria-valuenow="44" style="width: <?php  echo $project['progress']; ?>%;"></div>
                            
                            </div>
                                
                           </div>

                        </div>
                      </div>
        <?php        
    }
    
        
    function stampa_widjetProjectProgress ($owner, $userVendor, $icon, $project, $tot_mandatory, $tot_mandatoryFilled){
        /*
        if(isset($tot_mandatory) and isset($tot_mandatoryEmpty)){
           $tot_filled = $tot_mandatory-$tot_mandatoryEmpty; 
        }
         * 
         */
        
        if(!isset($icon)) {$icon = "fa fa-user";}       
        if(!isset($owner))$owner = "No owner";
        if(!isset($userVendor))$userVendor = "Not assigned";
        ?>
                       <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="<?php echo $icon; ?>"></i>
                          </div>
                            <div id="progress_completed" class="count" ><?php echo $userVendor; ?>
                            

                            
                            </div>

                          <h3><?php echo $owner; ?>                            
                          </h3><span id="progresscount"><?php  echo $tot_mandatoryFilled.'/'.$tot_mandatory ?></span>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                            <div class="progress progress_wide">
                              <div id="progressbar" class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php  echo $project['progress']; ?>" aria-valuenow="44" style="width: <?php  echo $project['progress']; ?>%;"></div>
                            
                            </div>
                                
                           </div>

                        </div>
                      </div>
        <?php        
    }
    
      
    
    function stampa_widjetPrjSum ($owner, $userVendor, $icon, $user_email=null){
        
        if(!isset($icon) || empty($icon)) {$icon = "fa fa-user";}       
        if(!isset($owner))$owner = "No owner";
        if(!isset($userVendor))$userVendor = "Not assigned";
        ?>
                       <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="<?php echo $icon; ?>"></i>
                          </div>
                            <div class="count">
                                <a href="mailto:<?php echo $user_email; ?>" title="Send mail"><?php echo $userVendor; ?></a>
                                </div>

                          <h3><?php echo $owner; ?></h3>
                          <p><?php #echo $title; ?></p>
                        </div>
                      </div>
        <?php        
    }
    
    function stampa_widjetStatus ($subtitle, $project, $user_id){
        
        $statusName = $this->get_statusNameByLevel($project['status_id']);
        $job_role = $this->get_user_info($user_id)['group_level'];
        
        if(!isset($owner))$owner = "No owner";
        if(!isset($statusName))$statusName = "Not assigned";
        ?>
                       <div class="animated flipInY col-lg-6 col-md-6 col-sm-6 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="fa fa-tasks"></i>
                          </div>
                            <div class="count"><?php echo $statusName; ?></div>
                          <h3><?php echo $subtitle; ?>
                 <?php if($job_role > 6) { ?>                       
                              <center>
                               <button type="button" class="btn btn-success btn-lg" data-toggle="modal" data-target="#myModal"><i class="fa fa-exchange"></i> Change Status</button>
                               <a href="export_file_excel.php?funzione=export_LSoc&devicetype=<?php echo $project['devicetype']; ?>&colorline=yellow" class="btn btn-primary btn-lg"><i class="fa fa-download"></i> Download empty RFI</a>
                               <button type="button" class="btn btn-info btn-lg" <?php #echo $disable; ?> data-toggle="modal" data-target="#importModal"><i class="fa fa-upload"></i> Upload RFI</button>
                              </center>
                       <?php }
                 // se utente vendor e stato assegnato al vendor -->     
                  elseif(($job_role == 6)  && $project['status_id']=='2'){ 
                  // Small modal -->
                     if($project['progress'] > 0) {$disable='';} 
                     else $disable= 'disabled="true"';

                    ?>
                  
                  <center>
                      <button type="button" class="btn btn-success btn-lg" <?php echo $disable; ?> data-toggle="modal" data-target=".bs-example-modal-sm"> Send RFI to WindTre</button>
                       <a href="export_file_excel.php?funzione=export_LSoc&devicetype=Smartphone&colorline=yellow" class="btn btn-primary btn-lg"><i class="fa fa-download"></i> Download empty RFI</a>
                   <button type="button" class="btn btn-info btn-lg" <?php #echo $disable; ?> data-toggle="modal" data-target="#importModal"><i class="fa fa-upload"></i> Upload RFI</button>
                  
                             
                  </center>
                 <?php } ?>            
                         
                          </h3>
                          <p><?php #echo $title; ?></p>

                        </div>                                           


                      </div>
        <?php        
    }
    
    function dropdown_button(){        
        //$permission = $page_protect->check_permission($row['department_id']);
        $string='<div class="btn-group"><button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button" aria-expanded="false"><i class="fa fa-gear"></i> Azioni <span class="caret"></span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                    <li class="divider"></li>
                      <li><a href="#">Modifica Campagna</a>
                      </li>
                      <li class="divider"></li>
                      <li><a href="#">Duplica Campagna</a>
                      </li>
                      <li class="divider"></li>
                      <li><a href="#">Elimina Campagna</a>
                      </li>
                    </ul></div>';
        return $string;
                          
    }
    
    function add_button(){        
        //$permission = $page_protect->check_permission($row['department_id']);
        $string='<div class="btn-group"><button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-sm" type="button" aria-expanded="false"><i class="fa fa-gear"></i> Azioni <span class="caret"></span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                    <li class="divider"></li>
                      <li><a href="#">Modifica Campagna</a>
                      </li>
                      <li class="divider"></li>
                      <li><a href="#">Duplica Campagna</a>
                      </li>
                      <li class="divider"></li>
                      <li><a href="#">Elimina Campagna</a>
                      </li>
                    </ul></div>';
        return $string;
                          
    }
    
     
    function display_giorni($value_db, $current, $modifica=Null){
        if(isset($modifica) and $modifica==true){
            if($value_db==$current) {
                echo  ' selected';        
            }else {
                echo  ''; 
            }
        }
        else{
            if($value_db==$current) {
                echo  ' selected';        
            }else {
                echo  ''; 
            }
        }
        
    }
    

    

     function selected_value($value_db, $current){

            if($value_db==$current) {
                echo  ' selected';        
            }else {
                echo  ''; 
            }
    }
    
    
    function input_value($modifica, $campagna_value, $defaul_val=Null){
        if($modifica) {
            echo $campagna_value;        
        }
        elseif(isset($defaul_val)){
            echo $defaul_val;
        }
        else {
            echo ''; 
        }
        
    }
    
    function get_value($modifica, $campagna_value, $defaul_val=Null){
        if($modifica) {
            return $campagna_value;        
        }
        elseif(isset($defaul_val)){
            return $defaul_val;
        }
        else {
            return ''; 
        }
        
    }

}

    
    
