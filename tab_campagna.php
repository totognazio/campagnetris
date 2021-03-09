<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <br/>
                    
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nomecampagna">Nome Campagna  <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="nomecampagna" name="pref_nome_campagna"  class="form-control col-md-7 col-xs-12" required="required" data-parsley-maxlength="40" data-parsley-trigger="keyup" readonly="readonly"  
                           <?php
                            if ($modifica){
                                echo " value=\"" . substr(stripslashes($id_campaign['pref_nome_campagna']), 0) . "\"";
                            }    
                            else {
                                echo " value=\"\"";
                            }           
                            ?>
                            />
                        </div>
                      </div>  
                      <br>  
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="stack">Stack  <span class="required">*</span></label>
                        <?php #print_r($id_campaign); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="stack_ins" name="stack_id" class="select2_single form-control"  required="required" <?php echo $disabled_value;?> >      
                               <option value=""></option>
                            <?php 
                            foreach ($stacks as $key => $value) {
                                if($modifica && $id_campaign['stack_id']==$key){
                                   echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                }
                                else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            }                                                  
                            ?>  
                          </select>
                        </div>
                      </div>
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Squad  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="squad_ins" name="squad_id" class="select2_single form-control"  required="required" <?php echo $disabled_value;?>>        
                            <?php
                                if($page_protect->get_job_role()!=2){
                                    echo'<option value=""></option>';
                                }                                                  
                                foreach ($squads as $key => $value) {
                                    if($modifica && $id_campaign['squad_id']==$key){
                                    echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                    }
                                    else {
                                        echo '<option value="'.$key.'">'.$value.'</option>';
                                    }
                              
                            }                                                  
                            ?>  
                          </select>
                        </div>
                      </div> 
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipologia <span class="required">*</span></label>                     
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <select id="type_ins" name="type_id" class="select2_single form-control"  required="required" <?php echo $disabled_value;?>>
                          <option value=""></option>
                               <?php   
                                foreach ($typlogies as $key => $value) {
                                if($modifica && $id_campaign['type_id']==$key){
                                   echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                }
                                else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                              
                            }                                                  
                            ?>                                      
                          </select>
                        </div>
                      </div>  
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note_camp">Note
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="note_camp" name="note_camp"  class="form-control col-md-7 col-xs-12" placeholder="alfanumerico (parte del nome campagna)" value="<?php if(isset($id_campaign['note_camp'])){ echo $id_campaign['note_camp']; } ?>" <?php echo $disabled_value;?>>
                        </div>
                      </div>

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modalità  <span class="required">*</span></label>                       
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="moda_ins" name="modality_id" class="select2_single form-control"  required="required" <?php echo $disabled_value;?>>        
                              <option value=""></option>
                            <?php 
                            foreach ($modality as $key => $value) {
                               if($modifica && $id_campaign['modality_id']==$key){
                                   echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                }
                                else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            }                                                  
                            ?>  
                          </select>
                        </div>
                      </div>   
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Target  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="cate_ins" name="category_id" class="select2_single form-control" tabindex="-1"  required="required" <?php echo $disabled_value;?>>        
                              <option value=""></option>
                            <?php 
                            //print_r($category);
                            foreach ($category as $key => $value) {
                                if($modifica && $id_campaign['category_id']==$key){
                                   echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                }
                                else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            }                                                  
                            ?>  
                          </select>
                        </div>
                      </div>
                     <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Priorità PM <span class="required">*</span></label>                     
                        <div class="col-md-6 col-sm-6 col-xs-12">
 
                          <select id="priority" name="priority" class="select2_single form-control"  required="required" <?php echo $disabled_value;?>>
                           <?php 
                            $selected = 'selected';
                            $lista_priorita = array(0, 1, 2, 3, 4, 5, 6, 7, 8, 9);
                            $selected_value = 1;
                            if(isset($id_campaign['priority'])) $selected_value = $id_campaign['priority'];
                            
                            foreach ($lista_priorita as $value) {

                                if($value == $selected_value){
                                    echo '<option '.$selected.' value="'.$value.'">'.$value.'</option>';
                                }
                                else{
                                    echo '<option  value="'.$value.'">'.$value.'</option>';
                                }
                            }                                                  
                            ?> 
 
                          </select>
                        </div>
                      </div>   
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descriz_target">Descrizione Attività
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="descriz_target" name="descrizione_target"  class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['descrizione_target'])){ echo $id_campaign['descrizione_target']; } ?>" <?php echo $disabled_value;?>>
                        </div>
                      </div>

                    <div class="form-group"  id="span_cod_campagna" style="display:none;" >                    
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" id="label_cod_campagna">Cod_Campagna</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="cod_campagna" name="cod_campagna" type="text" class="form-control col-md-7 col-xs-12"
                            <?php
                            if($action_duplica)
                                echo "value=\"\"";
                            elseif ($modifica)
                                echo "value=\"" . $id_campaign['cod_campagna'] . "\"";
								#echo "value=\"\"";
                            else
                                echo "value=\"\"";
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                            />
                            </div>
                    </div>
                    <br>
                        <div class="form-group"   id="span_cod_comunicazione"  style="display:none;">
                            <label class="control-label col-md-3 col-sm-3 col-xs-12" id="label_cod_comunicazione">Cod_Comunicazione</label>
                            <div class="col-md-6 col-sm-6 col-xs-12">
                            <input id="cod_comunicazione" name="cod_comunicazione" type="text" class="form-control col-md-7 col-xs-12"
                            <?php
                            if($action_duplica)
                                echo "value=\"\"";
                            elseif ($modifica)
                                echo "value=\"" . $id_campaign['cod_comunicazione'] . "\"";
								#echo "value=\"\"";
                            else
                                echo "value=\"\"";
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                            />
                        </div>
                        </div>
                        <br>
                      
                        <div class="form-group"  id="span_state"  style="display:none;">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Stato  <span class="required">*</span></label>
                                <div class="col-md-6 col-sm-6 col-xs-12">
                        
                            
                            <?php
                            //print_r($id_campaign);
                            if (($page_protect->get_job_role() == 2)) {
                                    $list = $funzioni_admin->get_list_state_id('campaign_states', 2);                                                
                            }
                            else{
                                $list = $funzioni_admin->get_list_state_id('campaign_states', 10);  
                            }
                            ?>
                            <select id="campaign_state_id" name="campaign_state_id" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>        
                              <option value=""></option>
                            <?php 
                                if ($modifica){
                                    $campaign_state_id = $id_campaign['campaign_state_id'];
                                }                                    
                                else {
                                    $campaign_state_id = 2; //default Draft per new campagne o duplica
                                }
                                    
                            foreach ($states as $key => $value) {
                                if($modifica && $campaign_state_id==$key){
                                   echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                }
                                else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            }                                                  
                            ?>  
                          </select>

                        </div>
                    </div>
                        </div> 

