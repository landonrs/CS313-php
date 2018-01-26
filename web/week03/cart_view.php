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
$image_dict = Array( '0' => 'atom.jpg', '1' => 'midas.jpg', '2' => 'zeus.jpg', '3' => 'noisy.jpg');
//if the user has pressed a button remove the corresponding robot from the array
if($_REQUEST["new_robot"] !== null){
	unset($_SESSION["cart_items"][$_REQUEST["new_robot"]]);
	$_SESSION["cart_items"] = array_values($_SESSION["cart_items"]);
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

<h1>Your Cart:</h1><br/>
<table class="table table-dark">
    <tbody>
	<?php 
		$cart_item_num = 0;
		foreach($_SESSION['cart_items'] as $robot){
			echo "<tr><td><img src='".$image_dict[$robot->id]."' /><td>$robot->name</td><td>$robot->description</td><td>Price:<br/>$" . number_format($robot->price, 2) . "</td>";
			echo "<td><form action='cart_view.php' method='post'><input type='hidden' name='new_robot' value='". $cart_item_num ."'><input type='submit' value='Remove from cart'></td></form></tr>";
			$cart_item_num++;
		}
	?>
    </tbody>
  </table>
<form action="checkout.php">
    <input class="btn btn-primary" type="submit" value="check out" />
</form><br/>
<form action="browse.php">
    <input class="btn btn-primary" type="submit" value="return to browse" />
</form><br/>
<h4>All images are sourced from http://www.publicdomainpictures.net/</h4>
</body>
</body>
</html>