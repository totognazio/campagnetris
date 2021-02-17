<?php
include_once 'db_config.php';
/*
  define("DB_SERVER", "localhost");
  define("DB_NAME", "ing");
  define("DB_USER", "root");
  define("DB_PASSWORD", "");
 */
if (!defined('TABLE1'))
    define("TABLE1", "dati_utenti");
if (!defined('TABLE1_TRAFFICO'))
    define("TABLE1_TRAFFICO", "dati_utenti_traffico");
if (!defined('TABLE2'))
    define("TABLE2", "dati_utenti1");
if (!defined('TABLE2_TRAFFICO'))
    define("TABLE2_TRAFFICO", "dati_utenti1_traffico");
if (!defined('TABLE_TACID'))
    define("TABLE_TACID", "dati_tacid");
if (!defined('TABLE_IMEI'))
    define("TABLE_IMEI", "dati_imei");
if (!defined('TABLE_IMEI_3ITA'))
    define("TABLE_IMEI_3ITA", "tac_h3g");
if (!defined('TABLE_IMEI_BOXI'))
    define("TABLE_IMEI_BOXI", "dati_imei_boxi");


/*

function connect_db() {
    $conn_str = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die("Error " . mysqli_error($conn_str));
    //   var_dump($conn_str);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $conn_str;
}
 * 
 */

function connect_db_li() {
    //$conn_str = mysql_connect(DB_SERVER, DB_USER, DB_PASSWORD);
    $conn_str = mysqli_connect(DB_SERVER, DB_USER, DB_PASSWORD, DB_NAME) or die("Error " . mysqli_error($conn_str));
    //   var_dump($conn_str);
    if (mysqli_connect_errno()) {
        printf("Connect failed: %s\n", mysqli_connect_error());
        exit();
    }
    return $conn_str;
}

function _valori($nome_tabella, $risultato, $terminale, $condizioni = "") {
    $db_link = connect_db_li();
    if ($condizioni != "")
        $condizioni = " and " . $condizioni;
    $query3 = "SELECT $risultato as risultato, dati_tacid.Modello as Modello FROM $nome_tabella left join dati_tacid on Tac1=TacId  WHERE $terminale  $condizioni order by risultato desc";
    /* $write_file = fopen("example.txt", "w");
      fwrite($write_file, $query3);
      fclose($write_file); */
    #echo "<br>Query ".$query3 . "<br>";

    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysqli_error($db_link));
    $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
    if (isset($obj3['risultato']))
        return $obj3['risultato'];
    else
        return 0;
    
    //Flush memory
    $query = "FLUSH TABLES;";
    $result = mysqli_query($db_link, $query) or die($query . " - " . mysqli_error($db_link));
    $query2 = "FLUSH QUERY CACHE;";
    $result2 = mysqli_query($db_link, $query2) or die($query2 . " - " . mysqli_error($db_link));
}

 function multineedle_stripos($haystack, $needles, $offset=0) {
        $flag = false;
        foreach($needles as $needle) {
            if(stripos($haystack, $needle, $offset)!==false){
                    return $flag = true;
            }
            
        }
        
        return $flag;
}

function multineedle_stripos_value($haystack, $needles, $offset=0) {
        $value = null;
        foreach($needles as $needle) {
            if(stripos($haystack, $needle, $offset)!==false){
                    
                    $value = $needle;
            }
            
        }
        
        return $value;
}


function recursive_return_array_value_by_key($needle, $haystack){
    $return = false;
    foreach($haystack as $key => $val){
        if(is_array($val)){
            $return = recursive_return_array_value_by_key($needle, $val);
        }
        else if($needle === $key){
            return "$val\n";
        }
    }
    return $return;
}



function _valori_2($nome_tabella, $lista_variabili, $condizioni, $gruppi, $check = false) {
    $db_link = connect_db_li();
    //var_dump($db_link);
    $query3 = "SELECT $lista_variabili FROM $nome_tabella left join dati_tacid on Tac1=TacId  $condizioni  $gruppi";
    /* if ($check) {
      $scrivi = fopen("example.txt", "w+");
      $leggi = fread($scrivi, filesize("example.txt"));
      fwrite($scrivi, $query3 . " \n" . $leggi);

      fclose($write_file);
      } */
    echo $query3 . "<br>";
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
    if (isset($obj3['risultato']))
        return $obj3['risultato'];
    else
        return 0;
}

function _valori_3($nome_tabella, $lista_variabili, $condizioni, $gruppi, $check = false) {
    $db_link = connect_db_li();
    //var_dump($db_link);
    $query3 = "SELECT $lista_variabili FROM $nome_tabella inner join `dati_requisiti` on `id_requisito`=`dati_requisiti`.id  $condizioni  $gruppi";
    /* if ($check) {
      $scrivi = fopen("example.txt", "w+");
      $leggi = fread($scrivi, filesize("example.txt"));
      fwrite($scrivi, $query3 . " \n" . $leggi);

      fclose($write_file);
      } */
    //echo $query3 . "<br>";
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
    if (isset($obj3['risultato']))
        return $obj3['risultato'];
    else
        return 0;
}

function _valori_generica($nome_tabella, $lista_variabili, $condizioni, $gruppi, $inner, $check = false) {
    $db_link = connect_db_li();
    //var_dump($db_link);
    $query3 = "SELECT $lista_variabili FROM $nome_tabella $inner  $condizioni  $gruppi";
    /* if ($check) {
      $scrivi = fopen("example.txt", "w+");
      $leggi = fread($scrivi, filesize("example.txt"));
      fwrite($scrivi, $query3 . " \n" . $leggi);

      fclose($write_file);
      } */
    //echo $query3 . "<br>";
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
    if (isset($obj3['risultato']))
        return $obj3['risultato'];
    else
        return 0;
}

function stampa_select_requisiti($nome_variabile, $query, $nome_campo, $multi = false, $id_campo = NULL, $messaggio = "", $selected = NULL, $javascript = "") {
    #$db_link = connect_db_li();
    $db_link = connect_db_li();
    echo "<select class=\"form-control\" style=\"clear: both;   height: 400px;
  width: 500px;\" id=textbox1 $javascript name=$nome_variabile";
    if ($multi)
        echo "  multiple=\"true\" ";
    echo ">";
//$query="select nome_tabella from lista_tabelle";
    //echo $query;
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    #echo "<option value=\"\">$messaggio</option>";
    $vendor_first = "";
    $count = 0;
    while ($obj3 = mysqli_fetch_array($result)) {

        $vendor_name = ucwords(mb_strtolower($obj3['vendor']));
        if ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count > 0))
            echo "</optgroup><optgroup label=\"$vendor_name\">";
        elseif ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count == 0)) {
            echo "<optgroup label=\"$vendor_name\">";
        }
        $count++;

        if ($id_campo == NULL)
            $value = $nome_campo;
        else
            $value = $id_campo;

        echo "<option ";
        if ($selected != NULL) {

            if (count($selected) == 1) {
                if ($selected[0] == $obj3[$value])
                    echo " selected=selected ";
            } else
                for ($i = 0; $i < count($selected); $i++) {

                    if ($selected[$i] == $obj3[$value])
                        echo " selected=selected ";
                }
        }
        $campo = $obj3[$nome_campo];
        #$campo = ucwords(mb_strtolower($obj3[$nome_campo]));
        echo " value=\"" . $obj3[$value] . "\"> " . $campo . " </option>";
        $vendor_first = $vendor_name;
    }
    echo "</select></div></div>";
}

function stampa_select_tel_tab($nome_variabile, $query, $nome_campo, $multi = false, $id_campo = NULL, $messaggio = "", $selected = NULL, $javascript = "") {
    $db_link = connect_db_li();
    //echo $query;
    echo "<select class=\"select2_multiple form-control select2-hidden-accessible\" id=textbox1 $javascript name=$nome_variabile";
    if ($multi)
        echo "  multiple=\"true\" ";
    echo ">";
//$query="select nome_tabella from lista_tabelle";

    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    #echo "<option value=\"\">$messaggio</option>";
    $vendor_first = "";
    $count = 0;
    while ($obj3 = mysqli_fetch_array($result)) {

        $vendor_name = ucwords(mb_strtolower($obj3['Marca']));
        if ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count > 0))
            echo "</optgroup><optgroup label=\"$vendor_name\">";
        elseif ((strcasecmp($vendor_first, $vendor_name) != 0) && ($count == 0)) {
            echo "<optgroup label=\"$vendor_name\">";
        }
        $count++;

        if ($id_campo == NULL)
            $value = $nome_campo;
        else
            $value = $id_campo;

        echo "<option ";
        if ($selected != NULL) {

            if (count($selected) == 1) {
                if ($selected[0] == $obj3[$value])
                    echo " selected=selected ";
            } else
                for ($i = 0; $i < count($selected); $i++) {

                    if ($selected[$i] == $obj3[$value])
                        echo " selected=selected ";
                }
        }
        $campo = $obj3[$nome_campo];
        #$campo = ucwords(mb_strtolower($obj3[$nome_campo]));
        echo " value=\"" . $obj3[$value] . "\"> " . $campo . " </option>";
        $vendor_first = $vendor_name;
    }
    echo "</select>";
}

function stampa_select($nome_variabile, $query, $nome_campo, $multi = false, $id_campo = NULL, $messaggio = "", $selected = NULL, $javascript = "") {
    $db_link = connect_db_li(); 
    #echo $query;
    echo "<select class=\"form-control\"  id=textbox1 $javascript name=$nome_variabile";
    if ($multi)
        echo "  multiple=\"true\" ";
    echo ">";
//$query="select nome_tabella from lista_tabelle";
    //echo $query . "<br>";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    if ($messaggio != "")
        echo "<option value=\"\">$messaggio</option>";
    while ($obj3 = mysqli_fetch_array($result)) {

        if ($id_campo == NULL)
            $value = $nome_campo;
        else
            $value = $id_campo;

        echo "<option ";
        if ($selected != NULL) {

            if (count($selected) == 1) {
                if ($selected[0] == $obj3[$value])
                    echo " selected=selected ";
            } else
                for ($i = 0; $i < count($selected); $i++) {

                    if ($selected[$i] == $obj3[$value])
                        echo " selected=selected ";
                }
        }
        
        
             $label_nome_campo = $obj3[$nome_campo];
            $variabile_nome_campo = $obj3[$value];
            /*
            $temp = false;
        if ($obj3[$nome_campo] == "") {
            $label_nome_campo = "n/a";
            $variabile_nome_campo = "n/a";
            $temp = true;
        } else {
            $label_nome_campo = $obj3[$nome_campo];
            $variabile_nome_campo = $obj3[$value];
        }
             * 
             */
        echo " value=\"" . $variabile_nome_campo . "\"> " . $label_nome_campo . " </option>";
    }
    echo "</select>";
}

function stampa_select_array($nome_variabile, $array, $nome_campo = NULL, $multi = false, $id_campo = NULL, $messaggio = "", $selected = NULL, $javascript = "") {
    $db_link = connect_db_li();
    echo "<select class=\"select2_group form-control\"   id=textbox1  $javascript name=$nome_variabile";
    if ($multi)
        echo "  multiple=\"true\" ";
    echo ">";

    echo "<option value=\"\">$messaggio</option>";
    foreach ($array as $key => $value) {

        echo "<option ";
        if ($selected != NULL) {

            if (count($selected) == 1) {
                if ($selected[0] == $value)
                    echo " selected=selected ";
            } else
                for ($i = 0; $i < count($selected); $i++) {

                    if ($selected[$i] == $value)
                        echo " selected=selected ";
                }
        }
        echo " value=\"" . stripslashes($value) . "\"> " . stripslashes($value) . " </option>";
    }
    echo "</select>";
}

function media_nazionale($table) {
    $db_link = connect_db_li();
    $query3 = "SELECT (sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S))*100/(sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S)+sum(Voce_in_on_net_S)+sum(Voce_out_on_net_S)) as PR FROM (select * from `$table` where Voce_in_on_net_S+Voce_out_on_net_S!=0 and (Voce_out_roaming_S+Voce_in_roaming_S)*100/(Voce_out_roaming_S+Voce_in_roaming_S+Voce_in_on_net_S+Voce_out_on_net_S)<90 ) as tab_senza_2g inner join dati_tacid on tab_senza_2g.Tac1=TacId WHERE Tecnologia='Handset'";

    $result3 = mysqli_query($query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    echo "<h3>La media nazionale per il roaming &egrave;: " . round($obj3['PR'], 2) . "</h3>";
    $query3 = "SELECT sum(mc4)*100/(sum(mc2)+sum(mc3)+sum(mc4)) as CDR FROM `$table` inner join `dati_tacid` on Tac1=TacId WHERE Tecnologia='Handset'";
    //echo $query3;
//$query3 = "SELECT sum(mc4)*100/(sum(mc2)+sum(mc3)+sum(mc4)) as CDR FROM `$table` ";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    echo "<h3>La media nazionale per le CDR &egrave;: " . round($obj3['CDR'], 2) . "</h3>";
}

function media_nazionale2($table, $condizioni) {
    $db_link = connect_db_li();
    $query3 = "SELECT (sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S))*100/(sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S)+sum(Voce_in_on_net_S)+sum(Voce_out_on_net_S)) as PR FROM (select * from `$table` where Voce_in_on_net_S+Voce_out_on_net_S!=0 and (Voce_out_roaming_S+Voce_in_roaming_S)*100/(Voce_out_roaming_S+Voce_in_roaming_S+Voce_in_on_net_S+Voce_out_on_net_S)<90 ) as tab_senza_2g inner join dati_tacid on tab_senza_2g.Tac1=TacId WHERE $condizioni";
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $risultati[0] = round($obj3['PR'], 2);
    $query3 = "SELECT sum(mc4)*100/(sum(mc2)+sum(mc3)+sum(mc4)) as CDR FROM `$table` inner join `dati_tacid` on Tac1=TacId WHERE  $condizioni and mobile_radio_access!='2G' ";
    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $risultati[1] = round($obj3['CDR'], 2);
    $query3 = "SELECT sum(numero_S) as numero_terminali FROM `$table` left join `dati_tacid` on Tac1=TacId WHERE $condizioni";
    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $risultati[2] = round($obj3['numero_terminali'], 2);
    return $risultati;
}

function traffico_dati_voce($table, $condizioni) {
    $db_link = connect_db_li();
    $query3 = "SELECT (sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S)+sum(Voce_in_on_net_S)+sum(Voce_out_on_net_S))/60000000 as PR FROM (select * from `$table`  ) as tab_senza_2g inner join dati_tacid on tab_senza_2g.Tac1=TacId WHERE $condizioni";
    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $risultati[0] = round($obj3['PR'], 2);
    $query3 = "SELECT sum( volume_Dati_S )/1073741824 as VD FROM `$table` inner join `dati_tacid` on Tac1=TacId WHERE  $condizioni";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $risultati[1] = round($obj3['VD'], 2);
    $query3 = "SELECT sum(numero_S) as numero_terminali FROM `$table` inner join `dati_tacid` on Tac1=TacId WHERE $condizioni";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $risultati[2] = round($obj3['numero_terminali'], 2);
    return $risultati;
}

function aggiorna_tabella_imeisv() {
    $db_link = connect_db_li();
    $query = " DROP TABLE `imei_sv_tot`";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = "create table imei_sv_tot
SELECT TacId,B,C
FROM  `imei_sv3`
LEFT JOIN dati_tacid ON dati_tacid.modello = A";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = " ALTER TABLE `imei_sv_tot` ENGINE = MYISAM ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = "ALTER TABLE `imei_sv_tot` ADD INDEX ( `TacId` )  ";
    $result3 = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
}

function create_table($query) {
    $db_link = connect_db_li();
    echo "<br>" . $query;
    mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
}

function lista_mese($mese, $numero_mesi) {
    $id_seme = get_mese_ordine($mese);
    $db_link = connect_db_li();
    $risultato = array();
    $query3 = "SELECT * FROM  `lista_tabelle` where ordine<=$id_seme ORDER BY `lista_tabelle`.`ordine` desc LIMIT 0 , $numero_mesi";
    //echo $query3;
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH)) {
        $risultato[] = array('nome' => $obj3['nome_visualizzato'], 'tabella' => $obj3['nome_tabella']);
    }
    return $risultato;
}

function get_mese_ordine($mese) {
    $db_link = connect_db_li();
    $risultato = array();
    $query3 = "SELECT * FROM  `lista_tabelle` where  nome_tabella='$mese'";
    //echo $query3;
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3, MYSQLI_BOTH);
    return $obj3['ordine'];
}

function lista_new_device($mese, $numero_mesi, $numero_device = 9) {
    $id_seme = get_mese_ordine($mese);
    #$db_link = connect_db_li();
    $db_link = connect_db_li();
    $query3 = "SELECT * FROM  `lista_tabelle` where ordine<=$id_seme ORDER BY `lista_tabelle`.`ordine` desc LIMIT $numero_mesi , 1";
    //echo $query3;
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $mese2 = $obj3['nome_tabella'];
    /* $query3 = "SELECT tabella_finale.Modello
      FROM  (
      SELECT sum( numero_3ITA ) as risultato_3ita,sum( numero_S ) as risultato,Modello,Marca
      FROM $mese
      left join dati_tacid on Tac1=TacId
      where (  Tipo='Smartphone' or Tipo='Phablet')  group by Modello having risultato_3ita>0 order by risultato desc
      ) as tabella_finale
      left join (
      SELECT sum( numero_3ITA ) as risultato,Modello,Marca
      FROM $mese2
      left join dati_tacid on Tac1=TacId  group by Modello
      ) as tabella_confronto on tabella_confronto.Modello=tabella_finale.Modello where tabella_confronto.Modello is null or tabella_confronto.risultato<500 limit 0,9"; */

    $query3 = "SELECT tabella_finale.Modello 
FROM ( 
    SELECT sum( numero_3ITA ) as risultato_3ita_1,Modello,Marca 
    FROM $mese 
    left join dati_tacid on Tac1=TacId 
    where ( Tipo='Smartphone' or Tipo='Phablet') group by Modello having risultato_3ita_1>0 order by risultato_3ita_1 desc ) as tabella_finale 
left join ( SELECT sum( numero_3ITA ) as risultato_3ita_2,Modello,Marca 
FROM $mese2 
left join dati_tacid on Tac1=TacId group by Modello ) as tabella_confronto on tabella_confronto.Modello=tabella_finale.Modello 
where tabella_confronto.Modello is null or (risultato_3ita_1>500 and risultato_3ita_2<50 and risultato_3ita_1-risultato_3ita_2>0) limit 0, $numero_device";
    //echo $query3;
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $risultato = array();
    while ($obj3 = mysqli_fetch_array($result3)) {
        $risultato[] = $obj3['Modello'];
    }
    return $risultato;
}

function lista_device($mese, $numero_device = 9) {
    $id_seme = get_mese_ordine($mese);
    
    $db_link = connect_db_li();
    $query3 = "SELECT sum( numero_3ITA ) as risultato_3ita_1,Modello,Marca 
    FROM $mese 
    left join dati_tacid on Tac1=TacId 
    where ( Tipo='Smartphone' or Tipo='Phablet') group by Modello having risultato_3ita_1>0 order by risultato_3ita_1 desc  limit 0, $numero_device";
    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $risultato = array();
    while ($obj3 = mysqli_fetch_array($result3)) {
        $risultato[] = $obj3['Modello'];
    }
    return $risultato;
}

function tabella_statistiche($table, $MSISDN = "") {
    
    $db_link = connect_db_li();
    $inizio = time();
    if ($MSISDN != "") {
        $filtro = " where `MSISDN`='" . $MSISDN . "' ";
        echo "<p>Dati relativi al MSISDN " . $_POST['MSISDN'] . "</p>";
    } else
        $filtro = "";


    $query3 = "
    select
        dati_tacid.Modello,
    dati_tacid.Marca,
        sum( volume_Dati) as volume_Dati_S,
        sum( Voce_out_on_net) as Voce_out_on_net_S,
        sum( Voce_out_roaming) as Voce_out_roaming_S,
        sum( Voce_in_on_net) as Voce_in_on_net_S,
        sum( n_MMS_off_net) as n_MMS_off_net,
        sum( n_MMS_on_net) as n_MMS_on_net,
        sum( n_Portale) as n_Portale,
        sum( Voce_in_roaming) as Voce_in_roaming_S
    from $table left join dati_tacid on $table.TAC=dati_tacid.TacId $filtro group by dati_tacid.Modello";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "<table border =1>";
    echo "<tr><td>Marca</td><td>Modello</td><td>n_MMS_off_net</td><td>n_MMS_on_net</td><td>n_Portale</td><td>Volume Dati (GB)</td><td>Voce out on net</td><td>Voce out roaming</td><td>Voce in on net</td><td>Voce in roaming </td><tr>";

    while ($obj3 = mysqli_fetch_array($result3)) {
        if ($obj3['Marca'] == "")
            $nome_marca = "N/A";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "N/A";
        else
            $nome_modello = $obj3['Modello'];

        $volume_Dati = str_replace(",", ".", round($obj3['volume_Dati_S'] / 1000000000, 3));
        echo "<tr><td>" . $nome_marca . " </td><td>" . $nome_modello . " </td><td> " . $obj3['n_MMS_off_net'] . "</td><td> " . $obj3['n_MMS_on_net'] . "</td><td> " . $obj3['n_Portale'] . "</td><td> " . $volume_Dati . "</td><td> " . $obj3['Voce_out_on_net_S'] . "</td><td> " . $obj3['Voce_out_roaming_S'] . " </td><td> " . $obj3['Voce_in_on_net_S'] . " </td><td> " . $obj3['Voce_in_roaming_S'] . "</td><tr>";
    }
    echo "</table>";
    $fine = time();
    $tempo_impiegato = $fine - $inizio;
    echo "<br><p>Tempo query:" . $tempo_impiegato . "</p>";
}

