<?php
// Recharger les fichiers nécissaires pour l'execution de script
require_once('config.inc.php');
require_once('fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Application.php');
require_once('../classes/Calendrier.php');




$appli= new Application();
$name = isset($_GET['name'])?$_GET['name']:'';
$enseigne = isset($_GET['enseigne'])?$_GET['enseigne']:'';
$irt = isset($_GET['irt'])?$_GET['irt']:'';
$trigramme = isset($_GET['trigramme'])?$_GET['trigramme']:'';
if (!$name  && !$enseigne && !$irt && !$trigramme) {
	$_SESSION['flash']['danger']="Recherche non abouti de l'application. Pas d'information d'application passée!";
	die();
}
$array= array();
$res=$appli->SelectAppliSearch($name,$enseigne,$irt,$trigramme);
$cal= new Calendrier();
//debug($res);
if (count($res)) {
	for ($i=0;$i<count($res);$i++)
	{
		$value=$res[$i];
		$cal->selectById($value[0]);
		if ($cal->getId()) {
			$tcal=array(
				'JFO' => $cal->getJourFerierOuvert(),'JFF'=> $cal->getJourFerierFermer(),
				'LO' => $cal->getLundiOuvert(),'LF'=> $cal->getLundiFermer(),
				'MAO' => $cal->getMardiOuvert(),'MAF'=> $cal->getMardiFermer(),
				'MEO' => $cal->getMercrediOuvert(),'MEF'=> $cal->getMercrediFermer(),
				'JO' => $cal->getJeudiOuvert(),'JF'=> $cal->getJeudiFermer(),
				'VO' => $cal->getVendrediOuvert(),'VF'=> $cal->getVendrediFermer(),
				'SO' => $cal->getSamediOuvert(),'SF'=> $cal->getSamediFermer(),
				'DO' => $cal->getDimancheOuvert(),'DF'=> $cal->getDimancheFermer()
				);
		}else  $tcal='';

		array_push($array,array("ID" => $value[0],"NAME" => $value[1],"ENSEIGNE" => $value[2],"IRT" => $value[3],"TRIGRAMME" => $value[4],"CAL" =>$tcal));
	}
}

$json = json_encode($array);
header('Content-Type: application/json');
echo $json;
//debug($array);
?>