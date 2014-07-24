<?php
/*

This file reads the whos-online database and makes a PNG image worldmap to display all visitors for the last 15 minutes
thanks to pinto (www.joske-online.be) for the idea and code sample

Who's Online PHP Script by Mike Challis
Free PHP Scripts - www.642weather.com/weather/scripts.php
Download         - www.642weather.com/weather/scripts/whos-online.zip
Live Example     - www.642weather.com/weather/whos-online.php
Contact Mike     - www.642weather.com/weather/contact_us.php
Donate: https://www.paypal.com/cgi-bin/webscr?cmd=_s-xclick&hosted_button_id=2319642  

Version: 3.02 - 29-Apr-2014 see changelog.txt for changes

You are free to use and modify the code

This php code provided "as is", and Long Beach Weather (Michael Challis)
disclaims any and all warranties, whether express or implied, including
(without limitation) any implied warranties of merchantability or
fitness for a particular purpose.

Copyright (C) 2008-2014 Mike Challis  (www.642weather.com/weather/contact_us.php)

This program is free software; you can redistribute it and/or modify
it under the terms of the GNU General Public License as published by
the Free Software Foundation; either version 2 of the License, or
(at your option) any later version.

This program is distributed in the hope that it will be useful,
but WITHOUT ANY WARRANTY; without even the implied warranty of
MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
GNU General Public License for more details.

You should have received a copy of the GNU General Public License
along with this program; if not, write to the Free Software
Foundation, Inc., 59 Temple Place, Suite 330, Boston, MA  02111-1307  USA
*/

// image name settings located in include-whos-online-settings.php

