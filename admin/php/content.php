<?php
		
function Content($dbc, $pg, $title) {
	
	
	
	$q1 = "SELECT * FROM content WHERE page='".$pg."' AND title='".$title."'";
	$r1 = mysqli_query ($dbc, $q1);
	$content = mysqli_fetch_assoc($r1);
	
		if (mysqli_num_rows ($r1) >0) {
   
}
	}
	?>

