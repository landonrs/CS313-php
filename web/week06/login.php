<?php
session_start();
 
$error = null;
$_SESSION['logged_in'] = false;
$_SESSION['user'] = htmlspecialchars($_POST['user']);
$password = htmlspecialchars($_POST['password']);

if ($_POST["user"] !== null) {
   try{
   require("db_connection.php");
   $db = connect_to_db();
   $statement = $db->prepare('SELECT username from users where password = :password AND username = :user');
   $statement->bindValue(':password', $password, PDO::PARAM_STR);
   $statement->bindValue(':user', $_SESSION['user'], PDO::PARAM_STR);
   $statement->execute();
   if($statement->rowCount() > 0){
	   $_SESSION['logged_in'] = true;
	   echo "redirecting page";
	   header("Location: object_creator.php");
	   die();
   }
   else {
   $_SESSION['user'] = null;
   $error = true;
 }
   } catch(PDOException $ex){
	   echo 'Error!: ' . $ex->getMessage();
	   die();
   }
   
 } 
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
	<div class="card" style="margin-top:50px;width:75%;justify:center;">
	  <div class="card-body">
		<h4 class="card-title" style="font-size:40px;">You must login to the system:</h4>
		<form id="login-form" action="login.php" method="post" enctype="multipart/form-data" >
	  <div class="form-group row">
		<div class="col-lg-4 col-centered">
			<label for="username">Username</label>
			<input type="text" class="form-control" id="username" name="user">
		</div>
	  </div>
	  <div class="form-group">
		<div class="col-lg-4 col-centered">
			<label for="pass">password</label>
			<input type="password" class="form-control" id="pass" name="password">
		</div>
	  </div>
	  <?php 
	  if($error){
		  echo "<h1 style='color:red'>username or password is incorrect</h1>";
	  }
	  ?>
	  <button type="submit" class="btn btn-primary">Login</button>
	</form>
	  </div>
 </body>