<?php

include_once (__DIR__.'/../funzioni_admin.php');
/* * **********************************************************************
  Access_user Class ver. 1.99
  A complete PHP suite to protect pages and maintain members

  Copyright (c) 2004 - 2008, Olaf Lederer
  All rights reserved.

  Redistribution and use in source and binary forms, with or without modification, are permitted provided that the following conditions are met:

 * Redistributions of source code must retain the above copyright notice, this list of conditions and the following disclaimer.
 * Redistributions in binary form must reproduce the above copyright notice, this list of conditions and the following disclaimer in the documentation and/or other materials provided with the distribution.
 * Neither the name of the finalwebsites.com nor the names of its contributors may be used to endorse or promote products derived from this software without specific prior written permission.

  THIS SOFTWARE IS PROVIDED BY THE COPYRIGHT HOLDERS AND CONTRIBUTORS "AS IS" AND ANY EXPRESS OR IMPLIED WARRANTIES, INCLUDING, BUT NOT LIMITED TO, THE IMPLIED WARRANTIES OF MERCHANTABILITY AND FITNESS FOR A PARTICULAR PURPOSE ARE DISCLAIMED. IN NO EVENT SHALL THE COPYRIGHT OWNER OR CONTRIBUTORS BE LIABLE FOR ANY DIRECT, INDIRECT, INCIDENTAL, SPECIAL, EXEMPLARY, OR CONSEQUENTIAL DAMAGES (INCLUDING, BUT NOT LIMITED TO, PROCUREMENT OF SUBSTITUTE GOODS OR SERVICES; LOSS OF USE, DATA, OR PROFITS; OR BUSINESS INTERRUPTION) HOWEVER CAUSED AND ON ANY THEORY OF LIABILITY, WHETHER IN CONTRACT, STRICT LIABILITY, OR TORT (INCLUDING NEGLIGENCE OR OTHERWISE) ARISING IN ANY WAY OUT OF THE USE OF THIS SOFTWARE, EVEN IF ADVISED OF THE POSSIBILITY OF SUCH DAMAGE.

  _________________________________________________________________________
  available at http://www.finalwebsites.com/snippets.php?id=10
  Comments & suggestions: http://www.finalwebsites.com/forums/forum/php-classes-support-forum

 * *********************************************************************** */

header("Cache-control: private"); // //IE 6 Fix 
// error_reporting (E_ALL); // I use this only for testing
//

require_once(__DIR__."/../../db_config.php"); // this path works for me...
// new since version 1.92: storage of sessions in MySQL
if (USE_MYSQL_SESSIONS) {
//include_once($_SERVER['DOCUMENT_ROOT']."/classes/access_user/session_handler.php"); 
    include_once(__DIR__."/../../session_handler.php");
} else {
    $timeout = 0;
    ini_set("session.gc_maxlifetime", $timeout);
    // Set the session cookie to timout
    ini_set("session.cookie_lifetime", $timeout);
    // Change the save path. Sessions stored in teh same path
    // all share the same lifetime; the lowest lifetime will be
    // used for all. Therefore, for this to work, the session
    // must be stored in a directory where only sessions sharing
    // it's lifetime are. Best to just dynamically create on.
    $seperator = strstr(strtoupper(substr(PHP_OS, 0, 3)), "WIN") ? "\\" : "/";
    $path = ini_get("session.save_path") . $seperator . "session_" . $timeout . "sec";
    if (!file_exists($path)) {
        if (!mkdir($path, 600)) {
            trigger_error("Failed to create session save path directory '$path'. Check permissions.", E_USER_ERROR);
        }
    }
    ini_set("session.save_path", $path);
    // Set the chance to trigger the garbage collection.
    ini_set("session.gc_probability", 100);
    ini_set("session.gc_divisor", 100); // Should always be 100
    // Start the session!
    session_start();
    // Renew the time left until this session times out.
    // If you skip this, the session will time out based
    // on the time when it was created, rather than when
    // it was last used.
    if (isset($_COOKIE[session_name()])) {
        setcookie(session_name(), $_COOKIE[session_name()], time() + $timeout, $cookie_domain);
    }
}

class Access_user {

    var $table_name = USER_TABLE;
    var $log_table = LOG_TABLE;
    var $user;
    var $user_pw;
    var $user_full_name;
    var $user_firstname;
    var $user_info;
    var $user_email;
    var $save_login = "yes";
    var $cookie_name = COOKIE_NAME;
    var $cookie_path = COOKIE_PATH;
    var $is_cookie;
    var $count_visit;
    var $id;
    var $language = "en"; // change this property to use messages in another language 
    var $the_msg;
    var $auto_activation; // use this variable in your login script
    var $send_copy = true; // send a mail copy (after activation) to the administrator 
    var $webmaster_mail = WEBMASTER_MAIL;
    var $webmaster_name = WEBMASTER_NAME;
    var $admin_mail = ADMIN_MAIL;
    var $admin_name = ADMIN_NAME;
    var $login_page = LOGIN_PAGE;
    var $main_page = START_PAGE;
    var $password_page = ACTIVE_PASS_PAGE;
    var $deny_access_page = DENY_ACCESS_PAGE;
    var $admin_page = ADMIN_PAGE;
    var $mysqli;