function aggiornamento_nomi($old_name, $new_name) {
   
    $db_link = connect_db_li();
    $query = "UPDATE `dati_tacid` SET `Modello` = '$new_name' WHERE `dati_tacid`.`Modello` = '$old_name';";
    mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
}

function _statistiche_multiUsim_totale($modello_scelto) {
    $db_link = connect_db_li();
    $query3 = "SELECT count( Modello1 ) AS numero_multi_usim
FROM (

SELECT count( MSISDN1 ) AS numero_Usim, Marca1, Modello1
FROM (

SELECT " . TABLE1 . ".MSISDN AS MSISDN1, " . TABLE1 . ".IMEI AS IMEI1, dati_tacid.Marca AS Marca1,
    dati_tacid.Modello AS Modello1
FROM  " . TABLE1 . " left join dati_tacid on TAC=TacId
            where dati_tacid.Modello  = '$modello_scelto'
GROUP BY MSISDN
) AS table2
GROUP BY IMEI1
ORDER BY count( MSISDN1 ) DESC
) AS table_risultati";
    //echo $query3;
       
    $result3 = mysqli_query($db_link, $query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    return $obj3['numero_multi_usim'];
}

function _statistiche_multiUsim($modello_scelto, $numero_usim) {
    $db_link = connect_db_li();
    $query3 = "SELECT count( Modello1 ) AS numero_multi_usim
FROM (

SELECT count( MSISDN1 ) AS numero_Usim, Marca1, Modello1
FROM (

SELECT " . TABLE1 . ".MSISDN AS MSISDN1, " . TABLE1 . ".IMEI AS IMEI1, dati_tacid.Marca AS Marca1,
    dati_tacid.Modello AS Modello1
FROM  " . TABLE1 . " left join dati_tacid on TAC=TacId
            where dati_tacid.Modello  = '$modello_scelto'
GROUP BY PortfolioId
) AS table2
GROUP BY IMEI1
ORDER BY count( MSISDN1 ) DESC
) AS table_risultati
WHERE numero_Usim =$numero_usim";
//echo "<br>".$query3."<br>";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    return $obj3['numero_multi_usim'];
}

function _statistiche_multiUsim_mese_precedente($modello_scelto, $numero_usim) {
    $db_link = connect_db_li();
    $query3 = "
SELECT count( Modello1 ) as numero_multi_usim
FROM (
SELECT count( MSISDN1 )AS numero_Usim, Marca1, Modello1
FROM (

SELECT MSISDN as MSISDN1, IMEI as IMEI1, Marca as Marca1, Modello as Modello1
FROM " . TABLE1 . "
WHERE Modello = '$modello_scelto'
GROUP BY MSISDN
) AS table1
JOIN (
SELECT MSISDN as MSISDN2, IMEI as IMEI2, Marca as Marca2, Modello as Modello2
FROM " . TABLE2 . "
WHERE Modello = '$modello_scelto'
GROUP BY MSISDN
) AS table2 ON table1.MSISDN1 = table2.MSISDN2
GROUP BY IMEI1
ORDER BY count( MSISDN1 ) desc
) AS table_risultati
WHERE numero_Usim >$numero_usim
";

//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    return $obj3['numero_multi_usim'];
}

function _statistiche_multiUsim_mese_precedente_totale($modello_scelto) {
    $db_link = connect_db_li();
    $query3 = "
SELECT count( Modello1 ) as numero_multi_usim
FROM (
SELECT count( MSISDN1 )AS numero_Usim, Marca1, Modello1
FROM (

SELECT MSISDN as MSISDN1, IMEI as IMEI1, Marca as Marca1, Modello as Modello1
FROM " . TABLE1 . "
WHERE Modello = '$modello_scelto'
GROUP BY MSISDN
) AS table1
JOIN (
SELECT MSISDN as MSISDN2, IMEI as IMEI2, Marca as Marca2, Modello as Modello2
FROM " . TABLE2 . "
WHERE Modello = '$modello_scelto'
GROUP BY MSISDN
) AS table2 ON table1.MSISDN1 = table2.MSISDN2
GROUP BY IMEI1
ORDER BY count( MSISDN1 ) desc
) AS table_risultati
";
    $query3 = "SELECT count( Modello1 ) AS numero_multi_usim
FROM (

SELECT count( MSISDN1 ) AS numero_Usim, Modello1
FROM (

SELECT dati_utenti.MSISDN as MSISDN1,dati_utenti.IMEI as IMEI1,dati_utenti.Modello as Modello1
FROM dati_utenti
JOIN dati_utenti1 ON dati_utenti1.MSISDN = dati_utenti.MSISDN
WHERE dati_utenti.Modello = '$modello_scelto'
GROUP BY dati_utenti.MSISDN,dati_utenti.IMEI

) AS table2
GROUP BY IMEI1
) AS table_risultati";
    echo "<br>" . $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    return $obj3['numero_multi_usim'];
}

function _statistiche_multiUsim_mese_precedente_totale2($modello_scelto) {
    $db_link = connect_db_li();
    $query3 = "
SELECT count( Modello1 ) as numero_multi_usim
FROM (
SELECT count( MSISDN1 )AS numero_Usim, Marca1, Modello1
FROM (

SELECT MSISDN as MSISDN1, IMEI as IMEI1, Marca as Marca1, Modello as Modello1
FROM " . TABLE1 . "
WHERE Modello = '$modello_scelto'
GROUP BY MSISDN
) AS table1
JOIN (
SELECT MSISDN as MSISDN2, IMEI as IMEI2, Marca as Marca2, Modello as Modello2
FROM " . TABLE2 . "
WHERE Modello = '$modello_scelto'
GROUP BY MSISDN
) AS table2 ON table1.MSISDN1 = table2.MSISDN2
GROUP BY IMEI1
ORDER BY count( MSISDN1 ) desc
) AS table_risultati
";

    echo "<br>" . $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    return $obj3['numero_multi_usim'];
}

function tabella_statistiche_multiUsim($modello_scelto) {
    $db_link = connect_db_li();
    $inizio = time();

    echo "<p>Dati relativi al Modello " . $modello_scelto . "</p>";
    $numero_telefoni = _statistiche_multiUsim_totale($modello_scelto);
    echo "<p>il numero di terminali considerato &egrave; : " . $numero_telefoni;
    for ($i = 1; $i < 5; $i = $i + 1) {
        $numero_multi_usim = _statistiche_multiUsim($modello_scelto, $i);

        echo "<p>Ci sono <font color=\"#FF0000\">" . $numero_multi_usim . "</font> \"$modello_scelto\" che hanno $i Usim</p>";
    }

    $fine = time();
    $tempo_impiegato = $fine - $inizio;
    echo "<br><p>Tempo query:" . $tempo_impiegato . "</p>";
}

function tabella_statistiche_emo($modello_scelto = "") {
    
    $db_link = connect_db_li();
    $inizio = time();

    if ($modello_scelto != "") {
        echo "<p>Dati relativi al Modello " . $modello_scelto . "</p>";

        $query3 = "select count(msisdn1) as cnt, marca1, modello1 FROM (
            select * from(
            SELECT
                u1.IMEI as imei1,
                dati_tacid.Modello AS modello1,
                dati_tacid.Marca AS marca1,
                u1.MSISDN msisdn1
            FROM " . TABLE1 . " AS u1 left join dati_tacid on u1.TAC=dati_tacid.TacId
            where dati_tacid.Modello='$modello_scelto' group by MSISDN
         as table1)
         inner join (
        SELECT
                u1.IMEI as imei11,
                dati_tacid.Modello AS modello11,
                dati_tacid.Marca AS marca11,
                u1.MSISDN msisdn11
            FROM " . TABLE2 . " AS u1 left join dati_tacid on u1.TAC=dati_tacid.TacId
            where dati_tacid.Modello='$modello_scelto' group by MSISDN
         as table2 ) on table1.msisdn1=table2.msisdn11) as tabella_join)

        ";
        echo $query3;
    } else
        $query3 = "select count(distinct emo.IMEI) as cnt, dati_tacid.Modello ,dati_tacid.Marca, emo.TAC from
            (SELECT u1.IMEI, u1.MSISDN,u1.Tac,u2.MSISDN
      FROM " . TABLE2 . " AS u1
      LEFT JOIN  " . TABLE1 . "  AS u2 ON u1.MSISDN = u2.MSISDN) as emo
        left join dati_tacid on emo.TAC=dati_tacid.TacId group by dati_tacid.Modello";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    //echo $query3;
    echo "<table border =1>";
    echo "<tr><td>Numero Terminali</td><td>Marca</td><td>Modello</td><tr>";

    while ($obj3 = mysqli_fetch_array($result3)) {
        if ($obj3['marca1'] == "")
            $nome_marca = "N/A";
        else
            $nome_marca = $obj3['marca1'];

        if ($obj3['modello1'] == "")
            $nome_modello = "N/A";
        else
            $nome_modello = $obj3['modello1'];

        echo "<tr><td> " . $obj3['cnt'] . "</td><td>" . $nome_marca . " </td><td>" . $nome_modello . " </td><tr>";
    }
    echo "</table>";
    $fine = time();
    $tempo_impiegato = $fine - $inizio;
    echo "<br><p>Tempo query:" . $tempo_impiegato . "</p>";
}

function tabella_statistiche_excel($table, $nome_new_table) {
    $db_link = connect_db_li();

    $query3 = "create Table $nome_new_table
    select * from(

        select Tac as Tac1,
            sum( Voce_out_on_net) as Voce_out_on_net_S,
            sum( Voce_out_roaming) as Voce_out_roaming_S,
            sum( Voce_in_on_net) as Voce_in_on_net_S,
            sum( Voce_in_roaming) as Voce_in_roaming_S,
            sum( n_MMS_off_net) as n_MMS_off_net,
            sum( n_MMS_on_net) as n_MMS_on_net,
            sum( n_Portale) as n_Portale

        from $table group by Tac1

    ) as stat
    left join (

            select count(distinct IMEI) as numero_S,  Tac as Tac2
            from $table  group by Tac2
    ) AS stat2 on stat.Tac1=stat2.Tac2
    ";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "<p>Operazione riuscita cno successo</p>";

    $query = " ALTER TABLE `$nome_new_table` ENGINE = MYISAM ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = "ALTER TABLE `$nome_new_table` ADD PRIMARY KEY ( `Tac1` )  ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = "insert into lista_tabelle (nome_tabella) values ('$nome_new_table') ";
    $result3 = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
}

function tabella_particolari_sottoinsieme($old_table, $table, $lista_tel, $lista_os = "", $cap = False, $rat = False) {
    $db_link = connect_db_li();
    //print_r($lista_tel);
    $tabella_dati_origine = $old_table;
    //print_r($lista_os);
    if ($cap == TRUE) {
        $cap_parametri = " ,comune,cap,provincia";
        $cap_join = "  JOIN cod_port_cap ON `PortfolioId` = codice_port ";
    } else {
        $cap_join = "";
        $cap_parametri = "";
    }
    if ($rat != false) {
        $rat_filter = " and mobile_radio_access = '" . $rat . "'";
    } else {
        $rat_filter = "";
    }
    $query3 = "create table $table SELECT `$tabella_dati_origine`.*, RIGHT(" . $tabella_dati_origine . ".IMEI_SV, 2) as imei_sv_trim,
`dati_tacid`.TacId,
`dati_tacid`.Marca as Marca1,
`dati_tacid`.Modello as Modello1,
`dati_tacid`.Tecnologia,
`dati_tacid`.Tipo,
`dati_tacid`.mobile_radio_access,
`dati_tacid`.OS $cap_parametri
FROM `dati_tacid`
 right JOIN `socmanager`.`$tabella_dati_origine` ON `dati_tacid`.`TacId` = `$tabella_dati_origine`.`Tac` $cap_join Where 1 $rat_filter ";
    $numero_condizioni = 0;
    if ($lista_tel != "") {

        $query3 = $query3 . " AND (";
        if ($lista_tel[0] != "") {
            $numero_condizioni = $numero_condizioni + 1;
            //$query3 = $query3 . " `dati_tacid`.Modello='" . $lista_tel[0] . "'";
            //
        for ($i = 0; $i < count($lista_tel); $i++) {
                if ($i == 0)
                    $query3 = $query3 . "";
                else
                    $query3 = $query3 . " or ";
                $query3 = $query3 . " `dati_tacid`.Modello='" . $lista_tel[$i] . "'";
            }
            $query3 = $query3 . " ) ";
        }
    }
    if ($lista_os != "") {
        //if ($numero_condizioni != 0)
        $query3 = $query3 . " AND  (";

        for ($k = 0; $k < count($lista_os); $k++) {
            if ($k == 0)
                $query3 = $query3 . "";
            else
                $query3 = $query3 . " or ";
            $query3 = $query3 . " `dati_tacid`.OS='" . $lista_os[$k] . "'";
        }
        $query3 = $query3 . " ) ";
    }
    echo "<p>$query3</p>";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "<p>Operazione riuscita cno successo Imei Totali</p>";

    $query = " ALTER TABLE `$table` ENGINE = MYISAM ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = "ALTER TABLE `$table` ADD PRIMARY KEY ( `id` )  ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
}

function tabella_statistiche_particolari($table, $nome_new_table, $filtro, $imei_sv = "n", $tariffa = "n", $tariffa_dati = "n") {
    $db_link = connect_db_li();
    //echo $imei_sv."<br>";

    if ($imei_sv == "y") {
        $imei_sv_filter = ",VERSION_SV";
        $imei_sv_filter3 = ",VERSION_SV as VERSION_SV_2";
        $imei_sv_filter2 = " and stat.VERSION_SV=stat2.VERSION_SV_2";
    } elseif ($tariffa == "y") {
        $imei_sv_filter = ",Piano_Tariffario";
        $imei_sv_filter3 = ",Piano_Tariffario as Piano_Tariffario_2";
        $imei_sv_filter2 = "and stat.Piano_Tariffario=stat2.Piano_Tariffario_2";
    } else {
        $imei_sv_filter = "";
        $imei_sv_filter2 = "";
        $imei_sv_filter3 = "";
    }
    if ($tariffa_dati == "y")
        $operazione = " sum(traffico) as tariffa_dati, ";
    else
        $operazione = "";
    // echo "filtro".$imei_sv_filter.$imei_sv_filter2.$imei_sv_filter3;
    $query3 = "create Table $nome_new_table
    select * from(

        select Tac as Tac1,$operazione
            sum( Voce_out_on_net) as Voce_out_on_net_S,
            sum( Voce_out_roaming) as Voce_out_roaming_S,
            sum( Voce_in_on_net) as Voce_in_on_net_S,
            sum( n_MMS_off_net) as n_MMS_off_net,
            sum( n_MMS_on_net) as n_MMS_on_net,
            sum( n_Portale) as n_Portale,
            sum(Voce_in_roaming) as Voce_in_roaming_S,
			sum(`vol_eventi` ) as vol_eventi,
			sum( `VOLUME_EVENTI_H3G_LTE` ) as VOLUME_EVENTI_H3G_LTE,
			sum( `VOLUME_EVENTI_ROAMING_ITZ` ) as VOLUME_EVENTI_ROAMING_ITZ,
			sum( `VOLUME_EVENTI_ROAMING_NAZ` ) as VOLUME_EVENTI_ROAMING_NAZ,
			sum(`VOLUME_EVENTI_H3G_3G`) as VOLUME_EVENTI_H3G_3G

    $imei_sv_filter
        from $table $filtro group by Tac1 $imei_sv_filter

    ) as stat
    left join (

            select count(distinct IMEI) as numero_S,  Tac as Tac2 $imei_sv_filter3
            from $table  group by Tac2 $imei_sv_filter
    ) AS stat2 on stat.Tac1=stat2.Tac2 $imei_sv_filter2
    ";
    echo "<br>" . $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "<p>Operazione riuscita cno successo</p>";

    $query = " ALTER TABLE `$nome_new_table` ENGINE = MYISAM ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
    $query = "ALTER TABLE `$nome_new_table` ADD PRIMARY KEY ( `Tac1` )  ";
    if (!mysqli_query($db_link,$query)) {
        echo "<br>" . $query;
    }
}

function tabella_statistiche_traffico_excel($table, $MSISDN = "") {
    $db_link = connect_db_li();


    $query3 = "SELECT $table.`MSISDN` , $table.`Tac` , `$table`.`PortfolioId` , `dati_utenti_traffico`.`codice_portafoglio` , sum( `dati_utenti_traffico`.`traffico` ) as volume_Dati
FROM  $table
LEFT JOIN `dati_utenti_traffico` ON `$table`.`PortfolioId` = `dati_utenti_traffico`.`codice_portafoglio`
GROUP BY Tac";
//echo "<br>".$query3."<br>";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello  \t  Volume Dati (GB) \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

//$volume_Dati = round($obj3['volume_Dati'] / 1000000, 3);
        $volume_Dati = $obj3['volume_Dati'];
        $volume_Dati_str = str_replace(",", ".", $volume_Dati);


        echo $nome_marca . ";" . $nome_modello . ";" . str_replace(".", ",", $volume_Dati) . ";";
    }
}

function export_statistiche_solo_voce($table, $imei_sv = "n", $tariffa = "n", $tariffa_dati = "n") {

    $db_link = connect_db_li();
    $today = date("y_m_d");
    header("Content-Disposition: attachment; filename=\"" . $today . "_Statistiche_$table.xls\"");
    header("Content-Type: application/vnd.ms-excel");

    if ($tariffa_dati == "y") {
        $operazione = " sum(tariffa_dati) as tariffa_dati_tot, ";
        $stampa_traffico_tariffa_header = " \t Traffico dati ";
    } else {
        $operazione = "";
        $stampa_traffico_tariffa_header = "";
    }
    if ($imei_sv == "y") {
        $imei_sv_filter = ",VERSION_SV";
        $FR_var = "";
        $FR_calcolo = "";
    } elseif ($tariffa == "y") {
        $imei_sv_filter = ",Piano_Tariffario_2";
        $FR_var = "";
        $FR_calcolo = "";
    } else {
        $imei_sv_filter = "";
        $FR_calcolo = ",
    (Voce_out_roaming_tot+Voce_in_roaming_tot-Voce_out_roaming_tot_FR-Voce_in_roaming_tot_FR)/(Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot-Voce_out_on_net_tot_FR-Voce_out_roaming_tot_FR-Voce_in_on_net_tot_FR-Voce_in_roaming_tot_FR) as percentuale_roaming_FR";
        $FR_var = ",sum( Voce_out_on_net_FR) as Voce_out_on_net_tot_FR,
      sum( Voce_out_roaming_FR) as Voce_out_roaming_tot_FR,
      sum( Voce_in_on_net_FR) as Voce_in_on_net_tot_FR,
      sum( Voce_in_roaming_FR) as Voce_in_roaming_tot_FR,
      sum( numero_full_roamers) as numero_full_roamers_FR";
    }
    $flag = false;

    $query3 = "
select *,
    (Voce_out_roaming_tot+Voce_in_roaming_tot)/(Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot) as percentuale_roaming,
    (Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot)/n_modello_tot as voce_terminale
    $FR_calcolo
     from (
    select $operazione
        dati_tacid.Marca,dati_tacid.Modello,Tecnologia,Tipo,numero_S,Tac1,OS,
        sum(numero_S) as n_modello_tot,
        sum( Voce_out_on_net_S) as Voce_out_on_net_tot,
        sum( Voce_out_roaming_S) as Voce_out_roaming_tot,
        sum( Voce_in_on_net_S) as Voce_in_on_net_tot,
        sum( Voce_in_roaming_S) as Voce_in_roaming_tot
         $FR_var      $imei_sv_filter
    from $table left join dati_tacid
    on $table.Tac1=dati_tacid.TacId
    group by dati_tacid.Modello $imei_sv_filter

    ) as stat order by n_modello_tot desc";
    echo $query3 . "\n";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    if ($imei_sv == "y")
        $stampa_FR = " VERSION_SV \t";
    elseif ($tariffa == "y")
        $stampa_FR = " Piano_Tariffario_2 \t";
    else
        $stampa_FR = " numero_full_roamers_FR \t Voce out on net_FR \t Voce out roaming_FR \t Voce in on net_FR \t Voce in roaming_FR \t %roaming_FR \t";


    echo "Alias \t Marca \t Modello  \t Tecnologia \t Tipo  \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t Voce terminale  \t %roaming  \t $stampa_FR OS $stampa_traffico_tariffa_header \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        if ($imei_sv == "y")
            $stampa_FR = trim($obj3['VERSION_SV']) . " \t ";
        elseif ($tariffa == "y")
            $stampa_FR = trim($obj3['Piano_Tariffario_2']) . " \t ";
        else
            $stampa_FR = str_replace(".", ",", $obj3['numero_full_roamers_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot_FR']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming_FR']) . " \t";


        if ($tariffa_dati == "y") {
            $stampa_traffico_tariffa = " \t " . str_replace(".", ",", $obj3['tariffa_dati_tot']);
        } else {
            $stampa_traffico_tariffa = "";
        }

        echo substr($nome_marca, 0, 3) . " " . $nome_modello . " \t " . $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['n_modello_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['voce_terminale']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming']) . " \t " . $stampa_FR . trim($obj3['OS']) . $stampa_traffico_tariffa . " \n";
    }
}

