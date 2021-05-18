<?php

include_once 'db_config.php';
include_once './classes/access_user/access_user_class.php';
include_once './classes/funzioni_admin.php';

class campaign_class  {

//put your code here
    var $mysqli;
    var $radici_list;
    var $lista_parametri_campagna;
    var $lista_rules;
    var $filter_view;
    var $the_msg;
    
    
    function __construct() {
        $mysqli = $this->connect_dbli();
        $this->filter_view = array();
        $this->radici_list = array('channels' => 'channels', 'stacks' => 'campaign_stacks', 'states' => 'campaign_states', 'squads' => 'squads', 'typologies' => 'campaign_types');
        $this->lista_parametri_campagna = array("nome_campagna", "pref_nome_campagna", "cod_comunicazione", "cod_campagna", "stack_id", "type_id", "squad_id", "user_id", "segment_id", "optimization", "priority", "data_inizio_validita_offerta", "data_fine_validita_offerta", "leva", "descrizione_leva", "campaign_state_id", "lista_preview", "lista_civetta", "control_group", "perc_control_group", "channel_id", "channel_type", "mod_invio", "sender_id", "storic", "testo_sms", "link", "sms_duration", "tipoMonitoring", "data_inizio", "volumeGiornaliero1", "volumeGiornaliero2", "volumeGiornaliero3", "volumeGiornaliero4", "volumeGiornaliero5", "volumeGiornaliero6", "volumeGiornaliero7", "data_fine", "escludi_sab_dom", "durata_campagna", "trial_campagna", "data_trial", "volume_trial", "perc_scostamento", "volume", "attivi", "sospesi", "disattivi", "consumer", "business", "microbusiness", "prepagato", "postpagato", "contratto_microbusiness", "cons_profilazione", "cons_commerciale", "cons_terze_parti", "cons_geolocalizzazione", "cons_enrichment", "cons_trasferimentidati", "voce", "dati", "fisso", "no_frodi", "altri_filtri", "etf", "vip", "dipendenti", "trial", "parlanti_ultimo", "profilo_rischio_ga", "profilo_rischio_standard", "profilo_rischio_high_risk", "altri_criteri", "data_inserimento", "redemption", "storicizza", "offer_id", "modality_id", "category_id", "tit_sott_id", "descrizione_target", "leva_offerta", "descrizione_offerta", "indicatore_dinamico", "tipo_leva", "cod_ropz", "cod_opz", "id_news", "note_operative","cat_sott_id","addcanale","note_camp","alias_attiv","day_val","sms_incarico","sms_target","sms_adesione","sms_nondisponibile","control_guide","numeric_control_group","n_collateral");
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
        if (isset($row) && $row[0] == 0) {
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

    // per i canali SMS e SMS Long
    function get_channel_ext1() {
        $sql = "SELECT id from channels  where ext_1=1 or ext_1=12 ";
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result);
            return $export;
        }
    }
// per il canale POS NG
    function get_channel_ext2() {
        $sql = "SELECT id from channels  where ext_2=13 ";

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
                'pref_nome_campagna' => $row['pref_nome_campagna'],
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
        $msg = "Sono state modificate " . $numero_row . " campagne in stato --> " . $this->get_state_name($value_update);
        $subj = "Campaign management: Cambio Stato";
        $page_protect = new Access_user();

        $mail_list = $page_protect->get_maillist();
//print_r($mail_list);
        $mail_list_string = "";
        foreach ($mail_list as $key => $value) {
            $mail_list_string = $mail_list_string . ";" . $value;
        }
        $page_protect->send_mail_list($mail_list, $msg, $subj);
        $result = "Record aggiornati: " . $numero_row . " ";
        return $result;
    }

