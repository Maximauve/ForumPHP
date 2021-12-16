<?php

session_start();

if (!isset($_SESSION['connected']) || !$_SESSION['connected']) {
    header('Location: ./login.php');
    exit();
}
