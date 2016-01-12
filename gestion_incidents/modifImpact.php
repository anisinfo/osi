<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
	}

$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	
$IdImpact=(isset($_GET['IdImpact']))?$_GET['IdImpact']:'';
if (!$IdImpact) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	header('Location:ListeImpact.php?idIncident='.$impacte->getIncidentId());
	die();
}
define('TITLE',"Modification de l'impacte N°:' ".$IdImpact);

require_once('../classes/db.php');
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
require_once('../classes/incidents.php');
require_once('../classes/Calendrier.php');
require_once('../classes/Chronogramme.php');

$incident =new incidents();
$impacte= new Impact();
$appli= new Application();
$calendrier= new Calendrier();
if (isset($_GET['action'])) {
$impacte->supprimer($IdImpact);
$_SESSION['flash']['erreur']="Impacte supprimé!";
header('Location:ListeImpact.php?idIncident='.$_GET['IdIncident']);
}


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
		$errors['Incident_Impact_datefin']="Vous devez remplir le champ fin impact!";
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
	$impacte->setParam($IdImpact,$_POST['IdIncident'],$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->modifier();
	$_SESSION['flash']['success'] =" L'incident est bien modifié.".$impacte->getIncidentId(); 
	header('Location:ListeImpact.php?idIncident='.$impacte->getIncidentId());
	
	}
}else
{
$impacte->chargerImpact($IdImpact);
$incident->_setUser($userConnected);
$incident->chargerIncident($impacte->getIncidentId());
$numero=$impacte->getIncidentId();

$idAppli=$impacte->getApplicationId();
$appli->SelectAppliById($idAppli);
if ($impacte->getApplicationId()) {
	$idAppli=$impacte->getApplicationId();
	$calendrier->selectById($idAppli);
	//debug($calendrier);
}

}
require_once('../inc/header.inc.php');
?>
<h1>Modification d'un impacte</h1>

<form action="" method="POST">
<input type="hidden" name="IdIncident" value="<?php getVarUpdate('IdIncident',$impacte->getIncidentId()); ?>">
	<div class="bloc">
	<?php
	require_once('../inc/search.inc.php');
	$statLink=($incident-> getIdStat())?'modifStat.php?idIncident='.$impacte->getIncidentId().'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$impacte->getIncidentId();
	?>
	<a class="btn btn-success" href="<?php echo $statLink; ?>">Stat</a>
	  <a  class="btn btn-success" href="javascript:EnvoyerMail('<?= $impacte->getIncidentId();?>')" >Comm à chaud</a>
	  <a class="btn btn-danger" href="javascript:supprimer('index.php?id=<?= $impacte->getIncidentId();?>&supprimer')" >Supprimer Incident</a>
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">Edition de l'incident N° <strong> <?=$incident->getIncident(); ?></strong></span>
	<span class="lib" style="float:left; margin-left:25px; line-height:2.5;">Titre comm <strong><?= $incident->getTitre(); ?> </strong> </span>
	</div>
	<div class="width100 bcg">
	<?php require_once('../inc/impactmodif.inc.php'); ?>
	</div>
    	</fieldset>
    	<input type="submit" value="Sauvegarder" name="submit" />
    	<input type="button" value="Annuler" name="button" onclick="javascript:document.location.href='ListeImpact.php?idIncident=<?= $impacte->getIncidentId(); ?>'" />
	</div>
	</div>

</form>
<textarea name="corp" id="corp" style="display:none;">
<table border="1" cellspacing="0" cellpadding="0" style="border:outset #767676 3.0pt" width="100%">
	<tbody>
		<tr>
			<td style="background: <?= $STATUTCOLOR[$incident->getStatut()-1];?>;padding:.75pt .75pt .75pt .75pt" colspan="2" align="center">
				
				<b><span style="font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
				INCIDENT : <?= $STATUT[$incident->getStatut()-1]; ?>
				</span>
				</b>
			</td>
			</tr>
			<tr>
			<td style="padding:.75pt .75pt .75pt .75pt" colspan="2"  align="center">
					<span style="font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">
						<?= $incident->getTitre(); ?>
					</span></b>
			</td>
			</tr>
				
			<tr>
			<td width="50%" style="width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt">
				<b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Date de d&eacute;but :</span></b>
				<span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getDateDebut();?></span>
			</td>
			<td width="50%" style="width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Date de fin estim&eacute;e :</span></b>
			<span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getDateFin();?></span>

			</td>
		</tr>
		<tr>
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
				<b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Dur&eacute;e de l'indisponibilité :</span></b>
			<?= $incident->getDuree();?>
			</td>
		</tr>

		<tr>
			<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
				<b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Priorit&eacute;</span></b>

			</td>
			<td width="30%" style="width:30.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt">
				<span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:crimson"><?= $PRIORITE[$incident->getPriorite()-1];?></span>
			</td>
		</tr>
		<tr>
			<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt" colspan="2">
				<b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Localisation</span></b>

			</td>
		</tr>
		<tr>
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getLocalisation();?></span>
			</td>
		</tr>

		<tr>
			<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt" colspan="2">
				<b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Impact</span></b>
			</td>
		</tr>
		<tr>
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
				<p><?= $impacte->getDescription();?></p>
			</td>
		</tr>
		<tr>
			<td colspan="2"  style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
			<b>Actions &agrave; r&eacute;aliser par les utilisateurs</b>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<?= $incident->getActionUtlisateur();?>	
			</td>
			
		</tr>	
		<tr>
			<td colspan="2"  style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
			<b>Source</b>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<?= $incident->getCause();?>(cause)	
			</td>
			
		</tr>
		<tr>
			<td colspan="2"  style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
			<b>Y a-t-il un risque d'aggravation ?</b>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<?= ($incident->getRisqueAggravation())?'Oui':'Non';?>	
			</td>
			
		</tr>
		<tr>
			<td colspan="2"  style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
			<b>Description</b>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<?= $incident->getDescripIncident();?>	
			</td>
			
		</tr>

		<tr>
			<td colspan="2"  style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
			<b>D&eacute;partement / utilisateurs affect&eacute;s</b>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<?= $incident->getDepartement().' / '.$incident->getUtilisImpacte(); ?>	
			</td>
			
		</tr>
		<tr>
			<td colspan="2"  style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
			<b>Actions en cours</b>
			</td>
		</tr>
		<tr>	
			<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
			<?php
				$chrono= new Chronogramme();
				$taches=$chrono->getChronogrammeByIncidentId($numero);
				foreach ($taches as $ligne)
				{
					echo $ligne->getActionDate().'  '.$ligne->getDescription().'<br>';
				}
				?>
			</td>
			
		</tr>
		<tr>
			<td colspan="2" align="center">
			<b>Incident Manager</b><br>
			<span style="font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&nbsp; RESG/GTS/RET<br>
			Email : <a href="mailto:for-retail.quality-of-service-gts@socgen.com" target="_blank">for-retail.quality-of-service-<wbr>gts@socgen.com</a></span><br>
			<span style="font-family:Webdings">&Agrave;</span>
			<span style="font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"> : Tel : 01 64 85 <span style="color:#1f497d">
			XXX</span> ou <span style="color:#1f497d">CCCC</span></span></p>
			<br>
			<br>
			<br>
			<br>
			<p class="MsoNormal" align="center" style="text-align:center">Numéro Incident : <span style="color:#1f497d"><?= $incident->getIncident();?></span></p>
			</td>
		</tr>
		</tbody>
		</table>
</textarea>
	<?php 
require_once('../inc/footer.inc.php');
?>

