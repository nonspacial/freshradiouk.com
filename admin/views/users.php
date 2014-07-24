<h1>User Manager</h1>

<div class="row">

        <div class="col-md-4" style="overflow-y:scroll; height:470px">
        
                    <div class="list-group">
        
                         <a href="?page=users" class="list-group-item">
                        <h4 class="list-group-item-heading"><i class="fa fa-plus"></i> New User</h4>
                        </a>  
                                                 
                    <?php	
                            #Get Page Content Query
                            $q = "SELECT * FROM users ORDER BY last ASC";
                            $r = mysqli_query ($dbc, $q);
                            
                            while($list = mysqli_fetch_assoc($r)) {
								
								 $list=data_user($dbc, $list['id']);?>
                             
                             <a class="list-group-item <?php selected($list['id'], $opened['id'], ' active');?>" href="index.php?page=users&amp;id=<?php echo $list['id'];?>" >
								<h4 class="list-group-item-heading"><?php echo $list['fullname_reverse']; ?></h4>
                             </a>
							 
					<?php }?>
                             
                    </div> 
        </div>

        <div class="col-md-7 mScroll" style="margin-right:auto; margin-left:3%; height:470px; overflow-y:scroll;">
        
        	<?php /* Page Saved/Inserted*/ if (isset($message)){ echo $message; }?>

        <form action="index.php?page=users&amp;id=<?php echo $opened['id'];?>" method="post" role="form">
                <div class="form-group">
                
                    <label for="first">First Name:</label>
                    <input class="form-control" type="text" name="first" id="first" value="<?php echo $opened['first']; ?>" placeholder="First Name:" autocomplete="off">
               
                </div>
                
                <div class="form-group">
                
                    <label for="last">Last Name:</label>
                    <input class="form-control" type="text" name="last" id="last" value="<?php echo $opened['last']; ?>" placeholder="Last Name:" autocomplete="off">
                    
                </div>
                
                <div class="form-group">
                
                    <label for="email">Email Address:</label>
                    <input class="form-control" type="email" name="email" id="email" value="<?php echo $opened['email']; ?>" placeholder="Email:" autocomplete="off">
                    
                </div>
                
                <div class="form-group">
                
                    <label for="username">Username:</label>
                    <input class="form-control" type="text" name="username" id="username" value="<?php echo $opened['username']; ?>" placeholder="Username:" autocomplete="off">
                    
                </div>
                
			<div class="form-group">

                <label for="status">Status:</label>
                <select class="form-control" name="status" id="status">
                        <option value="0" <?php if(isset($_GET['id'])){selected('0', $opened['status'], 'selected');} ?>>Inactive</option>
                        <option value="1" <?php if(isset($_GET['id'])){selected('1', $opened['status'], 'selected');} ?>>Active</option>
            </select>
             
             </div>
             
                <div class="form-group">
                
                    <label for="password">Password:</label>
                    <input class="form-control" type="password" name="password" id="password"  value="" placeholder="Password:" autocomplete="off">
                    
                </div>
                
                <div class="form-group">
                
                    <label for="passwordv">Verify Password:</label>
                    <input class="form-control" type="password" name="passwordv" id="passwordv" value="" placeholder="Type password again:" autocomplete="off">
                    
                </div>
                
            <br>
			<button type="submit" class="btn btn-default">Save</button>
			<input type="hidden" name="submitted" value="1">
			<?php if(isset($opened['id'])) { ?>
				<input type="hidden" name="id" value="<?php echo $opened['id']; ?>">
			<?php } ?>
        </form>
        
        </div>
        
    </div>
    