<script>

    var channel_label = "_";
    var squad_label = "_";
    var type_label = "_";
    var data_label = "";
    var note_label = "";
    var stato = 2;
    var selected_channel_id = 0;

    
    
  $(document).ready(function () {

    
    <?php
    if (isset($azione) && ($azione=='new')){
        ?>
            document.getElementById('nomecampagna').value = moment().format('YYYYMMDD');
            stato = document.getElementById('campaign_state_id').value = 2; //stato RICHIESTA
            selected_channel_id = document.getElementById('channel_ins').value;   
                  
            validazione(selected_channel_id, stato);
            validazione_criteri(stato);  
        <?php        
    }
    if ($modifica) {
        ?>
                document.getElementById("span_state").style.display = "inline";
                stato = document.getElementById('campaign_state_id').value;
                selected_channel_id = document.getElementById('channel_ins').value; 
                
                validazione(selected_channel_id, stato); 
                validazione_criteri(stato);
    <?php    
    }
        
    if ($modifica_codici) {
        ?>
                document.getElementById("span_cod_comunicazione").style.display = "inline";
                document.getElementById("span_cod_campagna").style.display = "inline";
        <?php
    }
?>   
       
       $('#squad_ins').on('select2:select', function () {  
            if (document.getElementById('nomecampagna').value.length > 0) {
            var pref_nome_campagna = document.getElementById('nomecampagna').value;
            var myarr = pref_nome_campagna.split("_");
            //if (myarr[0].value.length > 0)
            data_label = myarr[0];
            if (myarr[1])
                squad_label = "_" + myarr[1];
            if (myarr[2])    
             channel_label = "_" + myarr[2];
            if (myarr[3])
             type_label = "_" + myarr[3];
            if (myarr[4]) 
                note_label = "_" + myarr[4];
    
        }
            $.getJSON("get_label.php", {squad_id: $(this).val()}, function (dati) {
                squad_label = "_" + dati[0].etichetta;
                document.getElementById('nomecampagna').value = data_label + squad_label + channel_label + type_label + note_label;
            });
        }); 

        $('#type_ins').on('select2:select', function () {
            if (document.getElementById('nomecampagna').value.length > 0) {
            var pref_nome_campagna = document.getElementById('nomecampagna').value;
            var myarr = pref_nome_campagna.split("_");
            data_label = myarr[0];
            if (myarr[1])
                squad_label = "_" + myarr[1];
            if (myarr[2])    
             channel_label = "_" + myarr[2];
            if (myarr[3])
             type_label = "_" + myarr[3];
            if (myarr[4]) 
                note_label = "_" + myarr[4];
    
        }
            $.getJSON("get_label.php", {type_id: $(this).val()}, function (dati) {
                type_label = "_" + dati[0].etichetta;
                document.getElementById('nomecampagna').value = data_label + squad_label + channel_label + type_label + note_label;
            });
        });
        $('#note_camp').on('change', function() {   
            if (document.getElementById('nomecampagna').value.length > 0) {
            var pref_nome_campagna = document.getElementById('nomecampagna').value;
            var myarr = pref_nome_campagna.split("_");
            data_label = myarr[0];
            if (myarr[1])
                squad_label = "_" + myarr[1];
            if (myarr[2])    
             channel_label = "_" + myarr[2];
            if (myarr[3])
             type_label = "_" + myarr[3];
            if (myarr[4]) 
                note_label = "_" + myarr[4];
    
        }
                note_label = '_'+document.getElementById('note_camp').value;     
                document.getElementById('nomecampagna').value = data_label + squad_label + channel_label + type_label + note_label;
        });

         


        

 
  
    $('#campaign_state_id').select2({
      placeholder: "Select Stato",
      allowClear: true
    });


    //alert('stato adesso '+ stato);

    $('#campaign_state_id').on('select2:select', function() {
            //alert(' stato campagna  '+ $('#campaign_state_id').val());
            //var stato_info;
            stato = $('#campaign_state_id').val();
            
            var stato_info = $.parseJSON($.ajax({
                    url: "get_stato_info.php",
                    method: "POST",
                    data: { stato_id: stato },
                    dataType: "json",
                    async: false,
                }).responseText);

            console.log('stato_infoquii '+ JSON.stringify(stato_info));
            
            count =  $('#iniziative_dealer').val();   
            validazione(selected_channel_id, stato);              
            validazione_canaleDealer(count, stato);
            validazione_criteri(stato);

    });
    
 });

</script>