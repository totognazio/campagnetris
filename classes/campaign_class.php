<?php

include_once 'db_config.php';
include_once("./classes/access_user/access_user_class.php");
include_once './classes/funzioni_admin.php';
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of campaign_class
 *
 * @author vanhelsing
 */
class campaign_class  {

//put your code here
    var $mysqli;
    var $radici_list;
    var $lista_parametri_campagna;
    var $lista_rules;
    var $filter_view;
    
    
    function __construct() {
        $mysqli = $this->connect_dbli();
        $this->filter_view = array();
        $this->radici_list = array('channel' => 'channels', 'stack' => 'campaign_stacks', 'state' => 'campaign_states', 'squad' => 'squads', 'type' => 'campaign_types');
        $this->lista_parametri_campagna = array("nome_campagna", "pref_nome_campagna", "cod_comunicazione", "cod_campagna", "stack_id", "type_id", "squad_id", "user_id", "segment_id", "optimization", "priority", "data_inizio_validita_offerta", "data_fine_validita_offerta", "leva", "descrizione_leva", "campaign_state_id", "lista_preview", "lista_civetta", "control_group", "perc_control_group", "channel_id", "channel_type", "mod_invio", "sender_id", "storic", "testo_sms", "link", "sms_duration", "tipoMonitoring", "data_inizio", "volumeGiornaliero1", "volumeGiornaliero2", "volumeGiornaliero3", "volumeGiornaliero4", "volumeGiornaliero5", "volumeGiornaliero6", "volumeGiornaliero7", "data_fine", "escludi_sab_dom", "durata_campagna", "trial_campagna", "data_trial", "volume_trial", "perc_scostamento", "volume", "attivi", "sospesi", "disattivi", "consumer", "business", "microbusiness", "prepagato", "postpagato", "contratto_microbusiness", "cons_profilazione", "cons_commerciale", "cons_terze_parti", "cons_geolocalizzazione", "cons_enrichment", "cons_trasferimentidati", "voce", "dati", "fisso", "no_frodi", "altri_filtri", "etf", "vip", "dipendenti", "trial", "parlanti_ultimo", "profilo_rischio_ga", "profilo_rischio_standard", "profilo_rischio_high_risk", "altri_criteri", "data_inserimento", "redemption", "storicizza", "offer_id", "modality_id", "category_id", "tit_sott_id", "descrizione_target", "leva_offerta", "descrizione_offerta", "indicatore_dinamico", "tipo_leva", "opzione_leva", "id_taglio", "id_news", "note_operative");
        $this->lista_rules = array(
            'attivi'
            , 'sospesi'
            , 'consumer'
            , 'business'
            , 'prepagato'
            , 'postpagato'
            , 'cons_profilazione'
            , 'cons_commerciale'
            , 'checkboxAdesso3'
            , 'voce'
            , 'dati'
            , 'no_frodi'
            , 'no_collection'
            , 'etf'
            , 'vip'
            , 'dipendenti'
            , 'trial'
            , 'parlanti_ultimo'
            , 'profilo_rischio_ga'
            , 'profilo_rischio_standard'
            , 'profilo_rischio_high_risk');
    }

