<?php
session_start(); 
if ($_SESSION['logged_in'] == true) {
   // logged in
 } else {
   $_SESSION['user'] = null;
   $_SESSION['prev_page'] = 'category_creator.php';
   header("Location: login.php");
 }
require("db_connection.php");
$db = connect_to_db();


?>
<html>
<head>
<link rel="stylesheet" href="neo_style.css">
</head>
<body>
<?php
include('navbar.php');
?>
<div class="card" style="margin-top:50px;width:75%;justify:center;">
  <div class="card-body">
    <h4 class="card-title" style="font-size:40px;">Create a new category of objects</h4>
    <form id="object-form" action="category.php" method="post" enctype="multipart/form-data" >
		<div class="form-group">
		View existing categories:
		<select name="category" form="object-form">
					<?php
					foreach ($db->query('SELECT CATEGORY_NAME FROM CATEGORIES ORDER BY CATEGORY_NAME') as $row)
					{
					  echo '<option value="' . $row['category_name'] . '"> ' . $row['category_name'] . ' </option>';
					}
					?>				
			   </select><br>
			   </div>
	    <div class="form-group row">
			<div class="col-lg-4 col-centered">
				<label for="object_name">Enter a name for the new category</label>
				<input type="text" class="form-control" id="category_title" name="category_name">
			</div>
	    </div>
	
	<!-- <div class="form-group">
	<div class="col-lg-4 col-centered">
	or create a new category for this object:
	<input type="text" class="form-control" name="new_category"><br>
	</div>
	</div> -->
  <button type="submit" class="btn btn-primary">Add category</button>
</form>
  </div>
</div>
</body>
</html>