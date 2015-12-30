<?php
//phpinfo();
// Recharger les fichiers nécissaires pour l'execution de script
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Chronogramme.php');


$res= array();


$chrono= new Chronogramme();
$id = isset($_GET['id'])?$_GET['id']:'';
$date = isset($_GET['date'])?$_GET['date']:'';
$activite = isset($_GET['activite'])?$_GET['activite']:'';
$id_incident = isset($_GET['id_incident'])?$_GET['id_incident']:'';

if (!$id  && !$date && !$activite) {
	$_SESSION['flash']['danger']="Recherche non abouti de l'application. Pas d'information d'application passée!";
	die();
}

$chrono->setParam($id,$id_incident,$date,$activite);
if ($id) {
	$chrono->Modifier($id);
} else $res=$chrono->Creer();


$json = json_encode($res);
header('Content-Type: application/json');
echo $json;
?>