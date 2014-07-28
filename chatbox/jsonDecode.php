<?php
include ("../setup/connection.php");

$chatJson = file_get_contents('logs.json');
$chat = json_decode($chatJson, true);
header('Content-Type: application/json');

foreach($chat as $chatEcho){
	$userColour = $dbc->query("SELECT * FROM users WHERE username ='".$chatEcho['chats']['username']."'");
	$userColour = mysqli_fetch_assoc($userColour);
	if ($userColour['status'] === 1) {
		echo "<span style='color:#390;' class='uNameLogin'>" .$chatEcho['chats']['username']. "</span><br>";
		echo "<span class='date'>" . $chatEcho['chats']['time']. "</span><br>";
		echo "<span class='msg'>". $chatEcho['chats']['message']. "</span><br>";
		}elseif($userColour['status'] === 2){
			echo "<span style='color:#7B0BB4;' class='uNameDJ'>" .$chatEcho['chats']['username']. "</span><br>";
			echo "<span class='date'>" . $chatEcho['chats']['time']. "</span><br>";
			echo "<span class='msg'>". $chatEcho['chats']['message']. "</span><br>";
			}elseif($userColour['status'] === 567){
				echo "<span style='color:#FF0004;' class='uNameAdmin'>" .$chatEcho['chats']['username']. "</span><br>";
				echo "<span class='date'>" . $chatEcho['chats']['time']. "</span><br>";
				echo "<span class='msg'>". $chatEcho['chats']['message']. "</span><br>";
				}else{
					echo "<span style='color:#0243CC;' class='uName'>" .$chatEcho['chats']['username']. "</span><br>";
					echo "<span class='date'>" . $chatEcho['chats']['time']. "</span><br>";
					echo "<span class='msg'>". $chatEcho['chats']['message']. "</span><br>";
					}
	}
?>
<br />
<?php 
?>