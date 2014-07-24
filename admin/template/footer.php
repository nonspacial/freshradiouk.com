                        </div>
                    </div>
                </div>
                		<?php	 if ($debug == 1) { ?> 
                <div id="debugButton"><button id="btn-debug" class="btn btn-default navbar-btn"><i class="fa fa-bug"></i></button></div>
            <?php	} ?>

                <div id="debug"> 
		<?php if ($debug==1) {include ("php/debug.php");}?>
                </div>


                <div id="footer">
                    <div class="container inverse">
                        <p class="container text-muted"> <?php echo $siteTitle;?> &copy; <?php echo date("Y")?></p>
            </div>
        </div>
    </body>
</html>