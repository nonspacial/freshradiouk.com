<?php 
## Setup Document

/* Order of functions for mysqli seperated by a comma in single quotes as string:

	host (or location of the database)
	username
	password
	database name

*/ 

error_reporting(0);

include ("connection.php");
include ("sandbox.php");
include ("data.php");
							 
# Site Setup:

$debug = data_setting_value($dbc, 'debug-status');

#page ID

if (isset ($_GET['page'])){
	$pg = $_GET['page'];
	$pageContent= $_GET['id'];
	$pageTitle= $_GET['title'];
	}else{
	$pg = 'dashboard';
	$pageContent= 'dashboard';
	$pageTitle= 'home';
	}
			
//Stripslashes

function cleanshit ($dbc, $post) {

$var = mysqli_real_escape_string($dbc, stripslashes(trim($post)));

return $var;

}

// $user array
$siteTitle = siteTitle ($dbc);
$user= data_user($dbc, $_SESSION['username']);

#page setup
$path = get_path();

if(!isset($pg)) {
			$page='dashboard'; 
		}else{
			$page=$pg;
			}

include ("queries.php");

# OTHER INCLUDES

include ("src/facebook.php");
include ("nav.php");
