<?php

include_once 'classes/funzioni_admin.php';
$campaign = new funzioni_admin();
$dati = array();

$offer_id = "";

if (isset($_GET['id'])) {
    $segment_id = $_GET['id'];
    $lista_array = $campaign->get_segment($segment_id);
    echo json_encode($lista_array);
}
?>
