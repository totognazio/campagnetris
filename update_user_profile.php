<script language="JavaScript" type="text/javascript">
<!--  
function seleziona(riga){
     riga.className="selezionata";
} 

function deseleziona(riga){
     riga.className="bianco";
} 

function conferma(){
   if (!(confirm('Confermi eliminazione?')))		
	{return false;}	
   else {return true;}	
}

function seleziona_campo(campo){
     campoSelezionato=document.getElementById(campo);
     campoSelezionato.style.background="orange";
}

function deseleziona_campo(campo){    
     campoSelezionato=document.getElementById(campo);
     campoSelezionato.style.background= "white";
}
-->
</script>
<?php 
//include_once (__DIR__.'/classes/socmanager_class.php');
#var_dump($_POST);
include(__DIR__."/classes/access_user/ext_user_profile.php"); 

error_reporting (E_ALL); // I use this only for testing

//$soc = new socmanager();
$update_profile = new Users_profile(false); // need to be false otherwise the redirect to this page will not work
$update_profile->access_page($_SERVER['PHP_SELF'], $_SERVER['QUERY_STRING']); // protect this page too.
   
$access_level = $page_protect->get_access_level();
//$job_role = $soc->get_user_info($page_protect->id)['group_level'];
$user_id = $page_protect->id;
$user_email = $update_profile->user_email;

//$userType = $soc->get_user_info($user_id)['usertype'];
//echo $user_email;

if (isset($_POST['Submit'])) {
	#if ($_POST['user_email'] == "" || $_POST['address'] == "" || $_POST['postcode'] == "" || $_POST['city'] == "") {
	#	$update_profile->the_msg = "Please fill the required fields.";
	#} else { 
		$update_profile->update_user_profile($_POST['password'], $_POST['confirm'], $_POST['user_full_name'], $_POST['user_firstname'], $_POST['user_email']); // the update method
                $error = $update_profile->the_msg;
		if($error=="Your account is modified."){
                 ?>   


                 <div class="modal fade bs-example-modal-sm in" tabindex="-1" role="dialog" aria-hidden="true" style="display: block; padding-right: 17px;">
                    <div class="modal-dialog modal-sm">
                      <div class="modal-content">

                        <div class="modal-header">
                          <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">×</span>
                          </button>
                          <h4 class="modal-title" id="myModalLabel2">Profile update</h4>
                        </div>
                        <div class="modal-body">
                          <h4>Your account is modified.</h4>
                         
                        </div>
                        <div class="modal-footer">
                          
                          <a title="Home" class="btn btn-primary"  href="index.php">Home</a>
                        </div>

                      </div>
                    </div>
                  </div>    
                  <div class="modal-backdrop fade in"></div>
    
                 <?php   
			#header("Location: ./index.php");
			#exit;
		}
                #var_dump($_POST);
		#$eu_date_field = (!empty($_POST['field_two'])) ? $_POST['field_two']."##eu_date" : $_POST['field_two']; 
		// add the eu date field information ONLY if the field is not empty
		
		#$update_profile->save_profile_date($_POST['id'], $_POST['language'], $_POST['address'], 
		#$_POST['postcode'], $_POST['city'], $_POST['country'], "", "", 
		#"", "", "", "", ""); 
                #$error2 = $update_profile->the_msg;
                 
               
	#}

} 


 // error message
?>

