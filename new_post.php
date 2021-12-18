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
<head>
	<link rel="stylesheet" type="text/css" href="./assets/style/style.css">
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
	<meta http-equiv="X-UA-Compatible" content="ie=edge">
	<link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
	<title>Forum</title>
</head>

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
        $queryId = "SELECT id FROM user WHERE username = :username";
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
                'id'=>$res["id"],
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
                'id'=>$res["id"]
            ];
            $query = $pdo->prepare($queryInsert);
            $query->execute($datas);
            header('Location: /');
            die();
        }
    }
}

?>


<body>

<?php require('./templates/navbar.php'); ?>

<form action="./new_post.php" method="post" enctype="multipart/form-data">
    <label for="title">
        Titre :
        <input type="text" name="title" placeholder="Your title" required autofocus>
    </label>
    <br>
    <label for="content">
        Description :
        <input type="text" name="content" placeholder="your description" required>
    </label>
    <br>
    <label for="picture">
        Photo (non obligatoire) :
        <input type="file" name="picture">
    </label>
    <br>
    <button type="submit" name="login" id="confirmbtn">Post</button>
    <br>
    <p id="message"></p>
    <p> <?= $errorMessage ?> </p>
</form>

<script type="text/javascript" src="./assets/js/script.js"></script>
	<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
	<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>