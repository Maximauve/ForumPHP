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
<?php require("./templates/head.php"); ?>

<body>


<?php require('./templates/navbar.php'); ?>

<h1 class="Test">Test CSS</h1>

<script type="text/javascript" src="./assets/js/script.js"></script>
</body>
</html>