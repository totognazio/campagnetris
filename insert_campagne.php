<?php
include_once './classes/form_class.php';
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';
include_once './classes/access_user/access_user_class.php';
include_once('db_config.php');
require_once './classes/PHPExcel/Classes/PHPExcel.php'; 

// require __DIR__ . '/vendor/autoload.php';
$objPHPExcel = new PHPExcel();
// include('PHPExcel/IOFactory.php');

$page_protect = new Access_user;
$form = new form_class();
$funzione = new funzioni_admin();
$campaign = new campaign_class();
// $page_protect->login_page = "login.php"; // change this only if your login is on another page
$page_protect->access_page(); // only set this this method to protect your page
$page_protect->get_user_info();
$livello_accesso = $page_protect->get_job_role();

$channels = $funzione->get_list_select('channels');
$typlogies = $funzione->get_list_select('campaign_types');
$squads = $funzione->get_list_select('squads');
$states = $funzione->get_list_select('campaign_states');
$sprints = $funzione->get_list_select('sprints');
$user_id = $funzione->get_id('users', $_SESSION['user'], 'login');
$campaign_types = $funzione->get_list_select('campaign_types'); //Tipologias
$campaign_stacks = $funzione->get_list_select('campaign_stacks');
$campaign_categories = $funzione->get_list_select('campaign_categories');
$campaign_modalities = $funzione->get_list_select('campaign_modalities');
$campaign_tipo_app_outbound = $funzione->get_list_select('tipo_app_outbound');

//print_r($squads);
$squad_id_set = $page_protect->get_squads_id_by_user();
$list_squad = $funzione->get_squad_list_name(implode(',',$squad_id_set));
//print_r($list_squad);
//print_r(explode(',',$list_squad));



$query = array();
$check_file = true;

if(isset($_POST['id_upload'])){
    $id_upload = $_POST['id_upload'];
    $file_name = $id_upload.'.xlsm';
    $dir = 'upload/' . $id_upload;
    $filepath = 'upload/' . $id_upload.'/'.$file_name;
    $filepath_newtemplate = 'upload/' . $id_upload.'/new_'.$file_name;
}
else{

    exit('var id_upload doesn\'t exit');
}


