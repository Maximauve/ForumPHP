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

<?php require('../Templates/navbar.php'); ?>

<?php

$queryArticles = "SELECT * FROM article JOIN user ON user.userId = article.userId ORDER BY publicationDate DESC";
$query = $pdo->prepare($queryArticles);
$query->execute();
$articles = $query->fetchAll(mode:PDO::FETCH_ASSOC);
?>

<h1> Gestions des posts </h1>
<button><a href="/Admin/user.php" > Gestions des users </a></button>
<?php foreach($articles as $post) {?>
	<div class="space sp-large" id="<?=$post["id"]?>">
		<div class="post">
			<?php if ($post["picture"]) {?>
			<div>
			<?php } ?>
			<div>
				<a href="/user?id=<?=$post["userId"]?>"><p class="author"><img class="pp-small" src="<?= $post['profilePicture'] ?>"><?= $post["username"] ?></p></a>
				<a href="/Post?id=<?=$post["id"]?>">
				<p class="title"><?=$post["title"]?></p>
				<p class="content"><?=$post["content"]?></p>
				<p class="date">Date : <?=$post["publicationDate"]?></p>
				<?php if ($post["modified"]) { ?>
					<p> (modifié) </p>
					<?php } ?>
				</a>
			</div>
			<?php if ($post["picture"]) {?>
				</div>
					<img class="post-img" src="<?=$post["picture"]?>">
			<?php } ?>
			<form method="POST" action="/post/delete.php">
				<input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
				<button type="submit">Delete</button>
			</form>
			<a href="/Admin/editPost.php?id=<?=$post["id"]?>"><button type="button">Edit</button></a>
		</div>
	</div>
<?php } ?>

</body>
</html>