<?php function mainNav ($dbc, $user) {
	$userStatus = $dbc->query("SELECT * FROM users WHERE username = '$_SESSION[username]' LIMIT 1");
	$userStatus = mysqli_fetch_assoc($userStatus);

	?>
	
    <nav class="navbar navbar-inverse" role="navigation">
      <div class="container-fluid">
        <div class="container">
        <!-- Brand and toggle get grouped for better mobile display -->
            <div class="navbar-header">
              <button type="button" class="navbar-toggle" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1">
                <span class="sr-only">Toggle navigation</span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
                <span class="icon-bar"></span>
              </button>
            </div>

            <!-- Collect the nav links, forms, and other content for toggling -->
            <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
              <ul class="nav navbar-nav">
                
                    <li><a href="?page=dashboard&amp;id=dashboard&amp;title=home">Dashboard</a></li>
                    <li><a href="?page=pages">Pages</a></li>
                    <li><a href="?page=showtime">Showtime</a></li>
                    <li><a href="?page=users&amp;id=user&amp;title=home">Users</a></li>
                    <li><a href="?page=settings&amp;id=settings&amp;title=home">Settings</a></li>
                </ul>
                     <ul class="nav navbar-nav navbar-right">
							<?php #Debug button 
				 			if ($debug == 1) {?>
                 				<button id="btn-debug" class="btn btn-default"><i class="fa fa-bug"></i></button>
							 <?php } ?>
                        <li class="dropdown">
                          <a href="#" class="dropdown-toggle" data-toggle="dropdown"><b class="text-muted"><?php echo $userStatus['first']." ".$userStatus['last']; ?></b> <b class="caret"></b></a>
                             <ul class="dropdown-menu" role="menu">
                                <li><a href="../setup/logout.php">Logout</a></li>
                                <li><a href="../home">Home Page</a></li>
                                <li><a href="../Schedule">Schedule</a></li>
                                <li><a href="../Shoutbox">Shoutbox</a></li>
                                <li><a href="../Fbook">Facebook</a></li>
                                <li><a href="../Twitter">Twitter</a></li>
                                <li><a href="../visitor-map">Visitor Map</a></li>
                            </ul>
                        </li>
                    </ul>
            </div><!-- /.navbar-collapse -->
        </div><!-- /.container -->
      </div><!-- /.container-fluid -->
    </nav>
<?php }; //end function
				
function subNav ($dbc) {
	$q= "SELECT * FROM nav WHERE menu='sub' AND page='hire' ORDER BY id";
	$r=mysqli_query ($dbc, $q);	
				if ($r) {//begin IF?>
		
			<ul>
            	<?php	while ($navSub = mysqli_fetch_assoc($r)) {//begin WHILE?>
                
                    <li id="<?php echo $navSub['slug'];?>" class="subButton" title="<?php echo $navSub['page'];?>">
                    
                        <a href="<?php echo $navSub['slug'];?>"><?php echo $navSub['label'];?></a>
                        
                    </li>
				<?php ;}//end WHILE
		?> </ul>
			
					<?php ;}//end IF
				};//end FUNCTION
?>