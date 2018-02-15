<?php

function connect_to_db(){
	$dbUrl = getenv('DATABASE_URL');
	$message = "";
	$db = Null;

	$dbUrl = getenv('DATABASE_URL');
	$message = "";
	$db = Null;

	if (empty($dbUrl)) {
		try
		{
			$host = "localhost";
			$user = 'postgres';
			$password = 'root';
			$db = new PDO('pgsql:host=localhost;dbname=neo', $user, $password);
			$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
		}
		catch (PDOException $ex)
		{
		  echo 'Error!: ' . $ex->getMessage();
		  die();
		}
		$message = "connected to local DB!";
	}
	else{

		$dbopts = parse_url($dbUrl);

		$dbHost = $dbopts["host"];
		$dbPort = $dbopts["port"];
		$dbUser = $dbopts["user"];
		$dbPassword = $dbopts["pass"];
		$dbName = ltrim($dbopts["path"],'/');

		$db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
		$message = "successfully connected on heroku!";
	}
	$db->setAttribute( PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION );
	return $db;
}
?>