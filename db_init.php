<?php

ini_set('display_errors', 'On');

$dbhost = 'oniddb.cws.oregonstate.edu';
$dbuser = 'atkinsor-db';
$dbpass = 'g2uMWXsH902GzUEW';
$dbname = 'atkinsor-db';

$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);
if($mysqli->connect_error){
	die("Connection failed: " . $mysqli->connect_error);
}
?>
