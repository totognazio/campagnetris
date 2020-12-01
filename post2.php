<?php

include_once 'campaign_class.php';
include_once 'funzioni_admin.php';
include_once("./classes/access_user/access_user_class.php");


$funzioni_admin = new funzioni_admin();
$page_protect = new Access_user;
$campaign = new campaign_class();
$sortorder = 'asc'; // Sort order
$page = 1; // The current page

$qtype = ''; // Search column
$query = ''; // Search string
$filter_qtype = '';
// Get posted data
if (isset($_POST['page'])) {
    $page = addslashes($_POST['page']);
}
if (isset($_POST['sortname'])) {
    $sortname = addslashes($_POST['sortname']);
}
if (isset($_POST['sortorder'])) {
    $sortorder = addslashes($_POST['sortorder']);
}
if (isset($_POST['qtype'])) {
    $qtype = addslashes($_POST['qtype']);
}
if (isset($_POST['query'])) {
    $query = addslashes($_POST['query']);
}
if (isset($_POST['rp'])) {
    $rp = addslashes($_POST['rp']);
}

if (isset($_POST['selectAnno']))
    $_SESSION['selectAnno'] = intval($_POST['selectAnno']);
if (isset($_POST['selectMese']))
    $_SESSION['selectMese'] = intval($_POST['selectMese']);

$filter = array();
$intervallo = array();
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

//controllo dipartimento
$job_role = $page_protect->get_job_role();
if ($job_role == 2) {
    $department_id = $page_protect->get_department();
    $filter['data'] = $filter['data'] . " and (campaigns.`department_id` = $department_id) ";
}

if (isset($_POST['letter_pressed'])) {
    $letter_pressed = $_POST['letter_pressed'];
    if ($letter_pressed != "ALL")
        $filter['data'] = $filter['data'] . " and (`nome_campagna` like '$letter_pressed%') ";
}
if (isset($_POST['qtype']) and isset($_POST['query'])) {
    if ($query != "") {
        switch ($qtype) {
            case "gruppo_nome":
                $filter_qtype = " and (campaign_groups.NAME like '%" . $query . "%') ";
                break;
            case "nome_campagna":
                $filter_qtype = " and (`nome_campagna` like '%" . $query . "%') ";
                break;
            case "tipo_nome":
                $filter_qtype = " and (campaign_types.NAME like '%" . $query . "%') ";
            case "dipartimento_nome":
                $filter_qtype = " and (departments.NAME like '%" . $query . "%') ";
                break;
            case "nome_stato":
                $filter_qtype = " and (campaign_states.NAME like '%" . $query . "%') ";
                break;
            case "username":
                $filter_qtype = " and (username like '$query') ";
                break;
            default:
                break;
        }
    }
}
if ($sortname != "") {
    switch ($sortname) {
        case "gruppo_campagna":
            $sortname = " campaign_groups.id ";
            break;
        case "tipo_campagna":
            $sortname = " campaign_types.id ";
            break;
        case "tipo_campagna":
            $sortname = " campaign_types.id ";
            break;
        case "dipartimento":
            $sortname = " departments.id ";
            break;
        case "canale":
            $sortname = " channels.id ";
            break;
        case "nome_stato":
            $sortname = " campaign_states.id ";
            break;
    }
} else {
    $sortname = 'id'; // Sort column
}

$sortSql = "order by $sortname $sortorder";
$lista_filtri = array();

//definizione filtri da variabile di sessione
$campaign->set_filter_session();
$lista_filtri = array();
foreach ($campaign->radici_list as $key_table => $value_table) {
    $list = $funzioni_admin->get_list_id($value_table);
    $radice = $key_table . "_";
    foreach ($list as $key => $value) {
        if ($_SESSION[$radice . $value['id']] == 0) {
            $lista_filtri[] = " (" . $value_table . ".name not like '" . $value['name'] . "')";
        }
    }
}


$searchSql = ($qtype != '' && $query != '') ? " $qtype = '$query' " : '';
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

$total = $campaign->get_total_campaign($searchSql . " " . $filter_qtype);

// Setup paging SQL
$pageStart = ($page - 1) * $rp;
$limitSql = "limit $pageStart, $rp";
// Return JSON data
$data_output = array();
$data_output['page'] = intval($page);
$data_output['total'] = intval($total);
$data_output['rows'] = array();
$contatore = 1;

