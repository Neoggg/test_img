<?php
//print_r($_POST);
$dir_pwd="upload/live_up_img/liver_img_temporary/";
if(isset($_POST['del_info'])){
    unlink($dir_pwd.$_POST['del_info']);

}

?>