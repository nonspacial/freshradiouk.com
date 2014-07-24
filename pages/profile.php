<?php
		if (isset($_POST['submitted'])==1) {
			
			$first = cleanshit($dbc, $_POST['first']);
			$last = cleanshit($dbc, $_POST['last']);
			
				if ($_POST['password'] != ''){
					
					if ($_POST['password'] == $_POST['checker']){
						
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
			$q="UPDATE users SET first = '$first', last = '$last', email = '$_POST[email]', username='$_POST[user]', $password  status = $_POST[status] WHERE id = $userStatus[id] ";
					$r = mysqli_query($dbc, $q);
		}else{	
			
		   $action ='added';
		   $q = "INSERT INTO users (first, last, username, email, password, usertype, status) VALUES ('$first', '$last', '$_POST[user]', '$_POST[email]', SHA1('$_POST[password]'), 401, $_POST[status])";
					
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

	#Get Page Content Query
	$q = "SELECT * FROM users WHERE username='$_SESSION[user]' LIMIT 1";
	$r = mysqli_query ($dbc, $q); 
	
	$opened=mysqli_fetch_assoc($r);
?>
					<div class="container">
                    <h1>Your Profile</h1>
                    <div class="row">
                            <div id="editor" class="col-md-7 col-md-offset-2 panel panel-default" style="background-color:transparent; border:none;">
                           	 <?php /* Profile Changed*/ if (isset($message)){ echo $message;}?>
                            <form role="form" action="Profile" method="post">
                                    <div class="form-group">
                                        <label for="label">Username:</label>
                                        <input class="form-control" type="text" name="user" id="user" value="<?php echo $opened['username'];?>" placeholder="Username:">
                                    </div>
                                    <div class="form-group">
                                        <label for="first">First Name:</label>
                                        <input class="form-control" type="text" name="first" id="first" value="<?php echo $opened['first'];?>" placeholder="First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="last">Last Name:</label>
                                        <input class="form-control" type="text" name="last" id="last" value="<?php echo $opened['last'];?>" placeholder="Last Name:">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email:</label>
                                        <input class="form-control" type="email" name="email" id="email" value="<?php echo $opened['email'];?>" placeholder="Email Address:">
                                    </div>
                                    <div class="form-group">
                                        <label for="password">Change Password:</label>
                                        <input class="form-control" type="password" name="password" id="password" placeholder="Type New Password:">
                                    </div>
                                    <div class="form-group">
                                        <label for="checker">Re-Type New Password:</label>
                                        <input class="form-control" type="password" name="checker" id="checker" placeholder="Re-Type New Password:">
                                    </div>
								<br>
								<button type="submit" class="btn btn-default">Save</button>
                                <input type="hidden" name="submitted" value="1">
                                <input type="hidden" name="user" value="<?php echo $_SESSION['username'] ?>">
                                <input type="hidden" name="id" value="<?php echo $userStatus['id']; ?>">
                                <input type="hidden" name="status" value="<?php echo $userStatus['status']; ?>">
                                    
                    	</form>
                       </div>
                    </div>
                    </div>