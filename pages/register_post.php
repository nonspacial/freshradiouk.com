<?php
//error_reporting(0);
include ('../setup/connection.php');
include ('../functions/data.php');
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
if (isset($_POST['submitted'])==1) {
	$q=$dbc->query("SELECT * FROM users WHERE username = '$_POST[username]'");
		
		if(!isset($q)) {
			$message= '<p class="alert alert-danger>Username already in use, plesase choose different one!</p>';
			$location= '../Register';
			}else{	
			$first = cleanshit($dbc, $_POST['first']);
			$last = cleanshit($dbc, $_POST['last']);
			
				if ($_POST['password'] != ''){
					
					if ($_POST['password'] == $_POST['checker']){
						
						$password = " password = SHA1('$_POST[password]'),";
						$verify = true;
					
					}else{
							
						$verify = false;
						$location= '../Register';
					}
						
						} else {
						
						$verify = false;
						$location= '../Register';
						}
	
		if (isset($_POST['id'])!='') {
			
			$action = 'updated';
			$q="UPDATE users SET first = '$first', last = '$last', email = '$_POST[email]', username='$_POST[username]', $password  status = $_POST[status] WHERE id = $_GET[id] ";
					$r = mysqli_query($dbc, $q);
		}else{	
			
		   $action ='added';
		   $q = "INSERT INTO users (first, last, username, email, password, status) VALUES ('$first', '$last', '$_POST[username]', '$_POST[email]', SHA1('$_POST[password]'), $_POST[status])";
 					if($verify == true) {
						$r = mysqli_query($dbc, $q);
						$location= '../Success';
					}

				}
				
				if($r){
					
					$message = '<p class="alert alert-success">User was '.$action.'!</p>';
	
				} else {
					
					$message = '<p class="alert alert-danger">User could not be '.$action.' because: '.mysqli_error($dbc);
					if($verify == false) {
						$message .= '<p class="alert alert-danger">Password fields empty and/or do not match.</p>';
					}
					$message .= '<p class="alert alert-warning">Query: '.$q.'</p>';
					
				}
				
							
			}
}
			
	header("Location: ".$location."");

?>