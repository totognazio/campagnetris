<?php

include_once 'funzioni_admin.php';
$funzioni_admin = new funzioni_admin();
$dati = array();

if (isset($_GET['type_id'])) {
    $id = intval($_GET['type_id']);
    $lista = $funzioni_admin->get_type_label($id);
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['label']);
    }
}
if (isset($_GET['channel_id'])) {
    $id = intval($_GET['channel_id']);
    $lista = $funzioni_admin->get_channel_label($id);
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['label']);
    }
}
if (isset($_GET['group_id'])) {
    $id = intval($_GET['group_id']);
    $lista = $funzioni_admin->get_group_label($id);
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['label']);
    }
}
echo json_encode($dati);
?>
