<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	if ($_POST["id"]) {
		$queryDelete = "SELECT * FROM article WHERE id = :id";
		$datas = [
			'id'=>$_POST["id"],
		];
		$query = $pdo->prepare($queryDelete);
		$query->execute($datas);
		$post = $query->fetch(mode:PDO::FETCH_ASSOC);
	} else {
		$title = $_POST['title'];
		$content = $_POST['content'];
		$articleId = $_POST['articleId'];
		$queryUpdate = "UPDATE article SET title = :title, content = :content,modified = :modified WHERE id = :articleId";
		$datas = [
			'title'=>$title,
			'content'=>$content,
			'modified'=>true,
			'articleId'=>$articleId
		];
		$query = $pdo->prepare($queryUpdate);
		$query->execute($datas);
		header("Location: /Post?id=". $articleId);
		die();
	}
} else {
	header('Location: /');
}

?>
<html lang="fr">
<?php require("../Templates/head.php"); ?>

<body>


<?php
echo($id);
require('../Templates/navbar.php'); ?>

<h1> INFORMATIONS </h1>

<form action="./edit.php" method="post" enctype="multipart/form-data">
	<label for="title">
		<p>Titre :</p>
		<input type="text" name="title" value="<?= $post["title"] ?>" required autofocus>
	</label>
	<br>
	<label for="content">
		<p>Description :</p>
		<input type="text" name="content" value="<?= $post["content"] ?>" required>
	</label>
	<br>
	<input type="text" name="articleId" value="<?=$post["id"]?>" style="display: none;"/>
	<button type="submit" name="login" id="confirmbtn">Edit</button>
	<br>
	<p> <?= $errorMessage ?> </p>
</form>
</body>
</html>