<?php

//ini_set('error_reporting', E_ALL);
//ini_set("display_errors", 1);
include_once 'db_config.php';
#include_once 'socmanager_class.php';

function debug_to_console($data) {

   if (is_array($data))
        $output = "<script>console.log( 'Debug Objects: " . addslashes(implode(',', $data)) . "' );</script>";
    else
        $output = "<script>console.log( 'Debug Objects: " . addslashes($data) . "' );</script>";

    echo $output;
}

class funzioni_admin {

    var $mysqli;

    function __construct() {
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

    function stampa_select($nome_var, $lista_field, $lista_name, $javascript = "", $style = "", $selectStato_default = "") {
        echo "<select id=\"$nome_var\" name=\"$nome_var\" $javascript $style >";
        echo "<option value=\"\"></option>";
        $contatore = 0;
        if (count($lista_field) == count($lista_name)) {
            foreach ($lista_field as $key => $value) {
                $selected = "";
                if ($selectStato_default != "") {
                    if ($selectStato_default == $value) {
                        $selected = " selected=\"selected\" ";
                    }
                }

                echo "<option value=\"" . $value . "\"  $selected>" . $lista_name[$contatore] . "</option>";
                $contatore++;
            }
        }
        echo "</select>";
    }

    function stampa_select2($nome_var, $lista_field, $lista_name, $javascript = "", $style = "", $selectStato_default = "", $campo_nome = "") {
        if(!empty($campo_nome)){
            $nome_campo = $campo_nome;}
            else {
                $nome_campo = $nome_var;
            }
        echo "<select id=\"$nome_var\" class=\"select2_single form-control\" name=\"$nome_campo\" $javascript $style >";
        echo "<option value=\"\"></option>";
        $contatore = 0;
        if (count($lista_field) == count($lista_name)) {
            foreach ($lista_field as $key => $value) {
                $selected = "";
                if ($selectStato_default != "") {
                    if ($selectStato_default == $value) {
                        $selected = " selected=\"selected\" ";
                    }
                }

                echo "<option value=\"" . $value . "\"  $selected>" . $lista_name[$contatore] . "</option>";
                $contatore++;
            }
        }
        echo "</select>";
    }

    function get_id($nome_tabella, $valore_campo, $nome_campo = "name") {
        $query3 = "SELECT id as risultato FROM $nome_tabella  WHERE $nome_campo='$valore_campo'";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $obj3 = $result3->fetch_array(MYSQLI_ASSOC);
        if (isset($obj3['risultato']))
            return $obj3['risultato'];
        else
            return 0;
    }

    function get_type($id) {
        $query3 = "SELECT campaign_types.id,campaign_types.NAME as tipo_nome FROM campaign_types 
    left join campaign_stacks on campaign_stacks.id=campaign_types.campaign_stack_id
    where campaign_stacks.id=$id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['tipo_nome'];
            $list[] = $r;
        }
        return $list;
    }
    
