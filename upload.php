<?php
   if(isset($_FILES['file'])){
      $dir = "file/";
      $fileid = $_GET['fileid'];
       
      print_r($_FILES);

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
      
      $file_name = $fileid.'_'. $file_basename;

      $extensions= array("xlsx","txt","xls","xlsm");
      
      if(in_array($file_ext,$extensions)=== false){
         $errors[]="extension not allowed!!!";
      }
      
      if($file_size > 12097152){
         $errors[]='File size must be excately 12 MB';
      }
      
      if(empty($errors)==true){
         //move_uploaded_file($file_tmp,"gestioneLSoc/template/".$file_tmp);
         move_uploaded_file($file_tmp,"file/".$file_name);
         #echo "Success";
      }else{
         print_r($errors);
      }
  }
  elseif($_POST['action']=='delete'){
      $file_basename = $_POST['filename'];
      $fileid = $_POST['fileid'];
      $file_name = $fileid.'_'. $file_basename;
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