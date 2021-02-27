<style>
input:focus {
  background-color: yellow;
}
</style>  
<!-- bootstrap-daterangepicker -->
<link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- NProgress -->
<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- Dropzone.css -->
<link href="vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
<!-- Dropzone.js -->
<script src="vendors/dropzone/dist/dropzone.js"></script>

<script type="text/javascript">
        // Immediately after the js include
        Dropzone.autoDiscover = false;     
</script>

<?php
include_once './classes/access_user/access_user_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once './classes/form_class.php';

$form = new form_class();
$funzione = new funzioni_admin();
$funzioni_admin = new funzioni_admin();

$page_protect = new Access_user;
$page_protect->get_user_info();
$campaign = new campaign_class();

/// form tutto vuoto nel caso di add new campagna 

////////////////////// Per prevenire inserimento ad ogni F5
$_SESSION['form_submit'] = TRUE;
//////////////////////////////////

$messaggio = "";
$title = "Inserimento Nuova Campagna";
$id_upload = uniqid();
$nome_campagna = '';
$disabled_value = "";
$modifica = 0;
$action_duplica = false;
$modifica_stato = false;
$modifica_codici = false;
$display_none = "";
$load = "";
$id_campaign = array();
$azione = "new";
$readonly = false;
$readonly_value = "";
$visualizza_campagna = 0;


$back_url = "";
if ($page_protect->check_top_user($page_protect->get_squad())) {
    $back_url = "./index.php?page=pianificazione2";
} else {
    $back_url = "./index.php?page=gestioneCampagne2";
}

//leffo azione dai link bottoni
if (isset($_POST['azione'])) {
    
    $azione = $_POST['azione'];
    $id = $_POST['id'];
    
}

if ( isset($azione) && $azione=='modifica') {
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($id))->fetch_array();
    $title = "Modifica della Campagna ";
    //$nome_campagna = $campaign->name_camp($id_campaign);
    $nome_campagna = $id_campaign['pref_nome_campagna'];
    $modifica = true;
    $id_upload = $id_campaign['id'];
    $squad_id = $id_campaign['squad_id'];
    if ($page_protect->get_job_role() > 2) {
        $modifica_codici = true;
    }
    $permission = $page_protect->check_permission($squad_id);

    if ($permission) {
        
        if (isset($_POST['modifica_confim'])) {
            $messaggio = $campaign->update($_POST, $id);
        }
    } else {
        $messaggio = "L'utente non pu&ograve; modificare la campagna";
        $visualizza_campagna = 1;
        $modifica = true;
        $readonly = true;
        $readonly_value = " readonly=\"readonly\" ";
        $disabled_value = " disabled=\"disabled\"  ";
        $display_none = " display:none; ";
    }
} 
elseif ( isset($azione) && $azione=='open') {
    $visualizza_campagna = 1;
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . $id)->fetch_array();
    $modifica = true;
    $readonly = true;
    $readonly_value = " readonly=\"readonly\" ";
    $disabled_value = " disabled=\"disabled\"  ";
    $display_none = " display:none; ";
    $title = "Visualizzazione Campagna ";
    //$nome_campagna = $campaign->name_camp($id_campaign);
    $nome_campagna = $id_campaign['pref_nome_campagna'];

} 
elseif ( isset($azione) && $azione=='duplica') {    
    $title = "Duplicazione Campagna ";
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($id))->fetch_array();
    //$nome_campagna = $campaign->name_camp($id_campaign);
    $nome_campagna = $id_campaign['pref_nome_campagna'];
    // print_r($id_campaign);
    $action_duplica = true;
    $modifica = true;
    $squad_id = $id_campaign['squad_id'];
    if ($page_protect->get_job_role() > 2) {
        $modifica_codici = true;
    }
    $permission = $page_protect->check_permission($squad_id);

    if ($permission) {
        if (isset($_POST['modifica_confim'])) {
            $messaggio = $campaign->update($_POST, $id);
        }
    } else {
        $messaggio = "L'utente non pu&ograve; modificare la campagna";
        $visualizza_campagna = 1;
        $modifica = true;
        $readonly = true;
        $readonly_value = " readonly=\"readonly\" ";
        $disabled_value = " disabled=\"disabled\"  ";
        $display_none = " display:none; ";
    }
}

