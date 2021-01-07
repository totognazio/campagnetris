<style type="text/css">
            
                tr:hover {
                background-color: lightgrey;
                color: black;
                }
 </style>
          
<?php

include_once './classes/funzioni_admin.php';
$funzioni_admin = new funzioni_admin();
$funzioni_access = new Access_user;
if (isset($_POST['modificaUtente']) && $_POST['modificaUtente'] == "1") {

    if (isset($_POST['inserisci']))
        $inserisci = "Yes";
    else
        $inserisci = "No";
    if (isset($_POST['modifica']))
        $modifica = "Yes";
    else
        $modifica = "No";
    if (isset($_POST['cancella']))
        $cancella = "Yes";
    else
        $cancella = "No";

    if (isset($_POST['password']) && !empty($_POST['password']))
        $update_pw = ",`pw`='" . md5($_POST['password']) . "'";
    else
        $update_pw = '';
    if (isset($_POST['cognome']))
        $cognome = "`lastname`='" . trim($_POST['cognome']) . "',";
    else
        $cognome = '';
    if (isset($_POST['nome']))
        $nome = "`firstname`='" . trim($_POST['nome']) . "',";
    else
        $nome = '';
    if (isset($_POST['maillist']) && $_POST['maillist'] == 1)
        $maillist = ",`maillist`='1'";
    else
        $maillist = ",`maillist`='0'";
    $email = "";
    if (isset($_POST['email']) && $funzioni_access->check_email($_POST['email'])) {
        $email = ',`email`="' . trim($_POST['email']) . '"';

        $funzioni_access->user_email = $email;
#$funzioni_access->user = $first_login;
        /* if ($funzioni_access->check_user("lost")) {
          $this->the_msg = $this->messages(12);
          return;
          } */
    } //else
    // echo '<script type="text/javascript">alert("Attenzione! Indirizzo e-mail non valido.");</script>';
#if (isset($_POST['username']) && !empty($_POST['username'])) $funzioni_admin->check_new_username ($_POST['username']);
#$login = $_POST['username']
    $access_level = $funzioni_admin->access_level($inserisci, $modifica, $cancella);
    $update_sql = "UPDATE `users` SET $cognome $nome `job_role_id`='" . $_POST['selectRuolo'] . "',`login`='" . $_POST['login'] . "',`squad_id`='" . $_POST['selectDipartimento'] . "',`active`='" . $_POST['selectStato'] . "',`leggi`='Yes',`inserisci`='" . $inserisci . "',`modifica`='" . $modifica . "',`cancella`='" . $cancella . "' $email $update_pw ,`access_level`='" . $access_level . "' $maillist WHERE `id`='" . $_POST['idUtente'] . "'";
    $result = $funzioni_admin->user_update($update_sql);
    if ($result > 0)
        $stringa_risultato = "L'aggiornamento è avvenuto correttamente";
}
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
                    <h2>Gestione Utenti</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content" id="content"> 
                      
                      

    <script language="JavaScript" type="text/javascript">
        function seleziona(riga) {
            riga.className = "selezionata";
        }

        function deseleziona(riga) {
            riga.className = "bianco";
        }

        function conferma(utente) {
            if (!(confirm('L\'utente \'' + utente + '\' verrà disattivato. Confermi?')))
            {
                return false;
            }
            else {
                return true;
            }
        }

        function erase_user(utente) {
            if (!(confirm('L\'utente \'' + utente + '\' verrà eliminato dal DB. Confermi?')))
            {
                return false;
            }
            else {
                return true;
            }
        }

        function seleziona_campo(campo) {
            campoSelezionato = document.getElementById(campo);
            campoSelezionato.style.background = "orange";
        }

        function deseleziona_campo(campo) {
            campoSelezionato = document.getElementById(campo);
            campoSelezionato.style.background = "white";
        }
    </script>
    <?php
    if (isset($_GET['function'])) {

        if ($_GET['function'] == "updateUser") {
            if (!empty($_POST['idUtente'])) {
                $user_id = $_POST['idUtente'];
                $utente = $funzioni_admin->user_get_info($user_id);
                print_r($utente);
            }
            ?>


                <form id="form" name="form"  class="form-horizontal form-label-left" enctype="multipart/form-data" action="./index.php?page=gestioneUtenti" method="post" data-parsley-validate onsubmit="return controllaform()">
                    <div class="left" style="margin-left: 20px; margin:10px;  width:90%; min-height:20px;">
                        <label class="intestazione"  id="datianagrafici">Dati anagrafici:
                        </label>
                    </div>
          <div class="form-group">
                <label class="control-label col-md-3 col-sm-3 col-xs-12" for="login">Cognome </label>
                <div class="col-md-6 col-sm-6 col-xs-12">
                            <input class="form-control col-md-7 col-xs-12" id="cognome" name="cognome" type="text"  size="10" value="<?php echo $utente['lastname'];  ?>" style="font-weight:bold;"  tabindex="2" onfocus="seleziona_campo('cognome');" onblur="deseleziona_campo('cognome');"/>
                </div>
	    </div>
      <div class="form-group">
      		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="login">Nome </label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" id="nome" name="nome" type="text"  size="10" value="<?php echo $utente['firstname'];  ?>" style="font-weight:bold;"  tabindex="3" onfocus="seleziona_campo('nome');" onblur="deseleziona_campo('nome');"/>
                </div>
	  </div>
    

                    <div class="left" style="margin-left: 20px; margin:10px;  width:90%; min-height:20px;">
                        <label class="intestazione"   id="datiaccesso" >Dati d'accesso:
                        <span id="req_2" class="req">*</span>
                        </label>
                    </div>
            <div class="form-group">
      		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="login">Login <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" id="login" name="login"type="text"  size="10" value="<?php echo $utente['login'];  ?>" style="font-weight:bold;"  placeholder="(min. 6 chars.)" required="required" tabindex="4"  onfocus="seleziona_campo('login');" onblur="deseleziona_campo('login');"/>
                </div>
	  </div>              
                    
            <div class="form-group">
      		<label class="control-label col-md-3 col-sm-3 col-xs-12" for="login">New Password <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                    <input class="form-control col-md-7 col-xs-12" id="password" name="password" type="password"  size="10" value="" style="font-weight:bold;"  placeholder="(min. 6 chars.)" data-parsley-trigger="change" data-parsley-min="6" required="required" tabindex="5" onfocus="seleziona_campo('password');" onblur="deseleziona_campo('password');"/>
                </div>
	  </div>  
                  <div class="form-group">
      		<label class="control-label col-md-3 col-sm-3 col-xs-12" >E mail <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">                    
               <input type="email" id="email" class="form-control col-md-7 col-xs-12" name="email" value="<?php echo $utente['email']; ?>"  data-parsley-trigger="change" required />
                </div>
	  </div>  
      <br>
        <div class="form-group">
      		<label class="control-label col-md-3 col-sm-3 col-xs-12">Maillist </label>
            
            <input class="flat" id="maillist" name="maillist" type="checkbox" value="1" <?php
                if ($utente['maillist'] == 1)
                    echo 'checked="checked"';
                else
                    echo '';
                    ?>/>
            </div><br> 
            <div class="form-group">
	      		<label class="control-label col-md-3 col-sm-3 col-xs-12" >Ruolo <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                            <select class="select2_single form-control" id="selectRuolo" name="selectRuolo">          
                            <?php
                            $ruolo = $funzioni_admin->get_list_id("job_roles");

                            foreach ($ruolo as $key => $value) {
                                if ($utente['job_role_id'] == $value['id'])
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
      		<label class="control-label col-md-3 col-sm-3 col-xs-12" >Stato <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">

                        <?php
                        $selected_attivo = $selected_sidattivo = $selected_sospeso = '';
                        if (( trim(strtolower($utente['active'])) == 'y'))
                            $selected_attivo = 'selected="selected"';
                        elseif (( trim(strtolower($utente['active'])) == 'n'))
                            $selected_sidattivo = 'selected="selected"';
                        elseif (( trim(strtolower($utente['active'])) == 'b'))
                            $selected_sospeso = 'selected="selected"';
                        ?>                      
                        <select class="select2_single form-control" id="selectStato" name="selectStato">
                            <option <?php echo $selected_attivo; ?> value="y"   >Attivo</option>
                            <option <?php echo $selected_sidattivo; ?> value="n" >Disattivo</option>
                        </select>
                     </div>
	  </div>                

                                                                  <div class="form-group">
      		<label class="control-label col-md-3 col-sm-3 col-xs-12" >Squad <span class="required">*</span></label>
		<div class="col-md-6 col-sm-6 col-xs-12">
                        <select class="select2_single form-control" id="selectDipartimento" name="selectDipartimento">
                            <?php
                            $dep = $funzioni_admin->get_list_id("squads");

                            foreach ($dep as $key => $value) {
                                if ($utente['squad_id'] == $value['id'])
                                    $selected = 'selected=\"selected\"';
                                else
                                    $selected = '';
                                echo"<option $selected value=\"" . $value['id'] . "\" >" . $value['name'] . "</option>";
                            }
                            ?>

                        </select>
                    </div>
</div>

                      <br>
                      <div class="form-group">
                        <div class="col-md-6 col-sm-6 col-xs-12 col-md-offset-3">
                        <input id="annulla" name="annulla" class="btn btn-primary" tabindex="12" type="button" value="Annulla" onclick="javascript:window.location.href = 'index.php?page=gestioneUtenti&table=users'"/>
                        <input id="salva" name="salva" class="btn btn-success" tabindex="13" type="submit" value="Modifica" />
                        <input type="hidden" id="modificaUtente" name="modificaUtente" value="1" />
                        <input type="hidden" id="idUtente" name="idUtente" value="<?php echo $utente['id']; ?>" />
                        </div>
                      </div>

<div class="ln_solid"></div><br>
                </form>
            </div>
            
            <?php
        }
    }
    ?>
    <?php
    if (isset($_POST['azione']) && $_POST['azione'] == "disattiva") {
        if (isset($_POST['idUtente']) && !empty($_POST['idUtente'])) {
            $user_id = $_POST['idUtente'];

            $update_sql = "UPDATE `users` SET `active`='n' WHERE `id`='" . $user_id . "'";
            $funzioni_admin->user_update($update_sql);
            #var_dump($_POST);
        }
    }

    if (isset($_POST['azione']) && $_POST['azione'] == "erase") {
        if (isset($_POST['idUtente']) && !empty($_POST['idUtente']))
            $user_id = $_POST['idUtente'];

        if ($funzioni_admin->check_user_eraseble($user_id)) {

            $funzioni_admin->delete_name('users', $user_id);
            #var_dump($_POST);
        } else
            echo "<script type=\"text/javascript\">alert(\"Eliminazione non consentita! L'item è relazionato con dati presenti sul DB - \");</script>";
    }
    ?>
    <!--<div id="nascondi" style="float:left; height:300px; width:1px;"><img src="images/comprimi.gif" alt="n" title="Clicca qui per la visualizzazione estesa della pagina" onclick="nascondi();" width="11px"/></div>-->
    <div id="visualizza" style="display: none; float:left; height:300px; width:1px;"><img src="images/espandi.gif" alt="n" title="Clicca qui per la visualizzazione ridotta della pagina" onclick="visualizza();" width="11px"/></div>
    <div class="finestra" style="width:97%; min-height:400px; padding:5px;">

        <?php
        if (isset($stringa_risultato)) {
            echo "<div class=\"info\" style=\"margin-bottom: 20px;\">";
            echo "<h2 style=\"color: #ff0000\">" . $stringa_risultato . "</h2>";
            echo "</div><br />";
        }
        ?>
        <br>
    
        <table id="datatable-fixed-header" class="table table-striped table-bordered dataTable no-footer" role="grid" aria-describedby="datatable-fixed-header_info">
            <thead>
       
            <tr style="height:15px; font-weight: bold; background: url(images/wbg.gif) repeat-x 0px -1px;">
                <td align="center"  width="2$">N.</td>
                <td align="center" width="15%">Surname</td>
                <td align="center"  width="15%">Name</td>
                <td align="center"  width="15%">Login</td>
                <td align="center"  width="15%">email</td>
                <td align="center" width="15%">Ruolo</td>
                <td align="center"  width="20%">Squad</td>
                <td align="center"  width="15%">Status</td>
                <td align="center"  width="2%">Maillist</td>
                <td align="center"  colspan="2"  width="4%">
                    <form name="inserisciUtente" action="./index.php?page=register"  method="post" style="margin:0px;">
                        <input alt="Aggiungi Utente" title="Aggiungi nuovo utente" type="image" src="images/Inserisci.png" style="margin:0px"/>
                    </form>
                </td>
            </tr>
            </thead>

            <?php
#$table_name = 'campaign_groups';
            $user_list = $funzioni_admin->users_get_list_where($where = 'where `access_level`<=7');
            $riga = 0;
            foreach ($user_list as $key => $value) {
                if ($value['active'] == 'y') {
                    $stato = 'Attivo';
                    $style = '';
                    $azione_form = 'disattiva';
                    $title = 'title="Disattiva utente"';
                    $script = 'conferma';
                } elseif ($value['active'] == 'n') {
                    $stato = 'Disattivo';
                    $style = 'style="background-color: yellow"';
                    $azione_form = '"erase"';
                    $title = 'title="Elimina utente"';
                    $script = 'erase_user';
                } elseif ($value['active'] == 'b') {
                    $stato = 'Sospeso';
                    $style = 'style=\"background-color: yellow\"';
                    $azione_form = '"erase"';
                    $title = 'title="Elimina utente"';
                    $script = 'erase_user';
                }

                echo "<tr  style=\"height:25px;\" id=\"" . $riga++ . "\" onmouseover=\"seleziona(this);\"  onmouseout=\"deseleziona(this);\" ><td align=\"center\">$riga</td>";
                echo "<td>" . $value['lastname'] . "</td>";
                echo "<td>" . $value['firstname'] . "</td>";              
                echo "<td>" . $value['login'] . "</td>";
                echo "<td>" . $value['email'] . "</td>";
                echo "<td>" . $value['ruolo'] . "</td>";
                echo "<td>" . $value['dipartimento'] . "</td>";
                echo "<td $style>" . $stato . "</td>";
                if($value['maillist']==1){
                    $testo="X";
                    $stile="style=\"    background-color: cyan;text-align: center;\"";
                }
                else{
                    $testo="";
                    $stile="style=\"\"";
                }
                
                echo "<td $stile >" . $testo . "</td>";
                //echo "<td>" . $value['leggi'] . "</td>";
                //echo "<td>" . $value['inserisci'] . "</td>";
                //echo "<td>".$value['modifica']."</td>";
                //echo "<td>" . $value['cancella'] . "</td>";
                echo"<td align=\"center\"><form name=\"modificaUtente0\" id=\"modificaUtente0\" action=\"./index.php?page=gestioneUtenti&function=updateUser\" method=\"post\" style=\"margin:0px;\">
                               <input alt=\"Modifica\" title=\"Modifica utente\" type=\"image\" src=\"images/Modifica.png\" /> 
                               <input type=\"hidden\"  name=\"idUtente\" value=\"" . $value['id'] . "\" /> 
                          </form>
                    </td>
                    <td align=\"center\">
                          <form name=\"eliminaUtente0\" id=\"eliminaUtente0\" action=\"./index.php?page=gestioneUtenti\" onsubmit=\"return $script('" . $value['login'] . "')\" method=\"post\" style=\"margin:0px;\">
                               <input type=\"image\"  $title  src=\"images/Elimina.png\" value=\"Elimina\" />
                               <input type=\"hidden\"  name=\"azione\" value=$azione_form />
                               <input type=\"hidden\"  name=\"idUtente\" value=\"" . $value['id'] . "\" /> 
                          </form>
                    </td>
                </tr>";
            }
            ?>
        </table>
    </div>
</div><!-- end .content -->
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

