<!-- Tab Criteri-->   

<div role="tabpanel" class="tab-pane fade" id="tab_content4" aria-labelledby="profile-tab">
    <br/>
   
        
    <div class="col-md-12 col-sm-6 col-xs-12"> 
                    <div class="col-md-6 col-sm-6 col-xs-12">
              <label style="width:100%;">Call Guide
              <img id="infoRedemption" title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                 Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
              </label>

                <textarea id="redemption" name="redemption" class="form-control" rows="10"  <?php if ($readonly){echo $disabled_value;}?> onkeyup="checklength(0, 1000, 'redemption', 'charRedemption', '');" required="required" ><?php if ($modifica){echo stripslashes($id_campaign['redemption']); }?></textarea>
                <label style="width:100%;"><input type="text" name="charRedemption" id="charRedemption" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="4" value="1000" onfocus="this.blur()" /></label>
              </div> 
            <div class="col-md-3 col-sm-6 col-xs-12">
                   <label>Control Group  <span class="required">*</span>
                   <img id="infoControlGroup" title="Da impostare su SI soltanto se si vuole isolare e monitorare una percentuale del target su cui non verr&agrave; effettuata la campagna." alt="Control Group" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                   </label>
                                <?php
                                $value_0_selected = "";
                                $value_1_selected = "";
                                $display = ' style="display:none;"';
                                if ($modifica) {
                                    if($id_campaign['control_group']==1){
                                        $value_1_selected = " selected";
                                        $display = '';
                                    }
                                    else {$value_0_selected = " selected";}                                    
                                } 
                                ?> 
                     <select id="select_control_group" name="select_control_group" <?php if ($readonly){echo $disabled_value;} ?> class="select2_single form-control" style="width:100%" required="required">                                                                 
                         <option value="0"></option>       
                         <option value="0" <?php echo $value_0_selected; ?>>No</option>
                         <option value="1" <?php echo $value_1_selected; ?>>Si</option>
                          </select>                     
          
              
            </div>                      
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
               </div>       
            <div class="col-md-12 col-sm-6 col-xs-12">  
                <label style="width:100%;">File Upload
                </label>
                <div class="col-md-6 col-sm-6 col-xs-12">             
                    <div class="x_content">                        
                        <?php $fileid = uniqid();  ?>                      
                        <form id="my-dropzone" action="upload.php?fileid=<?php echo $fileid; ?>"  class="dropzone">
                        </form>
                        <br />
                    </div>
                </div>   
            </div>  
              
   
        <div  class="col-md-12 col-sm-12 col-xs-12"><br></div>    
  
  </div>

<script>
$(document).ready(function() {  

if(<?php echo $modifica; ?>){
    Dropzone.autoDiscover = false;
    Dropzone.options.myDropzone = {
        init: function() {
            thisDropzone = this;
        
            $.ajax({
                type: "POST",
                dataType: "json",
                url: "scan_uploaded.php",
                data: { fileid: '<?php echo $fileid; ?>'},
                success: function (data) {
        
                $.each(data, function(key,value){
                    
                    var mockFile = { name: value.name, size: value.size };
                    thisDropzone.options.thumbnail.call(thisDropzone, mockFile, "file/"+value.name);
                    thisDropzone.options.addedfile.call(thisDropzone, mockFile);
    
                    
                    
                });
                
                }
            });
        }  
    }
}
//console.log('sono quiiii');

var myDrop= new Dropzone("#my-dropzone");
myDrop.on("removedfile", function(file) {
    console.log('removedfile on');

     var filename = file.name; 

     $.ajax({
     url: "upload.php",
     data: { filename: filename, action: 'delete', fileid: '<?php echo $fileid; ?>'},
     type: 'POST',
     success: function (data) {
          if (data.NotificationType === "Error") {
               toastr.error(data.Message);
          } else {
               toastr.success(data.Message);                          
          }
        },
          error: function (data) {
               toastr.error(data.Message);
          }
     })

});



$('#select_control_group').select2({
          placeholder: "Select"
        });    
    
$('#select_control_group').on('select2:select', function () {
    var selected = $('#select_control_group').val();
    if(selected === '1'){
           //$("#spanLabelLinkTesto").fadeOut();
           $("#spanControlGroup").fadeIn();  
    }
    else if(selected === '0'){
       $("#spanControlGroup").fadeOut(); 
    }

    });
    
    
    });
</script>