// no settings below this line --------------------------------------------

  require_once ('include-whos-online-settings.php');

  if (!$C['enable_location_plugin']) {
     return '<p>get_whos_online_worldmap error: whos online location_plugin not enabled or installed</p>';
  }

  // set lat lon coordinates for worldmaps and custom regional maps.
  $ul_lat=0; $ul_lon=0; $lr_lat=360; $lr_lon=180; // default worldmap
  if ( isset($_GET['ul_lat']) && is_numeric($_GET['ul_lat'])  ) {
     $ul_lat = $_GET['ul_lat'];
  }
  if ( isset($_GET['ul_lon']) && is_numeric($_GET['ul_lon'])  ) {
     $ul_lon = $_GET['ul_lon'];
  }
  if ( isset($_GET['lr_lat']) && is_numeric($_GET['lr_lat'])  ) {
     $lr_lat = $_GET['lr_lat'];
  }
  if ( isset($_GET['lr_lon']) && is_numeric($_GET['lr_lon'])  ) {
     $lr_lon = $_GET['lr_lon'];
  }
  $offset_x = $offset_y = 0;
  if ( isset($_GET['offset_x']) && is_numeric($_GET['offset_x'])  ) {
     $offset_x = floor($_GET['offset_x']);
  }
  if ( isset($_GET['offset_y']) && is_numeric($_GET['offset_y'])  ) {
     $offset_y = floor($_GET['offset_y']);
  }
  // select text on or off
  $G['text_display'] = false; // default
  if ( isset($_GET['text']) && $_GET['text'] == 'on' ) {
    $G['text_display']  = true;
  }
  // select text align
  $G['text_align']  = 'cb'; // default center bottom
  if( isset($_GET['textalign']) && validate_text_align($_GET['textalign']) ) {
    $G['text_align'] =  $_GET['textalign'];
  }
  // select text color by hex code
  $G['text_color']  = '800000'; // default blue
  if( isset($_GET['textcolor']) && validate_color_wo($_GET['textcolor']) ) {
    $G['text_color'] =  str_replace('#','',$_GET['textcolor']);  // hex
  }
  // select text shadow color by hex code
  $G['text_shadow_color']  = 'C0C0C0'; // default white
  if( isset($_GET['textshadow']) && validate_color_wo($_GET['textshadow']) ) {
    $G['text_shadow_color'] =  str_replace('#','',$_GET['textshadow']);  // hex
  }
  // select pins on or off
  $G['pins_display'] = true;  // default
  if ( isset($_GET['pins']) && $_GET['pins'] == 'off' ) {
    $G['pins_display'] = false;
  }

  // select time units
  if ( isset($_GET['time']) && is_numeric($_GET['time']) && isset($_GET['units']) ) {
      $time  = floor($_GET['time']);
      $units = $_GET['units'];
      $units_filtered = '';
     if ( $time > 0 && ($units == 'minute' || $units == 'minutes') ) {
           $seconds_ago = ($time * 60); // minutes
           $units_filtered = $units;
           $units_lang = TEXT_MINUTES;
     } else if( $time > 0 && ($units == 'hour' || $units == 'hours') ) {
           $seconds_ago = ($time * 60*60); // hours
           $units_filtered = $units;
           $units_lang = TEXT_HOURS;
     } else if( $time > 0 && ($units == 'day' || $units == 'days') ) {
           $seconds_ago = ($time * 60*60*24); // days
           $units_filtered = $units;
           $units_lang = TEXT_DAYS;
     } else {
           $seconds_ago = abs(intval($C['track_time'] * 60)); // default
     }

  } else {
          $seconds_ago = abs(intval($C['track_time'] * 60)); // default
  }

  // select map image
  $image_worldmap_path = $C['files_path'] . 'images/' . $C['image_worldmap'];  // default
  if ( isset($_GET['map']) && is_numeric($_GET['map']) ) {
     $image_worldmap_path = $C['files_path'] . 'images/' . $C['image_worldmap_'.floor($_GET['map'])];
     if (!file_exists($C['files_path'] . 'images/' . $C['image_worldmap_'.floor($_GET['map'])])) {
          $image_worldmap_path = $C['files_path'] . 'images/' . $C['image_worldmap'];  // default
     }
  }
  // select pin image
  $image_pin_path = $C['files_path'] . 'images/' . $C['image_pin'];  // default
  if ( isset($_GET['pin']) && is_numeric($_GET['pin']) ) {
     $image_pin_path = $C['files_path'] . 'images/' . $C['image_pin_'.floor($_GET['pin'])];
     if (!file_exists($C['files_path'] . 'images/' . $C['image_pin_'.floor($_GET['pin'])])) {
          $image_pin_path = $C['files_path'] . 'images/' . $C['image_pin'];  // default
     }
  }

  // get image data
  list($image_worldmap_width, $image_worldmap_height, $image_worldmap_type) = getimagesize($image_worldmap_path);
  list($image_pin_width, $image_pin_height, $image_pin_type) = getimagesize($image_pin_path);

  switch($image_worldmap_type) {
        case "1": $map_im = imagecreatefromgif("$image_worldmap_path");
        break;
        case "2": $map_im = imagecreatefromjpeg("$image_worldmap_path");
        break;
        case "3": $map_im = imagecreatefrompng("$image_worldmap_path");
        break;
  }
  switch($image_pin_type) {
        case "1": $pin_im = imagecreatefromgif("$image_pin_path");
        break;
        case "2": $pin_im = imagecreatefromjpeg("$image_pin_path");
        break;
        case "3": $pin_im = imagecreatefrompng("$image_pin_path");
        break;
  }

    // map parameters
  $scale = 360 / $image_worldmap_width;

  //$green = imagecolorallocate ($map_im, 0,255,0);

  // Connect to the mysqli database now
  $wo_dbh = mysqli_connect($C['dbhost'], $C['dbuser'], $C['dbpass']);
  if (!$wo_dbh) die('Could not connect: ' . mysqli_error($wo_dbh));
  mysqli_select_db($wo_dbh,$C['dbname']) or die(mysqli_error($wo_dbh));

  // Time to remove old entries
  $xx_secs_ago = (time() - $seconds_ago);

  if ($C['show_bots_on_worldmap']) {
       $query = "SELECT longitude, latitude FROM ".TABLE_WHOS_ONLINE."
                 WHERE time_last_click > '" . $xx_secs_ago . "'";
  } else {
       $query = "SELECT longitude, latitude FROM ".TABLE_WHOS_ONLINE."
                 WHERE name = 'Guest' AND time_last_click > '" . $xx_secs_ago . "'";
  }

  $result = mysqli_query($wo_dbh,$query) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);

  $count = 0;
  // create pins on the map
  while($row = mysqli_fetch_array($result, MYSQL_ASSOC)) {
    if ($row['longitude'] != '0.0000' && $row['latitude'] != '0.0000') {

      if ($ul_lat == 0) { // must be the world map
            $count++;
			$x = floor ( ( $row['longitude'] + 180 ) / $scale );
			$y = floor ( ( 180 - ( $row['latitude'] + 90 ) ) / $scale );
	  } else {      // its a custom map
           // filter out what we do not want
           if ( ($row['latitude'] > $lr_lat && $row['latitude'] < $ul_lat) &&
                ($row['longitude'] < $lr_lon && $row['longitude'] > $ul_lon) ) {
            $count++;
            $x = floor ($image_worldmap_width * ($row['longitude'] - $ul_lon) / ($lr_lon - $ul_lon)+ $offset_x);
            $y = floor ($image_worldmap_height * ($row['latitude'] - $ul_lat) / ($lr_lat - $ul_lat)+ $offset_y);

            // discard pixels that are outside the image because of offsets
            if ( ($x < 0 || $x > $image_worldmap_width ) || ($y < 0 || $y > $image_worldmap_height) ) {
               $count--;
               continue;
            }
          } else {
                  continue;
          }
      }

      // Now mark the point on the map using a green 2 pixel rectangle
      //imagefilledrectangle($map_im,$x-1,$y-1,$x+1,$y+1,$green);
      if ($G['pins_display']) {
        // put pin image on map image
        imagecopy($map_im, $pin_im, $x, $y, 0, 0, $image_pin_width, $image_pin_height);
      }
    }
  }

  if ( $G['text_display'] ) {
     if ($units_filtered != '') {
         $text = "$count ".TEXT_VISITORS_SINCE." $time $units_lang ".TEXT_AGO;
     } else {
         $text = "$count ".TEXT_VISITORS_SINCE." ".abs(intval($C['track_time'])).' '.TEXT_MINUTES.' '.TEXT_AGO;
     }
     textoverlay($text, $map_im, $image_worldmap_width, $image_worldmap_height);
  }


  // Close the database connection
  mysqli_close($wo_dbh);

  // Return the map image
  if ( isset($_GET['type']) && $_GET['type'] == 'jpg' ) {
        header("Content-Type: image/jpeg");
        imagejpeg($map_im);
  } else if( isset($_GET['type']) && $_GET['type'] == 'png' ) {
        header("Content-Type: image/png");
        imagepng($map_im);
  } else {
        header("Content-Type: image/png");
        imagepng($map_im);
  }

  imagedestroy($map_im);
  imagedestroy($pin_im);

