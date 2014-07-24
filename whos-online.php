<?php
error_reporting(0); // Report all errors except E_NOTICE warnings
ini_set('display_errors', 1); // turn error reporting on
//ini_set('log_errors', 1); // log errors
//ini_set('error_log', dirname(__FILE__) . '/error_log.txt'); // where to log errors

// include the who's online functions
$C['files_path'] = 'whos-online/';              // full path, always end with a slash
//$C['files_url'] = 'http://localhost:8111/freshradiouk.com/whos-online/'; // url, always end with a slash
$C['files_url'] = 'http://www.freshradiouk.com/whos-online/'; // url, always end with a slash

require ($C['files_path'].'include-whos-online-header.php');
  $whos_online_records = update_whos_online();


// begin whos-online login check
$passed_login = false;
if ($C['enable_password_protect']) {
  $passed_login = process_login();
}
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-US">
<head>
<title>Who's Online</title>
<meta name="description" content="Who's on this web site right now." />
<meta http-equiv="content-type" content="application/xhtml+xml; charset=ISO-8859-1" />
<!-- begin whos online page header code -->
<?php
check_for_settings();
if(  isset($_GET['refresh']) && is_numeric($_GET['refresh']) ){
  $query = 'refresh='. $_GET['refresh'];
  if(  isset($_GET['show']) ) {
    if ( $_GET['show'] == 'all' || $_GET['show'] == 'bots' || $_GET['show'] == 'guests' ){
       $query .= '&amp;show='. $_GET['show'];
    }
  }
if(  isset($_GET['bots']) &&  $_GET['bots'] == 'show') {
    $query .= '&amp;bots=show';
}
  echo '<meta http-equiv="refresh" content="' . $_GET['refresh'] . ';URL=' . $C['filename_whos_online'] . '?' . $query . '" />
  ';
}
?>
<script type="text/javascript" language="JavaScript">
<!--
function who_is(query) {
  var whoisurl = '<?php echo $C['whois_url'] ?>' + query;
  window.open(whoisurl,"who_is_lookup","height=460,width=430,toolbar=no,statusbar=no,scrollbars=yes").focus();
}
//-->
</script>
<!-- end whos online page header code -->
</head>
<body>


<div id="main-copy">

  <h1>Who's Online</h1>

 <?php include($C['files_path'].'include-whos-online-page.php'); ?>
    
</div><!-- end main-copy -->

   </body>
</html>