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
<head>
	<link rel="stylesheet" type="text/css" href="./assets/style/style.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Forum</title>
</head>

<body>

<?php require('../templates/navbar.php');

$queryUser = "SELECT * FROM article JOIN user ON user.userId = article.userId WHERE user.username = :username";
$datas = [
		'username'=>$_SESSION['username']
];
$query = $pdo->prepare($queryUser);
$query->execute($datas);
$resPosts = $query->fetchAll(PDO::FETCH_ASSOC);


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

<h2> RECUPERATION DES INFORMATIONS </h2>
<form method="POST" action="/profile/edit.php">
	<input type="text" name="id" value="<?=$resPosts[0]["userId"]?>" style="display: none;"/>
	<button type="submit">Edit Profile</button>
</form>
<p> Username : <?= $resPosts["0"]['username'] ?> </p>
<p> Mail : <?= $resPosts["0"]['mail'] ?> </p>
<p> Photo de profil : <img src="<?=$resPosts["0"]["profilePicture"]?>"/> </p>
<p> isAdmin : <?php if ($resPosts["0"]['admin']) echo "Yes"; else echo "No" ?> </p>

<h2> RECUPERATIONS DES POSTS </h2>

<?php foreach($resPosts as $post) {?>
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
				<p class="post-title"><?=$post["title"]?></p>
				<p class="post-content"><?=$post["content"]?></p>
				<p class="post-date"><?=$post["publicationDate"]?></p>
			</div>
			<?php if ($post["picture"]) {?>
				</div>
					<img class="post-img" src="<?=$post["picture"]?>">
			<?php } ?>
		</div>
	</div>
<?php } ?>

</body>
</html>