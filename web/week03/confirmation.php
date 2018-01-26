<?php
session_start();
$street = htmlspecialchars($_REQUEST["street"]);
$city = htmlspecialchars($_REQUEST["city"]);
$state = htmlspecialchars($_REQUEST["state"]);
$zip = htmlspecialchars($_REQUEST["zip"]);

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
?>
<!DOCTYPE html>
<html>
<head>
<meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
</head>

<body>
<?php 
include('navbar.php');
?>

<h4>Order confirmed</h4><br/>
<table class="table table-dark">
    <tbody>
<?php
$cart_item_num = 0;
		foreach($_SESSION['cart_items'] as $robot){
			echo "<tr><td><img src='".$image_dict[$robot->id]."' /><td>$robot->name</td><td>$robot->description</td><td>Price:<br/>$" . number_format($robot->price, 2) . "</td>";
			$cart_item_num++;
		}
$_SESSION['cart_items'] = Array();
?>
</tbody>
  </table>
<?php
echo "<h5>Your order will be sent to $street</h5><br/>";
echo "<h5>$city, $state $zip</h5>";
?>
</body>
</html>