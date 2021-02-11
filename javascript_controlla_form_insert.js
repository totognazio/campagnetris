/*
function volume_tot() {
    durata = document.getElementById("durata_campagna").value;
    for (i = 1; i <= durata; i++) {
        document.getElementById('volumeGiornaliero' + i).style.display = "";
        document.getElementById('labelVolumeGiornaliero' + i).style.display = "";
    }
    for (j = i; j <= 7; j++) {

        document.getElementById('volumeGiornaliero' + j).style.display = "none";
        document.getElementById('labelVolumeGiornaliero' + j).style.display = "none";
    }

}

function volumeGiornaliero(start) {
    durata = document.getElementById("durata_campagna").value;
    temp = 0;
    volume_trial = document.getElementById('volume_trial').value;
    volume = document.getElementById('volume').value - parseInt(volume_trial);
    for (i = 1; i <= durata; i++) {
        if (i < (start + 1)) {
            m = document.getElementById('volumeGiornaliero' + i).value;
            temp = temp + parseInt(m);
        } else {
            //alert(Math.floor((volume - temp) / (durata - start)));
//            if (document.getElementById('volumeGiornaliero' + i).value == 0)
            document.getElementById('volumeGiornaliero' + i).value = Math.floor((volume - temp) / (durata - start));
        }
    }
    //   if (document.getElementById('volumeGiornaliero' + i).value == 0)
    if (volume - temp - Math.floor((volume - temp) / (durata - start)) * (durata - start - 1) < 0)
        alert("numero sms errato.")
    document.getElementById('volumeGiornaliero' + durata).value = volume - temp - Math.floor((volume - temp) / (durata - start)) * (durata - start - 1);


}

function checklength(areaText, maxchars, input, char, char_count_sms) {
    lunghezza_sms = 160;
    lunghezza_sms_concatenato = 153;
    lunghezza_link = 28;
    chars = document.getElementById(input).value;
    if ((document.getElementById("mod_invio").value == "interattivo") && (input == "testo_sms")) {
        lunghezza_link = 28;
    } else {
        lunghezza_link = 0;
    }
    maxchars = maxchars - lunghezza_link;
    if (chars.length > maxchars)
    {
        document.getElementById(input).value = chars.substr(0, maxchars);
        document.getElementById(input).blur();
    }
    //document.getElementById(char).value = maxchars - document.getElementById(input).value.length;
    document.getElementById(char).value = document.getElementById(input).value.length;
    if (char_count_sms != '') {
        if (document.getElementById(input).value.length <= 160 - lunghezza_link)
            document.getElementById(char_count_sms).value = 1;
        else
            document.getElementById(char_count_sms).value = Math.floor((document.getElementById(input).value.length - lunghezza_link) / 153) + 1;
    }
}

function checklengthTotal(input, char) {   
    lunghezza_test_sms = 0;
    chars = document.getElementById(input).value;
    if ((document.getElementById("mod_invio").value === "Interattivo")) {
        lunghezza_test_sms = document.getElementById("charTesto").value; 
        alert('eccolo test ' + lunghezza_test_sms);
    } else {
        lunghezza_test_sms = 0;
    }
    document.getElementById("numero_totale").value = document.getElementById(char).value.length + lunghezza_test_sms + 1;

}


function leva_check() {
    if (document.getElementById("leva").value == "1") {
        //document.getElementById("spandescrizione_leva").style.display = "inline";
        document.getElementById("dataInizioValOff").style.display = "inline";
        document.getElementById("dataFineValOff").style.display = "inline";
        document.getElementById("span_offer_list").style.display = "inline";
        document.getElementById("span_offer_search").style.display = "inline";
        document.getElementById("span_offer_description").style.display = "inline";
        document.getElementById("span_offer_description_OLD").style.display = "inline";
        document.getElementById("span_stringa_CCM").style.display = "inline";
    } else {
        document.getElementById("spandescrizione_leva").style.display = "none";
        document.getElementById("dataInizioValOff").style.display = "none";
        document.getElementById("dataFineValOff").style.display = "none";
        document.getElementById("span_offer_list").style.display = "none";
        document.getElementById("span_offer_search").style.display = "none";
        document.getElementById("span_offer_description").style.display = "none";
        document.getElementById("span_offer_description_OLD").style.display = "none";
        document.getElementById("span_stringa_CCM").style.display = "none";
    }
}

function controlStack() {
    if (document.getElementById("control_stack").value == "1")
        document.getElementById("spanControlStack").style.display = "inline";
    else
        document.getElementById("spanControlStack").style.display = "none";
}

function cancella(data) {
    if (window.event.keyCode)
        document.getElementById(data).value = "";
}

function visualizza(tab) {

    if (tab == "Campagna") {

        document.getElementById("tabCampagna").style.display = "inline";
        document.getElementById("tabComunicazione").style.display = "none";
        document.getElementById("tabCanale").style.display = "none";
        document.getElementById("tabCriteri").style.display = "none";
        //document.getElementById("tabCaricamentiMassivi").style.display = "none";
        document.getElementById("cam").className = "attiva";
        document.getElementById("com").className = "nonAttiva";
        document.getElementById("can").className = "nonAttiva";
        document.getElementById("cri").className = "nonAttiva";
        document.getElementById("car").className = "nonAttiva";
    }

    if (tab == "Comunicazione") {
        document.getElementById("tabCampagna").style.display = "none";
        document.getElementById("tabComunicazione").style.display = "inline";
        document.getElementById("tabCanale").style.display = "none";
        document.getElementById("tabCriteri").style.display = "none";
        document.getElementById("tabCaricamentiMassivi").style.display = "none";
        document.getElementById("cam").className = "nonAttiva";
        document.getElementById("com").className = "attiva";
        document.getElementById("can").className = "nonAttiva";
        document.getElementById("cri").className = "nonAttiva";
        document.getElementById("car").className = "nonAttiva";
    }
    

    if (tab == "Canale") {
        document.getElementById("tabCampagna").style.display = "none";
        document.getElementById("tabComunicazione").style.display = "none";
        document.getElementById("tabCanale").style.display = "inline";
        document.getElementById("tabCriteri").style.display = "none";
        document.getElementById("tabCaricamentiMassivi").style.display = "none";
        document.getElementById("cam").className = "nonAttiva";
        document.getElementById("com").className = "nonAttiva";
        document.getElementById("can").className = "attiva";
        document.getElementById("cri").className = "nonAttiva";
        document.getElementById("car").className = "nonAttiva";
    }

    if (tab == "Criteri") {
        document.getElementById("tabCampagna").style.display = "none";
        document.getElementById("tabComunicazione").style.display = "none";
        document.getElementById("tabCanale").style.display = "none";
        document.getElementById("tabCriteri").style.display = "inline";
        document.getElementById("tabCaricamentiMassivi").style.display = "none";
        document.getElementById("cam").className = "nonAttiva";
        document.getElementById("com").className = "nonAttiva";
        document.getElementById("can").className = "nonAttiva";
        document.getElementById("cri").className = "attiva";
        document.getElementById("car").className = "nonAttiva";
    }

    if (tab == "CaricamentiMassivi") {
        document.getElementById("tabCampagna").style.display = "none";
        document.getElementById("tabComunicazione").style.display = "none";
        document.getElementById("tabCanale").style.display = "none";
        document.getElementById("tabCriteri").style.display = "none";
        document.getElementById("tabCaricamentiMassivi").style.display = "inline";
        document.getElementById("cam").className = "nonAttiva";
        document.getElementById("com").className = "nonAttiva";
        document.getElementById("can").className = "nonAttiva";
        document.getElementById("cri").className = "nonAttiva";
        document.getElementById("car").className = "attiva";
    }
    
}

function visualizza_regole(tab) {

    if (tab == "Campagna") {

        document.getElementById("tabCampagna").style.display = "inline";
        document.getElementById("tabCriteri").style.display = "none";
    }

    if (tab == "Criteri") {
        document.getElementById("tabCampagna").style.display = "none";
        document.getElementById("tabCriteri").style.display = "inline";
    }

}
function visualizzaSpan(variabile1, variabile2) {

    if (document.getElementById(variabile1).value == "1")
        document.getElementById(variabile2).style.display = "inline";
    else
        document.getElementById(variabile2).style.display = "none";
}

function visualizzaCheck(variabile1, variabile2, variabile3, variabile4) {

    if (document.getElementById(variabile1).checked)
    {
        document.getElementById(variabile2).style.display = "inline";
        if (variabile3 != '')
            document.getElementById(variabile3).removeAttribute('disabled');
        if (variabile4 != '')
            document.getElementById(variabile4).setAttribute('disabled', 'disabled');
    }
    else
    {
        document.getElementById(variabile2).style.display = "none";
        if (variabile3 != '')
            document.getElementById(variabile3).setAttribute('disabled', 'disabled');
        if (variabile4 != '')
            document.getElementById(variabile4).removeAttribute('disabled');
    }
}

function disabilitaCheck(variabile1, variabile2, variabile3, variabile4) {

    if (document.getElementById(variabile1).checked)
    {
        document.getElementById(variabile2).style.display = "inline";
        if (variabile3 != '')
            document.getElementById(variabile3).setAttribute('disabled', 'disabled');
        if (variabile4 != '')
            document.getElementById(variabile4).removeAttribute('disabled');
    }
    else
    {
        document.getElementById(variabile2).style.display = "none";
        if (variabile3 != '')
            document.getElementById(variabile3).removeAttribute('disabled');
        if (variabile4 != '')
            document.getElementById(variabile4).setAttribute('disabled', 'disabled');
    }

}

function ctrlDate(data_da, data_a) {
    var g1 = data_da.substring(0, 2);
    var m1 = data_da.substring(3, 5);
    var a1 = data_da.substring(6, 10);
    var data1 = a1 + m1 + g1;
    var g2 = data_a.substring(0, 2);
    var m2 = data_a.substring(3, 5);
    var a2 = data_a.substring(6, 10);
    var data2 = a2 + m2 + g2;
    if (data1 <= data2) {
        return false;
    } else {
        return true;
    }
}

function checkNumber(variabile) {

    var pattern = /^\d+(.\d{2})?$/;
    if (!(pattern.test(variabile))) {
//alert("Il valore inserito non &egrave; un numero");
        return false;
    } else {
//alert("Il valore inserito &egrave; un numero");
        return true;
    }
}

function calcolaIVA(campo1, campo2, flgIVA) {

    if (flgIVA == "siIVA") {

        senzaIVA = Math.round(document.getElementById(campo1).value / 1.22 * 100) / 100;
        document.getElementById(campo2).value = senzaIVA;
    }
    else
    if (flgIVA == "noIVA") {

        conIVA = Math.round(document.getElementById(campo2).value * 1.22 * 100) / 100;
        document.getElementById(campo1).value = conIVA;
    }
}




function onKeyNumericDecimal(e) {
    if (((e.keyCode >= 48) && (e.keyCode <= 57)) || ((e.keyCode > 95) && (e.keyCode < 106)) || (e.keyCode == 8) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode == 8) || (e.keyCode == 109) || (e.keyCode == 37) || (e.keyCode == 39) || (e.keyCode == 190) || (e.keyCode == 110)) {
        return true;
    }
    else
    {
        return false;
    }
}



function trial_check() {


    if ((document.getElementById("trial_campagna").checked)) {
        document.getElementById("data_trial").style.display = "";
        document.getElementById("calendTrial").style.display = "";
        document.getElementById("labelTrial").style.display = "";
        document.getElementById("volume_trial").style.display = "";
        document.getElementById("labelvolume_trial").style.display = "";
    }
    else
    {
        document.getElementById("data_trial").style.display = "none";
        document.getElementById("calendTrial").style.display = "none";
        document.getElementById("labelTrial").style.display = "none";
        document.getElementById("volume_trial").style.display = "none";
        document.getElementById("labelvolume_trial").style.display = "none";
        document.getElementById("volume_trial").value = "0";

    }
    volumeGiornaliero(0);
}
function trial_check_load() {


    if ((document.getElementById("trial_campagna").checked)) {
        document.getElementById("data_trial").style.display = "";
        document.getElementById("calendTrial").style.display = "";
        document.getElementById("labelTrial").style.display = "";
        document.getElementById("volume_trial").style.display = "";
        document.getElementById("labelvolume_trial").style.display = "";
    }
    else
    {
        document.getElementById("data_trial").style.display = "none";
        document.getElementById("calendTrial").style.display = "none";
        document.getElementById("labelTrial").style.display = "none";
        document.getElementById("volume_trial").style.display = "none";
        document.getElementById("labelvolume_trial").style.display = "none";
        document.getElementById("volume_trial").value = "0";

    }
}
function interattivo() {
    if (document.getElementById("mod_invio").value == "Interattivo") {
        document.getElementById("spanLabelLinkTesto").style.display = "inline";
        document.getElementById("labelLinkTesto").style.display = "inline";
        document.getElementById("link").style.display = "inline";
        document.getElementById("spanTipoMonitoring").style.display = "inline";
    }
    else
    {
        document.getElementById("spanLabelLinkTesto").style.display = "none";
        document.getElementById("labelLinkTesto").style.display = "none";
        document.getElementById("link").style.display = "none";
        document.getElementById("spanTipoMonitoring").style.display = "none";
    }
}

*/
function seleziona(campo) {

    campoSelezionato = document.getElementById(campo);
    campoSelezionato.style.background = "yellow";
}