///////////////////////////////////////////////////////////
$channels = $funzione->get_list_select('channels');
$stacks = $funzione->get_list_select('campaign_stacks');
//$offers = $funzione->get_offers();
$offers = $funzione->get_list_select('campaign_offers2');

// print_r($offers);
$typlogies = $funzione->get_list_select('campaign_types');
$squads = $funzione->get_list_select('squads');
$states = $funzione->get_list_select('campaign_states');
$category = $funzione->get_list_select('campaign_categories');
$modality = $funzione->get_list_select('campaign_modalities');
$segments = $funzione->get_list_select('segments');
//$tit_sott = $funzione->get_allTable('campaign_titolo_sottotitolo');
//print_r($tit_sott);
$cat_sott = $funzione->get_allTable('campaign_cat_sott');
$sender = $funzione->get_allTable('senders');


//print_r($_POST);
//print_r($id_campaign);

?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_center">
                <h3><?php echo $title; ?> - <?php echo $nome_campagna; ?></h3>

              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">


                </div>
              </div>
            </div>
        <div class="clearfix"></div>            
        <!--Open Row page-->    
            <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                    <div class="x_title"><?php #print_r($_POST);print_r($id_campaign);?>
                      
   
   <?php
        if ($visualizza_campagna) {
            $elimina = "";
            $stato_elimina = $id_campaign['elimina'];
            $squad_id = $id_campaign['squad_id'];
            $squad_id = $page_protect->get_squad();
            $permission = $page_protect->check_permission($squad_id);

            ?>
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaModifica<?php echo $id; ?>">
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="azione" value="modifica" />                                                                
                        </form>
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaDuplica<?php echo $id; ?>"> 
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="azione" value="duplica" />                                                                
                        </form>
                        <form action="index.php?page=pianificazione2"  method="post" id="campagnaElimina<?php echo $id; ?>"> 
                            <input type="hidden" name="id" value="<?php echo $id; ?>" />
                            <input type="hidden" name="azione" value="elimina" />                                                                
                    </form>

            
                <ul class="nav navbar-left panel_toolbox">
                    
<a class="btn btn-sm btn-success" href="<?php echo $back_url;?>" data-placement="bottom" data-toggle="tooltip" data-original-title="Indietro" title="Indietro"><i class="fa fa-arrow-left"></i></a>                            
               
                   <a class="btn btn-sm btn-primary"href="#" onclick="manageCamp(<?php echo $id; ?>, 'modifica',<?php echo $permission; ?>);"  data-placement="bottom" data-toggle="tooltip" data-original-title="Modifica" title="Modifica"><i class="fa fa-edit"></i></a>        
              
<a class="btn btn-sm btn-default" href="#" onclick="manageCamp(<?php echo $id; ?>, 'duplica',<?php echo $permission; ?>);"  data-placement="bottom" data-toggle="tooltip" data-original-title="Duplica" title="Duplica"><i class="fa fa-clone"></i></a>         
              
<a class="btn btn-sm btn-danger" href="#" onclick="manageCamp(<?php echo $id; ?>, 'elimina',<?php echo $permission; ?>,<?php echo $stato_elimina; ?>);"  data-placement="bottom" data-toggle="tooltip" data-original-title="Elimina" title="Elimina"><i class="fa fa-trash-o"></i></a>    
                    
                
                </ul>

            <?php
        }
 if($azione == 'modifica' || $azione == 'duplica' || $azione == 'new')  {
?>  
    <h2>Compilazione</h2>
<?php
 }     
 ?>

                   



                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <!--<li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>-->
                    </ul>

                    <div class="clearfix"></div>
                   </div>  
              
                    <!--<div class="col text-center">
                          <a  href="index.php?page=inserisciCampagna2" class="btn btn btn-xs btn-success"><i class="fa fa-plus-square"></i> Add Canale</a>
                          
                      </div>-->
        
                   
                  <div class="x_content">                     
