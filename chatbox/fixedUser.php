<?php 
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
$_SESSION['fixed']=4; 
 ?>