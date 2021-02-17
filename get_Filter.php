<?php

$limit = ini_get('memory_limit');
ini_set('memory_limit', -1);

include_once (__DIR__.'/db_config.php');
include_once (__DIR__.'/classes/campaign_class.php');

$campaign = new campaign_class();

if(isset($_POST['datatable'])){
    $datatable = $_POST['datatable'];
} 
else{
    //print_r($_POST);
    exit('ERROR DATATABLE ABSENT!!!');
}   

$filter = $campaign->getFilter();

#echo'prima del render campagne dopo il get_filter';
#print_r($filter);
if($datatable=='pianificazione'){
    $list = $campaign->getCampaigns($filter); 
}
else if($datatable=='gestione'){
    $list = $campaign->getCampaignsGestione($filter); 
}

if(count($list)>0  && $datatable=='pianificazione'){
    $campaign->tablePianificazione($list);
}
else if(count($list)>0  && $datatable=='gestione'){ 
    $campaign->tableGestione($list);
}
else if(count($list)<=0  && $datatable=='gestione'){ 
    echo ' <br><h2></h2>Nessuna Campagna in Gestione per il tuo SQUAD !!!</h2>';
}
else if(count($list)<=0  && $datatable=='pianificazione'){ 
    echo ' <br><h2>Nessuna Campagna Pianificata !!!</h2>';
}
else { 
    echo ' <br><h2>Nessuna Campagna !!!</h2>';
}

            //print_r($list_campaign);
            //$html = $campaign->campaign_table($list_campaign, "sottotitolo");
            
            //print_r($html);



