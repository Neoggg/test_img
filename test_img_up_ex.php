<html>
<head>
    <meta http-equiv="Content-Type" content="text/html; charset=big5">
    <title></title>
<script language="JavaScript" type="text/JavaScript" src="/css/jquery-3.2.1.min.js"></script>
<script type="text/javascript">

function img(){
	alert('asas')
}

function check_file() {
    var file = document.getElementById('img_file').files
    alert('tt')
    alert(file.length)
    
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
              
              // xhr.upload.onprogress = function (evt) {
              
              // //上傳進度
              // if (evt.lengthComputable) {
              //   var complete = (evt.loaded / evt.total * 100 | 0);
              //   if(100==complete){
              //       complete=99.9;
              //    }
              //    up_progress.innerHTML = complete + ' %';
              //   }
              // }
              
              //  xhr.onload = function() {
              //   //上傳完成
              //   up_progress.innerHTML = '100 %, 上傳完成';
              // };

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

                //innerHTML+=累加生成 自行設定 img_id array 從最小的空欄位開始
                // reader.onload = function (e) {
                //    var n_array=[];    
                //    var n=1;   
                //     //img_div.innerHTML+= '<img src="'+e.target.result+'" width="300" height="200"> &nbsp;&nbsp;&nbsp;'
                //     // for(var i=1;i<6;i++){
                //     // if($('#pre_img'+i).attr('src')==''){//欄位是空的 array才能打入值
                //     //      n_array[n]=i 
                //     //      n++
                //     //    }
                //     // }
                //     //alert(fd.get('img_file[]'))
                //     alert(e.targ.result)
                //      for(var i=1;i<6;i++){ 
                //     if($('#pre_img'+i).length==0){//欄位沒存在 array才能打入值
                //          n_array[n]=i 
                //          n++
                //        }
                //     }
                //appendChild寫法
                //     //$('#pre_img'+n_array[1]).attr('src',e.target.result)//都優先塞第一個空的欄位 才能按照1234的順序                   
                //     var img = e.target.result;
                //     var imgx = document.createElement('img');
                //     imgx.alt="aaa"
                //     imgx.style.width = "300px";
                //     imgx.style.height = "200px";
                //     imgx.src = img;
                //     imgx.id="pre_img"+n_array[1]
                    
                //     document.getElementById('preview_img1').appendChild(imgx);   
                //     xhr.send(fd);
                // }
                var time_num = get_date_num();                
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

             // var div_new='<div  style="display : inline-block; position : relative;"><img id="load"   align="center" src="/images/Pacman.gif" style="  display: none; position:absolute; top:60; right:70;"><img  src="/images/add_new.png"  width="200" height="150" /></div>'; 
             //    $('#preview_img1').append(div_new);

        }
    var file_clear = document.getElementById(input.id); //假如上傳跟前一個一樣的會無法更新 所以要清空
    file_clear.outerHTML=file_clear.outerHTML
}

function openfile(evt) {
            var img = evt.target.result;
            var imgx = document.createElement('img');
            imgx.style.margin = "10px";
            imgx.src = img;
            document.getElementById('preview_img1').appendChild(imgx);
        }  

function get_date_num(){
     var now=new Date()
                var now_y=now.getFullYear()
                var now_m=now.getMonth()
                var now_d=now.getDate()
                var now_h=now.getHours()
                var now_i=now.getMinutes()
                var now_s=now.getSeconds()
                now_y=String(now_y);
                now_m=String(now_m);
                now_d=String(now_d);
                now_h=String(now_h);
                now_i=String(now_i);
                now_s=String(now_s);
                var time_num=now_y+now_m+now_d+now_h+now_i+now_s;
                return time_num
}

function clear_img_multiple(clear){
  //document.getElementById("form_test").reset() //全部重設
  // alert(file.outerHTML) //return false;
  var num=1;
  var file=document.getElementById('img_file');

  for($i=0;$i<file.files.length;$i++){
     $('#preview_img'+num).attr('src','');//預覽圖置空
     document.getElementById('msg_name'+num).innerHTML='請選擇圖片';//圖片info 回預設值
     document.getElementById('msg_wh'+num).innerHTML='';
     num++;
  }
  file.outerHTML=file.outerHTML;//預設的HTML蓋掉更新後的
   
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

//      $(function () {
//                 //移除圖片
//                 $("#preview_img1").on("click", "img", function () {
//                  var del_info="del_info="+this.id.substring(4)  
//                 if (confirm("確定移除圖片?")) {
// //-------------------ajax開始-----------------------------------------                              
//                     $.ajax({
//                       url: "delete.php",
//                       data: del_info,
//                       type:"POST",
//                       dataType:'text',

//                      success: function(msg){
//                        //alert(msg);
//                       },
//                  //  error:function(xhr, ajaxOptions, thrownError){ 
//                  //    alert(xhr.status); 
//                  //    alert(thrownError); 
//                  //  }
//             });
// //-------------------ajax結束-----------------------------------------

//                 $(this).remove(); //清空預覽圖    
//             }             
            
//                 });
// });

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
                  //var add= document.getElementById('add_new')
                  if(pre_sum<5&& $("#add_new").length==0){
                    var add_new='<img  id="add_new" src="/images/add_new.png"  width="200" height="150" onclick="img_file.click()" />'
                   $("#preview_img1").append(add_new)
                  }

                  }     
                }         
            
        });
});

         

</script>

</head>
<body>
    <form  method="POST" id="form_test" name="form_test" action="/test_img_re.php" enctype="multipart/form-data">
    <table align="center" width="85%" bgcolor="#f3f3f3">
    <tr>
    <td align="center">
        <input type="file" name="img_file[]" id="img_file" size="20" onchange="readimg_multiple(this);" style="display: none;" accept="image/jpeg,image/gif,image/png" multiple>
        <div id="preview_img1" ><img  id="add_new" src="/images/add_new.png"  width="200" height="150" onclick="img_file.click()" /></div> <!-- 預覽圖片位置 -->
    </td>
    </tr>
    </table>
   <!--  <table align="center" width="85%" bgcolor="#f3f3f3">
    <tr>
    <td align="center">
        <img id="img_pre" src="/images/glyphicons-647-ambulance.png" onclick="img_file.click()"> 
        
        <div id="searchResult"></div>

    </td>
    
    </tr>
    </table> -->
    <table align="center" width="85%" bgcolor="#f3f3f3">
    <tr>
    <td align="center">
    <input type="submit" value="submit" >
    </td>
    </tr>
    </table>
    </form>
     
</body>

</html>