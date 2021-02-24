<?php

include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once("./classes/access_user/access_user_class.php");

$funzioni_admin = new funzioni_admin();
$page_protect = new Access_user;
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$livello_accesso = $page_protect->get_job_role();
$hello_name = ($page_protect->user_full_name != "") ? $page_protect->user_full_name : $page_protect->user;
if (isset($_GET['action']) && $_GET['action'] == "log_out") {
    $page_protect->log_out(); // the method to log off
}

$campaign = new campaign_class();
//print_r($_POST);

//inserimento campagna
if (isset($_POST['azione']) and $_POST['azione']=='new') {   
    if ($page_protect->get_insert_permission()) {
        $result = $campaign->insert($_POST);
        if ($result == "1")
            $result = "La campagna è stata inserita correttamente";
    } else {
        $result = "L'utente non ha i diritti di inseirmento";
    }   
}

//inserimento campagna
if (isset($_POST['azione']) and $_POST['azione']=='duplica') {   
    if ($page_protect->get_insert_permission()) {
        $result = $campaign->insert($_POST);
        if ($result == "1")
            $result = "La campagna è stata inserita correttamente";
    } else {
        $result = "L'utente non ha i diritti di inseirmento";
    }   
}

//modifica campagna
if (isset($_POST['azione']) and $_POST['azione']=='modifica') {
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
    $squad_id = $id_campaign['squad_id'];
    $permission = $page_protect->check_permission($squad_id);
    if ($permission) {
        if (isset($_POST['modifica_confim'])) {
            $result = $campaign->update($_POST, $_POST['id']);
            if (is_numeric($result))
                $result = "La campagna è stata modificata";
        }
    } else {
        $result = "L'utente non pu&ograve; modificare l'articolo";
    }
}
//eliminazione Campagna
if (isset($_POST['azione']) and $_POST['azione']=='elimina') {
    if (isset($_POST['id'])) {
        $id = intval($_POST['id']);
        $result = $campaign->delete_campaign($id);
    }
}

if (isset($_POST['nofiletr']) and $_POST['nofiletr']=='nofiletr') {

    $result = $campaign->reset_filter();
    
}



