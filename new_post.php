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
<head><title>Nouveau post - Yforum</title></head>

<?php require("./templates/head.php"); ?>

<?php
// SELECT * FROM `article` ORDER BY id DESC LIMIT 1
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $title = $_POST['title'];
    $content = $_POST['content'];
    $publicationDate = date("Y-m-d H:i:s");
    if (!isset($title) || !isset($content)) {
        $errorMessage = "Les champs sont incomplets";
    } else {
        $username = $_SESSION['username'];
        $queryId = "SELECT userId FROM user WHERE username = :username";
        $datas = [
            'username'=>$username
        ];
        $query = $pdo->prepare($queryId);
        $query->execute($datas);
        $res = $query->fetch(PDO::FETCH_ASSOC);
        if ($_FILES["picture"]["error"] === 0) {
            $queryId = "SELECT id FROM `article` ORDER BY id DESC LIMIT 1";
            $query = $pdo->prepare($queryId);
            $query->execute();
            $postId = $query->fetch(PDO::FETCH_ASSOC);
            $file_name = $_FILES['picture']['name'];
            $file_size = $_FILES['picture']['size'];
            $file_tmp = $_FILES['picture']['tmp_name'];
            $extensions = array("jpeg","jpg","png","gif");
            $tmp = explode('.', $file_name);
            $file_ext = end($tmp);
            if(!in_array($file_ext,$extensions) || $file_size > 4000000) {
                $errorMessage = "Votre photo n'est pas conforme !";
                return;
            }
            $upload = move_uploaded_file($file_tmp,"./assets/post_pictures/".$postId["id"]+1 . "." . $file_ext);
            if (!$upload) {
                $errorMessage = "Erreur dans le téléchargement de votre photo";
                return;
            }
            $picture = "./assets/post_pictures/" . $postId["id"]+1 . "." . $file_ext;
            $queryInsert  = "INSERT INTO article (title,content,publicationDate,userId,picture) VALUES (:title, :content, :publicationDate,:id,:picture)";
            $datas = [
                'title'=>$title,
                'content'=>$content,
                'publicationDate'=>$publicationDate,
                'id'=>$res["userId"],
                'picture'=>$picture
            ];
            $query = $pdo->prepare($queryInsert);
            $query->execute($datas);
            header('Location: /');
            die();
        } else {
            $queryInsert  = "INSERT INTO article (title,content,publicationDate,userId) VALUES (:title, :content, :publicationDate,:id)";
            $datas = [
                'title'=>$title,
                'content'=>$content,
                'publicationDate'=>$publicationDate,
                'id'=>$res["userId"]
            ];
            $query = $pdo->prepare($queryInsert);
            $query->execute($datas);
            header('Location: /');
            die();
        }
    }
}

?>


<body class="newpost-page">

<?php require('./templates/navbar.php'); ?>
<h1>Yforum : Nouveau post</h1>
<div class="space sp-small">
	<div class="text">
		<p>De quoi voulez-vous parler ?</p>
	</div>
	<form action="./new_post.php" method="post" enctype="multipart/form-data">
		<div class="label">
    	<label for="title">
        Titre :<br />
        <input type="text" name="title" placeholder="Your title" required autofocus>
    	</label>
		</div>
    <div class="label">
    	<label for="content">
        Description :<br />
        <input type="text" name="content" placeholder="your description" required>
    	</label>
		</div>	
    <div class="label">
    	<label for="picture">
        Photo (facultatif) :<br />
        <input type="file" name="picture">
    	</label>
		</div>
    <button type="submit" name="login" id="confirmbtn">Post</button>
    <br>
    <p id="message"></p>
    <p> <?= $errorMessage ?> </p>
</form>
</div>

<script type="text/javascript" src="./assets/js/script.js"></script>
</body>
</html>