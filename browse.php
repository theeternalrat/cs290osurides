<?php
include("_header.php");
echo "<h1>This is the browse page!</h1>";
echo "You have ".checkAuth(false). " been authenticated.";
?>
<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("browsepage").className += "active";
	});
</script>
<?php
include("_footer.php");
?>