
//const id_tab = document.getElementById('tab_id').value;

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
    
    $( '#channel_ins1').on( 'select2:select ', function() {
      var selected_channel_id1= $( '#channel_ins1').val();
      //var test = $("input[name=testing]:hidden");
      
        //alert($( '#selected_channel_id1').val());
        //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
      
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
      ////$('#day_val_app_inbound1').attr('required', false);
      $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
      ////$('#day_val_app_outbound1').attr('required', false);
      $('#id_news_app_outbound1').attr('required', false);
      $('#prior_app_outbound1').attr('required', false);
      $('#notif_app_outbound1').attr('required', false);
      //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
      $('#type_mfh1').attr('required', false);
      $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);

        $(this).parsley().validate();

      if (selected_channel_id1===  '12') {
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').show();

                //sms
        $( '#senders_ins1').attr( 'required', true);
        $( '#storicizza_ins1').attr( 'required', true);
        $( '#notif_consegna1').attr( 'required', true);
        $( '#testo_sms1').attr( 'required', true);
        $( '#mod_invio1').attr( 'required', true);
        //$( '#link1').attr( 'required', true);
        ////$('#tipoMonitoring1').attr( 'required', true);
        //$('#sms_duration'.attr( 'required', true);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
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
            $("#senders_ins1").fadeOut();
            $("#senders_ins1").fadeIn();
            $("#senders_ins1").html(data);
            //$("#selected_senders") = data;

          }

        });

      }  
      else if (selected_channel_id1===  '13') {//CRM DA POS
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').show();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', true);
        $('#tit_sott_pos1').attr('required', true);
        //$( '#day_val_pos1').attr( 'required', true);
      //$( '#callguide_pos1').attr( 'required', true);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);

          
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id1
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins1").fadeOut();
            $("#cat_sott_ins1").fadeIn();
            $("#cat_sott_ins1").html(data);

          }

        });
      }
      else if (selected_channel_id1===  '14') {// 40400
            $( '#span_404001').show();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', true);
        $( '#day_val1').attr( 'required', true);
        $( '#sms_incarico1').attr( 'required', true);
        $( '#sms_target1').attr( 'required', true);
        $( '#sms_adesione1').attr( 'required', true);
        $( '#sms_nondisponibile1').attr( 'required', true);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      } 
      else if (selected_channel_id1===  '21') {//canale ICM
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').show();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();
        
                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', true);
        $( '#callguide_icm1').attr( 'required', true);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      } 
      else if (selected_channel_id1===  '15') {//canale APP INBOUND
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').show();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', true);
        $('#id_news_app_inbound1').attr('required', true);  
        $( '#prior_app_inbound1').attr( 'required', true);
       //$( '#callguide_app_inbound1').attr( 'required', true);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        ////$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
      else if (selected_channel_id1===  '16') {//canale APP OUTBOUND
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').show();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', true);
        $('#id_news_app_outbound1').attr('required', true);  
        $('#prior_app_outbound1').attr('required', true);
        $('#notif_app_outbound1').attr('required', true);
        //$('#callguide_app_outbound1').attr('required', true);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
      else if (selected_channel_id1===  '22') {//canale IVR INBOUND
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').show();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', true);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
      else if (selected_channel_id1===  '23') {//canale IVR OUTBOUND
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').show();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', true);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
      else if (selected_channel_id1===  '24') {//canale Jakala
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').show();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', true);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
      else if (selected_channel_id1===  '31') {//canale MFH
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').show();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', true);
        $('#note_mfh1').attr('required', true);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
      else if (selected_channel_id1===  '33') {//canale DEALER
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').show();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', true);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }   
      else if (selected_channel_id1===  '35') {//canale SPAI
            $( '#span_404001').hide();
            $( '#span_spai1').show();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false); 
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', true);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }
        
      else if (selected_channel_id1===  '29') {//canale Watson
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').show();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', true);
        $( '#contact_watson1').attr( 'required', true);
      }   
        
      else {
            $( '#span_404001').hide();
            $( '#span_spai1').hide();
            $( '#span_mfh1').hide();
            $( '#span_jakala1').hide();
            $( '#span_ivr_inbound1').hide();
            $( '#span_ivr_outbound1').hide();
            $( '#span_dealer1').hide();
            $( '#span_app_outbound1').hide();
            $( '#span_app_inbound1').hide();
            $( '#span_icm1').hide();
            $( '#span_watson1').hide();
            $( '#pos_field1').hide();
            $( '#sms_field1').hide();

                            //sms
        $( '#senders_ins1').attr( 'required', false);
        $( '#storicizza_ins1').attr( 'required', false);
        $( '#notif_consegna1').attr( 'required', false);
        $( '#testo_sms1').attr( 'required', false);
        $( '#mod_invio1').attr( 'required', false);
        $( '#link1').attr( 'required', false);
        //$('#tipoMonitoring1').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins1').attr('required', false);
        $('#tit_sott_pos1').attr('required', false);
        //$( '#day_val_pos1').attr( 'required', false);
      //$( '#callguide_pos1').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv1').attr( 'required', false);
        $( '#day_val1').attr( 'required', false);
        $( '#sms_incarico1').attr( 'required', false);
        $( '#sms_target1').attr( 'required', false);
        $( '#sms_adesione1').attr( 'required', false);
        $( '#sms_nondisponibile1').attr( 'required', false);
        //#span_app_inbound
        ////$('#day_val_app_inbound1').attr('required', false);
        $('#id_news_app_inbound1').attr('required', false);  
        $( '#prior_app_inbound1').attr( 'required', false);
       //$( '#callguide_app_inbound1').attr( 'required', false);
        //#span_app_outbound
        ////$('#day_val_app_outbound1').attr('required', false);
        $('#id_news_app_outbound1').attr('required', false);
        $('#prior_app_outbound1').attr('required', false);
        $('#notif_app_outbound1').attr('required', false);
        //$('#callguide_app_outbound1').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa1').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm1').attr( 'required', false);
        $( '#callguide_icm1').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound1').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound1').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala1').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai1').attr( 'required', false);
        //#span_mfh
        $('#type_mfh1').attr('required', false);
        $('#note_mfh1').attr('required', false);
        //#span_watson
        $( '#type_watson1').attr( 'required', false);
        $( '#contact_watson1').attr( 'required', false);
      }

      console.log( 'channel_id1  ' + selected_channel_id1);

    });

    
  


    
