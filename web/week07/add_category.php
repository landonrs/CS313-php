<?php
require("db_connection.php");
$db = connect_to_db();

$category_name = $_POST['new_category'];
$object_name = $_POST['new_object'];

// echo $category_name;
// echo $object_name;

try{
$statement = $db->prepare('INSERT INTO OBJECT_CATEGORIES(CATEGORY_ID, OBJECT_ID) 
							VALUES
							(
							(SELECT CATEGORY_ID FROM CATEGORIES WHERE CATEGORY_NAME = :C_NAME),
							(SELECT OBJECT_ID FROM OBJECTS WHERE OBJECT_NAME = :O_NAME)
							)');
$statement->bindValue(':C_NAME', $category_name, PDO::PARAM_STR);
$statement->bindValue(':O_NAME', $object_name, PDO::PARAM_STR);
$statement->execute();

}catch (PDOException $ex)
		{
		  echo 'Error!: ' . $ex->getMessage();
		  die();
		}
header("Location: object_library.php");

die();
?>