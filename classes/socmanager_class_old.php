<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of soc_manager
 *
 * @author itoto
 */

include_once 'db_config.php';
include_once("./classes/access_user/access_user_class.php");
include_once './classes/PHPExcel.php';


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
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
       $obj = mysqli_fetch_assoc($result); 
       
       return $obj;      
    }

    
    function delete_projects($id){
       $query = "DELETE FROM `projects` WHERE `id`='$id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
       
       return $result;
       
    }
    
    function delete_rfi_list($id){      
       $query = "DELETE FROM `dati_valori_requisiti` WHERE `id_project`='$id' ";
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
       
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
       $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
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
    
    
    function get_soc($project, $filtro_mdm=null){
        //filtro requisiti MDM Only
        if($filtro_mdm==1){
            $and_query = ' and description_mdm NOT LIKE \'nomap\' ';
        }
        else {$and_query='';}
        
        if($project['devicetype']=='Featurephone'){
            $query = "SELECT `temp` . * , `dati_requisiti` . *
            FROM `dati_requisiti`
            left JOIN (
            SELECT nome_tel,valore_requisito,id_requisito,note,data_modifica,id_usermodify,review
            FROM `dati_valori_requisiti`
            WHERE id_project = '".$project['id']."'
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.stato=1 and `dati_requisiti`.`lista_req` LIKE '%phone%' $and_query order by `dati_requisiti`.ordine, `dati_requisiti`.id ";

            
        }
        //valido per Smartphone e Tablet
        else{    

            $query = "SELECT `temp` . * , `dati_requisiti` . *
            FROM `dati_requisiti`
            left JOIN (
            SELECT nome_tel,valore_requisito,id_requisito,note,data_modifica,id_usermodify,review
            FROM `dati_valori_requisiti`
            WHERE id_project = '".$project['id']."'
            ) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.stato=1 and `dati_requisiti`.`lista_req` LIKE '%".$project['devicetype']."%' $and_query order by `dati_requisiti`.ordine, `dati_requisiti`.id ";


        }
     
        $result = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        
        return $result;
    
    }
    
    
    function get_soc_values($id_project){     
        $query = "SELECT * FROM `dati_valori_requisiti` WHERE id_project = '".$id_project."' ";
     
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        
        $rfi_values = array();
        
        while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $rfi_values[] = $row;
            
        }       
        return $rfi_values;
    }
    
    
    function get_statusNameByLevel($level) {
        $query = "SELECT * FROM `status` WHERE `group_level`='".$level."' ";
     
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        
        $output = array();
                while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $output = $row;
            
        }       
        return $output['name'];
       
    }
    
    function get_statusGroupById($id) {
        $query = "SELECT * FROM `status` WHERE `id`='".$id."' ";
     
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysql_error());
        
        $output = array();
                while ($row = $results->fetch_array(MYSQLI_ASSOC)) {  
            
           $output = $row;
            
        }       
        return $output['name'];
       
    }
           
    
    function update_rfi($rfi_value , $nota_value, $project, $user_id, $tobereview){
        
        $id_project = $project['id'];
        $data_update = date("Y-m-d");
      
        
            foreach ($rfi_value  as $id => $s) {       
            
                $valore_req = mysql_real_escape_string(trim($rfi_value [$id]));
                $nota_req = mysql_real_escape_string(trim($nota_value[$id]));
                
                if(isset($tobereview[$id])){
                    $tobereview_req = $tobereview[$id];
                }
                else {
                        $tobereview_req = 0;
                }   
                

                $query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                $result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysql_error());
                $obj_check = mysqli_fetch_array($result_check);

                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`, `data_modifica`, `id_usermodify`, `review` ) "
                            . "VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project . "',NOW(),'" . $user_id . "','" . $tobereview_req. " ')";
                    #echo "insert ".$query5."<br>";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' ,`id_usermodify`='" . $user_id . "', `data_modifica`=NOW(),`review`='" . $tobereview_req . "'  WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project . "' )";
                    #echo "update ".$query5."<br>";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
                    #echo 'Update SOC '. $query5.'<br>';
                }
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
                     
                $valore_req = mysql_real_escape_string(trim($rfi_values [$id]['valore_requisito']));
                $nota_req = mysql_real_escape_string(trim($rfi_values[$id]['note']));

                #$query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                #$result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysql_error());
                #$obj_check = mysqli_fetch_array($result_check);
                
            
                $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) "
                        . "VALUES (NULL,'" . $rfi_values [$id]['id_requisito'] . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                
                #echo'<pre>';
                #echo 'query insert '.$query5.'<br>';
                #echo'</pre>';
                mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
                
                
            /*    
                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project_to . "' and `nome_tel` = '" . $project['model'] . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
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
                
                $valore_req = mysql_real_escape_string(trim($rfi_values [$id]['valore_requisito']));
                $nota_req = mysql_real_escape_string(trim($rfi_values[$id]['note']));

                #$query_check = "SELECT  `id_requisito`, COUNT(  `id_requisito` ) AS Num FROM dati_valori_requisiti WHERE  id_project='" . $project['id'] . "' and id_requisito='" . $id . "'";
                #$result_check = mysqli_query($this->mysqli,$query_check) or die($query_check . " - " . mysql_error());
                #$obj_check = mysqli_fetch_array($result_check);
                
            
                $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) "
                        . "VALUES (NULL,'" . $rfi_values [$id]['id_requisito'] . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                
                #echo'<pre>';
                #echo 'query insert '.$query5.'<br>';
                #echo'</pre>';
                mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
                
                
            /*    
                if (($obj_check['Num'] == 0)) {
                    #echo 'Numero 0';
                    $query5 = "INSERT INTO `dati_valori_requisiti`(`id`, `id_requisito`, `nome_tel`, `valore_requisito`, `data_inserimento`, `note`, `data_accettazione`, `market`, `vendor`, `devicetype`, `id_project`) VALUES (NULL,'" . $id . "','" . $project['model'] . "','" . $valore_req . "','" . $data_update . "','" . $nota_req . "','" . $project['data_accettazione']. "','" . $project['market'] . "','" . $project['vendor'] . "','" . $project['devicetype'] . "','" . $id_project_to . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
                } else {                
                    $query5 = "UPDATE `dati_valori_requisiti` SET `valore_requisito` = '" . $valore_req . "' ,`data_inserimento`='" . $data_update . "',`note`='" . $nota_req . "' WHERE ( `id_requisito`='" . $id . "' and `id_project` = '" . $id_project_to . "' and `nome_tel` = '" . $project['model'] . "')";
                    mysqli_query($this->mysqli,$query5) or die($query5 . " - " . mysql_error());
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
        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
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
        
        
        $q1 = "SELECT COUNT(*) FROM `dati_requisiti` WHERE `stato`=1 AND (`mandatoryoptional`='M' OR `summary`=1) AND `lista_req` LIKE '%" . $devicetype . "%' ";
        
        $q1 = mysqli_query($this->mysqli, $q1) or die(mysql_error());
        $r1 = mysqli_fetch_assoc($q1);
        $tot_mand = $r1['tot'];
        
        return $tot_mand;
        
    }
    
    
    function get_tot_mandatory($devicetype=null) {
        
        if(empty($devicetype)){
            $where_cond = "1";
        }
        else {
            if($devicetype=='Fetaurephone'){$devicetype = 'phone';}
            $where_cond = "lista_req  like '%$devicetype%'";
        }

        $sql = "SELECT count(*) as totale FROM `dati_requisiti` WHERE (`mandatoryoptional`='M' or `summary`=1) and `stato`=1 and $where_cond";
        $query = mysqli_query($this->mysqli, $sql) or die(mysql_error());
        $r1 = mysqli_fetch_assoc($query);
        $tot_mand = $r1['totale'];
        
        return $tot_mand;
        
    }
    
    function is_mandatory_rfi($id) {       
        $sql = "SELECT * FROM `dati_requisiti` WHERE `id`=$id";
        $q1 = mysqli_query($this->mysqli, $sql) or die(mysql_error());
        $res = mysqli_fetch_assoc($q1);
        
        if($res['mandatoryoptional']=='M' || $res['summary']==1){
           return TRUE;
        }
        else return FALSE;      
    }
    
    
    
    //Return Tot value of mandatory rfi Empty
    function get_mandatoryEmpty_rfi($id_project) {
        
        $project = $this->get_projects($id_project);                
        $devicetype = $project['devicetype'];         
        if($project['devicetype']=='Fetaurephone'){$devicetype = 'phone';}
        
        // query per totale mandatory vuoti        
        $q3 = "SELECT `temp` . * , `dati_requisiti` . *, count(*) as tot 
	FROM `dati_requisiti`
	left JOIN (
	SELECT nome_tel,valore_requisito,id_requisito,note
	FROM `dati_valori_requisiti`
	WHERE id_project = '" . $project['id'] . "'
	) AS temp ON `temp`.`id_requisito` = `dati_requisiti`.`id` WHERE  `dati_requisiti`.`stato`=1 AND `dati_requisiti`.`lista_req` LIKE '%" . $devicetype . "%' AND  (`dati_requisiti`.`summary`=1 OR `dati_requisiti`.`mandatoryoptional`='M')   AND ((`valore_requisito` = '' OR `valore_requisito` IS NULL) AND (`note` = '' OR `note` IS NULL))";    

        $q3 = mysqli_query($this->mysqli, $q3) or die(mysql_error());
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
        $tot_mand_empty = $this->get_mandatoryEmpty_rfi($id_project);
        
        $tot_mand_not_empty = $tot_mand - $tot_mand_empty;
        
        $progress = round(($tot_mand_not_empty / $tot_mand)*100);        
        
        $q_update = "Update projects set progress='".$progress."' WHERE id='".$id_project."'";
        if(mysqli_query($this->mysqli, $q_update)){
                    #echo 'id_project  '.$id_project.'<br>';
                    #echo 'Vuoti  '.$tot_mand_empty.'<br>';
                    #echo 'Totale '.$tot_mand.'<br>';
                    #echo 'Progress '.$progress.'<br>';         
            //percentuale progress bar
            return $progress;

        }
        else { return mysql_error();}     
        
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
        else { return mysql_error();}       
    }
    
    
    function close_project($id_project) {

        $project = $this->get_projects($id_project);
        
        $q_update = "Update projects set status_id=3 Where id='".$id_project."'";
        if(mysqli_query($this->mysqli, $q_update)){        
            //percentuale progress bar
            return TRUE;

        }
        else { return mysql_error();}
        
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
    
    
    function get_projects_list($user_id=null) {
        if($this->is_user_vendor($user_id)){
            $vendor = $this->get_user_info($user_id)['vendor'];
            #$sql = "SELECT * FROM `projects` WHERE vendor like '%$vendor%' and status_id=2 order by `data_inserimento` desc";      
            
            $sql = "SELECT * FROM `projects` WHERE vendor like '%$vendor%'  order by `data_inserimento` desc";            
        }
        else {           
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
    
    
    function is_user_vendor($user_id){
        //job_roles==1 Vendor User
        if($this->get_user_info($user_id)['job_roles_id']==1){
            return TRUE;
        }      
        return FALSE;       
    }
    
    function is_user_eng($user_id){
        //job_roles!=1 NO Vendor User
        if($this->get_user_info($user_id)['job_roles_id']==2){
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
#require_once ("./classes/Class_lsoc.php");
        require_once './Excel/reader.php';

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
            $riga++;

            $worksheet = $objPHPExcel_reader->getSheet($i);
            $title_sheet = $worksheet->getTitle();

            foreach ($worksheet->getRowIterator() as $row) {

                $id_req = $worksheet->getCellByColumnAndRow(0, $row->getRowIndex())->getValue();
                $description = mysql_real_escape_string($worksheet->getCellByColumnAndRow(1, $row->getRowIndex())->getValue());
                $valore_req = mysql_real_escape_string($worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue());
                $nota_req = mysql_real_escape_string($worksheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue());
                
                #echo $id_req.'<br>';
                
                if ($description == "") {
                    $riga++;
                } elseif (!empty($valore_req) || !empty($nota_req) && $riga>1) {
                
                                    
                    $answers[$id_req] = $valore_req;
                    $notes[$id_req] = $nota_req;
                    $tobereview[$id_req] = 0;
                    $conto++;
                    $riga++;
                
                    #$apstatus[] = mysql_real_escape_string($worksheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue());


                    #$label = mysql_real_escape_string($worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue());
                    #$mand_opt = $worksheet->getCellByColumnAndRow(2, $row->getRowIndex())->getValue();
                    #$devicetype  = $worksheet->getCellByColumnAndRow(3, $row->getRowIndex())->getValue();
                    #$devicetype  = "CommonReq";
                    #$tipo_entry = $worksheet->getCellByColumnAndRow(6, $row->getRowIndex())->getValue();
                    #$options_validation = $worksheet->getCellByColumnAndRow(4, $row->getRowIndex())->getValue();
                    #$options = str_replace("\"", "", str_replace(",", ";", $options_validation));

                    #$label = $worksheet->getCellByColumnAndRow(7, $row->getRowIndex())->getValue();
                    #$summary = $worksheet->getCellByColumnAndRow(9, $row->getRowIndex())->getValue();
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
        $this->update_rfi($answers, $notes, $project, $user_id, $tobereview);
        echo "<br><p><h3>Insert $conto RFI values and/or notes </h3></p>";
        #echo "<p><h3>Requisiti modificati $numero_modifiche</h3></p>";
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
            //	$result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
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
                    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
                    $numero_inserimenti++;
                } else if (($data->sheets[$sheet]['cells'][$i][4] == "Modify")) {

                    $query4 = "UPDATE  `socmanager`.`dati_requisiti` SET  `descrizione_requisito` =  '" . $data->sheets[$sheet]['cells'][$i][2] . "',
							`stato` =  '" . $data->sheets[$sheet]['cells'][$i][5] . "',
									`data` =  '" . $data->sheets[$sheet]['cells'][$i][6] . "',
											`mandatoryoptional` =  '" . $data->sheets[$sheet]['cells'][$i][3] . "' WHERE  `dati_requisiti`.`nome_requisito` =" . $data->sheets[$sheet]['cells'][$i][1] . ";
													);";
                    $result4 = mysqli_query($db_link,$query4) or die($query4 . " - " . mysql_error());
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
            
            return true;
        }
        else {
            return true;
            
           
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


}
