<!-- footer content -->
<footer>
    <div class="pull-right">
        <a href="https://t-connect.cloud/vendortool/">Device Engineer Tool </a>
    </div>
  
</footer>
<!-- /footer content -->
</div>  <!-- Container body -->      
</div>  <!-- class="main_container -->
 


<!-- jQuery -->
    <script src="./vendors/jquery/dist/jquery.min.js"></script>
    <!-- Bootstrap -->
    <script src="./vendors/bootstrap/dist/js/bootstrap.min.js"></script>
    <!-- FastClick -->
    <script src="./vendors/fastclick/lib/fastclick.js"></script>
    <!-- NProgress -->
    <script src="./vendors/nprogress/nprogress.js"></script>
    <!-- bootstrap-progressbar -->
    <script src="./vendors/bootstrap-progressbar/bootstrap-progressbar.min.js"></script>
    <!-- iCheck -->
    <script src="./vendors/iCheck/icheck.min.js"></script>
    <!-- bootstrap-daterangepicker -->
    <script src="./vendors/moment/min/moment.min.js"></script>
    <script src="./vendors/bootstrap-daterangepicker/daterangepicker.js"></script>
    <!-- bootstrap-wysiwyg -->
    <script src="./vendors/bootstrap-wysiwyg/js/bootstrap-wysiwyg.min.js"></script>
    <script src="./vendors/jquery.hotkeys/jquery.hotkeys.js"></script>
    <script src="./vendors/google-code-prettify/src/prettify.js"></script>
    <!-- jQuery Tags Input -->
    <script src="./vendors/jquery.tagsinput/src/jquery.tagsinput.js"></script>
    <!-- Switchery -->
    <script src="./vendors/switchery/dist/switchery.min.js"></script>
    <!-- Select2 -->
    <script src="./vendors/select2/dist/js/select2.full.min.js"></script>
    <!-- Parsley -->
    <script src="./vendors/parsleyjs/dist/parsley.min.js"></script>
    <!-- Autosize -->
    <script src="./vendors/autosize/dist/autosize.min.js"></script>
    <!-- jQuery autocomplete -->
    <script src="./vendors/devbridge-autocomplete/dist/jquery.autocomplete.min.js"></script>
    <!-- starrr -->
    <script src="./vendors/starrr/dist/starrr.js"></script>
    
    
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
<!-- Custom Theme Scripts -->
    <script src="./build/js/custom.min.js"></script>

    <!-- bootstrap-daterangepicker -->
    <script>
      $(document).ready(function() {
        $('#birthday').daterangepicker({
          singleDatePicker: true,
          calender_style: "picker_4"
        }, function(start, end, label) {
          console.log(start.toISOString(), end.toISOString(), label);
        });
      });
    </script>
    <!-- /bootstrap-daterangepicker -->

    <!-- bootstrap-wysiwyg -->
    <script>
      $(document).ready(function() {
        function initToolbarBootstrapBindings() {
          var fonts = ['Serif', 'Sans', 'Arial', 'Arial Black', 'Courier',
              'Courier New', 'Comic Sans MS', 'Helvetica', 'Impact', 'Lucida Grande', 'Lucida Sans', 'Tahoma', 'Times',
              'Times New Roman', 'Verdana'
            ],
            fontTarget = $('[title=Font]').siblings('.dropdown-menu');
          $.each(fonts, function(idx, fontName) {
            fontTarget.append($('<li><a data-edit="fontName ' + fontName + '" style="font-family:\'' + fontName + '\'">' + fontName + '</a></li>'));
          });
          $('a[title]').tooltip({
            container: 'body'
          });
          $('.dropdown-menu input').click(function() {
              return false;
            })
            .change(function() {
              $(this).parent('.dropdown-menu').siblings('.dropdown-toggle').dropdown('toggle');
            })
            .keydown('esc', function() {
              this.value = '';
              $(this).change();
            });

          $('[data-role=magic-overlay]').each(function() {
            var overlay = $(this),
              target = $(overlay.data('target'));
            overlay.css('opacity', 0).css('position', 'absolute').offset(target.offset()).width(target.outerWidth()).height(target.outerHeight());
          });

          if ("onwebkitspeechchange" in document.createElement("input")) {
            var editorOffset = $('#editor').offset();

            $('.voiceBtn').css('position', 'absolute').offset({
              top: editorOffset.top,
              left: editorOffset.left + $('#editor').innerWidth() - 35
            });
          } else {
            $('.voiceBtn').hide();
          }
        }

        function showErrorAlert(reason, detail) {
          var msg = '';
          if (reason === 'unsupported-file-type') {
            msg = "Unsupported format " + detail;
          } else {
            console.log("error uploading file", reason, detail);
          }
          $('<div class="alert"> <button type="button" class="close" data-dismiss="alert">&times;</button>' +
            '<strong>File upload error</strong> ' + msg + ' </div>').prependTo('#alerts');
        }

        initToolbarBootstrapBindings();

        $('#editor').wysiwyg({
          fileUploadError: showErrorAlert
        });

        window.prettyPrint;
        prettyPrint();
      });
    </script>
    <!-- /bootstrap-wysiwyg -->

    <!-- Select2 -->
    <script>
      $(document).ready(function() {
        $(".select2_single").select2({
          placeholder: "Search value",
          allowClear: true
        });
        $(".select2_group").select2({});
        $(".select2_multiple").select2({
          maximumSelectionLength: 4,
          placeholder: "With Max Selection limit 4",
          allowClear: true
        });
      });
    </script>
    <!-- /Select2 -->

    <!-- jQuery Tags Input -->
    <script>
      function onAddTag(tag) {
        alert("Added a tag: " + tag);
      }

      function onRemoveTag(tag) {
        alert("Removed a tag: " + tag);
      }

      function onChangeTag(input, tag) {
        alert("Changed a tag: " + tag);
      }

      $(document).ready(function() {
        $('#tags_1').tagsInput({
          width: 'auto'
        });
      });
    </script>
    <!-- /jQuery Tags Input -->

    <!-- Parsley -->
    <script>
      $(document).ready(function() {
        $.listen('parsley:field:validate', function() {
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
        $.listen('parsley:field:validate', function() {
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

    <!-- jQuery autocomplete -->
    <script>
      $(document).ready(function() {
        var countries = { AD:"Andorra",A2:"Andorra Test",AE:"United Arab Emirates",AF:"Afghanistan",AG:"Antigua and Barbuda",AI:"Anguilla",AL:"Albania",AM:"Armenia",AN:"Netherlands Antilles",AO:"Angola",AQ:"Antarctica",AR:"Argentina",AS:"American Samoa",AT:"Austria",AU:"Australia",AW:"Aruba",AX:"Åland Islands",AZ:"Azerbaijan",BA:"Bosnia and Herzegovina",BB:"Barbados",BD:"Bangladesh",BE:"Belgium",BF:"Burkina Faso",BG:"Bulgaria",BH:"Bahrain",BI:"Burundi",BJ:"Benin",BL:"Saint Barthélemy",BM:"Bermuda",BN:"Brunei",BO:"Bolivia",BQ:"British Antarctic Territory",BR:"Brazil",BS:"Bahamas",BT:"Bhutan",BV:"Bouvet Island",BW:"Botswana",BY:"Belarus",BZ:"Belize",CA:"Canada",CC:"Cocos [Keeling] Islands",CD:"Congo - Kinshasa",CF:"Central African Republic",CG:"Congo - Brazzaville",CH:"Switzerland",CI:"Côte d’Ivoire",CK:"Cook Islands",CL:"Chile",CM:"Cameroon",CN:"China",CO:"Colombia",CR:"Costa Rica",CS:"Serbia and Montenegro",CT:"Canton and Enderbury Islands",CU:"Cuba",CV:"Cape Verde",CX:"Christmas Island",CY:"Cyprus",CZ:"Czech Republic",DD:"East Germany",DE:"Germany",DJ:"Djibouti",DK:"Denmark",DM:"Dominica",DO:"Dominican Republic",DZ:"Algeria",EC:"Ecuador",EE:"Estonia",EG:"Egypt",EH:"Western Sahara",ER:"Eritrea",ES:"Spain",ET:"Ethiopia",FI:"Finland",FJ:"Fiji",FK:"Falkland Islands",FM:"Micronesia",FO:"Faroe Islands",FQ:"French Southern and Antarctic Territories",FR:"France",FX:"Metropolitan France",GA:"Gabon",GB:"United Kingdom",GD:"Grenada",GE:"Georgia",GF:"French Guiana",GG:"Guernsey",GH:"Ghana",GI:"Gibraltar",GL:"Greenland",GM:"Gambia",GN:"Guinea",GP:"Guadeloupe",GQ:"Equatorial Guinea",GR:"Greece",GS:"South Georgia and the South Sandwich Islands",GT:"Guatemala",GU:"Guam",GW:"Guinea-Bissau",GY:"Guyana",HK:"Hong Kong SAR China",HM:"Heard Island and McDonald Islands",HN:"Honduras",HR:"Croatia",HT:"Haiti",HU:"Hungary",ID:"Indonesia",IE:"Ireland",IL:"Israel",IM:"Isle of Man",IN:"India",IO:"British Indian Ocean Territory",IQ:"Iraq",IR:"Iran",IS:"Iceland",IT:"Italy",JE:"Jersey",JM:"Jamaica",JO:"Jordan",JP:"Japan",JT:"Johnston Island",KE:"Kenya",KG:"Kyrgyzstan",KH:"Cambodia",KI:"Kiribati",KM:"Comoros",KN:"Saint Kitts and Nevis",KP:"North Korea",KR:"South Korea",KW:"Kuwait",KY:"Cayman Islands",KZ:"Kazakhstan",LA:"Laos",LB:"Lebanon",LC:"Saint Lucia",LI:"Liechtenstein",LK:"Sri Lanka",LR:"Liberia",LS:"Lesotho",LT:"Lithuania",LU:"Luxembourg",LV:"Latvia",LY:"Libya",MA:"Morocco",MC:"Monaco",MD:"Moldova",ME:"Montenegro",MF:"Saint Martin",MG:"Madagascar",MH:"Marshall Islands",MI:"Midway Islands",MK:"Macedonia",ML:"Mali",MM:"Myanmar [Burma]",MN:"Mongolia",MO:"Macau SAR China",MP:"Northern Mariana Islands",MQ:"Martinique",MR:"Mauritania",MS:"Montserrat",MT:"Malta",MU:"Mauritius",MV:"Maldives",MW:"Malawi",MX:"Mexico",MY:"Malaysia",MZ:"Mozambique",NA:"Namibia",NC:"New Caledonia",NE:"Niger",NF:"Norfolk Island",NG:"Nigeria",NI:"Nicaragua",NL:"Netherlands",NO:"Norway",NP:"Nepal",NQ:"Dronning Maud Land",NR:"Nauru",NT:"Neutral Zone",NU:"Niue",NZ:"New Zealand",OM:"Oman",PA:"Panama",PC:"Pacific Islands Trust Territory",PE:"Peru",PF:"French Polynesia",PG:"Papua New Guinea",PH:"Philippines",PK:"Pakistan",PL:"Poland",PM:"Saint Pierre and Miquelon",PN:"Pitcairn Islands",PR:"Puerto Rico",PS:"Palestinian Territories",PT:"Portugal",PU:"U.S. Miscellaneous Pacific Islands",PW:"Palau",PY:"Paraguay",PZ:"Panama Canal Zone",QA:"Qatar",RE:"Réunion",RO:"Romania",RS:"Serbia",RU:"Russia",RW:"Rwanda",SA:"Saudi Arabia",SB:"Solomon Islands",SC:"Seychelles",SD:"Sudan",SE:"Sweden",SG:"Singapore",SH:"Saint Helena",SI:"Slovenia",SJ:"Svalbard and Jan Mayen",SK:"Slovakia",SL:"Sierra Leone",SM:"San Marino",SN:"Senegal",SO:"Somalia",SR:"Suriname",ST:"São Tomé and Príncipe",SU:"Union of Soviet Socialist Republics",SV:"El Salvador",SY:"Syria",SZ:"Swaziland",TC:"Turks and Caicos Islands",TD:"Chad",TF:"French Southern Territories",TG:"Togo",TH:"Thailand",TJ:"Tajikistan",TK:"Tokelau",TL:"Timor-Leste",TM:"Turkmenistan",TN:"Tunisia",TO:"Tonga",TR:"Turkey",TT:"Trinidad and Tobago",TV:"Tuvalu",TW:"Taiwan",TZ:"Tanzania",UA:"Ukraine",UG:"Uganda",UM:"U.S. Minor Outlying Islands",US:"United States",UY:"Uruguay",UZ:"Uzbekistan",VA:"Vatican City",VC:"Saint Vincent and the Grenadines",VD:"North Vietnam",VE:"Venezuela",VG:"British Virgin Islands",VI:"U.S. Virgin Islands",VN:"Vietnam",VU:"Vanuatu",WF:"Wallis and Futuna",WK:"Wake Island",WS:"Samoa",YD:"People's Democratic Republic of Yemen",YE:"Yemen",YT:"Mayotte",ZA:"South Africa",ZM:"Zambia",ZW:"Zimbabwe",ZZ:"Unknown or Invalid Region" };

        var countriesArray = $.map(countries, function(value, key) {
          return {
            value: value,
            data: key
          };
        });

        // initialize autocomplete with custom appendTo
        $('#autocomplete-custom-append').autocomplete({
          lookup: countriesArray
        });
      });
    </script>
    <!-- /jQuery autocomplete -->

    <!-- Starrr -->
    <script>
      $(document).ready(function() {
        $(".stars").starrr();

        $('.stars-existing').starrr({
          rating: 4
        });

        $('.stars').on('starrr:change', function (e, value) {
          $('.stars-count').html(value);
        });

        $('.stars-existing').on('starrr:change', function (e, value) {
          $('.stars-count-existing').html(value);
        });
      });
    </script>
    <!-- /Starrr -->

<!-- Datatables -->
    <script>
      $(document).ready(function() {
        var handleDataTableButtons = function() {
          if ($("#datatable-buttons").length) {
            $("#datatable-buttons").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },
                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
          
          if ($("#datatable-buttons2").length) {
            $("#datatable-buttons2").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },

                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
          
          if ($("#datatable-buttons1").length) {
            $("#datatable-buttons2").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },

                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
          
          if ($("#datatable-buttons3").length) {
            $("#datatable-buttons3").DataTable({
              dom: "Bfrtip",
              buttons: [
                {
                  extend: "copy",
                  className: "btn-sm"
                },
                {
                  extend: "csv",
                  className: "btn-sm"
                },
                {
                  extend: "excel",
                  className: "btn-sm"
                },

                {
                  extend: "pdfHtml5",
                  className: "btn-sm"
                },
                {
                  extend: "print",
                  className: "btn-sm"
                },
              ],
              responsive: true
            });
          }
          
          
        };

        TableManageButtons = function() {
          "use strict";
          return {
            init: function() {
              handleDataTableButtons();
            }
          };
        }();

        $('#datatable').dataTable();

        $('#datatable-keytable').DataTable({
          keys: true
        });

        $('#datatable-responsive').DataTable();

        $('#datatable-scroller').DataTable({
          ajax: "js/datatables/json/scroller-demo.json",
          deferRender: true,
          scrollY: 380,
          scrollCollapse: true,
          scroller: true
        });

        $('#datatable-fixed-header').DataTable({
          fixedHeader: true
        });

        var $datatable = $('#datatable-checkbox');

        $datatable.dataTable({
          'order': [[ 1, 'asc' ]],
          'columnDefs': [
            { orderable: false, targets: [0] }
          ]
        });
        $datatable.on('draw.dt', function() {
          $('input').iCheck({
            checkboxClass: 'icheckbox_flat-green'
          });
        });

        TableManageButtons.init();
      });
    </script>
    
    
<script data-main="./vendors/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect/dist/js/" src="./vendors/jQuery-Multiple-Select-Plugin-For-Bootstrap-Bootstrap-Multiselect/dist/js/require.min.js"></script>        
<script type="text/javascript" defer>
require(['bootstrap-multiselect'], function(purchase){
    //Devicetype
        $('#first_level').multiselect({
          
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All typologies',
            selectAllName: 'select-all-typology',
            buttonWidth: '250px',
            
            onSelectAll: function() {
              event.preventDefault();
                $('#second_level').html('');
                $('#second_level').multiselect('rebuild');
                $('#third_level').html('');
                $('#third_level').multiselect('rebuild');
                $('#rfilist_level').html('');
                $('#rfilist_level').multiselect('rebuild');
	        $('#submitfilter').prop('disabled', true);
                $("#content_response").fadeOut();										  
  
                var selected_devicetype = this.$select.val();
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_second_level.php",
                  method:"POST",
                  data:{selected:selected_devicetype},
                  success:function(data)
                  {
                   $('#second_level').html(data);
                   $('#second_level').multiselect('rebuild');
                   
                  }
                 });
                }              
            },            
            onDeselectAll: function() {
              event.preventDefault();
                $('#second_level').html('');
                $('#second_level').multiselect('rebuild');
                $('#third_level').html('');
                $('#third_level').multiselect('rebuild');
                $('#rfilist_level').html('');
                $('#rfilist_level').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);								 
            },
            
            onChange:function(option, checked){
              event.preventDefault();
                $('#second_level').html('');
                $('#second_level').multiselect('rebuild');
                $('#third_level').html('');
                $('#third_level').multiselect('rebuild');
                $('#rfilist_level').html('');
                $('#rfilist_level').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
  
                var selected_devicetype = this.$select.val();
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_second_level.php",
                  method:"POST",
                  data:{selected:selected_devicetype},
                  success:function(data)
                  {
                   $('#second_level').html(data);
                   $('#second_level').multiselect('rebuild');
                   
                  }
                 });
                }
               }    
            
        });
        $('#first_level_test').multiselect({
          
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            enableFiltering: true,
            includeSelectAllOption: true,
            enableSelecetAll: true,
            allSelectedText: 'All typologies',
            selectAllName: 'select-all-typology',
            buttonWidth: '250px',
            
            onSelectAll: function() {
              event.preventDefault();
                $('#second_level_test').html('');
                $('#second_level_test').multiselect('rebuild');
                $('#third_level_test').html('');
                $('#third_level_test').multiselect('rebuild');
                $('#rfilist_level_test').html('');
                $('#rfilist_level_test').multiselect('rebuild');
	        $('#submitfilter').prop('disabled', true);
                $("#content_response").fadeOut();										  
  
                var selected_devicetype = this.$select.val();
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_second_level_test.php",
                  method:"POST",
                  data:{selected:selected_devicetype},
                  success:function(data)
                  {
                   $('#second_level_test').html(data);
                   $('#second_level_test').multiselect('rebuild');
                   
                  }
                 });
                }              
            },            
            onDeselectAll: function() {
              event.preventDefault();
                $('#second_level_test').html('');
                $('#second_level_test').multiselect('rebuild');
                $('#third_level_test').html('');
                $('#third_level_test').multiselect('rebuild');
                $('#rfilist_level_test').html('');
                $('#rfilist_level_test').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);								 
            },
            
            onChange:function(option, checked){
              event.preventDefault();
                $('#second_level_test').html('');
                $('#second_level_test').multiselect('rebuild');
                $('#third_level_test').html('');
                $('#third_level_test').multiselect('rebuild');
                $('#rfilist_level_test').html('');
                $('#rfilist_level_test').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
  
                var selected_devicetype = this.$select.val();
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_second_level_test.php",
                  method:"POST",
                  data:{selected:selected_devicetype},
                  success:function(data)
                  {
                   $('#second_level_test').html(data);
                   $('#second_level_test').multiselect('rebuild');
                   
                  }
                 });
                }
               }    
            
        });
    });
        
