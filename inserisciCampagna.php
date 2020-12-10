<?php
print_r($_SESSION);

print_r($_POST);
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';

include_once './classes/form_class.php';

$form = new form_class();
$funzione = new funzioni_admin();
$funzioni_admin = new funzioni_admin();
include_once("./classes/access_user/access_user_class.php");
$page_protect = new Access_user;
$page_protect->get_user_info();
$campaign = new campaign_class();

$messaggio = "";
$disabled_value = "";
$modifica = false;
$action_duplica = false;
$modifica_stato = false;
$modifica_codici = false;
$display_none = "";
$load = "";
$readonly = false;
$readonly_value = "";
$visualizza_campagna = 0;
$back_url = "";
if ($page_protect->check_top_user($page_protect->get_squad())) {
    $back_url = "./index.php?page=pianificazione";
} else {
    $back_url = "./index.php?page=gestioneCampagne";
}

$idCampagna = "";
if (isset($_POST['modifica'])) {
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
    
    $modifica = true;
    $squad_id = $id_campaign['squad_id'];
    if ($page_protect->get_job_role() > 2) {
        $modifica_codici = true;
    }
    $permission = $page_protect->check_permission($squad_id);

    if ($permission) {
        
        if (isset($_POST['modifica_confim'])) {
            $messaggio = $campaign->update($_POST, $_POST['id']);
        }
    } else {
        $messaggio = "L'utente non pu&ograve; modificare la campagna";
        $visualizza_campagna = 1;
        $modifica = true;
        $readonly = true;
        $readonly_value = " readonly=\"readonly\" ";
        $disabled_value = " disabled=\"disabled\"  ";
        $display_none = " display:none; ";
    }
} elseif (isset($_POST['idCampagna'])) {
    $idCampagna = intval($_POST['idCampagna']);
    $visualizza_campagna = 1;
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . $idCampagna)->fetch_array();
    $modifica = true;
    $readonly = true;
    $readonly_value = " readonly=\"readonly\" ";
    $disabled_value = " disabled=\"disabled\"  ";
    $display_none = " display:none; ";
} elseif (isset($_POST['duplica'])) {
    //echo'<---QUI-->';
    $id_campaign = $campaign->get_list_campaign(" where campaigns.id=" . intval($_POST['id']))->fetch_array();
    // print_r($id_campaign);
    $action_duplica = true;
    $modifica = true;
    $squad_id = $id_campaign['squad_id'];
    if ($page_protect->get_job_role() > 2) {
        $modifica_codici = true;
    }
    $permission = $page_protect->check_permission($squad_id);

    if ($permission) {
        if (isset($_POST['modifica_confim'])) {
            $messaggio = $campaign->update($_POST, $_POST['id']);
        }
    } else {
        $messaggio = "L'utente non pu&ograve; modificare la campagna";
        $visualizza_campagna = 1;
        $modifica = true;
        $readonly = true;
        $readonly_value = " readonly=\"readonly\" ";
        $disabled_value = " disabled=\"disabled\"  ";
        $display_none = " display:none; ";
    }
}
//echo'POST-->';
$random=  rand();


?>

