<!DOCTYPEHTML>
<html>
<head>
<?php
$radio_buttons = Array('CS' => 'Computer Science', 'SE' => 'Software Engineering', 'CE' => 'Computer Engineering', 'CIT' => 'Computer Info Tech');
?>
</head>
<form action="https://stark-sierra-64908.herokuapp.com/TA03/response.php" method="post" id="majorform">
  Name: <input name="name" type="text"><br>
  Email: <input name="email" type="text"><br>
  Major:<br>
<?php foreach($radio_buttons as $key => $value) {
            echo "<input checked name='major' value=\"$value\" type='radio'>$value<br>";
	} ?>

Continents that you have visited:<br>  
<input name="continent[]" value="na" type="checkbox">North America<br>
<input name="continent[]" value="sa" type="checkbox">South America<br>
<input name="continent[]" value="eu" type="checkbox">Europe<br>
<input name="continent[]" value="as" type="checkbox">Asia<br>
<input name="continent[]" value="au" type="checkbox">Australia<br>
<input name="continent[]" value="af" type="checkbox">Africa<br>
<input name="continent[]" value="an" type="checkbox">Antartica<br>
  <textarea name="comment" form="majorform"></textarea>


  <input type="submit">Click here</button>
</form>
</html>