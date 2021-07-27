<?php

$limit = ini_get('memory_limit');
ini_set('memory_limit', -1);

include_once (__DIR__.'/db_config.php');
include_once (__DIR__.'/classes/campaign_class.php');

$campaign = new campaign_class();
// print_r($_POST);
if(isset($_GET['datatable'])){
    $datatable = $_GET['datatable'];
} 
else{

    exit('ERROR DATATABLE ABSENT!!!');
}   

$filter = $campaign->getFilter();

//echo'prima del render campagne dopo il get_filter';
//print_r($filter);
if($datatable=='pianificazione'){
    $list = $campaign->getCampaigns($filter); 
}
else if($datatable=='gestione'){
    $list = $campaign->getCampaignsGestione($filter); 
}
else if($datatable=='gestioneStato'){
    $list = $campaign->getCampaignsGestione($filter); 
}


if(count($list)>0  && $datatable=='pianificazione'){
    $data =  $campaign->tablePianificazioneData($list);
    echo $data;
}
else if(count($list)>0  && $datatable=='gestione'){ 
    //$campaign->tableGestione($list);
    $data = $campaign->tableGestioneData($list);
    echo $data;
}


            //print_r($list_campaign);
            //$html = $campaign->campaign_table($list_campaign, "sottotitolo");
            
            //print_r($html);