<script type="text/javascript" src="javascript_controlla_form_insert.js<?php echo "?".$random; ?>"></script>
<script type="text/javascript" src="validaTesto.js<?php echo "?".$random; ?>"></script>
<script type="text/javascript">
    var stack_label = "_";
    var channel_label = "_";
    var type_label = "_";
    var offer_label = "_";
    var segment_label = "_";
    var data_label = "";
    
    $(document).ready(function () {

        if (document.getElementById('pref_nome_campagna').value.length > 0) {
            var pref_nome_campagna = document.getElementById('pref_nome_campagna').value;
            var myarr = pref_nome_campagna.split("_");
            //if (myarr[0].value.length > 0)
            data_label = myarr[0];
            //if (myarr[1].value.length > 0)
            channel_label = "_" + myarr[1];
            //if (myarr[2].value.length > 0)
            type_label = "_" + myarr[2];
            if (typeof myarr[3] !== 'undefined')
                offer_label = "_" + myarr[3];
            else
                offer_label = "_";
            //offer_label = document.getElementById('offer_description').value
            if (typeof myarr[4] !== 'undefined')
                segment_label = "_" + myarr[4];
            //alert(offer_label);
            else
                segment_label = "_";
        }
        $("form input").bind("keypress", function (e) {
            return e.keyCode !== 13;
        });
<?php
$lista = "var lista = [";
foreach ($campaign->lista_rules as $key => $value) {
    $lista = $lista . "'" . $value . "',";
}
echo substr($lista, 0, -1) . '];';

?>
        $("select#stack_id").change(function () {
            
            $.getJSON("selectStack.php", {id: $(this).val()}, function (dati) {
                document.getElementById('type_id').innerHTML = "";
                select = document.getElementById('type_id');
                for (var i = 0; i < dati.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = dati[i].valore;
                    opt.innerHTML = dati[i].etichetta;
                    select.appendChild(opt);
                }
                $('#type_id option:first').attr('selected', 'selected');
            });
        });
        $("select#channel_id").change(function () {
            $.getJSON("get_label.php", {channel_id: $(this).val()}, function (dati) {
                channel_label = "_" + dati[0].etichetta;
                document.getElementById('pref_nome_campagna').value = data_label + channel_label + type_label + offer_label + segment_label;
            });
        })
        $("select#type_id").change(function () {
            $.getJSON("get_rules.php", {type_id: $(this).val(), stack_id: (document.getElementById("stack_id").value)}, function (dati) {
                var etichetta;
                var valore;
                for (var i = 0; i < dati.length; i++) {
                    etichetta = dati[i].etichetta;
                    valore = dati[i].valore;
                    for (var k = 0; k < lista.length; k++) {
                        if (etichetta == lista[k]) {
                            var nome = lista[k];
                            if (valore == "1")
                                $("#" + nome).attr("checked", true);
                        }
                    }
                }
                document.getElementById('attivi').innerHTML = "";
            });
            $.getJSON("get_label.php", {type_id: $(this).val()}, function (dati) {
                type_label = "_" + dati[0].etichetta;
                document.getElementById('pref_nome_campagna').value = data_label + channel_label + type_label + offer_label + segment_label;
            });
        });
        $("input#offer_search").change(function () {
            document.getElementById("span_offer_list").style.display = "inline";
            $.getJSON("get_offer_name.php", {offer_name: $(this).val()}, function (dati) {

                document.getElementById('offer_id').innerHTML = "";
                select = document.getElementById('offer_id');
                document.getElementById('offer_id').size = 5;
                if (dati.length > 0) {
                    for (var i = 0; i < dati.length; i++) {
                        var opt = document.createElement('option');
                        opt.value = dati[i].id;
                        opt.innerHTML = dati[i].name;
                        select.appendChild(opt);
                    }
                    $('#offer_id option:first').attr('selected', 'selected');
                }
            });
        });
        $("select#offer_id").change(function () {
            document.getElementById("span_offer_description").style.display = "inline";
            document.getElementById("span_stringa_CCM").style.display = "inline";
            $.getJSON("get_offer_name.php", {id: $(this).val()}, function (dati) {

                //description = document.getElementById("offer_id").value;
                if (dati.length > 0) {
                    document.getElementById('offer_description').value = dati[0].description;
                    offer_label = "_" + dati[0].label;
                    stringa_ccm = dati[0].name;
                    document.getElementById('stringa_ccm').value = stringa_ccm;
                    document.getElementById('pref_nome_campagna').value = data_label + channel_label + type_label + offer_label + segment_label;
                } else {
                    document.getElementById('offer_description').value = '';
                }

            });
        });
        $("select#leva").change(function () {

            if (document.getElementById('leva').value === '0') {
                offer_label = "";
                document.getElementById('offer_search').value = "";
                $("#offer_id").empty();

                document.getElementById('offer_description').value = "";
                document.getElementById('stringa_ccm').value = "";
                document.getElementById('pref_nome_campagna').value = data_label + channel_label + type_label + offer_label + segment_label;
            }


        });
        $("select#channel_id").change(function () {
            $.getJSON("selectSender.php", {id: $(this).val()}, function (dati) {
                document.getElementById('sender_id').innerHTML = "";
                select = document.getElementById('sender_id');
                for (var i = 0; i < dati.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = dati[i].valore;
                    opt.innerHTML = dati[i].etichetta;
                    select.appendChild(opt);
                }
                $('#sender_id option:first').attr('selected', 'selected');
            });
        });
<?php
$segment_list = $funzioni_admin->get_segment_list();
foreach ($segment_list as $key => $value) {
    echo "$(\"input#" . $value['id'] . "_key\").change(function () {";

    echo "$.getJSON(\"get_segment_name.php\", {id: $(this).val()}, function (dati) {
        if (offer_label.length = 0) {
        offer_label=\"_\";
}
if (dati . length > 0) {
    segment_label = \"_\" + dati[0].label;
                document.getElementById('pref_nome_campagna').value = data_label + channel_label + type_label + offer_label + segment_label;
        }";
    echo "});";
    echo "});";
}
?>
    });
    $(window).load(function () {
        visualizza('Campagna');
<?php
if ($modifica_codici) {
    ?>
            document.getElementById("span_cod_comunicazione").style.display = "inline";
            document.getElementById("span_cod_campagna").style.display = "inline";
    <?php
}
if ($modifica) {
    ?>
            checklength(0, 640, 'testo_sms', 'charTesto', 'numero_sms');
            checklength(0, 1000, 'descrizione_leva', 'charLeva', '');
            leva_check();
            controlStack();
            trial_check_load();
            interattivo();
            tipo();
            volume_tot();
            document.getElementById("span_state").style.display = "inline";
            document.getElementById("span_ottimizzazione").style.display = "inline";
            var selectStack = document.getElementById("stack_id").value;
            $.getJSON("selectStack.php", {id: (document.getElementById("stack_id").value)}, function (dati) {
                document.getElementById('type_id').innerHTML = "";
                select = document.getElementById('type_id');
                for (var i = 0; i < dati.length; i++) {
                    var opt = document.createElement('option');
                    opt.value = dati[i].valore;
                    if (dati[i].valore ==<?php echo $id_campaign['type_id']; ?>) {
                        temp = i;
                    }
                    opt.innerHTML = dati[i].etichetta;
                    select.appendChild(opt);
                }
                $("#type_id")[0].selectedIndex = temp;
            });
            var temp;
    <?php
    if ($id_campaign['channel_id'] != NULL) {
        if (($id_campaign['channel_id'] == $funzioni_admin->get_nome_campo("channels", "ext_1", "1", "id")) 
                || ($id_campaign['channel_id'] == $funzioni_admin->get_nome_campo("channels", "ext_2", "1", "id"))
                || ($id_campaign['channel_id'] == $funzioni_admin->get_nome_campo("channels", "ext_1", "12", "id"))
                
                ) {
            ?>
                    $.getJSON("selectSender.php", {id: (document.getElementById("channel_id").value)}, function (dati) {
                        document.getElementById('sender_id').innerHTML = "";
                        select = document.getElementById('sender_id');
                        for (var i = 0; i < dati.length; i++) {
                            var opt = document.createElement('option');
                            opt.value = dati[i].valore;
                            if (dati[i].valore ==<?php echo $id_campaign['sender_id']; ?>) {
                                temp = i;
                            }
                            opt.innerHTML = dati[i].etichetta;
                            select.appendChild(opt);
                        }
                        $("#sender_id")[0].selectedIndex = temp;
                    });
            <?php
        }
    }
}
?>

    });
    function tipo() {

        var selected_canale = channel_id.options[channel_id.selectedIndex].value;
        document.getElementById("spansender_id").style.display = "none";
        document.getElementById("spanmod_invio").style.display = "none";
        document.getElementById("spantesto_sms").style.display = "none";
        document.getElementById("spanLabelLinkTesto").style.display = "none";
        document.getElementById("spansms_duration").style.display = "none";
        document.getElementById("spanTipoMonitoring").style.display = "none";
        document.getElementById("spanmod_invio").style.display = "none";
        document.getElementById("spanStoricizza").style.display = "none";
        //alert(selected_canale);
<?php
$lista_ext1 = $campaign->get_channel_ext1();
//print_r($lista_ext1);
if ($lista_ext1) {
    foreach ($lista_ext1 as $key => $value) {
        ?>
                if (selected_canale == "<?php echo $value; ?>") {
                    document.getElementById("spansender_id").style.display = "inline";
                    document.getElementById("spanmod_invio").style.display = "inline";
                    document.getElementById("spantesto_sms").style.display = "inline";
                    document.getElementById("spanLabelLinkTesto").style.display = "inline";
                    document.getElementById("spansms_duration").style.display = "inline";
                    document.getElementById("spanTipoMonitoring").style.display = "inline";
                    document.getElementById("spanmod_invio").style.display = "inline";
                    document.getElementById("spanStoricizza").style.display = "inline";
                }
                if (selected_canale == 12) {
                    document.getElementById("spansender_id").style.display = "inline";
                    document.getElementById("spanmod_invio").style.display = "inline";
                    document.getElementById("spantesto_sms").style.display = "inline";
                    document.getElementById("spanLabelLinkTesto").style.display = "inline";
                    document.getElementById("spansms_duration").style.display = "inline";
                    document.getElementById("spanTipoMonitoring").style.display = "inline";
                    document.getElementById("spanmod_invio").style.display = "inline";
                    document.getElementById("spanStoricizza").style.display = "inline";
                }
        <?php
    }
}
$lista_ext2 = $campaign->get_channel_ext2();
if ($lista_ext2) {
    foreach ($lista_ext2 as $key => $value) {
        ?>
                if (selected_canale == "<?php echo $value; ?>") {
                    document.getElementById("spansender_id").style.display = "inline";
                }
        <?php
    }
}
?>

    }


    function controllaform() {
        var Errore = 'Attenzione non hai compilato tutti i campi obbligatori:\n\n';
        durata = document.getElementById('durata_campagna').value;
        volumeTotale = document.getElementById('volume').value;
        volumeTrial = document.getElementById('volume_trial').value;
        somma = 0;
        for (i = 1; i <= durata; i++) {
            somma = parseInt(somma) + parseInt(document.getElementById('volumeGiornaliero' + i).value);
        }
        somma = somma + parseInt(volumeTrial);
//Se check trial e campo trial valorizzato controllo se è selezionato sabato o domenica
        if ((document.getElementById('trial_campagna').checked) && (document.getElementById('data_trial').value != "")) {
            s = document.getElementById('data_trial').value;
            c = s.split("/");
            data = new Date(c[2], c[1] - 1, c[0]);
            giorno = data.getDay();
            if (giorno == 6) {
                alert('Attenzione: hai pianificato il trial di sabato');
                return false;
            }
            if (giorno == 0) {
                alert('Attenzione: hai pianificato il trial di domenica');
                return false;
            }
        }

//Se data inizio è valorizzato controllo se è selezionato domenica
        if (document.getElementById('data_inizio').value != "")
        {

            s = document.getElementById('data_inizio').value;
            c = s.split("/");
            data = new Date(c[2], c[1] - 1, c[0]);
            giorno = data.getDay();
            if (giorno == 0) {
                alert('Attenzione: hai pianificato la campagna di domenica');
                return false;
            }
        }


//Se check escludi sabato e campo data inizio valorizzato controllo se è selezionato sabato
        if ((document.getElementById('escludi_sabato').checked) && (document.getElementById('data_inizio').value != "")) {
            s = document.getElementById('data_inizio').value;
            c = s.split("/");
            data = new Date(c[2], c[1] - 1, c[0]);
            giorno = data.getDay();
            if (giorno == 6) {
                alert('Attenzione: hai pianificato la campagna di sabato');
                return false;
            }
        }

        if ((document.getElementById('trial_campagna').checked) && (document.getElementById('data_trial').value != "") && (document.getElementById('data_inizio').value != "")) {
            ctlDate = ctrlDate(document.getElementById('data_trial').value, document.getElementById('data_inizio').value);
            if (ctlDate)
            {
                alert('Attenzione: Data inizio campagna antecedente quella del trial');
                return false;
            }
            else
            {
                data1 = document.getElementById('data_trial').value;
                data2 = document.getElementById('data_inizio').value;
                anno1 = parseInt(data1.substr(6), 10);
                mese1 = parseInt(data1.substr(3, 2), 10);
                giorno1 = parseInt(data1.substr(0, 2), 10);
                anno2 = parseInt(data2.substr(6), 10);
                mese2 = parseInt(data2.substr(3, 2), 10);
                giorno2 = parseInt(data2.substr(0, 2), 10);
                var dataok1 = new Date(anno1, mese1 - 1, giorno1);
                var dataok2 = new Date(anno2, mese2 - 1, giorno2);
                differenza = dataok2 - dataok1;
                giorni_differenza = new String(Math.floor(differenza / 86400000));
                s = document.getElementById('data_trial').value;
                c = s.split("/");
                data = new Date(c[2], c[1] - 1, c[0]);
                giorno = data.getDay();
                if ((giorno == 5) && (giorni_differenza == 4))
                {
                    alert('Attenzione: La data di inizio della campagna deve essere dopo almeno 2 giorni lavorativi la data di trial');
                    return false;
                }

                if (giorni_differenza < 2)
                {
                    alert('Attenzione: La data di inizio della campagna deve essere dopo almeno 2 giorni lavorativi la data di trial');
                    return false;
                }
            }

        }

        if (somma != volumeTotale) {
            alert('Attenzione il volume totale non coincide con la somma dei volumi giornalieri.');
            return false;
        } else {
            /* if (document.getElementById('nome_campagna').value == "") {
             Errore = Errore + "- Nome campagna\n";
             }
             if (document.getElementById('nome_campagna').value.length > 60) {
             Errore = Errore + "- Nome campagna troppo lungo" + document.getElementById('nome_campagna').value.length + " caratteri. Utilizzare massimo 60 caratteri\n";
             }*/
            if ((document.getElementById('nome_campagna').value.length + document.getElementById('pref_nome_campagna').value.length) > 40) {
                Errore = Errore + "- Nome campagna troppo lungo" + document.getElementById('nome_campagna').value.length + " caratteri. Utilizzare massimo 20 digit per le note\n";
            }
            if (document.getElementById('stack_id').value == "0") {
                Errore = Errore + "- Stack campagna\n";
            }
            if (document.getElementById('type_id').value == "") {
                Errore = Errore + "- Tipo campagna\n";
            }
            if (document.getElementById('priority').value == "0") {
                Errore = Errore + "- Priorit&agrave; PM\n";
            }
            if (document.getElementById('squad_id').value == "") {
                Errore = Errore + "- Dipartimento\n";
            }
            if (document.getElementById('leva').value == "") {
                Errore = Errore + "- Leva/offerta\n";
            }
            if (document.getElementById('leva').value == "1") {
                if (document.getElementById('data_inizio_validita_offerta').value == "") {
                    Errore = Errore + "- Data inizio offerta\n";
                }
                if (document.getElementById('data_fine_validita_offerta').value == "") {
                    Errore = Errore + "- Data fine offerta\n";
                }

                if ((document.getElementById('data_inizio_validita_offerta').value != "") && (document.getElementById('data_fine_validita_offerta').value != "")) {
                    ctlDate = ctrlDate(document.getElementById('data_inizio_validita_offerta').value, document.getElementById('data_fine_validita_offerta').value);
                    if (ctlDate) {
                        Errore = Errore + "- Data fine offerta antecedente la data di inizio offerta\n";
                    }
                    ctlDate = ctrlDate(document.getElementById('data_inizio_validita_offerta').value, document.getElementById('data_inizio').value);
                    if (ctlDate) {
                        Errore = Errore + "- Data di inizio offerta successiva a data inizio comunicazione \n";
                    }
                }
                if (document.getElementById('offer_description').value == "") {
                    Errore = Errore + "- Descrizione leva/offerta\n";
                }
            }

            if ((!(document.getElementById('attivi').checked)) && (!(document.getElementById('sospesi').checked))) {
                Errore = Errore + "- Seleziona almeno uno stato\n";
            }
            if ((!(document.getElementById('consumer').checked)) && (!(document.getElementById('business').checked))) {
                Errore = Errore + "- Seleziona almeno un tipo di offerta\n";
            }
            if ((!(document.getElementById('prepagato').checked)) && (!(document.getElementById('postpagato').checked))) {
                Errore = Errore + "- Seleziona almeno un tipo di contratto\n";
            }
            if ((!(document.getElementById('voce').checked)) && (!(document.getElementById('dati').checked))) {
                Errore = Errore + "- Seleziona almeno un tipo di piano\n";
            }
            if ((!(document.getElementById('etf').checked)) && (!(document.getElementById('vip').checked)) && (!(document.getElementById('dipendenti').checked)) && (!(document.getElementById('trial').checked))) {
                Errore = Errore + "- Seleziona almeno un ruolo\n";
            }
            if (document.getElementById('altri_criteri').value == "") {
                Errore = Errore + "- Altri criteri\n";
            }


            if (document.getElementById('control_stack').value == "") {
                Errore = Errore + "- Control stack\n";
            }
            if (document.getElementById('control_stack').value == "1") {
                if ((document.getElementById('perc_control_group').value == "") || (document.getElementById('perc_control_group').value == "0")) {
                    Errore = Errore + "- Percentuale control stack\n";
                }
            }


            if ((document.getElementById('trial_campagna').checked)) {
                if (document.getElementById('data_trial').value == "") {
                    Errore = Errore + "- Data trial\n";
                }
                if (document.getElementById('volume_trial').value == "0") {
                    Errore = Errore + "- Volume trial\n";
                }
            }
            if (document.getElementById('data_inizio').value == "") {
                Errore = Errore + "- Data inizio comunicazione\n";
            }
            if (document.getElementById('durata_campagna').value == "") {
                Errore = Errore + "- Durata\n";
            }
            if (document.getElementById('perc_scostamento').value == "") {
                Errore = Errore + "- Percentuale scostamento atteso\n";
            }
            if ((document.getElementById('volume').value == "") || (document.getElementById('volume').value == "0")) {
                Errore = Errore + "- Volume totale stimato\n";
            }

            for (i = 1; i <= durata; i++) {
                if (document.getElementById('volumeGiornaliero' + i).value == "") {
                    Errore = Errore + "- Volume giornaliero " + i + "\n";
                }
            }

            if (document.getElementById('caricamento_massivo').value == "") {
                Errore = Errore + "- Caricamento massivo\n";
            }

            if (document.getElementById('channel_id').value == "") {
                Errore = Errore + "- Canale\n";
            }
<?php
$lista_ext1 = $campaign->get_channel_ext1();
if ($lista_ext1) {
    foreach ($lista_ext1 as $key => $value) {
        ?>
                    if (document.getElementById('channel_id').value == "<?php echo $value; ?>") {
                        if (document.getElementById('sender_id').value == "") {
                            Errore = Errore + "- Sender\n";
                        }
                        if ((document.getElementById('sms_duration').value > 8) && (document.getElementById('sms_duration').value == 0)) {
                            Errore = Errore + "Durata sms non corretta\n";
                        }
                        if (document.getElementById('mod_invio').value == "") {
                            Errore = Errore + "- Mod invio\n";
                        }
                        if (document.getElementById('storicizza').value == "") {
                            Errore = Errore + "- storicizza\n";
                        }
                        if (document.getElementById('testo_sms').value == "") {
                            Errore = Errore + "- testo sms\n";
                        }
                        if ((document.getElementById('testo_sms').value != "") && (!validaTesto())) {
                            Errore = Errore + "- Il campo testo sms contiene caratteri non consentiti\n";
                        }
                        if (document.getElementById('sms_duration').value == "") {
                            Errore = Errore + "- Durata SMS\n";
                        }

                        if (document.getElementById('mod_invio').value == "Interattivo") {
                            if (document.getElementById('link').value == "") {
                                Errore = Errore + "- Link\n";
                            }
                            if (document.getElementById('tipoMonitoring').value == "") {
                                Errore = Errore + "- Tipo Monitoring\n";
                            }
                        }

                    }
        <?php
    }
}
$lista_ext2 = $campaign->get_channel_ext2();
if ($lista_ext2) {
    foreach ($lista_ext2 as $key => $value) {
        ?>
                    if (document.getElementById('channel_id').value == "<?php echo $value; ?>") {
                        if (document.getElementById('sender_id').value == "") {
                            Errore = Errore + "- Sender\n";
                        }
                    }
        <?php
    }
}
?>
            if ((document.getElementById('trial_campagna').checked)) {
                if (document.getElementById('data_trial').value == "") {
                    Errore = Errore + "- Data trial\n";
                }
                if (document.getElementById('volume_trial').value == "0") {
                    Errore = Errore + "- Volume trial\n";
                }
            }
            if (document.getElementById('data_inizio').value == "") {
                Errore = Errore + "- Data inizio comunicazione\n";
            }
            if (document.getElementById('durata_campagna').value == "") {
                Errore = Errore + "- Durata\n";
            }
            if (document.getElementById('perc_scostamento').value == "") {
                Errore = Errore + "- Percentuale scostamento atteso\n";
            }
            if ((document.getElementById('volume').value == "") || (document.getElementById('volume').value == "0")) {
                Errore = Errore + "- Volume totale stimato\n";
            }

            for (i = 1; i <= durata; i++) {

                if (document.getElementById('volumeGiornaliero' + i).value == "") {
                    Errore = Errore + "- Volume giornaliero " + i + "\n";
                }

            }
            if (Errore == "Attenzione non hai compilato tutti i campi obbligatori:\n\n") {
                if (!(confirm('Confermi?'))) {
                    return false;
                } else {
                    return true;
                }
            }
            else {
                alert(Errore);
                return false;
            }
        }

    }
