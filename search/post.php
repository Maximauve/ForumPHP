<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');

$src = $_GET['src'];
$querySearch = "SELECT * FROM article JOIN user ON article.userId = user.userId WHERE article.title LIKE '%" . $src . "%' OR article.content LIKE '%" . $src . "%' ORDER BY publicationDate DESC";
$query = $pdo->prepare($querySearch);
$query->execute();
$posts = $query->fetchAll(mode:PDO::FETCH_ASSOC);

$queryFavorite = "SELECT articleId FROM favorite INNER JOIN user ON user.userId = favorite.userId WHERE username = :username";
$datas = [
	'username'=>$_SESSION['username']
];
$query = $pdo->prepare($queryFavorite);
$query->execute($datas);
$favorites = $query->fetchAll(mode:PDO::FETCH_ASSOC);
$favorites = array_map(function ($favorite) {
    $favorite = $favorite["articleId"];
	return $favorite;
}, $favorites);

?> 
<?php require("../Templates/head.php"); ?>
<body>
<?php require('../Templates/navbar.php'); ?>
<?php

if (count($posts) == 0) { ?>
	<h1> Aucun résultat n'a été trouvé. </h1>
<?php } else { ?> 
	<h1> <?= count($posts) ?> résultats pour "<?=$src?>" </h1> 
	<?php foreach ($posts as $post) { ?>
		<div class="space sp-large" id="<?=$post["id"]?>">
		<div class="post">
			<?php if (in_array($post["id"], $favorites)) { ?>
			<a href="/Favorites/unLike.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img class="heart" src="/Assets/Images/heart2.png" alt="Heart"/></a>
			<?php } else { ?>
			<a href="/Favorites/like.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img class="heart" src="/Assets/Images/heart1.png" alt="Heart"/></a>
			<?php } ?>
			<?php if ($post["picture"]) {?>
			<div>
			<?php } ?>
			<div>
				<a href="/user?id=<?=$post["userId"]?>"><p class="author"><img class="pp-small" src="<?= $post['profilePicture'] ?>"><?= $post["username"] ?></p></a>
				<a href="./Post?id=<?=$post["id"]?>">
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
			<?php if ($post["username"] === $_SESSION["username"]) { ?>
			<form method="POST" action="/post/delete.php">
				<input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
				<button type="submit">Delete</button>
			</form>
			<form method="POST" action="/post/edit.php">
				<input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
				<button type="submit">Edit</button>
			</form>
			<?php } ?>
		</div>
	</div>
<?php }
} ?>