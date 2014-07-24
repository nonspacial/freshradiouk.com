<?php

//Stripslashes
function cleanshit ($dbc, $post) {

$var = mysqli_real_escape_string($dbc, stripslashes(trim($post)));

return $var;

}

//Site Title
function siteTitle ($dbc) {
	$q="SELECT * FROM settings WHERE id = 'site-title'";
	$r= mysqli_query($dbc, $q);
	
	$data=mysqli_fetch_assoc($r);
	
	return $data['value'];
	
	}

function data_user($dbc, $id) {
		
	if(is_numeric($id)) {
		$cond = "WHERE id = '$id'";
	} else {
		$cond = "WHERE username = '$id'";
	}
	
	$q = "SELECT * FROM users $cond";	
	$r = mysqli_query($dbc, $q);
	
	$data = mysqli_fetch_assoc($r);	
	
	$data['fullname'] = $data['first'].' '.$data['last'];
	$data['fullname_reverse'] = $data['last'].', '.$data['first'];
	
	
	return $data;
	
	
}

//data setting
function data_setting_value($dbc, $id){
	
	$q = "SELECT * FROM settings WHERE id = '$id'";
	$r = mysqli_query($dbc, $q);
	
	$data = mysqli_fetch_assoc($r);
	
	return $data['value'];	
	
}

//data page
function data_page($dbc, $id) {
	
	if(is_numeric($id)) {
		$cond = "WHERE id = $id";
	} else {
		$cond = "WHERE slug = '$id'";
	}
	
	$q = "SELECT * FROM content $cond";
	$r = mysqli_query($dbc, $q);
	
	$data = mysqli_fetch_assoc($r);	
	
	$data['body_nohtml'] = strip_tags($data['body']);
	
	if($data['body'] === $data['body_nohtml']) {
		
		$data['body_formatted'] = '<p>'.$data['body'].'</p>';
		
	} else {
		
		$data['body_formatted'] = $data['body'];
		
	}
	
	
	
	return $data;
	
}
#Edit Blog parameters
function editblog ($dbc, $id){
	$q= "SELECT * FROM blog WHERE id=$id";
	$r= mysqli_query($dbc, $q);
	$editDialog = mysqli_fetch_assoc ($r);
	return $editDialog; 
	}
	
#DJ Show on Air Function
function showtime($dbc, $current_time) {
	
	$day = date('l');
	$current_time= date('H:i:s');
	
	$q1="SELECT * FROM showtime WHERE day = '$day'";
	$r1=mysqli_query($dbc, $q1);
	
	while ($show=mysqli_fetch_assoc($r1)) {
		
		if ($show['start_time'] <= $current_time && $show['end_time'] > $current_time) {
			
			$showStart=explode(":", $show['start_time']);
			$showEnd=explode(":", $show['end_time']);
			echo '<div id="nowPlaying" class="nowPlaying">
					<h3>Now Playing</h3>
					<h4>'.$show["dj"].'</h4>
					<h5>'.$show['showtitle'].'</h5>
					<h4>'.$show['genre'].'</h4>
					<h4>'.$showStart[0].':'.$showStart[1].' - '.$showEnd[0].':'.$showEnd[1].'</h4>
				</div>';
			}
	
		}
					//print_r($showStart);print_r($showEnd);print_r($day);print_r($current_time);
	}
?>