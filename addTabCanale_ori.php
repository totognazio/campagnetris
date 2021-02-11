<?php

include_once './classes/campaign_class.php';
include_once './classes/funzioni_admin.php';
$funzione = new funzioni_admin();
$campaign = new campaign_class();
$channels = $funzione->get_list_select('channels');
$tit_sott = $funzione->get_allTable('campaign_titolo_sottotitolo');
$cat_sott = $funzione->get_allTable('campaign_cat_sott');
$id_campaign = array();
$addcanale_stored = array();

//print_r($_POST);

if (isset($_POST['tab_id'])) { 
    
    $id_tab = $_POST['tab_id'];
    $tab_content = 'contact_'.$id_tab;
    $readonly = $_POST['readonly'];
    $id_canale = $id_tab-4;
      
    if ($_POST['disabled_value'] != 0) { 
        $disabled_value = $_POST['disabled_value'];
    }
    else{
        $disabled_value = "";
    }

    if (isset($_POST['modifica'])) { 
        $modifica = $_POST['modifica'];
    }
    

    
    if ($_POST['campaign_id'] != 0 ) { 
        $id = $_POST['campaign_id'];
        $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . $id)->fetch_array();
        //print_r($id_campaign);
        print_r(json_decode($id_campaign['addcanale']), true); 
        if(isset(json_decode($id_campaign['addcanale'],true)[$id_canale])){
            $addcanale_stored = json_decode($id_campaign['addcanale'],true)[$id_canale];
        }
        
        //recuperare i valori della campagna da modificare
    }
 
   
    
}
                            $list = $funzione->get_list_id('channels');
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
                            
$string = '<div role="tabpanel" class="tab-pane fade" id="' . $tab_content . '" aria-labelledby="profile-tab">';         

$string .='<br/><input type="hidden" name="'.$id_canale.'_addcanale" value="'.$id_canale.'" >
                <input type="hidden" name="addcanale['.$id_canale.'][canale]" value="'.$id_canale.'" >            
                <div class="col-md-9 col-sm-6 col-xs-12">
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Canale  <span class="required">*</span></label>
                        <div class="col-md-6 col-sm-6 col-xs-12">'
                        .$funzione->string_select2('channel_ins'.$id_canale, $lista_field, $lista_name, $javascript, $style, $valore_channel_id, 'addcanale['.$id_canale.'][channel_id]').'
                        </div>
                    </div>
                </div>
        ';


