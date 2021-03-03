<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
    <br/>
    <div class="col-md-8 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Canale  <span class="required">*</span>
                <img  title="Inserire nel primo Canale il Canale Prioritario della Campagna" alt="Control Group" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
            <?php
                $canale = array(); 
                if(isset($id_campaign['addcanale']) and isset(json_decode($id_campaign['addcanale'],true)[0])){
                    $canale = json_decode($id_campaign['addcanale'],true)[0]; 
                } 
                            $list = $funzioni_admin->get_list_id('channels');
                            $lista_field = array_column($list, 'id');
                            $lista_name = array_column($list, 'name');
                            $javascript = $disabled_value.' required="required" ';
                            $display_sms =  ' style="display: none;"';                        
                            $required_sms = '';                            
                            $required_pos = '';
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
                            $required_spai = '';
   
                                                      
                            if ($modifica){
                                
                                $valore_channel_id = $id_campaign['channel_id'];
                                //sms
                                if($valore_channel_id==12){$display_sms =  ''; $required_sms =  ' required="required" ';}
                                //CRM Da POS
                                if($valore_channel_id==13){$display_pos =  ''; $required_pos = ' required="required" ';} 
                                //40400
                                if($valore_channel_id==14){$display_40400 =  ''; $required_400 = ' required="required" ';}  
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
                                //Spai
                                if($valore_channel_id==35){$display_spai =  ''; $required_spai = ' required="required" ';}                                   
                            }
                            else{
                                $valore_channel_id = "";
                            }
                                $funzioni_admin->stampa_select2('channel_ins', $lista_field, $lista_name, $javascript, $style, $valore_channel_id, 'channel_id');
                            ?>           
            <input type="hidden" id="canale_zero" name="addcanale[0][channel_id]" value="<?php if(isset($id_campaign['channel_id'])) echo $id_campaign['channel_id'] ?>" >
            
            </div>
        </div> 

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo <span class="required">*</span></label> 
            <div class="col-md-6 col-sm-6 col-xs-12">
                <?php 
                $select_monoleva = '';
                $select_info = '';
                $display_info = ' style="display: none;"';
                $display_mono = ' style="display: none;"';
                $select_multileva = '';
                //$display_multi = ' style="display: none;"';             
                if($modifica and $id_campaign['tipo_leva']=='mono'){
                    $select_monoleva = ' selected';
                    $display_mono = '';                   
                }
                if($modifica and $id_campaign['tipo_leva']=='multi'){$select_multileva = ' selected';$display_multi='';}   
                if($modifica and $id_campaign['tipo_leva']=='info'){$select_info = ' selected';$display_info='';}               
                ?>
                <select  id="idlevaselect" name="tipo_leva" class="select2_single form-control"  required="required" onchange="levaselect()"  <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php echo $select_info; ?> value="info">Informativa</option>
                    <option <?php echo $select_monoleva; ?> value="mono">MonoOfferta</option>
                    <option <?php echo $select_multileva; ?> value="multi" >MultOfferta</option>

                </select>
            </div>
        </div>  
        <span id="monoleva" <?php echo $display_mono; ?>>
        <!--  
            <div class="form-group">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">Opzione  <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="opzione_leva" name="opzione_leva" class="select2_single form-control" <?php //echo $disabled_value;?>>       
                        <option <?php //if($modifica and $canale['opzione_leva']=='0'){echo ' selected';} ?> value=""></option>
                        <option <?php //if($modifica and $canale['opzione_leva']=='Ropz'){echo ' selected';} ?> value="Ropz">Ropz</option>
                        <option <?php //if($modifica and $canale['opzione_leva']=='Popz'){echo ' selected';} ?>value="Ropz">Popz</option>

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
  

        </span>     
        

            <div class="form-group">
                <br />
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">File Upload 
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">             

                    <div class="x_content">                                             
                                        
                        <form id="dropzone-canale" action="upload.php?id_upload=<?php echo $id_upload; ?>&canale"  class="dropzone">
                        </form>
                        <br />
                    </div>
                </div>   
            </div>  
    

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
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Data Fine Campagna
            </label>
            <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                <input id="data_fine_validita_offerta" <?php if ($readonly){echo $disabled_value;}?> type="text" class="form-control has-feedback-left"  placeholder="Data Fine Campagna" aria-describedby="inputSuccess2Status3" required="required" name="data_fine_validita_offerta" value="<?php if(isset($id_campaign['data_fine_validita_offerta'])){echo date('d/m/Y', strtotime($id_campaign['data_fine_validita_offerta']));}?>">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Escludi Sab/Dom<span class="required">*</span></label>
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
                            <select id="senders_ins" name="addcanale[0][sender_id]" class="select2_single form-control" style="width:100%"  <?php echo $required_sms; ?> <?php echo $disabled_value;?>>      
                                <?php                               
                                foreach ($sender as $key => $value) {
                                    if($modifica and isset($canale['sender_id']) && $canale['sender_id']==$value['id']){$selected = ' selected';}
                                    else{$selected = '';}
                                    echo '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . '</option>';
                                }
                                ?> 
                          </select>
                        
                       <label style="margin-top:20px">Storicizzazione Legale  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="storicizza_ins" name="addcanale[0][storicizza]" class="select2_single form-control" style="width:100%"  <?php echo $required_sms; ?> <?php echo $disabled_value;?>>
                                <option <?php if($modifica and $canale['storicizza']=='0'){echo ' selected';} ?> value="0">No</option>
                                <option <?php if($modifica and $canale['storicizza']=='1'){echo ' selected';} ?> value="1">Si</option>
                                

                          </select>
                     <label style="margin-top:20px">Notifica Consegna  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="notif_consegna" name="addcanale[0][notif_consegna]" class="select2_single form-control" style="width:100%"  <?php echo $required_sms; ?> <?php echo $disabled_value;?>>                                
                                <option <?php if($modifica and $canale['notif_consegna']=='0'){echo ' selected';} ?> value="0">No</option>
                                <option <?php if($modifica and $canale['notif_consegna']=='1'){echo ' selected';} ?> value="1">Si</option>
                                

                          </select>
                         
          
            
              <label style="margin-top:20px" for="message">Testo SMS<span class="required">*</span></label>
              <textarea id="testo_sms" <?php echo $disabled_value; ?><?php echo $required_sms; ?> class="form-control" name="addcanale[0][testo_sms]" rows="8"	data-parsley-pattern="/^[a-zA-Z0-9-#/()%&\[\]{}!,.?£$@$' ]+$/gi" data-parsley-pattern-message="Caratteri come '€' ' ’ ' ed altri caratteri speciali non sono accettati come testo SMS !!" onkeyup="checklength(0, 640, 'testo_sms', 'charTesto', 'numero_sms')" ><?php if($modifica){echo $canale['testo_sms'];}else{echo'';}?></textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="addcanale[0][charTesto]" id="charTesto" value="<?php if($modifica and isset($canale['charTesto'])){echo $canale['charTesto'];} ?>" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" onfocus="this.blur();" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="addcanale[0][numero_sms]" id="numero_sms" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="<?php if($modifica and isset($canale['numero_sms'])){echo $canale['numero_sms'];} else{echo 0;} ?>" onfocus="this.blur();" /></label>                  
                     
     
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio" name="addcanale[0][mod_invio]" class="select2_single form-control" style="width:100%" <?php echo $required_sms; ?> <?php echo $disabled_value;?>>      
                                <option value="Standard" <?php if($modifica and $canale['mod_invio']=='Standard'){echo ' selected';} ?>>Standard</option>
                                <option value="MST" <?php if($modifica and $canale['mod_invio']=='MST'){echo ' selected ';} ?>>MST</option>
                                <option value="Interattivo" <?php if($modifica and $canale['mod_invio']=='Interattivo'){ echo ' selected ';} ?>>Interattivo</option>
                                

                          </select>
                        <?php if($modifica and $canale['mod_invio']=='Interattivo'){ ?>
                            <script> 
                                $('#spanLabelLinkTesto').show();                                
                                $('#link').attr('required', true);
                                //$('#tipoMonitoring').attr('required', true);                                                                
                            </script>
                        <?php } 
                         else { ?>
                            <script> 
                                $('#spanLabelLinkTesto').hide();            
                                $('#link').attr('required', false);
                                //$('#tipoMonitoring').attr('required', false);                                                                 
                            </script>
                        <?php } ?>  
                        <span id="spanLabelLinkTesto" style="display: none;">
                            <label style="margin-top:20px" id="labelLinkTesto">Link<span id="req_19" class="req">*</span></label>
                            <input  id="link" name="addcanale[0][link]" type="url" class="form-control col-md-7 col-xs-12"  data-parsley-type='url' maxlength="400" data-parsley-maxlength='400' 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $canale['link'] . "\"";
                            else
                                echo "value=\"\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                            
                            onkeyup="checklength(0, 255, 'link', 'charLink', ''); checklengthTotal('charLink','charTesto','numero_totale');"/>
                            <label style="width:100%;"><small>Numero</small><input type="text" name="addcanale[0][charLink]" id="charLink" class="text" readonly="readonly"  size="3" value="255" placeholder="max 255"onfocus="this.blur()" /></label>   
                            <label style="width:100%;"><small>Totale (SMS+Link)</small><input type="text" name="addcanale[0][numero_totale]" id="numero_totale" value="" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                          
                          <br>
                       <!--<label style="margin-top:20px">Tipo Monitoring  <span class="required">*</span></label>                                    
                            <select id="tipoMonitoring" name="addcanale[0][tipoMonitoring]" class="select2_single form-control" style="width:100%"  <?php //echo $disabled_value; ?>>      
                                <option value=""></option>
                                <option <?php //if($modifica and $canale['tipoMonitoring']=='1'){echo ' selected';}?> value="1">ADV Tracking tool</option>
                                <option <?php //if($modifica and $canale['tipoMonitoring']=='2'){echo ' selected';}?> value="2">Orphan page</option>
                                <option <?php //if($modifica and $canale['tipoMonitoring']=='3'){echo ' selected';}?> value="3">No monitoring</option>
                          </select>-->
                      </span>     
  
        </div> 

    </span>   
    <span id="pos_field" <?php echo $display_pos; ?>> 
            <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Titolo & Sottotitolo<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?> type="text" id="tit_sott_pos" name="addcanale[0][tit_sott_pos]" placeholder="testo"  data-parsley-trigger="keyup" data-parsley-maxlength="200" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['tit_sott_pos'])){echo $canale['tit_sott_pos']; }?>" <?php echo $required_pos; ?> >                         
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12"><br>
                <label>Categoria & Sottocategoria<span class="required">*</span></label></label>
                <select id="cat_sott_ins" style="width: 100%" name="addcanale[0][cat_sott_id]" class="select2_single form-control" <?php echo $required_pos; ?> <?php echo $disabled_value; ?>>        
                    <?php                               
                    foreach ($cat_sott as $key => $value) {
                        if($modifica and $canale['cat_sott_id']==$value['id']){$selected = ' selected';}
                        else{$selected = '';}
                        echo '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                    ?>  
                </select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12"><br>     
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?> type="number" id="day_val_pos" name="addcanale[0][day_val_pos]"  min="1" max="31" <?php //echo $required_pos ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val_pos'])){echo $canale['day_val_pos']; }?>">                         
            </div>
            <div  class="col-md-4 col-sm-6 col-xs-12" ><br>
                <label class="control-label">Call Guide (4000 chars max)</label>
                <textarea id="callguide_pos" name="addcanale[0][callguide_pos]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000"  <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica and (isset($canale['callguide_pos']))){echo stripslashes($canale['callguide_pos']); }?></textarea>                    
            </div>

    </span> 
    <span id="span_40400" <?php echo $display_40400; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label>Alias Attivazione<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="text" id="alias_attiv" name="addcanale[0][alias_attiv]"  <?php echo $required_400 ?> placeholder="alfanumerico"  class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['alias_attiv'])){echo $canale['alias_attiv']; }?>">
                <br><br>
                <label  class="control-label" for="day_val">Giorni di Validità<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val" name="addcanale[0][day_val]"  min="1" max="31"  <?php echo $required_400 ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val'])){echo $canale['day_val']; }?>">
                <br><br>
                <label  class="control-label" for="note">SMS Presa in carico<span class="required">*</span></label>
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_incarico" name="addcanale[0][sms_incarico]"  <?php echo $required_400 ?> placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($canale['sms_incarico'])){echo $canale['sms_incarico']; }?></textarea>
                <br><br>
                <label class="control-label" for="sms_target">SMS Non in Tanget<span class="required">*</span></label>            
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_target" name="addcanale[0][sms_target]"   <?php echo $required_400 ?> placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160"   data-parsley-trigger="keyup"  class="form-control col-md-7 col-xs-12" ><?php if(isset($canale['sms_target'])){echo $canale['sms_target']; }?></textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Adesione già Avvenuta<span class="required">*</span></label>
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_adesione" name="addcanale[0][sms_adesione]"    <?php echo $required_400 ?>placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($canale['sms_adesione'])){echo $canale['sms_adesione']; }?></textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Non Disponibile<span class="required">*</span></label>
                <textarea <?php if ($readonly){echo $disabled_value;}?> rows="2" id="sms_nondisponibile" name="addcanale[0][sms_nondisponibile]"   <?php echo $required_400 ?>placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" ><?php if(isset($canale['sms_nondisponibile'])){echo $canale['sms_nondisponibile']; }?></textarea>
        </div>
    </span> 
    <span id="span_app_inbound" <?php echo $display_app_inbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">
                <label  class="control-label">Id News<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="text" id="id_news_app_inbound" name="addcanale[0][id_news_app_inbound]" <?php echo $required_app_inbound ?> placeholder="testo"  data-parsley-trigger="keyup" data-parsley-maxlength="200" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['id_news_app_inbound'])){echo $canale['id_news_app_inbound']; }?>">
                <br><br>      
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_app_inbound" name="addcanale[0][day_val_app_inbound]"  min="1" max="31" <?php //echo $required_app_inbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val_app_inbound'])){echo $canale['day_val_app_inbound']; }?>">
                <br><br>
                <label  class="control-label">Priorità</label>                
                      <select id="prior_app_inbound" name="addcanale[0][prior_app_inbound]" class="select2_single form-control" style="width:100%"  <?php echo $required_app_inbound; ?> <?php echo $disabled_value;?>>
                            <option <?php if($modifica and isset($canale['prior_app_inbound']) && $canale['prior_app_inbound']=='1'){echo ' selected';} ?> value="1">HIGH</option>        
                            <option <?php if($modifica and isset($canale['prior_app_inbound']) && $canale['prior_app_inbound']=='0'){echo ' selected';} ?> value="0">LOW </option>                                                            
                        </select>
                <br><br>
                                         
        </div>
        <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)</label>

                    <textarea id="callguide_app_inbound" name="addcanale[0][callguide_app_inbound]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000"  <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica && isset($canale['callguide_app_inbound'])){echo stripslashes($canale['callguide_app_inbound']); }?></textarea>
                    
        </div> 
    </span>
    <span id="span_app_outbound" <?php echo $display_app_outbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">
                <label  class="control-label">Id News<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="text" id="id_news_app_outbound" name="addcanale[0][id_news_app_outbound]" <?php echo $required_app_outbound; ?> placeholder="testo"  data-parsley-trigger="keyup" data-parsley-maxlength="200" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['id_news_app_outbound'])){echo $canale['id_news_app_outbound']; }?>">
                <br><br>     
                <label  class="control-label">Giorni di Validità</label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_app_outbound" name="addcanale[0][day_val_app_outbound]"  min="1" max="31"  placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val_app_outbound'])){echo $canale['day_val_app_outbound']; }?>">
                <br><br>
                <label  class="control-label">Push Notification<span class="required">*</span></label>
                            <select id="notif_app_outbound" name="addcanale[0][notif_app_outbound]" class="select2_single form-control" style="width:100%"  <?php //echo $required_app_outbound; ?> <?php echo $disabled_value;?>>
                                <option <?php if($modifica and isset($canale['notif_app_outbound']) && $canale['notif_app_outbound']=='0'){echo ' selected';} ?> value="0">N</option>
                                <option <?php if($modifica and isset($canale['notif_app_outbound']) && $canale['notif_app_outbound']=='1'){echo ' selected';} ?> value="1">Y</option>
                                

                          </select>
                       
                <label  class="control-label">Priorità<span class="required">*</span></label>
                <!--<input <?php //if ($readonly){echo $disabled_value;}?>type="number" id="prior_app_outbound" name="addcanale[0][prior_app_outbound]"  min="0" max="9"  <?php //echo $required_app_outbound; ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php //if(isset($canale['prior_app_outbound'])){echo $canale['prior_app_outbound']; }?>">-->
                        <select id="prior_app_outbound" name="addcanale[0][prior_app_outbound]" class="select2_single form-control" style="width:100%"  <?php echo $required_app_outbound; ?> <?php echo $disabled_value;?>>
                            <option <?php if($modifica and isset($canale['prior_app_outbound']) && $canale['prior_app_outbound']=='1'){echo ' selected';} ?> value="1">HIGH</option>        
                            <option <?php if($modifica and isset($canale['prior_app_outbound']) && $canale['prior_app_outbound']=='0'){echo ' selected';} ?> value="0">LOW </option>                                                            
                        </select>
                                           
        </div>
                <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)</label>

                    <textarea id="callguide_app_outbound" name="addcanale[0][callguide_app_outbound]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000"  <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica && isset($canale['callguide_app_outbound'])){echo stripslashes($canale['callguide_app_outbound']); }?></textarea>
                    
        </div> 
    </span>   
    <span id="span_dealer" <?php echo $display_dealer; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Iniziative Dealer da gestire<span class="required">*</span></label>
                <select  id="iniziative_dealer" name="addcanale[0][count_iniziative_dealer]" class="select2_single form-control" <?php echo $required_dealer ?> <?php echo $disabled_value;?>>
                    
                <?php 
                for($i=2; $i<=9; $i++){
                    $display_cod[$i] = ' style="display: none;" '; 
                    $required_dealer_plus[$i] = '';
                    if($modifica and isset($canale['count_iniziative_dealer']) and ($i<=$canale['count_iniziative_dealer'])){
                        $display_cod[$i] = ' ';
                        $required_dealer_plus[$i] = ' required="requuired" ';
                    }
                }    
                
                for($i=1; $i<=9; $i++){
                    echo'<option ';
                    if($modifica and isset($canale['count_iniziative_dealer']) and $canale['count_iniziative_dealer']==$i){ 
                        echo ' selected';
                    }
                    echo ' value='.$i.' >'.$i.'</option>';
                }
                ?>
                     
                </select><br>                           
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12" id="dealer_1">      
                <label  class="control-label">Cod. iniziativa 1<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="Cod_iniziativa" name="addcanale[0][Cod_iniziativa]"   <?php echo $required_dealer; ?> min="0" max="999" placeholder="numerico da min 0 a max 999"  data-parsley-trigger="keyup" data-parsley-minlength="0" data-parsley-maxlength="3" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['Cod_iniziativa'])){echo $canale['Cod_iniziativa']; }?>">
                <br><br>                             
        </div>
        <?php 
                for($i=2; $i<=9; $i++){
                ?>    
                    <div class="col-md-4 col-sm-6 col-xs-12" id="dealer_<?php echo $i; ?>" <?php echo $display_cod[$i]; ?> >      
                        <label  class="control-label">Cod. iniziativa <?php echo $i; ?><span class="required">*</span></label>                        
                        <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="Cod_iniziativa<?php echo $i; ?>" name="addcanale[0][Cod_iniziativa<?php echo $i; ?>]"   <?php echo $required_dealer_plus[$i]; ?> min="0" max="999" placeholder="numerico da min 0 a max 999"  data-parsley-trigger="keyup" data-parsley-minlength="0" data-parsley-maxlength="3" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['Cod_iniziativa'.$i.''])){echo $canale['Cod_iniziativa'.$i.'']; }?>">
                        <br><br>                             
                    </div>
                <?php     
                }  
        ?>        

    </span>
    <span id="span_icm" <?php echo $display_icm; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_icm" name="addcanale[0][day_val_icm]"  min="1" max="31" <?php echo $required_icm; ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val_icm'])){echo $canale['day_val_icm']; }?>">
                                            
        </div>
        <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)<span class="required">*</span></label>
                <textarea id="callguide_icm" name="addcanale[0][callguide_icm]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" <?php echo $required_icm; ?> <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica && isset($canale['callguide_icm'])){echo stripslashes($canale['callguide_icm']); }?></textarea>                    
        </div>
    </span>
    <span id="span_ivr_inbound" <?php echo $display_ivr_inbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_ivr_inbound" name="addcanale[0][day_val_ivr_inbound]"  min="1" max="31" <?php echo $required_ivr_inbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val_ivr_inbound'])){echo $canale['day_val_ivr_inbound']; }?>">
                <br><br>                             
        </div>
    </span>
    <span id="span_ivr_outbound" <?php echo $display_ivr_outbound; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità<span class="required">*</span></label>
                <input <?php if ($readonly){echo $disabled_value;}?>type="number" id="day_val_ivr_outbound" name="addcanale[0][day_val_ivr_outbound]"  min="1" max="31" <?php echo $required_ivr_outbound ?> placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="<?php if(isset($canale['day_val_ivr_outbound'])){echo $canale['day_val_ivr_outbound']; }?>">
                <br><br>                             
        </div>
    </span>
    <span id="span_jakala" <?php echo $display_jakala; ?>>

        <div class="col-md-4 col-sm-6 col-xs-12">    
                <label class="control-label col-md-6 col-sm-3 col-xs-12">Data invio JAKALA<span class="required">*</span></label>
                <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                    <input id="data_invio_jakala" <?php if ($readonly){echo $disabled_value;}?> type="text" class="form-control has-feedback-rigth"  placeholder="Data Invio Jakala" aria-describedby="inputSuccessJakala" required="required" name="addcanale[0][data_invio_jakala]" value="<?php if(isset($canale['data_invio_jakala'])){echo $canale['data_invio_jakala'];}?>">
                    <span class="fa fa-calendar-o form-control-feedback rigth" aria-hidden="true"></span>
                    <span id="inputSuccessJakala" class="sr-only">(success)</span>
                </div>                             
        </div>
    </span>
    <span id="span_spai" <?php echo $display_spai; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">
                <label class="control-label col-md-6 col-sm-3 col-xs-12">Data invio SPAI<span class="required">*</span></label>
                <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                    <input id="data_invio_spai" <?php if ($readonly){echo $disabled_value;}?> type="text" class="form-control has-feedback-rigth"  placeholder="Data Invio Spai" aria-describedby="inputSuccessSpai" required="required" name="addcanale[0][data_invio_spai]" value="<?php if(isset($canale['data_invio_spai'])){echo $canale['data_invio_spai'];}?>">
                    <span class="fa fa-calendar-o form-control-feedback rigth" aria-hidden="true"></span>
                    <span id="inputSuccessSpai" class="sr-only">(success)</span>
                </div>                                 
        </div>
    </span>    
    <span id="span_mfh" <?php echo $display_mfh; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia MFH<span class="required">*</span></label>
                <select  id="type_mfh" name="addcanale[0][type_mfh]" class="select2_single form-control" <?php echo $required_mfh ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php if($modifica and isset($canale['type_mfh']) and $canale['type_mfh']=='ACCREDITI'){ echo ' selected';}?> value="ACCREDITI">ACCREDITI</option>
                    <option <?php if($modifica and isset($canale['type_mfh']) and $canale['type_mfh']=='ATTIVAZIONI'){ echo ' selected';}?> value="ATTIVAZIONI">ATTIVAZIONI</option>
                    <option <?php if($modifica and isset($canale['type_mfh']) and $canale['type_mfh']=='CAMBIO PIANO'){ echo ' selected';}?> value="CAMBIO PIANO">CAMBIO PIANO</option>
                    <option <?php if($modifica and isset($canale['type_mfh']) and $canale['type_mfh']=='PROROGA'){ echo ' selected';}?> value="PROROGA">PROROGA</option>
                    <option <?php if($modifica and isset($canale['type_mfh']) and $canale['type_mfh']=='RINNOVO SIM'){ echo ' selected';}?> value="RINNOVO SIM">RINNOVO SIM</option>
                </select>                           
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Note MFH<span class="required">*</span></label>                
                <textarea id="note_mfh" name="addcanale[0][note_mfh]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" <?php echo $required_mfh; ?> <?php if ($readonly){echo $disabled_value;}?>><?php if ($modifica && isset($canale['note_mfh'])){echo stripslashes($canale['note_mfh']); }?></textarea>                         
        </div>
    </span>
    <span id="span_watson" <?php echo $display_watson; ?>>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Campagna Watson<span class="required">*</span></label>
                <select  id="type_watson" name="addcanale[0][type_watson]" class="select2_single form-control" <?php echo $required_watson ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php if($modifica and isset($canale['type_watson']) and  $canale['type_watson']=='Add On'){ echo ' selected';}?> value="Add On">Add On</option>
                    <option <?php if($modifica and isset($canale['type_watson']) and $canale['type_watson']=='Cambio Offerta su CredRes'){ echo ' selected';}?> value="Cambio Offerta su CredRes">Cambio Offerta su CredRes</option>
                    <option <?php if($modifica and isset($canale['type_watson']) and $canale['type_watson']=='Cambio Piano con MDP'){ echo ' selected';}?> value="Cambio Piano con MDP">Cambio Piano con MDP</option>
                    <option <?php if($modifica and isset($canale['type_watson']) and $canale['type_watson']=='Cross Selling'){ echo ' selected';}?> value="Cross Selling">Cross Selling</option>
                    <option <?php if($modifica and isset($canale['type_watson']) and $canale['type_watson']=='Migrazione verso Fibra'){ echo ' selected';}?> value="Migrazione verso Fibra">Migrazione verso Fibra</option>
                    <option <?php if($modifica and isset($canale['type_watson']) and $canale['type_watson']=='Offerta Linea Fissa'){ echo ' selected';}?> value="Offerta Linea Fissa">Offerta Linea Fissa</option>
                    <option <?php if($modifica and isset($canale['type_watson']) and $canale['type_watson']=='Rivincolo cliente in scadenza'){ echo ' selected';}?> value="Rivincolo cliente in scadenza">Rivincolo cliente in scadenza</option>
                </select>                           
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Contatto Watson<span class="required">*</span></label>
                <select  id="contact_watson" name="addcanale[0][contact_watson]" class="select2_single form-control" <?php echo $required_watson ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option <?php if($modifica and isset($canale['contact_watson']) and $canale['contact_watson']=='Provisioning Automatico'){ echo ' selected';}?> value="Provisioning Automatico">Provisioning Automatico</option>
                    <option <?php if($modifica and isset($canale['contact_watson']) and $canale['contact_watson']=='Reinstradamento su Operatore'){ echo ' selected';}?> value="Reinstradamento su Operatore">Reinstradamento su Operatore</option>
                    <option <?php if($modifica and isset($canale['contact_watson']) and $canale['contact_watson']=='Tripletta CRM'){ echo ' selected';}?> value="Tripletta CRM">Tripletta CRM</option>
                </select>                           
        </div>
    </span>

