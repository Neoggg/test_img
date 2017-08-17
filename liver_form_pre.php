<?php
echo "aaa";
$liveconn = mysql_connect('10.50.21.12','achleader','ach1234');
print_r($_POST);
echo "pre"."<br>";
$time=date("Y-m-d H:i:s");
//----------------------直播達人 資料設定--------------------------------------------------------
$live_data=array();
$live_data['status']=$_POST['status'];
$live_data['name']=$_POST['name'];
$live_data['sex']=$_POST['sex'];
$live_data['coordination']=$_POST['coordination'];
$live_data['location']=$_POST['location'];
if($live_data['location']!='taiwan'&&$live_data['location']!='china'){
  $live_data['location_text']=$live_data['location'];
}
else $live_data['location_text']="";

$live_data['stage_name']=$_POST['stage_name'];
$live_data['birth_year']=$_POST['birth_year'];
$live_data['birth_month']=$_POST['birth_month'];
$live_data['birth_day']=$_POST['birth_day'];
$live_data['profession']=$_POST['profession'];
$live_data['high']=$_POST['high'];
$live_data['wight']=$_POST['wight'];
$live_data['postal_code']=$_POST['postal_code'];
$live_data['address']=$_POST['address'];

if(isset($_POST['phone'])) $live_data['phone']=$_POST['phone'];
else $live_data['phone']='';

$live_data['cell_phone']=$_POST['cell_phone'];
$live_data['line_id']=$_POST['line_id'];
$live_data['email']=$_POST['email'];
if(isset($_POST['weixin_id'])) $live_data['weixin_id']=$_POST['weixin_id'];
else $live_data['weixin_id']='';

if($_POST['manager']=='-1') $live_data['manager']='';
else $live_data['manager']=$_POST['manager'];
$live_data['manager_phone']=$_POST['manager_phone'];
$live_data['man_has']=$_POST['man_has'];

if($live_data['man_has']=='1'){
	if($live_data['manager']!='經紀公司1'&&$live_data['manager']!='經紀公司1'){
	  $live_data['manager_text']=$live_data['manager'];
	}
	else $live_data['manager_text']="";
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
		$live_data['live_fan'.($i+1)]=$_POST['live_fan'.($i+1)];
		$live_data['live_link'.($i+1)]=$_POST['live_link'.($i+1)];
}

$img_array=json_decode($_POST['img_ay']);//圖片解碼
if(isset($_POST['img_ay_user']))$img_array_user=json_decode($_POST['img_ay_user']);//edit原有圖片解碼

$live_data['special_direct']=$_POST['special_direct'];
$live_data['experience']=$_POST['experience'];
echo "<br>";
print_r($live_data);

//----------------------直播達人 資料設定 end-----------------------------------------------------

?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<script language="JavaScript" type="text/JavaScript" src="/css/jquery-3.2.1.min.js"></script>
<script type="text/javascript">
	$(function () { //顯示經紀人table
        if($("#else").attr('checked')){   //修改頁 location else 顯示text     
       			$("#location_text").show();
  			}

  		if($("#man_has").attr('checked')){  //修改頁 man_has 顯示table      
       			$("#manager_table").show();
  			}
  
  		if($("#man_else").attr('selected')){  //修改頁 man_has 顯示table      
       			$("#manager_text").show();
  			}      
    
  });
</script>
</head>
<body id="body">
<form name="liver_form" id="liver_form" method="POST"  enctype="multipart/form-data">
<input type="hidden" name="img_ay" id="img_ay">
<input type="hidden" name="img_ay_user" id="img_ay_user">
<input type="hidden" name="live_no" id="live_no" value="<?=$live_no?>">
<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td><h4>基本資料</h4></td>
  	<td >*狀態:
  	    <input type="radio" name="status" id="status" value="online" <? if ($live_data['status']=="online") echo "checked"; ?>>上線
  	    <input type="radio" name="status" value="offline" <? if ($live_data['status']=="offline") echo "checked"; ?>>下線
  	    <input type="radio" name="status" value="wait" <? if ($live_data['status']=="wait") echo "checked"; ?>>待審核
  	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	    *配合度:<select name="coordination" id="coordination">
        <option value="-1" >請選擇</option>　      
        <option value="1" <? if ($live_data['coordination']==1) echo "selected"; ?>>配合度1</option>
