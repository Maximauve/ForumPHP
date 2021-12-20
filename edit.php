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
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST["id"]) {
        $queryDelete = "SELECT * FROM article WHERE id = :id";
        $datas = [
            'id'=>$_POST["id"],
        ];
        $query = $pdo->prepare($queryDelete);
        $query->execute($datas);
        $post = $query->fetch(mode:PDO::FETCH_ASSOC);
    } else {
        $title = $_POST['title'];
        $content = $_POST['content'];
        $articleId = $_POST['articleId'];
        $queryUpdate = "UPDATE article SET title = :title, content = :content WHERE id = :articleId";
        $datas = [
            'title'=>$title,
            'content'=>$content,
            'articleId'=>$articleId
        ];
        $query = $pdo->prepare($queryUpdate);
        $query->execute($datas);
        header('Location: /');
        die();
    }
} else {
	header('Location: /');
}

?>
<html lang="fr">
<?php require("./templates/head.php"); ?>

<body>


<?php require('./templates/navbar.php'); ?>

<h1> INFORMATIONS <h2>

<form action="./edit.php" method="post" enctype="multipart/form-data">
    <label for="title">
        Titre :
        <input type="text" name="title" value="<?= $post["title"] ?>" required autofocus>
    </label>
    <br>
    <label for="content">
        Description :
        <input type="text" name="content" value="<?= $post["title"] ?>" required>
    </label>
    <br>
    <input type="text" name="articleId" value="<?=$post["id"]?>" style="display: none;"/>
    <button type="submit" name="login" id="confirmbtn">Edit</button>
    <br>
    <p> <?= $errorMessage ?> </p>
</form>
</body>
</html>