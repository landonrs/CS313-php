<html>

<?php
 $continent_dict = Array('na' => 'North America', 'sa' => 'South America', 'eu' => 'Europe', 'as' => 'Asia', 'af' => 'Africa', 'au' => 'Australia', 'an' => 'Antartica');

 echo 'Hey ' . $_POST['name'] . '<br>';
 echo 'Mail to: <a href="mailto:'. $_POST['email'] . '">' . $_POST['email'] . '</a><br>';
 echo $_POST['major'] . '<br>';
 echo $_POST['comment'] . '<br>';
if(!empty($_POST['continent'])) {
    foreach($_POST['continent'] as $continent) {
            echo $continent_dict[$continent] . '<br>';
	}
}

?>

</html>