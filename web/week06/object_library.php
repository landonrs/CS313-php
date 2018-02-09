<?php
session_start();

$dbUrl = getenv('DATABASE_URL');
$message = "";
$db = Null;
if($_REQUEST["search"] !== null){
$search_object = $_REQUEST['search'];
}

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
?>
<div class="library-title"><h2 class="coming_soon">Current Object Library:</h2></div>
<div class="search-bar"><form id="lookup" action="object_library.php" method="post">
   <input type="text" name="search" form="lookup"><input type="submit" value="search"></form></div>
<div class="clear" style="overflow:auto;">
<table class="table table-light">
    <tbody>
		<?php 
		if($search_object == Null){
		try{
			$statement = $db->query('SELECT object_name, object_image from objects');
			while ($row = $statement->fetch(PDO::FETCH_ASSOC))
			{
			  echo '<tr><td>Object Name: ' . $row['object_name'] . '</td><td>Object Image:<img src="object_images\\' . $row['object_name'] . '.jpg"></td>';
			  echo "<td><form action='object_details.php' method='get'><input type='hidden' name='name' value='".$row['object_name']."'><input type='submit' value='See object details'></td></form></tr>";
			}
		}catch (PDOException $ex)
		{
		  echo 'Error!: ' . $ex->getMessage();
		  die();
		}
		}
		else{
			try{
			$statement = $db->prepare('SELECT object_name, object_image from objects where object_name =:name');
			$statement->bindValue(':name', $search_object, PDO::PARAM_STR);
			$statement->execute();
			if($statement->rowCount() > 0){
				while ($row = $statement->fetch(PDO::FETCH_ASSOC))
				{
				  echo '<tr><td>Object Name: ' . $row['object_name'] . '</td><td>Object Image:<img src="object_images\\' . $row['object_name'] . '.jpg"></td>';
				  echo "<td><form action='object_details.php' method='get'><input type='hidden' name='name' value='".$row['object_name']."'><input type='submit' value='See object details'></td></form></tr>";
				}
			}
			else{
				echo "<h1 style='color:white;'>No object names matched your search.</h1>";
			}
		}catch (PDOException $ex)
		{
		  echo 'Error!: ' . $ex->getMessage();
		  die();
		}
			
		}
		
		?>
    </tbody>
  </table>
  </div>
</body>
</html>