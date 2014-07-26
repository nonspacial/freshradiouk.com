<?php

#Account Profile Query
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
	
	#DJ Profile Query
		if (isset($_POST['submitted'])==2) {
			$dj_name = cleanshit($dbc, $_POST['dj']);
			$dj_bio = htmlentities(cleanshit($dbc,$_POST['bio']));
			$dj=$dbc->query("SELECT * FROM dj_profiles WHERE id=$_POST[id]");
			$dj=mysqli_fetch_assoc($dj);
		if ($dj) {
			$action = 'updated';
			$q="UPDATE dj_profiles SET dj_name='$dj_name', bio='$dj_bio' WHERE id=$userStatus[id]";
			$r = mysqli_query($dbc, $q);
		}else{	
			$action ='added';
			$q = "INSERT INTO dj_profiles (id, dj_name, bio) VALUES ($userStatus[id],'$dj_name','$dj_bio')";
			$r = mysqli_query($dbc, $q);
				}
		if($r){
			$message = '<p class="alert alert-success">Your DJ Bio was '.$action.'!</p>';
		} else {
			$message = '<p class="alert alert-danger">DJ Bio could not be '.$action.' because: '.mysqli_error($dbc);
			$message .= '<p class="alert alert-warning">Query: '.$q.'</p>';
			}
		}
	if(isset($_GET['id'])) { $openedDJ = data_user($dbc, $_GET['id']); }
	
	#Get Page Content Query
	$q1=$dbc->query("SELECT * FROM users WHERE username='$_SESSION[user]' LIMIT 1");
	$opened=mysqli_fetch_assoc($q1);
	$q2=$dbc->query("SELECT * FROM dj_profiles WHERE id='$userStatus[id]'");
	$openedDJ=mysqli_fetch_assoc($q2);
?>
					<div class="container">
                    	<div id="tabs" class="panel" style="background:none;">
                             <ul>
                                <li><a href="#tabs-1">Your Profile</a></li>
<?php if ($_SESSION['status']>=2){?>
                                <li><a href="#tabs-2">DJ Profile</a></li>
<?php }?>
                            </ul>
                        <div class="row">
                            <div id="tabs-1">
                                <h1>Your Profile</h1>
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
<?php if ($_SESSION['status']>=2){?>
                            <div class="row">
                                <div id="tabs-2">
                                    <h1>DJ Profile</h1>
                                        <div id="editor" class="col-md-7 col-md-offset-2 panel panel-default" style="background-color:transparent; border:none;">
                                        <form role="form" action="Profile" method="post">
                                            <div class="form-group">
                                                <label for="DJ">DJ Name:</label>
                                                <input class="form-control" type="text" name="dj" id="dj" value="<?php echo $openedDJ['dj_name'];?>" placeholder="How you would like your name to appear on the profiles page">
                                            </div>
                                          <div class="form-group">
                                                <label for="bio">Bio:</label>
												<div id="textarea">
                                                <textarea class="form-control redactor" name="bio" id="bio" placeholder="Construct your own bio here, add pictures make headings and do what you like"><?php echo $openedDJ['bio'];?></textarea>
                                                </div>
                                            </div>
                                        <br>
                                        <button type="submit" class="btn btn-default">Save</button>
                                        <input type="hidden" name="submitted" value="2">
                                        <input type="hidden" name="user" value="<?php echo $_SESSION['username'] ?>">
                                        <input type="hidden" name="id" value="<?php echo $userStatus['id']; ?>">
                                    </form>
                                   </div>
                                </div>
                            </div>
<?php }?>
                        </div>
                    </div>
				<?php if ($path['call'] === 'Profile') { ?>
				<script type="text/javascript">
					$(".redactor").redactor({
						convertDivs: false,
						formattingTags: ["div", "p", "blockquote", "pre", "h1", "h2", "h3", "h4", "h5", "h6"],
						imageGetJson: "json/data.json",
						imageUpload: "setup/image_upload.php",
						fileUpload: "setup/file_upload.php",
						minHeight: 300,
						autoresize: false,
						cleanFontTag: false,
						focus: true,
						plugins: ['fontsize', 'fontfamily', 'fontcolor', 'fullscreen']
					});
				</script>
				<?php } ?>

