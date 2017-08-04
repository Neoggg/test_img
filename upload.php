<?php
//print_r($_POST);
//print_r($_FILES);
exit;
$pwd="upload/up_img/";
$time=Date('Y-m-d h:i:s');

$num=1;
foreach ($_FILES["img_file"]["name"] as $key => $value) {
        
        $tmp_name = $_FILES["img_file"]["tmp_name"][$key];
        $name = $pwd.$_FILES["img_file"]["name"][$key];
        
        move_uploaded_file($tmp_name, $name);
    
}

?>