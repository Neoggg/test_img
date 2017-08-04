<?php
//print_r($_POST);
$dir_pwd="upload/up_img/";
if(isset($_POST['del_info'])){
    unlink($dir_pwd.$_POST['del_info']);

}

?>