<?php

/*
         $id_upload = $_GET['download'];
         $filename = $_GET['file'];
         if(isset($_GET['com'])){
            $dir = "file\\$id_upload\\comunicazione\\";         
         }
         elseif(isset($_GET['canale'])){
            $dir = "file\\$id_upload\\canale\\";   
         }
         elseif(isset($_GET['import_campagne'])){
            $dir = "file\\$id_upload\\import_campagne\\";   
         }
         else{
            exit('Download Error !!!');
         }
*/

$filename = "template_import_campagne.xlsx";
$file_path = '';
         $file_path = $dir.$filename;
         // verifico che il file esista
         if (!file_exists($file_path))
         {
         // se non esiste stampo un errore
         echo "Il file non esiste!";
         }else{
         // Se il file esiste...
         // Imposto gli header della pagina per forzare il download del file
         header("Cache-Control: public");
         header("Content-Description: File Transfer");
         header("Content-Disposition: attachment; filename= " . $filename);
         header("Content-Transfer-Encoding: binary");
         // Leggo il contenuto del file
         readfile($file_path);
         }
  
      
