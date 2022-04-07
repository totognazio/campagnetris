<?php
ini_set("max_execution_time", "1000");
set_time_limit(1000);

   if(isset($_FILES['file'])){
      
      $id_upload = $_GET['id_upload'];
      if(isset($_GET['comunicazione'])){
         $dir = "file\\$id_upload\\comunicazione\\";
         
      }
      elseif(isset($_GET['canale'])){
         $dir = "file/$id_upload/canale/";
      }
      
      mkdir($dir, 0777, TRUE);
      //print_r($_FILES);

      $errors= array();
      $file_size =$_FILES['file']['size']; 
      $file_tmp =$_FILES['file']['tmp_name'];
      $file_type=$_FILES['file']['type'];
      $file_name = $_FILES['file']['name'][0];

      
      $info = new SplFileInfo($_FILES['file']['name']);
      #var_dump($info->getExtension());
      
      #$file_ext = strtolower(explode('.',$_FILES['file']['name'])[1]); 
      
      $file_ext = $info->getExtension();
      $file_basename = $info->getBasename();
      
      $file_name = preg_replace("/[^a-z0-9\_\-\.]/i", '_', $file_basename);

      $extensions= array("xlsx","txt","xls","xlsm", "doc", "docx");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed!!!";
      }
      
      if($file_size > 12097152){
         $errors[]='File size must be excately 12 MB';
      }
      
      if(empty($errors)==true){
         //move_uploaded_file($file_tmp,"gestioneLSoc/template/".$file_tmp);
         move_uploaded_file($file_tmp, $dir.$file_name);
         #echo "Success";
      }else{
         print_r($errors);
      }
  }
  elseif(isset($_POST['action']) and $_POST['action']=='delete'){
     if(isset($_POST['subdir'])){
         $subdir = $_POST['subdir'];
     }
     else{
         exit('Need subdir file upload!!!');
     }
      $file_basename = $_POST['filename'];
      $id_upload = $_POST['id_upload'];
      $file_name = $id_upload.'/'.$subdir.'/'. $file_basename;
      echo 'deleteeee  '.$file_name;
      if (file_exists("file/".$file_name)){
         unlink("file/".$file_name); 
      }
      
  }
  //download file
  elseif(isset($_GET['download'])){
     
         $id_upload = $_GET['download'];
         $filename = $_GET['file'];
         if(isset($_GET['com'])){
            $dir = "file\\$id_upload\\comunicazione\\";         
         }
         elseif(isset($_GET['canale'])){
            $dir = "file\\$id_upload\\canale\\";   
         }
         else{
            exit('Download Error !!!');
         }
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
  
      
}
?>
