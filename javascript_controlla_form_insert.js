            
function highlither_min_required(stato_id) {

  if (typeof stato_id != "undefined" && !get_required(stato_id)) {
    console.log('--->highlither_min_required');
    //Tab campagna
    document.querySelector('#tab_content1 > div:nth-child(4) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#tab_content1 > div:nth-child(5) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#tab_content1 > div:nth-child(6) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#tab_content1 > div:nth-child(8) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#tab_content1 > div:nth-child(9) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#n_collateral').style.backgroundColor = '#C1FFD5';
    document.querySelector('#priority').style.backgroundColor = '#C1FFD5';
    //Tab canale
    document.querySelector('#tab_content3 > div > div:nth-child(1) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#tab_content3 > div > div:nth-child(2) > div > span > span.selection > span').style.backgroundColor = '#C1FFD5';
    document.querySelector('#volume_tot').style.backgroundColor = '#C1FFD5';
    document.querySelector('#testo_sms').style.backgroundColor = '#C1FFD5';
   
  }
  else {
    console.log('--->All required as Normal');
    //Tab campagna
    document.querySelector('#tab_content1 > div:nth-child(4) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#tab_content1 > div:nth-child(5) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#tab_content1 > div:nth-child(6) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#tab_content1 > div:nth-child(8) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#tab_content1 > div:nth-child(9) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#n_collateral').style.backgroundColor = '';
    document.querySelector('#priority').style.backgroundColor = '';
  
    //Tab canale
    document.querySelector('#tab_content3 > div > div:nth-child(1) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#tab_content3 > div > div:nth-child(2) > div > span > span.selection > span').style.backgroundColor = '';
    document.querySelector('#volume_tot').style.backgroundColor = '';
    document.querySelector('#testo_sms').style.backgroundColor = '';

  }

}


function validazione_canaleDealer(count, stato_id) {
    if (count > 1) {
        for (i = 2; i < 10; i++) {
            if (i <= count) {
                //$('#dealer_' + i).show();                
                if (get_required(stato_id)) {
                    $('#Cod_iniziativa' + i).attr('required', true);
                }
                else {
                    $('#Cod_iniziativa' + i).attr('required', false);
                }
            }
            else {
                //$('#dealer_' + i).hide();
                $('#Cod_iniziativa' + i).attr('required', false);
            }
        }
    }
}


function validazione_add_canaleDealer(count, stato) {

        //alert('canale 1 '+$(this).val());
        //count = $(this).val();
        for (i = 2; i < 10; i++) {
            if (i <= count) {
                if (get_required(stato)) {
                    $('#addCod_iniziativa' + i).attr('required', true);
                }
                else {
                    $('#addCod_iniziativa' + i).attr('required', false);
                }
                //$('#adddealer_'+i).show();                                        
            }
            else {
                //$('#adddealer_'+i).hide();
                $('#addCod_iniziativa' + i).attr('required', false);
            }
        }

}


