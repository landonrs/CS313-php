<!DOCTYPE html>
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

<?php 
include('navbar.php');
?>

 <div class="card" style="margin-top:50px;width:90%;justify:center;">
  <div class="card-body">
    <h4 class="card-title" style="font-size:40px;">What is the NEO project?</h4>
    <p class="card-text" style="font-size:25px;text-align:justify;">The NEO project is an attempt to simulate how people learn from experience with objects in the real world
	and how we can replicate that understanding within machines.
	It involves a simulated 2D environment in which an A.I. agent interacts with objects and stores information about those objects in a relational database.
	The goal of the project is to be able to query NEO about the objects using natural language and having Neo successfully classify objects based on their attributes.
	</p>
	<h4 class="card-title" style="font-size:40px;">How to use this website</h4>
	<p class="card-text" style="font-size:25px;text-align:justify;">This site can be used to create objects to insert into NEO's environment. 
	It can also be used to add information about the attributes of objects(density, height, color, etc.) so the objects we create can have more detail for NEO
	to make connections with. Finally you can view the list of objects that have already been added to the database and view the details of each object.
	</p>
    <a href="https://github.com/sai-byui/NEO2D" class="btn btn-primary">See Neo's repository on GitHub</a>
  </div>
</div>

</body>
</html>