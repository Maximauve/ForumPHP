<?php 
session_start();
$dsn="mysql:host=localhost:3306;dbname=forum";
$username='root';
$password='';
try {
    $pdo = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
    die();
}

?>

<html lang="en">
<head>
	<link rel="stylesheet" type="text/css" href="./assets/style/style.css">
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>

		<link rel="preconnect" href="https://fonts.googleapis.com">
		<link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=VT323&display=swap" rel="stylesheet">
</head>

<?php 
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $queryUser = "SELECT username, password FROM user WHERE username = :username";
    $datas = [
        'username'=>$username,
    ];
    $query = $pdo->prepare($queryUser);
    $query->execute($datas);
    $users = $query->fetchAll(mode:PDO::FETCH_ASSOC);
    if (empty($users)) {
        $errorMessage = "Ce nom d'utilisateur n'existe pas";
    } else {
        $password = $_POST['password'];
        if (!password_verify($password,$users[0]["password"])) {
            $errorMessage = "Ce n'est pas le bon mot de passe !";
        } else {
            $_SESSION['username'] = htmlspecialchars($_POST['username']);
            $_SESSION['connected'] = true;
            header('Location: /');
            die();
        }
    }
}

?>

<body>
	<h1 class="login-title">Yforum</h1>
    <div class="login-space">
			<h2 class="login-subtitle">Connectez vous !</h2>
        <form method="post">
            <label for="username">
                Nom d'utilisateur :
                <input type="text" name="username" placeholder="toto@gmail.com" required autofocus>
            </label>
            <br>
            <label for="password">
                Mot de passe :
                <input type="password" name="password" placeholder="password" required>
            </label>
            <br>
            <button type="submit" name="login">Connexion</button>
        </form>
       <a href="./register.php"><button name="register">   Créer un compte  </button></a>
        <p> <?= $errorMessage ?> </p>
    </div>
	<img src="./assets/images/hero-glow.svg" alt="Glowing lights" class="hero-glow"/>
</body>
</html>