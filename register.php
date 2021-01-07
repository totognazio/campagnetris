<?php
include_once './classes/funzioni_admin.php';
include_once("./classes/access_user/access_user_class.php"); 


$funzioni_admin = new funzioni_admin();
$new_member = new Access_user;


if (isset($_POST['submit']) && $_POST['azione'] == "aggiungi") {
    #var_dump($_POST);
    $inserisci = isset($_POST['inserisci']) ? $_POST['inserisci'] : 'No';
    $modifica = isset($_POST['modifica']) ? $_POST['modifica'] : 'No';
    $cancella = isset($_POST['cancella']) ? $_POST['cancella'] : 'No';

    $levello_accesso = $funzioni_admin->access_level($inserisci, $modifica, $cancella);

    if (isset($_POST['selectStack']) && trim($_POST['selectStack'])!='')
        echo '<script type="text/javascript">errore("Attenzione scegliere lo Stack!!");</script>';

    $name = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);


    if (isset($_POST['maillist']))
        $maillist = intval($_POST['maillist']);
    else
        $maillist = 0;
 #echo'eccomi qua-----'.$levello_accesso;
    $new_member->register_newuser($_POST['login'], $_POST['password'], $_POST['confirm'], $cognome, $_POST['email'], $name, $_POST['selectRuolo'], $_POST['selectStack'], $_POST['selectStato'], $inserisci, $modifica, $cancella, $levello_accesso, $maillist);
}
$error = $new_member->the_msg; // error message
?>



<script language="JavaScript" type="text/javascript">

    function seleziona(riga) {
        riga.className = "selezionata";
    }

    function deseleziona(riga) {
        riga.className = "bianco";
    }

    function conferma() {
        if (!(confirm('Confermi eliminazione?')))
        {
            return false;
        }
        else {
            return true;
        }
    }

    function errore(value) {
        if (!(confirm(value)))
        {
            return false;
        }

    }

    function seleziona_campo(campo) {
        campoSelezionato = document.getElementById(campo);
        //campoSelezionato.style.background = "orange";
        campoSelezionato.style.background = "";
    }

    function deseleziona_campo(campo) {
        campoSelezionato = document.getElementById(campo);
        //campoSelezionato.style.background = "white";
        campoSelezionato.style.background = "";
    }

