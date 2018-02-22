<?php
require("db_connection.php");
$db = connect_to_db();

try{
	$statement = $db->prepare('SELECT OBJECT_NAME, OBJECT_ID FROM OBJECTS');
	$statement->execute();
	$objects = $statement->fetchAll(PDO::FETCH_ASSOC);
	$csv_list = Array();
	foreach($objects as $object){
		$object_array_list = array($object['object_name']);
		// get the attributes for each object and add them to the list
		$statement = $db->prepare('SELECT ATTRIBUTE_VALUE FROM OBJECT_DESCRIPTION OD JOIN OBJECTS O ON O.OBJECT_ID = OD.OBJECT_ID
									WHERE OD.OBJECT_ID =:object_id');
		$statement->bindValue(':object_id', $object['object_id'], PDO::PARAM_INT);			
		$statement->execute();
		$o_att = $statement->fetchAll(PDO::FETCH_ASSOC);
		foreach($o_att as $attribute){
			array_push($object_array_list, $attribute['attribute_value']);
		}
		// get the categories for each object
		$statement = $db->prepare('SELECT DISTINCT CATEGORY_NAME FROM CATEGORIES C JOIN OBJECT_CATEGORIES OC ON C.CATEGORY_ID = OC.CATEGORY_ID
									JOIN OBJECTS O ON OC.OBJECT_ID = O.OBJECT_ID WHERE O.OBJECT_ID =:object_id');
		$statement->bindValue(':object_id', $object['object_id'], PDO::PARAM_INT);		
		$statement->execute();
		$o_categories = $statement->fetchAll(PDO::FETCH_COLUMN, 0);
		// print_r($o_categories);
		$category_string = '[\'' . implode("','",$o_categories) . '\']';
		array_push($object_array_list, $category_string);
		// push object info into csv_list
		array_push($csv_list, $object_array_list);
	}
	header("Content-type: text/csv");
    header("Content-Disposition: attachment; filename=neo_library.csv");
    header("Pragma: no-cache");
    header("Expires: 0");
	// write the data to the ouput buffer and send it to the user
	$outputBuffer = fopen("php://output", 'w');
	foreach ($csv_list as $object) {
		fputcsv($outputBuffer, $object);
	}
	fclose($outputBuffer);
	
}catch (PDOException $ex)
{
  echo 'Error!: ' . $ex->getMessage();
  die();
}


?>