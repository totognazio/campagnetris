
//const id_tab = document.getElementById('tab_id').value;
stato = $('#campaign_state_id').val();

var selected_channel_id5 = $('#channel_ins5').val();
add_canale_validazione(selected_channel_id5, stato, 5);
count5 = $('#iniziative_dealer5').val();        
validazione_add_canaleDealer(count5, stato,5);


var testo_sms5 = document.getElementById("testo_sms5");
    testo_sms5.addEventListener(
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
testo_sms5.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});

var testo_sms_pos5 = document.getElementById("testo_sms_pos5");
    testo_sms_pos5.addEventListener(
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
testo_sms_pos5.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});


$( '#mod_invio5').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio5').on( 'select2:select ', function () {
    const selected_modsms5= $( '#mod_invio5').val();
    
    if(selected_modsms5===  'Interattivo'){
      $("#spanLabelLinkTesto5").show();
      $('#link5').attr('required', true);
      //$('#tipoMonitoring5').attr('required', true);   
    }
    else {
       $("#spanLabelLinkTesto5").hide(); 
      $('#link5').attr('required', false);
      //$('#tipoMonitoring5').attr('required', false);   
    }
    console.log( 'selected_modsms5  '+ selected_modsms5);   
    });

    $( '#data_invio_jakala5').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    
    $( '#data_invio_spai5').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    $( '#channel_ins5').select2({
      placeholder: "Select" 
    });
    
$('#channel_ins5').on('select2:select ', function () {
  selected_channel_id5 = $('#channel_ins5').val();
  stato = $('#campaign_state_id').val();
      add_canale_view(selected_channel_id5, 5);
      add_canale_validazione(selected_channel_id5, stato, 5);    

});


     $('#iniziative_dealer5').change(function() {
            //alert('canale 1 '+$(this).val());
            count = $(this).val();
            for(i=1; i<10; i++){
                if(i<=count){
                  $('#5adddealer_' + i).show();
                  if (get_required(stato)) {                      
                    $('#5addCod_iniziativa'+i).attr('required', true);
                  }
                  else{
                       $('#5addCod_iniziativa'+i).attr('required', false);
                  }                                          
                }                
                else{
                    $('#5adddealer_'+i).hide();
                    $('#5addCod_iniziativa'+i).attr('required', false);
                }
            }


     });   
        
     
    $('#campaign_state_id').on('select2:select', function() { 
      //alert(' stato campagna dentro addCanale 5 ' + $('#campaign_state_id').val());
      //alert(' dentro addCanale selected_channel_id1  ' + $('#channel_ins1').val());
      selected_channel_id5 = $('#channel_ins5').val();
      
      
            stato = $('#campaign_state_id').val();
            count5 = $('#iniziative_dealer5').val();        
           // add_canale_view(selected_channel_id5, 5);
            validazione_add_canaleDealer(count5, stato,5);
            
            add_canale_validazione(selected_channel_id5, stato, 5);
     
          

    });

    
  


    