<!--inizio mega Form inserimento-->   
<div class="bs-callout bs-callout-warning hidden">
  <h3><strong>Errore di validazione !!!   :(</strong></h3>
  <p><strong> Verifica il corretto inserimento dei campi evidenziati in rosso in tutte le schede</strong></p>
</div>

<!--
<div class="bs-callout bs-callout-info hidden">
  <h4>Yay!</h4>
  <p>Everything seems to be ok :)</p>
</div>   -->
<?php //print_r($_POST); ?>    
<form id="form-campagna-ins"  data-parsley-validate="" class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?php echo $back_url; ?>" method="post">  
                <input type="hidden" name="azione" value="<?php echo $_POST['azione']; ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $page_protect->id; ?>"> 
                <input type="hidden" name="id_upload" id="fileid" value="<?php echo $id_upload; ?>">  
                <div  id="myTab" class="" role="tabpanel" data-example-id="togglable-tabs">
                       
                      <ul  id="myTab-ul" class="nav nav-tabs bar_tabs" role="tablist">
                        <li id="tabcampagna" role="presentation" class="active"><a href="#tab_content1" id="home-tab" class="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Campagna</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Criteri</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Comunicazione</a>
                        </li>
                       <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Canale</a>
                        </li>
                        <li id="add-contact" role="presentation" class=""><a href="#" class="add-contact">+ Add Canale</a>
                        </li>                       

                      </ul>
                           
                      <div id="myTabContent" class="tab-content">
                                <!-- Tab Campagna-->
                           <?php  include_once 'tab_campagna.php'; ?>                   
                                <!-- Tab Criteri-->   
                           <?php  include_once 'tab_criteri.php'; ?>
                               <!-- Tab Canale-->  
                           <?php  include_once 'tab_canale.php'; ?>
                               <!-- Tab Comunicazione--> 
                           <?php  include_once 'tab_comunicazione.php'; ?>
                               <!-- Tab Canale-->  
                           <?php  #include_once 'tab_canale2.php'; ?>
     
                      </div> 
                      
                        <br>
                                             
                      
                            <div class="form-group">
                              <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                                  <div class="ln_solid"></div>
                    <?php
                    /*                  <input type="hidden" name="department_id" id="department_id" value="<?php echo $page_protect->get_department(); ?>"/>
                     * 
                     */
                    ?>
                    <input type="hidden" name="optimization" id="optimization" value="0" />
                    <input id="annulla" style="<?php echo $display_none; ?>"  class="btn btn-primary" name="annulla" tabindex="63" type="button" value="Annulla" onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"/>
                    <?php
                    if ( isset($azione) && $azione=='modifica') {
                        ?>
                        <input id="modifica" style="<?php echo $display_none; ?>" class="btn btn-warning" name="modifica" tabindex="64" type="submit" value="modifica" />

                        <input type="hidden" name="modifica_confim" id="modifica_confim" value="modifica_confim" />
                        <input type="hidden" name="id" id="id" value="<?php echo $_POST['id']; ?>"/>
                        <?php
                    } else {                        
                        ?>
                        <input style="<?php echo $display_none; ?>" id="salva" class="btn btn-success" name="salva" tabindex="64" type="submit" value="Salva" />
                        <input type="hidden" name="campaign_state_id" id="campaign_state_id" value="2" />
                        <?php
                    }
                    ?>
                    <input type="hidden" id="inserisciCampagna" name="inserisciCampagna" value="1" />
            
                              </div>
                            </div>

                   
                    </div>

</form>  

<?php $form->close_page(); ?>

<script>

//in caso di modifica open duplica di campagna multicanale 
var last_tab_click = 1; 
  
function validitaoffer(){
    if($( "#validitalevaofferta" ).val()==='1'){
        $('#validita-offerta').show();
        $('#descrizione_offerta').attr('required', true);   
    } else if($( "#validitalevaofferta" ).val()==='0'){
        $('#validita-offerta').hide();
        $('#descrizione_offerta').attr('required', false);
    }
    else {
       $('#validita-offerta').hide(); 
       $('#descrizione_offerta').attr('required', false);
    }
    
}
 