    function get_offerId($name) {
        $query3 = "SELECT offers.id,offers.name,offers.label,offers.description FROM offers 
        where name like '$name'";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $r['label'] = $obj3['label'];
            $r['description'] = $obj3['description'];
            $list[] = $r;
        }
        return $r['id'];
    }
    
    

	
    function get_type_label2($id) {
        $query3 = "SELECT campaign_types.id,campaign_types.NAME as tipo_nome,campaign_types.label as tipo_label FROM campaign_types 
    
    where campaign_types.id=$id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['tipo_nome'];
            $r['label'] = $obj3['tipo_label'];
            $list[] = $r;
        }
        return $r['label'];
    }
        function get_type_label($id) {
        $query3 = "SELECT campaign_types.id,campaign_types.NAME as tipo_nome,campaign_types.label as tipo_label FROM campaign_types 
    
    where campaign_types.id=$id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['tipo_nome'];
            $r['label'] = $obj3['tipo_label'];
            $list[] = $r;
        }
        return $list;
    }
    
 
    function get_channel_label2($id) {
        $query3 = "SELECT channels.id,channels.NAME as tipo_nome,channels.label as tipo_label FROM channels 
    
    where channels.id=$id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['tipo_nome'];
            $r['label'] = $obj3['tipo_label'];
            $list[] = $r;
        }
        return $r['label'];
    }

    function get_stack_label($id) {
        $query3 = "SELECT campaign_stacks.id,campaign_stacks.NAME as tipo_nome,campaign_stacks.label as tipo_label FROM campaign_stacks 
    
    where campaign_stacks.id=$id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['tipo_nome'];
            $r['label'] = $obj3['tipo_label'];
            $list[] = $r;
        }
        return $list;
    }

    function get_offers($name=NULL) {
        
       $query3 = "SELECT offers.id,offers.name,offers.label,offers.description FROM offers 
        where 1 ";
        
        if(isset($name)){
            $query3 = " and name like '%$name%' "; 
        }
        

//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $r['label'] = $obj3['label'];
            $r['description'] = $obj3['description'];
            $list[] = $r;
        }
        return $list;
    }

    function get_segment($id) {
        $query3 = "SELECT id,name,label FROM segments 
        where id like '$id'";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $r['label'] = $obj3['label'];
            $list[] = $r;
        }
        return $list;
    }

    function get_segment_list() {
        $query3 = "SELECT id,name,label FROM segments ";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $r['label'] = $obj3['label'];
            $list[] = $r;
        }
        return $list;
    }

    function get_offer_id($id) {
        $query3 = "SELECT offers.id,offers.name,offers.label,offers.description FROM offers 
        where id = $id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $r['label'] = $obj3['label'];
            $r['description'] = $obj3['description'];
            $list[] = $r;
        }
        return $list;
    }

    function get_senders($id) {
        $query3 = "SELECT senders.id,senders.NAME as tipo_nome FROM senders 
    left join channels on channels.id=senders.channel_id
    where channels.id=$id";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['tipo_nome'];
            $list[] = $r;
        }
        return $list;
    }
    
    function get_sprints() {
        $query3 = "SELECT * FROM `sprints`";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r[$obj3['id']] = $obj3;
         
        }
        return $r;
    }
    
    function get_allTable($table) {
        $query3 = "SELECT * FROM `$table`";
//echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r[$obj3['id']] = $obj3;
         
        }
        return $r;
    }

    function get_nome_campo($nome_tabella, $nome_campo_filtro, $valore_campo, $nome_campo = 'name') {
        $query3 = "SELECT $nome_campo as risultato FROM $nome_tabella  WHERE $nome_campo_filtro='" . addslashes($valore_campo) . "'";
//echo 'eccolo '.$query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $obj3 = $result3->fetch_array(MYSQLI_ASSOC);
        if (isset($obj3['risultato']))
            return $obj3['risultato'];
        else
            return 0;
    }

    function get_list_id($nome_tabella) {
        $query3 = "SELECT id,name FROM $nome_tabella ";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $list[] = $r;
        }
        return $list;
    }
    
    function get_list_select($nome_tabella) {
        $query3 = "SELECT id,name FROM $nome_tabella ";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        #$r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            #$r['id'] = $obj3['id'];
            #$r['name'] = $obj3['name'];
            $list[$obj3['id']] = $obj3['name'];
        }
        return $list;
    }

    function get_list_state_id($nome_tabella, $ordinamento) {
        $query3 = "SELECT id,name FROM $nome_tabella where ordinamento<=$ordinamento";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $list[] = $r;
        }
        return $list;
    }

    function get_all_list($nome_tabella, $order_condition = 'ORDER BY `campaign_types`.`campaign_stack_id` ASC', $filter = "") {
        $query3 = "SELECT * FROM $nome_tabella $order_condition";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        $i = 0;
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {

            #$r['name'] = $obj3['name'];
            $rows[] = $obj3;
        }
        return $rows;
    }

    #SELECT * FROM `campaign_types` WHERE 1 ORDER BY `campaign_types`.`campaign_stack_id` ASC

    function get_list_id_where($nome_tabella, $where_condition) {
        $query3 = "SELECT id,name FROM $nome_tabella where $where_condition";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['name'] = $obj3['name'];
            $list[] = $r;
        }
        return $list;
    }

    function get_list_user_log($start, $end) {
        $query3 = "SELECT log.id,lastname,firstname,login,ip,inizio_sessione FROM log left join  users on users.id=id_user where inizio_sessione<$end and inizio_sessione>$start ";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        $list = array();
        $r = array();
        while ($obj3 = $result3->fetch_array(MYSQLI_ASSOC)) {
            $r['id'] = $obj3['id'];
            $r['lastname'] = $obj3['lastname'];
            $r['firstname'] = $obj3['firstname'];
            $r['login'] = $obj3['login'];
            $r['ip'] = $obj3['ip'];
            $r['inizio_sessione'] = $obj3['inizio_sessione'];
            $list[] = $r;
        }
        return $list;
    }

    function update_name($nome_tabella, $id, $new_value, $color = NULL, $elimina = NULL, $label = NULL, $description = NULL) {
        //$query3 = "UPDATE `$nome_tabella` SET `name` = '$new_value' WHERE `$nome_tabella`.`id` = $id";
        if ($nome_tabella == "campaign_states") {
            $query3 = "UPDATE `$nome_tabella` SET `name` = '$new_value',`colore` ='$color',`elimina` ='$elimina'  WHERE `$nome_tabella`.`id` = $id";
        } elseif ($nome_tabella == "offers") {
            $query3 = "UPDATE `$nome_tabella` SET `name` = '$new_value',`label` = '$label',`description` ='$description'  WHERE `$nome_tabella`.`id` = $id";
        } elseif ($nome_tabella == 'campaign_modalities' || $nome_tabella == 'campaign_categories' || $nome_tabella == 'campaign_cat_sott' || $nome_tabella == 'campaign_titolo_sottotitolo' || $nome_tabella == "campaign_types" || $nome_tabella == 'campaign_stacks' || $nome_tabella == 'channels' || $nome_tabella == 'segments') {
            $query3 = "UPDATE `$nome_tabella` SET `name` = '$new_value',`label` = '$label'  WHERE `$nome_tabella`.`id` = $id";
        } else {
            $query3 = "UPDATE `$nome_tabella` SET `name` = '$new_value' WHERE `$nome_tabella`.`id` = $id";
        }
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        return $result3;
    }

    function delete_name($nome_tabella, $id) {
        $query3 = "DELETE FROM `$nome_tabella` WHERE `id` = $id";

        $result3 = $this->mysqli->query($query3) or
                die("<script type=\"text/javascript\">alert(\"Eliminazione non consentita! L'item è relazionato con dati presenti sul DB - \");</script>");
        #$campaign = new socmanager_class();
        #$campaign->reset_filter_session();
        return $result3;
    }

    function insert_name($nome_tabella, $name, $colore = '#FFFFFF', $label = "") {
        if ($nome_tabella == "campaign_states")
            $query3 = "INSERT INTO `$nome_tabella`(`id`, `name`, `colore`) VALUES ( NULL, '$name', '$colore')";
        elseif ($label != "")
            $query3 = "INSERT INTO `$nome_tabella`(`id`, `name`, `label`) VALUES ( NULL, '$name', '$label')";
        else
            $query3 = "INSERT INTO `$nome_tabella`(`id`, `name`) VALUES ( NULL, '$name')";

        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        return $result3;
    }

    function insert_new_campaigntype($name, $id_stack, $label) {
        $query3 = "INSERT INTO `campaign_types`(`id`, `name`, `campaign_stack_id`,label) VALUES ( NULL, '$name', '$id_stack','$label')";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        return $result3;
    }

    function insert_new_senders($name, $channel_id) {
        $query3 = "INSERT INTO `senders`(`id`, `name`, `channel_id`) VALUES ( NULL, '$name', '$channel_id')";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        return $result3;
    }

    function insert_new_campaignstatus($name, $color, $elimina) {
        $query3 = "INSERT INTO `campaign_states`(`id`, `name`, `colore`, `elimina`) VALUES ( NULL, '$name', '$color', '$elimina')";
        //echo $query3;
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        return $result3;
    }
