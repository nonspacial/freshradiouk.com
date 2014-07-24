<?php include ("../setup/connection.php");

$result1 = $dbc->query("(SELECT * FROM chat ORDER BY id DESC LIMIT 50)ORDER BY id ASC"); 

while ($extract = mysqli_fetch_array($result1)) {
	
	$userColour = $dbc->query("SELECT * FROM users WHERE username ='".$extract['username']."'");
	$userColour = mysqli_fetch_assoc($userColour);
	if ($userColour['status'] == 1) {
		echo "<span style='color:#390;' class='uNameLogin'>" . $extract['username']. "</span><br>";
		echo "<span class='date'>" . $extract['time']. "</span><br>";
		echo "<span class='msg'>". $extract['message']. "</span><br>";
		}elseif($userColour['status'] == 2){
			echo "<span style='color:#7B0BB4;' class='uNameDJ'>" . $extract['username']. "</span><br>";
			echo "<span class='date'>" . $extract['time']. "</span><br>";
			echo "<span class='msg'>". $extract['message']. "</span><br>";
			}elseif($userColour['status'] == 567){
				echo "<span style='color:#FF0004;' class='uNameAdmin'>" . $extract['username']. "</span><br>";
				echo "<span class='date'>" . $extract['time']. "</span><br>";
				echo "<span class='msg'>". $extract['message']. "</span><br>";
				}else{
					echo "<span style='color:#0243CC;' class='uName'>" . $extract['username']. "</span><br>";
					echo "<span class='date'>" . $extract['time']. "</span><br>";
					echo "<span class='msg'>". $extract['message']. "</span><br>";
					}
	}
	$dbc->close();
?>