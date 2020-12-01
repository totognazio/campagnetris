<?php
/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of UeCapabilities
 *
 * @author Ezio Toto <ezio.toto at totodomus.ddns.net>
 */
class UeCapabilities extends socmanager {

    //put your code here
    
    //Get from array json_capabilities Table 
    function get_chipset($rowcap){
        $capabilities = json_decode($rowcap[0]['json'],TRUE);
        return $capabilities['chipset'];       
    }
   
    function print_capability($rowcap, $count) {
        //$count = strval($varcount);
        //$rowcap = $this->get_capabilities($id_project);
        //print_r($rowcap[0]);
        //print_r($rowcap[0]['json']);
        $capability = json_decode($rowcap['json'],TRUE);
        //print_r($capability);
        //$capability1 = json_decode($rowcap[1]['json'],TRUE);
        //$capability2 = json_decode($rowcap[2]['json'],TRUE);
        //$capability3 = json_decode($rowcap[3]['json'],TRUE);
                //echo'eccolo';
        //print_r($combination);

        //print_r($capability[0]['feature']);
        //print_r($capability1[0]['feature']);
        //print_r($capability2[0]['feature']);
        //print_r($capability3[0]['feature']);
        
        
        
        $user = $this->get_ForeignUser($rowcap['id_usermodify']);
        $title = $capability[0]['feature'].'     ';
        $smalltitle = '     [SW '.$rowcap['sw_version'].']['.$user.' '.$rowcap['data_modifica'].']';
        
        if(strcasecmp($capability[0]['feature'], '5G UE-Capability')==0){
           $combination = $this->cap5gToView($capability[0]); 
        ?>

        <div class="panel">
            <a class="panel-heading" role="tab" id="heading<?php echo $count; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>" aria-expanded="false" aria-controls="collapse<?php echo $count; ?>">
                <h4 class="panel-title"><?php echo $title;?><small ><?php echo $smalltitle;?></small></h4>
            </a>
            <div id="collapse<?php echo $count; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $count; ?>">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#EN-DC Combination</th>                              
                                <th>DL</th>
                                <th>UL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $riga = 0;
                                    foreach ($combination as $key) {
                                        $riga++;
                                        echo"<tr><td scope=\"row\">$riga</td>";                                         
                                        echo"<td>".$key['DL']."</td>";
                                        echo"<td>".$key['UL']."</td></tr>";                                      
                                    }                            
                            ?>           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
           }
        else if(strcasecmp($capability[0]['feature'], '4G Bands')==0){
           $combination = $this->cap4gToView($capability[0]); 
        ?>

        <div class="panel">
            <a class="panel-heading" role="tab" id="heading<?php echo $count; ?>" data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $count; ?>" aria-expanded="false" aria-controls="collapse<?php echo $count; ?>">
                <h4 class="panel-title"><?php echo $title;?><small ><?php echo $smalltitle;?></small></h4>
            </a>
            <div id="collapse<?php echo $count; ?>" class="panel-collapse collapse" role="tabpanel" aria-labelledby="heading<?php echo $count; ?>">
                <div class="panel-body">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>#4G Bands Combination</th>                               
                                <th>DL</th>
                                <th>UL</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                                $riga = 0;
                                    foreach ($combination as $key) {
                                        $riga++;
                                        echo"<tr><td scope=\"row\">$riga</td>";                                         
                                        echo"<td>".$key['DL']."</td>";
                                        echo"<td>".$key['UL']."</td></tr>";                                      
                                    }                            
                            ?>           
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    <?php
           }   
        

    }
    
    function get_capabilities($id_project){
        $query = "SELECT * FROM `json_capabilities` WHERE `id_project`=$id_project ";
        $results = mysqli_query($this->mysqli,$query) or die($query . " - " . mysqli_error($this->mysqli));        
        $data_output = array(); 
        while ($row = $results->fetch_assoc()) {   
            $data_output[] = $row;           
        }
        return $data_output;
    }
    
   //Match all Redquirements Id in 5G UE-Capability Feature 
   function cap5gToView($fiveG_cap){
        
        //print_r(search_feature($datalog, '5G UE-Capability'));
        //$fiveG_cap = search_feature($datalog, '5G UE-Capability'); 
        //print_r($fiveG_cap);
        $DL = $this->search_key_InFeature($fiveG_cap, 'DL');
        $UL = $this->search_key_InFeature($fiveG_cap, 'UL');
        $NRDL = $this->search_key_InFeature($fiveG_cap, 'NRDL');
        $NRUL = $this->search_key_InFeature($fiveG_cap, 'NRUL');
        
        $row = '';        
        foreach ($DL as $key=>$key2) {
            $row = ''.$key;
            $dllength = 'DC';
            $ullength = 'DC';
            //DL loop
            foreach ($key2 as $key3=>$dlvalue) {
                //echo''.$UL[$key][$key2];
                $row .='  '.$dlvalue;
                $dllength .= '_'.$dlvalue;
                
                
            }
            //NRDL loop
            foreach ($NRDL[$key] as $key3=>$nrdlvalue) {
                //echo''.$UL[$key][$key2];
                $row .='  '.$nrdlvalue;
                $dllength .= '_'.$nrdlvalue;
                
                
            } 
            //UL loop
            foreach ($UL[$key] as $key3=>$ulvalue) {
                //echo''.$UL[$key][$key2];
                $row .='  '.$ulvalue;
                $ullength .= '_'.$ulvalue;
                
                
            }
            //NRUL loop
            foreach ($NRUL[$key] as $key3=>$nrulvalue) {
                //echo''.$UL[$key][$key2];
                $row .='  '.$nrulvalue;
                $ullength .= '_'.$nrulvalue;
                
                
            }
            $data[] = array('DL'=>strtoupper($dllength), 'UL'=>strtoupper($ullength));
        }        
        return $data;
  }
  
  function cap4gToView($fiveG_cap){
        
        //print_r(search_feature($datalog, '5G UE-Capability'));
        //$fiveG_cap = search_feature($datalog, '5G UE-Capability'); 
        //print_r($fiveG_cap);
        $DL = $this->search_key_InFeature($fiveG_cap, 'DL');
        $UL = $this->search_key_InFeature($fiveG_cap, 'UL');
        
        $row = '';        
        foreach ($DL as $key=>$key2) {
            //$row = ''.$key;
            $dllength = 'DC';
            $ullength = 'DC';
            //DL loop
            foreach ($key2 as $key3=>$value) {
                //echo''.$UL[$key][$key2];                  
                if(is_array($value)){
                 $dllength .= ' [MiMo'.$value['mimo'].']';    
                }
                else{
                    //$row .='  '.$dlvalue;
                    $dllength .= '_'.strtoupper($value); 
                }
                          
            }
            //UL loop
            if(isset($UL[$key])){
                foreach ($UL[$key] as $key3=>$ulvalue) {
                    //echo''.$UL[$key][$key2];
                    //$row .='  '.$ulvalue;
                    $ullength .= '_'.strtoupper($ulvalue);                                
                }                
            } else {
                $ullength = 'Undefined';
            }


            $data[] = array('DL'=>$dllength, 'UL'=>$ullength);
        }        
        return $data;
  }

} 
