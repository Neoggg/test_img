<?php
$birth_year='';
$birth_month='';
$birth_day='';
$sex=0;
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
<script language="JavaScript" type="text/JavaScript" src="/css/jquery-3.2.1.min.js"></script>
<script language="JavaScript" src="/tinymce/tinymce.min.js"></script>
<script language="JavaScript" type="text/JavaScript">
function showlocation(value) {
  //var loc_e = document.getElementById('else')
  if(value=='else'){
    //alert(value)
    $("#location_text").show();
  }
  else{
    //alert(value)
   $("#location_text").hide();
  }
}

function manager_change(value) {
  var m = document.getElementById('manager')
  if(value=='else'){
    $("#manager_text").show();
  }
  else{
    $("#manager_text").hide();
  }
}

function readimg_multiple(input) {

 var file_array= Math.random().toString(36).substring(2,6)

 var pre_sum= document.getElementsByClassName('pre_img').length //抓class算長度
 var file_can_use=0
 file_can_use=5-pre_sum
 if(input.files.length>file_can_use){
    alert('最多只能上傳5張照片');
    return false;
}
    
if (input.files && input.files[0]) {
               $("#add_new").remove()
               var filelist = document.getElementById(input.id).files;
               var fd = new FormData();
               var xhr = new XMLHttpRequest();
               var up_progress = document.getElementById('up_progress');
               xhr.open('POST', '/upload.php',true)
              
              for($i=0;$i<filelist.length;$i++){    
                
                var div_str='<div id="' +"div_"+ file_array+"_"+filelist[$i].name + '" name="' +"div_"+ file_array+"_"+filelist[$i].name + '"  style="display : inline-block; position : relative;"><img id="load"  name="' +"load_"+ file_array+"_"+filelist[$i].name + '" align="center" src="/images/loader06.gif" style=" display: none; position:absolute; top:0; right:4;"></div>'; //先生成預覽圖所需要div
                $('#preview_img1').append(div_str);
                
                var file= filelist[$i]                             
                var reader = new FileReader();
                var img_div=document.getElementById("preview_img1");
                reader.readAsDataURL(file);
                var app_load="load_"+ file_array+"_"+filelist[$i].name;
              
                $("img[name='"+app_load+"']").show()
        
               
                reader.onload = (function(file){ 
                   return function(event){     
                $("div[name='"+app_div+"']").append(load);
                  var app_div="div_"+ file_array+"_"+file.name;
                  //var app_img="img_"+ file_array+"_"+file.name;
                   var img_str = '<img  src="' + event.target.result + '" id="' +"img_"+ file_array+"_"+file.name + '" name="' +"img_"+ file_array+"_"+file.name + '" width="200" height="150" class="pre_img" /><img  id="'+ "del_" +file_array+"_"+file.name +'" src="/images/del.png" style="position:absolute; top:0px; right:5px; width:30px; height:30px; display:none">&nbsp;';
                   //var img_del_str='<img  src="/images/del_pre.png" style="position : absolute;top : 0px;right : 0px;width : 20px;height : 20px;">'
                   //$('#preview_img1').append(img_str);
                   $("div[name='"+app_div+"']").append(img_str);
                   xhr.send(fd);
                   

                   if(input.files.length<file_can_use){
                   var add_new='<img  id="add_new" src="/images/add_new.png"  width="200" height="150" onclick="img_file.click()" />'
                   $("#preview_img1").append(add_new)
                   
                 }
                   //$("#add_new").show()
                   };
                   })(file,file_array);

                              
                fd.append('img_file[]', filelist[$i],file_array+"_"+filelist[$i].name); 

                xhr.onreadystatechange = function() {
                    if (xhr.readyState === 4) {
                           if (xhr.status === 200) {
                             var str=xhr.responseText; 
                             document.getElementById("searchResult").innerHTML=str;
                
                            } else {
                              alert("發生錯誤: " + xhr.status);
                         }
                     }
                }  
                $("img[name='"+app_load+"']").fadeOut(3000)          
            }
        }
    var file_clear = document.getElementById(input.id); //假如上傳跟前一個一樣的會無法更新 所以要清空
    file_clear.outerHTML=file_clear.outerHTML
}

