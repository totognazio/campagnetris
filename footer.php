<!-- footer content -->

<footer>
    <div class="pull-right">

        <a href="mailto:francesco.forti@windtre.it?Subject=Segnalazioni%20e%20Consigli" target="_top" title="Invia mail">
            Tool Campaign - Powered by Device Engineering </a>
<?php print_r($_SESSION); ?>
    </div>
    <div class="clearfix"></div>
</footer>
<!-- /footer content -->
</div>
</div>


<!-- Bootstrap -->
<script src="vendors/bootstrap/dist/js/bootstrap.min.js"></script>
<!-- FastClick -->
<script src="vendors/fastclick/lib/fastclick.js"></script>
<!-- NProgress -->
<script src="vendors/nprogress/nprogress.js"></script>
<!-- Include the plugin multiselect -->
<script type="text/javascript" src="node_modules/bootstrap-multiselect/dist/js/bootstrap-multiselect.js"></script>


<!-- Datatables -->
<script src="./vendors/datatables.net/js/jquery.dataTables.min.js"></script>
<script src="./vendors/datatables.net-bs/js/dataTables.bootstrap.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/dataTables.buttons.min.js"></script>
<script src="./vendors/datatables.net-buttons-bs/js/buttons.bootstrap.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.html5.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/jszip.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/FileSaver.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.flash.min.js"></script>
<script src="./vendors/datatables.net-buttons/js/buttons.print.min.js"></script>

<script src="./vendors/datatables.net-fixedheader/js/dataTables.fixedHeader.min.js"></script>

<script src="./vendors/datatables.net-keytable/js/dataTables.keyTable.min.js"></script>

<script src="./vendors/datatables.net-responsive/js/dataTables.responsive.min.js"></script>
<script src="./vendors/datatables.net-responsive-bs/js/responsive.bootstrap.js"></script>
<script src="./vendors/datatables.net-responsive/js/jszip.min.js"></script>
<script src="./vendors/datatables.net-responsive/js/FileSaver.js"></script>
<script src="./vendors/datatables.net-responsive/js/buttons.html5.min.js"></script>
<script src="./vendors/datatables.net-responsive/js/buttons.print.min.js"></script>
<script src="./node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
<!-- bootstrap-daterangepicker -->
<script src="vendors/moment/min/moment.min.js"></script>
<script src="vendors/bootstrap-daterangepicker/daterangepicker.js"></script>

<script src="vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- iCheck -->
    <script src="vendors/iCheck/icheck.min.js"></script>
<!-- Custom Theme Scripts -->
<script src="build/js/custom.min.js"></script>
<!-- Custom Util -->
<script src="js/util.js"></script>

<!-- Initialize the plugin: -->
<script type="text/javascript">
    $(document).ready(function () {

    var selected_stacks = $('#stacks').val();
    var selected_squads = $('#squads').val();
    var selected_states = $('#states').val();
    var selected_channels = $('#channels').val();
    var selected_typologies = $('#typologies').val();
      
    $('#stacks').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All',
            selectAllName: 'select-all',
            buttonWidth: '150px',
            
            onSelectAll: function (option, checked) {

                selected_stacks = $('#stacks').val();
                campagnTable();
            },
            onDeselectAll: function (option, checked) {

                selected_stacks = $('#stacks').val();
                campagnTable();
            },
            onChange: function (option, checked) {

                selected_stacks = $('#stacks').val();
                campagnTable();
            }


    });
    $('#channels').multiselect({
    enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All',
            selectAllName: 'select-all',
            buttonWidth: '150px',
            onSelectAll: function (option, checked) {

            selected_channels = $('#channels').val();
            campagnTable();
            },
    onDeselectAll: function (option, checked) {

    selected_channels = $('#channels').val();
    campagnTable();
    },
            onChange: function (option, checked) {

            selected_channels = $('#channels').val();
            campagnTable();
            }
    });
    $('#squads').multiselect({
    enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All',
            selectAllName: 'select-all',
            buttonWidth: '150px',
            onSelectAll: function (option, checked) {

            selected_squads = $('#squads').val();
            campagnTable();
            },
    onDeselectAll: function (option, checked) {

    selected_squads = $('#squads').val();
    campagnTable();
    },
            onChange: function (option, checked) {

            selected_squads = $('#squads').val();
            campagnTable();
            }
    });
    $('#states').multiselect({
    enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All',
            selectAllName: 'select-all',
            buttonWidth: '150px',
            onSelectAll: function (option, checked) {

            selected_states = $('#states').val();
            campagnTable();
            },
    onDeselectAll: function (option, checked) {

    selected_states = $('#states').val();
    campagnTable();
    },
            onChange: function (option, checked) {

            selected_states = $('#states').val();
            campagnTable();
            }
    });
    $('#typologies').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All',
            selectAllName: 'select-all',
            buttonWidth: '150px',
            onSelectAll: function (option, checked) {

            selected_typologies = $('#typologies').val();
            campagnTable();
            },
    onDeselectAll: function (option, checked) {

    selected_typologies = $('#typologies').val();
    campagnTable();
    },
            onChange: function (option, checked) {

            selected_typologies = $('#typologies').val();
            campagnTable();
            }
    });
    
    

