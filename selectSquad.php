<?php
include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();


$string = '';

if (isset($_POST['squad_id'])) {
    $squad_id = intval($_POST['squad_id']);
    $lista = $funzioni_admin->get_type($squad_id);
    foreach ($lista as $key => $row) {        
        $string.= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
}

//echo json_encode($dati);
echo $string;