function validazione(selected_channel_id, all_required) {
        
  $('#senders_ins').attr('required', false);
  $('#storicizza_ins').attr('required', false);
  $('#notif_consegna').attr('required', false);
  $('#testo_sms').attr('required', false);
  $('#mod_invio').attr('required', false);
  $('#link').attr('required', false);
  //$('#tipoMonitoring').attr('required', false);
  //$('#sms_duration').attr('required', false);
  //pos
  $('#cat_sott_ins').attr('required', false);
  $('#tit_sott_pos').attr('required', false);
        
  //$('#day_val_pos').attr('required', false);
  //$('#callguide_pos').attr('required', false);
  //#span_40400
  $('#alias_attiv').attr('required', false);
  $('#day_val').attr('required', false);
  $('#sms_incarico').attr('required', false);
  $('#sms_target').attr('required', false);
  $('#sms_adesione').attr('required', false);
  $('#sms_nondisponibile').attr('required', false);
  //#span_app_inbound
  //$('#day_val_app_inbound').attr('required', false);
  $('#id_news_app_inbound').attr('required', false);
  $('#prior_app_inbound').attr('required', false);
  //$('#callguide_app_inbound').attr('required', false);
  //#span_app_outbound
  //$('#day_val_app_outbound').attr('required', false);
  $('#id_news_app_outbound').attr('required', false);
  $('#prior_app_outbound').attr('required', false);
  $('#notif_app_outbound').attr('required', false);
  ////$('#callguide_app_outbound').attr('required', false);
  //#span_dealer
  $('#Cod_iniziativa').attr('required', false);
  //#span_icm
  $('#day_val_icm').attr('required', false);
  $('#callguide_icm').attr('required', false);
  //#span_ivr_inbound
  $('#day_val_ivr_inbound').attr('required', false);
  //#span_ivr_outbound
  $('#day_val_ivr_outbound').attr('required', false);
  //#span_jakala
  $('#data_invio_jakala').attr('required', false);
  //#span_spai
  $('#data_invio_spai').attr('required', false);
  //#span_mfh
  $('#type_mfh').attr('required', false);
  $('#note_mfh').attr('required', false);
  //#span_watson
  $('#type_watson').attr('required', false);
  $('#contact_watson').attr('required', false);
        //#span_inorderweb
      $('#funnel').attr('required', false);
    
  //stato diverso  Richiesta, Da Approfondire, Oltre Capacity e Annullata    
  if (get_required(all_required)) {    
    if (selected_channel_id === '12') {
      //$('#sms_duration').attr('required', true);
      //$('#tipoMonitoring').attr('required', true);
      //$('#link').attr('required', true);
      $('#mod_invio').attr('required', true);
      $('#testo_sms').attr('required', true);
      $('#storicizza_ins').attr('required', true);
      $('#senders_ins').attr('required', true);
      $('#notif_consegna').attr('required', true);

      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
        
      //$('#day_val_pos').attr('required', false);
      ////$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);


    }
    else if (selected_channel_id === '13') {//CRM DA POS


      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', true);
      $('#tit_sott_pos').attr('required', true);
    
      //$('#day_val_pos').attr('required', true);
      //$('#callguide_pos').attr('required', true);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);

    }
        
    else if (selected_channel_id === '14') {// 40400


      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', true);
      $('#day_val').attr('required', true);
      $('#sms_incarico').attr('required', true);
      $('#sms_target').attr('required', true);
      $('#sms_adesione').attr('required', true);
      $('#sms_nondisponibile').attr('required', true);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '21') {//canale ICM

        
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', true);
      $('#callguide_icm').attr('required', true);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '15') {//canale APP INBOUND


      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', true);
      $('#id_news_app_inbound').attr('required', true);
      $('#prior_app_inbound').attr('required', true);
      //$('#callguide_app_inbound').attr('required', true);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '16') {//canale APP OUTBOUND
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', true);
      $('#id_news_app_outbound').attr('required', true);
      $('#prior_app_outbound').attr('required', true);
      $('#notif_app_outbound').attr('required', true);
      //$('#callguide_app_outbound').attr('required', true);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '33') {//canale DEALER


      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', true);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);

    }
    else if (selected_channel_id === '22') {//canale IVR INBOUND

      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', true);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '23') {//canale IVR OUTBOUND

      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', true);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '24') {//canale JAKALA
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', true);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '31') {//canale MFH
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', true);
      $('#note_mfh').attr('required', true);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '35') {//canale SPAI
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', true);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '29') {//canale watson
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', true);
      $('#contact_watson').attr('required', true);
            //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    else if (selected_channel_id === '36') {//canale watson
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
      $('#funnel').attr('required', true);
    }
    else {
      //sms
      $('#senders_ins').attr('required', false);
      $('#storicizza_ins').attr('required', false);
      $('#notif_consegna').attr('required', false);
      $('#testo_sms').attr('required', false);
      $('#mod_invio').attr('required', false);
      $('#link').attr('required', false);
      //$('#tipoMonitoring').attr('required', false);
      //$('#sms_duration').attr('required', false);
      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
      //$('#day_val_pos').attr('required', false);
      //$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);
      //#span_inorderweb
      $('#funnel').attr('required', false);
    }
    
    console.log('validazione dentro ' + selected_channel_id);
    
  }
  
  //se lo stato è Richiesta, Confermata, Da Approfondire, Nuova Pianificazione, Oltre Capacity o  Annullata
  // e si seleziona il canale SMS 
  if (!get_required(all_required) && (selected_channel_id === '12')) {    
      //$('#sms_duration').attr('required', true);
      //$('#tipoMonitoring').attr('required', true);
      //$('#link').attr('required', true);
      //$('#mod_invio').attr('required', true);
      $('#testo_sms').attr('required', true);
      //$('#storicizza_ins').attr('required', true);
      //$('#senders_ins').attr('required', true);
      $('#notif_consegna').attr('required', true);

      //pos
      $('#cat_sott_ins').attr('required', false);
      $('#tit_sott_pos').attr('required', false);
        
      //$('#day_val_pos').attr('required', false);
      ////$('#callguide_pos').attr('required', false);
      //#span_40400
      $('#alias_attiv').attr('required', false);
      $('#day_val').attr('required', false);
      $('#sms_incarico').attr('required', false);
      $('#sms_target').attr('required', false);
      $('#sms_adesione').attr('required', false);
      $('#sms_nondisponibile').attr('required', false);
      //#span_app_inbound
      //$('#day_val_app_inbound').attr('required', false);
      $('#id_news_app_inbound').attr('required', false);
      $('#prior_app_inbound').attr('required', false);
      //$('#callguide_app_inbound').attr('required', false);
      //#span_app_outbound
      //$('#day_val_app_outbound').attr('required', false);
      $('#id_news_app_outbound').attr('required', false);
      $('#prior_app_outbound').attr('required', false);
      $('#notif_app_outbound').attr('required', false);
      //$('#callguide_app_outbound').attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa').attr('required', false);
      //#span_icm
      $('#day_val_icm').attr('required', false);
      $('#callguide_icm').attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound').attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound').attr('required', false);
      //#span_jakala
      $('#data_invio_jakala').attr('required', false);
      //#span_spai
      $('#data_invio_spai').attr('required', false);
      //#span_mfh
      $('#type_mfh').attr('required', false);
      $('#note_mfh').attr('required', false);
      //#span_watson
      $('#type_watson').attr('required', false);
      $('#contact_watson').attr('required', false);

  }
}

