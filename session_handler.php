<?php
require_once (__DIR__.'/db_config.php');
error_reporting (E_ALL);
/* This class code is based on the tutorial of Matt Wade 
  from http://www.zend.com/zend/spotlight/code-gallery-wade8.php */

/* Create new object of class */
$ses_class = new session();

ini_set('display_errors', '1');
/* Change the save_handler to use the class functions */
//session_set_save_handler(array(&$ses_class, '_open'), array(&$ses_class, '_close'), array(&$ses_class, '_read'), array(&$ses_class, '_write'), array(&$ses_class, '_destroy'), array(&$ses_class, '_gc'));
/* Start the session */
session_start();


class session {
    /* Define the mysql table you wish to use with 
      this class, this table MUST exist. */
    var $mysqli;

    var $ses_table = SESSION_TABLE;
    var $log_table = LOG_TABLE;

    /* Change to 'Y' if you want to connect to a db in 
      the _open function */
    var $db_con = "Y";

    /* Configure the info to connect to MySQL, only required 
      if $db_con is set to 'Y' */
    var $db_host = DB_SERVER;
    var $db_user = DB_USER;
    var $db_pass = DB_PASSWORD;
    var $db_dbase = DB_NAME;

    /* Create a connection to a database */
    
    public function __construct(){
        $mysqli = $this->db_connect();
    }    
    
    
    
    function db_connect() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            return FALSE;
        } else {
            return TRUE;
        }
    }
    


    /* Open session, if you have your own db connection 
      code, put it in here! */

    function _open($path, $name) {
        if ($this->db_con == "Y") {
            $this->db_connect();
        }

        return TRUE;
    }

    /* Close session */

    function _close() {
        /* This is used for a manual call of the 
          session gc function */
        $this->_gc(0);
        return TRUE;
    }

    /* Read session data from database */

    function _read($ses_id) {
        $session_sql = "SELECT * FROM " . $this->ses_table
                . " WHERE ses_id = '$ses_id'";
        $session_res = mysqli_query($this->mysqli,$session_sql);
        if (!$session_res) {
            return '';
        }

        $session_num = mysqli_num_rows($session_res);
        if ($session_num > 0) {
            $session_row = mysqli_fetch_assoc($session_res);
            $ses_data = $session_row["ses_value"];
            return $ses_data;
        } else {
            return '';
        }
    }

    /* Write new data to database */

    function _write($ses_id, $data) {




        $session_sql = "UPDATE " . $this->ses_table
                . " SET ses_time='" . time()
                . "', ses_value='$data' WHERE ses_id='$ses_id'";

        $session_res = mysqli_query($this->mysqli,$session_sql);
        if (!$session_res) {
            return FALSE;
        }
        if (mysqli_affected_rows($this->mysqli)) {
            return TRUE;
        }
/*
        include_once 'funzioni_admin.php';
        $funzioni_admin = new funzioni_admin();
        $id_user = $funzioni_admin->get_id("users", "administrator", "login");
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }

        $temp = explode(";", $data);
        foreach ($temp as $key => $value) {
            $temp2 = explode("|", $value);
            if ($temp2[0] == "user") {
                $temp3 = explode("\"", $temp2[1]);
                $user = $temp3[1];
            }
        }
        if ($user != "") {
            $funzioni_admin = new funzioni_admin();
            $id_user = $funzioni_admin->get_id("users", $user, "login");
            $log_sql = "INSERT INTO " . $this->log_table
                    . " (id_user, inizio_sessione, ip)"
                    . " VALUES ('$id_user', '" . time()
                    . "', '" . $ip . "')";
            debug_to_console($log_sql);
            $log_sql = @mysql_query($log_sql);
        }
 * 
 */
        $session_sql = "INSERT INTO " . $this->ses_table
                . " (ses_id, ses_time, ses_start, ses_value)"
                . " VALUES ('$ses_id', '" . time()
                . "', '" . time() . "', '$data')";

        $session_res = mysqli_query($this->mysqli,$session_sql);
        if (!$session_res) {
            return FALSE;
        } else {
            return TRUE;
        }
        
    }

    /* Destroy session record in database */

    function _destroy($ses_id) {
        $session_sql = "DELETE FROM " . $this->ses_table
                . " WHERE ses_id = '$ses_id'";
        $session_res = mysqli_query($this->mysqli,$session_sql);
        if (!$session_res) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

    /* Garbage collection, deletes old sessions */

    function _gc($life) {
        $ses_life = strtotime("-240 minutes");

        $session_sql = "DELETE FROM " . $this->ses_table
                . " WHERE ses_time < $ses_life";
        $session_res = mysqli_query($this->mysqli,$session_sql);


        if (!$session_res) {
            return FALSE;
        } else {
            return TRUE;
        }
    }

}

