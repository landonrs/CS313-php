<?php
require("db_connection.php");
$db = connect_to_db();

$category_name = strtolower(htmlspecialchars($_POST['category_name']));

$statement = $db->prepare('INSERT INTO CATEGORIES (CATEGORY_NAME) VALUES (:name)');
		$statement->bindValue(':name', $category_name, PDO::PARAM_STR);
		$statement->execute();

header("Location: category_creator.php");

die();
?>