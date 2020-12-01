<?php

include_once 'funzioni_admin.php';
$campaign = new funzioni_admin();
$dati = array();

$offer_id = "";

if (isset($_GET['offer_name'])) {
    $offer_name = $_GET['offer_name'];
    $lista_array = $campaign->get_offers($offer_name);
    array_unshift($lista_array, array('id' => '', 'name' => '', 'description' => '', 'label' => ''));
    echo json_encode($lista_array);
}
if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $lista_array = $campaign->get_offer_id($id);
    echo json_encode($lista_array);
}
?>