// begin functions -------------------------------------------------------------

function findYcoord($myLat, $lr_lat, $mapHeight, $rfactor) {
      //$mapHeight = 396;
      //$rfactor = 290; // map scale
      $radBtm = deg2rad($lr_lat);
      $radPixel = deg2rad($myLat);
      $sinRadBtm = sin($radBtm);
      $sinRadPixel = sin($radPixel);
      $convHtBtm = $rfactor * log((1 + $sinRadPixel)/(1 - $sinRadPixel));
      $convHtPixel = $rfactor * log((1 + $sinRadBtm)/(1 - $sinRadBtm));
      $myTotHt = abs($convHtPixel - $convHtBtm);
      $myYcoord = round($mapHeight - $myTotHt, 3);
      return $myYcoord;
}

function textoverlay($text, $image_p, $new_width, $new_height) {
    global $G, $C;

    $fontstyle = 5; // 1,2,3,4 or 5
    $fontcolor = $G['text_color'];
    $fontshadowcolor = $G['text_shadow_color'];
    $ttfont = (isset($C['map_text_font'])) ? $C['map_text_font'] : '';
    $fontsize = 12; # size for True Type Font $ttfont only (8-18 recommended)
    $textalign = $G['text_align'];
    $xmargin = 5;
    $ymargin = 0;

    if (!preg_match('#[a-z0-9]{6}#i', $fontcolor)) $fontcolor = 'FFFFFF';  # default white
    if (!preg_match('#[a-z0-9]{6}#i', $fontshadowcolor)) $fontshadowcolor = '808080'; # default grey
    $fcint = hexdec("#$fontcolor");
    $fsint = hexdec("#$fontshadowcolor");
    $fcarr = array("red" => 0xFF & ($fcint >> 0x10),"green" => 0xFF & ($fcint >> 0x8),"blue" => 0xFF & $fcint);
    $fsarr = array("red" => 0xFF & ($fsint >> 0x10),"green" => 0xFF & ($fsint >> 0x8),"blue" => 0xFF & $fsint);
    $fcolor  = imagecolorallocate($image_p, $fcarr["red"], $fcarr["green"], $fcarr["blue"]);
    $fscolor = imagecolorallocate($image_p, $fsarr["red"], $fsarr["green"], $fsarr["blue"]);
    if ($ttfont != '') {
       # using ttf fonts
       $_b = imageTTFBbox($fontsize,0,$ttfont,'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789');
       $fontheight = abs($_b[7]-$_b[1]);
    } else {
      $font = $fontstyle;
      # using built in fonts, find alignment
      if($font < 0 || $font > 5){ $font = 1; }
          $fontwidth = ImageFontWidth($font);
          $fontheight = ImageFontHeight($font);
      }
      $text = preg_replace("/\r/",'',$text);
      # wordwrap line if too many characters on one line
      if ($ttfont != '') {
         # array lines
         $lines = explode("\n", $text);
         $lines = ttf_wordwrap($lines,$ttfont,$fontsize,floor($new_width - ($xmargin * 2)));
      } else {
        $maxcharsperline = floor(($new_width - ($xmargin * 2)) / $fontwidth);
        $text = wordwrap($text, $maxcharsperline, "\n", 1);
        # array lines
        $lines = explode("\n", $text);
      }
      # determine alignment
      $align = 'ul'; # default upper left
      if ($textalign == 'll') $align = 'll'; // lowerleft
      if ($textalign == 'ul') $align = 'ul'; // upperleft
      if ($textalign == 'lr') $align = 'lr'; // lowerright
      if ($textalign == 'ur') $align = 'ur'; // upperright
      if ($textalign == 'c')  $align = 'c';  // center
      if ($textalign == 'ct') $align = 'ct'; // centertop
      if ($textalign == 'cb') $align = 'cb'; // centerbottom
      # find start position for each text position type
      if ($align == 'ul') { $x = $xmargin; $y = $ymargin;}
      if ($align == 'll') { $x = $xmargin;
         $y = $new_height - ($fontheight + $ymargin);
         $lines = array_reverse($lines);
      }
      if ($align == 'ur') $y = $ymargin;
      if ($align == 'lr') { $x = $xmargin;
         $y = $new_height - ($fontheight + $ymargin);
         $lines = array_reverse($lines);
      }
      if ($align == 'ct') $y = $ymargin;
      if ($align == 'cb') { $x = $xmargin;
         $y = $new_height - ($fontheight + $ymargin);
         $lines = array_reverse($lines);
      }
      if ($align == 'c') $y = ($new_height/2) - ((count($lines) * $fontheight)/2);
      if ($ttfont != '') $y +=$fontsize; # fudge adjustment for truetype margin
         while (list($numl, $line) = each($lines)) {
             # adjust position for each text position type
             if ($ttfont != '') {
                $_b = imageTTFBbox($fontsize,0,$ttfont,$line);
                $stringwidth = abs($_b[2]-$_b[0]);
             }else{
                $stringwidth = strlen($line) * $fontwidth;
             }
             if ($align == 'ur'||$align == 'lr') $x = ($new_width - ($stringwidth) - $xmargin);
             if ($align == 'ct'||$align == 'cb'||$align == 'c') $x = $new_width/2 - $stringwidth/2;
             if ($ttfont != '') {
                # write truetype font text with slight SE shadow to standout
                imagettftext($image_p, $fontsize, 0, $x-1, $y, $fscolor, $ttfont, $line);
                imagettftext($image_p, $fontsize, 0, $x, $y-1, $fcolor, $ttfont, $line);
             }else{
                # write text with slight SE shadow to standout
                imagestring($image_p,$font,$x-1,$y,$line,$fscolor);
                imagestring($image_p,$font,$x,$y-1,$line,$fcolor);
             }
             # adjust position for each text position type
             if ($align == 'ul'||$align == 'ur'||$align == 'ct'||$align == 'c') $y += $fontheight;
             if ($align == 'll'||$align == 'lr'||$align == 'cb') $y -= $fontheight;
         } # end while
} // end function textoverlay



