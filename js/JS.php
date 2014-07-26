
		
		<!-- Latest compiled and minifiedJQuery -->
		<script src="//cdn.jsdelivr.net/jquery/2.1.1/jquery.min.js"></script>
		<script src="//code.jquery.com/ui/1.11.0/jquery-ui.js"></script>
		
		<!-- Latest compiled and minified JavaScript -->
		<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
        <?php if ($path['call'] === 'Profile' && $_SESSION['status']>=2) { ?>
        <!-- Redactor -->   
		<script src="admin/JS/redactor.min.js"></script>
		<script src="admin/JS/fullscreen.js"></script>
		<script src="admin/JS/fontsize.js"></script>
        <script src="admin/JS/fontfamily.js"></script>
        <script src="admin/JS/fontcolor.js"></script>
        <?php } ?>
		<script>
			$(function() {$( "#tabs" ).tabs();});
			window.fbAsyncInit = function () {FB.init({	appId: '{572212662900804}',	xfbml: true, version: 'v2.0'});};(function(d, s, id) {var js, fjs = d.getElementsByTagName(s)[0]; if (d.getElementById(id)) return; js = d.createElement(s); js.id = id;js.src = "//connect.facebook.net/en_GB/sdk.js#xfbml=1&appId=572212662900804&version=v2.0"; fjs.parentNode.insertBefore(js, fjs); }(document, 'script', 'facebook-jssdk'));
			!function(d,s,id){var js,fjs=d.getElementsByTagName(s)[0],p=/^http:/.test(d.location)?'http':'https';if(!d.getElementById(id)){js=d.createElement(s);js.id=id;js.src=p+'://platform.twitter.com/widgets.js';fjs.parentNode.insertBefore(js,fjs);}}(document, 'script', 'twitter-wjs');
			function encode(str) {
				return encodeURIComponent(str).
				// Note that although RFC3986 reserves "!", RFC5987 does not,
				// so we do not need to escape it
				replace(/\'/g, '\'').replace(/\(/g, '%28').replace(/\)/g, '%29').replace(/\*/g, '%2A').
				// The following are not required for percent-encoding per RFC5987, 
				//  so we can allow for a little better readability over the wire: |`^
				replace(/%(?:7C|60|5E)/g, unescape);
			}
			function updatePlaying() {$.ajax({url:"setup/nowPlaying.php", type: 'GET', success: function(data){$('#nowPlaying').html(data);}});}
			function active() {$.ajax({url:"chatbox/active.php", type: 'GET', success: function(data){$('.loggedInUsers p').html(data);}});}
			function guests() {$.ajax({url:"chatbox/guests.php", type: 'GET', success: function(data){$('.onlineGuests p').html(data);}});}
			function submitChat() {if (form1.uName.value === '' || form1.msg.value === '') {alert('ALL Fields ARE MANDATORY!'); return;}
			form1.uName.style.border = 'none'; $('#imageLoad').show(); var uName = form1.uName.value; var uNameEscaped = encode(uName); var msg = form1.msg.value; var msgEscaped = encode(msg);$('.you p').html(form1.uName.value);$.ajax({ url: "chatbox/insert.php?uName=" + uNameEscaped + "&msg=" + msgEscaped, success: function (data) { $('#chatlogs').html(data); $('#imageLoad').hide(); $('#message').val('');}});$.ajax({ url: "chatbox/chatJSON.php", type: "GET" });var elem = document.getElementById('chatlogs'); elem.scrollTop = elem.scrollHeight;}
			function updateUsers() {$.ajax({ url: "chatbox/updateUser.php", type: "GET" });}
			function insertUser(){var uName = form1.uName.value;uNameEscaped = encode(uName);$.ajax({ url: "chatbox/insertUser.php?uName=" + uNameEscaped, type: "GET" });}
		$('#console-debug').hide();	
		$(document).ready(function (e) {
				<?php if ($path['call'] === 'Profile') { ?>$(".redactor").redactor({
					convertDivs: false,
					formattingTags: ["div", "p", "blockquote", "pre", "h1", "h2", "h3", "h4", "h5", "h6"],
					imageGetJson: "json/data.json",
					imageUpload: "setup/image_upload.php",
					fileUpload: "setup/file_upload.php",
					minHeight: 300,
					autoresize: false,
					cleanFontTag: false,
					focus: true,
					plugins: ['fontsize', 'fontfamily', 'fontcolor', 'fullscreen']
				});
				<?php } ?>
				<?php if (isset($_SESSION['username'])) {?>form1.uName.readOnly=true;<?php }?>
				function wo_map_console(url) {window.open(url,"wo_map_console","height=650,width=800,toolbar=no,statusbar=no,scrollbars=yes").focus();}
				setInterval(function(){updateUsers();}, 179985);$('a').click(function(){ /*Run for all links*/ $('body').data('linkClicked', true); /*Set global variable*/ });
				$(window).unload(function(){  /*jQuery version of window.onunload*/ if(!$('body').data('linkClicked')){/*Check global variable*/$.ajax({ url: 'chatbox/unload.php', async: false /*this locks the browser, but it may be needed to make sure the ajax call runs before the tab is closed*/ }); }});
				$('#accordion').accordion({ collapsible: true, heightStyle: "fill" });
				var audio = $('#audioPlayer'); $('#reload').on("click", function (e) {audio.attr("src", "http://96.31.83.94:8061/;");audio[0].pause();audio[0].load(); /*suspends and restores all audio element*/audio[0].play();});
				setInterval(function () {updatePlaying();}, 900000);setInterval(function () {guests();}, 10000);setInterval(function () {active();}, 10000);
				$('#btn-debug').on("click", function () { $('#console-debug').toggle(); });$(function () {$.ajaxSetup({cache: false});});
				if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) {/*MOBILE Device to Console*/device = "mobile";console.log('You ARE using a mobile device!');}else{/* DESKTOP*/device = "desktop";console.log('You ARE NOT using a mobile device!');}
			});
			/*//home page scaling*/var viewportwidth;var viewportheight;/*//Standards compliant browsers (mozilla/netscape/opera/IE7)*/if (typeof window.innerWidth !== 'undefined') { viewportwidth = window.innerWidth, viewportheight = window.innerHeight; }/*// IE6*/else if (typeof document.documentElement !== 'undefined' && typeof document.documentElement.clientWidth !== 'undefined' && document.documentElement.clientWidth !== 0) { viewportwidth = document.documentElement.clientWidth, viewportheight = document.documentElement.clientHeight; }/*//Older IE*/else { viewportwidth = document.getElementsByTagName('body')[0].clientWidth, viewportheight = document.getElementsByTagName('body')[0].clientHeight; }if (viewportwidth <= viewportheight) {$('#formRow').before($('#chatInner'));} else {$('#formRow').after($('#chatInner'));}
		</script>
<?php $stream = 'http://96.31.83.94:8061/;';?>		
