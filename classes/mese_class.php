<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of mese_class
 *
 * @author vanhelsing
 */
include_once 'db_config.php';

class Mese_class {

    var $db_link;
    var $months_list;

    function mese_class() {
        $this->db_link = $this->connect_db_li();
        $this->months_list = $this->get_months_table();
    }

    function connect_db_li() {
        //$conn_str = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
        $conn_str = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, "ing") or die("Error " . mysqli_error($conn_str));
        //   var_dump($conn_str);
        if (mysqli_connect_errno()) {
            printf("Connect failed: %s\n", mysqli_connect_error());
            exit();
        }
        return $conn_str;
    }
    
    function get_months_table() { 
        if (!isset($_SESSION['operator']) || ($_SESSION['operator']== '3')) {
            $months_table = 'lista_tabelle';
        }
        elseif ($_SESSION['operator'] == 'wind') {
            $months_table = 'wind_mesi';
        }
        return $months_table;
    }
    
    function windtable_net($month) { 
        $pieces = explode("_", $month);
        $mese_rete = $pieces[0]."_rete_".$pieces[1];
        return $mese_rete;
    }

    function get_last_month() {
        $risultato = array();
        $query3 = "SELECT * FROM `$this->months_list` ORDER BY `$this->months_list`.`ordine` desc LIMIT 0 ,1";
        //echo $query3;
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
        $result = array();
        $result['id'] = $obj3['id'];
        $result['ordine'] = $obj3['ordine'];
        $result['nome_visualizzato'] = $obj3['nome_visualizzato'];
        $result['nome_tabella'] = $obj3['nome_tabella'];
        return $result;
    }

    function get_second_to_last() {
        $risultato = array();
        $query3 = "SELECT * FROM `$this->months_list` ORDER BY `$this->months_list`.`ordine` desc LIMIT 1 ,1";
        //echo $query3;
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
        $result = array();
        $result['id'] = $obj3['id'];
        $result['ordine'] = $obj3['ordine'];
        $result['nome_visualizzato'] = $obj3['nome_visualizzato'];
        $result['nome_tabella'] = $obj3['nome_tabella'];
        return $result;
    }

    function get_mese($mese) {
        $risultato = array();
        $query3 = "SELECT * FROM `$this->months_list` where  nome_tabella='$mese' ORDER BY `$this->months_list`.`ordine` desc LIMIT 0 ,1";
        //echo $query3;
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
        $result = array();
        $result['id'] = $obj3['id'];
        $result['ordine'] = $obj3['ordine'];
        $result['nome_visualizzato'] = $obj3['nome_visualizzato'];
        $result['nome_tabella'] = $obj3['nome_tabella'];
        return $result;
    }

    function get_last_year() {
        $id_seme = $this->get_mese_ordine($mese);
        $risultato = array();
        $query3 = "SELECT * FROM `$this->months_list` where ordine<=$id_seme ORDER BY `$this->months_list`.`ordine` desc LIMIT 0 , $numero_mesi";
        //echo $query3;
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        while ($obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
            $risultato[] = array('nome' => $obj3['nome_visualizzato'], 'tabella' => $obj3['nome_tabella']);
        }
        return $risultato;
    }

    function get_previous_year($mese) {
        $risultato = array();
        $id_mese = $this->get_mese($mese);
        $query3 = "SELECT * FROM `$this->months_list` where  ordine<='" . $id_mese['ordine'] . "' ORDER BY `$this->months_list`.`ordine` desc LIMIT 12,1";
        //echo $query3;
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
        $result = array();
        $result['id'] = $obj3['id'];
        $result['ordine'] = $obj3['ordine'];
        $result['nome_visualizzato'] = $obj3['nome_visualizzato'];
        $result['nome_tabella'] = $obj3['nome_tabella'];
        return $result;
    }

    function get_previous_mount($mese) {
        $risultato = array();
        $id_mese = $this->get_mese($mese);
        $query3 = "SELECT * FROM `$this->months_list` where  ordine<='" . $id_mese['ordine'] . "' ORDER BY `$this->months_list`.`ordine` desc LIMIT 1,1";
        //echo $query3;
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
        $result = array();
        $result['id'] = $obj3['id'];
        $result['ordine'] = $obj3['ordine'];
        $result['nome_visualizzato'] = $obj3['nome_visualizzato'];
        $result['nome_tabella'] = $obj3['nome_tabella'];
        return $result;
    }
    
    function get_last_six_month() {
        $risultato = array();
        $query3 = "SELECT * FROM `$this->months_list` ORDER BY `$this->months_list`.`ordine` desc LIMIT 0 ,6";
        //echo $query3; 
        $result3 = mysqli_query($this->db_link, $query3) or die($query3 . " - " . mysql_error());
        $key = 0;
        while ($obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) {          
            $result[$key]['id'] = $obj3['id'];
            $result[$key]['ordine'] = $obj3['ordine'];
            $result[$key]['nome_visualizzato'] = $obj3['nome_visualizzato'];
            $result[$key]['nome_tabella'] = $obj3['nome_tabella'];
            $key++;
        }
        #print_r($result);
        return $result;
        
    }

}
