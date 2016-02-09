<?php
	include("_header.php");

	if (checkAuth(true) != "") {
		echo "<div class=\"main\"><h1>This is the settings page! You've been authenticated.</h1></div>";
		echo "<h1>This is the settings page!</h1>";
?>
	<script type="text/javascript">
	$(document).ready( function() {
		document.getElementById("settingspage").className += "active";
	});
	</script>
<html>
<h1>My Profile</h1>
<div id="ratings">
	<p>***** Passenger</p>
	<p>***** Driver</p>
	<img src="https://cdn4.iconfinder.com/data/icons/round-buttons/512/red_user.png" id="profile_pic"/>
</div>
<h3>My Posts</h3>
	<div id="posts">
		<ul>
			<li>Looking for a one-way trip to Narnia, minimal baggage</li>
			<li>Swimming to Madagascar on the 22nd</li>
			<li>Who left this illegal item in my minivan</li>
		</ul>
	</div>
<p>Make a post</p>
</html>
<?php
	}	
	include("_footer.php");
?>

