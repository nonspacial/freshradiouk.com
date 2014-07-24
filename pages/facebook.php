            <div id="content" class="container">
                <div id="facebook" class="container col-md-8">
					<div class="container col-md-12">
                        <div class="fb-like-box" data-href="https://www.facebook.com/Freshradiouk" data-colorscheme="dark" data-show-faces="true" data-header="true" data-stream="true" data-show-border="false"></div>
                        <h4 style="color:#BBBBBB">If you like our website let your friends know. We'd like to be theirs too: </h4>
						<div class="fb-like" data-href="http://www.freshradiouk.com" data-width="100" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
                        <div class="fb-follow" data-href="https://www.facebook.com/FreshRadiouk" data-colorscheme="dark" data-layout="button_count" data-show-faces="true"></div>
                        <div class="fb-comments" data-href="http://www.freshradiouk.com" data-numposts="5" data-order-by="reverse_time" data-colorscheme="dark" data-width="100%"></div>
                    </div>
                </div>
                <div id="sidebarFbook" class="panel panel-default panelFbook col-md-4">
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
               