function channels_view(selected_channel_id) {

    if (selected_channel_id === '12') {
            $('#span_40400').hide();
            $('#span_spai').hide();
            $('#span_mfh').hide();
            $('#span_jakala').hide();
            $('#span_ivr_inbound').hide();
            $('#span_ivr_outbound').hide();
            $('#span_dealer').hide();
            $('#span_app_inbound').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
            $('#span_watson').hide();
            $('#pos_field').hide();
            $('#sms_field').show();

        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id
          },
          dataType: "html",
          success: function(data) {
            console.log(' sendersss qui' + JSON.stringify(data));
            console.log('eccoli2 data' + data);
            $("#senders_ins").fadeOut();
            $("#senders_ins").fadeIn();
            $("#senders_ins").html(data);
            //$("#selected_senders") = data;

          }

        });

      } else if (selected_channel_id === '13') {//CRM DA POS
            $('#sms_field').hide();
            $('#span_40400').hide();
            $('#span_spai').hide();
            $('#span_mfh').hide();
            $('#span_jakala').hide();
            $('#span_ivr_inbound').hide();
            $('#span_ivr_outbound').hide();
            $('#span_dealer').hide();
            $('#span_app_inbound').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
            $('#pos_field').show();

        $.ajax({
          url: "select_Cat_Sott.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id
          },
          dataType: "html",
          success: function(data) {
            $("#cat_sott_ins").fadeOut();
            $("#cat_sott_ins").fadeIn();
            $("#cat_sott_ins").html(data);

          }

        });
        } 
        
        else if (selected_channel_id === '14') {// 40400
            $('#sms_field').hide();
            $('#pos_field').hide();
            $('#span_spai').hide();
            $('#span_mfh').hide();
            $('#span_jakala').hide();
            $('#span_ivr_inbound').hide();
            $('#span_ivr_outbound').hide();
            $('#span_dealer').hide();
            $('#span_app_inbound').hide();
            $('#span_app_outbound').hide();
            $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
            $('#span_40400').show();
      } 
      else if (selected_channel_id === '21') {//canale ICM
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_icm').show();   
      }
      else if (selected_channel_id === '15') {//canale APP INBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_app_inbound').show();
      }
      else if (selected_channel_id === '16') {//canale APP OUTBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_app_outbound').show();
      }
      else if (selected_channel_id === '33') {//canale DEALER
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_dealer').show();
      }
     else if (selected_channel_id === '22') {//canale IVR INBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_ivr_inbound').show();
      }
      else if (selected_channel_id === '23') {//canale IVR OUTBOUND
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_ivr_outbound').show();
      }
      else if (selected_channel_id === '24') {//canale JAKALA
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_jakala').show();
      }
      else if (selected_channel_id === '31') {//canale MFH
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_mfh').show();
      }
      else if (selected_channel_id === '35') {//canale SPAI
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        $('#span_spai').show();
      }
     else if (selected_channel_id === '29') {//canale watson
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
      $('#span_icm').hide();
      $('#span_inorderweb').hide();
        $('#span_watson').show();
    }
      else if (selected_channel_id === '36') {//canale In Order Web
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').show();
      }
      else {
        $('#sms_field').hide();
        $('#pos_field').hide();
        $('#span_40400').hide();
        $('#span_spai').hide();
        $('#span_mfh').hide();
        $('#span_jakala').hide();
        $('#span_ivr_inbound').hide();
        $('#span_ivr_outbound').hide();
        $('#span_dealer').hide();
        $('#span_app_inbound').hide();
        $('#span_app_outbound').hide();
        $('#span_icm').hide();
      $('#span_watson').hide();
      $('#span_inorderweb').hide();
        
    }
    

      console.log('channel_id  ' + selected_channel_id);


}