</script> 
                <?php
                $string = '';
                //print_r($id_campaign);               
                if (isset($_POST['modifica'])) {
                     "<h2>Modifica Campagna</h2>";
                    echo "<p>" . substr(stripslashes($id_campaign['pref_nome_campagna']), 0);
                    if (strlen(trim($id_campaign['nome_campagna'])) > 0)
                        echo "_" . substr(stripslashes($id_campaign['nome_campagna']), 0);
                    echo "</p>";
                } else {

                    if (isset($id_campaign)) {
                        echo "<h2>Campagna:</h2>";
                        echo "<p>" . substr(stripslashes($id_campaign['pref_nome_campagna']), 0);
                        if (strlen(trim($id_campaign['nome_campagna'])) > 0)
                            echo "_" . substr(stripslashes($id_campaign['nome_campagna']), 0);
                        echo "</p>";
                    }else {
                        echo "<h2>Inserisci Campagna</h2>";
                    }
                }
                ?>
<?php $form->head_page("Gestione Campagne", "Inserisci nuova campagna"); ?>
<div class="content">
    <div class="finestra" style="width:95%; min-height:350px; padding:5px;">
        <div class="wufoo">
            <div class="info">


                <div></div>
            </div>
        </div>
        <?php
        if ($messaggio != "") {
            ?>
            <div class="wufoo">
                <div class="info">
                    <h2 style="color: #ff0000"><?php echo $messaggio; ?></h2>
                    <div></div>
                </div>
            </div>
            <?php
        }
        if ($visualizza_campagna) {
            $elimina = "";
            $stato_elimina = $id_campaign['elimina'];
            $squad_id = $id_campaign['squad_id'];
            $squad_id = $page_protect->get_squad();
            $permission = $page_protect->check_permission($squad_id);
            $elimina = "<form name=\"eliminaCampagna\" style=\"float:left;margin-right:2px;\"  id=\"eliminaCampagna0\" action=\"./index.php?page=gestioneCampagne\" "
                    . "onsubmit=\"return  conferma(" . $stato_elimina . "," . $permission . ")\" method=\"post\" style=\"margin:0px;\">
                <input type=\"image\" alt=\"Elimina\" title=\"Elimina la campagna\" name=\"elimina\"  style=\"height:30px;\" src=\"images/Elimina.png\" value=\"elimina\" />
                <input type=\"hidden\" id=\"id\" name=\"id\" value=\"" . $idCampagna . "\" />";
            $elimina = $elimina . "</form>";
            
            $modifica = "<form action=\"./index.php?page=inserisciCampagna\" onsubmit=\"return modifica($permission);\" method=\"post\"
      style=\"float:left;margin-right:2px;\">
        <input type=\"image\" alt=\"Modifica\" title=\"Modifica la campagna\" src=\"images/Modifica.png\"  style=\"height:30px;\"  />      
<input type=\"hidden\" value=\"modifica\" name=\"modifica\">
        <input type=\"hidden\" name=\"id\" value=\"" . $idCampagna . "\" /></form>";
            
            $duplica = "<form action=\"./index.php?page=inserisciCampagna\" onsubmit=\"return duplica($permission);\" method=\"post\"
      style=\"float:left;margin-right:2px;\">
        <input type=\"image\" name=\"duplica\" alt=\"Duplica\" title=\"Duplica la campagna\" src=\"images/duplica.gif\"  style=\"height:30px;\"  value=\"duplica\" />
        <input type=\"hidden\" name=\"id\" value=\"" . $idCampagna . "\" /></form>";
            ?>
            <div style="margin-left:0px; height:40px; margin-bottom:10px; margin-top:10px;">
                <div style="float:left; margin-left:0px; margin-right:5px; margin-bottom:10px; margin-top:10px;">
                    <form name="indietro" id="indietro" title="Indietro" action="<?php echo $back_url; ?>" method="post" style="margin: 0px;">
                        <input type="image" alt="indietro" title="Indietro" src="images/indietro.gif" value="indietro" style="height:40px;">
                    </form>
                </div>
                <div style="margin-left:0px; height:40px; margin-bottom:10px; margin-top:10px; float:left;">
                    <?php echo $modifica; ?>
                </div>
                <div style="margin-left:0px; height:40px; margin-bottom:10px; margin-top:10px; float:left;">
                    <?php echo $duplica; ?>
                </div>
                <div style="margin-left:0px; height:40px; margin-bottom:10px; margin-top:10px; float:left;">
                    <?php echo $elimina; ?>
                </div>
            </div>
            <?php
        }
        ?>
        <div style="clear:both;margin-left:0px; min-height:350px; margin-bottom:10px; margin-top:10px;">
            <form id="form" name="form"  enctype="multipart/form-data" action="<?php echo $back_url; ?>" method="post">

                <div id="navigation">      
                    <ul>      
                        <li id="cam"><a href="#" onclick="visualizza('Campagna');">Campagna</a></li>
			<?php if ($page_protect->get_job_role() >= 2) $display_tab_criteri= "visualizza('Criteri')";
                            else $display_tab_criteri= ""; //Guest non vede il Tab Criteri
                        ?>
                        <li id="cri"><a href="#" onclick="<?php echo $display_tab_criteri; ?>">Criteri</a></li>
                        <li id="can"><a href="#" onclick="visualizza('Canale');">Canale</a></li>
                        <li id="com"><a href="#" onclick="visualizza('Comunicazione');">Comunicazione</a></li>
                        <!--<li id="car"><a href="#" onclick="visualizza('CaricamentiMassivi');">Caricamenti Massivi</a></li>-->
                    </ul>
                </div> 

                <!--TAB CAMPAGNA-->
                <div id="tabCampagna" style="display:none">
                    <div class="left" style="margin:10px; min-height:350px; width:47%;">
                        <span class="" style="margin-top:10px; width:90%; display:block;">
                            <label id="labelNomeCampagna">Nome campagna<span id="req_1" class="req">*</span></label>
                            <input id="pref_nome_campagna" name="pref_nome_campagna" type="text" class="text grande" 
                            <?php
                            if ($modifica)