/*
    function insert_offer($name, $description, $label) {
        $query3 = "INSERT INTO `offers`(`id`, `name`, `description`, `label`) VALUES ( NULL, '$name', '$description', '$label')";
        //echo $query3 . "<br>";
        $result3 = $this->mysqli->query($query3);
        $error3 = $this->mysqli->error;
        //$campaign = new socmanager_class();
        //$campaign->reset_filter_session();
        return $error3;
    }
	*/
	
	function insert_offer($name, $label, $description) {
        $query3 = "INSERT INTO `offers`(`id`, `name`, `description`, `label`) VALUES ( NULL, '$name', '$description', '$label')";   
        //echo $query3 . "<br>";
        $result3 = $this->mysqli->query($query3);
        $error3 = $this->mysqli->error;
        //$campaign = new socmanager_class();
        //$campaign->reset_filter_session();
        if(!empty($error3))
                return $error3;
        
    }

    function insert_new_offers($name, $label, $description) {
        // check tripletta 
        // se la combinazione name label description è nuova inseriscila 
        $query3 = "INSERT IGNORE INTO `offers`(`id`, `name`, `description`, `label`) VALUES ( NULL, '$name', '$description', '$label')";
        //echo $query3 . "<br>";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
        //$campaign = new socmanager_class();
        //$campaign->reset_filter_session();
        return $result3;
    }

    function check_new_name($nome_tabella, $new_name) {
        $new_name = strtolower(trim($new_name));
        $query1 = "SELECT * FROM `$nome_tabella` where LOWER(TRIM(`name`))='$new_name'";
        $result1 = $this->mysqli->query($query1) or die($query1 . " - " . $this->mysqli->error);
        $obj1 = $result1->fetch_array(MYSQLI_ASSOC);
        if (empty($obj1['id']))
            return (TRUE);
        else
            return (FALSE);
    }
    
    function check_triplette_offers($new_name, $new_label, $new_description) {
        $new_name = strtolower(trim($new_name));
        $new_label = strtolower(trim($new_label));
        $new_description = strtolower(trim($new_description));
        $query1 = "SELECT * FROM offers where LOWER(TRIM(`name`))='$new_name' and LOWER(TRIM(`label`))='$new_label' and LOWER(TRIM(`description`))='$new_description' ";
        $result1 = $this->mysqli->query($query1) or die($query1 . " - " . $this->mysqli->error);
        $obj1 = $result1->fetch_array(MYSQLI_ASSOC);
        if (empty($obj1['id']))
            return (TRUE);
        else
            return (FALSE);
    }
    

    function check_user_eraseble($user_id) {
        $query1 = "SELECT `active` FROM `users` WHERE `id`='$user_id'";
        #$query2 = "SELECT count(*) as test  FROM `campaigns` WHERE `user_id`='$user_id'";
        $result1 = $this->mysqli->query($query1) or die($query1 . " - " . $this->mysqli->error);
        #$result2 = $this->mysqli->query($query2) or die($query2 . " - " . $this->mysqli->error);

        $active = $result1->fetch_array(MYSQLI_ASSOC);
        #$num_campaign = $result2->fetch_array(MYSQLI_ASSOC);

        #var_dump($num_campaign);

        #if ($active['active'] == 'n' && $num_campaign["test"] == 0)
        if ($active['active'] == 'n')
            return (TRUE);
        else
            return (FALSE);
    }

    function close_dbli() {
        $this->mysqli->close();
    }

    public function __wakeup() {
        echo "wakeup";
        $this->mysqli = $this->connect_dbli();
    }

    function users_get_list($nome_tabella) {
        $query3 = "SELECT users.id, `lastname`, `firstname`, `login`, `job_role_id`, `squad_id`, `active`, `leggi`, `inserisci`, `modifica`, `cancella`  , job_roles.name  as ruolo, squads.vendor as dipartimento FROM `users` left join squads on `squad_id`=squads.id left join job_roles on `job_role_id`=job_roles.id ORDER BY `users`.`lastname` ASC";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        while ($row = mysqli_fetch_assoc($result3)) {
            $list[] = $row;
        }
        #print_r($list);
        return $list;
    }

    function debug_to_console($data) {

        if (is_array($data))
            $output = "<script>console.log( 'Debug Objects: " . implode(',', $data) . "' );</script>";
        else
            $output = "<script>console.log( 'Debug Objects: " . $data . "' );</script>";

        echo $output;
    }

    function users_get_list_where_old($where) {
        $query3 = "SELECT users.id, `lastname`, `firstname`, `login`, `job_role_id`, `squad_id`, `active`, `leggi`, `inserisci`, `modifica`, `cancella` ,maillist , job_roles.name  as ruolo, squads.vendor as dipartimento FROM `users` left join squads on `squad_id`=squads.id left join job_roles on `job_role_id`=job_roles.id $where ORDER BY `users`.`lastname` ASC";
        #$query3 = "SELECT * From `users` $where ORDER BY `users`.`lastname` ASC";
        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        while ($row = mysqli_fetch_assoc($result3)) {
            $list[] = $row;
        }
        #print_r($list);
        return $list;
    }
    
    function users_get_list_where($where) {

        $query3 = "SELECT users.id, `lastname`, `firstname`, `login`, `job_role_id`, `email`, `squad_id`, `active`, `leggi`, `inserisci`, `modifica`, `cancella` ,maillist , job_roles.name as ruolo, squads.name as dipartimento FROM `users` left join squads on `squad_id`=squads.id left join job_roles on `job_role_id`=job_roles.id $where ORDER BY `users`.`lastname` ASC"; 


        $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);

        while ($row = mysqli_fetch_assoc($result3)) {
            $list[] = $row;
        }
        #print_r($list);
        return $list;
    }
    function user_get_info($id) {
        $sql = "SELECT * FROM `users` where `id`='$id'";
        $result3 = $this->mysqli->query($sql) or die($sql . " - " . $this->mysqli->error);
        $row = mysqli_fetch_assoc($result3);
        #print_r($row);
        return $row;
    }

    function user_update($query) {
        #$query3 = "UPDATE `users` SET `lastname`=".$_POST['cognome'].",`firstname`=".$_POST['nome'].",`login`=".$_POST['username'].",`job_role_id`=".$_POST['selectRuolo'].",`squad_id`=".$_POST['selectDipartimento'].",`active`=".$_POST['selectStato'].",`leggi`=Yes,`inserisci`=".$_POST['inserisci'].",`modifica`=".$_POST['modifica'].",`cancella`=".$_POST['cancella'].",`email`='xxx',`tmp_mail`=xxx,`pw`=".md5($_POST['password']).",`access_level`=1 WHERE `id`=".$_POST['idUtente']." ";
        #$query3 = "UPDATE `users` SET `name` = '$new_value' WHERE `$nome_tabella`.`id` = $id";
        $result3 = $this->mysqli->query($query) or die($query . " - " . $this->mysqli->error);
        #var_dump($result3);
        return $result3;
    }

    /*
      function user_insert_new($name) {
      $query3 = "INSERT INTO `users`(`id`, `name`) VALUES ( NULL, '$name')";
      $result3 = $this->mysqli->query($query3) or die($query3 . " - " . $this->mysqli->error);
      return $result3;
      }
     * 
     */

    function check_new_username($new_login) {
        $new_name = strtolower(trim($new_login));
        $query1 = "SELECT * FROM `users` where LOWER(TRIM(`login`))='$new_login'";
        $result1 = $this->mysqli->query($query1) or die($query1 . " - " . $this->mysqli->error);
        $obj1 = $result1->fetch_array(MYSQLI_ASSOC);
        if (empty($obj1['id']))
            return (TRUE);
        else
            return (FALSE);
    }

    function access_level($inserisci, $modifica, $cancella) {
        if (strtolower(trim($inserisci)) == 'yes')
            $inserisci = 1;
        else
            $inserisci = 0;
        if (strtolower(trim($modifica)) == 'yes')
            $modifica = 2;
        else
            $modifica = 0;
        if (strtolower(trim($cancella)) == 'yes')
            $cancella = 4;
        else
            $cancella = 0;
        $livello = $inserisci + $modifica + $cancella;
        return ($livello);
    }

}