$('#stack_ins').select2({
          placeholder: "Select Stack"
          // allowClear: true
        });
$('#stack_ins').on('select2:select', function () {
    var selected_stacks = $('#stack_ins').val();
    console.log('stack  '+ selected_stacks);
    
    $.ajax({
    url: "selectStack.php",
            method: "POST",
            data: {stack_id: selected_stacks},
            //dataType:"html",    
            success: function (data)
            {
                $("#type_ins").fadeOut();
                $("#type_ins").fadeIn();                
                $("#type_ins").html(data);
                
            }
            
        });  
});

$('#senders_ins').select2({
          placeholder: "Select Sender",
          allowClear: true
        });


$('#chammel_ins').select2({
          placeholder: "Select"
          // allowClear: true
        });
$('#chammel_ins').on('select2:select', function () {
   var selected_channel_id = $('#chammel_ins').val();
    
   if(selected_channel_id ==='1' || selected_channel_id ==='12'){
        $('#sms_field').show();
        $('#pos_field').hide();
        $.ajax({
        url: "selectSender_1.php",
                method: "POST",
                data: {channel_id: selected_channel_id},
                dataType:"html",    
                success: function (data)
                {
                    console.log('eccoli data' + JSON.stringify(data));
                    console.log('eccoli2 data' + data);
                    $("#senders_ins").fadeOut();
                    $("#senders_ins").fadeIn();                
                    $("#senders_ins").html(data);
                    //$("#selected_senders") = data;

                }

            });  

    }   
    else if(selected_channel_id ==='13'){
       $('#pos_field').show();
       $('#sms_field').hide();
       
      $.ajax({
        url: "select_Cat_Sott.php",
                method: "POST",
                data: {channel_id: selected_channel_id},
                dataType:"html",    
                success: function (data)
                {
                    $("#cat_sott_ins").fadeOut();
                    $("#cat_sott_ins").fadeIn();                
                    $("#cat_sott_ins").html(data);

                }

            }); 
    }
    else{
        $('#sms_field').hide();
        $('#pos_field').hide();
    }
    console.log('channel_id  '+ selected_channel_id);
    
});


$('#tit_sott_ins').select2({
          placeholder: "Select"
          // allowClear: true
        });
$('#tit_sott_ins').on('select2:select', function () {
    var selected_stacks = $('#tit_sott_ins').val();
    console.log('stack  '+ selected_stacks);
});

$('#cat_sott_ins').select2({
          placeholder: "Select"
          // allowClear: true
        });
$('#cat_sott_ins').on('select2:select', function () {
    var selected_stacks = $('#cat_sott_ins').val();
    console.log('stack  '+ selected_stacks);

});


$('#moda_ins').select2({
          placeholder: " Select"         
        });
$('#moda_ins').on('select2:select', function () {
    var selected_moda = $('#moda_ins').val();
    console.log('type_ins  '+ selected_moda);

});

$('#cate_ins').select2({
          placeholder: " Select"         
        });
$('#cate_ins').on('select2:select', function () {
    var selected_cate = $('#moda_ins').val();
    console.log('type_ins  '+ selected_cate);

});