</script>

<script type="text/javascript" defer>
require(['bootstrap-multiselect'], function(purchase){
    //Years of Projets
        $('#second_level').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,           
            allSelectedText: 'All Years',
            selectAllName: 'select-all-year',
            
            onSelectAll: function() {
                $('#third_level').html('');
                $('#third_level').multiselect('rebuild');
				        $('#submitfilter').prop('disabled', true);
                $("#content_response").fadeOut();										  
  
                var selected_years = this.$select.val();
                var select_first = $('#first_level').val();
                
              
                if(selected_years.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_third_level.php",
                  method:"POST",                  

                  data:{selected_years:selected_years,select_first:select_first},
                  success:function(data)
                  {
                   $('#third_level').html(data);
                   $('#third_level').multiselect('rebuild');
                  }
                 });
                }
               },            
            onDeselectAll: function() {
                $('#third_level').html('');
                $('#third_level').multiselect('rebuild');
				                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);								 
            },

            onChange:function(option, checked){
                $('#third_level').html('');
                $('#third_level').multiselect('rebuild');
				                $('#submitfilter').prop('disabled', true);
                $("#content_response").fadeOut();										  
  
                var selected_years = this.$select.val();
                var select_first = $('#first_level').val();
                
              
                if(selected_years.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_third_level.php",
                  method:"POST",                  

                  data:{selected_years:selected_years,select_first:select_first},
                  success:function(data)
                  {
                   $('#third_level').html(data);
                   $('#third_level').multiselect('rebuild');
                  }
                 });
                }
               }
            

        });
        $('#second_level_test').multiselect({
            enableFiltering: true,
            includeSelectAllOption: true,           
            allSelectedText: 'All Years',
            selectAllName: 'select-all-year',
            
            onSelectAll: function() {
                $('#third_level_test').html('');
                $('#third_level_test').multiselect('rebuild');
				        $('#submitfilter').prop('disabled', true);
                $("#content_response").fadeOut();										  
  
                var selected_years = this.$select.val();
                var select_first = $('#first_level_test').val();
                
              
                if(selected_years.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_third_level_test.php",
                  method:"POST",                  

                  data:{selected_years:selected_years,select_first:select_first},
                  success:function(data)
                  {
                   $('#third_level_test').html(data);
                   $('#third_level_test').multiselect('rebuild');
                  }
                 });
                }
               },            
            onDeselectAll: function() {
                $('#third_level_test').html('');
                $('#third_level_test').multiselect('rebuild');
				                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);								 
            },

            onChange:function(option, checked){
                $('#third_level_test').html('');
                $('#third_level_test').multiselect('rebuild');
				                $('#submitfilter').prop('disabled', true);
                $("#content_response").fadeOut();										  
  
                var selected_years = this.$select.val();
                var select_first = $('#first_level_test').val();
                
              
                if(selected_years.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_third_level_test.php",
                  method:"POST",                  

                  data:{selected_years:selected_years,select_first:select_first},
                  success:function(data)
                  {
                   $('#third_level_test').html(data);
                   $('#third_level_test').multiselect('rebuild');
                  }
                 });
                }
               }
            

        });
        
        
        
    });
