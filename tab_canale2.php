
<div role="tabpanel" class="tab-pane fade" id="tab_content5" aria-labelledby="profile-tab">
    <br/>
    <div class="col-md-9 col-sm-6 col-xs-12">
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Canale  <span class="required">*</span></label>
            <?php #print_r($stacks); ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="chammel_ins" style="width: 100%" name="select_channels[]" class="select2_single form-control"  required="required">      
                    <option value="0"></option>
                    <?php
                    foreach ($channels as $key => $value) {
                        echo '<option value="' . $key . '">' . $value . '</option>';
                    }
                    ?>  
                </select>
            </div>
        </div>

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Titolo & Sottotitolo  <span class="required">*</span></label>
            <?php #print_r($stacks); ?>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="tit_sott_ins" style="width: 100%" name="select_tit_sott[]" class="select2_single form-control" required="required">        
                    <option value=""></option>
                    <?php
                    foreach ($tit_sott as $key => $value) {
                        echo '<option value="' . $value['id'] . '">' . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                    ?>  
                </select>
            </div>
        </div>   

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Tipo Leva  <span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="idlevaselect" name="idlevaselect" class="select2_single form-control" onchange="levaselect()" required="required">        
                    <option value="0" selected></option>
                    <option value="mono">MonoLeva</option>
                    <option value="multi" >MultiLeva</option>

                </select>
            </div>
        </div>  
        <span id="monoleva" style="display: none;">  

            <div class="form-group">

                <label class="control-label col-md-3 col-sm-3 col-xs-12">Opzione  <span class="required">*</span></label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <select id="opz" name="opz" class="select2_single form-control" required="required">        
                        <option value="0" selected></option>
                        <option value="ropz">Ropz</option>
                        <option value="popz" >Popz</option>

                    </select>
                </div>

            </div> 
            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">ID Taglio
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="note" name="note" value="????"  class="form-control col-md-7 col-xs-12">
                </div>
            </div>


            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">ID News
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                    <input type="text" id="note" name="note"  class="form-control col-md-7 col-xs-12" value="????">
                </div>
            </div>    


        </span>     
        <span id="multileva" style="display: none;"> 

            <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">File Upload<span class="required">*</span>
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">             

                    <div class="x_content">
                        <p>Drag a file to the box below for upload or click to select file.</p>
                        <form action="form_upload.html" class="dropzone" required="required"></form>
                        <br />
                        <br />
                        <br />
                        <br />
                    </div>
                </div>   
            </div>  
        </span>   

        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Note Operative
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="text" id="note" name="note"  class="form-control col-md-7 col-xs-12">
            </div>
        </div>



        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Data Inizio Campagna
            </label>
            <div class="col-md-6 xdisplay_inputx form-group has-feedback">
                <input type="text" class="form-control has-feedback-left" id="data_inizio_comunicazione_campagna" placeholder="First Name" aria-describedby="inputSuccess2Status3" required="required">
                <span class="fa fa-calendar-o form-control-feedback left" aria-hidden="true"></span>
                <span id="inputSuccess2Status3" class="sr-only">(success)</span>
            </div>
        </div>
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12">Escludi Sa/Dom<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="escludi" name="escludi"  class="select2_single form-control"  style="width: 100%"   required="required">        
                    <option value="0" selected>No</option>
                    <option value="1">Sabato</option>
                    <option value="2" >Domenica</option>
                    <option value="3" >Sabato & Domenica</option>

                </select>
            </div>
        </div>  
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-6 col-xs-12">Durata Campagna<span class="required">*</span></label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <select id="duratacampagna" name="duratacampagna"  class="select2_single form-control"  style="width: 100%"   required="required" onchange="durata_camp(this.value);volumeRipartizione(0);">        
                    <option value="0" selected></option>
                    <option value="1">1 Giorno</option>
                    <option value="2" >2 Giorni</option>
                    <option value="3" >3 Giorni</option>
                    <option value="4" >4 Giorni</option>
                    <option value="5" >5 Giorni</option>
                    <option value="6" >6 Giorni</option>
                    <option value="7" >7 Giorni</option>

                </select>
            </div>
        </div>    
        <div class="form-group">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volume_tot">Volume Totale Stimato<span class="required">*</span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input id="volume_tot" name="volume_tot"  type="number" class="form-control col-md-7 col-xs-12" style="text-align:right"  onblur="volumeRipartizione(0);"  oninput="validity.valid||(value='');" pattern="/^-?\d+\.?\d*$/"  onKeyPress="if (this.value.length == 9)
                    return false;" min="0" max="999999999" value="" required="required" placeholder="maximum 9 digits">     

            </div>
        </div>  
        
        <div class="form-group" id="day1" style="display: none;">      
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero1">Volume Giorno 1<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero1" name="VolumeGiornaliero1"  class="form-control col-md-7 col-xs-12" style="text-align:right"   pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                    return false;"  min="0" max="999999999" value="0" required="required" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(1);">     

            </div>
        </div>  
        <div class="form-group" id="day2" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero2">Volume Giorno 2<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero2" name="volumeGiornaliero2"  class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="0" required="required" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(2);">     

            </div></div>  
        <div class="form-group" id="day3" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero3">Volume Giorno 3<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero3" name="volumeGiornaliero3"  class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="0" required="required" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(3);">     

            </div>
        </div>  
        <div class="form-group" id="day4" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="volumeGiornaliero4">Volume Giorno 4<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero4" name="volumeGiornaliero4" class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;" min="0" max="999999999" value="0" required="required" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(4);">     

            </div>
        </div>  
        <div class="form-group" id="day5" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="VolumeGiornaliero5">Volume Giorno 5<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero5" name="volumeGiornaliero5"  class="form-control col-md-7 col-xs-12" style="text-align:right"  pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="0" required="required" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(5);">     

            </div>
        </div>  

        <div class="form-group" id="day6" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Volume Giorno 6<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero6" name="volumeGiornaliero6" class="form-control col-md-7 col-xs-12" style="text-align:right"   pattern="/^-?\d+\.?\d*$/" onKeyPress="if (this.value.length == 9)
                            return false;"  min="0" max="999999999" value="0" required="required" oninput="validity.valid||(value='');" onblur="volumeRipartizione(6);">     

            </div>
        </div>  
        <div class="form-group" id="day7" style="display: none;">
            <label class="control-label col-md-3 col-sm-3 col-xs-12" for="note">Volume Giorno 7<span class="required"></span>
            </label>
            <div class="col-md-6 col-sm-6 col-xs-12">
                <input type="number" id="VolumeGiornaliero7" name="volumeGiornaliero7" class="form-control col-md-7 col-xs-12" style="text-align:right" pattern="/^-?\d+\.?\d*$/" 
                       onKeyPress="if (this.value.length == 9) return false;"   min="0" max="999999999" value="0" required="required" value="" oninput="validity.valid||(value='');" onblur="volumeRipartizione(7);">     

            </div>
        </div>                            

    
    
    
    
    
    </div>  

    <span id="sms_field" style="display: none;">  
        <div class="col-md-3 col-sm-6 col-xs-12">
                                
                        <label>Sender  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="senders_ins" name="senders_ins" class="select2_single form-control" style="width:100%" required="required">      
                                

                          </select>
                        

                       <label>Storicizzazione Legale  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="storicizza_ins" name="storicizza_ins" class="select2_single form-control" style="width:100%" required="required">      
                                <option value=""></option>
                                <option value="0">No</option>
                                <option value="1">Si</option>
                                

                          </select>
                         
          <form id="demo-form" data-parsley-validate>
            
              <label for="message">Test SMS </label>
              <textarea id="testo_sms" required="required" class="form-control" name="testo_sms" onkeyup="checklength(0, 640, 'testo_sms', 'charTesto', 'numero_sms')" ></textarea>  
              <label style="width:100%;"><small>Numeri caratteri utilizzati</small><input type="text" name="charTesto" id="charTesto" value="" class="text" value="" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
              <label style="width:100%;"><small>Numero SMS</small><input type="text" name="numero_sms" id="numero_sms" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
            </form>             
     
                          <label>Modalità Invio  <span class="required">*</span></label>                       
                            <select id="mod_invio" name="mod_invio" class="select2_single form-control" style="width:100%" required="required">      
                                <option value=""></option>
                                <option value="Interattivo">Interattivo</option>
                                <option value="Standard">Standard</option>

                          </select>
                      
                        <span id="spanLabelLinkTesto" style="display:none;">
                            <label  id="labelLinkTesto">Link<span id="req_19" class="req">*</span></label>
                            <input  id="link" name="link" type="text" class="form-control col-md-7 col-xs-12" style="text-align:right" tabindex="23" maxlength="400" onkeyup="checklength(0, 255, 'link', 'charLink', ''); checklengthTotal('charLink','charTesto','numero_totale');" />
                            <label style="width:100%;"><small>Numero</small><input type="text" name="charLink" id="charLink" class="text" readonly="readonly"  size="3" value="255" placeholder="max 255"onfocus="this.blur()" /></label>   
                            <label style="width:100%;"><small>Numero Caratteri Totale</small><input type="text" name="numero_totale" id="numero_totale" value="" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>                  
                        </span>   
                          <br>
                       <label>Tipo Monitoring  <span class="required">*</span></label>
                        <?php #print_r($stacks); ?>
                       
                            <select id="tipoMonitoring" name="tipoMonitoring" class="select2_single form-control" style="width:100%" required="required">      
                                <option value="0"></option>
                                <option value="1">ADV Tracking tool</option>
                                <option value="2">Orphan page</option>
                                <option value="3">No monitoring</option>
                          </select>
                       <label>Durata SMS  <span class="required">*</span></label>
                          <input type="text" id="sms_duration" name="sms_duration"  class="form-control col-md-7 col-xs-12" value="2">
                        <img id="info" title="Numero di giorni in cui la rete tenter&agrave; l'invio dell'sms. Range da 1 a 7 giorni." alt="Durata SMS" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
  
        </div>

        </span>   
        <span id="pos_field" style="display: none;"> 

            <?php #print_r($stacks); ?>
            <div class="col-md-3 col-sm-6 col-xs-12">
                <label>Categoria & Sottocategoria</label>
                <select id="cat_sott_ins" style="width: 100%" name="select_cat_sott[]" class="select2_single form-control" required="required">        
                    <?php                               
                    foreach ($cat_sott as $key => $value) {
                        echo '<option value="' . $value['id'] . '">' . $value['name'] . ' - ' . $value['label'] . '</option>';
                    }
                    ?>  
                </select>
            </div>
         

        
        
        </span>  
</div>                    

