             
<!-- footer content -->
<footer>
  <div class="pull-right">

    <a href="mailto:ignazio.toto.fullsystem@windtre.it?Subject=Segnalazioni%20e%20Consigli" target="_top" title="Invia mail">
      Tool Campaign - Powered by Device Engineering </a>
    <?php #print_r($_SESSION); 
    ?>
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
<script src="./vendors/datatables.net-responsive/js/buttons.colVis.min.js"></script>
<script src="./node_modules/datatables.net-fixedcolumns/js/dataTables.fixedColumns.min.js"></script>
<!--
<script type="text/javascript" src="DataTables/datatables.min.js"></script>


<script type="text/javascript" src="./node_modules/xlsx/dist/shim.min.js"></script>
<script src="./node_modules/xlsx/xlsx.mini.js"></script>-->

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
<!-- /Parsley -->
<script src="node_modules/parsleyjs/dist/parsley.min.js"></script>
<script src="node_modules/parsleyjs/dist/i18n/it.js"></script>
<script src="node_modules/parsleyjs/dist/i18n/it.extra.js"></script>
<!-- my JS -->
<script src="javascript_controlla_form_insert.js"></script>


<!-- Initialize the plugin: -->
<script type="text/javascript">
  $(document).ready(function() {

    var selected_stacks = $('#stacks').val();
    var selected_squads = $('#squads').val();
    var selected_states = $('#states').val();
    var selected_channels = $('#channels').val();
    var selected_typologies = $('#typologies').val();
    var selected_sprint = $('#sprints').val();
    var canale_zero = $('#channel_ins').val();
    var stato = null;
    var change_typologies = 0;
    var change_stacks = 0;
    var change_squads = 0;
    var change_channels = 0;
    var change_states = 0;
    var table_pianificazione = $('#datatable-pianificazione').DataTable();
    <?php 
  //print_r($_SERVER['REQUEST_URI']); 
      $datatable = 'pianificazione';
      if(isset($_GET['page']) && $_GET['page']=='gestioneCampagne2'){
        $datatable = 'gestione';
      }
      elseif(isset($_GET['page']) && $_GET['page']=='gestioneStato'){
        $datatable = 'gestioneStato';
      }
    ?>
    var datatable_name = '<?php echo $datatable; ?>';
    

    

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

      
      onChange: function(option, checked) {

        change_stacks = 1;
      },
        onDeselectAll: function(option, checked) {

        change_stacks = 1;
      },
        onSelectAll: function(option, checked) {

        change_stacks = 1;
      },
      
      onDropdownHide: function(option, checked) {
        if(change_stacks){
            selected_stacks = $('#stacks').val();
            change_stacks = 0;
            campagnTable();
        }
        
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
      
      onChange: function(option, checked) {

        change_channels = 1;
      },
      onDeselectAll: function(option, checked) {

        change_channels = 1;
      },
        onSelectAll: function(option, checked) {

        change_channels = 1;
      },
      onDropdownHide: function(option, checked) {
        if(change_channels){
            selected_channels = $('#channels').val();
            change_channels = 0;
            campagnTable();
        }
        
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
      
      onChange: function(option, checked) {

        change_squads = 1;
      },
      onDeselectAll: function(option, checked) {

        change_squads = 1;
      },
        onSelectAll: function(option, checked) {

        change_squads = 1;
      },
      onDropdownHide: function(option, checked) {
        if(change_squads){
            selected_squads = $('#squads').val();
            change_squads = 0;
            campagnTable();
        }
        
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
      
      onChange: function(option, checked) {

        change_states = 1;
      },
      onDeselectAll: function(option, checked) {

        change_states = 1;
      },
        onSelectAll: function(option, checked) {

        change_states = 1;
      },
      onDropdownHide: function(option, checked) {
        if(change_states){
            selected_states = $('#states').val();
            change_states = 0;
            campagnTable();
        }
        
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
      
      onChange: function(option, checked) {

        change_typologies = 1;
      },
      onDeselectAll: function(option, checked) {

        change_typologies = 1;
      },
        onSelectAll: function(option, checked) {

        change_typologies = 1;
      },
      onDropdownHide: function(option, checked) {
        if(change_typologies){
            selected_typologies = $('#typologies').val();
            change_typologies = 0;
            campagnTable();
            
        }
        
      }
    });




    $('#stack_ins').select2({
      placeholder: "Select Stack"
      // allowClear: true
    });


    $('#stack_ins').on('select2:select', function() {
      var selected_stacks = $('#stack_ins').val();
      console.log('stack  ' + selected_stacks);
/*
      $.ajax({
        url: "selectStack.php",
        method: "POST",
        data: {
          stack_id: selected_stacks
        },
        //dataType:"html",    
        success: function(data) {
          $("#type_ins").fadeOut();
          $("#type_ins").fadeIn();
          $("#type_ins").html(data);

        }

      });
      */
      $(this).parsley().validate();
    });

    $('#senders_ins').select2({
      placeholder: "Select Sender",
      allowClear: true
    });
    $('#senders_ins').on('select2:select', function() {
      var selected_stacks = $('#senders_ins').val();
      $(this).parsley().validate();
      console.log('sender  ' + selected_stacks);
    });

    $('#channel_ins').select2({
      placeholder: "Select Canale",
      //$('.select2-selection').css('background-color', 'blue');
      // allowClear: true
   });
    //$('#channel_ins').css('background-color', 'blue');
    $('#channel_ins').on('select2:select', function() {
      canale_0 = $('#channel_ins').val();
      document.getElementById("canale_zero").value = canale_0;
      
      $(this).parsley().validate();
      console.log('channel_ins canale zero  ' + canale_0);

    });

    $('#cat_sott_ins').select2({
      placeholder: "Select",
      allowClear: true
    });
    $('#cat_sott_ins').on('select2:select', function() {
      var selected_stacks = $('#cat_sott_ins').val();
      $(this).parsley().validate();
      console.log('cat_sott_ins  ' + selected_stacks);

    });



    $('#tit_sott_ins').select2({
      placeholder: "Select",
      allowClear: true
    });
    $('#tit_sott_ins').on('select2:select', function() {
      var selected_stacks = $('#tit_sott_ins').val();
      $(this).parsley().validate();
      console.log('tit_sott_ins  ' + selected_stacks);
    });




    $('#moda_ins').select2({
      placeholder: " Select"
    });
    $('#moda_ins').on('select2:select', function() {
      var selected_moda = $('#moda_ins').val();
      $(this).parsley().validate();
      console.log('moda_ins  ' + selected_moda);

    });
    

    $('#cate_ins').select2({
      placeholder: " Select"
    });
  
    $('#cate_ins').on('select2:select', function() {
      var selected_cate = $('#cate_ins').val();
      $(this).parsley().validate();
      console.log('cate_ins  ' + selected_cate);

    });

    $('#squad_ins').select2({
      placeholder: "Select Squad",
      allowClear: true
    });

    $('#squad_ins').on('select2:select', function() {
      var selected_stacks = $('#squad_ins').val();
      $(this).parsley().validate();
      console.log('squad  ' + selected_stacks);

    });

    //select Tipo in Tab Canale
    $('#idlevaselect').select2({
      placeholder: "Select Type"
    });
    $('#idlevaselect').on('select2:select', function() {
      //var selected_stacks = $('#idlevaselect').val();
      $(this).parsley().validate();
      console.log(' idlevaselect ' + $('#idlevaselect').val());
      if($( "#idlevaselect" ).val()==='mono'){
        $('#monoleva').show();
        $('#opzione_leva').attr('required', true); 
        $('#multileva').hide();
        $('#dropzone-canale').attr('required', false);
    }else if($( "#idlevaselect" ).val()==='multi'){
        $('#monoleva').hide();
        $('#multileva').show();
        $('#dropzone-canale').attr('required', true);
        $('#opzione_leva').attr('required', false);
    }
    else{
        $('#monoleva').hide();
        $('#multileva').hide();  
        $('#dropzone-canale').attr('required', false);
        $('#opzione_leva').attr('required', false);
    }

    });

    $('#type_ins').select2({
      placeholder: "Select Type"
    });
    
    $('#type_ins').on('select2:select', function() {
      var selected_type = $('#type_ins').val();
      $(this).parsley().validate();
      console.log('type_ins  ' + selected_type);
      /*
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
          */
    });


    $('#offer_ins').select2({
      placeholder: "Select Offer",
      allowClear: true
    });
    $('#offer_ins').on('select2:select', function() {
      var selected_offer_id = $('#offer_ins').val();
      $(this).parsley().validate();
      console.log('offer  ' + selected_offer_id);
    });


    


    function campagnTable() {
      console.log('startdate in camp ' + select_startDate);
      console.log('enddate in camp ' + select_endDate);
      console.log('sprint inside camp ' + selected_sprint);

      $("#content_response").fadeOut();
      //$('.loader').show();
      $.ajax({
        url: "get_Filter.php",
        method: "POST",
        data: {
          sprint: selected_sprint,
          startDate: select_startDate,
          endDate: select_endDate,
          selected_stacks: selected_stacks,
          selected_squads: selected_squads,
          selected_states: selected_states,
          selected_channels: selected_channels,
          selected_typologies: selected_typologies,
          datatable: datatable_name,
        },
        dataType:"html",    
        success: function(data) {
          $("#content_response").fadeOut();
          $("#content_response").fadeIn();
          $("#content_response").html(data);
          //$('.loader').hide();
          dataTable();
          
        },
        error: function(data) {
          console.log('An error occurred.');
          console.log(data);
        }
      });
    }

    function dataTable() {
      console.log('startdate in camp ' + select_startDate);
      console.log('enddate in camp ' + select_endDate);
      console.log('sprint inside camp ' + selected_sprint);

      $("#datatable-pianificazione").fadeOut();
      //$('.loader').show();
      
          $("#datatable-pianificazione").fadeOut();
          $("#datatable-pianificazione").fadeIn();
          
          //$('.loader').hide();
          var table_pianificazione = $('#datatable-pianificazione').DataTable({                      
            processing: true,
            language: {processing: '<img src="images/ajax.gif">'},                       
            //serverSide: true,
            //searching: true,
            filter: true, 
            // info: true,
            ajax: {
                url: "get_FilterData.php?datatable="+datatable_name,
                data: {
                    sprint: selected_sprint,
                    startDate: select_startDate,
                    endDate: select_endDate,
                    selected_stacks: selected_stacks,
                    selected_squads: selected_squads,
                    selected_states: selected_states,
                    selected_channels: selected_channels,
                    selected_typologies: selected_typologies,
                    datatable: datatable_name,
                },
                type: "POST"
            },
            deferRender: true,
            // senza tfoot
            // scrollY: "430px",
            // con tfoot
            scrollY: "400px",            
            //orderClasses: false,
            //scrollY: '50vh',
            
            scrollX: true,
            scrollCollapse: true,
            paging: false,
            dom: 'Bfrtip',                                    
            buttons: [
            {              
              extend: 'colvis',
              className: 'btn-xs btn-primary',
              text: '<i class="fa fa-table"></i> Vista Colonne', 
              titleAttr: 'Seleziona le colonne da visualizzare', 
            }
          
          ],

            columnDefs: [
                             
                { 
                    
                  targets: 0,
                  searchable: false,
                  orderable: false,  
                  data: null,
                  //defaultContent: "<button class=\"btn btn-xs btn-primary\" type=\"submit\" onclick=\"manageCamp('1', 'modifica','1')\"  data-placement=\"bottom\" data-toggle=\"tooltip\" data-original-title=\"Modifica\" title=\"Modifica\"><i class=\"fa fa-edit\" ></i></button><button class=\"btn btn-xs btn-default\" type=\"submit\" onclick=\"manageCamp('id1','duplica','pemission')\"  data-placement=\"bottom\" data-toggle=\"tooltip\" data-original-title=\"Duplica\" title=\"Duplica\"><i class=\"fa fa-clone\" ></i></button><button class=\"btn btn-xs btn-danger\" type=\"submit\" onclick=\"manageCamp('id','elimina','perm','stato_elimina')\"  data-placement=\"bottom\" data-toggle=\"tooltip\" data-original-title=\"Elimina\" title=\"Elimina\"><i class=\"fa fa-trash-o\"></i></button>",
                  defaultContent: "<button id=\"button-modifica\" class=\"btn btn-xs btn-primary\"  data-placement=\"bottom\" data-toggle=\"tooltip\" data-original-title=\"Modifica\" title=\"Modifica\"><i class=\"fa fa-edit\" ></i></button><button id=\"button-duplica\" class=\"btn btn-xs btn-default\"   data-placement=\"bottom\" data-toggle=\"tooltip\" data-original-title=\"Duplica\" title=\"Duplica\"><i class=\"fa fa-clone\" ></i></button><button id=\"button-elimina\" class=\"btn btn-xs btn-danger\" data-placement=\"bottom\" data-toggle=\"tooltip\" data-original-title=\"Elimina\" title=\"Elimina\"><i class=\"fa fa-trash-o\"></i></button>",
                  
                  
              },
              {      
                  targets: 1,                   
                  searchable: false,                  
                  // orderable: false,
                  visible: false,
              },
     
                           
            ],
          
            order: [1, 'asc'],            
            ordering: <?php if($datatable=="pianificazione") {echo "false";} elseif($datatable=="gestione"){echo "true";}else{echo "true";}?>,
            // ordering: true,

           rowCallback:  function(row, data, index, column) {
             if(datatable_name=='pianificazione'){
                    stato = data[11];   
                    $(row).children('td').each( (col, td) => {
                        //console.log('quaaaa ' +table_pianificazione.column( col ).header().textContent);
                        // Sun columns
                        var substring = "Sun";
                        if(table_pianificazione.column( col+1).header().textContent.indexOf(substring) !== -1){
                            $(td).css('background-color', 'gray');
                        }
                        // Column Vol(K)
                        if(col==11){
                            $(td).css('font-weight',  'bold');
                            $(td).css('color', 'black');
                        }
                        if(stato === 'ESEGUITA'){
                          if(col>11 && $(td).text() !=''){
                              //$('td', row).css('background-color', 'green');
                              $(td).css('background-color', 'lime');
                              $(td).css('font-weight',  'bold');
                              $(td).css('color', 'black');
                          }
                        }
                        else if(stato === 'RICHIESTA'){
                          if(col>11 && $(td).text() !=''){
                              //$('td', row).css('background-color', 'green');
                              $(td).css('background-color', 'red');
                              $(td).css('font-weight',  'bold');
                              $(td).css('color', 'black');
                              //$(row).find('td:eq('+col+')').css('background-color', 'green');
                          }
                        }
                        else if(stato === 'LAVORABILE'){
                          if(col>11 && $(td).text() !=''){
                              //$('td', row).css('background-color', 'green');
                              $(td).css('background-color', 'cyan');
                              $(td).css('font-weight',  'bold');
                              $(td).css('color', 'black');
                              //$(row).find('td:eq('+col+')').css('background-color', 'green');
                          }
                        }
                        else if(stato === 'CONFERMATA'){
                          if(col>11 && $(td).text() !=''){
                              //$('td', row).css('background-color', 'green');
                              $(td).css('background-color', 'yellow');
                              $(td).css('font-weight',  'bold');
                              $(td).css('color', 'black');
                              //$(row).find('td:eq('+col+')').css('background-color', 'green');
                          }
                        }
                        // Last Row Totale
                        else if(stato === 'Totale'){
                            if(col==0){
                                $('td:eq(0)', row).html( '' );
                                //$('td', row).css('background-color', 'green');
                                //$(td).css('background-color', 'yellow');

                                //$(row).find('td:eq('+col+')').css('background-color', 'green');
                            }
                            else if(col>11){
                                $(td).css('font-weight',  'bold');
                                $(td).css('color', 'black');
                            }

                        }
                        else{
                            if(col>11 && $(td).text() !=''){
                                //$('td', row).css('background-color', 'green');
                                //$(td).css('background-color', 'yellow');
                                //$(td).css('', 'black');                                
                                $(td).css('font-weight',  'bold');
                                $(td).css('color', 'black');
                                //$(row).find('td:eq('+col+')').css('background-color', 'green');
                            }
                        }
                        
                        //console.log( '[' +index+ ',' +col+ '] => ' + $(td).text());                        
                      });  

                      
                    }
              },
          //rendering row footer with total          
          footerCallback: function(row, data, start, end, display) {
              var api = this.api();
            
              api.columns('.sum', {
                page: 'current'
              }).every(function() {
                var sum = this
                  .data()
                  .reduce(function(a, b) {
                    var x = parseFloat(a.toString().replace('.','')) || 0;
                    var y = parseFloat(b.toString().replace('.','')) || 0;
                    return x + y;
                  }, 0);
                //console.log("somma "+sum); //alert(sum);
                $(this.footer()).html(sum.toLocaleString('it-IT'));
              });
              
              //console.log('ciclo row ' + row +' data '+ data +' start '+ start +' end '+ end)
              document.getElementById('conteggio_righe').textContent = '   filtrate n°' + end + '';
              
            }           
                                      
         
      });


       $('#datatable-pianificazione tbody').on( 'click', '#button-modifica', function () {
            var data = table_pianificazione.row( $(this).parents('tr') ).data();
            action = data[0].split("_");
            //manageCamp(id, 'modifica',permesso,stato_elimina);
            manageCamp(action[0], 'modifica',action[1]);
            // alert( action[0] +"  modifica : "+ action[1] );
        } );
      $('#datatable-pianificazione tbody').on( 'click', '#button-duplica', function () {
            var data = table_pianificazione.row( $(this).parents('tr') ).data();
            action = data[0].split("_");
            //manageCamp(id, 'modifica',permesso,stato_elimina);
            manageCamp(action[0], 'duplica',action[1]);                        
        } );
      $('#datatable-pianificazione tbody').on( 'click', '#button-elimina', function () {
            var data = table_pianificazione.row( $(this).parents('tr') ).data();
            action = data[0].split("_");
            //manageCamp(id, 'modifica',permesso,stato_elimina);
            manageCamp(action[0], 'elimina', action[1], action[2]);                      
        } );    
     $('#datatable-pianificazione tbody').on( 'click', '#button-open', function () {
            var data = table_pianificazione.row( $(this).parents('tr') ).data();            
            action = data[0].split("_");
            //manageCamp(id, 'modifica',permesso,stato_elimina);
            manageCamp(action[0], 'open');
        } ); 
    
    
}

    // bootstrap-daterangepicker     
    moment.locale('it');
    moment().format('LL');
    // valori iniziali se session vuota
    //var select_startDate = moment().startOf('month').format('YYYY-MM-DD');
    //var select_endDate = moment().endOf('month').format('YYYY-MM-DD');     
    // valori di session 
    
   var select_startDate = '<?php if (isset($_SESSION['filter']['startDate'])) {
                              echo $_SESSION['filter']['startDate'];
                            } else {
                              echo date('Y-m-01');
                            } ?>';
    var select_endDate = '<?php if (isset($_SESSION['filter']['endDate'])) {
                            echo $_SESSION['filter']['endDate'];
                          } else {
                            echo date('Y-m-t');
                          } ?>';
                          
    $('#reportrange_right span').html(moment(select_startDate, 'D MMMM, YYYY') + ' - ' + moment(select_endDate, 'D MMMM, YYYY'));

    var cb = function(start, end, label) {
      console.log(start.toISOString(), end.toISOString(), label);
      $('#reportrange_right span').html(start.format('D MMMM, YYYY') + ' - ' + end.format('D MMMM, YYYY'));
    };
    var optionSet1 = {
      startDate: moment().startOf('month').format('DD/MM/YYYY'),
      endDate: moment().endOf('month').format('DD/MM/YYYY'),
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
      },
      ranges: {
        'Oggi': [moment(), moment()],
        'Ieri': [moment().subtract(1, 'days'), moment().subtract(1, 'days')],
        'Domani': [moment().add(1, 'days'), moment().add(1, 'days')],
        'Ultimi 7 giorni': [moment().subtract(6, 'days'), moment()],
        'Ultimi 30 giorni': [moment().subtract(29, 'days'), moment()],
        'Settimana corrente': [moment().startOf('isoWeek'), moment().endOf('isoWeek')],
        'Settimana prossima': [moment().add(1, 'Week').startOf('isoWeek'), moment().add(1, 'Week').endOf('isoWeek')],
        'Mese precedente': [moment().subtract(1, 'month').startOf('month'), moment().subtract(1, 'month').endOf('month')],
        'Mese corrente': [moment().startOf('month'), moment().endOf('month')],
        'Mese successivo': [moment().add(1, 'month').startOf('month'), moment().add(1, 'month').endOf('month')]
        
      },
    };

    //solo al primo caricamento
    campagnTable();
    $('#reportrange_right span').html(select_startDate + ' - ' + select_endDate);
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
      

      //$('#sprints').select2('val', ' ');
      $('#sprints').select2({
        placeholder: " Select a Sprint",
        allowClear: true,
        ajax: ({
          url: "get_sprints.php",
          dataType: 'json',
          delay: 10,
          method: "POST",
          data: {
            startDate: select_startDate,
            endDate: select_endDate,
            sprint: $('#sprint').val,
          },
          //dataType:"html",    
          success: function(data) {
            console.log('sprints dentro ' + JSON.stringify(data));
            data: data;
            //$("#select2").select2({width: 300});
          }
        })
      });
      campagnTable();
    });
    $('#reportrange_right').on('cancel.daterangepicker', function(ev, picker) {
      console.log("cancel event fired");
    });


    $('#destroy').click(function() {
      $('#reportrange_right').data('daterangepicker').remove();
    });

    $('#sprints').select2({
      placeholder: " Select a Sprint",
      allowClear: true,
      ajax: ({
        url: "get_sprints.php",
        dataType: 'json',
        //delay: 10,
        method: "POST",
        data: {
          startDate: select_startDate,
          endDate: select_endDate
        },
        //dataType:"html",    
        success: function(data) {
          console.log(' Start select degli sprints ' + JSON.stringify(data)); 
        }
      })

    });
    $('#sprints').on('select2:unselecting', function() {
      selected_sprint = '';
      console.log('sprints cancellato  ' + selected_sprint);
      campagnTable();

    });
    $('#sprints').on('select2:select', function() {
      selected_sprint = $('#sprints').val();
      console.log('sprints  ' + selected_sprint);
      campagnTable();

    });


  });
