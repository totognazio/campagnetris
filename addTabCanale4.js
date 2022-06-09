
//const id_tab = document.getElementById('tab_id').value;
stato = $('#campaign_state_id').val();

var selected_channel_id4 = $('#channel_ins4').val();
add_canale_validazione(selected_channel_id4, stato, 4);
  
count4 =  $('#iniziative_dealer4').val();
validazione_add_canaleDealer(count4, stato, 4);


var testo_sms4 = document.getElementById("testo_sms4");
    testo_sms4.addEventListener(
             'keypress',
             function (e) {
            // Test for the key codes you want to filter out.
            if (e.which == 8364) {
                alert('  Attenzione il carattere \'€\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
               /*
            else if (e.which == 86) {
                alert('  Attenzione il carattere \'’\' non è consentito!!');
                // Prevent the default event action (adding the
                // character to the textarea).
                e.preventDefault();
            }
            */
            else if (!validaTesto()) {
                 alert('Testo non valido!!! Introdotto carattere non consentito !!!');
            }


        }
);
testo_sms4.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});

var testo_sms_pos4 = document.getElementById("testo_sms_pos4");
    testo_sms_pos4.addEventListener(
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
testo_sms_pos4.addEventListener('paste', (event) => {
    let paste = (event.clipboardData || window.clipboardData).getData('text');
    
    const re = /^[¡§¿ÄÖÑÜäöñüà@£$¥èéùìòÇØøÅå_\[\]ΘΞ^{}~|¤ÆæßÉ'<=>?,!"#%+&()*=:;/@\.a-zA-Z0-9_-\w\s]{1,640}$/;
        //testo_sms = document.getElementById('testo_sms').value;
        if (!(re.test(paste))) {
            alert('Test validaione SMS fallito !!!');
            event.preventDefault();
            //return false;
        }
    
});

$( '#mod_invio4').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio4').on( 'select2:select ', function () {
    const selected_modsms4= $( '#mod_invio4').val();
    
    if(selected_modsms4===  'Interattivo'){
      $("#spanLabelLinkTesto4").show();
      $('#link4').attr('required', true);
      //$('#tipoMonitoring4').attr('required', true);   
    }
    else {
       $("#spanLabelLinkTesto4").hide(); 
      $('#link4').attr('required', false);
      //$('#tipoMonitoring4').attr('required', false);   
    }
    console.log( 'selected_modsms4  '+ selected_modsms4);   
    });

    $( '#data_invio_jakala4').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 4        
      }
    });

    
    $( '#data_invio_spai4').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 4        
      }
    });

    $( '#channel_ins4').select2({
      placeholder: "Select" 
    });
    
//const id_tab = document.getElementById('tab_id').value;


$('#channel_ins4').on('select2:select ', function () {
  selected_channel_id4 = $('#channel_ins4').val();
  stato = $('#campaign_state_id').val();
      add_canale_view(selected_channel_id4, 4);
      add_canale_validazione(selected_channel_id4, stato, 4);    

});


     $('#iniziative_dealer4').change(function() {
            //alert('canale 1 '+$(this).val());
            count = $(this).val();
            for(i=1; i<10; i++){
                if(i<=count){
                  $('#4adddealer_' + i).show();
                  if (get_required(stato)) {                   
                    $('#4addCod_iniziativa'+i).attr('required', true);
                  }
                  else{
                       $('#4addCod_iniziativa'+i).attr('required', false);
                  }                                          
                }                
                else{
                    $('#4adddealer_'+i).hide();
                    $('#4addCod_iniziativa'+i).attr('required', false);
                }
            }


     });   
        
     
    $('#campaign_state_id').on('select2:select', function() {
      //alert(' stato campagna dentro addCanale 4 ' + $('#campaign_state_id').val());
      //alert(' dentro addCanale selected_channel_id1  ' + $('#channel_ins1').val());
      selected_channel_id4 = $('#channel_ins4').val();
      
      
            stato = $('#campaign_state_id').val();
            count4 = $('#iniziative_dealer4').val();      
           // add_canale_view(selected_channel_id4, 4);
            validazione_add_canaleDealer(count4,stato,4);
            
            add_canale_validazione(selected_channel_id4, stato, 4);
  
          

    });

    
  


    
