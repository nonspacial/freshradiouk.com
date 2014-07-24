<?php 

switch ($page){
	
	case 'dashboard':
		
	break;
		
	case 'pages':
	
		if (isset($_POST['submitted'])==1) {
			
		$pageName=cleanshit($dbc, $_POST['page']);
		$postTitle=cleanshit($dbc, $_POST['pageTitle']);
		$body=cleanshit($dbc, $_POST['body']);
		
		if (isset($_POST['id'])!='') {
				
					$action = 'updated';
					$q="UPDATE content SET page='$pageName', title='$_POST[pageTitle]', body='$body', slug='$_POST[slug]', label='$_POST[label]', hasSub=$_POST[sub] WHERE page='$_GET[id]' ";
					
				}else{
					
					$action ='added';
					$q = "INSERT INTO content (slug, page, title, body, menu, label, hasSub) VALUES ('$_POST[slug]', '$_POST[page]', '$postTitle', '$body', '$_POST[menu]', '$_POST[label]', $_POST[sub])";
				
					}
					
					$r = mysqli_query($dbc, $q);
					
					if ($r) {
						
							$message = '<p class="alert alert-success">Page was '.$action.'!</p>';
						
							}else{
								$message = '<p class="alert alert-danger">page could not be '.$action.' because '. mysqli_error($dbc);
								$message .= '<p class="alert alert-warning">Query: '.$q.'</p>';
							}
				}
	
	if (isset($_GET['id'])) {$opened = data_page($dbc, $pageContent, $pageTitle);}
	
	/*								$q = "INSERT into nav (page, title, menu, slug,  label) VALUES ('$page', '$postTitle', '$body', '$_POST[slug]', '$_POST[label]')";
									$r = mysqli_query($dbc, $q);
									if ($r) {
												$message = '<p>a Link was Created!</p>';
									}else{
										$message = '<p>Link could not be added because '. mysqli_error($dbc);
										$message .= '<p>'.$q.'</p>';
											}
	*/
								  


	
	break;
		
	case 'showtime':
	
		if (isset($_POST['submitted'])==1) {
			
		$startTime=$_POST['start_time'];
		$endTime=$_POST['end_time'];
		$day=cleanshit($dbc, $_POST['day']);
		$dj=cleanshit($dbc, $_POST['dj']);
		$show=cleanshit($dbc, $_POST['show']);
		$genre=cleanshit($dbc, $_POST['genre']);
		
		if (isset($_POST['id'])!='') {
				
					$action = 'updated';
					$q="UPDATE showtime SET start_time='$startTime', end_time='$endTime', day='$day', dj='$dj', showtitle='$_POST[show]', genre='$genre', weekday=$_POST[weekday] WHERE id='$_GET[id]' ";
					
				}else{
					
					$action ='added';
					$q = "INSERT INTO showtime(time, day, dj, showtitle, genre, weekday) VALUES ('$time', '$day', '$dj', '$show', '$genre', $_POST[weekday])";
				
					}
					
					$r = mysqli_query($dbc, $q);
					
					if ($r) {
						
							$message = '<p class="alert alert-success">Page was '.$action.'!</p>';
						
							}else{
								$message = '<p class="alert alert-danger">page could not be '.$action.' because '. mysqli_error($dbc);
								$message .= '<p class="alert alert-warning">Query: '.$q.'</p>';
							}
				}
	
	if (isset($_GET['id'])) {$opened = data_showtime($dbc, $_GET['id']);}
	
	/*								$q = "INSERT into nav (page, title, menu, slug,  label) VALUES ('$page', '$postTitle', '$body', '$_POST[slug]', '$_POST[label]')";
									$r = mysqli_query($dbc, $q);
									if ($r) {
												$message = '<p>a Link was Created!</p>';
									}else{
										$message = '<p>Link could not be added because '. mysqli_error($dbc);
										$message .= '<p>'.$q.'</p>';
											}
	*/
								  


	
	break;
		
	case 'users':
	
		if (isset($_POST['submitted'])==1) {
			
			$first = cleanshit($dbc, $_POST['first']);
			$last = cleanshit($dbc, $_POST['last']);
			
				if ($_POST['password'] != ''){
					
					if ($_POST['password'] == $_POST['passwordv']){
						
						$password = " password = SHA1('$_POST[password]'),";
						$verify = true;
					
					}else{
							
						$verify = false;
									
					}
						
						} else {
						
							$verify = false;
					
						}
	
		if (isset($_POST['id'])!='') {
			
			$action = 'updated';
			$q="UPDATE users SET first = '$first', last = '$last', email = '$_POST[email]', username='$_POST[username]', $password  status = $_POST[status] WHERE id = $_GET[id] ";
					$r = mysqli_query($dbc, $q);
		}else{	
			
		   $action ='added';
		   $q = "INSERT INTO users (first, last, username, email, password, usertype, status) VALUES ('$first', '$last', '$_POST[username]', '$_POST[email]', SHA1('$_POST[password]'), 401, $_POST[status])";
					
					if($verify == true) {
						$r = mysqli_query($dbc, $q);
					}

				}
				
				if($r){
					
					$message = '<p class="alert alert-success">User was '.$action.'!</p>';
					
				} else {
					
					$message = '<p class="alert alert-danger">User could not be '.$action.' because: '.mysqli_error($dbc);
					if($verify == false) {
						$message .= '<p class="alert alert-danger">Password fields empty and/or do not match.</p>';
					}
					$message .= '<p class="alert alert-warning">Query: '.$q.'</p>';
					
				}
							
			}
			
	if(isset($_GET['id'])) { $opened = data_user($dbc, $_GET['id']); }

/*								$q = "INSERT into nav (page, title, menu, slug,  label) VALUES ('$page', '$postTitle', '$body', '$_POST[slug]', '$_POST[label]')";
						$r = mysqli_query($dbc, $q);
						if ($r) {
									$message = '<p>a Link was Created!</p>';
						}else{
							$message = '<p>Link could not be added because '. mysqli_error($dbc);
							$message .= '<p>'.$q.'</p>';
								}
*/					   
								 
	break;
		
	case 'settings':
	
		if (isset($_POST['submitted'])==1) {
			
			$settingsLabel = cleanshit($dbc, $_POST['label']);
			$settingsValue = cleanshit($dbc, $_POST['value']);
	
		if (isset($_POST['id'])!='') {
			
			$action = 'updated';
			$q="UPDATE settings SET id = '$_POST[id]', label = '$settingsLabel', value = '$settingsValue' WHERE id = '$_POST[openedid]' ";
					$r = mysqli_query($dbc, $q);
				}
				
				if($r){
					
					$message = '<p class="alert alert-success">Setting was '.$action.'!</p>';
					
				} else {
					
					$message = '<p class="alert alert-danger">Setting could not be '.$action.' because: '.mysqli_error($dbc);
						$message .= '<p class="alert alert-warning">Query: '.$q.'</p>';
					
				}
							
			}
			
	if(isset($_GET['id'])) { $opened = data_user($dbc, $_GET['id']); }		
	break;
		
	default:
	
	break;
	
	}

							
?>
