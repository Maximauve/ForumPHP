<?php 
require('../Packages/checkConnection.php');
require('../Packages/database.php');

?>
<html lang="fr">
<?php require("../Templates/head.php"); ?>

<body>


<?php require('../Templates/navbar.php');

$userId = $_GET['id'];
$queryUser = "SELECT * FROM user WHERE userId = :id";
$datas = [
	'id'=>$userId
];
$query = $pdo->prepare($queryUser);
$query->execute($datas);
$user = $query->fetch(PDO::FETCH_ASSOC);

$queryPosts = "SELECT * FROM article WHERE userId = :id";
$datas = [
	'id'=>$userId
];
$query = $pdo->prepare($queryPosts);
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

<h1> PROFIL DE <?= $user['username'] ?> </h1>
<div class="profile-infos">
	<img class="profile-picture" src="<?=$user["profilePicture"]?>"/>
	<?php if ($user['admin']) {?>
		<p> Administrateur </p>
	<?php } ?>
</div>

<h1> PUBLICATIONS </h1>

<?php foreach($resPosts as $post) {?>
	<div class="space sp-large" id="<?=$post["id"]?>">
  		<div class="post">
		  <?php if (in_array($post["id"], $favorites)) { ?>
			<a href="./Favorites/unLike.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img class="heart" src="/Assets/Images/heart2.png" alt="Heart"/></a>
		<?php } else { ?>
			<a href="./Favorites/like.php?articleId=<?=$post["id"]?>&url=<?=$_SERVER["REQUEST_URI"]?>"><img class="heart" src="/Assets/Images/heart1.png" alt="Heart"/></a>
		<?php } ?>
			<?php if ($post["picture"]) {?>
				<div>
			<?php } ?>
			<a href="./Post?id=<?=$post["id"]?>">
			<div>
				<p class="title"><?=$post["title"]?></p>
				<p class="content"><?=$post["content"]?></p>
				<p class="date"><?=$post["publicationDate"]?></p>
				<?php if ($post["modified"]) { ?>
					<p> (modifié) </p>
				<?php } ?>
			</div>
			</a>
			<?php if ($post["picture"]) {?>
				</div>
					<img class="post-img" src="<?=$post["picture"]?>">
			<?php } ?>
		</div>
	</div>
<?php } ?>

</body>
</html>