$output = '<h3 class="text-success" align="center">Campagne caricate</h3><br /><table class="table table-bordered" ><thead><tr style="background-color: #eee"><th>n°</th><th>nome_campagna</th><th>Stack</th><th>Squad</th><th>Tipologia</th>
<th>Note</th><th>Modalita</th><th>Tipo_Target</th><th>Priorita_PM</th><th>Descrizione_Attivita</th><th>N_Collateral</th><th>TotIdNews</th><th>TipoAppOutbound</th><th>Persado</th>
<th>Stato</th><th>Tipo_Offerta</th><th>Tipo_Contratto</th><th>Consenso</th><th>Mercato</th><th>Altri_Criteri</th><th>Indicatore_Dinamico</th>
<th>Call_Guide</th><th>Control_Group</th><th>Canale</th><th>Tipo</th><th>Testo_SMS</th><th>Data_Inizio</th><th>Data_Fine</th>
<th>Escludi_Sab_Dom</th><th>Durata_Campagna</th><th>Volume_Totale</th><th>Note_Operative</th></tr></thead><tr>';

        $objPHPExcel = PHPExcel_IOFactory::load($filepath);
        
        /*//script per creare un template firmato
        ///set Keywords    
        $objPHPExcel->getProperties()->setCreator("WindTre")
                ->setLastModifiedBy("TH")
                ->setTitle("Office 2007 XLSX Test Document")
                ->setCategory("toolcampaign")
                ->setKeywords("newProtection_STYLE_STOP"); /// Firma

        // Redirect output to a client’s web browser (Excel2007)
        header('Content-Type: application/vnd.ms-excel; charset=UTF-8'); 
        header("Content-type:   application/x-msexcel; charset=utf-8");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private",false);
        header('Content-Disposition: attachment;filename= new_template_import_campagne.xlsx');
        header('Cache-Control: max-age=0');
        $objWriter = PHPExcel_IOFactory::createWriter($objPHPExcel, 'Excel2007');
        $objWriter->save($filepath_newtemplate);
        echo "nuovo file template salvato in $filepath_newtemplate";
        exit;  
        */
        ///////////////////////////////////  
        
            
            $worksheet = $objPHPExcel->getActiveSheet();
            $highestRow = $worksheet->getHighestRow(); 
            $key_security = $objPHPExcel->getProperties()->getKeywords();

            if ($key_security == 'newProtection_STYLE_STOP'){   
                
            }
            else {
                $error = 'Attenzione il file caricato non è un template valido !!! Utilizzare soltanto il template scaricabile da questa pagina.'; 
                echo "<script>alert('$error');</script>"; 
                return;
            }

            $count = 0;
        for ($row = 3; $row < $highestRow; $row++) {                                        
                    
                    $Stack = null;
                    $Stack_raw = $worksheet->getCellByColumnAndRow(0, $row)->getValue(); 
                    $lineplus = $row+1;
                    $linepluss = $row+2;      
                    $lineplusss = $row+3;  
                    //check ultima riga (almeno 3 stack vuoti a seguire)            
                    if(empty($Stack_raw) and empty($worksheet->getCellByColumnAndRow(0, $lineplus)->getValue()) and empty($worksheet->getCellByColumnAndRow(0, $linepluss)->getValue())and empty($worksheet->getCellByColumnAndRow(0, $lineplusss)->getValue())){ // fine file ultima riga                    
                        continue;   
                    }
                    elseif(in_array($Stack_raw, $campaign_stacks)) {
                        $Stack = array_search($Stack_raw, $campaign_stacks);
                        $count ++;
                    } 
                    else {
                        $error = 'Riga '.$row.' Valore del campo "Stack" vuoto o non valido --> '.$Stack_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $campaign_stacks); 
                        echo "<script>alert('$error');</script>"; 
                        return;
                    }
                    $Squad = null;
                    $Squad_raw = $worksheet->getCellByColumnAndRow(1, $row)->getValue();
                    if (in_array($Squad_raw, explode(',',$list_squad))) {
                        $Squad = array_search($Squad_raw, $squads);
                    }else {
                        $error = 'Riga '.$row.' Valore del campo "Squad" vuoto o non di appartenenza --> '.$Squad_raw.' !!!!';                        
                        $error .= '\nValori possibili del campo "Squad" per la tua utenza sono: '.$list_squad; 
                        echo "<script>alert('$error');</script>";                         
                        return;
                    }
                    $Tipologia = null;
                    $Tipologia_raw = $worksheet->getCellByColumnAndRow(2, $row)->getValue();
                    if (in_array($Tipologia_raw, $campaign_types)) {
                        $Tipologia = array_search($Tipologia_raw, $campaign_types);
                    }else {
                        $error = 'Riga '.$row.' Valore del campo "Tipologia" vuoto o non valido --> '.$Tipologia_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $campaign_types); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    $Note = null;
                    $Note = $worksheet->getCellByColumnAndRow(3, $row)->getValue();

                    $Modalita = null;
                    $Modalita_raw = $worksheet->getCellByColumnAndRow(4, $row)->getValue();
                    if (in_array($Modalita_raw, $campaign_modalities)) {
                        $Modalita = array_search($Modalita_raw, $campaign_modalities);
                    }else {
                        $error = 'Riga '.$row.' Valore del campo "Modalità" vuoto o non valido --> '.$Modalita_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $campaign_modalities); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }

                    $Tipo_Target = null;
                    $Tipo_Target_raw = $worksheet->getCellByColumnAndRow(5, $row)->getValue();
                    if (in_array($Tipo_Target_raw, $campaign_categories)) {
                        $Tipo_Target = array_search($Tipo_Target_raw, $campaign_categories);
                    }else {
                        $error = 'Riga '.$row.' Valore del campo "Tipo Target" vuoto o non valido --> '.$Tipo_Target_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $campaign_categories); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }

                    //$Priorita_PM = null;                    
                    $Priorita_PM_raw = $worksheet->getCellByColumnAndRow(6, $row)->getValue();
                    
                    $Priorita_PM_data_validation = ['0', '1', '2', '3', '4', '5', '6', '7', '8', '9'];
                    if (in_array($Priorita_PM_raw, $Priorita_PM_data_validation)) {
                        $Priorita_PM = $Priorita_PM_raw;
                        //echo 'Priorita_PM_data_validation '.$Priorita_PM_raw;
                    }                    
                    elseif(!empty($Priorita_PM_raw) && !(in_array($Priorita_PM_raw, $Priorita_PM_data_validation))) {
                        $error = 'Riga '.$row.' Valore del campo "Priorita PM" non valido --> '.$Priorita_PM_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Priorita_PM_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }                    
                    elseif(empty($Priorita_PM_raw)){
                        $Priorita_PM = 1; //default value
                    }

                    $Descrizione_Attivita = $worksheet->getCellByColumnAndRow(7, $row)->getValue();

                    $N_Collateral = null; 
                    $N_Collateral = $worksheet->getCellByColumnAndRow(8, $row)->getValue();
                    if(empty($N_Collateral)){
                        $N_Collateral = 1;
                    }                
                    elseif(!(is_numeric($N_Collateral) OR ($N_Collateral<0))){
                        $error = 'Riga '.$row.' Valore del campo "N Collateral" non valido --> '.$N_Collateral.' !!!!';
                        $error .= '\nValori possibili del campo sono i numeri interi '; 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                


                    $tot_id_news = $worksheet->getCellByColumnAndRow(9, $row)->getValue();
                    if(empty($tot_id_news)){
                        $tot_id_news = 0;
                    }
                    elseif(!(is_numeric($N_Collateral)) OR ($tot_id_news > 99)){
                        $error = 'Riga '.$row.' Valore del campo "Tot Id News" non valido --> '.$tot_id_news.' !!!!';
                        $error .= '\nValori possibili del campo sono i numeri interi < 99'; 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                                    
                    $tipo_app_outbound_raw = $worksheet->getCellByColumnAndRow(10, $row)->getValue();
                    if(empty($tipo_app_outbound_raw)){
                        $tipo_app_outbound_raw = 'ND'; //Default value
                    }    
                    if (in_array($tipo_app_outbound_raw, $campaign_tipo_app_outbound)) {
                        $tipo_app_outbound = array_search($tipo_app_outbound_raw, $campaign_tipo_app_outbound);
                    }
                    elseif(!empty($tipo_app_outbound_raw) && !(in_array($tipo_app_outbound_raw, $campaign_tipo_app_outbound))) {
                        $error = 'Riga '.$row.' Valore del campo "Tipo App Outbound" non valido --> '.$tipo_app_outbound_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $campaign_tipo_app_outbound); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }

                    $persado_raw = $worksheet->getCellByColumnAndRow(11, $row)->getValue();
                    $persado_validation = ['Y', 'N'];
                    if (in_array($persado_raw, $persado_validation)) {
                        $persado = $persado_raw;
                        //echo 'Priorita_PM_data_validation '.$Priorita_PM_raw;
                    }
                    elseif(!empty($persado_raw) && !(in_array($persado_raw, $persado_validation))) {
                        $error = 'Riga '.$row.' Valore del campo "Priorita PM" non valido --> '.$persado_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $persado_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    elseif(empty($persado_raw)){
                        $persado = 0; //default value
                    }

                    // Tab criteri ///////
                    /////////////////
                    $Stato = null;
                    $Stato_data_validation = ["Attivi"=>"attivi", "Sospesi"=>"sospesi", "Disattivi"=>"disattivi"];
                    $Stato_criteri = ["attivi"=>"0", "sospesi"=>"0", "disattivi"=>"0"];
                    $Stato_raw = $worksheet->getCellByColumnAndRow(12, $row)->getValue();

                    if(count(explode('+', $Stato_raw))>1){
                        $Stato_raw = explode('+', $Stato_raw);                        
                        $intersect_tipo = array_intersect_key(array_values($Stato_raw), array_keys($Stato_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Stato_criteri[$Stato_data_validation[$value]] = "1";
                        }
                        $Stato_raw = implode('+', $Stato_raw);
                    }
                    elseif (in_array($Stato_raw, array_keys($Stato_data_validation))) {                 
                        $Stato_raw_tmp[0] = $worksheet->getCellByColumnAndRow(12, $row)->getValue();                        
                        $intersect_tipo = array_intersect_key(array_values($Stato_raw_tmp), array_keys($Stato_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Stato_criteri[$Stato_data_validation[$value]] = "1";
                        }
                        $Stato_raw = $Stato_raw_tmp[0];
                    }
                    elseif(!empty($Stato_raw) && !(in_array($Stato_raw, array_keys($Stato_data_validation)))) {
                        $error = 'Riga '.$row.' Valore del criterio "Stato" non valido --> '.$Stato_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Stato_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    
                     
                    /*else {
                        $error = 'Riga '.$row.' Valore del criterio "Stato"  vuoto o non valido --> '.$Stato_raw.' !!!!';                        
                        echo "<script>alert('$error');</script>";
                        return;
                    } */

                    $Tipo_Offerta = null;
                    $Tipo_Offerta_data_validation = ["Consumer"=>"consumer", "Business"=>"business", "MicroBusiness"=>"microbusiness"];
                    $Tipo_Offerta_criteri = ["consumer"=>"0", "business"=>"0", "microbusiness"=>"0"];
                    $Tipo_Offerta_raw = $worksheet->getCellByColumnAndRow(13, $row)->getValue();                    
                    
                    if(count(explode('+', $Tipo_Offerta_raw))>1){
                        $Tipo_Offerta_raw = explode('+', $Tipo_Offerta_raw);                        
                        $intersect_tipo = array_intersect_key(array_values($Tipo_Offerta_raw), array_keys($Tipo_Offerta_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Tipo_Offerta_criteri[$Tipo_Offerta_data_validation[$value]] = "1";
                        }
                        $Tipo_Offerta_raw = implode('+', $Tipo_Offerta_raw);
                    }
                    elseif(in_array($Tipo_Offerta_raw, array_keys($Tipo_Offerta_data_validation))) {       
                        $Tipo_Offerta_raw_tmp[0] = $worksheet->getCellByColumnAndRow(13, $row)->getValue();                       
                        $intersect_tipo = array_intersect_key(array_values($Tipo_Offerta_raw_tmp), array_keys($Tipo_Offerta_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Tipo_Offerta_criteri[$Tipo_Offerta_data_validation[$value]] = "1";
                        }
                        $Tipo_Offerta_raw = $Tipo_Offerta_raw_tmp[0];
                    }                    
                    elseif(!empty($Tipo_Offerta_raw) && !(in_array($Tipo_Offerta_raw, array_keys($Tipo_Offerta_data_validation)))) {
                        $error = 'Riga '.$row.' Valore del criterio "Tipo Offerta" non valido --> '.$Tipo_Offerta_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Tipo_Offerta_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    
                    /*else {
                        $error = 'Riga '.$row.' Valore del criterio "Tipo Offerta"  vuoto o non valido --> '.$Tipo_Offerta_raw.' !!!!';                        
                        echo "<script>alert('$error');</script>";
                        return;
                    } */

                    $Tipo_Contratto = null;
                    $Tipo_Contratto_data_validation = ["Prepagato"=>"prepagato", "Postpagato"=>"postpagato", "Pre NoTax"=>"contratto_microbusiness"];
                    $Tipo_Contratto_criteri = ["prepagato"=>"0", "postpagato"=>"0", "contratto_microbusiness"=>"0"];                    
                    $Tipo_Contratto_raw = $worksheet->getCellByColumnAndRow(14, $row)->getValue();

                    if(count(explode('+', $Tipo_Contratto_raw))>1){
                        $Tipo_Contratto_raw = explode('+', $Tipo_Contratto_raw);
                        //echo 'inte ';
                        //print_r($Tipo_Contratto_raw);
                        $intersect_tipo = array_intersect_key(array_values($Tipo_Contratto_raw), array_keys($Tipo_Contratto_data_validation));
                        //echo ' intersect_tipo ';
                        //print_r($intersect_tipo);
                        foreach ($intersect_tipo as $key => $value) {
                            $Tipo_Contratto_criteri[$Tipo_Contratto_data_validation[$value]] = "1";
                        }
                        //echo ' Tipo_Contratto_criteri ';
                        //print_r($Tipo_Contratto_criteri);
                        $Tipo_Contratto_raw = implode('+', $Tipo_Contratto_raw);
                        //return;
                    }
                    elseif (in_array($Tipo_Contratto_raw, array_keys($Tipo_Contratto_data_validation))) {    
                        $Tipo_Contratto_raw_tmp[0] = $worksheet->getCellByColumnAndRow(14, $row)->getValue();                       
                        $intersect_tipo = array_intersect_key(array_values($Tipo_Contratto_raw_tmp), array_keys($Tipo_Contratto_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Tipo_Contratto_criteri[$Tipo_Contratto_data_validation[$value]] = "1";
                        }
                        $Tipo_Contratto_raw = $Tipo_Contratto_raw_tmp[0];
                    }                
                    elseif(!empty($Tipo_Contratto_raw) && !(in_array($Tipo_Contratto_raw, array_keys($Tipo_Contratto_data_validation)))) {
                        $error = 'Riga '.$row.' Valore del criterio "Tipo Contratto" non valido --> '.$Tipo_Contratto_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Tipo_Contratto_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    
                    
                     /*
                    else {
                        $error = 'Riga '.$row.' Valore del criterio "Tipo Contratto"  vuoto o non valido --> '.$Tipo_Contratto_raw.' !!!!';                        
                        echo "<script>alert('$error');</script>";
                        return;
                    } */

                    $Consenso = null;                    
                    $Consenso_data_validation = ["Profilazione"=>"cons_profilazione", "Commerciale"=>"cons_commerciale", "Terze Parti (Wind)"=>"cons_terze_parti", "Geolocalizzazione"=>"cons_geolocalizzazione", "Enrichment"=>"cons_enrichment","Trasferimento dati a terzi (Tre)"=>"cons_trasferimentidati"];
                    $Consenso_criteri = ["cons_profilazione"=>"0", "cons_commerciale"=>"0", "cons_terze_parti"=>"0","cons_geolocalizzazione"=>"0","cons_enrichment"=>"0","cons_trasferimentidati"=>"0"];
                    $Consenso_raw = $worksheet->getCellByColumnAndRow(15, $row)->getValue();                    
                    if(count(explode('+', $Consenso_raw))>1){
                        $Consenso_raw = explode('+', $Consenso_raw);                        
                        $intersect_tipo = array_intersect_key(array_values($Consenso_raw), array_keys($Consenso_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Consenso_criteri[$Consenso_data_validation[$value]] = "1";
                        }
                        $Consenso_raw = implode('+', $Consenso_raw); 
                    }
                    elseif (in_array($Consenso_raw, array_keys($Consenso_data_validation))) {    
                        $Consenso_raw_tmp[0] = $worksheet->getCellByColumnAndRow(15, $row)->getValue();                     
                        $intersect_tipo = array_intersect_key(array_values($Consenso_raw_tmp), array_keys($Consenso_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Consenso_criteri[$Consenso_data_validation[$value]] = "1";
                        }
                        $Consenso_raw = $Consenso_raw_tmp[0];
                    }  
                    elseif(strtoupper($Consenso_raw)=='MULTICONSENSO') {
                        $Consenso_raw = $Consenso_raw;
                    }                  
                    elseif(!empty($Consenso_raw) && !(in_array($Consenso_raw, array_keys($Consenso_data_validation)))) {
                        $error = 'Riga '.$row.' Valore del criterio "Consenso" non valido --> '.$Consenso_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Consenso_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    
                    

                    $Mercato = null;
                    $Mercato_data_validation = ["Mobile Voce"=>"voce", "Mobile Dati"=>"dati", "Fisso"=>"fisso"];
                    $Mercato_criteri = ["voce"=>"0", "dati"=>"0", "fisso"=>"0"];
                    $Mercato_raw = $worksheet->getCellByColumnAndRow(16, $row)->getValue();                    

                    if(count(explode('+', $Mercato_raw))>1){
                        $Mercato_raw = explode('+', $Mercato_raw);                        
                        $intersect_tipo = array_intersect_key(array_values($Mercato_raw), array_keys($Mercato_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Mercato_criteri[$Mercato_data_validation[$value]] = "1";
                        }
                        $Mercato_raw = implode('+', $Mercato_raw); 
                    }
                    elseif (in_array($Mercato_raw, array_keys($Mercato_data_validation))) {  
                        $Mercato_raw_tmp[0] = $worksheet->getCellByColumnAndRow(16, $row)->getValue();                      
                        $intersect_tipo = array_intersect_key(array_values($Mercato_raw_tmp), array_keys($Mercato_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $Mercato_criteri[$Mercato_data_validation[$value]] = "1";
                        }
                        $Mercato_raw = $Mercato_raw_tmp[0];
                    }                
                    elseif(!empty($Mercato_raw) && !(in_array($Mercato_raw, array_keys($Mercato_data_validation)))) {
                        $error = 'Riga '.$row.' Valore del criterio "Mercato" non valido --> '.$Mercato_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Mercato_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                
                    
                    /*
                    else {
                        $error = 'Riga '.$row.' Valore del criterio "Mercato"  vuoto o non valido --> '.$Mercato_raw.' !!!!';                        
                        echo "<script>alert('$error');</script>";
                        return;
                    }
                    */

                    $AltriCriteri1 = null;
                    $AltriCriteri1_data_validation = ["No Frodi"=>"no_frodi", "No Collection"=>"altri_filtri"];
                    $AltriCriteri1_criteri = ["no_frodi"=>"0", "altri_filtri"=>"0"];
                    $AltriCriteri1_raw = $worksheet->getCellByColumnAndRow(17, $row)->getValue();                    

                    if(count(explode('+', $AltriCriteri1_raw))>1){
                        $AltriCriteri1_raw = explode('+', $AltriCriteri1_raw);                        
                        $intersect_tipo = array_intersect_key(array_values($AltriCriteri1_raw), array_keys($AltriCriteri1_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $AltriCriteri1_criteri[$AltriCriteri1_data_validation[$value]] = "1";
                        }
                        $AltriCriteri1_raw = implode('+', $AltriCriteri1_raw); 
                    }
                    elseif (in_array($AltriCriteri1_raw, array_keys($AltriCriteri1_data_validation))) {  
                        $AltriCriteri1_raw_tmp[0] = $worksheet->getCellByColumnAndRow(17, $row)->getValue();                       
                        $intersect_tipo = array_intersect_key(array_values($AltriCriteri1_raw_tmp), array_keys($AltriCriteri1_data_validation));                        
                        foreach ($intersect_tipo as $key => $value) {
                            $AltriCriteri1_criteri[$AltriCriteri1_data_validation[$value]] = "1";
                        }
                        $AltriCriteri1_raw = $AltriCriteri1_raw_tmp[0];
                    }                    
                    elseif(!empty($AltriCriteri1_raw) && !(in_array($AltriCriteri1_raw, array_keys($AltriCriteri1_data_validation)))) {
                        $error = 'Riga '.$row.' Valore del criterio "Altri Criteri" non valido --> '.$AltriCriteri1_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $AltriCriteri1_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    
                    

                    $Altri_Criteri = $worksheet->getCellByColumnAndRow(18, $row)->getValue();
  
                    
                    $Indicatore_Dinamico_raw = $worksheet->getCellByColumnAndRow(19, $row)->getValue();
                    $Indicatore_Dinamico_data_validation = [0 => "No", 1 => "Si"];
                    if (in_array($Indicatore_Dinamico_raw, $Indicatore_Dinamico_data_validation)) {                        
                        $Indicatore_Dinamico = array_search($Indicatore_Dinamico_raw, $Indicatore_Dinamico_data_validation);
                    }elseif(empty($Indicatore_Dinamico_raw)) {
                        $Indicatore_Dinamico = 0;
                        $Indicatore_Dinamico_raw = "No";
                    }
                    elseif(!empty($Indicatore_Dinamico_raw) && !(in_array($Indicatore_Dinamico_raw, $Indicatore_Dinamico_data_validation))) {
                        $error = 'Riga '.$row.' Valore del criterio "Indicatore Dinamico" non valido --> '.$Indicatore_Dinamico_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Indicatore_Dinamico_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }

                    
                    $Call_Guide_raw = $worksheet->getCellByColumnAndRow(20, $row)->getValue();
                    $Call_Guide_data_validation = [0 => "No", 1 => "Si"];
                    if (in_array($Call_Guide_raw, $Call_Guide_data_validation)) {                        
                        $Call_Guide = array_search($Call_Guide_raw, $Call_Guide_data_validation);
                    }elseif(empty($Call_Guide_raw)) {
                        $Call_Guide = 0;
                        $Call_Guide_raw = "No";
                    } 
                    elseif(!empty($Call_Guide_raw) && !(in_array($Call_Guide_raw, $Call_Guide_data_validation))) {
                        $error = 'Riga '.$row.' Valore del criterio "Call Guide" non valido --> '.$Call_Guide_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Call_Guide_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    } 

                    
                    $Control_Group_raw = $worksheet->getCellByColumnAndRow(21, $row)->getValue();
                    $Control_Group_data_validation = [0 => "No", 1 => "Si (Percentuale)", 2 => "Si (Volume)"];
                    if (in_array($Control_Group_raw, $Control_Group_data_validation)) {
                        $Control_Group = array_search($Control_Group_raw, $Control_Group_data_validation);
                    }elseif(empty($Control_Group_raw)) {
                        $Control_Group = 0;
                        $Control_Group_raw = "No";
                    }
                    elseif(!empty($Control_Group_raw) && !(in_array($Control_Group_raw, $Control_Group_data_validation))) {
                        $error = 'Riga '.$row.' Valore del criterio "Call Group" non valido --> '.$Control_Group_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Control_Group_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }   

                    $Canale = null;                    
                    $Canale_raw = $worksheet->getCellByColumnAndRow(22, $row)->getValue();
                    if (in_array($Canale_raw, $channels)) {
                        $Canale = array_search($Canale_raw, $channels);
                    }
                    elseif(strtoupper($Canale_raw)=='MULTICANALE') {
                        $Canale = 'multicanale';
                    }
                    elseif(empty($Canale_raw)) {                        
                        $error = 'Riga '.$row.' il campo "Canale" non può essere vuoto!!!!\n';
                        $error .= 'Valori possibili del campo "Canale" sono:\n'.implode(' ', $channels); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    } 
                    else {                        
                        $error = 'Riga '.$row.' valore del campo "Canale" non valido --> '.$Canale_raw.' !!!!\n';
                        $error .= ' Valori possibili del campo sono:\n'.implode(' ', $channels); 
                        echo "<script>alert('$error');</script>";                        
                        return;
                    }

                    $Tipo = null;
                    $Tipo_raw = $worksheet->getCellByColumnAndRow(23, $row)->getValue();                
                    $Tipo_data_validation = ["info"=>"Informativa", "mono"=>"MonoOfferta", "multi"=>"Multiofferta"];
                    if (in_array($Tipo_raw, $Tipo_data_validation)) {                        
                        $Tipo = array_search($Tipo_raw,$Tipo_data_validation);
                    }
                    elseif(empty($Tipo_raw)) {                        
                        $error = 'Riga '.$row.' il campo "Tipo" non può essere vuoto!!!!';                      
                        echo "<script>alert('$error');</script>";                        
                        return;
                    }                    
                    else {                        
                        $error = 'Riga '.$row.' valore del campo "Tipo" non valido --> '.$Tipo_raw.' !!!!';
                        echo "<script>alert('$error');</script>";                        
                        return;
                    }
                    
                    //// solo nel caso di MonoOfferta
                    $CodiceRopz = '';
                    $CodiceOpz = '';
                    if ($Tipo_raw=="MonoOfferta") {
                        $CodiceRopz = $worksheet->getCellByColumnAndRow(24, $row)->getValue();
                        $CodiceOpz = $worksheet->getCellByColumnAndRow(25, $row)->getValue();
                    }

                    $Testo_SMS = $worksheet->getCellByColumnAndRow(26, $row)->getValue();
                    if($Canale==12 and empty($Testo_SMS)){
                        $error = 'Riga '.$row.' valore del campo "Testo SMS" vuoto!!!\nObbligatorio inserire un "Testo SMS" con canale tipo "SMS"';
                        echo "<script>alert('$error');</script>";                        
                        return;
                    }
                    // echo $Testo_SMS . '<br/>';

                    $Data_Inizio = $worksheet->getCellByColumnAndRow(27, $row)->getValue();
                    if(empty($Data_Inizio)) {                        
                        $error = 'Riga '.$row.' il campo "Data Inizio" non può essere vuoto!!!!';  
                        echo "<script>alert('$error');</script>";                      
                        return;
                    } 
                    $Data_Inizio = ($Data_Inizio - 25569) * 86400;
                    $Data_Inizio = date("Y-m-d", $Data_Inizio);
                    $Data_Inizio_year = new DateTime($Data_Inizio);
                    $Data_Inizio_year = $Data_Inizio_year->format('Ymd');
                    // print_r($Data_Inizio_year);
                    //print_r($Data_Inizio);

                    $Data_end = $worksheet->getCellByColumnAndRow(28, $row)->getValue();
                    $Data_Fine = ($Data_end - 25569) * 86400;
                    $Data_Fine = date("Y-m-d", $Data_Fine);  //Sarebbe data_fine_validita_offerta

                    if(empty($Data_end)) {                        
                        $error = 'Riga '.$row.' il campo "Data Fine" non può essere vuoto!!!!';   
                        echo "<script>alert('$error');</script>";                     
                        return;
                    } 
                    elseif((strtotime($Data_Fine) - strtotime($Data_Inizio))<0){
                        $error = 'Riga '.$row.' il campo "Data Fine" non può essere precedente a "Data inizio" !!!!\nData Fine '. $Data_Fine.' - Data Fine '.$Data_Inizio;
                        echo "<script>alert('$error');</script>";                      
                        return;
                   }


                    //echo $Data_Fine . '<br/>';
                    //print_r($Data_Fine);

                    $Escludi_Sab_Dom = null;
                    $Escludi_Sab_Dom_raw = $worksheet->getCellByColumnAndRow(29, $row)->getValue();
                    $Escludi_Sab_Dom_data_validation = [0 => "No", 1 => "Sabato", 2 => "Domenica", 3 => "Sabato & Domenica"];
                    if (in_array($Escludi_Sab_Dom_raw, $Escludi_Sab_Dom_data_validation)) {
                        $Escludi_Sab_Dom = array_search($Escludi_Sab_Dom_raw, $Escludi_Sab_Dom_data_validation);
                    
                    } elseif(empty($Escludi_Sab_Dom_raw)) {                        
                        $Escludi_Sab_Dom = 0;
                        $Escludi_Sab_Dom_raw = "No";
                        //$error ='Riga '.$row.' il campo "Escludi Sab/Dom" non può essere vuoto!!!!';                                      
                        //echo "<script>alert('$error');</script>";                   
                        //return;
                    }
                    elseif(!empty($Escludi_Sab_Dom_raw) && !(in_array($Escludi_Sab_Dom_raw, $Escludi_Sab_Dom_data_validation))) {
                        $error = 'Riga '.$row.' Valore del caampo "Escludi Sab/Dom" non valido --> '.$Escludi_Sab_Dom_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Escludi_Sab_Dom_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }

                    $Durata_Campagna = null;
                    $Durata_Campagna_raw = $worksheet->getCellByColumnAndRow(30, $row)->getValue();
                    // echo $Durata_Campagna_raw . '<br/>';
                    $Durata_Campagna_data_validation = [1 => "1 giorno", 2 => "2 giorni", 3 => "3 giorni", 4 => "4 giorni", 5 => "5 giorni", 6 => "6 giorni", 7 => "7 giorni"];
                    if (in_array($Durata_Campagna_raw, $Durata_Campagna_data_validation)) {
                        $Durata_Campagna = array_search($Durata_Campagna_raw, $Durata_Campagna_data_validation);
                    } elseif(empty($Durata_Campagna_raw)) {                        
                        $Durata_Campagna = 1;
                        $Durata_Campagna_raw = "1 giorno";
                        //$error = 'Riga '.$row.' il campo "Durata Campagna" non può essere vuoto!!!!';   
                        //echo "<script>alert('$error');</script>";                
                        //return;
                    }
                    elseif(!empty($Durata_Campagna_raw) && !(in_array($Durata_Campagna_raw, $Durata_Campagna_data_validation))) {
                        $error = 'Riga '.$row.' Valore del caampo "Durata Campagna" non valido --> '.$Durata_Campagna_raw.' !!!!';
                        $error .= '\nValori possibili del campo sono: '.implode(', ', $Durata_Campagna_data_validation); 
                        echo "<script>alert('$error');</script>";  
                        return;
                    }


                    $Volume_Totale = $worksheet->getCellByColumnAndRow(31, $row)->getValue();
                    if(empty($Volume_Totale)) {                        
                        //$Volume_Totale = 0;
                        $error = 'Riga '.$row.' il campo "Volume Toale" non può essere vuoto!!!!';     
                        echo "<script>alert('$error');</script>";                  
                        return;
                    }
                    /*
                    elseif(!(is_integer($Volume_Totale))) {
                        $error = 'Riga '.$row.' Valore del caampo "Volume Totale" non valido --> '.$Volume_Totale.' !!!!';
                        echo "<script>alert('$error');</script>";  
                        return;
                    }
                    */
                    // echo $Volume_Totale . '<br/>';
                    // print_r($Volume_Totale);

                    $Note_Operative = $worksheet->getCellByColumnAndRow(32, $row)->getValue();
                    // echo $Note_Operative . '<br/>';

                    // (5,
                    // $id = 5; // done auto increment
                    //  '0',

                    $squad_label = $funzione->get_squad_label($Squad);
                    if($Canale=='multicanale'){
                        $channel_label = 'MULTICHTBD'; 
                        $Canale = 0;
                    }
                    else{
                        $channel_label = $funzione->get_channel_label($Canale);
                    }
                    
                    $type_label = $funzione->get_type_label($Tipologia);

                    $nome_campagna = $Data_Inizio_year . '_' . $squad_label . '_' . $channel_label.'_' . $type_label; // done
                    if(!empty($Note)){
                        $nome_campagna .= '_'.$Note;
                    }

                    //data_label + squad_label + channel_label + type_label + note_label;
                    //'20210412_SQC_APO_INA_Deact_Aprile_Prova',
                    $pref_nome_campagna = $nome_campagna; //**** */
                    //  '',
                    $cod_comunicazione = ''; // Done Null-Yes
                    //  '', 
                    $cod_campagna = ''; // Done Null-Yes
                    // 4,
                    $stack_id = $Stack; // Done
                    //  20,
                    $type_id = $Tipologia;
                    // 21,
                    $squad_id = $Squad; // Done
                    //  104,
                    $user_id = $user_id; // Done
                    //  0,
                    $segment_id = 0; // Done Null-Yes
                    //  '0', 
                    $optimization = '0'; //Done Null-Yes
                    // 1, 
                    $priority = $Priorita_PM; //Done 
                    // '0000-00-00',
                    $data_inizio_validita_offerta = '0000-00-00'; // $Data_Inizio
                    //  '2021-04-20',
                    $data_fine_validita_offerta = $Data_Fine; //$Data_Fine Done
                    //  0, 
                    $leva = 0; // Done Null-Yes
                    // '0',
                    $descrizione_leva = '0'; // Done Null-Yes
                    //  6, 
                    $campaign_state_id = 2; // Stato Is default 'RICHIESTA'
                    // '0', 
                    $lista_preview = '0'; // Done Null-Yes
                    // '0',
                    $lista_civetta = '0'; // Done Null-Yes
                    //  '0', 
                    $control_group = $Control_Group; // Done Null-Yes
                    // '0', 
                    $perc_control_group = '0'; // Done Null-Yes
                    // 16, 
                    $channel_id = $Canale; // Done Null-Yes
                    // '',
                    $channel_type = ''; // Drop this
                    //  '',
                    $mod_invio = '0'; // Done Null-Yes
                    //  NULL, 
                    $sender_id = 0; // Done Null-Yes
                    // '0', 
                    $storic = '0'; // Done Null-Yes
                    // '0', 
                    $testo_sms = $funzione->mysqli->real_escape_string($Testo_SMS); // Done Null-Yes
                    // '0', 
                    $link = '0'; // Done Null-Yes
                    // 0,
                    $sms_duration = 0; // Done Null-Yes
                    //  0, 
                    $tipoMonitoring = 0;
                    // '2021-04-12', 
                    $data_inizio = $Data_Inizio; // Done Null-Yes

                    // '2021-04-12',
                    //$data_fine = date("Y-m-d", strtotime($Data_Inizio . '+ '.$Durata_Campagna.'days'));
                    $data_fine = $campaign->calcola_data_fine($Data_Inizio, $Durata_Campagna, $Escludi_Sab_Dom);

                    // '0',
                    $escludi_sab_dom = $Escludi_Sab_Dom;
                    // 1, 
                    $durata_campagna = $Durata_Campagna; // Done Null-Yes
        
        //inizializzo a zero            
        for ($i = 0; $i < 7; $i++) {    
            $volday[$i] = 0;
        }  
        //ripartizione volumi
        for ($i = 0; $i < $durata_campagna; $i++) {    

            $volday[$i] = floor($Volume_Totale / $durata_campagna);
 
        }
                            // 100000,
                    $volumeGiornaliero1 = $volday[0];
                    // 0, 
                    $volumeGiornaliero2 = $volday[1];
                    // 0,
                    $volumeGiornaliero3 = $volday[2];
                    // 0, 
                    $volumeGiornaliero4 = $volday[3];
                    // 0, 
                    $volumeGiornaliero5 = $volday[4];
                    // 0,
                    $volumeGiornaliero6 = $volday[5];
                    // 0,
                    $volumeGiornaliero7 = $volday[6];

                    // '0', 
                    $trial_campagna = '0';
                    // '0000-00-00',
                    $data_trial = '0000-00-00'; // Done Null-Yes
                    // 0,
                    $volume_trial = 0; // Done Null-Yes
                    // '0', 
                    $perc_scostamento = '0'; // Done Null-Yes
                    // 100000,
                    $volume = $Volume_Totale; // Done Null-Yes
                    // '0', 
                    $attivi = $Stato_criteri['attivi']; 
                    // '0', 
                    $sospesi = $Stato_criteri['sospesi']; 
                    // '0', 
                    $disattivi = $Stato_criteri['disattivi']; 
                    // '0', 
                    $consumer = $Tipo_Offerta_criteri['consumer'];
                    // '0',
                    $business = $Tipo_Offerta_criteri['business'];
                    // '0', 
                    $microbusiness = $Tipo_Offerta_criteri['microbusiness'];
                    // '0', 
                    $prepagato = $Tipo_Contratto_criteri['prepagato']; // Done Null-Yes
                    // '0', 
                    $postpagato = $Tipo_Contratto_criteri['postpagato'];
                    // '0', 
                    $contratto_microbusiness = $Tipo_Contratto_criteri['contratto_microbusiness'];
                    // '0', 
                    $cons_profilazione = $Consenso_criteri["cons_profilazione"];
                    // '0',
                    $cons_commerciale = $Consenso_criteri["cons_commerciale"];
                    // '0',
                    $cons_terze_parti = $Consenso_criteri["cons_terze_parti"];
                    // '0',
                    $cons_geolocalizzazione = $Consenso_criteri["cons_geolocalizzazione"];
                    // '0', 
                    $cons_enrichment = $Consenso_criteri["cons_enrichment"];
                    // '0', 
                    $cons_trasferimentidati = $Consenso_criteri["cons_trasferimentidati"];
                    // '0',
                    $voce = $Mercato_criteri["voce"];
                    // '0',
                    $dati = $Mercato_criteri["dati"];
                    // '0', 
                    $fisso = $Mercato_criteri["fisso"];
                    // '0'
                    $no_frodi = $AltriCriteri1_criteri["no_frodi"];
                    // '0', 
                    $altri_filtri = $AltriCriteri1_criteri["altri_filtri"];
                    // '0', 
                    $etf = '0'; // Done Null-Yes
                    // '0', 
                    $vip = '0'; // Done Null-Yes
                    // '0', 
                    $dipendenti = '0'; // Done Null-Yes
                    // '0',
                    $trial = '0'; // Done Null-Yes
                    // 0, 
                    $parlanti_ultimo = 0; // Done Null-Yes
                    // '0', 
                    $profilo_rischio_ga = '0'; // Done Null-Yes
                    // '0', 
                    $profilo_rischio_standard = '0'; // Done Null-Yes
                    // '0', 
                    $profilo_rischio_high_risk = '0'; // Done Null-Yes
                    // NULL, 
                    $altri_criteri = $funzione->mysqli->real_escape_string($Altri_Criteri); // Done Null-Yes
                    // '2021-04-20 15:39:29',
                    $data_inserimento = date("Y-m-d H:i:s");
                    //  NULL, 
                    $redemption = ''; // Done Null-Yes
                    // 0,
                    $storicizza = 0; //Done no need
                    // 0, 
                    $offer_id = 0; // Done no need
                    // 1, 
                    $modality_id = $Modalita;
                    // 1, 
                    $category_id = $Tipo_Target;
                    // 0, 
                    $tit_sott_id = 0; // Done no need
                    // '',
                    $descrizione_target = $funzione->mysqli->real_escape_string($Descrizione_Attivita); 
                    // '0', 
                    $leva_offerta = '0'; // Done Null-Yes
                    // '0', 
                    $descrizione_offerta = '0'; // Done no need
                    // '0',
                    $indicatore_dinamico = $Indicatore_Dinamico;
                    // 'mono',
                    $tipo_leva = $Tipo; // Done Null-Yes
                    // NULL,
                    $cod_ropz = $CodiceRopz; // Done Null-Yes
                    // NULL,
                    $cod_opz = $CodiceOpz; // Done Null-Yes
                    // '0', 
                    $id_news = '0'; // Done Null-Yes
                    // NULL, 
                    $note_operative = $funzione->mysqli->real_escape_string($Note_Operative); 
                    // 0, 
                    $cat_sott_id = 0;
                    // 'Deact_Aprile_Prova', 
                    $note_camp = $Note; // Done Null-Yes
                    // '0', 
                    $alias_attiv = '0'; //Done no need
                    // 0, 
                    $day_val = 0; //Done no need
                    // '0', 
                    $sms_incarico = '0'; //Done no need
                    // '0',
                    $sms_target = '0'; //Done no need
                    // '0', 
                    $sms_adesione = '0'; //Done no need
                    // '0', 
                    $sms_nondisponibile = '0';
                    // '0', 
                    $control_guide =$Call_Guide;
                    // 0,
                    $numeric_control_group = 0;
                    // 3),
                    $n_collateral = $N_Collateral;
                    
                    
                    //  {"0":{"channel_id":"15","sender_id":"","storicizza":"0","notif_consegna":"0","testo_sms":"","charTesto":"","numero_sms":"0","mod_invio":"Standard","link":"","charLink":"255","numero_totale":"","tit_sott_pos":"","cat_sott_id":"","day_val_pos":"","callguide_pos":"","testo_sms_pos":"","charTesto_pos":"","numero_sms_pos":"0","alias_attiv":"","day_val":"","sms_incarico":"","sms_target":"","sms_adesione":"","sms_nondisponibile":"","id_news_app_inbound":"","day_val_app_inbound":"","prior_app_inbound":"0","callguide_app_inbound":"","id_news_app_outbound":"","day_val_app_outbound":"","notif_app_outbound":"0","prior_app_outbound":"0","callguide_app_outbound":"","count_iniziative_dealer":"1","Cod_iniziativa":"","Cod_iniziativa2":"","Cod_iniziativa3":"","Cod_iniziativa4":"","Cod_iniziativa5":"","Cod_iniziativa6":"","Cod_iniziativa7":"","Cod_iniziativa8":"","Cod_iniziativa9":"","day_val_icm":"","callguide_icm":"","day_val_ivr_inbound":"","day_val_ivr_outbound":"","data_invio_jakala":"24\/01\/2022","data_invio_spai":"24\/01\/2022","type_mfh":"","note_mfh":"","type_watson":"","contact_watson":"","funnel":""}}
                    //  {"0":{"channel_id":"12","sender_id":"","storicizza":"0","notif_consegna":"0","testo_sms":"ewewrewrer","charTesto":"10","numero_sms":"1","mod_invio":"Standard","link":"","charLink":"255","numero_totale":"10","tit_sott_pos":"","cat_sott_id":"","day_val_pos":"","callguide_pos":"","testo_sms_pos":"","charTesto_pos":"","numero_sms_pos":"0","alias_attiv":"","day_val":"","sms_incarico":"","sms_target":"","sms_adesione":"","sms_nondisponibile":"","id_news_app_inbound":"","day_val_app_inbound":"","prior_app_inbound":"0","callguide_app_inbound":"","id_news_app_outbound":"","day_val_app_outbound":"","notif_app_outbound":"0","prior_app_outbound":"0","callguide_app_outbound":"","count_iniziative_dealer":"1","Cod_iniziativa":"","Cod_iniziativa2":"","Cod_iniziativa3":"","Cod_iniziativa4":"","Cod_iniziativa5":"","Cod_iniziativa6":"","Cod_iniziativa7":"","Cod_iniziativa8":"","Cod_iniziativa9":"","day_val_icm":"","callguide_icm":"","day_val_ivr_inbound":"","day_val_ivr_outbound":"","data_invio_jakala":"24\/01\/2022","data_invio_spai":"24\/01\/2022","type_mfh":"","note_mfh":"","type_watson":"","contact_watson":"","funnel":""}}
                    
                    
                    
                    
                    /*
                    $addcanale_array_data = array(
                        'channel_id' => $channel_id, 'sender_id' => $sender_id, 'storicizza' => $storicizza,
                        'storicizza' => $storicizza, 'testo_sms' => $testo_sms,
                        'mod_invio' => $mod_invio, 'link' => $link,
                        'cat_sott_id' => $cat_sott_id, 'day_val' => $day_val,
                        'alias_attiv' => $alias_attiv, 'day_val' => $day_val, 'sms_incarico' => $sms_incarico,
                        'sms_target' => $sms_target, 'sms_adesione' => $sms_adesione, 'sms_nondisponibile' => $sms_nondisponibile,
                    );
                    $addcanale_json = json_encode(array('0' => $addcanale_array_data), JSON_FORCE_OBJECT);
                    // print_r($addcanale_json);
                    */

                    //sms length  check
                    $length_sms = strlen($testo_sms);       
                    $num_sms = 0;     
                    if ($length_sms<=160 && $length_sms>0) {
                        $num_sms = 1;
                    }    
                    elseif( ($length_sms > 160 ) &&(  $length_sms<= 268 )){
                            $num_sms = 2;
                    }
                    elseif( ($length_sms > 268 )&&($length_sms <= 402 )){
                        $num_sms = 3;
                    }
                    elseif( ($length_sms > 402 )&&($length_sms <= 536 )){
                        $num_sms = 4;
                    }
                    else {
                        $num_sms = floor(($length_sms ) / 133) + 1;
                    }

                    $addcanale = '{"0":{"channel_id":"'.$channel_id.'","sender_id":"","storicizza":"0","notif_consegna":"0","testo_sms":"'.$testo_sms.'","charTesto":"'.$length_sms.'","numero_sms":"'.$num_sms.'","mod_invio":"Standard","link":"","charLink":"255","numero_totale":"10","tit_sott_pos":"","cat_sott_id":"","day_val_pos":"","callguide_pos":"","testo_sms_pos":"","charTesto_pos":"","numero_sms_pos":"0","alias_attiv":"","day_val":"","sms_incarico":"","sms_target":"","sms_adesione":"","sms_nondisponibile":"","id_news_app_inbound":"","day_val_app_inbound":"","prior_app_inbound":"0","callguide_app_inbound":"","id_news_app_outbound":"","day_val_app_outbound":"","notif_app_outbound":"0","prior_app_outbound":"0","callguide_app_outbound":"","count_iniziative_dealer":"1","Cod_iniziativa":"","Cod_iniziativa2":"","Cod_iniziativa3":"","Cod_iniziativa4":"","Cod_iniziativa5":"","Cod_iniziativa6":"","Cod_iniziativa7":"","Cod_iniziativa8":"","Cod_iniziativa9":"","day_val_icm":"","callguide_icm":"","day_val_ivr_inbound":"","day_val_ivr_outbound":"","data_invio_jakala":"24\/01\/2022","data_invio_spai":"24\/01\/2022","type_mfh":"","note_mfh":"","type_watson":"","contact_watson":"","funnel":""}}';

                    $query[$count] = "INSERT INTO campaigns(nome_campagna, pref_nome_campagna, cod_comunicazione, 
                    cod_campagna, stack_id, type_id, squad_id, user_id, segment_id, optimization, 
                    priority, data_inizio_validita_offerta, data_fine_validita_offerta, leva, 
                    descrizione_leva, campaign_state_id, lista_preview, lista_civetta, control_group,
                    perc_control_group, channel_id, channel_type, mod_invio, sender_id, storic, 
                    testo_sms, link, sms_duration, tipoMonitoring, data_inizio, volumeGiornaliero1, 
                    volumeGiornaliero2,volumeGiornaliero3, volumeGiornaliero4, volumeGiornaliero5, 
                    volumeGiornaliero6, volumeGiornaliero7, data_fine, escludi_sab_dom, durata_campagna, 
                    trial_campagna, data_trial, volume_trial, perc_scostamento, volume, attivi,
                    sospesi, disattivi, consumer, business, microbusiness, prepagato, 
                    postpagato, contratto_microbusiness, cons_profilazione, cons_commerciale, 
                    cons_terze_parti,cons_geolocalizzazione, cons_enrichment, cons_trasferimentidati, 
                    voce, dati, fisso, no_frodi, altri_filtri, etf, vip, dipendenti, trial, 
                    parlanti_ultimo, profilo_rischio_ga, profilo_rischio_standard, profilo_rischio_high_risk,
                    altri_criteri, data_inserimento, redemption, storicizza, offer_id, modality_id,
                    category_id, tit_sott_id, descrizione_target, leva_offerta, descrizione_offerta,
                    indicatore_dinamico, tipo_leva, cod_ropz, cod_opz, id_news, note_operative,
                    cat_sott_id, addcanale, note_camp, alias_attiv, day_val, sms_incarico, 
                    sms_target, sms_adesione, sms_nondisponibile, control_guide, 
                    numeric_control_group, n_collateral,tot_id_news,tipo_app_outbound,persado) VALUES('" . $nome_campagna . "','" . $pref_nome_campagna . "','" .
                        $cod_comunicazione . "','" . $cod_campagna . "'," . $stack_id . "," . $type_id . "," . $squad_id . "," .
                        $user_id . "," . $segment_id . ",'" . $optimization . "'," . $priority . ",'" . $data_inizio_validita_offerta . "','" .
                        $data_fine_validita_offerta . "'," . $leva . ",'" . $descrizione_leva . "'," . $campaign_state_id . ",'" .
                        $lista_preview . "','" . $lista_civetta . "','" . $control_group . "','" . $perc_control_group . "'," . $channel_id . ",'" .
                        $channel_type . "','" . $mod_invio . "'," . $sender_id . ",'" . $storic . "','" . $testo_sms . "','" . $link . "'," .
                        $sms_duration . "," . $tipoMonitoring . ",'" . $data_inizio . "'," . $volumeGiornaliero1 . "," .
                        $volumeGiornaliero2 . "," . $volumeGiornaliero3 . "," . $volumeGiornaliero4 . "," . $volumeGiornaliero5 . "," .
                        $volumeGiornaliero6 . "," . $volumeGiornaliero7 . ",'" . $data_fine . "','" . $escludi_sab_dom . "'," . $durata_campagna . ",'" .
                        $trial_campagna . "','" . $data_trial . "'," . $volume_trial . ",'" . $perc_scostamento . "'," . $volume . ",'" . $attivi . "','" .
                        $sospesi . "','" . $disattivi . "','" . $consumer . "','" . $business . "','" . $microbusiness . "','" . $prepagato . "','" .
                        $postpagato . "','" . $contratto_microbusiness . "','" . $cons_profilazione . "','" . $cons_commerciale . "','" .
                        $cons_terze_parti . "','" . $cons_geolocalizzazione . "','" . $cons_enrichment . "','" . $cons_trasferimentidati . "','" .
                        $voce . "','" . $dati . "','" . $fisso . "','" . $no_frodi . "','" . $altri_filtri . "','" . $etf . "','" .
                        $vip . "','" . $dipendenti . "','" . $trial . "'," . $parlanti_ultimo . ",'" . $profilo_rischio_ga . "','" .
                        $profilo_rischio_standard . "','" . $profilo_rischio_high_risk . "','" . $altri_criteri . "','" .
                        $data_inserimento . "','" . $redemption . "'," . $storicizza . "," . $offer_id . "," . $modality_id . "," .
                        $category_id . "," . $tit_sott_id . ",'" . $descrizione_target . "','" . $leva_offerta . "','" . $descrizione_offerta . "','" .
                        $indicatore_dinamico . "','" . $tipo_leva . "','" . $cod_ropz . "','" . $cod_opz . "','" . $id_news . "','" . $note_operative . "'," .
                        $cat_sott_id . ",'" . $addcanale . "','" . $note_camp . "','" . $alias_attiv . "','" . $day_val . "','" . $sms_incarico . "','" .
                        $sms_target . "','" . $sms_adesione . "','" . $sms_nondisponibile . "','" . $control_guide . "'," .
                        $numeric_control_group . "," . $n_collateral . ",".$tot_id_news.",'".$tipo_app_outbound."','".$persado."')";


                    $output .= '<td>' . $count . '</td>';
                    //$output .= '<td>' . $nome_campagna . '</td>';
                    $output .= '<td>' . $pref_nome_campagna . '</td>';
                    $output .= '<td>' . $Stack_raw . '</td>';
                    $output .= '<td>' . $Squad_raw . '</td>';
                    $output .= '<td>' . $Tipologia_raw . '</td>';
                    $output .= '<td>' . $Note . '</td>';
                    $output .= '<td>' . $Modalita_raw . '</td>';
                    $output .= '<td>' . $Tipo_Target_raw . '</td>';
                    $output .= '<td>' . $Priorita_PM . '</td>';
                    $output .= '<td>' . $Descrizione_Attivita . '</td>';
                    $output .= '<td>' . $N_Collateral . '</td>';

                    $output .= '<td>' . $tot_id_news . '</td>';
                    $output .= '<td>' . $tipo_app_outbound_raw . '</td>';
                    $output .= '<td>' . $persado_raw . '</td>';
                    $output .= '<td>' . $Stato_raw . '</td>';
                    $output .= '<td>' . $Tipo_Offerta_raw . '</td>';
                    $output .= '<td>' . $Tipo_Contratto_raw . '</td>';
                    $output .= '<td>' . $Consenso_raw . '</td>';
                    $output .= '<td>' . $Mercato_raw . '</td>';
                    $output .= '<td>' . $Altri_Criteri . '</td>';
                    $output .= '<td>' . $Indicatore_Dinamico_raw . '</td>';
                    $output .= '<td>' . $Call_Guide_raw . '</td>';
                    $output .= '<td>' . $Control_Group_raw . '</td>';
                    $output .= '<td>' . $Canale_raw . '</td>';
                    $output .= '<td>' . $Tipo_raw . '</td>';
                    $output .= '<td>' . $Testo_SMS . '</td>';
                    $output .= '<td>' . $Data_Inizio . '</td>';
                    $output .= '<td>' . $Data_Fine . '</td>';
                    $output .= '<td>' . $Escludi_Sab_Dom_raw . '</td>';
                    $output .= '<td>' . $Durata_Campagna_raw . '</td>';
                    $output .= '<td>' . $Volume_Totale . '</td>';
                    $output .= '<td>' . $Note_Operative . '</td>';
                    $output .= '</tr>';
                    // print_r($output);

                    // mysqli_query($conn, $query);

                //}
            }
$output .= '</table>';

        if($check_file){
                for ($i = 1; $i <= $count; $i++) {   
                   // import data into database
                   //echo 'queryyyyyy '.$query[$i].'<br>';
                    $funzione->mysqli->query($query[$i]) or die($query[$i] . " - " . $funzione->mysqli->error);                    
                }  
                
                

        }    



        



//unlink($filepath); 
//rmdir($dir);
echo $output;
echo" Inserite $count  nuove Campagne"; 

