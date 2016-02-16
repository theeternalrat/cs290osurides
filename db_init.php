<?php

ini_set('display_errors', 'On');

$dbhost = 'DB_HOST';
$dbuser = 'DB_USER';
$dbpass = 'DB_PASS';
$dbname = 'DB_NAME';

$mysqli = new mysqli($dbhost,$dbuser,$dbpass,$dbname);

?>
