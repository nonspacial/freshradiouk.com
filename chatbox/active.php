<?php 
include ("../setup/connection.php");
$q7=$dbc->query("SELECT * FROM activeusers");
$online_members = mysqli_num_rows($q7);
echo '<p>'.$online_members.'</p>';
$dbc->close();