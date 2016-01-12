<?php
session_start();

if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
	}
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	
$numero=(isset($_GET['id']))?$_GET['id']:'';


define('TITLE',"Modification de l'incident N°<".$numero.">");
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/incidents.php');
require_once('../classes/Application.php');
require_once('../classes/Calendrier.php');
require_once('../classes/Chronogramme.php');


// dateDiffImp('03/01/2016','01/01/2016','');
if (isset($_GET['NumeroIncident'])) {
	$rq="SELECT ID FROM ".SCHEMA.".INCIDENT WHERE INCIDENT='".urlencode($_GET['NumeroIncident'])."'";	 
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->total_record();
			if(isset($res[0])){
				header('Location:modif.php?id='.$res[0][0]);
				die();
			}else
			{
				$_SESSION['flash']['danger']="Le numéro de l'incident n'est pas valide!";
				header('Location:index.php');
				die();
			}
}
if (!$numero) {
	$_SESSION['flash']['danger']="Le numéro de l'incident est vide!";
	header('Location:index.php');
	die();
}

// Creation de l'objet incident
$incident = new incidents();
$impacte=new Impact();
$calendrier= new Calendrier();
$appli=new Application();

if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	/*
	Contrôle des champs obligatoire
	*/
	if(empty($_POST['debutincident'])){
		$errors['debutincident']="Vous devez remplir le champ date début incident!";
	}

	if(!isInteger($_POST['Incident_Impact_jourhommeperdu']) && !empty($_POST['Incident_Impact_jourhommeperdu'])){
		$errors['Incident_Impact_jourhommeperdu']="Le champ jours homme perdu doit etre numérique  !";
	}

	if(empty($_POST['finincident'])){
		$errors['finincident']="Vous devez remplir le champ date fin incident!";
	}

	if (!$_POST['Incident_statut']) {
		$errors['Incident_statut']="Le Statut n'est pas valide!";
	}


	if(empty($_POST['Incident_cause'])){
		$errors['Incident_cause']="Vous devez remplir le champ cause!";
	}

	if(empty($_POST['Incident_retablissement'])){
		$errors['Incident_retablissement']="Vous devez sélectionner une valeur de champ Retablissement!";
	}

	if(empty($_POST['Incident_Impact_datedebut'])){
		$errors['Incident_Impact_datedebut']="Vous devez remplir le champ date début impact!";
	}

	if(empty($_POST['Incident_Impact_datefin'])){
		$errors['Incident_Impact_datefin']="Vous devez remplir le champ date fin impact!";
	}

	if (!$_POST['Incident_Impact_impactmetier']) {
		$errors['Incident_Impact_impactmetier']="L'Immact métier n'est pas valide!";
	}

	if (!$_POST['Incident_Impact_sla']) {
		$errors['Incident_Impact_sla']="Le SLA n'est pas valide!";
	}

	if(empty($_POST['Incident_Impact_description'])){
		$errors['Incident_Impact_description']="Vous devez remplir le champ Description de l'impact!";
	}
	if(empty($_POST['IdAppli'])){
		$errors['IdAppli']="Vous devez remplir le application Impactée!";
	}

	if(empty($_POST['IdIncident'])){
		$errors['IdIncident']="Le numéro de l'incident est vide";
	}else{
		require_once('../classes/db.php');
		$rq="SELECT ID,INCIDENT FROM ".SCHEMA.".INCIDENT WHERE INCIDENT='".urlencode($_POST['IdIncident'])."'";	 
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->total_record();
			if($res && $_POST['IdIncident']== $res[0][1]){
				$errors['IdIncident']="Ce Numéro est déjà utlisé";
			}
		}	




	if(empty($errors))
	{
	//Incident	
	$incident->setIncident($numero,'',$_POST['IdIncident'],$_POST['titreincident'],$_POST['Incident_departement'],$_POST['Incident_statut'],$_POST['Incident_priorite'],$_POST['incidentuserimpacte'],$_POST['debutincident'],$_POST['finincident'],$_POST['Incident_duree'],$_POST['IncImpact_description'],$_POST['Incident_risqueAggravation'],$_POST['Incident_cause'],$_POST['incidentConnex'],$_POST['incidentprobleme'],$_POST['Incident_retablissement'],$_POST['incidentresponsabilite'],$_POST['incidentserviceacteur'],$_POST['Incident_localisation'],$_POST['Incident_useraction'],$_POST['incidentdatecreci'],$_POST['Incident_commentaire'],$_POST['Incident_dejaApparu'],$_POST['Incident_previsible']);
	$incident->sauvegarder();

	//AJout de calendrier
	if (!empty($_POST['IdAppli'])) {

	$calendrier->setParam($_POST['IdCalend'],$_POST['IdAppli'],$_POST['Edit_OuvertLu'],$_POST['Edit_FermerLu'],$_POST['Edit_OuvertMa'],$_POST['Edit_FermerMa'],$_POST['Edit_OuvertMe'],$_POST['Edit_FermerMe'],$_POST['Edit_OuvertJe'],$_POST['Edit_FermerJe'],$_POST['Edit_OuvertVe'],$_POST['Edit_FermerVe'],$_POST['Edit_OuvertSa'],$_POST['Edit_FermerSa'],$_POST['Edit_OuvertDi'],$_POST['Edit_FermerDi'],$_POST['Edit_OuvertJf'],$_POST['Edit_FermerJf']);
	$calendrier->creer();	
	}
	// Impacte
	$impacte->setParam($_POST['IdImpacte'],$numero,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->modifier();

	

	// Chronogramme
		$chrono = new Chronogramme();
		$chrono->DeleteAll($numero);

		if (!empty($_POST['ListeId']))
		{
		$listeIdChrono=explode(',', $_POST['ListeId']);
			for ($i=1; $i < count($listeIdChrono); $i++)
			{ 
			$chrono->setParam(NULL,$numero,$_POST['chrono_input_date_'.$listeIdChrono[$i]],$_POST['chrono_input_activite_'.$listeIdChrono[$i]]);
			$chrono->Creer();
			}
		}
		$_SESSION['flash']['success'] =" L'incident est bien modifié."; 
	//	header('Location:index.php');
	//	die();
	
	}
}else
{

$incident->chargerIncident($numero);
if (empty($incident->getNumero())) {
	$_SESSION['flash']['success'] =" Ce Numéro d'incident n'existe pas!"; 
	header('Location:index.php');
}
//debug($incident);
$impacte->chargerFirstIncident($incident->getNumero());
$appli->SelectAppliById($impacte->getApplicationId());
if ($impacte->getApplicationId()) {
	$idAppli=$impacte->getApplicationId();
	$calendrier->selectById($idAppli);
	//debug($calendrier);
}



}

