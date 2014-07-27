<?php 

//Connection to DB
//$dbc = new mysqli("localhost", "root", "spiral33", "fresh");
$dbc = new mysqli("localhost", "u506783747_fresh", "wEG?#7B@g;", "u506783747_fresh");

if ($dbc->connect_errno) {
    echo "Failed to connect to MySQL: (" . $dbc->connect_errno . ") " . $dbc->connect_error;
}
//echo $dbc->host_info . "\n";

//  get the (approximate) number of active sessions
//$active_sessions = $session->get_active_sessions();
/* Your Google Maps API key */
define('API_KEY', 'AIzaSyA6Fxwfqn8ZGsqE88RZUvaCimt5zsrfaLA');
?>