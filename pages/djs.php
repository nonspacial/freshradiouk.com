<?php 
include("setup/connection.php"); 
?>
<div id="profilesPage" class="container">
    <div id="djList" class="col-md-3">
        <div class="list-group" style="border-bottom:1px solid #DCDCDC;border-radius:0;">
		<?php	
			$list=$dbc->query("SELECT * FROM dj_profiles ORDER BY dj_name");
            #Get Page Content Query
            while($list=mysqli_fetch_assoc($list)) {?>
             <div id="profile_<?php echo $list['id']; ?>"  style="background:none;padding-bottom:4%;border:0px;"
             class="list-group-item<?php selected($list['id'], $_GET['id'], ' active');?>">
             <a href="Djs?id=<?php echo $list['id'];?>" ><span><h4 class="list-group-item-heading" style="color:#DCDCDC;" ><?php echo $list['dj_name'];?></h4></span></a>
             
             </div><?php };?>
        </div> 
    </div>
    <div id="djProfile" class="col-md-9 panel panel-default" style="background:none;">
       	<?php	$opened=$dbc->query("SELECT * FROM dj_profiles WHERE id=$_GET[id]");
				$list=mysqli_fetch_assoc($opened);
			 	if ($list) { ?>
                        <div id="bio_<?php echo $list['id'];?>" class="col-md-12 bio" style="height:700px;color:#DCDCDC;"><h1><?php echo $list['dj_name'];?></h1><?php echo html_entity_decode($list['bio'])?></div>					
		<?php		}else{?>
                        <div id="bioMain" class="col-md-12 bio" style="height:700px;color:#DCDCDC;"><h1>Our Dj's</h1></div>					
		<?php 		}?>
    </div>
</div>
<script type="text/javascript">
$('.bio').hide();
$('.bio').fadeIn(1500);
</script>