function export_statistiche($table) {

    $db_link = connect_db_li();
    $today = date("y_m_d");
    header("Content-Disposition: attachment; filename=\"" . $today . "_Statistiche_$table.xls\"");
    header("Content-Type: application/vnd.ms-excel");
    $label[] = '3ITA';
    //$label[] = 'FR';
    if (($table == "febbraio2013") || ($table == "gennaio2013") || ($table == "dicembre2012") || ($table == "novembre2012")) {
        $label[] = 'PRE_PAY';
        $label[] = 'POST_PAY';
        $label[] = 'PRE_3ITA';
        $label[] = 'POST_3ITA';
        $label[] = '3ITA_FullRoamers';
        $label[] = '3ITA_FullRoamers_POST';
        $label[] = '3ITA_FullRoamers_PRE';
        $label[] = 'FullRoamers_PRE';
        $label[] = 'FullRoamers_POST';
        $label[] = 'FullRoamers';
    }


    $flag = false;
    $query3 = "
      select *,
      (Voce_out_roaming_tot+Voce_in_roaming_tot)/(Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot) as percentuale_roaming,
      (Voce_out_roaming_tot+Voce_in_roaming_tot-Voce_out_roaming_tot_FR-Voce_in_roaming_tot_FR)/(Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot-Voce_out_on_net_tot_FR-Voce_out_roaming_tot_FR-Voce_in_on_net_tot_FR-Voce_in_roaming_tot_FR) as percentuale_roaming_FR,
      (Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot)/n_modello_tot as voce_terminale,
      volume_Dati_tot/n_modello_tot as traffico_terminale,
      (mc4_tot/(mc2_tot+mc3_tot+mc4_tot)) as percentuale_drop";
    foreach ($label as $key => $value) {
        $query3.=",(Voce_out_roaming_tot_$value+Voce_in_roaming_tot_$value)/(Voce_out_on_net_tot_$value+Voce_out_roaming_tot_$value+Voce_in_on_net_tot_$value+Voce_in_roaming_tot_$value) as percentuale_roaming_$value";
    }
    $query3.="
    from (
      select
      dati_tacid.Marca,dati_tacid.Modello,Tecnologia,Tipo,numero_S,Tac1,OS,
      sum(numero_S) as n_modello_tot,
      sum(volume_Dati) as volume_Dati_tot,
      sum(Voce_out_on_net_S) as Voce_out_on_net_tot,
      sum(Voce_out_roaming_S) as Voce_out_roaming_tot,
      sum(Voce_in_on_net_S) as Voce_in_on_net_tot,
      sum(Voce_in_roaming_S) as Voce_in_roaming_tot,
      sum(Voce_out_on_net_FR) as Voce_out_on_net_tot_FR,
      sum(Voce_out_roaming_FR) as Voce_out_roaming_tot_FR,
      sum(Voce_in_on_net_FR) as Voce_in_on_net_tot_FR,
      sum(Voce_in_roaming_FR) as Voce_in_roaming_tot_FR,
      sum(numero_full_roamers) as numero_full_roamers_FR,
      sum(mc2) as mc2_tot,
      sum(mc3) as mc3_tot,
      sum(mc4) as mc4_tot ";
    foreach ($label as $key => $value) {
        $query3.="
      ,sum(Voce_out_on_net_$value) as Voce_out_on_net_tot_$value,
      sum(Voce_out_roaming_$value) as Voce_out_roaming_tot_$value,
      sum(Voce_in_on_net_$value) as Voce_in_on_net_tot_$value,
      sum(Voce_in_roaming_$value) as Voce_in_roaming_tot_$value,
      sum(numero_$value) as numero_tot_$value";
    }
    $query3.=" from $table left join dati_tacid
      on $table.Tac1=dati_tacid.TacId
      group by dati_tacid.Modello

      ) as stat order by n_modello_tot desc";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Alias \t Marca \t Modello  \t Tecnologia \t Tipo  \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t Voce terminale \t Traffico Terminale KB \t %roaming \t %drop \t volume dati totale KB \t numero_full_roamers_FR \t Voce out on net_FR \t Voce out roaming_FR \t Voce in on net_FR \t Voce in roaming_FR \t %roaming senza FR \t OS ";
    foreach ($label as $key => $value) {
        echo " \t numero_tot_$value \t  Voce_out_on_net_tot_$value \t Voce_out_roaming_tot_$value \t Voce_in_on_net_tot_$value \t Voce_in_roaming_$value \t %roaming_$value ";
    }
    echo "\t mc2 \t mc3 \t mc4 \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        echo substr($nome_marca, 0, 3) . " " . $nome_modello . " \t " . $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['n_modello_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['voce_terminale']) . " \t " . str_replace(".", ",", $obj3['traffico_terminale']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming']) . " \t " . str_replace(".", ",", $obj3['percentuale_drop']) . " \t " . str_replace(".", ",", $obj3['volume_Dati_tot']) . " \t " . str_replace(".", ",", $obj3['numero_full_roamers_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot_FR']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot_FR']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming_FR']) . " \t " . trim($obj3['OS']);
        foreach ($label as $key => $value) {
            echo " \t " . str_replace(".", ",", $obj3['numero_tot_' . $value]) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot_' . $value]) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot_' . $value]) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot_' . $value]) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot_' . $value]) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming_' . $value]);
        }
        echo " \n";
    }
}

function export_statistiche_tacid($table) {

    $db_link = connect_db_li();
    $today = date("y_m_d");
    header("Content-Disposition: attachment; filename=\"" . $today . "_Statistiche_TAC_$table.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;
    $query3 = "
select *,
    (Voce_out_roaming_tot+Voce_in_roaming_tot)/(Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot) as percentuale_roaming,
    (Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot)/n_modello_tot as voce_terminale,
    volume_Dati_tot/n_modello_tot as traffico_terminale,
    (mc4_tot/(mc2_tot+mc3_tot+mc4_tot)) as percentuale_drop
     from (
    select
        dati_tacid.Marca,dati_tacid.Modello,Tecnologia,Tipo,numero_S,Tac1,
        numero_S as n_modello_tot,
        volume_Dati as volume_Dati_tot,
        Voce_out_on_net_S as Voce_out_on_net_tot,
        Voce_out_roaming_S as Voce_out_roaming_tot,
        Voce_in_on_net_S as Voce_in_on_net_tot,
        Voce_in_roaming_S as Voce_in_roaming_tot,
       mc2 as mc2_tot,
        mc3 as mc3_tot,
        mc4 as mc4_tot
    from $table left join dati_tacid
    on $table.Tac1=dati_tacid.TacId
    ) as stat order by n_modello_tot desc";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Tac1 \t Marca \t Modello  \t Tecnologia \t Tipo  \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t Voce terminale \t traffico_terminale \t %roaming \t %drop \t mc2 \t mc3 \t mc4 \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        echo trim($obj3['Tac1']) . " \t " . $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['n_modello_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['voce_terminale']) . " \t " . str_replace(".", ",", $obj3['traffico_terminale']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming']) . " \t " . str_replace(".", ",", $obj3['percentuale_drop']) . " \t " . str_replace(".", ",", $obj3['mc2_tot']) . " \t " . str_replace(".", ",", $obj3['mc3_tot']) . " \t " . str_replace(".", ",", $obj3['mc4_tot']) . " \n";
    }
}

function export_table_imeisv() {

    $db_link = connect_db_li();
    $today = date("Ymd");
    header("Content-Disposition: attachment; filename=\"Decodifica_SV_" . $today . ".csv\"");
    header("Content-Type: application/csv");


    $flag = false;
    $query3 = "SELECT * FROM  `imei_sv_tot` ";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    while ($obj3 = mysqli_fetch_array($result3)) {
        echo trim($obj3['TacId']) . ";" . trim($obj3['B']) . ";" . trim($obj3['C']) . "\n";
    }
}

function export_table_query($query) {

    $db_link = connect_db_li();
    $today = date("Ymd");
    header("Content-Disposition: attachment; filename=\"export_query_" . $today . ".csv\"");
    header("Content-Type: application/csv");


    $flag = false;
    $query3 = base64_decode($query);
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $num_campi = mysqli_num_fields($result3);

    for ($i = 0; $i < $num_campi; $i++){
        #echo mysql_field_name($result3, $i) . ';';
        $colObj = mysqli_fetch_field_direct($result3,$i);                            
        $col = $colObj->name;
        echo $col. ';';
    }
        
    echo "\n";
    

    while ($obj3 = mysqli_fetch_array($result3)) {
        //print_r($obj3);
        for ($i = 0; $i < count($obj3) / 2; $i++)
            echo trim($obj3[$i]) . ";";
        echo "\n";
    }
}

function export_table_tacid() {

    $db_link = connect_db_li();
    $today = date("Ymd");
    header("Content-Disposition: attachment; filename=\"IMEI_" . $today . ".txt\"");
    header("Content-Type: application/csv");


    $flag = false;
    $query3 = "SELECT * FROM  `dati_tacid` ";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    while ($obj3 = mysqli_fetch_array($result3)) {
        $tecnologia = "";
        if ($obj3['mobile_radio_access'] == "3G")
            $tecnologia = "UMTS";
        elseif ($obj3['mobile_radio_access'] == "2g")
            $tecnologia = "Altro";
        // =SE(E28="HANDSET";SE(G28="YES";"SMARTPHONE";"TELEFONO");SE(E28="TABLET";"TABLET";"DATACARD"))
        $tipo = "";
        if ($obj3['Tipo'] == "Smartphone")
            $tipo = "SMARTPHONE";
        elseif ($obj3['Tipo'] == "Featurephone")
            $tipo = "TELCO";
        elseif ($obj3['Tecnologia'] == "Tablet")
            $tipo = "TABLET";
        elseif ($obj3['Tecnologia'] == "Phablet")
            $tipo = "SMARTPHONE";
        elseif ($obj3['Tecnologia'] == "Datacard" || $obj3['Tecnologia'] == "MBB")
            $tipo = "DATACARD";
        else
            $tipo = "TELCO";


        echo trim(str_replace(";", "", $obj3['TacId'])) . ";" . trim(str_replace(";", "", $obj3['Marca'])) . ";" . trim(str_replace(";", "", $obj3['Modello'])) . ";" . $tecnologia . ";" . $tipo . ";;;" . "\n";
    }
}

function export_radar($table) {

    $db_link = connect_db_li();
    $today = date("y_m_d");
    header("Content-Disposition: attachment; filename=\"" . $today . "_radar.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;
    $query3 = "
select *,
    (Voce_out_roaming_tot+Voce_in_roaming_tot)/(Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot) as percentuale_roaming,
    (Voce_out_on_net_tot+Voce_out_roaming_tot+Voce_in_on_net_tot+Voce_in_roaming_tot)/n_modello_tot as voce_terminale,
    volume_Dati_tot/n_modello_tot as traffico_terminale
     from (
    select
        dati_tacid.Marca,dati_tacid.Modello,Tecnologia,Tipo,numero_S,Tac1,
    sum(numero_S) as n_modello_tot,
        sum( volume_Dati) as volume_Dati_tot,
        sum( Voce_out_on_net_S) as Voce_out_on_net_tot,
        sum( Voce_out_roaming_S) as Voce_out_roaming_tot,
        sum( Voce_in_on_net_S) as Voce_in_on_net_tot,
        sum( Voce_in_roaming_S) as Voce_in_roaming_tot
    from $table left join dati_tacid
    on $table.Tac1=dati_tacid.TacId
    group by dati_tacid.Modello

    ) as stat";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello  \t Tecnologia \t Tipo  \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t Voce terminale \t %roaming \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['n_modello_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_tot']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_tot']) . " \t " . str_replace(".", ",", $obj3['voce_terminale']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming']) . " \n";
    }
}

function tabella_statistiche_excel_full_roamers($table) {

    $db_link = connect_db_li();
    $today = date("y_m_d");
    header("Content-Disposition: attachment; filename=\"" . $today . "_Statistiche_full_roamers.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;
    $query3 = "
select *,
    (Voce_out_roaming_S+Voce_in_roaming_S)/(Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S) as percentuale_roaming,
    (Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S)/numero_S as voce_terminale
     from (
    select
        dati_tacid.Modello,Tecnologia,Tipo,
        sum( volume_Dati) as volume_Dati_S,
        sum( Voce_out_on_net) as Voce_out_on_net_S,
        sum( Voce_out_roaming) as Voce_out_roaming_S,
        sum( Voce_in_on_net) as Voce_in_on_net_S,
        sum( Voce_in_roaming) as Voce_in_roaming_S,
        sum( n_MMS_off_net) as n_MMS_off_net,
        sum( n_MMS_on_net) as n_MMS_on_net,
        sum( n_Portale) as n_Portale

    from $table left join dati_tacid on $table.TAC=dati_tacid.TacId
    where (Voce_in_roaming +Voce_out_roaming)/( Voce_out_roaming+ Voce_in_roaming + Voce_out_on_net + Voce_in_on_net)*100<15
    group by dati_tacid.Modello

    ) as stat left join (


    select count(distinct IMEI) as numero_S, dati_tacid.Modello ,dati_tacid.Marca, TAC
    from $table left join dati_tacid on $table.TAC=dati_tacid.TacId     where (Voce_in_roaming +Voce_out_roaming)/( Voce_out_roaming+ Voce_in_roaming + Voce_out_on_net + Voce_in_on_net)*100<15
group by dati_tacid.Modello

    ) AS stat2 ON stat.Modello = stat2.Modello";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello  \t Tecnologia \t Tipo  \t n_Modello \t n_MMS_off_net \t n_MMS_on_net \t n_Portale \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t Voce terminale \t %roaming \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \t " . str_replace(".", ",", $obj3['n_MMS_off_net']) . " \t " . str_replace(".", ",", $obj3['n_MMS_on_net']) . " \t " . str_replace(".", ",", $obj3['n_Portale']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_S']) . " \t " . str_replace(".", ",", $obj3['voce_terminale']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming']) . " \n";
    }
}

function tabella_statistiche_numero_terminali_excel($table) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"numero_terminali.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "select count(distinct IMEI) as numero_S, dati_tacid.Modello ,dati_tacid.Marca, TAC
    from $table left join dati_tacid on $table.TAC=dati_tacid.TacId group by dati_tacid.Modello";
// $query3 = "select count(distinct IMEI) as numero_S,  TAC from $table  group by TAC";
//echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello \t n Terminali  \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];


        echo $nome_marca . " \t " . $nome_modello . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \n";
    }
}

function multiaxes_datacard_traffico_dati($table, $condizioni, $unita_misura, $scala, $limite_terminali = 5000) {
    $db_link = connect_db_li();


//$query3 = "select * from(select sum(numero_S) as numero_datacard,sum(volume_Dati)/sum(numero_S) as volume_Dati2 , dati_tacid.Modello ,dati_tacid.Marca, Tac1     from $table  inner join dati_tacid on $table.Tac1=dati_tacid.TacId inner join tac_h3g on dati_tacid.TacId=id_tac  where Tecnologia='datacard' OR Tecnologia='ROUTER' group by Modello) as lista_datacard where numero_datacard>$limite_terminali   order by volume_Dati2 desc LIMIT 0 , 30";
    $query3 = "select * from(select sum(numero_S) as numero_datacard,sum(volume_Dati)/sum(numero_S) as volume_Dati2 , dati_tacid.Modello ,dati_tacid.Marca, Tac1     from $table  inner join dati_tacid on $table.Tac1=dati_tacid.TacId   $condizioni group by Modello) as lista_datacard where numero_datacard>$limite_terminali   order by volume_Dati2 desc LIMIT 0 , 20";
//echo $query3 . "<br>";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
//echo "Marca;Modello;numero_datacard;volume_Dati2<br>";
    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        $lista_nomi[] = substr($nome_marca, 0, 3) . " " . $nome_modello;
        $lista_valori1[] = $obj3['numero_datacard'];
        $lista_valori2[] = $obj3['volume_Dati2'];
//echo $nome_marca . ";" . $nome_modello . ";" . str_replace(".", ",", $obj3['numero_datacard']) . ";" . str_replace(".", ",", $obj3['volume_Dati2']) . "<br>";
    }
    multi_axes($lista_valori1, $lista_valori2, $lista_nomi, "# Devices", "Data traffic", 1000, $scala, "k", $unita_misura);
}

function multiaxes_telefoni_roaming($table, $limite_terminali = 5000, $h3g = False) {
    $db_link = connect_db_li();
    if ($h3g)
        $filtro_h3g = " inner join tac_h3g on $table.Tac1=tac_h3g.id_tac ";
    else
        $filtro_h3g = "";
    $query3 = "select * from(
select sum(numero_S) as numero_telefoni,
    (sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S))/(sum(Voce_out_on_net_S)+sum(Voce_out_roaming_S)+sum(Voce_in_on_net_S)+sum(Voce_in_roaming_S)) as percentuale_roaming,
    dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table $filtro_h3g inner join dati_tacid on $table.Tac1=dati_tacid.TacId
    where Tecnologia='Handset' group by Modello) as lista_telefoni where numero_telefoni>$limite_terminali
    order by numero_telefoni desc LIMIT 0 , 30";
//echo $query3 . "<br>";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
//echo "Marca;Modello;numero_datacard;volume_Dati2<br>";
    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        $lista_nomi[] = substr($nome_marca, 0, 3) . " " . $nome_modello;
        $lista_valori1[] = $obj3['numero_telefoni'];
        $lista_valori2[] = $obj3['percentuale_roaming'];
//echo $nome_marca . ";" . $nome_modello . ";" . str_replace(".", ",", $obj3['numero_datacard']) . ";" . str_replace(".", ",", $obj3['volume_Dati2']) . "<br>";
    }
    multi_axes($lista_valori1, $lista_valori2, $lista_nomi, "# Devices", "% roaming", 1000, 0.01, "k", "%");
}

function multiaxes_telefoni_drop($table, $limite_terminali = 5000, $h3g = False) {
    $db_link = connect_db_li();
    if ($h3g)
        $filtro_h3g = " inner join tac_h3g on $table.Tac1=tac_h3g.id_tac ";
    else
        $filtro_h3g = "";
    $query3 = "select * from(
select sum(numero_S) as numero_telefoni,
    (sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4))) as percentuale_drop,
    dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table $filtro_h3g inner join dati_tacid on $table.Tac1=dati_tacid.TacId
    where Tecnologia='Handset' group by Modello) as lista_telefoni where numero_telefoni>$limite_terminali
    order by numero_telefoni desc LIMIT 0 , 30";
//echo $query3 . "<br>";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
//echo "Marca;Modello;numero_datacard;volume_Dati2<br>";
    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        $lista_nomi[] = substr($nome_marca, 0, 3) . " " . $nome_modello;
        $lista_valori1[] = $obj3['numero_telefoni'];
        $lista_valori2[] = $obj3['percentuale_drop'];
//echo $nome_marca . ";" . $nome_modello . ";" . str_replace(".", ",", $obj3['numero_datacard']) . ";" . str_replace(".", ",", $obj3['volume_Dati2']) . "<br>";
    }
    multi_axes($lista_valori1, $lista_valori2, $lista_nomi, "# devices", "% drop", 1000, 0.01, "k", "%");
}

function radar_performance($table, $nome_terminale) {
    $db_link = connect_db_li();
    $query3 = "select * from(
select sum(numero_S) as numero_telefoni,
    (sum(Voce_out_roaming_S)+sum(Voce_in_roaming_S))/(sum(Voce_out_on_net_S)+sum(Voce_out_roaming_S)+sum(Voce_in_on_net_S)+sum(Voce_in_roaming_S)) as percentuale_roaming,
    (sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4))) as percentuale_drop,
    dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  inner join dati_tacid on $table.Tac1=dati_tacid.TacId
    where Tecnologia='Handset' group by Modello) as lista_telefoni where dati_tacid.Modello=$nome_terminale
    order by numero_telefoni desc LIMIT 0 , 30";
//echo $query3 . "<br>";
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
//echo "Marca;Modello;numero_datacard;volume_Dati2<br>";
    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        $lista_nomi[] = $nome_modello;
        $lista_valori1[] = $obj3['percentuale_roaming'];
        $lista_valori2[] = $obj3['percentuale_drop'];
