<style>
input:focus {
  background-color: yellow;
}
</style>  
<!-- bootstrap-daterangepicker -->
    <link href="vendors/bootstrap-daterangepicker/daterangepicker.css" rel="stylesheet">
    <!-- NProgress -->
<link href="vendors/nprogress/nprogress.css" rel="stylesheet">
<!-- Dropzone.js -->
<link href="vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
<!-- Dropzone.js -->
<script src="vendors/dropzone/dist/min/dropzone.min.js"></script>
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

//print_r($_POST);
//// form tutto vuoto nel caso di add new campagna 
$messaggio = "";
$title = "Inserimento Nuova Campagna";
$disabled_value = "";
$modifica = false;
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
    $back_url = "./index.php?page=pianificazione";
} else {
    $back_url = "./index.php?page=gestioneCampagne";
}

//leffo azione dai link bottoni
if (isset($_POST['azione'])) {
    
    $azione = $_POST['azione'];
    $id = $_POST['id'];
    
}


$idCampagna = "";
if ( isset($azione) && $azione=='modifica') {
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
    $title = "Modifica della Campagna";
    $modifica = true;
    $squad_id = $id_campaign['squad_id'];
    if ($page_protect->get_job_role() > 2) {
        $modifica_codici = true;
    }
    $permission = $page_protect->check_permission($squad_id);

    if ($permission) {
        
        if (isset($_POST['modifica_confim'])) {
            $messaggio = $campaign->update($_POST, $_POST['id']);
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
    $idCampagna = intval($_POST['id']);
    $visualizza_campagna = 1;
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . $idCampagna)->fetch_array();
    $modifica = true;
    $readonly = true;
    $readonly_value = " readonly=\"readonly\" ";
    $disabled_value = " disabled=\"disabled\"  ";
    $display_none = " display:none; ";
    $title = "Visualizzazione Campagna";
} elseif ( isset($azione) && $azione=='duplica') {
    //echo'<---QUI-->';
    $title = "Duplicazione Campagna";
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
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
            $messaggio = $campaign->update($_POST, $_POST['id']);
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
                <h3><?php echo $title; ?></h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <!--<div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>-->
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

<!--inizio mega Form inserimento-->                  
<form id="demo-form2" data-parsley-validate class="form-horizontal form-label-left">  
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
                                <button type="submit" class="btn btn-primary">Cancel</button>
                                <button type="submit" class="btn btn-success">Submit</button>
                              </div>
                            </div>

                   
                    </div>

</form>  

<?php $form->close_page(); ?>

    <!-- validator -->
<script src="vendors/validator/validator.js"></script>
<script>
  
function validitaoffer(){
    if($( "#validitalevaofferta" ).val()==='1'){
        $('#validita-offerta').show();
    } else if($( "#validitalevaofferta" ).val()==='0'){
        $('#validita-offerta').hide();
    }
    else {
       $('#validita-offerta').hide(); 
    }
    
}
 
function levaselect() {
    if($( "#idlevaselect" ).val()==='mono'){
        $('#monoleva').show();
        $('#multileva').hide();
    }else if($( "#idlevaselect" ).val()==='multi'){
        $('#monoleva').hide();
        $('#multileva').show();
    }
    else if ($( "#idlevaselect" ).val()==='0'){
        $('#monoleva').hide();
        $('#multileva').hide();  
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
                data: {tab_id: id, campaign_id: id},
                //dataType:"html",    
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
           //$("#spanLabelLinkTesto").fadeOut();
           $("#spanLabelLinkTesto").fadeIn();  
    }
    else if (selected_modsms === 'standard') {
       $("#spanLabelLinkTesto").fadeOut(); 
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
                echo 'startDate: \''.date('d/m/Y',strtotime($id_campaign['data_inizio'])).'\',';
            }
            if(isset($id_campaign['data_fine'])){
                echo 'endDate: \'' .date('d/m/Y',strtotime($id_campaign['data_fine'])).'\',';
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
            if(isset($id_campaign['data_inizio'])){
                
                $start = date('d/m/Y',strtotime($id_campaign['data_inizio']));
                $end = date('d/m/Y',strtotime($id_campaign['data_fine']));
                echo '$(\'#range_offerta span\').html(\''.$start.' - '.$end.'\');';
            }
            
            
    ?>

    
    


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
        console.log('select_startDate inn' + select_startDate);
 
    });
    $('#range_offerta').on('cancel.daterangepicker', function(ev, picker) {
            console.log("cancel event fired");
    });
    $('#options2').click(function() {
        $('#range_offerta').data('daterangepicker').setOptions(optionSet2, cb);
         console.log('option2 setting');
    });
    $('#destroy').click(function() {
        $('#range_offerta').data('daterangepicker').remove();
    });

        
      });
     
     
    </script>
