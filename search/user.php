<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');

$src = $_GET['src'];
$querySearch = "SELECT * FROM user WHERE username LIKE '%" . $src . "%'";
$query = $pdo->prepare($querySearch);
$query->execute();
$users = $query->fetchAll(mode:PDO::FETCH_ASSOC);

?> 

<?php require("../Templates/head.php"); ?>
<body>
<?php require('../Templates/navbar.php'); 
if (count($users) == 0) { ?>
	<h1> Aucun résultat n'a été trouvé. </h1>
<?php } else { ?> 
	<h1> <?= count($users) ?> résultats pour "<?=$src?>" </h1> 
<?php foreach($users as $user) {?>
	<div class="space sp-large">
		<div class="post">
			<a href="/user?id=<?=$user["userId"]?>"><p class="author"><img class="pp-medium" src="<?= $user['profilePicture'] ?>"><?= $user["username"] ?></p></a>
			<?php if ($user["admin"]) { ?> 
				<p>Administrateur</p>
			<?php } ?>
		</div>
	</div>
<?php } 
} ?>