//echo $nome_marca . ";" . $nome_modello . ";" . str_replace(".", ",", $obj3['numero_datacard']) . ";" . str_replace(".", ",", $obj3['volume_Dati2']) . "<br>";
    }
    radar($lista_valori1, $lista_valori2, $lista_nomi, "% roaming", "% drop", 0.001, 0.001, "%", "%");
}

function drop_roaming($table, $nome_terminale, $piano, $fullroamers) {

    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    $risultato[0] = $nome_terminale;
    $parametro_di_ricerca = "Modello";

    $tipo_terminale = "(Tecnologia='Handset' or Tecnologia='Tablet' or Tecnologia='Phablet')";
    $tot_2g = _valori($table, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $nome_terminale . "' ", $tipo_terminale);
    $tot_3g = _valori($table, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $nome_terminale . "' ", $tipo_terminale);
    $tot_2g_FR = 0;
    $tot_3g_FR = 0;
    if ($fullroamers == TRUE) {
        $tot_2g_FR = _valori($table, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $nome_terminale . "' ", $tipo_terminale);
        $tot_3g_FR = _valori($table, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $nome_terminale . "' ", $tipo_terminale);
    }

    if (($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR) > 0) {
        $risultato[1] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);
    } else
        $risultato[1] = 0;
    $risultato[2] = _valori($table, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $nome_terminale . "' ", $tipo_terminale);
    return $risultato;
}

function torta_vendor_datacard($table) {
    $db_link = connect_db_li();


    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where Tecnologia='datacard' or Tecnologia='MBB' group by dati_tacid.Marca order by numero_terminali desc LIMIT 0 , 8";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];
        $numero_terminali_top = $numero_terminali_top + $obj3['numero_terminali'];
        $lista_nomi[] = $nome_marca;
        $lista_valori[] = $obj3['numero_terminali'];
    }
    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where Tecnologia='datacard' or Tecnologia='MBB'   order by numero_terminali desc ";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_array($result3)) {
        $numero_terminali = $obj3['numero_terminali'];
        $altri = $numero_terminali - $numero_terminali_top;
        $lista_nomi[] = "ALTRI";
        $lista_valori[] = $altri;
    }


    torta($lista_valori, $lista_nomi);
    echo "<br><table align=center style=\"width:300px\"><thead><tr><th>Marca</th><th>n Terminali</th><tr></thead><tbody>";
    foreach ($lista_valori as $key => $value) {

        echo "<tr><th>" . $lista_nomi[$key] . "</th><td>" . $value . "</td></tr>";
    }
    echo "</tbody><tfoot><tr><th>Totale</th><th>$numero_terminali</th><tr></tfoot></table>";
}

function torta_vendor_telefoni($table, $filtro) {
    $db_link = connect_db_li();


    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where  $filtro group by dati_tacid.Marca order by numero_terminali desc LIMIT 0 , 9";
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];
        $numero_terminali_top = $numero_terminali_top + $obj3['numero_terminali'];
        $lista_nomi[] = $nome_marca;
        $lista_valori[] = $obj3['numero_terminali'];
    }

    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where   $filtro   order by numero_terminali desc ";
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $numero_terminali = $obj3['numero_terminali'];
    $altri = $numero_terminali - $numero_terminali_top;
    $lista_nomi[] = "ALTRI";
    $lista_valori[] = $altri;

    torta($lista_valori, $lista_nomi);
    echo "<br><table align=center style=\"width:300px\"><thead><tr><th>Marca</th><th>n Terminali</th><tr></thead><tbody>";
    foreach ($lista_valori as $key => $value) {

        echo "<tr><th>" . $lista_nomi[$key] . "</th><td>" . $value . "</td></tr>";
    }
    echo "</tbody><tfoot><tr><th>Totale</th><th>$numero_terminali</th><tr></tfoot></table>";
}

function home_torta_vendor_telefoni($table, $filtro, $title, $sottotitolo, $size) {
    $db_link = connect_db_li();


    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where  $filtro group by dati_tacid.Marca order by numero_terminali desc LIMIT 0 , 9";
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];
        $numero_terminali_top = $numero_terminali_top + $obj3['numero_terminali'];
        $lista_nomi[] = $nome_marca;
        $lista_valori[] = $obj3['numero_terminali'];
    }

    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where   $filtro   order by numero_terminali desc ";
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $obj3 = mysqli_fetch_array($result3);
    $numero_terminali = $obj3['numero_terminali'];
    $altri = $numero_terminali - $numero_terminali_top;
    $lista_nomi[] = "ALTRI";
    $lista_valori[] = $altri;

    home_torta($lista_valori, $lista_nomi, $title, $sottotitolo, $size);
    /*
    echo "<br><table align=center style=\"width:300px\"><thead><tr><th>Marca</th><th>n Terminali</th><tr></thead><tbody>";
    foreach ($lista_valori as $key => $value) {

        echo "<tr><th>" . $lista_nomi[$key] . "</th><td>" . $value . "</td></tr>";
    }
    echo "</tbody><tfoot><tr><th>Totale</th><th>$numero_terminali</th><tr></tfoot></table>";
     * 
     */
}


function torta_vendor_tablet($table) {
    $db_link = connect_db_li();


    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where Tecnologia='tablet' group by dati_tacid.Marca order by numero_terminali desc LIMIT 0 , 8";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    $numero_terminali_top = 0;
    $lista_nomi;
    $lista_valori;

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];
        $numero_terminali_top = $numero_terminali_top + $obj3['numero_terminali'];
        $lista_nomi[] = $nome_marca;
        $lista_valori[] = $obj3['numero_terminali'];
    }
    $query3 = "select sum(numero_S) as numero_terminali , dati_tacid.Modello ,dati_tacid.Marca, Tac1
    from $table  left join dati_tacid on $table.Tac1=dati_tacid.TacId where Tecnologia='tablet'  order by numero_terminali desc ";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    while ($obj3 = mysqli_fetch_array($result3)) {
        $numero_terminali = $obj3['numero_terminali'];
        $altri = $numero_terminali - $numero_terminali_top;
        $lista_nomi[] = "ALTRI";
        $lista_valori[] = $altri;
    }


    torta($lista_valori, $lista_nomi);
    echo "<br><table align=center style=\"width:300px\"><thead><tr><th>Marca</th><th>n Terminali</th><tr></thead><tbody>";
    foreach ($lista_valori as $key => $value) {

        echo "<tr><th>" . $lista_nomi[$key] . "</th><td>" . $value . "</td></tr>";
    }
    echo "</tbody><tfoot><tr><th>Totale</th><th>$numero_terminali</th><tr></tfoot></table>";
}

function torta($lista_valori, $lista_nomi) {
    $numero_random = rand();

    echo "<script type=\"text/javascript\">

var chart_$numero_random;
$(document).ready(function() {
chart_$numero_random = new Highcharts.Chart({
chart: {
renderTo: 'container_chart_$numero_random',
plotBackgroundColor: null,
plotBorderWidth: null,
plotShadow: false
},
title: {
text: ''
},
tooltip: {
formatter: function() {
return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
}
},
plotOptions: {
pie: {
allowPointSelect: true,
cursor: 'pointer',
dataLabels: {
enabled: true,
color: '#000000',
connectorColor: '#000000',
formatter: function() {
return '<b>'+ this.point.name +'</b>: '+ this.y +' %';
}
}
}
},colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
    series: [{
type: 'pie',
name: 'Browser share',
data: [";

    $numero_terminali = 0;
    foreach ($lista_valori as $key => $value) {
        $numero_terminali = $numero_terminali + $value;
    }
    foreach ($lista_nomi as $key => $value) {
        if (round($lista_valori[$key] * 100 / $numero_terminali) != 0) {
            echo "['$value'," . round($lista_valori[$key] * 100 / $numero_terminali, 1) . "]";
            if (count($lista_nomi) - 1 > $key)
                echo ",";
        }
    }
    echo "]
}]
});
});

</script>";
    echo "<div id=\"container_chart_$numero_random\" style=\"width: 800px; height: 400px; margin: 0 auto\"></div>";
}

function home_torta($lista_valori, $lista_nomi, $titolo, $sottotitolo, $size) {
    $numero_random = rand();

    echo "<script type=\"text/javascript\">

var chart_$numero_random;
$(document).ready(function() {
chart_$numero_random = new Highcharts.Chart({
chart: {
renderTo: 'container_chart_$numero_random',
plotBackgroundColor: null,
plotBorderWidth: null,
plotShadow: false
},
title: {
text: '$sottotitolo'
},

tooltip: {
                pointFormat: '<b>{series.name}</b>: <b>{point.percentage:.1f}%</b>'
            },
plotOptions: {
pie: {
allowPointSelect: true,
cursor: 'pointer',
dataLabels: {
enabled: true,
color: '#000000',
connectorColor: '#000000',
formatter: function() {
return '<b>'+ this.point.name +'</b>: n.'+ this.y +'';
}
}
}
},colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
    series: [{
type: 'pie',
name: 'Valore',
data: [";

    $numero_terminali = 0;
    foreach ($lista_valori as $key => $value) {
        $numero_terminali = $numero_terminali + $value;
    }
    foreach ($lista_nomi as $key => $value) {
        if (round($lista_valori[$key] * 100 / $numero_terminali) != 0) {
            #echo "['$value'," . round($lista_valori[$key] * 100 / $numero_terminali, 1) . "," . $lista_valori[$key]  . "]";
            echo "['$value'," . $lista_valori[$key]  . "]";
            if (count($lista_nomi) - 1 > $key)
                echo ",";
        }
    }
    echo "]}]});});</script>";
?>    
        <div class="col-md-<?php echo $size; ?> col-sm-<?php echo $size; ?> col-xs-<?php echo $size; ?>">
            <div class="x_panel">
                <div class="x_title">
                    <h2><?php echo $titolo; ?> <small><?php echo $sottotitolo; ?></small></h2>
                     <ul class="nav navbar-right panel_toolbox">
                        <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                        </li>
                        <li><a class="close-link"><i class="fa fa-close"></i></a>
                        </li>
                    </ul>
                    <div class="clearfix"></div>
                </div>
                <div class="x_content">
                    <div id="container_chart_<?php echo $numero_random; ?>" style="height: 400px; width: auto; margin: 0 auto"></div>
                </div>
            </div>
        </div><div class="row"></div>    
    
    
<?php    
}



function radar($lista_valori1, $lista_valori2, $lista_nomi, $nome_y1, $nome_y2, $fattore_di_scala1, $fattore_di_scala2, $unita_mis1, $unita_mis2, $titolo_grafico) {
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
		<script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
		<script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    echo "<script type=\"text/javascript\">

			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'radar',
						defaultSeriesType: 'scatter',
						zoomType: 'xy'
					},title: {
        text: '$titolo_grafico' ,x:10, align: 'left',
    style: {
            color: '#FF0000',
            fontWeight: 'bold'
        }
    },

					xAxis: {
						title: {
							enabled: true,
							text: '$nome_y1'
						},
						startOnTick: true,
						endOnTick: true,
						showLastLabel: true,labels: {
                format: '{value} %'
            }
					},
					yAxis: {
						title: {
							text: '$nome_y2'
						},labels: {
                format: '{value} %'
            }
					},
					tooltip: {
						formatter: function() {
				                return this.series.name+':'+this.x +' $unita_mis1, '+ this.y +' $unita_mis2';
						}
					},legend: {
            enabled:false

        },colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
        plotOptions: {

            scatter: {
                dataLabels: {
        x: 8,
                y: -8,
                    enabled: true,
                    formatter: function() {
                        return this.series.name;
                    }
                },
                marker: {
                    radius: 5,
                    states: {
                        hover: {
                            enabled: true,
                            lineColor: 'rgb(100,100,100)'
                        }
                    },
                    symbol:'square'
                },
                states: {
                    hover: {
                        marker: {
                            enabled: false
                        }
                    }
                }
            }
        },
					series: [";
    foreach ($lista_valori1 as $key => $value) {
        if ($value != 0) {
            $t1 = round($value / $fattore_di_scala1, 1);
            $t2 = round($lista_valori2[$key] / $fattore_di_scala2, 1);
            $stringa_tagliata = explode("-", $lista_nomi[$key]);
            echo "{name: '" . $stringa_tagliata[0] . "',
		color: '#4572A7',
		data: [[$t1,$t2]]}";
        }
        if ($key < count($lista_valori2) - 1)
            echo ",";
    }

    echo "]
				});


			});

		</script>";
    echo "<div id=\"radar\" style=\"width: 800px; height: 600px; margin: 0 auto\"></div>";
}

function multi_axes($lista_valori1, $lista_valori2, $lista_nomi, $nome_y1, $nome_y2, $fattore_di_scala1, $fattore_di_scala2, $unita_mis1, $unita_mis2) {


    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
		<script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
		<script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    echo "
<script type=\"text/javascript\">

			var chart;
			$(document).ready(function() {
				chart = new Highcharts.Chart({
					chart: {
						renderTo: 'container',
						zoomType: 'xy'
					},
                                        navigation: {
        buttonOptions: {
            verticalAlign: 'bottom',
            y: -20
        }
    },colors: ['#00B0F0',  '#0066ff', '#7030A0', '#FF9900', '#33CC33', '#BF0000', '#003B89', '#7F7F7F', '#D9D9D9', '#a6c96a'],
    title: {
						text: ''
					},
					subtitle: {
						text: ''
					},
					xAxis: [{
						categories: [";
    foreach ($lista_nomi as $key => $value) {
        echo "'$value'";
        if ($key < count($lista_nomi) - 1)
            echo ",";
    }
    echo "],labels: {
							rotation: -45,
							align: 'right',
							style: {
								 font: 'normal 10px Verdana, sans-serif'
							}
						}
					}],

					yAxis: [{ // Primary yAxis
    startOnTick: false,
						labels: {
							formatter: function() {
								return this.value+'$unita_mis2';
							},
							style: {
								color: '#4572A7'
							}
						},
						title: {
							text: '$nome_y2',
							style: {
								color: '#4572A7'
							}
						}
					}, { // Secondary yAxis
						        min: 0,
        startOnTick: false,title: {
							text: '$nome_y1',
							style: {
								color: '#ff9900'
							}
						},
						labels: {
							formatter: function() {
								return this.value+' $unita_mis1';
							},
							style: {
								color: '#4572A7'
							}
						},
						opposite: true


					}],
					tooltip: {
						formatter: function() {
							return ''+
								this.x +': '+ this.y+
								(this.series.name == '$nome_y2' ? ' $unita_mis2' : ' $unita_mis1');
						}
					},
					legend: {
						layout: 'vertical',
						align: 'left',
						x: 520,
						verticalAlign: 'top',
						y:0,
						floating: true,
						backgroundColor: '#FFFFFF'
					},
					series: [
                                             {
						name: '$nome_y2',
						color: '#4572A7',
						type: 'column',
						data: [";
    foreach ($lista_valori2 as $key => $value) {
        if ($value != 0) {
            $t = round($value / $fattore_di_scala2, 1);
            echo "" . $t . "";
        }
        if ($key < count($lista_valori2) - 1)
            echo ",";
    }

    echo "]
					},{
						name: '$nome_y1',
						color: '#FF9900',
						type: 'spline',
						yAxis: 1,
						data: [";
    foreach ($lista_valori1 as $key => $value) {
        if ($value != 0) {
            $t = round($value / $fattore_di_scala1, 1);
            echo "" . $t . "";
        }
        if ($key < count($lista_valori1) - 1)
            echo ",";
    }

    echo "]

					}
                                        ]
				});


			});

		</script>    ";



    echo "<div id=\"container\" style=\"width: 800px; height: 400px; margin: 0 auto\"></div>";
}

//----------------------------------------------
function _convert_tabella_citta($tabella) {

    return $tabella . "_comuneps";
}

//----------------------------------------
//-------------------------------------------------------------------------------------------------

function multi_axes_multi($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false, $titolo = "", $sottotitolo = "") {
    $db_link = connect_db_li();
    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    $riga = 0;
    $matrice_risultati = array();
    if ($piano == NULL)
        $piano = "S";
    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_S )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;  
        case "numero_ter":

            $unita_misura = "k";
            $ordinata = "# devices";

            //print_r($lista_condizioni);

            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;
                    //echo $tipo_terminale . "<br>";
                    
                    //////////////////////////////////////////////////////////////////
 //////////////////////////Calcolo Valori               
                if ($_SESSION['operator'] == '3')  {
                        $sum = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                }      
                if ($_SESSION['operator'] == 'wind')  {
                    $tac_counter = 'Count_IMEI';
                    $mese = $this->windtable_net($value);
                    $sum = _valori($mese, $tac_counter, $ricerca . $filtro_citta, $tipo_terminale);
                    
                }
////////////////////////////////////////////////////////////////////

                    #$sum = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "numero_ter_LTE":

            $unita_misura = "k";
            $ordinata = "# devices";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "")) {
                    $ricerca = " tipo is Null ";
                } else
                    $ricerca = " $parametro_di_ricerca='" . $value1 . "' ";
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numeroLTE_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numeroLTE_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numeroLTE_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( numeroLTE_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0' && !empty($citta)) {
                        if (_check_citta($value)) {
                            #echo "<br>checkcitta " . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_citta";
                            $filtro_citta = " and `COMUNE_PREVALENTE`='$citta'";
                            $verifica_citta = true;
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    
                    if ($imeisv) {
                        if ($citta != '0' && !empty($citta)) {
                                if (_check_citta($value)) {
                                    //echo "<br>" . $citta . "<br>";
                                    $value = $value . "_imeisv";
                                    $verifica_citta = true;
                                    $parametro_di_ricerca = "modello";
                                } 
                            }        
                            else
                            $filtro_citta = "";
                    } 
                    #else  $filtro_citta = "";                    
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $verifica_citta = true;
                            echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_sum_fullroamers = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers )+sum(Voce_in_on_net_" . $piano . "_FullRoamers )+sum(Voce_out_roaming_" . $piano . "_FullRoamers )+sum(Voce_in_roaming_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $voce_sum_fullroamers_tot = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers )+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $voce_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_voce = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);


                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($sum - $sum_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round(($sum_voce - $voce_sum_fullroamers) / ($sum - $sum_fullroamers), 0);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($voce_tutti_terminali - $voce_sum_fullroamers_tot) - ($sum_voce - $voce_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)), 0);
                        }
                    }

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "PDP":

            $unita_misura = "";
            $ordinata = "PDP (numero)";
            echo $parametro_di_ricerca;


            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_comuneps";
                            $filtro_citta = " and `COMUNE_PREVALENTE_PS`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                        $pdp_sum_fullroamers_tot = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "chiamate_non_risposte":

            $unita_misura = "";
            $ordinata = "Chiamate non risposte (numero)";
            $pdp_sum_fullroamers_tot = 0;

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_comuneps";
                            $filtro_citta = " and `COMUNE_PREVALENTE_PS`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                            $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                        else
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            $unita_di_misura = 1000000;
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $ordinata = "voice totale ( Milion minutes)";
                            $verifica_citta = true;
                            $unita_di_misura = 1000000;
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    //if ($numero_terminali_prov > 100) {
                    $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;

                    if ($fullroamers == TRUE) {
                        $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($tot - $tot_FR) / $unita_di_misura, 2);
                    }
                    //} else
                    //  $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";


            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $vol_tutti_terminali = 0;
                    $tot_tutti_terminali = 0;
                    $sum_fullroamers = 0;
                    $num_fullroamers = 0;
                    $sum_fullroamers_tot = 0;
                    $num_fullroamers_tot = 0;
                    $num_ter = 0;

                    if ($ITA) {
                        $vol_tutti_terminali = _valori($value, "sum(volume_Dati_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( volume_Dati_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        $num_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( volume_Dati_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                            $num_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers_tot = 0;
                        $num_fullroamers_tot = 0;
                    }

                    $sum = _valori($value, "sum( volume_Dati_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                    $num_ter = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($num_ter - $num_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round((($sum - $sum_fullroamers) / ($num_ter - $num_fullroamers)) / 1000, 2);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round(((($vol_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) /
                                    (($tot_tutti_terminali - $num_fullroamers_tot) - ($num_ter - $num_fullroamers))) / 1000, 2);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;
        case "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
            if ($tipo_grafico == "dati_totale")
                $seme = "volume_Dati";
            else if ($tipo_grafico == "dati_totale_LTE")
                $seme = "volume_Dati_LTE";
            else if ($tipo_grafico == "dati_totale_3g_di_device_LTE_mag_0")
                $seme = "traffico3G_terminaliLTE";



            $unita_misura = "T";
            $ordinata = "data traffic";
            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(" . $seme . "_" . $piano_totale . ")", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( " . $seme . "_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( " . $seme . "_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( " . $seme . "_" . $piano . " )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($sum - $sum_fullroamers) / 1000 / 1000 / 1000, 0);
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) / 1000 / 1000 / 1000, 0);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;

        default:
            break;
    }

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] * 100, 2);
                    break;
                case "numero_ter":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "numero_ter_LTE":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "roaming":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "voce":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 0);
                    break;

                case "voce_totale":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "chiamate_non_risposte":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "PDP":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                default:
                    break;
            }
        }
    }

    include_once 'graph_class.php';
    $grafico = new graph_class();  
    $grafico->print_graph($matrice_risultati, $lista_nomi, $ordinata, $minimo, $unita_misura, $titolo, $sottotitolo);
    
    include_once 'matrice_dati_class.php';
    $matrice = new matrice_dati_class();
    
    if (isset($matrice_risultati)) {
        $lista_nomi_visualizzati = _nome_mese($lista_nomi);
        $matrice->stampa_matrice($matrice_risultati, $lista_nomi_visualizzati, false, $titolo, $sottotitolo, true, $unita_misura);
            $matrice_incremento = $matrice->matrice_incremento($matrice_risultati, $lista_nomi_visualizzati);
        $matrice->stampa_matrice($matrice_incremento, $lista_nomi_visualizzati, false, " Incremento percentuale rispetto al mese di " . $lista_nomi_visualizzati[0],"", true, "");
            $matrice_carg = $matrice->matrice_carg($matrice_risultati, $lista_nomi_visualizzati);
        $matrice->stampa_matrice($matrice_carg, $lista_nomi_visualizzati, false, " Carg rispetto al mese di " . $lista_nomi_visualizzati[0]);
    }
    

}

