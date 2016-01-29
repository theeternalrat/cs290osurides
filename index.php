<?php include("_header.php"); ?>
<div>
<p>
<h1>Hello World!</h1>
<h2>Current time: <?php echo date("Y-m-d h:i:sa"); ?> </h2>
		
<h3> Names: Annie, Ryan, Sam, George, Charles, Rebecca. </h3>
</div>
<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("mainpage").className += "active";
	});
</script>
<?php include("_footer.php"); ?>