    function __construct($redirect = true) {
        $mysqli = $this->connect_dbli();
        if (empty($_SESSION['logged_in'])) {
            $this->login_reader();
            if ($this->is_cookie) {
                $this->set_user($redirect);
            }
        }
        if (isset($_SESSION['user'], $_SESSION['pw'])) {
            $this->user = $_SESSION['user'];
            $this->user_pw = $_SESSION['pw'];
        }
    }

// removed check for encoded var $this->user_pw
// replaced in default case var $password with $this->user_pw
// added MD5 to sql statement for "new_pass"
    function check_user($pass = "") {
        switch ($pass) {
            case "new":
                //  $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE email = %s OR login = %s", $this->table_name, $this->ins_string($this->user_email), $this->ins_string($this->user));
                $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE  login = %s", $this->table_name, $this->ins_string($this->user));
                break;
            case "lost":
                $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE email = %s AND active = 'y'", $this->table_name, $this->ins_string($this->user_email));
                break;
// new login name based check before new password activation
            case "new_pass":
                $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE MD5(CONCAT(login, %s)) = %s", $this->table_name, $this->ins_string(SECRET_STRING), $this->ins_string($this->check_user));
                break;
            case "active":
                $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE id = %d AND active = 'n'", $this->table_name, $this->id);
                break;
            case "validate":
                $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE id = %d AND tmp_mail <> ''", $this->table_name, $this->id);
                break;
            default:
                $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE BINARY login = %s AND pw = %s AND active = 'y'", $this->table_name, $this->ins_string($this->user), $this->ins_string($this->user_pw));
        }
        //$result = mysql_query($sql) or die(mysql_error());
        $result = mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
        if (mysqli_fetch_assoc($result)["test"] == 1) {
            return true;
        } else {
            return false;
        }
    }

// New methods to handle the access level	
    function get_access_level() {
        $sql = sprintf("SELECT access_level FROM %s WHERE login = %s AND active = 'y'", $this->table_name, $this->ins_string($this->user));
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            return mysqli_fetch_assoc($result)["access_level"];
        }
    }

    function get_job_role() {
        $sql = "SELECT group_level from users left join job_roles on job_roles.id=job_role_id where login = " . $this->ins_string($this->user) . " AND active = 'y'";
//echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["group_level"];
            return $export;
        }
    }

    function get_maillist() {
        $sql = "SELECT email from users where maillist = 1 AND active = 'y'";
//echo $sql;
        $lista_email = array();
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            while ($row = mysqli_fetch_assoc($result)) {
                $lista_email[] = $row['email'];
            }
            return $lista_email;
        }
    }

    function get_department() {
        $sql = "SELECT squad_id from users left join squads on squads.id=squad_id where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        //echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["squad_id"];
            return $export;
        }
    }
    
    function get_squad() {
        $sql = "SELECT squad_id from users left join squads on squads.id=squad_id where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        //echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["squad_id"];
            return $export;
        }
    }

    function get_squad_id_set() {
        $sql = "SELECT squad_id_set from users left join squads on squads.id=squad_id where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        //echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["squad_id_set"];
            //$squad_arr = explode(",", $export);
            //return explode(",", $export);
            return $export;
        }
    }
	
	function get_squads_id_set() {
        $sql = "SELECT squad_id_set from users left join squads on squads.id=squad_id where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        //echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
            return [$this->the_msg];
        } else {
            $export = mysqli_fetch_assoc($result)['squad_id_set'];
            //$squad_arr = explode(",", $export);
            return explode(",", $export);
            //return $export;
        }
    }

    function get_squads_id_by_user() {
        //$sql = "SELECT squad_id from users left join squads on squads.id=squad_id where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        $sql = "SELECT `squad_id_set` FROM `users` where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        //echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["squad_id_set"];
            return explode(',', $export);
        }
    }

    

    function get_insert_permission() {
        $job_role = $this->get_job_role();
        if ($job_role > 1) {

            return 1;
        } else
            return 0;
    }

    function get_modify_permission() {
        $sql = "SELECT modifica from users where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        //echo $sql;
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["modifica"];
            if ($export == "Yes")
                return 1;
            else
                return 0;
        }
    }

    function check_elimina() {
        $sql = "SELECT cancella from users where login = " . $this->ins_string($this->user) . " AND active = 'y'";
        if (!$result = mysqli_query($this->mysqli,$sql)) {
            $this->the_msg = $this->messages(14);
        } else {
            $export = mysqli_fetch_assoc($result)["cancella"];
            if ($export == "Yes")
                return 1;
            else
                return 0;
        }
    }

    function debug_to_console($data) {

        if (is_array($data))
            $output = "<script>console.log( 'Debug Objects: " . addslashes(implode(', ', $data)) . "' );</script>";
        else
            $output = "<script>console.log('Debug Objects: " . addslashes($data) . "');</script>";

        echo $output;
    }


/*
    function check_permission($squad_id) {
        $job_role = $this->get_job_role();
        //echo $squad_id ." - ". $this->get_department();
        if ($job_role > 1) {
            if ($job_role < 4) {

                if ($squad_id == $this->get_squad()) {
                    return 1;
                } else
                    return 0;
            } else
                return 1;
        } else
            return 0;
    }
*/

    function check_permission($squad_id) {
        $job_role = $this->get_job_role();
        //echo $squad_id ." - ". $this->get_department();
        if ($job_role > 1) {
            if ($job_role < 4) {
                $squad_list = $this->get_squads_id_set();
                //print_r($squad_list);
                //exit();
                if (in_array($squad_id, $squad_list)){
                //if ($squad_id == $this->get_squad()) {                    
                    return 1;
                } else
                    return 0;
            } else
                return 1;
        } else
            return 0;
    }	

    function check_permission_fast($squad_id, $user_info) {
        $job_role = $user_info['job_role'];
        $squad_user = $user_info['squad_id'];
        //echo $squad_id ." - ". $this->get_department();
        if ($job_role > 1) {
            if ($job_role < 4) {

                if ($squad_id == $squad_user) {
                    return 1;
                } else
                    return 0;
            } else
                return 1;
        } else
            return 0;
    }

    function check_top_user($squad_id) {
        $job_role = $this->get_job_role();
        if ($job_role < 4) {

            return 0;
        } else
            return 1;
    }

    function get_ip() {
        if (!empty($_SERVER['HTTP_CLIENT_IP'])) {
            $ip = $_SERVER['HTTP_CLIENT_IP'];
        } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) {
            $ip = $_SERVER['HTTP_X_FORWARDED_FOR'];
        } else {
            $ip = $_SERVER['REMOTE_ADDR'];
        }
        return $ip;
    }
