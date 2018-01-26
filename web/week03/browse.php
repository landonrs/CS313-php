<?php
session_start();
class Robot {
	public $name;
	public $description;
	public $price;
	public $id;
	
	function __construct($name, $description, $price, $id){
		$this->name = $name;
		$this->description = $description;
		$this->price = $price;
		$this->id = $id;
	}
}

$robots = Array(new Robot("Atom Smasher", "This robot smashes atoms!", 999.00, 0), 
				new Robot("Midas", "This robot turns everything into Gold!", 2100.00, 1),
				new Robot("Zeus", "The largest robot in our collection!", 5000.00, 2),
				new Robot("Noisy Boy", "This robot only speaks Japanese!", 1599.00, 3));

$image_dict = Array( '0' => 'atom.jpg', '1' => 'midas.jpg', '2' => 'zeus.jpg', '3' => 'noisy.jpg');


if ($_SESSION["cart_items"] === null){
	$cart_items = Array();
	$_SESSION["cart_items"] = $cart_items;
}
else if($_REQUEST["new_robot"] !== null){
	echo "<script> alert('Added " . $robots[$_REQUEST["new_robot"]]->name ." to cart') </script>";
	array_push($_SESSION["cart_items"], $robots[$_REQUEST["new_robot"]]);
}

?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="robots.css">
</head>

<body>
<?php 
include('navbar.php');
?>
<table class="table table-dark">
    <tbody>
	<?php 
		foreach($robots as $robot){
			echo "<tr><td><img src='".$image_dict[$robot->id]."' /><td>$robot->name</td><td>$robot->description</td><td>Price:<br/>$" . number_format($robot->price, 2) . "</td>";
			echo "<td><form action='browse.php' method='post'><input type='hidden' name='new_robot' value='".$robot->id."'><input type='submit' value='add to cart'></td></form></tr>";
		}
	?>
    </tbody>
  </table>
<h4>All images are sourced from http://www.publicdomainpictures.net/</h4>
</body>
</html>