<?php
/*
  if ($page_protect->get_access_level() > 5) {
  echo "<p><a href=\"./index.php?page=grafici&tipo_grafico=aggiorna_info_modello\">Gestione TD</a><p>";
  echo "<p><a href=\"./export_statistiche.php?function=tabella_specifiche\">Export RFI</a></p>
  <p><a href=\"index.php?page=gestoreCampi\">Modifica RFI</a></p>";
  }statistiche_automatiche_citta.php
 */


if ($page_protect->get_access_level() > 6) {
    ?>

    <div class="col-md-12 col-sm-12 col-xs-12">
        <div class="x_panel">
            <div class="x_title">
                <h2>Administration and Settings <small></small></h2>
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
                <div class="">
                    <ul class="to_do">
     
                                          
                        <li><p><a href="index.php?page=update_MDMtable">1. Update Table MDM from CSV</a></p></li>
                        <li><p><a href="index.php?page=insert_tacid_complete">2. Update Table DatiTacId from MDM</a></p></li>  
                        

                        
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <?php
}
?>