function ttf_wordwrap($srcLines,$font,$textSize,$width) {
    $dstLines = Array(); // The destination lines array.
    foreach ($srcLines as $currentL) {
        $line = '';
        $words = explode(" ", $currentL); //Split line into words.
        foreach ($words as $word) {
            $dimensions = imagettfbbox($textSize, 0, $font, $line.' '.$word);
            $lineWidth = $dimensions[4] - $dimensions[0]; // get the length of this line, if the word is to be included
            if ($lineWidth > $width && !empty($line) ) { // check if it is too big if the word was added, if so, then move on.
                $dstLines[] = trim($line); //Add the line like it was without spaces.
                $line = '';
            }
            $line .= $word.' ';
        }
        $dstLines[] =  trim($line); //Add the line when the line ends.
    }
    return $dstLines;
} // end of ttf_wordwrap function

function validate_color_wo($string) {
 // protect form input color fields from hackers and check for valid css color code hex
 // only allow simple 6 char hex codes with or without # like this 336699 or #336699

 if ( is_string($string) && preg_match("/^#[a-f0-9]{6}$/i", trim($string))) {
    return true;
 }
 if ( is_string($string) && preg_match("/^[a-f0-9]{6}$/i", trim($string))) {
    return true;
 }

 return false;
} // end function validate_color_wo

function validate_text_align($string) {
 // only allow proper text align codes
  $allowed = array('ll','ul','lr','ur','c','ct','cb');
 if ( in_array($string, $allowed) ) {
    return true;
 }
 return false;
} // end function validate_text_align

// end of file  