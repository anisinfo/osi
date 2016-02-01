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
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/incidents.php');
require_once('../classes/Application.php');
$incident = new incidents();
$impacte=new Impact();
$incident->chargerIncident($numero);
$impacte->chargerFirstIncident($numero);
$application= new Application();
$application->SelectAppliById($impacte->getApplicationId());
//header ('Content-Type: application/octet-stream');
header('Content-type: text/html; charset=utf-8');
header('Content-Disposition: attachment; filename='.basename('commachaud.vbs'));
?>
Const tmpD = "c:/temp/"
function GetFileName(url)
    segments = split(url,"/")
    furl = segments(ubound(segments))
    GetFileName = furl
end function

Sub writeImage(binaryData, strFullPath)

  Set objADO = CreateObject("ADODB.Stream")
  objADO.Open
  objADO.Type = 1
  objADO.Position = 0

  objADO.Write binaryData
  objADO.SaveToFile strFullPath, 2

  Set objADO = Nothing
End Sub

Function binaryURL(strURL)
  Set objHttp = CreateObject("WinHttp.WinHttpRequest.5.1")

  objHTTP.Open "GET", strURL, False
  objHTTP.Send

  binaryURL = objHTTP.ResponseBody
End Function
Set fso = CreateObject("scripting.filesystemobject")
Set objOL = CreateObject("Outlook.Application")
    Set objMail = objOL.CreateItem(0)
    Set colAttach = objMail.Attachments
    Call writeImage(binaryURL("<?= RACINE; ?>img/logo.png"), tmpD & GetFileName("<?= RACINE; ?>img/logo.png"))
    Set oAttach = colAttach.Add(tmpD & GetFileName("<?= RACINE; ?>img/logo.png"))
    content = "<img src='cid:logo.png' /><br /><br />"
	content = content & "<table border='1' cellspacing='0' cellpadding='0' style='border:outset #767676 3.0pt' width='100%'>"
	content = content & "<tbody><tr>"
	content = content & "<td style='background: <?= $STATUTCOLOR[$incident->getStatut()];?>;padding:.75pt .75pt .75pt .75pt' colspan='2' align='center'>"			
	content = content & "<b><span style='font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>"
	content = content & "INCIDENT : <?= $STATUT[$incident->getStatut()]; ?></span></b></td></tr><tr>"
	content = content & "<td style='padding:.75pt .75pt .75pt .75pt' colspan='2'  align='center'>"
	content = content & "<span style='font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black'>"
	content = content & "<?= $incident->getTitre(); ?>"
	content = content & "</span></b>"
	content = content & "</td>"
	content = content & "</tr><tr>"
	content = content & "<td width='50%' style='width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Date de d&eacute;but :</span></b>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= $incident->getDateDebut();?></span>"
	content = content & "</td>"
	content = content & "<td width='50%' style='width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Date de fin estim&eacute;e :</span></b>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= $incident->getDateFin();?></span>"
	content = content & "</td></tr><tr>"
	content = content & "<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Dur&eacute;e de l'indisponibilit&eacute; :</span></b>"
	content = content & "<?= $incident->getDuree();?>"
	content = content & "</td></tr><tr>"
	content = content & "<td style='background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black'>&nbsp;Priorit&eacute;</span></b>"
	content = content & "</td>"
	content = content & "<td width='30%' style='width:30.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<span style='font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:crimson'><?php if($incident->getPriorite()) echo $PRIORITE[$incident->getPriorite()];?></span>"
	content = content & "</td>"
	content = content & "</tr><tr>"
	content = content & "<td style='background:#a5a6a5;padding:.75pt .75pt .75pt .75pt' colspan='2'>"
	content = content & "<b><span style='font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black'>&nbsp;Localisation</span></b>"
	content = content & "</td>"
	content = content & "</tr><tr>"
	content = content & "<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<span style='font-size:10.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?=  str_replace( array("\r\n", "\r", "\n"), '<br />',$incident->getLocalisation());?></span>"
	content = content & "</td></tr><tr>"
	content = content & "<td style='background:#a5a6a5;padding:.75pt .75pt .75pt .75pt' colspan='2'>"
	content = content & "<b><span style='font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black'>&nbsp;Impact</span></b>"
	content = content & "</td></tr><tr>"
	content = content & "<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<p><?=  str_replace( array("\r\n", "\r", "\n"), '<br />',$impacte->getDescription());?></p>"
	content = content & "</td>"
	content = content & "</tr>"
	content = content & "<tr><td colspan='2'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b>Actions &agrave; r&eacute;aliser par les utilisateurs</b></td></tr><tr>	"
	content = content & "<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><?=  str_replace(array("\r\n", "\r", "\n"), '<br />',$incident->getActionUtlisateur());?>	"
	content = content & "</td></tr>	<tr><td colspan='2'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b>Source</b></td></tr>"
	content = content & "<tr><td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><?=  str_replace( array("\r\n", "\r", "\n"), '<br />',$incident->getCause());?>(cause)"	
	content = content & "</td>"
	content = content & "</tr><tr><td colspan='2'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b>Y a-t-il un risque d'aggravation ?</b>"
	content = content & "</td></tr>"
	content = content & "<tr><td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><?= ($incident->getRisqueAggravation())?'Oui':'Non';?>"	
	content = content & "</td></tr><tr><td colspan='2'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b>Description</b></td></tr><tr>"
	content = content & "<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><?= str_replace( array("\r\n", "\r", "\n"), '<br />',$incident->getDescripIncident());?>	</td></tr>"
	content = content & "<tr><td colspan='2'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b>D&eacute;partement / utilisateurs affect&eacute;s</b></td></tr><tr>	"
	content = content & "<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<?= $incident->getDepartement().' / '.$incident->getUtilisImpacte(); ?></td></tr>"
	content = content & "<tr><td colspan='2'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'><b>Actions en cours</b>"
	content = content & "</td></tr><tr>	<td colspan='2' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<?= str_replace( array("\r\n", "\r", "\n"), '<br />',$incident->getChronogramme()); ?>"
	content = content & "</td></tr><tr>"
	content = content & "<td colspan='2' align='center'>"
	content = content & "<b>Incident Manager</b><br>"
	content = content & "<span style='font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;'>&nbsp; RESG/GTS/RET<br>"
	content = content & "Email : <a href='mailto:<?= MAILCOMMACHAUD; ?>' target='_blank'><?= MAILCOMMACHAUD; ?></a></span><br>"
	content = content & "<span style='font-family:Webdings'></span>"
	content = content & "<span style='font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;'>Tel : <?= TELCOMMACHAUD; ?>"
	content = content & "</span></p><br><br><br><br>"
	content = content & "<p class='MsoNormal' align='center' style='text-align:center'>Num&eacute;ro Incident : <span style='color:#1f497d'><?= $incident->getIncident();?></span></p>"
	content = content & "</td></tr></tbody></table>"
With objMail
		.SentOnBehalfOfName = ""
		.Subject = "{<?= $STATUTCOMMACHAUD[$incident->getStatut()]; ?>} - [<?= $incident->getIncident();?>] - <?php if($incident->getPriorite()) echo '['.$PRIORITE[$incident->getPriorite()].']';?> - [RETAIL][<?= $application->getEnseigne();?>][<?= $application->getName();?>] - <?= html_entity_decode($incident->getTitre());?>"
		.To = "<?= DESTINATAIRE; ?>"
		.Cc = "<?= DESTINATAIRECC; ?>"
		.BCC = "<?= DESTINATAIREBCC; ?>"
		.HTMLBody = content
		.Display
	End With		