$string .='<span id="sms_field'.$id_canale.'" '.$display_sms.' data-parsley-check-children="7" data-parsley-validate-if-empty="">  
        <div class="col-md-3 col-sm-6 col-xs-12">
                                
                        <label>Sender  <span class="required">*</span></label>
                            <select id="senders_ins'.$id_canale.'" name="addcanale['.$id_canale.'][sender_id]" class="select2_single form-control" style="width:100%" '.$required_sms.'  '.$disabled_value.'>';      
                              
                                if(isset($addcanale_stored['sender_id'])){
                                   $string .= '<option selected value="'.$addcanale_stored['sender_id'].'">'.$addcanale_stored['sender_nome'].'</option>'; 
                                }                                
                                
                          $string .= '</select>
                        
                       <label style="margin-top:20px">Storicizzazione Legale  <span class="required">*</span></label>                        
                       
                            <select id="storicizza_ins'.$id_canale.'" name="addcanale['.$id_canale.'][storicizza]" class="select2_single form-control" style="width:100%" '.$required_sms.' '.$disabled_value.'>
                            <option';
                                 if($modifica and isset($addcanale_stored['storicizza']) and $addcanale_stored['storicizza']=='0'){$string .=  ' selected';} 
                                $string .=  ' value="0">No</option>
                                <option';
                                if($modifica and isset($addcanale_stored['storicizza']) and $addcanale_stored['storicizza']=='1'){$string .=  ' selected';}
                                 $string .= ' value="1">Si</option></select>
                                 <label style="margin-top:20px">Notifica Consegna  <span class="required">*</span></label>       
                            <select id="notif_consegna'.$id_canale.'" name="addcanale['.$id_canale.'][notif_consegna]" class="select2_single form-control" style="width:100%" '.$required_sms.' '.$disabled_value.'>
                                <option';
                                if($modifica and $addcanale_stored['notif_consegna']=='0'){$string .=  ' selected';}
                                $string .=' value="0">No</option>
                                <option';
                                if($modifica and $addcanale_stored['notif_consegna']=='1'){$string .= ' selected';}
                                $string .=' value="1">Si</option>
                          </select>
              <label style="margin-top:20px" for="message">Testo SMS </label>
              <textarea id="testo_sms'.$id_canale.'"';
            $string .= ' '.$disabled_value.' '.$required_sms.' class="form-control" name="testo_sms" onkeyup="checklength(0, 640, \'testo_sms\', \'charTesto\', \'numero_sms\')" >';
            if($modifica and isset($addcanale_stored['testo_sms'])){$string .= $addcanale_stored['testo_sms'];}else{$string .= ' ';}
            $string .='</textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="charTesto" id="charTesto'.$id_canale.'" value="" class="text" value="" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="numero_sms" id="numero_sms'.$id_canale.'" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                     
     
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio'.$id_canale.'" name="addcanale['.$id_canale.'][mod_invio]" class="select2_single form-control" style="width:100%" '.$required_sms.' '.$disabled_value.'>      
                                <option value=""></option>
                                <option value="Interattivo"';
                                if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='Interattivo'){ $string .= ' selected ';} 
                                $string .='>Interattivo</option>
                                <option ';
                                if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='Standard'){$string .= ' selected';}
                                $string .=' value="Standard">Standard</option>
                                <option ';
                                if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='MST'){$string .= ' selected';}
                                $string .=' value="MST">MST</option>

                          </select>';
                        if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='Interattivo'){ ?>
                            <script> 
                                $('#spanLabelLinkTesto<?php echo $id_canale; ?>').show();
                                $('#link<?php echo $id_canale; ?>').attr('required', true);                                                               
                            </script>
                        <?php } 
                         else { ?>
                            <script> 
                                $('#spanLabelLinkTesto<?php echo $id_canale; ?>').hide();
                                $('#link<?php echo $id_canale; ?>').attr('required', false);                                                                   
                            </script>
                        <?php } 
                        $string .=' 
                        <span id="spanLabelLinkTesto'.$id_canale.'">
                            <label style="margin-top:20px" id="labelLinkTesto'.$id_canale.'">Link<span id="req_19" class="req">*</span></label>
                            <input  id="link'.$id_canale.'" name="addcanale['.$id_canale.'][link]" type="text" class="form-control col-md-7 col-xs-12" style="text-align:right" tabindex="23" maxlength="400" ';
                            
                            if ($modifica and isset($addcanale_stored['link'])){
                                $string .=' value="' . $addcanale_stored['link'].'" ';
                            }                                
                            else {
                                $string .= ' value="" ';
                            }
                                                         
                            if ($readonly){
                                    $string .= $disabled_value;
                            }
                                
                            $string .= ' onkeyup="checklength(0, 255, \'link\', \'charLink\', \'\'); checklengthTotal(\'charLink\',\'charTesto\',\'numero_totale\');"/>
                            <label style="width:100%;"><small>Numero</small><input type="text" name="charLink" id="charLink'.$id_canale.'" class="text" readonly="readonly"  size="3" value="255" placeholder="max 255"onfocus="this.blur()" /></label>   
                            <label style="width:100%;"><small>Totale (SMS+Link)</small><input type="text" name="numero_totale" id="numero_totale'.$id_canale.'" value="" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                        </span>   
                          <br>
                       <label style="margin-top:20px">Tipo Monitoring  <span class="required">*</span></label>               
                            <select id="tipoMonitoring'.$id_canale.'" name="addcanale['.$id_canale.'][tipoMonitoring]" class="select2_single form-control" style="width:100%" '.$required_sms.' '.$disabled_value.'>      
                                <option value=""></option>
                                <option ';
                                if($modifica and isset($addcanale_stored['tipoMonitoring']) and $addcanale_stored['tipoMonitoring']=='1'){$string .=  ' selected';}
                                $string .= 'value="1">ADV Tracking tool</option>
                                <option ';
                                if($modifica and isset($addcanale_stored['tipoMonitoring']) and $addcanale_stored['tipoMonitoring']=='2'){$string .=  ' selected';}
                                $string .= ' value="2">Orphan page</option>
                                <option ';
                                if($modifica and isset($addcanale_stored['tipoMonitoring']) and $addcanale_stored['tipoMonitoring']=='3'){$string .=  ' selected';}
                                $string .= ' value="3">No monitoring</option>
                          </select>
                       <label style="margin-top:20px">Durata SMS  <span class="required">*</span></label>
                          <input type="text" id="sms_duration'.$id_canale.'" name="sms_duration"  class="form-control col-md-7 col-xs-12" value="';
                        if($modifica and isset($addcanale_stored['sms_duration'])){$string .=  $addcanale_stored['sms_duration'];}else{$string .= '2';};
                         $string .= '" '.$required_sms.' '. $disabled_value.'>';
                        $string .= '<img id="info" title="Numero di giorni in cui la rete tenter&agrave; l\'invio dell\'sms. Range da 1 a 7 giorni." alt="Durata SMS" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
  
        </div>
        </span>';

