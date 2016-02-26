<?php
include("_header.php");
echo "<h1>This is the browse page!</h1>";
echo "You have ".checkAuth(false). " been authenticated.";
?>

<section>
	<div id="columns">
		<div id="col1">
			
		</div>
		<div id="col2">
		
		</div>
	</div>
</section>


<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("browsepage").className += "active";
	});
</script>
<?php
include("_footer.php");
?>