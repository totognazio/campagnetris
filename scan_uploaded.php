 <?php

//print_r($_POST);
if (isset($_POST['id_dir'])) {
    $id_dir = $_POST['id_dir'];
}
else{
    exit('error in id_dir scan_upload.php');
}
if (isset($_POST['subdir'])) {
    $subdir = $_POST['subdir'];
}
else{
    exit('error in subdir scan_upload.php');
}

 $dir = "file/".$id_dir."/".$subdir."/";
 $result  = array();
 
    $files = scandir($dir);                
    if ( false!==$files ) {
        foreach ( $files as $file ) {
            if ( '.'!=$file && '..'!=$file) {       
                $obj['name'] = $file;
                $obj['size'] = filesize($dir.$file);
                $result[] = $obj;
            }
        }
    }
     
    //header('Content-type: text/json');           
    //header('Content-type: application/json');
    echo json_encode($result);