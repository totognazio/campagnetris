<?php

include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();
$dati = array();
$string = '<option value=""></option>';
if (isset($_POST['channel_id'])) {
    $id = intval($_POST['channel_id']);
    $lista = $funzioni_admin->get_senders($id);
    //print_r($lista);
    foreach ($lista as $key => $row) {        
        $string.= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
    /*
    foreach ($lista as $key => $row) {
        $dati[] = array(
            'valore' => $row['id'],
            'etichetta' => $row['name']);
    }
     * 
     */
}
echo $string;
//return $string;

