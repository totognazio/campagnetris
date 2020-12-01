<?php

$limit = ini_get('memory_limit');
ini_set('memory_limit', -1);

include_once (__DIR__.'/db_config.php');
include_once (__DIR__.'/classes/campaign_class.php');

$campaign = new campaign_class();

$filter = $campaign->getFilter();

$list = $campaign->getCampaigns($filter); 

if(count($list)>0){
    $campaign->tablePianificazione($list);
}
else{
    echo ' Nessun Campagna !!!';
}

            //print_r($list_campaign);
            //$html = $campaign->campaign_table($list_campaign, "sottotitolo");
            
            //print_r($html);



