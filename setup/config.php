<?php
## Setup Document#############################################################################################

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
			strstr($_SERVER['HTTP_USER_AGENT'],'iPod')){
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
//$C['files_url'] = 'http://localhost:8111/freshradiouk.com/whos-online/'; // url, always end with a slash
$C['files_url'] = 'http://www.freshradiouk.com/whos-online/'; // url, always end with a slash

require ($C['files_path'].'include-whos-online-header.php');
  $whos_online_records = update_whos_online();

?>
