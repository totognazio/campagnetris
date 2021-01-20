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
include_once("./classes/access_user/access_user_class.php");
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
    $nome_campagna = $campaign->name_camp($id_campaign);
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
} elseif ( isset($azione) && $azione=='open') {
    $visualizza_campagna = 1;
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . $id)->fetch_array();
    $modifica = true;
    $readonly = true;
    $readonly_value = " readonly=\"readonly\" ";
    $disabled_value = " disabled=\"disabled\"  ";
    $display_none = " display:none; ";
    $title = "Visualizzazione Campagna ";
    $nome_campagna = $campaign->name_camp($id_campaign);

} elseif ( isset($azione) && $azione=='duplica') {    
    $title = "Duplicazione Campagna ";
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($id))->fetch_array();
    $nome_campagna = $campaign->name_camp($id_campaign);
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
$tit_sott = $funzione->get_allTable('campaign_titolo_sottotitolo');
//print_r($tit_sott);
$cat_sott = $funzione->get_allTable('campaign_cat_sott');

?>
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3><?php echo $title; ?><small><?php echo $nome_campagna; ?></small></h3>
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
                      <h2>Compilazione<small></small></h2>

                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                   </div>  
              <!--
                    <div class="col text-center">
                          <a  href="index.php?page=inserisciCampagna2" class="btn btn btn-xs btn-success"><i class="fa fa-plus-square"></i> Add Canale</a>
                          
                      </div>-->
        
                   
                  <div class="x_content">                     
<?php print_r($_POST); 
print_r($id_campaign['addcanale']);?>
<!--inizio mega Form inserimento-->   
<div class="bs-callout bs-callout-warning hidden">
  <h3><strong>Errore di validazione !!!   :(</strong></h3>
  <p><strong> Verifica il corretto inserimento dei campi evidenziati in rosso in tutte le schede</strong></p>
</div>

<div class="bs-callout bs-callout-info hidden">
  <h4>Yay!</h4>
  <p>Everything seems to be ok :)</p>
</div>            
<form id="form-campagna-ins"  data-parsley-validate="" class="form-horizontal form-label-left" enctype="multipart/form-data" action="<?php echo $back_url; ?>" method="post">  
                <input type="hidden" name="azione" value="<?php echo $_POST['azione']; ?>">
                <input type="hidden" name="user_id" id="user_id" value="<?php echo $page_protect->id; ?>"> 
                <input type="hidden" name="id_upload" id="fileid" value="<?php echo $id_upload; ?>">  
                <div class="" role="tabpanel" data-example-id="togglable-tabs">
                       
                      <ul id="myTab" class="nav nav-tabs bar_tabs" role="tablist">
                        <li role="presentation" class="active"><a href="#tab_content1" id="home-tab" role="tab" data-toggle="tab" aria-expanded="true">Campagna</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content2" role="tab" id="profile-tab" data-toggle="tab" aria-expanded="false">Criteri</a>
                        </li>
                        <li role="presentation" class=""><a href="#tab_content4" role="tab" id="profile-tab3" data-toggle="tab" aria-expanded="false">Comunicazione</a>
                        </li>
                       <li role="presentation" class=""><a href="#tab_content3" role="tab" id="profile-tab2" data-toggle="tab" aria-expanded="false">Canale</a>
                        </li>
                        <li role="presentation" class=""><a href="#" class="add-contact">+ Add Canale</a>
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



$('.add-contact').click(function (e) {
    e.preventDefault();
    var id = $(".nav-tabs").children().length; //think about it ;)
    var tab_name = 'Canale ' + (id-3);
    //var tab_content = 'contact_' + id;
    
    $(this).closest('li').before('<li><a href="#contact_' + id + '">' + tab_name + ' </a><span style="cursor:pointer;position:absolute;right: 6px;top: 8px;color: red;">x</span></li>'); 

    $.ajax({
        url: "addTabCanale.php",
                method: "POST",
                data: {readonly: <?php if($readonly){echo 1;} else{echo 0;}?>, tab_id: id, campaign_id: <?php if(isset($azione)) echo $id; else {echo 0;}?>, disabled_value: <?php if(!empty($disabled_value)) echo $disabled_value; else {echo 0;}?> , modifica: <?php echo $modifica; ?>},
                dataType:"html",    
                success: function (data)
                {
                    //console.log('eccoli data' + JSON.stringify(data));
                    $('.tab-content').append(data);   
                    $('.nav-tabs li:nth-child(' + id + ') a').click();
                }
    });  
    
});

