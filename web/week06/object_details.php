<?php
session_start();

$dbUrl = getenv('DATABASE_URL');
$message = "";
$db = Null;
$object_name = $_GET['name'];
$object_id = $_GET['id'];

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
?>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
<link rel="stylesheet" href="neo_style.css">
</head>
<body>
<?php
include('navbar.php');
$statement = $db->prepare('SELECT OBJECT_IMAGE FROM OBJECTS WHERE OBJECT_ID = :id');
$statement->bindValue(':id', $object_id, PDO::PARAM_INT);
$statement->execute();
$object_image = $statement->fetch(PDO::FETCH_ASSOC);
?>
<img class="object_image" src="<?php echo $object_image['object_image']; ?>">
<h2 class="coming_soon"><?php echo $object_name; ?></h2>
<div style="overflow:auto;">
<table class="table table-light">
    <tbody>
	
		<?php 
		try{
			$statement = $db->prepare('SELECT ATTRIBUTE_NAME, ATTRIBUTE_VALUE 
									FROM OBJECT_DESCRIPTION OD JOIN ATTRIBUTES a on OD.ATTRIBUTE_ID = a.ATTRIBUTE_ID
									WHERE OD.OBJECT_ID = (SELECT OBJECT_ID FROM OBJECTS WHERE OBJECT_NAME =:name)');
			$statement->bindValue(':name', $object_name, PDO::PARAM_STR);
			$statement->execute();
			while ($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
			  echo '<tr><td>Object ' .  $row['attribute_name'] . ': ' . $row['attribute_value'] . '</td></tr><br/>';
			}
		}catch (PDOException $ex)
		{
		  echo 'Error!: ' . $ex->getMessage();
		  die();
		}
		
		?>
    </tbody>
  </table>
  </div>
</body>
</html>