function add_canale_validazione(selected_channel_id, all_required, add_canale) {
  //alert($( '#selected_channel_id'+add_canale).val());
  //sms
  $('#senders_ins' + add_canale).attr('required', false);
  $('#storicizza_ins' + add_canale).attr('required', false);
  $('#notif_consegna' + add_canale).attr('required', false);
  $('#testo_sms' + add_canale).attr('required', false);
  $('#mod_invio' + add_canale).attr('required', false);
  $('#link' + add_canale).attr('required', false);
  //$('#tipoMonitoring'+add_canale).attr( 'required', false);
  //$('#sms_duration'.attr( 'required', false);
  //pos
  $('#cat_sott_ins' + add_canale).attr('required', false);
  $('#tit_sott_pos' + add_canale).attr('required', false);
      
  //$( '#day_val_pos'+add_canale).attr( 'required', false);
  //$( '#callguide_pos'+add_canale).attr( 'required', false);
  //#span_40400
  $('#alias_attiv' + add_canale).attr('required', false);
  $('#day_val' + add_canale).attr('required', false);
  $('#sms_incarico' + add_canale).attr('required', false);
  $('#sms_target' + add_canale).attr('required', false);
  $('#sms_adesione' + add_canale).attr('required', false);
  $('#sms_nondisponibile' + add_canale).attr('required', false);
  //#span_app_inbound
  ////$('#day_val_app_inbound'+add_canale).attr('required', false);
  $('#id_news_app_inbound' + add_canale).attr('required', false);
  $('#prior_app_inbound' + add_canale).attr('required', false);
  //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
  //#span_app_outbound
  ////$('#day_val_app_outbound'+add_canale).attr('required', false);
  $('#id_news_app_outbound' + add_canale).attr('required', false);
  $('#prior_app_outbound' + add_canale).attr('required', false);
  $('#notif_app_outbound' + add_canale).attr('required', false);
  //$('#callguide_app_outbound'+add_canale).attr('required', false);
  //#span_dealer
  $('#Cod_iniziativa' + add_canale).attr('required', false);
  //#span_icm
  $('#day_val_icm' + add_canale).attr('required', false);
  $('#callguide_icm' + add_canale).attr('required', false);
  //#span_ivr_inbound
  $('#day_val_ivr_inbound' + add_canale).attr('required', false);
  //#span_ivr_outbound
  $('#day_val_ivr_outbound' + add_canale).attr('required', false);
  //#span_jakala
  $('#data_invio_jakala' + add_canale).attr('required', false);
  //#span_spai
  $('#data_invio_spai' + add_canale).attr('required', false);
  //#span_mfh
  $('#type_mfh' + add_canale).attr('required', false);
  $('#note_mfh' + add_canale).attr('required', false);
  //#span_watson
  $('#type_watson' + add_canale).attr('required', false);
  $('#contact_watson' + add_canale).attr('required', false);
  //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);

  //$(this).parsley().validate();
      
  //stato diverso  Draft, Da Approfondire, Oltre Capacity e Annullata 
  // OK Validazione    
  if (get_required(all_required)) {
    if (selected_channel_id === '12') {
      //sms
      $('#senders_ins' + add_canale).attr('required', true);
      $('#storicizza_ins' + add_canale).attr('required', true);
      $('#notif_consegna' + add_canale).attr('required', true);
      $('#testo_sms' + add_canale).attr('required', true);
      $('#mod_invio' + add_canale).attr('required', true);
      //$( '#link'+add_canale).attr( 'required', true);
      ////$('#tipoMonitoring'+add_canale).attr( 'required', true);
      //$('#sms_duration'.attr( 'required', true);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);

    }
    else if (selected_channel_id === '13') {//CRM DA POS
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', true);
      $('#tit_sott_pos' + add_canale).attr('required', true);
      //$( '#day_val_pos'+add_canale).attr( 'required', true);
      //$( '#callguide_pos'+add_canale).attr( 'required', true);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);

    }
    else if (selected_channel_id === '14') {// 40400
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', true);
      $('#day_val' + add_canale).attr('required', true);
      $('#sms_incarico' + add_canale).attr('required', true);
      $('#sms_target' + add_canale).attr('required', true);
      $('#sms_adesione' + add_canale).attr('required', true);
      $('#sms_nondisponibile' + add_canale).attr('required', true);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '21') {//canale ICM
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', true);
      $('#callguide_icm' + add_canale).attr('required', true);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '15') {//canale APP INBOUND
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', true);
      $('#id_news_app_inbound' + add_canale).attr('required', true);
      $('#prior_app_inbound' + add_canale).attr('required', true);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', true);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      ////$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '16') {//canale APP OUTBOUND
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', true);
      $('#id_news_app_outbound' + add_canale).attr('required', true);
      $('#prior_app_outbound' + add_canale).attr('required', true);
      $('#notif_app_outbound' + add_canale).attr('required', true);
      //$('#callguide_app_outbound'+add_canale).attr('required', true);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '22') {//canale IVR INBOUND
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', true);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '23') {//canale IVR OUTBOUND
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', true);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '24') {//canale Jakala
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', true);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '31') {//canale MFH
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', true);
      $('#note_mfh' + add_canale).attr('required', true);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '33') {//canale DEALER
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', true);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '35') {//canale SPAI
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', true);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
        
    else if (selected_channel_id === '29') {//canale Watson
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', true);
      $('#contact_watson' + add_canale).attr('required', true);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', false);
    }
    else if (selected_channel_id === '36') {//canale In Order Web
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
        //#span_inorderweb
  $('#funnel' + add_canale).attr('required', true);
    }
        
    else {
      //sms
      $('#senders_ins' + add_canale).attr('required', false);
      $('#storicizza_ins' + add_canale).attr('required', false);
      $('#notif_consegna' + add_canale).attr('required', false);
      $('#testo_sms' + add_canale).attr('required', false);
      $('#mod_invio' + add_canale).attr('required', false);
      $('#link' + add_canale).attr('required', false);
      //$('#tipoMonitoring'+add_canale).attr( 'required', false);
      //$('#sms_duration'.attr( 'required', false);
      //pos
      $('#cat_sott_ins' + add_canale).attr('required', false);
      $('#tit_sott_pos' + add_canale).attr('required', false);
      //$( '#day_val_pos'+add_canale).attr( 'required', false);
      //$( '#callguide_pos'+add_canale).attr( 'required', false);
      //#span_40400
      $('#alias_attiv' + add_canale).attr('required', false);
      $('#day_val' + add_canale).attr('required', false);
      $('#sms_incarico' + add_canale).attr('required', false);
      $('#sms_target' + add_canale).attr('required', false);
      $('#sms_adesione' + add_canale).attr('required', false);
      $('#sms_nondisponibile' + add_canale).attr('required', false);
      //#span_app_inbound
      ////$('#day_val_app_inbound'+add_canale).attr('required', false);
      $('#id_news_app_inbound' + add_canale).attr('required', false);
      $('#prior_app_inbound' + add_canale).attr('required', false);
      //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
      //#span_app_outbound
      ////$('#day_val_app_outbound'+add_canale).attr('required', false);
      $('#id_news_app_outbound' + add_canale).attr('required', false);
      $('#prior_app_outbound' + add_canale).attr('required', false);
      $('#notif_app_outbound' + add_canale).attr('required', false);
      //$('#callguide_app_outbound'+add_canale).attr('required', false);
      //#span_dealer
      $('#Cod_iniziativa' + add_canale).attr('required', false);
      //#span_icm
      $('#day_val_icm' + add_canale).attr('required', false);
      $('#callguide_icm' + add_canale).attr('required', false);
      //#span_ivr_inbound
      $('#day_val_ivr_inbound' + add_canale).attr('required', false);
      //#span_ivr_outbound
      $('#day_val_ivr_outbound' + add_canale).attr('required', false);
      //#span_jakala
      $('#data_invio_jakala' + add_canale).attr('required', false);
      //#span_spai
      $('#data_invio_spai' + add_canale).attr('required', false);
      //#span_mfh
      $('#type_mfh' + add_canale).attr('required', false);
      $('#note_mfh' + add_canale).attr('required', false);
      //#span_watson
      $('#type_watson' + add_canale).attr('required', false);
      $('#contact_watson' + add_canale).attr('required', false);
              //#span_inorderweb
      $('#funnel' + add_canale).attr('required', false
      );
    }
  }
  
   if (!get_required(all_required) && (selected_channel_id === '12')){
    //sms
    //$('#senders_ins' + add_canale).attr('required', true);
    //$('#storicizza_ins' + add_canale).attr('required', true);
    $('#notif_consegna' + add_canale).attr('required', true);
    $('#testo_sms' + add_canale).attr('required', true);
    //$('#mod_invio' + add_canale).attr('required', true);
    //$( '#link'+add_canale).attr( 'required', true);
    ////$('#tipoMonitoring'+add_canale).attr( 'required', true);
    //$('#sms_duration'.attr( 'required', true);
    //pos
    $('#cat_sott_ins' + add_canale).attr('required', false);
    $('#tit_sott_pos' + add_canale).attr('required', false);
    //$( '#day_val_pos'+add_canale).attr( 'required', false);
    //$( '#callguide_pos'+add_canale).attr( 'required', false);
    //#span_40400
    $('#alias_attiv' + add_canale).attr('required', false);
    $('#day_val' + add_canale).attr('required', false);
    $('#sms_incarico' + add_canale).attr('required', false);
    $('#sms_target' + add_canale).attr('required', false);
    $('#sms_adesione' + add_canale).attr('required', false);
    $('#sms_nondisponibile' + add_canale).attr('required', false);
    //#span_app_inbound
    ////$('#day_val_app_inbound'+add_canale).attr('required', false);
    $('#id_news_app_inbound' + add_canale).attr('required', false);
    $('#prior_app_inbound' + add_canale).attr('required', false);
    //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
    //#span_app_outbound
    ////$('#day_val_app_outbound'+add_canale).attr('required', false);
    $('#id_news_app_outbound' + add_canale).attr('required', false);
    $('#prior_app_outbound' + add_canale).attr('required', false);
    $('#notif_app_outbound' + add_canale).attr('required', false);
    //$('#callguide_app_outbound'+add_canale).attr('required', false);
    //#span_dealer
    $('#Cod_iniziativa' + add_canale).attr('required', false);
    //#span_icm
    $('#day_val_icm' + add_canale).attr('required', false);
    $('#callguide_icm' + add_canale).attr('required', false);
    //#span_ivr_inbound
    $('#day_val_ivr_inbound' + add_canale).attr('required', false);
    //#span_ivr_outbound
    $('#day_val_ivr_outbound' + add_canale).attr('required', false);
    //#span_jakala
    $('#data_invio_jakala' + add_canale).attr('required', false);
    //#span_spai
    $('#data_invio_spai' + add_canale).attr('required', false);
    //#span_mfh
    $('#type_mfh' + add_canale).attr('required', false);
    $('#note_mfh' + add_canale).attr('required', false);
    //#span_watson
    $('#type_watson' + add_canale).attr('required', false);
     $('#contact_watson' + add_canale).attr('required', false);
             //#span_inorderweb
     $('#funnel' + add_canale).attr('required', false
     );

        

    console.log('dentro add canale validazione channel_id1  ' + selected_channel_id);
  }
}

function add_canale_view(selected_channel_id, add_canale) {
        //alert($( '#selected_channel_id'+add_canale).val());  
    
    //sms
        if (selected_channel_id === '12') {
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field' + add_canale).hide();
           $('#span_inorderweb'+add_canale).hide();
          $('#sms_field'+add_canale).show();

          $.ajax({
            url: "selectSender_1.php",
            method: "POST",
            data: {
              channel_id: selected_channel_id
            },
            dataType: "html",
            success: function (data) {
              console.log(' sendersss qui ' + JSON.stringify(data));
              console.log('eccoli2 data ' + data);
              $("#senders_ins"+add_canale).fadeOut();
              $("#senders_ins"+add_canale).fadeIn();
              $("#senders_ins"+add_canale).html(data);
              //$("#selected_senders") = data;

            }

          });

        }
        else if (selected_channel_id === '13') {//CRM DA POS
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).show();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

                 
          $.ajax({
            url: "select_Cat_Sott.php",
            method: "POST",
            data: {
              channel_id: selected_channel_id
            },
            dataType: "html",
            success: function (data) {
              $("#cat_sott_ins"+add_canale).fadeOut();
              $("#cat_sott_ins"+add_canale).fadeIn();
              $("#cat_sott_ins"+add_canale).html(data);

            }

          });
        }
        else if (selected_channel_id === '14') {// 40400
          $('#span_40400'+add_canale).show();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

         
        }
        else if (selected_channel_id === '21') {//canale ICM
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).show();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();
        
        }
        else if (selected_channel_id === '15') {//canale APP INBOUND
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).show();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

         
        }
        else if (selected_channel_id === '16') {//canale APP OUTBOUND
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).show();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

         
        }
        else if (selected_channel_id === '22') {//canale IVR INBOUND
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).show();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

         
        }
        else if (selected_channel_id === '23') {//canale IVR OUTBOUND
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).show();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

      
        }
        else if (selected_channel_id === '24') {//canale Jakala
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).show();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

        }
        else if (selected_channel_id === '31') {//canale MFH
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).show();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

          //sms
          $('#senders_ins'+add_canale).attr('required', false);
          $('#storicizza_ins'+add_canale).attr('required', false);
          $('#notif_consegna'+add_canale).attr('required', false);
          $('#testo_sms'+add_canale).attr('required', false);
          $('#mod_invio'+add_canale).attr('required', false);
          $('#link'+add_canale).attr('required', false);
          //$('#tipoMonitoring'+add_canale).attr( 'required', false);
          //$('#sms_duration'.attr( 'required', false);
          //pos
          $('#cat_sott_ins'+add_canale).attr('required', false);
          $('#tit_sott_pos'+add_canale).attr('required', false);
          //$( '#day_val_pos'+add_canale).attr( 'required', false);
          //$( '#callguide_pos'+add_canale).attr( 'required', false);
          //#span_40400
          $('#alias_attiv'+add_canale).attr('required', false);
          $('#day_val'+add_canale).attr('required', false);
          $('#sms_incarico'+add_canale).attr('required', false);
          $('#sms_target'+add_canale).attr('required', false);
          $('#sms_adesione'+add_canale).attr('required', false);
          $('#sms_nondisponibile'+add_canale).attr('required', false);
          //#span_app_inbound
          ////$('#day_val_app_inbound'+add_canale).attr('required', false);
          $('#id_news_app_inbound'+add_canale).attr('required', false);
          $('#prior_app_inbound'+add_canale).attr('required', false);
          //$( '#callguide_app_inbound'+add_canale).attr( 'required', false);
          //#span_app_outbound
          ////$('#day_val_app_outbound'+add_canale).attr('required', false);
          $('#id_news_app_outbound'+add_canale).attr('required', false);
          $('#prior_app_outbound'+add_canale).attr('required', false);
          $('#notif_app_outbound'+add_canale).attr('required', false);
          //$('#callguide_app_outbound'+add_canale).attr('required', false);
          //#span_dealer
          $('#Cod_iniziativa'+add_canale).attr('required', false);
          //#span_icm
          $('#day_val_icm'+add_canale).attr('required', false);
          $('#callguide_icm'+add_canale).attr('required', false);
          //#span_ivr_inbound
          $('#day_val_ivr_inbound'+add_canale).attr('required', false);
          //#span_ivr_outbound
          $('#day_val_ivr_outbound'+add_canale).attr('required', false);
          //#span_jakala
          $('#data_invio_jakala'+add_canale).attr('required', false);
          //#span_spai
          $('#data_invio_spai'+add_canale).attr('required', false);
          //#span_mfh
          $('#type_mfh'+add_canale).attr('required', true);
          $('#note_mfh'+add_canale).attr('required', true);
          //#span_watson
          $('#type_watson'+add_canale).attr('required', false);
          $('#contact_watson'+add_canale).attr('required', false);
        }
        else if (selected_channel_id === '33') {//canale DEALER
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).show();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

          
        }
        else if (selected_channel_id === '35') {//canale SPAI
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).show();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

        }
        
        else if (selected_channel_id === '29') {//canale Watson
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).show();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

        }
        else if (selected_channel_id === '36') {//canale In Order Web
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).show();

        }
        
        else {
          $('#span_40400'+add_canale).hide();
          $('#span_spai'+add_canale).hide();
          $('#span_mfh'+add_canale).hide();
          $('#span_jakala'+add_canale).hide();
          $('#span_ivr_inbound'+add_canale).hide();
          $('#span_ivr_outbound'+add_canale).hide();
          $('#span_dealer'+add_canale).hide();
          $('#span_app_outbound'+add_canale).hide();
          $('#span_app_inbound'+add_canale).hide();
          $('#span_icm'+add_canale).hide();
          $('#span_watson'+add_canale).hide();
          $('#pos_field'+add_canale).hide();
          $('#sms_field' + add_canale).hide();
          $('#span_inorderweb'+add_canale).hide();

        }

      console.log( 'dentro view add canale channel_id'+add_canale+'  ' + selected_channel_id);

}

