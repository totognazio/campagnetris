    <!-- NProgress -->
    <link href="vendors/nprogress/nprogress.css" rel="stylesheet">
    <!-- Dropzone.css -->
    <link href="vendors/dropzone/dist/min/dropzone.min.css" rel="stylesheet">
    <!-- Dropzone.js -->
    <script src="vendors/dropzone/dist/dropzone.js"></script>

    <script type="text/javascript">
      // Immediately after the js include
      //Dropzone.autoDiscover = false;     
    </script>
    <?php
    include_once './classes/form_class.php';
    include_once './classes/funzioni_admin.php';
    include_once './classes/campaign_class.php';
    include_once './classes/access_user/access_user_class.php';
    require_once './classes/PHPExcel/Classes/PHPExcel.php'; 
    // To read excel file
    //require __DIR__ . '/vendors/autoload.php';
    //echo date('H:i:s') . " Create new PHPExcel object\n";
    $objPHPExcel = new PHPExcel();

    $page_protect = new Access_user;
    $form = new form_class();
    $funzione = new funzioni_admin();
    $campaign = new campaign_class();
    // $page_protect->login_page = "login.php"; // change this only if your login is on another page
    $page_protect->access_page(); // only set this this method to protect your page
    $page_protect->get_user_info();
    $livello_accesso = $page_protect->get_job_role();
    ?>

    <!-- page content -->
    <div class="right_col" role="main">
      <div class="">
        <div class="page-title">
          <div class="title_left">
            <h3>Import Nuove Campagne</h3>
          </div>

            <a class="btn btn btn-xs btn-success" data-placement="top" data-toggle="tooltip" data-original-title="Download Excel Template" href="download.php"><i class="fa fa-file-excel-o" aria-hidden="true"></i> Download Excel Template</a>
      

        </div>

        <div class="clearfix"></div>

        <div class="row">
          <div class="col-md-12 col-sm-12 col-xs-12">
            <div class="x_panel">
              <div class="x_title">
                <h2>Dropzone - Upload excel file</h2>

                <ul class="nav navbar-right panel_toolbox">
                  <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                  </li>
                  <!--
                  <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                    
                    <ul class="dropdown-menu" role="menu">
                      <li><a href="#">Settings 1</a>
                      </li>
                      <li><a href="#">Settings 2</a>
                      </li>
                    </ul>
                  </li>
                  <li><a class="close-link"><i class="fa fa-close"></i></a>
                  </li>-->
                </ul>
                <div class="clearfix"></div>
              </div>
              <div class="x_content">
                <p>Drag single file to the box below for upload or click to select file. <strong>Only template file is allowed.</strong> </p>
                <form action="form_upload.php" class="dropzone" id="dropzoneForm"></form>
                </form>
                <br />
              <?php
          //only PM user or Manager 
          if ($livello_accesso==2 OR $livello_accesso==10) {
          ?>
                <div align="center">
                  <button type="button" class="btn btn-info" id="submit-all">Upload</button>
                </div>

          <?php } ?>      
                <br />
                <h3 class="text-success" align="center">Input data</h3><br />
                <div class="table-responsive">
                  <div id="preview" class="table table-striped table-bordered" style="margin-bottom:0">
                    <!-- Excel file content will goeas here -->
                  </div>
                </div>
                <!-- container -->
                <!-- JavaScript code for uploading the file -->
                <script>
                  $(document).ready(function() {
                    Dropzone.options.dropzoneForm = {
                      autoProcessQueue: false,
                      acceptedFiels: ".xlsx",
                      init: function() {
                        var submitButton = document.querySelector("#submit-all");
                        myDropzone = this;
                        submitButton.addEventListener("click", function() {
                        myDropzone.processQueue();
                        });
                        this.on("complete", function() {
                          if (this.getQueuedFiles().length == 0 && this.getUploadingFiles().length == 0) {
                            var _this = this;
                            _this.removeAllFiles();
                          }
                          list_compain();
                        });
                      }
                    };
                    list_compain();

                    function list_compain() {
                      $.ajax({
                        url: "form_upload.php",
                        success: function(data) {
                          $('#preview').html(data);
                        }
                      });
                    }
                  });
                </script>
                <br />
                <br />
              </div>
              <!-- container end -->
              <br />
              <br />
              <br />
            </div>
          </div>
        </div>
      </div>
    </div>
    </div>










    <!-- /page content -->


    <!-- <script>
      $(document).ready(function() {
        //gestione upload file
        var myDropzoneCanale = new Dropzone(
          '#dropzone-canale', {
            <?php if ($readonly) {
              echo 'clickable: false,addRemoveLinks: false,';
            } else {
              echo 'clickable: true,';
            }
            ?>,
            init: function() {
              this.options.dictRemoveFileConfirmation = "Confermi di voler eliminare il File?";
              //solo su Modifica o Open
              <?php if (isset($_POST['azione']) && (($_POST['azione'] == 'modifica') || ($_POST['azione'] == 'open'))) { ?>
                thisCanale = this;
                $.ajax({
                  type: "POST",
                  dataType: "json",
                  url: "scan_uploaded.php",
                  data: {
                    id_dir: '<?php echo $id_campaign['id']; ?>',
                    subdir: 'canale'
                  },
                  success: function(data) {

                    $.each(data, function(key, value) {
                      var filename = value.name;
                      var a = document.createElement('a');
                      a.setAttribute('class', "dz-remove");
                      //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                      a.setAttribute('href', "upload.php?download=<?php echo $id_campaign['id']; ?>&canale&file=" + filename);
                      a.setAttribute('target', '_blank');
                      a.innerHTML = "Download file";
                      var mockFile = {
                        name: value.name,
                        size: value.size
                      };
                      thisCanale.options.thumbnail.call(thisCanale, mockFile);
                      thisCanale.options.addedfile.call(thisCanale, mockFile);
                      thisCanale.options.success.call(thisCanale, mockFile);
                      thisCanale.options.complete.call(thisCanale, mockFile);
                      document.getElementById("dropzone-canale").lastChild.appendChild(a);

                    });

                  }
                });
              <?php  } ?>

              this.on("removedfile", function(file) {
                console.log('removedfile on');

                var filename = file.name;

                $.ajax({
                  url: "upload.php",
                  data: {
                    filename: filename,
                    action: 'delete',
                    id_upload: '<?php echo $id_upload; ?>',
                    subdir: 'canale'
                  },
                  type: 'POST',
                  success: function(data) {
                    if (data.NotificationType === "Error") {
                      console.log('error 1');
                      //toastr.error(data.Message);
                    } else {
                      //toastr.success(data.Message);
                      console.log('error 2');
                    }
                  },
                  error: function(data) {
                    //toastr.error(data.Message);
                    console.log('error 3');
                  }
                })

              });


              this.on("processing", function(file) {});
              this.on("maxfilesexceeded",
                function(file) {
                  this.removeAllFiles();
                  this.addFile(file);
                });
              this.on("success",
                function(file, responseText) {
                  var filename = file.name;
                  var a = document.createElement('a');
                  a.setAttribute('class', "dz-remove");
                  //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                  a.setAttribute('href', "upload.php?download=<?php echo $id_upload; ?>&canale&file=" + filename);
                  a.setAttribute('target', '_blank');
                  a.innerHTML = "Download file";
                  file.previewTemplate.appendChild(a);
                  // do something here
                });
              this.on("error",
                function(data, errorMessage, xhr) {
                  // do something here
                });
            }
          });

        $('#data_invio_jakala').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_3",
          locale: {
            format: "DD/MM/YYYY",
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
            monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            firstDay: 1
          }
        });

        $('#data_invio_spai').daterangepicker({
          singleDatePicker: true,
          singleClasses: "picker_3",
          locale: {
            format: "DD/MM/YYYY",
            daysOfWeek: ['Do', 'Lu', 'Ma', 'Me', 'Gi', 'Ve', 'Sa'],
            monthNames: ['Gennaio', 'Febbraio', 'Marzo', 'Aprile', 'Maggio', 'Giugno', 'Luglio', 'Agosto', 'Settembre', 'Ottobre', 'Novembre', 'Dicembre'],
            firstDay: 1
          }
        });


        $('#campaign_state_id').select2({
          placeholder: "Select Stato",
          allowClear: true
        });
        $('#channel_ins').on('select2:select', function() {
          selected_channel_id = $('#channel_ins').val();

          stato = $('#campaign_state_id').val();
          //alert('stato in canale zero '+stato),
          channels_view(selected_channel_id);
          validazione(selected_channel_id, stato);

        });




        $('#iniziative_dealer').select2({
          placeholder: "Select numero Dealer",
          //allowClear: true
        });
        //canale Dealer select numero Dealer
        $('#iniziative_dealer').on('select2:select', function() {
          //alert('deale canale VIEW   '+$(this).val());
          count = $(this).val();
          for (i = 2; i < 10; i++) {
            if (i <= count) {
              $('#dealer_' + i).show();
              if (get_required(stato)) {
                $('#Cod_iniziativa' + i).attr('required', true);
              } else {
                $('#Cod_iniziativa' + i).attr('required', false);
              }
            } else {
              $('#dealer_' + i).hide();
              $('#Cod_iniziativa' + i).attr('required', false);
            }
          }


        });

      });
    </script> -->