$(document).ready(function() {  

    $('#mod_invio').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$('#mod_invio').on('select2:select', function () {
    var selected_modsms = $('#mod_invio').val();
    
    if(selected_modsms === 'Interattivo'){
           $("#spanLabelLinkTesto").fadeOut();
           $("#spanLabelLinkTesto").fadeIn();  
           $('#link').attr('required', true);  
    }
    else if (selected_modsms === 'Standard') {
       $("#spanLabelLinkTesto").fadeOut(); 
       $('#link').attr('required', false);  
    }
    console.log('selected_modsms  '+ selected_modsms);   
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
    
</script>

<script>
 $(document).ready(function() { 
    // bootstrap-daterangepicker     
    moment.locale('it');
    moment().format('LL');
    var select_startDate = moment().subtract(2, 'week').format('YYYY-MM-DD');
    var select_endDate = moment().add(2, 'week').format('YYYY-MM-DD');
        
    var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#range_offerta span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    };
    var cb2 = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#range_offerta span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    };
    var optionSet2 = {
            startDate: moment().format('DD/MM/YYYY'),
            endDate: moment().add(1, 'week').format('DD/MM/YYYY'),
            
            <?php 
            if(isset($id_campaign['data_inizio'])){
                echo 'startDate: \''.date('d/m/Y',strtotime($id_campaign['data_inizio_validita_offerta'])).'\',';
            }
            if(isset($id_campaign['data_fine'])){
                echo 'endDate: \'' .date('d/m/Y',strtotime($id_campaign['data_fine_validita_offerta'])).'\',';
            }
            ?>

            minDate: '01/01/2014',
            //maxDate: '12/31/2021',
            //dateLimit: {
            //days: 60
            //},
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            
            opens: 'right',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'DD/MM/YYYY',
            separator: ' to ',
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
            }};
        
      
        
    $('#range_offerta span').html(moment().format('DD/MM/YYYY') + ' - ' + moment().add(1, 'week').format('DD/MM/YYYY'));
    
    <?php 
            if(isset($id_campaign['leva']) and $id_campaign['leva']==1){
                
                $start = date('d/m/Y',strtotime($id_campaign['data_inizio_validita_offerta']));
                $end = date('d/m/Y',strtotime($id_campaign['data_fine_validita_offerta']));
                echo '$(\'#range_offerta span\').html(\''.$start.' - '.$end.'\');';
                echo '$(\'#data_inizio_validita_offerta\').attr(\'value\',date(\'YYYY-MM-DD\',\''.strtotime($id_campaign['data_inizio_validita_offerta']).'\'));';
                echo '$(\'#data_inizio_validita_offerta\').attr(\'value\',date(\'YYYY-MM-DD\',\''.strtotime($id_campaign['data_fine_validita_offerta']).'\'));';
                //echo '$(\'#data_fine_validita_offerta\').attr(\'value\',date(\'YYYY-MM-DD\',strtotime($id_campaign[\'data_fine_validita_offerta\']));';

            }
            
            
    ?>

    $('#data_inizio_validita_offerta').attr('value',moment().format('YYYY-MM-DD'));
    $('#data_fine_validita_offerta').attr('value',moment().add(1, 'week').format('YYYY-MM-DD'));
    $('#range_offerta').daterangepicker(optionSet2, cb2);  
    $('#range_offerta').on('show.daterangepicker', function() {
        console.log("show event fired");
    });
    $('#range_offerta').on('hide.daterangepicker', function() {
        console.log("hide event fired");
    });
    $('#range_offerta').on('apply.daterangepicker', function(ev, picker) {

        console.log("apply event fired, start/end dates are " + picker.startDate.format('DD/MM/YYYY') + " to " + picker.endDate.format('DD/MM/YYYY'));
        select_startDate = picker.startDate.format('YYYY-MM-DD');        
        select_endDate = picker.endDate.format('YYYY-MM-DD');
        $('#data_inizio_validita_offerta').attr('value',picker.startDate.format('YYYY-MM-DD'));
        $('#data_fine_validita_offerta').attr('value',picker.endDate.format('YYYY-MM-DD'));
 
        console.log('select_startDate inn' + select_startDate);
 
    });
    $('#range_offerta').on('cancel.daterangepicker', function(ev, picker) {
            console.log("cancel event fired");
    });
    $('#options2').click(function() {
        $('#range_offerta').data('daterangepicker').setOptions(optionSet2, cb);
        $('#data_inizio_validita_offerta').attr('value',start.format('YYYY-MM-DD'));
        $('#data_fine_validita_offerta').attr('value',end.format('YYYY-MM-DD'));
         console.log('option2 setting');
    });
    $('#destroy').click(function() {
        $('#range_offerta').data('daterangepicker').remove();
    });


        
    

        $('#data_inizio_campagna').daterangepicker({
          locale: {
            format: 'DD/MM/YYYY'
            },  
          singleDatePicker: true,
          calender_style: "picker_4",
          }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });


});
     
     
    </script>

<script type="text/javascript">
function controllaform() {
        var Errore = 'Attenzione non hai compilato tutti i campi obbligatori:\n\n';
        durata = document.getElementById('duratacampagna').value;
        volumeTotale = document.getElementById('volume_tot').value;        
        somma = 0;
        for (i = 1; i <= durata; i++) {
            somma = parseInt(somma) + parseInt(document.getElementById('VolumeGiornaliero' + i).value);
        }
        //somma = somma + parseInt(volumeTrial);
//Se check trial e campo trial valorizzato controllo se è selezionato sabato o domenica
/*
        if ((document.getElementById('trial_campagna').checked) && (document.getElementById('data_trial').value != "")) {
            s = document.getElementById('data_trial').value;
            c = s.split("/");
            data = new Date(c[2], c[1] - 1, c[0]);
            giorno = data.getDay();
            if (giorno == 6) {
                alert('Attenzione: hai pianificato il trial di sabato');
                return false;
            }
            if (giorno == 0) {
                alert('Attenzione: hai pianificato il trial di domenica');
                return false;
            }
        }
*/
//Se data inizio è valorizzato controllo se è selezionato domenica
/* 
        if (document.getElementById('data_inizio').value != "")
        {

            s = document.getElementById('data_inizio').value;
            c = s.split("/");
            data = new Date(c[2], c[1] - 1, c[0]);
            giorno = data.getDay();
            if (giorno == 0) {
                alert('Attenzione: hai pianificato la campagna di domenica');
                return false;
            }
        }
*/

//Se check escludi sabato e campo data inizio valorizzato controllo se è selezionato sabato
/*
        if ((document.getElementById('escludi_sabato').checked) && (document.getElementById('data_inizio').value != "")) {
            s = document.getElementById('data_inizio').value;
            c = s.split("/");
            data = new Date(c[2], c[1] - 1, c[0]);
            giorno = data.getDay();
            if (giorno == 6) {
                alert('Attenzione: hai pianificato la campagna di sabato');
                return false;
            }
        }
*/
/*
        if ((document.getElementById('trial_campagna').checked) && (document.getElementById('data_trial').value != "") && (document.getElementById('data_inizio').value != "")) {
            ctlDate = ctrlDate(document.getElementById('data_trial').value, document.getElementById('data_inizio').value);
            if (ctlDate)
            {
                alert('Attenzione: Data inizio campagna antecedente quella del trial');
                return false;
            }
            else
            {
                data1 = document.getElementById('data_trial').value;
                data2 = document.getElementById('data_inizio').value;
                anno1 = parseInt(data1.substr(6), 10);
                mese1 = parseInt(data1.substr(3, 2), 10);
                giorno1 = parseInt(data1.substr(0, 2), 10);
                anno2 = parseInt(data2.substr(6), 10);
                mese2 = parseInt(data2.substr(3, 2), 10);
                giorno2 = parseInt(data2.substr(0, 2), 10);
                var dataok1 = new Date(anno1, mese1 - 1, giorno1);
                var dataok2 = new Date(anno2, mese2 - 1, giorno2);
                differenza = dataok2 - dataok1;
                giorni_differenza = new String(Math.floor(differenza / 86400000));
                s = document.getElementById('data_trial').value;
                c = s.split("/");
                data = new Date(c[2], c[1] - 1, c[0]);
                giorno = data.getDay();
                if ((giorno == 5) && (giorni_differenza == 4))
                {
                    alert('Attenzione: La data di inizio della campagna deve essere dopo almeno 2 giorni lavorativi la data di trial');
                    return false;
                }

                if (giorni_differenza < 2)
                {
                    alert('Attenzione: La data di inizio della campagna deve essere dopo almeno 2 giorni lavorativi la data di trial');
                    return false;
                }
            }

        }
*/
        if (somma != volumeTotale) {
            alert('Attenzione il volume totale non coincide con la somma dei volumi giornalieri.');
            return false;
        } else {
            /* if (document.getElementById('nome_campagna').value == "") {
             Errore = Errore + "- Nome campagna\n";
             }
             if (document.getElementById('nome_campagna').value.length > 60) {
             Errore = Errore + "- Nome campagna troppo lungo" + document.getElementById('nome_campagna').value.length + " caratteri. Utilizzare massimo 60 caratteri\n";
             }*/
            if ((document.getElementById('squad_ins').value.length + document.getElementById('nomecampagna').value.length) > 40) {
                Errore = Errore + "- Nome campagna troppo lungo" + document.getElementById('nomecampagna').value.length + " caratteri. Utilizzare massimo 20 digit per le note\n";
            }
            if (document.getElementById('stack_ins').value == "0") {
                Errore = Errore + "- Stack campagna\n";
            }
            if (document.getElementById('type_ins').value == "") {
                Errore = Errore + "- Tipo campagna\n";
            }
            if (document.getElementById('priority').value == "0") {
                Errore = Errore + "- Priorit&agrave; PM\n";
            }
            if (document.getElementById('squad_ins').value == "") {
                Errore = Errore + "- Squad\n";
            }
            /*
            if (document.getElementById('validitalevaofferta').value == "") {
                Errore = Errore + "- Leva/offerta\n";
            }
            */
            if (document.getElementById('validitalevaofferta').value == "1") {
                /*
                if (document.getElementById('data_inizio_validita_offerta').value == "") {
                    Errore = Errore + "- Data inizio offerta\n";
                }
                if (document.getElementById('data_fine_validita_offerta').value == "") {
                    Errore = Errore + "- Data fine offerta\n";
                }

                if ((document.getElementById('data_inizio_validita_offerta').value != "") && (document.getElementById('data_fine_validita_offerta').value != "")) {
                    ctlDate = ctrlDate(document.getElementById('data_inizio_validita_offerta').value, document.getElementById('data_fine_validita_offerta').value);
                    if (ctlDate) {
                        Errore = Errore + "- Data fine offerta antecedente la data di inizio offerta\n";
                    }
                    ctlDate = ctrlDate(document.getElementById('data_inizio_validita_offerta').value, document.getElementById('data_inizio').value);
                    if (ctlDate) {
                        Errore = Errore + "- Data di inizio offerta successiva a data inizio comunicazione \n";
                    }
                }
                */
                if (document.getElementById('descrizione_offerta').value == "") {
                    Errore = Errore + "- Descrizione leva/offerta\n";
                }
            }
/*
            if ((!(document.getElementById('attivi').checked)) && (!(document.getElementById('sospesi').checked))) {
                Errore = Errore + "- Seleziona almeno uno stato\n";
            }
            if ((!(document.getElementById('consumer').checked)) && (!(document.getElementById('business').checked))) {
                Errore = Errore + "- Seleziona almeno un tipo di offerta\n";
            }
            if ((!(document.getElementById('prepagato').checked)) && (!(document.getElementById('postpagato').checked))) {
                Errore = Errore + "- Seleziona almeno un tipo di contratto\n";
            }
            if ((!(document.getElementById('voce').checked)) && (!(document.getElementById('dati').checked))) {
                Errore = Errore + "- Seleziona almeno un tipo di piano\n";
            }
            if ((!(document.getElementById('etf').checked)) && (!(document.getElementById('vip').checked)) && (!(document.getElementById('dipendenti').checked)) && (!(document.getElementById('trial').checked))) {
                Errore = Errore + "- Seleziona almeno un ruolo\n";
            }
            if (document.getElementById('altri_criteri').value == "") {
                Errore = Errore + "- Altri criteri\n";
            }
            


            if (document.getElementById('control_stack').value == "") {
                Errore = Errore + "- Control stack\n";
            }
            if (document.getElementById('control_stack').value == "1") {
                if ((document.getElementById('perc_control_group').value == "") || (document.getElementById('perc_control_group').value == "0")) {
                    Errore = Errore + "- Percentuale control group";
                }
            }


            if ((document.getElementById('trial_campagna').checked)) {
                if (document.getElementById('data_trial').value == "") {
                    Errore = Errore + "- Data trial\n";
                }
                if (document.getElementById('volume_trial').value == "0") {
                    Errore = Errore + "- Volume trial\n";
                }
            }
            if (document.getElementById('data_inizio').value == "") {
                Errore = Errore + "- Data inizio comunicazione\n";
            }
            if (document.getElementById('durata_campagna').value == "") {
                Errore = Errore + "- Durata\n";
            }
            if (document.getElementById('perc_scostamento').value == "") {
                Errore = Errore + "- Percentuale scostamento atteso\n";
            }
            if ((document.getElementById('volume').value == "") || (document.getElementById('volume').value == "0")) {
                Errore = Errore + "- Volume totale stimato\n";
            }

            for (i = 1; i <= durata; i++) {
                if (document.getElementById('volumeGiornaliero' + i).value == "") {
                    Errore = Errore + "- Volume giornaliero " + i + "\n";
                }
            }

            if (document.getElementById('caricamento_massivo').value == "") {
                Errore = Errore + "- Caricamento massivo\n";
            }
            */

            if (document.getElementById('channel_ins').value == "") {
                Errore = Errore + "- Canale\n";
            }
<?php
$lista_ext1 = $campaign->get_channel_ext1();
if ($lista_ext1) {
    foreach ($lista_ext1 as $key => $value) {
        ?>
                    if (document.getElementById('channel_ins').value == "<?php echo $value; ?>") {
                        if (document.getElementById('sender_ins').value == "") {
                            Errore = Errore + "- Sender\n";
                        }
                        if (document.getElementById('storicizza').value == "") {
                            Errore = Errore + "- storicizza\n";
                        }
                        if (document.getElementById('testo_sms').value == "") {
                            Errore = Errore + "- testo sms\n";
                        }
                        if (document.getElementById('mod_invio').value == "") {
                            Errore = Errore + "- Mod invio\n";
                        }                         
                        if ((document.getElementById('testo_sms').value != "") && (!validaTesto())) {
                            Errore = Errore + "- Il campo testo sms contiene caratteri non consentiti\n";
                        }
                        if (document.getElementById('sms_duration').value == "") {
                            Errore = Errore + "- Durata SMS\n";
                        }

                        if (document.getElementById('mod_invio').value == "Interattivo") {
                            if (document.getElementById('link').value == "") {
                                Errore = Errore + "- Link\n";
                            }
                        }
                        if (document.getElementById('tipoMonitoring').value == "") {
                                Errore = Errore + "- Tipo Monitoring\n";
                        }

                    }
        <?php
    }
}
$lista_ext2 = $campaign->get_channel_ext2();
if ($lista_ext2) {
    foreach ($lista_ext2 as $key => $value) {
        ?>
                    if (document.getElementById('channel_ins').value == "<?php echo $value; ?>") {
                        if (document.getElementById('category_id').value == "") {
                            Errore = Errore + "- Categoria & Sottocategoria\n";
                        }
                    }
        <?php
    }
}
?>
/*
            if ((document.getElementById('trial_campagna').checked)) {
                if (document.getElementById('data_trial').value == "") {
                    Errore = Errore + "- Data trial\n";
                }
                if (document.getElementById('volume_trial').value == "0") {
                    Errore = Errore + "- Volume trial\n";
                }
            }
 */           
            if (document.getElementById('data_inizio_campagna').value == "") {
                Errore = Errore + "- Data inizio campagna\n";
            }
            if (document.getElementById('duratacampagna').value == "") {
                Errore = Errore + "- Durata\n";
            }
            /*
            if (document.getElementById('perc_scostamento').value == "") {
                Errore = Errore + "- Percentuale scostamento atteso\n";
            }
            */
            if ((document.getElementById('volume_tot').value == "") || (document.getElementById('volume_tot').value == "0")) {
                Errore = Errore + "- Volume totale stimato\n";
            }

            for (i = 1; i <= durata; i++) {

                if (document.getElementById('VolumeGiornaliero' + i).value == "") {
                    Errore = Errore + "- Volume giornaliero " + i + "\n";
                }

            }
            if (Errore == "Attenzione non hai compilato tutti i campi obbligatori:\n\n") {
                if (!(confirm('Confermi?'))) {
                    return false;
                } else {
                    return true;
                }
            }
            else {
                alert(Errore);
                return false;
            }
        }

    }


//Controllo validazione ed output
$(function () {
  $('#form-campagna-ins').parsley().on('field:validated', function() {
    var ok = $('.parsley-error').length === 0;
    
    console.log('ok form  '+ok);
    console.log('parsley-error  '+$('.parsley-error').length);
    $('.bs-callout-info').toggleClass('hidden', !ok);
    $('.bs-callout-warning').toggleClass('hidden', ok);
  })
  
});



</script>