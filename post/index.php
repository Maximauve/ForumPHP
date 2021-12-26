<?php 
require('../Packages/checkConnection.php');
require('../Packages/database.php');
?>
<html lang="fr">
<?php require("../Templates/head.php"); ?>

<body class="index-page">

<?php require('../Templates/navbar.php'); 


$id = $_GET["id"];
if ($id == null) {
	header("Location: /");
}
$queryShow = "SELECT * FROM article INNER JOIN user ON user.userId = article.userId WHERE id = :id";
$datas = [
	'id'=>$id
];
$query = $pdo->prepare($queryShow);
$query->execute($datas);
$post = $query->fetch(mode:PDO::FETCH_ASSOC);

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
<br>
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
		<a href="/user?id=<?=$post["userId"]?>"><p class="author"><img class="pp-small" src="<?= $post['profilePicture'] ?>"><?= $post["username"] ?> </p></a>
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
            <?php } ?>
            <?php if ($post["username"] === $_SESSION["username"]) { ?>
		  <form method="POST" action="/post/edit.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Edit</button>
		  </form>
		  <?php } ?>
		</div>
	</div>

