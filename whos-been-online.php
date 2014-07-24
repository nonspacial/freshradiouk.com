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

// begin whose-online login check
$passed_login = false;
if ($C['enable_password_protect']) {
  $passed_login = process_login();
}
// end whose-online login check

 global $SITE;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-US">
<head>
<title>Who's Been Online</title>
<meta name="description" content="Who's Been Online." />
<meta http-equiv="content-type" content="application/xhtml+xml; charset=ISO-8859-1" />
<!-- begin whos online page header code -->
<script type="text/javascript" language="JavaScript">
<!--
function who_is(url) {
  window.open(url,"who_is_lookup","height=650,width=800,toolbar=no,statusbar=no,scrollbars=yes").focus();
}

//-->
</script>
<!-- end whos been online page header code -->
</head>
<body>


<div id="main-copy">


<h1>Who's Been Online</h1>


 <?php include($C['files_path'].'include-whos-been-online.php'); ?>

</div><!-- end main-copy -->

   </body>
</html>