　      <option value="2" <? if ($live_data['coordination']==2) echo "selected"; ?>>配合度2</option>
        </select>
  	</td>
  </tr>
</table>

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr >
  	<td height=40>*真實姓名:<input  name="name" type="text"  id="name" value="<?=$live_data['name']?>">
  	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	    *性別:
  	    <input type="radio" id="sex" name="sex" value="1" <? if ($live_data['sex']==1) echo "checked"; ?>>男
  	    <input type="radio" name="sex" value="0" <? if ($live_data['sex']==0) echo "checked"; ?>>女<!-- <? if ($sex==0) echo "selected"; ?> -->
  	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	    *地區:
  	    <input type="radio" id="location" name="location" value="taiwan" onclick="if(this.checked)showlocation(this.value);" <?if($live_data['location']=="taiwan") echo "checked";?>>台灣
  	    <input type="radio" name="location" value="china" onclick="if(this.checked)showlocation(this.value);" <?if($live_data['location']=="china") echo "checked";?>>大陸
        <input type="radio" id="else" name="location" value="else" onclick="if(this.checked)showlocation(this.value);" <?if($live_data['location']!="taiwan"&&$live_data['location']!="china"&&$live_data['location']!='') echo "checked";?>>其他
  	    <input  id="location_text" name="location_text" type="text" size="10" value="<?=$live_data['location_text']?>" style="display:none;">
  	</td>
  </tr>
</table>

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td height=40>*藝名:<input id="stage_name" name="stage_name" type="text" value="<?=$live_data['stage_name']?>">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	*出生年月日:
  		<select name="birth_year" id="birth_year">
                  <option value="-1" selected="selected">--</option>
<?for($i=1900;$i<date("Y");$i++){?>
                  <option value="<?=$i;?>"<?echo ($live_data['birth_year']==$i)?" selected":"";?>><?=$i;?> </option>
<?}?>
                  </select>
年
                  <select name="birth_month" id="birth_month">
                  <option value="-1">--</option>
<?for($i=1;$i<13;$i++){?>
                  <option value="<?=$i;?>"<?echo ($live_data['birth_month']==$i)?" selected":"";?>><?=$i;?> </option>
<?}?>
                  </select>
月
                  <select name="birth_day" id="birth_day">
                  <option value="-1">--</option>
<?for($i=1;$i<32;$i++){?>
                  <option value="<?=$i;?>"<?echo ($live_data['birth_day']==$i)?" selected":"";?>><?=$i;?> </option>
<?}?>
                  </select>
        日
  	</td>
  </tr>

  <tr>
  	<td height=40>
    *身高/體重:<input  id="high" name="high" type="text" size="5" value="<?=$live_data['height']?>">公分/<input id="wight" name="wight" type="text" size="5" value="<?=$live_data['wight']?>">公斤
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	*職業:<input id="profession" name="profession" type="text" value="<?=$live_data['profession']?>"></td>
  </tr>	
</table>
<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td><h4>聯絡資料</h4></td>
  </tr>

  <tr>
  	<td height=40 width="60%">*聯絡地址:<input id="postal_code" name="postal_code" type="text" size="5" placeholder="郵遞區號" value="<?=$live_data['postal_code']?>"><!-- <td height=40 width="60%">*聯絡地址:<input  style="color:#a0a0a1" name="postal_code" type="text" size="5" value="郵遞區號" color="#a0a0a1" onMouseDown="window.status='郵遞區號';if(this.value=='郵遞區號') this.value=''";> -->&nbsp;<input id="address" name="address" type="text" size="80" value="<?=$live_data['address']?>"></td>
  </tr>
</table>
<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td height=40>聯絡電話: 市話:<input  name="phone" type="text" value="<?=$live_data['phone']?>">&nbsp;&nbsp;&nbsp;&nbsp;
  	*手機:<input id="cell_phone" name="cell_phone" type="text" value="<?=$live_data['cell_phone']?>">&nbsp;&nbsp;&nbsp;&nbsp;
  	*LINE ID:<input  id="line_id" name="line_id" type="text" value="<?=$live_data['line_id']?>">
    </td>
  </tr>
  <tr>
    <td height=40>E-MAIL:<input id="email" name="email" type="email" value="<?=$live_data['email']?>" size="60">&nbsp;&nbsp;&nbsp;&nbsp;
    *微信 ID:<input  name="weixin_id" type="text" value="<?=$live_data['weixin_id']?>">
    </td>
  </tr>
