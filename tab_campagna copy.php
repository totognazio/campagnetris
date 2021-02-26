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
                              <option value=""></option>
                            <?php 
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
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Leva\Offerta  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="validitalevaofferta" name="leva_offerta" class="select2_single form-control" onchange="validitaoffer()"  required="required" <?php echo $disabled_value;?> >        
                             <?php  
                                $select_0 ='';
                                $select_1='';
                                $display_validitaofferta = 'style="display: none;"';
                                if($modifica && $id_campaign['leva_offerta']=='0'){
                                   $select_0 = 'selected';
                                }
                                elseif($modifica && $id_campaign['leva_offerta']=='1'){
                                   ?><script> 
                                        $('#validita-offerta').show();
                                        $('#descrizione_offerta').attr('required', true);                                                                   
                                      </script>
                                   <?php
                                   $select_1 = 'selected';
                                   $display_validitaofferta = '';
                                }
                             ?> 
                                
                              <option  value=""></option>
                              <option <?php echo $select_0; ?> value="0">No</option>
                              <option <?php echo $select_1; ?> value="1">Yes</option>
                              
                          </select>
                        </div>
                      </div>  
                     <span id="validita-offerta" <?php echo $display_validitaofferta; ?>>                  
                             <div class="form-group">           
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Validità Offerta  <span class="required">*</span></label>

                                 <div class="col-md-6 col-sm-6 col-xs-12">     
                                     <div class="well" style="overflow: auto">
                                         <div class="col-md-12">
                                    <!--
                                             <div id="range_offerta" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                                 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                 <span id="range_offerta">20/11/2020 - 30/11/20</span> <b class="caret"></b>
                                                 <input type="hidden" id="data_inizio_validita_offerta" name="data_inizio_validita_offerta" value="">
                                                 <input type="hidden" id="data_fine_validita_offerta" name="data_fine_validita_offerta" value="">
                                             </div>
                                             -->
                            <div class="control-group">
                              <div class="controls">
                                <div class="input-prepend input-group">
                                  <span class="add-on input-group-addon"><i class="glyphicon glyphicon-calendar fa fa-calendar"></i></span>
                                  <input type="text" style="width: 200px" name="reservation" id="reservation" class="form-control" value="" <?php echo $disabled_value;?> />
                                </div>
                              </div>
                            </div>    
                                         </div>
                                     </div>
        
                                 </div>
                             </div> 
                             
                                                 <input type="hidden" id="data_inizio_validita_offerta" name="data_inizio_validita_offerta" value="">
                                                 <input type="hidden" id="data_fine_validita_offerta" name="data_fine_validita_offerta" value="">
                 
                             <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Offerta  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="descrizione_offerta" name="descrizione_offerta"  class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['descrizione_offerta'])){echo $id_campaign['descrizione_offerta'];}?>" <?php echo $disabled_value;?>>
                        </div>
                             </div> 
                                                   
                      </span>  
                     <br>  
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
                            if (isset($id_campaign['ordinamento_stato'])) {
                                if (($id_campaign['ordinamento_stato'] < 2) && ($page_protect->get_job_role() == 2)) {
                                    $list = $funzioni_admin->get_list_state_id('campaign_states', 2);
                                    //print_r($list);
                                
                                } else {
                                    $list = $funzioni_admin->get_list_state_id('campaign_states', 10);
                                }
//$list = $funzioni_admin->get_list_id('campaign_states');
                                $lista_field = array_column($list, 'id');
                                $lista_name = array_column($list, 'name');
                                $javascript = "  tabindex=\"7\" onfocus=\"seleziona('campo');\" onblur=\"deseleziona('campo');\" ";
                                if ($readonly)
                                    $javascript = $javascript . $disabled_value;
                                $style = "";
                                if ($modifica)
                                    $campaign_state_id = $id_campaign['campaign_state_id'];
                                else
                                    $campaign_state_id = "";
                                $funzioni_admin->stampa_select2('campaign_state_id', $lista_field, $lista_name, $javascript, $style, $campaign_state_id);
                            }
                            ?>

                        </div>
                    </div>
                        </div> 

<script>
    
    var channel_label = "_";
    var squad_label = "_";
    var type_label = "_";
    var data_label = "";
    var note_label = "";
    
    
  $(document).ready(function () {

    $('#reservation').daterangepicker({   
            <?php

    if(isset($id_campaign['leva_offerta']) && $id_campaign['leva_offerta']==1 && (strtotime($id_campaign['data_inizio_validita_offerta'])>0)&& (strtotime($id_campaign['data_fine_validita_offerta'])>0)){                
                $start = date('d/m/Y',strtotime($id_campaign['data_inizio_validita_offerta']));
                $end = date('d/m/Y',strtotime($id_campaign['data_fine_validita_offerta']));
                echo "startDate:'".$start."',";
                echo "endDate:'".$end."',";
    }
    else{
?>
            startDate: moment().format('DD/MM/YYYY'),
            endDate: moment().add(1, 'week').format('DD/MM/YYYY'),  
<?php
    }

    ?>
        
      
            locale: {
                    format: "DD/MM/YYYY",
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
                    monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    firstDay: 1
            }, 
            function(start, end, label) {
                console.log(start.toISOString(), end.toISOString(), label);
                document.getElementById('data_inizio_validita_offerta').value = startDate.format('YYYY-MM-DD');
                document.getElementById('data_fine_validita_offerta').value = endDate.format('YYYY-MM-DD');

            }
    });

    $('#reservation').on('apply.daterangepicker', function(ev, picker) {
        console.log(picker.startDate.format('YYYY-MM-DD'));
        console.log(picker.endDate.format('YYYY-MM-DD'));
        $('#data_inizio_validita_offerta').attr('value',picker.startDate.format('YYYY-MM-DD'));
        $('#data_fine_validita_offerta').attr('value',picker.endDate.format('YYYY-MM-DD'));
    });


    //$('#reservation').data('daterangepicker').setStartDate('04/01/2014');
    //$('#reservation').data('daterangepicker').setEndDate('10/01/2014');


    
    <?php
    if (isset($azione) && ($azione=='new')){
        ?>
            document.getElementById('nomecampagna').value = moment().format('YYYYMMDD');
            document.getElementById('data_inizio_validita_offerta').value = moment().format('YYYYMMDD');
            document.getElementById('data_fine_validita_offerta').value = moment().add(1, 'week').format('YYYYMMDD');
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

         

<?php
if ($modifica) {
    ?>
    document.getElementById("span_state").style.display = "inline";
<?php    
}
    
if ($modifica_codici) {
    ?>
            document.getElementById("span_cod_comunicazione").style.display = "inline";
            document.getElementById("span_cod_campagna").style.display = "inline";
    <?php
}
?>
        

  })      
</script>