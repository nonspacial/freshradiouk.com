<?php 
include ("whos-online/include-whos-online-header.php");

//require_once("Settings.php");
 global $SITE;
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN"
   "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">

<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en-US">
<head>
<title><?php echo TEXT_VISITOR_MAPS ?></title>
<style type="text/css">
table.wo_map {
margin-left:auto;
margin-right:auto;
}
#wrapper {
margin-left:auto;
margin-right:auto;
text-align:center;
}
h3 {
font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
font-size: 14px;
}
p {
font-family: "Lucida Grande", Verdana, Arial, "Bitstream Vera Sans", sans-serif;
font-size: 12px;
}
</style>
<script type="text/javascript"><!--

function getRefToDivMod( divID, oDoc ) {
	if( !oDoc ) { oDoc = document; }
	if( document.layers ) {
		if( oDoc.layers[divID] ) { return oDoc.layers[divID]; } else {
			for( var x = 0, y; !y && x < oDoc.layers.length; x++ ) {
				y = getRefToDivNest(divID,oDoc.layers[x].document); }
			return y; } }
	if( document.getElementById ) { return oDoc.getElementById(divID); }
	if( document.all ) { return oDoc.all[divID]; }
	return oDoc[divID];
}

function resizeWinTo( idOfDiv ) {
	var oH = getRefToDivMod( idOfDiv ); if( !oH ) { return false; }
	var x = window; x.resizeTo( screen.availWidth, screen.availWidth );
	var oW = oH.clip ? oH.clip.width : oH.offsetWidth;
	var oH = oH.clip ? oH.clip.height : oH.offsetHeight; if( !oH ) { return false; }
	x.resizeTo( oW + 200, oH + 200 );
	var myW = 0, myH = 0, d = x.document.documentElement, b = x.document.body;
	if( x.innerWidth ) { myW = x.innerWidth; myH = x.innerHeight; }
	else if( d && d.clientWidth ) { myW = d.clientWidth; myH = d.clientHeight; }
	else if( b && b.clientWidth ) { myW = b.clientWidth; myH = b.clientHeight; }
	if( window.opera && !document.childNodes ) { myW += 16; }
	//second sample, as the table may have resized
	var oH2 = getRefToDivMod( idOfDiv );
	var oW2 = oH2.clip ? oH2.clip.width : oH2.offsetWidth;
	var oH2 = oH2.clip ? oH2.clip.height : oH2.offsetHeight;
	x.resizeTo( oW2 + ( ( oW + 200 ) - myW ), oH2 + ( (oH + 200 ) - myH ) );
}

//--></script>
</head>

