<?php 
require('../Packages/checkConnection.php');
require('../Packages/database.php');
require('../Packages/isAdmin.php');

?>

<html lang="fr">
<head><title>Administration - Yforum</title></head>
<?php 
require("../Templates/head.php");
?>

<body>

<?php require('../Templates/navbar.php'); 

$queryUsers = "SELECT * FROM user";
$query = $pdo->prepare($queryUsers);
$query->execute();
$users = $query->fetchAll(mode:PDO::FETCH_ASSOC);
?>

<h1> Gestions des users </h1>
<button><a href="/Admin/post.php" > Gestions des posts </a></button>
<?php foreach($users as $user) {?>
	<div class="space sp-large">
		<div class="post">
			<a href="/user?id=<?=$user["userId"]?>"><p class="author"><img class="pp-medium" src="<?= $user['profilePicture'] ?>"><?= $user["username"] ?></p></a>
			<p> Adresse mail : <?= $user["mail"] ?></p>
			<p> Admin : <?php if ($user["admin"]) { ?> Oui <?php } else { ?> Non
				<form method="POST" action="/admin/get_admin.php">
					<input type="text" name="id" value="<?=$user["userId"]?>" style="display: none;"/>
					<button type="submit">Promouvoir</button>
				</form>
			<?php } ?> </p>
		</div>
		<a href="/Admin/editUser.php?id=<?=$user['userId']?>"><button type="button">Edit</button></a>
		<form method="POST" action="/Admin/deleteUser.php">
			<input type="text" name="id" value="<?=$user["userId"]?>" style="display: none;"/>
			<button type="submit">Delete</button>
		</form>
	</div>
<?php } ?>

</body>
</html>