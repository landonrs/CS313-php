<?php
session_start();
$prev_page = $_SESSION['prev_page'];

require("db_connection.php");
$db = connect_to_db();



$a_name = $_POST['name'];
$new_attribute = $_POST['new_attribute'];
$object_id = $_POST['id'];

// echo $category_name;
// echo $object_name;

try{
$statement = $db->prepare('UPDATE OBJECT_DESCRIPTION SET ATTRIBUTE_VALUE = :new_attribute 
							where object_id = :id and attribute_id = 
							(SELECT attribute_id from attributes where attribute_name = :name)');
$statement->bindValue(':new_attribute', $new_attribute, PDO::PARAM_STR);
$statement->bindValue(':id', $object_id, PDO::PARAM_INT);
$statement->bindValue(':name', $a_name, PDO::PARAM_STR);
$statement->execute();

}catch (PDOException $ex)
		{
		  echo 'Error!: ' . $ex->getMessage();
		  die();
		}
header("Location: $prev_page");

die();
?>