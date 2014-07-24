<?php

//Blogs
function blog ($dbc, $user) {// blogs retrieved and sorted from DB

	
	if (isset ($_POST['PostComment'])=='Post Comment') { //actions when comment is made
				//escape string and stripslashes
				$commentTitle= cleanshit($dbc, $_POST['commentTitle']);
				$commentPost= cleanshit($dbc, $_POST['comment']);
				$commentUsername= cleanshit($dbc, $_POST['commentUserName']);
				$post=array($commentPost,$commentTitle,$commentUsername);
			$q3 ="INSERT INTO blog (blogcomment, title, post, username, date_posted) VALUES ('$_POST[blogcomment]','".$commentTitle."','".$commentPost."','".$commentUsername."', now())";
			$r3=mysqli_query($dbc, $q3);
			unset ($_POST);			

}	//end Comment Post actions
	if (isset ($_POST['newPost'])=='Create Post') { //actions for Creating Post
				//escape string and stripslashes
				$createName = cleanshit($dbc, $_POST['userName']);
				$createTitle = cleanshit($dbc, $_POST['title']);
				$createPost = cleanshit($dbc, $_POST['newPostText']);;
				$post=array($createName,$createPost,$createTitle);
			$q5="INSERT INTO blog (blogcomment, title, post, username, date_posted) VALUES ('$_POST[blogcomment]','".$createTitle."','".$createPost."','".$createName."', now())";
			$r5=mysqli_query($dbc, $q5);
			foreach ($_FILES["pictures"]["error"] as $key => $error) {
	if ($error == UPLOAD_ERR_OK) {
		$tmp_name = $_FILES["pictures"]["tmp_name"][$key];
		$name = $_FILES["pictures"]["name"][$key];
		move_uploaded_file($tmp_name, "images/blogs/$name");
		
	}else $errormsg .= "Upload error. [".$error."] on file '".$name."'<br/>\n";
}

			unset ($_POST);			

		}

		//setup user variable
	if (isset ($user['username'])) {	
/*		$user[]= 
		$q4 ="SELECT * FROM users WHERE email= '$_SESSION[username]' LIMIT 1";
		$r4 = mysqli_query ($dbc, $q4);
		if (mysqli_num_rows ($r4) >0) {
		$user = mysqli_fetch_assoc($r4);
*/		if (($user['usertype']==sha1(2147483647))) {// Create Post button
		
			echo '<div id="createPost" class="createPost">Create Post</div>
		<div id="panel" class="panel">
		<form action="?" method="post"  enctype="multipart/form-data">
		<label for="newPost" class="required"><b>Create new post: </b></label><br><br></br>
		Title: <input type="text" name="title" id="title" length="200px"/><br>
		<br>
		<textarea name="newPostText" id="newPostText" class="newPostText" rows="auto" cols="65" placeholder="Write or paste your post:" ></textarea><br>
		<input type="hidden" name="MAX_FILE_SIZE" value="30000" />
		<input type="file" name="pictures" size="40"/> <br><br>		   
		<input name="newPost" type="submit" value="Create Post" id="submit"/><br>
		<input type="hidden" name="blogcomment" value="0" id="blogcomment" /><br>
		<input type="hidden" name="userName" value="'.$user ['username'].'" id="userName" />
		</form>	</div>
					';
			}/*End Create Post button*/		//}//End if $user
		}elseif (!isset ($user['username'])) {$user='';} //End elseif $_COOKIE
		$q="select * from blog where blogcomment=0 order by id desc";
		$r = mysqli_query($dbc, $q);
		while ($blogPosts= mysqli_fetch_assoc ($r)) { // blogs displayed in table date descending while loop 1
		echo'<div id="blogPosts" class="blog">
		<a name="top1"></a>
		<table>
		<tr><h3>'.$blogPosts['title'].' by '.$user['fullname'].'</h3></tr>
		<tr>'.$blogPosts['post'].'</tr>
		</table> <br>';


/*		//Comments retrieve and display
		
		$q2="SELECT s.* FROM blog f INNER JOIN blog s ON f.title = s.title WHERE s.blogcomment > f.blogcomment AND f.title=s.title ORDER BY f.title, f.date_posted,  f.blogcomment  DESC";
		$r2 = mysqli_query($dbc, $q2);
		while ($blogComments=mysqli_fetch_assoc ($r2)) { //comments while loop 2
				if ($blogPosts['title'] == $blogComments['title']) { //if statement to create comments div
				echo '<div id="blogComments" class="comment"> 
				<table>
				<tr><h5>Comment by '.$blogComments['username'].'</h5></tr>
				<tr>'.$blogComments['post'].'</tr>
				</table></div>';} //End comments loop 2
				} //End if statement
					if (isset($_COOKIE['userid'])) { //comment posting ability if logged in (display form)
						
						echo '<div id="respond" class="comment">	
						<form action="?" method="post">
						<label for="comment">Leave us a comment: </label>
						<textarea name="comment" id="comment" rows="1" width="90%"></textarea>
							<input type="hidden" name="blogcomment" value="1" id="blogcomment" /><br>
							<input type="hidden" name="commentTitle" value="'.$blogPosts['title'].'" id="commentTitle" />
							<input type="hidden" name="commentUserName" value="'.$user ['username'].'" id="CommentUserName" />
							<input name="PostComment" type="submit" value="Post Comment" id="submit" />
						</form></div>
						';	
}	//end display comment form 	
*/echo '</div>';  // end post div
}   //end while loop 1
}   //end blogs function 
