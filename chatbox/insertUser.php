<?php 
include ("../setup/connection.php");
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
$time = time();
if (!isset($_SESSION['username'])) {
	$check1=$dbc->query("SELECT * FROM guests WHERE session_id='$session_id'");
		if($check1){
			$dbc->query("UPDATE guests SET user='$_GET[uName]', time_visited='$time' WHERE session_id='$session_id'");
		}else{
			$dbc->query("INSERT INTO guests (user, session_id, time_visited) VALUES ('$_SESSION[username]','$session_id','$time'");	
		}
} else {
	$check1=$dbc->query("SELECT * FROM activeusers WHERE session_id='$session_id'");
		if($check1){
			$dbc->query("UPDATE activeusers SET time_visited='$time' WHERE session_id='$session_id'");
		}else{
			$dbc->query("INSERT INTO activeusers (user, session_id, time_visited, status) VALUES ('$_SESSION[username]','$session_id','$time',$_SESSION[status])");	
		}
}

$dbc->close();

?>