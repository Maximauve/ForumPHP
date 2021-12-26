<?php

session_start();

if (!isset($_SESSION['connected']) || !$_SESSION['connected'] || $_SESSION['username'] == "") {
    header('Location: /Connections/login.php');
    exit();
}
