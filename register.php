
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
<head><title>Créer un compte - Yforum</title></head>

<?php 
require("./templates/head.php");
?>

<?php
$errorMessage = "";
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $mail = $_POST['mail'];
    
    $queryUser = "SELECT username, mail FROM user WHERE username = :username";
    $datas = [
        'username'=>$username,
    ];
    $query = $pdo->prepare($queryUser);
    $query->execute($datas);
    $users = $query->fetchAll(mode:PDO::FETCH_ASSOC);
    if (!empty($users)) {
        $errorMessage = "Ce nom d'utilisateur est déjà pris.";
    } else if (!empty($users)) {
        $errorMessage = "Cette adresse mail est déjà prise.";
    } else {
        if ($_FILES["picture"]["error"] !== 0) $picture = "./pictures/unknown.png";
        else {
            $file_name = $_FILES['picture']['name'];
            $file_size = $_FILES['picture']['size'];
            $file_tmp = $_FILES['picture']['tmp_name'];
            $extensions = array("jpeg","jpg","png","gif");
            $tmp = explode('.', $file_name);
            $file_ext = end($tmp);
            if(!in_array($file_ext,$extensions) || $file_size > 4000000) {
                $errorMessage = "Votre photo n'est pas conforme !";
                return;
            }
            $upload = move_uploaded_file($file_tmp,"./assets/profile_pictures/".$username . "." . $file_ext);
            if (!$upload) {
                $errorMessage = "Erreur dans le téléchargement de votre photo";
                return;
            }
            $picture = "./assets/profile_pictures/" . $username. "." . $file_ext;
        }
        $password = $_POST['password'];
        $confirm = $_POST['confirmpassword'];
        if ($password !== $confirm) {
            $errorMessage = "Les mots de passe ne correspondent pas.";
        } else {
            $password = password_hash($password, PASSWORD_DEFAULT);
            $queryString  = "INSERT INTO user (username, password, mail, profilePicture ) VALUES (:username, :password, :mail, :picture)";
            $datas = [
                'username'=>$username,
                'password'=>$password,
                'mail'=>$mail,
                'picture'=>$picture
            ];
            $query = $pdo->prepare($queryString);
            $query->execute($datas);
            $_SESSION['mail'] = htmlspecialchars($_POST['mail']);
            $_SESSION['connected'] = true;
            header('Location: /');
            die();
        }
    }
}

?>

<body class="register-page">
	<h1>Yforum : Créer un compte</h1>
	<div class="space  sp-small">
		<div class="text">
			<p>Bienvenue ! Créez un compte pour commencer.</p>
		</div>
    <form action="./register.php" method="post" enctype="multipart/form-data">
			<div class="label">
        <label for="username">
            Nom d'utilisateur* :<br/>
            <input type="text" name="username" placeholder="Example" required autofocus>
        </label>
			</div> 
			<div class="label">
        <label for="mail">
            Adresse mail* :<br/>
            <input type="text" name="mail" placeholder="example@example.com" required>
        </label>
			</div>
			<div class="label">
        <label for="picture">
            Photo de profil :<br/>
            <input type="file" name="picture">
        </label>
			</div>
			<div class="label">
        <label for="password">
            Mot de passe* :<br/>
            <input id='password' type="password" name="password" placeholder="example" onkeyup='check()' required>
        </label>
			</div>
			<div class="label">
        <label for="password">
            Confirmation de mot de passe* :<br/>
            <input id='confirmpassword' type="password" name="confirmpassword" placeholder="example" onkeyup='check()' required>
        </label>
			</div>
        <button type="submit" name="login" id="confirmbtn">Créer un compte</button>
        <br>

        <p id="message"></p>
        <p> <?= $errorMessage ?> </p>
    </form>
	</div>
	<p class="login-other">Vous avez déjà un compte ? <a href="./login.php">Se connecter</a>
	<img src="./assets/images/hero-glow.svg" alt="Glowing lights" class="hero-glow"/>
    <!-- <script type="text/javascript" src="./assets/js/script.js"></script> -->
</body>
</html>