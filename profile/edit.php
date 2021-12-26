<?php 
require('../Packages/checkConnection.php');
require('../Packages/database.php');



$errorMessage = "";

$queryUser = "SELECT * FROM user WHERE username = :username";
$datas = [
	'username'=>$_SESSION['username'],
];
$query = $pdo->prepare($queryUser);
$query->execute($datas);
$user = $query->fetch(mode:PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if (!password_verify($_POST['password'],$user["password"])) {
		$errorMessage = "Ce n'est pas le bon mot de passe !";
	} else if (($_POST['newPassword'] != "" && $_POST['confirmPassword'] != "") && ($_POST['newPassword'] !== $_POST['confirmPassword'])) {
		$errorMessage = "Les deux nouveaux mot de passe ne correspondent pas!";
	} else {
		if ($_POST['newPassword'] != '') {
			$password = password_hash($_POST['newPassword'], PASSWORD_DEFAULT);
		} else {
			$password = $user["password"];
		}
		$username = $_POST['username'];
		$mail = $_POST['mail'];
		$userId = $_POST['userId'];
		if ($_FILES["picture"]["error"] !== 0) {
			$pictureName = explode('.', $_POST['profilePicture']);
			rename(".." . $_POST['profilePicture'], '../Assets/ProfilePictures/' . $username . '.' . $pictureName[1]);
			$picture = '/Assets/ProfilePictures/' . $username . '.' . $pictureName[1];
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
				die();
			}
			$upload = move_uploaded_file($file_tmp,"../Assets/ProfilePictures/".$username . "." . $file_ext);
			if (!$upload) {
				$errorMessage = "Erreur dans le téléchargement de votre photo";
				die();
			}
			$picture = "/Assets/ProfilePictures/" . $username. "." . $file_ext;
		}
		$queryUpdate = "UPDATE user SET username = :username, mail = :mail, profilePicture = :profilePicture, password = :password WHERE userId = :userId";
		$datas = [
			'username'=>$username,
			'mail'=>$mail,
			'userId'=>$userId,
			'profilePicture'=>$picture,
			'password'=>$password
		];
		$query = $pdo->prepare($queryUpdate);
		$query->execute($datas);
		$_SESSION['username'] = htmlspecialchars($_POST['username']);
		$_SESSION['connected'] = true;
		header('Location: /Profile');
		die();
	}
}
?>
<html lang="fr">
<?php require("../Templates/head.php"); ?>

<body class="index-page">

<?php require('../Templates/navbar.php'); ?>



<h1> Edit User <h2>
<form action="./edit.php" method="post" enctype="multipart/form-data">
	<label for="username">
		Username :
		<input type="text" name="username" value="<?= $user["username"] ?>" required autofocus />
	</label>
	<br>
	<label for="mail">
		Adresse mail :
		<input type="text" name="mail" value="<?= $user["mail"] ?>" required />
	</label>
	<br>
	<label for="picture">
		Photo de profil :
		<img class="profile-picture" src="<?= $user["profilePicture"] ?>" />
		<br>
		Changer la photo de profil :
		<input type="file" name="picture">
	</label>
	<br>
	<label for="newPassword">
		Changer de mot de passe:
		<input type="password" name="newPassword" />
	</label>
	<br>
	<label for="confirmPassword">
		Confirmer le nouveau mot de passe:
		<input type="password" name="confirmPassword" />
	</label>
	<br>
	<label for="password">
		Entrez votre mot de passe pour confirmer les changements:
		<input type="password" name="password" required />
	</label>
	<br>
	<input type="text" name="userId" value="<?=$user["userId"]?>" style="display: none;"/>
	<input type="text" name="profilePicture" value="<?=$user["profilePicture"]?>" style="display: none;"/>
	<button type="submit" name="edit" id="confirmbtn">Edit</button>
	<br>
	<p> <?= $errorMessage ?> </p>
</form>
</body>
</html>