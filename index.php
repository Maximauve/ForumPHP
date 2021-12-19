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
  	  </div>
  	  <?php if ($post["picture"]) {?>
  	  	</div>
  	  		<img class="post-img" src="<?=$post["picture"]?>">
  		<?php } ?>
		  <form method="POST" action="./delete.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button class="delete" type="submit">Delete</button>
		  </form>
		</div>
	</div>
<?php } ?>

<script type="text/javascript" src="./assets/js/script.js"></script>
</body>
</html>