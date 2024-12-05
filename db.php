<?php
	// Establish connection info
	$server = "localhost";// your server
	$userid = "u4gf7e74mkd1u"; // your user id
	$pw = "@6o1r1$4245g"; // your pw
	$db = "dbmf6wszms8ula"; // your database

	// Create connection
	$conn = new mysqli($server, $userid, $pw );

	// Check connection
	if ($conn->connect_error) {
		die("Connection failed: " . $conn->connect_error);
	}

	// Select database
	$conn->select_db($db);
?>
