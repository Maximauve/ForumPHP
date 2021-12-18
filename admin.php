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

$username = $_SESSION["username"];
$queryCheck = "SELECT admin FROM user WHERE username = :username";
$datas = [
    'username'=>$username,
];
$query = $pdo->prepare($queryCheck);
$query->execute($datas);
$check = $query->fetch();
if ($check[0] !== "1") {
    header('Location: /');
}

?>

<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="./style/style.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Admin</title>
</head>



<body>
<nav class="navbar navbar-expand-lg navbar-light bg-light">
  <div class="container-fluid">
    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav">
        <li class="nav-item">
          <a class="nav-link" aria-current="page" href="./index.php">Acceuil</a>
        </li>
        <?php
        $username = $_SESSION["username"];
        $queryCheck = "SELECT admin FROM user WHERE username = :username";
        $datas = [
            'username'=>$username,
        ];
        $query = $pdo->prepare($queryCheck);
        $query->execute($datas);
        $check = $query->fetch();
        if ($check[0]) { ?>
            <li class="nav-item">
              <a class="nav-link" href="./admin.php">Admin</a>
            </li>
        <?php } ?>
        <li class="nav-item">
          <a class="nav-link" href="./logout.php">Se déconnecter</a>
        </li>
      </ul>
    </div>
  </div>
</nav>

<script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.10.2/dist/umd/popper.min.js" integrity="sha384-7+zCNj/IqJ95wo16oMtfsKbZ9ccEh31eOz1HGyDuCQ6wgnyJNSYdrPa03rtR1zdB" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.min.js" integrity="sha384-QJHtvGhmr9XOIpI6YVutG+2QOK9T+ZnN4kzFN1RtK3zEFEIsxhlmWl5/YESvpZ13" crossorigin="anonymous"></script>
</body>
</html>