<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once 'db_config.php';

include_once './classes/dati_tacid_class.php';


class form_class extends dati_tacid_class { 

//put your code here
    var $mysqli;
    #var $dati_tacid;

    
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
                        if ($value2 == $key)
                            echo " selected=selected ";
                    }
                } else if ($selected == $key)
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

    
    function stampa_select_tipodevice($nome_variabile, $lista_variabili, $multi = false, $messaggio = "", $selected = NULL, $javascript = "", $group = "") {
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

    
    
    function get_indicatore() {
        ?>

        <label for="selector1" class="col-sm-2 control-label">Indicatore</label>
        <div class="col-sm-4"><select name="dato" id="selector1" class="form-control">
                <?php
                $lista_dato = array('numero_ter' => '# TERMINALI',
                    'numero_ter_LTE' => 'TERMINALI con traffico LTE>0',
                    'roaming' => 'Roaming',
                    'drop' => 'Drop',
                    'dati' => 'Usage dati',
                    'dati_totale_LTE' => 'DATI TOTALE LTE',
                    'dati_totale_3g_di_device_LTE_mag_0' => 'DATI 3G dei terminali LTE con traffico >0',
                    'dati_totale' => 'DATI TOTALE',
                    'voce' => 'USAGE VOCE',
                    'voce_totale' => 'VOCE TOTALE',
                    'PDP' => 'PDP',
                    'chiamate_non_risposte' => 'Chiamate non risposte');
                /*$lista_dato = array('numero_ter' => '# TERMINALI',
                    'numero_ter_LTE' => 'TERMINALI con traffico LTE>0',
                    'dati' => 'Usage dati',
                    'dati_totale_LTE' => 'DATI TOTALE LTE',
                    'dati_totale_3g_di_device_LTE_mag_0' => 'DATI 3G dei terminali LTE con traffico >0',
                    'dati_totale' => 'DATI TOTALE',
                    'voce' => 'USAGE VOCE',
                    'voce_totale' => 'VOCE TOTALE');
                */    
                if (isset($_POST['dato'])) {
                    $dato = $_POST['dato'];
                } else
                    $dato = NULL;
                foreach ($lista_dato as $key => $value) {
                    echo "   <option value='$key'";
                    if ($dato == $key) {
                        echo " selected ";
                    }
                    echo ">$value</option>";
                }
                ?>
            </select></div>
        <?php
    }

    function get_filtro_piano() {
        ?>

        <div class="col-sm-6">
            <?php
            $filtro_piano_checked_PRE = $filtro_piano_checked_POST = "";
            $filtro_piano_checked_S = " checked=checked ";
            if (isset($_POST['filtro_piano'])) {
                if ($_POST['filtro_piano'] == "PRE") {
                    $filtro_piano_checked_PRE = " checked=checked ";
                } elseif ($_POST['filtro_piano'] == "POST") {
                    $filtro_piano_checked_POST = " checked=checked ";
                } else {
                    $filtro_piano_checked_S = " checked=checked ";
                }
            }
            ?>
            <div class="radio-inline"><label><input type="radio" name="filtro_piano" <?php echo $filtro_piano_checked_S; ?> value="S">Totale Device</label></div>
            <div class="radio-inline"><label><input type="radio"  name="filtro_piano" <?php echo $filtro_piano_checked_PRE; ?>  value="PRE">Device prepagati</label></div>
            <div class="radio-inline"><label><input type="radio"  name="filtro_piano" <?php echo $filtro_piano_checked_POST; ?>  value="POST">Device postpagati</label></div>
        </div>
        <?php
    }

    function get_lista_Mesi($condizione = "", $lista = true) {
        ?>

        <!--<div class="col-sm-2">
            <label class=" control-label"><b>Intervallo temporale</b></label>
            <br>-->
            <?php
            if (isset($_POST['tabella_name']))
                $selezionati = $_POST['tabella_name'];
            else
                $selezionati = "";
            if ($lista) {
                $nome_variabile = "tabella_name[]";
                $dimensioni = "class=\"select2_multiple form-control select2-hidden-accessible\" style=\"height:250px; width: 130px;\"";
                #$dimensioni = "";
            } else {
                $nome_variabile = "tabella_name";
                $dimensioni = "class=\"select2_multiple form-control select2-hidden-accessible\"  style=\"height: 35px;width: 130px\"";
                #$dimensioni = "";
            }
            $lista_tabelle = $this->get_lista_tabelle($condizione);
            $this->stampa_select($nome_variabile, $lista_tabelle, $lista, "", $selezionati, $dimensioni);
            ?>
       
        <?php
    }

    function _condizione_tipo_terminale($paramentro_di_gruppo = "") {
        $condizione_tipo_terminale = "where (Tecnologia='n/a' or Tecnologia='Handset' or Tecnologia='Tablet' or Tecnologia='Datacard' or Tecnologia='MBB' or Tecnologia='Phablet' ) ";
        if ($paramentro_di_gruppo == "Marca" or $paramentro_di_gruppo == "Modello") {
            if (!isset($_POST['filtro_handset']) and ! isset($_POST['filtro_MBB']) and ! isset($_POST['filtro_tablet'])) {
                $condizione_tipo_terminale = "where (Tecnologia='Handset' ) ";
            } else {
                $condizione_tipo_terminale = "";
                if (isset($_POST['filtro_MBB']))
                    $condizione_tipo_terminale = $condizione_tipo_terminale . " (Tecnologia='MBB' or Tecnologia='Datacard') or ";
                if (isset($_POST['filtro_handset']))
                    $condizione_tipo_terminale = $condizione_tipo_terminale . " (Tecnologia='Handset' or Tecnologia='Phablet') or";
                if (isset($_POST['filtro_tablet']))
                    $condizione_tipo_terminale = $condizione_tipo_terminale . " (Tecnologia='Tablet') or";
                $condizione_tipo_terminale = "(" . substr($condizione_tipo_terminale, 0, -3) . ")";
                if (isset($_POST['filtro_WEBFAMILY']))
                    $condizione_tipo_terminale = $condizione_tipo_terminale . " and (`webfamily` = 1) ";
                $condizione_tipo_terminale = " where ( " . $condizione_tipo_terminale . ")";
            }
        }
        return $condizione_tipo_terminale;
    }

    function get_tipo_device() {
        $checked_handset = '';
        $checked_MBB = ' ';
        $checked_tablet = ' ';
        if (!isset($_POST['filtro_handset']) and ! isset($_POST['filtro_MBB']) and ! isset($_POST['filtro_tablet'])) {
            $checked_handset = 'checked';
        } else {
            if (isset($_POST['filtro_MBB']))
                $checked_MBB = ' checked ';
            if (isset($_POST['filtro_handset']))
                $checked_handset = 'checked';
            if (isset($_POST['filtro_tablet']))
                $checked_tablet = ' checked ';
        }
        ?>
                <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()" name="filtro_handset" <?php echo $checked_handset; ?>  value="1">Handset</label></div>
                <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()"   name="filtro_MBB" <?php echo $checked_MBB; ?>  value="1">MBB</label></div>
                <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()"   name="filtro_tablet" <?php echo $checked_tablet; ?>  value="1">Tablet</label></div>

        <?php
    }
    
    function stampa_checkbox_newmodel() {
        $checked_newmodel = '';
        if (isset($_POST['filtro_newmodel'])) {
            $checked_newmodel = 'checked';
        }
        ?>
        <label><input type="checkbox" onclick="this.form.submit()" name="filtro_newmodel" <?php echo $checked_newmodel; ?>  value="1">New model</label>
        <?php
    }
    


    function stampa_select_top_vendor() {
        $selezione_tariffa = "";
        if (isset($_POST['vendor_select']))
            $selezione_tariffa = array($_POST['vendor_select']);

        $lista_top_vendor = $this->get_top_vendor();
        $lista_top_vendor = array("All" => "All") + $lista_top_vendor;
        //array_unshift($lista_top_vendor, "All");
        echo"<h2>Select Vendor</h2>";
        $this->stampa_select("vendor_select", $lista_top_vendor, false, "", $selezione_tariffa, "  onchange=\"this.form.submit()\" class=\"select2_group form-control\"");
    }
    
    function stampa_select_all_vendor($selezione="") {
        //$selezione = "";
        if (isset($_POST['vendor_select']))
            $selezione = array($_POST['vendor_select']);

        $lista_top_vendor = $this->get_all_marca();
        #print_r($lista_top_vendor);
        #$lista_top_vendor = array("All" => "All") + $lista_top_vendor;
        //array_unshift($lista_top_vendor, "All");
        echo"<h2>Select Vendor</h2>";
        $this->stampa_select("vendor_select", $lista_top_vendor, false, "", $selezione, "  class=\"select2_single form-control\" onchange=\"this.form.submit();\" ");
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
    
    function stampa_select_devicetype() {
        $selezione = "";
        if (isset($_POST['devicetype_select']))
            $selezione = array($_POST['devicetype_select']);

        $lista_modelli = $this->get_tipo();
        #print_r($lista_top_vendor);
        $lista_modelli = array("" => "---") + $lista_modelli;
        //array_unshift($lista_top_vendor, "All");
        echo"<br><h2>Select Device Type</h2>";
        $this->stampa_select("devicetype_select", $lista_modelli, false, "", $selezione, " required=\"required\"  class=\"select_single form-control\" onchange=\"this.form.submit();\" ");
    }
    
    function stampa_select_user($vendor=null, $job_roles_id=null) {
        $selezione = "";
       
        if (isset($_POST['user_select']))
            $selezione = array($_POST['user_select']);

        $lista_user = $this->get_user($vendor, $job_roles_id);
        #print_r($lista_user);
        $lista_user = array("null" => "---") + $lista_user;
        //array_unshift($lista_top_vendor, "All");
        echo"<h2>Select Owner</h2>";
        $this->stampa_select("user_select", $lista_user, false, "", $selezione, "   class=\"select_single form-control\" onchange=\"this.form.submit();\" ");
    }
    
    function stampa_select_vendor_user($vendor=null, $job_roles_id=null) {
        $selezione = "";
       
        if (isset($_POST['uservendor_select']))
            $selezione = array($_POST['uservendor_select']);

        $lista_user = $this->get_user($vendor, $job_roles_id);
        #print_r($lista_user);
        $lista_user = array("null" => "---") + $lista_user;
        //array_unshift($lista_top_vendor, "All");
        echo"<h2>Select Vendor User</h2>";
        $this->stampa_select("uservendor_select", $lista_user, false, "", $selezione, "   class=\"select_single form-control\" onchange=\"this.form.submit();\" ");
    }
    
    function stampa_select_status($status=null) {
        $selezione = "";
       
        if (isset($_POST['status_select']))
            $selezione = array($_POST['status_select']);

        $lista = $this->get_status_list();
        #print_r($lista_user);
        #$lista = array(0 => "---") + $lista;
        #$lista = array(0 => "---") + $lista;
        //array_unshift($lista_top_vendor, "All");
        echo"<h2>Select Project's Status </h2>";
        $this->stampa_select("status_select", $lista, false, "", $selezione, "   class=\"select_single form-control\" onchange=\"this.form.submit();\" ");
    }

    function get_piano_tariffario($condizione_tipo_terminale) {
        if (isset($_POST['tariffa_select']))
            $selezione_tariffa = array($_POST['tariffa_select']);
        else
            $selezione_tariffa = "";
        $lista_tariffa = $this->get_lista_tariffa($condizione_tipo_terminale);
        $lista_tariffa = array("All" => "All") + $lista_tariffa;
        ?>
        <div class="form-group">
            <label class = "col-sm-3 control-label">Piano Tariffario</label>
            <div class = "col-sm-9 ">
                <?php
                $this->stampa_select("tariffa_select", $lista_tariffa, false, "", $selezione_tariffa, "   class=\"form-control1\" style=\"height: 30px;width: 150px;\"");
                ?>
            </div>
        </div>
        <?php
    }

    
    function stampa_select_requisiti($nome_variabile, $lista_variabili, $multi = false, $messaggio = "", $selected = NULL, $javascript = "", $group = "") {
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
                        if ($value2 == $key)
                            echo " selected=selected ";
                    }
                }
                echo " value=\"" . $key
                        . "\">[".$key."]  " . $value . " </option>";
            }
            echo "</optgroup>";
        }
        echo "</select>";
    }

	
    
    function get_webfamily() {
        if (isset($_POST['filtro_MBB'])) {
            if ($_POST['filtro_MBB'] == 1) {
                if (isset($_POST['filtro_WEBFAMILY'])) {
                    if ($_POST['filtro_WEBFAMILY'] == 1)
                        $checked = " checked=checked ";
                } else
                    $checked = "";
                ?>

      <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()" <?php echo $checked; ?>  name="filtro_WEBFAMILY" value="1">WEBFAMILY</label></div>

                <?php
            }
        }
    }
    
    function stampa_select_classeT() {
        if (isset($_POST['classeT_select']))
            $classeT_select = $_POST['classeT_select'];
           
        $db_link = connect_db_li();
        $query = "SELECT  `classe_throughput` FROM  `dati_tacid` GROUP BY  `classe_throughput` ";
        $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        echo "<h2>Select throughtput class</h2><select class=\"select2_group form-control\"  name=\"classeT_select\" onchange=\"this.form.submit()\">";
        if ($classeT_select == "All")
            echo "<option selected value=\"All\">---- All ----</option>";
        else
            echo "<option value=\"All\">---- All ----</option>";
        while ($obj = mysqli_fetch_array($result)) {
            if ($classeT_select == $obj['classe_throughput'])
                echo "<option selected value=\"" . $obj['classe_throughput'] . "\" >" . $obj['classe_throughput'] . "</option>";
            else
                echo "<option value=\"" . $obj['classe_throughput'] . "\" >" . $obj['classe_throughput'] . "</option>";
        }
        echo "</select>";
    }
    
    function checkbox_tipo_device() {
        $checked_handset = '';
        $checked_MBB = ' ';
        $checked_tablet = ' ';
        if (!isset($_POST['filtro_handset']) and ! isset($_POST['filtro_MBB']) and ! isset($_POST['filtro_tablet'])) {
            $checked_handset = 'checked';
        } else {
            if (isset($_POST['filtro_MBB']))
                $checked_MBB = ' checked ';
            if (isset($_POST['filtro_handset']))
                $checked_handset = 'checked';
            if (isset($_POST['filtro_tablet']))
                $checked_tablet = ' checked ';
        }
        ?>
                <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()" name="filtro_handset" <?php echo $checked_handset; ?>  value="1">Handset</label></div>
                <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()"   name="filtro_MBB" <?php echo $checked_MBB; ?>  value="1">Router</label></div>
                <div class="radio-inline"><label><input type="checkbox" onclick="this.form.submit()"   name="filtro_tablet" <?php echo $checked_tablet; ?>  value="1">Tablet</label></div>

        <?php
    }
    
    
    function stampa_select_citta($citta){
        #echo '<div class="form-group">';
        
        $lista_capoluoghi = array('Roma', addslashes('L\'Aquila'), 'Potenza', 'Catanzaro', 'Napoli', 'Bologna', 'Trieste', 'Genova', 'Milano', 'Ancona', 'Campobasso', 'Torino', 'Bari', 'Cagliari', 'Palermo', 'Firenze', 'Trento', 'Perugia', 'Aosta', 'Venezia');  
        
        echo '<div class="col-md-4 col-sm-6 col-xs-12"><h2>Select Città</h2>';
        stampa_select_array('citta', $lista_capoluoghi, null, false, null, "", array($citta), "class=\"select2_group form-control\" onchange=\"this.form.submit()\"");
        echo "</div>";
    }
    
    function stampa_select_scala_grafico($selected_scala){
        #echo '<div class="form-group">';
        
        #$scala = array(1=>'0.001', 5=>'0.005', 10=>'0.01', 50=>'0.05', 100=>'0.1', 500=>'0.5', 1000=>'1');  
        #$scala = array(100=>'0.1', 500=>'0.5', 1000=>'1');  
        #$scala = array(500=>'0.5', 1000=>'1',3000=>'3',5000=>'5');
        $scala = array(500=>'0.5', 1000=>'1'); 
        #echo '<div class="col-md-3 col-sm-6 col-xs-12"><h2>Scala temporale in Secondi</h2>';
        $this->stampa_select_generica('val_scala', $scala,false, null, "", $selected_scala, "class=\"select2_group form-control\" onchange=\"this.form.submit()\"");
        #$this->stampa_select_generica('val_scala', $scala,false, null, "", $selected_scala, "class=\"select2_group form-control\"\"");
        #echo "</div>";
  
    }
    
    function stampa_select_file_parsed($json_filelist, $file_selected){

        #echo '<div class="col-md-3 col-sm-6 col-xs-12"><h2>Scala temporale in Secondi</h2>';
        $this->stampa_select_generica('selected_json', $json_filelist,false, null, "", $file_selected, "class=\"select2_group form-control\" onchange=\"this.form.submit()\"");
        #$this->stampa_select_generica('val_scala', $scala,false, null, "", $selected_scala, "class=\"select2_group form-control\"\"");
        #echo "</div>";
  
    }
    
    function stampa_select_generica($nome_variabile, $option_list,$multi = false, $id_campo = NULL, $messaggio = "", $selected = NULL, $javascript = "") {
        $db_link = connect_db_li();
        #echo "selected ".$selected;
        echo "<select class=\"select2_group form-control\"   id=textbox1  $javascript name=$nome_variabile";
        if ($multi)
            echo "  multiple=\"true\" ";
        echo ">";

        #echo "<option value=\"\">$messaggio</option>";
        foreach ($option_list as $key => $value) {

            echo "<option ";
            if ($selected != NULL) {

                if (count($selected) == 1) {
                    if ($selected[0] == $value)
                        echo " selected=selected ";
                } else
                    for ($i = 0; $i < count($selected); $i++) {

                        if ($selected[$i] == $value)
                            echo " selected=selected ";
                    }
            }
            echo " value=\"" . stripslashes($value) . "\"> " . stripslashes($value) . " </option>";
        }
        echo "</select>";
    }

    
    function stampa_select_formfactor($formfactor){
        #echo '<div class="form-group">';
        
        $lista_formfactor = array('Smartphone', 'Featurephone', 'Tablet', 'MBB');  
        
        echo '<div class="col-md-4 col-sm-6 col-xs-12"><h2>Select Città</h2>';
        stampa_select_array('formfactor', $lista_formfactor, null, false, null, "", array($formfactor), "class=\"select2_group form-control\" onchange=\"this.form.submit()\"");
        echo "</div>";
    }
    
    function stampa_select_formfactor_new($formfactor) {
           
        $db_link = connect_db_li();
        $query = "SELECT DISTINCT `tipo` FROM `dati_tacid` ORDER BY `Tipo` DESC";
        $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        while ($obj = mysqli_fetch_array($result)) {
            $lista_formfactor[] = $obj['tipo'];          
        }
        //$lista_formfactor = array('Smartphone', 'Featurephone', 'Tablet', 'MBB');          
        echo '<div class="col-md-4 col-sm-6 col-xs-12"><h2>Select Città</h2>';
        stampa_select_array('formfactor', $lista_formfactor, null, false, null, "", array($formfactor), "class=\"select2_group form-control\" onchange=\"this.form.submit()\"");
        echo "</div>";
    }
    
    
    function stampa_select_tipouser(){
    ############################# Select User Type###################    
    if (isset($_POST['filtro_piano'])) {
        $filtro_piano = $_POST['filtro_piano'];
    } else
        $filtro_piano = NULL;
    
    echo '<div class="col-md-4 col-sm-6 col-xs-12"><h2>Select user type</h2>';
    echo "<select class=\"select2_group form-control\" onchange=\"this.form.submit()\" name=\"filtro_piano\">
    <option value='S'";
    if ($filtro_piano == "S") {
        echo " selected ";
    }
    echo ">TOT</option>";
    
    if (!isset($_SESSION['operator']) || ($_SESSION['operator']== '3')){
            echo "<option value='S_PRE'";
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
    }
    echo "</select></div>";
   
 }
    
    
    function stampa_select_tipodato(){
        echo "<br>";
    ////////////// Tre/////////////////////////////
    if ($_SESSION['operator'] == '3')  {
                ////////////////////////////////////////////////////    
        if (isset($_POST['dato'])) {
            $dato = $_POST['dato'];
        } else
            $dato = NULL;
        echo '<div class="col-md-12 col-sm-12 col-xs-12">';
        echo '<div class="col-md-4 col-sm-6 col-xs-12"><h2>Select data type</h2>';
        echo "<select class=\"select2_group form-control\" onchange=\"this.form.submit()\" name=\"dato\">
        <option value='numero_ter'";
        if ($dato == "numero_ter") {
            echo " selected ";
        }
        echo "># TERMINALI</option>"
        . "<option value='numero_ter_LTE'";
        if ($dato == "numero_ter_LTE") {
            echo " selected ";
        }
        echo "># TERMINALI con traffico LTE>0</option>
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
        echo " >USAGE DATI</option> 
        <option value='dati_totale'";
        if ($dato == "dati_totale") {
            echo " selected ";
        }
        echo " >DATI TOTALE</option>"
        . "<option value='dati_totale_LTE'";
        if ($dato == "dati_totale_LTE") {
            echo " selected ";
        }
        echo " >DATI TOTALE LTE</option>
            <option value='dati_totale_3g_di_device_LTE_mag_0'";
        if ($dato == "dati_totale_3g_di_device_LTE_mag_0") {
            echo " selected ";
        }
        echo " >DATI 3G dei terminali LTE con traffico >0</option>
            <option value='voce'";
        if ($dato == "voce") {
            echo " selected ";
        }
        echo " >USAGE VOCE</option>
        <option value='voce_totale'";
        if ($dato == "voce_totale") {
            echo " selected ";
        }
        echo " >VOCE TOTALE</option>

            <option value='PDP'";
        if ($dato == "PDP") {
            echo " selected ";
        }
        echo " >PDP</option>"
        . "<option value='chiamate_non_risposte'";
        if ($dato == "chiamate_non_risposte") {
            echo " selected ";
        }
        echo " >chiamate non risposte</option>"
        . "</select>";
        echo "</div>";

        #echo '<div class="col-md-12 col-sm-12 col-xs-12">';

                echo "<br><br><input type=\"checkbox\" onchange=\"this.form.submit()\"  name=\"fullroamers\" value=\"TRUE\"";
                if (isset($_POST['fullroamers'])) {
                    echo " checked />";
                }

                echo '<p>Senza FullRoamers (*)</p></div>';
                #echo '<p>Senza FullRoamers (*)</p><p>(*)sono riferiti solo alle statistiche Totali, Roaming e voce</p>';
            #echo "</div>";
    }
    ////////////// Wind /////////////////////////////
    if ($_SESSION['operator'] == 'wind') {
                ////////////////////////////////////////////////////    
        if (isset($_POST['dato'])) {
            $dato = $_POST['dato'];
        } else
            $dato = NULL;
        echo '<div class="col-md-12 col-sm-12 col-xs-12">';
        echo '<div class="col-md-4 col-sm-6 col-xs-12"><h2>Select data type</h2>';
        echo "<select class=\"select2_group form-control\" onchange=\"this.form.submit()\" name=\"dato\">
        
        <option value='numero_ter'";
        if ($dato == "numero_ter") {
            echo " selected ";
        }
        echo "># TERMINALI</option>";
        
        /*
        echo "<option value='drop'";
        if ($dato == "drop") {
            echo " selected ";
        }
     
        echo " >DROP</option>
         * 
         */

        echo "<option value='dati_totale'";        
        if ($dato == "dati_totale") {
            echo " selected ";
        }
        echo " >Dati Totale</option>"
        . "<option value='dati_quattro_g'";
        if ($dato == "dati_quattro_g") {
            echo " selected ";
        }
        echo ">Dati 4G</option>";
        
        echo "<option value='dati_tre_g'";    
        if ($dato == "dati_tre_g") {
            echo " selected ";
        }
        echo " >Dati 3G</option>";
        
        echo'<option value="dati_due_g"';
            if ($dato == "dati_due_g") {
                echo " selected ";
            }
        echo " >Dati 2G</option>";
        echo'<option value="dati_usage"';
        if ($dato == "dati_usage") {
            echo " selected ";
        }
        echo " >Dati Usage</option>"; 
        
        echo "<option value='voce_totale'";
        if ($dato == "voce_totale") {
            echo " selected ";
        }
        echo " >Voce Totale</option>";
        
        echo "<option value='voce_tre_g'";
        if ($dato == "voce_tre_g") {
            echo " selected ";
        }
        echo " >Voce 3G</option>";
        echo "<option value='voce_due_g'";
        if ($dato == "voce_due_g") {
            echo " selected ";
        }
        echo " >Voce 2G</option>";
        
        echo "<option value='voce_chiamate'";
        if ($dato == "voce_chiamate") {
            echo " selected ";
        }
        echo " >Voce Chiamate</option>";
        
        echo "<option value='voce_usage'";
        if ($dato == "voce_usage") {
            echo " selected ";
        }
        echo " >Voce Usage</option>";
        /*    
        echo "<option value='chiamate_non_risposte'";
        if ($dato == "chiamate_non_risposte") {
            echo " selected ";
        }
        echo " >chiamate non risposte</option>"
         * 
         */
        echo "</select>";
        echo "</div>";

        #echo '<div class="col-md-12 col-sm-12 col-xs-12">';

                echo "<br><br>";
                 echo '</div>';

    }  

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


    function stampa_widjetProjectTitle ($subtitle, $title, $icon){
        if(empty($icon)) {$icon = "fa fa-mobile";}   
        if(empty($subtitle)) {$subtitle = " ---- ";} 
        
        
        #if($job_role > 6) { 
        #    if($tobereview_req==1){$tbr_check = "checked";}else{$tbr_check = "";}
                            ?>  
                             <!--<input type="checkbox" name="tobereview[<?php #echo $rfi['id'];?>]" value="1" <?php #echo $tbr_check; ?> >MDM requirements Only-->
                          <?php   
        #}
        #if(!isset($owner))$owner = "No owner";
        #if(!isset($userVendor))$userVendor = "Not assigned";
        ?>
                       <div class="animated flipInY col-lg-12 col-md-12 col-sm-12 col-xs-12">
                        <div class="tile-stats">
                          <div class="icon"><i class="<?php echo $icon; ?>"></i>
                          </div>
                            
                            <h1><center><b><?php echo $title; ?></b></center></h1>  
                            <h3><center><?php echo $subtitle ?></center></h3>
                          <p><?php #echo $title; ?></p>
                          
                        </div>
                      </div>
    

        <?php        
    }
    
    
    function stampa_widjetProjectProgress ($owner, $userVendor, $icon, $project){
        
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
                          </h3>
                            <div class="col-md-9 col-sm-9 col-xs-9">
                            <div class="progress progress_wide">
                              <div class="progress-bar bg-green" role="progressbar" data-transitiongoal="<?php  echo $project['progress']; ?>" aria-valuenow="44" style="width: <?php  echo $project['progress']; ?>%;"></div>
                            
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
                     if($project['progress']==100) {$disable='';} 
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
    
    

}
