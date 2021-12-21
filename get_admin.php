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
	$queryAdmin = "UPDATE user SET admin = :admin WHERE userId = :id";
    $datas = [
        'admin'=>true,
        'id'=>$_POST["id"]
    ];
    $query = $pdo->prepare($queryAdmin);
    $query->execute($datas);
	header('Location: /admin_user.php');
} else {
	header('Location: /');
}