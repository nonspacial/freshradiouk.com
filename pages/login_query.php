<?php include ("../setup/connection.php");?><?php  
if( strstr($_SERVER['HTTP_USER_AGENT'],'Android') ||
		strstr($_SERVER['HTTP_USER_AGENT'],'webOS') ||
		strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||
		strstr($_SERVER['HTTP_USER_AGENT'],'iPod')){
		// Mobile DO Nothing Paste @ bottom	
		session_start();
		$session_id = session_id();
	}else{
		#Desktop Paste Here	
		session_start();
		$session_id=$_COOKIE['PHPSESSID'];
	}
$username=$_POST['username'];
$password=$_POST['password'];
$q="SELECT * FROM users WHERE username = '".$username."' AND password = SHA1('$_POST[password]') LIMIT 1";
$r=mysqli_query($dbc, $q);
$res=mysqli_fetch_array($r);	

if (mysqli_num_rows($r)) {
	$_SESSION['username']=$res['username'];
	$_SESSION['status'] = $res['status'];
	$_SESSION['user']=$res['username'];
	header("location:../Shoutbox");
}else {
	header("location:../Login");
	echo "No User found. Please re-enter the correct details!";
	echo "click to go to site <a href='../index.php'>Here</a>";
}

#############################################################################################################
?> 