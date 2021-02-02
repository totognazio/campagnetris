<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
    <br/>
    <div class="col-md-8 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Canale  <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                            <?php
                            
                            $list = $funzioni_admin->get_list_id('channels');
                            $lista_field = array_column($list, 'id');
                            $lista_name = array_column($list, 'name');
                            $javascript = $disabled_value.' required="required" ';
                            $display_sms =  ' style="display: none;"';                        
                            $required_sms_field = '';                            
                            $required_pos_field = '';
                            $display_pos =  ' style="display: none;"';
                            $display_40400 =  ' style="display: none;"';
                            $required_400 = '';
                            $style = " style=\"width:100%;\" ";
                            $display_app_inbound = ' style="display: none;"';
                            $display_app_outbound = ' style="display: none;"';
                            $display_icm = ' style="display: none;"';
                            $display_dealer = ' style="display: none;"';
                            $display_spai = ' style="display: none;"';
                            $display_watson = ' style="display: none;"';
                            $display_ivr_inbound = ' style="display: none;"';
                            $display_ivr_outbound = ' style="display: none;"';
                            $display_jakala = ' style="display: none;"';
                            $display_mfh = ' style="display: none;"';
                            $required_app_inbound = ''; 
                            $required_app_outbound = ''; 
                            $required_dealer = ''; 
                            $required_mfh = ''; 
                            $required_watson = '';                         
                            $required_icm = ''; 
                            $required_ivr_inbound = ''; 
                            $required_ivr_outbound = '';
                            $required_jakala = '';                              

                            if ($modifica){
                                $valore_channel_id = $id_campaign['channel_id'];
                                //sms sms_long
                                if($valore_channel_id==12){$display_sms =  ''; $required_sms_field =  ' required="required" ';}
                                //CRM Da POS
                                if($valore_channel_id==13){$display_pos =  ''; $display_guide2=''; $required_callguide2 = ' required="required" '; $required_pos_field =  ' required="required" ';} 
                                //40400
                                if($valore_channel_id==10){$display_40400 =  ''; $required_400 = ' required="required" ';}  
                                //App Inbound
                                if($valore_channel_id==15){$display_app_inbound =  ''; $required_app_inbound = ' required="required" ';}  
                                //App Outbound
                                if($valore_channel_id==16){$display_app_outbound =  ''; $required_app_outbound = ' required="required" ';}                                 
                                //Dealer
                                if($valore_channel_id==33){$display_dealer =  ''; $required_dealer = ' required="required" ';}                                  
                                //ICM
                                if($valore_channel_id==21){$display_icm =  ''; $required_icm = ' required="required" ';} 
                                //IVR Inbound
                                if($valore_channel_id==22){$display_ivr_inbound =  ''; $required_ivr_inbound = ' required="required" ';} 
                                //IVR Outbound
                                if($valore_channel_id==23){$display_ivr_outbound =  ''; $required_ivr_outbound = ' required="required" ';} 
                                //Jakala
                                if($valore_channel_id==24){$display_jakala =  ''; $required_jakala = ' required="required" ';}                                                                                                                                 
                                //MFH
                                if($valore_channel_id==31){$display_mfh =  ''; $required_mfh = ' required="required" ';}  
                                //watson
                                if($valore_channel_id==29){$display_watson =  ''; $required_watson = ' required="required" ';}                                   
                            }
                            else{
                                $valore_channel_id = "";}
                                $funzioni_admin->stampa_select2('channel_ins', $lista_field, $lista_name, $javascript, $style, $valore_channel_id, 'channel_id');
                            ?>           
                <!--<select id="channel_ins" style="width: 100%" name="select_channels[]" class="select2_single form-control"  required="required" <?php #echo $disabled_value;?>>      
                    <option value="0"></option>
                    <?php 
                    /*
                         foreach ($channels as $key => $value) {
                                if($modifica and $id_campaign['channel_id']==$key){
                                   echo '<option selected value="'.$key.'">'.$value.'</option>'; 
                                }
                                else {
                                    echo '<option value="'.$key.'">'.$value.'</option>';
                                }
                            }
                     * 
                     */                                                  
                    ?>  
                </select>-->
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titolo & Sottotitolo </label>
            <?php #print_r($stacks); ?>
            <div class="col-md-6 col-sm-6 col-xs-12">                              
                <select  id="tit_sott_ins" style="width: 100%" name="tit_sott_id" class="select2_single form-control" <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <?php
                    foreach ($tit_sott as $key => $value) {                        
                        if($modifica and $id_campaign['tit_sott_id']==$key){
                                   echo '<option  selected value="' . $value['id'] . '">' . $value['name'] . ' - ' . $value['label'] . '</option>';
                                }
                                else {
                                   echo '<option  value="' . $value['id'] . '">' . $value['name'] . ' - ' . $value['label'] . '</option>';
                                }
                        
                    }
                    ?>  
                </select>
            </div>
        </div>   

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Leva  <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php 
                $select_monoleva = '';
                $display_mono = ' style="display: none;"';
                $select_multileva = '';
                $display_multi = ' style="display: none;"';             
                if($modifica and $id_campaign['tipo_leva']=='mono'){
                    $select_monoleva = ' selected';
                    $display_mono = '';                   
                }
                if($modifica and $id_campaign['tipo_leva']=='multi'){$select_multileva = ' selected';$display_multi='';}                
                ?>
                <select  id="idlevaselect" name="tipo_leva" class="select2_single form-control" required="required" onchange="levaselect()"  <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php echo $select_monoleva; ?> value="mono">MonoLeva</option>
                    <option <?php echo $select_multileva; ?> value="multi" >MultiLeva</option>

                </select>
            </div>
        </div>  
        <span id="monoleva" <?php echo $display_mono; ?>>
        <!--  
            <div class="form-group">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">Opzione  <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="opzione_leva" name="opzione_leva" class="select2_single form-control" <?php //echo $disabled_value;?>>       
                        <option <?php //if($modifica and $id_campaign['opzione_leva']=='0'){echo ' selected';} ?> value=""></option>
                        <option <?php //if($modifica and $id_campaign['opzione_leva']=='Ropz'){echo ' selected';} ?> value="Ropz">Ropz</option>
                        <option <?php //if($modifica and $id_campaign['opzione_leva']=='Popz'){echo ' selected';} ?>value="Ropz">Popz</option>

                    </select>
                </div>

            </div> 
            -->
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_taglio">Codice Ropz.
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input  <?php echo $disabled_value; ?>type="text" id="cod_ropz" name="cod_ropz" value="<?php if(isset($id_campaign['cod_ropz'])){$form->input_value($modifica, $id_campaign['cod_ropz']);} ?>"   placeholder=" campo alfanumerico" class="form-control col-md-7 col-xs-12">
                </div>
            </div>
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_taglio">Codice Popz.
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input  <?php echo $disabled_value; ?>type="text" id="cod_opz" name="cod_opz" value="<?php if(isset($id_campaign['cod_opz'])){$form->input_value($modifica, $id_campaign['cod_opz']);} ?>"   placeholder=" campo alfanumerico" class="form-control col-md-7 col-xs-12">
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_news">ID News
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input <?php echo $disabled_value;?> type="text" id="id_news" name="id_news"  class="form-control col-md-7 col-xs-12" placeholder=" campo alfanumerico" value="<?php if(isset($id_campaign['id_news'])){echo $id_campaign['id_news'];}?>">
                </div>
            </div>    


        </span>     
        <span id="multileva" <?php echo $display_multi; ?>> 

            <div class="form-group">
                <br />
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">File Upload<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">             

                    <div class="x_content">
                        <p>Drag a file to the box below for upload or click to select file.</p>                        
                                        
                        <form id="dropzone-canale" action="upload.php?id_upload=<?php echo $id_upload; ?>&canale"  class="dropzone">
                        </form>
                        <br />
                    </div>
                </div>   
            </div>  
        </span>   

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Note Operative
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php if ($readonly){echo $disabled_value;}?>type="text" id="note_operative" name="note_operative"  placeholder="campo alfanumerico" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['note_operative'])){echo $id_campaign['note_operative']; }?>">
            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Data Inizio Campagna
            </label>
            <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                <input id="data_inizio_campagna" <?php if ($readonly){echo $disabled_value;}?> type="text" class="form-control has-feedback-left"  placeholder="Data Inizio Campagna" aria-describedby="inputSuccess2Status3" required="required" name="data_inizio" value="<?php if(isset($id_campaign['data_inizio'])){echo date('d/m/Y', strtotime($id_campaign['data_inizio']));}?>">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Escludi Sa/Dom<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
               
                <select <?php echo $disabled_value;?> id="escludi_sab_dom" name="escludi_sab_dom"  class="select2_single form-control"  style="width: 100%"   required="required">        
                    <option <?php if($modifica and intval($id_campaign['escludi_sab_dom'])==0){echo ' selected ';} ?> value="0">No</option>
                    <option <?php if($modifica and intval($id_campaign['escludi_sab_dom'])==1){echo ' selected ';} ?> value="1">Sabato</option>
                    <option <?php if($modifica and intval($id_campaign['escludi_sab_dom'])==2){echo ' selected ';} ?> value="2" >Domenica</option>
                    <option <?php if($modifica and intval($id_campaign['escludi_sab_dom'])==3){echo ' selected ';} ?>value="3" >Sabato & Domenica</option>

                </select>
            </div>
        </div>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-6 col-xs-12">Durata Campagna<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select  <?php echo $disabled_value;?> id="duratacampagna" name="durata_campagna"  class="select2_single form-control"  style="width: 100%"  onchange="durata_camp(this.value);volumeRipartizione(0);">                            
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='1'){echo ' selected';}else{echo ' selected';}?> value="1">1 Giorno</option>
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='2'){echo ' selected';}?> value="2">2 Giorni</option>
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='3'){echo ' selected';}?> value="3">3 Giorni</option>
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='4'){echo ' selected';}?> value="4">4 Giorni</option>
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='5'){echo ' selected';}?> value="5">5 Giorni</option>
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='6'){echo ' selected';}?> value="6">6 Giorni</option>
                    <option <?php if($modifica and $id_campaign['durata_campagna']=='7'){echo ' selected';}?> value="7">7 Giorni</option>
                </select>
            </div>
        </div>    
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume_tot">Volume Totale Stimato<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> id="volume_tot" name="volume"  type="number" class="form-control col-md-7 col-xs-12" style="text-align:right"  onblur="volumeRipartizione(0);"  oninput="validity.valid||(value='');" pattern="/^-?\d+\.?\d*$/"  onKeyPress="if (this.value.length == 9) return false;" min="0" max="999999999"  required="required" placeholder="maximum 9 digits" 
                       value="<?php if($modifica){echo $id_campaign['volume'];}?>">
            </div>
        </div>  
        
        <div class="form-group" id="day1" style="display: none;">      
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero1">Volume Giorno 1
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero1" name="volumeGiornaliero1"  class="form-control col-md-7 col-xs-12" style="text-align:right"   pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                    return false;"  min="0" max="999999999" value="<?php if($modifica){echo $id_campaign['volumeGiornaliero1'];}else{echo'0';}?>"  value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(1);">     

            </div>
        </div>  
        <div class="form-group" id="day2" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero2">Volume Giorno 2
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero2" name="volumeGiornaliero2"  class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999"   value="<?php if($modifica){echo $id_campaign['volumeGiornaliero2'];}else{echo'0';}?>" oninput="validity.valid||(value='');" onblur="volumeRipartizione(2);">     

            </div>
        </div>  
        <div class="form-group" id="day3" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero3">Volume Giorno 3
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero3" name="volumeGiornaliero3"  class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="<?php if($modifica){echo $id_campaign['volumeGiornaliero3'];}else{echo'0';}?>"   oninput="validity.valid||(value='');" onblur="volumeRipartizione(3);">     

            </div>
        </div>  
        <div class="form-group" id="day4" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero4">Volume Giorno 4
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero4" name="volumeGiornaliero4" class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;" min="0" max="999999999" value="<?php if($modifica){echo $id_campaign['volumeGiornaliero4'];}else{echo'0';}?>"  oninput="validity.valid||(value='');" onblur="volumeRipartizione(4);">     

            </div>
        </div>  
        <div class="form-group" id="day5" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="VolumeGiornaliero5">Volume Giorno 5
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero5" name="volumeGiornaliero5"  class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="<?php if($modifica){echo $id_campaign['volumeGiornaliero5'];}else{echo'0';}?>"   oninput="validity.valid||(value='');" onblur="volumeRipartizione(5);">     

            </div>
        </div>  

        <div class="form-group" id="day6" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Volume Giorno 6
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero6" name="volumeGiornaliero6" class="form-control col-md-7 col-xs-12" style="text-align:right"   pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="<?php if($modifica){echo $id_campaign['volumeGiornaliero6'];}else{echo'0';}?>"  oninput="validity.valid||(value='');" onblur="volumeRipartizione(6);">     

            </div>
        </div>  
        <div class="form-group" id="day7" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Volume Giorno 7
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input <?php echo $disabled_value;?> type="number" id="VolumeGiornaliero7" name="volumeGiornaliero7" class="form-control col-md-7 col-xs-12" style="text-align:right" pattern="/^-?\d+\.?\d*$/" 
                       onKeyPress="if (this.value.length == 9 return false;"   min="0" max="999999999" value="<?php if($modifica){echo $id_campaign['volumeGiornaliero7'];}else{echo'0';}?>" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(7);">     

            </div>
        </div>                            

