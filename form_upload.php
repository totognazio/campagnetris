<?php
include_once './classes/form_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once './classes/access_user/access_user_class.php';
include_once('db_config.php');
require_once './classes/PHPExcel/Classes/PHPExcel.php'; 

// require __DIR__ . '/vendor/autoload.php';
$objPHPExcel = new PHPExcel();
// include('PHPExcel/IOFactory.php');

$page_protect = new Access_user;
$form = new form_class();
$funzione = new funzioni_admin();
$campaign = new campaign_class();
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$livello_accesso = $page_protect->get_job_role();
include('action.php');

$channels = $funzione->get_list_select('channels');
// print_r($channels);
$stacks = $funzione->get_list_select('campaign_stacks');
// print_r($stacks);
$typlogies = $funzione->get_list_select('campaign_types');
// print_r($typlogies);
$squads = $funzione->get_list_select('squads');
// print_r($squads);
$states = $funzione->get_list_select('campaign_states');
// print_r($states);
//$sprints = $funzione->get_sprints();
$sprints = $funzione->get_list_select('sprints');
// print_r($sprints);
// print_r($_SESSION['user']);
$user_id = $funzione->get_id('users', $_SESSION['user'], 'login');
// print_r($users);
$campaign_types = $funzione->get_list_select('campaign_types'); //Tipologias
// print_r($campaign_types);
$campaign_stacks = $funzione->get_list_select('campaign_stacks');
// print_r($campaign_stacks);
$campaign_categories = $funzione->get_list_select('campaign_categories');
$campaign_cat_sotts = $campaign_categories = $funzione->get_list_select('campaign_cat_sott');
// print_r($campaign_cat_sotts);


$folder_name = 'upload/';

if (!empty($_FILES)) {
    $temp_file = $_FILES['file']['tmp_name'];
    $location = $folder_name . $_FILES['file']['name'];
    move_uploaded_file($temp_file, $location);
}
$result = array();
$files = scandir('upload');