require_once('../inc/header.inc.php');
if ($incident->getEstOuvert()) {?>
<div class="alert alert-danger">
<?="Cet Incident est Ouvert par ".$incident->getUser().". Il n'est accessible que en lecture!";?>

	</div>
<?php } ?>
<h1>Modifier l'incident n°: <?=$incident->getIncident();?></h1>
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

<?php }
?>

<form action="" method="POST">
<div class="bloc">
<?php 
require_once('../inc/search.inc.php');
?>	
	 <a class="btn btn-success" href="ListeImpact.php?idIncident=<?php echo $_GET['id']; ?>">Impacts</a>
	 <?php
	 $statLink=($incident-> getIdStat())?'modifStat.php?idIncident='.$_GET['id'].'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$_GET['id'];
	 ?>
	  <a class="btn btn-success" href="<?php echo $statLink; ?>">Stat</a>
	  <a  class="btn btn-success" href="javascript:EnvoyerMail('<?= $_GET['id'];?>')" >Comm à chaud</a>
	  <a class="btn btn-danger" href="javascript:supprimer('index.php?id=<?= $_GET['id'];?>&supprimer')" >Supprimer</a>
	 
	<div class="width100 bcg">
		<div class="width100">
		    	<label  class="lib"  for="titreincident"> Incident *</label> 
		    	<input type="text" name="IdIncident" id="IdIncident" value="<?php getVarUpdate('IdIncident',$incident->getIncident()); ?>"  required>
	    	 
	    	</div>
		<div class=" width50 mr_35">
			<div class="width100">
		    	<label  class="lib"  for="titreincident"> Titre Incident</label> 
		    	<input type="text" name="titreincident" id="titreincident" value="<?php getVarUpdate('titreincident',$incident->getTitre()); ?>"  >
	    	</div>

	    	<div class="width100">
  				<div class=" width50">
  					<label  class="lib" for="statut"> Statut *</label>
  					<select id="statut" name="Incident_statut" required>
  						<?php
  						SelectUpdate('Incident_statut',$incident->getStatut(),$STATUT);
  						?>
	        		</select>
  				</div>
  				<div class=" width50 right">
  					<label  class="lib"  for="priorite"> Priorité</label>
  					<select id="priorite" name="Incident_priorite">
  						<?php
  						SelectUpdate('Incident_priorite',$incident->getPriorite(),$PRIORITE);
  						?>
	        		</select>
  				</div>
  			</div>

  			<div class="width100">
  				<div class=" width50">
  					<label  class="lib" for="debutincident"> Début Incident *</label> 
  					<input type="text" name="debutincident"  id="debutincident" value="<?php getVarUpdate('debutincident',$incident->getDateDebut()); ?>" required>
  				</div>
  				<div class=" width50 right">
  					<label  class="lib"  for="finincident"> Fin Incident *</label> 
  					<input type="text" name="finincident" id="finincident"  value="<?php getVarUpdate('finincident',$incident->getDateFin()); ?>" required>
  				</div>
  			</div>

  			<div class="width100">
  				<div class=" width50">
  					<label  class="lib" for="Incident_duree"> Durée Incident</label>
  					<input type="text" id="Incident_duree" name="Incident_duree" maxlength="255"  value="<?php getVarUpdate('Incident_duree',$incident->getDuree()); ?>">
  				</div>

  				<div class=" width50 right">
  					<br/>
  					<label  class="lib">
  						<input type="checkbox" id="Incident_risqueAggravation" name="Incident_risqueAggravation" value="0" <?php CheckUpdate('Incident_risqueAggravation',$incident->getRisqueAggravation()); ?>>
                        Risque aggravation
           			</label>
  				</div>
  			</div>

		   	<div class="width100">
		    			<label  class="lib" for="incidentConnex"> Incidents connexes</label> 
		    			<input type="text" name="incidentConnex"  id="incidentConnex" value="<?php getVarUpdate('incidentConnex',$incident->getConnexe()); ?>">
		   	</div>

		    <div class="width100">
		   			<label  class="lib" for="incidentprobleme">Problème</label> 
		   			<input type="text" name="incidentprobleme" id="incidentprobleme"  value="<?php getVarUpdate('incidentprobleme',$incident->getProbleme()); ?>">
 		    </div>

		   	<div class="width100">
		    	<div class=" width50">
				    	<label  class="lib" for="incidentresponsabilite"> Responsabilité</label> 
						<select name="incidentresponsabilite"  id="incidentresponsabilite">
			    		<?php
  						SelectUpdate('incidentresponsabilite',$incident->getResponsabilite(),$RESPONSABILITE);
  						?>
			    		</select>
		    	</div>
	  		
	  			<div class=" width50 right">
	  				<label  class="lib" for="incidentserviceacteur"> Service Acteur</label>
	  				<select name="incidentserviceacteur" id="incidentserviceacteur">
	  					<?php
  						SelectUpdate('incidentserviceacteur',$incident->getActeur(),$SERVICEACTEUR);
  						?>
		     
		        	</select>
	  			</div>
	  		</div>

	  		<div class=" width100">
	  			<label  class="lib" for="incidentdatecreci"> Date du publication</label> 
	  			<input type="text"  name="incidentdatecreci" id="incidentdatecreci" value="<?php getVarUpdate('incidentdatecreci',$incident->getDateCreci()); ?>" >
	  		</div>

	  		<div class=" width100">
	  			<div class=" width50">
	  				<label class="lib"><input type="checkbox" id="Incident_dejaApparu" name="Incident_dejaApparu" <?php CheckUpdate('Incident_dejaApparu',$incident->getDejaApparu()); ?>>
                        Déja apparu
            		</label>
            	</div>
            		
            	<div class=" width50">
	  				<label class="lib"><input type="checkbox" id="Incident_previsible" name="Incident_previsible" <?php CheckUpdate('Incident_previsible',$incident->getPrevisible()); ?>>
                        Prévisible
            		</label>
            	</div>
	  		</div>
	  	</div>
		
		<div class=" width50">
			<div class="width100">
		    			<label  class="lib" for="Incident_departement"> Département</label> 
		    			<input type="text" name="Incident_departement"  id="Incident_departement" value="<?php getVarUpdate('Incident_departement',$incident->getDepartement()); ?>">
		   	</div>

		    <div class="width100">
		   			<label  class="lib" for="incidentuserimpacte">Utilisateurs impactés</label> 
		   			<input type="text" name="incidentuserimpacte" id="incidentuserimpacte" value="<?php getVarUpdate('incidentuserimpacte',$incident->getUtilisImpacte()); ?>" >
		    </div>
		
	    	<div class="width100">
  				<label class="lib" for="Incident_IncImpact_description">Description de l'incident *</label>
  				<textarea  rows="3" id="IncImpact_description" name="IncImpact_description" required><?php getVarUpdate('IncImpact_description',$incident->getDescripIncident()); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_cause">Cause*</label>
  				<textarea  rows="3" id="Incident_cause" name="Incident_cause" required><?php getVarUpdate('Incident_cause',$incident->getCause()); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_retablissement" >Retablissement *</label>
  				<select id="Incident_retablissement" name="Incident_retablissement" required>
  				<?php SelectUpdate('Incident_retablissement',$incident->getRetablissement(),$RETABLISSEMENT); ?>
  				</select>
  			</div>

  			<div class="width100">
  				<div class=" width50">
  					<label class="lib" for="Incident_localisation">Localisation</label>
  					<textarea  rows="3" id="Incident_localisation" name="Incident_localisation"><?php getVarUpdate('Incident_localisation',$incident->getLocalisation()); ?></textarea>
  				</div>

  				<div class=" width50 right">
  					<label class="lib" for="Incident_useraction">Actions utilisateur</label>
  					<textarea  rows="3" id="Incident_useraction" name="Incident_useraction"><?php getVarUpdate('Incident_useraction',$incident->getActionUtlisateur()); ?></textarea>
  				</div>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_commentaire">Commentaire</label>
  				<textarea  rows="3" id="Incident_commentaire" name="Incident_commentaire"><?php getVarUpdate('Incident_commentaire',$incident->getCommentaire()); ?></textarea>
  			</div>
  		</div>
  			<?php require_once('../inc/impactmodif.inc.php'); ?>
  			<div class=" width50">
	    		<label class="lib" style="float:left;">Chronogramme</label> 
	    		<input type="button" value="+" class="btn-plus" id="btn_chrono">

	    			<div id="element_to_pop_up3">
    					<a class="b-close">x</a>
					Ajout d'un chronogramme
					
    					<label for="dateChrono" class="lib">Date</label>
    					<input type="text" id="dateChrono" name="dateChrono" >
    				

    				
    					<label for="ativiteChrono" class="lib">Activité</label>
    					<input type="text" id="ativiteChrono" name="ativiteChrono" >

    					<input type="button" value="Ajouter" onclick="CreateActivite()">
    				</div>

    				

	    			<table class="table"  id="table-chrono">
						<tr>
							<td align="center"><label class="lib"> Date </label></td>
							<td align="center"><label class="lib"> Activité</label></td>
		           			<td width="70px"></td>
		           			<td width="70px"></td>
           				</tr>
           			<tbody id="ChronosLignes">
           			<?php
				           	$chrono= new Chronogramme();
							$taches=$chrono->getChronogrammeByIncidentId($numero);		
							$ListeId="";		

			if(count($taches))
			{
				
				foreach ($taches as $ligne)
				{
					$idChrono=$ligne->getId();
					echo '<tr id="ligne_'.$idChrono.'">';
					echo '<td><span id="chrono_date_'.$idChrono.'">'.$ligne->getActionDate().'</span><input type="text" id="chrono_input_date_'.$idChrono.'" name="chrono_input_date_'.$idChrono.'" value="'.$ligne->getActionDate().'"  style="display:none;" /></td>';
					echo '<td><span id="chrono_activite_'.$idChrono.'">'.$ligne->getDescription().'</span><input type="text" id="chrono_input_activite_'.$idChrono.'" name="chrono_input_activite_'.$idChrono.'" value="'.$ligne->getDescription().'"  style="display:none;" /></td>';
					echo '<td><input type="button" value="Modifier" id="chrono_modif_'.$idChrono.'" Onclick="Modifier('.$idChrono.')" /><input type="button" value="Valider" id="chrono_valid_'.$idChrono.'" Onclick="Valider('.$idChrono.')" style="display:none;"/></td>';
					echo '<td><input type="button" value="Supprimer" id="chrono_suppri_'.$idChrono.'" Onclick="Supprimer('.$idChrono.')" /><input type="button" value="Annuler" id="chrono_annul_'.$idChrono.'" Onclick="Annuler('.$idChrono.')" style="display:none;"/></td>';
					echo "</tr>";
					$ListeId.=','.$idChrono;
				}
			}else echo '<tr><td colspan="5" align="center"><b>Pas d\'activitées</b></tr>';
					?>
					</tbody>
           			</table>
           			<input type="hidden" id="ListeId" name="ListeId" value="<?= $ListeId;?>" />
	    		</div>
    		</div>
    	</fieldset>

		<input type="submit" value="Sauvegarder" name="submit" />
	</div>

</div>

</form>
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

<?php 
require_once('../inc/footer.inc.php');
?>