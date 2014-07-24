<script type="text/javascript">	
			//Phone V Desktop
		  $(document).ready(function (e) {
			  if (/Android|webOS|iPhone|iPad|iPod|BlackBerry/i.test(navigator.userAgent)) { //MOBILE
				  //Device to Console
				  device = "mobile";
				  console.log('You ARE using a mobile device!');
			  } else { //DESKTOP
			  	//scrollBar
				  (function ($) {
					  $(window).load(function () {
						  $("#editor").mCustomScrollbar({
							  scrollButtons: {
								  enable: true
							  },
							  theme: "dark-2"
						  });
					  });
				  })(jQuery);
				  device = "desktop";
				  $(document).ready(function () {
					  $('ul.sm-screen').toggle();
				  });
				  console.log('You ARE NOT using a mobile device!');
			  }
		  });
		</script>