</script>
<script type="text/javascript">
$(function () { //進去div後顯示右上角X
        $("#preview_img1").on("mouseenter","div",function () {
           // alert(this.id.substring(4))
            var show=document.getElementById("del_"+this.id.substring(4))
            show.style.display="block"

        });

        $("#preview_img1").on("mouseleave","div",function () {
            var hide=document.getElementById("del_"+this.id.substring(4))
            hide.style.display="none"

        });           
    
  });

$(function () { //顯示經紀人table
        $("#man_has").on("click",function () {
            $("#manager_table").show()
        });

        $("#man_no").on("click",function () {
            $("#manager_table").hide()
            $("#manager").val("-1");
            $("#manager_text").val("");
            $("#manager_phone").val("");
        });          
    
  });

   $(function () { //點右上X後刪除檔案與預覽圖
                $("#preview_img1").on("click", "img", function () {
                 if(this.id.match("del_")){
                 var del_info="del_info="+this.id.substring(4) 
                    if (confirm("確定移除圖片?")) {
//-------------------ajax開始-----------------------------------------                              
                    $.ajax({
                      url: "/delete.php",
                      data: del_info,
                      type:"POST",
                      dataType:'text',

                     success: function(msg){
                       //alert(msg);
                      },
                     //  error:function(xhr, ajaxOptions, thrownError){ 
                     //    alert(xhr.status); 
                     //    alert(thrownError); 
                    //  }
            });
//-------------------ajax結束-----------------------------------------
                  var div_name="div_"+this.id.substring(4)
                  $("div[name='"+div_name+"']").remove(); //抓div name刪除
                  //$(this).closest("div").remove()//抓最近的div刪除
                  var pre_sum= document.getElementsByClassName('pre_img').length
                  if(pre_sum<5&& $("#add_new").length==0){
                    var add_new='<img  id="add_new" src="/images/add_new.png"  width="200" height="150" onclick="img_file.click()" />'
                   $("#preview_img1").append(add_new)
                  }

                  }     
                }         
            
        });
});


