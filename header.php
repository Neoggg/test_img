<?
session_start();
// $file_name=substr($_SERVER['PHP_SELF'],5);
// preg_match_all('/[^\_]+/',$file_name,$match);

// if(!preg_match('/'.$match[0][1].'/i',@$_SESSION['authority'])){
// 	echo "無此頁權限，請重新登入!";
// 	header('Refresh:2;url=/adm/login.php');
// 	exit;	
// }

$id='';
if(isset($_SESSION['id'])&&!empty($_SESSION['id'])){
	$id=$_SESSION['id'];
	$login_status="loginok";
}
else{
	//echo "請先登入!";
	$login_status="nologin";
	echo '<table align="center" width="400" bgcolor="#f3f3f3" style="border-radius: 5px;">
		  <tr>
		  	<td align="center">請先登入!</td>  	
		  </tr>
		  </table>';
	header('Refresh:2;url=/adm/login.php');
	exit;
}
?>

<!DOCTYPE html>
<html>
<head>
	<title></title>

<script type="text/javascript">
	$(function(){
        var a_str="<?=$_SESSION['authority']?>";
        if(a_str.match('liver')){
        	$("#liver_bar").show();
        }
        if(a_str.match('top30')){
        	$("#top30_bar").show();
        }
        if(a_str.match('wait')){
        	$("#wait_bar").show();
        }
        if(a_str.match('order')){
        	$("#order_bar").show();
        }
        if(a_str.match('domain')){
        	$("#domain_bar").show();
        }
        if(a_str.match('adv')){
        	$("#adv_bar").show();
        }
        if(a_str.match('success')){
        	$("#success_bar").show();
        }
        if(a_str.match('advup')){
        	$("#advup_bar").show();
        }
        if(a_str.match('up')){
        	$("#up_bar").show();
        }
        if(a_str.match('login')){
        	$("#login_bar").show();
        }
        if(a_str.match('warring')){
        	$("#warring_bar").show();
        }
	});
</script>
</head>
<body>
<table  width="1400">
  <tr>
  <?=$id?><a href="/adm/login_check.php">登出</a>
    <td align="center">
      <h1>直播達人後台</h1>
    </td>
  </tr>
</table>
</body>
</html>