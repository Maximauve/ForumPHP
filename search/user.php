<?php
require '../checkConnection.php';
$dsn="mysql:host=localhost:3306;dbname=forum";
$username='root';
$password='';
try {
	$pdo = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
	die();
}

$src = $_GET['src'];
$querySearch = "SELECT * FROM user WHERE username LIKE '%" . $src . "%'";
$query = $pdo->prepare($querySearch);
$query->execute();
$users = $query->fetchAll(mode:PDO::FETCH_ASSOC);

?> 

<?php require("../templates/head.php"); ?>
<body>
<?php require('../templates/navbar.php'); 
if (count($users) == 0) { ?>
	<h1> Aucun résultat n'a été trouvé. </h1>
<?php } else { ?> 
	<h1> <?= count($users) ?> résultats </h1> 
<?php foreach($users as $user) {?>
	<div class="space sp-large">
  	    <div class="post">
            <p> Username : <?= $user["username"] ?></p>
            Photo de profil <img src="<?= $user["profilePicture"] ?>"/>
            <p> Admin : <?php if ($user["admin"]) { ?> Oui <?php } else { ?> Non </p> <?php } ?>
	    </div>
	</div>
<?php } 
} ?>