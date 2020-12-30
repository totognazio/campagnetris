<?php

include_once 'classes/funzioni_admin.php';
$campaign = new funzioni_admin();
$dati = array();

$offer_id = "";

if (isset($_GET['offer_name'])) {
    $offer_name = $_GET['offer_name'];
    $lista_array=$campaign->get_offers($offer_name);
    //echo json_encode(array_unshift($lista_array, ""));
    echo json_encode($lista_array);
}
?>
