<?php 

function getActiveUsers ($dbc) {
	$q="SELECT * FROM session_data ORDER BY session_expire ASC";
	$r=mysqli_query($dbc, $q);
	$data=mysqli_fetch_assoc($r);
	
	return $data;	
	
	}



?>