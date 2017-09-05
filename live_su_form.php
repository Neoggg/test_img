<?
//print_r($_POST);
//print_r($_FILES);
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
  <script language="JavaScript" type="text/JavaScript" src="/css/jquery-3.2.1.min.js"></script>
<script type="text/javascript">


function check_form(){

    // var all_form=document.forms['su_form'];
    
    // if(!all_form.elements.adv_name.value){
    //   alert("請輸入廣告名稱!")
    //   document.getElementById("adv_name").focus()
    //   resu false;
    //   }
    // if(!all_form.elements.img_file.value){
    //   alert("請上傳檔案!")
    //   document.getElementById("img_file").focus()
    //   resu false;
    //   }
    // if(!all_form.elements.link.value){
    //   alert("請輸入連結!")
    //   document.getElementById("link").focus()
    //   resu false;
    //   }
    // if(!all_form.elements.start_time.value){
    //   alert("請選擇開始時間!")
    //   document.getElementById("start_time").focus()
    //   resu false;
    //   }
    // if(!all_form.elements.end_time.value){
    //   alert("請選擇結束時間!")
    //   document.getElementById("end_time").focus()
    //   resu false;
    //   }
    // if(all_form.elements.end_time.value<all_form.elements.start_time.value){
    //   alert("結束時間大於開始時間，請重新選擇")
    //   document.getElementById("end_time").focus()
    //   resu false;
    //   }
    // var form =document.getElementById("su_form");
    // form.submit();
    
}


</script>

</head>
<body>
<?include('/home/webuser/live/www/adm/header.php');?>
<?include('/home/webuser/live/www/adm/left_bar.html');?>
<form name="su_form" id="su_form" method="POST" action="live_su_check.php" enctype="multipart/form-data"><!-- action="/adm/liver_form_check.php" -->
<input type="hidden" name="cate" value="add">
<table align="left" width="1400" >
  <tr>
  	<td><h3>成功案例</h3></td>  	
  </tr>
</table>
<table align="center" width="800" bgcolor="#f3f3f3" left="100" style="border-radius: 5px;position:relative; right: 300px">
  <tr>
  	<td height=40 >標題: <input size='35' name="su_title" type="text"  id="su_title" value="">
  	</td>
  </tr>
  <tr>
    <td height=40>類別:<input type="text" value="" name="link" id="link">
    </td>
  </tr>
  <tr>
    <td height=120>客戶簡介:<textarea style="width:500px;height:100px;position: absolute;" value='' id="su_custom" name="su_custom"></textarea>
    </td>
  </tr>
  <tr>
    <td height=120>購買方案:<textarea style="width:500px;height:100px;position: absolute;" value='' id="su_buy" name="su_buy"></textarea>
    </td>
  </tr>
  <tr>
    <td height=120>應用:<textarea style="width:500px;height:100px;position: absolute;" value='' id="su_app" name="su_app"></textarea>
    </td>
  </tr>
  <tr>
    <td height=120>行銷效益:<textarea style="width:500px;height:100px;position: absolute;" value='' id="su_effect" name="su_effect"></textarea>
    </td>
  </tr>
  <tr>
    <td height=40>上傳圖片:<input  name="img_file" id="img_file" type="file" value="">
    </td>
  </tr>
  <tr>
    <td height=40>顯示:<input type="checkbox" value="Y" name="su_open" id="su_open">
    </td>
  </tr>
  <tr>
   <td height="40" align="center">
     <input type="button" value="送出" onclick="check_form(); ">
     </td>
   </tr>
</table>
</form>
</body>
</html>