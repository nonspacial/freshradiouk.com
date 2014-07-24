<?php

include ("connection.php");

session_start();

$q="DELETE FROM activeusers WHERE user = '".$_SESSION['user']."'";
$r=mysqli_query($dbc, $q);
session_destroy();
header("Location: ../Shoutbox?fixed=0");
?>