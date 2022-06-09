<?php

include_once './classes/campaign_class.php';
include_once './classes/funzioni_admin.php';
$funzione = new funzioni_admin();
$campaign = new campaign_class();
$channels = $funzione->get_list_select('channels');
//$tit_sott = $funzione->get_allTable('campaign_titolo_sottotitolo');
$cat_sott = $funzione->get_allTable('campaign_cat_sott');

$id_campaign = array();
$addcanale_stored = array();

//print_r($_POST);

if (isset($_POST['tab_id'])) { 
    //if 9  limite max raggiunto
    $id_tab = $_POST['tab_id'];
    $azione = $_POST['azione'];
    $disabled_value = $_POST['disabled_value'];
    $tab_content = 'contact_'.$id_tab;
    $readonly = $_POST['readonly'];
    $id_canale = $id_tab-4;
    $modifica = false;


    if (isset($_POST['azione']) &&  ($_POST['azione']=='duplica' || $_POST['azione']=='modifica' || $_POST['azione']=='open')) { 
        $modifica = true;
    }
    

    
    if ($_POST['campaign_id'] != 0 ) { 
        $id = $_POST['campaign_id'];
        $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . $id)->fetch_array();
        //print_r($id_campaign);
        //print_r(json_decode($id_campaign['addcanale']), true); 
        if(isset(json_decode($id_campaign['addcanale'],true)[$id_canale])){
            $addcanale_stored = json_decode($id_campaign['addcanale'],true)[$id_canale];
            //print_r($addcanale_stored);
        }
        
        //recuperare i valori della campagna da modificare
    } 
}
else {
       $string .=' <script>alert(\'tab_id Undefined\');</script>';
      echo $string; 
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
                            $display_iow = ' style="display: none;"';
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
                            $required_iow = '';
                            //$funzione->get_sender($addcanale_stored['sender_id']); 
   
                                                      
                            if ($modifica and isset($addcanale_stored['channel_id'])){
                                
                                $valore_channel_id = $addcanale_stored['channel_id'];
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
                                //InOrderWeb
                                if($valore_channel_id==36){$display_iow =  ''; $required_iow = ' required="required" ';}                                     
                            }
                            else{
                                $valore_channel_id = "";
                            }
                            
$string = '<div role="tabpanel" class="tab-pane fade" id="' . $tab_content . '" aria-labelledby="profile-tab">';         

$string .='<br/><input type="hidden" name="'.$id_canale.'_addcanale" value="'.$id_canale.'" >
                <input type="hidden" name="addcanale['.$id_canale.'][canale]" value="'.$id_canale.'" >            
                <div class="col-md-6 col-sm-6 col-xs-12">
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
                            <select id="senders_ins'.$id_canale.'" name="addcanale['.$id_canale.'][sender_id]" class="select2_single form-control" style="width:100%"  '.$disabled_value.'>
                                <option></option>';   
                            if($modifica){
                                        $sender = $funzione->get_allTable('senders');                                                    
                                        foreach ($sender as $key => $value) {
                                            if($modifica and isset($addcanale_stored['sender_id']) and $addcanale_stored['sender_id']==$value['id']){$selected = ' selected';}
                                            else{$selected = '';}
                                            $string .= '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . '</option>';
                                        }

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
                                if($modifica and  isset($addcanale_stored['notif_consegna']) and $addcanale_stored['notif_consegna']=='0'){$string .=  ' selected';}
                                $string .=' value="0">No</option>
                                <option';
                                if($modifica and  isset($addcanale_stored['notif_consegna']) and $addcanale_stored['notif_consegna']=='1'){$string .= ' selected';}
                                $string .=' value="1">Si</option>
                          </select>
              <label style="margin-top:20px" for="message">Testo SMS <span class="required">*</span></label>
             
            <textarea id="testo_sms'.$id_canale.'" ';
            $string .= ' '.$disabled_value.' '.$required_sms.' class="form-control" name="addcanale['.$id_canale.'][testo_sms'.$id_canale.']" rows="8"  data-parsley-pattern-message="Caratteri come \'€\' \' ’ \' ed altri caratteri speciali non sono accettati come testo SMS !!"onkeyup="checklength(0, 640, \'testo_sms'.$id_canale.'\', \'charTesto'.$id_canale.'\', \'numero_sms'.$id_canale.'\','.$id_canale.')" >';
            if($modifica and isset($addcanale_stored['testo_sms'.$id_canale.''])){$string .= $addcanale_stored['testo_sms'.$id_canale.''];}else{$string .= '';}
            $string .='</textarea>  

              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="addcanale['.$id_canale.'][charTesto'.$id_canale.']" id="charTesto'.$id_canale.'"  class="text" value="';
              if($modifica and isset($addcanale_stored['charTesto'.$id_canale.''])){$string.= ''.$addcanale_stored['charTesto'.$id_canale.''].'';}
              $string.='" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3"  onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="addcanale['.$id_canale.'][numero_sms'.$id_canale.']" id="numero_sms'.$id_canale.'" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="';
              if($modifica and isset($addcanale_stored['numero_sms'.$id_canale.''])){$string.= ''.$addcanale_stored['numero_sms'.$id_canale.''].'';} else{ $string .='0';}
              $string.='" onfocus="this.blur()" /></label>                  
                                       
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio'.$id_canale.'" name="addcanale['.$id_canale.'][mod_invio]" class="select2_single form-control" style="width:100%" '.$required_sms.' '.$disabled_value.'>
                            <option';    
                                if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='Standard'){$string .= ' selected';}
                                $string .=' value="Standard">Standard</option>
                                <option ';
                                if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='MST'){$string .= ' selected';}
                                $string .=' value="MST">MST</option>
                                <option value="Interattivo"';
                                if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='Interattivo'){ $string .= ' selected ';} 
                                $string .='>Interattivo</option>                                 
                            </select>';
                        if($modifica and isset($addcanale_stored['mod_invio']) and $addcanale_stored['mod_invio']=='Interattivo'){
                        $string .='  
                            <script> 
                                $(\'#spanLabelLinkTesto'.$id_canale.'\').show();
                                $(\'#link'.$id_canale.'\').attr(\'required\', true);   
                                $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', true);                                                             
                            </script>';
                         } 
                         else {
                            $string .='<script> 
                                $(\'#spanLabelLinkTesto'.$id_canale.'\').hide();
                                $(\'#link'.$id_canale.'\').attr(\'required\', false); 
                                $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);                                                                     
                            </script>';
                        } 
                        $string .=' 
                        <span id="spanLabelLinkTesto'.$id_canale.'" style="display: none;">
                                    <label style="margin-top:20px" id="labelLinkTesto'.$id_canale.'">Link<span id="req_19" class="req">*</span></label>
                                    <input  id="link'.$id_canale.'" name="addcanale['.$id_canale.'][link]"  type="url" data-parsley-type="url" class="form-control col-md-7 col-xs-12" autocomplete="on" placeholder="http://mywebsite.com" style="text-align:left" maxlength="400" ';
                                    
                                    if ($modifica and isset($addcanale_stored['link'])){
                                        $string .=' value="' . $addcanale_stored['link'].'" ';
                                    }                                
                                    else {
                                        $string .= ' value="" ';
                                    }
                                                                
                                    if ($readonly){
                                            $string .= $disabled_value;
                                    }
                                        
                                    $string .= ' onkeyup="checklength(0, 255, \'link'.$id_canale.'\', \'charLink'.$id_canale.'\', \'\', \''.$id_canale.'\'); checklengthTotal(\'charLink'.$id_canale.'\',\'charTesto'.$id_canale.'\',\''.$id_canale.'\');checklength(0, 640, \'testo_sms'.$id_canale.'\', \'charTesto'.$id_canale.'\', \'numero_sms'.$id_canale.'\',\''.$id_canale.'\');"/>
                                    <label style="width:100%;"><small>Numero</small><input type="text" name="addcanale['.$id_canale.'][charLink'.$id_canale.']"  id="charLink'.$id_canale.'" class="text" readonly="readonly"  size="3" value="255" placeholder="max 255"onfocus="this.blur()" /></label>   
                                    <label style="width:100%;"><small>Totale (SMS+Link)</small><input type="number" id="numero_totale'.$id_canale.'"  name="addcanale['.$id_canale.'][numero_totale]"  value="" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                                
                        </span>      
                </div>
        </span>';

$string .='<span id="pos_field'.$id_canale.'" '.$display_pos.'>                                         
            <div class="col-md-4 col-sm-6 col-xs-12">
                <label  class="control-label">Titolo e Sottotitolo<span class="required">*</span></label>
               <textarea id="tit_sott_pos'.$id_canale.'" name="addcanale['.$id_canale.'][tit_sott_pos]"  '.$required_pos.' class="form-control" rows="3" data-parsley-trigger="keyup"  data-parsley-maxlength="2000"';
                if ($readonly){
                    $string .=$disabled_value;}
                    $string .='>';
                    if ($modifica and (isset($addcanale_stored['tit_sott_pos']))){
                        $string.= stripslashes($addcanale_stored['tit_sott_pos']); }
                        $string.='</textarea><br>                    
                <label>Categoria & Sottocategoria<span class="required">*</span></label>
                <select id="cat_sott_ins'.$id_canale.'" style="width: 100%" name="addcanale['.$id_canale.'][cat_sott_id]" class="select2_single form-control" '.$required_pos.' '.$disabled_value.' > ';
                    $string.= '<option  value=""></option>';
                    foreach ($cat_sott as $key => $value) {
                        if($modifica and isset($addcanale_stored['cat_sott_id']) and $addcanale_stored['cat_sott_id']==$value['id']){$selected = ' selected';}
                        else{$selected = '';}
                        $string .= '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . '</option>';
                    }
                    
                     
                $string .= '</select>
                <label  class="control-label">Giorni di Validità</label>
                <input'; if ($readonly){$string .=' '.$disabled_value;}
                $string .=' type="number" id="day_val_pos'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_pos]"  min="1" max="31" placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_pos'])){$string .= $addcanale_stored['day_val_pos']; }
                $string .=' "><br>
                <label class="control-label">Call Guide (4000 chars max)</label>
                <textarea id="callguide_pos'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_pos]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" ';
                if ($readonly){$string .= $disabled_value;}
                $string .=' >';
                if ($modifica and (isset($addcanale_stored['callguide_pos']))){$string .= stripslashes($addcanale_stored['callguide_pos']); }
                $string .='</textarea> 
            
            <label style="margin-top:20px" for="message">POS Testo SMS </label>
              <textarea id="testo_sms_pos'.$id_canale.'" ';
            $string .= ' '.$disabled_value.'  class="form-control" name="addcanale['.$id_canale.'][testo_sms_pos'.$id_canale.']" rows="8"  data-parsley-pattern-message="Caratteri come \'€\' \' ’ \' ed altri caratteri speciali non sono accettati come testo SMS !!"onkeyup="checklength(0, 640, \'testo_sms_pos'.$id_canale.'\', \'charTesto_pos'.$id_canale.'\', \'numero_sms_pos'.$id_canale.'\')" >';
            if($modifica and isset($addcanale_stored['testo_sms_pos'.$id_canale.''])){$string .= $addcanale_stored['testo_sms_pos'.$id_canale.''];}else{$string .= '';}
            $string .='</textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="addcanale['.$id_canale.'][charTesto_pos'.$id_canale.']" id="charTesto_pos'.$id_canale.'"  class="text" value="';
              if($modifica and isset($addcanale_stored['charTesto_pos'.$id_canale.''])){$string.= ''.$addcanale_stored['charTesto_pos'.$id_canale.''].'';}
              $string.='" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3"  onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="addcanale['.$id_canale.'][numero_sms_pos'.$id_canale.']" id="numero_sms_pos'.$id_canale.'" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="';
              if($modifica and isset($addcanale_stored['numero_sms_pos'.$id_canale.''])){$string.= ''.$addcanale_stored['numero_sms_pos'.$id_canale.''].'';} else{ $string .='0';}
              $string.='" onfocus="this.blur()" /></label>
            </div>
        </span>';

$string .='<span id="span_40400'.$id_canale.'" '.$display_40400.'> 

        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label class="control-label" for="alias_attiv">Alias Attivazione<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' type="text" id="alias_attiv'.$id_canale.'" name="addcanale['.$id_canale.'][alias_attiv]"  placeholder="alfanumerico"  class="form-control col-md-7 col-xs-12" value="';                
                if($modifica and isset($addcanale_stored['alias_attiv'])) {$string .= $addcanale_stored['alias_attiv']; }
                $string .= '">
                <br><br><br><br>
                <label  class="control-label" for="day_val">Giorni di Validità<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .=  $disabled_value;}
                $string .= ' type="number" id="day_val'.$id_canale.'" name="addcanale['.$id_canale.'][day_val]"  min="1" max="31" placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if($modifica and isset($addcanale_stored['day_val'])) {$string .= $addcanale_stored['day_val']; }
                $string .= '"><br><br><br><br><label  class="control-label" for="note">SMS Presa in carico<span class="required">*</span></label><textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_incarico'.$id_canale.'" name="addcanale['.$id_canale.'][sms_incarico]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_incarico'])){$string .= $addcanale_stored['sms_incarico']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_target">SMS Non in Target<span class="required">*</span></label>
                <textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_target'.$id_canale.'" name="addcanale['.$id_canale.'][sms_target]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_target'])){$string .= $addcanale_stored['sms_target']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Adesione già Avvenuta<span class="required">*</span></label>
                <textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_adesione'.$id_canale.'" name="addcanale['.$id_canale.'][sms_adesione]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_adesione'])){$string .=$addcanale_stored['sms_adesione']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS per Sistema Non Disponibile<span class="required">*</span></label>
                <textarea ';if ($readonly){$string .=  $disabled_value;}
                $string .= ' rows="2" id="sms_nondisponibile'.$id_canale.'" name="addcanale['.$id_canale.'][sms_nondisponibile]"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_stored['sms_nondisponibile'])){$string .=$addcanale_stored['sms_nondisponibile']; }
                $string .='</textarea>
        </div>
 </span>'; 
 
$string .='<span id="span_app_inbound'.$id_canale.'"  '.$display_app_inbound.' >
        <div class="col-md-4 col-sm-6 col-xs-12">
                <label  class="control-label">Id News<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .=$disabled_value;}
                $string .=' type="text" id="id_news_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][id_news_app_inbound]"   '.$required_app_inbound.' placeholder="testo"  data-parsley-trigger="keyup" data-parsley-maxlength="200" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['id_news_app_inbound'])){$string .= $addcanale_stored['id_news_app_inbound']; }
                $string .='">
                <br><br>     
                <label  class="control-label">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .=$disabled_value;}
                $string .=' type="number" id="day_val_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_app_inbound]"  min="1" max="31"  placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_app_inbound'])){$string .= $addcanale_stored['day_val_app_inbound']; }
                $string .='">
                <br><br>
                <label  class="control-label">Priorità<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .=$disabled_value;}
                $string .=' type="number" id="prior_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][prior_app_inbound]"  min="0" max="999"  placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['prior_app_inbound'])){$string .=$addcanale_stored['prior_app_inbound']; } else {$string .=0;}
                $string .='">                
                <br><br>
                <label class="control-label">Call Guide (4000 chars max)</label>
                    <textarea id="callguide_app_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_app_inbound]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" ';
                    if ($readonly){$string .= $disabled_value;}
                    $string .='>';if ($modifica and isset($addcanale_stored['callguide_app_inbound'])){$string .= stripslashes($addcanale_stored['callguide_app_inbound']); }
                    $string .='</textarea>
                    
        </div> 
    </span>
    
    <span id="span_app_outbound'.$id_canale.'" '.$display_app_outbound.'>
        <div class="col-md-4 col-sm-6 col-xs-12">
                <label  class="control-label">Id News<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .=$disabled_value;}
                $string .=' type="text" id="id_news_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][id_news_app_outbound]"   '.$required_app_outbound.' placeholder="testo"  data-parsley-trigger="keyup" data-parsley-maxlength="200" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['id_news_app_outbound'])){$string .= $addcanale_stored['id_news_app_outbound']; }
                $string .='">
                <br><br>       
                <label  class="control-label">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .=' type="number" id="day_val_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_app_outbound]"  min="1" max="31"  placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_app_outbound'])){$string .= $addcanale_stored['day_val_app_outbound']; }
                $string .='">
                <br><br>
                <label  class="control-label">Push Notification<span class="required">*</span></label>
                            <select id="notif_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][notif_app_outbound]" class="select2_single form-control" style="width:100%" '.$required_app_outbound.' '.$disabled_value.'>
                                <option ';
                                if($modifica and isset($addcanale_stored['notif_app_outbound']) && $addcanale_stored['notif_app_outbound']=='0'){$string.= ' selected';}
                                $string.=' value="0">N</option>
                                <option ';
                                if($modifica and isset($addcanale_stored['notif_app_outbound']) && $addcanale_stored['notif_app_outbound']=='1'){$string.= ' selected';}
                                $string.=' value="1">Y</option>
                                
                          </select>                          
                <label  class="control-label">Priorità<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .=$disabled_value;}
                $string .=' type="number" id="prior_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][prior_app_outbound]"  min="0" max="999"  placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['prior_app_outbound'])){$string .=$addcanale_stored['prior_app_outbound']; } else {$string .=0;}
                $string .='">                
                <br><br>
                <label class="control-label">Call Guide (4000 chars max)</label>
                    <textarea id="callguide_app_outbound'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_app_outbound]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" ';
                    if ($readonly){$string .= $disabled_value;}
                    $string .='>';if ($modifica and isset($addcanale_stored['callguide_app_outbound'])){$string .= stripslashes($addcanale_stored['callguide_app_outbound']); }
                    $string .='</textarea>
        </div>
    </span>   
    <span id="span_dealer'.$id_canale.'" '.$display_dealer.'>
        <div class="col-md-4 col-sm-6 col-xs-12">  
            <div class="col-md-12 col-sm-12 col-xs-12">
                <label  class="control-label">Iniziative Dealer da gestire<span class="required">*</span></label>
                <select  id="iniziative_dealer'.$id_canale.'" name="addcanale['.$id_canale.'][addcount_iniziative_dealer'.$id_canale.']" class="select2_single form-control" '.$required_dealer.' '.$disabled_value.'>';                
                                     
                for($i=2; $i<=9; $i++){
                    $add_display_cod[$id_canale][$i] = ' style="display: none;" '; 
                    $add_required_dealer[$id_canale][$i] = '';
                    if($modifica and isset($addcanale_stored['addcount_iniziative_dealer'.$id_canale.'']) and ($i<=$addcanale_stored['addcount_iniziative_dealer'.$id_canale.''])){
                        $add_display_cod[$id_canale][$i] = ' ';
                        $add_required_dealer[$id_canale][$i] = ' required="requuired" ';
                    }
                }    
                
                for($i=1; $i<=9; $i++){
                    $string .= '<option ';
                    if($modifica and isset($addcanale_stored['addcount_iniziative_dealer'.$id_canale.'']) and $addcanale_stored['addcount_iniziative_dealer'.$id_canale.'']==$i){ 
                        $string .= ' selected';
                    }
                    $string .= ' value='.$i.' >'.$i.'</option>';
                }
                                 
                $string .='</select></div><br>                  
                <div class="col-md-12 col-sm-12 col-xs-12" id="dealer_1">  
                <label  class="control-label">Cod. iniziativa 1<span class="required">*</span></label>
                <input class="form-control col-md-7 col-xs-12" ';
                    if ($readonly){$string .= $disabled_value;}
                    $string .=' type="number" id="Cod_iniziativa'.$id_canale.'" name="addcanale['.$id_canale.'][addCod_iniziativa1]"  min="1"  '.$required_dealer.'  max="999" placeholder="numerico da min 1 a max 999"  data-parsley-trigger="keyup" data-parsley-minlength="0" data-parsley-maxlength="3"  value="';
                    if(isset($addcanale_stored['addCod_iniziativa1'])){$string .= $addcanale_stored['addCod_iniziativa1']; }
                $string .='"></div>'; 
                
                for($i=2; $i<=9; $i++){                    
                    $string.='<div class="col-md-12 col-sm-12 col-xs-12" id="'.$id_canale.'adddealer_'.$i.'" '.$add_display_cod[$id_canale][$i].' >      
                            <label  class="control-label">Cod. iniziativa '.$i.'<span class="required">*</span></label>                        
                            <input ';
                            if ($readonly){$string.= $disabled_value;}
                            $string.=' type="number" id="'.$id_canale.'addCod_iniziativa'.$i.'" name="addcanale['.$id_canale.'][addCod_iniziativa'.$i.']" '.$add_required_dealer[$id_canale][$i].' min="0" max="999" placeholder="numerico da min 0 a max 999"  data-parsley-trigger="keyup" data-parsley-minlength="0" data-parsley-maxlength="3" class="form-control col-md-7 col-xs-12" value="';
                            if(isset($addcanale_stored['addCod_iniziativa'.$i.''])){$string.= $addcanale_stored['addCod_iniziativa'.$i.'']; }
                            $string.='">
                            <br>                          
                    </div>';
                     
                }                                            
