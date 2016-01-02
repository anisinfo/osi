<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
			 	 die();
	}
$incident=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
if (!$incident) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	header('Location:index.php');
	die();
}
define('TITLE','Lisete des impactes pour l\'incident :'.$incident);
require_once('../inc/header.inc.php');
require_once('../inc/config.inc.php');
require_once('../classes/db.php');
require_once('../classes/incidents.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
$inci= new incidents();
$inci->chargerIncident($incident);
$imp = new Impact();
$resultats=$imp->chargerIncident($incident);
$appli= new Application();

?>
<h3>Liste d'impactes pour l'incident N°:<?= $inci->getIncident();?></h3>
<br />
<a class="btn btn-success"  href="impact.php?idIncident=<?= $incident;?>">Ajouter un impacte</a>
<br />
<br />
<form action="" method="POST">
<div class="bloc">

<table class="table">
	<thead>
		<th>Date de Début</th>
		<th>Date de Fin</th>
		<th>Application</th>
		<th>Description</th>
		<th>Impact</th>
		<th>Action</th>
	</thead>
	<tbody>
		
		<?php

		for ($i=0 ; $i < count($resultats) ; $i++ ) { 

			$value=$resultats[$i];

			$appli= new Application();
			$appli->SelectAppliById($value[2]);
		
			$ligne='<tr><td>'.$value[3].'</td>';
			$ligne.='<td>'.$value[4].'</td>';
			$ligne.='<td>'.$appli->getName().'</td>';
			$ligne.='<td>'.$value[11].'</td><td>';
			$ligne.=($value[8] !='')?$INCIDENTIMPACTMETIER[$value[8]-1]:'';
			$ligne.='</td><td><a href="modifImpact.php?IdImpact='.$value[0].'">Modifier</a></td></tr>';
			echo $ligne;
		}
		?>
		
	</tbody>
	</table>
</div>
<?php
require_once('../inc/footer.inc.php');
?>