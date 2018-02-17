<?php
session_start();
require("db_connection.php");
$db = connect_to_db();

$attributes = array();
$object_name = strtolower(htmlspecialchars($_POST['object_name']));
if(!isset($_POST['object_name']) || strlen(trim($_POST['object_name'])) == 0){
	// echo 'No name';
	$_SESSION['name_error'] = true;
	header("Location: object_creator.php");
	die();
}
$object_category = strtolower(htmlspecialchars($_POST['category']));
foreach ($db->query('SELECT ATTRIBUTE_NAME FROM ATTRIBUTES') as $row)
	{
		// if the user did not enter a value for any attribute, replace value with unknown
		if(!isset($_POST[$row['attribute_name']]) || strlen(trim($_POST[$row['attribute_name']])) == 0){
			$attributes[$row['attribute_name']] = 'unknown';
		}
		else{
			$attributes[$row['attribute_name']] = strtolower(htmlspecialchars($_POST[$row['attribute_name']]));
		}
	}
if(!file_exists($_FILES['fileToUpload']['tmp_name']) || !is_uploaded_file($_FILES['fileToUpload']['tmp_name'])) {
    // echo 'No upload';
	$_SESSION['upload_error'] = true;
	header("Location: object_creator.php");
	die();
}

$target_dir = "object_images\\";
$target_file = $target_dir . basename($_FILES["fileToUpload"]["name"]);
$uploadOk = 1;
$imageFileType = strtolower(pathinfo($target_file,PATHINFO_EXTENSION));

$statement = $db->query('SELECT (last_value + 1) from objects_object_id_seq');
$fileId = $statement->fetch(PDO::FETCH_NUM);
//echo $fileId[0];
$newFileName = $target_dir . $object_name . $fileId[0] .'.' . $imageFileType;

// Check if image file is a actual image or non image file
if(isset($_POST["submit"])) {
    $check = getimagesize($_FILES["fileToUpload"]["tmp_name"]);
    if($check !== false) {
        $uploadOk = 1;
    } else {
        // echo "File is not an image.";
        $uploadOk = 0;
		$_SESSION['upload_error'] = true;
		header("Location: object_creator.php");
		die();
    }
}


if ($uploadOk == 0) {
    echo "Sorry, your file was not uploaded.";
} else {
    if (move_uploaded_file($_FILES["fileToUpload"]["tmp_name"], $newFileName)) {
        echo "The file has been uploaded.";
    } else {
        echo "Sorry, there was an error uploading your file.";
		$_SESSION['upload_error'] = true;
		header("Location: object_creator.php");
		die();
    }
}

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




$redirect_name = 'object_details.php?name='.$object_name.'&id='.$fileId[0].'';
// set all error messages to false
$_SESSION['name_error'] = false;
$_SESSION['upload_error'] = false;
header("Location: $redirect_name");

die();
?>