//----------------------------------------------------------------------------------------------

function multi_axes_multi_new($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $classe_throughput = false, $ITA = false, $tipo_piano = false) {
    $db_link = connect_db_li();
    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    $riga = 0;
    $matrice_risultati = array();
    if ($piano == NULL)
        $piano = "S";



    $arrayFiltro = array();
    $arrayNomi = array();
    //$matrice_risultati=
    $filtro = array();

    $pattern = array();

    $unita_misura = "k";
    $ordinata = "# devices";

    if ($ITA) {
        $suffisso = "3ITA";
        if (count($arrayNomi) == 0) {
            $pattern[] = "3ITA";
            $pattern[] = "NO3ITA";
            foreach ($lista_condizioni as $key1 => $value1) {
                $arrayNomi[] = $value1 . "_3ITA";

                $arrayNomi[] = $value1 . "_NO3ITA";
            }
        }
    }
    if ($classe_throughput) {
        $query = "SELECT  `classe_throughput` FROM  `dati_tacid` GROUP BY  `classe_throughput` ";
        $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        $lista_richiesta = array();
        while ($obj = mysqli_fetch_array($result)) {
            if ($obj['classe_throughput'] != "") {
                $lista_richiesta[] = $obj['classe_throughput'];
            } else {
                $lista_richiesta[] = "N/A";
            }
        }
        foreach ($lista_condizioni as $key1 => $value1) {
            foreach ($lista_richiesta as $key2 => $value2) {
                $filtro[] = "Tipo= '$value1' and classe_throughput='$value2' ";
            }
        }
        if (count($arrayNomi) == 0) {

            foreach ($lista_condizioni as $key1 => $value1) {
                foreach ($lista_richiesta as $key2 => $value2) {
                    $arrayNomi[] = $value1 . "_" . $value2;
                }
            }
        } else {
            foreach ($arrayNomi as $key1 => $value1) {
                foreach ($lista_richiesta as $key2 => $value2) {
                    $arrayNomi[] = $value1 . "_" . $value2;
                }
            }
        }
    }
    if ($tipo_piano) {
        if (count($pattern) > 0) {
            foreach ($pattern as $key3 => $value3) {
                $pattern[$key3] = $value3 . "_PRE";
                $pattern[] = $value3 . "_POST";
            }
        } else {
            $pattern[] = "S_PRE";
            $pattern[] = "S_POST";
        }
        if (count($arrayNomi) == 0) {
            foreach ($lista_condizioni as $key1 => $value1) {
                $arrayNomi[] = $value1 . "_PRE";
                $arrayNomi[] = $value1 . "_POST";
            }
        } else {
            foreach ($arrayNomi as $key1 => $value1) {
                $arrayNomi[] = $value1 . "_PRE";
                $arrayNomi[] = $value1 . "_POST";
            }
        }
    }
    if (count($pattern) == 0) {
        $pattern[] = 'S';
    }
    if (count($filtro) == 0) {
        $filtro[] = '1';
    }
    //print_r($pattern);
    //print_r($arrayNomi);
    //print_r($filtro);
    echo "<br><br><br><br>";



    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_S )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;
        case "numero_ter":

            $cont_riga = 0;
            $matrice = array(array());

            $cont_colonna = 2;
            foreach ($lista_tabella as $key => $value) {
                //echo $value;
                //$cont_riga=1;
                //$matrice=array(array());
                //$matrice[$cont_riga][0]=$arrayNomi[$cont_riga];
                //echo $matrice[$cont_riga][0].$cont_riga;
                $cont_riga = 0;
                foreach ($pattern as $key1 => $value1) {
                    foreach ($filtro as $key2 => $value2) {
                        if ($value1 == "NO3ITA") {
                            $tot = _valori($value, "sum(numero_S)", " $value2", $tipo_terminale) -
                                    _valori($value, "sum(numero_3ITA)", " $value2", $tipo_terminale);
                        } elseif ($value1 == "NO3ITA_PRE") {
                            $tot = _valori($value, "sum(numero_S_PRE)", " $value2", $tipo_terminale) -
                                    _valori($value, "sum(numero_3ITA_PRE)", " $value2", $tipo_terminale);
                        } elseif ($value1 == "NO3ITA_POST") {
                            $tot = _valori($value, "sum(numero_S_POST)", " $value2", $tipo_terminale) -
                                    _valori($value, "sum(numero_3ITA_POST)", " $value2", $tipo_terminale);
                        } else
                            $tot = _valori($value, "sum(numero_$value1)", " $value2", $tipo_terminale);
                        $matrice[$cont_riga][$cont_colonna] = $cont_riga . " " . $cont_colonna;
                        $cont_riga++;
                    }
                }
                //echo $cont_colonna.$value;

                $cont_colonna++;
            }
            $lista_nomi_visualizzati = _nome_mese($lista_nomi);
            echo "<div style=\"margin-right:auto;margin-left:auto;\"><br>" . stampa_matrice($matrice, $lista_nomi_visualizzati) . "</p>";
            break;
        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                //echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        //echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        //echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                            }
                        }

                        $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                            //echo $matrice_risultati[$riga + 1][0]."<br>";
                            //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                            //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                            //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                            //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[0];
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }
            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        $voce_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        $voce_sum_fullroamers = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers )+sum(Voce_in_on_net_" . $piano . "_FullRoamers )+sum(Voce_out_roaming_" . $piano . "_FullRoamers )+sum(Voce_in_roaming_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                            $voce_sum_fullroamers_tot = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers )+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $voce_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    $sum_voce = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_voce - $voce_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($voce_tutti_terminali - $voce_sum_fullroamers_tot) - ($sum_voce - $voce_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);

                    if ($numero_terminali_prov > 100) {
                        $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        $tot_FR = 0;

                        if ($fullroamers == TRUE) {

                            $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                        }
                        $matrice_risultati[$riga][$colonna] = ($tot - $tot_FR);
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($sum > 200)
                        $matrice_risultati[$riga][$colonna] = round(_valori($value, "sum( volume_Dati_$piano )/sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale) / 1000, 2);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        case "dati_totale":
            $unita_misura = "T";
            $ordinata = "data traffic";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);

                    if ($numero_terminali_prov > 200)
                        $matrice_risultati[$riga][$colonna] = round(_valori($value, "sum( volume_Dati_$piano )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale) / 1000 / 1000 / 1000, 2);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        default:
            break;
    }
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
      <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    echo "<script type=\"text/javascript\">
      var chart;
      $(document).ready(function() {
      chart = new Highcharts.Chart({
      chart: {
      renderTo: 'container',
      defaultSeriesType: 'line',
      type: 'line',
      zoomType: 'xy'

      },
      credits: {
      enabled: false
      },
      title: {
      text: ''
      },
      xAxis: [{
      labels: {
      style: {
      fontSize: '14px',
      fontWeight: 'bold'
      }
      },categories: [";
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "'$value'";
            if ($key < count($lista_nomi_visualizzati) - 1)
                echo ",";
        }
    } else
    // print_r (_nome_mese($lista_nomi));
        echo "<th>$lista_nomi_visualizzati</th>";



    echo "]}],
      yAxis: {
      title: {
      text: '$ordinata'
      },$minimo
      labels: {
      formatter: function() {
      return this.value + '$unita_misura';
      },style: {
      fontSize: '14px',
      fontWeight:'bold'
      }
      },
      plotLines: [{
      value: 0,
      width: 1,
      color: '#808080'
      }]
      },
      tooltip: {
      formatter: function() {
      return '<b>'+ this.series.name +'</b><br/>'+
      this.x +': '+ this.y + '$unita_misura';
      }
      },
      legend: {
      style: {
      fontSize: '16px',
      fontWeight:'bold'
      },
      y:20,
      layout: 'vertical',
      align: 'right',
      verticalAlign: 'top',
      borderWidth: 0,
      floating:false
      },
      series: [";

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        echo "{type: 'spline',name: '";

        echo $matrice_risultati[$riga][0] . "',
      data: [";

        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    echo round($matrice_risultati[$riga][$colonna] * 100, 2) . "";
                    break;
                case "numero_ter":
                    echo round($matrice_risultati[$riga][$colonna] / 1000, 2) . "";
                    break;
                case "roaming":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "voce":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "dati":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "dati_totale":
                    echo round($matrice_risultati[$riga][$colonna], 2) . "";
                    break;
                case "voce_totale":
                    echo round($matrice_risultati[$riga][$colonna] / 1000 / 1000, 2) . "";
                    break;
                default:
                    break;
            }

            if ($colonna < count($lista_nomi))
                echo ",";
        }
        echo "]
      }";
        if ($riga < count($matrice_risultati) - 1)
            echo",";
    }
    echo" ]});});</script>";

    echo "<div id=\"container\" style=\"width: 900px; height: 400px; margin: 0 auto\"></div>";
    echo "<br><br>";
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    $riga = count($matrice_risultati);
    if ($tipo_grafico == "numero_ter") {

        $riga = count($matrice_risultati);
        $matrice_risultati[$riga][0] = "ALTRI";
        for ($i = 1; $i <= count($lista_nomi); $i++) {
            $matrice_risultati[$riga][] = _valori($lista_nomi[$i - 1], " sum(numero_$piano) ", $tipo_terminale) - sumArray($matrice_risultati, array('direction' => 'y', 'key' => $i), array(count($matrice_risultati) - 1));
        }
        //area_stacked_percent($lista_nomi, $matrice_risultati);
    }
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><br>" . stampa_matrice($matrice_risultati, $lista_nomi_visualizzati) . "</p>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Tabella incremento</h2><br>";
    stampa_incremento($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Stampa tabella carg</h2><br>";
    stampa_carg_2($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
}

//----------------------------------------------------------------------------------------------



function stampa_radar($lista_tabella, $tipo_terminale, $lista_condizioni, $piano, $fullroamers) {
    $risutlati_radar = 0;

    $table = $lista_tabella[count($lista_tabella) - 1];
    foreach ($lista_condizioni as $key => $value) {
        $risutlati_radar = drop_roaming($table, $value, $piano, $fullroamers);
        $lista_nomi[$key] = $risutlati_radar[0];
        $lista_valori1[$key] = $risutlati_radar[1];
        $lista_valori2[$key] = $risutlati_radar[2];
    }
    $media_nazionale = media_nazionale2($table, $tipo_terminale);
    //print_r($lista_nomi);
    //print_r($lista_valori1);
    //print_r($lista_valori2);
    $lista_nomi[count($lista_nomi)] = "National Average";
    $lista_valori1[count($lista_valori1)] = $media_nazionale[0];
    $lista_valori2[count($lista_valori2)] = $media_nazionale[1] / 100;
    radar($lista_valori1, $lista_valori2, $lista_nomi, "% roaming", "% drop", 1, 0.01, "%", "%", "Radar " . _nome_mese($table));
}

function area_stacked_percent($lista_nomi, $matrice_risultati) {
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
      <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    ?>
    <script type="text/javascript">

        var chart;
        $(document).ready(function () {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'area_stacked_percent',
                    defaultSeriesType: 'area'
                },
                title: {
                    text: 'Vendor trend'
                },
                xAxis: {
                    categories: [
    <?php
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "'$value'";
            if ($key < count($lista_nomi_visualizzati) - 1)
                echo ",";
        }
    } else
// print_r (_nome_mese($lista_nomi));
        echo "'$lista_nomi_visualizzati'";
    ?>
                    ],
                    tickmarkPlacement: 'on',
                    title: {
                        enabled: false
                    }
                },
                yAxis: {
                    title: {
                        text: 'Percent'
                    }
                },
                tooltip: {
                    formatter: function () {
                        return '' +
                                this.x + ': ' + Highcharts.numberFormat(this.percentage, 1) + '% (' +
                                Highcharts.numberFormat(this.y, 0, ',') + ' millions)';
                    }
                },
                plotOptions: {
                    area: {
                        stacking: 'percent',
                        lineColor: '#ffffff',
                        lineWidth: 1,
                        marker: {
                            lineWidth: 1,
                            lineColor: '#ffffff'
                        }
                    }
                },
                series: [
    <?php
    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        echo "{name: '" . $matrice_risultati[$riga][0] . "', data: [";

        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            echo round($matrice_risultati[$riga][$colonna] / 1000) . "";
            if ($colonna < count($lista_nomi))
                echo ",";
        }

        echo "]}";
        if ($riga < count($matrice_risultati) - 1)
            echo",";
    }
    ?>]
            });
        });
    </script>
    <div id="area_stacked_percent"  style="width: 900px; height: 400px; margin: 0 auto"></div><br></br>
    <?php
}

function bar_negative_stack($lista_nomi, $risultati_positivi, $risultati_negativi, $mese_iniziale, $mese_finale) {
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
      <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    ?>
    <script type="text/javascript">

        var chart,
                categories = [<?php
    foreach ($lista_nomi as $key => $value) {

        if ($key < count($lista_nomi) && ($key > 0))
            echo " , ";
        echo "'" . $value . "'";
    }
    ?>];
        $(document).ready(function () {
            chart = new Highcharts.Chart({
                chart: {
                    renderTo: 'bar_negative_stack',
                    defaultSeriesType: 'bar',
                    marginRight: 50
                },
                title: {
                    text: 'Delta devices (<?php echo $mese_iniziale . " - " . $mese_finale; ?>)'
                },
                xAxis: [
                    { // mirror axis on right side

                        reversed: false,
                        categories: categories}],
                yAxis: {
                    title: {
                        text: null
                    },
                    labels: {
                        formatter: function () {
                            return (Math.abs(this.value) / 1000) + 'k';
                        }
                    }
                },
                plotOptions: {
                    series: {
                        stacking: 'normal'
                    }
                },
                tooltip: {
                    formatter: function () {
                        return '<b>' + this.point.category + ':' + this.series.name + '</b><br/>' +
                                '# device: ' + Highcharts.numberFormat(Math.abs(this.point.y), 0);
                    }
                },
                series: [{color: '#ff0000',
                        name: 'Negative',
                        data: [
    <?php
    foreach ($lista_nomi as $key => $value) {

        if ($key < count($lista_nomi) && ($key > 0))
            echo " , ";
        echo $risultati_negativi[$value];
    }
    ?>]
                    }, {
                        name: 'Positive',
                        data: [<?php
    foreach ($lista_nomi as $key => $value) {

        if ($key < count($lista_nomi) && ($key > 0))
            echo " , ";
        echo $risultati_positivi[$value];
    }
    ?>]
                    }]
            });
        });
    </script>


    <div id="bar_negative_stack"  style="width: auto; height: 400px; margin: 0 auto"></div>
    <br>
    <?php
}

function sumArray($array, $params = array('direction' => 'x', 'key' => 'xxx'), $exclusions = array()) {
    if (!empty($array)) {
        $sum = 0;
        if ($params['direction'] == 'x') {
            $keys = array_keys($array);
            for ($x = 0; $x < count($keys); $x++) {
                if (!in_array($keys[$x], $exclusions))
                    $sum += $array[$keys[$x]];
            }
            return $sum;
        } elseif ($params['direction'] == 'y') {
            $keys = array_keys($array);
            if (array_key_exists($params['key'], $array[$keys[0]])) {
                for ($x = 0; $x < count($keys); $x++) {
                    if (!in_array($keys[$x], $exclusions)) {
                        $sum += $array[$keys[$x]][$params['key']];
                    }
                }
                return $sum;
            } else
                return false;
        } else
            return false;
    } else
        return false;
}

function stampa_matrice($matrice_risultati, $lista_nomi_visualizzati, $totale = false) {
    ?>
    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                <table id="datatable-buttons" class="table table-striped table-bordered">
                    <thead>
                        <tr>
                            <th></th>
                            <?php
                            if (count($lista_nomi_visualizzati) > 1) {
                                foreach ($lista_nomi_visualizzati as $key => $value) {
                                    echo "<th>$value</th>";
                                }
                            } else
                            // print_r (_nome_mese($lista_nomi));
                                echo "<th>$lista_nomi_visualizzati</th>";
                            ?>
                        </tr>
                    </thead>


                    <tbody>
                        <?php
                        foreach ($matrice_risultati as $v1) {
                            //print_r($v1);
                            echo "<tr>";
                            foreach ($v1 as $v2) {
                                echo "<td>" . str_replace(".", ",", $v2) . "</td>";
                            }
                            echo "</tr>";
                        }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>


    <div class="clearfix"></div>
    <?php
}

function stampa_carg_2($matrice_risultati, $lista_nomi_visualizzati) {
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><table align=center>";
    echo "<thead><tr><td></td>";
    // echo "<th>" . $lista_nomi_visualizzati[0] . " - " . $lista_nomi_visualizzati[count($lista_nomi_visualizzati) - 1] . "<th>";
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "<th>" . $lista_nomi_visualizzati[0] . " - $value</th>";
        }
    } else
    // print_r (_nome_mese($lista_nomi));
        echo "<th>$lista_nomi_visualizzati</th>";

    echo "</tr></thead><tbody>";
    $risultato = array();
    foreach ($matrice_risultati as $key => $v1) {
        echo "<tr>";
        echo "<td>" . $v1[0] . "</td>";
        echo "<td>N/A</td>";
        $inizio = $v1[1];
        foreach ($v1 as $key => $v2) {
            if ($key > 1) {
                if (($v2 != 0) || ($inizio != 0))
                    if (($v2 != 0) && ($inizio != 0)) {
                        $risultato_calcolo = pow(($v2 / $inizio), (1 / ($key - 1))) - 1;
                    } else
                        $risultato_calcolo = 0;
                else
                    $risultato_calcolo = 0;
                echo "<td>" . str_replace(".", ",", round($risultato_calcolo, 3)) . "</td>";
            }
        }

        echo "</tr>";
    }
    echo "</tbody></table></div>";
}

function stampa_incremento($matrice_risultati, $lista_nomi_visualizzati) {

    echo "<div style=\"margin-right:auto;margin-left:auto;\"><table align=center>";
    echo "<thead><tr><td></td>";
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "<th>" . $lista_nomi_visualizzati[0] . " - $value</th>";
        }
    } else
        echo "<th>$lista_nomi_visualizzati</th>";
    echo "</tr></thead><tbody>";
    $risultato = array();
    foreach ($matrice_risultati as $key => $v1) {
        echo "<tr>";
        echo "<td>" . $v1[0] . "</td>";

        echo "<td>N/A</td>";

        $inizio = $v1[1];

        foreach ($v1 as $key => $v2) {
            if ($key > 1) {
                if (($v2 != 0) || ($inizio != 0))
                    if (($v2 != 0) && ($inizio != 0)) {
                        $risultato_calcolo = ($v2 / $inizio) - 1;
                    } else
                        $risultato_calcolo = 0;
                else
                    $risultato_calcolo = 0;

                echo "<td>" . str_replace(".", ",", round($risultato_calcolo, 3)) . "</td>";
            }
        }

        echo "</tr>";
    }
    echo "</tbody></table></div>";
}

