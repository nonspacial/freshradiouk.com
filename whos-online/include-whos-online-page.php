<?php
/*
This file gets included in the body of your whos-online.php page

Who's Online PHP Script by Mike Challis
Free PHP Scripts - www.642weather.com/weather/scripts.php
Download         - www.642weather.com/weather/scripts/whos-online.zip
Live Example     - www.642weather.com/weather/whos-online.php
Contact Mike     - www.642weather.com/weather/contact_us.php

Version 3.02 - 29-Apr-2014 see changelog.txt for changes

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

// settings are now located in include-whos-online-settings.php

// no settings below this line --------------------------------------

// Automatic refresh times in seconds and display names
//   Time and Display Text order must match between the arrays
//   "None" is handled separately in the code
  $refresh_time = array(     30,    60,     120,     300,    600 );
  $refresh_display = array( '0:30', '1:00', '2:00', '5:00', '10:00' );
  $refresh_values = array();
  $refresh_values[] = array('id' => 'none', 'text' => TEXT_NONE);
  $refresh_values[] = array('id' => '30', 'text' => '0:30');
  $refresh_values[] = array('id' => '60', 'text' => '1:00');
  $refresh_values[] = array('id' => '120', 'text' => '2:00');
  $refresh_values[] = array('id' => '300', 'text' => '5:00');
  $refresh_values[] = array('id' => '600', 'text' => '10:00');

  $show_type = array();
  $show_type[] = array('id' => '', 'text' => TEXT_NONE);
  $show_type[] = array('id' => 'all', 'text' => TEXT_ALL);
  $show_type[] = array('id' => 'bots', 'text' => TEXT_BOTS);
  $show_type[] = array('id' => 'guests', 'text' => TEXT_GUESTS);


if ( $C['dbpass'] == '' || $C['dbuser'] == '' || $C['dbname'] == '' ) {
     echo '<p>Error: You need to set the settings for
     dbname, dbuser, and dbpass for the whos online script to function.</p>';
     exit;
}

// Connect to mysqli database
$wo_dbh = mysqli_connect($C['dbhost'], $C['dbuser'], $C['dbpass']);
if (!$wo_dbh) die('Could not connect: ' . mysqli_error($wo_dbh));
mysqli_select_db($wo_dbh,$C['dbname']) or die(mysqli_error($wo_dbh));

// show login form if password protection is on and not-logged in
if ($C['enable_password_protect'] && !$passed_login ) {
   show_login_form();
}

$geoip_old = 0;
if( $C['enable_location_plugin'] ){
  if ( !isset($C['geolite_path']) ) { // allow optional custom setting of geolite path
      $C['geolite_path'] = $C['files_path'];
  }
  $geoip_file_time = filemtime($C['geolite_path'].'GeoLiteCity.dat');
  //$geoip_file_time = strtotime("-1 month"); // for testing outdated
  // how many calendar days ago?
  $geoip_days_ago = floor((strtotime(date('Y-m-d'). ' 00:00:00') - strtotime(date('Y-m-d', $geoip_file_time). ' 00:00:00')) / (60*60*24));
  // is it older than the first of this month?
  $geoip_begin_month = strtotime( '01-' .date('m') .'-'. date('Y') );
  if ($geoip_begin_month > $geoip_file_time) {
    $geoip_old = check_geoip_date($geoip_file_time);
  }

}

// show logout link if password protection is on and logged in
if ($C['enable_password_protect'] && $passed_login ) {
   show_logout_link();
   if( $C['enable_location_plugin'] && $geoip_old ){
     echo '<p style="color:red">'.TEXT_LAST_UPDATED.' '.date($C['geoip_date_format'], $geoip_file_time). ' ('.$geoip_days_ago.' '.TEXT_DAYS_AGO.') '.TEXT_MIGHT_BE_OUTDATED.',
     <a href="'.$C['files_url'].'wo-update.php">'.TEXT_CLICK_TO_UPDATE.'</a></p>';
   }
}

// if password protection is on and not-logged in ...
// disallow configured options to the not-logged in
// unless $C['password_protect_all'] = 1; , then we are hiding the whole whose-online table
if ( $C['enable_password_protect'] && !$C['password_protect_all'] && !$passed_login )  {
 $C['password_protect_ip_display']       and $C['allow_ip_display']       = 0;
 $C['password_protect_refresh']          and $C['allow_refresh']          = 0;
 $C['password_protect_profile_display']  and $C['allow_profile_display']  = 0;
 $C['password_protect_ip_display']       and $C['allow_ip_display']       = 0;
 $C['password_protect_last_url_display'] and $C['allow_last_url_display'] = 0;
 $C['password_protect_referer_display']  and $C['allow_referer_display']  = 0;
}
 // if password protection is on, $C['password_protect_all'] = 1;, and logged in ...
 // allow all 5 configured options to the logged in
 else if ($C['enable_password_protect'] && $passed_login) {
 $C['allow_refresh'] = 1;
 $C['allow_profile_display'] = 1;
 $C['allow_ip_display'] = 1;
 $C['allow_last_url_display'] = 1;
 $C['allow_referer_display'] = 1;
}

// password protection feature logic
// decide if we are hiding the whole whose-online table or not
if ( ($C['enable_password_protect'] && $C['password_protect_all'] && $passed_login )
|| ( !$C['enable_password_protect'] )
|| ( $C['enable_password_protect'] && !$C['password_protect_all'] )  ) {

  $query = "SELECT count(*) as numrows FROM " . TABLE_WHOS_ONLINE;
  $result = mysqli_query($wo_dbh, $query) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);
  $numrows = mysqli_fetch_array($result);
  
  $query = "SELECT time_last_click FROM " . TABLE_WHOS_ONLINE . " ORDER BY time_last_click ASC LIMIT 1";
  $result = mysqli_query($wo_dbh,$query) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);
  $since = mysqli_fetch_array($result);

// Time to remove old entries
$xx_mins_ago = (time() - absint(($C['track_time'] * 60)));

if ($C['store_days'] > 0) {
       // remove visitor entries that have expired after $C['store_days'], save nickname friends
       $xx_days_ago_time = (time() - ($C['store_days'] * 60*60*24));
       $query = "DELETE from " . TABLE_WHOS_ONLINE . "
                 WHERE (time_last_click < '" . $xx_days_ago_time . "' and nickname = '')
                  OR   (time_last_click < '" . $xx_days_ago_time . "' and nickname IS NULL)";
} else {
       // remove visitor entries that have expired after $C['track_time'], save nickname friends
       $query = "DELETE from " . TABLE_WHOS_ONLINE . "
                 WHERE (time_last_click < '" . $xx_mins_ago . "' and nickname = '')
                  OR   (time_last_click < '" . $xx_mins_ago . "' and nickname IS NULL)";
}

$result = mysqli_query($wo_dbh,$query);


echo '<table border="0" width="99%">
 <tr><td>
  <form name="update" action="'.$C['filename_whos_online'].'" method="get">';
  if ($C['allow_profile_display']) echo TEXT_PROFILE_DISPLAY . ': ' . draw_pull_down_menu('show', $show_type, (isset($_GET['show']))? $_GET['show'] : '', 'onchange="this.form.submit();"') . ' ';
  if ($C['allow_refresh']) echo TEXT_REFRESH_RATE . ': ' . draw_pull_down_menu('refresh', $refresh_values, (isset($_GET['refresh']))? $_GET['refresh'] : '', 'onchange="this.form.submit();"') . ' ';
  echo TEXT_SHOW_BOTS . ': <input type="checkbox" name="bots" value="1" onclick="this.form.submit()"' . (isset($_GET['bots']) ? ' checked="checked"': '') . ' />';
  echo '
  </form>
  </td>
';
?>

<td>
 <table border="0" cellspacing="2" cellpadding="2" align="right">
 <tr>
  <td><?php echo '<img src="'.$C['files_url'] . 'images/' .$C['image_active_guest'].'" border="0" alt="'.TEXT_ACTIVE_GUEST.'" title="'.TEXT_ACTIVE_GUEST.'" /> ' . TEXT_ACTIVE_GUEST; ?>
  </td>
  <td><?php echo '<img src="'.$C['files_url'] . 'images/' .$C['image_inactive_guest'].'" border="0" alt="'.TEXT_INACTIVE_GUEST.'" title="'.TEXT_INACTIVE_GUEST.'" /> ' . TEXT_INACTIVE_GUEST; ?>
  </td>
 </tr>
  <tr>
   <td><?php echo '<img src="'.$C['files_url'] . 'images/' .$C['image_active_bot'].'" border="0" alt="'.TEXT_ACTIVE_BOT.'" title="'.TEXT_ACTIVE_BOT.'" /> ' . TEXT_ACTIVE_BOT; ?>
   </td>
   <td><?php echo '<img src="'.$C['files_url'] . 'images/' .$C['image_inactive_bot'].'" border="0" alt="'.TEXT_INACTIVE_BOT.'" title="'.TEXT_INACTIVE_BOT.'" /> ' . TEXT_INACTIVE_BOT; ?>
  </td>
 </tr>
</table>
</td>
</tr>
</table>


 <table border="0" cellspacing="2" cellpadding="2" width="99%">
 <tr>
   <td align="center">
     <b><?php echo sprintf(TEXT_NUM_VISITORS_SINCE,(int)$numrows['numrows'],date($C['date_time_format'],(int)$since['time_last_click'])); ?></b>
   </td>
 </tr>
 <tr>
   <td align="center">
     <b><?php echo TEXT_LAST_REFRESH.' '.  date( $C['time_format'] ); ?></b>
   </td>
 </tr>
 <tr>
     <td valign="top">
         <table border="0" width="99%" cellspacing="0" cellpadding="0">
         <tr>
            <td valign="top">
               <table border="0" width="99%" cellspacing="0" cellpadding="3">
               <tr class="table-top">
                  <td></td>
                  <td><?php echo TABLE_HEADING_ONLINE; ?></td>
                  <td><?php echo TABLE_HEADING_WHO; ?></td>
                  <td><?php echo TABLE_HEADING_VISITS; ?></td>
                  <?php if ($C['allow_ip_display']) echo '<td>'. TABLE_HEADING_IP_ADDRESS .'</td> '; ?>
                  <?php if ($C['enable_location_plugin']) echo '<td>'. TABLE_HEADING_LOCATION .'</td> '; ?>
                  <td><?php echo TABLE_HEADING_ENTRY; ?></td>
                  <td><?php echo TABLE_HEADING_LAST_CLICK; ?></td>
                  <?php 
				  if( ($C['allow_last_url_display']) && ( !isset($_GET['nlurl']) ) && ( ( $C['allow_profile_display'] ) && ( !isset($_GET['show']) || $_GET['show'] == '' ) )  ) {  
				    echo '<td>'. TABLE_HEADING_LAST_URL .'</td> '; 
				  }
				  ?>
                  <?php if ($C['allow_referer_display']) echo '<td>'. TABLE_HEADING_REFERER .'</td> '; ?>
               </tr>

<?php
  // Order by is on Last Click.

  $total_bots = 0;
  $total_admin = 0;
  $total_guests = 0;
  $total_users = 0; 
  $total_dupes = 0;
  $ip_addrs_active = array();
  $ip_addrs = array();
  $even_odd = 0;

  $query = "SELECT
        session_id,
        ip_address,
        name,
        nickname,
        country_name,
        country_code,
        city_name,
        state_name,
        state_code,
        latitude,
        longitude,
        last_page_url,
        http_referer,
        user_agent,
        hostname,
        time_entry,
        time_last_click,
        num_visits
            FROM " . TABLE_WHOS_ONLINE . "
            WHERE time_last_click > '" . $xx_mins_ago . "'
            ORDER BY time_last_click DESC";

  $result = mysqli_query($wo_dbh,$query) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);

  while ($whos_online = mysqli_fetch_array($result)) {

    // skip empty row just incase
    if ($whos_online['name'] == '' || $whos_online['session_id'] == '' || $whos_online['ip_address'] == '') continue;

    // skip nickname friends who are not online
    // (not needed anymore because of new $C['store_days'] feature)
    //if ($whos_online['time_last_click'] < $xx_mins_ago && $whos_online['nickname'] != '') continue;

    $time_online = ($whos_online['time_last_click'] - $whos_online['time_entry']);

    //Check for duplicates
    if (in_array($whos_online['ip_address'],$ip_addrs)) {$total_dupes++;};
    $ip_addrs[] = $whos_online['ip_address'];

    // Display Status
    //   Check who it is and set values
    $is_bot = $is_admin = $is_guest = false;

    if ($whos_online['name'] != 'Guest') {
      $total_bots++;
      $fg_color = $C['color_bot'];
      $is_bot = true;

      // Admin detection
    } else if ($whos_online['ip_address'] == $C['visitor_ip']) {
      $total_admin++;
      $fg_color = $C['color_admin'];
      $is_admin = true;
      $C['hostname'] = $whos_online['hostname'];

    // Guest detection (may include Bots not detected by spiders.txt)
    } else {
      $fg_color = $C['color_guest'];
      $is_guest = true;
      $total_guests++;
    }

  if (!($is_bot && !isset($_GET['bots']))) {

    // alternate row colors
    $row_class = '';
    $even_class = 'class="column-light"';
    $odd_class = 'class="column-dark"';
    if ($even_odd % 2){
        $row_class = $odd_class;
    } else {
        $row_class = $even_class;
    }
    $even_odd++;

    echo '<tr '.$row_class.'>' . "\n";

?>
        <!-- Status Light -->
        <td align="left" valign="top"><?php echo check_status($whos_online); ?></td>

        <!-- Time Online -->
        <td valign="top"><font color="<?php echo $fg_color; ?>"><?php echo time_online ($time_online); ?></font>&nbsp;</td>

        <!-- Name -->
        <?php
        echo '
        <td valign="top"><font color="' . $fg_color .'">';

        if ( $is_guest ){
                 echo TEXT_GUEST . '&nbsp;';
        } else if ( $is_admin ) {
                 echo TEXT_YOU . '&nbsp;';
        // Check for Bot
        } else if ( $is_bot ) {
            // Tokenize UserAgent and try to find Bots name
            $tok = strtok($whos_online['name']," ();/");
            while ($tok !== false) {
              if ( strlen(strtolower($tok)) > 3 )
                if ( !strstr(strtolower($tok), "mozilla") &&
                     !strstr(strtolower($tok), "compatible") &&
                     !strstr(strtolower($tok), "msie") &&
                     !strstr(strtolower($tok), "windows")
                     ) {
                     echo "$tok";
                     break;
                }
                $tok = strtok(" ();/");
              }
              } else {
                      echo TEXT_ERROR;
              }
              echo '</font></td>' . "\n";

              if ($C['allow_ip_display']) {
              ?>

       <!-- Visits -->
        <td valign="top"><font color="<?php echo $fg_color; ?>"><?php echo sanitize_output($whos_online['num_visits']); ?></font>&nbsp;</td>


        <!-- IP Address -->
        <td valign="top">
                <?php
                if ( $whos_online['ip_address'] == 'unknown' ) {
                      echo '<font color="' . $fg_color . '">' . $whos_online['ip_address'] . '</font>' . "\n";
                } else {
                         $this_nick = '';
                         if ($whos_online['nickname'] != '') {
                               $this_nick = ' (' . sanitize_output($whos_online['nickname']) . ' - '.sanitize_output($whos_online['num_visits']).' '.TEXT_VISITS.')';
                         }
                         if ($C['enable_host_lookups']) {
                                 $this_host = ($whos_online['hostname'] != '') ? host_to_domain($whos_online['hostname']) : 'n/a';
                         } else {
                                 $this_host = TEXT_HOST_NOT_ENABLED;
                         }

                     if ($C['whois_url_popup']) {
                        echo '<a href="'. $C['whois_url'] . $whos_online['ip_address'] . '" onclick="who_is(this.href); return false;" title="'.sanitize_output($this_host).'">'. $whos_online['ip_address'] . "$this_nick</a>" . "\n";
                     } else {
                        echo '<a href="'. $C['whois_url'] . $whos_online['ip_address'] . '" title="'.sanitize_output($this_host).'" target="_blank">'. $whos_online['ip_address'] . "$this_nick</a>" . "\n";
                     }
                }
                echo '</td>';

              } // end if ($C['allow_ip_display']

         if ( $C['enable_location_plugin'] ) {
        ?>
        <!-- Country Flag -->
        <td valign="top">

        <?php
           if ( $whos_online['country_code'] != '' ) {
              $whos_online['country_code'] = strtolower($whos_online['country_code']);
             if ($whos_online['country_code'] == '--'){ // unknown
                echo '<img src="'.$C['files_url'].'images-wo-country-flags/unknown.png" alt="'.TEXT_UNKNOWN.'" title="'.TEXT_UNKNOWN.'" />';
             } else {
                echo '<img src="'.$C['files_url'].'images-wo-country-flags/' . $whos_online['country_code']  . '.png" alt="'.$whos_online['country_name'].'" title="'.$whos_online['country_name'].'" />';
             }
           }

         if ( $C['enable_state_display'] ) {
                 $newguy = false;
                if (isset($_GET['refresh']) && is_numeric($_GET['refresh']) && $whos_online['time_entry'] > (time() - $_GET['refresh'])) {
                   $newguy = true; // Holds the italacized "new lookup" indication for 1 refresh cycle 
                 }
             if ($whos_online['city_name'] != '') {
                if ($whos_online['country_code'] == 'us') {
                     $whos_online['print'] = sanitize_output($whos_online['city_name']);
                     if ($whos_online['state_code'] != '')
                             $whos_online['print'] = sanitize_output($whos_online['city_name']) . ', ' . sanitize_output(strtoupper($whos_online['state_code']));
                }
                else {      // all non us countries
                     $whos_online['print'] = sanitize_output($whos_online['city_name']) . ', ' . sanitize_output(strtoupper($whos_online['country_code']));
                }
             }
             else {
                  $whos_online['print'] = '~ ' . $whos_online['country_name'];
             }
             if ($newguy)
                echo '<em>';
             echo '<font color="' . $fg_color . '">  ' . sanitize_output($whos_online['print']) . '</font>';
             if ($newguy)
                echo '</em>';
         }

	   echo '</td>';
         }
        ?>

        <!-- Time Entry -->
        <td valign="top"><font color="<?php echo $fg_color; ?>"><?php echo date($C['time_format_hms'], $whos_online['time_entry']); ?></font></td>

        <!-- Last Click -->
        <td valign="top"><font color="<?php echo $fg_color; ?>"><?php echo date($C['time_format_hms'], $whos_online['time_last_click']); ?></font></td>

              <?php
              if( ($C['allow_last_url_display']) && ( !isset($_GET['nlurl']) ) && ( ( $C['allow_profile_display'] ) && ( !isset($_GET['show']) || $_GET['show'] == '' ) )  ) {  
              ?>
        <!-- Last URL -->
        <td valign="top">
                <?php
                $display_link = $whos_online['last_page_url'];
                // escape any special characters to conform to HTML DTD
                $temp_url_link = $display_link;
                if (isset($C['site_url'])) {
                   $uri = parse_url($C['site_url']);
                   isset($uri['path']) and $display_link = str_replace($uri['path'],'',$display_link);
                }
                $display_link = htmlspecialchars($display_link);
                $display_link = wordwrap($display_link, $C['lasturl_wordwrap_chars'] , "<br />", true);
                echo '<a href="' . htmlspecialchars($temp_url_link) . '" target="_blank">' . $display_link . '</a></td>' . "\n";

              } // end if ($C['allow_last_url_display']


              if ($C['allow_referer_display']) {
              ?>
        <!-- Referer -->
        <td valign="top"><font color="<?php echo $fg_color; ?>">
                <?php
                if ($whos_online['http_referer'] == '') {
                    echo TEXT_NO;
                }else{
                   echo '<a href="' . htmlspecialchars($whos_online['http_referer']) . '" target="_blank">'.TEXT_YES.'</a>';
                }
                echo '</font></td>' . "\n";

              } // end if ($C['allow_referer_display']

              echo '</tr>' . "\n";
               if( ($C['allow_last_url_display']) && ( ( isset($_GET['nlurl']) ) || ( ( $C['allow_profile_display'] ) && ( isset($_GET['show']) && $_GET['show'] != '' ) ))  ) {
                   echo '<tr '.$row_class.'>' . "\n";
                   $display_link = $whos_online['last_page_url'];
                   if (isset($C['site_url'])) {
                      $uri = parse_url($C['site_url']);
                      isset($uri['path']) and $display_link = str_replace($uri['path'],'',$display_link);
                   }
              ?>

              <td style="text-align:left" colspan="8"><?php echo TABLE_HEADING_LAST_URL.' <a href="' . htmlspecialchars($whos_online['last_page_url']) . '" target="_blank">' . htmlspecialchars($display_link) . '</a>';  ?></td>
                    </tr>
              <?php
                }

              if ($C['allow_profile_display']) {
                 if ( (isset($_GET['show']) && $_GET['show'] == 'all') || (( isset($_GET['show']) && $_GET['show'] == 'bots') && $is_bot) || (( isset($_GET['show']) && $_GET['show'] == 'guests') && ( $is_guest || $is_admin || $is_user)) ) {

                    echo '<tr '.$row_class.'>' . "\n";
              ?>
                      <td style="text-align:left" colspan="8"><?php display_details(); ?></td>
                    </tr>
              <?php
                }
              } // end if ($C['allow_profile_display']
        } // closes if (!($is_bot
   } // closes while ($whos_online

  $total_sess = mysqli_num_rows($result);


?>
                        <tr>
                          <td colspan="9"><br />
                            <table border="0" cellpadding="0" cellspacing="3" width="600">
                              <tr>
                              <td align="right"><?php print "$total_sess" ?></td>
                              <td align="left"><?php echo TEXT_NUMBER_OF_USERS;?></td>
                                </tr>
                                <?php
                                if ($total_dupes > 0) {
                                ?>
                                <tr>
                                    <td align="right"><?php print "$total_dupes" ?></td>
                                    <td align="left""><?php echo TEXT_DUPLICATE_IP; ?></td>
                                </tr>
                                <?php
                                }
                                ?>
                                <tr>
                                    <td align="right"><?php print "$total_guests" ?></td>
                                    <td><?php echo TEXT_GUESTS; if(count($ip_addrs_active) > 0) echo ', <font color="' . $C['color_guest'] . '">' . count($ip_addrs_active) . TEXT_ARE_ACTIVE . '</font>'; ?></td>
                                </tr>
                                <tr>
                                    <td align="right"><?php print "$total_bots" ?></td>
                                    <td><?php echo TEXT_BOTS; ?></td>
                                </tr>
                                <tr>
                                <td align="right"><?php print "$total_admin" ?></td>
                                <td><?php echo TEXT_YOU; ?></td>
                              </tr>
                            </table>
                            <br />
                            <?php
                            if ($C['allow_ip_display']) {
                              echo TEXT_YOUR_IP_ADDRESS . ': '.sanitize_output($C['visitor_ip']);
                            }
                            if ($C['enable_host_lookups']) {
                              $this_host = ($C['hostname'] != '') ? host_to_domain($C['hostname']) : 'n/a';
                              // Display Hostname
                              echo '<br />
                              '.TEXT_HOST.': (' . sanitize_output($this_host) . ') '. sanitize_output($C['hostname']);
                            }

                            //------------------------ geoip lookup -------------------------
                            if ( $C['enable_location_plugin'] ) {
                               echo '<p>'.TEXT_MAXMIND_CREDIT.'<br />';
                               if( $geoip_old ){
                                 echo '<span style="color:red">'.TEXT_LAST_UPDATED.' '.date($C['geoip_date_format'], $geoip_file_time). ' ('.$geoip_days_ago.' '.TEXT_DAYS_AGO.') '.TEXT_MIGHT_BE_OUTDATED.'.</span>';
                               } else {
                                 echo TEXT_LAST_UPDATED.' '.date($C['geoip_date_format'], $geoip_file_time). ' ('.$geoip_days_ago.' '.TEXT_DAYS_AGO.').';
                               }
                               echo '</p>';
                            }
                            //------------------------ geoip lookup -------------------------
                            ?>
                          </td>
                        </tr>
                      </table>
                    </td>

                  </tr>
                </table>
              </td>
            </tr>
          </table>

<?php

	// Close the database connection
	mysqli_close($wo_dbh);

} // end not logged on (password protection feature)

echo '<!-- '.$C['version']." -->\n";
echo "<!-- http://www.642weather.com/weather/scripts.php -->\n\n";

// Determines status of visitor and displays appropriate icon.
  function check_status($whos_online) {
    global $ip_addrs_active, $C;

    // Determine if visitor active/inactive
    $xx_mins_ago_long = (time() - ($C['active_time'] * 60));

    if ($whos_online['name'] != 'Guest') {   // bot
      // inactive bot
      if ($whos_online['time_last_click'] < $xx_mins_ago_long) {
        return '<img src="'.$C['files_url'] . 'images/' .$C['image_inactive_bot'].'" border="0" alt="'.TEXT_INACTIVE_BOT.'" title="'.TEXT_INACTIVE_BOT.'" />';
        // active  bot
      } else {
        return '<img src="'.$C['files_url'] . 'images/' .$C['image_active_bot'].'" border="0" alt="'.TEXT_ACTIVE_BOT.'" title="'.TEXT_ACTIVE_BOT.'" />';
      }

    }else{  // guest
      // inactive guest
      if ($whos_online['time_last_click'] < $xx_mins_ago_long) {
        return '<img src="'.$C['files_url'] . 'images/' .$C['image_inactive_guest'].'" border="0" alt="'.TEXT_INACTIVE_GUEST.'" title="'.TEXT_INACTIVE_GUEST.'" />';
      // active guest
      } else {
            // next 3 lines count active guests without duplicates
            if (!in_array($whos_online['ip_address'],$ip_addrs_active)) {
             $whos_online['ip_address'] != $C['visitor_ip'] and $ip_addrs_active[] = $whos_online['ip_address'];
            }
        return '<img src="'.$C['files_url'] . 'images/' .$C['image_active_guest'].'" border="0" alt="'.TEXT_ACTIVE_GUEST.'" title="'.TEXT_ACTIVE_GUEST.'" />';
      }
    }
  } // end function check_status


  // Display the details about a visitor
  function display_details() {
    global $whos_online, $C;

    // Display User Agent
    echo TEXT_USER_AGENT . ': ' .  wordwrap(sanitize_output($whos_online['user_agent']), $C['useragent_wordwrap_chars'] , "<br />", true);
    echo '<br />';

    if ($C['enable_host_lookups']) {
      $this_host = ($whos_online['hostname'] != '') ? host_to_domain($whos_online['hostname']) : 'n/a';
      // Display Hostname
      echo TEXT_HOST . ': (' . sanitize_output($this_host) . ') '. sanitize_output($whos_online['hostname']);
      echo '<br />';
    }

    // Display Referer if available
    if($whos_online['http_referer'] != '' ) {
      echo TABLE_HEADING_REFERER . ': <a href="' . htmlspecialchars($whos_online['http_referer']) . '" target="_blank">' . wordwrap(htmlspecialchars($whos_online['http_referer']), $C['referer_wordwrap_chars'], '<br />', true) . '</a>';
      echo '<br />';
    }
    echo '<br clear="all" />';

  } // end function display_details



// Output a form pull down menu
  function draw_pull_down_menu($name, $values, $default = '', $parameters = '', $required = false) {
    global $_GET, $_POST;

    $field = '<select name="' . wo_output_string($name) . '"';

    if (not_null($parameters)) $field .= ' ' . $parameters;

    $field .= '>'."\n";

    if (empty($default) && ( (isset($_GET[$name]) && is_string($_GET[$name])) || (isset($_POST[$name]) && is_string($_POST[$name])) ) ) {
      if (isset($_GET[$name]) && is_string($_GET[$name])) {
        $default = stripslashes($_GET[$name]);
      } elseif (isset($_POST[$name]) && is_string($_POST[$name])) {
        $default = stripslashes($_POST[$name]);
      }
    }

    for ($i=0, $n=sizeof($values); $i<$n; $i++) {
      $field .= '<option value="' . wo_output_string($values[$i]['id']) . '"';
      if ($default == $values[$i]['id']) {
        $field .= ' selected="selected"';
      }

      $field .= '>' . wo_output_string($values[$i]['text'], array('"' => '&quot;', '\'' => '&#039;', '<' => '&lt;', '>' => '&gt;')) . '</option>'."\n";
    }
    $field .= '</select>'."\n";

    if ($required == true) $field .= 'Required';

    return $field;
  }

function time_online ($time_online) {
    // takes a time diff in secs and formats to 01:48:08  (hrs:min:secs)
    $hrs = (int) intval($time_online / 3600);
    $time_online = (int) intval($time_online - (3600 * $hrs));
    $mns = (int) intval($time_online / 60);
    $time_online = (int) intval($time_online - (60 * $mns));
    $secs = (int) intval($time_online / 1);
    return sprintf("%02d:%02d:%02d", $hrs, $mns, $secs);
 }

function check_geoip_date($geoip_file_time) {
   global $wo_dbh, $C;

  // checking for a newer maxmind geo database update file
  // Maxmind usually updates their file on the 1st of the month, but sometimes it is the 2nd, or 3rd of the month.
  // Now it only notifies you when there actually is a new file available.

  // check timestamp
  $query = "SELECT time_last_check FROM " . TABLE_GEO_UPDATE;
  $result = mysqli_query($query,$wo_dbh) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);

  // was a timestamp there?
  if (!$num_rows = mysqli_num_rows($result) ) {
     // jump start the timestamp now
     //echo "jump starting the timestamp now...<br />";
     $time_now  = time() - (7 * 60*60);
     $result = mysqli_query("INSERT INTO " . TABLE_GEO_UPDATE . " (`time_last_check`) VALUES ('" .$time_now . "');") or die("Invalid query: " . mysqli_error().__LINE__.__FILE__);
  }
  $result = mysqli_query($query,$wo_dbh) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);
  $time_last_check  = mysqli_fetch_array($result);

  // have I checked this already in the last 6 hours?
  if ($time_last_check['time_last_check'] < time() - (6 * 60*60) ) { // $time_last_check more than 6 hours ago
           // time to check it again, reset the needs_update flag first
           //echo "resetting the needs_update flag...<br />";
           $query = "UPDATE " . TABLE_GEO_UPDATE . "
           SET
           needs_update = '0'";
           $result = mysqli_query($query,$wo_dbh) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);

           // get last updated time of the maxmind geo database remote file
           // echo "checking the maxmind timestamp now...<br />";
           $remote_file_time = curl_last_mod('http://geolite.maxmind.com/download/geoip/database/GeoLiteCity.dat.gz');
  } else {
          // using the cached results
          // check needs_update flag
          $query = "SELECT needs_update FROM " . TABLE_GEO_UPDATE;
          $result = mysqli_query($query,$wo_dbh) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);
          $update_flag  = mysqli_fetch_array($result);
          if ($update_flag['needs_update'] == 1) {
                  //echo "needs update (cached result)...<br />";
                  return 1;
          } else {
                 //echo "does not need update(cached result from less than 6 hours ago)...<br />";
                 return 0;
          }
  }

  // set a new timestamp
  //echo "set a new timestamp (now)...<br />";
  $query = "UPDATE " . TABLE_GEO_UPDATE . "
  SET
  time_last_check = '" . time() . "'";
  $result = mysqli_query($query,$wo_dbh) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);

  // sanity check the remote date
  if ($remote_file_time < (time() - (365*24*60*60)) ) { // $remote_file_time less than 1 year ago
           echo "Warning: The last modified date of the Maxmind GeoLiteCity database ($remote_file_time) is out of expected range<br />";
           return 0;
  }
  if ($remote_file_time > $geoip_file_time ) {
         //echo "needs update...<br />";
         // set needs_update flag
         $query = "UPDATE " . TABLE_GEO_UPDATE . "
         SET
         needs_update = '1'";
         $result = mysqli_query($query,$wo_dbh) or die("Invalid query: " . mysqli_error($wo_dbh).__LINE__.__FILE__);
         return 1;
  }
  //echo "does not need update...<br />";
  return 0;
} // end function check_geoip_date


function curl_last_mod($remote_file) {
    // return unix timestamp (last_modified) from a remote URL file

    if ( !function_exists('curl_init') ) {
       return http_last_mod($remote_file,1);
    }

    $last_modified = $ch = $resultString = $headers = '';
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_USERAGENT, 'Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR 3.5.30729)');
    curl_setopt($ch, CURLOPT_URL, $remote_file);
    curl_setopt($ch, CURLOPT_TIMEOUT, 15); // 5 sec timeout
    curl_setopt($ch, CURLOPT_HEADER, 1);  // make sure we get the header
    curl_setopt($ch, CURLOPT_NOBODY, 1);  // make it a http HEAD request
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1); // write the response to a variable
    curl_setopt($ch, CURLOPT_FILETIME, 1 );

    $i = 1;
    while ($i++ <= 2) {
       if(curl_exec($ch) === false){
               error_exit('curl_last_mod error: could not connect to remote file'); // could not connect
               //   echo 'Curl error: ' . curl_error($ch);
               //   exit;
       }
       $headers = curl_getinfo($ch);
       if ($headers['http_code'] != 200) {
          sleep(3);  // Let's wait 3 seconds to see if its a temporary network issue.
       } else if ($headers['http_code'] == 200) {
          // we got a good response, drop out of loop.
          break;
       }
    }
    $last_modified = $headers['filetime'];
    if ($headers['http_code'] != 200) error_exit('curl_last_mod error: fetching timestamp failed for URL, 404 not found?'); // remote file not found
    curl_close ($ch);

  // sanity check the remote_file date
  // sometimes CURL returns -1 instead of the timestamp on some peoples servers
  // use http to check the date instead.
  if ($last_modified < (time() - (365*24*60*60)) ) { // $remote_file_time less than 1 year ago
       return http_last_mod($remote_file,1);
  }

    return $last_modified;
} // end of curl_last_mod function

function http_last_mod($url,$format=0) {
  $url_info=parse_url($url);
  $port = isset($url_info['port']) ? $url_info['port'] : 80;
  $fp=fsockopen($url_info['host'], $port, $errno, $errstr, 15);
  if($fp) {
    $head = "HEAD ".@$url_info['path']."?".@$url_info['query'];
    $head .= " HTTP/1.0\r\n";
    $head .= "Host: ".@$url_info['host']."\r\n";
    $head .= "User-Agent: Mozilla/5.0 (Windows; U; Windows NT 5.1; en-US; rv:1.9.1) Gecko/20090624 Firefox/3.5 (.NET CLR 3.5.30729)\r\n\r\n";
    fputs($fp, $head);
    while(!feof($fp)) {
      if($header=trim(fgets($fp, 1024))) {
        if($format == 1) {
          $h2 = split(': ',$header);
          // the first element is the http header type, such as HTTP/1.1 200 OK,
          // it doesn't have a separate name, so we have to check for it.
          if($h2[0] == $header) {
            $headers['status'] = $header;
              if (! preg_match('|HTTP/1.* 200 OK|i',$header)) {
                error_exit('http_last_mod error: fetching timestamp failed for URL 404 not found?');
              }
          } else {
            $headers[strtolower($h2[0])] = trim($h2[1]);
          }
        } else {
          $headers[] = $header;
        }
      }
    }
          fclose($fp);
          return strtotime($headers['last-modified']);
  } else {
         error_exit('http_last_mod error: could not connect to remote URL');
  }
} // end of function http_last_mod


function error_exit($error) {

   echo "$error<br />";
   return;

} // end function error_exit

// end of file  