function deseleziona(campo) {

    campoSelezionato = document.getElementById(campo);
    campoSelezionato.style.background = "white";
}

function manageCamp(id, azione, permesso_elimina, stato){
    //alert('eccoloooo ' + id +' '+ azione);
        if(azione==='modifica'){
            document.getElementById("campagnaModifica"+id).submit(); 
        }
    
        if (azione === 'duplica') {
            if (duplica())
                document.getElementById("campagnaDuplica"+id).submit(); 
            
        } 
        if (azione === 'elimina') {
            if(conferma(stato, permesso_elimina))
                document.getElementById("campagnaElimina"+id).submit(); 
            } 
        if(azione==='open'){
            document.getElementById("campagnaOpen"+id).submit(); 
        } 
        if(azione==='new'){
            document.getElementById("campagnaNew"+id).submit(); 
        } 

}

function onKeyNumeric(e) {
    if (((e.keyCode >= 48) && (e.keyCode <= 57)) || ((e.keyCode > 95) && (e.keyCode < 106)) || (e.keyCode == 8) || (e.keyCode == 46) || (e.keyCode == 9) || (e.keyCode == 8) || (e.keyCode == 109) || (e.keyCode == 37) || (e.keyCode == 39)) {
        return true;
    }
    else
    {
        return false;
    }
}

    function conferma(stato, permesso_elimina) {
        if (permesso_elimina == 0) {
            alert("Non hai i permessi per eliminare la campagna!");
            return false;
        }
        if (stato == 0) {
            alert("La campagna non è in uno stato eliminabile");
            return false;
        }
        if (!(confirm('Confermi eliminazione?'))) {
            return false;
        } else {
            return true;
        }
    }
    function duplica() {
        if (!(confirm('Confermi di voler duplicare la campagna?')))
        {
            return false;
        }
        else {
            return true;
        }
    }

    function inserisci() {
        permesso_inserisci = 1;
        if (permesso_inserisci != 1)
            alert("Non hai i permessi per inserire una campagna");
        else
            document.location.href = './index.php?page=inserisciCampagna2';
    }