</script>


<!-- Autosize -->
<script src="vendors/autosize/dist/autosize.min.js"></script>
<!-- Autosize -->
<script>
  $(document).ready(function() {
    autosize($('.resizable_textarea'));

    var min_data_offerta = moment().format('DD/MM/YYYY');

    $("body").tooltip({
      selector: '[data-toggle=tooltip]'
    });

    //console.log('stato '+ stato);
    //highlither_min_required();

    if (typeof stato != "undefined"){
        console.log('stato letto nel footer '+ stato);
        highlither_min_required(stato);
    }

    $('#data_inizio_campagna').daterangepicker({
      singleDatePicker: true,
      singleClasses: "picker_3",
      /*
      locale: {
        format: "DD/MM/YYYY"
      }
      */
      format: "DD/MM/YYYY",
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
    }, function(start, end, label) {
          console.log('data_inizio_campagna '+start.toISOString(), end.toISOString(), label);   
          //$('#data_fine_validita_offerta').destroy();       
          //$('#data_fine_validita_offerta').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
          $('#data_fine_validita_offerta').data('daterangepicker').minDate = start;
          //min_data_offerta = start.format('DD/MM/YYYY');

          if (document.getElementById('nomecampagna').value.length > 0) {
            const pref_nome_campagna = document.getElementById('nomecampagna').value;
            const myarr = pref_nome_campagna.split("_");
            data_label = myarr[0];
            if (myarr[1])
                squad_label = "_" + myarr[1];
            if (myarr[2])    
             channel_label = "_" + myarr[2];
            if (myarr[3])
             type_label = "_" + myarr[3];

            note_label = '_'+document.getElementById('note_camp').value;
            
            document.getElementById('nomecampagna').value = moment(start.toISOString()).format('YYYYMMDD') + squad_label + channel_label + type_label + note_label;
            
        }
        else{
            document.getElementById('nomecampagna').value = moment(start.toISOString()).format('YYYYMMDD');
        }
      
      
    });

    $('#data_fine_validita_offerta').daterangepicker({
      
      minDate: $('#data_inizio_campagna').data('daterangepicker').startDate,
      //startDate: min_data_offerta,
      singleDatePicker: true,
      singleClasses: "picker_3",
      format: "DD/MM/YYYY",
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
    }, function(start, end, label) {
          console.log('data_fine_validita_offerta '+ start.toISOString(), end.toISOString(), label);
          $('#data_fine_validita_offerta').data('daterangepicker').setStartDate(start.format('DD/MM/YYYY'));
    });


  });


        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

