<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$queryDelete = "DELETE FROM user WHERE userId = :id";
    $datas = [
        'id'=>$_POST["id"],
    ];
    $query = $pdo->prepare($queryDelete);
    $query->execute($datas);
	header('Location: /Admin/user.php');
} else {
	header('Location: /');
}