</script>


   <?php 
          $alert_danger = '<div class="alert alert-danger alert-dismissible fade in" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">×</span>
                    </button>
                    <strong>Holy guacamole!</strong>'. $error .'</div>';
    ?>

        <br><?php echo (isset($error)) ? $alert_danger : "&nbsp;"; ?>

        <?php
        if (!isset($_POST['submit'])) {
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
                    <h2>Registrazione Nuovo Utente</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 

                    <br />
            <form class="form-horizontal form-label-left name="form1" method="post" action="index.php?page=register">
                    <div class="form-group">
                   
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Cognome</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" id="cognome" name="cognome" type="text" class="text" value="<?php echo (isset($_POST['cognome'])) ? $_POST['cognome'] : ""; ?>" tabindex="2" onfocus="seleziona_campo('cognome');" onblur="deseleziona_campo('cognome');"/>
                        </div>
                    </div>      
                    <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Nome</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" id="nome" name="nome" type="text" class="text" value="<?php echo (isset($_POST['nome'])) ? $_POST['nome'] : ""; ?>" tabindex="3" onfocus="seleziona_campo('nome');" onblur="deseleziona_campo('nome');"/>
                        </div>
                   </div>   
       


                <div class="form-group"> 
                         
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Username</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" id="login" type="text" name="login" class="text"  value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : ""; ?>" onfocus="seleziona_campo('login');" onblur="deseleziona_campo('login');"/>
                        <span class="required">*</span>(min. 6 chars.) <br>
                        </div>
                </div>

                  
                 
                        <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" id="password" type="password" name="password" class="text"  value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ""; ?>" onfocus="seleziona_campo('password');" onblur="deseleziona_campo('password');"/>
                        <span class="required">*</span>(min. 6 chars.) <br>
                        </div>
                        </div>
               
                   <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Conferma Password</label>
                        <div class="col-md-6 col-sm-6 col-xs-12"><input class="form-control" id="confirm" type="password" name="confirm" class="text" value="<?php echo (isset($_POST['confirm'])) ? $_POST['confirm'] : ""; ?>" onfocus="seleziona_campo('confirm');" onblur="deseleziona_campo('confirm');"/>
                        <span class="required">*</span><br>
                        </div>
                        </div>
 <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">E-mail</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input class="form-control" id="email" type="text" name="email" class="text"  size="25" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ""; ?>" onfocus="seleziona_campo('email');" onblur="deseleziona_campo('email');">
                            <span class="required">*</span><br>
                           </div> 
                        </div>
         
                    <br>
               <div class="form-group">
                        <label class="control-label col-md-3 col-sm-3 col-xs-12">Maillist</label>
                        <div class="col-md-6 col-sm-6 col-xs-12">
                        <input  id="maillist" name="maillist" type="checkbox" value="1"   tabindex="8" /></span>
                        </div>
                </div>
                
                <div class="form-group"> 
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"   id="ruolo">Ruolo:
                       <span class="required">*</span>
                    </label>
                   <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control"  id="selectRuolo" name="selectRuolo"  tabindex="6" onfocus="seleziona_campo('selectRuolo');" onblur="deseleziona_campo('selectRuolo');"/>    
                    <option> </option>
    <?php
    $ruolo = $funzioni_admin->get_list_id("job_roles");

    foreach ($ruolo as $key => $value) {
        if (strtolower(trim($value['name'])) == 'guest')
            $selected = 'selected=\"selected\"';
        else
            $selected = '';
        echo"<option $selected value=\"" . $value['id'] . "\" >" . $value['name'] . "</option>";
    }
    ?>

                    </select>
                       </div>
                    </div>   
                    <div class="form-group">
                    <label class="control-label col-md-3 col-sm-3 col-xs-12"   id="stato">Stato:
                        <span class="required">*</span>
                    </label>

                        <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" id="selectStato" name="selectStato"  tabindex="7" onfocus="seleziona_campo('selectStato');" onblur="deseleziona_campo('selectStato');"/>      
                    <option  selected="selected" value="n" >Disattivo</option>
                    <option   value="y">Attivo</option>  
                    <option  value="b" >Sospeso</option>
                    </select>
               </div>
                        </div><br><br>
                 <div class="form-group"> 

                    <label class="control-label col-md-3 col-sm-3 col-xs-12"   id="dipartimento">Stack:
                        <span class="required">*</span>
                    </label>
                     <div class="col-md-6 col-sm-6 col-xs-12">
                    <select class="form-control" id="selectStack" name="selectStack"  tabindex="6" onfocus="seleziona_campo('selectStack');" onblur="deseleziona_campo('selectStack');"/>

    <?php
    $dep = $funzioni_admin->get_list_id("campaign_stacks");
    echo'<option></option>';
    foreach ($dep as $key => $value) {
        echo"<option  value=\"" . $value['id'] . "\" >" . $value['name'] . "</option>";
    }
    ?>
                    </select>
                </div>
                     </div>
          

         <div class="ln_solid"></div>
       
            <div class="form-group">
                <div class="col-md-6 col-md-offset-3">
                   
                    <input class="btn btn-primary" id="annulla" name="annulla"  tabindex="12" type="button" value="Annulla" onclick="javascript:window.location.href = ''"/>
                    <input class="btn btn-success" id="submit" name="submit"  tabindex="13" type="submit" value="Submit" />
                    <input type="hidden" id="modificaUtente" name="azione" value="aggiungi" />
                </div>

            </div>  

            </form>
    <?php
}
?>


    </div>
<?php
if (isset($_POST['submit']) && $_POST['azione'] == "aggiungi") {
    include 'gestioneUtenti.php';
}
?>
</div><!-- end .content -->