function validazione_criteri(all_required) {
  //stato diverso  Draft, Da Approfondire, Oltre Capacity e Annullata    
  if (!get_required(all_required)) {
    $('#attivi').attr('required', false);
    $('#sospesi').attr('required', false);
    $('#disattivi').attr('required', false);
    $('#consumer').attr('required', false);
    $('#business').attr('required', false);
    $('#microbusiness').attr('required', false);
    $('#prepagato').attr('required', false);
    $('#postpagato').attr('required', false);
    $('#voce').attr('required', false);
    $('#dati').attr('required', false);
    $('#fisso').attr('required', false);
    $('#no_frodi').attr('required', false);
    $('#altri_filtri').attr('required', false);
    $('#altri_criteri').attr('required', false);
    $('#select_control_indic').attr('required', false);
    //contratto_microbusiness cons_profilazione cons_commerciale cons_terze_parti cons_geolocalizzazione cons_enrichment cons_trasferimentidati
  }
  else {
        $('#attivi').attr('required', true);
    $('#sospesi').attr('required', true);
    $('#disattivi').attr('required', true);
    $('#consumer').attr('required', true);
    $('#business').attr('required', true);
    $('#microbusiness').attr('required', true);
    $('#prepagato').attr('required', true);
    $('#postpagato').attr('required', true);
    $('#voce').attr('required', true);
    $('#dati').attr('required', true);
    $('#fisso').attr('required', true);
    $('#no_frodi').attr('required', true);
    $('#altri_filtri').attr('required', true);
    $('#altri_criteri').attr('required', true);
    $('#select_control_indic').attr('required', true);
  }
}


