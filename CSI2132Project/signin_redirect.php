<?php
session_start();

$db_connection = pg_connect("host=localhost dbname=csi2132_project user=web password=webapp");

$query = "SELECT * FROM users WHERE username = '{$_POST["usr"]}'";

$result = pg_query($db_connection, $query) or
	die('Query failed: ' . pg_last_error());

$row = pg_fetch_array($result);


//Incorect password
if ($row["password"] != $_POST["pwd"])
	header('Location: index.php?action=fail');
else {
	//Assign session variables and continue to home page
	$_SESSION["isEmployee"] = $row["type"];
	$_SESSION["usr"] = $_POST["usr"];

	if ($_SESSION["isEmployee"] == "employee") {
		$result = pg_query($db_connection, "SELECT * FROM employee WHERE username = '{$_SESSION["usr"]}'");
		$row = pg_fetch_array($result);
		$_SESSION["hotel_id"] = $row["hotel_id"];
	}

	header('Location: ./home_redirect.php');	
}

?>