/*
    function log($utente) {
        $funzioni_admin = new funzioni_admin();
        $id_user = $funzioni_admin->get_id("users", $utente, "login");
        $ip = $this->get_ip();
        $sql = 'INSERT INTO ' . $this->log_table('id_user', 'inizio_sessione', 'ip') VALUES ($id_user, time(), ''. $ip . '')';
//debug_to_console($log_sql);
        $result = mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->mysqli));
        $test = mysqli_fetch_assoc($result);
        if ($test["test"] == 1) {
            return true;
        } else {
            return false;
        }
    }
    */

    function set_user($goto_page) {
        $_SESSION['user'] = $this->user;
        $_SESSION['pw'] = $this->user_pw;
        $_SESSION['logged_in'] = time(); // to offer a time limited access (later)

        if (!empty($_SESSION['referer'])) {
            $next_page = $_SESSION['referer'];
            unset($_SESSION['referer']);
        } else {
            $next_page = $this->main_page;
        }
        //print_r($_SESSION);
        if ($this->user_pw == md5("welcome")) {
            header("Location: ./index.php?page=update_user_profile");
            exit;
        }

        if ($goto_page) {
            header("Location: " . $next_page);
            exit;
        }
    }
    
    function set_user_redirect($pr) {      
        $_SESSION['user'] = $this->user;
        $_SESSION['pw'] = $this->user_pw;
        $_SESSION['logged_in'] = time(); // to offer a time limited access (later)

        if (!empty($_SESSION['referer'])) {
            $next_page = $_SESSION['referer'];
            unset($_SESSION['referer']);
        } else {
            //$next_page = $this->main_page;
        }
        //print_r($_SESSION);
        if (!empty($pr)) {
            $path = "index.php?sec=gestioneLSoc&pg=form_soc&externalpr=$pr";
            header("Location: " . $path);          
        }

    }
    
    function connect_dbli() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
//echo DB_SERVER." - ". DB_USER." - ". DB_PASSWORD." - ". DB_NAME;
    }

// added md5 to var $password
// changed argument for req_visit to $this->user_pw
    function login_user($user, $password) {
        if ($user != "" && $password != "") {
            $this->user = $user;
            $this->user_pw = md5($password);
            if ($this->check_user()) {
                $this->login_saver();
                //$this->log($this->user);
                if ($this->count_visit) {
                    $this->reg_visit($user, $this->user_pw);
                }
                $this->set_user(true);
            } else {
                $this->the_msg = $this->messages(10);
            }
        } else {
            $this->the_msg = $this->messages(11);
        }
    }
    
    function login_userExternal($user, $password, $pr) {
        if ($user != "" && $password != "") {
            $this->user = $user;
            $this->user_pw = $password;
            if ($this->check_user()) {                
                $this->login_saver();
                $this->log($this->user);
                if ($this->count_visit) {
                    $this->reg_visit($user, $this->user_pw);
                }
                
                if(isset($pr)&& !empty($pr) ){    
                    
                    $this->set_user_redirect($pr);
                }
                else {
                    $this->set_user(true);
                }
                
            } else {
                $this->the_msg = $this->messages(10);
            }
        } else {
            $this->the_msg = $this->messages(11);
        }
    }

    function login_saver() {
        if ($this->save_login == "no") {
            if (isset($_COOKIE[$this->cookie_name])) {
                $expire = time() - 3600;
            } else {
                return;
            }
        } else {
            $expire = time() + 2592000;
        }
        $cookie_str = $this->user . chr(31) . base64_encode($this->user_pw);
        setcookie($this->cookie_name, $cookie_str, $expire, $this->cookie_path);
    }

    function login_reader() {
        if (isset($_COOKIE[$this->cookie_name])) {
            $cookie_parts = explode(chr(31), $_COOKIE[$this->cookie_name]);
            $this->user = $cookie_parts[0];
            $this->user_pw = base64_decode($cookie_parts[1]);
            if ($this->check_user()) {
                $this->is_cookie = true;
            } else {
                unset($this->user);
                unset($this->user_pw);
            }
        }
    }

