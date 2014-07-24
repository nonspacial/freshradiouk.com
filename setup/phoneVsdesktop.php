

		<script type="text/javascript">	
			//Phone V Desktop
		  $(document).ready(function (e) {
			  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) { //MOBILE
				  //Device to Console
				<?php 	$stream = 'http://96.31.83.94:8061/;'; 
						$edgeJS = '<script type="text/javascript" charset="utf-8" src="homepage_mobile_edgePreload.js"></script>';
						$edgeFile = 'homepage_mobile.php';
				?>	  
				  device = "mobile";
				  console.log('You ARE using a mobile device!');
			  } else { //DESKTOP
				  (function ($) {
					<?php 	$stream = 'http://96.31.83.94:8061/;'; 
							$edgeJS = '<script type="text/javascript" charset="utf-8" src="homepage_edgePreload.js"></script>';
							$edgeFile = 'homepage.php';
					?>
					$('#audioPlayer').addEventListener('error', function failed(e) {
				   // audio playback failed - show a message saying why
				   // to get the source of the audio element use $(this).src
				   switch (e.target.error.code) {
					 case e.target.error.MEDIA_ERR_ABORTED:
					   alert('You aborted the audio playback.');
					   break;
					 case e.target.error.MEDIA_ERR_NETWORK:
					   alert('A network error caused the audio download to fail.');
					   	var audio = $(this);
						audio.src = "http://85.17.167.136:8534/;";
						audio.load();
					   break;
					 case e.target.error.MEDIA_ERR_DECODE:
					   alert('The audio playback was aborted due to a corruption problem or because the audio used features your browser did not support.');
					   	var audio = $(this);
						audio.src = "http://85.17.167.136:8534/;";
						audio.load();
					   break;
					 case e.target.error.MEDIA_ERR_SRC_NOT_SUPPORTED:
					   alert('The audio could not be loaded, either because the server or network failed or because the format is not supported.');
					   	var audio = $(this);
						audio.src = "http://85.17.167.136:8534/;";
						audio.load();
					   break;
					 default:
					   alert('An unknown error occurred.');
					   	var audio = $(this);
						audio.src = "http://85.17.167.136:8534/;";
						audio.load();
					   break;
				   }
				 }, true); 
				  })(jQuery);
				  device = "desktop";
				  $(document).ready(function () {
					  $('ul.sm-screen').toggle();
				  });
				  console.log('You ARE NOT using a mobile device!');
			  }
		  });
		</script>
