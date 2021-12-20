
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

<?php require('./templates/navbar.php');

$queryUser = "SELECT * FROM article JOIN user ON user.userId = article.userId WHERE user.username = :username";
$datas = [
    'username'=>$_SESSION['username']
];
$query = $pdo->prepare($queryUser);
$query->execute($datas);
$resPosts = $query->fetchAll(PDO::FETCH_ASSOC);
?>

<h2> RECUPERATION DES INFORMATIONS </h2>

<p> Username : <?= $resPosts['username'] ?> </p>
<p> Mail : <?= $resPosts['mail'] ?> </p>
<p> Photo de profil : <img src="<?=$resPosts["picture"]?>"/> </p>
<p> isAdmin : <?php if ($resPosts['admin']) echo "Yes"; else echo "No" ?> </p>

<h2> RECUPERATIONS DES POSTS </h2>

<?php foreach($resPosts as $post) {?>
	<div class="posts">
  	<div class="post-card">
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

<script type="text/javascript" src="./assets/js/script.js"></script>
</body>
</html>