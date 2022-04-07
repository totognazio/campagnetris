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
    $id_upload = uniqid();
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
                <!--<form action="form_upload.php" class="dropzone" id="dropzoneForm"></form>
                </form>-->
                        <form id="dropzone-import" action="form_upload.php?id_upload=<?php echo $id_upload; ?>"  class="dropzone">
                        </form>
                <br />
              <?php
                   // 
          if ($livello_accesso !=1 ) { //Not for Guest only
          ?>
                <div align="center">
                
                <button type="button" class="btn btn-info" id="submit-all" onclick="insert_campaign('<?php echo $id_upload; ?>');" >Import Campagne</button>

                </div>

          <?php } ?>      
                <br />                
                <div class="table-responsive">
                  <div id="preview" class="table table-striped table-bordered" style="margin-bottom:0">
                    <!-- Excel file content will goeas here -->
                  </div>
                </div>
                <!-- container -->
                <!-- JavaScript code for uploading the file -->

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


<script>

$(document).ready(function() {

document.querySelector("#submit-all").disabled=true;

var myDropzoneImport = new Dropzone(
        '#dropzone-import',
        {   
            clickable: true,
            acceptedFiles: ".xlsm",           
            init: function () {
                this.options.dictRemoveFileConfirmation = "Confermi di voler eliminare il File?";                   
                document.querySelector("#dropzone-import > div > span").innerHTML = "Excel Template Only";

                this.on("removedfile", function(file) {
                        console.log('removedfile on');

                        var filename = file.name; 

                                $.ajax({
                                url: "form_upload.php",
                                data: { filename: filename, action: 'delete', id_upload: '<?php echo $id_upload; ?>'},
                                type: 'POST',
                                success: function (data) {
                                    
                                  document.querySelector("#submit-all").disabled=false;

                                    if (data.NotificationType === "Error") {
                                        console.log('error 1');
                                        //toastr.error(data.Message);
                                    } else {
                                        //toastr.success(data.Message);
                                        console.log('error 2');                          
                                    }
                                    },
                                    error: function (data) {
                                        //toastr.error(data.Message);
                                        console.log('error 3');
                                    }
                                })

                });


                this.on("processing", function (file) {
                        });
                this.on("maxfilesexceeded",
                            function (file) {
                                this.removeAllFiles();
                                this.addFile(file);
                            });
                this.on("success",
                            function (file, responseText) {
                                var filename = file.name; 
                                var a = document.createElement('a');
                                a.setAttribute('class',"dz-remove");
                                //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                                a.setAttribute('href',"form_upload.php?upload=<?php echo $id_upload; ?>&file=" + filename);
                                a.setAttribute('target', '_blank');
                                //a.innerHTML = "Download file";
                                file.previewTemplate.appendChild(a);    
                                
                                document.querySelector("#submit-all").disabled=false;
                                                                  
                            // do something here
                            });
                        this.on("error",
                            function (data, errorMessage, xhr) {
                                // do something here
                            });
                    
        }
      });
    });
    
</script>