// removed the md5 from var $pass
    function reg_visit($login, $pass) {
        $visit_sql = sprintf("UPDATE %s SET extra_info = '%s' WHERE login = %s AND pw = %s", $this->table_name, date("Y-m-d H:i:s"), $this->ins_string($login), $this->ins_string($pass));
        mysqli_query($this->mysqli,$visit_sql);
        $this->log($this->user);
    }

    function log_out() {
        unset($_SESSION['user']);
        unset($_SESSION['pw']);
        unset($_SESSION['logged_in']);
        session_destroy(); // new in version 1.92
        header("Location: " . LOGOUT_PAGE);
        exit;
    }

    function access_page($refer = "", $qs = "", $level = DEFAULT_ACCESS_LEVEL) {
        $refer_qs = $refer;
        $refer_qs .= ($qs != "") ? "?" . $qs : "";
        if (!$this->check_user()) {
            $_SESSION['referer'] = $refer_qs;
            header("Location: " . $this->login_page);
            exit;
        }
        $admin = new funzioni_admin();
        if ($this->get_job_role() < $level) {
            header("Location: " . $this->deny_access_page);
            exit;
        }
    }

    function get_user_info() {
        $sql_info = sprintf("SELECT lastname, firstname, email, id FROM %s WHERE login = %s AND pw = %s", $this->table_name, $this->ins_string($this->user), $this->ins_string($this->user_pw));
        $res_info = mysqli_query($this->mysqli,$sql_info);
        $this->id = mysqli_fetch_assoc($res_info)["id"];
        $this->user_full_name = isset(mysqli_fetch_assoc($res_info)["lastname"]) ? mysqli_fetch_assoc($res_info)["lastname"] : "";
        $this->user_firstname = isset(mysqli_fetch_assoc($res_info)["firstname"]) ? mysqli_fetch_assoc($res_info)["firstname"] : "";
        $this->user_email = isset(mysqli_fetch_assoc($res_info)["email"]) ? mysqli_fetch_assoc($res_info)["email"] : "";

#$this->user_info = mysql_result($res_info, 0, "extra_info");
#$this->user_email = mysql_result($res_info, 0, "email"); 
#$sql_info = sprintf("SELECT email, id FROM %s WHERE login = %s AND pw = %s", $this->table_name, $this->ins_string($this->user), $this->ins_string($this->user_pw));
#$res_info = mysqli_query($this->mysqli,$sql_info);
#$this->id = mysql_result($res_info, 0, "id");
#$this->user_full_name = "";
#$this->user_firstname = "";
#$this->user_info = "";
#$this->user_email = mysql_result($res_info, 0, "email");
    }
    
    function uncoded_ExternalUserId($user_id_coded) {

           $secret_key = 'D(G+KbPeShVmYq3t6w9z$C&F)H@McQfTjWnZr4u7x!A%D*G-KaNdRgUkXp2s5v8y/B?E(H+MbQeShVmYq3t6w9z$C&F)J@NcRfUjWnZr4u7x!A%D*G-KaPdSgVkYp2s5v8y/B?E(H+MbQeThWmZq4t6w9z$C&F)J@NcRfUjXn2r5u8x!A%D*G-KaPdSgVkYp3s6v9y$B?E(H+MbQeThWmZq4t7w!z%C*F)J@NcRfUjXn2r5u8x/A?D(G+KaPdSgVkYp3s6v9y$B&E)H@McQeThWmZq4t7w!z%C*F-JaNdRgUjXn2r5u8x/A?D(G+KbPeShVmYp3s6v9y$B&E)H@McQfTjWnZr4t7w!z%C*F-JaNdRgUkXp2s5v8x/A?D(G+KbPeShVmYq3t6w9z$B&E)H@McQfTjWnZr4u7x!A%D*F-JaNdRgUkXp2s5v8y/B?E(H+KbPeShVmYq3t6w9z$C&F)J@NcRfTjWnZr4u7x!A%D*G-KaPdSgVkXp2s5v8y/B';
           $secret_iv = 'my_simple_secret_iv';
           $encrypt_method = "AES-256-CBC";
           $key = hash( 'sha256', $secret_key );
           $iv = substr( hash( 'sha256', $secret_iv ), 0, 16 );  

           $user_id_decoded = openssl_decrypt( base64_decode( $user_id_coded ), $encrypt_method, $key, 0, $iv ); 
        
           return $user_id_decoded;       
    }
    
    
    function get_ExternalUser($user_id_coded) {

        $user_id_decoded = $this->uncoded_ExternalUserId($user_id_coded);
        $sql_info = sprintf("SELECT * FROM %s WHERE id_external = %s ", $this->table_name, $user_id_decoded);       
        $res_info = mysqli_query($this->mysqli,$sql_info);

        return mysqli_fetch_assoc($res_info);
        
    }
    

    
    function check_ExternalUser($user_id_coded) {
        $id_external = $this->uncoded_ExternalUserId($user_id_coded);
        $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE id_external = %s ", $this->table_name, $id_external);
        $result = mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->db));
        if (mysqli_fetch_assoc($result)["test"] == 1) {
            return true;
        } else {
            return false;
        }
    }
    
    
    function check_ExternalUserEmail($user_id_coded) {
        
        $email_external = $this->get_ExternalUserEmail($user_id_coded);
        //echo '$email_external '.$email_external;
        $sql = sprintf("SELECT COUNT(*) AS test FROM %s WHERE email = '%s' ", $this->table_name, $email_external);
        #echo $sql; 
        $result = mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->db));
        if (mysqli_fetch_assoc($result)["test"] == 1) {
            #echo 'test OK ';
            return true;
        } else {
            return false;
        }
    }
    
    function get_ExternalUserEmail($user_id_coded) {
        
        $servername = "localhost";
        $username = "wordpress_9";
        $password = "a8]#91APlq";
        $dbname = "wordpress_f";
        
        $id_external = $this->uncoded_ExternalUserId($user_id_coded);        
        $conn_id = mysqli_connect($servername, $username, $password, $dbname);
        if(! $conn_id )
                {
                  die('Could not connect_id: ' . mysqli_error($conn_id));

                }
        $sql_id = "SELECT * FROM `Gbe8rN_users` WHERE `ID`= '".$id_external."'";
        $result = mysqli_query($conn_id, $sql_id);
        if(!$result)
                {
                  die('Could not update data_id: ' . mysqli_error($conn_id));

                }

        return mysqli_fetch_assoc($result)["user_email"];

    }
    
   function get_ForeignUser($user_id) {
        
        $servername = "localhost";
        $username = "wordpress_9";
        $password = "a8]#91APlq";
        $dbname = "wordpress_f";
        
        // $id_external = $this->uncoded_ExternalUserId($user_id_coded);
        $id_external = $user_id;
        $conn_id = mysqli_connect($servername, $username, $password, $dbname);
        if(! $conn_id )
                {
                  die('Could not connect_id: ' . mysqli_error($conn_id));

                }
        $sql_id = "SELECT * FROM `Gbe8rN_users` WHERE `ID`= '".$id_external."'";
  
        $result = mysqli_query($conn_id,$sql_id);
        if(!$result)
                {
                  die('Could not update data_id: ' . mysqli_error($conn_id));

                }

        return mysqli_fetch_assoc($result)["user_login"];

    }
    
    function get_user_id() {
        $sql_info = sprintf("SELECT lastname, firstname, email, id FROM %s WHERE login = %s AND pw = %s", $this->table_name, $this->ins_string($this->user), $this->ins_string($this->user_pw));
        $res_info = mysqli_query($this->mysqli,$sql_info);
        return mysqli_fetch_assoc($res_info)["id"];
    }

    function update_user($new_password, $new_confirm, $new_name, $new_info, $new_mail) {
        if ($new_password != "") {
            if ($this->check_new_password($new_password, $new_confirm)) {
                $ins_password = md5($new_password);
                $update_pw = true;
            } else {
                return;
            }
        } else {
            $ins_password = $this->user_pw;
            $update_pw = false;
        }
        if (trim($new_mail) <> $this->user_email) {
            if ($this->check_email($new_mail)) {
                $this->user_email = $new_mail;
                if (!$this->check_user("lost")) {
                    $update_email = true;
                } else {
                    $this->the_msg = $this->messages(31);
                    return;
                }
            } else {
                $this->the_msg = $this->messages(16);
                return;
            }
        } else {
            $update_email = false;
            $new_mail = "";
        }
        $upd_sql = sprintf("UPDATE %s SET pw = %s, real_name = %s, extra_info = %s, tmp_mail = %s WHERE id = %d", $this->table_name, $this->ins_string($ins_password), $this->ins_string($new_name), $this->ins_string($new_info), $this->ins_string($new_mail), $this->id);
        $upd_res = mysqli_query($this->mysqli,$upd_sql);
        if ($upd_res) {
            if ($update_pw) {
                $_SESSION['pw'] = $this->user_pw = $ins_password;
                if (isset($_COOKIE[$this->cookie_name])) {
                    $this->save_login = "yes";
                    $this->login_saver();
                }
            }
            $this->the_msg = $this->messages(30);
            if ($update_email) {
                if ($this->send_mail($new_mail, 33)) {
                    $this->the_msg = $this->messages(27);
                } else {
                    mysqli_query($this->mysqli,sprintf("UPDATE %s SET tmp_mail = ''", $this->table_name));
                    $this->the_msg = $this->messages(14);
                }
            }
        } else {
            $this->the_msg = $this->messages(15);
        }
    }
    
    
    function update_ExternalUserID($external_user_id, $external_email) {

        $upd_sql = sprintf("UPDATE %s SET id_external = %d WHERE email = %s", $this->table_name, $external_user_id, $this->ins_string($external_email));
        $upd_res = mysqli_query($this->mysqli,$upd_sql);
        
        if ($upd_res) {

                    $this->the_msg = $this->messages(14);

        } else {
            $this->the_msg = $this->messages(15);
        }
    }
    
