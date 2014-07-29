<?php
## Setup Document#############################################################################################
ob_start("ob_gzhandler");
error_reporting(0);

## Includes
include ("connection.php");
include ("queries.php");
include ("functions/data.php");
include ("functions/sandbox.php");
include ("template/nav.php");

#####Current Users#####

$users=getActiveUsers ($dbc);

if (isset($_GET['page'])) {
	
	$pg= $_GET['page'];
	
}else{
	
	$pg='home';
	
	}
# Site Setup:###############################################################################################

$siteTitle = siteTitle ($dbc);
$debug = data_setting_value($dbc, 'debug-status');
	
#page setup###############################################################################################

$path = get_path();
	if( strstr($_SERVER['HTTP_USER_AGENT'],'Android') ||
			strstr($_SERVER['HTTP_USER_AGENT'],'webOS') ||
			strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||
			strstr($_SERVER['HTTP_USER_AGENT'],'iPod') ||
			strstr($_SERVER['HTTP_USER_AGENT'],'iPad')){
			// Mobile DO Nothing Paste @ bottom	
			session_start();
			$session_id = session_id();
			if(!isset($path['call_parts'][0]) || $path['call_parts'][0] == '' ) {
				
				//$path['call_parts'][0] = 'home'; // Set $path[call_parts][0] to equal the value given in the URL
						header('Location: home');
				
			} 
		}else{
			#Desktop Paste Here	
			session_start();
			$session_id=$_COOKIE['PHPSESSID'];
			if(!isset($path['call_parts'][0]) || $path['call_parts'][0] == '' ) {
				
				//$path['call_parts'][0] = 'home'; // Set $path[call_parts][0] to equal the value given in the URL
				header('Location: home');
				
			}
		}


# Page Setup:###############################################################################################

$page = data_page($dbc, $path['call_parts'][0]);
$user= data_user($dbc, $_SESSION['username']);

############# VISITOR MAP INCLUDES ####################

// include the who's online functions
$C['files_path'] = 'whos-online/';              // full path, always end with a slash
$C['site_url'] = 'http://localhost:8080/freshradiouk.com/whos-online/';
//$C['files_url'] = ' http://www.freshbackup.hol.es/whos-online/'; // url, always end with a slash

require ($C['files_path'].'include-whos-online-header.php');
  $whos_online_records = update_whos_online();
  
# MY USER SETUPS ############################################################################################
$guest_timeout = time() - 180;
$member_timeout = time() - 180;
$time = time();
date_default_timezone_set("Europe/London");
$dateTime = date("l, F jS Y @ H:i:s a");
$current_time= DATETIME::createFromFormat('l, F jS Y @ H:i:s a', $dateTime);
$day = $current_time->format('l');
$current_time= $current_time->format('H:i:s');
$yourIp=$_SERVER['REMOTE_ADDR'];
$device=$_SERVER['HTTP_USER_AGENT'];
if (isset($_SESSION['username'])) {
	///Logged in
	$userStatus = $dbc->query("SELECT * FROM users WHERE username = '$_SESSION[username]' LIMIT 1");
	$userStatus = mysqli_fetch_assoc($userStatus);
	$_SESSION['status'] = $userStatus['status'];
	$dbc->query("DELETE FROM guests WHERE session_id='$session_id'");
	$_SESSION['user'] = $_SESSION['username'];
	$dbc->query("INSERT INTO activeusers (user, session_id, time_visited, status) VALUES ('$_SESSION[username]','$session_id','$time', ".(int)$_SESSION['status'].")");
	}else{	
	//Not Logged In Guest
	$userIps = $dbc->query("SELECT * FROM guests WHERE session_id = '$session_id'");
	$userIps = mysqli_fetch_assoc($userIps);
	if ($userIps) {
		$guest_name = $userIps['user'];				
		$_SESSION['user'] = $guest_name;
		$dbc->query("UPDATE guests SET user='$_SESSION[user]', time_visited='$time' WHERE session_id='$session_id'");
		}else{
		$rand = mt_rand(000,999);
		$guest_name = 'fresher_'.$rand;	
		$_SESSION['user'] = $guest_name;
		$dbc->query("INSERT INTO guests (user, session_id, time_visited) VALUES ('$_SESSION[user]','$session_id','$time')");
		}
	}
$dbc->query("DELETE FROM guests WHERE time_visited <".$guest_timeout);
$dbc->query("DELETE FROM activeusers WHERE time_visited <".$member_timeout);
$q6 = $dbc->query("SELECT * FROM guests");
$online_guest = mysqli_num_rows($q6);
$q7=$dbc->query("SELECT * FROM activeusers");
$online_members = mysqli_num_rows($q7);
$dbc->query("INSERT INTO visitors (ip, user, date_time, session_id, device) VALUES ('$yourIp', '$_SESSION[user]', '$dateTime','$session_id','$device')");
?>
