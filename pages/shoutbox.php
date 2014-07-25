<div id="chatInner" class="row" style="clear:both">
                    <div id="pageLoad" style="text-align:center"><h4 style="color:#CDCDCD">The Site is still in the Beta testing stage so please bare with us. New Guest List button added.</h4></div>
                    <div id="imageLoad" style="display:none;"><img src="images/1-0.gif" /></div>
  <div id="online" class="col-md-2 panel panel-default"></div>
        <div id="panelSocial" class="col-md-7 panel panel-default panelMain" style="background:none;padding-top:.5%;border:none;">
          <div class="tabs col-md-12 panel panel-default" id="socialTabs" style="margin-bottom:1%;">
            <ul><li><a href="#chatlogs">Shoutbox</a></li><li><a href="#FBook">Facebook</a></li><li><a href="#Twit">Twitter</a></li></ul>
            <div id="chatlogs" class="panel panel-default panelChat" style="align-content:center;">LOADING CHATLOG PLEASE WAIT... <img src="images/1-0.gif" /></div>
            <div id="FBook" class="panel panel-default panelFBook" style="align-content:center;">
              <div class="col-md-12 scoped">
                <div class="fb-like-box" data-href="https://www.facebook.com/Freshradiouk" data-colorscheme="dark" data-show-faces="true" data-header="true" data-stream="true" data-show-border="false"></div>
                </div>
              </div>
            <div id="Twit" class="panel panel-default panelTwitter" style="align-content:center;">
              <div><a class="twitter-timeline" href="https://twitter.com/freshradiouk" data-widget-id="484743821746380801" width="1200px" lang="EN" data-theme="dark">Tweets by @freshradiouk</a><a href="https://twitter.com/share" class="twitter-share-button" data-url="http://www.freshradiouk.com" data-text="Check out this cool Radio Station! Love Fresh all day!" data-related="freshradiouk" data-hashtags="FreshRadioUk.com">Tweet</a><h4 style="color:#BBBBBB">Please take the time to Follow Us and Tweet our page from here or the Social dropdown.</h4>
                </div>
              </div>
          </div>
        <form name="form1" class="col-md-12">
            <div class="form-group">
                <div class="col-md-2"><label for="nameLabel">Enter Your Name:</label></div>
                <div class="col-md-4"><input type="text" name="uName" class="form-control" value="<?php echo $_SESSION['user']; ?>"></div>
                <a id="guestList" class="btn btn-default" href="Shoutbox">Add me to the Guest List</a><br>
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
                                        <div class="sideDivs you"><h4>You Are:  </h4><br /><p><?php echo $_SESSION['user']; ?></p></div>
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
  <div id="bigGif" class="panel panel-default col-md-2" style="height:280px; background-image:url(images/FreshLogoSquare.gif); background-repeat:no-repeat; background-position:center; background-size:cover;"></div>
<div class="row" id="row3">
  <div class="container" id="facebookOutside">
    <h4 style="color:#BBBBBB">If you like our website let your friends know. We'd like to be theirs too: </h4>
    <div class="fb-like" data-href="http://www.freshradiouk.com" data-width="100" data-layout="button_count" data-action="like" data-show-faces="false" data-share="true"></div>
    <div class="fb-follow" data-href="https://www.facebook.com/FreshRadiouk" data-colorscheme="dark" data-layout="button_count" data-show-faces="true"></div>
    <div class="fb-comments" data-href="http://www.freshradiouk.com" data-numposts="5" data-order-by="reverse_time" data-colorscheme="dark" data-width="100%"></div>
  </div>
</div>
