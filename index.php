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
<?php

$queryArticles = "SELECT * FROM article JOIN user ON user.userId = article.userId ORDER BY publicationDate DESC";
$query = $pdo->prepare($queryArticles);
$query->execute();
$articles = $query->fetchAll(mode:PDO::FETCH_ASSOC);
?>

<?php foreach($articles as $post) {?>
	<div class="posts">
  	<div class="post-card">
  	  <?php if ($post["picture"]) {?>
  	    <div>
  	  <?php } ?>
  	  <div>
			
		<p> <?= $post["username"] ?> </p>
  	  	<p class="post-title"><?=$post["title"]?></p>
  	  	<p class="post-content"><?=$post["content"]?></p>
  	  	<p class="post-date"><?=$post["publicationDate"]?></p>
			<?php if ($post["modified"]) { ?>
		<p> (modifié) </p>
			<?php } ?>
  	  </div>
  	  <?php if ($post["picture"]) {?>
  	  	</div>
  	  		<img class="post-img" src="<?=$post["picture"]?>">
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
		</div>
	</div>
<?php } ?>

<script type="text/javascript" src="./assets/js/script.js"></script>

</body>
</html>