</table align="center" width="85%" bgcolor="#f3f3f3">

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td height="40">*是否有經紀約:
  	    <input type="radio" id="man_has" name="man_has" value="1" <?if($live_data['manager']!="")echo "checked"?>>有
  	    <input type="radio" id="man_no" name="man_has" value="0" <?if($live_data['manager']=="")echo "checked"?>>無
  	</td>
  </tr>
  </table>
  <table id="manager_table" align="center" width="85%" bgcolor="#f3f3f3" style="display: none">
  <tr>
  	<td>
  	經紀人/經紀公司:<select id="manager" name="manager" onchange="manager_change(this.value)">
        <option value="-1">請選擇</option>　      
        <option value="經紀公司1" <?if($live_data['manager']=="經紀公司1") echo "selected"?>>經紀公司1</option>
　      <option value="經紀公司2" <?if($live_data['manager']=="經紀公司2") echo "selected"?>>經紀公司2</option>
        <option id="man_else" value="else" <?if($live_data['manager']!="經紀公司1"&&$live_data['manager']!="經紀公司2"&&$live_data['manager']!="") echo "selected"?>>其他</option>
        </select>
        <input  id="manager_text" name="manager_text" type="text" size="50" value="<?=$live_data['manager_text']?>" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;聯絡電話(經紀人/公司):<input id="manager_phone" name="manager_phone" type="text" value="<?=$live_data['manager_phone']?>">
    </td>
  </tr>
</table>

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
    <td><h4>經歷資料</h4></td>
  </tr>
  <tr>
    <td height="40">*分類:
      <input id="category" type="checkbox" value="美食" name="category[]" <?if(preg_match("/美食/",$live_data['category'])) echo "checked"?>>美食
      <input type="checkbox" value="美妝" name="category[]" <?if(preg_match("/美妝/",$live_data['category'])) echo "checked"?>>美妝
      <input type="checkbox" value="遊戲" name="category[]" <?if(preg_match("/遊戲/",$live_data['category'])) echo "checked"?>>遊戲
      <input type="checkbox" value="生活" name="category[]" <?if(preg_match("/生活/",$live_data['category'])) echo "checked"?>>生活
      <input type="checkbox" value="拍賣" name="category[]" <?if(preg_match("/拍賣/",$live_data['category'])) echo "checked"?>>拍賣
    </td>
  </tr>
  <tr>
    <td height="40">*特殊才藝:
      <input id="skill" type="checkbox" value="唱歌" name="skill[]" <?if(preg_match("/唱歌/",$live_data['skill'])) echo "checked"?>>唱歌
      <input type="checkbox" value="跳舞" name="skill[]" <?if(preg_match("/跳舞/",$live_data['skill'])) echo "checked"?>>跳舞
      <input type="checkbox" value="吉他" name="skill[]" <?if(preg_match("/吉他/",$live_data['skill'])) echo "checked"?>>吉他
      <input type="checkbox" value="烏克麗麗" name="skill[]" <?if(preg_match("/烏克麗麗/",$live_data['skill'])) echo "checked"?>>烏克麗麗
      <input type="checkbox" value="鋼琴" name="skill[]" <?if(preg_match("/鋼琴/",$live_data['skill'])) echo "checked"?>>鋼琴
      <input type="checkbox" value="長笛" name="skill[]" <?if(preg_match("/長笛/",$live_data['skill'])) echo "checked"?>>長笛
      <input type="checkbox" value="爵士鼓" name="skill[]" <?if(preg_match("/爵士鼓/",$live_data['skill'])) echo "checked"?>>爵士鼓
      <input type="checkbox" value="電子琴" name="skill[]" <?if(preg_match("/電子琴/",$live_data['skill'])) echo "checked"?>>電子琴
      <input type="checkbox" value="魔術" name="skill[]" <?if(preg_match("/魔術/",$live_data['skill'])) echo "checked"?>>魔術
      <input type="checkbox" value="遊戲實況" name="skill[]" <?if(preg_match("/遊戲實況/",$live_data['skill'])) echo "checked"?>>遊戲實況
    </td>
  </tr>
  <tr>
    <td height="40">是否有直播經驗:
       <input type="radio" id="ex_has" name="ex_has" value="1" <?if($live_data['ex_has']='1') echo "checked"?>>有
       <input type="radio" name="ex_has" value="0" <?if($live_data['ex_has']='0') echo "checked"?>>無
    </td>
  </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
    <td height="40">直播平台:</td>
  </tr>
  <tr>
    <!-- <td height="40"><input type="checkbox" id="live_check1" value="fb" name="live_check1" <?if($live_data['fb_info'][0]=='fb') echo "checked"?>>FB</td>
    <td height="40">粉絲數 <input type="text" id="live_fan1" name="live_fan1" value="<?=$live_data['fb_info'][1]?>">人/ 連結:<input type="text" id="live_link1" name="live_link1" value="<?=$live_data['fb_info'][2]?>" size="60">&nbsp;&nbsp;&nbsp;&nbsp;可觀看平台: 
     <input type="checkbox" id="live_platform1" name="live_platform1[]" value="mobile" <?if(preg_match("/mobile/",$live_data['fb_info'][3])||preg_match("/mobile/",$live_data['fb_info'][4])) echo "checked"?>>手機
     <input type="checkbox"  name="live_platform1[]" value="web" <?if(preg_match("/web/",$live_data['fb_info'][3])||preg_match("/web/",$live_data['fb_info'][4])) echo "checked"?>>電腦
    </td> -->
    <td height="40">FB</td>
    <td height="40">粉絲數 <input type="text" id="live_fan1" name="live_fan1" value="<?=$live_data['live_fan1']?>">人/ 連結:<input type="text" id="live_link1" name="live_link1" size="60" value="<?=$live_data['live_link1']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  <tr>
    <td height="40">17直播</td>
    <td height="40">粉絲數 <input type="text" id="live_fan2" name="live_fan2" value="<?=$live_data['live_fan2']?>">人/ 連結:<input type="text" id="live_link2" name="live_link2" size="60" value="<?=$live_data['live_link2']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  <tr>
   <td height="40">UP直播</td>
    <td height="40">粉絲數 <input type="text" id="live_fan3" name="live_fan3" value="<?=$live_data['live_fan3']?>">人/ 連結:<input type="text" id="live_link3" name="live_link3" size="60" value="<?=$live_data['live_link3']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
  <tr>
    <td height="40">Liveme</td>
    <td height="40">粉絲數 <input type="text" id="live_fan4" name="live_fan4" value="<?=$live_data['live_fan4']?>">人/ 連結:<input type="text" id="live_link4" name="live_link4" size="60" value="<?=$live_data['live_link4']?>">&nbsp;&nbsp;&nbsp;&nbsp;
    </td>
  </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
   <tr>
     <td><h4>照片上傳:(請上傳5張照片，檔案大小不可超過1MB)</h4></td>
   </tr>
