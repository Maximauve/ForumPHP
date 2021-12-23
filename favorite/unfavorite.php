<?php 
require './../checkConnection.php';
$dsn="mysql:host=localhost:3306;dbname=forum";
$username='root';
$password='';
try {
	$pdo = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
	die();
}


if ($_GET["articleId"]) {
    $id = $_GET["articleId"];
    $username = $_SESSION["username"];
    $queryUser = "SELECT userId FROM user WHERE username = :username";
    $datas = [
        'username'=>$username
    ];
    $query = $pdo->prepare($queryUser);
    $query->execute($datas);
    $user = $query->fetch(mode:PDO::FETCH_ASSOC);
    $queryInsert = "DELETE FROM favorite WHERE userId = :userId AND articleId = :articleId";
    $datas = [
        'userId'=>$user["userId"],
        'articleId'=>$id
    ];
    $query = $pdo->prepare($queryInsert);
    $query->execute($datas);

    header('Location: ' . $_GET["url"] . '#' . $id);
} else {
    header("Location: /");
}