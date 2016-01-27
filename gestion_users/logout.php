<?php
session_start();

require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');

$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];
//Récupération de contenu du fichier Json
$contenu_fichier_json=file_get_contents('../inc/TraceFiche.json');
$tr = json_decode($contenu_fichier_json, true);
foreach ($tr as $key => $value) {
	if ($value['user']==$userConnected) {
		unset($tr[$key]);
	}
}
$json=json_encode($tr);
file_put_contents('../inc/TraceFiche.json', $json);


unset($_SESSION['auth']);
$_SESSION['flash']['success']="Maintenant vous êtes déconnecté";
header('Location:../index.php');
?>