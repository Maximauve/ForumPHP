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
<head><title>Mot de passe oublié - Yforum</title></head>

<?php 
require("./templates/head.php");


$errorMessage = "";
$done = false;
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$mail = $_POST['mail'];
	$queryUser = "SELECT mail, username FROM user WHERE mail = :mail";
	$datas = [
			'mail'=>$mail,
	];
	$query = $pdo->prepare($queryUser);
	$query->execute($datas);
	$users = $query->fetch(mode:PDO::FETCH_ASSOC);
	if (empty($users)) {
		$errorMessage = "Cet email n'appartient à aucun compte.	";
	} else {
		$done = true;
		$username = $users['username'];
		$mail = $users['mail'];
		$subject = "YForum - Réinitialisation de votre mot de passe";
		$header = "From: <maxime.mourgues@ynov.com>" . "\r\n";
		$message = "Cher" . $username . ", \r\n";
		$message .= "Votre réinitialisation de mot de passe à bien été prise en compte, et nous vous transmettons le nouveau. \r\n";
		$message .= "Nous vous conseillons vivement de modifier votre nouveau mot de passe dès votre prochaine connexion afin de ne pas l'oublier. \r\n";
		$message .= "Votre nouveau mot de passe: ~~insérer mot de passe ici~~ \r\n";
		$message .= "Nous vous souhaitons de passer un agréable moment sur notre Forum. \r\n";
		$message .= "Cordialement, \r\n L'équipe de YForum";

		mail($mail, $subject, $message, $header);
		die();
	} 
}
?>

<body class="login-page">
	<?php if (!$done) { ?>
	<h1>Yforum : Mot de passe oublié</h1>
    <div class="space  sp-small">
        <form method="post">
						<div class="label">
            	<label for="mail">
                Email :<br/>
                <input type="text" name="mail" placeholder="example@example.com" required autofocus>
            	</label>
						</div>
           <button type="submit" name="reset">Réinitialiser le mot de passe</button>
        </form>
        <p> <?= $errorMessage ?> </p>
    </div>
	<img src="./assets/images/hero-glow.svg" alt="Glowing lights" class="hero-glow"/>
	<?php } else { ?>
		<h1>Votre mot de passe à bien été réinitialisé!</h1>
		<p>Vérifiez votre boîte mail afin de prendre connaissance de votre nouveau mot de passe.</p>
		<p class="small"> Vous serez redirigé vers la page de connexion dans 5 secondes... </p>
	<?php
	sleep(10);
	header('Location: /login.php');
	}
	?>
</body>
</html>