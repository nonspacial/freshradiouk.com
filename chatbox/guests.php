<?php
include ("../setup/connection.php");
$q6 = $dbc->query("SELECT * FROM guests");
$online_guest = mysqli_num_rows($q6);
echo '<p>'.$online_guest.'</p>';
$dbc->close();