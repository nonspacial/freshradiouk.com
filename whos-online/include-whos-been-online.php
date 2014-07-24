<?php
/*
This file gets included in the body of your whos-been-online.php page

Who's Online PHP Script by Mike Challis
Free PHP Scripts - www.642weather.com/weather/scripts.php
Download         - www.642weather.com/weather/scripts/whos-online.zip
Live Example     - www.642weather.com/weather/whos-online.php
Contact Mike     - www.642weather.com/weather/contact_us.php

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

// no settings below this line --------------------------------------

  $show_arr = array();
  $show_arr[] = array('id' => '',       'text' => TEXT_NONE);
  $show_arr[] = array('id' => 'all',    'text' => TEXT_ALL);
  $show_arr[] = array('id' => 'bots',   'text' => TEXT_BOTS);
  $show_arr[] = array('id' => 'guests', 'text' => TEXT_GUESTS);

  $show = '';
  if ( isset($_GET['show']) && validate_show($_GET['show'])) {
    $show = $_GET['show'];
  }

  $sort_by_arr = array();
  $sort_by_arr[] = array('id' => 'who',      'text' => TABLE_HEADING_WHO );
  $sort_by_arr[] = array('id' => 'visits',   'text' => TABLE_HEADING_VISITS );
  $sort_by_arr[] = array('id' => 'time',     'text' => TABLE_HEADING_LAST_VISIT );
  $sort_by_arr[] = array('id' => 'ip',       'text' => TABLE_HEADING_IP_ADDRESS );
  $sort_by_arr[] = array('id' => 'location', 'text' => TABLE_HEADING_LOCATION);
  $sort_by_arr[] = array('id' => 'url',      'text' => TABLE_HEADING_LAST_URL );

  $sort_by_ar = array();
  $sort_by_ar['who'] = 'name';
  $sort_by_ar['visits'] = 'num_visits';
  $sort_by_ar['time'] = 'time_last_click';
  $sort_by_ar['ip'] = 'ip_address';
  $sort_by_ar['location'] = 'country_name, city_name';
  $sort_by_ar['url'] = 'last_page_url';

  $sort_by = 'time';
  if ( isset($_GET['sort_by']) && validate_sort_by($_GET['sort_by'])) {
    $sort_by = $_GET['sort_by'];
  }

  $order_arr = array();
  $order_arr[] = array('id' => 'desc', 'text' => TEXT_DESCENDING);
  $order_arr[] = array('id' => 'asc',  'text' => TEXT_ASCENDING);

  $order_ar = array();
  $order_ar['desc'] = 'DESC';
  $order_ar['asc'] = 'ASC';

  $order = 'desc';
  if ( isset($_GET['order']) && validate_order($_GET['order'])) {
    $order = $_GET['order'];
  }

  if ($order == 'asc' && $sort_by == 'location') {
     $order_ar['asc'] = '';
     $sort_by_ar['location'] = 'country_name ASC, city_name ASC';
  }
  if ($order == 'desc' && $sort_by == 'location') {
     $order_ar['desc'] = '';
     $sort_by_ar['location'] = 'country_name DESC, city_name DESC';
  }

  $bots = '';
  if ( isset($_GET['bots']) && $_GET['bots'] == 'show') {
    $bots = 'show';
  }

if ( $C['dbpass'] == '' || $C['dbuser'] == '' || $C['dbname'] == '' ) {
     echo '<p>Error: You need to set the settings for
     dbname, dbuser, and dbpass for the whos online script to function.</p>';
     exit;
}

// Connect to mysql database
$wo_dbh = mysql_connect($C['dbhost'], $C['dbuser'], $C['dbpass']);
if (!$wo_dbh) die('Could not connect: ' . mysql_error($wo_dbh));
mysql_select_db($C['dbname'],$wo_dbh) or die(mysql_error($wo_dbh));

// show login form if password protection is on and not-logged in
if ($C['enable_password_protect'] && !$passed_login ) {
   show_login_form();
}

// show logout link if password protection is on and logged in
if ($C['enable_password_protect'] && $passed_login ) {
   show_logout_link();
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
  $result = mysql_query($query,$wo_dbh) or die("Invalid query: " . mysql_error($wo_dbh).__LINE__.__FILE__);
  $numrows = mysql_fetch_array($result);
  $numrows = $numrows['numrows'];

  $query = "SELECT time_last_click FROM " . TABLE_WHOS_ONLINE . " ORDER BY time_last_click ASC LIMIT 1";
  $result = mysql_query($query,$wo_dbh) or die("Invalid query: " . mysql_error($wo_dbh).__LINE__.__FILE__);
  $since = mysql_fetch_array($result);
  $since = $since['time_last_click'];

    // http://www.tonymarston.net/php-mysql/pagination.html
  if (isset($_GET['pageno']) && is_numeric($_GET['pageno'])) {
     $pageno = $_GET['pageno'];
  } else {
     $pageno = 1;
  } // if

  $rows_per_page = 50;
  $lastpage      = ceil($numrows/$rows_per_page);
  $pageno = (int)$pageno;
  if ($pageno > $lastpage) {
      $pageno = $lastpage;
  }
  if ($pageno < 1) {
     $pageno = 1;
  }
  $limit = 'LIMIT ' .($pageno - 1) * $rows_per_page .',' .$rows_per_page;
  $getstring = '&amp;show='.$show.'&amp;order='.$order.'&amp;sort_by='.$sort_by;
  if ($bots != '') {
    $getstring .= '&amp;bots='.$bots;
  }


// Time to remove old entries
$xx_mins_ago = (time() - $C['track_time']);

echo '<table border="0" width="99%">
 <tr><td>';

echo '
  <form name="update" action="'.$C['filename_whos_been_online'].'" method="get">';
  if ($C['allow_profile_display']) echo TEXT_PROFILE_DISPLAY . ': ' . draw_pull_down_menu('show', $show_arr, $show, 'onchange="this.form.submit();"') . ' ';
  echo 'Sort:' . draw_pull_down_menu('sort_by', $sort_by_arr, $sort_by, 'onchange="this.form.submit();"').' ';
  echo  draw_pull_down_menu('order', $order_arr, $order, 'onchange="this.form.submit();"') . ' ';
  echo TEXT_SHOW_BOTS . ': <input type="checkbox" name="bots" value="show" onclick="this.form.submit()"' . ($_GET['bots'] == 'show' ? ' checked="checked"': '') . ' />';
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
     <b><?php echo sprintf(TEXT_NUM_VISITORS_SINCE,(int)$numrows,date($C['date_time_format'],(int)$since)); ?></b>
   </td>
 </tr>
 <tr>
   <td align="left">
     <?php
   if ($pageno == 1) {
     echo ' &laquo;'.TEXT_FIRST.' &lsaquo;'.TEXT_PREV;
   } else {
       echo ' <a href="'.$C['filename_whos_been_online']."?pageno=1$getstring\">&laquo;".TEXT_FIRST."</a> ";
          $prevpage = $pageno-1;
       echo ' <a href="'.$C['filename_whos_been_online']."?pageno=$prevpage$getstring\">&lsaquo;".TEXT_PREV."</a> ";
   } // if
    echo ' ('.sprintf(TEXT_PAGE_OF,$pageno, $lastpage).') ';
   if ($pageno == $lastpage) {
      echo ' '.TEXT_NEXT.'&rsaquo; '.TEXT_LAST.'&raquo; ';
   } else {
     $nextpage = $pageno+1;
     echo ' <a href="'.$C['filename_whos_been_online']."?pageno=$nextpage$getstring\">".TEXT_NEXT."&rsaquo;</a> ";
     echo ' <a href="'.$C['filename_whos_been_online']."?pageno=$lastpage$getstring\">".TEXT_LAST."&raquo;</a> ";
   } // if
   ?>
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
                  <td><?php echo TABLE_HEADING_WHO; ?></td>
                  <td><?php echo TABLE_HEADING_VISITS; ?></td>
                  <td><?php echo TABLE_HEADING_LAST_VISIT; ?></td>
                  <?php if ($C['allow_ip_display']) echo '<td>'. TABLE_HEADING_IP_ADDRESS .'</td> ';
                   if ($C['enable_location_plugin']) echo '<td>'. TABLE_HEADING_LOCATION .'</td> ';

				  if( ($C['allow_last_url_display']) && ( !isset($_GET['nlurl']) ) && ( ( $C['allow_profile_display'] ) && ( !isset($_GET['show']) || $_GET['show'] == '' ) )  ) {  
				    echo '<td>'. TABLE_HEADING_LAST_URL .'</td> '; 
				  }
				  if ($C['allow_referer_display']) echo '<td>'. TABLE_HEADING_REFERER .'</td> '; ?>
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
            ORDER BY ".$sort_by_ar[$sort_by]." ".$order_ar[$order]." $limit";

  $result = mysql_query($query,$wo_dbh) or die("Invalid query: " . mysql_error($wo_dbh).__LINE__.__FILE__);

  while ($whos_online = mysql_fetch_array($result)) {

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

       <!-- Last Visit -->
        <td valign="top">&nbsp;<font color="<?php echo $fg_color; ?>"><?php echo date($C['date_time_format'], $whos_online['time_last_click']); ?></font></td>

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

  $total_sess = mysql_num_rows($result);


?>

                      </table>
                    </td>

                  </tr>
                </table>
              </td>
            </tr>
            <tr>
   <td align="left">
     <?php
   if ($pageno == 1) {
     echo ' &laquo;'.TEXT_FIRST.' &lsaquo;'.TEXT_PREV;
   } else {
       echo ' <a href="'.$C['filename_whos_been_online']."?pageno=1$getstring\">&laquo;".TEXT_FIRST."</a> ";
          $prevpage = $pageno-1;
       echo ' <a href="'.$C['filename_whos_been_online']."?pageno=$prevpage$getstring\">&lsaquo;".TEXT_PREV."</a> ";
   } // if
    echo ' ('.sprintf(TEXT_PAGE_OF,$pageno, $lastpage).') ';
   if ($pageno == $lastpage) {
      echo ' '.TEXT_NEXT.'&rsaquo; '.TEXT_LAST.'&raquo; ';
   } else {
     $nextpage = $pageno+1;
     echo ' <a href="'.$C['filename_whos_been_online']."?pageno=$nextpage$getstring\">".TEXT_NEXT."&rsaquo;</a> ";
     echo ' <a href="'.$C['filename_whos_been_online']."?pageno=$lastpage$getstring\">".TEXT_LAST."&raquo;</a> ";
   } // if
   ?>
   </td>
 </tr>
          </table>

<?php

	// Close the database connection
	mysql_close($wo_dbh);

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

function validate_sort_by($string) {
 // only allow if in array
  $allowed = array('who','visits','time','ip','location','url');
 if ( in_array($string, $allowed) ) {
    return true;
 }
 return false;
} // end function validate_sort_by

 function validate_order($string) {
 // only allow if in array
  $allowed = array('desc','asc');
 if ( in_array($string, $allowed) ) {
    return true;
 }
 return false;
} // end function validate_order

 function validate_show($string) {
 // only allow if in array
  $allowed = array('all','bots','guests');
 if ( in_array($string, $allowed) ) {
    return true;
 }
 return false;
} // end function validate_show

function error_exit($error) {

   echo "$error<br />";
   return;

} // end function error_exit

// end of file