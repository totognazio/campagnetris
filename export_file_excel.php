<?php
include_once 'db_config.php';
include_once './classes/PHPExcel.php';
include_once './classes/PHPExcel/IOFactory.php';
/** PHPExcel_Cell_AdvancedValueBinder */
include_once './classes/PHPExcel/Cell/AdvancedValueBinder.php';

include_once ("./classes/Class_lsoc.php");
require_once './Excel/reader.php';
include_once './classes/upload_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/funzioni.php'; 
include_once './classes/campaign_class.php';


#print_r($_POST);

$gestore = new Class_lsoc();

if ($_GET['funzione'] == "export_pianificazione"){

    $campaign = new campaign_class();

    $filter = $_SESSION['filter'];

    #echo'prima del render campagne dopo il get_filter';

    $list = $campaign->getCampaigns($filter); 
    $tot_volume = $campaign->tot_volume();

    $list_day = $campaign->daterange();
    $gestore->export_pianificazione($list, $tot_volume, $list_day);
}



//OLD 
if ($_GET['funzione'] == "export_template_LSoc"){
        $gestore->export_template_LSoc();
}

if ($_GET['funzione'] == "export_LSoc_Wind"){
        $devicetype = $_GET['devicetype'];
        $device_name = $_GET['nomedevice'];
        $gestore->export_LSoc_Wind($devicetype, $device_name);
}

if ($_GET['funzione'] == "export_mdm"){
        $project_id = base64_decode($_GET['id']);
        $devicetype = base64_decode($_GET['devicetype']);
        $device_model = base64_decode($_GET['model']);
        $device_vendor = base64_decode($_GET['vendor']);
        $gestore->export_MDM_ingestion($project_id, $devicetype, $device_model,$device_vendor);
}
if ($_GET['funzione'] == "export_ppt_summary"){
        $project_id = base64_decode($_GET['id']);
        $devicetype = base64_decode($_GET['devicetype']);
        $device_model = base64_decode($_GET['model']);
        $device_vendor = base64_decode($_GET['vendor']);
        #echo 'eccolo';        
        require_once 'ppt_summary_1.php';
}

if ($_GET['funzione'] == "export_LSoc"){
        if (isset($_GET['pr'])){
            $id_project = base64_decode($_GET['pr']);      
            #$gestore->exportRFI($id_project);
        }
        else {
            $id_project = null;   
        }
        
        $devicetype = $_GET['devicetype'];

        #echo $devicetype;
        if (isset($_GET['model'])) {
            $device_name = $_GET['model'];
            $device_vendor = $_GET['vendor'];
         #   echo $device_name;
            $gestore->exportRFI($devicetype, $device_name, $device_vendor, $id_project);
        }
        else {
            
            $gestore->exportRFI($devicetype, $device_name=false);
            /*
            $filename = "Requirements_".$devicetype;
            $query = "SELECT * FROM dati_requisiti WHERE lista_req LIKE '%$devicetype%'";
            $gestore->export_query2csv(base64_encode($query), $filename);     
             * 
             */            
        }
}


if ($_GET['funzione'] == "exportRFItest"){ 
  
            $id_project = base64_decode($_GET['pr']);
            #$gestore->exportRFI($id_project);
      
            $devicetype = base64_decode($_GET['devicetype']);

            $device_model = base64_decode($_GET['model']);
            $device_vendor = base64_decode($_GET['vendor']);

            $gestore->exportRFItestValue($devicetype, $device_model, $device_vendor, $id_project);
  
}
if ($_GET['funzione'] == "exportRFI"){    
    
        if (isset($_GET['pr'])){ 
            $id_project = base64_decode($_GET['pr']);
            #$gestore->exportRFI($id_project);
        }
        else {
            $id_project = null;
        }
        
        $devicetype = base64_decode($_GET['devicetype']);

        #echo $devicetype;
        if (isset($_GET['model'])) {
            $device_model = base64_decode($_GET['model']);
            $device_vendor = base64_decode($_GET['vendor']);
         
            #print_r($_GET);
            
            #echo $devicetype.' '.$device_model.' '.$device_vendor.' '.$id_project;
            $gestore->exportRFI($devicetype, $device_model, $device_vendor, $id_project);
        }
        else $gestore->exportRFI($devicetype, $device_model=false);
}

if ($_GET['funzione'] == "exportRFIOld"){    
    
        if (isset($_GET['pr'])){ 
            $id_project = base64_decode($_GET['pr']);
            #$gestore->exportRFI($id_project);
        }
        else {
            $id_project = null;
        }
        
        $devicetype = base64_decode($_GET['devicetype']);

        #echo $devicetype;
        if (isset($_GET['model'])) {
            $device_model = base64_decode($_GET['model']);
            $device_vendor = base64_decode($_GET['vendor']);
         
            #print_r($_GET);
            
            #echo $devicetype.' '.$device_model.' '.$device_vendor.' '.$id_project;
            $gestore->exportRFIOldProject($devicetype, $device_model, $device_vendor, $id_project);
        }
        else $gestore->exportRFIOldProject($devicetype, $device_model=false);
}

if ($_GET['funzione'] == "export_LSoc_new"){
        $devicetype = $_GET['devicetype'];
        $devicetype ='Phone';
        #echo $devicetype;
        if (isset($_GET['nomedevice'])) {
            $device_name = $_GET['nomedevice'];
         #   echo $device_name;
            $gestore->export_LSoc_with_windslide($devicetype, $device_name);
        }
        else $gestore->export_LSoc_with_windslide($devicetype, $device_name=false);
}


/*
if ($_GET['funzione'] == "export_lsoc_specifica"){
        $device_name = $_GET['nomedevice'];
        $device_type = $_GET['devicetype'];
        $gestore->export_LSoc_specifica($device_name, $device_type);
}
 
 */
if ($_GET['funzione'] == "excel_to_parsing"){
       $my_upload = new file_upload;
        $my_upload->upload_dir = "./gestioneLSoc/template/"; // "files" is the folder for the uploaded files (you have to create this folder)
        $my_upload->extensions = array(".xls", ".xlsx"); // specify the allowed extensions here
        // $my_upload->extensions = "de"; // use this to switch the messages into an other language (translate first!!!)
        $my_upload->max_length_filename = 50; // change this value to fit your field length in your database (standard 100)
        $my_upload->rename_file = true;

        $my_upload->the_temp_file = $_FILES['file_to_parse']['tmp_name'];
        $my_upload->the_file = $_FILES['file_to_parse']['name'];
        $my_upload->http_error = $_FILES['file_to_parse']['error'];
        $my_upload->the_mime_type = $_FILES['file_to_parse']['type']; // new in ver. 2.33
        $my_upload->replace = (isset($_POST['replace'])) ? $_POST['replace'] : "n"; // because only a checked checkboxes is true
        $my_upload->do_filename_check = (isset($_POST['check'])) ? $_POST['check'] : "n"; // use this boolean to check for a valid filename
        $today = date("Ymdhis");
        $new_name = $today;
        if ($my_upload->upload($new_name)) { // new name is an additional filename information, use this to rename the uploaded file
            $full_path = $my_upload->upload_dir . $my_upload->file_copy;
            $info = $my_upload->get_uploaded_file_info($full_path);
        }
        $gestore->parsing_and_export($full_path, FALSE, FALSE); //parsing and export
}


 