</div>  

    <span id="sms_field" <?php echo $display_sms; ?> data-parsley-check-children="7" data-parsley-validate-if-empty="">  
        <div class="col-md-3 col-sm-6 col-xs-12">
                                
                        <label>Sender  <span class="required">*</span></label>
                            <select id="senders_ins" name="sender_id" class="select2_single form-control" style="width:100%"  <?php echo $required_sms_field; ?> <?php echo $disabled_value;?>>      
                                <?php   
                                if(isset($id_campaign['sender_id'])){
                                   echo '<option selected value="'.$id_campaign['sender_id'].'">'.$id_campaign['sender_nome'].'</option>'; 
                                }                                
                                ?>   
                          </select>
                        
                       <label style="margin-top:20px">Storicizzazione Legale  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="storicizza_ins" name="storicizza" class="select2_single form-control" style="width:100%"  <?php echo $required_sms_field; ?> <?php echo $disabled_value;?>>      
                                <option value=""></option>
                                <option <?php if($modifica and $id_campaign['storicizza']=='0'){echo ' selected';} ?> value="0">No</option>
                                <option <?php if($modifica and $id_campaign['storicizza']=='1'){echo ' selected';} ?> value="1">Si</option>
                                

                          </select>
                         
          
            
              <label style="margin-top:20px" for="message">Test SMS </label>
              <textarea id="testo_sms" <?php echo $disabled_value; ?><?php echo $required_sms_field; ?> class="form-control" name="testo_sms" onkeyup="checklength(0, 640, 'testo_sms', 'charTesto', 'numero_sms')" ><?php if($modifica){echo $id_campaign['testo_sms'];}else{echo'';}?></textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="charTesto" id="charTesto" value="" class="text" value="" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="numero_sms" id="numero_sms" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                     
     
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio" name="mod_invio" class="select2_single form-control" style="width:100%"  <?php echo $required_sms_field; ?> <?php echo $disabled_value;?>>      
                                <option value=""></option>
                                <option value="Interattivo"<?php if($modifica and $id_campaign['mod_invio']=='Interattivo'){ echo ' selected ';} ?>>Interattivo</option>
                                <option <?php if($modifica and $id_campaign['mod_invio']=='Standard'){echo ' selected';} ?> value="Standard">Standard</option>

                          </select>
                        <?php if($modifica and $id_campaign['mod_invio']=='Interattivo'){ ?>
                            <script> 
                                $('#spanLabelLinkTesto').show();
                                $('#link').attr('required', true);                                                                   
                            </script>
                        <?php } 
                         else { ?>
                            <script> 
                                $('#spanLabelLinkTesto').hide();
                                $('#link').attr('required', false);                                                                   
                            </script>
                        <?php } ?>  
                        <span id="spanLabelLinkTesto">
                            <label style="margin-top:20px" id="labelLinkTesto">Link<span id="req_19" class="req">*</span></label>
                            <input  id="link" name="link" type="text" class="form-control col-md-7 col-xs-12" style="text-align:right" tabindex="23" maxlength="400" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['link'] . "\"";
                            else
                                echo "value=\"\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                            
                            onkeyup="checklength(0, 255, 'link', 'charLink', ''); checklengthTotal('charLink','charTesto','numero_totale');"/>
                            <label style="width:100%;"><small>Numero</small><input type="text" name="charLink" id="charLink" class="text" readonly="readonly"  size="3" value="255" placeholder="max 255"onfocus="this.blur()" /></label>   
                            <label style="width:100%;"><small>Totale (SMS+Link)</small><input type="text" name="numero_totale" id="numero_totale" value="" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                        </span>   
                          <br>
                       <label style="margin-top:20px">Tipo Monitoring  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="tipoMonitoring" name="tipoMonitoring" class="select2_single form-control" style="width:100%" <?php echo $required_sms_field; ?> <?php echo $disabled_value; ?>>      
                                <option value=""></option>
                                <option <?php if($modifica and $id_campaign['tipoMonitoring']=='1'){echo ' selected';}?> value="1">ADV Tracking tool</option>
                                <option <?php if($modifica and $id_campaign['tipoMonitoring']=='2'){echo ' selected';}?> value="2">Orphan page</option>
                                <option <?php if($modifica and $id_campaign['tipoMonitoring']=='3'){echo ' selected';}?> value="3">No monitoring</option>
                          </select>
                       <label style="margin-top:20px">Durata SMS  <span class="required">*</span></label>
                          <input type="text" id="sms_duration" name="sms_duration"  class="form-control col-md-7 col-xs-12" value="<?php if($modifica){echo $id_campaign['sms_duration'];}else{echo'2';}?>" <?php echo $required_sms_field; ?> <?php echo $disabled_value; ?>>
                        <img id="info" title="Numero di giorni in cui la rete tenter&agrave; l'invio dell'sms. Range da 1 a 7 giorni." alt="Durata SMS" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
  
        </div> 

        </span>   
        <span id="pos_field" <?php echo $display_pos; ?>> 
            <?php #print_r($stacks); ?>
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label>Categoria & Sottocategoria</label>
                <select id="cat_sott_ins" style="width: 100%" name="cat_sott_id" class="select2_single form-control" <?php echo $required_pos_field ?> <?php echo $disabled_value; ?>>        
                    <?php                               
                    foreach ($cat_sott as $key => $value) {
                        if($modifica and $id_campaign['cat_sott_id']==$value['id']){$selected = ' selected';}
                        else{$selected = '';}
                        echo '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                    ?>  
                </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_pos" name="day_val_pos"  min="1" max="31" <?php echo $required_pos_field ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val_pos'])){echo $id_campaign['day_val_pos']; }?>">                         
            </div>
            <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)
                <img  title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>

                    <textarea id="callguide_icm" name="callguide_icm" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" <?php echo $required_callguide_icm; ?> <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica){echo stripslashes($id_campaign['callguide_icm']); }?></textarea>
                    
        </div>

        </span> 
    <span id="span_40400" <?php echo $display_40400; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label>Alias Attivazione</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="text" id="alias_attiv" name="alias_attiv"  <?php echo $required_400 ?> placeholder="alfanumerico"  class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['alias_attiv'])){echo $id_campaign['alias_attiv']; }?>">
                <br><br>
                <label  class="control-label" for="day_val">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val" name="day_val"  min="1" max="31"  <?php echo $required_400 ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val'])){echo $id_campaign['day_val']; }?>">
                <br><br>
                <label  class="control-label" for="note">SMS Presa in carico</label>
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_incarico" name="sms_incarico"  <?php echo $required_400 ?> placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($id_campaign['sms_incarico'])){echo $id_campaign['sms_incarico']; }?></textarea>
                <br><br>
                <label class="control-label" for="sms_target">SMS Non in Tanget</label>            
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_target" name="sms_target"   <?php echo $required_400 ?> placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($id_campaign['sms_target'])){echo $id_campaign['sms_target']; }?></textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Adesione già Avvenuta</label>
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_adesione" name="sms_adesione"    <?php echo $required_400 ?>placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($id_campaign['sms_adesione'])){echo $id_campaign['sms_adesione']; }?></textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Non Disponibile</label>
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_nondisponibile" name="sms_nondisponibile"   <?php echo $required_400 ?>placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($id_campaign['sms_nondisponibile'])){echo $id_campaign['sms_nondisponibile']; }?></textarea>
        </div>
    </span> 
    <span id="span_app_inbound" <?php echo $display_app_inbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_app_inbound" name="day_val_app_inbound"  min="1" max="31" <?php echo $required_app_inbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val_app_inbound'])){echo $id_campaign['day_val_app_inbound']; }?>">
                <br><br>
                <label  class="control-label">Priorità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="prior_app_inbound" name="prior_app_inbound"  min="0" max="9"  <?php echo $required_app_inbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['prior_app_inbound'])){echo $id_campaign['prior_app_inbound']; }?>">
                <br><br>                                
        </div>
        <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)
                <img  title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>

                    <textarea id="callguide_app_inbound" name="callguide_app_inbound" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" <?php echo $required_callguide_app_inbound; ?> <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica){echo stripslashes($id_campaign['callguide_app_inbound']); }?></textarea>
                    
        </div> 
    </span>
    <span id="span_app_outbound" <?php echo $display_app_outbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_app_outbound" name="day_val_app_outbound"  min="1" max="31" <?php echo $required_app_outbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val_app_outbound'])){echo $id_campaign['day_val_app_outbound']; }?>">
                <br><br>
                <label  class="control-label">Priorità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="prior_app_outbound" name="prior_app_outbound"  min="0" max="9"  <?php echo $required_app_outbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['prior_app_outbound'])){echo $id_campaign['prior_app_outbound']; }?>">
                <br><br>                                
        </div>
    </span>   
    <span id="span_dealer" <?php echo $display_dealer; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Cod. iniziativa</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="Cod_iniziativa" name="Cod_iniziativa"  min="1"  <?php echo $required_dealer ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['Cod_iniziativa'])){echo $id_campaign['Cod_iniziativa']; }?>">
                <br><br>                             
        </div>
    </span>
    <span id="span_icm" <?php echo $display_icm; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_icm" name="day_val_icm"  min="1" max="31" <?php echo $required_icm ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val_icm'])){echo $id_campaign['day_val_icm']; }?>">
                <br><br>                             
        </div>
        <div  class="col-md-6 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)
                <img  title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>

                    <textarea id="callguide_icm" name="callguide_icm" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" <?php echo $required_icm; ?> <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica){echo stripslashes($id_campaign['callguide_icm']); }?></textarea>
                    
        </div>
    </span>
    <span id="span_ivr_inbound" <?php echo $display_ivr_inbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_ivr_inbound" name="day_val_ivr_inbound"  min="1" max="31" <?php echo $required_ivr_inbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val_ivr_inbound'])){echo $id_campaign['day_val_ivr_inbound']; }?>">
                <br><br>                             
        </div>
    </span>
    <span id="span_ivr_outbound" <?php echo $display_ivr_outbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_ivr_outbound" name="day_val_ivr_outbound"  min="1" max="31" <?php echo $required_ivr_outbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['day_val_ivr_outbound'])){echo $id_campaign['day_val_ivr_outbound']; }?>">
                <br><br>                             
        </div>
    </span>
    <span id="span_jakala" <?php echo $display_jakala; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Data invio JAKALA</label>
                <input id="data_invio_jakala" <?php if ($readonly){echo $disabled_value;}?> type="text" class="form-control has-feedback-left"  placeholder="Data Invio Jakala" aria-describedby="inputSuccessJakala" required="required" name="data_invio_jakala" value="<?php if(isset($id_campaign['data_invio_jakala'])){echo date('d/m/Y', strtotime($id_campaign['data_invio_jakala']));}?>">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccessJakala" class="sr-only">(success)</span>                             
        </div>
    </span>
    <span id="span_spai" <?php echo $display_spai; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Data invio SPAI</label>
                <input id="data_invio_spai" <?php if ($readonly){echo $disabled_value;}?> type="text" class="form-control has-feedback-left"  placeholder="Data Invio Spai" aria-describedby="inputSuccessSpai" required="required" name="data_invio_spai" value="<?php if(isset($id_campaign['data_invio_spia'])){echo date('d/m/Y', strtotime($id_campaign['data_invio_spai']));}?>">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccessSpai" class="sr-only">(success)</span>                             
        </div>
    </span>    
    <span id="span_mfh" <?php echo $display_mfh; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia MFH</label>
                <select  id="type_mfh" name="type_mfh" class="select2_single form-control" <?php echo $required_mfh ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php if($modifica and $id_campaign['type_mfh']=='ACCREDITI'){ echo ' selected';}?> value="ACCREDITI">ACCREDITI</option>
                    <option <?php if($modifica and $id_campaign['type_mfh']=='ATTIVAZIONI'){ echo ' selected';}?> value="ATTIVAZIONI">ATTIVAZIONI</option>
                    <option <?php if($modifica and $id_campaign['type_mfh']=='CAMBIO PIANO'){ echo ' selected';}?> value="CAMBIO PIANO">CAMBIO PIANO</option>
                    <option <?php if($modifica and $id_campaign['type_mfh']=='PROROGA'){ echo ' selected';}?> value="PROROGA">PROROGA</option>
                    <option <?php if($modifica and $id_campaign['type_mfh']=='RINNOVO SIM'){ echo ' selected';}?> value="RINNOVO SIM">RINNOVO SIM</option>
                </select>                           
        </div>
    </span>
    <span id="span_watson" <?php echo $display_watson; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Campagna Watson</label>
                <select  id="type_watson" name="type_watson" class="select2_single form-control" <?php echo $required_watson ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Add On'){ echo ' selected';}?> value="Add On">Add On</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Cambio Offerta su CredRes'){ echo ' selected';}?> value="Cambio Offerta su CredRes">Cambio Offerta su CredRes</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Cambio Piano con MDP'){ echo ' selected';}?> value="Cambio Piano con MDP">Cambio Piano con MDP</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Cross Selling'){ echo ' selected';}?> value="Cross Selling">Cross Selling</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Migrazione verso Fibra'){ echo ' selected';}?> value="Migrazione verso Fibra">Migrazione verso Fibra</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Offerta Linea Fissa'){ echo ' selected';}?> value="Offerta Linea Fissa">Offerta Linea Fissa</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Rivincolo cliente in scadenza'){ echo ' selected';}?> value="Rivincolo cliente in scadenza">Rivincolo cliente in scadenza</option>
                </select>                           
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Contatto Watson</label>
                <select  id="contact_watson" name="contact_watson" class="select2_single form-control" <?php echo $required_watson ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Provisioning Automatico'){ echo ' selected';}?> value="Provisioning Automatico">Provisioning Automatico</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Reinstradamento su Operatore'){ echo ' selected';}?> value="Reinstradamento su Operatore">Reinstradamento su Operatore</option>
                    <option <?php if($modifica and $id_campaign['type_watson']=='Tripletta CRM'){ echo ' selected';}?> value="Tripletta CRM">Tripletta CRM</option>
                </select>                           
        </div>
    </span>

