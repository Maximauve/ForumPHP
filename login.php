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


<?php 
require("./templates/head.php");
?>
<head><title>Connexion - Yforum</title></head>


<?php
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $mail = $_POST['mail'];
    $queryUser = "SELECT mail,username, password FROM user WHERE mail = :mail";
    $datas = [
        'mail'=>$mail,
    ];
    $query = $pdo->prepare($queryUser);
    $query->execute($datas);
    $users = $query->fetch(mode:PDO::FETCH_ASSOC);
    if (empty($users)) {
        $errorMessage = "Cet email n'existe pas";
    } else {
        $password = $_POST['password'];
        if (!password_verify($password,$users["password"])) {
            $errorMessage = "Ce n'est pas le bon mot de passe !";
        } else {
            $_SESSION['username'] = htmlspecialchars($users["username"]);
            $_SESSION['connected'] = true;
            header('Location: /');
            die();
        }
    }
}

?>

<body class="login-page">
	<h1 class="login-title">Yforum</h1>
    <div class="login-space">
			<div class="text">
				<p>Bienvenue ! Connectez-vous pour commencer.</p>
			</div>
        <form method="post">
						<div class="username">
            	<label for="mail">
                Email :<br/>
                <input type="text" name="mail" placeholder="example@example.com" required autofocus>
            	</label>
						</div>
						<div class="password">
            	<label for="password">
                Mot de passe :<br/>
                <input type="password" name="password" placeholder="example" required>
            	</label>
						</div>
           <button type="submit" name="login">Connexion</button>
        </form>
        <p> <?= $errorMessage ?> </p>
    </div>
		<p class="login-other">Vous n'avez pas de compte ? <a href="./register.php">Créer un compte</a>
	<img src="./assets/images/hero-glow.svg" alt="Glowing lights" class="hero-glow"/>
</body>
</html>