$list_campaign = $campaign->get_list_campaign($searchSql . " " . $filter_qtype . " " . $sortSql . " " . $limitSql);
foreach ($list_campaign as $key => $row) {
    if ($row['sender_nome'] != NULL)
        $sender_nome = $row['sender_nome'];
    else
        $sender_nome = "";
    $elimina = "";
    $stato_elimina = $row['elimina'];
    //$elimina_campaign = $page_protect->check_elimina_campaign($row['department_id']);
    $modifica_permission = $page_protect->get_modify_permission();
    $permission = $page_protect->check_permission($row['department_id']);
    $volume = number_format(round($row['volume'] / 1000, 0), 0, ',', '.');
    $volume = $row['volume'] / 1000;
    $nome_campagna_totale = substr(stripslashes($row['pref_nome_campagna']), 0);
    
    
    if (strlen($nome_campagna_totale) > 0 )
        $nome_campagna_totale = $nome_campagna_totale . "_" . substr(stripslashes($row['nome_campagna']), 0);
    else
        $nome_campagna_totale = substr(stripslashes($row['nome_campagna']), 0);
    
    if (substr($nome_campagna_totale, -1)== "_") $nome_campagna_totale = substr($nome_campagna_totale, 0,-1);

    if ($row['volume'] / 1000 < 1)
        $volume = number_format(round($row['volume'] / 1000, 1), 1, ',', '.');
    else
        $volume = number_format(round($row['volume'] / 1000, 0), 0, ',', '.');
    if ($row['optimization'] == "0")
        $optimization = "NO";
    else
        $optimization = "YES";
    $elimina = "<form name=\"eliminaCampagna\" style=\"float:left;margin-right:2px;\"  id=\"eliminaCampagna0\" action=\"./index.php?page=gestioneCampagne\" "
            . "onsubmit=\"return  conferma(" . $stato_elimina . "," . $permission . ")\" method=\"post\" style=\"margin:0px;\">
                <input type=\"image\" alt=\"Elimina\" title=\"Elimina la campagna\" name=\"elimina\"  style=\"width:14px; height:14px;\" src=\"images/Elimina.png\" value=\"elimina\" />
                <input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . $row['id'] . "\" />";
    $elimina = $elimina . "</form>";
    $modifica = "<form action=\"./index.php?page=inserisciCampagna\" onsubmit=\"return modifica($permission);\" method=\"post\"
      style=\"float:left;margin-right:2px;\">
        <input type=\"image\" alt=\"Modifica\" title=\"Modifica la campagna\" src=\"images/Modifica.png\" />
        <input type=\"hidden\" value=\"modifica\" name=\"modifica\" />
        <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" /></form>";
    $duplica = "<form action=\"./index.php?page=inserisciCampagna\" onsubmit=\"return duplica($permission);\" method=\"post\"
      style=\"float:left;margin-right:2px;\">
        <input type=\"image\" name=\"duplica\" alt=\"Duplica\" title=\"Duplica la campagna\" src=\"images/duplica.gif\"  style=\"width:14px; height:14px;\"  style=\"width:14px; height:14px;\"  value=\"duplica\" />
        <input type=\"hidden\" name=\"id\" value=\"" . $row['id'] . "\" /></form>";
/*
    $data_output['rows'][] = array(
        'id' => $row['id'],
        'cell' => array($elimina . $modifica . $duplica, $contatore, "<a href=\"#\">" . $nome_campagna_totale . "</a>",
            $row['gruppo_nome'], $row['tipo_nome'], $row['dipartimento_nome'], $row['cod_campagna'],
            $row['cod_comunicazione'], $optimization, $row['username'], $sender_nome,
            $row['channel_nome'], $row['mod_invio'], $campaign->data_eng_to_it_($row['data_inizio']),
            $campaign->data_eng_to_it_($row['data_fine']), $row['durata_campagna'], $campaign->_binary_convert($row['trial']),
            ($row['trial'] == 1 ? $campaign->data_eng_to_it_($row['data_trial']) : "n/a"),
            $campaign->_binary_convert($row['storicizza']), $row['campaign_stato_nome'], $campaign->data_ora_eng_to_it_($row['data_inserimento']), $volume)
    );
     * 
     */
    // senza campo Ottimizzazione
    $data_output['rows'][] = array(
        'id' => $row['id'],
        'cell' => array($elimina . $modifica . $duplica, $contatore, "<a href=\"#\">" . $nome_campagna_totale . "</a>",
            $row['gruppo_nome'], $row['tipo_nome'], $row['dipartimento_nome'], $row['cod_campagna'],
            $row['cod_comunicazione'], $row['username'], $sender_nome,
            $row['channel_nome'], $row['mod_invio'], $campaign->data_eng_to_it_($row['data_inizio']),
            $campaign->data_eng_to_it_($row['data_fine']), $row['durata_campagna'], $campaign->_binary_convert($row['trial']),
            ($row['trial'] == 1 ? $campaign->data_eng_to_it_($row['data_trial']) : "n/a"),
            $campaign->_binary_convert($row['storicizza']), $row['campaign_stato_nome'], $campaign->data_ora_eng_to_it_($row['data_inserimento']), $volume)
    );
    
    
    $contatore++;
}
echo json_encode($data_output);

