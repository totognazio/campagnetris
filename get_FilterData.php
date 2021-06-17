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

// print_r($data);
/*
echo'
{"draw":1,"recordsTotal":3,"recordsFiltered":3,
"data":[["387_1",1,"WIND","2021_08","UPSELLING","387_20210428_SQU_APO_CPI_TRY&BUY REFRESH","CAMBIO PIANO","1000p6m709w3","","APO","2021-04-28","NUOVA PIANIFICAZIONE","13","_0,0","_0,0","_0,0","_0,0",1620172800,1620259200,1620345600,1620432000,1620518400,1620604800,1620691200,1620777600,1620864000,1620950400,1621036800,1621123200,1621209600,1621296000,1621382400,1621468800,1621555200,1621641600,1621728000,1621814400,1621900800,1621987200,1622073600,1622160000,1622246400,1622332800,1622419200],
["205_1",2,"TRE","2021_08","GO TO MARKET","205_20210501_GTM_SMS_CAR_T_N_WDAY_NU_SH","CARING","","","SMS","2021-05-01","ANNULLATA","1.500","_1.500",1619913600,1620000000,1620086400,1620172800,1620259200,1620345600,1620432000,1620518400,1620604800,1620691200,1620777600,1620864000,1620950400,1621036800,1621123200,1621209600,1621296000,1621382400,1621468800,1621555200,1621641600,1621728000,1621814400,1621900800,1621987200,1622073600,1622160000,1622246400,1622332800,1622419200],
["211_1",3,"WIND","2021_08","GO TO MARKET","211_20210501_GTM_SMS_CAR_W_N_WDAY_NU_SH","CARING","","","SMS","2021-05-01","ANNULLATA","1.500","_1.500",1619913600,1620000000,1620086400,1620172800,1620259200,1620345600,1620432000,1620518400,1620604800,1620691200,1620777600,1620864000,1620950400,1621036800,1621123200,1621209600,1621296000,1621382400,1621468800,1621555200,1621641600,1621728000,1621814400,1621900800,1621987200,1622073600,1622160000,1622246400,1622332800,1622419200]
]}';
*/
echo $data;
}
else if(count($list)>0  && $datatable=='gestione'){ 
    $campaign->tableGestione($list);
}


            //print_r($list_campaign);
            //$html = $campaign->campaign_table($list_campaign, "sottotitolo");
            
            //print_r($html);



