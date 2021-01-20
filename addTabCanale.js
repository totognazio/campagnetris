    

    $('#channel_ins5').select2({
      placeholder: "Select"      //allowClear: true
    });
    
    $('#channel_ins5').on('select2:select', function() {
      var selected_channel_id5 = $('#channel_ins5').val();
      $('#cat_sott_ins5').attr('required', false);
      $('#sms_duration5').attr('required', false);
      $('#tipoMonitoring5').attr('required', false);
      $('#link5').attr('required', false);
      $('#mod_invio5').attr('required', false);
      $('#testo_sms5').attr('required', false);
      $('#storicizza_ins5').attr('required', false);
      $('#senders_ins5').attr('required', false);
      $(this).parsley().validate();

      if (selected_channel_id5 === '1' || selected_channel_id === '12') {
        $('#sms_field5').show();
        $('#sms_duration5').attr('required', true)
        $('#tipoMonitoring5').attr('required', true)
        $('#link5').attr('required', true)
        $('#mod_invio5').attr('required', true)
        $('#testo_sms5').attr('required', true)
        $('#storicizza_ins5').attr('required', true)
        $('#senders_ins5').attr('required', true)

        $('#pos_field5').hide();
        $.ajax({
          url: "selectSender_1.php",
          method: "POST",
          data: {
            channel_id: selected_channel_id5
          },
          dataType: "html",
          success: function(data) {
            console.log('eccoli data' + JSON.stringify(data));
            console.log('eccoli2 data' + data);
            $("#senders_ins5").fadeOut();
            $("#senders_ins5").fadeIn();
            $("#senders_ins5").html(data);
            //$("#selected_senders") = data;

          }

        });

      } else if (selected_channel_id5 === '13') {
        $('#pos_field5').show();
        $('#cat_sott_ins5').attr('required', true)
        $('#sms_field5').hide();

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
      } else {
        $('#sms_field5').hide();
        $('#pos_field5').hide();
      }
      console.log('channel_id5  ' + selected_channel_id);

    });

    