$string.='</div>
    </span>
    <span id="span_icm'.$id_canale.'" '.$display_icm.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità<span class="required">*</span></label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .=' type="number" id="day_val_icm'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_icm]"  min="1" max="31" '.$required_icm.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_icm'])){$string .= $addcanale_stored['day_val_icm']; }
                $string .='">
                <br><br>                             
        
                <label class="control-label">Call Guide (4000 chars max)                
                <span class="required">*</span></label>
                    <textarea id="callguide_icm'.$id_canale.'" name="addcanale['.$id_canale.'][callguide_icm]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" '.$required_icm;
                    if ($readonly){$string .= $disabled_value;}
                    $string .='>';
                    if ($modifica and isset($addcanale_stored['day_val_icm'])){$string .= stripslashes($addcanale_stored['callguide_icm']); }
                    $string .='</textarea>
                    
        </div>
    </span>
    <span id="span_ivr_inbound'.$id_canale.'" '.$display_ivr_inbound.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità<span class="required">*</span></label>
                <input ';
                if ($readonly){ $string .= $disabled_value;}
                $string .=' type="number" id="day_val_ivr_inbound'.$id_canale.'" name="addcanale['.$id_canale.'][day_val_ivr_inbound]"  min="1" max="31" '.$required_ivr_inbound.' placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if(isset($addcanale_stored['day_val_ivr_inbound'])){$string .= $addcanale_stored['day_val_ivr_inbound']; }
                $string .='">
                <br><br>                             
        </div>
    </span>
    <span id="span_ivr_outbound'.$id_canale.'" '.$display_ivr_outbound.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Giorni di Validità<span class="required">*</span></label>
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
                <label class="control-label col-md-6 col-sm-3 col-xs-12">Data invio JAKALA<span class="required">*</span></label>
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
                <label class="control-label col-md-6 col-sm-3 col-xs-12">Data invio SPAI<span class="required">*</span></label>
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
                <label  class="control-label">Tipologia MFH<span class="required">*</span></label>
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
    
                <label  class="control-label">Note MFH<span class="required">*</span></label>                
                <textarea id="note_mfh'.$id_canale.'" name="addcanale['.$id_canale.'][note_mfh]" class="form-control" rows="10" data-parsley-trigger="keyup"  data-parsley-maxlength="4000" ';
                if ($readonly){$string .= $disabled_value;}
                $string .=' >';
                if ($modifica and (isset($addcanale_stored['note_mfh']))){$string .= stripslashes($addcanale_stored['note_mfh']); }
                $string .='</textarea>                             
        </div>
    </span>
    <span id="span_watson'.$id_canale.'" '.$display_watson.'>
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label  class="control-label">Tipologia Campagna Watson<span class="required">*</span></label>
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
   
                <label  class="control-label">Tipologia Contatto Watson<span class="required">*</span></label>
                <select  id="contact_watson'.$id_canale.'" name="addcanale['.$id_canale.'][contact_watson]" class="select2_single form-control" '.$required_watson.' '.$disabled_value.'>
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
    </span>';
    $string .='<span id="span_inorderweb'.$id_canale.'" '.$display_iow.'>
                      <div class="col-md-4 col-sm-6 col-xs-12">      
                <label>Funnel<span class="required">*</span></label>          
    <input id="funnel'.$id_canale.'" ';
                    if ($readonly){$string .= $disabled_value;}
                    $string .=' type="text" class="form-control has-feedback-rigth"  placeholder="alfanumerico" aria-describedby="inputSuccessSpai" '.$required_iow.'  name="addcanale['.$id_canale.'][funnel]" value="';
                    if(isset($addcanale_stored['funnel'])){$string .= $addcanale_stored['funnel'];}
                    $string .='">
                <br>
        </div>
    </span> 
    </div>
    ';

    $string .=' <script src="addTabCanale'.$id_canale.'.js"></script>';


    echo $string; 
            
                

    