/*
    function update_user2($id_user, $new_password, $new_confirm, $new_name, $new_info, $new_mail, $nome, $job_role_id, $ruolo, $squad_id, $active, $inserisci, $modifica, $cancella, $access_level, $maillist) {
        $update_sql = "UPDATE `users` SET $cognome $nome `job_role_id`='" . $_POST['selectRuolo'] . "',`squad_id`='" . $_POST['selectStack'] . "',`active`='" . $_POST['selectStato'] . "',`leggi`='Yes',`inserisci`='" . $inserisci . "',`modifica`='" . $modifica . "',`cancella`='" . $cancella . "' $update_pw ,`access_level`='" . $access_level . "' $maillist WHERE `id`='" . $_POST['idUtente'] . "'";
        if ($new_password != "") {
            if ($this->check_new_password($new_password, $new_confirm)) {
                $ins_password = md5($new_password);
                $update_pw = true;
            } else {
                return;
            }
        } else {
            $ins_password = $this->user_pw;
            $update_pw = false;
        }
        if (trim($new_mail) <> $this->user_email) {
            if ($this->check_email($new_mail)) {
                $this->user_email = $new_mail;
                if (!$this->check_user("lost")) {
                    $update_email = true;
                } else {
                    $this->the_msg = $this->messages(31);
                    return;
                }
            } else {
                $this->the_msg = $this->messages(16);
                return;
            }
        } else {
            $update_email = false;
            $new_mail = "";
        }
        $update_sql = "UPDATE `users` SET $cognome $nome `job_role_id`='" . $_POST['selectRuolo'] . "',`squad_id`='" . $_POST['selectStack'] . "',`active`='" . $_POST['selectStato'] . "',`leggi`='Yes',`inserisci`='" . $inserisci . "',`modifica`='" . $modifica . "',`cancella`='" . $cancella . "' $update_pw ,`access_level`='" . $access_level . "' $maillist WHERE `id`='" . $_POST['idUtente'] . "'";
        $upd_sql = sprintf("UPDATE %s SET pw = %s, lastname = %s, firstname = %s, job_role_id=%d, squad_id=%d, active=%s, leggi='Yes', inserisci=%s, modifica=%s, cancella=%s, access_level=%d, maillist=%d, tmp_mail = %s WHERE id = %d", $this->table_name, $this->ins_string($ins_password), $this->ins_string($new_name), $this->ins_string($new_info), $this->ins_string($new_mail), $this->id);
#var_dump($upd_sql);
        $upd_res = mysqli_query($this->mysqli,$upd_sql);
#var_dump($upd_res);
        if ($upd_res) {
            if ($update_pw) {
                $_SESSION['pw'] = $this->user_pw = $ins_password;
                if (isset($_COOKIE[$this->cookie_name])) {
                    $this->save_login = "yes";
                    $this->login_saver();
                }
            }
            $this->the_msg = $this->messages(30);
            if ($update_email) {
                if ($this->send_mail($new_mail, 33)) {
                    $this->the_msg = $this->messages(27);
                } else {
                    mysqli_query($this->mysqli,sprintf("UPDATE %s SET tmp_mail = ''", $this->table_name));
                    $this->the_msg = $this->messages(14);
                }
            }
        } else {
            $this->the_msg = $this->messages(15);
        }
    }
*/
    function check_new_password($pass, $pw_conform) {
        if ($pass == $pw_conform) {
            if (strlen($pass) >= PW_LENGTH) {
                return true;
            } else {
                $this->the_msg = $this->messages(32);
                return false;
            }
        } else {
            $this->the_msg = $this->messages(38);
            return false;
        }
    }

    function check_email($mail_address) {
        if (preg_match("/^[0-9a-z]+(([\.\-_])[0-9a-z]+)*@[0-9a-z]+(([\.\-])[0-9a-z-]+)*\.[a-z]{2,4}$/i", $mail_address)) {
            return true;
        } else {
            return false;
        }
    }

    function ins_string($value) {
        if (preg_match("/^(.*)(##)(int|date|eu_date)$/", $value, $parts)) {
            $value = $parts[1];
            $type = $parts[3];
        } else {
            $type = "";
        }
        //$value = (!get_magic_quotes_gpc()) ? addslashes($value) : $value;
        $value = addslashes($value);
        switch ($type) { 
            case "int":
                $value = ($value != "") ? intval($value) : NULL;
                break;
            case "eu_date":
                $date_parts = preg_split("/[\-\/\.]/", $value);
                $time = mktime(0, 0, 0, $date_parts[1], $date_parts[0], $date_parts[2]);
                $value = strftime("'%Y-%m-%d'", $time);
                break;
            case "date":
                $value = "'" . preg_replace("/[\-\/\.]/", "-", $value) . "'";
                break;
            default:
                $value = ($value != "") ? "'" . $value . "'" : "''";
        }
        return $value;
    }

    function register_user($first_login, $first_password, $confirm_password, $first_name, $first_info, $first_email) {
        if ($this->check_new_password($first_password, $confirm_password)) {
            if (strlen($first_login) >= LOGIN_LENGTH) {
                if ($this->check_email($first_email)) {
                    $this->user_email = $first_email;
                    $this->user = $first_login;
                    if ($this->check_user("new")) {
                        $this->the_msg = $this->messages(12);
                        return;
                    } else {
                        $sql = sprintf("INSERT INTO %s (id, login, pw, lastname, extra_info, email, access_level, active) VALUES (NULL, %s, %s, %s, %s, %s, %d, 'n')", $this->table_name, $this->ins_string($first_login), $this->ins_string(md5($first_password)), $this->ins_string($first_name), $this->ins_string($first_info), $this->ins_string($this->user_email), DEFAULT_ACCESS_LEVEL);
#var_dump($sql);
                        $ins_res = mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->db));
                        if ($ins_res) {
                            $this->id = mysqli_insert_id($this->mysqli) ;
                            $this->user_pw = md5($first_password);
                            if ($this->send_mail($this->user_email, 29, 28)) {
                                $this->the_msg = $this->messages(13);
                            } else {
                                mysqli_query($this->mysqli,sprintf("DELETE FROM %s WHERE id = %d", $this->table_name, $this->id));
                                $this->the_msg = $this->messages(14);
                            }
                        } else {
                            $this->the_msg = $this->messages(15);
                        }
                    }
                } else {
                    $this->the_msg = $this->messages(16);
                }
            } else {
                $this->the_msg = $this->messages(17);
            }
        }
    }

    function register_newuser($first_login, $first_password, $confirm_password, $cognome, $first_email, $nome, $ruolo, $squad, $stato, $inserisci, $modifica, $cancella, $levello_accesso, $maillist) {
#register_newuser          ($_POST['login'], $_POST['password'], $_POST['confirm'], $cognome, $_POST['email'], $name, $_POST['selectRuolo'], $_POST['selectStack'], $_POST['selectStato'], 'Yes', $inserisci, $modifica, $cancella, $levello_accesso);            
#register_user2($_POST['login'], $_POST['password'], $_POST['confirm'], $cognome, $_POST['info'], $_POST['email'], $nome, $_POST['selectRuolo'], $_POST['selectStack'], $_POST['selectStato'], 'Yes', $inserisci, $modifica, $cancella, $levello_accesso)
        if ($this->check_new_password($first_password, $confirm_password)) {
            if (strlen($first_login) >= LOGIN_LENGTH) {
                //if ($this->check_email($first_email)) {
                $this->user_email = $first_email;
                $this->user = $first_login;
                $squad_list = $squad;
                $list = implode(",", array_values($squad_list));
                if ($this->check_user("new")) {
                    $this->the_msg = $this->messages(12);
                    return;
                } else {
                    if (isset($_POST['maillist']))
                        $maillist = intval($_POST['maillist']);
                    else
                        $maillist = 0;

                    $sql = "INSERT INTO `users` ("
                            . "`id`, `lastname`, `firstname`, `login`, `job_role_id`, `squad_id_set`, "
                            . "`active`, `leggi`, `inserisci`, `modifica`, `cancella`, `email`, `tmp_mail`, `pw`, `access_level`,`maillist`)"
                            . " VALUES (NULL, '" . $cognome . "', '" . $nome . "', " . $this->ins_string($first_login) . ", '" . $ruolo . "', '" . $list . "', '" . $stato . "', 'Yes', '" . $inserisci . "', '" . $modifica . "', '" . $cancella . "', " . $this->ins_string($this->user_email) . ", '', " . $this->ins_string(md5($first_password)) . ", '" . $levello_accesso . "', '" . $maillist . "')";

#$sql = sprintf("INSERT INTO %s (id, login, pw, lastname, extra_info, email, access_level, active) VALUES (NULL, %s, %s, %s, %s, %s, %d, 'n')", $this->table_name, $this->ins_string($first_login), $this->ins_string(md5($first_password)), $this->ins_string($cognome), $this->ins_string($first_info), $this->ins_string($this->user_email), DEFAULT_ACCESS_LEVEL);
#var_dump($sql);
                    $ins_res = mysqli_query($this->mysqli,$sql) or die(mysqli_error($this->db));
                    if ($ins_res) {
                        $this->id = mysqli_insert_id($this->mysqli) ;
                        $this->user_pw = md5($first_password);
                        
                        //if (true) {
                        if (strlen($this->user_email) > 0) {
                            if ($this->send_mail($this->user_email, 37, 39, $this->send_copy)) {
                                $this->the_msg = $this->messages(13);
                            } else {
                                echo "access_user_class.php riga 837 --> rimuovere commento alla riga DELETE mysql";
                                //mysqli_query($this->mysqli,sprintf("DELETE FROM %s WHERE id = %d", $this->table_name, $this->id));
                                //echo sprintf("DELETE FROM %s WHERE id = %d", $this->table_name, $this->id);
                                $this->the_msg = $this->messages(14);
                            }
                        } else {
                            $this->the_msg = "Utente aggiunto correttamente";
                        }
                    } else {
                        $this->the_msg = $this->messages(15);
                    }
                }
                //} else {
                ///    $this->the_msg = $this->messages(16);
                //}
            } else {
                $this->the_msg = $this->messages(17);
            }
        }
    }

    function validate_email($validation_key, $key_id) {
        if ($validation_key != "" && strlen($validation_key) == 32 && $key_id > 0) {
            $this->id = $key_id;
            if ($this->check_user("validate")) {
                $upd_sql = sprintf("UPDATE %s SET email = tmp_mail, tmp_mail = '' WHERE id = %d AND MD5(pw) = %s", $this->table_name, $key_id, $this->ins_string($validation_key));
                if (mysqli_query($this->mysqli,$upd_sql)) {
                    $this->the_msg = $this->messages(18);
                } else {
                    $this->the_msg = $this->messages(19);
                }
            } else {
                $this->the_msg = $this->messages(34);
            }
        } else {
            $this->the_msg = $this->messages(21);
        }
    }

