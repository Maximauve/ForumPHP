<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');
require('../Packages/isAdmin.php');


$errorMessage = "";

$postId = $_GET['id'];

if ($postId == "") {
	header("Location: /");
}

$queryDelete = "SELECT * FROM article WHERE id = :id";
$datas = [
	'id'=>$postId,
];
$query = $pdo->prepare($queryDelete);
$query->execute($datas);
$post = $query->fetch(mode:PDO::FETCH_ASSOC);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	$title = $_POST['title'];
	$content = $_POST['content'];
	$queryUpdate = "UPDATE article SET title = :title, content = :content,modified = :modified WHERE id = :postId";
	$datas = [
		'title'=>$title,
		'content'=>$content,
		'modified'=>true,
		'postId'=>$postId
	];
	$query = $pdo->prepare($queryUpdate);
	$query->execute($datas);
	header("Location: /Post?id=". $postId);
	die();
}

?>
<html lang="fr">
<?php require("../Templates/head.php"); ?>

<body>


<?php
echo($id);
require('../Templates/navbar.php'); ?>

<h1> INFORMATIONS </h1>

<form action="/Admin/editPost.php?id=<?=$post['id']?>" method="post" enctype="multipart/form-data">
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
	<button type="submit" name="login" id="confirmbtn">Edit</button>
	<br>
	<p> <?= $errorMessage ?> </p>
</form>
</body>
</html>