//echo "value=\"" . substr(stripslashes($id_campaign['pref_nome_campagna']), 9) . "\"";
                                echo "value=\"" . substr(stripslashes($id_campaign['pref_nome_campagna']), 0) . "\"";
                            else
                                echo "value=\"\"";
                            echo " readonly=\"readonly\" ";
                            ?>
                                   tabindex="1" maxlength="30"  /> 
                            
                            <label id="labelNomeCampagna">Note<span id="req_1" class="req">
                                    <img title="Note" alt="Note" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;" /></span></label>
                            
                            <input id="nome_campagna" name="nome_campagna" type="text" class="text grande"
                            <?php
                            if ($modifica)
                                echo "value=\"" . stripslashes($id_campaign['nome_campagna']) . "\"";
                            else
                                echo "value=\"\"";
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="1" maxlength="70" onfocus="seleziona('nome_campagna');" onblur="deseleziona('nome_campagna');"/>
                        </span>           

                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label>Stack<span id="req_2" class="req">*</span></label>
                            <?php
                            $list = $funzioni_admin->get_list_id('campaign_stacks');
                            $lista_field = array_column($list, 'id');
                            $lista_name = array_column($list, 'name');
                            $javascript = "  tabindex=\"2\" onfocus=\"seleziona('stack_id');\" onblur=\"deseleziona('stack_id');\" ";
                            if ($readonly)
                                $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:200px;\" ";
                            if ($modifica)
                                $valore_stack = $id_campaign['stack_id'];
                            else
                                $valore_stack = "";
                            $funzioni_admin->stampa_select('stack_id', $lista_field, $lista_name, $javascript, $style, $valore_stack);
                            ?>
                        </span>

                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label>Tipo Campagna<span id="req_3" class="req">*</span></label>
                            <select id="type_id" name="type_id" onchange="" tabindex="3"
                            <?php
                            if ($readonly)
                                echo $readonly_value . $disabled_value;
                            ?>
                                    onfocus="seleziona('type_id');" onblur="deseleziona('type_id');" style="width:200px;">
                            </select>
                        </span>

                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label>Priorit&agrave; PM<span id="req_4" class="req">*</span></label>
                            <?php
                            $lista_field = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                            $lista_name = array('0', '1', '2', '3', '4', '5', '6', '7', '8', '9');
                            $javascript = "  tabindex=\"5\" onfocus=\"seleziona('priority');\" onblur=\"deseleziona('priority');\" ";
                            if ($readonly)
                                $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:200px;\" ";
                            if ($modifica)
                                $valore_priority = $id_campaign['priority'];
                            else
                                $valore_priority = "1";
                            $funzioni_admin->stampa_select('priority', $lista_field, $lista_name, $javascript, $style, $valore_priority);
                            ?>

                            <img title="Priorit&agrave; da assegnare alle campagne del singolo utente" alt="Priorit&agrave; PM" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;" />
                        </span>

                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label id="dipartimento">Squad:
                                <span id="req_5" class="req">*</span>
                            </label>
                            <?php
                            $list = $funzioni_admin->get_list_id('squads');
                            $lista_field = array_column($list, 'id');
                            $lista_name = array_column($list, 'name');
                            $javascript = " tabindex=\"6\" onfocus=\"seleziona('squad_id');\" onblur=\"deseleziona('squad_id');\" ";
                            if ($readonly)
                                $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:200px;\" ";
                            if ($modifica)
                                $valore_department = $id_campaign['squad_id'];
                            else {
                                $squad_id = $page_protect->get_squad();
                                $valore_department = $squad_id;
                            }
                            if ($page_protect->get_job_role() == 2) {
                                $lista_field = array($squad_id);
                                $lista_name = array($funzioni_admin->get_nome_campo("squads", "id", $squad_id, "name"));
                            }

                            $funzioni_admin->stampa_select('squad_id', $lista_field, $lista_name, $javascript, $style, $valore_department);
                            ?>
                        </span>

                        <span class="left"  id="span_state"  style="margin-top:10px; width:90%; display:none;">
                            <label>Stato<span id="req_6" class="req">*</span></label>
                            <?php
                            if (isset($id_campaign['ordinamento_stato'])) {
                                if (($id_campaign['ordinamento_stato'] < 2) && ($page_protect->get_job_role() == 2)) {
                                    $list = $funzioni_admin->get_list_state_id('campaign_states', 2);
                                } else {
                                    $list = $funzioni_admin->get_list_state_id('campaign_states', 10);
                                }
//$list = $funzioni_admin->get_list_id('campaign_states');
                                $lista_field = array_column($list, 'id');
                                $lista_name = array_column($list, 'name');
                                $javascript = "  tabindex=\"7\" onfocus=\"seleziona('selectStato');\" onblur=\"deseleziona('selectStato');\" ";
                                if ($readonly)
                                    $javascript = $javascript . $disabled_value;
                                $style = " style=\"width:150px;\" ";
                                if ($modifica)
                                    $campaign_state_id = $id_campaign['campaign_state_id'];
                                else
                                    $campaign_state_id = "";
                                $funzioni_admin->stampa_select('campaign_state_id', $lista_field, $lista_name, $javascript, $style, $campaign_state_id);
                            }
                            ?>

                        </span>
                        <span class="left"  id="span_cod_campagna"  style="margin-top:10px; width:90%; display:none;">
                            <label id="label_cod_campagna">Cod_Campagna</label>
                            <input id="cod_campagna" name="cod_campagna" type="text" class="text grande" 
                            <?php
                            if($action_duplica)
                                echo "value=\"\"";
                            elseif ($modifica)
                                echo "value=\"" . $id_campaign['cod_campagna'] . "\"";
								#echo "value=\"\"";
                            else
                                echo "value=\"\"";
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="1" maxlength="100" onfocus="seleziona('cod_campagna');" onblur="deseleziona('cod_campagna');"/>
                        </span>
                        <span class="left"  id="span_cod_comunicazione"  style="margin-top:10px; width:90%; display:none;">
                            <label id="label_cod_comunicazione">Cod_Comunicazione</label>
                            <input id="cod_comunicazione" name="cod_comunicazione" type="text" class="text grande" 
                            <?php
                            if($action_duplica)
                                echo "value=\"\"";
                            elseif ($modifica)
                                echo "value=\"" . $id_campaign['cod_comunicazione'] . "\"";
								#echo "value=\"\"";
                            else
                                echo "value=\"\"";
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="1" maxlength="100" onfocus="seleziona('cod_comunicazione');" onblur="deseleziona('cod_comunicazione');"/>
                        </span>
                    </div>
                    <div class="left" style="margin:10px; min-height:350px; width:47%;">

                        <span class="left" id="span_ottimizzazione" style="margin-top:10px; width:90%; display:none;">
                            <label>Ottimizzazione<span id="req_7" class="req">*</span></label>
                            <select id="ottimizzazione" name="ottimizzazione" tabindex="8" onfocus="seleziona('ottimizzazione');" onblur="deseleziona('ottimizzazione');" style="background: white;">
                                <option value=""></option>
                                <option value="0" selected="selected">No</option>
                                <option value="1">Si</option>
                            </select>
                            <img title="Da impostare su SI soltanto se la campagna deve essere ottimizzata" alt="Ottimizzazione" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;" />
                        </span>
                        <div>
                            <span class="left" style="margin-top:10px; width:90%; display:block;">
                                <label>Descrizione leva/offerta<span id="req_8" class="req">*</span></label>
                                <?php
                                $lista_field = array('0', '1');
                                $lista_name = array('No', 'Yes');
                                $javascript = "  tabindex=\"7\" onchange=\"leva_check();\" onfocus=\"seleziona('leva');\" onblur=\"deseleziona('leva');\" ";
                                if ($readonly)
                                    $javascript = $javascript . $disabled_value;
                                $style = " style=\"width:200px;\" ";
                                if ($modifica)
                                    $valore_leva = $id_campaign['leva'];
                                else
                                    $valore_leva = "0";
                                $funzioni_admin->stampa_select('leva', $lista_field, $lista_name, $javascript, $style, $valore_leva);
                                ?>
                                <img title="Da impostare su SI soltanto se si offre un prodotto al cliente. In tal caso inserire la data di inizio e fine validit&agrave; dell'offerta e la relativa descrizione" alt="Leva Offerta" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                            </span>

                            <span class="left" id="dataInizioValOff" style="margin-top:10px; width:90%; display:none;">
                                <label>Data inizio validit&agrave; offerta<span id="req_9" class="req">*</span></label>
                                <input class="text" type="text" name="data_inizio_validita_offerta" id="data_inizio_validita_offerta" tabindex="8"  onfocus="seleziona('data_inizio_validita_offerta');" onblur="deseleziona('data_inizio_validita_offerta');" onkeyup="cancella('data_inizio_validita_offerta')"
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['data_inizio_validita_offerta'] != NULL)
                                        echo "value=\"" . $campaign->data_eng_to_it_($id_campaign['data_inizio_validita_offerta']) . "\"";
                                } else
                                    echo "value=\"\"";

                                if ($readonly)
                                    echo $disabled_value;
                                ?>
                                       />
                                <input                         <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> type="image" style="width:15px;" tabindex="9" alt="Calendario" src="images/Calendario.gif" value="Calendario" onclick="return showCalendar('data_inizio_validita_offerta', '%d/%m/%Y');" />
                            </span>

                            <span class="left" id="dataFineValOff" style="margin-top:10px; width:90%; display:none;">
                                <label>Data fine validit&agrave; offerta<span id="req_10" class="req">*</span></label>
                                <input class="text" type="text" name="data_fine_validita_offerta" id="data_fine_validita_offerta" tabindex="10"  readonly="readonly" onfocus="seleziona('data_fine_validita_offerta');" onblur="deseleziona('data_fine_validita_offerta');" onkeyup="cancella('data_fine_validita_offerta')"
                                <?php
                                if ($modifica)
                                    if ($id_campaign['data_fine_validita_offerta'] != NULL)
                                        echo "value=\"" . $campaign->data_eng_to_it_($id_campaign['data_fine_validita_offerta']) . "\"";
                                    else
                                        echo "value=\"\"";
                                ?>                        <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?>
                                       />
                                <input                         <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> type="image" style="width:15px;" tabindex="11" alt="Calendario" src="images/Calendario.gif" value="Calendario" onclick="return showCalendar('data_fine_validita_offerta', '%d/%m/%Y');" />
                            </span>


                            <span class="left" id="spandescrizione_leva" style="width:45%; margin-top:10px; display:none;">
                                <label style="width:100%;">Descrizione leva/offerta<span id="req_11" class="req">*</span></label>
                                <textarea id="descrizione_leva"
                                <?php
                                if ($readonly)
                                    echo $readonly_value;
                                ?>
                                          style="width:100%;" name="descrizione_leva" class="grande" rows="10" cols="50" tabindex="12" onkeyup="checklength(0, 1000, 'descrizione_leva', 'charLeva', '')" onfocus="seleziona('descrizione_leva');" onblur="deseleziona('descrizione_leva');"><?php
                                              if ($modifica)
                                                  $descrizione_leva = $id_campaign['descrizione_leva'];
                                              else
                                                  $descrizione_leva = "";
                                              echo $descrizione_leva;
                                              ?></textarea>
                                <label style="width:100%;"><input type="text" name="charLeva" id="charLeva" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="4" value="1000" onfocus="this.blur()" /></label>
                            </span>
                            <span class="left"  id="span_offer_search"   style="width:90%; margin-top:20px; display:none;">
                                <label> Offer search:</label>
                                <input 
                                <?php
                                if ($readonly)
                                    echo $readonly_value;
                                ?> class="text grande" type="text" name="offer_search"  id="offer_search" />
                                <a href="#"><img title="Clicca per cercare il nome offerta" alt="Ottimizzazione" type="image" src="images/Icona-Lente.jpg" style="height:18px"></a>

                            </span>
                            <span class="left" id="span_offer_list"  style="width:90%; margin-top:10px; display:none;">
                                <select name="offer_id" id="offer_id"  onchange="" >
                                    <option value=''>Seleziona leva</option>
                                    <?php
                                    if ($modifica)
                                        echo "<option value='" . $id_campaign['offer_id'] . "'>" . $id_campaign['offer_name'] . "</option>";
                                    ?>
                                </select>
                            </span>
                            <span  class="left" id="span_offer_description" style="width:90%; margin-top:10px; display:none;">
                                <label style="width:100%;">Descrizione leva/offerta (DESC_LINK)<span id="req_11" class="req">*</span></label>
                                <textarea <?php
                                if ($modifica)
                                    $offer_description = stripslashes($id_campaign['offer_description']);
                                else
                                    $offer_description = "";
                                if ($readonly)
                                    echo $readonly_value;
                                ?> name="offer_description" id="offer_description"  rows="4" cols="70" readonly><?php echo $offer_description; ?></textarea>
                            </span>
                            <span  class="left" id="span_stringa_CCM" style="width:90%; margin-top:10px; display:none;">
                                <label style="width:100%;">Stringa CCM (DESC_DESCRIZIONE_CAMPAGNA)<span id="req_11" class="req">*</span></label>
                                <textarea <?php
                                if ($modifica)
                                    $stringa_ccm = stripslashes($id_campaign['offer_name']);
                                else
                                    $stringa_ccm = "";
                                if ($readonly)
                                    echo $readonly_value;
                                ?> name="stringa_ccm" id="stringa_ccm"  rows="1" cols="70" readonly><?php echo $stringa_ccm; ?></textarea>
                            </span>

                            <span  class="left" id="span_offer_description_OLD" style="width:90%; margin-top:10px; display:none;">
                                <?php
                                if ($modifica)
                                    $descrizione_leva = stripslashes($id_campaign['descrizione_leva']);
                                else
                                    $descrizione_leva = "";
                                if ($descrizione_leva != "") {
                                    ?>
                                    <label style="width:100%;">Descrizione leva/offerta OLD</label>
                                    <textarea <?php
                                    if ($modifica)
                                        $descrizione_leva = stripslashes($id_campaign['descrizione_leva']);
                                    else
                                        $descrizione_leva = "";
                                    if ($readonly)
                                        echo $readonly_value;
                                    ?> name="descrizione_leva" id="descrizione_leva"  rows="4" cols="70"><?php echo $descrizione_leva; ?></textarea>
                                        <?php
                                    }
                                    ?>
                            </span>

                        </div>
                        <br/>


                    </div>


                </div>  

                <!--TAB COMUNICAZIONE-->

                <div id="tabComunicazione" style="display:none">

                    <div class="left" style="margin:10px; min-height:350px; width:47%;">

                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label>Control stack<span id="req_12" class="req">*</span></label>
                            <?php
                            $lista_field = array('0', '1');
                            $lista_name = array('No', 'Yes');
                            $javascript = "  tabindex=\"15\" onfocus=\"seleziona('control_stack');\"  onchange=\"controlStack();\" onblur=\"deseleziona('control_stack');\" ";
                            if ($readonly)
                                $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:50px;\" ";
                            if ($modifica)
                                $valore_control_group = $id_campaign['control_group'];
                            else
                                $valore_control_group = "0";
                            $funzioni_admin->stampa_select2('control_group', $lista_field, $lista_name, $javascript, $style, $valore_control_stack);
                            ?>

                            <img id="infoControlGroup" title="Da impostare su SI soltanto se si vuole isolare e monitorare una percentuale del target su cui non verr&agrave; effettuata la campagna." alt="Control Group" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                        </span>


                        <span class="left" id="spanControlGroup" style="margin-top:10px; width:40%; display:none;">
                            <label>Percentuale control group<span id="req_13" class="req">*</span></label>
                            <input id="perc_control_group" name="perc_control_group" style="text-align:right" type="text" class="text piccolo" maxlength="2" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['perc_control_group'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="16" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('perc_control_group');" onblur="deseleziona('perc_control_group');" />%
                        </span>
                    </div>
                    <div class="left" style="margin:10px; min-height:350px; width:47%;">

                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label style="width:100%;">Criteri di redemption</label>
                            <textarea <?php
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                id="redemption" name="redemption" style="width:100%;" class="grande" rows="10" cols="50" tabindex="60" onkeyup="checklength(0, 1000, 'redemption', 'charRedemption')" onfocus="seleziona('redemption');" onblur="deseleziona('redemption');"><?php
                                    if ($modifica)
                                        echo stripslashes($id_campaign['redemption']);
                                    ?></textarea>
                            <label style="width:100%;"><input type="text" name="charRedemption" id="charRedemption" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="4" value="1000" onfocus="this.blur()" />
                            </label>
                            <img id="infoRedemption" title="Indicare le azioni che il cliente dovr&agrave; eseguire per essere considerato redeemer (esempio: il cliente dovr&agrave; attivare una opzione in un range temporale). 
                                 Non &egrave; considerata redemption il click di un link da parte di un cliente." alt="Criteri Redemption" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                        </span>

                    </div>
                </div>

                <!--TAB CANALE-->

                <div id="tabCanale" style="display:none">
                    <div class="left" style="margin:10px; min-height:350px; width:47%;">
                        <span class="left" style="margin-top:10px; width:45%; display:block;">
                            <label>Canale<span id="req_14" class="req">*</span></label>
                            <?php
                            $list = $funzioni_admin->get_list_id('channels');
                            $lista_field = array_column($list, 'id');
                            $lista_name = array_column($list, 'name');
                            $javascript = " onchange=\"tipo();\" tabindex=\"17\" onfocus=\"seleziona('channel_id');\" onblur=\"deseleziona('channel_id');\"  ";
                            $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:150px;\" ";
                            if ($modifica)
                                $valore_channel_id = $id_campaign['channel_id'];
                            else
                                $valore_channel_id = "";
                            $funzioni_admin->stampa_select('channel_id', $lista_field, $lista_name, $javascript, $style, $valore_channel_id);
                            ?>
                        </span>

                        <span class="left" id="spanmod_invio" style="margin-top:10px; width:45%; display:none;">
                            <label>Modalit&agrave; invio<span id="req_15" class="req">*</span></label>

                            <?php
                            $lista_field = array('Interattivo', 'Standard');
                            $lista_name = array('Interattivo', 'Standard');
                            $javascript = "  onchange=\"interattivo();\" tabindex=\"18\" onfocus=\"seleziona('mod_invio');\" onblur=\" deseleziona('mod_invio');\"  ";
                            $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:150px;\" ";
                            if ($modifica)
                                $valore_mod_invio = $id_campaign['mod_invio'];
                            else
                                $valore_mod_invio = "";
                            $funzioni_admin->stampa_select('mod_invio', $lista_field, $lista_name, $javascript, $style, $valore_mod_invio);
                            ?>
                        </span>

                        <span class="left" id="spansender_id" style="margin-top:10px; width:45%; display:none;">
                            <label>Sender<span id="req_16" class="req">*</span></label>
                            <select id="sender_id" name="sender_id" onchange="" tabindex="3" 
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                                    onfocus="seleziona('sender_id');" onblur="deseleziona('sender_id');" style="width:150px;">
                            </select>

                        </span>
                        <span class="left" id="spanStoricizza" style="margin-top: 10px; width: 40%; display: none;">
                            <label>Storicizzazione legale<span id="req_17" class="req">*</span></label>
                            <?php
                            $lista_field = array('0', '1');
                            $lista_name = array('No', 'Si');
                            $javascript = "  tabindex=\"20\" onfocus=\"seleziona('storicizza');\" onblur=\" deseleziona('storicizza');\"  ";
                            $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:150px;\" ";
                            if ($modifica)
                                $valore_mod_invio = $id_campaign['storicizza'];
                            else
                                $valore_mod_invio = "";
                            $funzioni_admin->stampa_select('storicizza', $lista_field, $lista_name, $javascript, $style, $valore_mod_invio);
                            ?>

                        </span>

                        <span class="left" id="spantesto_sms" style="width:70%; margin-top:10px; display:none;">
                            <label style="width:100%;">Testo sms<span id="req_18" class="req">*</span></label>
                            <textarea id="testo_sms" 
                            <?php
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                      style="width:100%;" name="testo_sms" class="grande" rows="10" cols="50" tabindex="21" onkeyup="checklength(0, 640, 'testo_sms', 'charTesto', 'numero_sms')" onfocus="seleziona('testo_sms');" onblur=" deseleziona('testo_sms');"><?php
                                          if ($modifica)
                                              echo stripslashes($id_campaign['testo_sms']);
                                          ?></textarea>
                            <label style="width:100%;">Numeri caratteri utilizzati<input type="text" name="charTesto" id="charTesto" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
                            <label style="width:100%;">Numero SMS<input type="text" name="numero_sms" id="numero_sms" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="0" onfocus="this.blur()" /></label>
                        </span>
                        
                       


                        <span class="left" id="spanLabelLinkTesto" style="margin-top:10px; width:70%; display:none;">
                            <label style="width:100%; display:block;" id="labelLinkTesto">Link<span id="req_19" class="req">*</span></label>
                            <input style="width:100%; display:block;" id="link" name="link" type="text" class="text grande" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['link'] . "\"";
                            else
                                echo "value=\"\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="23" maxlength="400" onkeyup="checklength(0, 255, 'link', 'charLink', '')" onfocus="seleziona('link');" onblur="deseleziona('link');"/>
                            <label style="width:100%;"><input type="text" name="charLink" id="charLink" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="3" value="255" onfocus="this.blur()" /></label>
                        </span>

                        <span class="left"  id="spansms_duration" style="margin-top:10px; width:45%; display:none;">
                            <label >Durata sms<span id="req_20" class="req">*</span></label>
                            <input id="sms_duration" name="sms_duration" style="float:left; text-align:right; margin-right:5px;" type="text" class="text piccolo" maxlength="2" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['sms_duration'] . "\"";
                            else
                                echo "value=\"2\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="22" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('sms_duration');" onblur="deseleziona('sms_duration');" />
                            <img id="info" title="Numero di giorni in cui la rete tenter&agrave; l'invio dell'sms. Range da 1 a 7 giorni." alt="Durata SMS" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                        </span>

                        <span class="left" id="spanTipoMonitoring" style="margin-top:10px; width:35%; display:none;">
                            <label>Tipo monitoring</label>
                            <?php
                            $lista_field = array('1', '2', '3');
                            $lista_name = array('ADV Tracking tool', 'Orphan page', 'No monitoring');
                            $javascript = " tabindex=\"59\" onfocus=\"seleziona('tipoMonitoring');\" onblur=\"deseleziona('tipoMonitoring');\" ";
                            $javascript = $javascript . $disabled_value;
                            $style = "  ";
                            if ($modifica)
                                $valore_tipoMonitoring = $id_campaign['tipoMonitoring'];
                            else
                                $valore_tipoMonitoring = "0";
                            $funzioni_admin->stampa_select('tipoMonitoring', $lista_field, $lista_name, $javascript, $style, $valore_tipoMonitoring);
                            ?>
                        </span>
                    </div>

                    <div class="left" style="margin:10px; min-height:350px; width:47%;">

                        <span class="left" style="margin-top:10px; width:60%; display:block;">
                            <label id="labelTrial" style="display:none;" >Data trial<span id="req_21" class="req">*</span></label>
                            <input style="display:none;" class="text" type="text" name="data_trial" id="data_trial" tabindex="24"  readonly="readonly" onfocus="seleziona('data_trial');" onblur="deseleziona('data_trial');" onkeyup="cancella('data_trial')"
                            <?php
                            if ($modifica)
                                if ($id_campaign['trial_campagna'] == 1)
                                    if ($id_campaign['data_trial'] != NULL)
                                        echo "value=\"" . $campaign->data_eng_to_it_($id_campaign['data_trial']) . "\"";
                                    else
                                        echo "value=\"\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                                   />
                            <input style="display:none; width:15px" type="image" id="calendTrial" tabindex="25" alt="Calendario" src="images/Calendario.gif"
                            <?php
                            if ($modifica)
                                if ($id_campaign['trial_campagna'] == 1)
                                    if ($id_campaign['data_trial'] != NULL)
                                        echo "value=\"" . $campaign->data_eng_to_it_($id_campaign['data_trial']) . "\"";
                                    else
                                        echo "value=\"\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                                   onclick="return showCalendar('data_trial', '%d/%m/%Y');" />
                            <input type="checkbox" id="trial_campagna" name="trial_campagna"
                            <?php
                            if ($modifica) {
                                if ($id_campaign['trial_campagna'] == 1)
                                    echo " checked=\"checked\" ";
                            } else
                                echo "";
                            ?>
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?> value="1" tabindex="26" onfocus="seleziona('trial_campagna');" onblur="deseleziona('trial_campagna');" onclick="return trial_check();"/>
                            Trial <span id="req_22" class="req">O</span>
                        </span>

                        <span class="left" style="margin-top:10px; width:90%; display:block;">

                            <label>Data inizio comunicazione<span id="req_23" class="req">*</span></label>
                            <input class="text" type="text" name="data_inizio" id="data_inizio" tabindex="27"  readonly="readonly" onfocus="seleziona('data_inizio');" onblur="deseleziona('data_inizio');" onkeyup="cancella('data_inizio');"
                            <?php
                            if ($modifica)
                                if ($id_campaign['data_inizio'] != NULL)
                                    echo "value=\"" . $campaign->data_eng_to_it_($id_campaign['data_inizio']) . "\"";
                                else
                                    echo "value=\"\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                                   />
                            <input type="image"
                            <?php
                            if ($readonly)
                                echo $disabled_value;
                            ?>style="width:15px;" tabindex="28" alt="Calendario"  id="calendario" src="images/Calendario.gif" value="Calendario" onclick="return  showCalendar('data_inizio', '%d/%m/%Y')" />
                            <input type="checkbox" id="escludi_sabato" name="escludi_sabato"
                            <?php
                            if ($modifica) {
                                if ($id_campaign['escludi_sabato'] == 1)
                                    echo " checked=\"checked\" ";
                                else
                                    echo "";
                            } else
                                echo " checked=\"checked\" ";
                            if ($readonly)
                                echo $disabled_value;
                            ?>
                                   tabindex="29" value="1" onfocus="seleziona('escludi_sabato');" onblur="deseleziona('escludi_sabato');"/>
                            Escludi sabato
                        </span>

                        <span class="left" style="margin-top:10px; width:45%; display:block;">
                            <label>Durata comunicazione <span id="req_24" class="req">*</span></label>
                            <?php
                            $lista_field = array('1', '2', '3', '4', '5', '6', '7');
                            $lista_name = array('1 giorni', '2 giorni', '3 giorni', '4 giorni', '5 giorni', '6 giorni', '7 giorni');

                            $javascript = " tabindex=\"30\" onchange=\"volume_tot();volumeGiornaliero(0);\" onfocus=\"seleziona('durata_campagna');\" onblur=\"deseleziona('durata_campagna');\" ";
                            if ($readonly) {
                                $javascript = $javascript . $disabled_value;
                            }
                            $style = "  ";
                            if ($modifica)
                                $valore_priority = $id_campaign['durata_campagna'];
                            else
                                $valore_priority = "1";
                            $funzioni_admin->stampa_select('durata_campagna', $lista_field, $lista_name, $javascript, $style, $valore_priority);
                            ?>

                        </span>


                        <span class="left" style="border:1px solid white;width:45%;margin-top:10px; display:block;">
                            <label>Max percentuale scostamento atteso <span id="req_25" class="req">O</span></label>
                            <input id="perc_scostamento" name="perc_scostamento" style="text-align:right" type="text" class="text piccolo" maxlength="9" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['perc_scostamento'] . "\"";
                            else
                                echo "value=\"10\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo $readonly_value;
                            ?>
                                   tabindex="31" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('perc_scostamento');" onblur="deseleziona('perc_scostamento');" />%
                        </span>

                        <span class="left" style="border:1px solid white; width:45%;margin-top:10px; display:block;">
                            <label>Volume Totale Stimato (per unit&agrave;)<span id="req_26" class="req">*</span></label>
                            <input id="volume" name="volume" style="text-align:right" type="text" class="text piccolo" maxlength="9" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volume'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volume');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volume');volumeGiornaliero(0);\"";
                            ?>
                                   tabindex="32" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volume');"  />
                        </span>


                        <span class="left" style="width:45%;margin-top:10px; display:block;">

                            <label style="display:none;" id="labelvolume_trial">Volume Trial<span id="req_27" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volume_trial" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volume_trial'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volume_trial');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volume_trial');volumeGiornaliero(0);\"";
                            ?>
                                   name="volume_trial" type="text" class="text piccolo" maxlength="9"  tabindex="33" onkeydown="return onKeyNumeric(event);" onfocus=" seleziona('volume_trial');" />

                            <label id="labelVolumeGiornaliero1">Volume Giorno 1<span id="req_28" class="req">*</span></label>
                            <input id="volumeGiornaliero1" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero1'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero1');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero1');volumeGiornaliero(1);\"";
                            ?>
                                   name="volumeGiornaliero1" style="text-align:right" type="text" class="text piccolo" maxlength="9"  tabindex="34" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero1');"  />

                            <label style="display:none;" id="labelVolumeGiornaliero2">Volume Giorno 2<span id="req_29" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volumeGiornaliero2" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero2'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero2');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero2');volumeGiornaliero(2);\"";
                            ?>
                                   name="volumeGiornaliero2" type="text" class="text piccolo" maxlength="9" tabindex="35" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero2');"  />

                            <label style="display:none;" id="labelVolumeGiornaliero3">Volume Giorno 3<span id="req_30" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volumeGiornaliero3"
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero3'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero3');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero3');volumeGiornaliero(3);\"";
                            ?>
                                   name="volumeGiornaliero3" type="text" class="text piccolo" maxlength="9" tabindex="36" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero3');"  />

                            <label style="display:none;" id="labelVolumeGiornaliero4">Volume Giorno 4<span id="req_31" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volumeGiornaliero4" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero4'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero4');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero4');volumeGiornaliero(4);\"";
                            ?>
                                   name="volumeGiornaliero4" type="text" class="text piccolo" maxlength="9" tabindex="37" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero4');"/>

                            <label style="display:none;" id="labelVolumeGiornaliero5">Volume Giorno 5<span id="req_32" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volumeGiornaliero5" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero5'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero5');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero5');volumeGiornaliero(5);\"";
                            ?>
                                   name="volumeGiornaliero5" type="text" class="text piccolo" maxlength="9" tabindex="38" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero5');" />

                            <label style="display:none;" id="labelVolumeGiornaliero6">Volume Giorno 6<span id="req_33" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volumeGiornaliero6" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero6'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero6');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero6');volumeGiornaliero(6);\"";
                            ?>
                                   name="volumeGiornaliero6" type="text" class="text piccolo" maxlength="9" tabindex="39" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero6');" />

                            <label style="display:none;" id="labelVolumeGiornaliero7">Volume Giorno 7<span id="req_34" class="req">*</span></label>
                            <input style="display:none; text-align:right" id="volumeGiornaliero7" 
                            <?php
                            if ($modifica)
                                echo "value=\"" . $id_campaign['volumeGiornaliero7'] . "\"";
                            else
                                echo "value=\"0\"";
                            ?>
                            <?php
                            if ($readonly)
                                echo "onblur=\"deseleziona('volumeGiornaliero7');\"" . $readonly_value;
                            else
                                echo "onblur=\"deseleziona('volumeGiornaliero7');volumeGiornaliero(7);\"";
                            ?>
                                   name="volumeGiornaliero7" type="text" class="text piccolo" maxlength="9" tabindex="40" onkeydown="return onKeyNumeric(event);" onfocus="seleziona('volumeGiornaliero7');" />

                        </span>

                    </div>
                </div>

                <!--TAB CRITERI-->

                <div id="tabCriteri" style="display:none">
                    <div class="left" style="margin:10px; min-height:350px; width:47%;">

                        <span class="left" style="margin-top:10px; width:30%; display:block;">
                            <label>Stato<span id="req_35" class="req">*</span></label>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['attivi'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1" id="attivi" name="attivi" tabindex="41" onfocus="seleziona('attivi');" onblur="deseleziona('attivi');" />Attivi</span>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['sospesi'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="sospesi" name="sospesi" tabindex="42" onfocus="seleziona('sospesi');" onblur="deseleziona('sospesi');" />Sospesi</span>
                        </span>

                        <span class="left" style="margin-top:10px; width:30%; display:block;">
                            <label>Tipo offerta<span id="req_36" class="req">*</span></label>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['consumer'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="consumer" name="consumer"tabindex="43" onfocus="seleziona('consumer');" onblur="deseleziona('consumer');" />Consumer</span>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['business'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="business" name="business"tabindex="44" onfocus="seleziona('business');" onblur="deseleziona('business');" />Business</span>
                        </span>

                        <span class="left" style="margin-top:10px; width:30%; display:block;">
                            <label>Tipo contratto<span id="req_37" class="req">*</span></label>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['prepagato'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="prepagato" name="prepagato"tabindex="45" onfocus="seleziona('prepagato');" onblur=" deseleziona('prepagato');" />Prepagato</span>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['postpagato'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="postpagato" name="postpagato"tabindex="46" onfocus="seleziona('postpagato');" onblur="deseleziona('postpagato');" />Postpagato</span>
                        </span>

                        <span class="left" style="margin-top:10px; height:70px; width:30%; display:block;">
                            <label>Consenso</label>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_profilazione'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="cons_profilazione"  name="cons_profilazione"tabindex="47" onfocus="seleziona('cons_profilazione');" onblur="deseleziona('cons_profilazione');" />Profilazione</span>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['cons_commerciale'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="cons_commerciale" name="cons_commerciale"tabindex="48" onfocus="seleziona('cons_commerciale');" onblur="deseleziona('cons_commerciale');" />Commerciale</span>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['checkboxAdesso3'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="checkboxAdesso3"  name="checkboxAdesso3"tabindex="49" onfocus="seleziona('checkboxAdesso3');" onblur="deseleziona('checkboxAdesso3');" />Adesso 3</span>
                        </span>

                        <span class="left" style="margin-top:10px; height:70px; width:30%; display:block;">
                            <label>Tipo piano<span id="req_38" class="req">*</span></label>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['voce'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?>
                                                                            id="voce" name="voce" value="1" tabindex="50" onfocus="seleziona('voce');" onblur="deseleziona('voce');" />Voce</span>
                            <span style="display:block; width:100%;"><input type="checkbox" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['dati'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  id="dati" name="dati" tabindex="51" onfocus="seleziona('dati');" onblur="deseleziona('dati');" />Dati</span>
                        </span>

                        <span class="left" style="margin-top:10px;height:70px; width:30%; display:block;">
                            <label>Frodatori</label>
                            <span style="display:block; width:100%;"><input type="checkbox" id="no_frodi" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['no_frodi'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  name="no_frodi"  tabindex="52" onfocus="seleziona('no_frodi');" onblur="deseleziona('no_frodi');" />No Frodi</span>
                            <span style="display:block; width:100%;"><input type="checkbox" id="no_collection" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['no_collection'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  name="no_collection" tabindex="53" onfocus="seleziona('no_collection');" onblur="deseleziona('no_collection');" />No collection</span>
                        </span>

                        <span class="left" style="margin-top:10px; width:30%; display:block;">
                            <label>Ruolo<span id="req_39" class="req">*</span></label>
                            <span style="display:block; width:100%;"><input type="checkbox" id="etf" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['etf'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1" name="etf"tabindex="54" onfocus="seleziona('etf');" onblur="deseleziona('etf');" />Clienti Effettivi</span>
                            <span style="display:block; width:100%;"><input type="checkbox" id="vip" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['vip'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  name="vip"  tabindex="55" onfocus="seleziona('vip');" onblur="deseleziona('vip');" />VIP</span>
                            <span style="display:block; width:100%;"><input type="checkbox" id="dipendenti" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['dipendenti'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  name="dipendenti" tabindex="56" onfocus="seleziona('dipendenti');" onblur="deseleziona('dipendenti');" />Dipendenti</span>
                            <span style="display:block; width:100%;"><input type="checkbox" id="trial" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['trial'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  name="trial"  tabindex="57" onfocus="seleziona('trial');" onblur="deseleziona('trial');" />Trial</span>
                        </span>

                        <span class="left" style="margin-top:10px; width:30%; display:block;">
                            <label style="display:block; float:left; margin-right:5px;">Profilo di rischio</label>
                            <img title="GA: Nuove attivazioni da 0 a 4 mesi.

                                 High: Da -4 mesi a +3 mesi dallo svincolo (nel caso di mancato rivincolo) TRANNE I PREPAGATI
                                 Da -4 mesi dallo svincolo a rivincolo (nel caso di rivincolo) TRANNE I PREPAGATI

                                 Standard: In tutti gli altri casi" alt="Profilo di Rischio" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                            <span style="display:block; width:100%;">
                                <input type="checkbox" id="profilo_rischio_ga" name="profilo_rischio_ga" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['profilo_rischio_ga'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  tabindex="54"onfocus="seleziona('profilo_rischio_ga');" onblur="deseleziona('profilo_rischio_ga');" />GA</span>
                            <span style="display:block; width:100%;"><input type="checkbox" id="profilo_rischio_standard" name="profilo_rischio_standard" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['profilo_rischio_standard'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  tabindex="55" onfocus="seleziona('profilo_rischio_standard');" onblur="deseleziona('profilo_rischio_standard');" />Standard</span>
                            <span style="display:block; width:100%;"><input type="checkbox" id="profilo_rischio_high_risk" name="profilo_rischio_high_risk" 
                                <?php
                                if ($modifica) {
                                    if ($id_campaign['profilo_rischio_high_risk'] == 1)
                                        echo " checked=\"checked\" ";
                                } else
                                    echo "";
                                ?>
                                <?php
                                if ($readonly)
                                    echo $disabled_value;
                                ?> value="1"  tabindex="56" onfocus="seleziona('profilo_rischio_high_risk');" onblur="deseleziona('profilo_rischio_high_risk');" />High Risk</span>
                        </span>



                        <span class="left" style="margin-top:10px; width:30%; display:block;">
                            <label style="display:block;  margin-right:5px;">Segmento</label>
                            <?php
                            $list = $funzioni_admin->get_list_id('segments');
                            $lista_field = array_column($list, 'id');
                            $lista_name = array_column($list, 'name');

                            $style = " style=\"width:200px;\" ";
                            if ($modifica)
                                $segment_id = $id_campaign['segment_id'];
                            else {
                                $segment_id = 0;
                            }
                            $stringa_reset = "";
                            foreach ($lista_field as $key => $value) {
                                echo "<span style=\"display:block; width:100%;\">";
                                echo "<input type=\"radio\"";
                                $stringa_reset = $stringa_reset . ",\"" . $value . "_key\"";
                                if ($readonly)
                                    echo $disabled_value;
                                if ($segment_id == $value)
                                    echo " checked=\"checked\" ";
                                echo "name=\"segment_id\" id=\"" . $value . "_key\" value=\"$value\"/>" . $lista_name[$key];
                                echo "</span>";
                            }
                            if (!$readonly) {
                                echo "<span style=\"display:block; width:100%;\">";

                                echo "<a href=\"#\" id=\"clear-button\">Clear</a>";
                                echo "<script type=\"text/javascript\">
    document.getElementById('clear-button').addEventListener('click', function () {
      [" . substr($stringa_reset, 1) . "].forEach(function(id) {
        document.getElementById(id).checked = false;
        segment_label = \"\" ;
            document.getElementById('pref_nome_campagna').value = data_label + channel_label + type_label + offer_label + segment_label;
      });
      return false;
    })
  </script>";
                                echo "</span>";
                            }
//$funzioni_admin->stampa_select('squad_id', $lista_field, $lista_name, $javascript, $style, "");
                            ?>
                        </span>













                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label>Parlanti ultimo/i</label>
                            <?php
                            $lista_field = array('0', '1', '2', '3', '4', '5', '6');
                            $lista_name = array('0', '1 mese', '2 mese', '3 mese', '4 mese', '5 mese', '6 mese');
                            $javascript = " tabindex=\"59\" onfocus=\"seleziona('parlanti_ultimo');\" onblur=\"deseleziona('parlanti_ultimo');\" ";
                            if ($readonly)
                                $javascript = $javascript . $disabled_value;
                            $style = " style=\"width:50px;\" ";
                            if ($modifica)
                                $valore_priority = $id_campaign['parlanti_ultimo'];
                            else
                                $valore_priority = "1";
                            $funzioni_admin->stampa_select('parlanti_ultimo', $lista_field, $lista_name, $javascript, $style, $valore_priority);
                            ?>

                        </span>

                    </div>
                    <div class="left" style="margin:10px; min-height:350px; width:47%;">


                        <span class="left" style="margin-top:10px; width:90%; display:block;">
                            <label style="width:100%;">Altri criteri<span id="req_40" class="req">*</span></label>
                            <textarea<?php
                            if ($readonly)
                                echo $readonly_value;
                            ?> id="altri_criteri" style="width:100%;" name="altri_criteri" class="grande" rows="10" cols="50" tabindex="60" onkeyup="checklength(0, 1000, 'altri_criteri', 'charCriteri', '')" onfocus="seleziona('altri_criteri');" onblur="deseleziona('altri_criteri');"><?php
                                if ($modifica)
                                    echo stripslashes($id_campaign['altri_criteri']);
                                ?></textarea>
                            <label style="width:100%;"><input type="text" name="charCriteri" id="charCriteri" class="text" readonly="readonly" style="width:50px; float:right; text-align:right;" size="4" value="1000" onfocus="this.blur()" /></label>
                        </span>

                    </div>
                </div>

                <!--TAB CARICAMENTI MASSIVI
                <div id="tabCaricamentiMassivi" style="display:none">
                    <div class="left" style="margin:10px; min-height:350px; width:90%;">


                        <span class="left" id="spanCaricamentoMassivo" style="margin-top:10px; width:90%; display:block;">
                            <label>Caricamento massivo<span id="req_41" class="req">*</span></label>
                            <select id="caricamento_massivo" name="caricamento_massivo"  tabindex="61" onfocus="seleziona('caricamento_massivo');" onblur="deseleziona('caricamento_massivo');">
                                <option value=""></option>
                                <option value="0" selected="selected" >No</option>

                            </select>
                            <img id="infoCaricamentoMassivo" title="Da impostare su SI soltanto se la campagna prevede l'attivazione massiva di uno sconto, opzione e/o cambio piano." alt="Caricamento Massivo" type="image" src="images/informazione.jpg" style="margin:0px; height:15px;"/>
                        </span>
                    </div>
                </div>
                -->
                
                <div style="float:left; text-align:center; width:100%;">
                    <input type="hidden" name="user_id" id="user_id" value="<?php echo $page_protect->id; ?>"/>
                    <?php
                    /*                  <input type="hidden" name="squad_id" id="squad_id" value="<?php echo $page_protect->get_squad(); ?>"/>
                     * 
                     */
                    ?>
                    <input type="hidden" name="optimization" id="optimization" value="0" />
                    <input id="annulla" style="<?php echo $display_none; ?>"  name="annulla" tabindex="63" type="button" value="Annulla" onclick="javascript:window.location.href = './index.php?page=gestioneCampagne'"/>
                    <?php
                    if (isset($_POST['modifica'])) {
                        ?>
                        <input id="modifica"  style="<?php echo $display_none; ?>" name="modifica" tabindex="64" type="submit" value="modifica"  onclick="return controllaform()"/>

                        <input type="hidden" name="modifica_confim" id="modifica_confim" value="modifica_confim" />
                        <input type="hidden" name="id" id="id" value="<?php echo $_POST['id']; ?>"/>
                        <?php
                    } else {
                        ?><input style="<?php echo $display_none; ?>" id="salva" name="salva" tabindex="64" type="submit" value="Salva"  onclick="return controllaform()"/>
                        <input type="hidden" name="campaign_state_id" id="campaign_state_id" value="2" />
                        <?php
                    }
                    ?>
                    <input type="hidden" id="inserisciCampagna" name="inserisciCampagna" value="1" />
                </div>

                <div>
                    <label class="" id="campoObbligatorio">
                        <span id="req_94" class="req">*</span>
                        Campo obbligatorio
                    </label>

                    <label class="" id="campoOpzionale">
                        <span id="req_95" class="req">O</span>
                        Campo opzionale
                    </label>
                </div>

            </form>



        </div>


    </div>

</div><!-- end .content -->
<?php $form->close_page(); ?> 