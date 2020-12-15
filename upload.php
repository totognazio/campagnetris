<?php
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
      
      $file_name = $file_basename;

      $extensions= array("xlsx","txt","xls","xlsm");
      
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
  elseif($_POST['action']=='delete'){
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
      unlink("file/".$file_name); 
  }
?>
<!--
<html>
   <body>
      
      <form action="" method="POST" enctype="multipart/form-data">
         <input type="file" name="file" />
         <input type="submit"/>
      </form>
      
   </body>
</html>

-->