<?php

include_once './classes/funzioni_admin.php';
$funzione = new funzioni_admin();
$dati = array();

$startDate = "";
$endDate = "";
if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $sprints = $funzione->get_sprints($startDate,$endDate);
}
else{

    $sprints = $funzione->get_sprints();
}



foreach ($sprints as $key => $row) {
    $dati[] = array(
        'id' => $row['id'],
        'text' => $row['name'],
        //'data_inizio' => $row['data_inizio'],
        //'data_fine' => $row['data_fine'],
    );
}
echo json_encode(array("results"=>$dati));
?>