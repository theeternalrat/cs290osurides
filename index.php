<?php include("_header.php"); ?>
<p>
<h1>Hello World!</h1>
<h2>Current time: <?php echo date("Y-m-d h:i:sa"); ?> </h2>
		
<h3> Names: Annie, Ryan, Sam, George, Charles, Rebecca. </h3>

<a href="settings.php">Log In</a>
<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("mainpage").className += "active";
	});
</script>
<?php include("_footer.php"); ?>