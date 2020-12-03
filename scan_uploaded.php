 <?php

 $dir = "file/";
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