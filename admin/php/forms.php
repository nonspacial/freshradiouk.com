<div id="profileEditorForm" style="display:none;" title="Edit Your Profile">
   		<form method="post" autocomplete="on">     

    	<p>Username: <?php echo $user['username'];?></p>
       	<p>Name: <?php echo "".$user['first']." ".$user['last']."";?></p>
       	<p>Email: <?php echo $user['email'];?></p>
        <p>Password: </p>        
        <input type="password" name="password" placeholder="Password" size="30">
        <p>New Password: </p>        
        <input type="password" name="newPassword" placeholder="Password" size="30">
        <p>Confirm Password</p>
        <input type="password" name="confirmNew" placeholder="Confirm New Password" size="30">
    	<input type="hidden" name="update" value="1">
        <br>
        <input type="submit" name="submit" value="Update" size="45">
        </form>
</div>

<div id='reg_form' class='registration' style='display:none;' title='Abstrkt Registration'>

		<form method='post' autocomplete='on'>
    	<p>Username: </p>
        <input type='text' name='username' placeholder='Choose a Username (Max. 30chars):' size='30'>
       	<p>First Name: </p>
        <input type='text' name='first' placeholder='Your First Name:' size='30'>
    	<p>Surname: </p>
        <input type='text' name='last' placeholder='Your Surname:' size='30'>
       	<p>Email: </p>
        <input type='text' name='email' placeholder='Your Email Address:' size='30'>
        <p>Password: </p>        
        <input type='password' name='password' placeholder='Password' size='30'>
        <p>Confirm Password</p>
        <input type='password' name='confirm' placeholder='Confirm Password' size='30'>
    	<input type='hidden' name='register' value='1'>
        <br>
        <input type='submit' name='submit' value='Register' size='45'></form></div>
        
