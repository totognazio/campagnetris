
//const id_tab = document.getElementById('tab_id').value;

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
        }
    );

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
    
    $( '#channel_ins5').on( 'select2:select ', function() {
      var selected_channel_id5= $( '#channel_ins5').val();
      //var test = $("input[name=testing]:hidden");
      
        //alert($( '#selected_channel_id5').val());
        //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
      
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
      ////$('#day_val_app_inbound5').attr('required', false);
      $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
      //$('#day_val_app_outbound5').attr('required', false);
      $('#id_news_app_outbound5').attr('required', false);
      $('#prior_app_outbound5').attr('required', false);
      $('#notif_app_outbound5').attr('required', false);
      //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
      $('#type_mfh5').attr('required', false);
      $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);

        $(this).parsley().validate();

      if (selected_channel_id5===  '12') {
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').show();

                //sms
        $( '#senders_ins5').attr( 'required', true);
        $( '#storicizza_ins5').attr( 'required', true);
        $( '#notif_consegna5').attr( 'required', true);
        $( '#testo_sms5').attr( 'required', true);
        $( '#mod_invio5').attr( 'required', true);
        //$( '#link5').attr( 'required', true);
        ////$('#tipoMonitoring5').attr( 'required', true);
        //$('#sms_duration'.attr( 'required', true);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
        $.ajax({
          url: "selectSender_5.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id5
          },
          dataType: "html",
          success: function(data) {
            console.log( ' sendersss qui ' + JSON.stringify(data));
            console.log( 'eccoli2 data ' + data);
            $("#senders_ins5").fadeOut();
            $("#senders_ins5").fadeIn();
            $("#senders_ins5").html(data);
            //$("#selected_senders") = data;

          }

        });

      }  
      else if (selected_channel_id5===  '13') {//CRM DA POS
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').show();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', true);
        $('#tit_sott_pos5').attr('required', true);
        //$( '#day_val_pos5').attr( 'required', true);
      //$( '#callguide_pos5').attr( 'required', true);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);

          
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id5
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins5").fadeOut();
            $("#cat_sott_ins5").fadeIn();
            $("#cat_sott_ins5").html(data);

          }

        });
      }
      else if (selected_channel_id5===  '14') {// 40400
            $( '#span_404005').show();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', true);
        $( '#day_val5').attr( 'required', true);
        $( '#sms_incarico5').attr( 'required', true);
        $( '#sms_target5').attr( 'required', true);
        $( '#sms_adesione5').attr( 'required', true);
        $( '#sms_nondisponibile5').attr( 'required', true);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      } 
      else if (selected_channel_id5===  '21') {//canale ICM
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').show();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();
        
                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', true);
        $( '#callguide_icm5').attr( 'required', true);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      } 
      else if (selected_channel_id5===  '15') {//canale APP INBOUND
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').show();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', true);
        $('#id_news_app_inbound5').attr('required', true);  
        $( '#prior_app_inbound5').attr( 'required', true);
       //$( '#callguide_app_inbound5').attr( 'required', true);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
      else if (selected_channel_id5===  '16') {//canale APP OUTBOUND
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').show();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', true);
        $('#id_news_app_outbound5').attr('required', true);  
        $('#prior_app_outbound5').attr('required', true);
        $('#notif_app_outbound5').attr('required', true);
        //$('#callguide_app_outbound5').attr('required', true);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
      else if (selected_channel_id5===  '22') {//canale IVR INBOUND
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').show();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', true);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
      else if (selected_channel_id5===  '23') {//canale IVR OUTBOUND
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').show();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', true);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
      else if (selected_channel_id5===  '24') {//canale Jakala
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').show();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', true);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
      else if (selected_channel_id5===  '31') {//canale MFH
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').show();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', true);
        $('#note_mfh5').attr('required', true);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
      else if (selected_channel_id5===  '33') {//canale DEALER
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').show();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', true);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }   
      else if (selected_channel_id5===  '35') {//canale SPAI
            $( '#span_404005').hide();
            $( '#span_spai5').show();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', true);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }
        
      else if (selected_channel_id5===  '29') {//canale Watson
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').show();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', true);
        $( '#contact_watson5').attr( 'required', true);
      }   
        
      else {
            $( '#span_404005').hide();
            $( '#span_spai5').hide();
            $( '#span_mfh5').hide();
            $( '#span_jakala5').hide();
            $( '#span_ivr_inbound5').hide();
            $( '#span_ivr_outbound5').hide();
            $( '#span_dealer5').hide();
            $( '#span_app_outbound5').hide();
            $( '#span_app_inbound5').hide();
            $( '#span_icm5').hide();
            $( '#span_watson5').hide();
            $( '#pos_field5').hide();
            $( '#sms_field5').hide();

                            //sms
        $( '#senders_ins5').attr( 'required', false);
        $( '#storicizza_ins5').attr( 'required', false);
        $( '#notif_consegna5').attr( 'required', false);
        $( '#testo_sms5').attr( 'required', false);
        $( '#mod_invio5').attr( 'required', false);
        $( '#link5').attr( 'required', false);
        //$('#tipoMonitoring5').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins5').attr('required', false);
        $('#tit_sott_pos5').attr('required', false);
        //$( '#day_val_pos5').attr( 'required', false);
      //$( '#callguide_pos5').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv5').attr( 'required', false);
        $( '#day_val5').attr( 'required', false);
        $( '#sms_incarico5').attr( 'required', false);
        $( '#sms_target5').attr( 'required', false);
        $( '#sms_adesione5').attr( 'required', false);
        $( '#sms_nondisponibile5').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound5').attr('required', false);
        $('#id_news_app_inbound5').attr('required', false);  
        $( '#prior_app_inbound5').attr( 'required', false);
       //$( '#callguide_app_inbound5').attr( 'required', false);
        
        //#span_app_outbound
        //$('#day_val_app_outbound5').attr('required', false);
        $('#id_news_app_outbound5').attr('required', false);
        $('#prior_app_outbound5').attr('required', false);
        $('#notif_app_outbound5').attr('required', false);
        //$('#callguide_app_outbound5').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa5').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm5').attr( 'required', false);
        $( '#callguide_icm5').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound5').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound5').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala5').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai5').attr( 'required', false);
        //#span_mfh
        $('#type_mfh5').attr('required', false);
        $('#note_mfh5').attr('required', false);
        //#span_watson
        $( '#type_watson5').attr( 'required', false);
        $( '#contact_watson5').attr( 'required', false);
      }

      console.log( 'channel_id5  ' + selected_channel_id5);

    });

    
  


    
