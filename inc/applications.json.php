<?php
// Recharger les fichiers nécissaires pour l'execution de script
require_once('config.inc.php');
require_once('fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Application.php');


$array= array();

$appli= new Application();
$name = isset($_GET['name'])?$_GET['name']:'';
$enseigne = isset($_GET['enseigne'])?$_GET['enseigne']:'';
$irt = isset($_GET['irt'])?$_GET['irt']:'';
$trigramme = isset($_GET['trigramme'])?$_GET['trigramme']:'';
if (!$name  && !$enseigne && !$irt && !$trigramme) {
	$_SESSION['flash']['danger']="Recherche non abouti de l'application. Pas d'information d'application passée!";
	die();
}

$res=$appli->SelectAppliSearch($name,$enseigne,$irt,$trigramme);

if (count($res)) {
	foreach ($res as $value) {
		array_push($array,array("ID" => $value[0],"NAME" => $value[1],"ENSEIGNE" => $value[2],"IRT" => $value[3],"TRIGRAMME" => $value[4]));
	}
}

$json = json_encode($array);
header('Content-Type: application/json');
echo $json;
?>