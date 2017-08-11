<?php
print_r($_POST);
echo "<br>";
$time=date("Y-m-d H:i:s");
//----------------------直播達人 資料設定--------------------------------------------------------
$live_data=array();
$live_data['status']=$_POST['status'];
$live_data['user_name']=$_POST['name'];
$live_data['sex']=$_POST['sex'];
$live_data['coordination']=$_POST['coordination'];
if($_POST['location']=='else') $live_data['location']=$_POST['location_text'];
else $live_data['location']=$_POST['location'];

$live_data['stage_name']=$_POST['stage_name'];
$live_data['birthday']=$_POST['birth_year']."-".$_POST['birth_month']."-".$_POST['birth_day'];
$live_data['profession']=$_POST['profession'];
$live_data['body']=$_POST['high']."/".$_POST['wight'];
$live_data['address']=$_POST['postal_code']."_".$_POST['address'];

if(isset($_POST['phone'])) $live_data['phone']=$_POST['phone'];
else $live_data['phone']='';

$live_data['cell_phone']=$_POST['cell_phone'];
$live_data['line_id']=$_POST['line_id'];
$live_data['email']=$_POST['email'];
if(isset($_POST['weixin_id'])) $live_data['weixin_id']=$_POST['weixin_id'];
else $live_data['weixin_id']='';

if($_POST['man_has']=='1'){
    if($_POST['manager']=='else') $live_data['manager']=$_POST['manager_text'];
    else $live_data['manager']=$_POST['manager'];
    $live_data['manager_phone']=$_POST['manager_phone'];
}
else{
	$live_data['manager']='';
	$live_data['manager_phone']='';
}

$live_data['category']='';
$live_data['skill']='';
for ($i=0; $i <count($_POST['category']) ; $i++) { 
         $live_data['category']=$_POST['category'][$i].'|'.$live_data['category'];	
         
}

for ($i=0; $i <count($_POST['skill']) ; $i++) { 
         $live_data['skill']=$_POST['skill'][$i].'|'.$live_data['skill'];	
}
$live_data['ex_has']=$_POST['ex_has'];
$live_info=array();

for ($i=0 ;$i <4 ; $i++) { 
  if(isset($_POST['live_check'.($i+1)])){
	$platform='';
	for ($j=0; $j < count($_POST['live_platform'.($i+1)]) ; $j++) { 
		$platform=$_POST['live_platform'.($i+1)][$j]."|".$platform;
	}

		$live_data['live_info'][$i]=$_POST['live_check'.($i+1)]."|".$_POST['live_fan'.($i+1)]."|".$_POST['live_link'.($i+1)]."|".$platform;
  }
  else{
  	$live_data['live_info'][$i]='';
  }

}

$img_array=json_decode($_POST['img_ay']);
$live_data['special_direct']=$_POST['special_direct'];
$live_data['experience']=$_POST['experience'];
//$liver_no='1111';
$no_class="liver_no";
$liver_no=get_num($no_class);
if(!$liver_no){
	echo "編號無產生!!";
	exit;
}
$live_data['$liver_no']=$liver_no;
//----------------------直播達人 資料設定 end-----------------------------------------------------

$liveconn = mysql_connect('10.50.21.12','achleader','ach1234');
$sql ="select * from live.live_data where liver_no='$liver_no'";
$result=mysql_query($sql, $liveconn);
$result_num=mysql_num_rows($result);

if($result_num==0){
	del_move_img($img_array,$liver_no);
    $live_data['img_url']=change_img($liver_no);//取得圖片路徑

        $sql = "insert into live.live_data (id,liver_no,name,status,coordination,stage_name,sex,location,birthday,profession,body,address,phone,cell_phone,line_id,email,weixin_id,manager,manager_phone,category,skill,live_ex,fb_info,17_info,up_info,me_info,img1,img2,img3,img4,img5,special_direct,experience,ins_time,update_time) values ('','".$live_data['$liver_no']."','".$live_data['user_name']."','".$live_data['status']."','".$live_data['coordination']."','".$live_data['stage_name']."','".$live_data['sex']."','".$live_data['location']."','".$live_data['birthday']."','".$live_data['profession']."','".$live_data['body']."','".$live_data['address']."','".$live_data['phone']."','".$live_data['cell_phone']."','".$live_data['line_id']."','".$live_data['email']."','".$live_data['weixin_id']."','".$live_data['manager']."','".$live_data['manager_phone']."','".$live_data['category']."','".$live_data['skill']."','".$live_data['ex_has']."','".$live_data['live_info'][0]."','".$live_data['live_info'][1]."','".$live_data['live_info'][2]."','".$live_data['live_info'][3]."','".$live_data['img_url'][0]."','".$live_data['img_url'][1]."','".$live_data['img_url'][2]."','".$live_data['img_url'][3]."','".$live_data['img_url'][4]."','".$live_data['special_direct']."','".$live_data['experience']."','$time','$time')";
        mysql_query($sql, $liveconn);
}
else{
	echo "會員編號重複!!";
	exit;
}

print_r($live_data);

?>

<?
function get_num($num_class){

$liveconn = mysql_connect('10.50.21.12','achleader','ach1234');
$sql="select * from live.live_num where status='use' AND num_class='$num_class'";
$result= mysql_query($sql, $liveconn);
while ($r=mysql_fetch_array($result)){
	$no=$r['num']; 
}
$num_year=date("Y");
$num_year=substr($num_year,-2);
$num_month=date("m");
$num_month=str_pad($num_month,2,'0',STR_PAD_LEFT);
$num=$no+1;
$num=str_pad($num,4,'0',STR_PAD_LEFT);
$liver_no="L".$num_year.$num_month.$num;
$sql="update live.live_num set num=$no+1 where status='use' AND num_class='$num_class'";
mysql_query($sql, $liveconn);
return $liver_no;
}

function del_move_img($img_array,$live_no){
 $dir=$live_no;
 $pwd="/home/webuser/live/www/upload/live_up_img/";
 $pre_dir="/home/webuser/live/www/upload/live_up_img/liver_img_temporary/";
 
 if(!file_exists($pwd.$dir)){
 $oldmask = umask(0);
 mkdir($pwd.$dir,0777);
 umask($oldmask);
}

foreach ($img_array as $key => $value) {
        
        $pre_name = $pre_dir.$value;
        $name = $pwd.$dir."/".$value;
        copy($pre_name, $name);
        unlink($pre_name);
    
 }
}
function change_img($live_no){
$pwd="/home/webuser/live/www/upload/live_up_img/";
$dirname=$pwd.$live_no."/";
$dh=opendir($dirname);
$return_img_array=array();
$i=1;
while ($dave=readdir($dh))
{
   if ($dave != "." && $dave != "..") { 
	 $ex_name=pathinfo($dirname.$dave,PATHINFO_EXTENSION);
     rename($dirname.$dave,$dirname.$live_no."_".$i.".".$ex_name);
     $return_img_array[$i-1]=$dirname.$live_no."_".$i.".".$ex_name;
     $i++;
    }
}
for ($i=0; $i <5 ; $i++) { 
	if(!isset($return_img_array[$i])){
		$return_img_array[$i]='';
	}
}
closedir ($dh);
return $return_img_array;
}
?>