$string .='<span id="pos_field'.$id_canale.'" '.$display_pos.'> 
            <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Categoria & Sottocategoria</label>
                <select id="cat_sott_ins'.$id_canale.'" style="width: 100%" name="addcanale['.$id_canale.'][cat_sott_id]" class="select2_single form-control" '.$required_pos.' '.$disabled_value.'>';        
                                                 
                    foreach ($cat_sott as $key => $value) {
                        if($modifica and isset($addcanale_stored['cat_sott_id']) and $addcanale_stored['cat_sott_id']==$value['id']){$selected = ' selected ';}
                        else{$selected = '';}
                        $string .=  '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                     
                $string .= '</select>
            </div>
            <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input'; if ($readonly){$string .=' '.$disabled_value;}
                $string .=' type="number" id="day_val_pos'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_pos]"  min="1" max="31" '.$required_pos.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_pos'])){$string .= $addcanale_stored['day_val_pos']; }
                $string .='">
                </div>
            <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)
                <img  title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>
                <textarea id="callguide_pos'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_pos]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" '.$required_pos;
                if ($readonly){$string .= $disabled_value;}
                $string .=' >';
                if ($modifica and (isset($addcanale_stored['callguide_pos']))){$string .= stripslashes($addcanale_stored['callguide_pos']); }
                $string .='</textarea>                    
            </div>

        </span>';

$string .='<span id="span_40400'.$id_canale.'" '.$display_40400.'> 
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label class="control-label" for="alias_attiv">Alias Attivazione</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .= 'type="text" id="alias_attiv'.$id_canale.'" name="addcanale['.$id_canale.'][alias_attiv]"  placeholder="alfanumerico"  class="form-control col-md-7 col-xs-12" value="';
                if(isset($id_campaign['alias_attiv'])){$string .= $id_campaign['alias_attiv']; }
                $string .= '">
                <br><br><br><br>
                <label  class="control-label" for="day_val">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .=  $disabled_value;}
                $string .= 'type="number" id="day_val'.$id_canale.'" name="addcanale['.$id_canale.'][day_val]"  min="1" max="31" placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if($modifica and isset($addcanale_stored['day_val'])) {$string .= $addcanale_stored['day_val']; }
                $string .= '"><br><br><br><br><label  class="control-label" for="note">SMS Presa in carico</label><textarea';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_incarico'.$id_canale.'" name="addcanale['.$id_canale.'][sms_incarico]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_incarico'])){$string .= $addcanale_stored['sms_incarico']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_target">SMS Non in Tanget</label>            
                <textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_target'.$id_canale.'" addcanale['.$id_canale.'][sms_target]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_target'])){$string .= $addcanale_stored['sms_target']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Adesione già Avvenuta</label>
                <textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_adesione'.$id_canale.'" name="addcanale['.$id_canale.'][sms_adesione]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" > ';
                if($modifica and isset($addcanale_stored['sms_adesione'])){$string .=  $addcanale_stored['sms_adesione']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Non Disponibile</label>
                <textarea ';if ($readonly){$string .=  $disabled_value;}
                $string .= ' rows="2" id="sms_nondisponibile'.$id_canale.'" name="addcanale['.$id_canale.'][sms_nondisponibile]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_adesione'])){$string .=  $addcanale_stored['sms_adesione']; }
                $string .= '</textarea>
        </div>
 </span>'; 
 
