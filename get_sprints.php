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



//$dati[] = array('id' => 0,'text' => '');
foreach ($sprints as $key => $row) {
    $flag = false;
    if($_SESSION['filter']['sprint']==$row['id'] ){
            $flag = true;
    }
    $dati[] = array(
        'id' => $row['id'],
        'text' => $row['name'],
        'selected'=> $flag
    );
}

echo json_encode(array("results"=>$dati));
?>