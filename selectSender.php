<?php

include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();
$dati = array();
if (isset($_POST['id'])) {
    $id = intval($_POST['id']);
    $lista = $funzioni_admin->get_senders($id);
    
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['name']);
         }
}




echo json_encode($dati);
?>
