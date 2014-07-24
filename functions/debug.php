<div id="console-debug">
	<?php
	
		$all_vars = get_defined_vars();
	
	?>
<h1>Date Array:</h1>	

	<pre>
<?php print_r($dateTime); ?>			
	</pre>
	

<h1>ALL VARS:</h1>	

<pre>
<?php print_r($all_vars); ?>
</pre>
	
		
<h1>newTime:</h1>	

	<pre>
<?php print_r($newTime); ?>			
	</pre>
		
<h1>Post:</h1>	

<h1>showStart:</h1>	

	<pre>
<?php print_r($showStart); ?>			
	</pre>
		
<h1>Post:</h1>	

<h1>showEnd:</h1>	

	<pre>
<?php print_r($showEnd); ?>			
	</pre>
		
<h1>Post:</h1>	

<h1>time:</h1>	

	<pre>
<?php print_r($current_time); ?>			
	</pre>
		
<h1>Post:</h1>	

	<pre>
<?php print_r($_POST); ?>			
	</pre>
	
<h1>Title:</h1>	

	<pre>
<?php print_r($title); ?>			
	</pre>
	
<h1>Pg:</h1>	

	<pre>
<?php print_r($pg); ?>			
	</pre>			
	
<h1>Debug Status:</h1>	

	<pre>
<?php print_r($debug); ?>			
	</pre>
    
<h1>User Array:</h1>	

	<pre>
<?php print_r ($user); ?>			
	</pre>
    
<h1>Nav Array:</h1>	

	<pre>
<?php   print_r ($nav);?>			
	</pre>
     
<h1>Subnav Array:</h1>	

	<pre>
<?php  print_r ($subNav);  ?>			
	</pre>
    
<h1>Cleanshit Page:</h1>	

	<pre>
<?php  print_r ($pageName); ?>			
	</pre>
    			
<h1>Pagelists Array:</h1>	

	<pre>
<?php  print_r ($pagelists); ?>			
	</pre>
    
<h1>Label Array:</h1>	

	<pre>
<?php  print_r ($label); ?>			
	</pre>
    
<h1>Message:</h1>	

	<pre>
<?php  print_r ($message); ?>			
	</pre>
    
<h1>Cleanshit Title:</h1>	

	<pre>
<?php  print_r ($pageTitle); ?>			
	</pre>
    
<h1>Cleanshit Page Body:</h1>	

	<pre>
<?php  print_r ($body); ?>			
	</pre>
    
<h1>Path Array</h1>
	
	<pre>			
<?php print_r($path); ?>	
	</pre>
	
<h1>GET</h1>
	
	<pre>			
<?php print_r($_GET); ?>	
	</pre>	
	
<h1>POST</h1>
	
	<pre>			
<?php print_r($_POST); ?>	
	</pre>	

<h1>Page Array:</h1>	

	<pre>
<?php print_r($page); ?>			
	</pre>	
    		
    
<h1>Opened Array:</h1>	

	<pre>
<?php  print_r ($opened); ?>			
	</pre>
    
<h1>Menutype Array:</h1>	

	<pre>
<?php  print_r ($menuType); ?>			
	</pre>
    

<pre>
<?php print_r($session->get_settings()); ?>
</pre>

<pre>

<?php print_r($session->get_active_sessions());	?>

</pre>
		
<pre>

<?php print_r(getActiveUsers($dbc)); ?>

</pre>
    
</div>
