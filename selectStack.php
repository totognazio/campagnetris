<?php
include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();


$string = '<option value=""></option>';

if (isset($_POST['stack_id'])) {
    $stack_id = intval($_POST['stack_id']);
    $lista = $funzioni_admin->get_type_by_stack($stack_id);
    foreach ($lista as $key => $row) {        
        $string.= '<option value="'.$row['id'].'">'.$row['name'].'</option>';
    }
}

//echo json_encode($dati);
echo $string;

