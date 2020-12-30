<?php

include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();
$dati = array();

if (isset($_GET['type_id'])) {
    $id = intval($_GET['type_id']);
    $lista = $funzioni_admin->get_type($id);
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['label']);
    }
}
if (isset($_GET['channel_id'])) {
    $id = intval($_GET['channel_id']);
    $lista = $funzioni_admin->get_channel($id);
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['label']);
    }
}
if (isset($_GET['stack_id'])) {
    $id = intval($_GET['stack_id']);
    $lista = $funzioni_admin->get_stack($id);
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['label']);
    }
}
echo json_encode($dati);
?>