function levaselect() {
    if($( "#idlevaselect" ).val()==='mono'){
        $('#monoleva').show();
        $('#opzione_leva').attr('required', true); 
        $('#multileva').hide();
        $('#dropzone-canale').attr('required', false);
    }else if($( "#idlevaselect" ).val()==='multi'){
        $('#monoleva').hide();
        $('#multileva').show();
        $('#dropzone-canale').attr('required', true);
        $('#opzione_leva').attr('required', false);
    }
    else{
        $('#monoleva').hide();
        $('#multileva').hide();  
        $('#dropzone-canale').attr('required', false);
        $('#opzione_leva').attr('required', false);
    }
}

  
function checklength(areaText, maxchars, input, char, char_count_sms) {
    lunghezza_sms = 160;
    lunghezza_sms_concatenato = 153;
    lunghezza_link = 28;
    chars = document.getElementById(input).value;
    if ((document.getElementById("mod_invio").value == "Interattivo") && (input == "testo_sms")) {
        lunghezza_link = 28;
    } else {
        lunghezza_link = 0;
    }
    maxchars = maxchars - lunghezza_link;
    if (chars.length > maxchars)
    {
        document.getElementById(input).value = chars.substr(0, maxchars);
        document.getElementById(input).blur();
    }
    //document.getElementById(char).value = maxchars - document.getElementById(input).value.length;
    document.getElementById(char).value = document.getElementById(input).value.length;
    if (char_count_sms != '') {
        if (document.getElementById(input).value.length <= 160 - lunghezza_link)
            document.getElementById(char_count_sms).value = 1;
        else
            document.getElementById(char_count_sms).value = Math.floor((document.getElementById(input).value.length - lunghezza_link) / 153) + 1;
    }
}

function checklengthTotal(input, char) {   
    lunghezza_test_sms = 0;
    chars = document.getElementById(input).value;
    if ((document.getElementById("mod_invio").value === "Interattivo")) {
        lunghezza_test_sms = document.getElementById(char).value; 
        
    } else {
        lunghezza_test_sms = 0;
    }
    totale = document.getElementById("numero_totale").value = parseInt(chars) + parseInt(lunghezza_test_sms) + 1;
    //alert('eccolo test ' + totale);
}

//Tab canale controller
$(".nav-tabs").on("click", "a", function (e) {
        e.preventDefault();
        if (!$(this).hasClass('add-contact')) {
            $(this).tab('show');
        }
    })
    .on("click", "span", function () {
        var anchor = $(this).siblings('a');
        $(anchor.attr('href')).remove();
        $(this).parent().remove();
        $(".nav-tabs li").children('a').first().click();
    });

//creazione nuovo Tab addcanale    
$('.add-contact').click(function (e) {
    e.preventDefault();
    var id = $(".nav-tabs").children().length; //think about it ;)
    var tab_name = 'Canale ' + (id-3);
    var readonly_value = <?php if($readonly){echo 1;} else{echo 0;}?>
    
    //limite canali aggiunti 5 + 5 tab di default
    if(id<10){
            $(this).closest('li').before('<li><a href="#contact_' + id + '">' + tab_name + ' </a><span style="cursor:pointer;position:absolute;right: 6px;top: 8px;color: red;">x</span></li>'); 

            $.ajax({
                url: "addTabCanale.php",
                        method: "POST",
                        data: {readonly: readonly_value, tab_id: id, campaign_id: <?php if(isset($azione)) echo $id; else {echo 0;}?>, disabled_value: <?php if(!empty($disabled_value)) echo $disabled_value; else {echo "''";}?> , azione: '<?php echo $azione; ?>'},
                        dataType:"html",    
                        success: function (data)
                        {
                            //console.log('eccoli data' + JSON.stringify(data));
                            $('.tab-content').append(data); 
                            console.log('ultimo tab '+last_tab_click);
                            if(last_tab_click){
                                $('.nav-tabs li:nth-child(' + id + ') a').click();
                            }  
                            
                        }
            }); 
    }
    else if(readonly_value){
        alert(' Azione non consentita !!!')
    }
    else{
        alert('E\' stato raggiunto il limite massimo di canali per una campagna!!!')
    }  
});







