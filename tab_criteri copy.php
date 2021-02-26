<!-- Tab Criteri-->   

    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

        <br />
<?php
//Guest non vede il Tab Criteri
if ($page_protect->get_job_role() >= 2) {
    ?>        
        
        <div class="col-md-12">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Stato </label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="attivi" id="attivi" data-parsley-errors-container="#checkbox-errors" 
                 <?php
                                if ($modifica) {
                                    if ($id_campaign['attivi'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                ?>       
                value="1" data-parsley-multiple="stato" required class="flat" /> Attivi
                <br />

                <input type="checkbox" name="sospesi" id="sospesi" 
                 <?php
                                if ($modifica) {
                                    if ($id_campaign['sospesi'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>
                       value="1" data-parsley-multiple="stato" class="flat" /> Sospesi
                <br />

                <input type="checkbox" data-parsley-multiple="stato" name="disattivi" id="disattivi" 
                        <?php
                                if ($modifica) {
                                    if ($id_campaign['disattivi'] == 1){
                                    echo " checked=\"checked\" ";                                    
                                    }
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>
                       value="1" class="flat" /> Disattivi
                <br />
                <div id="checkbox-errors"></div>
            <p>
        </div>     
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tipo Offerta </label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="consumer" id="consumer"  data-parsley-multiple="consumer" required data-parsley-errors-container="#checkbox-errors5"
                                                <?php
                                if ($modifica) {
                                    if ($id_campaign['consumer'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>                              
                value="1"  class="flat" /> Consumer
                <br />

                <input type="checkbox" name="business" id="business" data-parsley-multiple="consumer" 
                                                                <?php
                                if ($modifica) {
                                    if ($id_campaign['business'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>   
                       value="1" class="flat" /> Business
                <br />

                <input type="checkbox" name="microbusiness" id="microbusiness" data-parsley-multiple="consumer" 
                                                                                      <?php
                                if ($modifica) {
                                    if ($id_campaign['microbusiness'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>  
                       value="1" class="flat" /> MicroBusiness
                <br />
                <div id="checkbox-errors5"></div>
            <p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tipo Contratto </label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="prepagato" id="prepagato" data-parsley-multiple="tipo_contratto" required  data-parsley-errors-container="#checkbox-errors4"  
                                                                                                            <?php
                                if ($modifica) {
                                    if ($id_campaign['prepagato'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>                         
                       value="1"  class="flat" /> Prepagato
                <br />

                <input type="checkbox" name="postpagato" id="postpagato" data-parsley-multiple="tipo_contratto"  
                        <?php
                                if ($modifica) {
                                    if ($id_campaign['postpagato'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>  
                       value="1" class="flat" /> Postpagato
                <br />

                <input type="checkbox" name="contratto_microbusiness" id="contratto_microbusiness" data-parsley-multiple="tipo_contratto"                                                                                                                                     <?php
                                if ($modifica) {
                                    if ($id_campaign['contratto_microbusiness'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                echo "";}
                                ?>
                                <?php
                                if ($readonly){
                                echo $disabled_value;}
                                ?>  
                       value="1" class="flat" /> MicroBusiness
                <br />
                <div id="checkbox-errors4"></div>
            <p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Consenso </label>
            <p style="padding: 5px;">
                <input type="checkbox" name="cons_profilazione" id="cons_profilazione" 
                               <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_profilazione'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?>                       
                       value="1"  class="flat" /> Profilazione
                <br />

                <input type="checkbox" name="cons_commerciale" id="cons_commerciale" 
                                                                              <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_profilazione'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Commerciale
                <br />

                <input type="checkbox" name="cons_terze_parti" id="cons_terze_parti" 
                                                                                                     <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_terze_parti'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Terze Parti (Wind)
                <br />
                <input type="checkbox" name="cons_geolocalizzazione" id="cons_geolocalizzazione" 
                                                                                                     <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_geolocalizzazione'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Geolocalizzazione
                <br />
                <input type="checkbox" name="cons_enrichment" id="cons_enrichment" 
                                                                                                     <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_enrichment'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Enrichment
                <br />
                <input type="checkbox" name="cons_trasferimentidati" id="cons_trasferimentidati" 
                                                                                                     <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_trasferimentidati'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Trasferimento dati a terzi (Tre)
                <br />
                
            </p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Mercato </label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="voce" id="voce" data-parsley-multiple="mercato" required data-parsley-errors-container="#checkbox-errors2"        
                    <?php
                                if ($modifica) {
                                    if ($id_campaign['voce'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Mobile Voce
                <br />
                <input type="checkbox" name="dati" id="dati" data-parsley-multiple="mercato" 
                    <?php
                                if ($modifica) {
                                    if ($id_campaign['dati'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Mobile Dati
                <br />
                <input type="checkbox" name="fisso" id="fisso" data-parsley-multiple="mercato"  
                                           <?php
                                if ($modifica) {
                                    if ($id_campaign['fisso'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Fisso
                <br />
                <div id="checkbox-errors2"></div>
            </p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Frodatori </label><span class="required"></span>
            <p style="padding: 5px;">
                <input type="checkbox" name="no_frodi" id="no_frodi" 
                                                                  <?php
                                if ($modifica) {
                                    if ($id_campaign['no_frodi'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1"  class="flat" /> No Frodi
                <br />

                <input type="checkbox" name="altri_filtri" id="altri_filtri"  
                      <?php
                                if ($modifica) {
                                    if ($id_campaign['altri_filtri'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> No Collection
                       
                <br />

            </p>  
            <div id="checkbox-errors1"></div>  
        
        </div>
       </div>     
        <div class="col-md-12">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Segmento </label>
            <p style="padding: 5px;">
             <?php 
                 //$require_first = 'required';  
                 $require_first = '';            
                            if ($modifica){$segment_id = $id_campaign['segment_id'];}
                            else {$segment_id = 0;}                            
                            foreach ($segments as $key => $value) {                                
                                echo' <input type="radio" name="segment_id" id="ch_'.$key.'" value="'.$key.'" data-parsley-multiple="segmento" '.$require_first.'  class="flat" ';
                                if ($readonly) {echo $disabled_value;}
                                if ($segment_id == $key){echo " checked=\"checked\" ";}                                
                                echo'/> '.ucwords(strtolower($value));
                                echo'<br/>';
                                $require_first = '';  
                            }
                            echo'<br/>';
                            if (!$readonly) {
                                echo'<input id="clear-button" type="button"  name="reset" value="reset" onClick="reset_button();">';
                                 echo '<script>function reset_button() {';
                                foreach ($segments as $key => $value) {   
                                     echo '$("#ch_'.$key.'").iCheck(\'uncheck\');'; 
                                }
                                echo '}</script>';

                            }       
                                                       
              ?>  

            </p>     
        </div>
                    <form id="demo-form" data-parsley-validate>
            <div  class="col-md-6 col-sm-12 col-xs-12">
              <label for="message">Altri Criteri (2000 chars max) </label><span class="required">*</span>
                                <?php
                                $value = "";
                                if ($modifica) {
                                    $value = $id_campaign['altri_criteri'];                                    
                                } 
                                if ($readonly){
                                echo $disabled_value;}
                                ?>               
              <textarea id="altri_criteri" required="required" class="form-control" rows="15" name="altri_criteri" <?php if ($readonly){echo $disabled_value;}?> data-parsley-trigger="keyup"  data-parsley-maxlength="2000" data-parsley-maxlength-message="Attenzione!! E' stata raggiunta la lunghezza massima..." data-parsley-validation-threshold="10"><?php echo stripslashes($value);?></textarea>  
            </div>                       
            </form>

                    <div class="col-md-3 col-sm-6 col-xs-12">
                        <label>Indicatore Dinamico <span class="required">*</span>
                        <!--<img id="infoInd" title="bla bla bla on verr&agrave; effettuata la campagna." alt="Control Group" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>-->
                        </label>
                                        <?php
                                        $value_0_selected = "";
                                        $value_1_selected = "";
                                        //$display = ' style="display:none;"';
                                        if ($modifica) {
                                            if($id_campaign['indicatore_dinamico']==1){
                                                $value_1_selected = " selected";
                                                //$display = '';
                                            }
                                            else {$value_0_selected = " selected";}                                    
                                        } 
                                        ?> 
                            <select id="select_control_indic" name="indicatore_dinamico" <?php if ($readonly){echo $disabled_value;} ?> class="select2_single form-control" style="width:100%" required="required" >                                                                                                 
                                <option value="0" <?php echo $value_0_selected; ?>>No</option>
                                <option value="1" <?php echo $value_1_selected; ?>>Si</option>
                            </select>  
                            <div id="checkbox-errors5"></div>                    
                        
                    </div>  
                                   
 
     
          
       </div>
        <div  class="col-md-12 col-sm-12 col-xs-12"><br></div>    
  

<?php }
 else {
?>     
        <br />     
        <div  class="col-md-12 col-sm-12 col-xs-12"><br><br><h2>Accesso non consentito!!!</h2></div>       
<?php
}
?>
        

  </div>


