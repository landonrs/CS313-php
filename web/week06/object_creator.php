<?php
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
    <h4 class="card-title" style="font-size:40px;">Create a new object</h4>
    <form id="object-form" action="upload.php" method="post" enctype="multipart/form-data" >
  <div class="form-group row">
	<div class="col-lg-4 col-centered">
		<label for="object_name">Enter a name for this object</label>
		<input type="text" class="form-control" id="object_title" name="object_name">
	</div>
  </div>
  <div class="form-group">
	<div class="col-lg-4 col-centered">
		<h4>Upload an image for this object</h4>
		<input type="file"  name="fileToUpload" id="fileToUpload"><br>
	</div>
  </div>
  <?php
	foreach ($db->query('SELECT ATTRIBUTE_NAME FROM ATTRIBUTES') as $row)
	{
	  echo '<div class="form-group">';
	  echo '<div class="col-lg-4 col-centered">';
	  echo 'object '. $row['attribute_name'] .': <input type="text" class="form-control" name="'.$row['attribute_name'].'"><br>';
	  echo '</div></div>';
	}
	?>
	<div class="form-group">
	Select the best category for this object:
	<select name="category" form="object-form">
				<?php
				foreach ($db->query('SELECT CATEGORY_NAME FROM CATEGORIES ORDER BY CATEGORY_NAME') as $row)
				{
				  echo '<option value="' . $row['category_name'] . '"> ' . $row['category_name'] . ' </option>';
				}
				?>				
		   </select><br>
		   </div>
	<!-- <div class="form-group">
	<div class="col-lg-4 col-centered">
	or create a new category for this object:
	<input type="text" class="form-control" name="new_category"><br>
	</div>
	</div> -->
  <button type="submit" class="btn btn-primary">Create Object</button>
</form>
  </div>
</div>
</body>
</html>