<?php 
require './checkConnection.php';
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
<?php require("./templates/head.php"); ?>

<body class="index-page">


<?php require('./templates/navbar.php'); ?>

<?php 
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $queryShow = "SELECT * FROM article JOIN user ON user.userId = article.userId WHERE article.id = :id";
    $datas = [
        'id'=>$_POST["id"],
    ];
    $query = $pdo->prepare($queryShow);
    $query->execute($datas);
    $post = $query->fetch(mode:PDO::FETCH_ASSOC);
    $queryUser = "SELECT admin FROM user WHERE username = :username";
    $datas = [
        'username'=>$_SESSION["username"]
    ];
    $query2 = $pdo->prepare($queryUser);
    $query2->execute($datas);
    $user = $query2->fetch(mode:PDO::FETCH_ASSOC);
} else {
	header('Location: /');
}

?>
<h1> Show </h1>
<div class="space sp-large">
  	<div class="post">
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
		  <?php if ($post["username"] === $_SESSION["username"] || $user["admin"]) { ?>
            <form method="POST" action="./delete.php">
                <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
                <button type="submit">Delete</button>
            </form>
            <?php } ?>
            <?php if ($post["username"] === $_SESSION["username"]) { ?>
		  <form method="POST" action="./edit.php">
			  <input type="text" name="id" value="<?=$post["id"]?>" style="display: none;"/>
			  <button type="submit">Edit</button>
		  </form>
		  <?php } ?>
		</div>
	</div>