$('#squad_ins').select2({
          placeholder: "Select Squad",
          allowClear: true
        });
$('#squad_ins').on('select2:select', function () {
    var selected_stacks = $('#squad_ins').val();
    console.log('squad  '+ selected_stacks);
     
});
       

$('#type_ins').select2({
          placeholder: "Select Type"         
        });
$('#type_ins').on('select2:select', function () {
    var selected_type = $('#type_ins').val();
    console.log('type_ins  '+ selected_type);
    
    $.ajax({
    url: "selectType.php",
            method: "POST",
            data: {selected_type: selected_type},
            //dataType:"html",    
            success: function (data)
            {
                $("#nomecampagna").fadeOut();
                $("#nomecampagna").fadeIn();
                $("#nomecampagna").val(data);
            }
            
        });  
});


$('#offer_ins').select2({
          placeholder: "Select Offer",
          allowClear: true
        });
$('#offer_ins').on('select2:select', function () {
    var selected_offer_id = $('#offer_ins').val();
    console.log('offer  '+ selected_offer_id);
});

    

function  campagnTable() {
    //console.log('startdate in camp '+ select_startDate);
    //console.log('enddate in camp '+ select_endDate);
    //var startDate = Date.parse(select_startDate);
    //var endDate = Date.parse(select_endDate);
    
    //console.log('eccolosososo in '+ startDate);
    //console.log('eccolosososo in '+ endDate);
   
    $("#content_response").fadeOut();
    $('.loader').show();
    $.ajax({
    url: "get_Filter.php",
            method: "POST",
            data: {startDate: select_startDate, endDate: select_endDate, selected_stacks: selected_stacks, selected_squads: selected_squads, selected_states: selected_states, selected_channels: selected_channels, selected_typologies: selected_typologies},
            //dataType:"html",    
            success: function (data)
            {
            $("#content_response").fadeOut();
            $("#content_response").fadeIn();
            $("#content_response").html(data);
            //console.log('Submission was successful.');
            //console.log('eccoloooo ' + data);
            //alert('ciao '+data);
            $('#datatable-pianificazione').DataTable( {
                    scrollY:        "350px",
                    scrollX:        true,
                    scrollCollapse: true,
                    paging:         false,
                    //fixedColumns:   {
                    //    leftColumns: 5
                    //}
                    "ordering": false,
                    "columnDefs": [
                                    { "orderable": false, "targets": 0 },
                                    { "orderable": false, "targets": 1 }
                                    
                                  ]
                    
                               
            } );
            
            $('#datatable-pianificazione').DataTable().columns.adjust().responsive.recalc();
            $('.loader').hide();
            },
            error: function (data) {
            console.log('An error occurred.');
            console.log(data);
            }
    });
}
     
    // bootstrap-daterangepicker     
    moment.locale('it');
    moment().format('LL');
    var select_startDate = moment().startOf('month').format('YYYY-MM-DD');
    var select_endDate = moment().endOf('month').format('YYYY-MM-DD');
        
    var cb = function(start, end, label) {
        console.log(start.toISOString(), end.toISOString(), label);
        $('#reportrange_right span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    };
    var optionSet1 = {
            startDate: moment().startOf('month').format('DD/MM/YYYY'),
            endDate:  moment().endOf('month').format('DD/MM/YYYY'),
            minDate: '01/01/2014',
            maxDate: '12/31/2021',
            //dateLimit: {
            //days: 60
            //},
            showDropdowns: true,
            showWeekNumbers: true,
            timePicker: false,
            timePickerIncrement: 1,
            timePicker12Hour: true,
            ranges: {
                    'Oggi': [moment(), moment()],
                    'Ieri': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
                    'Ultimi 7 giorni': [moment().subtract(6, 'days'), moment()],
                    'Ultimi 30 giorni': [moment().subtract(29, 'days'), moment()],
                    'Settimana corrente': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
                    'Settimana prossima': [moment().add(1, 'Week').startOf('isoWeek'), moment().add(1, 'Week').endOf('isoWeek')],
                    'Mese corrente': [moment().startOf('month'), moment().endOf('month')],
                    'Mese precedente': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')]
            },
            opens: 'right',
            buttonClasses: ['btn btn-default'],
            applyClass: 'btn-small btn-primary',
            cancelClass: 'btn-small',
            format: 'DD/MM/YYYY',
            separator: ' to ',
            locale: {
                    format: "DD/MM/YYYY",
                    applyLabel: 'Submit',
                    cancelLabel: 'Clear',
                    fromLabel: 'From',
                    toLabel: 'To',
                    customRangeLabel: 'Custom',
                    daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
                    monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
                    firstDay: 1
            }
    };
        
    //solo al primo
    campagnTable();
    $('#reportrange_right span').html(moment().startOf('month').format('D MMMM, YYYY')  + ' - ' + moment().endOf('month').format('D MMMM, YYYY') );
    $('#reportrange_right').daterangepicker(optionSet1, cb);

    $('#reportrange_right').on('show.daterangepicker', function() {
        console.log("show event fired");
    });
    $('#reportrange_right').on('hide.daterangepicker', function() {
        console.log("hide event fired");
    });
    $('#reportrange_right').on('apply.daterangepicker', function(ev, picker) {

        console.log("apply event fired, start/end dates are " + picker.startDate.format('DD/MM/YYYY') + " to " + picker.endDate.format('DD/MM/YYYY'));
        select_startDate = picker.startDate.format('YYYY-MM-DD');        
        select_endDate = picker.endDate.format('YYYY-MM-DD');
        console.log('select_startDate inn' + select_startDate);
        console.log('select_endDate inn' + select_endDate);
        campagnTable();
    });
    $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
            console.log("cancel event fired");
    });
    $('#options1').click(function() {
        $('#reportrange_right').data('daterangepicker').setOptions(optionSet1, cb);
    });
  
    $('#destroy').click(function() {
        $('#reportrange_right').data('daterangepicker').remove();
    });
    
    
    });
    



