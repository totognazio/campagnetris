<?php

include_once 'classes/funzioni_admin.php';
$campaign = new funzioni_admin();


    $lista_array = $campaign->get_lastDataSprint();
    echo json_encode($lista_array);

?>