<?php


include_once (__DIR__.'/../db_config.php');
include_once (__DIR__.'/../classes/access_user/access_user_class.php');
include_once (__DIR__.'/../classes/PHPExcel.php');


class socmanager {
    //put your code here
    var $mysqli;
   
    
    
    public function __construct(){
        $mysqli = $this->connect_dbli();
    }    
    
    
    
    function connect_dbli() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
//echo DB_SERVER." - ". DB_USER." - ". DB_PASSWORD." - ". DB_NAME;
    }
    
    
    function get_projects($id){       
       $query = "Select * FROM `projects` WHERE id = '$id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
       $obj = mysqli_fetch_assoc($result); 
       
       return $obj;      
    }
    
    function search_project($marca, $modello){       
       $query = "Select * FROM `projects` WHERE vendor LIKE '$marca' and model LIKE '%$modello%'";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
       $obj = mysqli_fetch_assoc($result); 
       
       return $obj;      
    }

    
    function delete_projects($id){
       $query = "DELETE FROM `projects` WHERE `id`='$id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
       
       return $result;
       
    }
    
    function delete_rfi_list($id){      
       $query = "DELETE FROM `dati_valori_requisiti` WHERE `id_project`='$id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
       
       return $result;
       
    }
    
    function get_status_list(){
        
       #$query = "SELECT DISTINCT `status_id` FROM `projects` ";
       $query = "SELECT * FROM `status` ";
       $risultato = array();
       
       if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['group_level']] = $this->get_statusNameByLevel($row['group_level']);
            }
            return $risultato;
        } else
            return array();      
    }
    
    
    function get_user_info($user_id){        
       $query = "Select users.lastname,users.firstname,users.login,users.active,users.leggi,users.inserisci,users.modifica,users.cancella,users.email,users.access_level,users.maillist,job_roles.id as job_roles_id, job_roles.name as usertype,job_roles.group_level as group_level ,departments.name as vendor FROM `users` left join job_roles on job_role_id=job_roles.id LEFT JOIN departments on department_id=departments.id  WHERE users.id='$user_id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
       $obj = mysqli_fetch_assoc($result); 
       
       return $obj;
       
    }
    
    function getFirstLastName($user_id){
        $firstLastName = '';
            if(!empty($this->get_user_info($user_id)['firstname']) || !empty($this->get_user_info($user_id)['lastname'])){

                $firstLastName = $this->get_user_info($user_id)['firstname'].' '.$this->get_user_info($user_id)['lastname'];
            }
            else if(!empty($this->get_user_info($user_id)['login'])){

                $firstLastName = $this->get_user_info($user_id)['login'];
            }
            else if($this->is_user_vendor($user_id)) {
                $firstLastName = 'Not Assigned'; 
            }
            else if($this->is_user_eng($user_id)) {
                $firstLastName = 'No Owner'; 
            }
            
            return $firstLastName;
    }
    
    function check_prototype($model){
        $delimiter ='*';
        
        if(substr($model, -1) == $delimiter){
            return TRUE;
        }
        else {  
            return FALSE;}

       
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
    
    
    function getAllRfiValueAndUeCapByPrId($id_project){       

        //$query = "SELECT * FROM `dati_valori_requisiti` WHERE  `id_project`='".$id_project."'";
        $query = "SELECT * FROM `dati_valori_requisiti` left join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito LEFT join dati_valori_requisiti_test on dati_valori_requisiti_test.id_requisito=dati_valori_requisiti.id_requisito WHERE dati_requisiti.decoder=1 and dati_valori_requisiti.id_project='".$id_project."'";

       #echo $query;
       
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[$id_project][$row['id_requisito']] = $row;
            
        } 
        #print_r($rfi_values);
        return $rfi_values;

    }

    function getAllRfiValueByPrId($id_project){       

        $query = "SELECT * FROM `dati_valori_requisiti` WHERE  `id_project`='".$id_project."'";

       #echo $query;
       
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
          while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[$id_project][$row['id_requisito']] = $row;
            
        } 
        #print_r($rfi_values);
        return $rfi_values;

    }

    function getRfiList($devicetypelist, $rfisubset=Null){       
        $where_condition=' 1 ';
        foreach ($devicetypelist as $key=>$value){
            
            if($value=='MBB'){
                $value='Router';
            }
            if($value=='Featurephone'){
                $value='phone';
            }
            
            $where_condition .= ' and  (`lista_req` like \'%'.$value.'%\') ';
            
        }
        
       if(isset($rfisubset) and ($rfisubset=='mdmreq')){
           //Filtro lista Requisiti MDM mandatori
           $query = "SELECT * FROM `dati_requisiti` WHERE $where_condition and `stato`=1 and summary=1 and description_mdm NOT LIKE 'nomap' ORDER by sheet_name, ordine";
       }
       elseif(isset($rfisubset)and ($rfisubset=='mandreq')){
           //Filtro lista Requisiti mandatori M=1
           $query = "SELECT * FROM `dati_requisiti` WHERE $where_condition and `stato`=1 and mandatoryoptional='M' ORDER by sheet_name,  ordine";
       }
       else{
           $query = "SELECT * FROM `dati_requisiti` WHERE $where_condition and `stato`=1 ORDER by sheet_name, ordine";
       }
       #echo $query;
       
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
          while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[$row['id']] = $row;
            
        } 
        
        return $rfi_values;

    }
    
    function getRfiList_test($devicetypelist, $rfisubset=Null){       
        $where_condition=' 1 ';
        foreach ($devicetypelist as $key=>$value){
            
            if($value=='MBB'){
                $value='Router';
            }
            if($value=='Featurephone'){
                $value='phone';
            }
            
            $where_condition .= ' and  (`lista_req` like \'%'.$value.'%\') ';
            
        }
        
       if(isset($rfisubset) and ($rfisubset=='mdmreq')){
           //Filtro lista Requisiti MDM mandatori
           $query = "SELECT * FROM `dati_requisiti` WHERE $where_condition and `decoder`=1 and `stato`=1 and summary=1 and description_mdm NOT LIKE 'nomap' ORDER by sheet_name, ordine";
       }
       elseif(isset($rfisubset)and ($rfisubset=='mandreq')){
           //Filtro lista Requisiti mandatori M=1
           $query = "SELECT * FROM `dati_requisiti` WHERE $where_condition and `decoder`=1 and `stato`=1 and mandatoryoptional='M' ORDER by sheet_name,  ordine";
       }
       else{
           $query = "SELECT * FROM `dati_requisiti` WHERE $where_condition and `decoder`=1 and `stato`=1 ORDER by sheet_name, ordine";
       }
       #echo $query;
       
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
          while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[$row['id']] = $row;
            
        } 
        
        if(count($rfi_values)>0) {
            return $rfi_values;
        }
        else {
            return NULL;
        }
            
        

    }

    
function getRfiListTechSum($devicetypelist){       
        $where_condition=' ';
        $count=0;
        
        foreach ($devicetypelist as $key=>$value){
            
            if($value=='Datacard'){
                $value='MBB';
            }
            if($value=='Router'){
                $value='MBB';
            }
            if($value=='Featurephone'){
                $value='phone';
            }
            
            if($count>0){
                $where_condition.=' OR ';
            }
            
            $where_condition .= ' (`lista_req` like \'%'.$value.'%\') ';
            $count++;
        }
           
           //Filtro lista Requisiti mandatori M=1
           $query = "SELECT * FROM `techsummary_list` WHERE $where_condition  ";


       #echo $query;
       
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
          while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[$row['id']] = $row;
            
        } 
        
        return $rfi_values;

    }
    
   function getRfiListTechSum_test($devicetypelist){       
        $where_condition=' ';
        $count=0;
        
        foreach ($devicetypelist as $key=>$value){
            
            if($value=='Datacard'){
                $value='MBB';
            }
            if($value=='Router'){
                $value='MBB';
            }
            if($value=='Featurephone'){
                $value='phone';
            }
            
            if($count>0){
                $where_condition.=' OR ';
            }
            
            $where_condition .= ' (`lista_req` like \'%'.$value.'%\') ';
            $count++;
        }
           
           //Filtro lista Requisiti mandatori M=1
           $query = "SELECT * FROM `techsummary_list` WHERE $where_condition  ";


       #echo $query;
       
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
          while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[$row['id']] = $row;
            
        } 
        
        return $rfi_values;

    } 
    
    function getRequirementInfoById($id){       

           $query = "SELECT * FROM `dati_requisiti` WHERE id='".$id."'";

        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
   
        return $row = $results->fetch_array(MYSQLI_ASSOC);

    }
    
    
    function get_soc($project, $filtro_mdm=null, $filter_5gBands=null){
        //filtro requisiti MDM Only
        if($filtro_mdm==1){
            $and_query = ' and description_mdm NOT LIKE \'nomap\' ';
        }
        else {$and_query='';}
        
        //filtro requisiti 5G Bands combination
        if($filter_5gBands==1){
            $and_query .= '';
        }
        else {
            $and_query .= ' and `dati_requisiti`.sheet_name NOT LIKE \'EN-DC List\' ';
            }
        /////////////////////////////////////
        
        if($project['devicetype']=='Featurephone'){ 
            $query = "SELECT `temp` . * , `dati_requisiti` . *
            FROM `dati_requisiti`
            left JOIN (
            SELECT nome_tel,valore_requisito,id_requisito,note,data_modifica,id_usermodify,review
            FROM `dati_valori_requisiti`
            WHERE id_project = '".$project['id']."'
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.stato=1 and `dati_requisiti`.`lista_req` LIKE '%phone%' $and_query order by `dati_requisiti`.sheet_name, `dati_requisiti`.ordine ";

            
        }
        elseif ((strcasecmp($project['devicetype'], 'MBB') == 0) or (strcasecmp($project['devicetype'], 'Router') == 0) or (strcasecmp($project['devicetype'], 'Datacard') == 0) ){
            $query = "SELECT `temp` . * , `dati_requisiti` . *
            FROM `dati_requisiti`
            left JOIN (
            SELECT nome_tel,valore_requisito,id_requisito,note,data_modifica,id_usermodify,review
            FROM `dati_valori_requisiti`
            WHERE id_project = '".$project['id']."'
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.stato=1 and `dati_requisiti`.`lista_req` LIKE '%Router%' $and_query order by `dati_requisiti`.sheet_name, `dati_requisiti`.ordine ";

            
        }
        elseif ((strcasecmp($project['devicetype'], 'Smartphone') == 0) or (strcasecmp($project['devicetype'], 'Tablet') == 0) ){
        //valido per Smartphone e Tablet
        //elseif($project['devicetype']=='Smartphone'){  

            $query = "SELECT `temp` . * , `dati_requisiti` . *
            FROM `dati_requisiti`
            left JOIN (
            SELECT nome_tel,valore_requisito,id_requisito,note,data_modifica,id_usermodify,review
            FROM `dati_valori_requisiti`
            WHERE id_project = '".$project['id']."'
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.stato=1 and `dati_requisiti`.`lista_req` LIKE '%".$project['devicetype']."%' $and_query order by `dati_requisiti`.sheet_name, `dati_requisiti`.ordine ";


        }
        #echo $query;
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
        return $result;
    
    }
    
    
    function get_soc_values($id_project){  
               
        $results = $this->get_soc($this->get_projects($id_project));
        
        $rfi_values = array();
        
        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[] = $row;
            
        }       
        return $rfi_values;
    }
    
    
    function get_statusNameByLevel($level) {
        $query = "SELECT * FROM `status` WHERE `group_level`='".$level."' ";
     
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
        $output = array();
                while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $output = $row;
            
        }       
        return $output['name'];
       
    }
    
    function get_statusGroupById($id) {
        $query = "SELECT * FROM `status` WHERE `id`='".$id."' ";
     
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        
        $output = array();
                while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $output = $row;
            
        }       
        return $output['name'];
       
    }
           
    
