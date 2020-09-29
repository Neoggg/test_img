<?
session_start();
// print_r($_SESSION );
$s_id= session_id();
$date=date('YmdHis');
$ip=$_SERVER["REMOTE_ADDR"];

$link = mysqli_connect("127.0.0.1", "root", "00000000") 
        or die("無法開啟MySQL資料庫連接!<br/>");
$dbname = "test";
mysqli_select_db($link, $dbname);

$sql="SELECT id from vote_user where user_guid='$s_id' or user_ip='$ip' ";
$re=mysqli_query($link, $sql);
$nums=mysqli_num_rows($re);
if($nums=='0'){
	$sql="insert  vote_user (user_guid,user_ip,user_vote,user_date) values ('$s_id','$ip','','$date')";
	$re=mysqli_query($link, $sql);
	echo mysqli_error($link);
}else{
	echo 'exist';
}

$sql="SELECT * FROM `vote_term`";
$re=mysqli_query($link, $sql);
// $data=mysqli_fetch_row($re);
$i=0;
while($data = mysqli_fetch_array($re))
{
	// print_r($data);
	// echo '<br>';
	$vote_term[$i]=$data['name'];
	$i++;
	// print_r($vote_term);
} 
?>
<!DOCTYPE html>
<html>
<head>
	<title></title>
</head>
<body>
<form id='vote_form' action="fin.php" method="POST">
	<?for($i=0;$i<count($vote_term);$i++){?>
    <input  type="radio" name="vote_term" value="<?=$vote_term[$i]?>"><?=$vote_term[$i]?>
<?}?>
<input id="submit_button" type="submit" value="送出" >
</FORM>


</body>
</html>