<?php if ($C['enable_location_plugin']) {

// http://www.howtocreate.co.uk/perfectPopups.html
?>
<body onload="resizeWinTo('wrapper');" style="padding:0;margin:0;">


<div style="position:absolute;left:0px;top:0px;" id="wrapper">
<table><tr><td>
<?php
/*       require_once(dirname(__FILE__) .'/class-wo-map-page.php');
       $wo_map_page = new WoMapPage();
       $wo_map_page->do_map_page();*/

$map_time = $C['default_map_time'];  // default
$map_units = $C['default_map_units']; // default
$map_text_color = 'FBFB00';  // default
$map_text_shadow_color = '3F3F3F';  // default
$map_selected = $C['default_map'];  // default

if (isset($_POST['time']) && is_numeric($_POST['time'])) {
  $map_time = floor($_POST['time']);
}
if (isset($_POST['units']) && validate_map_units($_POST['units'])) {
  $map_units = $_POST['units'];
}
if (isset($_POST['textcolor']) && validate_input_color($_POST['textcolor'])) {
  $map_text_color = $_POST['textcolor'];
}
if (isset($_POST['textcolors']) && validate_input_color($_POST['textcolors'])) {
  $map_text_shadow_color = $_POST['textcolors'];
}
if (isset($_POST['map']) && is_numeric($_POST['map'])) {
  $map_selected = floor($_POST['map']);
}
?>

<form method="post" name="time_select" action="">
<p>
<?php echo TEXT_VISITOR_MAPS ?>
<br /><br />
<?php echo TEXT_SELECT_TIME ?> <?php echo $C['store_days']; ?> <?php echo TEXT_DAYS_AGO ?>:<br />
<label for="time"><?php echo TEXT_TIME ?>:</label>
<input type="text" id="time" name="time" value="<?php echo $map_time ?>" size="3" />
<label for="units"><?php echo TEXT_UNITS ?>:</label>
<select id="units" name="units">
<?php
$map_units_array =array(
'minutes' => TEXT_MINUTES,
'hours' => TEXT_HOURS,
'days' => TEXT_DAYS,
);
$selected = '';
foreach ($map_units_array as $k => $v) {
 if ($map_units == "$k")  $selected = ' selected="selected"';
 echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>'."\n";
 $selected = '';
}
?>
</select>
<!-- <br />
<label for="textcolor">Text Color:</label>
<input type="text" id="textcolor" name="textcolor" value="<?php echo $map_text_color ?>" size="8" />
<label for="textcolors">Text Shadow Color:</label>
<input type="text" id="textcolors" name="textcolors" value="<?php echo $map_text_shadow_color ?>" size="8" />
-->
<br />
<label for="map"><?php echo TEXT_MAP ?>:</label>
<select id="map" name="map">
<?php
$map_select_array = array(
'1'  => 'World (smallest)',
'2'  => 'World (small)',
'3'  => 'World (medium)',
'4'  => 'World (large)',
'5'  => 'US (black)',
'6'  => 'US (brown)',
'7'  => 'Canada and US (black)',
'8'  => 'Canada and US (brown)',
'9'  => 'Asia (black)',
'10' => 'Asia (brown)',
'11' => 'Australia and NZ (black)',
'12' => 'Australia and NZ (brown)',
'13' => 'Europe Central (black)',
'14' => 'Europe Central (brown)',
'15' => 'Europe (black)',
'16' => 'Europe (brown)',
'17' => 'Finland (black)',
'18' => 'Finland (brown)',
'19' => 'Great Britain (black)',
'20' => 'Great Britain (brown)',
'21' => 'US Midwest (black)',
'22' => 'US Midwest (brown)',
'23' => 'US Upper Midwest (black)',
'24' => 'US Upper Midwest (brown)',
'25' => 'US Northeast (black)',
'26' => 'US Northeast (brown)',
'27' => 'US Northwest (black)',
'28' => 'US Northwest (brown)',
'29' => 'US Rocky Mountain (black)',
'30' => 'US Rocky Mountain (brown)',
'31' => 'US South (black)',
'32' => 'US South (brown)',
'33' => 'US Southeast (black)',
'34' => 'US Southeast (brown)',
'35' => 'US Southwest (black)',
'36' => 'US Southwest (brown)',
'37' => 'Spain/Portugal (black)',
'38' => 'Spain/Portugal (brown)',
);
$selected = '';
foreach ($map_select_array as $k => $v) {
 if ($map_selected == "$k")  $selected = ' selected="selected"';
 echo '<option value="'.$k.'"'.$selected.'>'.$v.'</option>'."\n";
 $selected = '';
}
?>
</select>
<input type="submit" name="<?php echo TEXT_GO ?>" value="<?php echo TEXT_GO ?>" />
</p>
</form>


<?php

// I just put these here for my reference, they are actually set in include-whos-online-settings.php
// worldmap image names
/*
$C['image_worldmap']    = 'wo-worldmap-smallest.jpg';// World (smallest) do not delete this one, it is the default
$C['image_worldmap_1']  = 'wo-worldmap-smallest.jpg';// World (smallest) do not delete this one, it is the default
$C['image_worldmap_2']  = 'wo-worldmap-small.jpg';   // World (small)
$C['image_worldmap_3']  = 'wo-worldmap-medium.jpg';  // World (medium)
$C['image_worldmap_4']  = 'wo-worldmap-large.jpg';   // World (large)
$C['image_worldmap_5']  = 'wo-us-black-map.png';     // US (black)
$C['image_worldmap_6']  = 'wo-us-brown-map.png';     // US (brown)
$C['image_worldmap_7']  = 'wo-akus-black-map.png';   // Canada and US (black)
$C['image_worldmap_8']  = 'wo-akus-brown-map.png';   // Canada and US (brown)
$C['image_worldmap_9']  = 'wo-asia-black-map.png';   // Asia (black)
$C['image_worldmap_10']  = 'wo-asia-brown-map.png';   // Asia (brown)
$C['image_worldmap_11']  = 'wo-aus-nz-black-map.png'; // Australia and NZ (black)
$C['image_worldmap_12'] = 'wo-aus-nz-brown-map.png'; // Australia and NZ (brown)
$C['image_worldmap_13'] = 'wo-ceu-black-map.png';    // Europe Central (black)
$C['image_worldmap_14'] = 'wo-ceu-brown-map.png';    // Europe Central (brown)
$C['image_worldmap_15'] = 'wo-eu-black-map.png';     // Europe (black)
$C['image_worldmap_16'] = 'wo-eu-brown-map.png';     // Europe (brown)
$C['image_worldmap_17'] = 'wo-fin-black-map.png';    // Finland (black)
$C['image_worldmap_18'] = 'wo-fin-brown-map.png';    // Finland (brown)
$C['image_worldmap_19'] = 'wo-gb-black-map.png';     // Great Britain (black)
$C['image_worldmap_20'] = 'wo-gb-brown-map.png';     // Great Britain (brown)
$C['image_worldmap_21'] = 'wo-mwus-black-map.png';   // US Midwest (black)
$C['image_worldmap_22'] = 'wo-mwus-brown-map.png';   // US Midwest (brown)
$C['image_worldmap_23'] = 'wo-ncus-black-map.png';   // US Upper Midwest (black)
$C['image_worldmap_24'] = 'wo-ncus-brown-map.png';   // US Upper Midwest (brown)
$C['image_worldmap_25'] = 'wo-neus-black-map.png';   // US Northeast (black)
$C['image_worldmap_26'] = 'wo-neus-brown-map.png';   // US Northeast (brown)
$C['image_worldmap_27'] = 'wo-nwus-black-map.png';   // US Northwest (black)
$C['image_worldmap_28'] = 'wo-nwus-brown-map.png';   // US Northwest (brown)
$C['image_worldmap_29'] = 'wo-rmus-black-map.png';   // US Rocky Mountain (black)
$C['image_worldmap_30'] = 'wo-rmus-brown-map.png';   // US Rocky Mountain (brown)
$C['image_worldmap_31'] = 'wo-scus-black-map.png';   // US South (black)
$C['image_worldmap_32'] = 'wo-scus-brown-map.png';   // US South (brown)
$C['image_worldmap_33'] = 'wo-seus-black-map.png';   // US Southeast (black)
$C['image_worldmap_34'] = 'wo-seus-brown-map.png';   // US Southeast (brown)
$C['image_worldmap_35'] = 'wo-swus-black-map.png';   // US Southwest (black)
$C['image_worldmap_36'] = 'wo-swus-brown-map.png';   // US Southwest (brown)
$C['image_worldmap_37'] = 'wo-es-pt-black-map.png';   // Spain/Portugal (black)
$C['image_worldmap_38'] = 'wo-es-pt-brown-map.png';   // Spain/Portugal (brown)
*/
?>

<?php
if ($map_selected == 1) {
echo '<!-- World (smallest) -->' . "\n";
$map_settings = array(
// html map settings World (small)
// set these settings as needed
'time'       => $map_time,      // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => '1',       // 1,2 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => '000000',  // any hex color code
'textshadow' => 'FFFFFF',  // any hex color code
'textalign'  => 'cb',      // ll , ul, lr, ur, c, ct, cb  (these codes mean lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '0',       // default 0 for worldmap
'ul_lon'     => '0',       // default 0 for worldmap
'lr_lat'     => '360',     // default 360 for worldmap
'lr_lon'     => '180',     // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '0',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'jpg',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 2) {
echo '<!-- World (small) -->' . "\n";
$map_settings = array(
// html map settings World (small)
// set these settings as needed
'time'       => $map_time,      // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => '2',       // 1,2 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => '000000',  // any hex color code
'textshadow' => 'FFFFFF',  // any hex color code
'textalign'  => 'cb',      // ll , ul, lr, ur, c, ct, cb  (these codes mean lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '0',       // default 0 for worldmap
'ul_lon'     => '0',       // default 0 for worldmap
'lr_lat'     => '360',     // default 360 for worldmap
'lr_lon'     => '180',     // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '0',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'jpg',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 3) {
echo '<!-- World (medium) -->' . "\n";
$map_settings = array(
// html map settings World (small)
// set these settings as needed
'time'       => $map_time,      // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => '3',       // 1,2 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => '000000',  // any hex color code
'textshadow' => 'FFFFFF',  // any hex color code
'textalign'  => 'cb',      // ll , ul, lr, ur, c, ct, cb  (these codes mean lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '0',       // default 0 for worldmap
'ul_lon'     => '0',       // default 0 for worldmap
'lr_lat'     => '360',     // default 360 for worldmap
'lr_lon'     => '180',     // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '0',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'jpg',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 4) {
echo '<!-- World (large) --> ' . "\n";
$map_settings = array(
// html map settings World (large)
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => '4',       // 1,2 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => '000000',  // any hex color code
'textshadow' => 'FFFFFF',  // any hex color code
'textalign'  => 'cb',      // ll , ul, lr, ur, c, ct, cb  (these codes mean lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '0',       // default 0 for worldmap
'ul_lon'     => '0',       // default 0 for worldmap
'lr_lat'     => '360',     // default 360 for worldmap
'lr_lon'     => '180',     // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '0',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 5 || $map_selected == 6) {
echo '<!-- US Map --> ' . "\n";
$map_settings = array(
// html map settings US Map
// set these settings as needed
'time'       => $map_time,     // digits of time
'units'      => $map_units,    // minutes, hours, or days (with or without the "s")
'map'        => $map_selected, // 1,2,3 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more map images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '58.30',   // default 0 for worldmap
'ul_lon'     => '-125.26', // default 0 for worldmap
'lr_lat'     => '12.76',   // default 360 for worldmap
'lr_lon'     => '-65.98',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '37',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 7 || $map_selected == 8) {
echo '<!-- Canada and US Map --> ' . "\n";
$map_settings = array(
// html map settings Canada and US Map
// set these settings as needed
'time'       => $map_time,     // digits of time
'units'      => $map_units,    // minutes, hours, or days (with or without the "s")
'map'        => $map_selected, // 1,2,3 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more map images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '65.30',   // default 0 for worldmap
'ul_lon'     => '-167.83', // default 0 for worldmap
'lr_lat'     => '-27.52',   // default 360 for worldmap
'lr_lon'     => '-52.17',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '52',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 0 || $map_selected == 10) {
echo '<!-- Asia Map -->' . "\n";
$map_settings = array(
// html map settings Asia Map
// set these settings as needed
'time'       => $map_time,     // digits of time
'units'      => $map_units,    // minutes, hours, or days (with or without the "s")
'map'        => $map_selected, // 1,2,3 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more map images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '55.84',   // default 0 for worldmap
'ul_lon'     => '63.86',   // default 0 for worldmap
'lr_lat'     => '-4.67',   // default 360 for worldmap
'lr_lon'     => '136.14',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '25',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 11 || $map_selected == 12) {
echo '<!-- Australia and NZ Map --> ' . "\n";
$map_settings = array(
// html map settings Australia and NZ Map
// set these settings as needed
'time'       => $map_time,     // digits of time
'units'      => $map_units,    // minutes, hours, or days (with or without the "s")
'map'        => $map_selected, // 1,2,3 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more map images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '9.56',    // default 0 for worldmap
'ul_lon'     => '112.75',  // default 0 for worldmap
'lr_lat'     => '-49.35',  // default 360 for worldmap
'lr_lon'     => '179.25',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '-30',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 13 || $map_selected == 14) {
echo '<!-- Europe Central Map  -->' . "\n";
$map_settings = array(
// html map settings Europe Central Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '58.42',   // default 0 for worldmap
'ul_lon'     => '-4.46',   // default 0 for worldmap
'lr_lat'     => '39.80',   // default 360 for worldmap
'lr_lon'     => '24.46',   // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '25',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 15 || $map_selected == 16) {
echo '<!-- Europe Map  -->' . "\n";
$map_settings = array(
// html map settings Europe Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '63.26',   // default 0 for worldmap
'ul_lon'     => '-2.47',   // default 0 for worldmap
'lr_lat'     => '26.40',   // default 360 for worldmap
'lr_lon'     => '52.47',   // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '44',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 17 || $map_selected == 18) {
echo '<!-- Finland Map --> ' . "\n";
$map_settings = array(
// html map settings Finland Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '64.88',   // default 0 for worldmap
'ul_lon'     => '-4.46',   // default 0 for worldmap
'lr_lat'     => '49.49',   // default 360 for worldmap
'lr_lon'     => '24.46',   // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '10',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 19 || $map_selected == 20) {
echo '<!-- Great Britain Map  -->' . "\n";
$map_settings = array(
// html map settings Great Britain  Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '62.47',   // default 0 for worldmap
'ul_lon'     => '-12.46',   // default 0 for worldmap
'lr_lat'     => '45.83',   // default 360 for worldmap
'lr_lon'     => '16.46',   // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '21',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 21 || $map_selected == 22) {
echo '<!-- US Midwest Map -->' . "\n";
$map_settings = array(
// html map settings US Midwest Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '51.29',   // default 0 for worldmap
'ul_lon'     => '-100.84', // default 0 for worldmap
'lr_lat'     => '35.69',   // default 360 for worldmap
'lr_lon'     => '-79.16',  // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '17',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 23 || $map_selected == 24) {
echo '<!-- US Upper Midwest Map -->' . "\n";
$map_settings = array(
// html map settings US Upper Midwest Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '53.49',   // default 0 for worldmap
'ul_lon'     => '-115.46', // default 0 for worldmap
'lr_lat'     => '32.70',   // default 360 for worldmap
'lr_lon'     => '-86.54',  // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '20',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 25 || $map_selected == 26) {
echo '<!-- US Northeast Map -->' . "\n";
$map_settings = array(
// html map settings US Northeast Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',     // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '51.84',   // default 0 for worldmap
'ul_lon'     => '-92.46',   // default 0 for worldmap
'lr_lat'     => '30.37',   // default 360 for worldmap
'lr_lon'     => '-63.54',   // default 180 for worldmap
'offset_x'   => '0',      // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '20',     // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',    // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 27 || $map_selected == 28) {
echo '<!-- US Northwest Map -->' . "\n";
$map_settings = array(
// html map settings US Northwest Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2,3 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'ct',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '53.49',   // default 0 for worldmap
'ul_lon'     => '-126.46', // default 0 for worldmap
'lr_lat'     => '32.70',   // default 360 for worldmap
'lr_lon'     => '-97.54',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '25',      // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 29 || $map_selected == 30) {
echo '<!-- US Rocky Mountain Map -->' . "\n";
$map_settings = array(
// html map settings US Rocky Mountain Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2,3 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '50.17',   // default 0 for worldmap
'ul_lon'     => '-124.46',   // default 0 for worldmap
'lr_lat'     => '28.06',   // default 360 for worldmap
'lr_lon'     => '-95.54',   // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '15',      // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 31 || $map_selected == 32) {
echo '<!-- US South Map -->' . "\n";
$map_settings = array(
// html map settings US South Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2,3 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '45.11',   // default 0 for worldmap
'ul_lon'     => '-112.46', // default 0 for worldmap
'lr_lat'     => '21.23',   // default 360 for worldmap
'lr_lon'     => '-83.54',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '9',      // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 33 || $map_selected == 34) {
echo '<!-- US Southeast Map -->' . "\n";
$map_settings = array(
// html map settings US Southeast Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2,3 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '43.40',   // default 0 for worldmap
'ul_lon'     => '-100.46', // default 0 for worldmap
'lr_lat'     => '18.99',   // default 360 for worldmap
'lr_lon'     => '-71.54',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '5',      // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 35 || $map_selected == 36) {
echo '<!-- US Southwest Map -->' . "\n";
$map_settings = array(
// html map settings US Southwest Map
// set these settings as needed
'time'       => $map_time,  // digits of time
'units'      => $map_units, // minutes, hours, or days (with or without the "s")
'map'        => $map_selected,        // 1,2,3 (you can add more map images in settings)
'pin'        => '1',        // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',      // off (off is required for html map)
'text'       => 'on',       // on or off
'textcolor'  => $map_text_color,         // any hex color code
'textshadow' => $map_text_shadow_color,  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '46.80',   // default 0 for worldmap
'ul_lon'     => '-126.46', // default 0 for worldmap
'lr_lat'     => '23.49',   // default 360 for worldmap
'lr_lon'     => '-97.54',  // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '10',      // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

if ($map_selected == 37 || $map_selected == 38) {
echo '<!-- Spain/Portugal Map -->' . "\n";
$map_settings = array(
// html map settings for Spain/Portugal Map
// set these settings as needed
'time'       => $map_time, // digits of time
'units'      => $map_units,// minutes, hours, or days (with or without the "s")
'map'        => $map_selected,  // 1,2,3 (you can add more map images in settings)
'pin'        => '1',       // 1,2,3 (you can add more pin images in settings)
'pins'       => 'off',     // off (off is required for html map)
'text'       => 'on',      // on or off
'textcolor'  => 'FBFB00',  // any hex color code
'textshadow' => '3F3F3F',  // any hex color code
'textalign'  => 'cb',      // ll, ul, lr, ur, c, ct, cb (codes for: lower left, upper left, upper right, center, center top, center bottom)
'ul_lat'     => '45.01',   // default 0 for worldmap
'ul_lon'     => '-10.69',  // default 0 for worldmap
'lr_lat'     => '34.56',   // default 360 for worldmap
'lr_lon'     => '3.13',    // default 180 for worldmap
'offset_x'   => '0',       // + or - offset for x axis  - moves pins left, + moves pins right
'offset_y'   => '0',       // + or - offset for y axis  - moves pins up,   + moves pins down
'type'       => 'png',     // jpg or png (map output type)
);
echo get_whos_online_worldmap($map_settings);
}

       echo '<p><a href="javascript:window.close()">Close</a></p>';
           if ($C['enable_credit_link']) {
              echo '<p><small>Powered by Who\'s Online</small></p>';
           }
       echo'</td></tr></table></div>';

    } else {
         echo '<body><p>Geolocation is disabled in settings.</p>';
    }
    // footer

function validate_map_units($string) {
 // only allow proper text align codes
  $allowed = array('minutes','hours','days');
 if ( in_array($string, $allowed) ) {
    return true;
 }
 return false;
} // end function validate_text_align

function validate_input_color($string) {
 # protect form input color fields from hackers and check for valid css color code hex
 # only allow simple 6 char hex codes with or without # like this 336699 or #336699

if ( is_string($string) && preg_match("/^#[a-f0-9]{6}$/i", trim($string))) {
    return true;
 }
 if ( is_string($string) && preg_match("/^[a-f0-9]{6}$/i", trim($string))) {
    return true;
 }
 return false;
}

?>
</body>
</html>