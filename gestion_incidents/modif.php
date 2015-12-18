<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
			 	 die();
			 

	}
$numero=(isset($_GET['id']))?$_GET['id']:'';
define('TITLE',"Modification de l'incident N°<".$numero.">");
require_once('../inc/config.inc.php');
require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/incidents.php');
require_once('../classes/Application.php');
require_once('../inc/header.inc.php');

if (!$numero) {
	$_SESSION['flash']['danger']="Le numéro de l'incident est vide!";
	header('Location:index.php');
	die();
}

// Creation de l'objet incident
$incident = new incidents();

if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	/*
	Contrôle des champs obligatoire
	*/
	if (!$_POST['Incident_statut']) {
		$errors['Incident_statut']="Le Statut n'est pas valide!";
	}


	if(empty($_POST['Incident_cause'])){
		$errors['Incident_cause']="Vous devez remplir le champ cause!";
	}

	if(empty($_POST['Incident_Impact_datedebut'])){
		$errors['Incident_cause']="Vous devez remplir le champ début impact!";
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


	if(empty($errors))
	{
	//Incident	
	
	$incident->setIncident($numero,$_POST['titreincident'],$_POST['Incident_departement'],$_POST['Incident_statut'],$_POST['Incident_priorite'],$_POST['incidentuserimpacte'],$_POST['debutincident'],$_POST['finincident'],$_POST['Incident_duree'],addslashes($_POST['IncImpact_description']),$_POST['Incident_risqueAggravation'],$_POST['Incident_cause'],$_POST['incidentConnex'],$_POST['incidentprobleme'],$_POST['Incident_retablissement'],$_POST['incidentresponsabilite'],$_POST['incidentserviceacteur'],$_POST['Incident_localisation'],$_POST['Incident_useraction'],$_POST['incidentdatecreci'],$_POST['Incident_commentaire'],$_POST['Incident_dejaApparu'],$_POST['Incident_previsible']);
	$incident->sauvegarder();

	// Impacte
	$impacte=new Impact();
	$impacte->setParam($_POST['IdImpacte'],$numero,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->modifier();

	$_SESSION['flash']['success'] =" L'incident est bien modifié."; 
		header('Location:index.php');
	
	}
}else
{
$incident->chargerIncident($numero);
$impacte= new Impact();
$impacte->chargerFirstIncident($numero);
$appli= new Application();
$appli->SelectAppliById($impacte->getApplicationId());
//debug($appli);
}
?>
<h1>Modifier l'incident n°: <?=$numero;?></h1>
<?php
if(!empty($errors)){?>
	<div class="alert alert-danger">
	<ul>
	<p>Vous avez des erreurs dans le remplissage de votre formulaire</p>
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
	<div class="width100 input-group-addon">
		<label class="lib width50"> N°Incident </label> <input type="number" name="numincident" size="12" > <input type="button" value="?" onclick="info()">
		<input type="button" value="<" onclick="prec()"> 
		<input type="button" value=">" onclick="suiv()">
		<input type="button" value=">>" onclick="lastone()">
		<span class="fl-left">
	      <button class="btn btn-success" type="button">Ajouter</button>
	    </span></div>

	<div class="width100 bcg">
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
  					<label  class="lib" for="debutincident"> Début Incident</label> 
  					<input type="datetime" name="debutincident"  id="debutincident" value="<?php getVarUpdate('debutincident',$incident->getDateDebut()); ?>">
  				</div>
  				<div class=" width50 right">
  					<label  class="lib"  for="finincident"> Fin Incident</label> 
  					<input type="datetime" name="finincident" id="finincident"  value="<?php getVarUpdate('finincident',$incident->getDateFin()); ?>">
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
	  			<label  class="lib" for="incidentdatecreci"> Date du Creci</label> 
	  			<input type="date"  name="incidentdatecreci" id="incidentdatecreci" value="<?php getVarUpdate('incidentdatecreci','"'.$incident->getDateCreci().'"'); ?>" >
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
  				<label class="lib" for="Incident_IncImpact_description">Description de l'incident*</label>
  				<textarea  rows="3" id="IncImpact_description" name="IncImpact_description" required><?php getVarUpdate('IncImpact_description',$incident->getDescripIncident()); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_cause">Cause*</label>
  				<textarea  rows="3" id="Incident_cause" name="Incident_cause" required><?php getVarUpdate('Incident_cause',$incident->getCause()); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_retablissement">Retablissement</label>
  				<textarea  rows="3" id="Incident_retablissement" name="Incident_retablissement"><?php getVarUpdate('Incident_retablissement',$incident->getRetablissement()); ?></textarea>
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

  		<fieldset>
    		<legend>Application Impactée</legend>
    		<div class=" width50 mr_35"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_application_libelle"> Application</label> 
		    		<input type="text" name="Incident_Impact_application_libelle" id="Incident_Impact_application_libelle"  value="<?php getVarUpdate('Incident_Impact_application_libelle',$appli->getName()); ?>" disabled>
					<input id="IdAppli" name="IdAppli" type="hidden" value="<?php getVarUpdate('IdAppli',$appli->getId()); ?>" />	    		
	    			<input id="IdImpacte" name="IdImpacte" type="hidden" value="<?php getVarUpdate('IdImpacte',$impacte->getId()); ?>" />
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_datedebut"> Début impact *</label> 
		    			<input type="text" name="Incident_Impact_datedebut" id="Incident_Impact_datedebut" value="<?php getVarUpdate('Incident_Impact_datedebut',$impacte->getDateDebut()); ?>" required>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact </label> 
		    			<input type="text" name="Incident_Impact_datefin" id="Incident_Impact_datefin"  value="<?php getVarUpdate('Incident_Impact_datefin',$impacte->getDateFin()); ?>">
	    			</div>	    			
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_impactmetier"> Impact métier *</label> 
		    			<select id="Incident_Impact_impactmetier" name="Incident_Impact_impactmetier" required>
		    			<?php
		    			SelectUpdate('Incident_Impact_impactmetier',$impacte->getImpactMetier(),$IMPACTMETIER);
		    			?>
		    			</select>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_impact"> Impact</label> 
		    			<select id="Incident_Impact_impact" name="Incident_Impact_impact">
		    			<?php
		    			SelectUpdate('Incident_Impact_impact',$impacte->getImpact(),$INCIDENTIMPACTMETIER);
		    			?>
		    			</select>
	    			</div>	    			
	    		</div>
    		</div>

    		<div class=" width50">

    			<div class="width100">

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_enseigne" class="lib">Enseigne</label>
    					<input disabled="" type="text" id="Incident_Impact_application_enseigne" name="Incident_Impact_application_enseigne" value="<?php getVarUpdate('Incident_Impact_application_enseigne',$appli->getEnseigne()); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_irt" class="lib">Code IRT</label>
    					<input disabled="" type="text" id="Incident_Impact_application_irt" name="Incident_Impact_application_irt" value="<?php getVarUpdate('Incident_Impact_application_irt',$appli->getIrt()); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_trigramme" class="lib">Trigramme</label>
    					<input disabled="" type="text" id="Incident_Impact_application_trigramme" name="Incident_Impact_application_trigramme" value="<?php getVarUpdate('Incident_Impact_application_trigramme',$appli->getTrigramme()); ?>">
    				</div>

    				<div class="width12 mr_7">
    					<a class="btn_calendrier" id="btn_calendrier" href="#" title="calendrier">
                        	<img alt="calendrier" src="../img/calendar.png">
                    	</a>
                    </div>

                    <div class="width12">
	                    <a class="btn_info" id="btn_info" href="#" title="informations">
	                        <img alt="Informations sur l'application" src="../img/search.png">
	                    </a>
	                </div>


    			</div>

    			<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_dureereelle"> Durée réelle </label> 
		    			<input type="text" name="Incident_Impact_dureereelle" id="Incident_Impact_dureereelle" value="<?php getVarUpdate('Incident_Impact_dureereelle',$impacte->getDureeReelle()); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_jourhommeperdu"> Jour homme perdu</label> 
		    			<input type="text" name="Incident_Impact_jourhommeperdu" id="Incident_Impact_jourhommeperdu" value="<?php getVarUpdate('Incident_Impact_jourhommeperdu',$impacte->getJourHomme()); ?>" >
	    			</div>	    			
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_sla"> SLA *</label> 
		    			<select id="Incident_Impact_sla" name="Incident_Impact_sla" required>
		    			<?php
		    			SelectUpdate('Incident_Impact_sla',$impacte->getSla(),$SLA);
		    			?>
		    			</select>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_criticite"> Criticité</label> 
		    			<select id="Incident_Impact_criticite" name="Incident_Impact_criticite">
		    			<?php
		    			SelectUpdate('Incident_Impact_criticite',$impacte->getSeverite(),$CRITICITE);
		    			?>
		    			</select>
	    			</div>	    			
	    		</div>

    		</div>

    		<div class="width100">
                <label class="lib" for="Incident_Impact_description">Description de l'impact *</label>
                <textarea id="Incident_Impact_description" name="Incident_Impact_description" required maxlength="4000"><?php getVarUpdate('Incident_Impact_description',$impacte->getDescription()); ?></textarea>
    		</div>
    	</fieldset>

		<input type="submit" value="Sauvegarder" name="submit" />
	</div>

</div>

</form>

<?php 
require_once('../inc/footer.inc.php');
?>