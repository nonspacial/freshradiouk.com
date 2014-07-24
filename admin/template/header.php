<!doctype html>
<html>
<head>
<?php include ("php/setup.php");?>
<?php 

session_start();

if(!isset($_SESSION['username'])) {header('location: ../index.php');}//else{echo $_SESSION ['username'];};

?>
<?php include ("php/css.php");?>
<?php include ("php/js.php");?>
<?php include ("php/phoneVsdesktop.php");?>

</head>
	<body>
        	
				<?php mainNav ($dbc, $user) ?>
                
<div class="container-fluid">
                 
            
		<div id="mainContent" class="container">
        							            
                <div id="pageContent" class="panel panel-default">