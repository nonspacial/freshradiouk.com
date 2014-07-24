                            <div class="row">
                            <div id="message"><?php if($message){ echo $message;}?></div>
                            <div id="loginform" class="col-md-4 col-md-offset-4">
                                <div class="panel panel-info">
                                <div class="panel-heading"><h3>Fresh Registeration</h3></div><!--END panelheading-->
                                    <div class="panel-body">
                                    <form role="form" action="pages/register_post.php" method="post" autocomplete="on">
                                      
                                    <div class="form-group">
                                        <label for="username">Username</label>
                                        <input type="username" class="form-control" id="username" name="username" placeholder="Choose your username">
                                    </div>
                                    <div class="form-group">
                                        <label for="email">Email</label>
                                        <input type="email" class="form-control" id="email" name="email" placeholder="Enter your Email">
                                    </div>
                                    <div class="form-group">
                                        <label for="first">First Name</label>
                                        <input type="first" class="form-control" id="first" name="first" placeholder="Enter Your First Name">
                                    </div>
                                    <div class="form-group">
                                        <label for="last">Last Name</label>
                                        <input type="last" class="form-control" id="last" name="last" placeholder="Enter your Last Name">
                                    </div>
 	                                <div class="form-group">
                                        <label for="password">Password</label>
                                        <input type="password" class="form-control" id="password" name="password" placeholder="Choose a Password">
                                    </div>
                                    <div class="form-group">
                                        <label for="checker">Password Check</label>
                                        <input type="password" class="form-control" id="checker" name="checker" placeholder="Re-Enter your Password">
                                    </div>
                                      <input type="hidden" name="status" id="status" value="1" >
                                      <input type="hidden" name="submitted" id="submtted" value="1" >
                                      <button type="submit" class="btn btn-default">Submit</button>
                                      <a href="../">Back to Main Site</a>
                                    </form>
                                 </div><!--END panelbody-->
                              </div><!--END panel-->
                         </div><!--END col-->
                    </div><!--END row-->
