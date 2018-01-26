<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
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
<div id="navbar-header">
	<h1 class="font-weight-bold" style="font-size:50px">ROBOTS ARE US</h1>
	<a href="cart_view.php"><img id="cart_image" src='cart.png'></a>
	<a class="font-weight-bold cust-font-size" style="font-size:25px;" href="browse.php">BROWSE</a>
	<a class="font-weight-bold cust-font-size" style="font-size:25px;margin-left:20px;" href="cart_view.php">CART</a>
	<a class="font-weight-bold cust-font-size" style="font-size:25px;margin-left:20px;" href="checkout.php">CHECKOUT</a>
</div>
</body>
</html>