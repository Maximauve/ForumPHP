<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$queryAdmin = "UPDATE user SET admin = :admin WHERE userId = :id";
    $datas = [
        'admin'=>true,
        'id'=>$_POST["id"]
    ];
    $query = $pdo->prepare($queryAdmin);
    $query->execute($datas);
	header('Location: /Admin/user.php');
} else {
	header('Location: /');
}