function check_form(){
    var all_form=document.forms['liver_form'];
    var pre_img= document.getElementsByClassName('pre_img')
    var img_array = document.getElementById('img_ay');
    var a=[];
    for($i=0;$i<pre_img.length;$i++){
        
        a[$i]=pre_img[$i].id.substring(4)
        //img_array[$i].value=pre_img[$i].id;
        //alert(a[$i])
        //alert(img_array[$i].value)
        
    }
   //img_array.value=a
    //alert(img_array);
    img_array.value=JSON.stringify(a);
    //alert(JSON.parse(img_array.value))
    //var img_array = document.getElementById('img_ay');
    //img_array.value=a;
    //alert(img_array.value)
  //   if(!all_form.elements.status.value){
  //     alert("請選擇狀態!")
  //     document.getElementById("status").focus()
  //     return false;
  //     }
  //   if(all_form.elements.coordination.value=='-1'){
  //     alert("請選擇配合度!")
  //     document.getElementById("coordination").focus()
  //     return false;
  //     }
  //   if(!all_form.elements.name.value){
  //     alert("請輸入姓名!")
  //     document.getElementById("name").focus()
  //     return false;
  //     }
  //   if(!all_form.elements.sex.value){
  //     alert("請選擇性別!")
  //     document.getElementById("sex").focus()
  //     return false;
  //     }
  //   if(!all_form.elements.location.value){        
  //        alert("請選擇/輸入地區!")
  //        document.getElementById("location").focus()
  //        return false;
  //     }
  //   if(all_form.elements.location.value=='else'&&all_form.elements.location_text.value==''){
  //         alert("請選擇/輸入地區!")
  //        document.getElementById("location_text").focus()
  //        return false;
  //     }
  //    if(!all_form.elements.stage_name.value){
  //     alert("請輸入藝名!")
  //     document.getElementById("stage_name").focus()
  //     return false;
  //     }
  //   if(all_form.elements.birth_year.value=='-1'||all_form.elements.birth_month.value=='-1'||all_form.elements.birth_day.value=='-1'){
  //     alert("請選擇好出生年日日!")
  //     document.getElementById("birth_year").focus()
  //     return false;
  //     }
  //   if(all_form.elements.high.value==''){
  //     alert("請輸入身高")
  //     document.getElementById("high").focus()
  //     return false;
  //     }
  //   if(all_form.elements.wight.value==''){
  //     alert("請輸入體重!")
  //     document.getElementById("wight").focus()
  //     return false;
  //     }
  //   if(all_form.elements.profession.value==''){
  //     alert("請輸入職業!")
  //     document.getElementById("profession").focus()
  //     return false;
  //     }

  //   if(all_form.elements.postal_code.value==''){
  //     alert("請輸入郵遞區號!")
  //     document.getElementById("postal_code").focus()
  //     return false;
  //     }
  //   if(all_form.elements.address.value==''){
  //     alert("請輸入地址!")
  //     document.getElementById("address").focus()
  //     return false;
  //     }
  //   if(all_form.elements.cell_phone.value==''){
  //     alert("請輸入電話!")
  //     document.getElementById("cell_phone").focus()
  //     return false;
  //     }
  //   if(all_form.elements.line_id.value==''){
  //     alert("請輸入line ID!")
  //     document.getElementById("line_id").focus()
  //     return false;
  //     } 
  //   if(all_form.elements.email.value==''){
  //     alert("請輸入email!")
  //     document.getElementById("email").focus()
  //     return false;
  //     }
  //   if(all_form.elements.man_has.value==''){
  //     alert("請選擇是否有經紀合約!")
  //     document.getElementById("man_has").focus()
  //     return false;
  //     }
  //    if(all_form.elements.man_has.value=='1'){
  //      if(all_form.elements.manager.value=='-1'){
  //        alert("請選擇或輸入經紀公司");
  //        document.getElementById("manager").focus()  
  //       return false;
  //       }
  //      if(all_form.elements.manager.value=='else'&&all_form.elements.manager_text.value==''){
  //        alert("請選擇或輸入經紀公司");
  //        document.getElementById("manager_text").focus()  
  //       return false;
  //       }
  //      if(all_form.elements.manager_phone.value==''){
  //        alert("請輸入經紀公司電話");
  //        document.getElementById("manager_phone").focus()  
  //       return false;
  //       }
  //   }   
  //       var category=document.getElementsByName("category[]");
  //       var category_chk='f';
  //       for($i=0;$i<category.length;$i++){
  //         if(category[$i].checked==true){
  //           category_chk='t';
  //           break;
  //         }
  //       }
  //       if(category_chk=='f'){  
  //         alert("請選擇直播分類!");
  //         document.getElementById("category").focus()
  //         return false;  
  //       }
  //       var skill=document.getElementsByName("skill[]");
  //       var skill_chk='f';
  //       for($i=0;$i<skill.length;$i++){
  //         if(skill[$i].checked==true){
  //           skill_chk='t';
  //           break;
  //         }
  //       }
  //       if(skill_chk=='f'){  
  //         alert("請選擇特殊才藝!");
  //         document.getElementById("skill").focus()
  //         return false;  
  //       }
  //    if(all_form.elements.ex_has.value==''){  
  //        alert("請選擇是否有直播經驗!");
  //        document.getElementById("ex_has").focus()  
  //       return false;
  //    }
  //   $platform_num=4
  //   for($i=1;$i<= $platform_num;$i++){
  //    var chk_num=String($i);
  //    var check1 = document.getElementById("live_check"+chk_num);
  //    var fan = document.getElementById("live_fan"+chk_num);
  //    var link = document.getElementById("live_link"+chk_num);
  //    var live_platform=document.getElementsByName("live_platform"+chk_num+"[]");
  //    if(check1.checked){  
  //       if(fan.value==''){  
  //         alert("請輸入粉絲人數!");
  //         document.getElementById("live_fan"+chk_num).focus()
  //         return false;  
  //       }
  //    }
  //    if(check1.checked){  
  //       if(link.value==''){  
  //         alert("請輸入直播連結!");
  //         document.getElementById("live_link"+chk_num).focus()
  //         return false;  
  //       }
  //    }
  //    if(check1.checked){  
  //       var chk='f';
  //       for($j=0;$j<live_platform.length;$j++){
  //         if(live_platform[$j].checked==true){
  //           chk='t';
  //         }
  //       }
  //       if(chk=='f'){  
  //         alert("請選擇直播平台!");
  //         document.getElementById("live_platform"+chk_num).focus()
  //         return false;  
  //       }
  //    }
  // }
  // var img_sum= document.getElementsByClassName('pre_img').length
  //       if(img_sum==0){  
  //         alert("請上傳圖片!");
  //         document.getElementById("add_new").focus()
  //         return false;  
  //     }
  //    if(all_form.elements.special_direct.value==''){  
  //        alert("請輸入特色說明!");
  //        document.getElementById("special_direct").focus()
  //        return false;  
  //    }
     
  //    if(tinyMCE.get('experience').getContent()==''){  
  //        alert("請輸入個人經歷!");
  //        document.getElementById("experience").focus()  
  //        return false;
  //    }

    document.getElementById("liver_form").submit()
}
   

