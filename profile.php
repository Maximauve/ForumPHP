
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
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>Forum</title>
</head>

<body>

<?php require('./templates/navbar.php'); ?>

<?php

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
    <div class="card mb-3">
    <div class="row g-0">
        <?php if ($post["picture"]) {?>
            <div class="col-md-6">
        <?php } ?>
            <div class="card-body">
            <h5 class="card-title"><?=$post["title"]?></h5>
                <p class="card-text"><?=$post["content"]?></p>
                <p class="card-text"><small class="text-muted"><?=$post["publicationDate"]?></small></p>
            </div>
        <?php if ($post["picture"]) {?>
            </div>
            <div class="col-md-6">
                <img src="<?=$post["picture"]?>" class="card-img-rigth"">
            </div>
        <?php } ?>
    </div>
</div>
    <?php } ?>

<script type="text/javascript" src="./assets/js/script.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>