// iCheck
$(document).ready(function() {
    if ($("input.flat")[0]) {
        $(document).ready(function () {
            $('input.flat').iCheck({
                checkboxClass: 'icheckbox_flat-green',
                radioClass: 'iradio_flat-green'
            });
        });
    }
});
// /iCheck

// Table
$('datatable-pianificazione input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('datatable-pianificazione input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});

var checkState = '';

$('.bulk_action input').on('ifChecked', function () {
    checkState = '';
    $(this).parent().parent().parent().addClass('selected');
    countChecked();
});
$('.bulk_action input').on('ifUnchecked', function () {
    checkState = '';
    $(this).parent().parent().parent().removeClass('selected');
    countChecked();
});
$('.bulk_action input#check-all').on('ifChecked', function () {
    checkState = 'all';
    countChecked();
});
$('.bulk_action input#check-all').on('ifUnchecked', function () {
    checkState = 'none';
    countChecked();
});

function countChecked() {
    if (checkState === 'all') {
        $(".bulk_action input[name='table_records']").iCheck('check');
    }
    if (checkState === 'none') {
        $(".bulk_action input[name='table_records']").iCheck('uncheck');
    }

    var checkCount = $(".bulk_action input[name='table_records']:checked").length;

    if (checkCount) {
        $('.column-title').hide();
        $('.bulk-actions').show();
        $('.action-cnt').html(checkCount + ' Records Selected');
    } else {
        $('.column-title').show();
        $('.bulk-actions').hide();
    }
}


$(document).ready(function() {
           
        var table_pianificazione = $('#datatable-pianificazione').DataTable();     
                console.log(' conteggio righe '+ table_pianificazione.rows().count());

                var tot_rows = parseInt(table_pianificazione.rows().count());
                if(tot_rows>0){
                    tot_rows = parseInt(table_pianificazione.rows().count()-1);
                }
                if(document.getElementById('conteggio_righe')){
                    document.getElementById('conteggio_righe').textContent = '   filtrate n°' + tot_rows + '';
                    document.getElementById('datatable-pianificazione_info').textContent = ' Campagne filtrate n°' + tot_rows + '';
                }
            
            $('#datatable-pianificazione tbody').on( 'click', 'button', function () {
            
                var data = table.row( $(this).parents('tr') ).data();
                alert( data[2] +"'s salary is: "+ data[ 5 ] );
            } );
    });


</script>  




</body>

</html>