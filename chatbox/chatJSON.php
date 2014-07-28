<?php
include ("../setup/connection.php");

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