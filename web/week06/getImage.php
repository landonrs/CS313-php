<?php
session_start();

$dbUrl = getenv('DATABASE_URL');
$message = "";
$db = Null;
$image_id = $_GET['id'];

if (empty($dbUrl)) {
	// example localhost configuration URL with postgres username and a database called cs313db
	$host = "localhost"; 
	$user = "postgres"; 
	$pass = "root"; 
	$dbcon = "neo"; 

	$db = pg_connect("host=$host dbname=$dbcon user=$user password=$pass")
		or die ("Could not connect to server\n");
	}
else{

	$dbopts = parse_url($dbUrl);

	$dbHost = $dbopts["host"];
	$dbPort = $dbopts["port"];
	$dbUser = $dbopts["user"];
	$dbPassword = $dbopts["pass"];
	$dbName = ltrim($dbopts["path"],'/');
	
	$db = pg_connect("host=$dbhost dbname=$dbname user=$dbUser password=$dbPassword")
		or die ("Could not connect to server\n");
		
	/* $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
	$message = "successfully connected on heroku!"; */
}

$query = "SELECT image FROM OBJECT_IMAGES WHERE image_id=$image_id";
$res = pg_query($db, $query) or die (pg_last_error($db)); 
$data = pg_fetch_result($res, 'image');
header('Content-type: image/jpeg');
echo pg_unescape_bytea($data);
?>