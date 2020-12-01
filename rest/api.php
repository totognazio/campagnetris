<?php
/*
  This is an example class script proceeding secured API
  To use this class you should keep same as query string and function name
  Ex: If the query string value rquest=delete_user Access modifiers doesn't matter but function should be
  function delete_user(){
  You code goes here
  }
  Class will execute the function dynamically;

  usage :

  $object->response(output_data, status_code);
  $object->_request	- to get santinized input

  output_data : JSON (I am using)
  status_code : Send status message for headers

  Add This extension for localhost checking :
  Chrome Extension : Advanced REST client Application
  URL : https://chrome.google.com/webstore/detail/hgmloofddffdnphfgcellkdfbfbjeloo

  I used the below table for demo purpose.

  CREATE TABLE IF NOT EXISTS `users` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `user_fullname` varchar(25) NOT NULL,
  `email` varchar(50) NOT NULL,
  `password` varchar(50) NOT NULL,
  `user_status` tinyint(1) NOT NULL DEFAULT '0',
  PRIMARY KEY (`id`)
  ) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;
 */

require_once("Rest.inc.php");
include_once(__DIR__.'/../classes/access_user/access_user_class.php');
include_once (__DIR__.'/../classes/socmanager_class.php');

class API extends REST {

    public $data = "";

    const DB_SERVER = "localhost";
    const DB_USER = "vendor_tool_db";
    const DB_PASSWORD = "Wq9ji%35";
    const DB = "vendor_tool";

    private $db = NULL;

    public function __construct() {
        parent::__construct();    // Init parent contructor
        $this->dbConnect();     // Initiate Database connection
    }

    /*
     *  Database connection 
     */

    private function dbConnect() {
        $this->db = mysqli_connect(self::DB_SERVER, self::DB_USER, self::DB_PASSWORD, self::DB);
    }

    /*
     * Public method for access api.
     * This method dynmically call the method based on the query string
     *
     */

    public function processApi() {
        $func = strtolower(trim(str_replace("/", "", $_REQUEST['rquest'])));
        if ((int) method_exists($this, $func) > 0)
            $this->$func();
        else
            $this->response('', 404);    // If the method not exist with in this class, response would be "Page not found".
    }

    /*
     * 	Simple login API
     *  Login must be POST method
     *  email : <USER EMAIL>
     *  pwd : <USER PASSWORD>
     */

    private function login_ORI() {
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        $email = $this->_request['email'];
        $password = $this->_request['pwd'];

        $return = null;
        if (!empty($email) and ! empty($password)) {
            if (filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $sql = mysqli_query($this->db, "SELECT id FROM `users` WHERE email = '" . $email . "' AND password = '" . md5($password) . "' LIMIT 1");
                if (mysqli_num_rows($sql) > 0) {
                    $result = mysqli_fetch_array($sql, MYSQLI_NUM);
                    $return = $result[0];
                }
            }
        }
        return $return;
    }

