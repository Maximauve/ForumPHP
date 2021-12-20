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

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$queryDelete = "SELECT * FROM article WHERE id = :id";
    $datas = [
        'id'=>$_POST["id"],
    ];
    $query = $pdo->prepare($queryDelete);
    $query->execute($datas);
    $post = $query->fetch(mode:PDO::FETCH_ASSOC);
    
} else {
	header('Location: /');
}

?>

<h1> INFORMATIONS <h2>

<form action="./new_post.php" method="post" enctype="multipart/form-data">
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
    <button type="submit" name="login" id="confirmbtn">Edit</button>
    <br>
    <p> <?= $errorMessage ?> </p>
</form>