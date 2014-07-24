    <!-- Jquery & UI-->
    <script src="//code.jquery.com/jquery-2.1.0.js"></script>
    <script src="//code.jquery.com/ui/1.10.4/jquery-ui.min.js"></script>
    
	<!-- Latest compiled and minified JavaScript -->
	<script src="//maxcdn.bootstrapcdn.com/bootstrap/3.2.0/js/bootstrap.min.js"></script>
    
    <!-- Scrollbar -->
    <script src="JS/jquery.mCustomScrollbar.concat.min.js"></script>
    <!-- Redactor -->
	<script src="JS/redactor.min.js"></script>
    <script src="JS/fullscreen.js"></script>
	<script src="JS/fontcolor.js"></script>
	<script src="JS/fontfamily.js"></script>
	<script src="JS/fontsize.js"></script>
	
    <script type="text/javascript">
	$(document).ready(
		function()
		{
			$('#console-debug').hide();
			$('#btn-debug').on("click", function () {
				$('#console-debug').toggle();
				
				});
				
			$(".btn-delete").on("click", function () {
				
				var selected = $(this).attr("id");
				
				var pageId = selected.split("del_").join("");
				var confirmed = confirm("Are you sure you want to delete this page!");
				if (confirmed==true) {
				
				$.get("AJAX/pages.php?id="+pageId);
				
				$("#page_"+pageId).remove();
				
				}
				
				//alert (selected);
				
				});
			
			$(".redactor").redactor({
			convertDivs: false,
			formattingTags: ["div", "p", "blockquote", "pre", "h1", "h2", "h3", "h4", "h5", "h6"],
			imageGetJson: "json/data.json",	
			imageUpload: "php/image_upload.php",
			fileUpload: "php/file_upload.php",
			minHeight: 300,
			autoresize: false,
			cleanFontTag: false,
			focus: true,
			plugins: ['fontsize', 'fontfamily','fontcolor','fullscreen']
			});});
	</script>
