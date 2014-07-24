<?php include ("../setup/connection.php");?>
<?php 
	
    $q="SELECT * FROM activeusers ORDER BY time_visited ASC";
    $r=mysqli_query($dbc, $q);
    if ($r) {
        while ($activeUsers=mysqli_fetch_assoc($r)) {
			
			if ($activeUsers['status'] == 1) {
                echo '<li style="color:#390;" class="uNameLogin">'.$activeUsers['user'].'</li>';
			} elseif ($activeUsers['status'] == 2){
                echo '<li style="color:#7B0BB4;" class="uNameDJ">'.$activeUsers['user'].'</li>';
				} elseif ($activeUsers['status'] == 567) {
                echo '<li style="color:#FF0004;" class="uNameAdmin">'.$activeUsers['user'].'</li>';
				}
        }
    }
    $q="SELECT * FROM guests ORDER BY time_visited";
    $r=mysqli_query($dbc, $q);
    if ($r) {
        while ($activeGuests=mysqli_fetch_assoc($r)) {
                echo ' <li style="color:#0243CC;" class="uName">'.$activeGuests['user'].'</li>';
        }
    }
?>


