<?php

include_once 'db_config.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';

$funzioni_admin = new funzioni_admin();
$page_protect = new Access_user;
$campaign = new campaign_class();
$radici_list = $campaign->radici_list;

$filter = array();
$intervallo = array();
if (isset($_POST['selectAnno']))
    $_SESSION['selectAnno'] = intval($_POST['selectAnno']);
if (isset($_POST['selectMese']))
    $_SESSION['selectMese'] = intval($_POST['selectMese']);

if (isset($_SESSION['selectAnno']) && (isset($_SESSION['selectMese']))) {
    $intervallo = $campaign->calcola_intervallo_mese();
} else {
    $intervallo = $campaign->calcola_settimana_corrente();
}

$data_start = $intervallo['anno_start'] . "-" . $intervallo['mese_start'] . "-" . $intervallo['giorno_start'];
$data_end = $intervallo['anno_end'] . "-" . $intervallo['mese_end'] . "-" . $intervallo['giorno_end'];
$filter['data'] = " ("
        . "`data_inizio` <= '" . $data_end
        . "' AND  (`data_fine` >= '" . $data_start . "' )"
        . ")";

$job_role = $page_protect->get_job_role();
if ($job_role == 2) {
    $squad_id = $page_protect->get_squad();
    $filter['data'] = $filter['data'] . " and (campaigns.`squad_id` = $squad_id) ";
}
$lista_filtri = array();

foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        if (isset($_POST[$radice . $value['id']])) {
            $filtro_post = intval($_POST[$radice . $value['id']]);

            if ($filtro_post == "0") {
                $lista_filtri[] = " (" . $value_table . ".name not like '" . $value['name'] . "')";
            }
        }
    }
}



$searchSql = " where 1 ";


if (count($filter) > 0) {

    foreach ($filter as $key => $value) {
        $searchSql = $searchSql . " and " . $value;
    }
}
$channel_query = " ";
if (count($lista_filtri) > 0) {
    foreach ($lista_filtri as $key => $value) {
        $channel_query = $value . " and " . $channel_query;
    }
    $searchSql = $searchSql . " and " . "(" . substr($channel_query, 0, -5) . ")";
}

//$searchSql = " where 1 ";
//lista variabili parziali
$data_output = array();

$summary = "";
$contatore_stack = 0;
$somma_volume_stack = 0;

foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        if (isset($_POST[$radice . $value['id']])) {
            $filtro_post = intval($_POST[$radice . $value['id']]);
            $totale = $campaign->get_total_campaign($searchSql . " and (" . $value_table . ".name like '" . $value['name'] . "')");
            $volume = $campaign->get_volume_campaign($searchSql . " and (" . $value_table . ".name like '" . $value['name'] . "')");
            $data_output['num_' . $radice . $value['id']] = $totale;

            if ($key_table == 'stack') {
                $summary = $summary . "<tr><td align=\"left\">" . $value['name'] . ":</td><td align=\"center\">(" . $totale . ")</td><td align=\"right\" title=\"\">" . number_format(round($volume / 1000, 0), 0, ',', '.') . " K</td></tr>";
                $contatore_stack = $contatore_stack + $totale;
                $somma_volume_stack = $somma_volume_stack + $volume;
            }
        }
    }
}

//lista variabili totali
$searchSql = " where " . $filter['data'];


foreach ($radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        if (isset($_POST[$radice . $value['id']])) {
            $filtro_post = intval($_POST[$radice . $value['id']]);
            $totale = $campaign->get_total_campaign($searchSql . " and (" . $value_table . ".name like '" . $value['name'] . "')");
            $volume = $campaign->get_volume_campaign($searchSql . " and (" . $value_table . ".name like '" . $value['name'] . "')");
            $data_output['tot_' . $radice . $value['id']] = $totale;
        }
    }
}



$data_output['totali'] = "<table width=\"100%\" border=\"0\">" . $summary . "<tr><td align=\"left\" style=\"font-weight: bold;\">TOTALE:</td><td align=\"center\" style=\"font-weight: bold;\">($contatore_stack)</td><td align=\"right\" style=\"font-weight: bold;\" title=\"\">" . number_format(round($somma_volume_stack / 1000, 0), 0, ',', '.') . " K</td></tr>\n        </table>";

echo json_encode($data_output);
