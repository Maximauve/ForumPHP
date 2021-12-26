<?php 
require('../Packages/checkConnection.php');
require('../Packages/database.php');
require('../Packages/isAdmin.php');

$errorMessage = "";
$userId = $_GET['id'];

if ($userId == "") {
	header("Location: /");
}

$queryUser = "SELECT * FROM user WHERE userId = :id";
$query = $pdo->prepare($queryUser);
$datas = [
	'id' => $userId,
];
$query->execute($datas);
$user = $query->fetch(mode:PDO::FETCH_ASSOC);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$username = $_POST['username'];
	$mail = $_POST['mail'];
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
	$queryUpdate = "UPDATE user SET username = :username, mail = :mail, profilePicture = :profilePicture WHERE userId = :userId";
	$datas = [
		'username'=>$username,
		'mail'=>$mail,
		'profilePicture'=>$picture,
		'userId'=>$userId
	];
	$query = $pdo->prepare($queryUpdate);
	$query->execute($datas);
	header('Location: /Admin/user.php');
	die();
}
?>
<html lang="fr">
<?php require("../Templates/head.php"); ?>

<body class="index-page">

<?php require('../Templates/navbar.php'); ?>



<h1> Edit User <h2>
<form action="/Admin/editUser.php?id=<?=$user['userId']?>" method="post" enctype="multipart/form-data">
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
	
	<input type="text" name="profilePicture" value="<?=$user["profilePicture"]?>" style="display: none;"/>
	<button type="submit" name="edit" id="confirmbtn">Edit</button>
	<br>
	<p> <?= $errorMessage ?> </p>
</form>
</body>
</html>