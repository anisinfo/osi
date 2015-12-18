<?php
session_start();
unset($_SESSION['auth']);
$_SESSION['flash']['success']="Maintenant vous êtes déconnecté";
header('Location:index.php');
?>