
//const id_tab = document.getElementById('tab_id').value;

stato = $('#campaign_state_id').val();
var selected_channel_id1; 

var testo_sms1 = document.getElementById("testo_sms1");
    testo_sms1.addEventListener(
        'keypress',
        function (e) {
            // Test for the key codes you want to filter out.
            if (e.which == 8364) {
                alert('  Attenzione il carattere \'€\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
        }
);
    

$( '#mod_invio1').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio1').on( 'select2:select ', function () {
    const selected_modsms1= $( '#mod_invio1').val();
    
    if(selected_modsms1===  'Interattivo'){
      $("#spanLabelLinkTesto1").show();
      $('#link1').attr('required', true);
      //$('#tipoMonitoring1').attr('required', true);   
    }
    else {
       $("#spanLabelLinkTesto1").hide(); 
       $('#link1').attr('required', false);
      //$('#tipoMonitoring1').attr('required', false);   
    }
    console.log( 'selected_modsms1  '+ selected_modsms1);   
    });

    $( '#data_invio_jakala1').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    
    $( '#data_invio_spai1').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    $( '#channel_ins1').select2({
      placeholder: "Select" 
    });

// Trigger Cambio di Chanale 1  
$('#channel_ins1').on('select2:select ', function () {
  selected_channel_id1 = $('#channel_ins1').val();
  stato = $('#campaign_state_id').val();
      add_canale_view(selected_channel_id1, 1);
      add_canale_validazione(selected_channel_id1, stato, 1);    

});


     $('#iniziative_dealer1').change(function() {
            //alert('canale 1 '+$(this).val());
            count = $(this).val();
            for(i=2; i<10; i++){
                if(i<=count){
                  $('#1adddealer_' + i).show();
                  if (get_required(stato)) {                   
                    $('#1addCod_iniziativa'+i).attr('required', true);
                  }
                  else{
                       $('#1addCod_iniziativa'+i).attr('required', false);
                  }                                          
                }                
                else{
                    $('#1adddealer_'+i).hide();
                    $('#1addCod_iniziativa'+i).attr('required', false);
                }
            }


     });   
        
    
     // Trigger Cambio di Stato
    $('#campaign_state_id').on('select2:select', function() {
      //alert(' stato campagna dentro addCanale 1 ' + $('#campaign_state_id').val());
      //alert(' dentro addCanale selected_channel_id1  ' + $('#channel_ins1').val());
      selected_channel_id1 = $('#channel_ins1').val();
      
      
            stato = $('#campaign_state_id').val();
      //count1 = document.getElementById('iniziative_dealer1').value;
                 count1 =  $('#iniziative_dealer1').val();
      
           add_canale_view(selected_channel_id1, 1);
            validazione_add_canaleDealer(count1, stato);            
            add_canale_validazione(selected_channel_id1, stato, 1);    
          

    });

    
  


    
