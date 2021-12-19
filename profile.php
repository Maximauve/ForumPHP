
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

$queryUser = "SELECT * FROM user WHERE username = :username";
$datas = [
    'username'=>$_SESSION['username']
];
$query = $pdo->prepare($queryUser);
$query->execute($datas);
$resUser = $query->fetch(PDO::FETCH_ASSOC);
$queryPosts = "SELECT * FROM article WHERE userId = :id";
$datas = [
    'id'=>$resUser['id']
];
$queryP = $pdo->prepare($queryPosts);
$queryP->execute($datas);
$resPosts = $queryP->fetchAll(PDO::FETCH_ASSOC);
?>

<h1> RECUPERATION DES INFORMATIONS </h1>

<p> Username : <?= $resUser['username'] ?> </p>
<p> Mail : <?= $resUser['mail'] ?> </p>
<p> Photo de profil : <img src="<?=$resUser["picture"]?>"/> </p>
<p> isAdmin : <?php if ($resUser['admin']) echo "Yes"; else echo "No" ?> </p>

<h1> RECUPERATIONS DES POSTS </h1>

<?php foreach($resPosts as $post) {?>
	<div class="posts">
  	<div class="card-post">
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
  	  	<div>
  	  		<img src="<?=$post["picture"]?>">
  	  	</div>
  		<?php } ?>
		</div>
	</div>
<?php } ?>

<script type="text/javascript" src="./assets/js/script.js"></script>
</body>
</html>