    function connect_dbli() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
//echo DB_SERVER." - ". DB_USER." - ". DB_PASSWORD." - ". DB_NAME;
    }

    function data_eng_to_it_($var) {
        $temp = explode("-", $var);
        if (count($temp) > 2) {
            list($aaaa, $mm, $gg) = $temp;
            $result = $gg . "-" . $mm . "-" . $aaaa;
        } else
            $result = "01-01-1970";
        return $result;
    }

    function data_ora_eng_to_it_($var) {

        $temp = explode(" ", $var);
        $result = $this->data_eng_to_it_($temp[0]) . " " . $temp[1];
        return $result;
    }

    function data_it_to_eng_($var) {
//echo $var;
        if ($var != "") {
            $i = explode("/", $var);
            if (count($i) > 1) {
                list($gg, $mm, $aaa) = explode("/", $var);
                $result = $aaa . "-" . $mm . "-" . $gg;
                //echo $result."<br>";
                return $result;
            } else {
                list($gg, $mm, $aaa) = explode("-", $var);

                $result = $aaa . "-" . $mm . "-" . $gg;
//echo $var." ".$result."<br> ";
                return $result;
            }
        } else
            return "1969-10-06";
    }

    function _binary_convert($var) {
//echo $var;
        if ($var == "1") {
            return 'Yes';
        } elseif ($var == "0") {
            return 'No';
        }
    }

    function _insert_field($nome_tabella, $nome, $campaign_stack_id = NULL, $channel_id = NULL) {
        if ($channel_id == NULL) {
            $query3 = "SELECT count(*) FROM $nome_tabella where name='$nome'";
            $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
            $row = $results->fetch_array();
        } else {
            $query3 = "SELECT count(*) FROM $nome_tabella where name='$nome' and channel_id=$channel_id";
//echo $query3 . "<br>";
            $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
            $row = $results->fetch_array();
        }
        if ($row[0] == 0) {
            if ($campaign_stack_id != NULL) {
                $query3 = "INSERT INTO `$nome_tabella`(`name`,campaign_stack_id) VALUES ('$nome','$campaign_stack_id')";
                $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
            } elseif ($channel_id != NULL) {
                $query3 = "INSERT INTO `$nome_tabella`(`name`,channel_id) VALUES ('$nome','$channel_id')";
                $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
            } else {
                if ($nome != "") {
                    $query3 = "INSERT INTO `$nome_tabella`(`name`) VALUES ('$nome')";
                    $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
                } else
                    return NULL;
            }
        }
//echo $query3."--".$row[0]."<br>";
        $query3 = "SELECT id FROM $nome_tabella where name='$nome'";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row['id'];
    }

    function _insert_field_login($nome_tabella, $nome, $squad_id) {
        $query3 = "SELECT count(*) FROM $nome_tabella where login='$nome'";
//echo $query3 . "<br>";
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        if ($row[0] == 0) {
            $query3 = "INSERT INTO `$nome_tabella`(`login`,squad_id) VALUES ('$nome',$squad_id)";
            $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        }
//echo $query3."--".$row[0]."<br>";
        $query3 = "SELECT id FROM $nome_tabella where login='$nome'";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row['id'];
    }

    function _update_login($nome_tabella, $login, $nome, $cognome, $ruolo) {
        $query3 = "SELECT id FROM `job_roles`  where name='$ruolo'"; //  login='$login'";
//echo $query3 . "<br>";
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $job_role = $results->fetch_array();
        $query3 = "SELECT id FROM `users`  where login='$login'"; //  login='$login'";
//echo $query3 . "<br>";
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $user = $results->fetch_array();
        if ($job_role['id'] != "") {
            $query3 = "UPDATE `users` SET `lastname` = '" . htmlspecialchars($cognome, ENT_QUOTES)
                    . "', `firstname` = '" . htmlspecialchars($nome, ENT_QUOTES) . "',`job_role_id`=" . $job_role['id'] . " WHERE `users`.`id` = '" . $user['id'] . "';";
//echo $query3. "<br>";
            $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        }
    }

    function readLine_campaign($file, $lista_utenti) {
//echo $file."<br>";
//echo $lista_utenti."<br>";
        $delimiter = "\n";
        $inizio = time();
        $fp = fopen($file, 'r');
        $contatore_fallimenti = 0;
        $contatore = 0;
        $volume_giornaliero = array('volumeGiornaliero1', 'volumeGiornaliero2', 'volumeGiornaliero3', 'volumeGiornaliero4', 'volumeGiornaliero5', 'volumeGiornaliero6', 'volumeGiornaliero7');

//$buffer = stream_get_line($fp, 2048, $delimiter);
        while (!feof($fp)) {
            $record = array();
            $buffer = '';
            $buffer = stream_get_line($fp, 2048, $delimiter);
            if (strlen($buffer) > 3) {
                $pieces = explode("\";\"", $buffer);
                foreach ($pieces as $key => $value) {
                    $pieces[$key] = mb_convert_encoding($value, 'UTF-8', 'UTF-8');
                }
//print_r($pieces);
//echo "<br /><br />";
                $record['nome_campagna'] = $pieces['1'];
                $record['stack_id'] = $this->_insert_field('campaign_stacks', $pieces['2']);
                $record['type_id'] = $this->_insert_field('campaign_types', $pieces['3'], $record['stack_id']);
                $record['squad_id'] = $this->_insert_field('squads', $pieces['4']);
                $record['user_id'] = $this->_insert_field_login('users', $pieces['5'], $record['squad_id']);
                if ($pieces['6'] == 'NO')
                    $record['caricamento_massivo'] = 0;
                else
                    $record['caricamento_massivo'] = 1;
                if ($pieces['7'] == 'NO')
                    $record['optimization'] = 0;
                else
                    $record['optimization'] = 1;
                $record['priority'] = $pieces['8'];
                //$record['data_inizio_validita_offerta'] = $this->data_it_to_eng_($pieces['9']);
                $record['data_inizio_validita_offerta'] = $pieces['9'];
                $record['data_fine_validita_offerta'] = $pieces['10'];
                if ($pieces['11'] == 'NO')
                    $record['leva'] = 0;
                else
                    $record['leva'] = 1;
                $record['descrizione_leva'] = $pieces['12'];
                $record['campaign_state_id'] = $this->_insert_field('campaign_states', $pieces['13']);
                $record['lista_preview'] = $pieces['14'];
                if ($pieces['15'] == 'NO')
                    $record['lista_civetta'] = 0;
                else
                    $record['lista_civetta'] = 1;
                if ($pieces['16'] == 'NO')
                    $record['control_group'] = 0;
                else
                    $record['control_group'] = 1;
                $record['perc_control_group'] = $pieces['17'];
//$record['perc_control_group'] = 0;
                $record['channel_id'] = $this->_insert_field('channels', $pieces['18']);
                $record['mod_invio'] = $pieces['19'];
                if ($pieces['20'] != "")
                    $record['sender_id'] = $this->_insert_field('senders', $pieces['20'], NULL, $record['channel_id']);
                else
                    $record['sender_id'] = NULL;
                if ($pieces['21'] == 'NO')
                    $record['storico'] = 0;
                else
                    $record['storico'] = 1;
                $record['testo_sms'] = $pieces['22'];
                $record['link'] = $pieces['23'];
                $record['sms_duration'] = $pieces['24'];
                $record['data_inizio'] = $pieces['25'];
                $record['data_fine'] = $pieces['26'];
                $record['durata_campagna'] = $pieces['27'];
                if ($pieces['28'] == 'NO')
                    $record['trial_campagna'] = 0;
                else
                    $record['trial_campagna'] = 1;
                $record['data_trial'] = $pieces['29'];
                $record['volume_trial'] = $pieces['30'];
                $record['perc_scostamento'] = $pieces['31'];
                $record['volume'] = $pieces['32'];
                $numero = round(($record['volume'] - $record['volume_trial']) / $record['durata_campagna'], 0);
                for ($h = 0; $h < $record['durata_campagna']; $h++) {
                    $record[$volume_giornaliero[$h]] = $numero;
                }
                if ($pieces['33'] == 'NO')
                    $record['attivi'] = '0';
                else
                    $record['attivi'] = '1';
                if ($pieces['34'] == 'NO')
                    $record['sospesi'] = '0';
                else
                    $record['sospesi'] = '1';
                if ($pieces['35'] == 'NO')
                    $record['consumer'] = '0';
                else
                    $consumer = '1';
                if ($pieces['36'] == 'NO')
                    $record['business'] = '0';
                else
                    $record['business'] = '1';
                if ($pieces['37'] == 'NO')
                    $record['prepagato'] = '0';
                else
                    $record['prepagato'] = '1';
                if ($pieces['38'] == 'NO')
                    $record['postpagato'] = '0';
                else
                    $record['postpagato'] = '1';
                if ($pieces['39'] == 'NO')
                    $record['cons_profilazione'] = '0';
                else
                    $record['cons_profilazione'] = '1';
                if ($pieces['40'] == 'NO')
                    $record['cons_commerciale'] = '0';
                else
                    $record['cons_commerciale'] = '1';
                if ($pieces['41'] == 'NO')
                    $record['voce'] = '0';
                else
                    $record['voce'] = '1';
                if ($pieces['42'] == 'NO')
                    $record['dati'] = '0';
                else
                    $record['dati'] = '1';
                if ($pieces['43'] == 'NO')
                    $record['no_frodi'] = '0';
                else
                    $record['no_frodi'] = '1';
                if ($pieces['44'] == 'NO')
                    $record['no_collection'] = '0';
                else
                    $record['no_collection'] = '1';
                if ($pieces['45'] == 'NO')
                    $record['etf'] = '0';
                else
                    $record['etf'] = '1';
                if ($pieces['46'] == 'NO')
                    $record['vip'] = '0';
                else
                    $record['vip'] = '1';
                if ($pieces['47'] == 'NO')
                    $record['dipendenti'] = '0';
                else
                    $record['dipendenti'] = '1';
                if ($pieces['48'] == 'NO')
                    $record['trial'] = '0';
                else
                    $record['trial'] = '1';
                if ($pieces['49'] == 'NO')
                    $record['profilo_rischio_ga'] = '0';
                else
                    $record['profilo_rischio_ga'] = '1';
                if ($pieces['50'] == 'NO')
                    $record['profilo_rischio_standard'] = '0';
                else
                    $record['profilo_rischio_standard'] = '1';
                if ($pieces['51'] == 'NO')
                    $record['profilo_rischio_standard'] = '0';
                else
                    $record['profilo_rischio_standard'] = '1';
                if ($pieces['52'] == 'NO')
                    $record['profilo_rischio_high_risk'] = '0';
                else
                    $record['vprofilo_rischio_high_risk'] = '1';
                $record['altri_criteri'] = $pieces['53'];
//                echo "<br /><br />";
//                //print_r($record);
//                echo "<br /><br />";
                $res = $this->insert($record);
                if ($res == 1)
                    $contatore++;
                else
                    echo "<p>" . $record['nome_campagna'] . " - " . $this->insert($record) . "</p>";
            }
        }

        $tabella_utenti = array();
        $fp_utenti = fopen($lista_utenti, 'r');
        while (!feof($fp_utenti)) {
            $record = array();
            $buffer = '';
            $buffer = stream_get_line($fp_utenti, 2048, $delimiter);
//$this->_update_login($nome_tabella, $login, $nome, $cognome, $ruolo)
//echo $buffer."<br>";
            if (strlen($buffer) > 3) {
                $pieces = explode("\";\"", $buffer);
                $this->_update_login('users', $pieces['3'], $pieces['2'], $pieces['1'], $pieces['4']);
            }
        }
        return $contatore;
//
//                $query_dati = "INSERT INTO $table (`Marca`,`Modello`,`TacId`,`mobile_radio_access`, `Tecnologia`,OS,`Tipo`) VALUES (";
//                $controllo = true;
//                foreach ($pieces as $key => $value) {
//                    if ($key == 4) {
//                        if ($value == "MODEM") {
//                            $value = "MBB";
//                        } elseif ($value == "ROUTER") {
//                            $value = "MBB";
//                        } elseif ($value == "NETBOOK") {
//                            $value = "MBB";
//                        }
//                    }
//
//                    if ($key < 7) {
//                        $value = str_replace("'", "", trim($value));
//                        $valore_dato = addslashes(str_replace(';', ' ', str_replace('"', '', trim($value))));
//                        if ($valore_dato == "")
//                            $valore_dato = "n/a";
//                        $query_dati = $query_dati . " '" . $valore_dato . "'";
//                        if ($key < 6)
//                            $query_dati = $query_dati . ",";
//                    }
//                }
//
//                $query_dati = $query_dati . ")";
//                //echo $query_dati."<br>";
//
//                mysql_query($query_dati) or die($query_dati . " - " . mysql_error());
//            }
//        }
//
//        $query_a = "update dati_tacid set Tipo= 'Smartphone'  where Tipo = 'YES'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set Tipo= 'Featurephone'  where Tipo = 'NO'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set Tecnologia= 'Phablet',Tipo='Phablet'  where Tecnologia = 'PHABLET'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set Tipo='MBB'  where Tecnologia = 'MBB'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set Tecnologia= 'Handset'  where Tecnologia = 'HANDSET'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set Tecnologia= 'Tablet',Tipo='Tablet'  where Tecnologia = 'TABLET'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set Tecnologia= 'Datacard',Tipo='Datacard'  where Tecnologia = 'DATACARD'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $query_a = "update dati_tacid set mobile_radio_access= '3G'  where mobile_radio_access = 'SATELLITE'";
//        mysql_query($query_a) or die($query_dati . " - " . mysql_error());
//        $fine = time();
//        $tempo_impiegato = $fine - $inizio;
//        echo "<br><p>Tempo query:" . $tempo_impiegato . "</p>";
//        return true;
    }

    function get_channel_ext1() {
        $sql = "SELECT id from channels  where ext_1=1 or ext_1=12 ";
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result);
            return $export;
        }
    }
    
    function get_channel_ext3() {
        $sql = "SELECT id from channels  where ext_3=1 ";
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result);
            return $export;
        }
    }

    function get_state_order($state_id, $border) {
        $sql = "SELECT ordinamento FROM `campaign_states` where id= $state_id";
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result);
            return $export;
        }
    }

    function calcola_data_fine($data_inizio, $durata_campagna_start, $escludi_sab_dom) {
        // 0  1-sab  2--dom   3-sab e dom
        $timestamp = strtotime($data_inizio);
        $list_day = array();
        $start = date('d', $timestamp);
        $mese = date('m', $timestamp);
        $anno = date('Y', $timestamp);
        if ($escludi_sab_dom==1)
            $durata_campagna = $durata_campagna_start + 1 + floor(($durata_campagna_start / 7));
        elseif($escludi_sab_dom==2)
            $durata_campagna = $durata_campagna_start + 1 + floor(($durata_campagna_start / 7)) * 2;
        elseif($escludi_sab_dom==3)
            $durata_campagna = $durata_campagna_start + 2 + floor(($durata_campagna_start / 7)) * 2;   
        elseif($escludi_sab_dom==0)
            $durata_campagna = $durata_campagna_start;      

        $contatore = 1;
        for ($d = $start; $d < $start + $durata_campagna; $d++) {

            if ($escludi_sab_dom==3 and (date('D', mktime(0, 0, 0, $mese, $d, $anno)) != "Sun") and (date('D', mktime(0, 0, 0, $mese, $d, $anno)) != "Sat")) {
               //echo date('D', mktime(0, 0, 0, $mese, $d, $anno)) . "<br>";
                    if ($contatore == $durata_campagna_start) {
//echo date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                        return date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                    }
                    $contatore++;
                
            }
                elseif ($escludi_sab_dom==2 and (date('D', mktime(0, 0, 0, $mese, $d, $anno)) != "Sun") ) {
//echo date('D', mktime(0, 0, 0, $mese, $d, $anno)) . "<br>";

                        if ($contatore == $durata_campagna_start) {
//echo date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                            return date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                        }
                        $contatore++;
                    
                } 
                elseif ($escludi_sab_dom==1 and (date('D', mktime(0, 0, 0, $mese, $d, $anno)) != "Sat") ) {
//echo date('D', mktime(0, 0, 0, $mese, $d, $anno)) . "<br>";

                        if ($contatore == $durata_campagna_start) {
//echo date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                            return date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                        }
                        $contatore++;
                    
                } 
                elseif ($escludi_sab_dom==0) {
//echo date('D', mktime(0, 0, 0, $mese, $d, $anno)) . "<br>";

                        if ($contatore == $durata_campagna_start) {
//echo date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                            return date('Y-m-d', mktime(0, 0, 0, $mese, $d, $anno));
                        }
                        $contatore++;
                    
                }
            
        }
    }

    function calcola_settimana_corrente() {
        $ts = strtotime(date('Y-m-d'));
        $start = (date('w', $ts) == 0) ? $ts : strtotime('last sunday', $ts);
        $end = date('Y-m-d', strtotime('next saturday', $start));

        $begin = date('Y-m-d', $start);
        $export = array();
        $export['mese_end'] = $mese = date('m', strtotime('next saturday', $start));
        $export['anno_end'] = $anno = date('Y', strtotime('next saturday', $start));
        $export['mese_start'] = date('m', $start);
        $export['anno_start'] = $anno = date('Y', $start);
        $export['giorno_start'] = date('d', $start);
        $export['giorno_end'] = date('d', strtotime('next saturday', $start));
        if (date('Y') < $export['anno_end']) {
            $export['anno_end'] = date('Y');
        }
        if (date('Y') > $export['anno_start']) {
            $export['anno_start'] = date('Y');
        }
        /* if (date('m') < $export['mese_end']) {
          $export['mese_end'] = date('m');
          $export['giorno_end'] = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
          }
          if (date('m') > $export['mese_start']) {
          $export['mese_start'] = date('m');
          $export['giorno_start'] = 1;
          } */


//print_r($export);
        return $export;
    }

    function calcola_settimana_prossima() {
        $ts = strtotime(date('Y-m-d'));
        $start = (date('w', $ts) == 0) ? $ts : strtotime('next monday', $ts);
        $end = date('Y-m-d', strtotime('next saturday', $start));

        $begin = date('Y-m-d', $start);
        $export = array();
        $export['mese_end'] = $mese = date('m', strtotime('next saturday', $start));
        $export['anno_end'] = $anno = date('Y', strtotime('next saturday', $start));
        $export['mese_start'] = date('m', $start);
        $export['anno_start'] = $anno = date('Y', $start);
        $export['giorno_start'] = date('d', $start);
        $export['giorno_end'] = date('d', strtotime('next saturday', $start));
        if (date('Y') < $export['anno_end']) {
            $export['anno_end'] = date('Y');
        }
        if (date('Y') > $export['anno_start']) {
            $export['anno_start'] = date('Y');
        }
        /* if (date('m') < $export['mese_end']) {
          $export['mese_end'] = date('m');
          $export['giorno_end'] = cal_days_in_month(CAL_GREGORIAN, date('m'), date('Y'));
          }
          if (date('m') > $export['mese_start']) {
          $export['mese_start'] = date('m');
          $export['giorno_start'] = 1;
          } */


//print_r($export);
        return $export;
    }

    function FirstLastWeek($data) {
        list($giorno, $mese, $anno) = explode('/', $data);
        $w = date('w', mktime(0, 0, 0, $mese, $giorno, $anno));
        $day['W'] = date('W', mktime(0, 0, 0, $mese, $giorno, $anno));
        $giorni = array(0 => 'Sunday', 1 => 'Monday', 2 => 'Tuesday', 3 => 'Wednesday',
            4 => 'Thursday', 5 => 'Friday', 6 => 'Saturday');
        $day['giorno'] = $giorni[$w];
        $day['anno'] = $anno;
        if ($w == 0) {
            $day['lunedi'] = date('d/m/Y', mktime(0, 0, 0, $mese, $giorno - 6, $anno));
            $day['domenica'] = date('d/m/Y', mktime(0, 0, 0, $mese, $giorno, $anno));
        } else {
            $day['lunedi'] = date('d/m/Y', mktime(0, 0, 0, $mese, $giorno - $w + 1, $anno));
            $day['domenica'] = date('d/m/Y', mktime(0, 0, 0, $mese, $giorno - $w + 7, $anno));
        }
        return $day;
    }

    function calcola_intervallo_mese() {
        $export = array();
        if (intval($_SESSION['selectMese']) < 12) {
            $export['anno_start'] = $export['anno_end'] = $_SESSION['selectAnno'];
            $export['mese_start'] = $export['mese_end'] = $_SESSION['selectMese'] + 1;
            $export['giorno_start'] = 1;
            $export['giorno_end'] = 31;
        } elseif (intval($_SESSION['selectMese']) == 12) {
            $_SESSION['selectAnno'] = date('Y');
            $time = mktime(12, 0, 0, date('m'), date('d'), date('Y'));
            $export['mese_start'] = $export['mese_end'] = date('m', $time);
            $export['anno_start'] = $export['anno_end'] = date('Y', $time);
            $export['giorno_end'] = $export['giorno_start'] = date('d', $time);
        } elseif (intval($_SESSION['selectMese']) == 13) {
            $_SESSION['selectAnno'] = date('Y');
            $time = mktime(12, 0, 0, date('m'), date('d') - 1, date('Y'));
            $export['mese_start'] = $export['mese_end'] = date('m', $time);
            $export['anno_start'] = $export['anno_end'] = date('Y', $time);
            $export['giorno_end'] = $export['giorno_start'] = date('d', $time);
        } elseif (intval($_SESSION['selectMese']) == 15) {
            $_SESSION['selectAnno'] = date('Y');
            $time = mktime(12, 0, 0, date('m'), date('d') + 1, date('Y'));
            $export['mese_start'] = $export['mese_end'] = date('m', $time);
            $export['anno_start'] = $export['anno_end'] = date('Y', $time);
            $export['giorno_end'] = $export['giorno_start'] = date('d', $time);
        } elseif (intval($_SESSION['selectMese']) == 16) {
            $time = mktime(12, 0, 0, 1, 1, $_SESSION['selectAnno']);
            $export['mese_start'] = 1;
            $export['mese_end'] = 12;
            $export['anno_start'] = $export['anno_end'] = date('Y', $time);
            $export['giorno_end'] = 31;
            $export['giorno_start'] = 1;
        } elseif (intval($_SESSION['selectMese']) == 14) {
            $result = $this->calcola_settimana_corrente();
            $_SESSION['selectAnno'] = date('Y');
            $export['mese_start'] = $result['mese_start'];
            $export['anno_start'] = $result['anno_start'];
            $export['mese_end'] = $result['mese_end'];
            $export['anno_end'] = $result['anno_end'];
            $export['giorno_start'] = $result['giorno_start'];
            $export['giorno_end'] = $result['giorno_end'];
        } elseif (intval($_SESSION['selectMese']) == 17) {
            $result = $this->calcola_settimana_prossima();
            $_SESSION['selectAnno'] = date('Y');
            $export['mese_start'] = $result['mese_start'];
            $export['anno_start'] = $result['anno_start'];
            $export['mese_end'] = $result['mese_end'];
            $export['anno_end'] = $result['anno_end'];
            $export['giorno_start'] = $result['giorno_start'];
            $export['giorno_end'] = $result['giorno_end'];
        }
        //print_r ($export);
        return $export;
    }

    function volume_per_giorno($giorni_campagna, $volume_giornaliero) {
        $result = array();
        foreach ($giorni_campagna as $key => $value) {
            $result[$value] = $volume_giornaliero[$key];
        }
        return $result;
    }

    function somma_volume_per_giorno($giorni_campagna, $volume_giornaliero) {
        $result = 0;
        foreach ($giorni_campagna as $key => $value) {
            if ($volume_giornaliero[$key] / 1000 < 1)
                $_m = round($volume_giornaliero[$key] / 1000, 1);
            else
                $_m = round($volume_giornaliero[$key] / 1000, 0);
            $result = $_m + $result;
        }
        return $result;
    }

    function calcola_giorni_campagna($time, $durata, $escludi_sab_dom) {
        $d = date('d', $time);
        $m = date('m', $time);
        $y = date('Y', $time);
        $contatore = 0;
        $result = array();

        while ($durata > 0) {
            $giorno = date('D', mktime(0, 0, 0, $m, $d + $contatore, $y));
            if (!($giorno == "Sat") && !($giorno == "Sun")) {
                $result[] = mktime(0, 0, 0, $m, $d + $contatore, $y);
                $durata--;
            } else if (($giorno == "Sat") && !$escludi_sab_dom) {
                $result[] = mktime(0, 0, 0, $m, $d + $contatore, $y);
                $durata--;
            }
            $contatore++;
        }
        return $result;
    }

    function get_channel_ext2() {
        $sql = "SELECT id from channels  where ext_2=1 ";

        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result);
            return $export;
        }
    }

    function get_list_kick_off($start, $end, $state) {
        $sortSql = " order by data_inizio asc";
        $filter = "where  (`data_inizio` >= '" . $start . "' AND `data_inizio` <= '" . $end . "') and (campaign_states.id = '$state')";
        $sql = "SELECT users.LOGIN AS username
	,campaign_types.NAME AS tipo_nome
	,campaign_stacks.NAME AS stack_nome
	,squads.NAME AS squad_nome
	,senders.NAME AS sender_nome
	,channels.NAME AS channel_nome
	,campaign_states.NAME AS campaign_stato_nome
	,campaigns.*
FROM campaigns
LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
LEFT JOIN squads ON `squad_id` = squads.id
LEFT JOIN campaign_types ON `type_id` = campaign_types.id
LEFT JOIN senders ON `sender_id` = senders.id
LEFT JOIN channels ON campaigns.`channel_id` = channels.id
LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
LEFT JOIN users ON `user_id` = users.id
        $filter  $sortSql";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $data_output = array();
        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
            if ($row['sender_nome'] == NULL)
                $sender_nome = "";
            else
                $sender_nome = $row['sender_nome'];
            $data_output[] = array('id' => $row['id'],
                'nome_campagna' => $row['nome_campagna'],
                'stack_nome' => $row['stack_nome'],
                'tipo_nome' => $row['tipo_nome'],
                'channel_nome' => $row['channel_nome'],
                'optimization' => $row['optimization'],
                'data_inizio' => $row['data_inizio'],
                'data_fine' => $row['data_fine'],
                'volume' => round($row['volume'] / 1000, 0) . "K",
                'campaign_stato_nome' => $row['campaign_stato_nome']);
        }
        return $data_output;
    }

    function get_list_campaign_rules_sintesi($searchSql = "", $order = "") {
        $sortSql = " order by data_inizio asc";
//$filter = "where  (`data_inizio` >= '" . $start . "' AND `data_inizio` <= '" . $end . "') and (campaign_states.id = '$state')";
        $sql = "SELECT users.LOGIN AS username
	,campaign_types.NAME AS tipo_nome
	,campaign_stacks.NAME AS stack_nome
	,squads.NAME AS squad_nome
	,senders.NAME AS sender_nome
	,channels.NAME AS channel_nome
	,campaign_states.NAME AS campaign_stato_nome
	,campaign_rules.*
FROM campaign_rules
LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
LEFT JOIN squads ON `squad_id` = squads.id
LEFT JOIN campaign_types ON `type_id` = campaign_types.id
LEFT JOIN senders ON `sender_id` = senders.id
LEFT JOIN channels ON campaign_rules.`channel_id` = channels.id
LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
LEFT JOIN users ON `user_id` = users.id
    $searchSql     $sortSql";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $data_output = array();
        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {
            if ($row['sender_nome'] == NULL)
                $sender_nome = "";
            else
                $sender_nome = $row['sender_nome'];
            $data_output[] = array('id' => $row['id'],
                'nome_campagna' => $row['nome_campagna'],
                'stack_nome' => $row['stack_nome'],
                'tipo_nome' => $row['tipo_nome'],
                'channel_nome' => $row['channel_nome'],
                'optimization' => $row['optimization'],
                'data_inizio' => $row['data_inizio'],
                'data_fine' => $row['data_fine'],
                'volume' => round($row['volume'] / 1000, 0) . "K",
                'campaign_stato_nome' => $row['campaign_stato_nome']);
        }
        return $data_output;
    }

    function send_email($subj, $msg) {
//echo $msg;
        $page_protect = new Access_user();
        $mail_list = $page_protect->get_maillist();
        $mail_list_string = "";
        foreach ($mail_list as $key => $value) {
            $mail_list_string = $mail_list_string . ";" . $value;
        }
        $page_protect->send_mail_list($mail_list, $msg, $subj);
    }

    function update_kickoff($lista_id, $value_update) {
//print_r($lista_id);

        $sql = "UPDATE `campaigns` SET `campaign_state_id` = '$value_update'";
        $where = " WHERE ";
        foreach ($lista_id as $key => $value) {
            $where = $where . "  `campaigns`.`id` = $value or";
        }
        $where = substr($where, 0, -2);
        $sql = $sql . $where;
//echo "<BR />".$sql."<BR />";

        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $numero_row = $this->mysqli->affected_rows;
        $msg = "Sono stati modificate " . $numero_row . " campagne";
        $subj = "Campaign managment: Cambio Stato";
        $page_protect = new Access_user();

        $mail_list = $page_protect->get_maillist();
//print_r($mail_list);
        $mail_list_string = "";
        foreach ($mail_list as $key => $value) {
            $mail_list_string = $mail_list_string . ";" . $value;
        }
        $page_protect->send_mail_list($mail_list, $msg, $subj);

        return "Record aggiornati: " . $numero_row . " ";
    }

    function delete_campaign($id) {
        $id_campaign = $this->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
        
        
        
        $page_protect = new Access_user;
        $permission = $page_protect->check_permission($id_campaign['squad_id']);
//print_r($lista_id);
        if ($permission) {
            $sql = "DELETE FROM  `campaigns` WHERE `campaigns`.`id` = '$id'";
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            return "Record eliminati: " . $this->mysqli->affected_rows . " ";
        } else {
            return "L'utente non può eliminare la campagna ";
        }
    }

    function delete_campaign_rules($id) {
//print_r($lista_id);
        $sql = "DELETE FROM .`campaign_rules` WHERE `campaign_rules`.`id` = '$id'";
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        return "Record eliminati: " . $this->mysqli->affected_rows . " ";
    }

    function duplicate_campaign($id) {
        $id_campaign = $this->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
        $page_protect = new Access_user;
        $permission = $page_protect->check_permission($id_campaign['squad_id']);
//print_r($lista_id);
        if ($permission) {
//print_r($lista_id);
            $sql = "CREATE TEMPORARY TABLE temp_table AS SELECT * FROM campaigns WHERE id=$id;";
//echo $sql;
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            $sql = "ALTER TABLE temp_table DROP id;";
//echo $sql;
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            $sql = "ALTER TABLE temp_table ADD `id` INT NULL DEFAULT NULL FIRST;";
//echo $sql;
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            $sql = "INSERT INTO campaigns SELECT * FROM temp_table;";
//echo $sql;
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            //$retur_string = "Record duplicati: " . $this->mysqli->affected_rows . " ";
            $retur_string = $this->mysqli->insert_id;
            $sql = "DROP TEMPORARY TABLE temp_table;";
//echo $sql;
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            return $retur_string;
        } else {
            return 0;
        }
    }

    function insert_rule($record) {
//print_r($lista_id);

        $lista_variabili = "";
        $lista_valori = "";
        foreach ($this->lista_parametri_campagna as $key => $value) {
            $temp = explode('_', $value);
            if (isset($_POST[$value])) {
                $valore_inviato = $_POST[$value];
                if ($valore_inviato != "") {
                    if ($temp[0] == 'data') {
                        $lista_variabili = $lista_variabili . "`" . $value . "`,";
                        $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string($this->data_it_to_eng_($valore_inviato)) . "',";
                    } else {
                        $lista_variabili = $lista_variabili . "`" . $value . "`,";
                        $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string($valore_inviato) . "',";
                    }
                }
            }
        }
        $lista_variabili = $lista_variabili . " `data_inserimento`";
        $lista_valori = $lista_valori . " '" . date("Y-m-d H:i:s") . "'";
        $sql = "INSERT INTO `campaign_rules` (" . $lista_variabili . ")VALUES (" . $lista_valori . ")";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        return "Record inserito correttamente";
    }

    function my_mysql_query($query, $conn = false) {
        $res = $this->mysqli->query($query);
        if (!$res) {
            $errno = $this->mysqli->errno;
            $error = $this->mysqli->error;
//echo $errno;

            switch ($errno) {
                case 1062:
                    throw new Exception("Record duplicato");
                    break;
                default:
                    throw new Exception($error);
                    break;
            }
        }
        return $res;
// ...
// doing something
// ...
        if ($something_is_wrong) {
            throw new Exception("Logic exception while performing query result processing");
        }
    }

