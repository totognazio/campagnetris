<?php

include_once './classes/funzioni_admin.php';
$funzione = new funzioni_admin();
$dati = array();

$startDate = "";
$endDate = "";

if (isset($_POST['startDate']) && isset($_POST['endDate'])) {
    $startDate = $_POST['startDate'];
    $endDate = $_POST['endDate'];
    $sprints_list = $funzione->get_sprints($startDate,$endDate);
    
}
else{

    $sprints_list = $funzione->get_sprints();
}

$sprint_sel = '';
if(isset($_POST['sprint'])){
    $sprint_sel = $_POST['sprint'];
}

//$dati[] = array('id' => 0,'text' => '');
foreach ($sprints_list as $key => $row) {
    $flag = false;
    if($_SESSION['filter']['sprint']==$row['id'] || $sprint_sel==$row['id']){
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