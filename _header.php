<?php include("auth.php"); ?>

<html><head>
	<title>OSU Rides</title>
		<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="mainstyle.css">

	</head><body>
	<div id="container">
		<div class="header">
			<ul id="navbar" class="center">
				<li id="Name" class="name"> OSU Rides</li> 
				<?php  if(checkAuth(false) != ""){
					echo "<li id='login'><a href='logout.php'>Log Out</a></li>";
				} else {
					echo "<li id='login'><a href='my_profile.php'>Log In</a></li>";
				} ?>
				<li id="settingspage"><a href="my_profile.php">My Profile</a></li>
				<li id="browsepage"><a href="browse.php">Browse</a></li>
				<li id="mainpage"><a href="index.php" >Home</a></li>
			</ul>
		</div>
		<div class="content">
