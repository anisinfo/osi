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

<a class="btn btn-success"  href="impact.php?idIncident=<?= $numero;?>">Ajouter un impacte</a>
<a class="btn btn-success"  href="modif.php?id=<?= $numero;?>">Retour à l'incident</a>
<br />
<br />
<div class="bloc">
<?php
require_once('../inc/search.inc.php');
?>
<a class="btn btn-success" href="<?php echo $statLink; ?>">Stat</a>
<a  class="btn btn-success" href="javascript:EnvoyerMail('<?= $incident->getNumero();?>')" >Comm à chaud</a>
<a class="btn btn-danger" href="javascript:supprimer('index.php?id=<?= $_GET['idIncident'];?>&supprimer')" >Supprimer l'incident</a>
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
			$ligne.=($value[8] !='')?$numeroIMPACTMETIER[$value[8]-1]:'';
			$ligne.='</td><td><a class="btn btn-success" href="modifImpact.php?IdImpact='.$value[0].'">Modifier</a></td>';
			$ligne.='<td>';
			if($supprimer) $ligne.='<a class="btn btn-danger" href="modifImpact.php?IdIncident='.$_GET['idIncident'].'&action=supprimer&IdImpact='.$value[0].'">Supprimer</a>';
			$ligne.='</td></tr>';
			echo $ligne;
		}
		?>
		
	</tbody>
	</table>
	<textarea name="corp" id="corp" style="display:none;" >
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
</div>
<?php
require_once('../inc/footer.inc.php');
?>