</script>


<script type="text/javascript" defer>
require(['bootstrap-multiselect'], function(purchase){
    //Projects List
        $('#third_level').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All Projects checked',
            nonSelectedText: 'No Project selected!',
            //buttonWidth: '400px',
            
           onSelectAll: function() {
                $('#rfilist_level').html('');
                //$('#rfilist_level').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                var selected_rfi = $('#rfilist_level').val();
                if(selected_rfi>0){
                  $('#submitfilter').prop('disabled', false);
                }

                //Prendo i dati dalla prima select DevicetType
                var selected_devicetype = $('#first_level').val();
                                
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_rfilist.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype},
                  success:function(data)
                  {
                   $('#rfilist_level').html(data);
                   $('#rfilist_level').multiselect('rebuild');
                   
                  }
                 });
                }
           },
           onDeselectAll: function() {
                $('#rfilist_level').html('');
                //$('#rfilist_level').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                
            },
           //onchange trigger rfilist_level select 
           onChange:function(option, checked){
                $('#rfilist_level').html('');
                //$('#rfilist_level').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                var selected_rfi = $('#rfilist_level').val();
                    if(selected_rfi>0){
                      $('#submitfilter').prop('disabled', false);
                    }

                //Prendo i dati dalla prima select DevicetType
                var selected_devicetype = $('#first_level').val();
                
                                
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_rfilist.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype},
                  success:function(data)
                  {
                   $('#rfilist_level').html(data);
                   $('#rfilist_level').multiselect('rebuild');
                   var selected_rfi = $('#rfilist_level').val();
                    if(selected_rfi>0){
                      $('#submitfilter').prop('disabled', false);
                    }
                   
                  }
                 });
                }
               }   
                              
        });
        $('#third_level_test').multiselect({
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All Projects checked',
            nonSelectedText: 'No Project selected!',
            //buttonWidth: '400px',
            
           onSelectAll: function() {
                $('#rfilist_level_test').html('');
                //$('#rfilist_level_test').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                var selected_rfi = $('#rfilist_level_test').val();
                if(selected_rfi>0){
                  $('#submitfilter').prop('disabled', false);
                }

                //Prendo i dati dalla prima select DevicetType
                var selected_devicetype = $('#first_level_test').val();
                                
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_rfilist_test.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype},
                  success:function(data)
                  {
                   $('#rfilist_level_test').html(data);
                   $('#rfilist_level_test').multiselect('rebuild');
                   
                  }
                 });
                }
           },
           onDeselectAll: function() {
                $('#rfilist_level_test').html('');
                //$('#rfilist_level_test').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                
            },
           //onchange trigger rfilist_level_test select 
           onChange:function(option, checked){
                $('#rfilist_level_test').html('');
                //$('#rfilist_level_test').multiselect('rebuild');
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                var selected_rfi = $('#rfilist_level_test').val();
                    if(selected_rfi>0){
                      $('#submitfilter').prop('disabled', false);
                    }

                //Prendo i dati dalla prima select DevicetType
                var selected_devicetype = $('#first_level_test').val();
                
                                
                if(selected_devicetype.length > 0)
                {
                 $.ajax({
                  url:"gestioneLSoc/multiselect_rfilist_test.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype},
                  success:function(data)
                  {
                   $('#rfilist_level_test').html(data);
                   $('#rfilist_level_test').multiselect('rebuild');
                   var selected_rfi = $('#rfilist_level_test').val();
                    if(selected_rfi>0){
                      $('#submitfilter').prop('disabled', false);
                    }
                   
                  }
                 });
                }
               }   
                              
        });
    });
        