</div>                    



<script>
$(document).ready(function() {  
    
    //gestione nome campagna
    $('#channel_ins').on('select2:select', function () {  
            console.log ('eccociii '+ $('#channel_ins :selected').text());
            
            if (document.getElementById('nomecampagna').value.length > 0) {
            var pref_nome_campagna = document.getElementById('nomecampagna').value;
            var myarr = pref_nome_campagna.split("_");
            data_label = myarr[0];
            //if (myarr[1].value.length > 0)
            squad_label = "_" + myarr[1];
            channel_label = "_" + myarr[2];
            //if (myarr[2].value.length > 0)
            type_label = "_" + myarr[3];
            note_lable = "_" + myarr[4];
    
        }
            $.getJSON("get_label.php", {channel_id: $(this).val()}, function (dati) {
                channel_label = "_" + dati[0].etichetta;
                document.getElementById('nomecampagna').value = data_label + squad_label + channel_label + type_label + note_label;
            });
        });
      
        
 

//gestione upload file
var myDropzoneCanale = new Dropzone(
        '#dropzone-canale',
        {          
            init: function () {
             this.options.dictRemoveFileConfirmation = "Confermi di voler eliminare il File?";   
           //solo su Modifica o Duplica     
           <?php if($modifica) {?>     
            thisCanale = this;        
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "scan_uploaded.php",
                    data: { id_dir: '<?php echo $id_campaign['id']; ?>',subdir: 'canale'},
                    success: function (data) {
            
                    $.each(data, function(key,value){
                        var filename = value.name; 
                        var a = document.createElement('a');
                                a.setAttribute('class',"dz-remove");
                                //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                                a.setAttribute('href',"upload.php?download=<?php echo $id_campaign['id']; ?>&canale&file=" + filename);
                                a.setAttribute('target', '_blank');
                                a.innerHTML = "Download file";
                        var mockFile = { name: value.name, size: value.size };                        
                        thisCanale.options.thumbnail.call(thisCanale, mockFile);
                        thisCanale.options.addedfile.call(thisCanale, mockFile);
                        thisCanale.options.success.call(thisCanale, mockFile);
                        thisCanale.options.complete.call(thisCanale, mockFile);
                        document.getElementById("dropzone-canale").lastChild.appendChild(a);

                    });
                
                }
            });
       <?php  } ?>

            this.on("removedfile", function(file) {
                        console.log('removedfile on');

                        var filename = file.name; 

                                $.ajax({
                                url: "upload.php",
                                data: { filename: filename, action: 'delete', id_upload: '<?php echo $id_upload; ?>',subdir: 'canale'},
                                type: 'POST',
                                success: function (data) {
                                    if (data.NotificationType === "Error") {
                                        console.log('error 1');
                                        //toastr.error(data.Message);
                                    } else {
                                        //toastr.success(data.Message);
                                        console.log('error 2');                          
                                    }
                                    },
                                    error: function (data) {
                                        //toastr.error(data.Message);
                                        console.log('error 3');
                                    }
                                })

                });


                this.on("processing", function (file) {
                        });
                this.on("maxfilesexceeded",
                            function (file) {
                                this.removeAllFiles();
                                this.addFile(file);
                            });
                this.on("success",
                            function (file, responseText) {
                                var filename = file.name; 
                                var a = document.createElement('a');
                                a.setAttribute('class',"dz-remove");
                                //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                                a.setAttribute('href',"upload.php?download=<?php echo $id_upload; ?>&canale&file=" + filename);
                                a.setAttribute('target', '_blank');
                                a.innerHTML = "Download file";
                                file.previewTemplate.appendChild(a);
                            // do something here
                            });
                        this.on("error",
                            function (data, errorMessage, xhr) {
                                // do something here
                            });
                    }
        });

    $('#data_invio_jakala').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY"
      }
    });

    $('#data_invio_spai').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY"
      }
    });

    $('#channel_ins').on('select2:select', function() {
      var selected_channel_id = $('#channel_ins').val();
        //alert($('#channel_ins').val());
        $('#cat_sott_ins').attr('required', false);
        $('#sms_duration').attr('required', false);
        $('#tipoMonitoring').attr('required', false);
        $('#link').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#senders_ins').attr('required', false);
        $('#callguide2').attr('required', false);
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false); 
      $(this).parsley().validate();

      if (selected_channel_id === '12') {
        $('#sms_field').show();
        $('#sms_duration').attr('required', true)
        $('#tipoMonitoring').attr('required', true)
        $('#link').attr('required', true)
        $('#mod_invio').attr('required', true)
        $('#testo_sms').attr('required', true)
        $('#storicizza_ins').attr('required', true)
        $('#senders_ins').attr('required', true)

        $('#pos_field').hide();
        $('#span_call_guide2').hide();

        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id
          },
          dataType: "html",
          success: function(data) {
            console.log('eccoli data' + JSON.stringify(data));
            console.log('eccoli2 data' + data);
            $("#senders_ins").fadeOut();
            $("#senders_ins").fadeIn();
            $("#senders_ins").html(data);
            //$("#selected_senders") = data;

          }

        });

      } else if (selected_channel_id === '13') {//CRM DA POS
            $('#sms_field').hide();
            $('#span_40400').hide();
            $('#span_spai').hide();
            $('#span_mfh').hide();
            $('#span_jakala').hide();
            $('#span_ivr_inbound').hide();
            $('#span_ivr_outbound').hide();
            $('#span_dealer').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
            $('#span_watson').hide();
            $('#pos_field').show();

        $('#cat_sott_ins').attr('required', true)
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins").fadeOut();
            $("#cat_sott_ins").fadeIn();
            $("#cat_sott_ins").html(data);

          }

        });
        } 
        else if (selected_channel_id === '14') {// 40400
            $('#sms_field').hide();
            $('#pos_field').hide();
            $('#span_spai').hide();
            $('#span_mfh').hide();
            $('#span_jakala').hide();
            $('#span_ivr_inbound').hide();
            $('#span_ivr_outbound').hide();
            $('#span_dealer').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
            $('#span_watson').hide();
            $('#span_40400').show();

          
          $('#callguide2').attr('required', true);
          $('#alias_attiv').attr('required', true);
          $('#day_val').attr('required', true);
          $('#sms_incarico').attr('required', true);
          $('#sms_target').attr('required', true);
          $('#sms_adesione').attr('required', true);
          $('#sms_nondisponibile').attr('required', true); 
      } 
      else if (selected_channel_id === '21') {//canale ICM
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_outbound').hide();
        $('#span_watson').hide();
        $('#span_icm').show();         
      }
      else if (selected_channel_id === '15') {//canale APP INBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_app_inbound').show();
      }
      else if (selected_channel_id === '16') {//canale APP OUTBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_app_outbound').show();
      }
      else if (selected_channel_id === '33') {//canale DEALER
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_dealer').show();
      }
     else if (selected_channel_id === '22') {//canale IVR INBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_ivr_inbound').show();
      }
      else if (selected_channel_id === '23') {//canale IVR OUTBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_ivr_outbound').show();
      }
      else if (selected_channel_id === '24') {//canale JAKALA
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_jakala').show();
      }
      else if (selected_channel_id === '31') {//canale MFH
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_mfh').show();
      }
      else if (selected_channel_id === '35') {//canale SPAI
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
        $('#span_spai').show();
      }
     else if (selected_channel_id === '29') {//canale watson
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').show();
      }
      else {
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
        $('#span_watson').hide();
      }
      console.log('channel_id  ' + selected_channel_id);

    });


});





</script>