// upd. version 1.97 only activate status active = 'n', update the database table:
// ALTER TABLE `users` CHANGE `active` `active` ENUM( 'y', 'n', 'b' ) DEFAULT 'n' NOT NULL 
    function activate_account($activate_key, $key_id) {
        if ($activate_key != "" && strlen($activate_key) == 32 && $key_id > 0) {
            $this->id = $key_id;
            if ($this->check_user("active")) {
                if ($this->auto_activation) {
                    $upd_sql = sprintf("UPDATE %s SET active = 'y' WHERE id = %d AND MD5(pw) = %s AND active = 'n'", $this->table_name, $key_id, $this->ins_string($activate_key));
                    if (mysqli_query($this->mysqli,$upd_sql)) {
                        if ($this->send_confirmation($key_id)) {
                            $this->the_msg = $this->messages(18);
                        } else {
                            $this->the_msg = $this->messages(14);
                        }
                    } else {
                        $this->the_msg = $this->messages(19);
                    }
                } else {
                    if ($this->send_mail($this->admin_mail, 40, 39)) {
                        $this->the_msg = $this->messages(36);
                    } else {
                        $this->the_msg = $this->messages(14);
                    }
                }
            } else {
                $this->the_msg = $this->messages(20);
            }
        } else {
            $this->the_msg = $this->messages(21);
        }
    }

    function forgot_password($forgot_email) {
        if ($this->check_email($forgot_email)) {
            $this->user_email = $forgot_email;
            if (!$this->check_user("lost")) {
                $this->the_msg = $this->messages(22);
            } else {
// changed from pw to login for verification string
                $forgot_sql = sprintf("SELECT login FROM %s WHERE email = %s", $this->table_name, $this->ins_string($this->user_email));
                if ($forgot_result = mysqli_query($this->mysqli,$forgot_sql)) {
                    if ($this->send_mail($this->user_email, 35, 26)) {
                        $this->the_msg = $this->messages(23);
                    } else {
                        $this->the_msg = $this->messages(14);
                    }
                } else {
                    $this->the_msg = $this->messages(15);
                }
            }
        } else {
            $this->the_msg = $this->messages(16);
        }
    }

    function check_activation_password($controle_str) {
        if ($controle_str != "" && strlen($controle_str) == 32) {
            $this->check_user = $controle_str;
            if ($this->check_user("new_pass")) {
// this is a fix for version 1.76
// we need this login name that teh user will remember the name too
                $sql_get_user = sprintf("SELECT login FROM %s WHERE MD5(CONCAT(login, %s)) = %s", $this->table_name, $this->ins_string(SECRET_STRING), $this->ins_string($this->check_user));
                $get_user = mysqli_query($this->mysqli,$sql_get_user);
                $this->user = mysqli_fetch_assoc($get_user)["login"]; // end fix
                return true;
            } else {
                $this->the_msg = $this->messages(21);
                return false;
            }
        } else {
            $this->the_msg = $this->messages(21);
            return false;
        }
    }

    function activate_new_password($new_pass, $new_confirm, $verif_str) {
        if ($this->check_new_password($new_pass, $new_confirm)) {
// new password is set based on user name now
            $sql_new_pass = sprintf("UPDATE %s SET pw = '%s' WHERE MD5(CONCAT(login, %s)) = %s", $this->table_name, md5($new_pass), $this->ins_string(SECRET_STRING), $this->ins_string($verif_str));
            if (mysqli_query($this->mysqli,$sql_new_pass)) {
                $this->the_msg = $this->messages(30);
                return true;
            } else {
                $this->the_msg = $this->messages(14);
                return false;
            }
        } else {
            return false;
        }
    }

    function send_confirmation($id) {
        $sql = sprintf("SELECT lastname, email FROM %s WHERE id = %d", $this->table_name, $id);
        $res = mysqli_query($this->mysqli,$sql);
        $user_email = mysqli_fetch_assoc($res)["email"];
        $this->user_full_name = mysqli_fetch_assoc($res)["lastname"];
        if ($this->user_full_name == "")
            $this->user_full_name = "User"; // change "User" to whatever you want, it's just a default name
        if ($this->send_mail($user_email, 37, 24, $this->send_copy)) {
            return true;
        } else {
            return false;
        }
    }