</script>
<script type="text/javascript" defer>
require(['bootstrap-multiselect'], function(purchase){
    //Requirements List    
        $('#rfilist_level').multiselect({                               
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All Requirements checked',
            nonSelectedText: 'No Requirement selected!',
            buttonWidth: '400px',

            onChange:function(option, checked){
              $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                var selected_projects = $('#third_level').val();
         var selected_rfi = $('#rfilist_level').val();
        if(selected_rfi.length>0 && selected_projects.length>0){ 

                      $('#submitfilter').prop('disabled', false);
                    }
            
            
            },
            onDeselectAll: function() {
                $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                
            },
            onSelectAll:function(option, checked){
              $("#content_response").fadeOut();
                $('#submitfilter').prop('disabled', true);
                var selected_projects = $('#third_level').val();
         var selected_rfi = $('#rfilist_level').val();
        if(selected_rfi.length>0 && selected_projects.length>0){ 

                      $('#submitfilter').prop('disabled', false);
                    }
            
            
            }


        });
        $('#rfilist_level_test').multiselect({                               
            enableClickableOptGroups: true,
            enableCollapsibleOptGroups: true,
            includeSelectAllOption: true,
            enableFiltering: true,
            enableCaseInsensitiveFiltering: true,
            allSelectedText: 'All Requirements checked',
            nonSelectedText: 'No Requirement selected!',
            buttonWidth: '400px',

            onChange:function(option, checked){
              $("#content_response").fadeOut();
                $('#submitfilter_test').prop('disabled', true);
                var selected_projects = $('#third_level_test').val();
         var selected_rfi = $('#rfilist_level_test').val();
        if(selected_rfi.length>0 && selected_projects.length>0){ 

                      $('#submitfilter_test').prop('disabled', false);
                    }
            
            
            },
            onDeselectAll: function() {
                $("#content_response").fadeOut();
                $('#submitfilter_test').prop('disabled', true);
                
            },
            onSelectAll:function(option, checked){
              $("#content_response").fadeOut();
                $('#submitfilter_test').prop('disabled', true);
                var selected_projects = $('#third_level_test').val();
         var selected_rfi = $('#rfilist_level_test').val();
        if(selected_rfi.length>0 && selected_projects.length>0){ 

                      $('#submitfilter_test').prop('disabled', false);
                    }
            
            
            }


        });
          
 
        $('#techsum-select-button').on('click', function(event) {
            event.preventDefault(); 
            var selected_devicetype = $('#first_level').val();
            var rfisubset='techsum';
			      $("#content_response").fadeOut();								 

            $.ajax({
                  url:"gestioneLSoc/get_RfiList.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype,rfisubset:rfisubset},
                  dataType:"json",
                  success:function(data)
                  {
                      $("#rfilist_level").val(data);
                      $("#rfilist_level").multiselect("refresh");
                      $('#submitfilter').prop('disabled', false);
                  }
            });
            //alert('Selected 1, 2 and 4.');
        });
        $('#mdmreq-select-button').on('click', function(event) {
            event.preventDefault(); 
            var selected_devicetype = $('#first_level').val();
            var rfisubset='mdmreq';
		 	      $("#content_response").fadeOut();								 
            $.ajax({
                  url:"gestioneLSoc/get_RfiList.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype,rfisubset:rfisubset},
                  dataType:"json",
                  success:function(data)
                  {
                      $("#rfilist_level").val(data);
                      $("#rfilist_level").multiselect("refresh");
                      $('#submitfilter').prop('disabled', false);
                  }
            });
            //alert('Selected 1, 2 and 4.');
        });
        $('#mandreq-select-button').on('click', function(event) {
            event.preventDefault(); 
            var selected_devicetype = $('#first_level').val();
            var rfisubset='mandreq';
			      $("#content_response").fadeOut();								 
            $.ajax({
                  url:"gestioneLSoc//get_RfiList.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype,rfisubset:rfisubset},
                  dataType:"json",
                  success:function(data)
                  {
                      $("#rfilist_level").val(data);
                      $("#rfilist_level").multiselect("refresh");
                     $('#submitfilter').prop('disabled', false);
                  }
            });
        });
        
        $('#techsum-select-button-test').on('click', function(event) {
            event.preventDefault(); 
            var selected_devicetype = $('#first_level_test').val();
            var rfisubset='techsum';
			      $("#content_response").fadeOut();								 

            $.ajax({
                  url:"gestioneLSoc/get_RfiList_test.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype,rfisubset:rfisubset},
                  dataType:"json",
                  success:function(data)
                  {
                      $("#rfilist_level_test").val(data);
                      $("#rfilist_level_test").multiselect("refresh");
                      $('#submitfilter_test').prop('disabled', false);
                  }
            });
            //alert('Selected 1, 2 and 4.');
        });
        $('#mdmreq-select-button-test').on('click', function(event) {
            event.preventDefault(); 
            var selected_devicetype = $('#first_level_test').val();
            var rfisubset='mdmreq';
		 	      $("#content_response").fadeOut();								 
            $.ajax({
                  url:"gestioneLSoc/get_RfiList_test.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype,rfisubset:rfisubset},
                  dataType:"json",
                  success:function(data)
                  {
                      $("#rfilist_level_test").val(data);
                      $("#rfilist_level_test").multiselect("refresh");
                      $('#submitfilter_test').prop('disabled', false);
                  }
            });
            //alert('Selected 1, 2 and 4.');
        });
        $('#mandreq-select-button-test').on('click', function(event) {
            event.preventDefault(); 
            var selected_devicetype = $('#first_level_test').val();
            var rfisubset='mandreq';
			      $("#content_response").fadeOut();								 
            $.ajax({
                  url:"gestioneLSoc//get_RfiList_test.php",
                  method:"POST",
                  data:{selected_devicetype:selected_devicetype,rfisubset:rfisubset},
                  dataType:"json",
                  success:function(data)
                  {
                      $("#rfilist_level_test").val(data);
                      $("#rfilist_level_test").multiselect("refresh");
                      $('#submitfilter_test').prop('disabled', false);
                  }
            });
        });
        
    });
