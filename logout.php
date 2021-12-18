<?php

session_start();

unset($_SESSION['username']);
unset($_SESSION['connected']);

header('Location: /');
exit();