<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
	}
$numincident=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	

if (!$numincident) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	header('Location:ListeImpact.php?idIncident='.$numincident);
	die();
}
define('TITLE',"Modification de l'impacte N°:' ".$numincident);
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');

require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
require_once('../classes/incidents.php');
require_once('../classes/Calendrier.php');

$Impacte= new Impact();



if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	/*
	Contrôle des champs obligatoire
	*/
	if(empty($_POST['IdAppli'])){
		$errors['IdAppli']="Vous devez remplir le champ Application!";
	}

	if(!isInteger($_POST['Incident_Impact_jourhommeperdu']) && !empty($_POST['Incident_Impact_jourhommeperdu'])){
		$errors['Incident_Impact_jourhommeperdu']="Le champ jours homme perdu doit etre numérique  !";
	}

	if(empty($_POST['Incident_Impact_datedebut'])){
		$errors['Incident_Impact_datedebut']="Vous devez remplir le champ début impact!";
	}

	if (!$_POST['Incident_Impact_impactmetier']) {
		$errors['Incident_Impact_impactmetier']="L'Impact métier n'est pas valide!";
	}


	if(empty($_POST['Incident_Impact_description'])){
		$errors['Incident_Impact_description']="Vous devez remplir le champ Description de l'impact!";
	}

	if(empty($errors))
	{

	// Impacte
	$impacte=new Impact();
	$impacte->setParam(NULL,$numincident,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->creer();
	

	$_SESSION['flash']['success'] =" L'impacte est bien ajoutée."; 
	header('Location:ListeImpact.php?idIncident='.$numincident);
	
	}
}
require_once('../inc/header.inc.php');
?>
<h1>Ajout d'un impact</h1>
<?php
if(!empty($errors)){?>
	<div class="alert alert-danger">
	<ul>
	<h5>Vous avez des erreurs dans le remplissage de votre formulaire</h5>
		<?php
		foreach ($errors as $error) {
			echo '<li>'.$error.'</li>';
		}
		?>
		</ul>
	</div>

<?php
}
?>
<form action="" method="POST">
	<div class="bloc">
	<?php
	$incident =new incidents();
	$incident->chargerIncident($numincident);
	require_once('../inc/search.inc.php'); ?>
	<?php
	 $statLink=($incident-> getIdStat())?'modifStat.php?idIncident='.$numincident.'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$numincident;
	?>
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">
	      Ajout pour l'incident N°:<strong><?= $incident->getIncident() ?></strong>
	    </span>
		
		<span class="lib" style="float:left; margin-left:25px; line-height:2.5;"> Titre comm :
		<strong><?php getVarUpdate('numincident',$incident->getTitre()); ?> </strong> 
		</span>	
	    </div>
	<fieldset>
	<?php 
	include('../inc/impact.inc.php');
	?>	
    <div class="width100">
    	<input type="submit" value="Sauvegarder" name="submit" />
    	<input onclick="javascript:document.location.href='ListeImpact.php?idIncident=<?= $_GET["idIncident"]; ?>'" type="button" value="Annuler" name="button" />
	</div>
	</fieldset>
	</div>

</form>
	<?php 
$impacte= new Impact();
$impacte->chargerFirstIncident($numincident);
$application= new Application();
$application->SelectAppliById($impacte->getApplicationId());	
$idIncident=$numincident;	
require_once('../inc/commachaud.inc.php');	
require_once('../inc/footer.inc.php');
?>

