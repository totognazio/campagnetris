<?php

include_once './classes/campaign_class.php';
include_once './classes/funzioni_admin.php';
$funzione = new funzioni_admin();
$campaign = new campaign_class();
$channels = $funzione->get_list_select('channels');
$tit_sott = $funzione->get_allTable('campaign_titolo_sottotitolo');
$cat_sott = $funzione->get_allTable('campaign_cat_sott');

$id_campaign = array();



//$dati = array();
//$string = '<option value=""></option>';
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
        print_r(json_decode($id_campaign['addcanale']), true); 
        $addcanale_sotred = json_decode($id_campaign['addcanale'],true)[$id_canale];
        
        //recuperare i valori della campagna da modificare
    }
 
   
    
}
$list = $funzione->get_list_id('channels');
$lista_field = array_column($list, 'id');
$lista_name = array_column($list, 'name');
$javascript = $disabled_value.' required="required" ';
$display_sms =  ' style="display: none;"';
                            $required_sms_field = '';
                            $required_pos_field = '';
                            $display_pos =  ' style="display: none;"';
                            $display_40400 =  ' style="display: none;"';
                            $style = " style=\"width:100%;\" ";
                            if ($modifica){
                                $valore_channel_id = $id_campaign['channel_id'];
                                //sms sms_long
                                if($valore_channel_id==1 or $valore_channel_id==12){$display_sms =  ''; $required_sms_field =  ' required="required" ';}
                                //POS
                                if($valore_channel_id==13){$display_pos =  ''; $required_pos_field =  ' required="required" ';} 
                                //40400
                                if($valore_channel_id==14){$display_40400 =  ''; }    
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
                            <select id="senders_ins'.$id_canale.'" name="addcanale['.$id_canale.'][sender_id]" class="select2_single form-control" style="width:100%" '.$required_sms_field.'  '.$disabled_value.'>';      
                              
                                if(isset($addcanale_sotred['sender_id'])){
                                   $string .= '<option selected value="'.$addcanale_sotred['sender_id'].'">'.$addcanale_sotred['sender_nome'].'</option>'; 
                                }                                
                                
                          $string .= '</select>
                        
                       <label style="margin-top:20px">Storicizzazione Legale  <span class="required">*</span></label>                        
                       
                            <select id="storicizza_ins'.$id_canale.'" name="addcanale['.$id_canale.'][storicizza]" class="select2_single form-control" style="width:100%"  <?php echo $required_sms_field; ?> <?php echo $disabled_value;?>>      
                                <option value=""></option>
                                <option';
                                 if($modifica and $addcanale_sotred['storicizza']=='0'){$string .=  ' selected';} 
                                $string .=  ' value="0">No</option>
                                <option';
                                if($modifica and $addcanale_sotred['storicizza']=='1'){$string .=  ' selected';}
                                 $string .= ' value="1">Si</option>
                                

                          </select>
                         
          
            
              <label style="margin-top:20px" for="message">Test SMS </label>
              <textarea id="testo_sms"';
            $string .= ' '.$disabled_value.' '.$required_sms_field.' class="form-control" name="testo_sms" onkeyup="checklength(0, 640, \'testo_sms\', \'charTesto\', \'numero_sms\')" >';
            if($modifica and isset($addcanale_sotred['testo_sms'])){$string .= $addcanale_sotred['testo_sms'];}else{$string .= ' ';}
            $string .='</textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="charTesto" id="charTesto'.$id_canale.'" value="" class="text" value="" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="numero_sms" id="numero_sms'.$id_canale.'" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                     
     
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio'.$id_canale.'" name="addcanale['.$id_canale.'][mod_invio]" class="select2_single form-control" style="width:100%" '.$required_sms_field.' '.$disabled_value.'>      
                                <option value=""></option>
                                <option value="Interattivo"';
                                if($modifica and $addcanale_sotred['mod_invio']=='Interattivo'){ $string .= ' selected ';} 
                                $string .='>Interattivo</option>
                                <option ';
                                if($modifica and $addcanale_sotred['mod_invio']=='Standard'){$string .= ' selected';}
                                $string .=' value="Standard">Standard</option>

                          </select>';
                        if($modifica and $addcanale_sotred['mod_invio']=='Interattivo'){ ?>
                            <script> 
                                $('#spanLabelLinkTesto<?php echo $id_canale; ?>).show();
                                $('#link').attr('required', true);                                                                   
                            </script>
                        <?php } 
                         else { ?>
                            <script> 
                                $('#spanLabelLinkTesto<?php echo $id_canale; ?>').hide();
                                $('#link<?php echo$id_canale; ?>').attr('required', false);                                                                   
                            </script>
                        <?php } 
                        $string .=' 
                        <span id="spanLabelLinkTesto'.$id_canale.'">
                            <label style="margin-top:20px" id="labelLinkTesto">Link<span id="req_19" class="req">*</span></label>
                            <input  id="link" name="addcanale['.$id_canale.'][link]" type="text" class="form-control col-md-7 col-xs-12" style="text-align:right" tabindex="23" maxlength="400" ';
                            
                            if ($modifica){
                                $string .=' value="' . $addcanale_sotred['link'].'" ';
                            }                                
                            else {
                                $string .= ' value="" ';
                            }
                                                         
                            if ($readonly){
                                    $string .= $disabled_value;
                            }
                                
                            $string .= ' onkeyup="checklength(0, 255, \'link\', \'charLink\', \'\'); checklengthTotal(\'charLink\',\'charTesto\',\'numero_totale\');"/>
                            <label style="width:100%;"><small>Numero</small><input type="text" name="charLink" id="charLink" class="text" readonly="readonly"  size="3" value="255" placeholder="max 255"onfocus="this.blur()" /></label>   
                            <label style="width:100%;"><small>Totale (SMS+Link)</small><input type="text" name="numero_totale" id="numero_totale" value="" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                        </span>   
                          <br>
                       <label style="margin-top:20px">Tipo Monitoring  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="tipoMonitoring'.$id_canale.'" name="addcanale['.$id_canale.'][tipoMonitoring]" class="select2_single form-control" style="width:100%" <?php echo $required_sms_field; ?> <?php echo $disabled_value; ?>>      
                                <option value=""></option>
                                <option';
                                if($modifica and $addcanale_sotred['tipoMonitoring']=='1'){$string .=  ' selected';}
                                $string .= 'value="1">ADV Tracking tool</option>
                                <option ';
                                if($modifica and $addcanale_sotred['tipoMonitoring']=='2'){$string .=  ' selected';}
                                $string .= ' value="2">Orphan page</option>
                                <option ';
                                if($modifica and $addcanale_sotred['tipoMonitoring']=='3'){$string .=  ' selected';}
                                $string .= ' value="3">No monitoring</option>
                          </select>
                       <label style="margin-top:20px">Durata SMS  <span class="required">*</span></label>
                          <input type="text" id="sms_duration" name="sms_duration"  class="form-control col-md-7 col-xs-12" value="';
                        if($modifica and isset($addcanale_sotred['sms_duration'])){$string .=  $addcanale_sotred['sms_duration'];}else{$string .= '2';};
                         $string .= '" '.$required_sms_field.' '. $disabled_value.'>';
                        $string .= '<img id="info" title="Numero di giorni in cui la rete tenter&agrave; l\'invio dell\'sms. Range da 1 a 7 giorni." alt="Durata SMS" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
  
        </div>

        </span>   
        <span id="pos_field'.$id_canale.'" '.$display_pos.'> 
            <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Categoria & Sottocategoria</label>
                <select id="cat_sott_ins'.$id_canale.'" style="width: 100%" name="addcanale['.$id_canale.'][cat_sott_id]" class="select2_single form-control" '.$required_pos_field.' '.$disabled_value.'>';        
                                                 
                    foreach ($cat_sott as $key => $value) {
                        if($modifica and $addcanale_sotred['cat_sott_id']==$value['id']){$selected = ' selected';}
                        else{$selected = '';}
                        $string .=  '<option '. $selected. ' value="' . $value['id'] .'">'  . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                     
                $string .= '</select>
            </div>

        </span></div>

    <span id="span_40400'.$id_canale.'" '.$display_40400.'> 
        <div class="col-md-4 col-sm-6 col-xs-12">      
                <label class="control-label" for="alias_attiv">Alias Attivazione</label>
                <input ';
                if ($readonly){$string .= $disabled_value;}
                $string .= 'type="text" id="alias_attiv" name="alias_attiv"  placeholder="alfanumerico"  class="form-control col-md-7 col-xs-12" value="';
                if(isset($id_campaign['alias_attiv'])){$string .= $id_campaign['alias_attiv']; }
                $string .= '">
                <br><br><br><br>
                <label  class="control-label" for="day_val">Giorni di Validità</label>
                <input ';
                if ($readonly){$string .=  $disabled_value;}
                $string .= 'type="number" id="day_val" name="day_val"  min="1" max="31" placeholder="numerico"  data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" value="';
                if($modifica and isset($addcanale_sotred['day_val'])) {$string .= $addcanale_sotred['day_val']; }
                $string .= '"><br><br><br><br><label  class="control-label" for="note">SMS Presa in carico</label><textarea';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_incarico" name="sms_incarico"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_sotred['sms_incarico'])){$string .= $addcanale_sotred['sms_incarico']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_target">SMS Non in Tanget</label>            
                <textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_target" name="sms_target"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_sotred['sms_target'])){$string .= $addcanale_sotred['sms_target']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Adesione già Avvenuta</label>
                <textarea ';
                if ($readonly){$string .= $disabled_value;}
                $string .= ' rows="2" id="sms_adesione" name="sms_adesione"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" > ';
                if($modifica and isset($addcanale_sotred['sms_adesione'])){$string .=  $addcanale_sotred['sms_adesione']; }
                $string .= '</textarea>
                <br><br>
                <label class="control-label" for="sms_adesione">SMS Non Disponibile</label>
                <textarea ';if ($readonly){$string .=  $disabled_value;}
                $string .= ' rows="2" id="sms_nondisponibile" name="sms_nondisponibile"  placeholder="alfanumerico (max 160 char.)" data-parsley-maxlength="160" data-parsley-trigger="keyup" class="form-control col-md-7 col-xs-12" >';
                if($modifica and isset($addcanale_sotred['sms_adesione'])){$string .=  $addcanale_sotred['sms_adesione']; }
                $string .= '</textarea>
        </div>
 </span> 
    ';  

$string .= '<script>
    $(\'#channel_ins'.$id_canale.'\').select2({
      placeholder: "Select" 
    });
    
    $(\'#channel_ins'.$id_canale.'\').on(\'select2:select\', function() {
      console.log(\'channel_id'.$id_canale.'  \' + selected_channel_id'.$id_canale.');
      var selected_channel_id'.$id_canale.' = $(\'#channel_ins'.$id_canale.'\').val();
      const canale_text_id = $(\'#channel_ins :selected'.$id_canale.'\').text();
      $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', false);
      $(\'#sms_duration'.$id_canale.'\').attr(\'required\', false);
      $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', false);
      $(\'#link'.$id_canale.'\').attr(\'required\', false);
      $(\'#mod_invio'.$id_canale.'\').attr(\'required\', false);
      $(\'#testo_sms'.$id_canale.'\').attr(\'required\', false);
      $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', false);
      $(\'#senders_ins'.$id_canale.'\').attr(\'required\', false);
      $(this).parsley().validate();

      if (selected_channel_id'.$id_canale.' === \'1\' || selected_channel_id'.$id_canale.' === \'12\') {
        $(\'#sms_field'.$id_canale.'\').show();
        $(\'#sms_duration'.$id_canale.'\').attr(\'required\', true)
        $(\'#tipoMonitoring'.$id_canale.'\').attr(\'required\', true)
        $(\'#link'.$id_canale.'\').attr(\'required\', true)
        $(\'#mod_invio'.$id_canale.'\').attr(\'required\', true)
        $(\'#testo_sms'.$id_canale.'\').attr(\'required\', true)
        $(\'#storicizza_ins'.$id_canale.'\').attr(\'required\', true)
        $(\'#senders_ins'.$id_canale.'\').attr(\'required\', true)
        $(\'#pos_field'.$id_canale.'\').hide();

        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id'.$id_canale.'
          },
          dataType: "html",
          success: function(data) {
            console.log(\'eccoli data\' + JSON.stringify(data));
            console.log(\'eccoli2 data\' + data);
            $("#senders_ins'.$id_canale.'").fadeOut();
            $("#senders_ins'.$id_canale.'").fadeIn();
            $("#senders_ins'.$id_canale.'").html(data);
            //$("#selected_senders'.$id_canale.'") = data;

          }

        });

      } else if (selected_channel_id'.$id_canale.' === \'13\') {
          console.log(\'quiiiii channel_id'.$id_canale.'  \');
        $(\'#pos_field'.$id_canale.'\').show();
        $(\'#cat_sott_ins'.$id_canale.'\').attr(\'required\', true)
        $(\'#sms_field'.$id_canale.'\').hide();

        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id'.$id_canale.'
          },
          dataType: "html",
          success: function(data) {
            $(\'#pos_field'.$id_canale.'\').show();  
            $("#cat_sott_ins'.$id_canale.'").fadeOut();
            $("#cat_sott_ins'.$id_canale.'").fadeIn();
            $("#cat_sott_ins'.$id_canale.'").html(data);

          }

        });
      } 
      else if(canale_text===\'40400\'){
                $(\'#span_40400'.$id_canale.'\').show();
      
      }
      else {
        $(\'#sms_field'.$id_canale.'\').hide();
        $(\'#pos_field'.$id_canale.'\').hide();
        $(\'#span_40400'.$id_canale.'\').hide();
      }
      
    });

    </script>
    ';
            
                
echo $string;                