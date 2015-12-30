<?php
session_start();
$incident=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
if (!$incident) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	echo $incident;
	header('Location:index.php');
	die();
}
define('TITLE','Lisete des impactes pour l\'incident :'.$incident);
require_once('../inc/header.inc.php');
require_once('../inc/config.inc.php');
require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
$imp = new Impact();
$resultats=$imp->chargerIncident($incident);
$appli= new Application();

?>
<h1>Liste d'impactes</h1>

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
		<tr>
		<?php

		for ($i=0 ; $i < count($resultats) ; $i++ ) { 

			$value=$resultats[$i];
			echo $value[8].'ppp';
			$appli= new Application();
			$appli->SelectAppliById($value[2]);
		
			$ligne='<td>'.$value[3].'</td>';
			$ligne.='<td>'.$value[4].'</td>';
			$ligne.='<td>'.$appli->getName().'</td>';
			$ligne.='<td>'.$value[11].'</td>';
			$ligne.='<td>'.$INCIDENTIMPACTMETIER[$value[8]-1].'</td>';
			$ligne.='<td><a href="modifImpact.php?IdImpact='.$value[0].'">Modifier</a></td>';
			echo $ligne;
		}
		?>
		</tr>
	</tbody>
	</table>
</div>
<?php
require_once('../inc/footer.inc.php');
?>