</table>
<table  align="center" width="85%" bgcolor="#f3f3f3">
   <tr >
     <td>
       
        <input type="file" name="img_file[]" id="img_file" size="20" onchange="readimg_multiple(this);console.log(this.value);" style="display: none;" accept="image/jpeg,image/gif,image/png" multiple>
        <div id="preview_img1" ><?
        for ($i=0; $i <=4 ; $i++) { 
            if(isset($img_array[$i])&&$img_array[$i]!=''){
              $img_dir_tem="/upload/live_up_img/liver_img_temporary/";
              $live_src=$img_dir_tem.$img_array[$i];   
              echo '<div  style="padding-right:10px; display : inline-block; position : relative;"><img  src='.$live_src.' width="200" height="150" class="pre_img_user" /></div>';
            }
        }
        ?>
       </div> <!-- 預覽圖片位置 -->
    <div id="searchResult"></div>
     </td>
   </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
   <tr>
     <td><h4>特色說明：(字數限制30字)</h4></td>
   </tr>
   <tr>
     <td ><input type="text" id="special_direct" name="special_direct" size="120" value="<?=$live_data['special_direct']?>"></td>
   </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
   <tr>
    <!-- <img src="/images/glyphicons-17-bin.png" onclick="set_content()"> -->
     <td><h4>個人經歷：</h4> <a style="color:red">(注意：字數上限為9000個字元，總容量包含圖檔不可超過 500K ，2個字元等於1個中文字) 
     </a></td>
   </tr>
   <tr>
     <td><div><?=$live_data['experience']?></div></td>
   </tr>
   <tr>
     <td height="40" align="center"><input type="button" value="送出資料" onclick="check_form();"></td>
   </tr>
</table>
</form>
</body>
</html>