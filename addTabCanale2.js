//const id_tab = document.getElementById('tab_id').value;

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
        }
    );


$( '#mod_invio2').select2({
          placeholder: "Select Modalità SMS"
        });    
    
$( '#mod_invio2').on( 'select2:select ', function () {
    const selected_modsms2= $( '#mod_invio2').val();
    
    if(selected_modsms2===  'Interattivo'){
           $("#spanLabelLinkTesto2").fadeOut();
           $("#spanLabelLinkTesto2").fadeIn();  
      $('#link2').attr('required', true);  
      ////$('#tipoMonitoring2').attr('required', true);   
    }
    else {
       $("#spanLabelLinkTesto2").fadeOut(); 
      $('#link2').attr('required', false);  
      ////$('#tipoMonitoring2').attr('required', false);  
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
    
    $( '#channel_ins2').on( 'select2:select ', function() {
      var selected_channel_id2= $( '#channel_ins2').val();
      //var test = $("input[name=testing]:hidden");
      
        //alert($( '#selected_channel_id2').val());
        //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);

        $(this).parsley().validate();

      if (selected_channel_id2===  '12') {
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').show();

                //sms
        $( '#senders_ins2').attr( 'required', true);
        $( '#storicizza_ins2').attr( 'required', true);
        $( '#notif_consegna2').attr( 'required', true);
        $( '#testo_sms2').attr( 'required', true);
        $( '#mod_invio2').attr( 'required', true);
        //$( '#link2').attr( 'required', true);
        ////$('#tipoMonitoring2').attr( 'required', true);
        $( '#sms_duration2').attr( 'required', true);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id2
          },
          dataType: "html",
          success: function(data) {
            console.log( ' sendersss qui ' + JSON.stringify(data));
            console.log( 'eccoli2 data ' + data);
            $("#senders_ins2").fadeOut();
            $("#senders_ins2").fadeIn();
            $("#senders_ins2").html(data);
            //$("#selected_senders") = data;

          }

        });

      }  
      else if (selected_channel_id2===  '13') {//CRM DA POS
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').show();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', true);
        $( '#day_val_pos2').attr( 'required', true);
        $( '#callguide_pos2').attr( 'required', true);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);

          
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id2
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins2").fadeOut();
            $("#cat_sott_ins2").fadeIn();
            $("#cat_sott_ins2").html(data);

          }

        });
      }
      else if (selected_channel_id2===  '14') {// 40400
            $( '#span_404002').show();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', true);
        $( '#day_val2').attr( 'required', true);
        $( '#sms_incarico2').attr( 'required', true);
        $( '#sms_target2').attr( 'required', true);
        $( '#sms_adesione2').attr( 'required', true);
        $( '#sms_nondisponibile2').attr( 'required', true);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      } 
      else if (selected_channel_id2===  '21') {//canale ICM
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').show();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();
        
                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', true);
        $( '#callguide_icm2').attr( 'required', true);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      } 
      else if (selected_channel_id2===  '15') {//canale APP INBOUND
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').show();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', true);
        $( '#prior_app_inbound2').attr( 'required', true);
        $( '#callguide_app_inbound2').attr( 'required', true);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }
      else if (selected_channel_id2===  '16') {//canale APP OUTBOUND
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').show();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', true);
        $( '#prior_app_outbound2').attr( 'required', true);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }
      else if (selected_channel_id2===  '22') {//canale IVR INBOUND
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').show();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', true);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }
      else if (selected_channel_id2===  '23') {//canale IVR OUTBOUND
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').show();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', true);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }
      else if (selected_channel_id2===  '24') {//canale Jakala
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').show();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', true);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }
      else if (selected_channel_id2===  '31') {//canale MFH
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').show();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', true);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }  
      else if (selected_channel_id2===  '33') {//canale DEALER
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').show();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', true);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }    
      else if (selected_channel_id2===  '35') {//canale SPAI
            $( '#span_404002').hide();
            $( '#span_spai2').show();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', true);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }
        
      else if (selected_channel_id2===  '29') {//canale Watson
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').show();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', true);
        $( '#contact_watson2').attr( 'required', true);
      }   
        
      else {
            $( '#span_404002').hide();
            $( '#span_spai2').hide();
            $( '#span_mfh2').hide();
            $( '#span_jakala2').hide();
            $( '#span_ivr_inbound2').hide();
            $( '#span_ivr_outbound2').hide();
            $( '#span_dealer2').hide();
            $( '#span_app_outbound2').hide();
            $( '#span_app_inbound2').hide();
            $( '#span_icm2').hide();
            $( '#span_watson2').hide();
            $( '#pos_field2').hide();
            $( '#sms_field2').hide();

                            //sms
        $( '#senders_ins2').attr( 'required', false);
        $( '#storicizza_ins2').attr( 'required', false);
        $( '#notif_consegna2').attr( 'required', false);
        $( '#testo_sms2').attr( 'required', false);
        $( '#mod_invio2').attr( 'required', false);
        $( '#link2').attr( 'required', false);
        //$('#tipoMonitoring2').attr( 'required', false);
        $( '#sms_duration2').attr( 'required', false);
        //pos
        $( '#cat_sott_ins2').attr( 'required', false);
        $( '#day_val_pos2').attr( 'required', false);
        $( '#callguide_pos2').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv2').attr( 'required', false);
        $( '#day_val2').attr( 'required', false);
        $( '#sms_incarico2').attr( 'required', false);
        $( '#sms_target2').attr( 'required', false);
        $( '#sms_adesione2').attr( 'required', false);
        $( '#sms_nondisponibile2').attr( 'required', false);
        //#span_app_inbound
        $( '#day_val_app_inbound2').attr( 'required', false);
        $( '#prior_app_inbound2').attr( 'required', false);
        $( '#callguide_app_inbound2').attr( 'required', false);
        //#span_app_outbound
        $( '#day_val_app_outbound2').attr( 'required', false);
        $( '#prior_app_outbound2').attr( 'required', false);
        //#span_dealer
        $( '#Cod_iniziativa2').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm2').attr( 'required', false);
        $( '#callguide_icm2').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound2').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound2').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala2').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai2').attr( 'required', false);
        //#span_mfh
        $( '#type_mfh2').attr( 'required', false);
        //#span_watson
        $( '#type_watson2').attr( 'required', false);
        $( '#contact_watson2').attr( 'required', false);
      }

      console.log( 'channel_id2  ' + selected_channel_id2);

    });

    
  


    
