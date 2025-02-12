<?php

	$conn = mysqli_connect(
		getenv('DB_HOST'),
		getenv('DB_USER'),
		getenv('DB_PASS'),
		getenv('DB_NAME')
	);

	if(!$conn){
		$error = "Database connection error: " . mysqli_connect_error();
		error_log($error);
		die("Could not connect to the database. Please try again later. Error: $error");
	}

?>