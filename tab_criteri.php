<!-- Tab Criteri-->   

    <div role="tabpanel" class="tab-pane fade" id="tab_content2" aria-labelledby="profile-tab">

        <br />
<?php
//Guest non vede il Tab Criteri
if ($page_protect->get_job_role() >= 2) {
    ?>        
        
        <div class="col-md-12">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Stato:</label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="attivi" id="attivi" 
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
                value="1" data-parsley-mincheck="1" required class="flat" /> Attivi
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
                       value="1" class="flat" /> Sospesi
                <br />

                <input type="checkbox" name="disattivi" id="disattivi" 
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
            <p>
        </div>     
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tipo Offerta:</label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="consumer" id="consumer" 
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
                value="1" data-parsley-mincheck="1" required class="flat" /> Consumer
                <br />

                <input type="checkbox" name="business" id="business" 
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

                <input type="checkbox" name="microbusiness" id="microbusiness" 
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
            <p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Tipo Contratto:</label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="prepagato" id="prepagato" 
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
                       value="1" data-parsley-mincheck="1" required class="flat" /> Prepagato
                <br />

                <input type="checkbox" name="postpagato" id="postpagato" 
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
                       value="postpagato" class="flat" /> Postpagato
                <br />

                <input type="checkbox" name="contratto_microbusiness" id="contratto_microbusiness"                                                                                                                                    <?php
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
                       value="microBusiness" class="flat" /> MicroBusiness
                <br />
            <p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Consenso:</label>
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
                       value="1" class="flat" /> Trasferimento dati a terzi (solo Tre TBC)
                <br />
            <p>     
        </div>
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Mercato:</label><span class="required">*</span>
            <p style="padding: 5px;">
                <input type="checkbox" name="voce" id="voce"        
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
                <input type="checkbox" name="dati" id="dati" 
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
                <input type="checkbox" name="fisso" id="fisso" 
                                           <?php
                                if ($modifica) {
                                    if ($id_campaign['fisso'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Fissso
                <br />
            <p>     
        </div>
                <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Frodatori:</label><span class="required">*</span>
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
                       value="1" data-parsley-mincheck="1" required class="flat" /> No Frodi
                <br />

                <input type="checkbox" name="altri_filtri" id="altri_filtri" 
                      <?php
                                if ($modifica) {
                                    if ($id_campaign['no_frodi'] == 1){
                                    echo " checked=\"checked\" ";}
                                } else{
                                        echo "";}
                                if ($readonly){
                                echo $disabled_value;}
                                ?> 
                       value="1" class="flat" /> Altri Filtri
                <br />

            <p>     
        </div>
       </div>     
        <div class="col-md-12">
        <div class="col-md-2 col-sm-6 col-xs-12">
            <label>Segmento:</label><span class="required">*</span>
            <p style="padding: 5px;">
             <?php 
                              
                            if ($modifica){$segment_id = $id_campaign['segment_id'];}
                            else {$segment_id = 0;}                            
                            foreach ($segments as $key => $value) {                                
                                echo' <input type="radio" name="segment_id" id="'.$key.'" value="'.$key.'" data-parsley-mincheck="1" required class="flat" ';
                                if ($readonly) {echo $disabled_value;}
                                if ($segment_id == $key){echo " checked=\"checked\" ";}                                
                                echo'/> '.ucwords(strtolower($value));
                                echo'<br/>';
                            }                             
              ?>  


            <p>     
        </div>
                                   
                        <div class="col-md-4 col-sm-6 col-xs-12">
                         <label >Indicatore Dinamico  <span class="required">*</span></label>    
                          <input type="text" id="indicatore_dinamico" name="indicatore_dinamico"  class="form-control col-md-7 col-xs-12" 
                                <?php
                                $value = "";
                                if ($modifica) {
                                    $value = $id_campaign['indicatore_dinamico'];                                    
                                } 
                                if ($readonly){
                                echo $disabled_value;}
                                ?>                                                                              
                         value="<?php echo $value;?>">
                        </div>  
            <form id="demo-form" data-parsley-validate>
            <div  class="col-md-6 col-sm-12 col-xs-12">
              <label for="message">Altri Criteri (2000 chars max) :</label>
                                <?php
                                $value = "";
                                if ($modifica) {
                                    $value = $id_campaign['altri_criteri'];                                    
                                } 
                                if ($readonly){
                                echo $disabled_value;}
                                ?>               
              <textarea id="altri_criteri" required="required" class="form-control" name="altri_criteri" <?php if ($readonly){echo $disabled_value;}?> data-parsley-trigger="keyup"  data-parsley-maxlength="2000" data-parsley-maxlength-message="Attenzione!! E' stata raggiunta la lunghezza massima..." data-parsley-validation-threshold="10"><?php echo stripslashes($value);?></textarea>  
            </div>                       
            </form>
     
          
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


