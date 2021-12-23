<?php 
session_start();
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

$queryUser = "SELECT userId FROM user WHERE username = :username";
$datas = [
    'username'=>$_SESSION["username"]
];
$query = $pdo->prepare($queryUser);
$query->execute($datas);
$user = $query->fetch(mode:PDO::FETCH_ASSOC);

$queryFavorites = "SELECT * FROM article JOIN user ON article.userId = user.userId JOIN favorite ON favorite.articleId = article.id WHERE favorite.userId = :id";
$datas = [
    'id'=>$user["userId"]
];
$query = $pdo->prepare($queryFavorites);
$query->execute($datas);
$favorites = $query->fetchAll(mode:PDO::FETCH_ASSOC);

if (count($favorites) == 0) { ?>
	<h1> Aucun résultat n'a été trouvé. </h1>
<?php } else { ?> 
	<h1> <?= count($favorites) ?> résultats </h1> 

<?php foreach($favorites as $post) {?>
	<!-- <a href="./post?id=<?=$post["id"]?>"> -->
		<div class="space sp-large" id="<?=$post["id"]?>">
  		<div class="post">
			<a href="/favorite/unfavorite.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img src="/assets/images/heart-2.png" alt="Heart"/></a>
  		  <?php if ($post["picture"]) {?>
  		    <div>
  		  <?php } ?>
  		  <div>
					<p class="author">Auteur : <a href="/user?id=<?=$post["userId"]?>"><?= $post["username"] ?></a></p>
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
	<!-- </a> -->
<?php } 
} ?>
