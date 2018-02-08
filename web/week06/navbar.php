<?php

header("Cache-Control: no-store, no-cache, must-revalidate, max-age=0");
header("Cache-Control: post-check=0, pre-check=0", false);
header("Pragma: no-cache");
?>
<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/css/bootstrap.min.css">
  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.12.6/umd/popper.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/4.0.0-beta.2/js/bootstrap.min.js"></script>
  <link rel="stylesheet" href="neo_style.css">
  
</head>
<body>
<a href="neo_main.php"><img id='home_image' src="Neo.png"></a>
<h1 id='home_title'>Neo Trainer 1.0</h1>

<ul class="nav nav-pills nav-fill">
  <li class="nav-item">
    <a class="nav-link active" href="neo_main.php">Project Description</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="object_creator.php">Create Objects for Neo's Environment</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="attribute_creator.php">Teach Neo About Attributes</a>
  </li>
  <li class="nav-item">
    <a class="nav-link active" href="object_library.php">View Object Library</a>
  </li>
</ul>
</body>
</html>