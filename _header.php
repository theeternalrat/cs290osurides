<?php
session_start();

<<<<<<< HEAD
function checkAuth($doRedirect) {
	if (isset($_SESSION["onidid"]) && $_SESSION["onidid"] != "") return $_SESSION["onidid"];

	 $pageURL = 'http';
	 if (isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on") {$pageURL .= "s";}
	 $pageURL .= "://";
	 if ($_SERVER["SERVER_PORT"] != "80") {
	  $pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
	 } else {
	  $pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
	 }
=======
function auth($redir){
	if(isset($_SESSION["onidid"]) && $_SESSION["onidid"] != ""){
		 return $_SESSION["onidid"];
	}
	
	$pageURL = 'http';
	if(isset($_SERVER["HTTPS"]) && $_SERVER["HTTPS"] == "on"){
		$pageURL .= "s";
	}
	
	if($_SERVER["SERVER_PORT"] != "80"){
		$pageURL .= $_SERVER["SERVER_NAME"].":".$_SERVER["SERVER_PORT"].$_SERVER["SCRIPT_NAME"];
	} else {
		$pageURL .= $_SERVER["SERVER_NAME"].$_SERVER["SCRIPT_NAME"];
	}
	
	$ticket = isset($_REQUEST["ticket"]) ? $_REQUEST["ticket"] : "";
	
	if($ticket != ""){
		$url = "https://login.oregonstate.edu/cas/serviceValidate?ticket=".$ticket."&service=".$pageURL;
		$html = file_get_contents($url);
		$pattern = '/\\<cas\\:user\\>([a-zA-Z0-9]+)\\<\\/cas\\:user\\>/';
		preg_match($pattern, $html, $matches);
		if($matches && count($matches) > 1){
			$onidid = $matches[1];
			$_SESSION["onidid"] = $onidid;
			return $onidid;
		}
	} else if($redir){
		$url = "https://login.oregonstate.edu/cas/login?service=".$pageURL;
		echo "<script>location.replace('" . $url . "');</script>";
	}
	return "";
}
echo "<html><head>"; ?>
>>>>>>> 9df0a7e50c8192fe0d5087d1298419ba5e4cbe75

	$ticket = isset($_REQUEST["ticket"]) ? $_REQUEST["ticket"] : "";

	if ($ticket != "") {
		$url = "https://login.oregonstate.edu/cas/serviceValidate?ticket=".$ticket."&service=".$pageURL;
		$html = file_get_contents($url);
		$pattern = '/\\<cas\\:user\\>([a-zA-Z0-9]+)\\<\\/cas\\:user\\>/';
		preg_match($pattern, $html, $matches);
		if ($matches && count($matches) > 1) {
			$onidid = $matches[1];
			$_SESSION["onidid"] = $onidid;
			return $onidid;
		} 
	} else if ($doRedirect) {
		$url = "https://login.oregonstate.edu/cas/login?service=".$pageURL;
		echo "<script>location.replace('" . $url . "');</script>";
	} 
	return "";
}

echo "<html><head>"; ?>
	<title>OSU Rides</title>
		<script src="https://code.jquery.com/jquery-1.9.1.min.js"></script>
		<link rel="stylesheet" type="text/css" href="mainstyle.css">
		
	</head><body>
<<<<<<< HEAD
	<div id="container">
		<div class="header">
			<ul id="navbar" class="center">
				<li id="mainpage"><a href="index.php" >Home</a></li>
				<li id="settingspage"><a href="settings.php">Settings</a></li>
				<li id="browsepage"><a href="browse.php">Browse</a></li>
			</ul>
		</div>
		<div class="content">
=======
	  
<ul id="navbar" class="center">
	<li id="mainpage"><a href="index.php" >Home</a></li>
	<li id="settingspage"><a href="settings.php">Settings</a></li>
	<li id="browsepage"><a href="browse.php">Browse</a></li>
</ul>
>>>>>>> 9df0a7e50c8192fe0d5087d1298419ba5e4cbe75
