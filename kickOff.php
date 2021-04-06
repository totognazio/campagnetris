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
                    <h2>Modifica Stato Campagne</h2>
                    <ul class="nav navbar-right panel_toolbox">
                      <li><a class="collapse-link"><i class="fa fa-chevron-up"></i></a>
                      </li>
                      <li><a class="close-link"><i class="fa fa-close"></i></a>
                      </li>
                    </ul>
                    <div class="clearfix"></div>
                  </div>
                  <div class="x_content">


            <?php
            if (isset($_POST['cambiaStato'])) {
                echo "<div class=\"info\">";
                echo "<h2>" . $campaign_class->update_kickoff($_POST['checkbox'], intval($_POST['selectNuovoStato'])) . "</h2>";
                echo "</div>";
            }
          

            $lista = $campaign_class->getCampaignsGestione($_SESSION['filter'] ); 
            // print_r($lista);
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
                $funzioni_admin->stampa_select2('selectNuovoStato', $lista_field, $lista_name, $javascript, $style);
                if (isset($_POST['sel1']) && isset($_POST['sel3'])) {
                    echo "<input type=\"hidden\" id=\"sel1\" name=\"sel1\" value=\"" . $_POST['sel1'] . "\" />";
                    echo "<input type=\"hidden\" id=\"sel3\" name=\"sel3\" value=\"" . $_POST['sel3'] . "\" />";
                }
                ?>

            </div>

            <div style="float:left; width:150px; height:80px; margin-top:34px; margin-left:30px;  display:block ">
                <input type="submit" class="btn btn btn-sm btn-info" style="margin-top:15px;" id="cambia" name="cambia" tabindex=""  value="Cambia stato" />
                <input type="hidden" id="cambiaStato" name="cambiaStato" value="1" />
            </div>
<div  class="col-md-12 col-sm-12 col-xs-12" >

                    <div class="table-responsive">
                      <table class="table table-striped jambo_table bulk_action">
                        <thead>
                          <tr class="headings">
                            <th>
                              <input type="checkbox" id="check-all" class="flat">
                            </th>
                            
                            <th class="column-title">Stack </th>
                            <th class="column-title">Sprint </th>
                            <th class="column-title">Squad </th>
                            <th class="column-title">Nome Campagna </th>
                            <th class="column-title">Tipologia </th>
                            <th class="column-title">Canale </th>
                            <th class="column-title">Data Inzio </th>
                            <th class="column-title">Data Fine </th>
                            <th class="column-title">Stato </th>                                                    
                            </th>
                        </tr>
                    </thead>
                    <tbody>
    
                   <?php
                if (1) {
                    $contatore = 1;
                
                    foreach ($lista as $key => $value) {
                        echo "<tr  id=\"riga" . $contatore . "\"  style=\"height:25px;\" onmouseover=\"selezionaRiga(this);\"  onmouseout=\"deselezionaRiga(this);\" > ";
                        echo "
                                <td align=\"center\"><input type=\"checkbox\" class=\"flat\" name=\"checkbox[]\" id=\"checkbox" . $contatore . "\" onclick=\"deselezionaCheckTot(295);\" value=\"" . $value['id'] . "\"/></td>                               
                    
                    <td>" . $value['stacks_nome'] . "</td>
                    <td>" . $campaign_class->sprint_find($value['data_inizio']) . "</td>
                    <td>" . $value['squads_nome'] . "</td>
                    <td>" . $value['pref_nome_campagna'] . "</td>
                    <td>" . $value['tipo_nome'] . "</td>
                    <td>" . $campaign_class->tableChannelLabel($value). "</td>                    
                    <td align=\"center\">" . $value['data_inizio'] . "</td>
                    <td align=\"center\">" . $value['data_fine_validita_offerta'] . "</td>                    
                    <td align=\"center\">" . $value['campaign_stato_nome'] . "</td>";
                        echo "</tr>";
                        $contatore++;
                    }
                }
                ?><tbody></table>
                </div>
                </div>
                </form>

    </div>
     </div>
     </div>
 </div>
 </div>
</div><!-- end .content -->