</script>
</head>
<body>
<form name="liver_form" id="liver_form" method="POST" action="/adm/liver_form_check.php" enctype="multipart/form-data">
<input type="hidden" name="img_ay" id="img_ay">
<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td><h4>基本資料</h4></td>
  	<td >*狀態:
  	    <input type="radio" name="status" id="status" value="online">上線
  	    <input type="radio" name="status" value="offline">下線
  	    <input type="radio" name="status" value="wait">待審核
  	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	    *配合度:<select name="coordination" id="coordination">
        <option value="-1">請選擇</option>　      
        <option value="1">配合度1</option>
　      <option value="2">配合度2</option>
        </select>
  	</td>
  </tr>
</table>

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr >
  	<td height=40>*真實姓名:<input  name="name" type="text"  id="name" value="">
  	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	    *性別:
  	    <input type="radio" id="sex" name="sex" value="1" >男
  	    <input type="radio" name="sex" value="0" >女<!-- <? if ($sex==0) echo "selected"; ?> -->
  	   &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	    *地區:
  	    <input type="radio" id="location" name="location" value="taiwan" onclick="if(this.checked)showlocation(this.value);">台灣
  	    <input type="radio" name="location" value="china" onclick="if(this.checked)showlocation(this.value);">大陸
        <input type="radio" id="else" name="location" value="else" onclick="if(this.checked)showlocation(this.value);">其他
  	    <input  id="location_text" name="location_text" type="text" size="10" value="" style="display:none;">
  	</td>
  </tr>
</table>

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td height=40>*藝名:<input id="stage_name" name="stage_name" type="text" value="">
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	*出生年月日:
  		<select name="birth_year" id="birth_year">
                  <option value="-1" selected="selected">--</option>
<?for($i=1900;$i<date("Y");$i++){?>
                  <option value="<?=$i;?>"<?echo ($birth_year==$i)?" selected":"";?>><?=$i;?> </option>
<?}?>
                  </select>
年
                  <select name="birth_month" id="birth_month">
                  <option value="-1">--</option>
<?for($i=1;$i<13;$i++){?>
                  <option value="<?=$i;?>"<?echo ($birth_month==$i)?" selected":"";?>><?=$i;?> </option>
<?}?>
                  </select>
月
                  <select name="birth_day" id="birth_day">
                  <option value="-1">--</option>