function stampa_incremento_tipo2($matrice_risultati, $lista_nomi_visualizzati) {
    include('SpearmanCorrelation.php');
    $sp = new SpearmanCorrelation();
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><table align=center>";
    echo "<thead><tr><td></td>";
    $controllo_terminali_test = false;
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "<th>" . $lista_nomi_visualizzati[0] . " - $value</th>";
        }
    } else
        echo "<th>$lista_nomi_visualizzati</th>";
    echo "</tr></thead><tbody>";
    $risultato = array();
    $iphone6 = array();
    $iphone4s = array();
    foreach ($matrice_risultati as $key => $v1) {
        echo "<tr>";
        echo "<td>" . $v1[0] . "</td>";

        echo "<td>N/A</td>";

        $inizio = $v1[1];
        $telefono = array();
        $telefono[] = $v1[0];

        foreach ($v1 as $key => $v2) {
            if ($key > 1) {
                if (($v2 != 0)) {
                    if ($v2 > 100) {
                        $risultato_calcolo = ($v2 - $inizio) / $v2;
                        $telefono[] = $risultato_calcolo;
                    } else {
                        $risultato_calcolo = 0;
                    }
                } else
                    $risultato_calcolo = 0;

                echo "<td>" . str_replace(".", ",", round($risultato_calcolo, 4)) . "</td>";
                $inizio = $v2;
            }
        }
        array_push($risultato, $telefono);
        $v1[0] == "iPhone 6" ? array_push($iphone6, $telefono) : "";
        $v1[0] == "iPhone 4S" ? array_push($iphone4s, $telefono) : "";

        echo "</tr>";
    }
    echo "</tbody></table></div>";
    echo "<br><br><br><br>";
    echo "<table><tbody>";
    echo "<tr>";
    echo "<td></td>";

    $lunghezza1 = count($iphone6[0]);
    echo "<br>" . $lunghezza1 . "<br>";
    $lunghezza2 = count($iphone4s[0]);
    echo "<br>" . $lunghezza2 . "<br>";
    $lunghezza1 < $lunghezza2 ? $lunghezza = $lunghezza1 - 1 : $lunghezza = $lunghezza2 - 1;
    echo "<br>" . $lunghezza . "<br>";
    print_r($iphone6[0]);
    echo "<br>";
    print_r($iphone4s[0]);
    echo "<br>";
    print_r(array_slice(array_slice($iphone6[0], 1), 0, $lunghezza));
    echo "<br>";
    print_r(array_slice(array_slice($iphone4s[0], 1), 0, $lunghezza));
    echo "<br>";
    $result = $sp->test(array_slice(array_slice($iphone6[0], 1), 0, $lunghezza), array_slice(array_slice($iphone4s[0], 1), 0, $lunghezza));
    //$result = $sp->test( $vettore1,  $vettore2);
    echo "<br>" . round($result, 8) . "</br>";

    foreach ($risultato as $key => $v1) {

        echo "<td>" . $v1[0] . "</td>";
    }
    echo "</tr>";

    foreach ($risultato as $key => $v1) {
        echo "<tr>";
        echo "<td>" . $v1[0] . "</td>";

        $vettore1 = array_slice($v1, 1);

        foreach ($risultato as $key => $v2) {
            $vettore2 = array_slice($v2, 1);
            $lunghezza1 = count($vettore1);
            $lunghezza2 = count($vettore2);
            $lunghezza1 < $lunghezza2 ? $lunghezza = $lunghezza1 : $lunghezza = $lunghezza2;
            //$v1[0]=="iPhone 6" ? print_r(array_slice($vettore2, 0,$lunghezza)):"";
            $result = $sp->test(array_slice($vettore1, 0, $lunghezza), array_slice($vettore2, 0, $lunghezza));
            //$result = $sp->test( $vettore1,  $vettore2);
            echo "<td>" . round($result, 8) . "</td>";
        }
        echo "</tr>";
    }
    echo "</tbody></table>";
}

function _nome_mese($lista_nomi) {
    $db_link = connect_db_li();
    if (count($lista_nomi) > 1) {
        foreach ($lista_nomi as $key => $value) {
            if ($_SESSION['operator'] == '3')  {
                $query = "select * from lista_tabelle where nome_tabella='$value'";
            }    
            elseif ($_SESSION['operator'] == 'wind')  {
                $query = "select * from wind_mesi where nome_tabella='$value'";
            }
            $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
            $obj = mysqli_fetch_array($result);
            $nome_visualizzato[] = $obj['nome_visualizzato'];
        }
    } else {
        //print_r($lista_nomi);
        $query = "select * from lista_tabelle where nome_tabella='" . $lista_nomi[0] . "'";
        $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        $obj = mysqli_fetch_array($result);
        $nome_visualizzato = $obj['nome_visualizzato'];
        //echo $nome_visualizzato;
    }

    return $nome_visualizzato;
}

//ritorna l'ultimo mese inserito
function ultimo_mese() {
    $db_link = connect_db_li();
    $query = "select * from lista_tabelle order by ordine desc";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $obj = mysqli_fetch_array($result);
    $nome_visualizzato = $obj['nome_tabella'];
    return $nome_visualizzato;
}

function ultimo_mese_csi() {
    $db_link = connect_db_li();
    $query = "select * from lista_tabelle where  csi=1 order by ordine desc";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $obj = mysqli_fetch_array($result);
    $nome_visualizzato = $obj['nome_tabella'];
    return $nome_visualizzato;
}

function ultimo_mese_imeisv() {
    $db_link = connect_db_li();
    $query = "select * from lista_tabelle where  imeisv=1 order by ordine desc";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $obj = mysqli_fetch_array($result);
    $nome_visualizzato = $obj['nome_tabella'];
    return $nome_visualizzato;
}

function _check_citta($tabella) {
    $db_link = connect_db_li();
    $query = "select * from lista_tabelle where  nome_tabella='$tabella'";
    $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    $obj = mysqli_fetch_array($result);
    //print_r($obj);
    if ($obj['citta'] == 1)
        return 1;
    else
        return 0;
}

function multi_axes_multi_barre($lista_nomi, $condizioni, $titolo_grafico, $nome_variabile) {
    $db_link = connect_db_li();


    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }



    $temp = 0;
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>";
    echo "
      <script type=\"text/javascript\">
      var $nome_variabile;
      $(document).ready(function() {
      $nome_variabile = new Highcharts.Chart({
      chart: {
      renderTo: 'container$nome_variabile',
      defaultSeriesType: 'column'
      },title: {
      text: '$titolo_grafico' ,x:10, align: 'left',
      style: {
      color: '#FF0000',
      fontWeight: 'bold'
      },
      floating: false,
      margin: 30
      },


      xAxis: [{
      labels: {
      style: {
      fontSize: '14px',
      fontWeight:'bold'
      }
      },categories: [";
    foreach ($lista_nomi as $key => $value) {
        $query = "select * from lista_tabelle where nome_tabella='$value'";
        $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        $obj = mysqli_fetch_array($result);


        echo "'" . $obj['nome_visualizzato'] . "'";
        if ($key < count($lista_nomi) - 1)
            echo ",";
    }
    echo "]}],
      yAxis: [{ // Primary yAxis
      max:2,min:0,labels: {
      formatter: function() {
      return this.value +'%';
      },
      style: {
      color: '#AA4643'
      }
      },
      title: {
      text: '% Drop',
      style: {
      color: '#AA4643'
      }
      },
      opposite: true

      }, { // Secondary yAxis
      max:16,min:0,
      gridLineWidth: 0,
      title: {
      text: '% Roaming',
      style: {
      color: '#3366CC'
      }
      },
      labels: {
      formatter: function() {
      return this.value +' %';
      },
      style: {
      color: '#3366CC'
      }
      }

      }, { // Tertiary yAxis
      min:0,max:8000,
      gridLineWidth: 0,
      title: {
      text: '# Devices',
      style: {
      color: '#FF9900'
      }
      },
      labels: {
      formatter: function() {
      return this.value +' k';
      },
      style: {
      color: '#FF9900'
      }
      },
      opposite: true
      }],

      tooltip: {
      formatter: function() {
      return '<b>'+ this.series.name +'</b><br/>'+
      this.x +': '+ this.y;
      }
      },
      navigation: {
      buttonOptions: {
      verticalAlign: 'top'
      }
      },
      legend: {
      x:-70,
      floating:true,
      style: {
      fontSize: '16px',
      fontWeight:'bold'
      },
      align: 'right',
      verticalAlign: 'top'
      },
      plotOptions: {
      series: {
      dataLabels: {
      enabled: true,
      formatter: function() {
      return this.y ;
      }
      }
      }
      },
      series: [";

    echo "{name: '% Roaming',type: 'spline',yAxis: 1, data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        $roaming = media_nazionale2($lista_nomi[$k], $condizioni);
        echo $roaming[0];
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]},";
    echo "{name: '% Drop',type: 'spline', data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        $roaming = media_nazionale2($lista_nomi[$k], $condizioni);
        echo $roaming[1];
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]},";
    echo "{name: '# Devices',type: 'spline',color:'#FF9900',	yAxis: 2,	 data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        $roaming = media_nazionale2($lista_nomi[$k], $condizioni);
        echo round($roaming[2] / 1000);
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]}";
    echo "  ]
      });


      });</script>

      ";



    echo "<div id=\"container$nome_variabile\" style=\"width: 850px; height: 400px; margin: 0 auto\"></div>";
}

//function multi_axes_multi_barre($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo="GROUP BY dati_tacid.Marca", $limit=4, $lista_condizioni=NULL, $parametro_ug="Marca", $minimo=NULL, $marca=NULL, $h3g=false) {
function stampa_traffico_dati_voce($lista_nomi, $condizioni, $titolo_grafico, $nome_variabile) {
    $db_link = connect_db_li();


    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }



    $temp = 0;
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
      <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    echo "
      <script type=\"text/javascript\">
      var $nome_variabile;
      $(document).ready(function() {
      $nome_variabile = new Highcharts.Chart({
      chart: {
      renderTo: 'container$nome_variabile',
      defaultSeriesType: 'column'
      },title: {
      text: '$titolo_grafico' ,x:10, align: 'left',
      style: {
      color: '#FF0000',
      fontWeight: 'bold'
      },
      floating: false,
      margin: 30
      },


      xAxis: [{
      labels: {
      style: {
      fontSize: '14px',
      fontWeight:'bold'
      }
      },categories: [";
    foreach ($lista_nomi as $key => $value) {
        $query = "select * from lista_tabelle where nome_tabella='$value'";
        $result = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        $obj = mysqli_fetch_array($result);


        echo "'" . $obj['nome_visualizzato'] . "'";
        if ($key < count($lista_nomi) - 1)
            echo ",";
    }
    echo "]}],
      yAxis: [{ // Primary yAxis
      labels: {
      formatter: function() {
      return this.value +' TB';
      },
      style: {
      color: '#AA4643'
      }
      },
      title: {
      text: '#TeraByte data traffic',
      style: {
      color: '#AA4643'
      }
      },
      opposite: true

      }, { // Secondary yAxis

      gridLineWidth: 0,
      title: {
      text: '#M voice hours',
      style: {
      color: '#3366CC'
      }
      },
      labels: {
      formatter: function() {
      return this.value +' M';
      },
      style: {
      color: '#3366CC'
      }
      }

      }, { // Tertiary yAxis
      min:0,max:4000,
      gridLineWidth: 0,
      title: {
      text: '# Devices',
      style: {
      color: '#FF9900'
      }
      },
      labels: {
      formatter: function() {
      return this.value +' k';
      },
      style: {
      color: '#FF9900'
      }
      },
      opposite: true
      }],

      tooltip: {
      formatter: function() {
      return '<b>'+ this.series.name +'</b><br/>'+
      this.x +': '+ this.y;
      }
      },
      navigation: {
      buttonOptions: {
      verticalAlign: 'top'
      }
      },
      legend: {
      x:-70,
      floating:true,
      style: {
      fontSize: '16px',
      fontWeight:'bold'
      },
      align: 'right',
      verticalAlign: 'top'
      },
      plotOptions: {
      series: {
      dataLabels: {
      enabled: true,
      formatter: function() {
      return this.y ;
      }
      }
      }
      },
      series: [";

    echo "{name: 'voice traffic',type: 'spline',yAxis: 1, data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        $roaming = traffico_dati_voce($lista_nomi[$k], $condizioni);
        echo $roaming[0];
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]},";
    echo "{name: 'data traffic',type: 'spline', data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        $roaming = traffico_dati_voce($lista_nomi[$k], $condizioni);
        echo $roaming[1];
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]},";
    echo "{name: '# Devices',type: 'spline',color:'#FF9900',	yAxis: 2,	 data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        $roaming = traffico_dati_voce($lista_nomi[$k], $condizioni);
        echo round($roaming[2] / 1000);
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]}";
    echo "  ]
      });


      });</script>

      ";



    echo "<div id=\"container$nome_variabile\" style=\"width: 850px; height: 400px; margin: 0 auto\"></div>";
}

function multi_axes_multi_barre2($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_ug = "Marca", $minimo = NULL, $marca = NULL, $h3g = false) {
    $db_link = connect_db_li();


    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    for ($i = 0; $i < count($lista_tabella); $i++) {
        $query = "SELECT (sum( Voce_out_roaming_S )+sum( Voce_in_roaming_S ) )/(sum( Voce_out_on_net_S ) +sum( Voce_in_on_net_S ) + sum( Voce_out_roaming_S )+sum( Voce_in_roaming_S ) )AS Roaming_S0,
      sum( mc4 ) /(sum( mc4 ) +sum( mc3 ) + sum( mc2 ))AS drop0,
      sum( numero_S ) AS numero_telefoni0,Marca, dati_tacid.$parametro_ug AS " . $parametro_ug . "0, Tac1
      FROM " . $lista_tabella[$i] . "
      INNER JOIN dati_tacid ON Tac1 = dati_tacid.TacId ";
        if ($h3g)
            $query = $query . " inner join tac_h3g on " . $lista_tabella[$i] . ".Tac1=tac_h3g.id_tac ";

        $query = $query . " WHERE (  Modello='$lista_condizioni'";
        if ($tipo_terminale != "")
            $query = $query . "AND $tipo_terminale";
        $query = $query . ") ";
        $query = $query . "$gruppo";
        $result3 = mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
        $obj3 = mysqli_fetch_array($result3);
        $risultati_roaming[$i] = $obj3["Roaming_S0"];
        $risultati_drop[$i] = $obj3["drop0"];
        $risultati_num_terminali[$i] = $obj3["numero_telefoni0"];
        if (round($risultati_num_terminali[$i] / 1000, 1) == 0) {
            $risultati_roaming[$i] = 0;
            $risultati_drop[$i] = 0;
        } else {
            $risultati_roaming[$i] = $obj3["Roaming_S0"];
            $risultati_drop[$i] = $obj3["drop0"];
        }

        //echo $query . "<br>";
    }



    $temp = 0;
    echo "<script type=\"text/javascript\" src=\"js/1.8.2/jquery.min.js\"></script>
      <script type=\"text/javascript\" src=\"./js/highcharts.js\"></script>
      <script type=\"text/javascript\" src=\"./js/modules/exporting.js\"></script>";
    echo "
      <script type=\"text/javascript\">
      var chart;
      $(document).ready(function() {
      chart = new Highcharts.Chart({
      chart: {
      renderTo: 'container',
      defaultSeriesType: 'column',
      marginRight: 180,
      marginBottom: 25
      },title: {
      text: '$lista_condizioni',x:10, align: 'left',
      style: {
      color: '#FF0000',
      fontWeight: 'bold'
      }
      },


      xAxis: [{
      labels: {
      style: {
      fontSize: '14px',
      fontWeight:'bold'
      }
      },categories: [";
    $lista_nomi_visualizzati = _nome_mese($lista_nomi);
    if (count($lista_nomi_visualizzati) > 1) {
        foreach ($lista_nomi_visualizzati as $key => $value) {
            echo "'$value'";
            if ($key < count($lista_nomi_visualizzati) - 1)
                echo ",";
        }
    } else
    // print_r (_nome_mese($lista_nomi));
        echo "'$lista_nomi_visualizzati'";
    echo "]}],
      yAxis: [{
      labels: {
      formatter: function() {
      return this.value +'%';
      },
      style: {
      color: '#AA4643'
      }
      },
      title: {
      text: '% Drop',
      style: {
      color: '#AA4643'
      }
      },
      opposite: true

      }, {
      gridLineWidth: 0,
      title: {
      text: '% Roaming',
      style: {
      color: '#3366CC'
      }
      },
      labels: {
      formatter: function() {
      return this.value +' %';
      },
      style: {
      color: '#3366CC'
      }
      }

      }, {
      gridLineWidth: 0,
      title: {
      text: '# Devices',
      style: {
      color: '#FF9900'
      }
      },
      labels: {
      formatter: function() {
      return this.value +' k';
      },
      style: {
      color: '#FF9900'
      }
      },
      opposite: true
      }],

      tooltip: {
      formatter: function() {
      return '<b>'+ this.series.name +'</b><br/>'+
      this.x +': '+ this.y;
      }
      },
      legend: {
      style: {
      fontSize: '16px',
      fontWeight:'bold'
      },
      shadow: true,
      align: 'center',
      verticalAlign: 'top'
      },
      series: [";

    echo "{name: '% Roaming',type: 'column',yAxis: 1, data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        echo round($risultati_roaming[$k] * 100, 2);
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]},";
    echo "{name: '% Drop',type: 'column', data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        echo round($risultati_drop[$k] * 100, 2);
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]},";
    echo "{name: '# Devices',type: 'spline',color:'#FF9900',	yAxis: 2,	 data: [";
    for ($k = 0; $k < count($lista_nomi); $k++) {
        echo round($risultati_num_terminali[$k] / 1000, 1);
        if (count($lista_nomi) - 1 > $k)
            echo ",";
    }
    echo "]}";
    echo "  ]
      });


      });</script>

      ";



    echo "<div id=\"container\" style=\"width: 850px; height: 400px; margin: 0 auto\"></div>";
}

function incrocio_imei_3ita($table) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"numero_terminali_imei_3ita_$table.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "
      select count(distinct $table.IMEI) as numero_S,
      dati_imei_boxi.imei,
      dati_tacid.Modello ,
      dati_tacid.Marca,
      dati_tacid.Tipo,
      dati_tacid.Tecnologia,
      OS,
      TAC,
      sum( Voce_out_on_net) as Voce_out_on_net_S,
      sum( Voce_out_roaming) as Voce_out_roaming_S,
      sum( Voce_in_on_net) as Voce_in_on_net_S,
      sum( Voce_in_roaming) as Voce_in_roaming_S
      from $table inner join dati_imei_boxi on $table.IMEI=dati_imei_boxi.imei inner join dati_tacid on $table.TAC=dati_tacid.TacId
      group by dati_tacid.Modello  ";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello \t Tecnologia \t Tipo \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t OS  \n";
    //echo "Marca \t Modello \t Tecnologia \t Tipo \t n_Modello \t OS \n";
    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_S']) . " \t " . trim($obj3['OS']) . "  \n";
        //echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \t " . trim($obj3['OS']) . "  \n";
    }
}

function incrocio_imei_3ita_magazzino($table) {//restituisce un file conle i dati di magazzino
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"numero_terminali_imei_3ita_magazzino_$table.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    //echo "<br>".$query3."<br>";

    $query3 = "

      select count(imei) as numero_S,dati_imei_boxi.imei, dati_tacid.Modello ,dati_tacid.Marca,dati_tacid.Tipo,dati_tacid.Tecnologia,OS

      from  dati_imei_boxi inner join dati_tacid on LEFT( imei, 8 ) =dati_tacid.TacId
      group by dati_tacid.Modello  ";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    //echo "Marca \t Modello \t Tecnologia \t Tipo \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t OS \n";
    echo "Marca \t Modello \t Tecnologia \t Tipo \t n_Modello \t OS \n";
    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        //echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_S']) . " \t " . trim($obj3['OS']). " \n";
        echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \t " . trim($obj3['OS']) . "  \n";
    }
}

function incrocio_imei_NO3ita($table) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"numero_terminali_imei_NO3ita_$table.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "
      select *,
      (Voce_out_roaming_S+Voce_in_roaming_S)/(Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S) as percentuale_roaming,
      (Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S)/numero_S as voce_terminale
      from (
      select
      dati_tacid.Modello,Tecnologia,Tipo,dati_imei.SERIAL_ICCID,
      sum( Voce_out_on_net) as Voce_out_on_net_S,
      sum( Voce_out_roaming) as Voce_out_roaming_S,
      sum( Voce_in_on_net) as Voce_in_on_net_S,
      sum( Voce_in_roaming) as Voce_in_roaming_S
      from $table inner join dati_imei on $table.IMEI!=dati_imei.SERIAL_ICCID inner join dati_tacid on $table.TAC=dati_tacid.TacId
      group by dati_tacid.Modello
      ) as stat inner join (
      select count(distinct IMEI) as numero_S,dati_imei.SERIAL_ICCID, dati_tacid.Modello ,dati_tacid.Marca, TAC
      from $table inner join dati_imei on $table.IMEI!=dati_imei.SERIAL_ICCID inner join dati_tacid on $table.TAC=dati_tacid.TacId
      group by dati_tacid.Modello
      ) AS stat2 ON stat.Modello = stat2.Modello";

    //echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello \t Tecnologia \t Tipo \t n_Modello \t Voce out on net \t Voce out roaming \t Voce in on net \t Voce in roaming \t Voce terminale \t %roaming \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];

        echo $nome_marca . " \t " . $nome_modello . " \t " . trim($obj3['Tecnologia']) . " \t " . trim($obj3['Tipo']) . " \t " . str_replace(".", ",", $obj3['numero_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_out_roaming_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_on_net_S']) . " \t " . str_replace(".", ",", $obj3['Voce_in_roaming_S']) . " \t " . str_replace(".", ",", $obj3['voce_terminale']) . " \t " . str_replace(".", ",", $obj3['percentuale_roaming']) . " \n";
    }
}

