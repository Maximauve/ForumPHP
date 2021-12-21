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

$username = $_SESSION["username"];
$queryCheck = "SELECT admin FROM user WHERE username = :username";
$datas = [
    'username'=>$username,
];
$query = $pdo->prepare($queryCheck);
$query->execute($datas);
$check = $query->fetch();
if ($check[0] !== "1") {
    header('Location: /');
}

?>

<html lang="fr">
<head><title>Administration - Yforum</title></head>
<?php 
require("./templates/head.php");
?>

<body>

<?php require('./templates/navbar.php'); ?>

<?php

$queryUsers = "SELECT * FROM user";
$query = $pdo->prepare($queryUsers);
$query->execute();
$users = $query->fetchAll(mode:PDO::FETCH_ASSOC);
?>

<h1> Gestions des users </h1>
<button><a href="./admin_post.php" > Gestions des posts </a></button>
<?php foreach($users as $user) {?>
	<div class="space sp-large">
  	    <div class="post">
            <p> Username  <?= $user["username"] ?></p>
            <p> Adresse mail <?= $user["mail"] ?></p>
            Photo de profil <img src="<?= $user["profilePicture"] ?>"/>
            <p> Admin : <?php if ($user["admin"]) { ?> Oui <?php } else { ?> Non
                <form method="POST" action="./get_admin.php">
                    <input type="text" name="id" value="<?=$user["userId"]?>" style="display: none;"/>
                    <button type="submit">Promouvoir</button>
                </form>
                <?php } ?> </p>
	    </div>
        <form method="POST" action="./delete_user.php">
            <input type="text" name="id" value="<?=$user["userId"]?>" style="display: none;"/>
			<button type="submit">Delete</button>
		</form>
	</div>
<?php } ?>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>