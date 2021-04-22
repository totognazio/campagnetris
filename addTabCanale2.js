
//const id_tab = document.getElementById('tab_id').value;
stato = $('#campaign_state_id').val();
var selected_channel_id2; 
var testo_sms2 = document.getElementById("testo_sms2");
    testo_sms2.addEventListener(
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
testo_sms2.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});
var testo_sms_pos2 = document.getElementById("testo_sms_pos2");
    testo_sms_pos2.addEventListener(
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
testo_sms_pos2.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});
$( '#mod_invio2').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio2').on( 'select2:select ', function () {
    const selected_modsms2= $( '#mod_invio2').val();
    
    if(selected_modsms2===  'Interattivo'){
      $("#spanLabelLinkTesto2").show();
      $('#link2').attr('required', true);
      //$('#tipoMonitoring2').attr('required', true);   
    }
    else {
       $("#spanLabelLinkTesto2").hide(); 
      $('#link2').attr('required', false);
      //$('#tipoMonitoring2').attr('required', false);   
    }
    console.log( 'selected_modsms2  '+ selected_modsms2);   
    });

    $( '#data_invio_jakala2').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    
    $( '#data_invio_spai2').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    $( '#channel_ins2').select2({
      placeholder: "Select" 
    });
    
    
$('#channel_ins2').on('select2:select ', function () {
  selected_channel_id2 = $('#channel_ins2').val();
  stato = $('#campaign_state_id').val();
      add_canale_view(selected_channel_id2, 2);
      add_canale_validazione(selected_channel_id2, stato, 2);    

});


     $('#iniziative_dealer2').change(function() {
            //alert('canale 1 '+$(this).val());
            count = $(this).val();
            for(i=2; i<10; i++){
                if(i<=count){
                  $('#2adddealer_' + i).show();
                  if (get_required(stato)) {                    
                    $('#2addCod_iniziativa'+i).attr('required', true);
                  }
                  else{
                       $('#2addCod_iniziativa'+i).attr('required', false);
                  }                                          
                }                
                else{
                    $('#2adddealer_'+i).hide();
                    $('#2addCod_iniziativa'+i).attr('required', false);
                }
            }


     });   
        
     
    $('#campaign_state_id').on('select2:select', function() {
      //alert(' stato campagna dentro addCanale 2 ' + $('#campaign_state_id').val());
      //alert(' dentro addCanale selected_channel_id1  ' + $('#channel_ins1').val());
      selected_channel_id2 = $('#channel_ins2').val();
      stato = $('#campaign_state_id').val();
      count2 = $('#iniziative_dealer2').val();      
      // add_canale_view(selected_channel_id2, 2);   
      validazione_add_canaleDealer(count2, stato);
      
      add_canale_validazione(selected_channel_id2, stato, 2);
      
      
          

    });

    
  


    
