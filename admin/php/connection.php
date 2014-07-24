<?php 

//Connection to DB
$dbc = new mysqli("localhost", "root", "spiral33", "fresh");
//$dbc = new mysqli("localhost", "freshrad_robbie", "fr35hdb", "freshrad_2014");

if ($dbc->connect_errno) {
    echo "Failed to connect to MySQL: (" . $dbc->connect_errno . ") " . $dbc->connect_error;
}
//echo $dbc->host_info . "\n";

//  get the (approximate) number of active sessions
//$active_sessions = $session->get_active_sessions();

?>