    private function login() {
        // Cross validation if the request method is POST else it will return "Not Acceptable" status
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        if (isset($this->_request['login']) and isset($this->_request['pw'])) {
            $login = $this->_request['login'];
            $password = $this->_request['pw'];
        } else {
            $error = array('login' => "Failed", "msg" => "Please enter Login and Password");
            exit($this->response($this->json($error), 400));
        }

        $return = null;
        if (!empty($login) and ! empty($password)) {
            if (filter_var($login, FILTER_DEFAULT)) {
                #echo "SELECT * FROM `users` WHERE login = '".$login."' AND pw = '".md5($password)."' LIMIT 1";
                $sql = mysqli_query($this->db, "SELECT * FROM `users` WHERE login = '" . $login . "' AND pw = '" . md5($password) . "' LIMIT 1");
                if (mysqli_num_rows($sql) > 0) {
                    $result = mysqli_fetch_array($sql, MYSQLI_NUM);
                    #$return  = $result[0];


                    $job_role_id = $result[4];

                    // se l'utente è un Engineer o Admin è abilitato a richieste REST       
                    if ($job_role_id == 2 or $job_role_id == 8) {
                        $res = array('job_role_id' => "$job_role_id", "msg" => "Welcome to VendorTool");
                        #$this->response($this->json($res), 200);
                        $return = $result[0];
                    }
                    //se l'utente non è un Engineer non è abilitato a richieste REST
                    else if (!($job_role_id == 2 or $job_role_id == 8)) {
                        $error = array('job_role_id' => "$job_role_id", "msg" => "User not licensed");
                        exit($this->response($this->json($error), 401));
                    }
                } else {
                    $error = array("login" =>$login,"pw" =>$password,  "msg" => "Bad SQL Request !!!");
                    exit($this->response($this->json($error), 400));
                }
            }
        }
        $res = array("msg" => "Please enter Loign and Password");
        #$this->response($this->json($res), 400);
        return $return;
    }

    function GetAll() {
        if ($this->login() > 0) {
            $table_name = $this->_request['table'];
            $conditions = $this->_request['conditions'];
            if (isset($this->_request['order_by']))
                $order_by = $this->_request['order_by'];
            else
                $order_by = null;
            $sql0 = "SELECT * FROM " . $table_name . " WHERE 1=1";
            if ($conditions != null) {
                foreach ($conditions as $key => $value) {
                    $sql0 .= " AND {$key} = '${value}'";
                }
            }
            if ($order_by != null) {
                $sql0 .= " ORDER BY ";
                foreach ($order_by as $key => $value) {
                    $sql0 .= " {$key} ${value}";
                }
            } echo $sql0;
            $sql = mysqli_query($this->db, $sql0);
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('status' => "Failed", "msg" => "Sorry It's Not Working");
        $this->response($this->json($error), 400);
    }

    function GetAllRFIProjects() {
        if ($this->login() > 0) {
            #$table_name = $this->_request['table'];					
            #$conditions = $this->_request['rfiIdList'];
            #order by `data_inserimento` desc
            #print_r($conditions);
/*
            if (isset($this->_request['order_by']))
                $order_by = $this->_request['order_by'];
            else
                $order_by = " data_inserimento desc ";
            #$sql0 = "SELECT * FROM ".$table_name." WHERE 1=1";
*/
            $sql0 = "SELECT * FROM `projects` " . " WHERE 1 ORDER BY `data_inserimento` desc";
            #echo $sql0;
            /*
              if($conditions != null) {
              foreach($conditions as $key=>$value){
              $sql0 .= " OR  {$key} = '${value}'";
              }
              }
              #echo $sql0;
              if($order_by != null) {
              $sql0 .=" ORDER BY ";
              foreach($order_by as $key=>$value){
              $sql0 .= " {$key} ${value}";
              }
              }
             * 
             */


            #echo $sql0;

            $sql = mysqli_query($this->db, $sql0);
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('login' => $this->login(), 'status' => "Failed", "msg" => "Sorry It's Not Working");
        $this->response($this->json($error), 400);
    }
    
function GetAllProjects() {
    //Come GetAllRFIProjects ma senza login
    
        if (isset($this->_request['order_by'])){
               $order_by = $this->_request['order_by'];
        }
        else {
            $order_by = " data_inserimento desc ";
        }
        $sql0 = "SELECT * FROM `projects` " . " WHERE 1 ORDER BY `data_inserimento` desc";

        $sql = mysqli_query($this->db, $sql0);
        if (mysqli_num_rows($sql) > 0) {
            while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC)){
                $result[] = $row;
            }    
            $this->response($this->json($result), 200);
        }
        //}
        $error = array('status' => "Failed", "msg" => "Sorry It's Not Working");
        $this->response($this->json($error), 400);
    }
    
    