function tabella_IMEI($table, $nome_telefono) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"imei_telefoni_$nome_telefono.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;
    /* $query3 = "SELECT `dati_tacid`.`TacId` , `dati_tacid`.`Marca` , `dati_tacid`.`Modello` , $table.`MSISDN` , $table.`Tac` , `$table`.`PortfolioId` , `dati_utenti_traffico`.`codice_portafoglio` , sum( `dati_utenti_traffico`.`traffico` ) as volume_Dati
      FROM `dati_tacid`
      LEFT JOIN $table ON `dati_tacid`.`TacId` = `$table`.`Tac`
      LEFT JOIN `dati_utenti_traffico` ON `$table`.`PortfolioId` = `dati_utenti_traffico`.`codice_portafoglio`
      GROUP BY dati_tacid.Modello"; */
    $query3 = "select distinct IMEI ,dati_tacid.Modello ,dati_tacid.Marca from $table
    left join dati_tacid on $table.TAC=dati_tacid.TacId
    where dati_tacid.Modello='$nome_telefono'";
// $query3 = "select count(distinct IMEI) as numero_S,  TAC from $table  group by TAC";
//echo "<br>".$query3."<br>";
//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca;Modello;n IMEI \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];


        echo $nome_marca . ";" . $nome_modello . ";" . $obj3['IMEI'] . "\n";
    }
}

function tabella_IMEI_3ITA($table, $condizione) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"imei_telefoni.csv\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "SELECT `dati_imei_boxi`.`imei`, `dati_utenti`.*, `dati_tacid`.*
FROM `dati_tacid`
 LEFT JOIN `socmanager`.`dati_utenti` ON `dati_tacid`.`TacId` = `dati_utenti`.`Tac`
 LEFT JOIN `socmanager`.`dati_imei_boxi` ON `dati_utenti`.`IMEI` = `dati_imei_boxi`.`imei` where $condizione";

    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca;Modello;PortfolioId;imei;tac;MSISDN \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];


        echo $nome_marca . ";" . $nome_modello . ";" . $obj3['PortfolioId'] . ";" . $obj3['IMEI'] . ";" . $obj3['Tac'] . ";" . $obj3['MSISDN'] . " \n";
    }
}

function tabella_statistiche_numero_terminali_full_roamers_excel($table) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"numero_terminali_full_roamers.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "    select count(distinct IMEI) as numero_S, dati_tacid.Modello ,dati_tacid.Marca, TAC
    from $table left join dati_tacid on $table.TAC=dati_tacid.TacId     where (Voce_in_roaming +Voce_out_roaming)/( Voce_out_roaming+ Voce_in_roaming + Voce_out_on_net + Voce_in_on_net)*100>99
group by dati_tacid.Modello";
//echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Marca \t Modello \t n Terminali  \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];


        echo $nome_marca . " \t " . $nome_modello . " \t " . str_replace(".", ",", $obj3['numero_S']) . "  \n";
    }
}

function aggiorna_tabella_full_roamers_excel($table_vecchia, $table, $filtro = "") {
    $db_link = connect_db_li();


    $query = "ALTER TABLE `$table` DROP `Voce_out_on_net_FR` DOUBLE NOT NULL ,
DROP `Voce_out_roaming_FR` DOUBLE NOT NULL ,
DROP `Voce_in_on_net_FR` DOUBLE NOT NULL,
    DROP `numero_full_roamers` DOUBLE NOT NULL,
DROP `Voce_in_roaming_FR` DOUBLE NOT NULL ;";
//echo "<br>".$query;
    if (!mysqli_query($db_link,$query))
        echo "<p>Sono stati rimossi i dati precedenti</p>";
    $query = "ALTER TABLE `$table` ADD `Voce_out_on_net_FR` DOUBLE NOT NULL ,
ADD `Voce_out_roaming_FR` DOUBLE NOT NULL ,
ADD `Voce_in_on_net_FR` DOUBLE NOT NULL,
ADD `Voce_in_roaming_FR` DOUBLE NOT NULL,
    ADD `numero_full_roamers` DOUBLE NOT NULL;";
//echo "<br>".$query;
    if (!mysqli_query($db_link,$query))
        echo "<p>Tabella aggiornata</p>";

    $flag = false;

    $query3 = "
select *,
    (Voce_out_roaming_S+Voce_in_roaming_S)/(Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S) as percentuale_roaming,
    (Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S)/numero_S as voce_terminale
     from (
    select
        Tac as Tac1,
        sum( Voce_out_on_net) as Voce_out_on_net_S,
        sum( Voce_out_roaming) as Voce_out_roaming_S,
        sum( Voce_in_on_net) as Voce_in_on_net_S,
        sum( Voce_in_roaming) as Voce_in_roaming_S

    from $table_vecchia
    where (Voce_in_roaming +Voce_out_roaming)/( Voce_out_roaming+ Voce_in_roaming + Voce_out_on_net + Voce_in_on_net)*100>90 $filtro
    group by Tac

    ) as stat left join (

    select count(distinct IMEI) as numero_S, Tac as Tac2
    from $table_vecchia
    where (Voce_in_roaming +Voce_out_roaming)/( Voce_out_roaming+ Voce_in_roaming + Voce_out_on_net + Voce_in_on_net)*100>90 $filtro
    group by Tac

    ) AS stat2 ON stat.Tac1 = stat2.Tac2";
//echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    //echo "Marca \t Modello \t n Terminali  \n";

    while ($obj3 = mysqli_fetch_array($result3)) {
        $query = "UPDATE $table SET `Voce_out_on_net_FR` = " . $obj3['Voce_out_on_net_S'] . ",`Voce_out_roaming_FR` = " . $obj3['Voce_out_roaming_S'] . ",`Voce_in_on_net_FR` = " . $obj3['Voce_in_on_net_S'] . ",`Voce_in_roaming_FR` = " . $obj3['Voce_in_roaming_S'] . ",`numero_full_roamers` = " . $obj3['numero_S'] . " WHERE  `Tac1`='" . $obj3['Tac1'] . "'";

        mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    }
}

function aggiorna_tabella_3ita_excel($table_vecchia, $table, $filtro = "") {
    $db_link = connect_db_li();


    $query = "ALTER TABLE `$table` DROP `Voce_out_on_net_3ITA` DOUBLE NOT NULL ,
DROP `Voce_out_roaming_3ITA` DOUBLE NOT NULL ,
DROP `Voce_in_on_net_3ITA` DOUBLE NOT NULL,
    DROP `numero_3ITA` DOUBLE NOT NULL,
DROP `Voce_in_roaming_3ITA` DOUBLE NOT NULL ;";
//echo "<br>".$query;
    if (!mysqli_query($db_link,$query))
        echo "<p>Sono stati rimossi i dati precedenti</p>";
    $query = "ALTER TABLE `$table` ADD `Voce_out_on_net_3ITA` DOUBLE NOT NULL ,
ADD `Voce_out_roaming_3ITA` DOUBLE NOT NULL ,
ADD `Voce_in_on_net_3ITA` DOUBLE NOT NULL,
ADD `Voce_in_roaming_3ITA` DOUBLE NOT NULL,
    ADD `numero_3ITA` DOUBLE NOT NULL;";
//echo "<br>".$query;
    if (!mysqli_query($db_link,$query))
        echo "<p>Tabella aggiornata</p>";

    $flag = false;

    $query3 = "
select *,
    (Voce_out_roaming_S+Voce_in_roaming_S)/(Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S) as percentuale_roaming,
    (Voce_out_on_net_S+Voce_out_roaming_S+Voce_in_on_net_S+Voce_in_roaming_S)/numero_S as voce_terminale
     from (
    select
        Tac as Tac1,FLAG_MAGAZZINO,
        sum( Voce_out_on_net) as Voce_out_on_net_S,
        sum( Voce_out_roaming) as Voce_out_roaming_S,
        sum( Voce_in_on_net) as Voce_in_on_net_S,
        sum( Voce_in_roaming) as Voce_in_roaming_S

    from $table_vecchia
    where FLAG_MAGAZZINO=1  $filtro
    group by Tac

    ) as stat left join (

    select count(distinct IMEI) as numero_S, Tac as Tac2,FLAG_MAGAZZINO
    from $table_vecchia
    where FLAG_MAGAZZINO=1 $filtro
    group by Tac

    ) AS stat2 ON stat.Tac1 = stat2.Tac2";
//echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    //echo "Marca \t Modello \t n Terminali  \n";

    while ($obj3 = mysqli_fetch_array($result3)) {
        $query = "UPDATE $table SET `Voce_out_on_net_3ITA` = " . $obj3['Voce_out_on_net_S'] . ",`Voce_out_roaming_3ITA` = " . $obj3['Voce_out_roaming_S'] . ",`Voce_in_on_net_3ITA` = " . $obj3['Voce_in_on_net_S'] . ",`Voce_in_roaming_3ITA` = " . $obj3['Voce_in_roaming_S'] . ",`numero_3ITA` = " . $obj3['numero_S'] . " WHERE  `Tac1`='" . $obj3['Tac1'] . "'";

        //echo "<p>$query</p>";
        mysqli_query($db_link,$query) or die($query . " - " . mysql_error());
    }
}

function tac_id_excel($table) {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"tac_id_excel.csv\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "    select COUNT(Tac) as numeroTac,Tac, Modello ,Marca  from $table group by tac";
//echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo " Tac | Marca | Modello|  numeroTac  \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];


        echo $obj3['Tac'] . "|" . $nome_marca . "|" . $nome_modello . "|" . $obj3['numeroTac'] . "\n";
    }
}

function tabella_statistiche_numero_terminali_fascia($table, $min, $max, $nome_terminale) {
    $db_link = connect_db_li();

    $flag = false;

    $query3 = "SELECT `dati_tacid`.`TacId`, `dati_tacid`.`Marca`, `dati_tacid`.`Modello`, $table.`Tac`, $table.`PortfolioId`, `dati_utenti_traffico`.`codice_portafoglio`, `dati_utenti_traffico`.`traffico`, COUNT(distinct $table.`IMEI`) as numero_S
FROM `dati_tacid`
 LEFT JOIN $table ON `dati_tacid`.`TacId` = $table.`Tac`
 LEFT JOIN `socmanager`.`dati_utenti_traffico` ON `dati_utenti`.`PortfolioId` = `dati_utenti_traffico`.`codice_portafoglio`
WHERE ( dati_tacid.Modello='$nome_terminale' AND `dati_utenti_traffico`.`traffico`>=$min AND `dati_utenti_traffico`.`traffico`<=$max)";
    //echo "<br>".$query3."<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    while ($obj3 = mysqli_fetch_array($result3)) {
        return str_replace(".", ",", $obj3['numero_S']);
    }
}

function tabella_statistiche_numero_terminali_fascia_roaming($table, $min, $max, $nome_terminale, $imei_tre = false) {
    $db_link = connect_db_li();
    if ($imei_tre)
        $merge_tabella_imei = "inner join dati_imei on $table.IMEI=dati_imei.SERIAL_ICCID";
    else
        $merge_tabella_imei = "";
// header("Content-Disposition: attachment; filename=\"numero_terminali_".$nome_terminale."_".$min."_".$max.".xls\"");
//header("Content-Type: application/vnd.ms-excel");


    $flag = false;
    $query3 = "select count(imei) as numero_S from (
        SELECT imei,sum(Voce_out_on_net) as Voce_out_on_net_ris ,sum(Voce_out_roaming)as Voce_out_roaming_ris,
    sum(Voce_in_on_net) as Voce_in_on_net_ris,sum(Voce_in_roaming) as Voce_in_roaming_ris

        FROM $table  inner JOIN `dati_tacid` ON `dati_tacid`.`TacId` = $table.`Tac` $merge_tabella_imei
        WHERE (dati_tacid.Modello='$nome_terminale') group by imei ) as table1
        WHERE (
        100*(Voce_out_roaming_ris+Voce_in_roaming_ris)/(Voce_out_on_net_ris+Voce_out_roaming_ris+Voce_in_on_net_ris+Voce_in_roaming_ris)>=$min AND
        100*(Voce_out_roaming_ris+Voce_in_roaming_ris)/(Voce_out_on_net_ris+Voce_out_roaming_ris+Voce_in_on_net_ris+Voce_in_roaming_ris)<$max)";


    echo "<br>" . $query3 . "<br>";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    while ($obj3 = mysqli_fetch_array($result3)) {
        return str_replace(".", ",", $obj3['numero_S']);
    }
}

function tabella_statistiche_numero_terminali_fascia_voce_sum($table, $min, $max, $nome_terminale, $imei_tre = false) {
    $db_link = connect_db_li();
    if ($imei_tre)
        $merge_tabella_imei = "inner join dati_imei on $table.IMEI=dati_imei.SERIAL_ICCID";
    else
        $merge_tabella_imei = "";


    $flag = false;
    $query3 = "select sum(Voce_out_on_net_ris+Voce_out_roaming_ris+Voce_in_on_net_ris+Voce_in_roaming_ris) as somma_voce from (
        SELECT imei,sum(Voce_out_on_net) as Voce_out_on_net_ris ,sum(Voce_out_roaming)as Voce_out_roaming_ris,
    sum(Voce_in_on_net) as Voce_in_on_net_ris,sum(Voce_in_roaming) as Voce_in_roaming_ris

        FROM $table  inner JOIN `dati_tacid` ON `dati_tacid`.`TacId` = $table.`Tac` $merge_tabella_imei
        WHERE (dati_tacid.Modello='$nome_terminale') group by imei ) as table1
        WHERE (
        100*(Voce_out_roaming_ris+Voce_in_roaming_ris)/(Voce_out_on_net_ris+Voce_out_roaming_ris+Voce_in_on_net_ris+Voce_in_roaming_ris)>=$min AND
        100*(Voce_out_roaming_ris+Voce_in_roaming_ris)/(Voce_out_on_net_ris+Voce_out_roaming_ris+Voce_in_on_net_ris+Voce_in_roaming_ris)<$max)";


    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    while ($obj3 = mysqli_fetch_array($result3)) {
        return str_replace(".", ",", $obj3['somma_voce']);
    }
}

function tabella_statistiche_excel_emo() {
    $db_link = connect_db_li();

    header("Content-Disposition: attachment; filename=\"Statistiche_emo.xls\"");
    header("Content-Type: application/vnd.ms-excel");


    $flag = false;

    $query3 = "
select sum(cnt) as somma_sim_tac, dati_tacid.Modello ,dati_tacid.Marca, TAC
    from (SELECT count( distinct u1.IMEI ) as cnt,u1.Tac, u1.MSISDN as ns1,u2.MSISDN as ns2
      FROM " . TABLE2 . " AS u1
      JOIN " . TABLE1 . "  AS u2 ON u1.MSISDN = u2.MSISDN GROUP BY u1.Tac)as temp
    left join dati_tacid on temp.TAC=dati_tacid.TacId group by dati_tacid.Modello";
    /*

     *  $query3 = "SELECT count( u1.Modello ) as cnt,u1.IMEI, u1.Marca AS marca1, u1.Modello AS m1, u1.MSISDN,u2.MSISDN

      FROM " . TABLE1 . " AS u1
      JOIN  " . TABLE2 . "  AS u2 ON u1.MSISDN = u2.MSISDN GROUP BY m1";
     */
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo "Contatore \t Marca \t Modello   \n";

    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "N/A";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "N/A";
        else
            $nome_modello = $obj3['Modello'];

        echo "" . $obj3['somma_sim_tac'] . " \t " . $nome_marca . " \t " . $nome_modello . " \n";
    }
}

function top($table1, $table2, $funzione, $numero_valori, $condizione_ordine = NULL) {
    $db_link = connect_db_li();
    switch ($funzione) {
        case 'top_in_tel':
            $terminale = "dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='Tablet' or dati_tacid.Tecnologia='Phablet'";
            $ordine = "desc";

            break;
        case 'top_in_dat':
            $terminale = "dati_tacid.Tecnologia='datacard' or dati_tacid.Tecnologia='MBB'";
            $ordine = "desc";

            break;
        case 'top_out_tel':
            $terminale = "dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='Tablet' or dati_tacid.Tecnologia='Phablet'";
            $ordine = "asc";

            break;
        case 'top_out_dat':
            $terminale = "dati_tacid.Tecnologia='datacard' or dati_tacid.Tecnologia='MBB'";
            $ordine = "asc";

            break;
        default:
            break;
    }


    $var_ordine = "";
    switch ($condizione_ordine) {
        case ">":
            $var_ordine = "  numero_terminali1 - numero_terminali2 > 0";

            break;

        case "<":
            $var_ordine = " numero_terminali1 - numero_terminali2 < 0";

            break;
    }
    $query3 = "select *,numero_terminali1-numero_terminali2 as diff_teminali from(
    select COALESCE(sum($table2.numero_S),0) as numero_terminali2 ,COALESCE(sum($table1.numero_S),0) as numero_terminali1 , dati_tacid.Modello, dati_tacid.Tipo  ,dati_tacid.Marca, $table1.Tac1 as Tac$table1,$table2.Tac1
    from dati_tacid  left  join $table1 on $table1.Tac1=dati_tacid.TacId left  join $table2 on $table2.Tac1=dati_tacid.TacId
    where $terminale  group by dati_tacid.Modello )as tabella_diff
    where  $var_ordine
    order by diff_teminali  $ordine LIMIT 0 , $numero_valori";


//echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    echo "<br><table align=center style=\"width:300px\"><thead><tr><th>Marca</th><th>Modello</th><th>n Terminali</th><th>Tipo</th><tr></thead><tbody>";
    $numero_terminali = 0;
    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = $obj3['Modello'];
        $numero_terminali = $numero_terminali + $obj3['diff_teminali'];
        if ($obj3['diff_teminali'] > 0)
            echo "<tr><th>" . $nome_marca . "</th><th>" . $nome_modello . "</th><th bgcolor=\"#00FF00\">" . $obj3['diff_teminali'] . "</th><th bgcolor=\"#ff0000\">" . $obj3['Tipo'] . "</th></tr>";
        else
            echo "<tr><th>" . $nome_marca . "</th><th>" . $nome_modello . "</th><th bgcolor=\"#ff0000\">" . $obj3['diff_teminali'] . "</th><th bgcolor=\"#ff0000\">" . $obj3['Tipo'] . "</th></tr>";
    }
    echo "</tbody><tfoot><tr><th>Totale</th><th>$numero_terminali</th><th>Tipo</th><tr></tfoot></table>
    <br><a href=\"#top\">Go to the Top</a> ";
}

function top_marca($table1, $table2, $funzione, $condizione_ordine, $lista_vendor) {
    $db_link = connect_db_li();
    switch ($funzione) {
        case 'top_in_tel':
            $terminale = "dati_tacid.Tecnologia='Phablet' or dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='Tablet'";
            $ordine = "desc";

            break;

        case 'top_out_tel':
            $terminale = "dati_tacid.Tecnologia='Phablet' or dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='Tablet'";
            $ordine = "asc";

            break;

        default:
            break;
    }


    $var_ordine = "";
    switch ($condizione_ordine) {
        case ">":
            $var_ordine = "  numero_terminali1 - numero_terminali2 > 0";

            break;

        case "<":
            $var_ordine = " numero_terminali1 - numero_terminali2 < 0";

            break;
    }
    $query3 = "select *, sum(diff_teminali) as diff_marca from (select *,numero_terminali1-numero_terminali2 as diff_teminali from(
    select COALESCE(sum($table2.numero_S),0) as numero_terminali2 ,COALESCE(sum($table1.numero_S),0) as numero_terminali1 , dati_tacid.Modello ,dati_tacid.Marca, $table1.Tac1 as Tac$table1,$table2.Tac1
    from dati_tacid  left  join $table1 on $table1.Tac1=dati_tacid.TacId left  join $table2 on $table2.Tac1=dati_tacid.TacId
    where $terminale  group by dati_tacid.Modello )as tabella_diff
    where  $var_ordine and (";
    foreach ($lista_vendor as $key => $value) {

        if ($key < count($lista_vendor) && ($key > 0))
            $query3 = $query3 . " or ";
        $query3 = $query3 . " Marca='" . $value . "'";
    }
    $query3 = $query3 . ") order by diff_teminali  ) as temp4
group by Marca order by  diff_marca  $ordine limit 0,10";


    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());
    echo'<div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <ul class="nav navbar-right panel_toolbox">
                    <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                    </li>
                    <li><a class="close-link"><i class="fa fa-close"></i></a>
                    </li>
                </ul>
                <div class="clearfix"></div>
            </div>
            <div class="x_content">
                ';
    #echo "<div style=\"margin-right:auto;margin-left:auto;\"><table align=center>";
    #echo "<thead><tr><td></td>";
    echo '<table class="table table-striped table-bordered"><thead><tr><th>Marca</th><th>n Terminali</th><tr></thead><tbody>';
    $numero_terminali = 0;
    $temp = 0;
    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = substr($nome_marca, 0, 3) . " " . $obj3['Modello'];
        $numero_terminali = $numero_terminali + $obj3['diff_teminali'];
        $risultato[$nome_marca] = $obj3['diff_marca'];
        if ($obj3['diff_teminali'] > 0)
            echo "<tr><th>" . $nome_marca . "</th><th bgcolor=\"#00FF00\">" . $obj3['diff_marca'] . "</th></tr>";
        else
            echo "<tr><th>" . $nome_marca . "</th><th bgcolor=\"#ff0000\">" . $obj3['diff_marca'] . "</th></tr>";
        $temp++;
    }
    // print_r($risultato);
    echo "</tbody></table><br></div></div>";
    return $risultato;
}