</script>



    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#data_fine').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4",
          format: 'YYYY-MM-DD'
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
        
        $('#data_inizio').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4",
          format: 'YYYY-MM-DD'
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->


<!-- Parsley -->
    <!-- Parsley -->
    <script src="vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="vendors/autosize/dist/autosize.min.js"></script>
    <script>
      $(document).ready(function() {
        window.Parsley.on('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form .btn').on('click', function() {
          $('#demo-form').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });

      $(document).ready(function() {
        window.Parsley.on('parsley:field:validate', function() {
          validateFront();
        });
        $('#demo-form2 .btn').on('click', function() {
          $('#demo-form2').parsley().validate();
          validateFront();
        });
        var validateFront = function() {
          if (true === $('#demo-form2').parsley().isValid()) {
            $('.bs-callout-info').removeClass('hidden');
            $('.bs-callout-warning').addClass('hidden');
          } else {
            $('.bs-callout-info').addClass('hidden');
            $('.bs-callout-warning').removeClass('hidden');
          }
        };
      });
      try {
        hljs.initHighlightingOnLoad();
      } catch (err) {}
    </script>
    <!-- /Parsley -->

    <!-- Autosize -->
    <script>
      $(document).ready(function() {
        autosize($('.resizable_textarea'));
      });
    </script>
    <!-- /Autosize -->

        <script>
      $(document).ready(function() {
          
         //$('#noteinfo_'+reqId).tooltip('hide').attr('data-original-title', info).tooltip('show');
         //$('#noteinfo_'+reqId).delay(2000).tooltip('hide');  
         //tooltip
         //$('btn[title]').tooltip({
         //   container: 'body'
         // });
          $(function () {
            $('[data-toggle="tooltip"]').tooltip();
            $('[data-toggle="tooltip"]').tooltip('hide').attr('data-original-title', info).tooltip('show');
            $('[data-toggle="tooltip"]').delay(2000).tooltip('hide');  
          });
          
       
        $('#data_inizio_campagna').daterangepicker({            
          singleDatePicker: true,
          singleClasses: "picker_3",
                locale: {
                    format: "DD/MM/YYYY"
                }
            }, function(start, end, label) {
              console.log(start.toISOString(), end.toISOString(), label);
            });

          });
      
      
    </script>
    



</body>
</html>