    function delete_campaign($id) {
        $id_campaign = $this->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
        
        $page_protect = new Access_user;
        $permission = $page_protect->check_permission($id_campaign['squad_id']);
//print_r($lista_id);
        if ($permission) {
            $sql = "DELETE FROM  `campaigns` WHERE `campaigns`.`id` = '$id'";
            $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
            $this->rrmdir("file/".$id_campaign['id']);

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
        $id_camp = $this->mysqli->insert_id;
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
        return array('res'=>$res, 'id_camp'=>$id_camp);
// ...
// doing something
// ...
/*
        if ($something_is_wrong) {
            throw new Exception("Logic exception while performing query result processing");
        }
        */
    }

function check_addCanale($record){
    if(isset($record['1_addcanale'])){
    for($i=1; $i<=100; $i++){
        $key = $i.'_addcanale';
        if(isset($record[$key])){

        }
        else{
            return $i;
        }  
    }    
    }
    return 0;
}    

function insert($record) {
//print_r($lista_id);
    //print_r($record);

    //$addcanale = $this->check_addCanale($record);
    //echo "<br/>addcanale " . $addcanale . "<br/>";

        $lista_variabili = "";
        $lista_valori = "";
        
        foreach ($this->lista_parametri_campagna as $key=>$value) {
            //echo $value. "<br/>";
            $temp = explode('_', $value);
            if ($value == "data_fine") {

                if ($record['data_inizio'] != "" && $record['durata_campagna'] != "") {
                    //echo $record['data_inizio'].' data inizio prima';
                    $data_inizio = $this->mysqli->real_escape_string($this->data_it_to_eng_($record['data_inizio']));
                    $durata_campagna = $this->mysqli->real_escape_string($record['durata_campagna']);
                    if (isset($record['escludi_sab_dom'])) {
                        $escludi_sab_dom = $this->mysqli->real_escape_string($record['escludi_sab_dom']);
                    } else
                        $escludi_sab_dom = 0;
                    $lista_variabili = $lista_variabili . "`" . $value . "`,";
//echo "weee data fine ".$data_inizio.'  '. $durata_campagna.'  '. $escludi_sab_dom.'  '.$this->calcola_data_fine($data_inizio, $durata_campagna, $escludi_sab_dom);
                    $lista_valori = $lista_valori . "'" . $this->calcola_data_fine($data_inizio, $durata_campagna, $escludi_sab_dom) . "', ";
                }
            } 
            elseif (isset($record[$value])) {

                if ($value == "pref_nome_campagna") {
                    if (substr($record[$value], -1, 1) == "_")
                        $valore_inviato = substr($record[$value], 0, -1);
                    else
                        $valore_inviato = $record[$value];
                    $lista_variabili = $lista_variabili . "`" . $value . "`,";
                    $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string(addslashes($valore_inviato)) . "',";
                } 
                elseif ($value == "addcanale") {
                    $valore_inviato = json_encode($record[$value], JSON_FORCE_OBJECT);
                    $lista_variabili = $lista_variabili . "`" . $value . "`,";
                    $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string($valore_inviato) . "',";

                }    
                else {
                    $valore_inviato = $record[$value];
//echo $value . " - " . $valore_inviato . "<br/>";
                    if (strlen($valore_inviato) > 0) {
//echo $value . " - " . $valore_inviato . "<br/>";
                        if ($temp[0] == 'data') {
                            $lista_variabili = $lista_variabili . "`" . $value . "`,";
                            $lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string($this->data_it_to_eng_($valore_inviato)) . "',";
                            //$lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string(addslashes($valore_inviato)) . "',";
                            //$lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string(date('Y-m-d',strtotime($valore_inviato))) . "',";
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

        //echo "<br/>" . $sql . "<br/>";
        try {
            $res = $this->my_mysql_query($sql);
            $page_protect = new Access_user;
            $user_info = $page_protect->get_user_id();
//L'utente Rattini Marco ha modificato lo stato della campagna “Nome Campagna�? in RICHIESTA. Data inizio campagna 21/03/2016.
            $this->send_email("[CTM] La campagna " .$record['pref_nome_campagna']. " ha cambiato stato", "L'utente '" . $this->get_firtname($user_info) . " " . $this->get_lastname($user_info) . "' ha modificato lo stato della campagna '" .$record['pref_nome_campagna']. " in " . $this->get_state_name($record['campaign_state_id']) . ". Data inizio campagna: " . $_POST['data_inizio'] . ".");
            
            //$stringa_mail ="[CTM] La campagna " .$record['pref_nome_campagna']. " ha cambiato stato L'utente '" . $this->get_firtname($user_info) . " " . $this->get_lastname($user_info) . "' ha modificato lo stato della campagna '" .$record['pref_nome_campagna']. " in " . $this->get_state_name($record['campaign_state_id']) . ". Data inizio campagna: " . $_POST['data_inizio'] . ".";
            //echo '<script type="text/javascript">alert("SIMULAZIONE Invio Email' . $stringa_mail . '")</script>';
                    // copy and remove files and dir of related file upload
                if(isset($record['id_upload'])){
                    //$id_camp = $this->mysqli->insert_id;
                    $this->rcopy("file/".$record['id_upload'],"file/".$res['id_camp']);
                    $this->rrmdir("file/".$record['id_upload']);
                }
        } catch (Exception $e) {
            echo 'ERROR:'.$e->getMessage(). " - " . $sql;
        }
        /*
        catch (MySQLDuplicateKeyException $e) {
// duplicate entry exception
            return $e->getMessage();
        } catch (MySQLException $e) { 
// other mysql exception (not duplicate key entry)
            return $e->getMessage() . " - " . $sql;
        } catch (Exception $e) {
// not a MySQL exception
            return $e->getMessage() . " - " . $sql;
        }
        */

        // rename unique Dir with id row table
        //exec('rename file/.'$record['id_upload'].' file/'..$this->mysqli->insert_id);
        //copy("file/".$record['id_upload'],"file/".$this->mysqli->insert_id);
        //unlink("file/".$record['id_upload']);
        
        
        
        
        return $res['res'];
    }

// removes files and non-empty directories
function rrmdir($dir) {
  if (is_dir($dir)) {
    $files = scandir($dir);
    foreach ($files as $file)
    if ($file != "." && $file != "..") $this->rrmdir("$dir/$file");
    rmdir($dir);
  }
  else if (file_exists($dir)) unlink($dir);
}

// copies files and non-empty directories
function rcopy($src, $dst) {
  if (file_exists($dst)) $this->rrmdir($dst);
  if (is_dir($src)) {
    mkdir($dst);
    $files = scandir($src);
    foreach ($files as $file)
    if ($file != "." && $file != "..") $this->rcopy("$src/$file", "$dst/$file");
  }
  else if (file_exists($src)) copy($src, $dst);
}

function update($record, $id_campagne) {    
    //reset JSON ADDCANALE
    //$sql = "UPDATE `campaigns` SET `addcanale`= '{\"0\": {}}' where id='" . $id_campagne . "';";
    //$results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
// print_r($record);
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
            } 
            elseif (isset($_POST[$value])) {
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
                    } 
                    elseif ($value == "addcanale") {
                        $valore_inviato = json_encode($record[$value], JSON_FORCE_OBJECT);
                        //$lista_variabili = $lista_variabili . "`" . $value . "`,";
                        //$lista_valori = $lista_valori . "'" . $this->mysqli->real_escape_string($valore_inviato) . "',";
                        $lista_variabili = $lista_variabili . "`" . $value . "`='" . $this->mysqli->real_escape_string($valore_inviato) . "',";
                    }  
                    else {
                        if ($value == "campaign_state_id") {
                            //if (($this->get_state_eliminabile($id_campagne) > 0) && ($valore_inviato != $id_state)) {
                            $states_infos = $this->get_states_info();
                            //check if invio_email==1
                            if ($states_infos[$valore_inviato]['invio_email']==1) {
                            //if ($valore_inviato == $this->get_states_info()) {
                                
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
        //$lista_variabili = $lista_variabili . " `data_inserimento` = '" . date("Y-m-d  H:i:s") . "'";
        $lista_variabili = $lista_variabili . " `data_inserimento` = '" . date("Y-m-d  H:i:s") . "'";
        //$lista_variabili = substr($lista_variabili, 0, -1);
        $sql = "UPDATE `campaigns` SET " . $lista_variabili . " where id='" . $id_campagne . "';";
        //echo $sql;
        $page_protect = new Access_user;
        $user_info = $page_protect->get_user_id();
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        if ($send_email) {
//L'utente Rattini Marco ha modificato lo stato della campagna “Nome Campagna�? in RICHIESTA. Data inizio campagna 21/03/2016.
            $this->send_email("[CTM] La campagna " .$record['pref_nome_campagna']. " ha cambiato stato", "L'utente '" . $this->get_firtname($user_info) . " " . $this->get_lastname($user_info) . "' ha modificato lo stato della campagna '" .$record['pref_nome_campagna']. " in " . $this->get_state_name($this->get_state($id_campagne)) . ". Data inizio campagna: " . $_POST['data_inizio'] . ".");
            // $stringa_mail ="[CTM] La campagna: " . $record['pref_nome_campagna'] . " ha cambiato stato. L'utente " . $this->get_firtname($user_info) . " " . $this->get_lastname($user_info) . " ha modificato lo stato della campagna in ". $this->get_state_name($this->get_state($id_campagne)) . ". Data inizio campagna: " . $_POST['data_inizio'];           
            // echo '<script type="text/javascript">alert("SIMULAZIONE Invio Email' . $stringa_mail . '")</script>';
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
        $query3 = "SELECT id FROM campaign_states where invio_email=1";
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

    function get_states_info() {
        $query3 = "SELECT * FROM campaign_states where 1";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);        
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $rows[$obj3['id']] = $obj3;
        }
        return $rows;
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

function reset_filter_session_new() {
        $funzioni_admin = new funzioni_admin();
        foreach ($this->radici_list as $key_table => $value_table) {
            $list = $funzioni_admin->get_list_id($value_table);
            $radice = $key_table;
            foreach ($list as $key => $value) {
//if (isset($_POST[$radice . $value['id']])) {
                $_SESSION['filter'][$radice][] = $value['id'];
//} 
            }
        }

        return $_SESSION['filter'][$radice];
    }

function reset_filter() {
        $funzioni_admin = new funzioni_admin();
        foreach ($this->radici_list as $key_table => $value_table) {
            $list = $funzioni_admin->get_list_id($value_table);
            $radice = $key_table;
            foreach ($list as $key => $value) {
//if (isset($_POST[$radice . $value['id']])) {
                $_SESSION['filter'][$radice][] = $value['id'];
//} 
            }
        }
        $_SESSION['filter']['endDate'] = date('Y-m-t');
        $_SESSION['filter']['startDate'] = date('Y-m-01');

        return $_SESSION['filter'][$radice];
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
      $funzioni = new funzioni_admin();
        if(!empty($filter['sprint'])){
          
          $sprint = $funzioni->get_sprint($filter['sprint']);
          //echo 'eccolo quiiiiiiiii';
          //print_r($sprint);
          $sql_and = " (`data_inizio` <= '".$sprint['data_fine']."' AND (`data_fine` >= '".$sprint['data_inizio']."' ))";
      } 
      else {
          $sql_and = " 1 ";
      } 

     $sql_canali = '';
     if(count($filter["channels"])< count($funzioni->get_list_select('channels'))) {
        
            $sql_canali = ' and ( ';
            
            foreach ($filter["channels"] as $key => $value) {

                    $sql_canali .= " `addcanale` like '%\"channel_id\":\"".$filter["channels"][$key]."\"%' OR ";
                }
                $sql_canali = rtrim($sql_canali,'OR ');


            $sql_canali .= ' ) '; 
     }           
        
       $sql = "SELECT durata_campagna
        ,escludi_sab_dom
        ,users.LOGIN AS username
        ,campaign_types.NAME AS tipo_nome
        ,campaign_stacks.NAME AS stacks_nome
        ,squads.NAME AS squads_nome
        ,senders.NAME AS sender_nome
        ,channels.NAME AS channel_nome
        ,channels.label AS channel_label
        ,campaign_states.NAME AS campaign_stato_nome
        ,campaign_states.colore AS colore
        ,campaign_states.elimina AS elimina
        ,campaign_states.ordinamento AS ordinamento_stato

	    ,campaigns.*
        FROM campaigns
        LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
        LEFT JOIN squads ON `squad_id` = squads.id
        LEFT JOIN campaign_types ON `type_id` = campaign_types.id
        LEFT JOIN senders ON `sender_id` = senders.id
        LEFT JOIN channels ON campaigns.`channel_id` = channels.id
        LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
        LEFT JOIN users ON `user_id` = users.id";

       
         $sql .= " WHERE (`data_inizio` <= '".$filter['endDate']."' AND (`data_fine` >= '".$filter['startDate']."' )) and $sql_and";
         
         $sql .= "  and squads.id  IN ('" . implode("', '", $filter["squads"]). "')"
               . " and campaign_stacks.id  IN ('" . implode("', '", $filter["stacks"]). "') "
               . "and campaign_states.id  IN ('" . implode("', '", $filter["states"]). "') "
               . "and campaign_types.id IN ('" . implode("', '", $filter["typologies"]). "')";
               //SELECT `addcanale`, `id` from `campaigns` WHERE `addcanale` like '%"channel_id":"12"%'
           
       

       $sql .= $sql_canali." order by data_inizio ASC ";
       
      //echo $sql;
  
        $result3 = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $list = array();

        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $list[] = $obj3;
        }

        return $list;
    }

    function getCampaignsPianificazione($filter){
      $funzioni = new funzioni_admin();
        if(!empty($filter['sprint'])){
          
          $sprint = $funzioni->get_sprint($filter['sprint']);
          //echo 'eccolo quiiiiiiiii';
          //print_r($sprint);
          $sql_and = " (`data_inizio` <= '".$sprint['data_fine']."' AND (`data_fine` >= '".$sprint['data_inizio']."' ))";
      } 
      else {
          $sql_and = " 1 ";
      } 

     $sql_canali = '';
     if(count($filter["channels"])< count($funzioni->get_list_select('channels'))) {
        
            $sql_canali = ' and ( ';
            
            foreach ($filter["channels"] as $key => $value) {

                    $sql_canali .= " `addcanale` like '%\"channel_id\":\"".$filter["channels"][$key]."\"%' OR ";
                }
                $sql_canali = rtrim($sql_canali,'OR ');


            $sql_canali .= ' ) '; 
     }           
        
       $sql = "SELECT durata_campagna
        ,escludi_sab_dom
        ,users.LOGIN AS username
        ,campaign_types.NAME AS tipo_nome
        ,campaign_stacks.NAME AS stacks_nome 
        ,squads.NAME AS squads_nome  
        
        ,campaign_states.NAME AS campaign_stato_nome
        ,campaign_states.colore AS colore
        ,campaign_states.elimina AS elimina
        ,campaign_states.ordinamento AS ordinamento_stato

	    ,campaigns.*
        FROM campaigns
        LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
        LEFT JOIN squads ON `squad_id` = squads.id
        LEFT JOIN campaign_types ON `type_id` = campaign_types.id
        
        LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
        LEFT JOIN users ON `user_id` = users.id";

       
         $sql .= " WHERE (`data_inizio` <= '".$filter['endDate']."' AND (`data_fine` >= '".$filter['startDate']."' )) and $sql_and";
         
         $sql .= "  and squads.id  IN ('" . implode("', '", $filter["squads"]). "')"
               . " and campaign_stacks.id  IN ('" . implode("', '", $filter["stacks"]). "') "
               . "and campaign_states.id  IN ('" . implode("', '", $filter["states"]). "') "
               . "and campaign_types.id IN ('" . implode("', '", $filter["typologies"]). "')";
               //SELECT `addcanale`, `id` from `campaigns` WHERE `addcanale` like '%"channel_id":"12"%'
           
       

       $sql .= $sql_canali." order by data_inizio ASC ";
       
      //echo $sql;
  
        $result3 = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $list = array();

        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $list[] = $obj3;
        }

        return $list;
    }


    function getCampaignsGestione($filter){
        $funzioni = new funzioni_admin();
        //controllo Squad
        $page_protect = new Access_user;
        $sql_squad = '';
        $job_role = $page_protect->get_job_role();
        if ($job_role == 2) {
            $squad_id = $page_protect->get_squad();
            $sql_squad = " (campaigns.`squad_id` = $squad_id)  and ";
        }

      if(!empty($filter['sprint'])){
          
          $sprint = $funzioni->get_sprint($filter['sprint']);
          //echo 'eccolo quiiiiiiiii';
          //print_r($sprint);
          $sql_and = " (`data_inizio` <= '".$sprint['data_fine']."' AND (`data_fine` >= '".$sprint['data_inizio']."' ))";
      } 
      else {
          $sql_and = " 1 ";
      } 


     $sql_canali = '';
     if(count($filter["channels"])< count($funzioni->get_list_select('channels'))) {
        
            $sql_canali = ' and ( ';
            
            foreach ($filter["channels"] as $key => $value) {

                    $sql_canali .= " `addcanale` like '%\"channel_id\":\"".$filter["channels"][$key]."\"%' OR ";
                }
                $sql_canali = rtrim($sql_canali,'OR ');


            $sql_canali .= ' ) '; 
     }   
      
        
       $sql = "SELECT durata_campagna
        ,escludi_sab_dom
        ,users.LOGIN AS username
        ,campaign_types.NAME AS tipo_nome
        ,campaign_stacks.NAME AS stacks_nome
        ,squads.NAME AS squads_nome
        ,senders.NAME AS sender_nome
        ,channels.NAME AS channel_nome
        ,channels.label AS channel_label
        ,campaign_states.NAME AS campaign_stato_nome
        ,campaign_states.colore AS colore
        ,campaign_states.elimina AS elimina
        ,campaign_states.ordinamento AS ordinamento_stato
        ,campaign_modalities.NAME AS modality_nome
        ,campaign_categories.NAME AS category_nome
        ,campaign_cat_sott.NAME AS cat_sott_nome

	    ,campaigns.*
        FROM campaigns
        LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
        LEFT JOIN squads ON `squad_id` = squads.id
        LEFT JOIN campaign_types ON `type_id` = campaign_types.id
        LEFT JOIN senders ON `sender_id` = senders.id
        LEFT JOIN channels ON campaigns.`channel_id` = channels.id
        LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
        LEFT JOIN users ON `user_id` = users.id
        LEFT JOIN campaign_modalities ON `modality_id`=campaign_modalities.id
        LEFT JOIN campaign_categories ON `category_id`=campaign_categories.id
        left JOIN campaign_cat_sott on `cat_sott_id`=campaign_cat_sott.id    
        ";

       
         $sql .= " WHERE  $sql_squad  (`data_inizio` <= '".$filter['endDate']."' AND (`data_fine` >= '".$filter['startDate']."' )) and $sql_and ";
         
         $sql .= "  and squads.id  IN ('" . implode("', '", $filter["squads"]). "')"
               . " and campaign_stacks.id  IN ('" . implode("', '", $filter["stacks"]). "') "
               . " and campaign_states.id  IN ('" . implode("', '", $filter["states"]). "') "
               . " and campaign_types.id IN ('" . implode("', '", $filter["typologies"]). "')";

       

       //$sql .= " order by data_inizio ASC ";
       $sql .= $sql_canali." order by data_inizio ASC ";
       
      //echo $sql;
  
        $result3 = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $list = array();

        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $list[] = $obj3;
        }

        return $list;
    }

    function getCampaignsCapacity($filter){
        $funzioni = new funzioni_admin();
        //controllo Squad
        $page_protect = new Access_user;
        $sql_squad = '';
        $job_role = $page_protect->get_job_role();
        if ($job_role == 2) {
            $squad_id = $page_protect->get_squad();
            $sql_squad = " (campaigns.`squad_id` = $squad_id)  and ";
        }

      if(!empty($filter['sprint'])){
          
          $sprint = $funzioni->get_sprint($filter['sprint']);
          //echo 'eccolo quiiiiiiiii';
          //print_r($sprint);
          $sql_and = " (`data_inizio` <= '".$sprint['data_fine']."' AND (`data_fine` >= '".$sprint['data_inizio']."' ))";
      } 
      else {
          $sql_and = " 1 ";
      } 


      $sql_canali = '';
     if(count($filter["channels"])< count($funzioni->get_list_select('channels'))) {
        
            $sql_canali = ' and ( ';
            
            foreach ($filter["channels"] as $key => $value) {

                    $sql_canali .= " `addcanale` like '%\"channel_id\":\"".$filter["channels"][$key]."\"%' OR ";
                }
                $sql_canali = rtrim($sql_canali,'OR ');


            $sql_canali .= ' ) '; 
     } 
        
    $sql = "SELECT durata_campagna
        ,escludi_sab_dom
        ,users.LOGIN AS username
        ,campaign_types.NAME AS tipo_nome
        ,campaign_stacks.NAME AS stacks_nome
        ,squads.NAME AS squads_nome
        ,senders.NAME AS sender_nome
        ,channels.NAME AS channel_nome
        ,channels.label AS channel_label
        ,campaign_states.NAME AS campaign_stato_nome
        ,campaign_states.colore AS colore
        ,campaign_states.elimina AS elimina
        ,campaign_states.ordinamento AS ordinamento_stato
        ,campaign_modalities.NAME AS modality_nome
        ,campaign_categories.NAME AS category_nome
        ,campaign_cat_sott.NAME AS cat_sott_nome

	    ,campaigns.*
        FROM campaigns
        LEFT JOIN campaign_stacks ON `stack_id` = campaign_stacks.id
        LEFT JOIN squads ON `squad_id` = squads.id
        LEFT JOIN campaign_types ON `type_id` = campaign_types.id
        LEFT JOIN senders ON `sender_id` = senders.id
        LEFT JOIN channels ON campaigns.`channel_id` = channels.id
        LEFT JOIN campaign_states ON `campaign_state_id` = campaign_states.id
        LEFT JOIN users ON `user_id` = users.id
        LEFT JOIN campaign_modalities ON `modality_id`=campaign_modalities.id
        LEFT JOIN campaign_categories ON `category_id`=campaign_categories.id
        left JOIN campaign_cat_sott on `cat_sott_id`=campaign_cat_sott.id    
        ";

       
         $sql .= " WHERE  $sql_squad  (`data_inizio` <= '".$filter['endDate']."' AND (`data_fine` >= '".$filter['startDate']."' )) and $sql_and ";
         
         $sql .= "  and squads.id  IN ('" . implode("', '", $filter["squads"]). "')"
               . " and campaign_stacks.id  IN ('" . implode("', '", $filter["stacks"]). "') "
               . " and campaign_states.id  IN ('" . implode("', '", $filter["states"]). "') "
               . " and campaign_types.id IN ('" . implode("', '", $filter["typologies"]). "')";

       

       //$sql .= " order by data_inizio ASC ";
       $sql .= $sql_canali." order by data_inizio ASC ";
       
      //echo $sql;
  
        $result3 = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $list = array();

        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $list[] = $obj3;
        }

        return $list;
    }

    function tablePianificazione($list) {   
    // print_r($list);
        ?>                                                    
              <table id="datatable-pianificazione" data-order='[[ 1, "asc" ]]' class="display compact table-bordered text-nowrap table-hover no-margin nowrap" cellspacing="0" cellpadding="0" defer>
                        <thead>
                            <tr>                            
                            <th class="not-export-col">Azione</th> 
                            <th class="not-export-col">N.</th>                            
                            <th>Stack</th>  
                            <th>Sprint</th>                          
                            <th>Squad</th>
                            <th>Nome_Campagna</th>
                            <th>Tipologia</th>
                            <th>Cod. Camp.</th>
                            <th>Cod. Com.</th>                            
                            <th>Canale</th>
                            <th>Data_inizio</th>                                                  
                            <th>Stato</th>
                            <th>Vol. (k)</th>
                        <?php $this->datePeriod(); ?>
                            </tr>
                        </thead>
                        <tbody>
                            
 <?php
    $page_protect = new Access_user;
    $string = '';
    $riga = 1;
    $tot_volume = $this->tot_volume();
    $tot_volume['totale'] = 0;
    $daterange = $this->daterange();
    $user_info['job_role'] = $page_protect->get_job_role();
    $user_info['squad_id'] = $page_protect->get_squad();
               
     foreach ($list as $key => $row) {
        $stato_elimina = $row['elimina'];
        
        $permission = $page_protect->check_permission_fast($row['squad_id'], $user_info); 
        ?>
        <tr align="left"><td><form action="index.php?page=inserisciCampagna2" method="post" id="campagnaModifica<?php echo $row['id'];?>"><input type="hidden" name="id" value="<?php echo $row['id'];?>" /><input type="hidden" name="azione" value="modifica"></form>
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaDuplica<?php echo $row['id'];?>"> 
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>">
                            <input type="hidden" name="azione" value="duplica">                                                                
                        </form>
                        <form action="index.php?page=pianificazione2"  method="post" id="campagnaElimina<?php echo $row['id'];?>"> 
                            <input type="hidden" name="id" value="<?php echo$row['id'];?>" />
                            <input type="hidden" name="azione" value="elimina" />                                                                
                        </form>

                    <button class="btn btn-xs btn-primary" type="submit" onclick="manageCamp('<?php echo $row['id'];?>', 'modifica','<?php echo $permission;?>');"  data-placement="bottom" data-toggle="tooltip" data-original-title="Modifica" title="Modifica"><i class="fa fa-edit" ></i></button>
                    <button class="btn btn-xs btn-default" type="submit" onclick="manageCamp('<?php echo $row['id'];?>','duplica','<?php echo $permission;?>');"  data-placement="bottom" data-toggle="tooltip" data-original-title="Duplica" title="Duplica"><i class="fa fa-clone" ></i></button>
                    <button class="btn btn-xs btn-danger" type="submit" onclick="manageCamp('<?php echo $row['id'];?>','elimina','<?php echo $permission;?>','<?php echo $stato_elimina;?>');"  data-placement="bottom" data-toggle="tooltip" data-original-title="Elimina" title="Elimina"><i class="fa fa-trash-o"></i></button></td>
                  
        <td><?php echo $riga; ?></td><td><?php echo $row['stacks_nome'];?></td>
        <td><?php echo $this->sprint_find($row['data_inizio']);?></td>
        <td><?php echo $row['squads_nome'];?></td>
        <td>
                         <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaOpen<?php echo $row['id'];?>"> 
                            <input type="hidden" name="id" value="<?php echo $row['id'];?>" />
                            <input type="hidden" name="azione" value="open" />                                                                
                        </form>
                        <a href="#" data-placement="bottom" data-toggle="tooltip" title="Open" onclick="manageCamp('<?php echo $row['id'];?>', 'open');"><?php echo stripslashes($row['pref_nome_campagna']);?></a>
                
                </td>
        <td><?php echo $row['tipo_nome'];?></td>
        <td><?php echo $row['cod_campagna'];?></td>
        <td><?php echo $row['cod_comunicazione'];?></td>
        <td><?php echo $this->tableChannelLabelPianificazione($row);?></td>
        <td><?php echo $row['data_inizio'];?></td>
        <td class="stato"><?php echo $row['campaign_stato_nome'];?></td>
        <td><strong><?php echo $this->round_volume($row['volume']);?></strong></td>
        
        <?php 
        $tot_volume['totale'] = $tot_volume['totale'] + $row['volume'];
        $volume_giorno = $this->day_volume($row);        
        
        //print_r($volume_giorno);
        //print_r($daterange);

        foreach($daterange as $key=>$daytimestamp){
               
                if(isset($volume_giorno[$daytimestamp])){                   
                    ?>
                    <td  class="valore" bgcolor="<?php echo strtolower($row['colore']);?>" ><strong><font color="black"><?php echo $this->round_volume($volume_giorno[$daytimestamp]);?><font></strong></td>                    
                    <?php 
                    $tot_volume[$daytimestamp] =  $tot_volume[$daytimestamp] + $volume_giorno[$daytimestamp];
                } 
                else {
                        ?>
                        <td <?php echo $this->bgcolor($daytimestamp);?> ></td>
             <?php           
                }
        }
    ?>
        </tr>
        <?php     
        $riga++; 
    }
     
     ?>
        <tr><td><strong></strong></td><td><?php echo $riga;?></td><td></td>
        <td></td><td></td><td></td><td></td><td></td><td></td><td></td><td></td><td><strong>Totale<strong></td>
        <td><strong><?php echo $this->round_volume($tot_volume['totale']);?></strong></td>
    <?php 
     foreach($daterange as $key=>$daytimestamp){
         if(intval($tot_volume[$daytimestamp])>0){
            ?>
            <td><strong><?php echo $this->round_volume($tot_volume[$daytimestamp]);?></strong></td>
            <?php
         }
         else{
             ?>
             <td><strong>0</strong></td>
         <?php    
         }
     }
     ?>
     </tr> 
 
    </tbody></table>
    <?php
         
    }

    function tableChannelLabel($row) { 
        $string = $row['channel_label'];
        if(isset(json_decode($row['addcanale'],true)[1])){
            $funzione = new funzioni_admin();            
            $addcanale = json_decode($row['addcanale'], true);            
            foreach($addcanale as $key => $value ){
                //print_r($value['channel_id']);
                if($key>0){
                    $string .= '/'.$funzione->get_channel_label($value['channel_id']);  
                }
                
            }
            return $string;
        }
        else{
            return $string;
        }

    }

    function tableChannelLabelPianificazione($row) { 
        $funzione = new funzioni_admin();
        $addcanale = json_decode($row['addcanale'], true);
        if(isset($addcanale[1])){
                        
            $addcanale = json_decode($row['addcanale'], true);            
            foreach($addcanale as $key => $value ){
                //print_r($value['channel_id']);
                
                    $str[] = $funzione->get_channel_label($value['channel_id']);  
                    
                
                
            }

            return implode('/',$str);
        }
        else{
            $str = $funzione->get_channel_label($addcanale[0]['channel_id']); 
            return $str;
        }

    }

    function getCriteri($row, $criterio){

        if($criterio=='stato'){
            $stringa = '';
            if($row['attivi']==1) $stringa .= 'Attivi ';
            if($row['sospesi']==1) $stringa .= 'Sospesi ';
            if($row['disattivi']==1) $stringa .= 'Disattivi ';
            return $stringa;

        }
        if($criterio=='tipo_offerta'){
            $stringa = '';
            if($row['consumer']==1) $stringa .= 'Consumer ';
            if($row['business']==1) $stringa .= 'Business ';
            if($row['microbusiness']==1) $stringa .= 'MicroBusiness ';
            return $stringa;
        }
        if($criterio=='tipo_contratto'){
            $stringa = '';
            if($row['prepagato']==1) $stringa .= 'Prepagato ';
            if($row['postpagato']==1) $stringa .= 'Postpagato ';
            if($row['contratto_microbusiness']==1) $stringa .= 'MicroBusiness ';
            return $stringa;
        }
        if($criterio=='consenso'){
            $stringa = '';
            if($row['cons_profilazione']==1) $stringa .= 'Profilazione ';
            if($row['cons_commerciale']==1) $stringa .= 'commerciale ';
            if($row['cons_terze_parti']==1) $stringa .= 'Terze Parti (Wind) ';
            if($row['cons_geolocalizzazione']==1) $stringa .= 'Geolocalizzazione ';
            if($row['cons_enrichment']==1) $stringa .= 'Enrichment ';
            if($row['cons_trasferimentidati']==1) $stringa .= 'Trasferimento dati a terzi (Tre) ';
            return $stringa;
        }

        if($criterio=='mercato'){
            $stringa = '';
            if($row['voce']==1) $stringa .= 'Mobile Voce ';
            if($row['dati']==1) $stringa .= 'Mobile Dati ';
            if($row['fisso']==1) $stringa .= 'Fisso ';
            return $stringa;
        }
        if($criterio=='frodatori'){
            $stringa = '';
            if($row['no_frodi']==1) $stringa .= 'No Frodi ';
            if($row['altri_filtri']==1) $stringa .= 'No Collection ';    
            return $stringa;
        }
        //Tab Comunicazione
        if($criterio=='control_group'){            
            if($row['control_group']==0) return 'No';
            if($row['control_group']==1) return 'Si (Percentuale)';    
            if($row['control_group']==2) return 'Si (Volume)'; 
            else return ' ';        
        }
        //Tab Comunicazione
        if($criterio=='tipo_leva'){
            if($row['tipo_leva']=='info') return 'Informativa';
            if($row['tipo_leva']=='mono') return 'MonoOfferta';    
            if($row['tipo_leva']=='multi') return 'MultOfferta'; 
            else return ' ';        
        }

        

    }

    function getAddCanale($row, $canale_var, $addcanale_numero=0){

        if($canale_var=='link'){
            return $row['addcanale'][$addcanale_numero]['link'];
        }
        

    }

    function tableGestioneStato($lista) {            
    //print_r($list);
            ?>      
            <form id="formCambiaStato" name="formCambiaStato" action="./index.php?page=gestioneStato" method="post"  onsubmit="controllaStato(<?php echo count($lista); ?>);">
        <div class="col-md-12 col-sm-12 col-xs-12">      
            <div style="float:left; width:150px; height:80px; margin-left:280px; display:block ">
                <label>Nuovo Stato<span>*</span></label>
                <?php
                $funzioni_admin = new funzioni_admin(); 
                $list = $funzioni_admin->get_list_id('campaign_states');
                $lista_field = array_column($list, 'id');
                $lista_name = array_column($list, 'name');
                $javascript = "  tabindex=\"7\" onfocus=\"seleziona('selectNuovoStato');\" onblur=\"deseleziona('selectNuovoStato');\" ";
                $style = "  ";
                $funzioni_admin->stampa_select2('selectNuovoStato', $lista_field, $lista_name, $javascript, $style);
                if (isset($_POST['sel1']) && isset($_POST['sel3'])) {
                    echo "<input type=\"hidden\" id=\"sel1\" name=\"sel1\" value=\"" . $_POST['sel1'] . "\" />";
                    echo "<input type=\"hidden\" id=\"sel3\" name=\"sel3\" value=\"" . $_POST['sel3'] . "\" />";
                }
                ?>

            </div>  
            <div style="float:left; width:150px; height:100px; margin-top:10px; margin-left:30px;  display:block ">
                <input class="btn btn btn-sm btn-info" type="submit" style="margin-top:15px;" id="cambia" name="cambia" tabindex=""  value="Cambia Stato" />
                <input type="hidden" id="cambiaStato" name="cambiaStato" value="1" />
            </div>  
        </div>                                            
         <div class="col-md-12 col-sm-12 col-xs-12">       
         <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action" >
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>                            
                            <th class="column-title">Stack </th>
                            <th class="column-title">Sprint </th>
                            <th class="column-title">Squad </th>
                            <th class="column-title">Nome Campagna </th>
                            <th class="column-title">Tipologia </th>
                            <th class="column-title">Canale </th>
                            <th class="column-title">Data Inzio </th>
                            <th class="column-title">Data Fine </th>
                            <th class="column-title">Stato </th>                                                    
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                            
    <?php
   
    //print_r($list);              

         $contatore = 1;
        $string = '';    
        foreach ($lista as $key => $value) {
                        $string .= "<tr  id=\"riga" . $contatore . "\"  style=\"height:25px;\" onmouseover=\"selezionaRiga(this);\"  onmouseout=\"deselezionaRiga(this);\" > ";
                        $string .= "
                                <td align=\"center\"><input type=\"checkbox\" class=\"flat\" name=\"checkbox[]\" id=\"checkbox" . $contatore . "\" onclick=\"deselezionaCheckTot(295);\" value=\"" . $value['id'] . "\"/></td>                               
                    
                    <td>" . $value['stacks_nome'] . "</td>
                    <td>" . $this->sprint_find($value['data_inizio']) . "</td>
                    <td>" . $value['squads_nome'] . "</td>
                    <td>" . $value['pref_nome_campagna'] . "</td>
                    <td>" . $value['tipo_nome'] . "</td>
                    <td>" . $this->tableChannelLabel($value). "</td>                    
                    <td align=\"center\">" . $value['data_inizio'] . "</td>
                    <td align=\"center\">" . $value['data_fine_validita_offerta'] . "</td>                    
                    <td align=\"center\">" . $value['campaign_stato_nome'] . "</td>";
        $string .= "</tr>";      
                      $contatore++;
     }
      
        $string .= "</tbody></table></div></div></form>";
        $string .= "";
        
        echo $string;
       
        //return $string;
 
    }
    


 function tableGestione($list) {    
    // print_r($list);
            ?>                                                    
                    <!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <table id="datatable-responsive" cellspacing="0" width="100%">
                    <table id="datatable-scroll" class="table table-bordered nowrap">
                    <table id="datatable-scroll" class="table table-bordered nowrap" style="width:100%">
                    <table id="datatable-pianificazione" class="display compact table-bordered table-striped  table-hover no-margin" cellspacing="0" cellpadding="0">-->    
                    <table id="datatable-pianificazione" class="display compact table-bordered text-nowrap table-hover no-margin nowrap" cellspacing="0" cellpadding="0" defer>
                        <thead>
                            <tr>
                            <th class="not-export-col">Azione</th>
                            <th>N°</th>
                            <th>Stack</th> 
                            <th>Sprint</th>                                                       
                            <th>Squad</th>
                            <th>Nome_Campagna</th>
                            <th>Tipologia</th>                         
                            <th>Cod. Camp.</th>                                                        
                            <th>Cod. Com.</th>
                            <th>Modalità</th>                            
                            <th>Priorità</th>
                            <th>Descrizione Attvità</th>
                            <th>Canale</th>
                            <th>Tipo</th>
                            <th>Data Inizio Campagna</th>
                            <th>Data Fine Campagna</th> 
                            <th>Volume (k)</th>
                            <th>Stato</th>
                            <th>Username</th>
                            <th>Data Inserimento</th>  
                            <th>Stato</th>
                            <th>Tipo Offerta</th>
                            <th>Tipo Contratto</th>
                            <th>Consenso</th>                            
                            <th>Mercato</th>                            
                            <th>Frodatori</th>                                                                                             
                            <th>Indicatore Dinamico</th>                            
                            <th>Control Group</th>                                                                                                                                  
                            </tr>
                        </thead>
                        <tbody>
                            
    <?php
        $page_protect = new Access_user;
        $string = '';
        $riga = 1;
        $tot_volume = $this->tot_volume();
        $tot_volume['totale'] = 0;
    
        //print_r($list);              
        foreach ($list as $key => $row) {
            $stato_elimina = $row['elimina'];        
            $permission = $page_protect->check_permission($row['squad_id']); 
            $string .= "<tr><td>".'   
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaModifica'.$row['id'].'"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="modifica" />                                                                
                        </form>
                        <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaDuplica'.$row['id'].'"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="duplica" />                                                                
                        </form>
                        <form action="index.php?page=pianificazione2"  method="post" id="campagnaElimina'.$row['id'].'"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="elimina" />                                                                
                        </form>

                    <button class="btn btn-xs btn-primary" type="submit" onclick="manageCamp('.$row['id'].', \'modifica\','.$permission.');"  data-placement="bottom" data-toggle="tooltip" data-original-title="Modifica" title="Modifica"><i class="fa fa-edit" ></i></button>
                    <button class="btn btn-xs btn-default" type="submit" onclick="manageCamp('.$row['id'].',\'duplica\','.$permission.');"  data-placement="bottom" data-toggle="tooltip" data-original-title="Duplica" title="Duplica"><i class="fa fa-clone" ></i></button>
                    <button class="btn btn-xs btn-danger" type="submit" onclick="manageCamp('.$row['id'].',\'elimina\','.$permission.','.$stato_elimina.');"  data-placement="bottom" data-toggle="tooltip" data-original-title="Elimina" title="Elimina"><i class="fa fa-trash-o"></i></button>                    
                '.  "</td>";
        $string .= "<td>".$riga."</td>";
        $string .= "<td>".$row['stacks_nome']."</td>";
        $string .= "<td>".$this->sprint_find($row['data_inizio'])."</td>";
        $string .= "<td>".$row['squads_nome']."</td>";
        $string .= "<td>".'
                         <form action="index.php?page=inserisciCampagna2" method="post" id="campagnaOpen'.$row['id'].'"> 
                            <input type="hidden" name="id" value="'.$row['id'].'" />
                            <input type="hidden" name="azione" value="open" />                                                                
                        </form>
                        <a href="#" data-placement="bottom" data-toggle="tooltip" title="Open" onclick="manageCamp('.$row['id'].', \'open\');">'.stripslashes($row['pref_nome_campagna']).'</a>
                '
                . "</td>";
        $string .= "<td>".$row['tipo_nome']."</td>"; 
        $string .= "<td>".$row['cod_campagna']."</td>"; 
        $string .= "<td>".$row['cod_comunicazione']."</td>";               
        $string .= "<td>".$row['modality_nome']."</td>";
        $string .= "<td>".$row['priority']."</td>";
        $string .= "<td>".$row['descrizione_target']."</td>";
        $string .= "<td>".$this->tableChannelLabel($row)."</td>";
        $string .= "<td>".$this->getCriteri($row,'tipo_leva')."</td>";
        $string .= "<td>".$row['data_inizio']."</td>";
        $string .= "<td>".$row['data_fine_validita_offerta']."</td>";
        $string .= "<td><strong>".$this->round_volume($row['volume'])."</strong></td>";
        
        $string .= "<td class=\"stato\">".$row['campaign_stato_nome']."</td>";
        $string .= "<td>".$row['username']."</td>";        
        $string .= "<td>".$row['data_inserimento']."</td>";

        $string .= "<td>".$this->getCriteri($row,'stato')."</td>";
        $string .= "<td>".$this->getCriteri($row,'tipo_offerta')."</td>";
        $string .= "<td>".$this->getCriteri($row,'tipo_contratto')."</td>";
        $string .= "<td>".$this->getCriteri($row,'consenso')."</td>";
        $string .= "<td>".$this->getCriteri($row,'mercato')."</td>";
        $string .= "<td>".$this->getCriteri($row,'frodatori')."</td>";        
        $string .= "<td>".$row['indicatore_dinamico']."</td>";        
        $string .= "<td>".$this->getCriteri($row,'control_group')."</td>";
        
        $string .= "</tr>";      
        $riga++; 
     }
      
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
        
        //echo 'dentro getFilter prima';
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

        
        if(!empty($filter_view["sprint"])){
            $sprint = $filter_view["sprint"]; 
            
            //Modifica Start End Data quando lo sprint finesce o iizia prma del Range Data
            if($this->sprint_overDate($endDate,$sprint)){
                $endDate = $this->sprint_date($sprint,'data_fine');
                $_POST['endDate'] = $endDate; 
                $startDate = $filter_view["startDate"]; 
            }
            elseif($this->sprint_anteDate($startDate,$sprint)){
                $startDate = $this->sprint_date($sprint,'data_inizio');
                $endDate = $filter_view["endDate"];
                $_POST['startDate'] = $startDate; 

            }

        }else{
                $sprint = '';
            }     
        
        //$sprint = $_POST['sprint'];
                    
        //print_r($filter_view);
        
        //echo 'dentro getFilter dopo modifica';
        //print_r($_POST); 

        $_SESSION['filter'] = array("sprint"=>$sprint,"startDate"=>$startDate,"endDate"=>$endDate,"channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
        
        return array("sprint"=>$sprint, "startDate"=>$startDate,"endDate"=>$endDate,"channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
   
    }

    function getFilter2(){
        
        //echo 'dentro getFilter prima';
        //print_r($_POST); 
        if(isset($_POST)){
            $filter_view = $_POST;           
        }
        elseif($_SESSION['filter']){    
            $filter_view = $_SESSION['filter'];
        }
        else{
            $filter_view= $this->reset_filter();
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

        
        if(!empty($filter_view["sprint"])){
            $sprint = $filter_view["sprint"]; 
            
            //Modifica Start End Data quando lo sprint finesce o iizia prma del Range Data
            if($this->sprint_overDate($endDate,$sprint)){
                $endDate = $this->sprint_date($sprint,'data_fine');
                $_POST['endDate'] = $endDate; 
                $startDate = $filter_view["startDate"]; 
            }
            elseif($this->sprint_anteDate($startDate,$sprint)){
                $startDate = $this->sprint_date($sprint,'data_inizio');
                $endDate = $filter_view["endDate"];
                $_POST['startDate'] = $startDate; 

            }

        }else{
                $sprint = '';
            }     
        
        //$sprint = $_POST['sprint'];
                    
        //print_r($filter_view);
        
        //echo 'dentro getFilter dopo modifica';
        //print_r($_POST); 

        $_SESSION['filter'] = array("sprint"=>$sprint,"startDate"=>$startDate,"endDate"=>$endDate,"channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
        
        return array("sprint"=>$sprint, "startDate"=>$startDate,"endDate"=>$endDate,"channels"=>$channels,"squads"=>$squads,"stacks"=>$stacks,"states"=>$states,"typologies"=>$typologies);
   
    }

		
	function sprint_overDate($endDate, $sprint_id) {
        
    
        $query3 = "SELECT * FROM `sprints` WHERE id=$sprint_id ";
        
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        /*
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r[$obj3['id']] = $obj3;

         
        }
        */
        $obj3 = $result3->fetch_array(MYSQLI_ASSOC);
        if(strtotime($obj3['data_fine'])>strtotime($endDate)){
            return true;
        }
        return false;
        
    }

    function sprint_anteDate($startDate, $sprint_id) {
        
    
        $query3 = "SELECT * FROM `sprints` WHERE id=$sprint_id ";
        
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        /*
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r[$obj3['id']] = $obj3;

         
        }
        */
        $obj3 = $result3->fetch_array(MYSQLI_ASSOC);
        if(strtotime($obj3['data_inizio'])<strtotime($startDate)){
            return true;
        }
        return false;
        
    }

    function sprint_date($sprint_id, $data_flag='both') {
        
        
        $query3 = "SELECT * FROM `sprints` WHERE id=$sprint_id ";
        
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        /*
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r[$obj3['id']] = $obj3;

         
        }
        */
        $obj3 = $result3->fetch_array(MYSQLI_ASSOC);
        if($data_flag=='data_inizio'){
            return $obj3['data_inizio'];
        }
        if($data_flag=='data_fine'){
            return $obj3['data_fine'];
        }
        if($data_flag=='both'){
            return array('data_inizio'=>$obj3['data_inizio'],'data_fine'=>$obj3['data_fine']);
        }
        return false;
        
    }



    function reset_filter2(){
        unset($_SESSION['filter']); 
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
        
        //$filter_view = $_POST;
    if(isset($_POST["startDate"])){
        $filter_view = $_POST;
    }
    else{
        $filter_view = $_SESSION['filter'];
    }

        $startDate = $filter_view["startDate"];
        $endDate = $filter_view["endDate"];
        
        $interval = $this->dateDifference($startDate, $endDate);
        
        return $interval;
 
    }
    
function datePeriod(){    
    //$filter_view = $_POST;
    if(isset($_POST["startDate"])){
        $filter_view = $_POST;
    }
    else{
        $filter_view = $_SESSION['filter'];
    }

   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);
   
////////////////////////////////////
   $differenza = $begin->diff($end);
   if($differenza->format('%a')<=7){
        $day_add = 30 - $differenza->format('%a');
        $stringa = '+'.$day_add. 'day';
        $end = $end->modify($stringa);
   }
 /////////////////////////////////
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);

   foreach($daterange as $date){
       echo "<th>".$date->format("d D") . "</th>";
   }
}

function datePeriodExcel(){    
    //$filter_view = $_POST;
    if(isset($_POST["startDate"])){
        $filter_view = $_POST;
    }
    else{
        $filter_view = $_SESSION['filter'];
    }

   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);
   $data = array(); 
   foreach($daterange as $date){
       $data[] = $date->format("d D");
   }
   return $data;
}

function daterange(){    
    if(isset($_POST["startDate"])){
        $filter_view = $_POST;
    }
    else{
        $filter_view = $_SESSION['filter'];
    }

   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);


////////////////////////////////////
   $differenza = $begin->diff($end);
   if($differenza->format('%a')<=7){
        $day_add = 30 - $differenza->format('%a');
        $stringa = '+'.$day_add. 'day';
        $end = $end->modify($stringa);
   }
 /////////////////////////////////
   $differenza = $begin->diff($end);

   if($differenza->format('%a')<=7){
        $end = $end->modify( '+7 day' );
   }
 /////////////////////////////////  
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
    if(isset($_POST["startDate"])){
        $filter_view = $_POST;
    }
    else{
        $filter_view = $_SESSION['filter'];
    }
    
   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);

////////////////////////////////////
   $differenza = $begin->diff($end);
   if($differenza->format('%a')<=7){
        $day_add = 30 - $differenza->format('%a');
        $stringa = '+'.$day_add. 'day';
        $end = $end->modify($stringa);
   }
 /////////////////////////////////
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);
   $day_list = array();
   foreach($daterange as $date){

       $tot_volume[date_timestamp_get($date)] = 0;
       
   }
   
   return $tot_volume;
   
}


function tot_volume2(){   

        $filter_view = $_SESSION['filter'];
    
    
   $begin = new DateTime($filter_view["startDate"]);
   $end = new DateTime($filter_view["endDate"]);

////////////////////////////////////
   $differenza = $begin->diff($end);
   if($differenza->format('%a')<=7){
        $day_add = 30 - $differenza->format('%a');
        $stringa = '+'.$day_add. 'day';
        $end = $end->modify($stringa);
   }
 ///////////////////////////////// 
   $end = $end->modify( '+1 day' );

   $interval = new DateInterval('P1D');
   $daterange = new DatePeriod($begin, $interval ,$end);
   
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
            
            if($row['escludi_sab_dom']==0){
                    //da lunedi a domenica tutti i giorni
                    //if(($row['durata_campagna'] > $count) and ($date->format('N')<6)){
                       $volume[date_timestamp_get($date)]  = $volume_giornaliero[$count];
                       $count++;
                    //}
            }
            elseif($row['escludi_sab_dom']==1){
                //con esclusione del sabato
                if($date->format('N')<>6){
                   $volume[date_timestamp_get($date)]  = $volume_giornaliero[$count];
                   $count++;
                }
            }
            elseif($row['escludi_sab_dom']==2){
                //con esclusione del domenica
                if($date->format('N')<>7){
                   $volume[date_timestamp_get($date)]  = $volume_giornaliero[$count];
                   $count++;
                }
            }
            elseif($row['escludi_sab_dom']==3){
                //con esclusione del sabato e dom
                if($date->format('N')<6){
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
            $m = number_format($r / 1000, 1,",",".");
            //$m = round($r / 1000, 1);
        } else {
            $m = number_format($r / 1000, 0,",",".");
            //$m = round($r / 1000, 0);
        }
        return $m;
        //return number_format($m, 1, ',', '.');
        
    }


 function sprint_find($startDate) {
        
        if(isset($startDate)){
            $query3 = "SELECT * FROM `sprints` WHERE `data_inizio`<='".$startDate."' ORDER BY id DESC LIMIT 0, 1";
        }
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        /*
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r[$obj3['id']] = $obj3;

         
        }
        */
        $obj3 = $result3->fetch_array(MYSQLI_ASSOC);
        return $obj3['name'];
    }
        
    
    function bgcolor($daytimestamp) {
        $bgcolor = " ";
        if (date('D', $daytimestamp) === "Sun") {
            //$bgcolor = " bgcolor=\"lightgray\"";
            $bgcolor = " bgcolor=\"#808080\"";
        }

        return $bgcolor;
    }

    function bgcolor_sun($daytimestamp) { 
        
        if (date('D', $daytimestamp) === "Sun") {
            //$bgcolor = " bgcolor=\"lightgray\"";
            return true;
        }
        return false;
    }

    function hexToRgb($hex, $alpha = false) {
        $hex      = str_replace('#', '', $hex);
        $length   = strlen($hex);
        $rgb['r'] = hexdec($length == 6 ? substr($hex, 0, 2) : ($length == 3 ? str_repeat(substr($hex, 0, 1), 2) : 0));
        $rgb['g'] = hexdec($length == 6 ? substr($hex, 2, 2) : ($length == 3 ? str_repeat(substr($hex, 1, 1), 2) : 0));
        $rgb['b'] = hexdec($length == 6 ? substr($hex, 4, 2) : ($length == 3 ? str_repeat(substr($hex, 2, 1), 2) : 0));
        if ( $alpha ) {
            $rgb['a'] = $alpha;
        }
        $colorRGB = ''.$rgb['r'].','.$rgb['g'].','.$rgb['b'].''; 
        return $colorRGB;
    }

    function bordercolor($daytimestamp) {
        $bgcolor = " ";
        if (date('D', $daytimestamp) === "Sun") {
            $bgcolor = " bodercolor=\"red\"";
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

        function messages($num) {
        $host = "http://" . $_SERVER['HTTP_HOST'];
        switch ($this->language) {
            case "de":
                $msg[10] = "Login und/oder Passwort finden keinen Treffer in der Datenbank.";
                $msg[11] = "Login und/oder Passwort sind leer!";
                $msg[12] = "Leider existiert bereits ein Benutzer mit diesem Login und/oder E-mailadresse.";
                $msg[13] = "Weitere Anweisungen wurden per E-mail versandt, folgen Sie nun den Instruktionen.";
                $msg[14] = "Es is ein Fehler entstanden probieren Sie es erneut.";
                $msg[15] = "Es is ein Fehler entstanden probieren Sie es sp�ter nochmal.";
                $msg[16] = "Die eingegebene E-mailadresse ist nicht g�ltig.";
                $msg[17] = "Das Feld login (min. " . LOGIN_LENGTH . " Zeichen) muss eingegeben sein.";
                $msg[18] = "Ihr Benutzerkonto ist aktiv. Sie k�nnen sich nun anmelden.";
                $msg[19] = "Ihr Aktivierungs ist nicht g�ltig.";
                $msg[20] = "Da ist kein Konto zu aktivieren.";
                $msg[21] = "Der benutzte Aktivierung-Code is nicht g�ltig!";
                $msg[22] = "Keine Konto gefunden dass mit der eingegeben E-mailadresse �bereinkommt.";
                $msg[23] = "Kontrollieren Sie Ihre E-Mail um Ihr neues Passwort zu erhalten.";
                $msg[24] = "Ihr Benutzerkonto wurde aktiviert.";
                $msg[25] = "Kann Ihr Passwort nicht aktivieren.";
                $msg[26] = "Sie haben Ihr Passwort vergessen...";
                $msg[27] = "Kontrollieren Sie Ihre E-Mailbox und best�tigen Sie Ihre �nderung(en).";
                $msg[28] = "Ihre Anfrage best�tigen...";
                $msg[29] = "Hallo,\r\n\r\num Ihre Anfrage zu aktivieren klicken Sie bitte auf den folgenden Link:\r\n" . $host . $this->login_page . "?ident=" . $this->id . "&activate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nmit freundlichen Gr�ssen\r\n" . $this->admin_name;
                $msg[30] = "Ihre �nderung ist durchgef�hrt.";
                $msg[31] = "Diese E-mailadresse wird bereits genutzt, bitte w�hlen Sie eine andere.";
                $msg[32] = "Das Feld Passwort (min. " . PW_LENGTH . " Zeichen) muss eingegeben sein.";
                $msg[33] = "Hallo,\r\n\r\nIhre neue E-mailadresse muss noch �berpr�ft werden, bitte klicken Sie auf den folgenden Link:\r\n" . $host . $this->login_page . "?id=" . $this->id . "&validate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nmit freundlichen Gr�ssen\r\n" . $this->admin_name;
                $msg[34] = "Da ist keine E-mailadresse zu �berpr�fen.";
                $msg[35] = "Hallo,\r\n\r\nIhr neues Passwort kann nun eingegeben werden, bitte klicken Sie auf den folgenden Link:\r\n" . $host . $this->password_page . "?activate=" . md5($this->user . SECRET_STRING) . "&language=" . $this->language . "\r\n\r\nmit freundlichen Gr�ssen\r\n" . $this->admin_name;
                $msg[36] = "Ihr Antrag ist verarbeitet und wird nun durch den Administrator kontrolliert. \r\nSie erhalten eine Nachricht wenn dies geschehen ist.";
                $msg[37] = "Hallo " . $this->user_full_name . ",\r\n\r\nIhr Konto ist nun eigerichtet und Sie k�nnen sich nun anmelden.\r\n\r\nKlicken Sie hierf�r auf den folgenden Link:\r\n" . $host . $this->login_page . "\r\n\r\nmit freundlichen Gr�ssen\r\n" . $this->admin_name;
                $msg[38] = "Das best&auml;tigte Passwort hat keine &Uuml;bereinstimmung mit dem ersten Passwort, bitte probieren Sie es erneut.";
                $msg[39] = "Neuer Benutzer...";
                $msg[40] = "Es hat sich am " . date("Y-m-d") . " ein neuer Benutzer angemeldet.\r\n\r\nKlicken Sie hier um zur Verwaltungsseite zu gelangen:\r\n\r\n" . $host . $this->admin_page . "?login_id=" . $this->id;
                $msg[41] = "Best�tigen Sie Ihre E-mailadresse...";
                $msg[42] = "Ihre E-mailadresse wurde ge�ndert.";
                break;
                break;
            case "nl":
                $msg[10] = "Gebruikersnaam en/of wachtwoord vinden geen overeenkomst in de database.";
                $msg[11] = "Gebruikersnaam en/of wachtwoord zijn leeg!";
                $msg[12] = "Helaas bestaat er al een gebruiker met deze gebruikersnaam en/of e-mail adres.";
                $msg[13] = "Er is een e-mail is aan u verzonden, volg de instructies die daarin vermeld staan.";
                $msg[14] = "Het is een fout ontstaan, probeer het opnieuw.";
                $msg[15] = "Het is een fout ontstaan, probeer het later nog een keer.";
                $msg[16] = "De opgegeven e-mail adres is niet geldig.";
                $msg[17] = "De gebruikersnaam (min. " . LOGIN_LENGTH . " teken) moet opgegeven zijn.";
                $msg[18] = "Het gebruikersaccount is aangemaakt, u kunt u nu aanmelden.";
                $msg[19] = "Kan uw account niet activeren.";
                $msg[20] = "Er is geen account te activeren.";
                $msg[21] = "De gebruikte activeringscode is niet geldig!";
                $msg[22] = "Geen account gevonden dat met de opgegeven e-mail adres overeenkomt.";
                $msg[23] = "Er is een e-mail is aan u verzonden, daarin staat hoe uw een nieuw wachtwoord kunt aanmaken.";
                $msg[24] = "Uw gebruikersaccount is geactiveerd... ";
                $msg[25] = "Kan het wachtwoord niet activeren.";
                $msg[26] = "U bent uw wachtwoord vergeten...";
                $msg[27] = "Er is een e-mail is aan u verzonden, volg de instructies die daarin vermeld staan.";
                $msg[28] = "Bevestig uw aanvraag ...";
                $msg[29] = "Hallo,\r\n\r\nBedankt voor uw aanvraag,\r\n\r\nklik op de volgende link om de aanvraag te verwerken:\r\n" . $host . $this->login_page . "?ident=" . $this->id . "&activate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nmet vriendelijke groet\r\n" . $this->admin_name;
                $msg[30] = "Uw wijzigingen zijn doorgevoerd.";
                $msg[31] = "Dit e-mailadres bestaat al, gebruik en andere.";
                $msg[32] = "Het veld wachtwoord (min. " . PW_LENGTH . " teken) mag niet leeg zijn.";
                $msg[33] = "Beste gebruiker,\r\n\r\nde nieuwe e-mailadres moet nog gevalideerd worden, klik hiervoor op de volgende link:\r\n" . $host . $this->login_page . "?id=" . $this->id . "&validate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nmet vriendelijke groet\r\n" . $this->admin_name;
                $msg[34] = "Er is geen e-mailadres te valideren.";
                $msg[35] = "Hallo,\r\n\r\nuw nieuw wachtwoord kan nu ingevoerd worden, klik op deze link om verder te gaan:\r\n" . $host . $this->password_page . "?activate=" . md5($this->user . SECRET_STRING) . "&language=" . $this->language . "\r\n\r\nmet vriendelijke groet\r\n" . $this->admin_name;
                $msg[36] = "U aanvraag is verwerkt en wordt door de beheerder binnenkort activeert. \r\nU krijgt bericht wanneer dit gebeurt is.";
                $msg[37] = "Hallo " . $this->user_full_name . ",\r\n\r\nHet account is nu gereed en u kunt zich aanmelden.\r\n\r\nKlik hiervoor op de volgende link:\r\n" . $host . $this->login_page . "\r\n\r\nmet vriendelijke groet\r\n" . $this->admin_name;
                $msg[38] = "Het bevestigings wachtwoord komt niet overeen met het wachtwoord, probeer het opnieuw.";
                $msg[39] = "Nieuwe gebuiker...";
                $msg[40] = "Er heeft zich een nieuwe gebruiker aangemeld op " . date("Y-m-d") . ":\r\n\r\nKlik hier voor toegang tot de beheer pagina:\r\n\r\n" . $host . $this->admin_page . "?login_id=" . $this->id;
                $msg[41] = "Bevestiging e-mail adres...";
                $msg[42] = "Uw e-mailadres is gewijzigd.";
                break;
            case "fr":
                $msg[10] = "Le login et/ou mot de passe ne correspondent pas.";
                $msg[11] = "Le login et/ou mot de passe est vide !";
                $msg[12] = "D�sol�, un utilisateur avec le m�me email et/ou login existe d�j�.";
                $msg[13] = "V�rifiez votre email et suivez les instructions.";
                $msg[14] = "D�sol�, une erreur s'est produite. Veuillez r�essayer.";
                $msg[15] = "D�sol�, une erreur s'est produite. Veuillez r�essayer plus tard.";
                $msg[16] = "L'adresse email n'est pas valide.";
                $msg[17] = "Le champ \"Nom d'usager\" doit �tre compos� d'au moins " . LOGIN_LENGTH . " carat�res.";
                $msg[18] = "Votre requete est compl�te. Enregistrez vous pour continuer.";
                $msg[19] = "D�sol�, nous ne pouvons pas activer votre account.";
                $msg[20] = "D�sol�, il n'y � pas d'account � activer.";
                $msg[21] = "D�sol�, votre clef d'authorisation n'est pas valide";
                $msg[22] = "D�sol�, il n'y � pas d'account actif avec cette adresse email.";
                $msg[23] = "Veuillez consulter votre email pour recevoir votre nouveau mot de passe.";
                $msg[24] = "Votre compte est pr�t � l'usage";
                $msg[25] = "D�sol�, nous ne pouvons pas activer votre mot de passe.";
                $msg[26] = "Vous avez oubli� votre mot de passe...";
                $msg[27] = "Veuillez consulter votre email pour activer les modifications.";
                $msg[28] = "Votre requete doit etre ex�cuter...";
                $msg[29] = "Bonjour,\r\n\r\npour activer votre account clickez sur le lien suivant:\r\n" . $host . $this->login_page . "?ident=" . $this->id . "&activate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nCordialement\r\n" . $this->admin_name;
                $msg[30] = "Votre account � �t� modifi�.";
                $msg[31] = "D�sol�, cette adresse email existe d�j�, veuillez en utiliser une autre.";
                $msg[32] = "Le champ password (min. " . PW_LENGTH . " char) est requis.";
                $msg[33] = "Bonjour,\r\n\r\nvotre nouvelle adresse email doit �tre valid�e, clickez sur le liens suivant:\r\n" . $host . $this->login_page . "?id=" . $this->id . "&validate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nCordialement\r\n" . $this->admin_name;
                $msg[34] = "Il n'y � pas d'email � valider.";
                $msg[35] = "Bonjour,\r\n\r\nPour entrer votre nouveaux mot de passe, clickez sur le lien suivant:\r\n" . $host . $this->password_page . "?activate=" . md5($this->user . SECRET_STRING) . "&language=" . $this->language . "\r\n\r\nCordialement\r\n" . $this->admin_name;
                $msg[36] = "Votre demande a �t� bien trait�e et d'ici peu l'administrateur va l 'activer. Nous vous informerons quand ceci est arriv�.";
                $msg[37] = "Bonjour " . $this->user_full_name . ",\r\n\r\nVotre compte est maintenant actif et il est possible d'y avoir acc�s.\r\n\r\nCliquez sur le lien suivant afin de rejoindre la page d'acc�s:\r\n" . $host . $this->login_page . "\r\n\r\nCordialement\r\n" . $this->admin_name;
                $msg[38] = "Le mot de passe de confirmation de concorde pas avec votre mot de passe. Veuillez r�essayer";
                $msg[39] = "Nouvel utilisateur...";
                $msg[40] = "Nouvel utilisateur s'est enregistr� " . date("Y-m-d") . ":\r\n\r\nCliquez ici pour acc�der au page d'administration:\r\n\r\n" . $host . $this->admin_page . "?login_id=" . $this->id;
                $msg[41] = "Confirmez l'adresse email...";
                $msg[26] = "Votre adresse email est modifi�e.";
                break;
            default:
                $msg[10] = "Login and/or password did not match to the database.";
                $msg[11] = "Login and/or password is empty!";
                $msg[12] = "Sorry, a user with this login and/or e-mail address already exist.";
                $msg[13] = "Please check your e-mail and follow the instructions.";
                $msg[14] = "Sorry, an error occurred please try it again.";
                $msg[15] = "Sorry, an error occurred please try it again later.";
                $msg[16] = "The e-mail address is not valid.";
                $msg[17] = "The field login (min. " . LOGIN_LENGTH . " char.) is required.";
                $msg[18] = "Your request is processed. Login to continue.";
                $msg[19] = "Sorry, cannot activate your account.";
                $msg[20] = "There is no account to activate.";
                $msg[21] = "Sorry, this activation key is not valid!";
                $msg[22] = "Sorry, there is no active account which match with this e-mail address.";
                $msg[23] = "Please check your e-mail to get your new password.";
                $msg[24] = "Your user account is activated... ";
                $msg[25] = "Sorry, cannot activate your password.";
                $msg[26] = "Your forgotten password...";
                $msg[27] = "Please check your e-mail and activate your modification(s).";
                $msg[28] = "Your request must be processed...";
                $msg[29] = "Hello,\r\n\r\nto activate your request click the following link:\r\n" . $host . $this->login_page . "?ident=" . $this->id . "&activate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nkind regards\r\n" . $this->admin_name;
                $msg[30] = "Your account is modified.";
                $msg[31] = "This e-mail address already exist, please use another one.";
                $msg[32] = "The field password (min. " . PW_LENGTH . " char) is required.";
                $msg[33] = "Hello,\r\n\r\nthe new e-mail address must be validated, click the following link:\r\n" . $host . $this->login_page . "?id=" . $this->id . "&validate=" . md5($this->user_pw) . "&language=" . $this->language . "\r\n\r\nkind regards\r\n" . $this->admin_name;
                $msg[34] = "There is no e-mail address for validation.";
                $msg[35] = "Hello,\r\n\r\nEnter your new password next, please click the following link to enter the form:\r\n" . $host . $this->password_page . "?activate=" . md5($this->user . SECRET_STRING) . "&language=" . $this->language . "\r\n\r\nkind regards\r\n" . $this->admin_name;
                $msg[36] = "Your request is processed and is pending for validation by the admin. \r\nYou will get an e-mail if it's done.";
                $msg[37] = "Hello " . $this->user_full_name . ",\r\n\r\nThe account is active and it's possible to login now.\r\n\r\nClick on this link to access the login page:\r\n" . $host . $this->login_page . "\r\n\r\nkind regards\r\n" . $this->admin_name;
                $msg[38] = "The confirmation password does not match the password. Please try again.";
                $msg[39] = "A new user...";
                $msg[40] = "There was a new user registration on " . date("Y-m-d") . ":\r\n\r\nClick here to enter the admin page:\r\n\r\n" . $host . $this->admin_page . "?login_id=" . $this->id;
                $msg[41] = "Validate your e-mail address..."; // subject in e-mail
                $msg[42] = "Your e-mail address is modified.";
               
                
        }
        return $msg[$num];
    }

}