<?php
session_start();
$_SESSION = [];       // kosongkan data sesi
session_destroy();    // hancurkan sesi di server
header('Location: login.php');
exit;