<?for($i=1;$i<32;$i++){?>
                  <option value="<?=$i;?>"<?echo ($birth_day==$i)?" selected":"";?>><?=$i;?> </option>
<?}?>
                  </select>
        日
  	</td>
  </tr>

  <tr>
  	<td height=40>
    *身高/體重:<input  id="high" name="high" type="text" size="5" value="">公分/<input id="wight" name="wight" type="text" size="5" value="">公斤
    &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
  	*職業:<input id="profession" name="profession" type="text" value=""></td>
  </tr>	
</table>
<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td><h4>聯絡資料</h4></td>
  </tr>

  <tr>
  	<td height=40 width="60%">*聯絡地址:<input id="postal_code" name="postal_code" type="text" size="5" placeholder="郵遞區號" ><!-- <td height=40 width="60%">*聯絡地址:<input  style="color:#a0a0a1" name="postal_code" type="text" size="5" value="郵遞區號" color="#a0a0a1" onMouseDown="window.status='郵遞區號';if(this.value=='郵遞區號') this.value=''";> -->&nbsp;<input id="address" name="address" type="text" size="80" value=""></td>
  </tr>
</table>
<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td height=40>聯絡電話: 市話:<input  name="phone" type="text" value="">&nbsp;&nbsp;&nbsp;&nbsp;
  	*手機:<input id="cell_phone" name="cell_phone" type="text" value="">&nbsp;&nbsp;&nbsp;&nbsp;
  	*LINE ID:<input  id="line_id" name="line_id" type="text" value="">
    </td>
  </tr>
  <tr>
    <td height=40>E-MAIL:<input id="email" name="email" type="email" value="" size="60">&nbsp;&nbsp;&nbsp;&nbsp;
    *微信 ID:<input  name="weixinid" type="text" value="">
    </td>
  </tr>
</table align="center" width="85%" bgcolor="#f3f3f3">

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
  	<td height="40">*是否有經紀約:
  	    <input type="radio" id="man_has" name="man_has" value="1" >有
  	    <input type="radio" id="man_no" name="man_has" value="0" >無
  	</td>
  </tr>
  </table>
  <table id="manager_table" align="center" width="85%" bgcolor="#f3f3f3" style="display: none">
  <tr>
  	<td>
  	經紀人/經紀公司:<select id="manager" name="manager" onchange="manager_change(this.value)">
        <option value="-1">請選擇</option>　      
        <option value="經紀公司1">經紀公司1</option>
　      <option value="經紀公司2">經紀公司2</option>
        <option value="else">其他</option>
        </select>
        <input  id="manager_text" name="manager_text" type="text" size="50" value="" style="display:none;">&nbsp;&nbsp;&nbsp;&nbsp;聯絡電話(經紀人/公司):<input id="manager_phone" name="manager_phone" type="text" value="">
    </td>
  </tr>
</table>

