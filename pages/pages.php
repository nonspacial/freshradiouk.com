        <?php 	if( strstr($_SERVER['HTTP_USER_AGENT'],'Android') ||
				strstr($_SERVER['HTTP_USER_AGENT'],'webOS') ||
				strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||
				strstr($_SERVER['HTTP_USER_AGENT'],'iPod')){
				// Mobile DO Nothing Paste @ bottom	
				$edgeHome='<iframe id="U108_animation" src="edgeanimate_assets/homepage_tablet/Assets/homepage_tablet.html" scrolling="no" class="animationContainer an_invi"></iframe>				
';
				}else{
				#Desktop Paste Here	
				$edgeHome='<iframe id="U108_animation" src="edgeanimate_assets/homepage/Assets/homepage.html" scrolling="no" class="animationContainer an_invi"></iframe>				
';
				}
					 if ($_SESSION['status']>=2) {?>
                        <div class="row"  style="margin-bottom:3px;">
                            <div id="audioPanel" class="container" style="margin-bottom:1px;">
                                <div class="col-md-2 col-md-offset-4">
                                    <audio id="audioPlayer" class="audioPlayer" src="<?php echo $stream; ?>" controls>
                                        Your browser does not support the audio element. Please use the links provided in the side panel or try a different browser. the latest IE, Firefox and Chrome should all work perfectly.
                                    </audio>
                                </div>
                            </div>
                            <div class="container" style=""><div class="col-md-4 col-md-offset-4"><button id="reload" class="btn btn-primary btn-xs">Reload</button></div></div>
                        </div>
					<?php }else{ ?>
                        <div class="row"  style="margin-bottom:3px;">
                            <div id="audioPanel" class="container" style="margin-bottom:1px;">
                                <div class="col-md-2 col-md-offset-4">
                                    <audio id="audioPlayer" class="audioPlayer" src="<?php echo $stream; ?>" controls autoplay>
                                        Your browser does not support the audio element. Please use the links provided in the side panel or try a different browser. the latest IE, Firefox and Chrome should all work perfectly.
                                    </audio>
                                </div>
                            </div>
                            <div class="container" style=""><div class="col-md-4 col-md-offset-4"><button id="reload" class="btn btn-primary btn-xs">Reload</button></div></div>
                        </div>
		           	<?php }
			if ($page['slug']==='home' || $page['slug']==='Schedule') {?>
            <div class="container" style="clear:both;">
              <div id="mainContentBlock" class="row" style="height:100%;" >
						<?php } 
					if ($page['slug'] === 'Shoutbox') {
						include ("shoutbox.php");
					}elseif ($page['slug'] === 'visitor-map') {
						include ("visitors.php");
					}elseif ($page['slug'] === 'Fbook') {
						include ("facebook.php");
					}elseif ($page['slug'] === 'Twitter') {
						include ("twitter.php");
					}elseif ($page['slug'] === 'home') {
						echo $edgeHome;
					}elseif ($path['call'] === 'Profile') {
						include ("profile.php");
					}elseif ($path['call'] === 'Login') {
						include ("login.php");
					}elseif ($path['call'] === 'Register') {
						include ("register.php");
					}elseif ($path['call_parts'][0] === 'Success') {
						include ("register_success.php");
					}elseif ($path['call_parts'][0] === 'Djs') {
						include ("djs.php");
					}else{
						$content = $dbc->query("SELECT * FROM content WHERE slug = '$page[slug]'");
						$content = mysqli_fetch_assoc($content);
						echo $content['body'];?>
				<script type="text/javascript">$('#accordion').accordion({ collapsible: true, heightStyle: "fill" });</script>
					<?php }
           if ($page['slug']==='home' || $page['slug']==='Schedule') {?>
              </div>
           </div>
        <?php }
 		
		 if ($debug === 1) { ?> 
        <div id="debugButton"><button id="btn-debug" class="btn btn-default navbar-btn"><i class="fa fa-bug"></i></button></div>
            <?php	} 
			if( strstr($_SERVER['HTTP_USER_AGENT'],'Android') ||
				strstr($_SERVER['HTTP_USER_AGENT'],'webOS') ||
				strstr($_SERVER['HTTP_USER_AGENT'],'iPhone') ||
				strstr($_SERVER['HTTP_USER_AGENT'],'iPod')){
				// Mobile Paste Audio Here	?> 
		<?php }else{
			#Do NOthing paste @ top 
                      } ?>
<script type="text/javascript">var audio = $('#audioPlayer'); $('#reload').on("click", function (e) {audio.attr("src", "http://96.31.83.94:8061/;");audio[0].pause();audio[0].load(); /*suspends and restores all audio element*/audio[0].play();});</script>