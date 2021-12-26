<?php
require('../Packages/checkConnection.php');
require('../Packages/database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['choice'] === 'post') {
        print_r("OUI");
        header("Location: ./post.php?src=" . $_POST["search"]);
        die();
    } else {
        print_r("NON");
        header('Location: ./user.php?src=' . $_POST["search"]);
        die();
    }
} else {
    header('Location: /');
}