<?php include ("setup/config.php");	?>
<!doctype html>
<html>
    <head>
		<?php include ("css/css.php");?>
        <?php include ("js/JS.php");?>
	</head>
    <body>
		<?php  echo mainNav($dbc, $path);?>
    	<div id="page" class="container-fluid"></div>
			<div id="fb-root" class="fb_reset"></div>
            <?php 
				include ("pages/pages.php");
			?>
		</div>
        <?php include('template/footer.php');?>
    </body>
</html>
