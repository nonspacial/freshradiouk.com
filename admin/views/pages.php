                    <h1>Page Manager</h1>
                    <div class="row">
                            <div class="col-md-4">
											<div class="list-group">
												<a href="?page=pages" class="list-group-item">
												<h4 class="list-group-item-heading"><i class="fa fa-plus"></i> New Page</h4>
												</a>  
                                        <?php	
												#Get Page Content Query
												$q = "SELECT * FROM content ORDER BY id ASC";
                                                $r = mysqli_query ($dbc, $q);
                                                
                                                while($list = mysqli_fetch_assoc($r)) {?>
                                                 <div id="page_<?php echo $list['id']; ?>"  style="padding-bottom:4%;"
                                                 class="list-group-item<?php selected($list['slug'], $opened['slug'], ' active');?>">
                                                 <div class="pull-right">
                                                 <a href="#" id="del_<?php echo $list['id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
                                                 <a href="index.php?page=pages&amp;id=<?php echo $list['page'];?>&amp;title=<?php echo $list['title'];?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
                                                 </div>
                                                 <span><h4 style=" color:#000000"  class="list-group-item-heading"><?php echo $list['label'];?></h4></span>
                                                 
                                                 </div><?php };?>
                                        </div> 
                            </div>
                            <div id="editor" class="col-md-7 panel panel-default">
                           	 <?php /* Page Saved/Inserted*/ if (isset($message)){ echo $message;}?>
                            <form role="form" action="index.php?page=pages&amp;id=<?php echo $opened['page'];?>&amp;title=<?php echo $opened['title'];?>" method="post">
                                    <div class="form-group">
                                        <label for="label">Label:</label>
                                        <input class="form-control" type="text" name="label" id="label" value="<?php echo $opened['label'];?>" placeholder="Page">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Page:</label>
                                        <input class="form-control" type="text" name="page" id="page" value="<?php echo $opened['page'];?>" placeholder="Page">
                                    </div>
                                    <div class="form-group">
                                        <label for="slug">Friendly URL name:</label>
                                        <input class="form-control" type="text" name="slug" id="slug" value="<?php echo $opened['slug'];?>" placeholder="Friendly URL Here:">
                                    </div>
                                    <div class="form-group">
                                        <label for="pageTitle">Title:</label>
                                        <input class="form-control" type="text" name="pageTitle" id="pageTitle" value="<?php echo $opened['title'];?>" placeholder="Page Title">
                                    </div>
                                    <div class="form-group">
                                        <label for="title">Body:</label>
                                     <div id="textarea"><textarea class="form-control redactor" name="body" id="body" rows="20" placeholder="Page Body"><?php echo $opened['body'];?></textarea></div>
                                    </div>
                                    <label for="menu">Menu Type:</label>
                                    <select class="form-control" name="menu" id="menu">
                                            <option value="0">No Type</option>
                                        <?php	#Menu Creation Dropdown
												$q = "SELECT * FROM navtype";
                                                $r = mysqli_query($dbc, $q);
                                            
                                                while($menuType = mysqli_fetch_assoc($r)) {?>
                                            			
                                                    <option value="<?php echo $menuType['type'];?>" 
                
                                                    <?php 	if(isset($path)){selected($menuType['type'], $opened['menu'], 'selected');} 
																				else {selected($menuType['type'], $pagelists['menu'], 'selected');}?>>
																					<?php echo $menuType['type']; ?></option><?php  } ?>
								</select>
                                 <label for="sub">Has subMenu:</label>
								<select class="form-control" name="sub" id="sub">
									<option value="0" <?php if(isset($_GET['id'])){selected('0', $opened['hasSub'], 'selected');} ?>>No</option>
									<option value="1" <?php if(isset($_GET['id'])){selected('1', $opened['hasSub'], 'selected');} ?>>Yes</option>
								</select>

								<br>
								<button type="submit" class="btn btn-default">Save</button>
                                <input type="hidden" name="submitted" value="1">
                                <input type="hidden" name="user" value="<?php echo $user['id'] ?>">
								<?php if(isset($opened['id'])) { ?>
                                    <input type="hidden" name="id" value="<?php echo $opened['id']; ?>">
                                <?php } ?>
                    	</form>
                       </div>
                    </div>
