<?php
//print_r($_POST);
//echo $_SERVER['HTTP_REFERER'];
$live_no=$_POST['live_no'];
if($_POST['form']=='edit'){
	$dir_tem="/home/webuser/live/www/upload/live_up_img/liver_img_temporary/";
	$dir_pwd="/home/webuser/live/www/upload/live_up_img/".$_POST['live_no']."/";
	if(isset($_POST['del_info'])){
		if(!file_exists($dir_pwd.$_POST['del_info'])){  //編輯頁剛上船的要tem資料夾刪除
		    unlink($dir_tem.$_POST['del_info']);	
		}
		else{
		    unlink($dir_pwd.$_POST['del_info']);  //原本的要在liver資料夾刪除並同時清除DB的img路徑
		    $img_num=substr($_POST['del_info'],10,1);
	        $img_clumn="img".$img_num;
	        $liveconn = mysql_connect('10.50.21.12','achleader','ach1234');
	        $sql="update  live.live_data set $img_clumn=''  where liver_no='$live_no'";
	        mysql_query($sql, $liveconn);
	    }
	}
}
else{ 
	$dir_pwd="/home/webuser/live/www/upload/live_up_img/liver_img_temporary/";
    if(isset($_POST['del_info'])){
    unlink($dir_pwd.$_POST['del_info']);
    }
}
// $dir_pwd="upload/live_up_img/liver_img_temporary/L17080001/";
// if(isset($_POST['del_info'])){
//     unlink($dir_pwd.$_POST['del_info']);

// }

?>