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
require_once('../classes/Chronogramme.php');

$Impacte= new Impact();



if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	/*
	Contrôle des champs obligatoire
	*/
	if(!isInteger($_POST['Incident_Impact_jourhommeperdu']) && !empty($_POST['Incident_Impact_jourhommeperdu'])){
		$errors['Incident_Impact_jourhommeperdu']="Le champ jours homme perdu doit etre numérique  !";
	}

	if(empty($_POST['Incident_Impact_datedebut'])){
		$errors['Incident_Impact_datedebut']="Vous devez remplir le champ début impact!";
	}

	if(empty($_POST['Incident_Impact_datefin'])){
		$errors['Incident_Impact_datefin']="Vous devez remplir le champ date fin impact!";
	}

	if (!$_POST['Incident_Impact_impactmetier']) {
		$errors['Incident_Impact_impactmetier']="L'Impact métier n'est pas valide!";
	}

	if (!$_POST['Incident_Impact_sla']) {
		$errors['Incident_Impact_sla']="Le SLA n'est pas valide!";
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
}else
{
$incident =new incidents();
$incident->_setUser($userConnected);
$incident->chargerIncident($numincident);
}
require_once('../inc/header.inc.php');
?>
<h1>Ajout d'un impacte</h1>

<form action="" method="POST">
	<div class="bloc">
	<?php
	require_once('../inc/search.inc.php'); ?>
	<?php
	 $statLink=($incident-> getIdStat())?'modifStat.php?idIncident='.$numincident.'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$numincident;
	?>
	<a class="btn btn-success"  align="left" href="add.php?IdIncident=<?= $numincident; ?>">Ajouter Incident</a>
	<a class="btn btn-success" href="ListeImpact.php?idIncident=<?php echo $numincident; ?>">Impacts</a>
	<a class="btn btn-success" href="<?php echo $statLink; ?>">Stat</a>
	<a  class="btn btn-success" href="javascript:EnvoyerMail('<?= $numincident;?>')" >Comm à chaud</a>
	<a class="btn btn-danger" href="javascript:supprimer('index.php?id=<?= $numincident;?>&supprimer')" >Supprimer l'incident</a>
	<a class="btn btn-success disabled"  href="">Ajouter un impact</a>
	<a class="btn btn-success"  href="modif.php?id=<?= $numincident;?>">Retour à l'incident</a>

	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">
	      Ajout pour l'incident N°:<strong><?= $incident->getIncident() ?></strong>
	    </span>
		
		<span class="lib" style="float:left; margin-left:25px; line-height:2.5;"> Titre comm :
		<strong><?php getVarUpdate('numincident',$incident->getTitre()); ?> </strong> 
		</span>
		
	    </div>
	<div class="width100 bcg">
	<?php 
	include('../inc/impact.inc.php');
	?>
    	</fieldset>

    	<input type="submit" value="Sauvegarder" name="submit" />
    	<input onclick="javascript:document.location.href='ListeImpact.php?idIncident=<?= $_GET["idIncident"]; ?>'" type="button" value="Annuler" name="button" />
	</div>
	</div>

</form>
	<?php 
$impacte= new Impact();
$impacte->chargerFirstIncident($numincident);	
$idIncident=$numincident;	
require_once('../inc/commachaud.inc.php');	
require_once('../inc/footer.inc.php');
?>

