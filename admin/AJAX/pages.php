<?php 

include ("../php/connection.php");

$id = $_GET['id'];

$q= "DELETE FROM content WHERE id = $id";
$r = mysqli_query($dbc,$q);

if ($r) {
	echo 'page deleted';
	
	}else {
		
		echo 'There was an error ...<br>';
		echo $q.'<br>';
		echo mysqli_error($dbc);
		}
?>