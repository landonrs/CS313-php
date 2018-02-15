<?php
require("db_connection.php");
$db = connect_to_db();

$attributes = array();
$object_name = $_POST['object_name'];
$object_category = $_POST['category'];
foreach ($db->query('SELECT ATTRIBUTE_NAME FROM ATTRIBUTES') as $row)
	{
	  $attributes[$row['attribute_name']] = $_POST[$row['attribute_name']];
	  // echo  $attributes[$row['attribute_name']] . '<br>';
	}
$target_dir = "object_images\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$statement = $db->query('SELECT (last_value + 1) from objects_object_id_seq');
$fileId = $statement->fetch(PDO::FETCH_NUM);
//echo $fileId[0];
$newFileName = $target_dir . $object_name . $fileId[0] .'.' . $imageFileType;
// echo $newFileName;
try{
	$statement = $db->prepare('INSERT INTO OBJECTS(OBJECT_NAME, OBJECT_IMAGE) VALUES
							(
							:name,
							:file_name
							)');
	$statement->bindValue(':name', $object_name, PDO::PARAM_STR);
	$statement->bindValue(':file_name', $newFileName, PDO::PARAM_STR);
	$statement->execute();
	foreach ($attributes as $key => $value) {
		echo $key . ': ' . $value .'<br>';
		
		$statement = $db->prepare('INSERT INTO OBJECT_DESCRIPTION(OBJECT_ID, ATTRIBUTE_ID, ATTRIBUTE_VALUE)
									VALUES
									(
									(SELECT last_value from objects_object_id_seq),
									(SELECT ATTRIBUTE_ID FROM ATTRIBUTES WHERE ATTRIBUTE_NAME = :A_NAME),
									:A_VALUE
									)');
		$statement->bindValue(':A_NAME', $key, PDO::PARAM_STR);
		$statement->bindValue(':A_VALUE', $value);
		$statement->execute();
		
		$statement = $db->prepare('INSERT INTO OBJECT_CATEGORIES(OBJECT_ID, CATEGORY_ID)
									VALUES
									(
									(SELECT last_value from objects_object_id_seq),
									(SELECT CATEGORY_ID FROM CATEGORIES WHERE CATEGORY_NAME = :C_NAME)
									)');
		$statement->bindValue(':C_NAME', $object_category, PDO::PARAM_STR);
		$statement->execute();
	}
	
}
catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}



// Check if image file is a actual image or fake image
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        // echo "File is an image - " . $check["mime"] . ".";
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
    }
}

// Check if $uploadOk is set to 0 by an error
if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
// if everything is ok, try to upload file
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newFileName)) {
        echo "The file has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
    }
}
$redirect_name = 'object_details.php?name='.$object_name.'&id='.$fileId[0].'';
header("Location: $redirect_name");

die();
?>