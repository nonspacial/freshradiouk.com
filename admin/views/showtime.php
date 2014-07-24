<h1>Page Manager</h1>
<div class="row">
        <div id="showtimeMaster" class="col-md-4">
          <div class="list-group">
                    <a href="?page=showtime" class="list-group-item">
                    <h4 class="list-group-item-heading"><i class="fa fa-plus"></i> New Show</h4>
                    </a>  
            <?php	
                    #Get Page Content Query
                    $q = "SELECT * FROM showtime GROUP BY weekday ASC";
                    $r = mysqli_query ($dbc, $q);
                    ?>
                    <div style="height:430px;"> 
                    <div id="Accordion1"><!--START accordion-->
						<?php
						while ($heading = mysqli_fetch_assoc($r)) {?>
							<h3><a href="#"><?php echo $heading['day']; ?></a></h3>
                            <div id="days<?php echo $heading['id'] ?>" style="padding:0%;">
								<?php
							$q1 = "SELECT * FROM showtime WHERE day = '$heading[day]' ORDER BY start_time ASC";
							$r1 = mysqli_query ($dbc, $q1);
                            while($list = mysqli_fetch_assoc($r1)) {
                                ?>
                                 <div id="showtime_<?php echo $list['id']; ?>"  style="padding-bottom:0%; background-color:#4D4D4D; width:100% !important;" class="list-group-item<?php selected($list['id'], $opened['id'], ' active');?>">
                                     <div class="pull-right">
                                         <a href="#" id="del_<?php echo $list['id']; ?>" class="btn btn-danger btn-delete"><i class="fa fa-trash-o"></i></a>
                                         <a href="index.php?page=showtime&amp;id=<?php echo $list['id'];?>" class="btn btn-default"><i class="fa fa-chevron-right"></i></a>
                                     </div>
                                     <span>
                                         <h4 style=" color:#000000"  class="list-group-item-heading"><?php echo $list['start_time']."-".$list['end_time'];?></h4>
                                         <h5><?php echo $list['dj'];?></h5> 
                                         <p><?php echo $list['showtitle']; ?></p>
                                     </span>
                                 </div><?php }/*END WHILE Times*/?>
                         	</div><!--END days-->
                            <?php }/*END WHILE EachDay*/?>
                    </div><!--END accordion-->
                    </div>
                </div>
            </div>
        <div id="editor" class="col-md-7 panel panel-default">
         <?php /* Page Saved/Inserted*/ if (isset($message)){ echo $message;}?>
        <form role="form" action="index.php?page=showtime&amp;id=<?php echo $opened['id'];?>" method="post">
                <div class="form-group">
                    <label for="starttime">Time:</label>
                    <input class="form-control" type="text" name="start_time" id="start_time" value="<?php echo $opened['start_time'];?>" placeholder="Time in format: 00:00">
                </div>
                <div class="form-group">
                    <label for="endtime">Time:</label>
                    <input class="form-control" type="text" name="end_time" id="end_time" value="<?php echo $opened['end_time'];?>" placeholder="Time in format: 00:00">
                </div>
                <div class="form-group">
                    <label for="day">Day:</label>
                    <input class="form-control" type="text" name="day" id="day" value="<?php echo $opened['day'];?>" placeholder="Day of the week">
                </div>
                <div class="form-group">
                    <label for="weekday">Day of the week (1-7 where 1 = Monday and 7 = Sunday):</label>
                    <input class="form-control" type="text" name="weekday" id="weekday" value="<?php echo $opened['weekday'];?>" placeholder="1">
                </div>
                <div class="form-group">
                    <label for="dj">DJ:</label>
                    <input class="form-control" type="text" name="dj" id="dj" value="<?php echo $opened['dj'];?>" placeholder="DJ name">
                </div>
                <div class="form-group">
                    <label for="show">Show:</label>
                    <input class="form-control" type="text" name="show" id="show" value="<?php echo $opened['showtitle'];?>" placeholder="Show Title">
                </div>
                <div class="form-group">
                    <label for="genre">Genre:</label>
                 <div id="textarea"><input class="form-control" name="genre" id="genre" value="<?php echo $opened['genre'];?>" placeholder="Genre"></div>
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

<?php //print_r ($r);?>
<!--  <h3><a href="#">Section 1</a></h3>
  <div>
    <p>Content 1</p>
  </div>
-->

<script type="text/javascript">
$(function() {
	$( "#Accordion1" ).accordion({
					collapsible: true,
					heightStyle: "fill"
						}); 
			});
</script>
