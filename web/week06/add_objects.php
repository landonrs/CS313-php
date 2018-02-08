<?php
$dbUrl = getenv('DATABASE_URL');
$message = "";
$db = Null;

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
	
	$db = pg_connect("host=$dbhost port=$dbPort dbname=$dbname user=$dbUser password=$dbPassword")
		or die ("Could not connect to server\n");
	echo "connected to heroku!";
	/* $db = new PDO("pgsql:host=$dbHost;port=$dbPort;dbname=$dbName", $dbUser, $dbPassword);
	$message = "successfully connected on heroku!"; */
} 

$object_list = ['apple', 'banana', 'orange'];


foreach($object_list as $object_name){
$file_name = "object_images\\" . $object_name . ".jpg";

$img = fopen($file_name, 'r') or die("cannot read image\n");
$data = fread($img, filesize($file_name));

$es_data = pg_escape_bytea($data);
fclose($img);

$query = "INSERT INTO OBJECT_IMAGES (IMAGE) VALUES('$es_data')";
pg_query($db, $query); 

$query = "INSERT INTO OBJECTS (OBJECT_NAME, OBJECT_IMAGE) VALUES
(
'$object_name',
(select currval('object_images_image_id_seq'))
)";
echo $query;
pg_query($db, $query); 
}

pg_close($db); 
echo "successfully added Images!";
?>