</div>                    



<script>
$(document).ready(function() { 


    
    var testo_sms = document.getElementById("testo_sms");
    testo_sms.addEventListener(
        'keypress',
        function (event) {
            //alert('apostrofo word ' + parseInt(event.which) );

            
            // escludo caratteri € ed apostrofo word 86
            if (parseInt(event.which) == 69 || parseInt(event.which) == 86) {
                alert('  Attenzione il carattere \'€\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                event.preventDefault();
            }
            
            
        }
    );
    /*
    testo_sms.bind("paste input",function(){
      $(this).val($(this).val().replace (/[<>]/g ,"")) 
    });
    */

 document.addEventListener("keydown", function(event) {
  console.log('testo sms ' + parseInt(event.which));
})
    
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
            <?php if($readonly){echo 'clickable: false,';} else{echo 'clickable: true,';}?>       
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
        format: "DD/MM/YYYY",
        daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
        monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
        firstDay: 1        
      }
    });

    $('#data_invio_spai').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
        monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
        firstDay: 1        
      }
    });


    $('#channel_ins').on('select2:select', function() {
      var selected_channel_id = $('#channel_ins').val();
      //var test = $("input[name=testing]:hidden");
        $('#canale_zero').val(selected_channel_id);
        //alert($('#channel_ins').val());
        //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        ////$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);

        $(this).parsley().validate();

      if (selected_channel_id === '12') {
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
            $('#pos_field').hide();
            $('#sms_field').show();

        //$('#sms_duration').attr('required', true);
        //$('#tipoMonitoring').attr('required', true);
        //$('#link').attr('required', true);
        $('#mod_invio').attr('required', true);
        $('#testo_sms').attr('required', true);
        $('#storicizza_ins').attr('required', true);
        $('#senders_ins').attr('required', true);
        $('#notif_consegna').attr('required', true);

         //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        
        //$('#day_val_pos').attr('required', false);
        ////$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);

        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id
          },
          dataType: "html",
          success: function(data) {
            console.log(' sendersss qui' + JSON.stringify(data));
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
            $('#span_app_inbound').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
            $('#span_watson').hide();
            $('#pos_field').show();

                    //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', true);
        $('#tit_sott_pos').attr('required', true);
    
        //$('#day_val_pos').attr('required', true);
        //$('#callguide_pos').attr('required', true);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false);        
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);

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
            $('#span_app_inbound').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
            $('#span_watson').hide();
            $('#span_40400').show();

        //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', true);
        $('#day_val').attr('required', true);
        $('#sms_incarico').attr('required', true);
        $('#sms_target').attr('required', true);
        $('#sms_adesione').attr('required', true);
        $('#sms_nondisponibile').attr('required', true);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_watson').hide();
        $('#span_icm').show();   
        
                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', true);
        $('#callguide_icm').attr('required', true);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', true);
        $('#id_news_app_inbound').attr('required', true);
        $('#prior_app_inbound').attr('required', true);
        //$('#callguide_app_inbound').attr('required', true);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', true);
        $('#id_news_app_outbound').attr('required', true);
        $('#prior_app_outbound').attr('required', true);
        $('#notif_app_outbound').attr('required', true); 
        //$('#callguide_app_outbound').attr('required', true);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', true);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);             

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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', true);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', true);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', true);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', true);
        $('#note_mfh').attr('required', true);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', true);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', true);
        $('#contact_watson').attr('required', true);
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

                //sms
        $('#senders_ins').attr('required', false);
        $('#storicizza_ins').attr('required', false);
        $('#notif_consegna').attr('required', false);
        $('#testo_sms').attr('required', false);
        $('#mod_invio').attr('required', false);
        $('#link').attr('required', false);
        //$('#tipoMonitoring').attr('required', false);
        //$('#sms_duration').attr('required', false);
        //pos
        $('#cat_sott_ins').attr('required', false);
        $('#tit_sott_pos').attr('required', false);
        //$('#day_val_pos').attr('required', false);
        //$('#callguide_pos').attr('required', false);
        //#span_40400
        $('#alias_attiv').attr('required', false);
        $('#day_val').attr('required', false);
        $('#sms_incarico').attr('required', false);
        $('#sms_target').attr('required', false);
        $('#sms_adesione').attr('required', false);
        $('#sms_nondisponibile').attr('required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound').attr('required', false);
        $('#id_news_app_inbound').attr('required', false);
        $('#prior_app_inbound').attr('required', false);
        //$('#callguide_app_inbound').attr('required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound').attr('required', false);
        $('#id_news_app_outbound').attr('required', false);
        $('#prior_app_outbound').attr('required', false);
        $('#notif_app_outbound').attr('required', false); 
        //$('#callguide_app_outbound').attr('required', false);
        //#span_dealer
        $('#Cod_iniziativa').attr('required', false);
        //#span_icm
        $('#day_val_icm').attr('required', false);
        $('#callguide_icm').attr('required', false);
        //#span_ivr_inbound
        $('#day_val_ivr_inbound').attr('required', false);
        //#span_ivr_outbound
        $('#day_val_ivr_outbound').attr('required', false);
        //#span_jakala
        $('#data_invio_jakala').attr('required', false);
        //#span_spai
        $('#data_invio_spai').attr('required', false);
        //#span_mfh
        $('#type_mfh').attr('required', false);
        $('#note_mfh').attr('required', false);
        //#span_watson
        $('#type_watson').attr('required', false);
        $('#contact_watson').attr('required', false);
      }
      console.log('channel_id  ' + selected_channel_id);

    });


    //canale Dealer select numero Dealer
    $('#iniziative_dealer').change(function() {
            //alert('deale canale 0  '+$(this).val());
            count = $(this).val();
            for(i=2; i<10; i++){
                if(i<=count){
                    $('#dealer_'+i).show();
                    $('#Cod_iniziativa'+i).attr('required', true);                    
                }                
                else{
                    $('#dealer_'+i).hide();
                    $('#Cod_iniziativa'+i).attr('required', false);
                }
            }


        });  


});





</script>