    function GetRFIvalue($id_project, $id_rfi) {  
        if ($this->login() > 0) {
            
            if (isset($this->_request['id_project']) and isset($this->_request['id_rfi'])) {
                $id_project = $this->_request['id_project'];
                $id_rfi = $this->_request['id_rfi'];
            } else {
                $error = array('id_project' => $id_project, 'id_rfi' => $id_rfi,"msg" => "Please enter valid id_project and id_rfi");
                exit($this->response($this->json($error), 400));
            } 
            
        $id_rfi = $this->db_escape($id_rfi);
        $id_project = $this->db_escape($id_project);
        
            $query = "SELECT `valore_requisito` FROM `dati_valori_requisiti` WHERE `id_project`=$id_project and `id_requisito`=$id_rfi";
            
            $sql = mysqli_query($this->db, $query)  or die($query . " - SQL ERRORE -- " . mysql_error());
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('status' => "Bad Query", "msg" => "Please check id_project and/or id_rfi");
        $this->response($this->json($error), 400);

    }
    
    function GetRFIvalues($id_project) {  
        if ($this->login() > 0) {
            
            if (isset($this->_request['id_project'])) {
                $id_project = $this->_request['id_project'];

            } else {
                $error = array('id_project' => "not present", "msg" => "Please enter valid id_project");
                exit($this->response($this->json($error), 400));
            } 

        $id_project = $this->db_escape($id_project);
        
            $query = "SELECT * FROM `dati_valori_requisiti` WHERE `id_project`=$id_project ";
            
            $sql = mysqli_query($this->db, $query)  or die($query . " - SQL ERRORE -- " . mysql_error());
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('status' => "Bad Query", "msg" => "Please check id_project ");
        $this->response($this->json($error), 400);

    }
    
    function GetRFIlist($id_project) {  
        if ($this->login() > 0) {
            
            if (isset($this->_request['id_project'])) {
                $id_project = $this->_request['id_project'];

            } else {
                $error = array('status' => "Bad Query", "msg" => "Please check id_project ");
                $this->response($this->json($error), 400);
            } 

        $id_project = $this->db_escape($id_project);
                            
            $query = "SELECT `temp` . * , `dati_requisiti` . *
            FROM `dati_requisiti`
            left JOIN (
            SELECT nome_tel,valore_requisito,id_requisito,note,data_modifica,id_usermodify,review
            FROM `dati_valori_requisiti`
            WHERE id_project = $id_project 
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.stato=1 and (lista_req like '%phone%' or lista_req like 'Tablet') order by `dati_requisiti`.ordine ";

            
            $sql = mysqli_query($this->db, $query)  or die($query . " - SQL ERRORE -- " . mysql_error());
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('status' => "Bad Query", "msg" => "Please check id_project ");
        $this->response($this->json($error), 400);

    }
    
    function GetRFIreqinfo(){
        if ($this->login() > 0) {
            
            if (isset($this->_request['id_rfi'])) {
                $id_rfi = $this->_request['id_rfi'];
                $id_rfi = $this->db_escape($id_rfi);
            } else {
                $error = array('id_rfi' => "Failed", "msg" => "Please enter id_rfi");
                exit($this->response($this->json($error), 401));
            }  
            
        
            $query = "SELECT * FROM `dati_requisiti` where `id`=$id_rfi";


            $sql = mysqli_query($this->db, $query)  or die($query . " - SQL ERRORE -- " . mysql_error());
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('status' => "Bad Query", "msg" => "Please check id_rfi value");
        $this->response($this->json($error), 400);

    }    
    
    function GetRFIreqinfo_NL(){
        //if ($this->login() > 0) {
            
            if (isset($this->_request['id_rfi'])) {
                $id_rfi = $this->_request['id_rfi'];
            } else {
                $error = array('id_rfi' => "Failed", "msg" => "Please enter id_rfi");
                exit($this->response($this->json($error), 401));
            }  
            
            $id_rfi = $this->db_escape($id_rfi);
            $query = "SELECT * FROM `dati_requisiti` where `id`=$id_rfi";


            $sql = mysqli_query($this->db, $query)  or die($query . " - SQL ERRORE -- " . mysql_error());
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        //}
        $error = array('status' => "Bad Query", "msg" => "Please check id_rfi value");
        $this->response($this->json($error), 400);

    }  

    function GetRFIuserinfo($id_user){
        if ($this->login() > 0) {
            
            if (isset($this->_request['id_user'])) {
                $id_user = $this->_request['id_user'];
                $id_user = $this->db_escape($id_user);
            } else {
                $error = array('id_user' => "Failed", "msg" => "Please enter id_user");
                exit($this->response($this->json($error), 401));
            }  
            
        
            $query = "SELECT `lastname`,`firstname`,`login`,`job_role_id`,`active`,`email`,`id_external` FROM `users` where `id`=$id_user";


            $sql = mysqli_query($this->db, $query)  or die($query . " - SQL ERRORE -- " . mysql_error());
            if (mysqli_num_rows($sql) > 0) {
                while ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $result[] = $row;
                $this->response($this->json($result), 200);
            }
        }
        $error = array('status' => "Bad Query", "msg" => "Please check id_rfi value");
        $this->response($this->json($error), 400);

    }    

    function Delete() {
        if ($this->login() > 0) {
            $table_name = $this->_request['table'];
            $conditions = $this->_request['conditions'];

            $sql0 = "DELETE FROM " . $table_name . " WHERE 1=1";
            foreach ($conditions as $key => $value) {
                if (is_numeric($value))
                    $sql0 .= " AND " . $key . "=" . $value . ",";
                else
                    $sql0 .= " AND " . $key . "=" . $this->db_escape($value) . ",";
            }
            $sql0 = substr($sql0, 0, -1);
            $sql = mysqli_query($this->db, $sql0);
            if (mysqli_affected_rows($this->db) > 0) {
                $this->response($this->json(array('Deleted_id' => mysqli_affected_rows($this->db))), 200);
            }
            $this->response('', 204);
        }
        $error = array('status' => "Failed", "msg" => "Failed To Delete");
        $this->response($this->json($error), 400);
    }

    function GetRow() {
        if ($this->login() > 0) {
            $table_name = $this->_request['table'];
            $conditions = $this->_request['conditions'];
            if (isset($this->_request['order_by']))
                $order_by = $this->_request['order_by'];
            else
                $order_by = null;
            $sql0 = "SELECT * FROM " . $table_name . " WHERE 1=1";
            if ($conditions != null) {
                foreach ($conditions as $key => $value) {
                    $sql0 .= " AND {$key} = '${value}'";
                }
            }
            if ($order_by != null) {
                $sql0 .= " ORDER BY ";
                foreach ($order_by as $key => $value) {
                    $sql0 .= " {$key} ${value}";
                }
            }  //  echo $sql0;
            $sql0 .= " LIMIT 1";
            $sql = mysqli_query($this->db, $sql0);
            if (mysqli_num_rows($sql) > 0) {
                if ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $this->response($this->json($row), 200);
                else
                    $this->response(array('status' => "Failed", "msg" => "Sorry It's Not Working"), 400);
            }
            $this->response('', 204); // If no records "No Content" status
        }
        $error = array('status' => "Failed", "msg" => "Sorry It's Not Working");
        $this->response($this->json($error), 400);
    }

    function GetSingleValue() {
        if ($this->login() > 0) {
            $tablename = $this->_request['table'];
            $column_single = $this->_request['column_single'];
            if (isset($this->_request['conditions']))
                $conditions = $this->_request['conditions'];
            else
                $conditions = null;

            $sql0 = "SELECT " . $column_single . " FROM " . $tablename . " WHERE 1=1";
            if ($conditions != null) {
                foreach ($conditions as $key => $value) {
                    if (is_numeric($value))
                        $sql0 .= " AND {$key} = ${value}";
                    else
                        $sql0 .= " AND {$key} = '${value}'";
                }
            }
            $sql = mysqli_query($this->db, $sql0);
            if (mysqli_num_rows($sql) > 0) {
                if ($row = mysqli_fetch_array($sql, MYSQLI_ASSOC))
                    $this->response($this->json($row), 200);
                else
                    $this->response(array('status' => "Failed", "msg" => "Sorry It's Not Working"), 400);
            }
            $this->response('', 204); // If no records "No Content" status
        }
        $error = array('status' => "Failed", "msg" => "Sorry It's Not Working");
        $this->response($this->json($error), 400);
    }
    
    
    function Capability5g() {
        
        $access = New Access_user(); 
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        if (!empty($this->_request['time'])) {
            $time = $this->_request['time'];         
            $timestamp = $access->uncoded_ExternalUserId($time);
            $now = time();
            if($now-$timestamp > 15*60){
                $this->response('Session Expired!!', 406);
            }
        } else {
            $this->response('Time Undefined!!', 406);
        }

        if (!empty($this->_request['user'])) {
            $user_id = $this->_request['user'];
            // $user = $access->get_ForeignUser($user_id);
        } else {
            $this->response('User Undefined', 406);
        }
        if (!empty($this->_request['sw_version'])) {
            $sw_version = $this->_request['sw_version'];
        } else {
            $sw_version = NULL;
            //$this->response('sw_version Undefined', 406);
        }

        if (!empty($this->_request['req_list'])) {
            $req_list = $this->_request['req_list'];
        } else {
            $this->response('Requirement ID List Undefined', 406);
        }
        if (!empty($this->_request['projectid'])) {
            $projectid = $this->_request['projectid'];
        } else {
            $this->response('projectid Undefined', 406);
        }
        if (!empty($this->_request['jsonfilename'])) {
            $jsonfilename = $this->_request['jsonfilename'];
        } else {
            $this->response('jsonfilename Undefined', 406);
        }
        if (!empty($this->_request['alllogfilename'])) {
            $alllogfilename = $this->_request['alllogfilename'];
        } else {
            $this->response('Log file Undefined', 406);
        }

        $soc = New socmanager();
        $project = $soc->get_projects($projectid);
        $reqId_array = explode(" ", $req_list);
        $rfi_value = 'True';
        $msg = "";
        foreach ($reqId_array as $id_req) {
                
                if($soc->updateSingleRfiFromTest($id_req, $rfi_value, $project, $user_id, $sw_version)){ 
                    $msg .= "<br> Update Id ".$id_req;
                }
                else {
                    $msg .= "<br> Failed to Insert ".$id_req.' SQL '.$soc->updateSingleRfiFromTest($id_req, $rfi_value, $project, $user_id, $sw_version);
                }
        }
        
        //Insert JSON and Log file into DB 
        if ($soc->updateJsonTable($project, $user_id, $sw_version, $jsonfilename, $alllogfilename)) {
            $msg .= "<br><br> JSON Capabilities Table Updated ";
            $msg .= "<br> Log Table Updated ";
        } else {
            $msg .= " Failed to Insert " . $id_req . ' SQL ' . $soc->updateJsonTable($project, $user_id, $sw_version, $json, $alllog);
        }

        $data = array('msg' => $msg.'<br> Done !! ');

        //$data = array('msg' => $msg,'timenow' => $now,'timestamp' => $timestamp, 'token' => $time, 'user' => $user, 'projectid' => $projectid, 'req_list' => $req_list);

        $this->response($this->json($data), 200);
    }
    

    function Capability4g() {
        $access = New Access_user(); 
        if ($this->get_request_method() != "POST") {
            $this->response('', 406);
        }

        if (!empty($this->_request['time'])) {
            $time = $this->_request['time'];         
            $timestamp = $access->uncoded_ExternalUserId($time);
            $now = time();
            if($now-$timestamp > 15*60){
                $this->response('Session Expired!!', 406);
            }
        } else {
            $this->response('Time Undefined!!', 406);
        }

        if (!empty($this->_request['user'])) {
            $user_id = $this->_request['user'];
            // $user = $access->get_ForeignUser($user_id);
        } else {
            $this->response('User Undefined', 406);
        }
        if (!empty($this->_request['sw_version'])) {
            $sw_version = $this->_request['sw_version'];
        } else {
            $sw_version = NULL;
            //$this->response('sw_version Undefined', 406);
        }
        if (!empty($this->_request['projectid'])) {
            $projectid = $this->_request['projectid'];
        } else {
            $this->response('projectid Undefined', 406);
        }
        if (!empty($this->_request['req4g_value'])) {
            $rfi_value = urldecode($this->_request['req4g_value']);
        } else {
            $this->response('Requirement Value Undefined', 406);
        }
        if (!empty($this->_request['req4g_id'])) {
            $id_req = $this->_request['req4g_id'];
        } else {
            $this->response('Requirement ID Undefined', 406);
        }
        if (!empty($this->_request['jsonfilename'])) {
            $jsonfilename = $this->_request['jsonfilename'];
        } else {
            $this->response('jsonfilename Undefined', 406);
        }
        if (!empty($this->_request['alllogfilename'])) {
            $alllogfilename = $this->_request['alllogfilename'];
        } else {
            $this->response('Log file Undefined', 406);
        }

        $soc = New socmanager();
        $project = $soc->get_projects($projectid);
  
        $msg = "";
    
                
                if($soc->updateSingleRfiFromTest($id_req, $rfi_value, $project, $user_id, $sw_version)){ 
                    $msg .= " Update requirement ".$id_req.'<br>';
                }
                else {
                    $msg .= " Failed to Insert ".$id_req.' SQL '.$soc->updateSingleRfiFromTest($id_req, $rfi_value, $project, $user_id, $sw_version);
                    $this->response($this->json($msg), 406);
                }
        //Insert JSON and Log file into DB 
        if ($soc->updateJsonTable($project, $user_id, $sw_version, $jsonfilename, $alllogfilename)) {
            $msg .= "<br><br> JSON Capabilities Table Updated ";
            $msg .= "<br> Log Table Updated ";
        } else {
            $msg .= " Failed to Insert " . $id_req . ' SQL ' . $soc->updateJsonTable($project, $user_id, $sw_version, $jsonfilename, $alllogfilename);
        }
        
        $data = array('msg' => $msg.'<br> Done !!');
        //$data = array('msg' => $msg,'timenow' => $now,'timestamp' => $timestamp, 'token' => $time, 'user' => $user, 'projectid' => $projectid, 'req_list' => $req_list);

        $this->response($this->json($data), 200);
    }

    function Insert() {
        if ($this->login() > 0) {
            $table_name = $this->_request['table'];
            $data = $this->_request['data'];

            $sql0 = "INSERT INTO " . $table_name . " (";
            $sql1 = " VALUES (";
            foreach ($data as $key => $value) {
                $sql0 .= $key . ",";
                if (is_array($value)) {
                    if ($value[1] == 'date')
                        $sql1 .= $this->db_escape($value[0]) . ",";
                    if ($value[1] == 'float')
                        $sql1 .= $value . ",";
                } else
                    $sql1 .= $this->db_escape($value) . ",";
            }
            $sql0 = substr($sql0, 0, -1) . ")";
            $sql1 = substr($sql1, 0, -1) . ")";
            //$string =  str_replace('\"', '',$sql0.$sql1);
            $string = stripslashes($sql0 . $sql1);
            // $this->response($string, 400);
            $sql = mysqli_query($this->db, $sql0 . $sql1);
            if (mysqli_insert_id($this->db) > 0) {
                $this->response($this->json(array('inserted_id' => mysqli_insert_id($this->db))), 200);
            }
            //$this->response('', 204);
            $error = array('status' => "Failed", "msg" => "Failed To Insert " . $string);
            $this->response($this->json($error), 400);
        } else {
            $error = array('status' => "Failed", "msg" => "Sorry You are not authenticated.");
            $this->response($this->json($error), 400);
        }
    }

    function Update() {
        if ($this->login() > 0) {
            $table_name = $this->_request['table'];
            $data = $this->_request['data'];
            $primary_key = $this->_request['primary_key'];

            $sql0 = "UPDATE " . $table_name . " SET ";
            foreach ($data as $key => $value) {
                if (is_array($value)) {
                    if ($value[1] == 'date')
                        $sql0 .= $key . " = " . $this->db_escape(date2sql($value[0])) . ",";
                    if ($value[1] == 'float')
                        $sql0 .= $key . " = " . $value . ",";
                }else {
                    if (is_numeric($value))
                        $sql0 .= $key . " = " . $value . ",";
                    else
                        $sql0 .= $key . " = " . $this->db_escape($value) . ",";
                }
            }
            $sql0 = substr($sql0, 0, -1);
            $sql0 .= " where ";

            foreach ($primary_key as $key => $value) {
                if (is_array($value)) {
                    if ($value[1] == 'date')
                        $sql0 .= $key . " = " . $this->db_escape(date2sql($value[0])) . ",";
                    if ($value[1] == 'float')
                        $sql0 .= $key . " = " . $value . ",";
                }else {
                    if (is_numeric($value))
                        $sql0 .= $key . " = " . $value . ",";
                    else
                        $sql0 .= $key . " = " . $this->db_escape($value) . ",";
                }
            }
            $sql0 = substr($sql0, 0, -1);
            $sql = mysqli_query($this->db, $sql0);
            if ($sql) {
                $this->response($this->json(array('response' => 'Updated')), 200);
            }
            $this->response($this->json(array($sql0)), 200);
        } else {
            $error = array('status' => "Failed", "msg" => "Sorry You are not authenticated.");
            $this->response($this->json($error), 400);
        }
    }
    
    function Test() {
 
        $file = 'atcommand'.time().'.txt';
        // Open the file to get existing content
        //$current = file_get_contents($file);
        // Append a new person to the file
        $current = "ETETET\n";
        // Write the contents back to the file
        file_put_contents($file, $current);
        echo 'Toto Ezio Eccoloooooo '. time() ;
        return json_encode('Toto Ezio Eccoloooooo '. time());

    }

    public function db_escape($value = "", $nullify = false) {
        $value = @html_entity_decode($value);
        $value = @htmlspecialchars($value);

        //reset default if second parameter is skipped
        $nullify = ($nullify === null) ? (false) : ($nullify);

        //check for null/unset/empty strings
        if ((!isset($value)) || (is_null($value)) || ($value === "")) {
            $value = ($nullify) ? ("NULL") : ("''");
        } else {
            if (is_string($value)) {
                //value is a string and should be quoted; determine best method based on available extensions
                if (function_exists('mysqli_real_escape_string')) {
                    $value = "'" . mysqli_real_escape_string($this->db, $value) . "'";
                } else {
                    $value = "'" . mysqli_escape_string($this->db, $value) . "'";
                }
            } else if (!is_numeric($value)) {
                //value is not a string nor numeric
                display_error("ERROR: incorrect data type send to sql query");
                echo '<br><br>';
                exit();
            }
        }
        return $value;
    }

    /*
     * 	Encode array into JSON
     */

    private function json($data) {
        if (is_array($data)) {
            return json_encode($data);
        }
    }

}

// Initiiate Library	
$api = new API;
$api->processApi();
?>