function update_rfi($rfi_value , $nota_value, $project, $user_id, $tobereview){
        
        $id_project = $project['id'];
        $data_update = date("Y-m-d");
        $update_count = 0;
        $insert_count = 0;
        
            foreach ($rfi_value  as $id => $s) {       
            
                $valore_req = mysqli_escape_string($this->mysqli,$rfi_value[$id]);
                $nota_req = mysqli_escape_string($this->mysqli,$nota_value[$id]);
                
                $valore_req = $this->validator($id, $valore_req);
                
                if(isset($tobereview[$id])){
                    $tobereview_req = $tobereview[$id];
                }
                else {
                        $tobereview_req = 0;
                }   
                

                $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                $obj_check = mysqli_fetch_array($result_check);

                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`, `data_modifica`, `id_usermodify`, `review` ) "
                            . "VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project . "',NOW(),'" . $user_id . "','" . $tobereview_req. " ')";
                    #echo "insert ".$query5."<br>";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    $insert_count++;
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' ,`id_usermodify`='" . $user_id . "', `data_modifica`=NOW(),`review`='" . $tobereview_req . "'  WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project . "' )";
                    #echo "update ".$query5."<br>";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    #echo 'Update SOC '. $query5.'<br>';
                    $update_count++;
                }
            }
            
            return array('insert'=>$insert_count,'update'=>$update_count);
    }
    
    function validator($idreq, $valuereq){        
        // Req. Launch Date (yyyymm)        
        if($idreq == 11706){
            if (preg_match("/^[0-9]{4}-[0-1][0-9]$/",$valuereq))
                {
                    return $valuereq;
                }else{
                    
                    return substr($valuereq, 0, 6);
                }
        }
        else {
            return $valuereq;
        }
        
    }
    
    
    //Validator with report message warnig output
    function validatorMsg($idreq, $valuereq, $validationReport){        
        // Req. Launch Date (yyyymm)        
        if($idreq == 11706){
            if (preg_match("^[0-9]{4}-[0-1][0-9]$",$valuereq))
                {
                    return TRUE;
                }else{
                    
                    return substr($valuereq, 0, 6);
                }
        }
        else {
            return $valuereq;
        }
        
    }
    
    
    
    function updateSingleRfi($id, $rfi_value ,$project, $user_id){
        
        $id_project = $project['id'];
        $data_update = date("Y-m-d");
        $tobereview_req = 0;
            
                $valore_req = mysqli_escape_string($this->mysqli,trim($rfi_value));

                
                $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                $obj_check = mysqli_fetch_array($result_check);

                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`, `data_modifica`, `id_usermodify`, `review` ) "
                            . "VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project . "',NOW(),'" . $user_id . "','" . $tobereview_req. " ')";
                        mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    //echo "Insert Done";
                    return true;    
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`id_usermodify`='" . $user_id . "', `data_modifica`=NOW()  WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project . "' )";
                    
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));                 
                    // echo "Update Done";
                    return true;
                }
                
                
    }
    
    function updateSingleRfiFromTest($id, $rfi_value ,$project, $user_id, $sw_version){
        
        $id_project = $project['id'];
        //$data_update = date("Y-m-d");
        $tobereview_req = 0;
        //True SW[222] Ignazio Toto 2020-06-22 14:48:23
        $access = New Access_user();
        $user = $access->get_ForeignUser($user_id);
        $valore_req = mysqli_escape_string($this->mysqli,trim($rfi_value));
        $date_update = date("Y-m-d H:i:s");
        
        $history = mysqli_escape_string($this->mysqli,$valore_req.' SW['.$sw_version.'] '.$user.' '.$date_update);
                
                $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti_test WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                $obj_check = mysqli_fetch_array($result_check);

                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    
                    $query5 = "INSERT INTO `dati_valori_requisiti_test`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`, `data_modifica`, `id_usermodify`, `review`, `sw_version`, `history`) "
                            . "VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $date_update . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project . "', '" . $date_update . "','" . $user_id . "','" . $tobereview_req. " ','" . $sw_version. " ','" . $history . " ')";
                        mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    //echo "Insert Done";
                    return true;    
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti_test` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $date_update . "',`id_usermodify`='" . $user_id . "', `data_modifica`='".$date_update.".', `history` = CONCAT('$history','|',`history`)   WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project . "' )";
                    
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));                 
                    // echo "Update Done";
                    return true;
                }
                
                
    }
    
    function updateSingleNote($id, $nota, $project, $user_id){
        
        $id_project = $project['id'];
        $data_update = date("Y-m-d");
        $tobereview_req = 0;
            
                $nota_req = mysqli_escape_string($this->mysqli,trim($nota));
               
                $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                $obj_check = mysqli_fetch_array($result_check);

                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`, `data_modifica`, `id_usermodify`, `review` ) "
                            . "VALUES (NULL,'" . $id . "','" . $project['model'] . "','','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project . "',NOW(),'" . $user_id . "','" . $tobereview_req. " ')";
                    // echo "insert ".$query5."<br>";
                    if(mysqli_query($this->mysqli,$query5)){
                        return true;
                    }else{
                       return $query5 . " - " . mysqli_error($this->mysqli); 
                    }
                            
                    
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `note` = '" . $nota_req . "' ,`data_inserimento`='" . $data_update . "',`id_usermodify`='" . $user_id . "', `data_modifica`=NOW()  WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project . "' )";
                    // echo "update ".$query5."<br>";
                    if(mysqli_query($this->mysqli,$query5)){
                        return true;
                    }else{
                       return $query5 . " - " . mysqli_error($this->mysqli); 
                    }
                }

    }
    
    
    
    function updateJsonTable($project, $user_id, $sw_version, $jsonfilename, $alllogfilename){
        $dir = '../../log_check/';
        $json = file_get_contents($dir . $jsonfilename);
        $alllog = file_get_contents($dir . $alllogfilename);
        
        $id_project = $project['id'];
        $date_update = date("Y-m-d H:i:s");
        //True SW[222] Ignazio Toto 2020-06-22 14:48:23
        $access = New Access_user();
        $user = $access->get_ForeignUser($user_id);
        $json = mysqli_escape_string($this->mysqli,trim($json));
        $alllog = mysqli_escape_string($this->mysqli,trim($alllog));
        //$valore_req = mysqli_escape_string($this->mysqli,trim($rfi_value));
        //$history = mysqli_escape_string($this->mysqli,$valore_req.' SW['.$sw_version.'] '.$user.' '.date("Y-m-d H:i:s"));
                
                $query_check = "SELECT  count(*) AS Num  FROM  `json_capabilities` WHERE  id_project='" . $project['id'] . "' ";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                $obj_check = mysqli_fetch_array($result_check);

                //if (($obj_check['Num'] == 0)) {
                    $query5 = "INSERT INTO `json_capabilities`(`id`, `data_inserimento`, `id_project`, `data_modifica`, `id_usermodify`, `sw_version`, `json`, `log`) "
                            . "VALUES (NULL, '" . $date_update . "', '" . $id_project . "', '" . $date_update . "', '" . $user_id . "', '" . $sw_version. " ' , '$json', '$alllog') ";
                    if(mysqli_query($this->mysqli,$query5)){                        
                        return true;                            
                    }
                    else {
                         return $query5 . " - " . mysqli_error($this->mysqli);  
                    }

                       
               /*
                    } else {                
                    $query5 = "UPDATE `json_capabilities` SET `id_usermodify`='" . $user_id . "', `data_modifica`=NOW(), `history` = CONCAT('$history','|',`history`)   WHERE (  `id_project` = '" . $id_project . "' )";
                    
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));                 
                    // echo "Update Done";
                    return true;
                }
                * 
                */
                
                
    }
  
    function updateToBeReview($id, $value, $project, $user_id){
        
        $id_project = $project['id'];
        $data_update = date("Y-m-d");
        $tobereview_req = $value;
                
                $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                $obj_check = mysqli_fetch_array($result_check);

                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`,  `data_inserimento`,`data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`, `data_modifica`, `id_usermodify`, `review` ) "
                            . "VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $data_update . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project . "',NOW(),'" . $user_id . "','" . $tobereview_req. " ')";
                    // echo "insert ".$query5."<br>";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    return 1;
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `review` = '" . $tobereview_req . "' ,`data_inserimento`='" . $data_update . "',`id_usermodify`='" . $user_id . "', `data_modifica`=NOW()  WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project . "' )";
                    // echo "update ".$query5."<br>";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    return 2;
                }

    }
    


    function copy_rfi_values($id_project_from, $id_project_to){

        $project = $this->get_projects($id_project_to);
        $rfi_values = $this->get_soc_values($id_project_from);
        
        #$id_project = $project['id'];
        $data_update = date("Y-m-d");
       
        #$rfi_value = $this->get_soc($this->get_projects($id_project_from));
      #echo'<pre>';
      #  print_r($rfi_values);
      #echo'</pre>';  

            foreach ($rfi_values  as $id=>$value) {
                     
                $valore_req = mysqli_query($this->mysqli,trim($rfi_values [$id]['valore_requisito']));
                $nota_req = mysqli_query($this->mysqli,trim($rfi_values[$id]['note']));

                #$query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                #$result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                #$obj_check = mysqli_fetch_array($result_check);
                
            
                $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) "
                        . "VALUES (NULL,'" . $rfi_values [$id]['id_requisito'] . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                
                #echo'<pre>';
                #echo 'query insert '.$query5.'<br>';
                #echo'</pre>';
                mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                
                
            /*    
                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project_to . "' and `nome_tel` = '" . $project['model'] . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    #echo 'Update SOC '. $query5.'<br>';
                }
             * 
             */
            }


    }
    
    function copy_rfi_values_mandatory($id_project_from, $id_project_to){

        $project = $this->get_projects($id_project_to);
        $rfi_values = $this->get_soc_values($id_project_from);
        
        #$id_project = $project['id'];
        $data_update = date("Y-m-d");
       
        #$rfi_value = $this->get_soc($this->get_projects($id_project_from));
      #echo'<pre>';
      #  print_r($rfi_values);
      #echo'</pre>';  

          foreach ($rfi_values  as $id=>$value) {
                
              if($this->is_mandatory_rfi($rfi_values [$id]['id_requisito'])){
                
                $valore_req = mysqli_query($this->mysqli,trim($rfi_values [$id]['valore_requisito']));
                $nota_req = mysqli_query($this->mysqli,trim($rfi_values[$id]['note']));

                #$query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                #$result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysqli_error($this->mysqli));
                #$obj_check = mysqli_fetch_array($result_check);
                
            
                $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) "
                        . "VALUES (NULL,'" . $rfi_values [$id]['id_requisito'] . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                
                #echo'<pre>';
                #echo 'query insert '.$query5.'<br>';
                #echo'</pre>';
                mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                
                
            /*    
                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project_to . "' and `nome_tel` = '" . $project['model'] . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysqli_error($this->mysqli));
                    #echo 'Update SOC '. $query5.'<br>';
                }
             * 
             */
                }
            }


    }
    
    
    function get_tot_rfi($id_project) {
        $query3 = "select count(id) as numero_requisiti from dati_valori_requisiti where id_project='$id_project'";
        //echo $query3;
        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysqli_error($this->mysqli));
        $obj3 = mysqli_fetch_array($result3);
        if (isset($obj3['numero_requisiti']))
            return $obj3['numero_requisiti'];
        else
            return 0;
    }
    
    
    function get_mandatory_rfi($id_project,$status=null) {
        
        if(empty($status)){
            $where_cond = "";
        }
        elseif($status==0 || $status==1) {
           $where_cond = "stato=".$status." and "; 
        }
        
        $project = $this->get_projects($id_project);
        
        $devicetype = $project['devicetype'];         
        if($project['devicetype']=='Fetaurephone'){$devicetype = 'phone';}
        elseif ((strcasecmp($project['devicetype'], 'MBB') == 0) or (strcasecmp($project['devicetype'], 'Router') == 0) or (strcasecmp($project['devicetype'], 'Datacard') == 0)){
            $where_cond = "lista_req  like '%Router%'";
        }
        
        
        $q1 = "SELECT COUNT(*) FROM `dati_requisiti` WHERE `stato`=1 AND (`mandatoryoptional`='M' OR `summary`=1) AND `lista_req` LIKE '%" . $devicetype . "%' ";
        
        $q1 = mysqli_query($this->mysqli, $q1) or die(mysqli_error($this->mysqli));
        $r1 = mysqli_fetch_assoc($q1);
        $tot_mand = $r1['tot'];
        
        return $tot_mand;
        
    }
    
    
    function get_tot_mandatory($devicetype=null) {
        
        $devicetype = $this->devicetypeToquery($devicetype);
        
        if(!empty($devicetype)){ 
            $where_cond = "lista_req  like '%$devicetype%'";
        }
        else {$where_cond = " 1"; }

        
        $sql = "SELECT count(*) as totale FROM `dati_requisiti` WHERE (`mandatoryoptional`='M' or `summary`=1) and `stato`=1 and $where_cond";
        
        $query = mysqli_query($this->mysqli, $sql) or die(mysqli_error($this->mysqli));
        $r1 = mysqli_fetch_assoc($query);
        $tot_mand = $r1['totale'];
        
        return $tot_mand;
        
    }
               
    
    
    function is_mandatory_rfi($id) {       
        $sql = "SELECT * FROM `dati_requisiti` WHERE `id`=$id";
        $q1 = mysqli_query($this->mysqli, $sql) or die(mysqli_error($this->mysqli));
        $res = mysqli_fetch_assoc($q1);
        
        if($res['mandatoryoptional']=='M' || $res['summary']==1){
           return TRUE;
        }
        else return FALSE;      
    }
    
    
    
    //Return Tot value of mandatory rfi Empty
    function get_mandatoryEmpty_rfi($id_project) {
        
        $project = $this->get_projects($id_project);                
        $devicetype = $this->devicetypeToquery($project['devicetype']);         

        // query per totale mandatory vuoti        
        $q3 = "SELECT `temp` . * , `dati_requisiti` . *, count(*) as tot 
	FROM `dati_requisiti`
	left JOIN (
	SELECT nome_tel,valore_requisito,id_requisito,note
	FROM `dati_valori_requisiti`
	WHERE id_project = '" . $project['id'] . "'
	) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.`stato`=1 AND `dati_requisiti`.`lista_req` LIKE '%" . $devicetype . "%' AND  (`dati_requisiti`.`summary`=1 OR `dati_requisiti`.`mandatoryoptional`='M')   AND ((`valore_requisito` = '' OR `valore_requisito` IS NULL) AND (`note` = '' OR `note` IS NULL))";    

        $q3 = mysqli_query($this->mysqli, $q3) or die(mysqli_error($this->mysqli));
        $r1 = mysqli_fetch_assoc($q3);
        //usare questo
        //mysqli_num_rows($result)
        $tot = $r1['tot'];
        
        return $tot;
        
    }
    
        //Return Tot value of mandatory rfi Empty
    function get_mandatoryFilled_rfi($id_project) {
        
        $project = $this->get_projects($id_project);                
        $devicetype = $this->devicetypeToquery($project['devicetype']);         

        /*
        if(!empty($all)){ 
            $where_cond .= " and  sheet_name NOT LIKE '%EN-DC%'";
        }
        else {$where_cond = " "; }
         * 
         */
        
        // query per totale mandatory Pieni       
        $q3 = "SELECT count(*) as tot from dati_valori_requisiti left join dati_requisiti on dati_requisiti.id=dati_valori_requisiti.id_requisito  WHERE id_project = '" . $project['id'] . "' and  `dati_requisiti`.`stato`=1 AND `dati_requisiti`.`lista_req` LIKE '%" . $devicetype . "%' AND  (`dati_requisiti`.`summary`=1 OR `dati_requisiti`.`mandatoryoptional`='M')   AND (`valore_requisito` <> '' OR `note` <> '' ) ";
     
        
        $q3 = mysqli_query($this->mysqli, $q3) or die(mysqli_error($this->mysqli));
        $r1 = mysqli_fetch_assoc($q3);
        //usare questo
        //mysqli_num_rows($result)
        $tot = $r1['tot'];
        
        return $tot;
        
    }
    
    

    
    function update_all_progress_projects() {
        
        //update all projects progess
           $data_projects = $this->get_projects_list(); 
           foreach ($data_projects as $key => $value) {
               
               $this->update_progress_project($data_projects[$key]['id']);
               
           } 

    }
    
    function update_progress_project($id_project) {
        
        $project = $this->get_projects($id_project);  
        $devicetype = $project['devicetype'];
        
        $tot_mand = $this->get_tot_mandatory($devicetype);
        //$tot_mand_empty = $this->get_mandatoryEmpty_rfi($id_project);
        

        //$tot_mand_not_empty = $tot_mand - $tot_mand_empty;
        $tot_mand_not_empty = $this->get_mandatoryFilled_rfi($id_project);
        
        $progress = round(($tot_mand_not_empty / $tot_mand)*100,1);     
        #echo "tot_mand ".$tot_mand;
        #echo "tot_mand_empty ".$tot_mand_empty;
        #echo "progress ".$progress;
        
        $q_update = "Update projects set progress='".$progress."' WHERE id='".$id_project."'";
        if(mysqli_query($this->mysqli, $q_update)){
                    #echo 'id_project  '.$id_project.'<br>';
                    #echo 'Vuoti  '.$tot_mand_empty.'<br>';
                    #echo 'Totale '.$tot_mand.'<br>';
                    #echo 'Progress '.$progress.'<br>';         
            //percentuale progress bar
            return $progress;

        }
        else { return mysqli_error($this->mysqli);}     
        
    }     

    
    
    
    function update_status_project($id_project, $status) {
        //1 Open WindTre
        //2 Open Vendor
        //3 Close
        $project = $this->get_projects($id_project);     
        $q_update = "Update projects set status_id='".$status."' Where id='".$id_project."'";
        if(mysqli_query($this->mysqli, $q_update)){        
            //percentuale progress bar
            return TRUE;
        }
        else { return mysqli_error($this->mysqli);}       
    }
    
    
    function close_project($id_project) {

        $project = $this->get_projects($id_project);
        
        $q_update = "Update projects set status_id=3 Where id='".$id_project."'";
        if(mysqli_query($this->mysqli, $q_update)){        
            //percentuale progress bar
            return TRUE;

        }
        else { return mysqli_error($this->mysqli);}
        
    }
    

    
     function get_projects_where($condition=1) {
          
        $data_output = array();
        
        #$query1 = "SELECT * FROM dati_valori_requisiti where $where_condition GROUP by `nome_tel`,`vendor` order by `data_inserimento` desc";
        $sql = "SELECT * FROM `projects` "
                . " WHERE $condition order by `data_inserimento` desc";
//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);

        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {   
            $data_output[] = array( 
            'id'=>$row['id'],     
            'owner'=>$row['owner'],
            'status'=>$row['status'],
            'progress'=>$row['progress'],
            'data_inserimento'=>$row['data_inserimento'],
            'data_accettazione'=>$row['data_accettazione'],
            'model'=>$row['model'],
            'market'=>$row['market'],
            'devicetype'=>$row['devicetype'],
            'vendor'=>$row['vendor']);
            
        }
    return $data_output;
        
    }
    
    function get_modelsByprojects($vendor=null, $devicetype=null) {
        $where_condition = " WHERE 1 ";
        
        if(!empty($vendor)){ $where_condition .= " and `vendor`='".$vendor."'";}
        if(!empty($devicetype)){ $where_condition .= " and  `devicetype`='".$devicetype."'";}  

        $query = "SELECT distinct `model`, `id`  FROM `projects` $where_condition  order by `model` asc";
        #echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['id']] = $row['model'];
            }
            return $risultato;
        } else
            return array();
    }
    
    
    function get_projects_list_old($user_id=null) {
        $job_role = $this->get_user_info($user_id)['group_level'];
        
        #if($this->is_user_vendor($user_id)){
        // Se l'utente è un Vendor
        if($job_role == 6){
            $vendor = $this->get_user_info($user_id)['vendor'];
            #$sql = "SELECT * FROM `projects` WHERE vendor like '%$vendor%' and status_id=2 order by `data_inserimento` desc";                
            $sql = "SELECT * FROM `projects` WHERE vendor like '%$vendor%'  order by `data_inserimento` desc";            
        }
        //se utente Guest o Tester WindTre vede solo Progetti Closed
        elseif($job_role<=2 ){
            
            $sql = "SELECT * FROM `projects` WHERE status_id=3 order by `data_inserimento` desc";            
        }
        //Utenti PM o Engineer vede Tutto
        elseif($job_role>6){       
            $sql = "SELECT * FROM `projects` "
                . " WHERE 1 order by `data_inserimento` desc";
        }
        $data_output = array();
        #$query1 = "SELECT * FROM dati_valori_requisiti where $where_condition GROUP by `nome_tel`,`vendor` order by `data_inserimento` desc";

//echo $sql;
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);

        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {   
            $data_output[] = array( 
            'id'=>$row['id'],     
            'owner'=>$row['owner'],
            'status_id'=>$row['status_id'],
            'progress'=>$row['progress'],
            'data_inserimento'=>$row['data_inserimento'],
            'data_accettazione'=>$row['data_accettazione'],
            'model'=>$row['model'],
            'market'=>$row['market'],
            'devicetype'=>$row['devicetype'],
            'vendor'=>$row['vendor'],
            'vendor_user_id'=>$row['vendor_user_id']
                    
            );
            
        }
    return $data_output;
        
    }
    
    
    function get_projects_list($user_id=null) {

        $sql = "SELECT * FROM `projects` ";
        
        $job_role = $this->get_user_info($user_id)['group_level'];

        #if($this->is_user_vendor($user_id)){
        // Se l'utente è un Vendor
        if($job_role == 6){
            $vendor = $this->get_user_info($user_id)['vendor'];
            #$sql = "SELECT * FROM `projects` WHERE vendor like '%$vendor%' and status_id=2 order by `data_inserimento` desc";                
            $sql = $sql ." WHERE vendor like '%$vendor%' ";            
        }
        //se utente Guest  vede solo Progetti Closed
        elseif($job_role<2 ){
            
            $sql = $sql ."  WHERE status_id=3 ";            
        }
        //Utenti PM o Engineer o un Tester vede Tutto
        elseif($job_role>6 or $job_role == 2){       
            $sql = $sql ." WHERE 1 "; 
                    //Qyery modificata per OLD and NEW RFI
            
        }
        $sql = $sql . ' AND  (id>=242 OR id IN (100,94,95,190,188,189,1,184,198,179,92,93,186,185,187)) order by `data_inserimento` desc';
        #$query1 = "SELECT * FROM dati_valori_requisiti where $where_condition GROUP by `nome_tel`,`vendor` order by `data_inserimento` desc";
        
        if($user_id=='all'){
            $sql = "SELECT * FROM `projects` order by `data_inserimento` desc";
        }
        
        
//echo $sql; 

        
        $data_output = array();
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);

        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {   
            $data_output[] = array( 
            'id'=>$row['id'],     
            'owner'=>$row['owner'],
            'status_id'=>$row['status_id'],
            'progress'=>$row['progress'],
            'data_inserimento'=>$row['data_inserimento'],
            'data_accettazione'=>$row['data_accettazione'],
            'model'=>$row['model'],
            'market'=>$row['market'],
            'devicetype'=>$row['devicetype'],
            'vendor'=>$row['vendor'],
            'vendor_user_id'=>$row['vendor_user_id']
                    
            );
            
        }
    return $data_output;
        
    }
    
    function get_UECapProjects($user_id=null) {
        $job_role = $this->get_user_info($user_id)['group_level'];

        // Se l'utente è un Vendor
        if($job_role >=7){
            $sql = "SELECT `id`, `data_inserimento`,`id_project`,`data_modifica`,`id_usermodify`,`sw_version` FROM `json_capabilities` Group BY `id_project` ORDER BY `data_modifica` DESC"; 
            // $sql = "SELECT * FROM `json_capabilities` Group BY `id_project` ORDER BY `data_modifica` DESC";   
            //$sql = "SELECT * FROM `json_capabilities` ORDER BY `data_modifica` DESC"; 
        }
        else {
            return FALSE;
        }

        $data_output = array();
        $results = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);

        while ($row = $results->fetch_assoc()) {   
            $data_output[] = $row;           
        }
        return $data_output;
        
    }
    
    
    function is_user_test($user_id){
        //job_roles==1 Vendor User
        if($this->get_user_info($user_id)['group_level']==2){
            return TRUE;
        }      
        return FALSE;       
    }
    
    function is_user_vendor($user_id){
        //job_roles==1 Vendor User
        if($this->get_user_info($user_id)['group_level']==6){
            return TRUE;
        }      
        return FALSE;       
    }
    
    function is_user_pm($user_id){
        //job_roles==1 Vendor User
        if($this->get_user_info($user_id)['group_level']==7){
            return TRUE;
        }      
        return FALSE;       
    }
    
    function is_user_guest($user_id){
        //job_roles==1 Vendor User
        if($this->get_user_info($user_id)['group_level']==1){
            return TRUE;
        }      
        return FALSE;       
    }
    
    function is_user_eng($user_id){
        //job_roles!=1 NO Vendor User
        if($this->get_user_info($user_id)['group_level']==8){
            return TRUE;
        }      
        return FALSE;       
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
    
    
    
    
 function insertFromRFItemplate($full_path, $project, $user_id) {
        #require_once './classes/PHPExcel.php';
        require_once './classes/PHPExcel/IOFactory.php';
        /** PHPExcel_Cell_AdvancedValueBinder */
        require_once './classes/PHPExcel/Cell/AdvancedValueBinder.php';

        if (!file_exists($full_path)) {
            exit("File non pervenuto." . EOL);
        }
        $numero_inserimenti = 0;
        $numero_modifiche = 0;
        $inputFileName = $full_path;
        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        $objReader->setReadDataOnly(true);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel_reader = $objReader->load($inputFileName);
        $objPHPExcel_reader->getActiveSheet(0);
        #$date = date("Y-m-d");
        #$description = array();
        $answers = array();
        $notes = array();
        $tobereview = array();
        $conto = 0;
        $riga = 0;
        //foreach ($objPHPExcel_reader->getWorksheetIterator() as $worksheet) 
        for ($i = 0; $i < $objPHPExcel_reader->getSheetCount(); $i++) {
            $worksheet = $objPHPExcel_reader->getSheet($i);
            $title_sheet = $worksheet->getTitle();
            //exit('$title_sheet '.$title_sheet);
            foreach ($worksheet->getRowIterator() as $row) {
                $id_req = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
                //salto le righe con id non intero
              if($id_req > 1000) {
                //echo '$id_req'. $id_req;
                //exit('$title_sheet '.$title_sheet.' $id_req '.$id_req); 
                if($title_sheet !='EN-DC List'){ 
                    
                    //$description = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                    $valore_req = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue(); 
                    $nota_req = $worksheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
                }
                elseif($title_sheet == 'EN-DC List'){        
                    
                    //$description = $worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue();
                    $valore_req = $worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue(); 
                    $nota_req = $worksheet->getCellByColumnAndRow(8, $row->getRowIndex())->getValue(); 
                    
                }
                /*per template con formule di Daniele Siena 
                if(strstr($valore_req,'=')==true){
                    $valore_req = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getOldCalculatedValue();
                }
                 * 
                 */
                /////workoround ZTE insert Vero/Falso  True/False
                ///////////////////////////////////////////////////
                if($this->checkBooleanOption($id_req)){
                    
                    if(is_bool($valore_req) and $valore_req){
                        $valore_req = 'True';
                    }
                    elseif(is_bool($valore_req) and !$valore_req){
                        $valore_req = 'False';
                    }

                }
                //////////////////////////////////////////////////////
                    
                $valore_req =  mysqli_real_escape_string ($this->mysqli,$valore_req);              
                $nota_req =  mysqli_real_escape_string ($this->mysqli,$nota_req);
                
                if (isset($valore_req) || isset($nota_req) && $riga>1) {
                                    
                    $answers[$id_req] = $valore_req;
                    $notes[$id_req] = $nota_req;
                    $tobereview[$id_req] = 0;
                    $conto++;
                    $riga++;

                }
              }
            }
           
        }
        #echo'<pre>';
        #echo'lettura excel';   
        #print_r($id_req);
        #print_r($answers);
        #print_r($notes);
        #echo'</pre>';
        $conto--;
        $output = $this->update_rfi($answers, $notes, $project, $user_id, $tobereview);
        $insert = $output['insert'];
        $update = $output['update'];
        #echo "<br><p><h3>Requirements: Values added $insert / Values updated $update </h3></p>";
        echo "<p><h3>Upload complete: $insert added, $update updated</h3></p>";
    }
    
    
    function  checkBooleanOption($id_req){
       
        $query = "SELECT `opzioni_requisito` FROM `dati_requisiti` WHERE `id`='".$id_req."'";
        
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));
        $res = mysqli_fetch_row($result);
        if((stripos($res[0],"true")!== false) and (stripos($res[0],"false")!== false)) {
            return TRUE;
        }
        else {return FALSE;}
        
    }
    
    function insert_update_template_lsoc($full_path, $modello, $update = false) {
    $db_link = connect_db_li();
    require_once 'Excel/reader.php';
    $data = new Spreadsheet_Excel_Reader();   
    $data->setOutputEncoding('ISO-8859-1//IGNORE'); // Set output Encoding.
    $data->read($full_path);
    error_reporting(E_ALL ^ E_NOTICE);
    connect_db();
    //echo "<table border='1'>";
    $numero_inserimenti = 0;
    
    //sheet number
    for ($sheet = 0; $sheet < 34; $sheet++) {
        for ($i = 1; $i <= $data->sheets[$sheet]['numRows']; $i++) {

            //$query3 = "SELECT id,count(id)as numero_record  FROM `dati_requisiti` WHERE `nome_requisito` LIKE '" . $data->sheets[$sheet]['cells'][$i][1] . "'";
            //	$result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysqli_error($this->mysqli));
            //$obj3 = mysqli_fetch_array($result3);
            //if ($obj3['numero_record'] == 1) {
            if ($data->sheets[$sheet]['cells'][$i][3] == "M") {
                if (($data->sheets[$sheet]['cells'][$i][4] == "New")) {
                    $query4 = "INSERT INTO  `socmanager`.`dati_requisiti` (
							`id` ,
							`nome_requisito` ,
							`descrizione_requisito` ,
							`label` ,
							`summary` ,
							`stato` ,
							`data`
							`mandatoryoptional`
							)
							VALUES (
							NULL ,  '" . $data->sheets[$sheet]['cells'][$i][1] . "',
									'" . $data->sheets[$sheet]['cells'][$i][2] . "',
									'','',
									'" . $data->sheets[$sheet]['cells'][$i][5] . "',
									'" . $data->sheets[$sheet]['cells'][$i][6] . "'
									'" . $data->sheets[$sheet]['cells'][$i][3] . "'		
									);";
                    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysqli_error($this->mysqli));
                    $numero_inserimenti++;
                } else if (($data->sheets[$sheet]['cells'][$i][4] == "Modify")) {

                    $query4 = "UPDATE  `socmanager`.`dati_requisiti` SET  `descrizione_requisito` =  '" . $data->sheets[$sheet]['cells'][$i][2] . "',
							`stato` =  '" . $data->sheets[$sheet]['cells'][$i][5] . "',
									`data` =  '" . $data->sheets[$sheet]['cells'][$i][6] . "',
											`mandatoryoptional` =  '" . $data->sheets[$sheet]['cells'][$i][3] . "' WHERE  `dati_requisiti`.`nome_requisito` =" . $data->sheets[$sheet]['cells'][$i][1] . ";
													);";
                    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysqli_error($this->mysqli));
                    $numero_inserimenti++;
                }
            }
        }
    }
    echo "<h2>Sono stati inseriti $numero_inserimenti requisiti con successo</h2>";
}

    function checkRFI_template ($full_path) {
        #print_r(explode('.',$full_path)); 
        
        
       $file_ext = strtolower(explode('.',$full_path)[2]); 
       

       $extensions= array("xlsx","xls");
      
      if(in_array($file_ext,$extensions)=== false){

          exit("Extension not allowed, please choose a XLSX or XLS file.");
      }
        

        if (PHP_SAPI == 'cli'){
            die('This example should only be run from a Web Browser');
        }
        
        $objPHPExcel = new PHPExcel();
        
        $inputFileName = $full_path;

        /**  Identify the type of $inputFileName  * */
        $inputFileType = PHPExcel_IOFactory::identify($inputFileName);
        /**  Create a new Reader of the type that has been identified  * */
        $objReader = PHPExcel_IOFactory::createReader($inputFileType);
        /**  Load $inputFileName to a PHPExcel Object  * */
        $objPHPExcel_reader = $objReader->load($inputFileName);
        
        $creator = $objPHPExcel_reader->getProperties()->getCreator();
        $title = $objPHPExcel_reader->getProperties()->getTitle();
        $key_security = $objPHPExcel_reader->getProperties()->getKeywords();
        $security = $objPHPExcel_reader->getSecurity(); 
        
        //check security
        if ($key_security=='newProtection_STYLE_STOP'){   
            //exit("key_security Error --> ".$key_security);
            return true;
        }
        else {
            //exit("key_security Error --> ".$key_security);
            return false;
        }
        
        //return array($creator,$title,$security);
                //->setCategory("LSoc");
    }

    
    function upload_RFItemplate($path=null) { 
       $path =  "gestioneLSoc/template/";

       $fileid = $_POST['fileid'];

       if(isset($_FILES['file'])){
          print_r($_FILES);
          $errors= array();
          $file_name = uniqid().'_'. $_FILES['file']['name']; 
          $file_size =$_FILES['file']['size'];
          $file_tmp =$_FILES['file']['tmp_name'];
          $file_type=$_FILES['file']['type'];


          $file_ext = strtolower(explode('.',$_FILES['file']['name'])[1]); 

          $extensions= array("xlsx","xls");

          if(in_array($file_ext,$extensions)=== false){
             $errors[]="extension not allowed, please choose a XLSX or XLS file.";
          }

          if($file_size > 2097152){
             $errors[]='File size must be excately 2 MB';
          }

          if(empty($errors)==true){
             move_uploaded_file($file_tmp,"gestioneLSoc/template/".$file_name);
             echo "Success";
             return $path.$file_name;

          }else{
             print_r($errors);
          }
       }

    }
    
    
    function devicetypeToquery($devicetype){
        //traduce il devicetype scritto nella tabella Project
        //nel device type per fare la query su dati_requisiti
        if(empty($devicetype)) {return $devicetype;}
            
            if((strcasecmp($devicetype, 'Featurephone') == 0)){
                    $devicetype = 'phone';
                }
            elseif ((strcasecmp($devicetype, 'MBB') == 0) or (strcasecmp($devicetype, 'Router') == 0) or (strcasecmp($devicetype, 'Datacard') == 0) ){
            
                $devicetype = 'Router';
            
            }
            elseif ((strcasecmp($devicetype, 'Smartphone') == 0)){
            
                $devicetype = 'Smartphone';
            
            }

            return $devicetype;
        }
        
        
    
    function form_RfiRow($project, $job_role, $rfi, $user_id){
        ?>
<script type="text/javascript" src="https://code.jquery.com/jquery-1.6.2.min.js"></script>
<script>
$(document).ready(function() {
    $("#valore_req_<?php echo $rfi['id']; ?>").blur(function(){

    //var dati = $("#formsoc_<?php #echo $rfi['id']; ?>").serialize(); //recupera tutti i valori del form automaticamente
    var valore_req_<?php echo $rfi['id']; ?> = $("#valore_req_<?php echo $rfi['id']; ?>").val();
    var project_id = <?php echo $project['id']; ?>;
    var id_req = <?php echo $rfi['id']; ?>;
    var user_id = <?php echo $user_id; ?>;

    //form invio dati post ajax

    //questo alert potete levarlo, serve solo per farvi capire come vengono passati i dati
    alert(valore_req_<?php echo $rfi['id']; ?>);

    //invio
    $.ajax({
    type: "POST",
    url: "./classes/formsoc_update.php",
    //Quali dati devo inviare?
    data: "valore_req=" + valore_req_<?php echo $rfi['id']; ?> + "&project_id=" + project_id  + "&id_req=" + id_req +"&user_id=" + user_id,

    dataType: "html",
    success: function(msg)
    {
    alert("Modifica Valore requisito avvenuta con successo");
    $("#risultato").html(msg);
    
    },
    error: function()
    {
    alert("Chiamata fallita Valore Req, si prega di riprovare...");
    }

    });//ajax

    });//bottone click
});
</script>
<script>
$(document).ready(function() {
    $("#nota_<?php echo $rfi['id']; ?>").blur(function(){

    //var dati = $("#formsoc_<?php #echo $rfi['id']; ?>").serialize(); //recupera tutti i valori del form automaticamente
    var nota_<?php echo $rfi['id']; ?> = $("#nota_<?php echo $rfi['id']; ?>").val();
    var project_id = <?php echo $project['id']; ?>;
    var id_req = <?php echo $rfi['id']; ?>;
    var user_id = <?php echo $user_id; ?>;

    //form invio dati post ajax

    //questo alert potete levarlo, serve solo per farvi capire come vengono passati i dati
    alert(nota_<?php echo $rfi['id']; ?>);

    //invio
    $.ajax({
        type: "POST",
        url: "./classes/formsoc_update.php",
        data: "nota=" + nota_<?php echo $rfi['id']; ?> + "&project_id=" + project_id  + "&id_req=" + id_req + "&user_id=" + user_id,
        
        dataType: "html",
        success: function(msg)
        {
        alert("Modifica nota avvenuta con successo");
        $("#risultato").html(msg);

        },
        error: function()
        {
        alert("Chiamata fallita Nota, si prega di riprovare...");
        }
    });//ajax

    });//bottone click
});
</script>
<?php
        
        $area_name = trim($rfi['area_name']); 
        $descrizione_requisito = $rfi['descrizione_requisito'];
        $label = $rfi['label'];
        $note = $rfi['note'];
        $valore_requisito = $rfi['valore_requisito'];  
        $id_usermodify = $rfi['id_usermodify']; 
        $data_modifica = $rfi['data_modifica']; 
        
        $usermodify = $this->get_user_info($id_usermodify)['login'];       
        $info = "Modified by ". $usermodify ." at ".$data_modifica;
        $tobereview_req = $rfi['review'];       
        if($tobereview_req==1){$tbr_check = "checked";}else{$tbr_check = "";}
        
        ////////////////////////////////////////
       //Check requisito Mandatorio
       if($this->is_mandatory_rfi($rfi['id']) && ($job_role < 9)) { 
           
           #if(!empty($valore_requisito) || !empty($note)){
               //$flagrequired = 'required="required" '; 
            #   $flagrequired = 'required="required"'; 
           #}
           #else {
               //mandatory BG color  giallo
               $flagrequired = 'required="required"'; 
           #}

       }
       else {
           //not mandatory BG color grigetto
           //$flagrequired = ' style="background-color:#E0E0E0;"';
           
           $flagrequired = '';
           
       }  
       ///////////////////////////////////////////////
       /////////////////Check BG color
       //////////////////////////////////////////////
       if($rfi['review']==1) {
           //rosella rewiev
           $bg_color = 'style="background-color:#ff9d9d"';                       
       }
       elseif ($rfi['review']!=1 && $this->is_mandatory_rfi($rfi['id'])){
           //giallino mandatorio
           $bg_color = 'style="background-color:#FFFFCC"'; 
       }
       elseif ($rfi['review']!=1 && $this->is_mandatory_rfi($rfi['id'])==False){
           //grigetto
           $bg_color = ''; 
       }
        
        ?>
        <form id="formsoc_<?php echo $rfi['id']; ?>" class="form-horizontal form-label-left" novalidate enctype="multipart/form-data" method="post" action="#" />     
            <input type="hidden" name="pr" value="<?php echo $project['id']; ?>" /> 
            <input type="hidden" name="update_lsoc" value="1" /> 
                       <div class="item form-group">                     
                         <div class="col-md-6 col-sm-6 col-xs-12">
                            <label  for="name">    
                             <?php if($job_role > 6) { ?>    
                             <a title="Modify Requirement" href="index.php?page=gestioneLSoc/gestore_lsoc&funzione=form&cid=<?php echo $rfi['id']; ?>" ><?php echo "[".$rfi['id']."] - ";?><?php echo $label; ?></a> 
                             <?php }
                              elseif($job_role <= 6) { 
                                echo "[".$rfi['id']."] - ".$label; 
                              } ?>
                             </label>  
                             
       <?php //se è un campo select                  
       /////////////Requisito con select
        if ($rfi['opzioni_requisito'] != "") {#echo $obj3['opzioni_requisito'];
            echo "<select id=\"valore_req_".$rfi['id']."\" class=\"form-control\" $flagrequired  $bg_color name=\"valore_req_".$rfi['id']."\"  />";
            $pieces = explode(';', trim($rfi['opzioni_requisito']));
            #echo "<option value=\"$pieces[$i]\"></option>";
            for ($i = 0; $i < count($pieces); $i++) {
                $selected = "";
                if (($pieces[$i] == $rfi['valore_requisito']) && ($pieces[$i] != ""))
                    $selected = "selected";
                #$val_select = "val_select_" . $obj3['id'];
                echo "<option  value=\"$pieces[$i]\"  $selected>$pieces[$i]</option>";
                #echo substr_compare($obj3['opzioni_requisito'], $obj3['valore_requisito'], 1)."<br>".$obj3['valore_requisito']."--".$obj3['opzioni_requisito']."<br>";
            }
            echo "</select>";
            
        } 
        ////////Requisito con textarea
        else {//se è un campo <input text
        ?>  
                             
           <input id="<?php echo "valore_req_".$rfi['id']; ?>" class="form-control col-md-6 col-xs-12" data-validate-length-range="1"    name="<?php echo "valore_req_".$rfi['id']; ?>" placeholder="<?php #echo $rfi['example']; ?>" <?php echo $flagrequired.' '.$bg_color; ?> type="text" title="<?php echo $rfi['example']; ?>" value="<?php echo $valore_requisito; ?>" />
        
           
        <?php  } ?>
          
  
            </div>   
                           
                    <div class="col-md-3 col-sm-6 col-xs-12">  
                       <label  for="name">
                       <?php if($job_role > 6) { ?> 
                       <a title="Modify Example" href="index.php?page=gestioneLSoc/gestore_lsoc&funzione=form&cid=<?php echo $rfi['id']; ?>" >Example</a> 
                       <?php } 
                       elseif($job_role <= 6) { 
                            echo "Example";
                        } ?>
                       </label>

                        <textarea class="form-control" rows="1" 
                                  
                            <?php #if($job_role < 9) { 
                              //disabled for vendor  
                               echo 'disabled="true"';
                            #} ?>          
                                  
                        ><?php echo $rfi['example']; ?></textarea> 
                        
                        </div>              
                           
                        <div class="col-md-3 col-sm-6 col-xs-12">  
                       <label  for="name">Note </span>
                            </label>
                        <textarea class="form-control" rows="1" id="<?php echo "nota_".$rfi['id']; ?>"  name="<?php echo "nota_".$rfi['id']; ?>"  ><?php echo $note; ?></textarea>
                        
                        </div>
                      </div>
                     <div class="form-group">
                                                         
                        <div class="col-md-3 col-md-offset-1">
                                         <input class="col-md-offset-1" title="<?php echo $info; ?>"  type="image" src="images/informazione.jpg" style="align:right; margin-left:20px; height:15px;"/>
                                         <?php if($job_role > 6) { ?>  
                             <input type="checkbox" class="col-md-offset-3"name="tobereview[<?php echo $rfi['id'];?>]" value="1" <?php echo $tbr_check; ?> >To be Reviewed
                                         <?php }?>
                            
                            
                            

                                <?php if($job_role > 6) { 
                             
                              if(empty($rfi['opzioni_requisito'])){ ?>                              
                                <button type="button" class="btn btn-default btn-xs" <?php #echo $disable; ?> data-toggle="modal" data-target="#checktextModal<?php echo $rfi['id'];?>" ><i class="fa fa-edit"></i> Check text</button>
                             <?php } ?>   
<!--Modal Check Text Requirement -->   
                  <div id="checktextModal<?php echo $rfi['id'];?>" class="modal fade bs-example-modal-lg" tabindex="-1" role="dialog" aria-hidden="true">
                     
                    <div class="modal-dialog modal-lg">
                      <div class="modal-content">
                            
                        <div class="modal-header"> 
                          <button type="button" class="close" data-dismiss="modal"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel"><?php echo "[".$rfi['id']."] --- ".$descrizione_requisito;?></h4>
                        </div>
                        <div class="modal-body">
                          <p><?php echo $info;?></p>  
                          <?php
    
                          ?>

                    
                       <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Current Requirement Answer <span class="required"></span>
                        </label>   

                          <textarea class="col-md-6 col-sm-6 col-xs-12" id="req<?php echo $rfi['id'];?>"><?php echo $valore_requisito;?></textarea>

                      </div>     
                          <br><br>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Find <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="find<?php echo $rfi['id'];?>" required="required" class="form-control col-md-7 col-xs-12" name="find">
                        </div>
                          
                      </div>
                      <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">Substitute <span class="required"></span>
                        </label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                          <input type="text" id="substitute<?php echo $rfi['id'];?>" required="required" class="form-control col-md-7 col-xs-12" name="substitute">
                        </div>
                      </div> 
                     <div class="form-group">
                         <center><button type="button" class="btn btn-success" onclick="myFunction_<?php echo $rfi['id'];?>()">Change</button></center>
                        </div>

                          
        <form class="form-horizontal form-label-left" novalidate enctype="multipart/form-data" method="post" action="index.php?sec=gestioneLSoc&pg=form_soc#<?php echo $anchor; ?>" />     
                    <input type="hidden" name="pr" value="<?php echo $project['id']; ?>" /> 
             
                      <div class="form-group">
                      <label class="control-label col-md-3 col-sm-3 col-xs-12" for="first-name">New Requirement Answer <span class="required"></span>
                        </label>  
                          
                          <textarea class="col-md-6 col-sm-6 col-xs-12" id="new<?php echo $rfi['id'];?>" name="newtext" ></textarea>
                      </div> 
                         
                        </div>
<script>
    
    function replaceMulti(haystack, needle, replacement)
    {
        return haystack.split(needle).join(replacement);
    }    
    
        function myFunction_<?php echo $rfi['id'];?>() {
            var x = document.getElementById("find<?php echo $rfi['id'];?>");
            var y = document.getElementById("substitute<?php echo $rfi['id'];?>");
            var text = document.getElementById("req<?php echo $rfi['id'];?>");
            var s = text.value;

            s = replaceMulti(s, x.value,y.value);

            document.getElementById("new<?php echo $rfi['id'];?>").value = s;

        }
</script>      
                        <div class="modal-footer">
                             
                        <center><button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                   
                      <input type="hidden" name="newanswerID" value="<?php echo $rfi['id'];?>" />        
                        
                            <input id="send" class="btn btn-primary" type="submit"  name="submit" value="Save changes" />
                     </form>          
                        </center>
                        </div>

                      </div>
                    </div><div id="risultato"></div>
                      <br>
                  </div>
<!--Close Check Text Requirement modal -->

                            <?php } ?>
        

                        </div>
      
                      </div>
   
   
                 </form>
    <?php             
    }

function rfiComparisonPrint($prj, $rfilist) {
    ?>
              <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo "Requirements Comparison"; ?><small><?php #echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                        <li><!--<a target=\"_blank\" onclick="exportTableToExcel('datatable-responsive', 'filename')" href="#"><img  src="excel-icon.png" alt="Export Comparison" /></a>--></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                        <thead>
                            <tr>
                           <th>n°</th><th>Requirement Description</th>
             
    <?php
        $string = '';
        

        $rfiPrj = array();
        for ($i = 0; $i < count($prj); $i++) {
            $prj_brand = $this->get_projects($prj[$i])['vendor'];
            $prj_model = $this->get_projects($prj[$i])['model'];
            $prj_id = $this->get_projects($prj[$i])['id'];
            $rfiPrj[$i] = $this->get_soc_values($prj[$i]);
            $string .= "<th>" . $prj_brand . " " . $prj_model . "</th>";
        }
        $string .= "</tr></thead><tbody>";
        #echo'<pre>';      
        #print_r($rfilist);
        #print_r($rfiPrj);
        #echo'</pre>';
        $count = 1;

        for ($i = 0; $i < count($rfilist); $i++) {

            $string .= "<tr>";
            $req=$this->getRequirementInfoById($rfilist[$i]);

            $descrizione=$req['descrizione_requisito'];
            
            $string .= "<td>$count</td><td>$descrizione</td>";

            for ($j = 0; $j < count($rfiPrj); $j++) {
                $flag=false;
                foreach ($rfiPrj[$j] as $key => $value) {
                    #print_r($value);                   
                    if($value['id_requisito'] == $rfilist[$i]) {
                        $flag=true;
                        $string .= "<td>" . $value['valore_requisito'] . "</td>";                         
                    }
                }
                //se per uno specifico progetto ed uno specifico ID_requisito non esiste nessun record 
                if($flag==false){
                     $string .= "<td></td>";
                }
            }


            $string .= "</tr>";
            $count++;
            #}
        }
        $string .= "</tbody></table>";
        $string .= "</div></div></div>";


        return $string;
    }
    
    
function rfiComparisonPrint2($prj, $rfilist) {
    ?>
              <div class="x_panel" style='overflow-x:scroll;overflow-y:auto;width:100%;'>
                <div class="x_title">
                    <h2><?php echo "Requirements Comparison"; ?><small><?php #echo $sottotitolo; ?></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                        <li><!--<a target=\"_blank\" onclick="exportTableToExcel('datatable-responsive', 'filename')" href="#"><img  src="excel-icon.png" alt="Export Comparison" /></a>--></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                      
                    <!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <table id="datatable-responsive" cellspacing="0" width="100%">-->
                    <table id="datatable-responsive" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                           <th>n°</th><th>Requirement Description</th>
             
    <?php
        $string = '';
        

        $rfiPrj = array();
        for ($i = 0; $i < count($prj); $i++) {
            $prj_brand = $this->get_projects($prj[$i])['vendor'];
            $prj_model = $this->get_projects($prj[$i])['model'];
            $prj_id[$i] = $this->get_projects($prj[$i])['id'];
            $rfiPrj[$i] = $this->getAllRfiValueByPrId($prj_id[$i]);
            $string .= "<th>" . $prj_brand . " " . $prj_model . "</th>";
        }
        $string .= "</tr></thead><tbody>";
        #echo'<pre>';      
        #print_r($rfilist);
        #print_r($rfiPrj);
        #echo'</pre>';
        $count = 1;
        $numero_elementi=0;
        for ($i = 0; $i < count($rfilist); $i++) {
            
            $string .= "<tr>";
            $req=$this->getRequirementInfoById($rfilist[$i]);
            
            //////workaround 5G EN-DC
            if(strcasecmp($req['sheet_name'],'EN-DC List') == 0 ){                                
                        $descrizione = '5G EN-DC: DL - '.$req['descrizione_requisito'].' UL - '.$req['devicetype'];
                 }
            else {
                        $descrizione=$req['descrizione_requisito'];
                 }
            
            // $descrizione=$req['descrizione_requisito'];
            
            $string .= "<td>$count</td><td>$descrizione</td>";

            for ($j = 0; $j < count($prj); $j++) {
                $flag=false;
                if(isset($rfiPrj[$j][$prj_id[$j]][$rfilist[$i]])){
                                            $flag=true;
                        $string .= "<td>" . $rfiPrj[$j][$prj_id[$j]][$rfilist[$i]]['valore_requisito'] . "</td>"; 
                        $numero_elementi++;
                }
                else{
                     $string .= "<td></td>";
                     $numero_elementi++;
                }
                /*
                foreach ($rfiPrj[$j][$prj_id[$j]] as $key => $value) {
                    #print_r($value);                   
                    if($value['id_requisito'] == $rfilist[$i]) {
                        $flag=true;
                        $string .= "<td>" . $value['valore_requisito'] . "</td>"; 
                        $numero_elementi++;
                    }
                }
                //se per uno specifico progetto ed uno specifico ID_requisito non esiste nessun record 
                if($flag==false){
                     $string .= "<td></td>";
                     $numero_elementi++;
                }
                 * 
                 */
            }


            $string .= "</tr>";
            $count++;
            #}
        }
        $string .= "</tbody></table>";
        $string .= "</div></div></div>";
        #echo"righe ".count($rfilist);
        #echo"colonne ".count($rfiPrj);
        #echo"elementi stampati ".$numero_elementi;

        return $string;
    }    
  
function rfiComparisonPrintTest($prj, $rfilist) {
    ?>
              <div class="x_panel" style='overflow-x:scroll;overflow-y:auto;width:100%;'>
                <div class="x_title">
                    <h2>UE Capabilities vs Requirements Comparison<small></small></h2>
                    <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                        <li><!--<a target=\"_blank\" onclick="exportTableToExcel('datatable-responsive', 'filename')" href="#"><img  src="excel-icon.png" alt="Export Comparison" /></a>--></li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                      
                    <!--<table id="datatable-responsive" class="table table-striped table-bordered dt-responsive nowrap" cellspacing="0" width="100%">
                    <table id="datatable-responsive" cellspacing="0" width="100%">-->
                    <table id="datatable-responsive" class="table table-striped table-bordered" width="100%">
                        <thead>
                            <tr>
                           <th>n°</th><th>Requirement Description</th>
             
    <?php
        $string = '';
        

        $rfiPrj = array();
        for ($i = 0; $i < count($prj); $i++) {
            $prj_brand = $this->get_projects($prj[$i])['vendor'];
            $prj_model = $this->get_projects($prj[$i])['model'];
            $prj_id[$i] = $this->get_projects($prj[$i])['id'];
            $rfiPrj[$i] = $this->getAllRfiValueAndUeCapByPrId($prj_id[$i]);
            $string .= "<th>" . $prj_brand . " " . $prj_model . " Vendor value</th><th>" . $prj_brand . " " . $prj_model . " Decoder value</th>";
        }
        $string .= "</tr></thead><tbody>";
        #echo'<pre>';      
        #print_r($rfilist);
        #print_r($rfiPrj);
        #echo'</pre>';
        $count = 1;
        $numero_elementi=0;
        for ($i = 0; $i < count($rfilist); $i++) {
            
            $string .= "<tr>";
            $req=$this->getRequirementInfoById($rfilist[$i]);
            
            //////workaround 5G EN-DC
            if(strcasecmp($req['sheet_name'],'EN-DC List') == 0 ){                                
                        $descrizione = '5G EN-DC: DL - '.$req['descrizione_requisito'].' UL - '.$req['devicetype'];
                 }
            else {
                        $descrizione=$req['descrizione_requisito'];
                 }
            
            // $descrizione=$req['descrizione_requisito'];
            
            $string .= "<td>$count</td><td>$descrizione</td>";

            for ($j = 0; $j < count($prj); $j++) {
                $flag=false;
                if(isset($rfiPrj[$j][$prj_id[$j]][$rfilist[$i]])){
                        $flag=true;
                        $string .= "<td>" . $rfiPrj[$j][$prj_id[$j]][$rfilist[$i]]['valore_requisito'] . "</td>"; 
                        $string .= "<td>" . $rfiPrj[$j][$prj_id[$j]][$rfilist[$i]]['history'] . "</td>"; 
                        $numero_elementi++;
                }
                else{
                     $string .= "<td></td><td></td>";
                     $numero_elementi++;
                }

            }


            $string .= "</tr>";
            $count++;
            #}
        }
        $string .= "</tbody></table>";
        $string .= "</div></div></div>";
        #echo"righe ".count($rfilist);
        #echo"colonne ".count($rfiPrj);
        #echo"elementi stampati ".$numero_elementi;

        return $string;
    } 
    
  function rfiComparisonExcel($prj, $rfilist) {

    
    $rfiPrj = array();
        for ($i = 0; $i < count($prj); $i++) {
            $prj_brand[$i] = $this->get_projects($prj[$i])['vendor'];
            $prj_model[$i] = $this->get_projects($prj[$i])['model'];
            $prj_id[$i]= $this->get_projects($prj[$i])['id'];
            $rfiPrj[$i] = $this->get_soc_values($prj[$i]);
            }

        $count = 1;

        for ($i = 0; $i < count($rfilist); $i++) {

            $string .= "<tr>";
            $req=$this->getRequirementInfoById($rfilist[$i]);

            $descrizione=$req['descrizione_requisito'];
            
            $string .= "<td>$count</td><td>$descrizione</td>";

            for ($j = 0; $j < count($rfiPrj); $j++) {
                $flag=false;
                foreach ($rfiPrj[$j] as $key => $value) {
                    #print_r($value);                   
                    if($value['id_requisito'] == $rfilist[$i]) {
                        $flag=true;
                        $string .= "<td>" . $value['valore_requisito'] . "</td>";                         
                    }
                }
                //se per uno specifico progetto ed uno specifico ID_requisito non esiste nessun record 
                if($flag==false){
                     $string .= "<td></td>";
                }
            }


            $string .= "</tr>";
            $count++;
            #}
        }
        $string .= "</tbody></table>";
        $string .= "</div></div></div></div></div>";

        $objPHPExcel = new PHPExcel();
$objPHPExcel->getProperties()->setCreator("H3G")
        ->setLastModifiedBy("TH")
        ->setTitle("Office 2007 XLSX Test Document")
        ->setCategory("LSoc");
$objWorksheet = $objPHPExcel->setActiveSheetIndex(0);

$objPHPExcel->getActiveSheet()->getColumnDimension('A')->setWidth("25");
$objPHPExcel->getActiveSheet()->getColumnDimension('B')->setWidth("35");
$objPHPExcel->getActiveSheet()->getColumnDimension('C')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('D')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('E')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('F')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('G')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('H')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('I')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('J')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('K')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('L')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('M')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('N')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('O')->setWidth("30");
$objPHPExcel->getActiveSheet()->getColumnDimension('P')->setWidth("30");

$objWorksheet->setCellValue('A1', "ID");
$objWorksheet->setCellValue('B1', "Description");

$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFill()
            ->setFillType(PHPExcel_Style_Fill::FILL_SOLID)
            ->getStartColor()->setARGB('00BFBFBF');
$objPHPExcel->getActiveSheet()->getStyle('A1:S1')->getFont()->setBold(true);

$objPHPExcel->getActiveSheet()->getStyle('A2:Z300')
->getAlignment()->setWrapText(true);
$objPHPExcel->getActiveSheet()->getStyle('A2:Z300')
->getAlignment()->setWrapText(true);





    $col = 2;
    for ($i = 0; $i < count($prj); $i++)
        $objWorksheet->setCellValueByColumnAndRow($col++, 1, $telefoni[$i]);


    $riga = 2;
    
    $count = 1;

        for ($i = 0; $i < count($rfilist); $i++) {


            $req=$this->getRequirementInfoById($rfilist[$i]);

            $descrizione=$req['descrizione_requisito'];
            
            $string .= "<td>$count</td><td>$descrizione</td>";
          $objWorksheet->setCellValueByColumnAndRow(0, $riga, $req['id']);  
          $objWorksheet->setCellValueByColumnAndRow(1, $riga, $descrizione);

            for ($j = 0; $j < count($rfiPrj); $j++) {
                $flag=false;
                foreach ($rfiPrj[$j] as $key => $value) {
                    #print_r($value);                   
                    if($value['id_requisito'] == $rfilist[$i]) {
                        $flag=true;
                        #$string .= "<td>" . $value['valore_requisito'] . "</td>"; 
                        $objWorksheet->setCellValueByColumnAndRow($col, $riga, $value['valore_requisito'] );
                    }
                }
                //se per uno specifico progetto ed uno specifico ID_requisito non esiste nessun record 
                if($flag==false){
                     #$string .= "<td></td>";
                     $objWorksheet->setCellValueByColumnAndRow($col, $riga, ' ');
                }
                $col++;
            }


            #$string .= "</tr>";
            $count++;
            $riga++;
            #}
        }

    $today = date("y_m_d");
    // Redirect output to a client’s web browser (Excel2007)
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="confronto_LSoC_'.$filtro.'-' . $today . '.xls"');
    header('Cache-Control: max-age=0');
    $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel5');
    $objWriter->save('php://output');
    exit;



    }

  
  function enabledDisabledForm($job_role, $project_statusId){
      //possono modificare la SOC
      if(!($job_role <= 6 and $project_statusId!=2)) {           
          $output = '';
      }
      else {
            $output = ' disabled ';
      }  
      
      //I PM non possono modificare la SOC
      if($job_role == 7){
          $output = ' disabled ';
      }
      
      return $output;
            
  } 
  
  
   //Match all Redquirements Id in 5G UE-Capability Feature 
   function cap5gToReqIdList($fiveG_cap){    
        //print_r(search_feature($datalog, '5G UE-Capability'));
        //$fiveG_cap = search_feature($datalog, '5G UE-Capability'); 
        //print_r($fiveG_cap);
        $conn = connect_db_li();
        $DL = $this->search_key_InFeature($fiveG_cap, 'DL');
        $UL = $this->search_key_InFeature($fiveG_cap, 'UL');
        $NRDL = $this->search_key_InFeature($fiveG_cap, 'NRDL');
        $NRUL = $this->search_key_InFeature($fiveG_cap, 'NRUL');
        
        //$row = '';        
        foreach ($DL as $key=>$key2) {
            $sql = "SELECT * FROM `dati_requisiti` WHERE `sheet_name`='EN-DC List' ";
            //$row = ''.$key;
            $dllength = 'DC';
            $ullength = 'DC';
            //DL loop
            foreach ($key2 as $key3=>$dlvalue) {
                //echo''.$UL[$key][$key2];
                //$row .='  '.$dlvalue;
                $dllength .= '_'.$dlvalue;
                $sql .= " and `descrizione_requisito` like '%$dlvalue%' ";
                
            }
            //NRDL loop
            foreach ($NRDL[$key] as $key3=>$nrdlvalue) {
                //echo''.$UL[$key][$key2];
                //$row .='  '.$nrdlvalue;
                $dllength .= '_'.$nrdlvalue;
                $sql .= " and `descrizione_requisito` like '%$nrdlvalue%' ";
                
            } 
            //UL loop
            foreach ($UL[$key] as $key3=>$ulvalue) {
                //echo''.$UL[$key][$key2];
                //$row .='  '.$ulvalue;
                $ullength .= '_'.$ulvalue;
                $sql .= " and `devicetype` like '%$ulvalue%'";
                
            }
            //NRUL loop
            foreach ($NRUL[$key] as $key3=>$nrulvalue) {
                //echo''.$UL[$key][$key2];
                //$row .='  '.$nrulvalue;
                $ullength .= '_'.$nrulvalue;
                $sql .= " and `devicetype` like '%$nrulvalue%'";
                
            }
            
            $sql .= " and LENGTH(trim(`descrizione_requisito`))=".strlen($dllength)." and LENGTH(trim(`devicetype`))=".strlen($ullength);             
            //echo '<br>'.$sql;                        
            $result = mysqli_query($conn,$sql) or die($sql . " - " . mysqli_error($conn));
            $outdata[] = mysqli_fetch_assoc($result);                       
            
        }
        return $outdata;
  }
  
   function search_feature($haystack, $needle, $offset=0) {
        $flag = false;
        foreach($haystack as $key=>$value) {
            if(stripos($value['feature'], $needle, $offset)!==false){
                    return $haystack[$key];
            }
            
        }        
        return $flag;
    }

    function search_key_InFeature($haystack, $needle, $offset=0) {
            $flag = false;
            foreach($haystack as $key=>$value) {
                if(stripos($key, $needle, $offset)!==false){
                        return $value;
                }

            }        
            return $flag;
    }
    
    
    function isJson($string) {
        json_decode($string);
        return (json_last_error() == JSON_ERROR_NONE);
    }
    
    
    function jsonFileImport($filename) {      
        $json = file_get_contents($filename);        
        if($this->isJson($json)){
            echo $json;
            
        }      
    }
    
}