$string .='<span id="span_app_inbound'.$id_canale.' "'.$display_app_inbound.' >
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .=$disabled_value;}
                $string .='type="number" id="day_val_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_app_inbound]"  min="1" max="31" '.$required_app_inbound.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_app_inbound'])){$string .= $addcanale_stored['day_val_app_inbound']; }
                $string .='">
                <br><br>
                <label  class="control-label">Priorità</label>
                <input';
                if ($readonly){$string .= $disabled_value;}
                $string .=' type="number" id="prior_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][prior_app_inbound]"  min="0" max="9" '.$required_app_inbound.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['prior_app_inbound'])){$string .= $addcanale_stored['prior_app_inbound']; }
                $string .='">
                <br><br>                                
        </div>
        <div  class="col-md-4 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)
                <img  title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>

                    <textarea id="callguide_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_app_inbound]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" '. $required_app_inbound;
                     if ($readonly){$string .= $disabled_value;}
                     $string .='> ';
                    if ($modifica){$string .= stripslashes($addcanale_stored['callguide_app_inbound']); }
                    $string .='</textarea>
                    
        </div> 
    </span>
    
        <span id="span_app_outbound'.$id_canale.'" '.$display_app_outbound.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .='type="number" id="day_val_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_app_outbound]"  min="1" max="31" '.$required_app_outbound.'  placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_app_outbound'])){$string .= $addcanale_stored['day_val_app_outbound']; }
                $string .='">
                <br><br>
                <label  class="control-label">Priorità</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .='type="number" id="prior_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][prior_app_outbound]"  min="0" max="9"  '.$required_app_outbound.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['prior_app_outbound'])){$string .= $addcanale_stored['prior_app_outbound']; }
                $string .='">
                <br><br>                                
        </div>
    </span>   
    <span id="span_dealer'.$id_canale.'" '.$display_dealer.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Cod. iniziativa</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .='type="number" id="Cod_iniziativa'.$id_canale.'" name="addcanale['.$id_canale.'][Cod_iniziativa]"  min="1"  '.$required_dealer.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['Cod_iniziativa'])){$string .= $addcanale_stored['Cod_iniziativa']; }
                $string .='">
                <br><br>                             
        </div>
    </span>
    <span id="span_icm'.$id_canale.'" '.$display_icm.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .='type="number" id="day_val_icm'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_icm]"  min="1" max="31" '.$required_icm.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_icm'])){$string .= $addcanale_stored['day_val_icm']; }
                $string .='">
                <br><br>                             
        </div>
        <div  class="col-md-6 col-sm-6 col-xs-12" >
                <label class="control-label">Call Guide (4000 chars max)
                <img  title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>

                    <textarea id="callguide_icm'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_icm]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" '.$required_icm;
                    if ($readonly){$string .= $disabled_value;}
                    $string .='>';
                    if ($modifica){$string .= stripslashes($addcanale_stored['callguide_icm']); }
                    $string .='</textarea>
                    
        </div>
    </span>
    <span id="span_ivr_inbound'.$id_canale.'" '.$display_ivr_inbound.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input';
                if ($readonly){ $string .= $disabled_value;}
                $string .=' type="number" id="day_val_ivr_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_ivr_inbound]"  min="1" max="31" '.$required_ivr_inbound.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_ivr_inbound'])){$string .= $addcanale_stored['day_val_ivr_inbound']; }
                $string .='">
                <br><br>                             
        </div>
    </span>
    <span id="span_ivr_outbound'.$id_canale.'" '.$display_ivr_outbound.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .=' type="number" id="day_val_ivr_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_ivr_outbound]"  min="1" max="31"  '. $required_ivr_outbound.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_ivr_outbound'])){$string .= $addcanale_stored['day_val_ivr_outbound']; }
                $string .='">
                <br><br>                             
        </div>
    </span>
    <span id="span_jakala'.$id_canale.'" '.$display_jakala.'>

        <div class="col-md-4 col-sm-6 col-xs-12">    
                <label class="control-label col-md-6 col-sm-3 col-xs-12">Data invio JAKALA</label>
                <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                    <input id="data_invio_jakala'.$id_canale.'" ';
                    if ($readonly){$string .= $disabled_value;}
                    $string .=' type="text" class="form-control has-feedback-rigth"  placeholder="Data Invio Jakala" aria-describedby="inputSuccessJakala" required="required" name="addcanale['.$id_canale.'][data_invio_jakala]" value="';
                    if(isset($addcanale_stored['data_invio_jakala'])){$string .= $addcanale_stored['data_invio_jakala'];}
                    $string .='">
                    <span class="fa fa-calendar-o form-control-feedback rigth" aria-hidden="true"></span>
                    <span id="inputSuccessJakala'.$id_canale.'" class="sr-only">(success)</span>
                </div>                             
        </div>
    </span>
    <span id="span_spai'.$id_canale.'" '.$display_spai.'>
        <div class="col-md-4 col-sm-6 col-xs-12">
                <label class="control-label col-md-6 col-sm-3 col-xs-12">Data invio SPAI</label>
                <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                    <input id="data_invio_spai'.$id_canale.'" ';
                    if ($readonly){$string .= $disabled_value;}
                    $string .=' type="text" class="form-control has-feedback-rigth"  placeholder="Data Invio Spai" aria-describedby="inputSuccessSpai" required="required" name="addcanale['.$id_canale.'][data_invio_spai]" value="';
                    if(isset($addcanale_stored['data_invio_spai'])){$string .= $addcanale_stored['data_invio_spai'];}
                    $string .='">
                    <span class="fa fa-calendar-o form-control-feedback rigth" aria-hidden="true"></span>
                    <span id="inputSuccessSpai'.$id_canale.'" class="sr-only">(success)</span>
                </div>                                 
        </div>
    </span>    
    <span id="span_mfh'.$id_canale.'" '.$display_mfh.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia MFH</label>
                <select  id="type_mfh'.$id_canale.'" name="addcanale['.$id_canale.'][type_mfh]" class="select2_single form-control" '.$required_mfh.' '.$disabled_value.'>        
                    <option value=""></option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_mfh']) and $addcanale_stored['type_mfh']=='ACCREDITI'){ $string .= ' selected';}
                    $string .=' value="ACCREDITI">ACCREDITI</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_mfh']) and $addcanale_stored['type_mfh']=='ATTIVAZIONI'){ $string .= ' selected';}
                    $string .=' value="ATTIVAZIONI">ATTIVAZIONI</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_mfh']) and $addcanale_stored['type_mfh']=='CAMBIO PIANO'){ $string .= ' selected';}
                    $string .=' value="CAMBIO PIANO">CAMBIO PIANO</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_mfh']) and $addcanale_stored['type_mfh']=='PROROGA'){ $string .= ' selected';}
                    $string .=' value="PROROGA">PROROGA</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_mfh']) and $addcanale_stored['type_mfh']=='RINNOVO SIM'){ $string .= ' selected';}
                    $string .=' value="RINNOVO SIM">RINNOVO SIM</option>
                </select>                           
        </div>
    </span>
    <span id="span_watson'.$id_canale.'" '.$display_watson.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Campagna Watson</label>
                <select  id="type_watson'.$id_canale.'" name="addcanale['.$id_canale.'][type_watson]" class="select2_single form-control"  '. $required_watson.' '.$disabled_value.'>        
                    <option value=""></option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and  $addcanale_stored['type_watson']=='Add On'){ $string .= ' selected';}
                    $string .=' value="Add On">Add On</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and $addcanale_stored['type_watson']=='Cambio Offerta su CredRes'){ $string .= ' selected';}
                    $string .=' value="Cambio Offerta su CredRes">Cambio Offerta su CredRes</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and $addcanale_stored['type_watson']=='Cambio Piano con MDP'){ $string .= ' selected';}
                    $string .=' value="Cambio Piano con MDP">Cambio Piano con MDP</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and $addcanale_stored['type_watson']=='Cross Selling'){ $string .= ' selected';}
                    $string .='value="Cross Selling">Cross Selling</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and $addcanale_stored['type_watson']=='Migrazione verso Fibra'){ $string .= ' selected';}
                    $string .=' value="Migrazione verso Fibra">Migrazione verso Fibra</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and $addcanale_stored['type_watson']=='Offerta Linea Fissa'){ $string .= ' selected';}
                    $string .=' value="Offerta Linea Fissa">Offerta Linea Fissa</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['type_watson']) and $addcanale_stored['type_watson']=='Rivincolo cliente in scadenza'){ $string .= ' selected';}
                    $string .=' value="Rivincolo cliente in scadenza">Rivincolo cliente in scadenza</option>
                </select>                           
        </div>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Contatto Watson</label>
                <select  id="contact_watson'.$id_canale.'" name="addcanale['.$id_canale.'][contact_watson]" class="select2_single form-control" <?php echo $required_watson ?> <?php echo $disabled_value;?>>        
                    <option value=""></option>
                    <option ';
                    if($modifica and isset($addcanale_stored['contact_watson']) and $addcanale_stored['contact_watson']=='Provisioning Automatico'){ $string .= ' selected';}
                    $string .=' value="Provisioning Automatico">Provisioning Automatico</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['contact_watson']) and $addcanale_stored['contact_watson']=='Reinstradamento su Operatore'){ $string .= ' selected';}
                    $string .=' value="Reinstradamento su Operatore">Reinstradamento su Operatore</option>
                    <option ';
                    if($modifica and isset($addcanale_stored['contact_watson']) and $addcanale_stored['contact_watson']=='Tripletta CRM'){ $string .= ' selected';}
                    $string .=' value="Tripletta CRM">Tripletta CRM</option>
                </select>                           
        </div>
    </span>
    
    ';


 $string .= '</div><script>

