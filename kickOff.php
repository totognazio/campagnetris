<?php
include_once './classes/funzioni_admin.php';
include_once './classes/campaign_class.php';

$funzioni_admin = new funzioni_admin();
$campaign_class = new campaign_class();
$rand=  rand();
?>
    <script type="text/javascript" src="calendario/calendar.js<?php echo "?".$rand; ?>"></script>
    <script type="text/javascript" src="calendario/calendar-it.js<?php echo "?".$rand; ?>"></script>
    <script type="text/javascript" src="calendario/funzioniCalendario.js<?php echo "?".$rand; ?>"></script>
    <link rel="stylesheet" type="text/css" media="all" href="calendario/skins/aqua/theme.css " title="Aqua" />
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

    function seleziona(campo) {

        campoSelezionato = document.getElementById(campo);
        campoSelezionato.style.background = "orange" //"#FF8000";
    }

    function deseleziona(campo) {

        campoSelezionato = document.getElementById(campo);
        campoSelezionato.style.background = "white";
    }

    function selezionaRiga(riga) {
        riga.className = "selezionata";
    }

    function deselezionaRiga(riga) {
        riga.className = "bianco";
    }


    function cancella(data) {
        if (window.event.keyCode)
            document.getElementById(data).value = "";
    }


    function ctrlDate(data_da, data_a) {

        var fromArray = data_da.split('/');
        fromdate = new Date(fromArray[2], fromArray[1] - 1, fromArray[0]);

        var toArray = data_a.split('/');
        todate = new Date(toArray[2], toArray[1] - 1, toArray[0]);
        diff = ((todate - fromdate) / 86400000);

        if (diff < 0)  {
            alert('Attenzione: La data di fine è antecedente la data inizio');
            return true;
        }

    }



    function controllaform() {

        Errore = "Attenzione non hai compilato tutti i campi obbligatori:\n\n";

        if (document.getElementById('sel1').value == "") {
            Errore = Errore + "- data inizio\n";
        }
        if (document.getElementById('sel3').value == "") {
            Errore = Errore + "- data fine\n";
        }
        if (document.getElementById('selectStato').value == "") {
            Errore = Errore + "- stato\n";
        }

        if ((document.getElementById('sel1').value != "") && (document.getElementById('sel3').value != ""))
        {

            ctlDate = ctrlDate(document.getElementById('sel1').value, document.getElementById('sel3').value);

            if (ctlDate)
            {
                //alert('Attenzione: La data di inizio è antecedente la data fine');
                return false;

            }

        }

        if (Errore == "Attenzione non hai compilato tutti i campi obbligatori:\n\n") {

            return true;
        }
        else {
            alert(Errore);
            return false;
        }
    }
    function controllaform2() {

        Errore = "Attenzione non hai compilato tutti i campi obbligatori:\n\n";
        temp = true;
        if (document.getElementById('selectNuovoStato').value == "") {
            Errore = Errore + "- Nuovo Stato\n";
            temp = false;
        }
        if (temp) {

            return true;
        }
        else {
            alert(Errore);
            return false;
        }
    }
    function selectAll(num) {

        if (document.getElementById('checkboxTot').checked)
        {
            for (i = 0; i < num; i++)
                document.getElementById('checkbox' + i).checked = true;
        }
        else
        {
            for (i = 0; i < num; i++)
                document.getElementById('checkbox' + i).checked = false;
        }
    }

    function deselezionaCheckTot(num) {

        var nocheck = 0;

        for (i = 0; i < num; i++) {

            if (document.getElementById('checkbox' + i).checked == false)
                nocheck++;

        }

        if (nocheck == 0)
            document.getElementById('checkboxTot').checked = true;
        else
            document.getElementById('checkboxTot').checked = false;

    }

    function controllaStato(num) {

        var check = 0;

        for (i = 0; i < num; i++) {

            if (document.getElementById('checkbox' + i).checked == true)
                check++;

        }

        if (check == 0) {
            alert('Seleziona almeno una campagna'); // document.getElementById('checkboxTot').checked=true;
            return false;
        }


        stato = document.getElementById('selectStato').value;
        nuovoStato = document.getElementById('selectNuovoStato').value;

        if (nuovoStato == "")
        {
            alert("Inserisci il nuovo stato");
            return false;
        }
        else
        if (stato == nuovoStato)
        {
            alert("Il nuovo stato deve essere diverso dal vecchio stato!");
            return false;
        }
        else {
            return true;
        }

    }

