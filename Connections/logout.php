<?php

session_start();

unset($_SESSION['username']);
unset($_SESSION['connected']);

header('Location: /Connections/login.php');
exit();