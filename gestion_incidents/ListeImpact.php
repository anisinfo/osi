<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
	}
$numero=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];
if (!$numero) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	header('Location:index.php');
	die();
}
define('TITLE','Liste des impactes pour l\'incident :'.$numero);

require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/incidents.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
require_once('../classes/Chronogramme.php');
$incident= new incidents();
$incident->_setUser($userConnected);
$incident->chargerIncident($numero);
$impacte = new Impact();
$resultats=$impacte->chargerIncident($numero);
$appli= new Application();
require_once('../inc/header.inc.php');
$statLink=($incident->getIdStat())?'modifStat.php?idIncident='.$_GET['idIncident'].'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$_GET['idIncident'];
?>
<h3>Liste d'impactes pour l'incident N°:<?= $incident->getIncident();?></h3>
<br />
<br />
<div class="bloc">
<?php
require_once('../inc/search.inc.php');
?>
<a class="btn btn-success"  align="left" href="add.php?IdIncident=<?= $_GET['idIncident'];?>">Ajouter Incident</a>
<a class="btn btn-success disabled" >Impacts</a>
<a class="btn btn-success" href="<?php echo $statLink; ?>">Stat</a>
<a  class="btn btn-success" href="javascript:EnvoyerMail('<?= $incident->getNumero();?>')" >Comm à chaud</a>
<a class="btn btn-danger" href="javascript:supprimer('index.php?id=<?= $_GET['idIncident'];?>&supprimer')" >Supprimer l'incident</a>
<a class="btn btn-success"  href="impact.php?idIncident=<?= $numero;?>">Ajouter un impact</a>
<a class="btn btn-success"  href="modif.php?id=<?= $numero;?>">Retour à l'incident</a>
<br />
<br />
<table class="table">
	<thead>
		<th>Date de Début</th>
		<th>Date de Fin</th>
		<th>Application</th>
		<th>Description</th>
		<th>Impact</th>
		<th colspan="2">Action</th>
	</thead>
	<tbody>
		
		<?php
		$supprimer=(count($resultats) > 1)?true:false;
		for ($i=0 ; $i < count($resultats) ; $i++ ) { 

			$value=$resultats[$i];

			$appli= new Application();
			$appli->SelectAppliById($value[2]);
		
			$ligne='<tr><td>'.$value[3].'</td>';
			$ligne.='<td>'.$value[4].'</td>';
			$ligne.='<td>'.$appli->getName().'</td>';
			$ligne.='<td>'.$value[11].'</td><td>';
			$ligne.=($value[8] !='')?$INCIDENTIMPACTMETIER[$value[8]]:'';
			$ligne.='</td><td><a class="btn btn-success" href="modifImpact.php?IdImpact='.$value[0].'">Modifier</a></td>';
			$ligne.='<td>';
			if($supprimer) $ligne.='<a class="btn btn-danger" href="modifImpact.php?IdIncident='.$_GET['idIncident'].'&action=supprimer&IdImpact='.$value[0].'">Supprimer</a>';
			$ligne.='</td></tr>';
			echo $ligne;
		}
		?>
		
	</tbody>
	</table>
</div>
<?php
$idIncident=$numero;
require_once('../inc/commachaud.inc.php');
require_once('../inc/footer.inc.php');
?>