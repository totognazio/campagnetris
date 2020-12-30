<?php
include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();


$string = '_';

if (isset($_POST['selected_type'])) {
    $selected_type = intval($_POST['selected_type']);
    $label = $funzioni_admin->get_type_label($selected_type);
    // print_r($lista);
    $string .= $label;

}

//echo json_encode($dati);
echo $string.'_';

