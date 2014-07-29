<?php include ("../setup/connection.php");?>
<?php include ("../functions/data.php");?>
<?php include ("smilieParse.php");?>
<?php 
//Session Start Zebra
if( strstr($_SERVER['HTTP_USER_AGENT'],'Android') ||
		strstr($_SERVER['HTTP_USER_AGENT'],'webOS') ||
		strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||
		strstr($_SERVER['HTTP_USER_AGENT'],'iPod')){
		// Mobile DO Nothing Paste @ bottom	
		session_start();
		$session_id = session_id();
	}else{
		#Desktop Paste Here	
		session_start();
		$session_id=$_COOKIE['PHPSESSID'];
	}
date_default_timezone_set("Europe/London");
$dateTime = date("l, F jS Y @ H:ia");
$uName = $_GET['uName'];
$msg = $_GET['msg'];
$time = time();
//Create an instance of simpleParser
$parser = new SimpleParser();
$msg=$parser->parseText($msg,1,0);
$uName= cleanshit($dbc, $uName);
$msg= cleanshit($dbc, $msg);
$userIps = $dbc->query("SELECT * FROM guests WHERE session_id = '$session_id'");
$userIps = mysqli_fetch_assoc($userIps);
	if (!isset($_SESSION['username'])){
		$existingUsers=$dbc->query("SELECT * FROM users WHERE username='$uName'");
		$existingUsers=mysqli_fetch_assoc($existingUsers);
		$existingGuests=$dbc->query("SELECT * FROM guests WHERE user='$uName'");
		$existingGuests=mysqli_fetch_assoc($existingGuests);
			if(!isset($existingUsers)){
				if (!isset($existingGuests)){
						$_SESSION['user'] = $uName;
						$dbc->query("UPDATE guests SET user='$uName', time_visited=$time WHERE session_id='$session_id'");
						$dbc->query("INSERT INTO chat(username, time, message) VALUES ('$uName','$dateTime','$msg')");
						$dbc->query("DELETE FROM chat WHERE id NOT IN (SELECT id FROM (SELECT id FROM chat ORDER BY id DESC LIMIT 100) foo);");
						$result1 = $dbc->query("SELECT * FROM chat ORDER BY id ASC"); 
					}elseif ($existingGuests['session_id']==$_COOKIE['PHPSESSID']){
						$_SESSION['user'] = $uName;
						$dbc->query("UPDATE guests SET user='$uName', time_visited=$time WHERE session_id='$session_id'");
						$dbc->query("INSERT INTO chat(username, time, message) VALUES ('$uName','$dateTime','$msg')");
						$dbc->query("DELETE FROM chat WHERE id NOT IN (SELECT id FROM (SELECT id FROM chat ORDER BY id DESC LIMIT 100) foo);");
						$result1 = $dbc->query("SELECT * FROM chat ORDER BY id ASC"); 
					}else{
						echo '<p class="alert alert-danger">Guest already exists please choose another name!</p>';
					}
			}else{
				echo '<p class="alert alert-danger">User already exists please choose another name!</p>';
			}
	}else{
		if ($userIps['user'] != $uName) {
			$_SESSION['user'] = $uName;
			$dbc->query("UPDATE activeusers SET user='$uName', time_visited=$time WHERE session_id='$session_id'");
						}
			$dbc->query("INSERT INTO chat(username, time, message) VALUES ('$uName','$dateTime','$msg')");
			$dbc->query("DELETE FROM chat WHERE id NOT IN (SELECT id FROM (SELECT id FROM chat ORDER BY id DESC LIMIT 100) foo);");
			$result1 = $dbc->query("SELECT * FROM chat ORDER BY id ASC"); 
	}
//Write new json to file
$chat = $dbc->query("(SELECT * FROM chat ORDER BY id DESC LIMIT 50)ORDER BY id ASC"); 
$data= array();
while ($extract = mysqli_fetch_assoc($chat)) {
	
	$data[]['chats'] = $extract;
}
$fh = fopen("logs.json", 'w')
      or die("Error opening output file");
fwrite($fh, json_encode($data,JSON_UNESCAPED_UNICODE));
fclose($fh);

$dbc->close();
?>
<br />