function seleziona(campo) {

    campoSelezionato = document.getElementById(campo);
    campoSelezionato.style.background = "yellow";
}

function deseleziona(campo) {

    campoSelezionato = document.getElementById(campo);
    campoSelezionato.style.background = "white";
}

function manageCamp(id, azione, permesso_elimina, stato){
    //alert('eccoloooo ' + id +' '+ azione);
        if(azione==='modifica'){
            document.getElementById("campagnaModifica"+id).submit();  
        }
    
        if (azione === 'duplica') {
            if (duplica())
                document.getElementById("campagnaDuplica"+id).submit(); 
            
        } 
        if (azione === 'elimina') {
            if(conferma(stato, permesso_elimina))
                document.getElementById("campagnaElimina"+id).submit(); 
            } 
        if(azione==='open'){
            document.getElementById("campagnaOpen"+id).submit(); 
        } 
        if(azione==='new'){
            document.getElementById("campagnaNew"+id).submit(); 
      } 
      if(azione==='exportpianificazione'){
            document.getElementById("exportpianificazione").submit(); 
      } 
      if(azione==='exportgestione'){
            document.getElementById("exportgestione").submit(); 
    } 
    if(azione==='exportcapacity'){
            document.getElementById("exportcapacity").submit(); 
    } 
    if(azione==='nofilter'){
            document.getElementById("nofilter").submit(); 
    } 

}

