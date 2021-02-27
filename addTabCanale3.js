
//const id_tab = document.getElementById('tab_id').value;

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
        }
    );

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
    
    $( '#channel_ins3').on( 'select2:select ', function() {
      var selected_channel_id3= $( '#channel_ins3').val();
      //var test = $("input[name=testing]:hidden");
      
        //alert($( '#selected_channel_id3').val());
        //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
      
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
      //$('#day_val_app_inbound3').attr('required', false);
      $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
      //$('#day_val_app_outbound3').attr('required', false);
      $('#id_news_app_outbound3').attr('required', false);
      $('#prior_app_outbound3').attr('required', false);
      $('#notif_app_outbound3').attr('required', false);
      //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
      $('#type_mfh3').attr('required', false);
      $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);

        $(this).parsley().validate();

      if (selected_channel_id3===  '12') {
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').show();

                //sms
        $( '#senders_ins3').attr( 'required', true);
        $( '#storicizza_ins3').attr( 'required', true);
        $( '#notif_consegna3').attr( 'required', true);
        $( '#testo_sms3').attr( 'required', true);
        $( '#mod_invio3').attr( 'required', true);
        //$( '#link3').attr( 'required', true);
        ////$('#tipoMonitoring3').attr( 'required', true);
        //$('#sms_duration'.attr( 'required', true);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
        $.ajax({
          url: "selectSender_3.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id3
          },
          dataType: "html",
          success: function(data) {
            console.log( ' sendersss qui ' + JSON.stringify(data));
            console.log( 'eccoli2 data ' + data);
            $("#senders_ins3").fadeOut();
            $("#senders_ins3").fadeIn();
            $("#senders_ins3").html(data);
            //$("#selected_senders") = data;

          }

        });

      }  
      else if (selected_channel_id3===  '13') {//CRM DA POS
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').show();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', true);
        $('#tit_sott_pos3').attr('required', true);
        //$( '#day_val_pos3').attr( 'required', true);
      //$( '#callguide_pos3').attr( 'required', true);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);

          
        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id3
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins3").fadeOut();
            $("#cat_sott_ins3").fadeIn();
            $("#cat_sott_ins3").html(data);

          }

        });
      }
      else if (selected_channel_id3===  '14') {// 40400
            $( '#span_404003').show();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', true);
        $( '#day_val3').attr( 'required', true);
        $( '#sms_incarico3').attr( 'required', true);
        $( '#sms_target3').attr( 'required', true);
        $( '#sms_adesione3').attr( 'required', true);
        $( '#sms_nondisponibile3').attr( 'required', true);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      } 
      else if (selected_channel_id3===  '21') {//canale ICM
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').show();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();
        
                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', true);
        $( '#callguide_icm3').attr( 'required', true);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      } 
      else if (selected_channel_id3===  '15') {//canale APP INBOUND
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').show();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', true);
        $('#id_news_app_inbound3').attr('required', true);  
        $( '#prior_app_inbound3').attr( 'required', true);
       //$( '#callguide_app_inbound3').attr( 'required', true);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
      else if (selected_channel_id3===  '16') {//canale APP OUTBOUND
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').show();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', true);
        $('#id_news_app_outbound3').attr('required', true);  
        $('#prior_app_outbound3').attr('required', true);
        $('#notif_app_outbound3').attr('required', true);
        //$('#callguide_app_outbound3').attr('required', true);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
      else if (selected_channel_id3===  '22') {//canale IVR INBOUND
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').show();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', true);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
      else if (selected_channel_id3===  '23') {//canale IVR OUTBOUND
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').show();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', true);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
      else if (selected_channel_id3===  '24') {//canale Jakala
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').show();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', true);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
      else if (selected_channel_id3===  '31') {//canale MFH
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').show();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', true);
        $('#note_mfh3').attr('required', true);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
      else if (selected_channel_id3===  '33') {//canale DEALER
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').show();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', true);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }   
      else if (selected_channel_id3===  '35') {//canale SPAI
            $( '#span_404003').hide();
            $( '#span_spai3').show();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', true);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }
        
      else if (selected_channel_id3===  '29') {//canale Watson
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').show();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', true);
        $( '#contact_watson3').attr( 'required', true);
      }   
        
      else {
            $( '#span_404003').hide();
            $( '#span_spai3').hide();
            $( '#span_mfh3').hide();
            $( '#span_jakala3').hide();
            $( '#span_ivr_inbound3').hide();
            $( '#span_ivr_outbound3').hide();
            $( '#span_dealer3').hide();
            $( '#span_app_outbound3').hide();
            $( '#span_app_inbound3').hide();
            $( '#span_icm3').hide();
            $( '#span_watson3').hide();
            $( '#pos_field3').hide();
            $( '#sms_field3').hide();

                            //sms
        $( '#senders_ins3').attr( 'required', false);
        $( '#storicizza_ins3').attr( 'required', false);
        $( '#notif_consegna3').attr( 'required', false);
        $( '#testo_sms3').attr( 'required', false);
        $( '#mod_invio3').attr( 'required', false);
        $( '#link3').attr( 'required', false);
        //$('#tipoMonitoring3').attr( 'required', false);
        //$('#sms_duration'.attr( 'required', false);
        //pos
        $('#cat_sott_ins3').attr('required', false);
        $('#tit_sott_pos3').attr('required', false);
        //$( '#day_val_pos3').attr( 'required', false);
      //$( '#callguide_pos3').attr( 'required', false);
        //#span_40400
        $( '#alias_attiv3').attr( 'required', false);
        $( '#day_val3').attr( 'required', false);
        $( '#sms_incarico3').attr( 'required', false);
        $( '#sms_target3').attr( 'required', false);
        $( '#sms_adesione3').attr( 'required', false);
        $( '#sms_nondisponibile3').attr( 'required', false);
        //#span_app_inbound
        //$('#day_val_app_inbound3').attr('required', false);
        $('#id_news_app_inbound3').attr('required', false);  
        $( '#prior_app_inbound3').attr( 'required', false);
       //$( '#callguide_app_inbound3').attr( 'required', false);
        //#span_app_outbound
        //$('#day_val_app_outbound3').attr('required', false);
        $('#id_news_app_outbound3').attr('required', false);
        $('#prior_app_outbound3').attr('required', false);
        $('#notif_app_outbound3').attr('required', false);
        //$('#callguide_app_outbound3').attr('required', false);
        //#span_dealer
        $( '#Cod_iniziativa3').attr( 'required', false);
        //#span_icm
        $( '#day_val_icm3').attr( 'required', false);
        $( '#callguide_icm3').attr( 'required', false);
        //#span_ivr_inbound
        $( '#day_val_ivr_inbound3').attr( 'required', false);
        //#span_ivr_outbound
        $( '#day_val_ivr_outbound3').attr( 'required', false);
        //#span_jakala
        $( '#data_invio_jakala3').attr( 'required', false);
        //#span_spai
        $( '#data_invio_spai3').attr( 'required', false);
        //#span_mfh
        $('#type_mfh3').attr('required', false);
        $('#note_mfh3').attr('required', false);
        //#span_watson
        $( '#type_watson3').attr( 'required', false);
        $( '#contact_watson3').attr( 'required', false);
      }

      console.log( 'channel_id3  ' + selected_channel_id3);

    });

    
  


    