$(\'#mod_invio'.$id_canale.'\').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$(\'#mod_invio'.$id_canale.'\').on(\'select2:select\', function () {
    const selected_modsms'.$id_canale.' = $(\'#mod_invio'.$id_canale.'\').val();
    
    if(selected_modsms'.$id_canale.' === \'Interattivo\'){
           $("#spanLabelLinkTesto'.$id_canale.'").fadeOut();
           $("#spanLabelLinkTesto'.$id_canale.'").fadeIn();  
           $(\'#link'.$id_canale.'\').attr(\'required\', true);  
    }
    else {
       $("#spanLabelLinkTesto'.$id_canale.'").fadeOut(); 
       $(\'#link'.$id_canale.'\').attr(\'required\', false);  
    }
    console.log(\'selected_modsms'.$id_canale.'  \'+ selected_modsms'.$id_canale.');   
    });

    $(\'#data_invio_jakala'.$id_canale.'\').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [\'Do\', \'Lu\', \'Ma\', \'Me\', \'Gi\', \'Ve\', \'Sa\'],
        monthNames: [\'Gennaio\', \'Febbraio\', \'Marzo\', \'Aprile\', \'Maggio\', \'Giugno\', \'Luglio\', \'Agosto\', \'Settembre\', \'Ottobre\', \'Novembre\', \'Dicembre\'],
        firstDay: 1        
      }
    });

    $(\'#data_invio_spai'.$id_canale.'\').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [\'Do\', \'Lu\', \'Ma\', \'Me\', \'Gi\', \'Ve\', \'Sa\'],
        monthNames: [\'Gennaio\', \'Febbraio\', \'Marzo\', \'Aprile\', \'Maggio\', \'Giugno\', \'Luglio\', \'Agosto\', \'Settembre\', \'Ottobre\', \'Novembre\', \'Dicembre\'],
        firstDay: 1        
      }
    });

    $(\'#channel_ins'.$id_canale.'\').select2({
      placeholder: "Select" 
    });
    
    $(\'#channel_ins'.$id_canale.'\').on(\'select2:select\', function() {
      var selected_channel_id'.$id_canale.' = $(\'#channel_ins'.$id_canale.'\').val();
      //var test = $("input[name=testing]:hidden");
      
        //alert($(\'#selected_channel_id'.$id_canale.'\').val());
        //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);

        $(this).parsley().validate();

      if (selected_channel_id'.$id_canale.' === \'12\') {
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').show();

                //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', true);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', true);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', true);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', true);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', true);
        $(\'#link'.$id_canale.'\').attr(\'required\', true);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', true);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', true);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id'.$id_canale.'
          },
          dataType: "html",
          success: function(data) {
            console.log(\' sendersss qui\' + JSON.stringify(data));
            console.log(\'eccoli2 data\' + data);
            $("#senders_ins'.$id_canale.'").fadeOut();
            $("#senders_ins'.$id_canale.'").fadeIn();
            $("#senders_ins'.$id_canale.'").html(data);
            //$("#selected_senders") = data;

          }

        });

      } 
      else if (selected_channel_id'.$id_canale.' === \'13\') {//CRM DA POS
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').show();
            $(\'#sms_field'.$id_canale.'\').hide();

                            //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', true);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', true);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', true);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);

          
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id'.$id_canale.'
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins'.$id_canale.'").fadeOut();
            $("#cat_sott_ins'.$id_canale.'").fadeIn();
            $("#cat_sott_ins'.$id_canale.'").html(data);

          }

        });
        }
        else if (selected_channel_id'.$id_canale.' === \'14\') {// 40400
            $(\'#span_40400'.$id_canale.'\').show();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();

                            //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', true);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', true);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', true);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', true);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', true);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', true);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      } 
      else if (selected_channel_id'.$id_canale.' === \'21\') {//canale ICM
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').show();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
        
                            //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', true);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', true);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      }
      else if (selected_channel_id'.$id_canale.' === \'15\') {//canale APP INBOUND
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').show();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();

                            //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', true);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', true);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', true);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      }
      else if (selected_channel_id'.$id_canale.' === \'16\') {//canale APP OUTBOUND
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').show();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
                            //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', true);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', true);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      }
      else if (selected_channel_id'.$id_canale.' === \'22\') {//canale IVR INBOUND
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').show();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
		           //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      }
      else if (selected_channel_id'.$id_canale.' === \'23\') {//canale IVR OUTBOUND
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').show();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
                           //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', true);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);

      }
      else if (selected_channel_id'.$id_canale.' === \'24\') {//canale JAKALA
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').show();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
                           //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', true);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      }
      else if (selected_channel_id'.$id_canale.' === \'31\') {//canale MFH
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').show();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
                           //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', true);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);

      }
      else if (selected_channel_id'.$id_canale.' === \'35\') {//canale SPAI
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').show();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();

                           //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', true);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);

      }
      else if (selected_channel_id'.$id_canale.' === \'29\') {//canale watson
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').show();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();
                           //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', true);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', true);
      }
 
      else {
            $(\'#span_40400'.$id_canale.'\').hide();
            $(\'#span_spai'.$id_canale.'\').hide();
            $(\'#span_mfh'.$id_canale.'\').hide();
            $(\'#span_jakala'.$id_canale.'\').hide();
            $(\'#span_ivr_inbound'.$id_canale.'\').hide();
            $(\'#span_ivr_outbound'.$id_canale.'\').hide();
            $(\'#span_dealer'.$id_canale.'\').hide();
            $(\'#span_app_outbound'.$id_canale.'\').hide();
            $(\'#span_app_inbound'.$id_canale.'\').hide();
            $(\'#span_icm'.$id_canale.'\').hide();
            $(\'#span_watson'.$id_canale.'\').hide();
            $(\'#pos_field'.$id_canale.'\').hide();
            $(\'#sms_field'.$id_canale.'\').hide();

                            //sms
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#notif_consegna'.$id_canale.'\').attr(\'required\', false);
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
        $(\'#link'.$id_canale.'\').attr(\'required\', false);
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
        //pos
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val_pos'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_pos'.$id_canale.'\').attr(\'required\', false);
        //#span_40400
        $(\'#alias_attiv'.$id_canale.'\').attr(\'required\', false);
        $(\'#day_val'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_incarico'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_target'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_adesione'.$id_canale.'\').attr(\'required\', false);
        $(\'#sms_nondisponibile'.$id_canale.'\').attr(\'required\', false);
        //#span_app_inbound
        $(\'#day_val_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_inbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_app_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_app_outbound
        $(\'#day_val_app_outbound'.$id_canale.'\').attr(\'required\', false);
        $(\'#prior_app_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_dealer
        $(\'#Cod_iniziativa'.$id_canale.'\').attr(\'required\', false);
        //#span_icm
        $(\'#day_val_icm'.$id_canale.'\').attr(\'required\', false);
        $(\'#callguide_icm'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_inbound
        $(\'#day_val_ivr_inbound'.$id_canale.'\').attr(\'required\', false);
        //#span_ivr_outbound
        $(\'#day_val_ivr_outbound'.$id_canale.'\').attr(\'required\', false);
        //#span_jakala
        $(\'#data_invio_jakala'.$id_canale.'\').attr(\'required\', false);
        //#span_spai
        $(\'#data_invio_spai'.$id_canale.'\').attr(\'required\', false);
        //#span_mfh
        $(\'#type_mfh'.$id_canale.'\').attr(\'required\', false);
        //#span_watson
        $(\'#type_watson'.$id_canale.'\').attr(\'required\', false);
        $(\'#contact_watson'.$id_canale.'\').attr(\'required\', false);
      }
      console.log(\'channel_id'.$id_canale.' \' + selected_channel_id'.$id_canale.');

    
    });


    
    </script>';
            
                

    echo $string;                