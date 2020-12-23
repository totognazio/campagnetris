<div role="tabpanel" class="tab-pane fade" id="tab_content3" aria-labelledby="profile-tab">
    <br/>
    <div class="col-md-9 col-sm-6 col-xs-12">
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
                            $style = " style=\"width:100%;\" ";
                            if ($modifica){
                                $valore_channel_id = $id_campaign['channel_id'];
                                if($valore_channel_id==1 or $valore_channel_id==12){$display_sms =  ''; $required_sms_field =  ' required="required" ';}
                                if($valore_channel_id==13){$display_pos =  ''; $required_pos_field =  ' required="required" ';}    
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
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titolo & Sottotitolo  <span class="required">*</span></label>
            <?php #print_r($stacks); ?>
            <div class="col-md-6 col-sm-6 col-xs-12">                              
                <select  id="tit_sott_ins" style="width: 100%" name="tit_sott_id" class="select2_single form-control" required="required" <?php echo $disabled_value;?>>        
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
            <div class="form-group">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">Opzione  <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="opzione_leva" name="opzione_leva" class="select2_single form-control" <?php echo $disabled_value;?> required="required">       
                        <option <?php if($modifica and $id_campaign['opzione_leva']=='0'){echo ' selected';} ?> value=""></option>
                        <option <?php if($modifica and $id_campaign['opzione_leva']=='Ropz'){echo ' selected';} ?> value="Ropz">Ropz</option>
                        <option <?php if($modifica and $id_campaign['opzione_leva']=='Popz'){echo ' selected';} ?>value="Ropz">Popz</option>

                    </select>
                </div>

            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_taglio">ID Taglio
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input  <?php echo $disabled_value; ?>type="text" id="id_taglio" name="id_taglio" value="<?php if(isset($id_campaign['id_taglio'])){$form->input_value($modifica, $id_campaign['id_taglio']);} ?>"   placeholder="testo libero" class="form-control col-md-7 col-xs-12">
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="id_news">ID News
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input <?php echo $disabled_value;?> type="text" id="id_news" name="id_news"  class="form-control col-md-7 col-xs-12" placeholder="testo libero" value="<?php if(isset($id_campaign['id_taglio'])){echo $id_campaign['id_news'];}?>">
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
                <input <?php if ($readonly){echo $disabled_value;}?>type="text" id="note_operative" name="note_operative"  placeholder="testo libero" class="form-control col-md-7 col-xs-12" value="<?php if(isset($id_campaign['note_operative'])){echo $id_campaign['note_operative']; }?>">
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
                    <option <?php if($modifica and $id_campaign['escludi_sab_dom']=='0'){echo ' selected';} ?> value="0">No</option>
                    <option <?php if($modifica and $id_campaign['escludi_sab_dom']=='1'){echo ' selected';} ?> value="1">Sabato</option>
                    <option <?php if($modifica and $id_campaign['escludi_sab_dom']=='2'){echo ' selected';} ?> value="2" >Domenica</option>
                    <option <?php if($modifica and $id_campaign['escludi_sab_dom']=='3'){echo ' selected';} ?>value="3" >Sabato & Domenica</option>

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
                            <select id="senders_ins" name="senders_id" class="select2_single form-control" style="width:100%"  <?php echo $required_sms_field; ?> <?php echo $disabled_value;?>>      
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
                         
          <form id="demo-form" data-parsley-validate>
            
              <label style="margin-top:20px" for="message">Test SMS </label>
              <textarea id="testo_sms" <?php echo $disabled_value; ?>  <?php echo $required_sms_field; ?> class="form-control" name="testo_sms" onkeyup="checklength(0, 640, 'testo_sms', 'charTesto', 'numero_sms')" ><?php if($modifica){echo $id_campaign['testo_sms'];}else{echo'';}?></textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="charTesto" id="charTesto" value="" class="text" value="" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="numero_sms" id="numero_sms" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
            </form>             
     
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio" name="mod_invio" class="select2_single form-control" style="width:100%"  <?php echo $required_sms_field; ?> <?php echo $disabled_value;?>>      
                                <option value=""></option>
                                <option <?php if($modifica and $id_campaign['mod_invio']=='Interattivo'){echo ' selected';} ?> value="Interattivo">Interattivo</option>
                                <option <?php if($modifica and $id_campaign['mod_invio']=='Standard'){echo ' selected';} ?> value="Standard">Standard</option>

                          </select>
                      
                        <span id="spanLabelLinkTesto" style="display:none;">
                            <label style="margin-top:20px" id="labelLinkTesto">Link<span id="req_19" class="req">*</span></label>
                            <input  id="link" name="link" type="text" class="form-control col-md-7 col-xs-12" style="text-align:right" tabindex="23" maxlength="400" onkeyup="checklength(0, 255, 'link', 'charLink', ''); checklengthTotal('charLink','charTesto','numero_totale');"  <?php echo $required_sms_field; ?>/>
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
            <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Categoria & Sottocategoria</label>
                <select id="cat_sott_ins" style="width: 100%" name="category_id" class="select2_single form-control" <?php echo $required_pos_field ?> <?php echo $disabled_value; ?>>        
                    <?php                               
                    foreach ($cat_sott as $key => $value) {
                        if($modifica and $id_campaign['category_id']==$value['id']){$selected = ' selected';}
                        else{$selected = '';}
                        echo '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                    ?>  
                </select>
            </div>

        </span>  
</div>                    



<script>
$(document).ready(function() {  

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


});



</script>