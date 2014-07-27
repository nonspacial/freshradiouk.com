			<div id="chatInner" class="row" style="clear:both">
                    <div id="pageLoad" style="text-align:center"><h4 style="color:#CDCDCD">The Site is still in the Beta testing stage so please bare with us. New Guest List button added.</h4></div>
                            
                    <div id="imageLoad" style="display:none;"><img src="images/1-0.gif" /></div>
                    <div id="online" class="col-md-2 panel panel-default panelMain"><div id="onlineUsers"></div></div>
                    <div class="col-md-7">
                        <div id="chatlogs" class="col-md-12 panel panel-default panelMain" style="margin:0;">LOADING CHATLOG PLEASE WAIT... <img src="images/1-0.gif" /></div>
                            <form name="form1" class="col-md-12">
                                <div class="form-group">
                                    <div class="col-md-3"><label for="nameLabel">Enter Your Name:</label></div>
                                    <div class="col-md-4"><input type="text" name="uName" class="form-control" value="<?php echo $_SESSION['user']; ?>"></div>
                                    <div class="col-md-4"><a id="guestList" class="btn btn-primary" href="Shoutbox">Add me to the Guest List</a></div>
                                </div>
                                <div class="form-group">
                                    <div class="col-md-8"><label for="messageLabel">Your Message:</label></div>
                                    <div class="col-md-12"><textarea type="text" class="form-control" name="msg" id="message" rows="1"></textarea></div><br />
                                    <div id="emoteButtons" class="col-md-12">
                                        <img src="images/emoticons/smiley-02.svg" class="emoticon emoticonButton" alt=":)" />
                                        <img src="images/emoticons/smiley-16.svg" class="emoticon emoticonButton" alt=":(" />
                                        <img src="images/emoticons/smiley-13.svg" class="emoticon emoticonButton" alt=":D" />
                                        <img src="images/emoticons/smiley-04.svg" class="emoticon emoticonButton" alt=";)" />
                                        <img src="images/emoticons/smiley-06.svg" class="emoticon emoticonButton" alt=":o" />
                                        <img src="images/emoticons/smiley-05.svg" class="emoticon emoticonButton" alt=":p" />
                                        <img src="images/emoticons/smiley-07.svg" class="emoticon emoticonButton" alt=":/" />
                                        <img src="images/emoticons/smiley-08.svg" class="emoticon emoticonButton" alt=":[" />
                                        <img src="images/emoticons/smiley-22.svg" class="emoticon emoticonButton" alt="8)" />
                                        <img src="images/emoticons/smiley-15.svg" class="emoticon emoticonButton" alt=":'(" />
                                        <img src="images/emoticons/smiley-10.svg" class="emoticon emoticonButton" alt=":s" />
                                        <img src="images/emoticons/smiley-20.svg" class="emoticon emoticonButton" alt=":x" />
                                        <img src="images/emoticons/smiley-27.svg" class="emoticon emoticonButton" alt=">:>" />
                                        <img src="images/emoticons/smiley-28.svg" class="emoticon emoticonButton" alt="O:-)" />
                                        <img src="images/emoticons/tunewhite.png" class="emoticon emoticonButton" alt="tune" />
                                        <img src="images/emoticons/alien.png" class="emoticon emoticonButton" alt="alien" />
                                        <img src="images/emoticons/handGrenade.png" class="emoticon emoticonButton" alt="grenade" />
                                        <img src="images/emoticons/heart.png" class="emoticon emoticonButton" alt="<3" />
                                        <img src="images/emoticons/onFire.png" class="emoticon emoticonButton" alt="(^^)" />
                                        <img src="images/emoticons/thumbsUp.png" class="emoticon emoticonButton" alt="thumbsUp" />
                                    </div>
                                    <div class="col-md-1"><button type="button" class="btn btn-default" href="#" onClick="submitChat()">Send</button></div> 
                                </div>
                            </form>
                    </div>
                    <div id="sidebar" class="panel panel-default panelMain col-md-2">
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
                                    <div id="alternateStreams" class="sideDivs streamLinks">
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
<script>
	setTimeout (function () { var elem = document.getElementById('chatlogs'); elem.scrollTop = elem.scrollHeight; }, 4000);
	$('#message').focus();
	$('.emoticonButton').on('click', function (e) { var smiley = $(this).attr('alt'); var message = $('#message').val(); $('#message').val(message + ' ' + smiley + '').focus();});
	$('.slide').on("click", function () {
		$('.toSlide').slideToggle(1000);
		$(this).find(".upArrow, .downArrow").toggle();
	});
	setTimeout(function () { $('#chatlogs').load('chatbox/logs.php'); var elem = document.getElementById('chatlogs'); }, 2000);
	setTimeout(function () { $('#onlineUsers').load('chatbox/activeUsers.php'); }, 2000);
	setInterval(function () { $('#chatlogs').load('chatbox/logs.php'); var elem = document.getElementById('chatlogs'); }, 10000);
	setInterval(function () { $('#onlineUsers').load('chatbox/activeUsers.php'); }, 6000);
	$("#message").keydown(function (e) { if (e.keyCode === 13) { if (e.shiftKey) { $(this).val($(this).val() + "\n"); } else { e.preventDefault(); submitChat(); } } });
</script>
