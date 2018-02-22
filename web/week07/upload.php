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

$image_url = htmlspecialchars($_POST['fileToUpload']);
if(!isset($_POST['fileToUpload']) || strlen(trim($_POST['fileToUpload'])) == 0){
	// echo 'No name';
	$_SESSION['url_error'] = true;
	header("Location: object_creator.php");
	die();
}

$statement = $db->query('SELECT (last_value + 1) from objects_object_id_seq');
$fileId = $statement->fetch(PDO::FETCH_NUM);

try{
	$statement = $db->prepare('INSERT INTO OBJECTS(OBJECT_NAME, OBJECT_IMAGE) VALUES
							(
							:name,
							:file_name
							)');
	$statement->bindValue(':name', $object_name, PDO::PARAM_STR);
	$statement->bindValue(':file_name', $image_url, PDO::PARAM_STR);
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