<!-- Tab Criteri-->   
<?php #print_r($id_campaign);?>
<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
    <br/>
   
        
    <div class="col-md-12 col-sm-6 col-xs-12"> 
            <div class="col-md-3 col-sm-6 col-xs-12">
                   <label>Call Guide  <span class="required">*</span>
                   <img id="infoCallGiude" title="Da impostare su SI soltanto se si vuole inserire la Call Guide nell'apposita area di testo" alt="Call Guide flag" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                   </label>
                                <?php
                                $value_2_selected = "";
                                $value_3_selected = "";
                                $display_guide = ' style="display:none;"';
                                if ($modifica) {
                                    if($id_campaign['control_guide']==1){
                                        $value_3_selected = " selected";
                                        $display_guide = '';
                                    }
                                    else {$value_2_selected = " selected";}                                    
                                } 
                                ?> 
                     <select id="control_guide" name="control_guide" <?php if ($readonly){echo $disabled_value;} ?> class="select2_single form-control" style="width:100%" required="required" >                                                                                                 
                         <option value="0" <?php echo $value_2_selected; ?>>No</option>
                         <option value="1" <?php echo $value_3_selected; ?>>Si</option>
                    </select>                     
          
              
            </div> 

            <div class="col-md-3 col-sm-6 col-xs-12">
                   <label>Control Group  <span class="required">*</span>
                   <img id="infoControlGroup" title="Da impostare su SI soltanto se si vuole isolare e monitorare una percentuale del target su cui non verr&agrave; effettuata la campagna." alt="Control Group" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                   </label>
                                <?php
                                $value_0_selected = "";
                                $value_1_selected = "";
                                $value_2_selected = "";
                                $display = ' style="display:none;"';
                                $display_num = ' style="display:none;"';
                                if ($modifica) {
                                    if($id_campaign['control_group']==1){
                                        $value_1_selected = " selected";
                                        $display = '';
                                    }
                                    elseif($id_campaign['control_group']==2){
                                        $value_2_selected = " selected";
                                        $display = ' style="display:none;"';
                                        $display_num = '';
                                    }
                                    else {$value_0_selected = " selected";}                                    
                                } 
                                ?> 
                     <select id="control_group" name="control_group" <?php if ($readonly){echo $disabled_value;} ?> class="select2_single form-control" style="width:100%" required="required" >                                                                                                 
                         <option value="0" <?php echo $value_0_selected; ?>>No</option>
                         <option value="1" <?php echo $value_1_selected; ?>>Si (Percentuale)</option>
                         <option value="2" <?php echo $value_2_selected; ?>>Si (Volume)</option>
                    </select>                     
          
              
            </div>  
 </div>  
<div class="col-md-12 col-sm-6 col-xs-12"><br> 
        <span id="div_call_guide" <?php echo $display_guide; ?>>           
            <div  class="col-md-6 col-sm-6 col-xs-12" >
                <label style="width:100%;">Call Guide 
                <img id="infoRedemption" title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                    Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                </label>

                    <textarea id="redemption" name="redemption" class="form-control" rows="10" <?php if ($readonly){echo $disabled_value;}?> onkeyup="checklength(0, 1000, 'redemption', 'charRedemption', '');" ><?php if ($modifica){echo stripslashes($id_campaign['redemption']); }?></textarea>
                    <label style="width:100%;"><input type="text" name="charRedemption" id="charRedemption" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="4" value="1000" onfocus="this.blur()" /></label>
            </div> 
        </span>                    
            <span id="spanControlGroup" name="spanControlGroup" <?php echo $display; ?>>
                <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>Percentuale di Controllo<span id="req_13" class="req">*</span></label>
                            <input class="form-control col-md-2 col-sm-3 col-xs-12" id="perc_control_group" name="perc_control_group" <?php if ($readonly){echo $disabled_value;} ?> style="text-align:right" type="text"  maxlength="2"
                            <?php
                            if ($modifica){echo "value=\"" . $id_campaign['perc_control_group'] . "\"";}
                            else{echo "value=\"0\"";}
                            if ($readonly){echo $readonly_value;}
                            ?>
                            tabindex="16" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('perc_control_group');" onblur="deseleziona('perc_control_group');" />%
                </div>
            </span>
            <span id="spanControlNumerico" name="spanControlNumerico" <?php echo $display_num; ?>>
                <div class="col-md-3 col-sm-6 col-xs-12">
                            <label>Volume <span class="required">*</span></label>
                            <input class="form-control col-md-2 col-sm-3 col-xs-12" id="numeric_control_group" name="numeric_control_group" <?php if ($readonly){echo $disabled_value;} ?> style="text-align:right" type="number" min="0" max="99999999999" maxlength="14"
                            <?php
                            if ($modifica){echo "value=\"" . $id_campaign['numeric_control_group'] . "\"";}
                            else{echo "value=\"0\"";}
                            if ($readonly){echo $readonly_value;}
                            ?>
                            />
                </div>
            </span>