function insert($record) {
//print_r($lista_id);
echo 'dentro la insert ';
        print_r($_POST);
        //print_r($_POST);
        $lista_variabili = "";
        $lista_valori = "";
        
        foreach ($this->lista_parametri_campagna as $key=>$value) {
            echo $value. "<br/>";
            $temp = explode('_', $value);
            if ($value == "data_fine") {

                if ($record['data_inizio'] != "" && $record['durata_campagna'] != "") {
                    $data_inizio = $this->mysqli->real_escape_string($this->data_it_to_eng_($record['data_inizio']));
                    $durata_campagna = $this->mysqli->real_escape_string($record['durata_campagna']);
                    if (isset($record['escludi_sab_dom'])) {
                        $escludi_sab_dom = $this->mysqli->real_escape_string($record['escludi_sab_dom']);
                    } else
                        $escludi_sab_dom = 0;
                    $lista_variabili = $lista_variabili . "`" . $value . "`,";
echo "weee data fine ".$data_inizio.'  '. $durata_campagna.'  '. $escludi_sab_dom.'  '.$this->calcola_data_fine($data_inizio, $durata_campagna, $escludi_sab_dom);
                    $lista_valori = $lista_valori . "'" . $this->calcola_data_fine($data_inizio, $durata_campagna, $escludi_sab_dom) . "', ";
                }
            } elseif (isset($record[$value])) {

                if ($value == "pref_nome_campagna") {
                    if (substr($record[$value], -1, 1) == "_")
                        $valore_inviato = substr($record[$value], 0, -1);
                    else
                        $valore_inviato = $record[$value];
                    $lista_variabili = $lista_variabili . "`" . $value . "`,";
                    $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string(addslashes($valore_inviato)) . "',";
                } else {
                    $valore_inviato = $record[$value];
echo $value . " - " . $valore_inviato . "<br/>";
                    if (strlen($valore_inviato) > 0) {
//echo $value . " - " . $valore_inviato . "<br/>";
                        if ($temp[0] == 'data') {
                            $lista_variabili = $lista_variabili . "`" . $value . "`,";
                            $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string($this->data_it_to_eng_($valore_inviato)) . "',";
                        } else {

                            $lista_variabili = $lista_variabili . "`" . $value . "`,";
                            $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string(addslashes($valore_inviato)) . "',";
                        }
                    }
                }
            }
        }
		
	/*			
        if (!is_numeric($record['offer_id']) ) {        
            $funzioni_admin = new funzioni_admin();
            $offer_id = $funzioni_admin->get_offerId($record['stringa_ccm']);    
            $lista_variabili = $lista_variabili . " `offer_id`,";
            $lista_valori = $lista_valori . " '" . $offer_id . "',";     
        }
    */    

        $lista_variabili = $lista_variabili . " `data_inserimento`";
        $lista_valori = $lista_valori . " '" . date("Y-m-d  H:i:s") . "'";

        $sql = "INSERT INTO `campaigns` (" . $lista_variabili . ")VALUES (" . $lista_valori . ")";

        echo "<br/>" . $sql . "<br/>";
        try {
            $res = $this->my_mysql_query($sql);
            $page_protect = new Access_user;
            $user_info = $page_protect->get_user_id();
//L'utente Rattini Marco ha modificato lo stato della campagna “Nome Campagna�? in RICHIESTA. Data inizio campagna 21/03/2016.
            //$this->send_email("[CTM] Nuova campagna: " . $_POST['nome_campagna'] . "", "L'utente '" . $this->get_firtname($user_info) . " " . $this->get_lastname($user_info) . "' ha inserito una nuova campagna '" . $_POST['nome_campagna'] . "'. Data inizio campagna: " . $_POST['data_inizio'] . ".");
        } catch (MySQLDuplicateKeyException $e) {
// duplicate entry exception
            return $e->getMessage();
        } catch (MySQLException $e) {
// other mysql exception (not duplicate key entry)
            return $e->getMessage() . " - " . $sql;
        } catch (Exception $e) {
// not a MySQL exception
            return $e->getMessage() . " - " . $sql;
        }
        return $res;
    }

    function update($record, $id_campagne) {
//print_r($record);
        $send_email = 0;
        $id_state = $this->get_state($id_campagne);
        $lista_variabili = "";
        $lista_valori = "";
        foreach ($this->lista_parametri_campagna as $key => $value) {
            //if ($value != "squad_id") {
            $temp = explode('_', $value);
            if ($value == "data_fine") {

                if ($_POST['data_inizio'] != "" && $_POST['durata_campagna'] != "") {
                    $data_inizio = $this->mysqli->real_escape_string($this->data_it_to_eng_($_POST['data_inizio']));
                    $durata_campagna = $this->mysqli->real_escape_string($_POST['durata_campagna']);
                    if (isset($_POST['escludi_sab_dom'])) {
                        $escludi_sab_dom = $this->mysqli->real_escape_string($_POST['escludi_sab_dom']);
                    } else
                        $escludi_sab_dom = 0;
                    $lista_variabili = $lista_variabili . "`data_fine`='" . $this->calcola_data_fine($data_inizio, $durata_campagna, $escludi_sab_dom) . "', ";
                }
            } elseif (isset($_POST[$value])) {
                $valore_inviato = $_POST[$value];
                if ($valore_inviato != "") {
                    if ($temp[0] == 'data') {

                        $lista_variabili = $lista_variabili . " `" . $value . "`='" . $this->mysqli->real_escape_string($this->data_it_to_eng_($valore_inviato)) . "',";
                    } elseif ($value == "pref_nome_campagna") {
                        if (substr($record[$value], -1, 1) == "_")
                            $valore_inviato = substr($record[$value], 0, -1);
                        else
                            $valore_inviato = $record[$value];
                        $lista_variabili = $lista_variabili . "`" . $value . "`='" . $this->mysqli->real_escape_string(addslashes($valore_inviato)) . "',";
                    } else {
                        if ($value == "campaign_state_id") {
                            //if (($this->get_state_eliminabile($id_campagne) > 0) && ($valore_inviato != $id_state)) {
                            if ($valore_inviato == $this->get_state_invio_email()) {
                                $send_email = 1;
                            }
                        }
                        if ($value != "user_id") {
                            $lista_variabili = $lista_variabili . " `" . $value . "`='" . $this->mysqli->real_escape_string($valore_inviato) . "',";
                        }
                    }
                } elseif ($value == "cod_comunicazione") {
                    $lista_variabili = $lista_variabili . " `" . $value . "`='',";
                } elseif ($value == "cod_campagna") {
                    $lista_variabili = $lista_variabili . " `" . $value . "`='',";
                } elseif ($value == "link") {
                    $lista_variabili = $lista_variabili . " `" . $value . "`='',";
                }elseif ($value == "nome_campagna") {
                    $lista_variabili = $lista_variabili . " `" . $value . "`='',";
                }
            } elseif ($value != "sender_id") {
                $lista_variabili = $lista_variabili . " `" . $value . "`='0',";
            } else {
                $lista_variabili = $lista_variabili . " `" . $value . "`= NULL,";
            }
            //}
        }

        $lista_variabili = substr($lista_variabili, 0, -1);
        $sql = "UPDATE `campaigns` SET " . $lista_variabili . " where id='" . $id_campagne . "';";
        //echo $sql;
        $page_protect = new Access_user;
        $user_info = $page_protect->get_user_id();
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        if ($send_email) {
//L'utente Rattini Marco ha modificato lo stato della campagna “Nome Campagna�? in RICHIESTA. Data inizio campagna 21/03/2016.
            $this->send_email("[CTM] La campagna " .$_POST['pref_nome_campagna']. "_". $_POST['nome_campagna'] . " ha cambiato stato", "L'utente '" . $this->get_firtname($user_info) . " " . $this->get_lastname($user_info) . "' ha modificato lo stato della campagna '" .$_POST['pref_nome_campagna']. "_" . $_POST['nome_campagna'] . "' in " . $this->get_state_name($this->get_state($id_campagne)) . ". Data inizio campagna: " . $_POST['data_inizio'] . ".");
        }
        return "Campagna modificata correttamente";
    }

    function get_state_eliminabile($id) {
        $query3 = "SELECT count(*)
FROM campaigns
LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
    where campaigns.id=$id and elimina=1";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function get_state_invio_email() {
        $query3 = "SELECT id
FROM campaign_states where invio_email=1";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function get_state($id) {
        $query3 = "SELECT campaign_state_id FROM campaigns where id=$id";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function get_state_name($id) {
        $query3 = "SELECT name FROM campaign_states where id=$id";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
//echo $row[0];
        return $row[0];
    }

    function get_firtname($id) {
        $query3 = "SELECT firstname FROM users where id=$id";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function get_lastname($id) {
        $query3 = "SELECT lastname FROM users where id=$id";
//echo $query3;
        $results = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function update_rule($record, $id_campagne) {
//print_r($lista_id);

        $lista_variabili = "";
        $lista_valori = "";
        foreach ($this->lista_parametri_campagna as $key => $value) {
            $temp = explode('_', $value);
            if (isset($_POST[$value])) {
                $valore_inviato = $_POST[$value];
                if ($valore_inviato != "") {
                    if ($temp[0] == 'data') {
                        $lista_variabili = $lista_variabili . " `" . $value . "`='" . $this->mysqli->real_escape_string($this->data_it_to_eng_($valore_inviato)) . "',";
                    } else {
                        $lista_variabili = $lista_variabili . " `" . $value . "`='" . $this->mysqli->real_escape_string($valore_inviato) . "',";
                    }
                }
            } elseif ($value != "sender_id") {
                $lista_variabili = $lista_variabili . " `" . $value . "`='0',";
            } else {
                $lista_variabili = $lista_variabili . " `" . $value . "`= NULL,";
            }
        }
        if ($_POST['data_inizio'] != "" && $_POST['durata_campagna'] != "") {
            $data_inizio = $this->mysqli->real_escape_string($this->data_it_to_eng_($_POST['data_inizio']));
            $durata_campagna = $this->mysqli->real_escape_string($_POST['durata_campagna']);
            if (isset($_POST['escludi_sab_dom'])) {
                $escludi_sab_dom = $this->mysqli->real_escape_string($_POST['escludi_sab_dom']);
            } else
                $escludi_sab_dom = 0;
//
            $lista_variabili = $lista_variabili . "`data_fine`='" . $this->calcola_data_fine($data_inizio, $durata_campagna, $escludi_sab_dom) . "'";
        }else {
            $lista_variabili = substr($lista_variabili, 0, -1);
        }
        $sql = "UPDATE `campaign_rules` SET " . $lista_variabili . " where id=" . $id_campagne . ";";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        return "Campagna modificata correttamente";
    }

    function get_list_campaign($searchSql, $order = "") {
        $sql = "SELECT durata_campagna
	,escludi_sab_dom
	,users.LOGIN AS username
	,campaign_types.NAME AS tipo_nome
	,campaign_stacks.NAME AS stack_nome
	,squads.NAME AS squad_nome
	,senders.NAME AS sender_nome
	,channels.NAME AS channel_nome
	,campaign_states.NAME AS campaign_stato_nome
	,campaign_states.colore AS colore
	,campaign_states.elimina AS elimina
        ,campaign_states.ordinamento AS ordinamento_stato
        ,offers.description as offer_description
        ,offers.id as offer_id
        ,offers.name as offer_name
        ,offers.label as stringa_ccm
	,campaigns.*
FROM campaigns
LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
LEFT JOIN squads ON `squad_id` = squads.id
LEFT JOIN campaign_types ON `type_id` = campaign_types.id
LEFT JOIN senders ON `sender_id` = senders.id
LEFT JOIN channels ON campaigns.`channel_id` = channels.id
LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
LEFT JOIN users ON `user_id` = users.id
LEFT JOIN offers ON `offer_id` = offers.id
LEFT JOIN campaign_modalities ON `campaign_modalities`.id = campaigns.`modality_id`
LEFT JOIN campaign_categories ON `campaign_categories`.id = campaigns.`category_id`
LEFT JOIN campaign_titolo_sottotitolo ON `campaign_titolo_sottotitolo`.id = campaigns.`tit_sott_id`


        $searchSql $order ";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        return $results;
    }

    function get_list_campaign_rule($searchSql, $order = "") {
        $sql = "SELECT durata_campagna
	,escludi_sab_dom
	,users.LOGIN AS username
	,campaign_types.NAME AS tipo_nome
	,campaign_stacks.NAME AS stack_nome
	,squads.NAME AS squad_nome
	,senders.NAME AS sender_nome
	,channels.NAME AS channel_nome
	,campaign_states.NAME AS campaign_stato_nome
	,campaign_states.colore AS colore
	,campaign_states.elimina AS elimina
	,campaign_rules.*
FROM campaign_rules
LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
LEFT JOIN squads ON `squad_id` = squads.id
LEFT JOIN campaign_types ON `type_id` = campaign_types.id
LEFT JOIN senders ON `sender_id` = senders.id
LEFT JOIN channels ON campaign_rules.`channel_id` = channels.id
LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
LEFT JOIN users ON `user_id` = users.id

        $searchSql $order ";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        return $results;
    }

    function get_total_campaign($searchSql) {
        $sql = "SELECT count(*) FROM (
    SELECT users.LOGIN AS username
	,campaign_types.NAME AS tipo_nome
	,campaign_stacks.NAME AS stack_nome
	,squads.NAME AS squad_nome
	,senders.NAME AS sender_nome
	,channels.NAME AS channel_nome
	,campaign_states.NAME AS campaign_stato_nome
        ,campaign_states.elimina AS elimina
	,campaigns.* FROM campaigns 
    left join campaign_stacks on `stack_id`=campaign_stacks.id 
    left join squads on `squad_id`=squads.id 
    left join campaign_types on `type_id`=campaign_types.id 
    LEFT JOIN senders ON `sender_id` = senders.id
    left join channels on  campaigns.`channel_id`=channels.id 
    left join campaign_states on `campaign_state_id`=campaign_states.id
    left join users on `user_id`=users.id
        $searchSql ) as table_temp";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function set_filter_session() {
        $funzioni_admin = new funzioni_admin();
        if (isset($_POST['selectAnno']))
            $_SESSION['selectAnno'] = intval($_POST['selectAnno']);
        if (isset($_POST['selectMese']))
            $_SESSION['selectMese'] = intval($_POST['selectMese']);
        foreach ($this->radici_list as $key_table => $value_table) {
            $list = $funzioni_admin->get_list_id($value_table);
            $radice = $key_table . "_";
            foreach ($list as $key => $value) {
                if (isset($_POST[$radice . $value['id']])) {
                    $_SESSION[$radice . $value['id']] = $_POST[$radice . $value['id']];
                } else {
                    $_SESSION[$radice . $value['id']] = 0;
                }
            }
        }
    }

    function reset_filter_session() {
        $funzioni_admin = new funzioni_admin();
        foreach ($this->radici_list as $key_table => $value_table) {
            $list = $funzioni_admin->get_list_id($value_table);
            $radice = $key_table . "_";
            foreach ($list as $key => $value) {
//if (isset($_POST[$radice . $value['id']])) {
                $_SESSION[$radice . $value['id']] = 1;
//} 
            }
        }
    }

    function set_filter_session_single($nome_filtro, $nome_tabella, $nome_canale) {
        $funzioni_admin = new funzioni_admin();
        $list = $funzioni_admin->get_list_id($nome_tabella);
        $radice = $nome_canale . "_";

        foreach ($list as $key => $value) {
            if ($nome_filtro == $key)
                $_SESSION[$radice . $value['id']] = 1;
            else
                $_SESSION[$radice . $value['id']] = 0;
        }
    }

    function get_volume_campaign($searchSql) {
        $sql = "SELECT sum(volume) as totale_volume FROM campaigns 
    left join campaign_stacks on `stack_id`=campaign_stacks.id 
    left join squads on `squad_id`=squads.id 
    left join campaign_types on `type_id`=campaign_types.id 
    LEFT JOIN senders ON `sender_id` = senders.id
    left join channels on  campaigns.`channel_id`=channels.id 
    left join campaign_states on `campaign_state_id`=campaign_states.id
    left join users on `user_id`=users.id
        $searchSql ";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $row = $results->fetch_array();
        return $row[0];
    }

    function debug_to_console($data) {

        if (is_array($data))
            $output = "<script>console.log( 'Debug Objects: " . addslashes(implode(', ', $data)) . "' );</script>";
        else
            $output = "<script>console.log('Debug Objects: " . addslashes($data) . "');</script>";

        echo $output;
    }
    
    function arrayYears() {
           $years = range(date('Y'), 2014);
           return array_combine(array_values($years), array_values($years) );
    }
    
       
    
    function getCampaigns($filter){
        
       $sql = "SELECT durata_campagna
	,escludi_sab_dom
	,users.LOGIN AS username
	,campaign_types.NAME AS tipo_nome
	,campaign_stacks.NAME AS stacks_nome
	,squads.NAME AS squads_nome
	,senders.NAME AS sender_nome
	,channels.NAME AS channel_nome
	,campaign_states.NAME AS campaign_stato_nome
	,campaign_states.colore AS colore
	,campaign_states.elimina AS elimina
        ,campaign_states.ordinamento AS ordinamento_stato
        ,offers.description as offer_description
        ,offers.id as offer_id
        ,offers.name as offer_name
        ,offers.label as stringa_ccm
	,campaigns.*
        FROM campaigns
        LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
        LEFT JOIN squads ON `squad_id` = squads.id
        LEFT JOIN campaign_types ON `type_id` = campaign_types.id
        LEFT JOIN senders ON `sender_id` = senders.id
        LEFT JOIN channels ON campaigns.`channel_id` = channels.id
        LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
        LEFT JOIN users ON `user_id` = users.id
        LEFT JOIN offers ON `offer_id` = offers.id";

       /*// query per escusione --> inversa alla attuale
       $filter = $this->getFilter2Query();
          
             $sql .= " WHERE squads.id NOT IN ('" . implode("', '", $filter["squads"]). "')"
               . " and campaign_stacks.id NOT IN ('" . implode("', '", $filter["stacks"]). "') and "
               . "channels.id NOT IN ('" . implode("', '", $filter["channels"]). "') "
               . "and campaign_states.id NOT IN ('" . implode("', '", $filter["states"]). "') "
               . "and campaign_types.id NOT IN ('" . implode("', '", $filter["typologies"]). "')";
        * 
        */
                  
         //echo 'start'.$filter['startDate'].' data '.date('Y-m-d',intval($filter['startDate']));
         //echo 'end'.$filter['endDate'].' data '.date('Y-m-d',intval($filter['endDate']));
         
         $sql .= " WHERE (`data_inizio` <= '".$filter['endDate']."' AND (`data_fine` >= '".$filter['startDate']."' )) and ";
         //$sql .= " WHERE (`data_inizio` <= '".date('Y-m-d',intval($filter['startDate']))."' AND (`data_fine` >= '".date('Y-m-d',intval($filter['endDate']))."' )) and ";
         //$sql .= " WHERE (`data_inizio` >= '2020-09-30' AND (`data_fine` <= '2020-10-29' )) and ";
         
             $sql .= "  squads.id  IN ('" . implode("', '", $filter["squads"]). "')"
               . " and campaign_stacks.id  IN ('" . implode("', '", $filter["stacks"]). "') and "
               . "channels.id  IN ('" . implode("', '", $filter["channels"]). "') "
               . "and campaign_states.id  IN ('" . implode("', '", $filter["states"]). "') "
               . "and campaign_types.id IN ('" . implode("', '", $filter["typologies"]). "')";

       

       $sql .= " order by data_inizio ASC ";
       
      // echo $sql;
  
        $result3 = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $list = array();

        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $list[] = $obj3;
        }

        return $list;
    }
    
    function tablePianificazione($list) {   
    print_r($list);
    ?>                                                    
                    <!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <table id="datatable-responsive" cellspacing="0" width="100%">
                    <table id="datatable-scroll" class="table table-bordered nowrap">
                    <table id="datatable-scroll" class="table table-bordered nowrap" style="width:100%">-->
                    <table id="datatable-pianificazione" class="display compact table-bordered table-striped  nowrap table-hover no-margin" cellspacing="0">    
              
                        <thead>
                            <tr>
                            <th><small>Azione</small></th>
                            <th><small>n°</small></th>
                            <th><small>Stack</small></th>                            
                            <th><small>Squad</small></th>
                            <th><small>Nome campagna</small></th>
                            <th><small>Tipologia</small></th>
                            <th><small>Cod_Camp.</small></th>
                            <th><small>Cod_Com.</small></th>                            
                            <th><small>Canale</small></th>
                            <th><small>Data inizio</small></th>                                                  
                            <th><small>Stato</small></th>
                            <th><small>Vol. (k)</small></th>
                            <?php $this->datePeriod(); ?>
                            </tr>
                        </thead>
                        <tbody>
                            
 <?php
 
    $string = '';
    $riga = 1;
    $tot_volume = $this->tot_volume();
    $tot_volume['totale'] = 0;
    
    //print_r($list);              
     foreach ($list as $key => $row) {
         
        $string .= "<tr><td>".'   
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaModifica"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="modifica" />                                                                
                        </form>
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaDuplica"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="duplica" />                                                                
                        </form>
                        <form action="index.php?page=inserisciCampagna2" "onsubmit=\"return conferma(" . $stato_elimina . "," . $permission . ")\" method="post" id="campagnaElimina"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="elimina" />                                                                
                        </form>
            
                    <button class="btn btn-sm btn-primary" type="submit" onclick="manageCamp('.$row['id'].', \'modifica\');"  data-placement="top" data-toggle="tooltip" data-original-title="Modifica" title="Modifica"><i class="fa fa-edit" ></i></button>
                    <button class="btn btn-sm btn-default" type="submit" onclick="manageCamp('.$row['id'].',\'duplica\');"  data-placement="top" data-toggle="tooltip" data-original-title="Duplica" title="Duplica"><i class="fa fa-clone" ></i></button>
                    <button class="btn btn-sm btn-danger" type="submit" onclick="manageCamp('.$row['id'].',\'elimina\');"  data-placement="top" data-toggle="tooltip" data-original-title="Elimina" title="Elimina"><i class="fa fa-trash-o"></i></button>                    
                '.  "</td>";
        $string .= "<td><small>$riga</small></td>";
        $string .= "<td><small>".$row['stacks_nome']."</small></td>";
        $string .= "<td><small>".$row['squads_nome']."</small></td>";
        $string .= "<td><small>".'
                         <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaOpen"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="open" />                                                                
                        </form>
                        <a href="#" data-toggle="tooltip" title="Open" onclick="manageCamp('.$row['id'].', \'open\');">'.$this->nomeCampagna($row).'</a>
                '
                . "</small></td>";
        $string .= "<td><small>".$row['tipo_nome']."</small></td>";
        $string .= "<td><small>".$row['cod_campagna']."</small></td>";
        $string .= "<td><small>".$row['cod_comunicazione']."</small></td>";
        $string .= "<td><small>".$row['channel_nome']."</small></td>";
        $string .= "<td><small>".$row['data_inizio']."</small></td>";      
        $string .= "<td><small>".$row['campaign_stato_nome']."</small></td>";
        $string .= "<td><small><strong>".$this->round_volume($row['volume'])."</strong></small></td>";
        
        $tot_volume['totale'] = $tot_volume['totale'] + $row['volume'];
        $volume_giorno = $this->day_volume($row);        
        $daterange = $this->daterange();

        foreach($daterange as $key=>$daytimestamp){
               
                if(array_key_exists($daytimestamp, $volume_giorno)){                   
                    $string .= "<td bgcolor=\"".$row['colore']."\"><small><strong><font color=\"black\">".$this->round_volume($volume_giorno[$daytimestamp])."<font></strong><small></td>";                    
                    
                    $tot_volume[$daytimestamp] =  $tot_volume[$daytimestamp] + $volume_giorno[$daytimestamp];
                } 
                else {
                    $string .= "<td" .$this->bgcolor($daytimestamp)."><small></small></td>";
                }
        }
        $string .= "</tr>";      
        $riga++; 
     }
     
        $string .= "<tr><td><strong>Totale >>> </strong></td><td></td><td></td>";
        $string .= "<td></td>";
        $string .= "<td></td>";
        $string .= "<td></td>";
        $string .= "<td></td>";
        $string .= "<td></td>";
        $string .= "<td></td>";
        $string .= "<td></td>";
        $string .= "<td><strong>Totale<strong></td>";
        $string .= "<td><small><strong>".$this->round_volume($tot_volume['totale'])."</strong></small></td>";
     foreach($daterange as $key=>$daytimestamp){
         $string .= "<td><small><strong>".$this->round_volume($tot_volume[$daytimestamp])."</strong></small></td>";
     }
     $string .= "</tr>"; 
 
        $string .= "</tbody></table>";
        $string .= "";
        
        echo $string;
       
        //return $string;
 
    }
    
    
    function dropdown_button(){        
        //$permission = $page_protect->check_permission($row['squad_id']);
        $string2='<div class="btn-group">
                   <button data-toggle="dropdown" class="btn btn-primary dropdown-toggle btn-xs" type="button" aria-expanded="false"><i class="fa fa-gear"></i> Azioni <span class="caret"></span>
                    </button>
                    <ul role="menu" class="dropdown-menu">
                    <li class="divider"></li>
                      <li><a href="#">Modifica Campagna</a>
                      </li>
                      <li class="divider"></li>
                      <li><a href="#">Duplica Campagna</a>
                      </li>
                      <li class="divider"></li>
                      <li><a href="#">Elimina Campagna</a>
                      </li>
                    </ul></div>';
        
        
         $string='
                          <form  class="form-horizontal"   action="index.php?page=inserisciCampagna2" method="post" enctype="multipart/form-data" />
                                 
                                <button class="btn btn-sm btn-default" type="submit" name="modifica" value="modifica"  data-placement="top" data-toggle="tooltip" data-original-title="Forward"><i class="fa fa-share"></i></button>

                                <button class="btn btn-sm btn-default" type="submit" name="elimina" value="elimina" data-placement="top" data-toggle="tooltip" data-original-title="Print"><i class="fa fa-print"></i></button>

                                <button class="btn btn-sm btn-default" type="submit" name="duplica" value="duplica" data-placement="top" data-toggle="tooltip" data-original-title="Trash"><i class="fa fa-trash-o"></i></button>
                        </form>        
                    ';
        return $string;
                          
    }
    
    
    
    //negative values 
    function getFilter2Query(){
        $funzione = new funzioni_admin();
        $filter_view = $_POST;

        $channels_all = $funzione->get_list_select('channels');
        $stacks_all = $funzione->get_list_select('campaign_stacks');
        $typlogies_all = $funzione->get_list_select('campaign_types');
        $squads_all = $funzione->get_list_select('squads');
        $states_all = $funzione->get_list_select('campaign_states');

        $channels = array_diff(array_keys($channels_all), array_values($filter_view["selected_channels"]));
        $squads = array_diff(array_keys($squads_all), array_values($filter_view["selected_squads"]));
        $stacks = array_diff(array_keys($stacks_all), array_values($filter_view["selected_stacks"]));
        $states = array_diff(array_keys($states_all), array_values($filter_view["selected_states"]));
        $typologies = array_diff(array_keys($typlogies_all), array_values($filter_view["selected_typologies"]));
        
        return array("channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
   
    }
    
    
    function getFilter(){
        
        //echo 'dentro getFilter';
        //print_r($_POST); 
        if(isset($_POST)){
            $filter_view = $_POST;           
        }
        else{    
            $filter_view = $_SESSION['filter'];
        }

        if(is_array($filter_view["selected_channels"]) && count($filter_view["selected_channels"])>0){
            $channels = $filter_view["selected_channels"];            
        } else{
            exit('<h2> Nessuna Campagna !!! </h2>');
            }
        if(is_array($filter_view["selected_squads"]) && count($filter_view["selected_squads"])>0){
            $squads = $filter_view["selected_squads"];            
        }else{
                exit('<h2> Nessuna Campagna !!! </h2>');
            }
        if(is_array($filter_view["selected_stacks"]) && count($filter_view["selected_stacks"])>0){
            $stacks = $filter_view["selected_stacks"];        
        }else{
                exit('<h2> Nessuna Campagna !!! </h2>');
            }
        
        if(is_array($filter_view["selected_states"]) && count($filter_view["selected_states"])>0){
            $states = $filter_view["selected_states"];         
        }else{
                exit('<h2> Nessuna Campagna !!! </h2>');
            }
        if(is_array($filter_view["selected_typologies"]) && count($filter_view["selected_typologies"])>0){
            $typologies = $filter_view["selected_typologies"];            
        }else{
                exit('<h2> Nessuna Campagna !!! </h2>');
            }
     
            
            
        if(isset($filter_view["startDate"])){
            $startDate = $filter_view["startDate"];            
        }else{
                $startDate = date('Y-m-01');
            }  
        if(isset($filter_view["endDate"])){
            $endDate = $filter_view["endDate"];            
        }else{
                $endDate = date('Y-m-t');
            }  
                    
        
        $_SESSION['filter'] = array("startDate"=>$startDate,"endDate"=>$endDate,"channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
        
        return array("startDate"=>$startDate,"endDate"=>$endDate,"channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
   
    }

    function getStartEndDatapicker(){
        if(isset($_SESSION['filter'])){    
            
            $filter_view = $_SESSION['filter'];
        }  
        else{
           $_SESSION['filter']['startDate'] = date('Y-m-01'); 
           $startDate = date('Y-m-01');
           $_SESSION['filter']['endDate'] = date('Y-m-t');
           $endDate = date('Y-m-t');
           
        }       
            
        if(isset($filter_view["startDate"])){
            $startDate = $filter_view["startDate"];            
        }else{
                $startDate = date('Y-m-01');
            }  
        if(isset($filter_view["endDate"])){
            $endDate = $filter_view["endDate"];            
        }else{
                $endDate = date('Y-m-t');
            }  

        return array("startDate"=>$startDate,"endDate"=>$endDate);
   
    }
    

function countDaysFromFilter(){
        
        $filter_view = $_POST;

        $startDate = $filter_view["startDate"];
        $endDate = $filter_view["endDate"];
        
        $interval = $this->dateDifference($startDate, $endDate);
        
        return $interval;
 
    }
    
function datePeriod(){    
    $filter_view = $_POST;

   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);

   foreach($daterange as $date){
       echo "<td><small>".$date->format("d D") . "</small></td>";
   }
}

function daterange(){    
    $filter_view = $_POST;

   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);
   
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);
   $day_list = array();
   foreach($daterange as $date){

       $day_list[] = date_timestamp_get($date);
       
   }
   
   return $day_list;
   
}

function tot_volume(){    
    $filter_view = $_POST;

   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);
   $day_list = array();
   foreach($daterange as $date){

       $tot_volume[date_timestamp_get($date)] = 0;
       
   }
   
   return $tot_volume;
   
}
    
