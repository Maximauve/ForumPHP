<?php 
session_start();
require('../Templates/database.php');
require('../PHPMailer-master/src/Exception.php');
require('../PHPMailer-master/src/PHPMailer.php');
require('../PHPMailer-master/src/SMTP.php');

function randomPassword() {
    $alphabet = 'abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ1234567890';
    $pass = array();
    $alphaLength = strlen($alphabet) - 1;
    for ($i = 0; $i < 8; $i++) {
        $n = rand(0, $alphaLength);
        $pass[] = $alphabet[$n];
    }
    return implode($pass);
}
?>

<html lang="fr">
<head><title>Mot de passe oublié - Yforum</title></head>

<?php 
require("/Templates/head.php");


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
		$newPassword = randomPassword();
		$username = $users['username'];
		$email = $users['mail'];
		$message = "<center><h1>Cher " . $username . ", </h1></center>";
		$message .= "Votre réinitialisation de mot de passe à bien été prise en compte, et nous vous transmettons le nouveau. <br>";
		$message .= "Nous vous conseillons vivement de modifier votre nouveau mot de passe dès votre prochaine connexion afin de ne pas l'oublier. <br>";
		$message .= "Votre nouveau mot de passe: <b>$newPassword</b> <br>";
		$message .= "Nous vous souhaitons de passer un agréable moment sur notre forum. <br>";
		$message .= "Cordialement, <br> L'équipe de YForum";

		$mail = new PHPMailer\PHPMailer\PHPMailer();
		$mail->CharSet="UTF-8";
		$mail->IsSMTP();
		$mail->SMTPAuth = true;
		$mail->SMTPSecure = 'ssl';
		$mail->Host = "smtp.gmail.com";
		$mail->Port = 465;
		$mail->IsHTML(true);
		$mail->Username = "ynov.yforum@gmail.com";
		$mail->Password = "YForum2021";
		$mail->SetFrom("support.yforum@gmail.com", 'Support YForum');
		$mail->Subject = "YForum - Réinitialisation de votre mot de passe";
		$mail->Body = $message;
		$mail->AddAddress($email);

 		if(!$mail->Send()) {
   		echo "Mailer Error: " . $mail->ErrorInfo;
 		} else {
			$queryReset = "UPDATE user SET password = :password WHERE mail = :mail";
			$datas = [
				'password'=>password_hash($newPassword, PASSWORD_DEFAULT),
				'mail' => $email,
			];
			$query = $pdo->prepare($queryReset);
			$query->execute($datas);
		 }
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
		<p class="small"> Vous serez redirigé vers la page de connexion dans 10 secondes... </p>
	<?php
	header('refresh:10;url=login.php');
	}
	?>
</body>
</html>