</div>      
                   
            <div class="col-md-12 col-sm-6 col-xs-12"><br><br> 
                <label style="width:100%;">File Upload
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">             
                    <div class="x_content">                                          
                        <form id="my-dropzone" action="upload.php?id_upload=<?php echo $id_upload; ?>&comunicazione"  class="dropzone">
                        </form>
                        <br />
                    </div>
                </div>   
            </div>  
         
   
        <div  class="col-md-12 col-sm-12 col-xs-12"><br></div>    
  
  </div>

<script>
$(document).ready(function() { 
var myDropzoneProfile = new Dropzone(
        '#my-dropzone',
        {          
            init: function () {
            //this.options.dictRemoveFileConfirmation = true;
            this.options.dictRemoveFileConfirmation = "Confermi di voler eliminare il File?";
            //solo su Modifica o Duplica     
          <?php if($modifica) {?>    
            thisDropzone = this;        
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "scan_uploaded.php",
                    data: { id_dir: '<?php echo $id_campaign['id']; ?>',subdir: 'comunicazione'},
                    success: function (data) {
            
                    $.each(data, function(key,value){  
                                var filename = value.name; 
                                var a = document.createElement('a');
                                a.setAttribute('class',"dz-remove");
                                //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                                a.setAttribute('href',"upload.php?download=<?php echo $id_campaign['id']; ?>&com&file=" + filename);
                                a.setAttribute('target', '_blank');
                                a.innerHTML = "Download file";

                        var mockFile = { name: value.name, size: value.size };                        
                        thisDropzone.options.thumbnail.call(thisDropzone, mockFile);
                        thisDropzone.options.addedfile.call(thisDropzone, mockFile);
                        thisDropzone.options.success.call(thisDropzone, mockFile);
                        thisDropzone.options.complete.call(thisDropzone, mockFile);
                        document.getElementById("my-dropzone").lastChild.appendChild(a);

                    });
                
                }
            });
        <?php  } ?>
            this.on("removedfile", function(file) {
                        console.log('removedfile on');

                        var filename = file.name; 

                                $.ajax({
                                url: "upload.php",
                                data: { filename: filename, action: 'delete', id_upload: '<?php echo $id_upload; ?>',subdir: 'comunicazione'},
                                type: 'POST',
                                success: function (data) {
                                    if (data.NotificationType === "Error") {
                                        console.log('error 1');
                                        //toastr.error(data.Message);
                                    } else {
                                        //toastr.success(data.Message);
                                        console.log('error 2');                          
                                    }
                                    },
                                    error: function (data) {
                                        //toastr.error(data.Message);
                                        console.log('error 3');
                                    }
                                })

                });


                this.on("processing", function (file) {
                        });
                this.on("maxfilesexceeded",
                            function (file) {
                                this.removeAllFiles();
                                this.addFile(file);
                            });

                this.on("success",
                            function (file, responseText) {
                                var filename = file.name; 
                                var a = document.createElement('a');
                                a.setAttribute('class',"dz-remove");
                                //onclick="javascript:window.location.href = './index.php?page=gestioneCampagne2'"
                                a.setAttribute('href',"upload.php?download=<?php echo $id_upload; ?>&com&file=" + filename);
                                a.setAttribute('target', '_blank');
                                a.innerHTML = "Download file";
                                file.previewTemplate.appendChild(a);
                            // do something here
                            });
           
                this.on("error",
                            function (data, errorMessage, xhr) {
                                // do something here
                            });
           
                            
            }
        });


$('#control_group').select2({
        placeholder: "Select"
});    
    
$('#control_group').on('select2:select', function () {    
    const selected_group = $('#control_group').val();
    console.log('controllo gruppo '+ selected_group);
    $(this).parsley().validate();
    if(selected_group === '1'){
           $("#spanControlGroup").fadeOut(); 
           $("#spanControlNumerico").fadeOut(); 
           $("#spanControlGroup").fadeIn();
              
    }
    else if(selected_group === '2'){
       $("#spanControlNumerico").fadeOut();  
       $("#spanControlGroup").fadeOut();  
       $("#spanControlNumerico").fadeIn();         
    }
    else if(selected_group === '0'){
       $("#spanControlGroup").fadeOut();
       $("#spanControlNumerico").fadeOut();  
    }

    });

$('#control_guide').select2({
          placeholder: "Select"
        });    
    
$('#control_guide').on('select2:select', function () {    
    const selected = $('#control_guide').val();
    console.log('controllo guide '+ selected);
    $(this).parsley().validate();
    if(selected === '1'){
           //$("#spanLabelLinkTesto").fadeOut();
           $("#div_call_guide").fadeIn();  
    }
    else if(selected === '0'){
       $("#div_call_guide").fadeOut(); 
    }

    });
    
    
    });



</script>