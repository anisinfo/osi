<?php
session_start();

require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];


$db = new db();
$db->db_connect();
$db->db_query($rq);
$db->close();


unset($_SESSION['auth']);
$_SESSION['flash']['success']="Maintenant vous êtes déconnecté";
header('Location:index.php');
?>