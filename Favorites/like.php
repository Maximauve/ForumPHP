<?php 
require('../Packages/checkConnection.php');
require('../Packages/database.php');


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
    $queryInsert = "INSERT INTO favorite (userId, articleId) VALUES (:userId, :articleId)";
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