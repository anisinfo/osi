<textarea id="sujet"  style="display:none;">{<?= $STATUTCOMMACHAUD[$incident->getStatut()]; ?>} - [<?= $incident->getIncident();?>] - <?php if($incident->getPriorite()) echo '['.$PRIORITE[$incident->getPriorite()].']';?> - [RETAIL][<?= $application->getEnseigne();?>][<?= $application->getName();?>] - <?= $incident->getTitre();?></textarea>
<textarea  id="corp"  style="display:none;">
<img src="<?= RACINE; ?>img/logo.png" /><br /><br />
<table border="1" cellspacing="0" cellpadding="0" style="border:outset #767676 3.0pt" width="100%">
	<tbody>
		<tr>
			<td style="background: <?= $STATUTCOLOR[$incident->getStatut()];?>;padding:.75pt .75pt .75pt .75pt" colspan="2" align="center">
				
				<b><span style="font-size:18.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;">
				INCIDENT : <?= $STATUT[$incident->getStatut()]; ?>
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
				<span style="font-size:11.0pt;font-family:&quot;Arial&quot;,&quot;sans-serif&quot;;color:crimson"><?php if($incident->getPriorite()) echo $PRIORITE[$incident->getPriorite()];?></span>
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
			<?= $incident->getChronogramme(); ?>
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