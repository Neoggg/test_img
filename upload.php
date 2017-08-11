<?php
//print_r($_POST);
//print_r($_FILES);
//exit;
$dir="liver_img_temporary";
$pwd="upload/live_up_img/";
//上傳檔案-----------------------------
if(!file_exists($pwd.$dir)){
 $oldmask = umask(0);
 mkdir($pwd.$dir,0777);
 umask($oldmask);
}
foreach ($_FILES["img_file"]["name"] as $key => $value) {
        
        $tmp_name = $_FILES["img_file"]["tmp_name"][$key];

        $name = $pwd.$dir."/".$_FILES["img_file"]["name"][$key];
        
        move_uploaded_file($tmp_name, $name);
    
}
//更改檔名----------------------------
// $dh=opendir($dirname);
// $i=1;
// while ($dave=readdir($dh))
// {
// if ($dave != "." && $dave != "..") { 
// 	$ex_name=pathinfo($dirname.$dave,PATHINFO_EXTENSION);
// //echo $dave." ";
// rename($dirname.$dave,$dirname.$num.$i.".".$ex_name);
// $i++;
// } 
// }
// closedir ($dh);

?>