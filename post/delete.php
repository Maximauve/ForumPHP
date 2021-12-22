<?php
require('../checkConnection.php');
$dsn="mysql:host=localhost:3306;dbname=forum";
$username='root';
$password='';
try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
    die();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$queryDelete = "DELETE FROM article WHERE id = :id";
    $datas = [
        'id'=>$_POST["id"],
    ];
    $query = $pdo->prepare($queryDelete);
    $query->execute($datas);
	header('Location: /');
} else {
	header('Location: /');
}