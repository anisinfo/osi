<?php
// Recharger les fichiers nécissaires pour l'execution de script
require_once('config.inc.php');
require_once('fonctions.inc.php');
require_once('../classes/db.php');
require_once('../gestion_osi/inc/fonctions.inc.php');


$array= array();

$td1=$_GET['td1'];
$td2=$_GET['td2'];

if (!isset($_GET['idappli'])) {
# code.calcul incident
$res= dateDiff($td1,$td2);
}else
{
# code.calcul impact
$db = new db();
$db->db_connect();
$dbcnx=$db->connection;


$obj = new DateTime();

$dateDeb=$obj::createFromFormat('d/m/Y G:i',$td1);
$dateFin=$obj::createFromFormat('d/m/Y G:i',$td2);
$res= calc_impact($dateDeb->format('Y-m-d H:i:00'), $dateFin->format('Y-m-d H:i:59'), $_GET['idappli'], $dbcnx);
}

$json = json_encode($res);
header('Content-Type: application/json');

echo $json;
?>