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

<body class="login-page">
	<h1 class="login-title">Yforum</h1>
    <div class="login-space">
			<div class="text">
				<p>Bienvenue ! Connectez-vous pour commencer.</p>
			</div>
        <form method="post">
						<div class="username">
            	<label for="username">
                Nom d'utilisateur :<br/>
                <input type="text" name="username" placeholder="example@example.com" required autofocus>
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