<?php
#include("./classes/access_user/access_user_class.php"); 
include_once 'funzioni_admin.php';


$funzioni_admin = new funzioni_admin();
$new_member = new Access_user;


if (isset($_POST['submit']) && $_POST['azione'] == "aggiungi") {
    #var_dump($_POST);
    $inserisci = isset($_POST['inserisci']) ? $_POST['inserisci'] : 'No';
    $modifica = isset($_POST['modifica']) ? $_POST['modifica'] : 'No';
    $cancella = isset($_POST['cancella']) ? $_POST['cancella'] : 'No';

    $levello_accesso = $funzioni_admin->access_level($inserisci, $modifica, $cancella);

    if (empty(trim($_POST['selectDipartimento'])))
        echo '<script type="text/javascript">errore("Attenzione scegliere il Dipartimento!!");</script>';

    $name = trim($_POST['nome']);
    $cognome = trim($_POST['cognome']);


    if (isset($_POST['maillist']))
        $maillist = intval($_POST['maillist']);
    else
        $maillist = 0;

    $new_member->register_newuser($_POST['login'], $_POST['password'], $_POST['confirm'], $cognome, $_POST['email'], $name, $_POST['selectRuolo'], $_POST['selectDipartimento'], $_POST['selectStato'], $inserisci, $modifica, $cancella, $levello_accesso, $maillist);
}
$error = $new_member->the_msg; // error message
?>



<script language="JavaScript" type="text/javascript">
<!--  
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
        campoSelezionato.style.background = "orange";
    }

    function deseleziona_campo(campo) {
        campoSelezionato = document.getElementById(campo);
        campoSelezionato.style.background = "white";
    }
-->
</script>
<div class="content">
    <div class="finestra" style="width:50%;  padding:5px;">
        <div class="wufoo">
            <div class="info">
                <h2>Registrazione nuovo Utente</h2>
                <div></div>
            </div>
        </div>

        <p style="color:#FF0000;font-weight:bold;"><br><b><?php echo (isset($error)) ? $error : "&nbsp;"; ?></b></p>

        <p>&nbsp;</p>
        <?php
        if (!isset($_POST['submit'])) {
            ?>
            <form name="form1" method="post" action="index.php?page=register">

                <div class="left" style="margin:10px; min-height:100px; width:90%;">
                    <label class="intestazione"  id="datianagrafici">Dati anagrafici:

                    </label>
                    <span class="" style="margin-top:10px; display:block;">
                        <label>Cognome</label>
                        <input id="cognome" name="cognome" type="text" class="text" value="<?php echo (isset($_POST['cognome'])) ? $_POST['cognome'] : ""; ?>" tabindex="2" onfocus="seleziona_campo('cognome');" onblur="deseleziona_campo('cognome');"/>

                    </span>
                    <span class="" style="margin-top:10px; display:block;">
                        <label>Nome</label>
                        <input id="nome" name="nome" type="text" class="text" value="<?php echo (isset($_POST['nome'])) ? $_POST['nome'] : ""; ?>" tabindex="3" onfocus="seleziona_campo('nome');" onblur="deseleziona_campo('nome');"/>

                    </span>
                </div>    


                <div class="left" style="margin:10px; width:40%; min-height:120px;">
                    <label class="intestazione"  id="datiaccesso">Dati d'accesso:
                        <span id="req_2" class="req">*</span>
                    </label>
                    <span class="" style="margin-top:10px; display:block;">
                        <label>Username</label>
                        <input id="login" type="text" name="login" class="text"  value="<?php echo (isset($_POST['login'])) ? $_POST['login'] : ""; ?>" onfocus="seleziona_campo('login');" onblur="deseleziona_campo('login');"/>
                        <span id="req_1" class="req">* </span>(min. 6 chars.) <br>

                    </span>
                    <span class="" style="margin-top:10px; display:block;">

                        <label>Password</label>

                        <input id="password" type="password" name="password" class="text"  value="<?php echo (isset($_POST['password'])) ? $_POST['password'] : ""; ?>" onfocus="seleziona_campo('password');" onblur="deseleziona_campo('password');"/>
                        <span id="req_1" class="req">* </span>(min. 4 chars.) <br>
                    </span>
                    <span class="" style="margin-top:10px; display:block;">
                        <label>Conferma Password</label>
                        <input id="confirm" type="password" name="confirm" class="text" value="<?php echo (isset($_POST['confirm'])) ? $_POST['confirm'] : ""; ?>" onfocus="seleziona_campo('confirm');" onblur="deseleziona_campo('confirm');"/>
                        <span id="req_1" class="req">* </span><br>
                    </span>
                    <span class="" style="margin-top:10px; display:block;">
                        <label>E-mail</label>
                        <input id="email" type="text" name="email" class="text"  size="25" value="<?php echo (isset($_POST['email'])) ? $_POST['email'] : ""; ?>" onfocus="seleziona_campo('email');" onblur="deseleziona_campo('email');">
                        <span id="req_1" class="req">* </span><br>
                    </span>
                    <br>
                    <span class="" style="margin-top:10px; display:block;">
                        <label>Maillist</label>
                        <input id="maillist" name="maillist" type="checkbox" value="1"   tabindex="8" /></span>
                </div>
                <div class="left" style="margin-left: 10px; margin:10px; width:40%; min-height:120px;">
                    <label class="intestazione" style=""  id="ruolo">Ruolo:
                        <span id="req_3" class="req">*</span>
                    </label>

                    <select id="selectRuolo" name="selectRuolo" style="margin-top:10px;" tabindex="6" onfocus="seleziona_campo('selectRuolo');" onblur="deseleziona_campo('selectRuolo');"/>    
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
                    <label class="intestazione" style="margin-top:10px;"  id="stato">Stato:
                        <span id="req_4" class="req">*</span>
                    </label>


                    <select id="selectStato" name="selectStato" style="margin-top:10px;" tabindex="7" onfocus="seleziona_campo('selectStato');" onblur="deseleziona_campo('selectStato');"/>      
                    <option  selected="selected" value="n" >Disattivo</option>
                    <option   value="y">Attivo</option>  
                    <option  value="b" >Sospeso</option>
                    </select>



                    <label class="intestazione" style="margin-top:10px;"  id="dipartimento">Dipartimento:
                        <span id="req_4" class="req">*</span>
                    </label>
                    <select id="selectDipartimento" name="selectDipartimento" style="margin-top:10px;" tabindex="6" onfocus="seleziona_campo('selectDipartimento');" onblur="deseleziona_campo('selectDipartimento');"/>

    <?php
    $dep = $funzioni_admin->get_list_id("departments");
    foreach ($dep as $key => $value) {
        echo"<option  value=\"" . $value['id'] . "\" >" . $value['name'] . "</option>";
    }
    ?>
                    </select>
                </div>

                <div class="left" style="margin-top: 30px; margin-left: 40%;  text-align:center;"> 
                    <input id="annulla" name="annulla"  tabindex="12" type="button" value="Annulla" onclick="javascript:window.location.href = ''"/>
                    <input id="submit" name="submit"  tabindex="13" type="submit" value="Submit" />
                    <input type="hidden" id="modificaUtente" name="azione" value="aggiungi" />
                </div>
                <div>
                    <label class="" id="campoObbligatorio">
                        <a href="<?php $_SERVER['PHP_SELF'] ?>">Insert New</a>
                    </label>
                </div>     

                <div style="text-align: right;">
                    <label class="" id="campoObbligatorio">
                        <span id="req_5" class="req">*</span>
                        Campo obbligatorio
                    </label>
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
