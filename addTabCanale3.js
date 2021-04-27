
//const id_tab = document.getElementById('tab_id').value;
//const id_tab = document.getElementById('tab_id').value;
stato = $('#campaign_state_id').val();

var selected_channel_id3 = $('#channel_ins3').val();
add_canale_validazione(selected_channel_id3, stato, 3); 

var testo_sms3 = document.getElementById("testo_sms3");
    testo_sms3.addEventListener(
             'keypress',
             function (e) {
            // Test for the key codes you want to filter out.
            if (e.which == 8364) {
                alert('  Attenzione il carattere \'€\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
            else if (e.which == 86) {
                alert('  Attenzione il carattere \'’\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
            else if (!validaTesto()) {
                 alert('Testo non valido!!! Introdotto carattere non consentito !!!');
            }


        }
);
testo_sms3.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});
var testo_sms_pos3 = document.getElementById("testo_sms_pos3");
    testo_sms_pos3.addEventListener(
        'keypress',
              function (e) {
            // Test for the key codes you want to filter out.
            if (e.which == 8364) {
                alert('  Attenzione il carattere \'€\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
            else if (e.which == 86) {
                alert('  Attenzione il carattere \'’\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
            else if (!validaTesto()) {
                 alert('Testo non valido!!! Introdotto carattere non consentito !!!');
            }


        }
);
testo_sms_pos3.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});

$( '#mod_invio3').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio3').on( 'select2:select ', function () {
    const selected_modsms3= $( '#mod_invio3').val();
    
    if(selected_modsms3===  'Interattivo'){
      $("#spanLabelLinkTesto3").show();
      $('#link3').attr('required', true);
      //$('#tipoMonitoring3').attr('required', true);   
    }
    else {
       $("#spanLabelLinkTesto3").hide(); 
      $('#link3').attr('required', false);
      //$('#tipoMonitoring3').attr('required', false);   
    }
    console.log( 'selected_modsms3  '+ selected_modsms3);   
    });

    $( '#data_invio_jakala3').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 3        
      }
    });

    
    $( '#data_invio_spai3').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 3        
      }
    });

    $( '#channel_ins3').select2({
      placeholder: "Select" 
    });
    
  
  

    $('#channel_ins3').on('select2:select ', function () {
      selected_channel_id3 = $('#channel_ins3').val();
      stato = $('#campaign_state_id').val();
      add_canale_view(selected_channel_id3, 3);
      add_canale_validazione(selected_channel_id3, stato, 3);    

});


     $('#iniziative_dealer3').change(function() {
            //alert('canale 1 '+$(this).val());
            count = $(this).val();
            for(i=2; i<10; i++){
                if(i<=count){
                  $('#3adddealer_' + i).show();
                  if (get_required(stato)) {                    
                    $('#3addCod_iniziativa'+i).attr('required', true);
                  }
                  else{
                       $('#3addCod_iniziativa'+i).attr('required', false);
                  }                                          
                }                
                else{
                    $('#3adddealer_'+i).hide();
                    $('#3addCod_iniziativa'+i).attr('required', false);
                }
            }


     });   
        
     
    $('#campaign_state_id').on('select2:select', function() {
      //alert(' stato campagna dentro addCanale 3 ' + $('#campaign_state_id').val());
      //alert(' dentro addCanale selected_channel_id1  ' + $('#channel_ins1').val());
      selected_channel_id3 = $('#channel_ins3').val();
      
      
            stato = $('#campaign_state_id').val();
            count3 = $('#iniziative_dealer3').val();       
           // add_canale_view(selected_channel_id3, 3);
            validazione_add_canaleDealer(count3, stato);
            
      add_canale_validazione(selected_channel_id3, stato, 3);
           

    });


    
