<?php
require '../checkConnection.php';
$dsn="mysql:host=localhost:3306;dbname=forum";
$username='root';
$password='';
try {
		$pdo = new PDO($dsn, $username, $password);
} catch (PDOException $exception) {
		die();
}
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
		if (isset($_POST['id'])) {
				$id = $_POST['id'];
				$queryUser = "SELECT * FROM user WHERE userId = :id";
				$datas = [
						'id'=>$id
				];
				$query = $pdo->prepare($queryUser);
				$query->execute($datas);
				$user = $query->fetch(mode:PDO::FETCH_ASSOC);
		} else {
				$username = $_POST['username'];
				$mail = $_POST['mail'];
				$userId = $_POST['userId'];
				if ($_FILES["picture"]["error"] !== 0) {
						$pictureName = explode('.', $_POST['profilePicture']);
						rename($_POST['profilePicture'], '../assets/profile_pictures/' . $username . '.' . $pictureName[2]);
						$picture = '../assets/profile_pictures/' . $username . '.' . $pictureName[2];
				} else {
						unlink($_POST['profilePicture']);
						$file_name = $_FILES['picture']['name'];
						$file_size = $_FILES['picture']['size'];
						$file_tmp = $_FILES['picture']['tmp_name'];
						$extensions = array("jpeg","jpg","png","gif");
						$tmp = explode('.', $file_name);
						$file_ext = end($tmp);
						if(!in_array($file_ext,$extensions) || $file_size > 4000000) {
								$errorMessage = "Votre photo n'est pas conforme !";
								header('Location: /');
								die();
						}
						$upload = move_uploaded_file($file_tmp,"../assets/profile_pictures/".$username . "." . $file_ext);
						if (!$upload) {
								$errorMessage = "Erreur dans le téléchargement de votre photo";
								header('Location: /');
								die();
						}
						$picture = "../assets/profile_pictures/" . $username. "." . $file_ext;
				}
				$queryUpdate = "UPDATE user SET username = :username, mail = :mail, profilePicture = :profilePicture WHERE userId = :userId";
				$datas = [
						'username'=>$username,
						'mail'=>$mail,
						'userId'=>$userId,
						'profilePicture'=>$picture
				];
				$query = $pdo->prepare($queryUpdate);
				$query->execute($datas);
				$_SESSION['username'] = htmlspecialchars($_POST['username']);
				$_SESSION['connected'] = true;
				header('Location: ../profile.php');
				die();
		}
} else {
	header('Location: /');
}

?>
<html lang="fr">
<?php require("../templates/head.php"); ?>
<head>
	<link rel="stylesheet" type="text/css" href="../assets/style/style.css">
</head>

<body>


<?php require('../templates/navbar.php'); ?>

<h1> Edit User <h2>
<form action="./edit.php" method="post" enctype="multipart/form-data">
		<label for="username">
				Username :
				<input type="text" name="username" value="<?= $user["username"] ?>" required autofocus>
		</label>
		<br>
		<label for="mail">
				Adresse mail :
				<input type="text" name="mail" value="<?= $user["mail"] ?>" required>
		</label>
		<br>
		Changer le mot de passe : <button><a href="resetPassword.php"> Changer le mot de passe </a></button><br>
		<label for="picture">
				Photo de profil :
				<img src="<?php $user["profilePicture"] ?>">
				<br>
				Changer la photo de profil :
				<input type="file" name="picture">
		</label>
		<input type="text" name="userId" value="<?=$user["userId"]?>" style="display: none;"/>
		<input type="text" name="profilePicture" value="<?=$user["profilePicture"]?>" style="display: none;"/>
		<button type="submit" name="edit" id="confirmbtn">Edit</button>
		<br>
		<p> <?= $errorMessage ?> </p>
</form>
</body>
</html>