<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
			 	 die();
	}
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	
$numero=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
if (!$numero) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	header('Location:index.php');
	die();
}
define('TITLE','Comme a chaud l\'incident :'.$numero);

require_once('../inc/config.inc.php');
require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/incidents.php');
require_once('../classes/Application.php');
require_once('../classes/Chronogramme.php');

if(!empty($_POST)){
	$errors=array();

	/*
	Contrôle des champs obligatoire
	*/
	if(empty($_POST['mail_dest'])){
		$errors['mail_dest']="Vous devez remplir le champ Destination!";
	}elseif (filter_var($_POST['mail_dest'], FILTER_VALIDATE_EMAIL)) {
   		 $errors['mail_dest']='Cet email est correct.';
		} 
	

	if(empty($_POST['sujet'])){
		$errors['sujet']="Vous devez remplir le champ Objet";
	}

	if (empty($errors)) {
		$from=$_SESSION['auth'][3];
		$headers = "From: " .$from. "\r\n";
    	$headers .= "MIME-Version: 1.0\r\n";
    	$headers .= "Content-Type: text/html; charset=iso-8859-1\r\n";
    	$headers .= "Content-Transfer-Encoding: 8bit\r\n";

		if (mail($_POST['mail_dest'], $_POST['sujet'], $_POST['corp'],$headers)) {
		 	$_SESSION['flash']['success']="Votre mail est bien envoyée!";
		}else $_SESSION['flash']['danger']="Votre mail n'est pas envoyée!";

	}
}else
{

}
$incident = new incidents();
$impacte=new Impact();
$incident->_setUser($userConnected);
$incident->chargerIncident($numero);
$impacte->chargerFirstIncident($numero);
require_once('../inc/header.inc.php');

?>
<script type="text/javascript">
	tinymce.init({ selector:'textarea',language: 'fr_FR'});
</script>
<h3>Comme a Chaud de l'incident N°:<?= $incident->getIncident();?></h3>
<br />
<br />
<form action="" method="POST">
<div class="bloc">

<label>A :</label>
<input type="text" name="mail_dest" name="mail_dest" value="aouini.aniss@gmail.com" />

<label>CC :</label>
<input type="text" name="mail_dest_cc" name="mail_dest_cc" />

<label>Objet :</label>
<input type="text" name="sujet" name="sujet" value="Comme a chaud pour l'incident N° :<?= $incident->getIncident();?>" />

<label>Mail :</label>
<textarea name="corp" name="corp" style="height:500px;" >
	<table border="1" cellspacing="0" cellpadding="0" style="border:outset #767676 3.0pt" width="100%">
<tbody>
<tr>
<td style="border:inset #767676 1.0pt;padding:.75pt .75pt .75pt .75pt">
<div align="center">
<table border="0" cellpadding="0" width="100%" style="width:100.0%">
<tbody>
<tr>
<td rowspan="2" style="padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#767676;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center; color:white;">
<b><span style="font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">INCIDENT : <?= $STATUT[$incident->getStatut()-1]; ?>
</span></b></p>
</td>
</tr>
<tr>
<td style="padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center"><b>
<span style="font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">
<?= $incident->getTitre(); ?>
</span></b></p>
<p>&nbsp</p>
</td>
</tr>
</tbody>
</table>
</div>
<table border="0" cellpadding="0" width="100%" style="width:100.0%">
<tbody>
<tr>
<td width="50%" style="width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Date de début :
</span></b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getDateDebut();?></span></p>
<p>&nbsp</p>
</td>
<td width="50%" style="width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Date de fin estimée :
</span></b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getDateFin();?></span></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">Durée de l'indisponibilité :
</span></b></p>
<p><?= $incident->getDuree();?></p>
</td>
</tr>
</tbody>
</table>
<p class="MsoNormal"><span style="font-size:7.5pt">&nbsp;</span></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Priorité</span></b></p>
<p>&nbsp</p>
</td>
<td width="30%" style="width:30.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center"><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:crimson"><?= $PRIORITE[$incident->getPriorite()-1];?></span></p>
</td>
</tr>
</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Localisation</span></b></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getLocalisation();?>
</span></p>
<p>&nbsp</p>
</td>
</tr>
</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Impact</span></b></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt"></td>
</tr>
</tbody>
</table>
<p class="MsoNormal"><span style="color:#1f497d">Description impact</span></p>
<p><?= $impacte->getDescription();?></p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Actions à réaliser par les utilisateurs</span></b></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt"></td>
</tr>
</tbody>
</table>
<p class="MsoNormal"><span style="color:#1f497d"><?= $incident->getActionUtlisateur();?></span></p>
<p>&nbsp</p>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">
&nbsp;Source</span></b></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getCause();?>
<span style="color:#1f497d">(cause)</span></span></p>
<p>&nbsp</p>
</td>
</tr>
</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b>
<span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Y a-t-il un risque d'aggravation ?</span></b></p>

<p>&nbsp</p></td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= ($incident->getRisqueAggravation())?'Oui':'Non';?></span></p>
<p>&nbsp</p>
</td>
</tr>
</tbody>
</table>
<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Description</span></b></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;"><?= $incident->getDescripIncident();?></span></p>
<p>&nbsp</p>
</td>
</tr>
</tbody>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b>
<span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">&nbsp;Département / utilisateurs affectés</span></b></p>

<p><?= $incident->getDepartement().' / '.$incident->getUtilisImpacte(); ?></p></td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt"> </td>
</tr>
</tbody>
</table>

<table border="0" cellspacing="0" cellpadding="0" width="100%">
<tbody>
<tr>
<td width="2%" style="width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">

</td>
<td style="background:#a5a6a5;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal"><b><span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black">
&nbsp;Actions en cours
</span></b></p>
<p>&nbsp</p>
</td>
</tr>
<tr>
<td colspan="2" style="background:#dedfde;padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal">
<span style="font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
<?php
$chrono= new Chronogramme();
$taches=$chrono->getChronogrammeByIncidentId($numero);
//debug($taches);
foreach ($taches as $ligne) {
	echo $ligne->getActionDate().'  '.$ligne->getDescription().'<br>';
}
?>
</p>
</td>
</tr>
</tbody>
</table>
<table border="0" cellpadding="0" width="100%" style="width:100.0%">
<tbody>
<tr>
<td style="padding:.75pt .75pt .75pt .75pt">
<p align="center" style="text-align:center"><b><span style="font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">Incident Manager</span></b><br>
<span style="font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;">&nbsp; RESG/GTS/RET<br>
Email : <a href="mailto:for-retail.quality-of-service-gts@socgen.com" target="_blank">for-retail.quality-of-service-<wbr>gts@socgen.com</a></span><br>
<span style="font-family:Webdings">Å</span>
<span style="font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;"> : Tel : 01 64 85 <span style="color:#1f497d">
XXX</span> ou <span style="color:#1f497d">CCCC</span></span></p>
</td>
</tr>
</tbody>
</table>
<p class="MsoNormal">&nbsp;</p>
<table border="0" cellpadding="0" width="100%" style="width:100.0%">
<tbody>
<tr>
<td style="padding:.75pt .75pt .75pt .75pt">
<p class="MsoNormal" align="center" style="text-align:center">Numéro Incident : <span style="color:#1f497d">
<?= $incident->getIncident();?></span></p>
</td>
</tr>
</tbody>
</table>
</td>
</tr>
</tbody>
</table>
</textarea>
<br />
<br />
<br />
<br />
<input type="submit" name="Envoyer" value="Envoyer" />
</div>
<?php
require_once('../inc/footer.inc.php');
?>