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



 $string .='</div>';        
                
echo $string;                