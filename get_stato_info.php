<?php

include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();
$dati = array();

if (isset($_POST['stato_id'])) {
    $id = intval($_POST['stato_id']);
    $dati = $funzioni_admin->get_stato_info($id);
}

echo json_encode($dati);
?>