function onKeyNumeric(e) {
    if (((e.keyCode >= 48) && (e.keyCode <= 57)) || ((e.keyCode > 95) && (e.keyCode < 106)) || (e.keyCode == 8) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode == 8) || (e.keyCode == 109) || (e.keyCode == 37) || (e.keyCode == 39)) {
        return true;
    }
    else
    {
        return false;
    }
}

    function conferma(stato, permesso_elimina) {
        if (permesso_elimina == 0) {
            alert("Non hai i permessi per eliminare la campagna!");
            return false;
        }
        if (stato == 0) {
            alert("La campagna non è in uno stato eliminabile");
            return false;
        }
        if (!(confirm('Confermi eliminazione?'))) {
            return false;
        } else {
            return true;
        }
    }
    function duplica() {
        if (!(confirm('Confermi di voler duplicare la campagna?')))
        {
            return false;
        }
        else {
            return true;
        }
    }

    function inserisci() {
        permesso_inserisci = 1;
        if (permesso_inserisci != 1)
            alert("Non hai i permessi per inserire una campagna");
        else
            document.location.href = './index.php?page=inserisciCampagna2';
    }



function get_info_stato(stato_id) {
  var stato_info = '';

  $.ajax({
    url: "get_stato_info.php",
    method: "POST",
    data: { stato_id: stato_id },
    //dataType: "json",
    success: function (data) {
      console.log('stato info ' + JSON.stringify(data));
      stato_info = JSON.stringify(data);
      //console.log('stato all_required ' + stato_info.all_required);          
    }
  });

  return stato_info;

}

function get_info_required(stato_id) {
  var required = false;
  $.ajax({
    url: "get_stato_info.php",
    method: "POST",
    data: { stato_id: stato_id },
    dataType: "json",
    success: function (data) {
      console.log('stato info ' + JSON.stringify(data));
      //stato_info = JSON.parse(data);
      stato_info = data;
      console.log('stato all_required ' + stato_info.all_required);
      if (stato_info.all_required == 1) {
        console.log('get_info_stato eccolo return true');
          required = true;
        }
      else if (stato_info.all_required == 0) {
        console.log('get_info_stato eccolo return false');
          required = false;
        }
      
    }
  });

  return required;

}


function process_stato(stato_id, stato_id_new) {
  //Una campagna può passare in stato lavorabile solo se si trova in stato confermata
  //ID 4 confermata  ID 10 Lavorabile
  if ((stato_id_new==10) && (stato_id != 4)) {
    alert('Una campagna può passare in stato LAVORABILE solo se si trova in stato CONFERMATA !!');
    return false;
  }
  else {
    return true;
  }

}

