<?php 
require './checkConnection.php';
$dsn="mysql:host=localhost:3306;dbname=forum";
$username='root';
$password='';
try {
	$pdo = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
	die();
}

?>
<html lang="fr">
<head>
	<link rel="stylesheet" type="text/css" href="./assets/style/style.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Forum</title>
</head>

<body>


<?php require('./templates/navbar.php'); ?>

<h1 class="Test">Test CSS</h1>

<script type="text/javascript" src="./assets/js/script.js"></script>
</body>
</html>