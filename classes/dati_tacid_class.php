<?php

/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
include_once './db_config.php';
include_once './classes/socmanager_class.php';

class dati_tacid_class extends socmanager   {

    //put your code here
    var $mysqli;
    var $months_list;

    function __construct() {
        $mysqli = $this->connect_dbli();
        $this->months_list = $this->get_months_table();
    }

    function connect_dbli() {
        $this->mysqli = new mysqli(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME);
        if ($this->mysqli->connect_errno) {
            printf("Connect failed: %s\n", $this->mysqli->connect_error);
            exit();
        }
//echo DB_SERVER." - ". DB_USER." - ". DB_PASSWORD." - ". DB_NAME;
    }

    function get_classe_throughput() {
        $query = "SELECT  `classe_throughput` FROM  `".TABLE_TACID."` GROUP BY  `classe_throughput` ";
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['classe_throughput']] = $row['classe_throughput'];
            }
            return $risultato;
        } else
            return array();
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

    function get_lista_tabelle($condizione = "") {
        $query = "select nome_tabella,nome_visualizzato from `$this->months_list`  $condizione order by ordine asc";
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {

                $risultato[$row['nome_tabella']] = $row['nome_visualizzato'];
            }
            return $risultato;
        } else
            return array();
    }

    function ultimo_mese() {
        $query = "select * from `$this->months_list` order by ordine desc";
        if ($result = mysqli_query($this->mysqli, $query)) {
            $obj = mysqli_fetch_assoc($result);
            $risultato = $obj['nome_tabella'];
            return $risultato;
        } else
            return array();
    }
    
    function ultimo_mese_tre() {
        $query = "select * from lista_tabelle order by ordine desc";
        if ($result = mysqli_query($this->mysqli, $query)) {
            $obj = mysqli_fetch_assoc($result);
            $risultato = $obj['nome_tabella'];
            return $risultato;
        } else
            return array();
    }
    
    function ultimo_mese_wind() {
        $query = "select * from wind_mesi order by ordine desc";
        if ($result = mysqli_query($this->mysqli, $query)) {
            $obj = mysqli_fetch_assoc($result);
            $risultato = $obj['nome_tabella'];
            return $risultato;
        } else
            return array();
    }
    
    


    
    function getDeviceType() {
      $query = "select name FROM devicetypes";
        //echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['name']] = $row['name'];
            }
            return $risultato;
        } else
            return array();
    }
    
    
    function getProjectDeviceType() {
      $query = "SELECT DISTINCT `devicetype` FROM `projects`";
        //echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['devicetype']] = $row['devicetype'];
            }
            return $risultato;
        } else
            return 'Error';
    }
    

    function get_lista_device($paramentro_di_gruppo, $having_query, $condizione_tipo_terminale) {
        if ($_SESSION['operator'] == '3')  {
            $tac_counter = 'numero_S';
            $mese = $this->ultimo_mese();
        }      
        if ($_SESSION['operator'] == 'wind')  {
            $tac_counter = 'Count_IMEI';
            $mese = $this->ultimo_mese();
            $mese = $this->windtable_net($mese);
        }
        
        $query = "select * from(select sum($tac_counter) as numero_device, ".TABLE_TACID.".Modello,classe_throughput ,".TABLE_TACID.".Tecnologia ,".TABLE_TACID.".Marca,".TABLE_TACID.".OS,".TABLE_TACID.".Tipo, Tac1
            from " . $mese . " "
                . "inner join ".TABLE_TACID." on Tac1=".TABLE_TACID.".TacId  $condizione_tipo_terminale "
                . "group by ".TABLE_TACID.".Marca , $paramentro_di_gruppo $having_query) as lista_device ";
        //echo $query;
        $risultato = array();
        $marca = "";

        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['Modello']] = $row['Modello'];
            }
            return $risultato;
        } else
            return array();
    }

      
    
    function get_lista_device_group_by_marca($paramentro_di_gruppo, $having_query, $condizione_tipo_terminale) {
        if ($_SESSION['operator'] == '3')  {
            $tac_counter = 'numero_S';
            $mese = $this->ultimo_mese();
        }      
        if ($_SESSION['operator'] == 'wind')  {
            $tac_counter = 'Count_IMEI';
            $mese = $this->ultimo_mese();
            $mese = $this->windtable_net($mese);
        }
        $query = "select * from(select sum($tac_counter) as numero_device, ". TABLE_TACID.".Modello, classe_throughput ,". TABLE_TACID.".Tecnologia ,". TABLE_TACID.".Marca,". TABLE_TACID.".OS,". TABLE_TACID.".Tipo, Tac1
            from " . $mese . " "
                . "inner join ". TABLE_TACID." on Tac1=". TABLE_TACID.".TacId  $condizione_tipo_terminale "
                . "group by ". TABLE_TACID.".Marca , $paramentro_di_gruppo $having_query) as lista_device ";
        
        #echo $query;
        $risultato = array();
        $modello = array();
        $marca = "";
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($marca == strtoupper($row['Marca']))
                    $modello[] = $row['Modello'];
                else {
                    if (count($modello) > 0) {
                        $risultato[$marca] = $modello;
                    }
                    $marca = strtoupper($row['Marca']);

                    $modello = array();
                    $modello[] = $row['Modello'];
                }
            }
            $risultato[$marca] = $modello;
            return $risultato;
        } else
            return array();
    }
    
    function get_lista_tariffa($condizione_tipo_terminale) {        
        
        $query = "select numero_device,Piano_Tariffario from(select sum(numero_S) as numero_device, ".TABLE_TACID.".Modello,classe_throughput ,Piano_Tariffario,".TABLE_TACID.".Tecnologia ,".TABLE_TACID.".Marca,".TABLE_TACID.".OS,".TABLE_TACID.".Tipo, Tac1
            from " . $this->ultimo_mese() . "_traffico "
                . "inner join ".TABLE_TACID." on Tac1=".TABLE_TACID.".TacId  $condizione_tipo_terminale "
                . "group by Piano_Tariffario ) as lista_tariffa order by numero_device desc";
        //echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['Piano_Tariffario']] = $row['Piano_Tariffario'];
            }
            return $risultato;
        } else
            return array();
    }

    function get_lista_marca($condizione_tipo_terminale = "") {

        if ($_SESSION['operator'] == '3')  {
            $tac_counter = 'numero_S';
            $query = "select numero_device,Marca from(select sum($tac_counter) as numero_device, ".TABLE_TACID.".Modello,classe_throughput ,Piano_Tariffario,".TABLE_TACID.".Tecnologia ,".TABLE_TACID.".Marca,".TABLE_TACID.".OS,".TABLE_TACID.".Tipo, Tac1
            from " . $this->ultimo_mese() . "_traffico "
                . "inner join ".TABLE_TACID." on Tac1=".TABLE_TACID.".TacId  $condizione_tipo_terminale "
                . "group by Marca ) as lista_tariffa order by numero_device desc";
        }      
        if ($_SESSION['operator'] == 'wind')  {
            $tac_counter = 'Count_IMEI';
            $mese = $this->ultimo_mese();
            $mese = $this->windtable_net($mese);
            
            $query = "select numero_device,Marca from(select sum($tac_counter) as numero_device, ".TABLE_TACID.".Modello,classe_throughput, ".TABLE_TACID.".Tecnologia ,".TABLE_TACID.".Marca,".TABLE_TACID.".OS,".TABLE_TACID.".Tipo, Tac1
            from " . $mese 
                . " inner join ".TABLE_TACID." on Tac1=".TABLE_TACID.".TacId  $condizione_tipo_terminale "
                . " group by Marca ) as lista_tariffa order by numero_device desc";
        }    
       
    #echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['Marca']] = $row['Marca'];
            }
            return $risultato;
        } else
            return array();
    }

    function get_lista_citta($condizione_tipo_terminale = "") {
        $query = "select numero_device,COMUNE_PREVALENTE from(
            select sum(numero_S) as numero_device,COMUNE_PREVALENTE
            from " . $this->ultimo_mese() . "_citta "
                . "inner join ".TABLE_TACID." on Tac1=".TABLE_TACID.".TacId  $condizione_tipo_terminale "
                . "group by COMUNE_PREVALENTE ) as lista_citta order by numero_device desc";
        //echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['COMUNE_PREVALENTE']] = $row['COMUNE_PREVALENTE'];
            }
            return $risultato;
        } else
            return array();
    }

    function get_top_vendor() {
        $query = "SELECT distinct `vendor` FROM `dati_valori_requisiti` order by `vendor` asc ";
        //echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['vendor']] = $row['vendor'];
            }
            return $risultato;
        } else
            return array();
    }
    
    function get_user($vendor=null, $job_roles_id=null) {
        
        if(isset($job_roles_id)){
            $where_cond = "  and `job_role_id`=$job_roles_id";
        }
        else {
            $where_cond ='';
        }
        
        if(isset($vendor)){
            $query = "SELECT users.id, users.lastname, users.firstname, users.login FROM `users` left join departments on departments.id=users.department_id WHERE departments.name='".$vendor."' $where_cond";
        }
        else {
            $query = "SELECT users.id, users.lastname, users.firstname, users.login FROM `users` left join departments on departments.id=users.department_id  WHERE 1 ".$where_cond."";
        }
        #$query = "SELECT * FROM users left join departments on departments.id=users.department_id WHERE departments.name='Samsung'";
#echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                #$username = $row['lastname'].'-'.$row['firstname'];
                $username = $row['login'];
                $risultato[$row['id']] = $username;
            }
            return $risultato;
        } else
            return mysqli_error($this->mysqli);
    }
    
    function get_all_marca() {
        $query = "SELECT distinct `Marca` FROM `dati_tacid` order by `Marca` asc";
        //echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['Marca']] = $row['Marca'];
            }
            return $risultato;
        } else
            return array();
    }
    
    function get_models($vendor=null, $devicetype=null) {
        $where_condition = " WHERE 1 ";
        
        if(!empty($vendor)){ $where_condition .= " and `Marca`='".$vendor."'";}
        if(!empty($devicetype)){ $where_condition .= " and  `Tipo`='".$devicetype."'";}  

        $query = "SELECT distinct `Modello` FROM `dati_tacid` $where_condition  order by `Modello` asc";
        #echo $query;
        $risultato = array();
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                $risultato[$row['Modello']] = $row['Modello'];
            }
            return $risultato;
        } else
            return array();
    }
    
    function get_lista_requisiti($filtro) {
        #print_r($filtro);
            $like_smart = 0;
            $like_mbb = 0;
            $like_tab = 0;
            if (isset($filtro['filtro_handset']))
                   $like_smart = 4;
            if (isset($filtro['filtro_MBB']))
                   $like_mbb = 2;
            if (isset($filtro['filtro_tablet']))
                  $like_tab = 1;

            $like_cond = $like_smart + $like_mbb + $like_tab;
            #echo 'like '.$like_cond;
            
            if($like_cond==7 or $like_cond==0)
                $condition = " `lista_req` like '%phone%' or `lista_req` like '%Router%' or `lista_req` like '%Datacard%' or `lista_req` like '%Tablet%' ";
            elseif($like_cond==6)
                $condition = " `lista_req` like '%phone%' or `lista_req` like '%Router%' or `lista_req` like '%Datacard%' ";
            elseif($like_cond==5)
                $condition = " `lista_req` like '%phone%' or `lista_req` like '%Tablet%' ";
            elseif($like_cond==4)
                $condition = " `lista_req` like '%phone%' ";
            elseif($like_cond==3)
                $condition = " `lista_req` like '%Router%' or `lista_req` like '%Datacard%' or `lista_req` like '%Tablet%' ";      
            elseif($like_cond==2)
                $condition = " `lista_req` like '%Router%' or `lista_req` like '%Datacard%' ";
            elseif($like_cond==1)
                $condition = " `lista_req` like '%Tablet%' ";
            
            $query = "SELECT * FROM `dati_requisiti` WHERE  $condition  ORDER by `area_name`,`ordine` ";
    #echo $query;
        $risultato = array();
        $modello = array();
        $marca = "";
        if ($result = mysqli_query($this->mysqli, $query)) {
            while ($row = mysqli_fetch_assoc($result)) {
                if ($marca == strtoupper($row['area_name']))
                    $modello[$row['id']] = $row['label'];
                else {
                    if (count($modello) > 0) {
                        $risultato[$marca] = $modello;
                    }
                    $marca = strtoupper($row['area_name']);

                    $modello = array();
                    $modello[$row['id']] = $row['label'];
                }
            }
            $risultato[$marca] = $modello;
            return $risultato;
        } else
            return array();
    }
    
    function check_project_new($marca,$modello,$devicetype) { 

        $query3 = "select count(id) as numero from projects where model='$modello' and vendor='$marca' and devicetype='$devicetype' ";
        //echo $query3;
        $result3 = mysqli_query($this->mysqli,$query3) or die($query3 . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3);
        if (isset($obj3['numero']) && $obj3['numero']==0)
            return TRUE;
        else
            return FALSE;
    }
    
    function insert_project_new($marca,$modello,$devicetype,$owner,$uservendor_id) {
        $data_inserimento = date("Y-m-d");
        
        $query = "INSERT INTO `projects`(`id`, `owner`, `status_id`, `progress`, `data_inserimento`, `data_accettazione`, `model`, `vendor`, `devicetype`, `market`, `vendor_user_id`) "
                . "VALUES ('','$owner','1','0','".$data_inserimento."','','$modello','$marca','$devicetype','customized','$uservendor_id')";
        #echo 'insert project '.$query;  
        
        if ($result = mysqli_query($this->mysqli, $query)) {
             return $result;               
            }          
         else {
            return mysqli_error($this->mysqli);
         }

    }
    
    function update_project($idproject, $marca,$modello,$devicetype,$owner, $status, $new_uservendor) {
        #$data_inserimento = date("Y-m-d");
        
        $query = "UPDATE `projects` SET `owner`='$owner',`status_id`='$status',`model`='$modello',`vendor`='$marca',`devicetype`='$devicetype', `vendor_user_id`='$new_uservendor' WHERE `id`='$idproject' ";
        
        #echo $query;   
        
        if ($result = mysqli_query($this->mysqli, $query)) {
             return $result;               
            }          
         else {
            return mysqli_error($this->mysqli);
         }

    }
    
    function update_project_status($idproject, $status_id) {
        #$data_inserimento = date("Y-m-d");
        
        $query = "UPDATE `projects` SET `status_id`='$status_id' WHERE `id`='$idproject' ";
        
        #echo $query;   
        
        if ($result = mysqli_query($this->mysqli, $query)) {
             return $result;               
            }          
         else {
            return mysqli_error($this->mysqli);
         }

    }
    


}    