function get_required(stato_id) {
  //full required stoto LAVORABILE ed ESEGUITA
                  if (stato_id == 1 || stato_id == 10) {                    
                      return true;
                  }
                  else {
                    return false;
                    
  }

}

function new_get_stato(stato_id) {
              var stato_info = JSON.parse($.ajax({
                    url: "get_stato_info.php",
                    method: "POST",
                    data: { stato_id: stato_id },
                    dataType: "json",
                    async: false,
                }).responseText);
  //console.log('stato_info new ' + JSON.stringify(stato_info));
  return stato_info;
}

    function durata_camp(value) {
     if(value === '0'){
            $('#day1').hide();
            $('#day2').hide();
            $('#day3').hide();
            $('#day4').hide();
            $('#day5').hide();
            $('#day6').hide();
            $('#day7').hide();   
     }        
            else if(value === '1'){
                    $('#day1').show();
                    $('#day2').hide();
                    $('#day3').hide();
                    $('#day4').hide();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();  
                
            }else if(value === '2'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').hide();
                    $('#day4').hide();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();  
            }else if(value === '3'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').hide();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();
            }
            else if(value === '4'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').hide();
                    $('#day6').hide();
                    $('#day7').hide();
            }
                else if(value === '5'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').show();
                    $('#day6').hide();
                    $('#day7').hide();
            }
                    else if(value === '6'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').show();
                    $('#day6').show();
                    $('#day7').hide();
            }
            else if(value === '7'){
                    $('#day1').show();
                    $('#day2').show();
                    $('#day3').show();
                    $('#day4').show();
                    $('#day5').show();
                    $('#day6').show();
                    $('#day7').show();
            }
}


   
 function volumeRipartizione(start) {
    durata = $('#duratacampagna').val();
    temp = 0;
    
    volume = $('#volume_tot').val();
    var volday = [0, 0, 0, 0, 0, 0, 0]; 
    volday[0] = $('#VolumeGiornaliero1').val();
    volday[1] = $('#VolumeGiornaliero2').val();
    volday[2] = $('#VolumeGiornaliero3').val();
    volday[3] = $('#VolumeGiornaliero4').val();
    volday[4] = $('#VolumeGiornaliero5').val();
    volday[5] = $('#VolumeGiornaliero6').val();
    volday[6] = $('#VolumeGiornaliero7').val();

    for (i = 0; i < parseInt(durata); i++) {    
        if (i < (start)) {
            temp = temp + parseInt(volday[i]);
        } else {
            //alert(Math.floor((volume - temp) / (durata - start)));
//            if (document.getElementById('volumeGiornaliero' + i).value == 0)
            //document.getElementById('volumeGiornaliero' + i).value = Math.floor((volume - temp) / (durata - start));
            volday[i] = Math.floor((volume - temp) / (durata - start));
 
        }
    }
   if (volume - temp - Math.floor((volume - temp) / (durata - start)) * (durata - start - 1) < 0){
        alert("numero sms errato.");
    }    
    //document.getElementById('volumeGiornaliero' + durata).value = volume - temp - Math.floor((volume - temp) / (durata - start)) * (durata - start - 1);


    $("#VolumeGiornaliero1").val(volday[0]);  
    $("#VolumeGiornaliero2").val(volday[1]); 
    $("#VolumeGiornaliero3").val(volday[2]);   
    $("#VolumeGiornaliero4").val(volday[3]);   
    $("#VolumeGiornaliero5").val(volday[4]);   
    $("#VolumeGiornaliero6").val(volday[5]);   
    $("#VolumeGiornaliero7").val(volday[6]);     
 

 }

 function checklength(areaText, maxchars, input, char, char_count_sms) {
    lunghezza_sms = 160;
    lunghezza_sms_concatenato = 153;
    lunghezza_link = 28;
    chars = document.getElementById(input).value;
    if ((document.getElementById("mod_invio").value == "Interattivo") && (input == "testo_sms")) {
        lunghezza_link = 28;
    } else {
        lunghezza_link = 0;
    }
    maxchars = maxchars - lunghezza_link;
    if (chars.length > maxchars)
    {
        document.getElementById(input).value = chars.substr(0, maxchars);
        document.getElementById(input).blur();
    }
    //document.getElementById(char).value = maxchars - document.getElementById(input).value.length;
    document.getElementById(char).value = document.getElementById(input).value.length;
    if (char_count_sms != '') {
        if (document.getElementById(input).value.length <= 160 - lunghezza_link)
            document.getElementById(char_count_sms).value = 1;
        else
            document.getElementById(char_count_sms).value = Math.floor((document.getElementById(input).value.length - lunghezza_link) / 153) + 1;
    }
}

function checklengthTotal(input, char) {   
    lunghezza_test_sms = 0;
    chars = document.getElementById(input).value;
    if ((document.getElementById("mod_invio").value === "Interattivo")) {
        lunghezza_test_sms = document.getElementById(char).value; 
        
    } else {
        lunghezza_test_sms = 0;
    }
    totale = document.getElementById("numero_totale").value = parseInt(chars) + parseInt(lunghezza_test_sms) + 1;
    //alert('eccolo test ' + totale);
}



