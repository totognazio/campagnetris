<?php
include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();


//$string = '_';

if (isset($_POST['offer_id'])) {
    $offer_id = intval($_POST['offer_id']);

    $offer = $funzioni_admin->get_offer_id($offer_id);

}

echo json_encode($offer);