-->
</script>

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
                    <h2>Kick Off</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content"> 


<div class="content">
    <div class="finestra" style="width:97%; min-height:400px; padding:5px;">
        <div class="wufoo">
            <?php
            if (isset($_POST['cambiaStato'])) {
                echo "<div class=\"info\">";
                echo "<h2>" . $campaign_class->update_kickoff($_POST['checkbox'], intval($_POST['selectNuovoStato'])) . "</h2>";
                echo "</div>";
            }
            ?>
        </div>
        <form id="formDate" name="formDate" action="index.php?page=kickOff" method="post" onsubmit="return controllaform();">

            <div style="float:left; width:150px; height:80px; margin-top:25px; margin-left:30px;">
                <label>Data inizio<span id="req_1" class="req">*</span></label>
                <input class="text" type="text" name="sel1" id="sel1"
                <?php
                if (isset($_POST['sel1'])) {
                    echo " value=" . $_POST['sel1'];
                }
                ?>  tabindex="24"  readonly="readonly" onfocus="seleziona('sel1');" onblur="deseleziona('sel1');" onkeyup="cancella('sel1')"/>
                <input style="width:15px" type="image" id="calendInizio" tabindex="25"  alt="Calendario" src="images/Calendario.gif" value="Calendario" onclick="return showCalendar('sel1', '%d/%m/%Y');" />         
            </div>
            <div style="float:left; width:150px; height:80px; margin-top:25px; margin-left:30px;">
                <label>Data fine<span id="req_2" class="req">*</span></label>
                <input class="text" type="text" name="sel3" id="sel3" tabindex="24" 
                <?php
                if (isset($_POST['sel3'])) {
                    echo " value=" . $_POST['sel3'];
                }
                ?> 
                       readonly="readonly" onfocus="seleziona('sel3');" onblur="deseleziona('sel3');" onkeyup="cancella('sel3')"/>
                <input style="width:15px" type="image" id="calendFine" tabindex="25" alt="Calendario" src="images/Calendario.gif" value="Calendario" onclick="return showCalendar('sel3', '%d/%m/%Y');" />         
            </div>

            <div style="float:left; width:150px; height:80px; margin-top:25px; margin-left:30px;">
                <label>Stato<span id="req_3" class="req">*</span></label>
                <?php
                $list = $funzioni_admin->get_list_id('campaign_states');
                $lista_field = array_column($list, 'id');
                $lista_name = array_column($list, 'name');
                $javascript = " tabindex=\"7\" onfocus=\"seleziona('selectStato');\" onblur=\"deseleziona('selectStato');\" ";
                $style = " style=\"width:150px;\" ";
                if (isset($_POST['selectStato'])) {
                    $selectStato_default = $_POST['selectStato'];
                } else
                    $selectStato_default = "";
                $funzioni_admin->stampa_select('selectStato', $lista_field, $lista_name, $javascript, $style, $selectStato_default);
                ?>

            </div>

            <div style="float:left; width:150px; height:80px; margin-top:25px; margin-left:30px;">
                <input type="submit" style="margin-top:15px;" id="vai" name="vai" tabindex="" value="Vai" />
                <input type="hidden" id="esegui" name="esegui" value="1" />
            </div>

        </form>
        <?php
        $lista = array();
        if (isset($_POST['esegui'])) {
            $calendInizio = $campaign_class->data_it_to_eng_($_POST['sel1']);
            $calendFine = $campaign_class->data_it_to_eng_($_POST['sel3']);

            $lista = $campaign_class->get_list_kick_off($calendInizio, $calendFine, $_POST['selectStato']);
        }
        ?>
        <form id="formCambiaStato" name="formCambiaStato" action="./index.php?page=kickOff" method="post" onsubmit="return controllaStato(<?php echo count($lista); ?>);">

            <div style="float:left; width:150px; height:80px; margin-top:25px; margin-left:30px;  display:block ">
                <label>Nuovo stato<span id="req_4" class="req">*</span></label>
                <?php
                $list = $funzioni_admin->get_list_id('campaign_states');
                $lista_field = array_column($list, 'id');
                $lista_name = array_column($list, 'name');
                $javascript = "  tabindex=\"7\" onfocus=\"seleziona('selectNuovoStato');\" onblur=\"deseleziona('selectNuovoStato');\" ";
                $style = " style=\"width:150px;\" ";
                $funzioni_admin->stampa_select('selectNuovoStato', $lista_field, $lista_name, $javascript, $style);
                if (isset($_POST['sel1']) && isset($_POST['sel3'])) {
                    echo "<input type=\"hidden\" id=\"sel1\" name=\"sel1\" value=\"" . $_POST['sel1'] . "\" />";
                    echo "<input type=\"hidden\" id=\"sel3\" name=\"sel3\" value=\"" . $_POST['sel3'] . "\" />";
                }
                ?>

            </div>

            <div style="float:left; width:150px; height:80px; margin-top:25px; margin-left:30px;  display:block ">
                <input type="submit" style="margin-top:15px;" id="cambia" name="cambia" tabindex=""  value="Cambia stato" />
                <input type="hidden" id="cambiaStato" name="cambiaStato" value="1" />
            </div>


            <table class="bordo tabella">
                <tr style="height:25px; font-weight: bold; background: url('./images/wbg.gif') repeat-x 0px -1px;">
                    <td align="center" width="1%"><input type="checkbox" name="checkboxTot" id="checkboxTot" onclick="selectAll(295);" /></td>
                    <td align="center" width="1%">N.</td>
                    <td align="center" width="10%">Nome Campagna</td>
                    <td align="center" width="15%">Gruppo</td>
                    <td align="center" width="10%">Tipo</td>
                    <td align="center" width="10%">Canale</td>
                    <td align="center" width="10%">Ottimizz.</td>
                    <td align="center" width="10%">Data inizio</td>
                    <td align="center" width="10%">Data fine</td>
                    <td align="center" width="10%">Volume Totale</td>
                    <td align="center" width="10%">Stato</td>
                </tr>

                <?php
                if (isset($_POST['esegui'])) {
                    $contatore = 1;
                    foreach ($lista as $key => $value) {
                        echo "<tr  id=\"riga" . $contatore . "\"  style=\"height:25px;\" onmouseover=\"selezionaRiga(this);\"  onmouseout=\"deselezionaRiga(this);\" > ";
                        echo "
                                <td align=\"center\"><input type=\"checkbox\" name=\"checkbox[]\" id=\"checkbox" . $contatore . "\" onclick=\"deselezionaCheckTot(295);\" value=\"" . $value['id'] . "\"/></td>
                                <td align=\"center\">" . $contatore . "</td>
                    <td>" . $value['nome_campagna'] . "</td>
                    <td>" . $value['stack_nome'] . "</td>
                    <td>" . $value['tipo_nome'] . "</td>
                    <td>" . $value['channel_nome'] . "</td>
                    <td align=\"center\">" . $value['optimization'] . "</td>
                    <td align=\"center\">" . $campaign_class->data_eng_to_it_($value['data_inizio']) . "</td>
                    <td align=\"center\">" . $campaign_class->data_eng_to_it_($value['data_fine']) . "</td>
                    <td align=\"center\">" . $value['volume'] . "</td>
                    <td align=\"center\">" . $value['campaign_stato_nome'] . "</td>";
                        echo "</tr>";
                        $contatore++;
                    }
                }
                ?></table></form>

    </div>

</div><!-- end .content -->

                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
        <!-- /page content -->