function top_value($table1, $table2, $funzione, $numero_valori, $condizione_ordine = NULL) {
    $db_link = connect_db_li();
    switch ($funzione) {
        case 'top_in_tel':
            $terminale = "dati_tacid.Tecnologia='Handset'  or dati_tacid.Tecnologia='MBB'";
            $ordine = "desc";

            break;
        case 'top_in_dat':
            $terminale = "dati_tacid.Tecnologia='datacard'";
            $ordine = "desc";

            break;
        case 'top_out_tel':
            $terminale = "dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='MBB'";
            $ordine = "asc";

            break;
        case 'top_out_dat':
            $terminale = "dati_tacid.Tecnologia='datacard'";
            $ordine = "asc";

            break;
        default:
            break;
    }


    $var_ordine = "";
    switch ($condizione_ordine) {
        case ">":
            $var_ordine = "  numero_terminali1 - numero_terminali2 > 0";

            break;

        case "<":
            $var_ordine = " numero_terminali1 - numero_terminali2 < 0";

            break;
    }
    $query3 = "select *,numero_terminali1-numero_terminali2 as diff_teminali from(
    select COALESCE(sum($table2.numero_S),0) as numero_terminali2 ,COALESCE(sum($table1.numero_S),0) as numero_terminali1 , dati_tacid.Modello ,dati_tacid.Marca, $table1.Tac1 as Tac$table1,$table2.Tac1
    from dati_tacid  left  join $table1 on $table1.Tac1=dati_tacid.TacId left  join $table2 on $table2.Tac1=dati_tacid.TacId
    where $terminale )as tabella_diff
    where  $var_ordine
    order by diff_teminali  $ordine LIMIT 0 , $numero_valori";


    echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    $obj3 = mysqli_fetch_array($result3);
    return $obj3['diff_teminali'];
}

function matrice_dati($lista_tabella, $lista_nomi, $tipo_terminale, $gruppo = "GROUP BY dati_tacid.Marca", $limit = 4, $lista_condizioni = NULL, $parametro_di_ricerca = "Modello", $minimo = NULL, $marca = NULL, $tipo_grafico = NULL, $piano = NULL, $fullroamers = false, $citta = 0, $imeisv = false, $titolo = "", $sottotitolo = "") {
    $db_link = connect_db_li();
    if ($lista_tabella[0] == "") {
        //echo "<br>";
        array_shift($lista_tabella);
    }
    if ($lista_nomi[0] == "") {
        //echo "<br>";
        array_shift($lista_nomi);
    }
    $riga = 0;
    $matrice_risultati = array();
    if ($piano == NULL)
        $piano = "S";
    switch ($tipo_grafico) {
        case "drop":
            $unita_misura = "%";
            $ordinata = "% drop";
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $numero_terminali_prov = _valori($value, "sum( numero_S )", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    if ($numero_terminali_prov > 400)
                        $matrice_risultati[$riga][$colonna] = _valori($value, "(sum(mc4)/(sum(mc2)+sum(mc3)+sum(mc4)))", " $parametro_di_ricerca='" . $value1 . "' ", $tipo_terminale);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
            }
            $colonna = 0;
            $matrice_risultati[$riga][$colonna] = "National Average";
            for ($k = 0; $k < count($lista_tabella); $k++) {
                $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                $colonna++;
                $matrice_risultati[$riga][$colonna] = $temp[1] / 100;
                //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
            }

            break;
        case "numero_ter":

            $unita_misura = "k";
            $ordinata = "# devices";

            //print_r($lista_condizioni);

            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;
                    //echo $tipo_terminale . "<br>";

                    $sum = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "numero_ter_LTE":

            $unita_misura = "k";
            $ordinata = "# devices";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "")) {
                    $ricerca = " tipo is Null ";
                } else
                    $ricerca = " $parametro_di_ricerca='" . $value1 . "' ";
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numeroLTE_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numeroLTE_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numeroLTE_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( numeroLTE_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = $sum - $sum_fullroamers;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = ($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            break;

        case "roaming":

            $unita_misura = "%";
            $ordinata = "% roaming";
            foreach ($lista_condizioni as $key1 => $value1) {

                $colonna = 0;
//echo substr($piano, 0, 4);
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                $colonna++;

                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_comuneps";
                            $filtro_citta = " and `COMUNE_PREVALENTE_PS`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if ($numero_terminali_prov > 0) {

                        $tot_2g = _valori($value, "(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_2g  ".$tot_2g."<br>";
                        $tot_3g = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
//echo "tot_3g  ".$tot_3g."<br>";

                        $tot_2g_FR = 0;
                        $tot_3g_FR = 0;
                        $tot_2g_FR_tutti_terminali = 0;
                        $tot_3g_FR_tutti_terminali = 0;

                        if ($ITA) {
                            $tot_2g_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_2g_tutti_terminali  ".$tot_2g_tutti_terminali."<br>";
                            $tot_3g_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            //echo "tot_3g_tutti_terminali  ".$tot_3g_tutti_terminali."<br>";
                        }

                        if ($fullroamers == TRUE) {
                            $tot_2g_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $tot_3g_FR = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            if ($ITA) {
                                $tot_2g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers)+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                                $tot_3g_FR_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers)+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            }
                        }

                        if (($citta != '0') && !$verifica_citta) {
                            $matrice_risultati[$riga][$colonna] = 0;
                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = 0;
                            }
                        } else {
                            $matrice_risultati[$riga][$colonna] = round(($tot_2g - $tot_2g_FR) * 100 / ($tot_2g + $tot_3g - $tot_2g_FR - $tot_3g_FR), 2);

                            if ($ITA) {
                                $matrice_risultati[$riga + 1][$colonna] = round(($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR)) * 100 / ($tot_2g_tutti_terminali - $tot_2g_FR_tutti_terminali - ($tot_2g - $tot_2g_FR) + $tot_3g_tutti_terminali - $tot_3g_FR_tutti_terminali - ($tot_3g - $tot_3g_FR_tutti_terminali)), 2);
                                //echo $matrice_risultati[$riga + 1][0]."<br>";
                                //echo "tot_2g_FR_tutti_terminali  ".$tot_2g_FR_tutti_terminali."<br>";
                                //     echo "tot_2g_FR  ".$tot_2g_FR."<br>";
                                //    echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali ."<br>";
                                //   echo "tot_3g_FR_tutti_terminali  ".$tot_3g_FR_tutti_terminali."<br>";
                            }
                        }
                    } else
                        $matrice_risultati[$riga][$colonna] = 0;

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }
            $colonna = 0;
            if (!$imeisv) {
                $matrice_risultati[$riga][$colonna] = "National Average";
                for ($k = 0; $k < count($lista_tabella); $k++) {
                    $temp = media_nazionale2($lista_tabella[$k], $tipo_terminale);
                    $colonna++;
                    $matrice_risultati[$riga][$colonna] = $temp[0];
                    //print_r(media_nazionale2($lista_tabella[$k], $tipo_terminale));
                }
            }
            break;
        case "voce":

            $unita_misura = "";
            $ordinata = "voice (minutes)";

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $verifica_citta = true;
                            echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_tutti_terminali = _valori($value, "(sum(Voce_out_on_net_$piano_totale)+sum(Voce_in_on_net_$piano_totale))+(sum(Voce_out_roaming_$piano_totale)+sum(Voce_in_roaming_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $voce_sum_fullroamers = _valori($value, "(sum(Voce_out_on_net_" . $piano . "_FullRoamers )+sum(Voce_in_on_net_" . $piano . "_FullRoamers )+sum(Voce_out_roaming_" . $piano . "_FullRoamers )+sum(Voce_in_roaming_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $voce_sum_fullroamers_tot = _valori($value, "(sum(Voce_out_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_in_on_net_" . $piano_totale . "_FullRoamers )+sum(Voce_out_roaming_" . $piano_totale . "_FullRoamers )+sum(Voce_in_roaming_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $voce_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_voce = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);


                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($sum - $sum_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round(($sum_voce - $voce_sum_fullroamers) / ($sum - $sum_fullroamers), 0);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($voce_tutti_terminali - $voce_sum_fullroamers_tot) - ($sum_voce - $voce_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)), 0);
                        }
                    }

                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "PDP":

            $unita_misura = "";
            $ordinata = "PDP (numero)";
            echo $parametro_di_ricerca;


            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_comuneps";
                            $filtro_citta = " and `COMUNE_PREVALENTE_PS`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";
                    if ($imeisv) {
                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_imeisv";
                            $verifica_citta = true;
                            $parametro_di_ricerca = "modello";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        echo " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta . "<bR>";
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(PDP_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(PDP_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(PDP_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                        $pdp_sum_fullroamers_tot = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(PDP_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;

        case "chiamate_non_risposte":

            $unita_misura = "";
            $ordinata = "Chiamate non risposte (numero)";
            $pdp_sum_fullroamers_tot = 0;

            foreach ($lista_condizioni as $key1 => $value1) {
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;


                $colonna++;
                foreach ($lista_tabella as $key => $value) {

                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $table_citta = $value;
                            $value = $value . "_comuneps";
                            $filtro_citta = " and `COMUNE_PREVALENTE_PS`='$citta'";
                        } else {
                            $filtro_citta = "";
                            $table_citta = "";
                        }
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $voce_sum_fullroamers_tot = 0;
                    //if (_check_citta($table_citta)) {
                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_tutti_terminali = _valori($value, "(sum(chiamate_non_risposte_$piano_totale))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        $pdp_sum_fullroamers = _valori($value, "(sum(chiamate_non_risposte_" . $piano . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                            $pdp_sum_fullroamers_tot = _valori($value, "(sum(chiamate_non_risposte_" . $piano_totale . "_FullRoamers ))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers = 0;
                        $pdp_sum_fullroamers = 0;
                    }
                    $sum = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $sum_pdp = _valori($value, "(sum(chiamate_non_risposte_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    if (($sum - $sum_fullroamers) > 0)
                        $matrice_risultati[$riga][$colonna] = round(($sum_pdp - $pdp_sum_fullroamers) / ($sum - $sum_fullroamers), 3);
                    else
                        $matrice_risultati[$riga][$colonna] = 0;
                    if ($ITA) {
                        if ((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) > 0)
                            $matrice_risultati[$riga + 1][$colonna] = (($pdp_tutti_terminali - $pdp_sum_fullroamers_tot) - ($sum_pdp - $pdp_sum_fullroamers)) / (($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers));
                        else
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                    }
                    //} else {
                    //    $matrice_risultati[$riga][$colonna] = 0;
                    //    if ($ITA) {
                    //        $matrice_risultati[$riga + 1][$colonna] = 0;
                    //    }
                    //}
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }

            break;
        case "voce_totale":
            $unita_misura = "";
            $ordinata = "voice totale ( Milion minutes)";
            $unita_di_misura = 1000000;
            foreach ($lista_condizioni as $key1 => $value1) {
                $colonna = 0;
                $matrice_risultati[$riga][$colonna] = $value1;
                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            $ordinata = "voice totale ( Milion minutes)";
                            $verifica_citta = true;
                            $unita_di_misura = 1000000;
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";
                    $numero_terminali_prov = _valori($value, "sum( numero_$piano )", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);

                    //if ($numero_terminali_prov > 100) {
                    $tot = _valori($value, "(sum(Voce_out_on_net_$piano)+sum(Voce_in_on_net_$piano))+(sum(Voce_out_roaming_$piano)+sum(Voce_in_roaming_$piano))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    $tot_FR = 0;

                    if ($fullroamers == TRUE) {
                        $tot_FR = _valori($value, "(sum(Voce_out_roaming_" . $piano . "_FullRoamers)+sum(Voce_in_roaming_" . $piano . "_FullRoamers))+(sum(Voce_out_on_net_" . $piano . "_FullRoamers)+sum(Voce_in_on_net_" . $piano . "_FullRoamers))", " $parametro_di_ricerca='" . $value1 . "' " . $filtro_citta, $tipo_terminale);
                    }

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($tot - $tot_FR) / $unita_di_misura, 2);
                    }
                    //} else
                    //  $matrice_risultati[$riga][$colonna] = 0;
                    $colonna++;
                }
                $riga++;
                //echo "<br>";
            }
            break;
        case "dati":
            $unita_misura = "MB";
            $ordinata = "data traffic";


            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;
                    $vol_tutti_terminali = 0;
                    $tot_tutti_terminali = 0;
                    $sum_fullroamers = 0;
                    $num_fullroamers = 0;
                    $sum_fullroamers_tot = 0;
                    $num_fullroamers_tot = 0;
                    $num_ter = 0;

                    if ($ITA) {
                        $vol_tutti_terminali = _valori($value, "sum(volume_Dati_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                        $tot_tutti_terminali = _valori($value, "sum(numero_$piano_totale)", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( volume_Dati_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        $num_fullroamers = _valori($value, "sum( numero_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( volume_Dati_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                            $num_fullroamers_tot = _valori($value, "sum( numero_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else {
                        $sum_fullroamers_tot = 0;
                        $num_fullroamers_tot = 0;
                    }

                    $sum = _valori($value, "sum( volume_Dati_$piano )", $ricerca . $filtro_citta, $tipo_terminale);
                    $num_ter = _valori($value, "sum( numero_$piano )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        if (($num_ter - $num_fullroamers) > 0)
                            $matrice_risultati[$riga][$colonna] = round((($sum - $sum_fullroamers) / ($num_ter - $num_fullroamers)) / 1000, 2);
                        else
                            $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round(((($vol_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) /
                                    (($tot_tutti_terminali - $num_fullroamers_tot) - ($num_ter - $num_fullroamers))) / 1000, 2);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;
        case "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
            if ($tipo_grafico == "dati_totale")
                $seme = "volume_Dati";
            else if ($tipo_grafico == "dati_totale_LTE")
                $seme = "volume_Dati_LTE";
            else if ($tipo_grafico == "dati_totale_3g_di_device_LTE_mag_0")
                $seme = "traffico3G_terminaliLTE";



            $unita_misura = "T";
            $ordinata = "data traffic";
            foreach ($lista_condizioni as $key1 => $value1) {
                $ricerca = "";
                if (substr($piano, 0, 4) == "3ITA") {
                    $ITA = TRUE;
                } else
                    $ITA = FALSE;
                $colonna = 0;

                if ($ITA) {
                    $matrice_risultati[$riga][$colonna] = $value1 . "_3ITA";
                    $matrice_risultati[$riga + 1][$colonna] = $value1 . "_NO3ITA";
                    $piano_totale = "S" . substr($piano, 4);
                } else
                    $matrice_risultati[$riga][$colonna] = $value1;

                if (($parametro_di_ricerca == 'Tipo') && ($value1 == "n/a")) {
                    $ricerca = " tipo is Null or ";
                } elseif (($parametro_di_ricerca == 'classe_throughput') && ($value1 == "n/a")) {
                    $ricerca = " classe_throughput is Null or ";
                } elseif (($parametro_di_ricerca == 'Tecnologia') && ($value1 == "n/a")) {
                    $ricerca = " Tecnologia is Null or ";
                }
                $ricerca = "(" . $ricerca . " $parametro_di_ricerca='" . $value1 . "' )";

                $colonna++;
                foreach ($lista_tabella as $key => $value) {
                    $verifica_citta = false;
                    if ($citta != '0') {

                        if (_check_citta($value)) {
                            //echo "<br>" . $citta . "<br>";
                            $value = $value . "_comunecs";
                            $filtro_citta = " and `COMUNE_PREVALENTE_CS`='$citta'";
                            $verifica_citta = true;
                        } else
                            $filtro_citta = "";
                    } else
                        $filtro_citta = "";

                    $sum_fullroamers_tot = 0;


                    if ($ITA) {
                        $tot_tutti_terminali = _valori($value, "sum(" . $seme . "_" . $piano_totale . ")", $ricerca . $filtro_citta, $tipo_terminale);
                    }
                    if ($fullroamers == TRUE) {
                        $sum_fullroamers = _valori($value, "sum( " . $seme . "_" . $piano . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);

                        if ($ITA) {
                            $sum_fullroamers_tot = _valori($value, "sum( " . $seme . "_" . $piano_totale . "_FullRoamers )", $ricerca . $filtro_citta, $tipo_terminale);
                        }
                    } else
                        $sum_fullroamers = 0;

                    $sum = _valori($value, "sum( " . $seme . "_" . $piano . " )", $ricerca . $filtro_citta, $tipo_terminale);

                    if (($citta != '0') && !$verifica_citta) {
                        $matrice_risultati[$riga][$colonna] = 0;
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = 0;
                        }
                    } else {
                        $matrice_risultati[$riga][$colonna] = round(($sum - $sum_fullroamers) / 1000 / 1000 / 1000, 0);
                        if ($ITA) {
                            $matrice_risultati[$riga + 1][$colonna] = round((($tot_tutti_terminali - $sum_fullroamers_tot) - ($sum - $sum_fullroamers)) / 1000 / 1000 / 1000, 0);
                        }
                    }
                    $colonna++;
                }
                if ($ITA) {
                    $riga = $riga + 2;
                } else
                    $riga++;
                //echo "<br>";
            }


            break;

        default:
            break;
    }

    for ($riga = 0; $riga < count($matrice_risultati); $riga++) {
        for ($colonna = 1; $colonna <= count($lista_nomi); $colonna++) {
            switch ($tipo_grafico) {
                case "drop":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] * 100, 2);
                    break;
                case "numero_ter":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "numero_ter_LTE":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna] / 1000, 2);
                    break;
                case "roaming":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "voce":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "dati" or "dati_totale" or "dati_totale_LTE" or "dati_totale_3g_di_device_LTE_mag_0":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 0);
                    break;

                case "voce_totale":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "chiamate_non_risposte":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                case "PDP":
                    $matrice_risultati[$riga][$colonna] = round($matrice_risultati[$riga][$colonna], 2);
                    break;
                default:
                    break;
            }
        }
    }
    return $matrice_risultati;


    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Tabella incremento</h2><br>";
    stampa_incremento($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Stampa tabella carg</h2><br>";
    stampa_carg_2($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
    echo "<div style=\"margin-right:auto;margin-left:auto;\"><h2>Tabella incremento TIPO 2</h2><br>";
    //stampa_incremento_tipo2($matrice_risultati, $lista_nomi_visualizzati);
    echo "</div>";
}

function top_marca_risultati($table1, $table2, $funzione, $condizione_ordine, $lista_vendor) {
    $db_link = connect_db_li();
    switch ($funzione) {
        case 'top_in_tel':
            $terminale = "dati_tacid.Tecnologia='Phablet' or dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='Tablet'";
            $ordine = "desc";

            break;

        case 'top_out_tel':
            $terminale = "dati_tacid.Tecnologia='Phablet' or dati_tacid.Tecnologia='Handset' or dati_tacid.Tecnologia='Tablet'";
            $ordine = "asc";

            break;

        default:
            break;
    }


    $var_ordine = "";
    switch ($condizione_ordine) {
        case ">":
            $var_ordine = "  numero_terminali1 - numero_terminali2 > 0";

            break;

        case "<":
            $var_ordine = " numero_terminali1 - numero_terminali2 < 0";

            break;
    }
    $query3 = "select *, sum(diff_teminali) as diff_marca from (select *,numero_terminali1-numero_terminali2 as diff_teminali from(
    select COALESCE(sum($table2.numero_S),0) as numero_terminali2 ,COALESCE(sum($table1.numero_S),0) as numero_terminali1 , dati_tacid.Modello ,dati_tacid.Marca, $table1.Tac1 as Tac$table1,$table2.Tac1
    from dati_tacid  left  join $table1 on $table1.Tac1=dati_tacid.TacId left  join $table2 on $table2.Tac1=dati_tacid.TacId
    where $terminale  group by dati_tacid.Modello )as tabella_diff
    where  $var_ordine and (";
    foreach ($lista_vendor as $key => $value) {

        if ($key < count($lista_vendor) && ($key > 0))
            $query3 = $query3 . " or ";
        $query3 = $query3 . " Marca='" . $value . "'";
    }
    $query3 = $query3 . ") order by diff_teminali  ) as temp4
group by Marca order by  diff_marca  $ordine limit 0,10";


    //echo $query3;
    $result3 = mysqli_query($db_link,$query3) or die($query3 . " - " . mysql_error());

    
    $numero_terminali = 0;
    $temp = 0;
    while ($obj3 = mysqli_fetch_array($result3)) {

        if ($obj3['Marca'] == "")
            $nome_marca = "ND";
        else
            $nome_marca = $obj3['Marca'];

        if ($obj3['Modello'] == "")
            $nome_modello = "ND";
        else
            $nome_modello = substr($nome_marca, 0, 3) . " " . $obj3['Modello'];
        $numero_terminali = $numero_terminali + $obj3['diff_teminali'];
        $risultato[$nome_marca] = $obj3['diff_marca'];
     
        $temp++;
    }
    // print_r($risultato);
    #echo "</tbody></table><br> ";
    return $risultato;
}

function cmTopixel($var) {
    $conv = round ($var*38);
        return $conv;  
    }
?>