<table align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
    <td><h4>經歷資料</h4></td>
  </tr>
  <tr>
    <td height="40">*分類:
      <input id="category" type="checkbox" value="美食" name="category[]">美食
      <input type="checkbox" value="美妝" name="category[]">美妝
      <input type="checkbox" value="遊戲" name="category[]">遊戲
      <input type="checkbox" value="生活" name="category[]">生活
      <input type="checkbox" value="拍賣" name="category[]">拍賣
    </td>
  </tr>
  <tr>
    <td height="40">*特殊才藝:
      <input id="skill" type="checkbox" value="唱歌" name="skill[]">唱歌
      <input type="checkbox" value="跳舞" name="skill[]">跳舞
      <input type="checkbox" value="吉他" name="skill[]">吉他
      <input type="checkbox" value="烏克麗麗" name="skill[]">烏克麗麗
      <input type="checkbox" value="鋼琴" name="skill[]">鋼琴
      <input type="checkbox" value="長笛" name="skill[]">長笛
      <input type="checkbox" value="爵士鼓" name="skill[]">爵士鼓
      <input type="checkbox" value="電子琴" name="skill[]">電子琴
      <input type="checkbox" value="魔術" name="skill[]">魔術
      <input type="checkbox" value="遊戲實況" name="skill[]">遊戲實況
    </td>
  </tr>
  <tr>
    <td height="40">是否有直播經驗:
       <input type="radio" id="ex_has" name="ex_has" value="1">有
       <input type="radio" name="ex_has" value="0">無
    </td>
  </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
  <tr>
    <td height="40">直播平台:</td>
  </tr>
  <tr>
    <td height="40"><input type="checkbox" id="live_check1" value="fb" name="live_check1">FB</td>
    <td height="40">粉絲數 <input type="text" id="live_fan1" name="live_fan1">人/ 連結:<input type="text" id="live_link1" name="live_link1" size="60">&nbsp;&nbsp;&nbsp;&nbsp;可觀看平台: 
     <input type="checkbox" id="live_platform1" name="live_platform1[]" value="moblie">手機
     <input type="checkbox"  name="live_platform1[]" value="web">電腦
    </td>
  </tr>
  <tr>
    <td height="40"><input type="checkbox" value="17" id="live_check2" name="live_check2">17直播</td>
    <td height="40">粉絲數 <input type="text" id="live_fan2" name="live_fan2">人/ 連結:<input type="text" id="live_link2" name="live_link2" size="60">&nbsp;&nbsp;&nbsp;&nbsp;可觀看平台: 
     <input type="checkbox" id="live_platform2" name="live_platform2[]" value="mobile">手機
     <input type="checkbox"  name="live_platform2[]" value="web">電腦
    </td>
  </tr>
  <tr>
    <td height="40"><input type="checkbox" value="up" id="live_check3" name="live_check3">UP直播</td>
    <td height="40">粉絲數 <input type="text" id="live_fan3" name="live_fan3">人/ 連結:<input type="text" id="live_link3" name="live_link3" size="60">&nbsp;&nbsp;&nbsp;&nbsp;可觀看平台: 
     <input type="checkbox"  id="live_platform3" name="live_platform3[]" value="mobile">手機
     <input type="checkbox"  name="live_platform3[]" value="web">電腦
    </td>
  </tr>
  <tr>
    <td height="40"><input type="checkbox" value="me" id="live_check4" name="live_check4">Liveme</td>
    <td height="40">粉絲數 <input type="text" id="live_fan4" name="live_fan4">人/ 連結:<input type="text" id="live_link4" name="live_link4" size="60">&nbsp;&nbsp;&nbsp;&nbsp;可觀看平台: 
     <input type="checkbox" id="live_platform4" name="live_platform4[]" value="mobile">手機
     <input type="checkbox"  name="live_platform4[]" value="web">電腦
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
       
        <input type="file" name="img_file[]" id="img_file" size="20" onchange="readimg_multiple(this);" style="display: none;" accept="image/jpeg,image/gif,image/png" multiple>
        <div id="preview_img1" ><img  id="add_new" src="/images/add_new.png"  width="200" height="150" onclick="img_file.click()" /></div> <!-- 預覽圖片位置 -->
    
     </td>
   </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
   <tr>
     <td><h4>特色說明：(字數限制30字)</h4></td>
   </tr>
   <tr>
     <td ><input type="text" id="special_direct" name="special_direct" size="140"></td>
   </tr>
</table>

<table  align="center" width="85%" bgcolor="#f3f3f3">
   <tr>
     <td><h4>個人經歷：</h4> <a style="color:red">(注意：字數上限為9000個字元，總容量包含圖檔不可超過 500K ，2個字元等於1個中文字) 
     </a></td>
   </tr>
   <tr>
     <td><textarea name="experience" id="experience" ></textarea></td>
   </tr>
   <tr>
     <td height="40" align="center"><input type="button" value="送出資料" onclick="check_form();"></td>
   </tr>
</table>
</form>
</body>
</html>