$(document).ready(function() {  

<?php 
 
 if (isset($azione) && ($azione=='duplica' || $azione=='modifica' || $azione=='open')) {

    if(isset(json_decode($id_campaign['addcanale'],true)[1])){
        $addcanale = json_decode($id_campaign['addcanale'],true);

        for($i=1;  $i<count($addcanale); $i++){?>
                last_tab_click = 0; //in caso di apertura campagna multicanale 
                $('.add-contact').trigger("click");
                //$('#myTab-ul a:first').trigger("click");
            <?php    
        } 
    } ?>
    
    //$('#myTab-ul a:first').tab('show'); 
    //$('#myTab-ul a:first').trigger("click");
    
    <?php
}

 ?>

$('#mod_invio').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$('#mod_invio').on('select2:select', function () {
    const selected_modsms = $('#mod_invio').val();    
    
    if(selected_modsms === 'Interattivo'){
           $("#spanLabelLinkTesto").fadeOut();
           $("#spanLabelLinkTesto").fadeIn();  
           $('#link').attr('required', true);  
    }
    else {
       $("#spanLabelLinkTesto").fadeOut(); 
       $('#link').attr('required', false);  
    }
    //console.log('selected_modsms  '+ selected_modsms);   
    });
 

    var selected_duratacampagna = $('#duratacampagna').val();
    durata_camp(selected_duratacampagna);
    
    
    
});
    
    
    function durata_camp(value) {
     if(value === '0'){
            $('#day1').hide();
            $('#day2').hide();
            $('#day3').hide();
            $('#day4').hide();
            $('#day5').hide();
            $('#day6').hide();
            $('#day7').hide();   
     }        
            else if(value === '1'){
                    $('#day1').show();
                    $('#day2').hide();
                    $('#day3').hide();
                    $('#day4').hide();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();  
                
            }else if(value === '2'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').hide();
                    $('#day4').hide();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();  
            }else if(value === '3'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').hide();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();
            }
            else if(value === '4'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();
            }
                else if(value === '5'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').show();
                    $('#day6').hide();
                    $('#day7').hide();
            }
                    else if(value === '6'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').show();
                    $('#day6').show();
                    $('#day7').hide();
            }
            else if(value === '7'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').show();
                    $('#day6').show();
                    $('#day7').show();
            }
}


   
 function volumeRipartizione(start) {
    durata = $('#duratacampagna').val();
    temp = 0;
    
    volume = $('#volume_tot').val();
    var volday = [0, 0, 0, 0, 0, 0, 0]; 
    volday[0] = $('#VolumeGiornaliero1').val();
    volday[1] = $('#VolumeGiornaliero2').val();
    volday[2] = $('#VolumeGiornaliero3').val();
    volday[3] = $('#VolumeGiornaliero4').val();
    volday[4] = $('#VolumeGiornaliero5').val();
    volday[5] = $('#VolumeGiornaliero6').val();
    volday[6] = $('#VolumeGiornaliero7').val();

    for (i = 0; i < parseInt(durata); i++) {    
        if (i < (start)) {
            temp = temp + parseInt(volday[i]);
        } else {
            //alert(Math.floor((volume - temp) / (durata - start)));
//            if (document.getElementById('volumeGiornaliero' + i).value == 0)
            //document.getElementById('volumeGiornaliero' + i).value = Math.floor((volume - temp) / (durata - start));
            volday[i] = Math.floor((volume - temp) / (durata - start));
 
        }
    }
   if (volume - temp - Math.floor((volume - temp) / (durata - start)) * (durata - start - 1) < 0){
        alert("numero sms errato.");
    }    
    //document.getElementById('volumeGiornaliero' + durata).value = volume - temp - Math.floor((volume - temp) / (durata - start)) * (durata - start - 1);


    $("#VolumeGiornaliero1").val(volday[0]);  
    $("#VolumeGiornaliero2").val(volday[1]); 
    $("#VolumeGiornaliero3").val(volday[2]);   
    $("#VolumeGiornaliero4").val(volday[3]);   
    $("#VolumeGiornaliero5").val(volday[4]);   
    $("#VolumeGiornaliero6").val(volday[5]);   
    $("#VolumeGiornaliero7").val(volday[6]);     
 

 }
    
//Controllo validazione ed output
$(function () {
  $('#form-campagna-ins').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    
    console.log('ok form  '+ JSON.stringify('.parsley-error'));
    console.log('parsley-error  '+$('.parsley-error').length);
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  
});



</script>