// new in version 1.99 support for phpmailer as alternative mail program
    function send_mail($mail_address, $msg = 29, $subj = 28, $send_admin = false) {
        if (is_int($subj))
            $subject = $this->messages($subj);
        else
            $subject = $subj;
        if (is_int($msg))
            $body = $this->messages($msg);
        else
            $body = $msg;
        
        #$body = $this->messages($msg);
        if (USE_PHP_MAILER) {
            $mail = new PHPMailer();
            if (PHP_MAILER_SMTP) {
                $mail->isSMTP();
//$mail->SMTPDebug = 2;
                $mail->Debugoutput = 'html';
             
                $mail->SMTPDebug = 3;
     
                $mail->SMTPOptions = array(
                        'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );

/*
    $mail->Host = 'smtp.gmail.com';
    $mail->Port = 587;
    $mail->SMTPSecure = 'tls';
    $mail->SMTPAuth = true;
    $mail->Username = "ezio.toto@gmail.com";
    $mail->Password = "Sucaminchia01";
    $mail->Timeout = 3600;
 * 
 */

//$mail->Host = 'smtp.gmail.com';

                #$mail->Host = '10.213.37.67';
//$mail->Port = 587;
                #$mail->Port = 25;
//$mail->SMTPSecure = 'tls';
//$mail->SMTPAuth = true;
//$mail->Username = SMTP_LOGIN;
//$mail->Password = SMTP_PASSWD;
            } else {
                $mail->IsSendmail();
            }
            $mail->isHTML(TRUE);
            $mail->From = $this->webmaster_mail;
            $mail->FromName = $this->webmaster_name;
            $mail->AddAddress($mail_address);
            if ($send_admin)
                $mail->AddBCC(ADMIN_MAIL);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        } else {
            $header = "From: \"" . $this->webmaster_name . "\" <" . $this->webmaster_mail . ">\n";
            if ($send_admin)
                $header .= "Bcc: " . ADMIN_MAIL . "\n";
            $header .= "MIME-Version: 1.0\n";
            $header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
            $header .= "Content-Transfer-Encoding: 7bit\n";
            $mail->isHTML(TRUE);
            if (mail($mail_address, $subject, $body, $header)) {
                return true;
            } else {
                return false;
            }
        }
    }

    function send_mail_list($mail_list, $msg = 29, $subj = 28, $send_admin = false) {

        if (is_int($subj))
            $subject = $this->messages($subj);
        else
            $subject = $subj;
        if (is_int($msg))
            $body = $this->messages($msg);
        else
            $body = $msg;
        if (USE_PHP_MAILER) {
            $mail = new PHPMailer();
            if (PHP_MAILER_SMTP) {
                $mail->isSMTP();
                $mail->Debugoutput = 'html';
                $mail->Host = '10.213.37.67';
                $mail->Port = 25;
                $mail->SMTPOptions = array(
                    'ssl' => array(
                        'verify_peer' => false,
                        'verify_peer_name' => false,
                        'allow_self_signed' => true
                    )
                );
            } else {
                $mail->IsSendmail();
            }
            $mail->From = $this->webmaster_mail;
            $mail->FromName = $this->webmaster_name;


            if (!empty($mail_list)) {
                foreach ($mail_list as $emailAddress) {
                    $mail->AddAddress(trim($emailAddress));
                }
            }
#$mail->AddAddress($mail_address);

            $mail->isHTML(TRUE);

            if ($send_admin)
                $mail->AddBCC(ADMIN_MAIL);
            $mail->isHTML(TRUE);
            $mail->Subject = $subject;
            $mail->Body = $body;
            if ($mail->Send()) {
                return true;
            } else {
                return false;
            }
        } else {
            $header = "From: \"" . $this->webmaster_name . "\" <" . $this->webmaster_mail . ">\n";
            if ($send_admin)
                $header .= "Bcc: " . ADMIN_MAIL . "\n";
            $header .= "MIME-Version: 1.0\n";
            $header .= "Content-Type: text/plain; charset=\"iso-8859-1\"\n";
            $header .= "Content-Transfer-Encoding: 7bit\n";

            $emails = implode(",", $mail_list["email"]);
            $mail->isHTML(TRUE);
            if (mail($emails, $subject, $body, $header)) {
                return true;
            } else {
                return false;
            }
        }
    }

// message no. 35 is changed because the verification string based in the user name now
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

?>