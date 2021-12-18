
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
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register</title>
    <link rel="stylesheet" type="text/css" href="./assets/style/style.css">
</head>

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
            $queryString  = "INSERT INTO user (username, password, mail, picture ) VALUES (:username, :password, :mail, :picture)";
            $datas = [
                'username'=>$username,
                'password'=>$password,
                'mail'=>$mail,
                'picture'=>$picture
            ];
            $query = $pdo->prepare($queryString);
            $query->execute($datas);
            $_SESSION['username'] = htmlspecialchars($_POST['username']);
            $_SESSION['connected'] = true;
            header('Location: /');
            die();
        }
    }
}

?>

<body>
    <form action="./register.php" method="post" enctype="multipart/form-data">
        <label for="username">
            Nom d'utilisateur* :
            <input type="text" name="username" placeholder="Totodu56" required autofocus>
        </label>
        <br>
        <label for="mail">
            Adresse mail* :
            <input type="text" name="mail" placeholder="toto@gmail.com" required>
        </label>
        <br>
        <label for="picture">
            Photo de profil :
            <input type="file" name="picture">
        </label>
        <br>
        <label for="password">
            Mot de passe* :
            <input id='password' type="text" name="password" placeholder="password" onkeyup='check()' required>
        </label>
        <br>
        <label for="password">
            Confirmation de mot de passe* :
            <input id='confirmpassword' type="text" name="confirmpassword" placeholder="confirm password" onkeyup='check()' required>
        </label>
        <br>
        <button type="submit" name="login" id="confirmbtn">Connexion</button>
        <br>

        <p id="message"></p>
        <p> <?= $errorMessage ?> </p>
    </form>
    <a href="./login.php"><button name="login">   Tu as deja un compte ? connecte toi  </button></a>
    <!-- <script type="text/javascript" src="./assets/js/script.js"></script> -->
</body>
</html>