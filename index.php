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

<body class="index-page">


<?php require('./templates/navbar.php'); ?>
<h1>Yforum</h1>

<?php
phpinfo();

$queryArticles = "SELECT * FROM article JOIN user ON user.userId = article.userId ORDER BY publicationDate DESC";
$query = $pdo->prepare($queryArticles);
$query->execute();
$articles = $query->fetchAll(mode:PDO::FETCH_ASSOC);
?>

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
		  <?php if ($post["username"] === $_SESSION["username"]) { ?>
		  <form method="POST" action="./delete.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Delete</button>
		  </form>
		  <form method="POST" action="./edit.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Edit</button>
		  </form>
		  <?php } ?>
		  <form method="POST" action="./show.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Show</button>
		  </form>
		</div>
	</div>
<?php } ?>
<script type="text/javascript" src="./assets/js/script.js"></script>

</body>
</html>