<!-- page content -->
        <div class="right_col" role="main">
          <div class="">
            <div class="page-title">
              <div class="title_left">
                <h3>Amministrazione</h3>
              </div>

              <div class="title_right">
                <div class="col-md-5 col-sm-5 col-xs-12 form-group pull-right top_search">
                  <!--<div class="input-group">
                    <input type="text" class="form-control" placeholder="Search for...">
                    <span class="input-group-btn">
                      <button class="btn btn-default" type="button">Go!</button>
                    </span>
                  </div>-->
                </div>
              </div>
            </div>

            <div class="clearfix"></div>

                <div class="row">
              <div class="col-md-12 col-sm-12 col-xs-12">
                <div class="x_panel">
                  <div class="x_title">
    
                    <h2>Update User Profile <?php //echo 'userType'; ?></h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li class="dropdown">
                        <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="false"><i class="fa fa-wrench"></i></a>
                        <ul class="dropdown-menu" role="menu">
                          <li><a href="#">Settings 1</a>
                          </li>
                          <li><a href="#">Settings 2</a>
                          </li>
                        </ul>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">

	  <p>&nbsp;</p>
          
       <p style="color:#FF0000;font-weight:bold;"><br><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>
        <!--<p style="color:#FF0000;font-weight:bold;"><br><b><?php echo (isset($error2)) ? $error2 : "&nbsp;"; ?></b></p>-->
      
	<form class="form-horizontal form-label-left" name="form1" method="post" action="<?php echo $_SERVER['REQUEST_URI'];?>">
            
          <div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="login">Username:</label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" id="username" type="text" disabled="disabled" size="10" value="<?php echo $update_profile->user; ?>" style="font-weight:bold;"  onfocus="seleziona_campo('username');" onblur="deseleziona_campo('username');" >
                </div>
	  </div>
        
	  <div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="password">Password:<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                <input class="form-control col-md-7 col-xs-12" id="password" name="password" type="password" value="" size="6" placeholder="* (min. 6 chars.)">
		
                </div>
	  </div>
	  <div class="form-group">
		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="confirm">Confirm password:<span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                    
                    <input class="form-control col-md-7 col-xs-12" id="confirm" name="confirm" type="password" value="" size="6" placeholder="* (min. 6 chars.)">
		
                </div>
	  </div>
       
	  <?php 
	  echo "<div class=\"form-group\">".$update_profile->create_form_field("user_full_name", "Cognome:", 30)."</div></div>";
          echo "<div class=\"form-group\">".$update_profile->create_form_field("user_firstname", "Nome:", 30)."</div></div>";
	  echo "<div class=\"form-group\">".$update_profile->create_form_field("user_email", "E-mail:", 30)."</div></div>";
	  #echo "<div>".$update_profile->create_form_field("user_info", "Extra info:", 20)."</div>";
	  // start fields from the profile table
	  #echo "<div>".$update_profile->create_form_field("field_one", "Company name <br>(user field 1")."</div>";
	  #echo "<div>".$update_profile->create_form_field("address", "Address", 20, true)."</div>";
	  #echo "<div>".$update_profile->create_form_field("postcode", "Postcode", 10, true)."</div>";
	  #echo "<div>".$update_profile->create_form_field("city", "City", 20, true)."</div>";
	  #echo "<div>".$update_profile->create_country_menu("Country")."</div>";
	  #echo "<div>".$update_profile->create_form_field("homepage", "Homepage")."</div>";
	  #echo "<div>".$update_profile->create_text_area("notes", "Signature or comment...")."</div>";
	  // You have to use the same field like the variable in the class 
	  #echo "<div>".$update_profile->create_form_field("field_two", "Euro Date dd/mm/yyyy<br>(user field 2)", 10, false, false, true)."</div>";
	  #echo "<div>".$update_profile->create_form_field("field_three", "US Date yyyy-mm-dd<br>(user field 3)", 10)."</div>";
	  #echo "<div>".$update_profile->language_menu("Language")."</div>";
	  ?>
 
            
          <div class="form-group"> 
		<div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
		<input type="hidden" name="id" value="<?php echo  $update_profile->profile_id; ?>">
		<input type="submit" class="btn btn-success" name="Submit" value="Update">
                </div>
	  </div>
                      <div>
                <label class="" id="campoObbligatorio">

                </label>
            </div> 
            
	</form>



      </div>


</div><!-- end .content -->
<p>This forms update the user informations.</p>
<p>Fields with a * are required and keep the password field(s) empty if you don't want to change it.</p>
 

</div>
</div>
</div>

