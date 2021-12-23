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
?>
<html lang="fr">
<?php require("../templates/head.php"); ?>

<body class="index-page">

<?php require('../templates/navbar.php'); 


$id = $_GET["id"];
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
<h1> Show </h1>

<div class="space sp-large" id="<?=$post["id"]?>">
  		<div class="post">
		  <?php if (in_array($post["id"], $favorites)) { ?>
			<a href="/favorite/unfavorite.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img src="/assets/images/heart-2.png" alt="Heart"/></a>
		<?php } else { ?>
			<a href="/favorite/favorite.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img src="/assets/images/heart-1.png" alt="Heart"/></a>
		<?php } ?>
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
            <?php } ?>
            <?php if ($post["username"] === $_SESSION["username"]) { ?>
		  <form method="POST" action="/post/edit.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Edit</button>
		  </form>
		  <?php } ?>
		</div>
	</div>