$output = '<table class="table table-bordered" ><thead><tr style="background-color: #eee"><th>ID</th><th>nome_campagna</th><th>pref_nome_campagna</th><th>Stack</th><th>Squad</th><th>Tipologia</th>
<th>Note</th><th>Modalita</th><th>Tipo_Target</th><th>Priorita_PM</th><th>Descrizione_Attivita</th><th>N_Collateral</th>
<th>Stato</th><th>Tipo_Offerta</th><th>Tipo_Contratto</th><th>Mercato</th><th>Altri_Criteri</th><th>Indicatore_Dinamico</th>
<th>Call_Guide</th><th>Control_Group</th><th>Canale</th><th>Tipo</th><th>Testo_SMS</th><th>Data_Inizio</th><th>Data_Fine</th>
<th>Escludi_Sab_Dom</th><th>Durata_Campagna</th><th>Volume_Toale</th><th>Note_Operative</th></tr></thead><tr>';
if (false !== $files) {
    foreach ($files as $file) {
        if ('.' != $file && '..' != $file) {
            // echo $file . 'rahim *******';
            // include('PHPExcel/IOFactory.php');
            $objPHPExcel = PHPExcel_IOFactory::load('upload/' . $file);

            // echo "<label class='text-success'>Input data</label><br /><table class='table table-bordered'>";
            foreach ($objPHPExcel->getWorksheetIterator() as $worksheet) {
                $highestRow = $worksheet->getHighestRow();
                $data_length = 3;
                $count = 0;
                for ($row = 3; $row <= 3; $row++) {
                    // echo "<tr>";
                    $count += 1;
                    $Stack = null;
                    $Stack_raw = $worksheet->getCellByColumnAndRow(0, $row)->getValue();
                    // echo $Stack_raw . '<br/>';
                    if (in_array($Stack_raw, $campaign_stacks)) {
                        $Stack = array_search($Stack_raw, $campaign_stacks);
                        // print_r($Stack);
                    } else {
                        return;
                    }
                    $Squad = null;
                    $Squad_raw = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    // echo $Squad_raw . '<br/>';
                    if (in_array($Squad_raw, $squads)) {
                        $Squad = array_search($Squad_raw, $squads);
                        // print_r($Squad);
                    }
                    $Tipologia = null;
                    $Tipologia_raw = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    // echo $Tipologia_raw . '<br/>';
                    if (in_array($Tipologia_raw, $campaign_types)) {
                        $Tipologia = array_search($Tipologia_raw, $campaign_types);
                        // print_r($Tipologia);
                    }
                    $Note = null;
                    $Note = $worksheet->getCellByColumnAndRow(3, $row)->getValue();
                    // echo $Note . '<br/>';

                    $Modalita = null;
                    $Modalita_raw = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    // echo $Modalita_raw . '<br/>';
                    if (in_array($Modalita_raw, $campaign_stacks)) {
                        $Modalita = array_search($Modalita_raw, $campaign_stacks);
                        print_r($Modalita);
                    }

                    $Tipo_Target = null;
                    $Tipo_Target_raw = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    // echo $Tipo_Target_raw . '<br/>';
                    if (in_array($Tipo_Target_raw, $campaign_categories)) {
                        $Tipo_Target = array_search($Tipo_Target_raw, $campaign_categories);
                    }

                    $Priorita_PM = null;
                    $Priorita_PM_raw = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    // echo $Priorita_PM_raw . '<br/>';
                    $Priorita_PM_data_validation = [0, 1, 2, 3, 4, 5, 6, 7, 8, 9];
                    if (in_array($Priorita_PM_raw, $Priorita_PM_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Priorita_PM = $Priorita_PM_raw;
                    }

                    $Descrizione_Attivita = $worksheet->getCellByColumnAndRow(7, $row)->getValue();
                    // echo $Descrizione_Attivita . '<br/>';
                    $N_Collateral = $worksheet->getCellByColumnAndRow(8, $row)->getValue();

                    $Stato = null;
                    $Stato_raw = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    // echo $Stato_raw . '<br/>';
                    $Stato_data_validation = ["Attivi", "Sospesi", "Disattivi"];
                    if (in_array($Stato_raw, $Stato_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Stato = $Stato_raw;
                    }

                    $Tipo_Offerta = null;
                    $Tipo_Offerta_raw = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    // echo $Tipo_Offerta_raw . '<br/>';
                    $Tipo_Offerta_data_validation = ["Consumer", "Business", "MicroBusiness"];
                    if (in_array($Tipo_Offerta_raw, $Tipo_Offerta_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Tipo_Offerta = $Tipo_Offerta_raw;
                    }

                    $Tipo_Contratto = null;
                    $Tipo_Contratto_raw = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    // echo $Tipo_Contratto_raw . '<br/>';
                    $Tipo_Contratto_data_validation = ["Prepagato", "Postpagato", "Pre NoTax"];
                    if (in_array($Tipo_Contratto_raw, $Tipo_Contratto_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Tipo_Contratto = $Tipo_Contratto_raw;
                    }

                    $Mercato = null;
                    $Mercato_raw = $worksheet->getCellByColumnAndRow(12, $row)->getValue();
                    // echo $Mercato_raw . '<br/>';
                    $Mercato_data_validation = ["Mobile Voce", "Mobile Dati", "Fisso"];
                    if (in_array($Mercato_raw, $Mercato_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Mercato = $Mercato_raw;
                    }

                    $Altri_Criteri = $worksheet->getCellByColumnAndRow(13, $row)->getValue();
                    // echo $Altri_Criteri . '<br/>';
                    // print_r($Altri_Criteri);

                    $Indicatore_Dinamico = null;
                    $Indicatore_Dinamico_raw = $worksheet->getCellByColumnAndRow(14, $row)->getValue();
                    // echo $Indicatore_Dinamico_raw . '<br/>';
                    $Indicatore_Dinamico_data_validation = ["No", "Si"];
                    if (in_array($Indicatore_Dinamico_raw, $Indicatore_Dinamico_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Indicatore_Dinamico = $Indicatore_Dinamico_raw;
                    }

                    $Call_Guide = null;
                    $Call_Guide_raw = $worksheet->getCellByColumnAndRow(15, $row)->getValue();
                    // echo $Call_Guide_raw . '<br/>';
                    $Call_Guide_data_validation = ["No", "Si"];
                    if (in_array($Call_Guide_raw, $Call_Guide_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Call_Guide = $Call_Guide_raw;
                    }

                    $Control_Group = null;
                    $Control_Group_raw = $worksheet->getCellByColumnAndRow(16, $row)->getValue();
                    // echo $Control_Group_raw . '<br/>';
                    $Control_Group_data_validation = [0 => "No", 1 => "Si"];
                    if (in_array($Control_Group_raw, $Control_Group_data_validation)) {
                        $Control_Group = array_search($Control_Group_raw, $Control_Group_data_validation);
                        // print_r($Control_Group);
                    }

                    $Canale = $worksheet->getCellByColumnAndRow(17, $row)->getValue();
                    // echo $Canale . '<br/>';

                    $Tipo = null;
                    $Tipo_raw = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
                    // echo $Tipo_raw . '<br/>';
                    $Tipo_data_validation = ["Informativa", "MonoOfferta", "Multiofferta"];
                    if (in_array($Tipo_raw, $Tipo_data_validation)) {
                        // $Stack = array_search($Stack_raw, $stacks);
                        $Tipo = $Tipo_raw;
                    }

                    $Testo_SMS = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                    // echo $Testo_SMS . '<br/>';

                    $Data_Inizio = $worksheet->getCellByColumnAndRow(20, $row)->getValue(); // *****
                    $Data_Inizio = ($Data_Inizio - 25569) * 86400;
                    $Data_Inizio = date("Y-m-d", $Data_Inizio);
                    $Data_Inizio_year = new DateTime($Data_Inizio);
                    $Data_Inizio_year = $Data_Inizio_year->format('Y');
                    // print_r($Data_Inizio_year);
                    // print_r($Data_Inizio);

                    $Data_Fine = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                    $Data_Fine = ($Data_Fine - 25569) * 86400;
                    $Data_Fine = date("Y-m-d", $Data_Fine);
                    // echo $Data_Fine . '<br/>';
                    // print_r($Data_Fine);

                    $Escludi_Sab_Dom = null;
                    $Escludi_Sab_Dom_raw = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                    // echo $Escludi_Sab_Dom_raw . '<br/>';
                    $Escludi_Sab_Dom_data_validation = [0 => "No", 1 => "Sabato", 2 => "Domenica", 3 => "Sabato & Domenica"];
                    if (in_array($Escludi_Sab_Dom_raw, $Escludi_Sab_Dom_data_validation)) {
                        $Escludi_Sab_Dom = array_search($Escludi_Sab_Dom_raw, $Escludi_Sab_Dom_data_validation);
                        // $Escludi_Sab_Dom = $Escludi_Sab_Dom_raw;
                        // print_r($Escludi_Sab_Dom);
                    }

                    $Durata_Campagna = null;
                    $Durata_Campagna_raw = $worksheet->getCellByColumnAndRow(23, $row)->getValue();
                    // echo $Durata_Campagna_raw . '<br/>';
                    $Durata_Campagna_data_validation = [1 => "1 giorno", 2 => "2 giorni", 3 => "3 giorni", 4 => "4 giorni", 5 => "5 giorni", 6 => "6 giorni", 7 => "7 giorni"];
                    if (in_array($Durata_Campagna_raw, $Durata_Campagna_data_validation)) {
                        $Durata_Campagna = array_search($Durata_Campagna_raw, $Durata_Campagna_data_validation);
                    }

                    $Volume_Toale = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                    // echo $Volume_Toale . '<br/>';
                    // print_r($Volume_Toale);

                    $Note_Operative = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                    // echo $Note_Operative . '<br/>';

                    // (5,
                    // $id = 5; // done auto increment
                    //  '0',


                    $nome_campagna = $Data_Inizio_year . '_' . $Squad_raw . '_' . $Tipologia_raw; // done
                    //'20210412_SQC_APO_INA_Deact_Aprile_Prova',
                    $pref_nome_campagna = $nome_campagna; //**** */
                    //  '',
                    $cod_comunicazione = 'not ent'; // Done Null-Yes
                    //  '', 
                    $cod_campagna = 'cod_campagna'; // Done Null-Yes
                    // 4,
                    $stack_id = $Stack; // Done
                    //  20,
                    $type_id = $Tipologia;
                    // 21,
                    $squad_id = $Squad; // Done
                    //  104,
                    $user_id = $user_id; // Done
                    //  0,
                    $segment_id = 0; // Done Null-Yes
                    //  '0', 
                    $optimization = '0'; //Done Null-Yes
                    // 1, 
                    $priority = $Priorita_PM; //Done 
                    // '0000-00-00',
                    $data_inizio_validita_offerta = $Data_Fine; // $Data_Inizio
                    //  '2021-04-20',
                    $data_fine_validita_offerta = $Data_Fine; //$Data_Fine Done
                    //  0, 
                    $leva = 0; // Done Null-Yes
                    // '0',
                    $descrizione_leva = '0'; // Done Null-Yes
                    //  6, 
                    $campaign_state_id = 6; // Done Null-Yes ****
                    // '0', 
                    $lista_preview = '0'; // Done Null-Yes
                    // '0',
                    $lista_civetta = '0'; // Done Null-Yes
                    //  '0', 
                    $control_group = $Control_Group; // Done Null-Yes
                    // '0', 
                    $perc_control_group = '0'; // Done Null-Yes
                    // 16, 
                    $channel_id = 0; // Done Null-Yes
                    // '',
                    $channel_type = 'EMAIL'; // Drop this
                    //  '',
                    $mod_invio = '0'; // Done Null-Yes
                    //  NULL, 
                    $sender_id = 0; // Done Null-Yes
                    // '0', 
                    $storic = '0'; // Done Null-Yes
                    // '0', 
                    $testo_sms = $Testo_SMS; // Done Null-Yes
                    // '0', 
                    $link = '0'; // Done Null-Yes
                    // 0,
                    $sms_duration = 0; // Done Null-Yes
                    //  0, 
                    $tipoMonitoring = 0;
                    // '2021-04-12', 
                    $data_inizio = $Data_Inizio; // Done Null-Yes
                    // 100000,
                    $volumeGiornaliero1 = 0;
                    // 0, 
                    $volumeGiornaliero2 = 0;
                    // 0,
                    $volumeGiornaliero3 = 0;
                    // 0, 
                    $volumeGiornaliero4 = 0;
                    // 0, 
                    $volumeGiornaliero5 = 0;
                    // 0,
                    $volumeGiornaliero6 = 0;
                    // 0,
                    $volumeGiornaliero7 = 0;
                    // '2021-04-12',
                    $data_fine = '2021-04-12'; // Done Null-Yes
                    // '0',
                    $escludi_sab_dom = $Escludi_Sab_Dom;
                    // 1, 
                    $durata_campagna = $Durata_Campagna; // Done Null-Yes
                    // '0', 
                    $trial_campagna = '0';
                    // '0000-00-00',
                    $data_trial = '2021-04-20'; // Done Null-Yes
                    // 0,
                    $volume_trial = 0; // Done Null-Yes
                    // '0', 
                    $perc_scostamento = '0'; // Done Null-Yes
                    // 100000,
                    $volume = $Volume_Toale; // Done Null-Yes
                    // '0', 
                    $attivi = '0'; // Done Null-Yes
                    // '0', 
                    $sospesi = '0'; // Done Null-Yes
                    // '0', 
                    $disattivi = '0'; // Done Null-Yes
                    // '0', 
                    $consumer = '0'; // Done Null-Yes
                    // '0',
                    $business = '0'; // Done Null-Yes
                    // '0', 
                    $microbusiness = '0'; // Done Null-Yes
                    // '0', 
                    $prepagato = '0'; // Done Null-Yes
                    // '0', 
                    $postpagato = '0'; // Done Null-Yes
                    // '0', 
                    $contratto_microbusiness = '0'; // Done Null-Yes
                    // '0', 
                    $cons_profilazione = '0'; // Done Null-Yes
                    // '0',
                    $cons_commerciale = '0'; // Done Null-Yes
                    // '0',
                    $cons_terze_parti = '0'; // Done Null-Yes
                    // '0',
                    $cons_geolocalizzazione = '0'; // Done Null-Yes
                    // '0', 
                    $cons_enrichment = '0'; // Done Null-Yes
                    // '0', 
                    $cons_trasferimentidati = '0'; // Done Null-Yes
                    // '0',
                    $voce = '0'; // Done Null-Yes
                    // '0',
                    $dati = '0'; // Done Null-Yes
                    // '0', 
                    $fisso = '0'; // Done Null-Yes
                    // '0'
                    $no_frodi = '0'; // Done Null-Yes
                    // '0', 
                    $altri_filtri = '0'; // Done Null-Yes
                    // '0', 
                    $etf = '0'; // Done Null-Yes
                    // '0', 
                    $vip = '0'; // Done Null-Yes
                    // '0', 
                    $dipendenti = '0'; // Done Null-Yes
                    // '0',
                    $trial = '0'; // Done Null-Yes
                    // 0, 
                    $parlanti_ultimo = 0; // Done Null-Yes
                    // '0', 
                    $profilo_rischio_ga = '0'; // Done Null-Yes
                    // '0', 
                    $profilo_rischio_standard = '0'; // Done Null-Yes
                    // '0', 
                    $profilo_rischio_high_risk = '0'; // Done Null-Yes
                    // NULL, 
                    $altri_criteri = $Altri_Criteri; // Done Null-Yes
                    // '2021-04-20 15:39:29',
                    $data_inserimento = date("Y-m-d H:i:s");
                    //  NULL, 
                    $redemption = 'text'; // Done Null-Yes
                    // 0,
                    $storicizza = 0; //Done no need
                    // 0, 
                    $offer_id = 0; // Done no need
                    // 1, 
                    $modality_id = 1;
                    // 1, 
                    $category_id = 1;
                    // 0, 
                    $tit_sott_id = 0; // Done no need
                    // '',
                    $descrizione_target = 'descrizione_target';
                    // '0', 
                    $leva_offerta = '0'; // Done Null-Yes
                    // '0', 
                    $descrizione_offerta = '0'; // Done no need
                    // '0',
                    $indicatore_dinamico = $Indicatore_Dinamico;
                    // 'mono',
                    $tipo_leva = 'mono'; // Done Null-Yes
                    // NULL,
                    $cod_ropz = 0; // Done Null-Yes
                    // NULL,
                    $cod_opz = 0; // Done Null-Yes
                    // '0', 
                    $id_news = '0'; // Done Null-Yes
                    // NULL, 
                    $note_operative = $Note_Operative; //$Note_Operative; // Done
                    // 0, 
                    $cat_sott_id = 0;
                    // 'Deact_Aprile_Prova', 
                    $note_camp = 'a'; // Done Null-Yes
                    // '0', 
                    $alias_attiv = '0'; //Done no need
                    // 0, 
                    $day_val = 0; //Done no need
                    // '0', 
                    $sms_incarico = '0'; //Done no need
                    // '0',
                    $sms_target = '0'; //Done no need
                    // '0', 
                    $sms_adesione = '0'; //Done no need
                    // '0', 
                    $sms_nondisponibile = '0';
                    // '0', 
                    $control_guide = '0';
                    // 0,
                    $numeric_control_group = 0;
                    // 3),
                    $n_collateral = 3;
                    // '{\"0\":{\"channel_id\":\"16\",\"sender_id\":\"66\",\"storicizza\":\"0\",\"notif_consegna\":\"0\",\"testo_sms\":\"\",\"charTesto\":\"\",\"numero_sms\":\"0\",\"mod_invio\":\"Standard\",\"link\":\"\",\"charLink\":\"255\",\"numero_totale\":\"\",\"tit_sott_pos\":\"\",\"cat_sott_id\":\"1\",\"day_val_pos\":\"\",\"callguide_pos\":\"\",\"alias_attiv\":\"\",\"day_val\":\"\",\"sms_incarico\":\"\",\"sms_target\":\"\",\"sms_adesione\":\"\",\"sms_nondisponibile\":\"\",\"id_news_app_inbound\":\"\",\"day_val_app_inbound\":\"\",\"prior_app_inbound\":\"1\",\"callguide_app_inbound\":\"\",\"id_news_app_outbound\":\"\",\"day_val_app_outbound\":\"\",\"notif_app_outbound\":\"0\",\"prior_app_outbound\":\"1\",\"callguide_app_outbound\":\"\",\"count_iniziative_dealer\":\"1\",\"Cod_iniziativa\":\"\",\"Cod_iniziativa2\":\"\",\"Cod_iniziativa3\":\"\",\"Cod_iniziativa4\":\"\",\"Cod_iniziativa5\":\"\",\"Cod_iniziativa6\":\"\",\"Cod_iniziativa7\":\"\",\"Cod_iniziativa8\":\"\",\"Cod_iniziativa9\":\"\",\"day_val_icm\":\"\",\"callguide_icm\":\"\",\"day_val_ivr_inbound\":\"\",\"day_val_ivr_outbound\":\"\",\"data_invio_jakala\":\"12\\/04\\/2021\",\"data_invio_spai\":\"12\\/04\\/2021\",\"type_mfh\":\"\",\"note_mfh\":\"\",\"type_watson\":\"\",\"contact_watson\":\"\",\"funnel\":\"\"}}', 
                    $addcanale_array_data = array(
                        'channel_id' => $channel_id, 'sender_id' => $sender_id, 'storicizza' => $storicizza,
                        'storicizza' => $storicizza, 'testo_sms' => $testo_sms,
                        'mod_invio' => $mod_invio, 'link' => $link,
                        'cat_sott_id' => $cat_sott_id, 'day_val' => $day_val,
                        'alias_attiv' => $alias_attiv, 'day_val' => $day_val, 'sms_incarico' => $sms_incarico,
                        'sms_target' => $sms_target, 'sms_adesione' => $sms_adesione, 'sms_nondisponibile' => $sms_nondisponibile,
                    );
                    $addcanale_json = json_encode(array('0' => $addcanale_array_data), JSON_FORCE_OBJECT);
                    // print_r($addcanale_json);
                    $addcanale = $addcanale_json;



                    // $query = "INSERT INTO campaigns(sender_id, storicizza , notif_consegna , testo_sms, charTesto, numero_sms,
                    // mod_invio, link, charLink, numero_totale, tit_sott_pos, cat_sott_id, day_val_pos, callguide_pos, testo_sms_pos,
                    // charTesto_pos, numero_sms_pos, alias_attiv, day_val, sms_incarico, sms_target, sms_adesione, sms_nondisponibile,
                    // id_news_app_inbound, day_val_app_inbound, prior_app_inbound, callguide_app_inbound, id_news_app_outbound, day_val_app_outbound,
                    // notif_app_outbound, prior_app_outbound, callguide_app_outbound, count_iniziative_dealer, Cod_iniziativa, Cod_iniziativa2,
                    // Cod_iniziativa3, Cod_iniziativa4, Cod_iniziativa5, Cod_iniziativa6, Cod_iniziativa7,Cod_iniziativa8, Cod_iniziativa9,
                    // day_val_icm, callguide_icm,day_val_ivr_inbound, day_val_ivr_outbound, data_invio_jakala,data_invio_spai,
                    // type_mfh, type_watson, contact_watson, funnel) VALUES ('" . $fullname . "', '" . $student_number . "','" . $grade . "','" . $term . "')";

                    // '{\"0\":{\"channel_id\":\"16\",\"sender_id\":\"66\",\"storicizza\":\"0\",\"notif_consegna\":\"0\",
                    // \"testo_sms\":\"\",\"charTesto\":\"\",\"numero_sms\":\"0\",\"mod_invio\":\"Standard\",\"link\":\"\",\"charLink\":\"255\",
                    // \"numero_totale\":\"\",\"tit_sott_pos\":\"\",\"cat_sott_id\":\"1\",\"day_val_pos\":\"\",\"callguide_pos\":\"\",
                    // \"alias_attiv\":\"\",\"day_val\":\"\",\"sms_incarico\":\"\",\"sms_target\":\"\",\"sms_adesione\":\"\",\"sms_nondisponibile\":\"\",
                    // \"id_news_app_inbound\":\"\",\"day_val_app_inbound\":\"\",\"prior_app_inbound\":\"1\",
                    // \"callguide_app_inbound\":\"\",\"id_news_app_outbound\":\"\",\"day_val_app_outbound\":\"\",
                    // \"notif_app_outbound\":\"0\",\"prior_app_outbound\":\"1\",\"callguide_app_outbound\":\"\",
                    // \"count_iniziative_dealer\":\"1\",\"Cod_iniziativa\":\"\",\"Cod_iniziativa2\":\"\",
                    // \"Cod_iniziativa3\":\"\",\"Cod_iniziativa4\":\"\",\"Cod_iniziativa5\":\"\",
                    // \"Cod_iniziativa6\":\"\",\"Cod_iniziativa7\":\"\",\"Cod_iniziativa8\":\"\",
                    // \"Cod_iniziativa9\":\"\",\"day_val_icm\":\"\",\"callguide_icm\":\"\",
                    // \"day_val_ivr_inbound\":\"\",\"day_val_ivr_outbound\":\"\",\"data_invio_jakala\":\"12\\/04\\/2021\",
                    // \"data_invio_spai\":\"12\\/04\\/2021\",\"type_mfh\":\"\",\"note_mfh\":\"\",\"type_watson\":\"\",
                    // \"contact_watson\":\"\",\"funnel\":\"\"}}', 
                    // $addcanale_array_data = array(
                    //     'channel_id' => $channel_id, 'sender_id' => $sender_id, 'storicizza' => $storicizza,
                    //     'storicizza' => $storicizza, 'notif_consegna' => $notif_consegna, 'testo_sms' => $testo_sms, 'charTesto' => $charTesto,
                    //     'numero_sms' => $numero_sms, 'mod_invio' => $mod_invio, 'Standard' => $Standard, 'link' => $link, 'charLink' => $charLink,
                    //     'numero_totale' => $numero_totale, 'tit_sott_pos' => $tit_sott_pos, 'cat_sott_id' => $cat_sott_id, 'day_val_pos' => $day_val_pos,
                    //     'callguide_pos' => $callguide_pos, 'alias_attiv' => $alias_attiv, 'day_val' => $day_val, 'sms_incarico' => $sms_incarico,
                    //     'sms_target' => $sms_target, 'sms_adesione' => $sms_adesione, 'sms_nondisponibile' => $sms_nondisponibile,
                    //     'id_news_app_inbound' => $id_news_app_inbound, 'day_val_app_inbound' => $day_val_app_inbound, 'prior_app_inbound' => $prior_app_inbound,
                    //     'callguide_app_inbound' => $callguide_app_inbound, 'id_news_app_outbound' => $id_news_app_outbound, 'day_val_app_outbound' => $day_val_app_outbound,
                    //     'notif_app_outbound' => $notif_app_outbound, 'prior_app_outbound' => $prior_app_outbound, 'callguide_app_outbound' => $callguide_app_outbound,
                    //     'count_iniziative_dealer' => $count_iniziative_dealer, 'Cod_iniziativa' => $Cod_iniziativa, 'Cod_iniziativa2' => $Cod_iniziativa2,
                    //     'Cod_iniziativa3' => $Cod_iniziativa3, 'Cod_iniziativa4' => $Cod_iniziativa4, 'Cod_iniziativa5' => $Cod_iniziativa5,
                    //     'Cod_iniziativa6' => $Cod_iniziativa6, 'Cod_iniziativa7' => $Cod_iniziativa7, 'Cod_iniziativa8' => $Cod_iniziativa8,
                    //     'Cod_iniziativa9' => $Cod_iniziativa9, 'day_val_icm' => $day_val_icm, 'callguide_icm' => $callguide_icm,
                    //     'day_val_ivr_inbound' => $day_val_ivr_inbound, 'day_val_ivr_outbound' => $day_val_ivr_outbound, 'data_invio_jakala' => $data_invio_jakala,
                    //     'data_invio_spai' => $data_invio_spai, 'type_mfh' => $type_mfh, 'note_mfh' => $note_mfh, 'type_watson' => $type_watson,
                    //     'contact_watson' => $contact_watson, 'funnel' => $funnel
                    // );



                    $query = "INSERT INTO campaigns(nome_campagna, pref_nome_campagna, cod_comunicazione, 
                    cod_campagna, stack_id, type_id, squad_id, user_id, segment_id, optimization, 
                    priority, data_inizio_validita_offerta, data_fine_validita_offerta, leva, 
                    descrizione_leva, campaign_state_id, lista_preview, lista_civetta, control_group,
                    perc_control_group, channel_id, channel_type, mod_invio, sender_id, storic, 
                    testo_sms, link, sms_duration, tipoMonitoring, data_inizio, volumeGiornaliero1, 
                    volumeGiornaliero2,volumeGiornaliero3, volumeGiornaliero4, volumeGiornaliero5, 
                    volumeGiornaliero6, volumeGiornaliero7, data_fine, escludi_sab_dom, durata_campagna, 
                    trial_campagna, data_trial, volume_trial, perc_scostamento, volume, attivi,
                    sospesi, disattivi, consumer, business, microbusiness, prepagato, 
                    postpagato, contratto_microbusiness, cons_profilazione, cons_commerciale, 
                    cons_terze_parti,cons_geolocalizzazione, cons_enrichment, cons_trasferimentidati, 
                    voce, dati, fisso, no_frodi, altri_filtri, etf, vip, dipendenti, trial, 
                    parlanti_ultimo, profilo_rischio_ga, profilo_rischio_standard, profilo_rischio_high_risk,
                    altri_criteri, data_inserimento, redemption, storicizza, offer_id, modality_id,
                    category_id, tit_sott_id, descrizione_target, leva_offerta, descrizione_offerta,
                    indicatore_dinamico, tipo_leva, cod_ropz, cod_opz, id_news, note_operative,
                    cat_sott_id, addcanale, note_camp, alias_attiv, day_val, sms_incarico, 
                    sms_target, sms_adesione, sms_nondisponibile, control_guide, 
                    numeric_control_group, n_collateral) VALUES('" . $nome_campagna . "','" . $pref_nome_campagna . "','" .
                        $cod_comunicazione . "','" . $cod_campagna . "'," . $stack_id . "," . $type_id . "," . $squad_id . "," .
                        $user_id . "," . $segment_id . ",'" . $optimization . "'," . $priority . ",'" . $data_inizio_validita_offerta . "','" .
                        $data_fine_validita_offerta . "'," . $leva . ",'" . $descrizione_leva . "'," . $campaign_state_id . ",'" .
                        $lista_preview . "','" . $lista_civetta . "','" . $control_group . "','" . $perc_control_group . "'," . $channel_id . ",'" .
                        $channel_type . "','" . $mod_invio . "'," . $sender_id . ",'" . $storic . "','" . $testo_sms . "','" . $link . "'," .
                        $sms_duration . "," . $tipoMonitoring . ",'" . $data_inizio . "'," . $volumeGiornaliero1 . "," .
                        $volumeGiornaliero2 . "," . $volumeGiornaliero3 . "," . $volumeGiornaliero4 . "," . $volumeGiornaliero5 . "," .
                        $volumeGiornaliero6 . "," . $volumeGiornaliero7 . ",'" . $data_fine . "','" . $escludi_sab_dom . "'," . $durata_campagna . ",'" .
                        $trial_campagna . "','" . $data_trial . "'," . $volume_trial . ",'" . $perc_scostamento . "'," . $volume . ",'" . $attivi . "','" .
                        $sospesi . "','" . $disattivi . "','" . $consumer . "','" . $business . "','" . $microbusiness . "','" . $prepagato . "','" .
                        $postpagato . "','" . $contratto_microbusiness . "','" . $cons_profilazione . "','" . $cons_commerciale . "','" .
                        $cons_terze_parti . "','" . $cons_geolocalizzazione . "','" . $cons_enrichment . "','" . $cons_trasferimentidati . "','" .
                        $voce . "','" . $dati . "','" . $fisso . "','" . $no_frodi . "','" . $altri_filtri . "','" . $etf . "','" .
                        $vip . "','" . $dipendenti . "','" . $trial . "'," . $parlanti_ultimo . ",'" . $profilo_rischio_ga . "','" .
                        $profilo_rischio_standard . "','" . $profilo_rischio_high_risk . "','" . $altri_criteri . "','" .
                        $data_inserimento . "','" . $redemption . "'," . $storicizza . "," . $offer_id . "," . $modality_id . "," .
                        $category_id . "," . $tit_sott_id . ",'" . $descrizione_target . "','" . $leva_offerta . "','" . $descrizione_offerta . "','" .
                        $indicatore_dinamico . "','" . $tipo_leva . "','" . $cod_ropz . "','" . $cod_opz . "','" . $id_news . "','" . $note_operative . "'," .
                        $cat_sott_id . ",'" . $addcanale . "','" . $note_camp . "','" . $alias_attiv . "','" . $day_val . "','" . $sms_incarico . "','" .
                        $sms_target . "','" . $sms_adesione . "','" . $sms_nondisponibile . "','" . $control_guide . "'," .
                        $numeric_control_group . "," . $n_collateral . ")";
                    // import data into database
                    $funzione->mysqli->query($query) or die($query . " - " . $funzione->mysqli->error);

                    $output .= '<td>' . $count . '</td>';
                    $output .= '<td>' . $nome_campagna . '</td>';
                    $output .= '<td>' . $pref_nome_campagna . '</td>';
                    $output .= '<td>' . $Stack . '</td>';
                    $output .= '<td>' . $Squad . '</td>';
                    $output .= '<td>' . $Tipologia . '</td>';
                    $output .= '<td>' . $Note . '</td>';
                    $output .= '<td>' . $Modalita . '</td>';
                    $output .= '<td>' . $Tipo_Target . '</td>';
                    $output .= '<td>' . $Priorita_PM . '</td>';
                    $output .= '<td>' . $Descrizione_Attivita . '</td>';
                    $output .= '<td>' . $N_Collateral . '</td>';
                    $output .= '<td>' . $Stato . '</td>';
                    $output .= '<td>' . $Tipo_Offerta . '</td>';
                    $output .= '<td>' . $Tipo_Contratto . '</td>';
                    $output .= '<td>' . $Mercato . '</td>';
                    $output .= '<td>' . $Altri_Criteri . '</td>';
                    $output .= '<td>' . $Indicatore_Dinamico . '</td>';
                    $output .= '<td>' . $Call_Guide . '</td>';
                    $output .= '<td>' . $Control_Group . '</td>';
                    $output .= '<td>' . $Canale . '</td>';
                    $output .= '<td>' . $Tipo . '</td>';
                    $output .= '<td>' . $Testo_SMS . '</td>';
                    $output .= '<td>' . $Data_Inizio . '</td>';
                    $output .= '<td>' . $Data_Fine . '</td>';
                    $output .= '<td>' . $Escludi_Sab_Dom . '</td>';
                    $output .= '<td>' . $Durata_Campagna . '</td>';
                    $output .= '<td>' . $Volume_Toale . '</td>';
                    $output .= '<td>' . $Note_Operative . '</td>';
                    $output .= '</tr>';
                    // print_r($output);

                    // mysqli_query($conn, $query);

                }
            }
        }
        // unset($objPHPExcel);

    }
}
$output .= '</table>';
echo $output;
