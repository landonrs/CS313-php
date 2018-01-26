<?php
session_start();

?>
<!DOCTYPE html>
<html lang='en'>
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

Please enter the following Information:<br/>
<table class="table table-dark table-striped">
    <thead>
      <tr>
        <th>Street Address</th>
        <th>City</th>
        <th>State</th>
        <th>Zip</th>
      </tr>
    </thead>
    <tbody>
      <form action="confirmation.php" method="post">
		<tr>
		
			<td><input type="text" name="street"></td>
			<td><input type="text" name="city"></td>
			<td><input type="text" name="state"></td>
			<td><input type="text" name="zip"></td>
		</tr>
		
		
      
    </tbody>
</table>
		<input class="btn btn-primary" type="submit" value="Place Order">
	</form><br/>
<form action="cart_view.php">
    <input class="btn btn-primary" style="margin-top:10px;" type="submit" value="return to cart" />
</form>
</body>
</html>