//////////////////////////////////////////////////////////////////////
//PARA: Date Should In YYYY-MM-DD Format
//RESULT FORMAT:
// '%y Year %m Month %d Day %h Hours %i Minute %s Seconds'        =>  1 Year 3 Month 14 Day 11 Hours 49 Minute 36 Seconds
// '%y Year %m Month %d Day'                                    =>  1 Year 3 Month 14 Days
// '%m Month %d Day'                                            =>  3 Month 14 Day
// '%d Day %h Hours'                                            =>  14 Day 11 Hours
// '%d Day'                                                        =>  14 Days
// '%h Hours %i Minute %s Seconds'                                =>  11 Hours 49 Minute 36 Seconds
// '%i Minute %s Seconds'                                        =>  49 Minute 36 Seconds
// '%h Hours                                                    =>  11 Hours
// '%a Days                                                        =>  468 Days
//////////////////////////////////////////////////////////////////////
function dateDifference($date_1 , $date_2 , $differenceFormat = '%a' )
{
    $datetime1 = date_create($date_1);
    $datetime2 = date_create($date_2);
   
    $interval = date_diff($datetime1, $datetime2);
   
    return $interval->format($differenceFormat);
   
}


function nomeCampagna($row) {
        $nome_campagna_totale = substr(stripslashes($row['pref_nome_campagna']), 0);
        if (strlen($nome_campagna_totale) > 0){
            $nome_campagna_totale = $nome_campagna_totale . "_" . substr(stripslashes($row['nome_campagna']), 0);
        }
        else{
            $nome_campagna_totale = substr(stripslashes($row['nome_campagna']), 0);
        }
        
        return substr($nome_campagna_totale, 0,40);
    }
    
    
   function day_volume($row) {
           
        $volume_giornaliero = array($row['volumeGiornaliero1'], $row['volumeGiornaliero2'], $row['volumeGiornaliero3'], $row['volumeGiornaliero4'], $row['volumeGiornaliero5'], $row['volumeGiornaliero6'], $row['volumeGiornaliero7']);
        
        $begin = new DateTime($row["data_inizio"]);
        $end = new DateTime($row["data_fine"]);
        $end = $end->modify( '+1 day' );

        $interval = new DateInterval('P1D');
        $daterange = new DatePeriod($begin, $interval ,$end);
        
       
        $count = 0;
        $volume = array();
        foreach($daterange as $date){
            
            if($row['escludi_sab_dom']){
                    //con esclusione di sabato e  domenica
                    if(($row['durata_campagna'] > $count) and ($date->format('N')<6)){
                       $volume[date_timestamp_get($date)]  = $volume_giornaliero[$count];
                       $count++;
                    }
            }
            else{
                //con esclusione della domenica
                if(($row['durata_campagna'] > $count) and ($date->format('N')<=6)){
                   $volume[date_timestamp_get($date)]  = $volume_giornaliero[$count];
                   $count++;
                }
            }
            
            
        } 

           return $volume;
        } 
 
       
        
 function round_volume($value) {
     
        $r = $value;
        if ($r / 1000 < 1) {
            $m = number_format($r / 1000, 1, ',', '.');
        } else {
            $m = number_format(round($r / 1000, 0), 0, ',', '.');
        }
        return $m;
        
    }
    
    
    function bgcolor($daytimestamp) {
        $bgcolor = " ";
        if (date('D', $daytimestamp) === "Sun") {
            $bgcolor = " bgcolor=\"gray\"";
        }

        return $bgcolor;
    }
    
    
    function multiselect_session($param, $session_array) {
        $string = '';
        foreach ($param as $key => $value) {
            if (count(array_values($session_array)) == 0 || (in_array($key, array_values($session_array)))) {
                $string .= '<option value="' . $key . '" selected>' . $value . '</option>';
            } else {
                $string .= '<option value="' . $key . '">' . $value . '</option>';
            }
        }
        
        return $string;
    }

    function name_camp($id_campaign){      
        $name_camp =  substr(stripslashes($id_campaign['pref_nome_campagna']), 0);
        if (strlen(trim($id_campaign['nome_campagna'])) > 0){
            $name_camp .="_" . substr(stripslashes($id_campaign['nome_campagna']), 0);
        }

        return $name_camp;

    }

}