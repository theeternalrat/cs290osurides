<?php
include("_header.php");

if(checkAuth(true) != ""){

echo "<div class=\"main\"><h1>This is the settings page! You've been authenticated.</h1></div>";
?>
<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("settingspage").className += "active";
	});
</script>
<?php
}
include("_footer.php");
?>