</script>

<script type="text/javascript" defer>
    $('#submitfilter').click(function(e){
         e.preventDefault();
         var selected_devicetype = $('#first_level').val();
         var selected_years = $('#second_level').val();
         var selected_projects = $('#third_level').val();
         var selected_rfi = $('#rfilist_level').val();
         
         $('.loader').show(); 
        if(selected_rfi.length>0 && selected_projects.length>0){ 
            $.ajax({
                url:"gestioneLSoc/get_RfiFilter.php",
                method:"POST",
                data:{selected_devicetype:selected_devicetype,selected_years:selected_years,selected_projects:selected_projects,selected_rfi:selected_rfi},
                //dataType:"html",    
                success: function(data) 
                {   
                    $("#content_response").fadeIn();
                    $("#content_response").html(data);
                    //console.log('Submission was successful.');
                    //console.log(data);
                    //alert('ciao');
                    $('#datatable-responsive').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copyHtml5',
                                'print',
                                'csvHtml5',                                
                                'excelHtml5'
                                
                            ]
                        } );
                    $('#datatable-responsive').DataTable().columns.adjust().responsive.recalc();
                    $('.loader').hide();
				
												  
						  
                },
  
                error: function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            });
        }
     });
    $('#submitfilter_test').click(function(e){
         e.preventDefault();
         var selected_devicetype = $('#first_level_test').val();
         var selected_years = $('#second_level_test').val();
         var selected_projects = $('#third_level_test').val();
         var selected_rfi = $('#rfilist_level_test').val();
         
         $('.loader').show(); 
        if(selected_rfi.length>0 && selected_projects.length>0){ 
            $.ajax({
                url:"gestioneLSoc/get_RfiFilter_test.php",
                method:"POST",
                data:{selected_devicetype:selected_devicetype,selected_years:selected_years,selected_projects:selected_projects,selected_rfi:selected_rfi},
                //dataType:"html",    
                success: function(data) 
                {   
                    $("#content_response").fadeIn();
                    $("#content_response").html(data);
                    //console.log('Submission was successful.');
                    //console.log(data);
                    //alert('ciao');
                    $('#datatable-responsive').DataTable( {
                            dom: 'Bfrtip',
                            buttons: [
                                'copyHtml5',
                                'print',
                                'csvHtml5',                                
                                'excelHtml5'
                                
                            ]
                        } );
                    $('#datatable-responsive').DataTable().columns.adjust().responsive.recalc();
                    $('.loader').hide();
				
												  
						  
                },
  
                error: function (data) {
                    console.log('An error occurred.');
                    console.log(data);
                },
            });
        }
     });

</script>
    
  </body>
</html>