<?php
header('Content-Disposition: attachment; filename='.basename('commachaud.vbs'));
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
$resultats=$impacte->chargerIncident($numero);
$LDescription="";
$LApplication="";
for ($i=0 ; $i < count($resultats) ; $i++ ) { 

			$value=$resultats[$i];

			$application= new Application();
			$application->SelectAppliById($value[2]);
			$LDescription.=$value[11].', ';
			$LApplication.=($i== 0)?'<b>'.$application->getName().'</b>,':$application->getName();
}

$listeBcci=$incident->chargerBcci();
$BccFinal='';
	foreach ($DESTINATAIREBCC as $key => $value) {
    	$BccFinal.=(strpos($listeBcci,$key.',') !== false)?$value.';':'';
    }
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
    <?php
    if($incident->getPriorite() != "")
    {?>
	Call writeImage(binaryURL("<?= RACINE; ?>img/p<?= $incident->getPriorite(); ?>.png"), tmpD & GetFileName("<?= RACINE; ?>img/p<?= $incident->getPriorite(); ?>.png"))
    Set oAttach = colAttach.Add(tmpD & GetFileName("<?= RACINE; ?>img/p<?= $incident->getPriorite(); ?>.png"))
   <?php }
    ?>
   
	content = "" 
    content = content & "<HTML xmlns='http://www.w3.org/1999/xhtml' lang='fr'><HEAD>"
    content = content & "<meta charset='utf-8'>"
    content = content & "</HEAD><BODY>"
    content = "<br /><br />"
	content = content & "<table border='1' cellspacing='0' cellpadding='0' style='border:outset #767676 3.0pt' width='100%'>"
	content = content & "<tbody><tr>"
	content = content & "<td  rowspan='2' width='5%' align='center'><img src='cid:p<?= $incident->getPriorite(); ?>.png' /></td>"
	content = content & "<td colspan='3' style='background: <?= $STATUTCOLOR[$incident->getStatut()];?>;padding:.75pt .75pt .75pt .75pt' align='center'>"			
	content = content & "<b><span style='font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>"
	content = content & "INCIDENT : <?= EcritureCommachaud($STATUT[$incident->getStatut()]); ?></span></b></td></tr><tr>"
	content = content & "<td style='padding:.75pt .75pt .75pt .75pt' colspan='3'  align='center'>"
	content = content & "<span style='font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:black'>"
	content = content & "<?= EcritureCommachaud($incident->getTitre()); ?>"
	content = content & "</span></b>"
	content = content & "</td>"
	content = content & "</tr><tr>"
	content = content & "<td width='50%' style='width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt' colspan='2'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Date de d&eacute;but  : </span></b>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= $incident->getDateDebut();?></span>"
	content = content & "</td>"
	content = content & "<td width='50%' style='width:50.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt' colspan='2'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Date de fin estim&eacute;e : </span></b>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= $incident->getDateFin();?></span>"
	content = content & "</td></tr><tr>"
	content = content & "<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Dur&eacute;e de l'indisponibilit&eacute; :</span></b>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= $incident->getDuree();?></span>"
	content = content & "</td></tr><tr>"
	content = content & "<td style='background:#a5a6a5;padding:.75pt .75pt .75pt .75pt' colspan='3'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>&nbsp;Priorit&eacute;</span></b>"
	content = content & "</td>"
	content = content & "<td width='30%' style='width:30.0%;background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<span style='font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:crimson'><?php if($incident->getPriorite()) echo $PRIORITE[$incident->getPriorite()];?></span>"
	content = content & "</td>"
	content = content & "</tr><tr>"
	content = content & "<td style='background:#a5a6a5;padding:.75pt .75pt .75pt .75pt' colspan='4'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>&nbsp;Localisation</span></b>"
	content = content & "</td>"
	content = content & "</tr><tr>"
	content = content & "<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?=  EcritureCommachaud($incident->getLocalisation());?></span>"
	content = content & "</td></tr><tr>"
	content = content & "<td style='background:#a5a6a5;padding:.75pt .75pt .75pt .75pt' colspan='4'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>&nbsp;Impact</span></b>"
	content = content & "</td></tr><tr>"
	content = content & "<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<p><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?=  EcritureCommachaud($LApplication.'<br />'.$LDescription);?></span></p>"
	content = content & "</td>"
	content = content & "</tr>"
	content = content & "<tr><td colspan='4'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Actions &agrave; r&eacute;aliser par les utilisateurs</span></b></td></tr><tr>	"
	content = content & "<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?=  EcritureCommachaud($incident->getActionUtlisateur());?>	</span>"
	content = content & "</td></tr>	<tr><td colspan='4'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Source</span></b></td></tr>"
	content = content & "<tr><td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?=  EcritureCommachaud($incident->getCause());?></span>"	
	content = content & "</td>"
	content = content & "</tr><tr><td colspan='4'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Y a-t-il un risque d'aggravation ?</span></b>"
	content = content & "</td></tr>"
	content = content & "<tr><td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= ($incident->getRisqueAggravation())?'Oui':'';?></span>"	
	content = content & "</td></tr><tr><td colspan='4'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Description</span></b></td></tr><tr>"
	content = content & "<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= EcritureCommachaud($incident->getDescripIncident());?></span></td></tr>"
	content = content & "<tr><td colspan='4'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>D&eacute;partement / utilisateurs affect&eacute;s</span></b></td></tr><tr>	"
	content = content & "<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>"
	content = content & "<?= ($incident->getDepartement() !='' && $incident->getUtilisImpacte() != '')?EcritureCommachaud($incident->getDepartement()).' / '.EcritureCommachaud($incident->getUtilisImpacte()):EcritureCommachaud($incident->getDepartement()).''.EcritureCommachaud($incident->getUtilisImpacte());?></span></td></tr>"
	content = content & "<tr><td colspan='4'  style='width:2.0%;background:#a5a6a5;padding:.75pt .75pt .75pt .75pt'><b><span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'>Actions en cours</span></b>"
	content = content & "</td></tr><tr>	<td colspan='4' style='background:#dedfde;padding:.75pt .75pt .75pt .75pt'>"
	content = content & "<span style='font-size:8.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;'><?= EcritureCommachaud($incident->getChronogramme()); ?></span>"
	content = content & "</td></tr><tr>"
	content = content & "<td colspan='4' align='center'>"
	content = content & "<br /><br /><img src='cid:logo.png' /><b>Incident Manager</b><br>"
	content = content & "<span style='font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;'>&nbsp; RESG/GTS/RET<br>"
	content = content & "Email : <a href='mailto:<?= MAILCOMMACHAUD; ?>' target='_blank'><?= MAILCOMMACHAUD; ?></a></span><br>"
	content = content & "<span style='font-family:Webdings'></span>"
	content = content & "<span style='font-size:10.0pt;font-family:&quot;Calibri&quot;,&quot;sans-serif&quot;'><img src='cid:tel.png' /> : <?= TELCOMMACHAUD; ?>"
	content = content & "</span></p><br>"
	content = content & "<p class='MsoNormal' align='center' style='text-align:center'>Num&eacute;ro Incident : <span style='color:#1f497d'><?= EcritureCommachaud($incident->getIncident());?></span></p>"
	content = content & "</td></tr></tbody></table><p class='MsoNormal' align='center' style='text-align:center'>Liste des destinataires : <?php $Lbcc=explode(';', $BccFinal); for($i=0;$i<count($Lbcc);$i++){echo "<a href='mailto:".$Lbcc[$i]." target='_blank'>".$Lbcc[$i]."</a>  ";} ?></p></BODY></HTML>"
With objMail
		.SentOnBehalfOfName = "<?= EcritureCommachaud(FROMMAIL); ?>"
		.Subject = "{<?= EcritureCommachaud($STATUTCOMMACHAUD[$incident->getStatut()]); ?>} - [Incident] - <?php if($incident->getPriorite()) echo '['.$PRIORITE[$incident->getPriorite()].'] - ';?> <?= EcritureCommachaud($incident->getTitre());?>"
		.To = "<?= DESTINATAIRE; ?>"
		.Cc = "<?= DESTINATAIRECC; ?>"
		.BCC = "<?= $BccFinal; ?>"
		.HTMLBody = content
		.Display
	End With		
