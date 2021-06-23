<?php
include_once 'db_config.php';
include_once './classes/Class_lsoc.php';
//require_once './Excel/reader.php';
include_once './classes/upload_class.php';
include_once './classes/funzioni_admin.php'; 
include_once './classes/campaign_class.php';
require_once './classes/PHPExcel/Classes/PHPExcel.php'; 


#print_r($_POST);

$gestore = new Class_lsoc();
$campaign = new campaign_class();
$filter = $_SESSION['filter'];

if ($_POST['funzione'] == "export_pianificazione"){

    
    $list = $campaign->getCampaigns($filter); 
    $tot_volume = $campaign->tot_volume();
    $list_day = $campaign->datePeriodExcel();
    $gestore->export_pianificazione($list, $tot_volume, $list_day, $filter); 
}
if ($_POST['funzione'] == "export_gestione"){

    $list = $campaign->getCampaignsGestione($filter); 
    //$tot_volume = $campaign->tot_volume();
    //$list_day = $campaign->datePeriodExcel();
    //print_r($list);
    $gestore->export_gestione($list, $filter); 
}
// export Proposal
if ($_POST['funzione'] == "export_capacity"){

    $list = $campaign->getCampaignsCapacity($filter); 
    //$tot_volume = $campaign->tot_volume();
    //$list_day = $campaign->datePeriodExcel();
    $gestore->export_capacity($list, $filter); 
}






 