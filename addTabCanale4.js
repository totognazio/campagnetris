const id_tab = document.getElementById('tab_id').value;

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
        }
    );

$( '#mod_invio4').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio4').on( 'select2:select ', function () {
    const selected_modsms4= $( '#mod_invio4').val();
    
    if(selected_modsms4===  'Interattivo'){
           $("#spanLabelLinkTesto4").fadeOut();
           $("#spanLabelLinkTesto4").fadeIn();  
      $('#link4').attr('required', true);  
      $('#tipoMonitoring4').attr('required', true);  
    }
    else {
       $("#spanLabelLinkTesto4").fadeOut(); 
      $('#link4').attr('required', false);  
      $('#tipoMonitoring4').attr('required', false);  
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
        firstDay: 1        
      }
    });

    
    $( '#data_invio_spai4').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      locale: {
        format: "DD/MM/YYYY",
        daysOfWeek: [ 'Do ',  'Lu ',  'Ma ',  'Me ',  'Gi ',  'Ve ',  'Sa '],
        monthNames: [ 'Gennaio ',  'Febbraio ',  'Marzo ',  'Aprile ',  'Maggio ',  'Giugno ',  'Luglio ',  'Agosto ',  'Settembre ',  'Ottobre ',  'Novembre ',  'Dicembre '],
        firstDay: 1        
      }
    });

    $( '#channel_ins4').select2({
      placeholder: "Select" 
    });
    
    $( '#channel_ins4').on( 'select2:select ', function() {
      var selected_channel_id4= $( '#channel_ins4').val();
      //var test = $("input[name=testing]:hidden");
      
        //alert($( '#selected_channel_id4').val());
        //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);

        $(this).parsley().validate();

      if (selected_channel_id4===  '12') {
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').show();

                //sms
        $( '#senders_ins4').attr( 'required', true);
        $( '#storicizza_ins4').attr( 'required', true);
        $( '#notif_consegna4').attr( 'required', true);
        $( '#testo_sms4').attr( 'required', true);
        $( '#mod_invio4').attr( 'required', true);
        //$( '#link4').attr( 'required', true);
        //$( '#tipoMonitoring4').attr( 'required', true);
        $( '#sms_duration4').attr( 'required', true);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id1
          },
          dataType: "html",
          success: function(data) {
            console.log( ' sendersss qui ' + JSON.stringify(data));
            console.log( 'eccoli2 data ' + data);
            $("#senders_ins4").fadeOut();
            $("#senders_ins4").fadeIn();
            $("#senders_ins4").html(data);
            //$("#selected_senders") = data;

          }

        });

      }  
      else if (selected_channel_id4===  '13') {//CRM DA POS
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').show();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', true);
        $( '#day_val_pos4').attr( 'required', true);
        $( '#callguide_pos4').attr( 'required', true);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);

          
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id1
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins4").fadeOut();
            $("#cat_sott_ins4").fadeIn();
            $("#cat_sott_ins4").html(data);

          }

        });
      }
      else if (selected_channel_id4===  '14') {// 40400
            $( '#span_404004').show();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', true);
        $( '#day_val4').attr( 'required', true);
        $( '#sms_incarico4').attr( 'required', true);
        $( '#sms_target4').attr( 'required', true);
        $( '#sms_adesione4').attr( 'required', true);
        $( '#sms_nondisponibile4').attr( 'required', true);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      } 
      else if (selected_channel_id4===  '21') {//canale ICM
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').show();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();
        
                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', true);
        $( '#callguide_icm4').attr( 'required', true);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      } 
      else if (selected_channel_id4===  '15') {//canale APP INBOUND
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').show();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', true);
        $( '#prior_app_inbound4').attr( 'required', true);
        $( '#callguide_app_inbound4').attr( 'required', true);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }
      else if (selected_channel_id4===  '16') {//canale APP OUTBOUND
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').show();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', true);
        $( '#prior_app_outbound4').attr( 'required', true);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }
      else if (selected_channel_id4===  '22') {//canale IVR INBOUND
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').show();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', true);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }
      else if (selected_channel_id4===  '23') {//canale IVR OUTBOUND
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').show();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', true);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }
      else if (selected_channel_id4===  '24') {//canale Jakala
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').show();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', true);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }
      else if (selected_channel_id4===  '31') {//canale MFH
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').show();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', true);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }  
      else if (selected_channel_id4===  '33') {//canale DEALER
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').show();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', true);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }   
      else if (selected_channel_id4===  '35') {//canale SPAI
            $( '#span_404004').hide();
            $( '#span_spai4').show();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', true);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }
        
      else if (selected_channel_id4===  '29') {//canale Watson
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').show();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', true);
        $( '#contact_watson4').attr( 'required', true);
      }   
        
      else {
            $( '#span_404004').hide();
            $( '#span_spai4').hide();
            $( '#span_mfh4').hide();
            $( '#span_jakala4').hide();
            $( '#span_ivr_inbound4').hide();
            $( '#span_ivr_outbound4').hide();
            $( '#span_dealer4').hide();
            $( '#span_app_outbound4').hide();
            $( '#span_app_inbound4').hide();
            $( '#span_icm4').hide();
            $( '#span_watson4').hide();
            $( '#pos_field4').hide();
            $( '#sms_field4').hide();

                            //sms
        $( '#senders_ins4').attr( 'required', false);
        $( '#storicizza_ins4').attr( 'required', false);
        $( '#notif_consegna4').attr( 'required', false);
        $( '#testo_sms4').attr( 'required', false);
        $( '#mod_invio4').attr( 'required', false);
        $( '#link4').attr( 'required', false);
        $( '#tipoMonitoring4').attr( 'required', false);
        $( '#sms_duration4').attr( 'required', false);
        //pos
        $( '#cat_sott_ins4').attr( 'required', false);
        $( '#day_val_pos4').attr( 'required', false);
        $( '#callguide_pos4').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv4').attr( 'required', false);
        $( '#day_val4').attr( 'required', false);
        $( '#sms_incarico4').attr( 'required', false);
        $( '#sms_target4').attr( 'required', false);
        $( '#sms_adesione4').attr( 'required', false);
        $( '#sms_nondisponibile4').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound4').attr( 'required', false);
        $( '#prior_app_inbound4').attr( 'required', false);
        $( '#callguide_app_inbound4').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound4').attr( 'required', false);
        $( '#prior_app_outbound4').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa4').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm4').attr( 'required', false);
        $( '#callguide_icm4').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound4').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound4').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala4').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai4').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh4').attr( 'required', false);
        //#span_watson
        $( '#type_watson4').attr( 'required', false);
        $( '#contact_watson4').attr( 'required', false);
      }

      console.log( 'channel_id1  ' + selected_channel_id1);

    });

    
  


    
