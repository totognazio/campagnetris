
<div role="tabpanel" class="tab-pane fade active in" id="tab_content1" aria-labelledby="home-tab">
                    <br/>
                    
                       <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="nomecampagna">Nome Campagna  <span class="required">*</span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="nomecampagna" name="nomecampagna"  required="required" class="form-control col-md-7 col-xs-12" readonly="readonly"  
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
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Stack  <span class="required">*</span></label>
                        <?php #print_r($id_campaign); ?>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="stack_ins" name="select_stacks[]" class="select2_single form-control" required="required" <?php echo $disabled_value;?> >      
                               <option value="0"></option>
                            <?php 
                            foreach ($stacks as $key => $value) {
                                if($id_campaign['stack_id']==$key){
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
                            <select id="squad_ins" name="select_squads[]" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>        
                              <option value=""></option>
                            <?php 
                            foreach ($squads as $key => $value) {
                                if($id_campaign['squad_id']==$key){
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
                          <select id="type_ins" name="type_ins" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>
                               <?php   
                                if(isset($id_campaign['type_id'])){
                                   echo '<option selected value="'.$id_campaign['type_id'].'">'.$id_campaign['tipo_nome'].'</option>'; 
                                }                                
                                ?>
                          </select>
                        </div>
                      </div>  

                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Modalità  <span class="required">*</span></label>                       
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="moda_ins" name="select_moda[]" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>        
                              <option value=""></option>
                            <?php 
                            foreach ($modality as $key => $value) {
                               if($id_campaign['modality_id']==$key){
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
                            <select id="cate_ins" name="select_cate[]" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>        
                              <option value=""></option>
                            <?php 
                            foreach ($category as $key => $value) {
                                if($id_campaign['category_id']==$key){
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
 
                          <select id="priority" name="priority" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>
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
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="descriz_target">Descrizione Target
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <input type="text" id="descriz_target" name="descriz_target"  class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['descrizione_target'])){ echo $id_campaign['descrizione_target']; } ?>" <?php echo $disabled_value;?>>
                        </div>
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Leva\Offerta  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                            <select id="validitalevaofferta" name="validitalevaofferta" class="select2_single form-control" onchange="validitaoffer()" required="required" <?php echo $disabled_value;?> >        
                             <?php  
                                $select_0 ='';
                                $select_1='';
                                $display_validitaofferta = 'style="display: none;"';
                                if($id_campaign['leva']=='0'){
                                   $select_0 = 'selected';
                                }
                                elseif($id_campaign['leva']=='1'){
                                   ?><script> $('#validita-offerta').show(); </script>
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

                                             <div id="range_offerta" class="pull-left" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc">
                                                 <i class="glyphicon glyphicon-calendar fa fa-calendar"></i>
                                                 <span id="range_offerta">20/11/2020 - 30/11/20</span> <b class="caret"></b>
                                             </div>
                                         </div>
                                     </div>
                                 </div>
                             </div> 
                 
                             <div class="form-group">
                                 <label class="control-label col-md-3 col-sm-3 col-xs-12">Offerta  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="descriz_target" name="descriz_target"  class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['descrizione_offerta'])){echo $id_campaign['descrizione_offerta'];}?>">
                        </div>
                             </div>                                                   
                   
                        
                      </span>   
                    

                        </div> 

