<?php

include_once 'classes/campaign_class.php';
$campaign = new campaign_class();
$dati = array();

$gruop_id = "";
$type_id = "";
if (isset($_GET['group_id'])) {
    $gruop_id = intval($_GET['group_id']);
}

if (isset($_GET['type_id'])) {
    $type_id = intval($_GET['type_id']);
}

$id_campaign = $campaign->get_list_campaign_rule(" where type_id=$type_id and group_id=$gruop_id")->fetch_array(MYSQLI_ASSOC);
foreach ($id_campaign as $key => $row) {
    $dati[] = array(
        'valore' => $row,
        'etichetta' => $key);
}
echo json_encode($dati);
?>
