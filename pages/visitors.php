<?php


$visited=$dbc->query("SELECT * FROM visitors");
$visited=mysqli_fetch_assoc($visited);
 
?>

        <div id="content" class="container">
			<div id="visit" class="col-md-8">
				<?php include ("whos-online-maps.php");?>
            </div>
            <div id="sidebarVisit" class="panel panel-default panelMain col-md-4">
                <div id="rowSideBar" class="row">
                    <div id="row1" class="row">
                        <div id="nowPlayingContainer" class="nowPlayingContainer "><?php showtime($dbc, $dateTime); ?></div>
                    </div>
                    <div id="row2" class="row">
                        <div id="sub1" class="row removePaddingRight">
                            <div id="setups" class="col-md-4 removePaddingLeft">
                                <div class="sideDivs you"><h4>You Are:  </h4><p><?php echo $_SESSION['user']; ?></p></div>
                            </div>
                            <div id="setups" class="col-md-4 removePaddingLeft">
                                <div class="sideDivs loggedInUsers"><h4>Online Users: </h4><p><?php echo $online_members; ?></p></div>
                            </div>
                            <div id="setups" class="col-md-4 removePaddingLeft setupsLast">
                                <div class="sideDivs onlineGuests"><h4>Online Guests:  </h4><p><?php echo $online_guest; ?></p></div>
                            </div>
                        </div>
                        <div id="sub2" class="row">
                            <div class="sideDivs streamLinks">
                                <h4 class="title">Alternate Streams</h4>		
                                <!--<div class="stream128 col-md-12">128 Kbps Streaming...<br>
                                <a href="http://sh.fl-us.audio-stream.com/tunein.php/freshrad.asx"><img src="images/wmp.png" /></a> 
                                <a href="http://sh.fl-us.audio-stream.com/tunein.php/freshrad.pls"><img src="images/winamp.png" /></a> 
                                <a href="http://sh.fl-us.audio-stream.com/tunein.php/freshrad.ram"><img src="images/real.png" /></a> 
                                <a href="http://sh.fl-us.audio-stream.com/tunein.php/freshrad.qtl"><img src="images/itunes.png" /></a>
                                </div>-->
                                <div class="stream64 col-md-12">64 Kbps AAC+ Streaming...<br>
                                <a href="http://vs.tx-us.audio-stream.com/tunein/freshrad2.asx"><img src="images/wmp.png" /></a> 
                                <a href="http://vs.tx-us.audio-stream.com/tunein/freshrad2.pls"><img src="images/winamp.png" /></a> 
                                <a href="http://vs.tx-us.audio-stream.com/tunein/freshrad2.ram"><img src="images/real.png" /></a> 
                                <a href="http://vs.tx-us.audio-stream.com/tunein/freshrad2.qtl"><img src="images/itunes.png" /></a>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>