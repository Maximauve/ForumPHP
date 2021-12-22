<?php 
require('../checkConnection.php');
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
require("../templates/head.php");
?>

<body>

<?php require('../templates/navbar.php'); ?>

<?php

$queryArticles = "SELECT * FROM article JOIN user ON user.userId = article.userId ORDER BY publicationDate DESC";
$query = $pdo->prepare($queryArticles);
$query->execute();
$articles = $query->fetchAll(mode:PDO::FETCH_ASSOC);
?>

<h1> Gestions des posts </h1>
<button><a href="/admin/admin_user.php" > Gestions des users </a></button>
<?php foreach($articles as $post) {?>
	<div class="space sp-large">
  	<div class="post">
  	  <?php if ($post["picture"]) {?>
  	    <div>
  	  <?php } ?>
  	  <div>
				<p class="author">Auteur : <?= $post["username"] ?> </p>
  	  	<p class="title"><?=$post["title"]?></p>
  	  	<p class="content"><?=$post["content"]?></p>
  	  	<p class="date">Date : <?=$post["publicationDate"]?></p>
				<?php if ($post["modified"]) { ?>
					<p> (modifié) </p>
				<?php } ?>
  	  </div>
  	  <?php if ($post["picture"]) {?>
  	  	</div>
  	  		<img class="img" src="<?=$post["picture"]?>">
  		<?php } ?>
		  <form method="POST" action="/post/delete.php">
        <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Delete</button>
		  </form>
      <?php if ($post["username"] === $_SESSION["username"]) { ?>
		  <form method="POST" action="/post/edit.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Edit</button>
		  </form>
		  <?php } ?>
		</div>
	</div>
<?php } ?>

</body>
</html>