<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
			 

	}

define('TITLE','Ajouter un incident');
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/Impact.php');
require_once('../classes/incidents.php');
require_once('../classes/Calendrier.php');
require_once('../classes/Application.php');
require_once('../classes/db.php');
//$dbc = new PDO('oci:dbname='.HOST.':'.PORT.'/'.SCHEMA.';charset=CL8MSWIN1251', SCHEMA_LOGIN, SCHEMA_PASS);
if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	

	/*
	Contrôle des champs obligatoire
	*/
	if(empty($_POST['debutincident'])){
		$errors['debutincident']="Vous devez remplir le champ date début incident!".$_POST['debutincident'];
	}

	if(!isInteger($_POST['Incident_Impact_jourhommeperdu']) && !empty($_POST['Incident_Impact_jourhommeperdu'])){
		$errors['Incident_Impact_jourhommeperdu']="Le champ jours homme perdu doit etre numérique  !";
	}

	if (!$_POST['Incident_statut']) {
		$errors['Incident_statut']="Le Statut n'est pas valide!";
	}


	if(empty($_POST['Incident_cause'])){
		$errors['Incident_cause']="Vous devez remplir le champ cause!";
	}
	if(empty($_POST['Incident_suivi'])){
		$errors['Incident_suivi']="Vous devez sélectionner une valeur de champ Suivi!";
	}

	if(empty($_POST['Incident_Impact_datedebut'])){
		$errors['Incident_Impact_datedebut']="Vous devez remplir le champ date début impact!";
	}

	if (!$_POST['Incident_Impact_impactmetier']) {
		$errors['Incident_Impact_impactmetier']="L'Immact métier n'est pas valide!";
	}

	if(empty($_POST['Incident_Impact_description'])){
		$errors['Incident_Impact_description']="Vous devez remplir le champ Description de l'impact!";
	}
	if(empty($_POST['IdAppli'])){
		$errors['IdAppli']="Vous devez remplir le application Impactée!";
	}


	$reg='/^[0-2]?[0-9]:[0-5][0-9]$/';

	if(!preg_match($reg,$_POST['Edit_OuvertJf']))
		{$errors['Edit_OuvertJf']="Le format d'heure d'ouverture de Jour Férier n'est pas valide";}

	if(!preg_match($reg,$_POST['Edit_FermerJf']))
		{$errors['Edit_FermerJf']="Le format d'heure de fermiture de Jour Férier n'est pas valide";}

	if(!preg_match($reg,$_POST['Edit_OuvertLu']))
		{$errors['Edit_OuvertLu']="Le format d'heure d'ouverture de Lundi n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerLu']))
		{$errors['Edit_FermerLu']="Le format d'heure de fermiture de Lundi n'est pas valide";}

	if(!preg_match($reg,$_POST['Edit_OuvertMa']))
		{$errors['Edit_OuvertMa']="Le format d'heure d'ouverture de Mardi n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerMa']))
		{$errors['Edit_FermerMa']="Le format d'heure de fermiture de Mardi n'est pas valide".$_POST['Edit_FermerMa'];}

	if(!preg_match($reg,$_POST['Edit_OuvertMe']))
		{$errors['Edit_OuvertMe']="Le format d'heure d'ouverture de Mercredi n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerMe']))
		{$errors['Edit_FermerMe']="Le format d'heure de fermiture de Mercredi n'est pas valide";}
		
	if(!preg_match($reg,$_POST['Edit_OuvertJe']))
		{$errors['Edit_OuvertJe']="Le format d'heure d'ouverture de Jeudi n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerJe']))
		{$errors['Edit_FermerJe']="Le format d'heure de fermiture de Jeudi n'est pas valide";}

	if(!preg_match($reg,$_POST['Edit_OuvertVe']))
		{$errors['Edit_OuvertVe']="Le format d'heure d'ouverture de Vendredi n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerVe']))
		{$errors['Edit_FermerVe']="Le format d'heure de fermiture de Vendredi n'est pas valide";}
		
	if(!preg_match($reg,$_POST['Edit_OuvertSa']))
		{$errors['Edit_OuvertSa']="Le format d'heure d'ouverture de Samedi n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerSa']))
		{$errors['Edit_FermerSa']="Le format d'heure de fermiture de Samedi n'est pas valide";}
		
	if(!preg_match($reg,$_POST['Edit_OuvertDi']))
		{$errors['Edit_OuvertDi']="Le format d'heure d'ouverture de Dimanche n'est pas valide";}	

	if(!preg_match($reg,$_POST['Edit_FermerDi']))
		{$errors['Edit_FermerDi']="Le format d'heure de fermiture de Dimanche n'est pas valide";}						


	if(empty($_POST['IdIncident'])){
		$errors['IdIncident']="Le numéro de l'incident est vide";
	}else{
		require_once('../classes/db.php');
		$rq="SELECT ID FROM ".SCHEMA.".INCIDENT WHERE INCIDENT='".urlencode($_POST['IdIncident'])."'";	 
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->total_record();
			if($res){
				$errors['IdIncident']="Ce Numéro est déjà utlisé";
			}
		}	


	if(empty($errors))
	{
	$incident = new incidents();
	$incident->setIncident(NULL,'',$_POST['IdIncident'],$_POST['titreincident'],$_POST['Incident_departement'],$_POST['Incident_statut'],$_POST['Incident_priorite'],$_POST['incidentuserimpacte'],$_POST['debutincident'],$_POST['finincident'],$_POST['Incident_duree'],$_POST['IncImpact_description'],$_POST['Incident_risqueAggravation'],$_POST['Incident_cause'],$_POST['incidentConnex'],$_POST['incidentprobleme'],$_POST['Incident_retablissement'],$_POST['incidentresponsabilite'],$_POST['incidentserviceacteur'],$_POST['Incident_localisation'],$_POST['Incident_useraction'],$_POST['incidentdatecreci'],$_POST['Incident_commentaire'],$_POST['Incident_dejaApparu'],$_POST['Incident_previsible'],$_POST['Incident_suivi'],$_POST['incidentdatedecision'],$_POST['Incident_chronogramme']);
	$id_incident=$incident->sauvegarder();
	$_SESSION['flash']['success'] =" L'incident est bien ajouté."; 
	 // Ajoutde l'impact
	$imp = new Impact();
	$imp->setParam(NULL,$id_incident,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$imp->creer();

	//AJout de calendrier
	if (!empty($_POST['IdAppli'])) {
	$calendrier= new Calendrier();
	$calendrier->setParam(NULL,$_POST['IdAppli'],$_POST['Edit_OuvertLu'],$_POST['Edit_FermerLu'],$_POST['Edit_OuvertMa'],$_POST['Edit_FermerMa'],$_POST['Edit_OuvertMe'],$_POST['Edit_FermerMe'],$_POST['Edit_OuvertJe'],$_POST['Edit_FermerJe'],$_POST['Edit_OuvertVe'],$_POST['Edit_FermerVe'],$_POST['Edit_OuvertSa'],$_POST['Edit_FermerSa'],$_POST['Edit_OuvertDi'],$_POST['Edit_FermerDi'],$_POST['Edit_OuvertJf'],$_POST['Edit_FermerJf']);
	$calendrier->creer();
	}
	
	$_SESSION['flash']['success'] =" L'incident est bien ajouté."; 

	header('Location:index.php');
	die();
	# code...
	}
}
require_once('../inc/header.inc.php');
?>
<h1>Ajouter un incident</h1>
<?php
if(!empty($errors)){?>
	<div class="alert alert-danger">
	<h5>Vous avez des erreurs dans le remplissage de votre formulaire</h5>
	<ul>
	
		<?php
		foreach ($errors as $error) {
			echo '<li>'.$error.'</li>';
		}
		?>
		</ul>
	</div>

<?php } ?>
<form action="" method="POST">
<div class="bloc">
<?php 
$incident= new incidents();
$idIncident=(isset($_GET['IdIncident']))?$_GET['IdIncident']:'';
if ($idIncident) {
	$incident->chargerIncident($idIncident);
}
require_once('../inc/search.inc.php');
?>
	<div class="width100 bcg">
		<div class=" width50 mr_35">
			<div class="width100">
		    	<label  class="lib"  for="titreincident"> Incident *</label> 
		    	<input type="text" name="IdIncident" id="IdIncident" value="<?php getVar('IdIncident'); ?>"  required>
		    	
	    	</div>

			<div class="width100">
		    	<label  class="lib"  for="titreincident"> Titre Incident</label> 
		    	<input type="text" name="titreincident" id="titreincident" value="<?php getVar('titreincident'); ?>"  >
	    	</div>

	    	<div class="width100">
  				<div class=" width50">
  					<label  class="lib" for="statut"> Statut *</label>
  					<select id="statut" name="Incident_statut" required>
  						<?php
  						Select('Incident_statut',$STATUT);
  						?>
	        		</select>
  				</div>
  				<div class=" width50 right">
  					<label  class="lib"  for="priorite"> Priorité</label>
  					<select id="priorite" name="Incident_priorite">
  						<?php
  						Select('Incident_priorite',$PRIORITE);
  						?>
	        		</select>
  				</div>
  			</div>

  			<div class="width100">
  				<div class=" width50">
  					<label  class="lib" for="debutincident"> Début Incident *</label> 
  					<input type="text" name="debutincident"  id="debutincident" value="<?php getVar('debutincident'); ?>" required>
  				</div>
  				<div class=" width50 right">
  					<label  class="lib"  for="finincident"> Fin Incident</label> 
  					<input type="text" name="finincident" id="finincident"  value="<?php getVar('finincident'); ?>" required>
  				</div>
  			</div>

  			<div class="width100">
  				<div class=" width50">
  					<label  class="lib" for="Incident_duree"> Durée Incident</label>
  					<input type="text" id="Incident_duree" name="Incident_duree" maxlength="255"  value="<?php getVar('Incident_duree'); ?>">
  				</div>

  				<div class=" width50 right">
  					<br/>
  					<label  class="lib">
  						<input type="checkbox" id="Incident_risqueAggravation" name="Incident_risqueAggravation" value="0" <?php Check('Incident_risqueAggravation'); ?>>
                        Risque aggravation
           			</label>
  				</div>
  			</div>

		   	<div class="width100">
		    			<label  class="lib" for="incidentConnex"> Incidents connexes</label> 
		    			<input type="text" name="incidentConnex"  id="incidentConnex" value="<?php getVar('incidentConnex'); ?>">
		   	</div>

		    <div class="width100">
		   			<label  class="lib" for="incidentprobleme">Problème</label> 
		   			<input type="text" name="incidentprobleme" id="incidentprobleme"  value="<?php getVar('incidentprobleme'); ?>">
 		    </div>

		   	<div class="width100">
		    	<div class=" width50">
				    	<label  class="lib" for="incidentresponsabilite"> Responsabilité</label> 
						<select name="incidentresponsabilite"  id="incidentresponsabilite">
			    		<?php
  						Select('incidentresponsabilite',$RESPONSABILITE);
  						?>
			    		</select>
		    	</div>
	  		
	  			<div class=" width50 right">
	  				<label  class="lib" for="incidentserviceacteur"> Service Acteur</label>
	  				<select name="incidentserviceacteur" id="incidentserviceacteur">
	  					<?php
  						Select('incidentserviceacteur',$SERVICEACTEUR);
  						?>
		     
		        	</select>
	  			</div>
	  		</div>

	  		<div class=" width100">
	  			<label  class="lib" for="incidentdatecreci"> Date du publication</label> 
	  			<input type="text"  name="incidentdatecreci" id="incidentdatecreci" value="<?php getVar('incidentdatecreci'); ?>" >
	  		</div>

	  		<div class=" width100">
	  			<label  class="lib" for="incidentdatedecision"> Date du prise de décision</label> 
	  			<input type="text"  name="incidentdatedecision" id="incidentdatedecision" value="<?php getVar('incidentdatedecision'); ?>" >
	  		</div>

	  		<div class=" width100">
	  			<div class=" width50">
	  				<label class="lib"><input type="checkbox" id="Incident_dejaApparu" name="Incident_dejaApparu" <?php Check('Incident_dejaApparu'); ?>>
                        Déja apparu
            		</label>
            	</div>
            		
            	<div class=" width50">
	  				<label class="lib"><input type="checkbox" id="Incident_previsible" name="Incident_previsible" <?php Check('Incident_previsible'); ?>>
                        Prévisible
            		</label>
            	</div>
	  		</div>
	  	</div>
		
		<div class=" width50">
			<div class="width100">
		    			<label  class="lib" for="Incident_departement"> Département</label> 
		    			<input type="text" name="Incident_departement"  id="Incident_departement" value="<?php getVar('Incident_departement'); ?>">
		   	</div>

		    <div class="width100">
		   			<label  class="lib" for="incidentuserimpacte">Utilisateurs impactés</label> 
		   			<input type="text" name="incidentuserimpacte" id="incidentuserimpacte" value="<?php getVar('incidentuserimpacte'); ?>" >
		    </div>
		
	    	<div class="width100">
  				<label class="lib" for="Incident_IncImpact_description">Description de l'incident *</label>
  				<textarea  rows="3" id="IncImpact_description" name="IncImpact_description" required><?php getVar('IncImpact_description'); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_cause">Cause*</label>
  				<textarea  rows="3" id="Incident_cause" name="Incident_cause" required><?php getVar('Incident_cause'); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_retablissement">Retablissement</label>
  				<textarea id="Incident_retablissement" name="Incident_retablissement"><?php getVar('Incident_retablissement'); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_suivi">Suivi *</label>
  				<select id="Incident_suivi" name="Incident_suivi" required>
				<?php Select('Incident_suivi',$SUIVI); ?>
				</select>
  			</div>

  			<div class="width100">
  				<div class=" width50">
  					<label class="lib" for="Incident_localisation">Localisation</label>
  					<textarea  rows="3" id="Incident_localisation" name="Incident_localisation"><?php getVar('Incident_localisation'); ?></textarea>
  				</div>

  				<div class=" width50 right">
  					<label class="lib" for="Incident_useraction">Actions utilisateur</label>
  					<textarea  rows="3" id="Incident_useraction" name="Incident_useraction"><?php getVar('Incident_useraction'); ?></textarea>
  				</div>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_commentaire">Commentaire</label>
  				<textarea  rows="3" id="Incident_commentaire" name="Incident_commentaire"><?php getVAr('Incident_commentaire'); ?></textarea>
  			</div>
  		</div>

		<?php require_once('../inc/impact.inc.php'); ?>
		<div class=" width50">
	    		<label class="lib" style="float:left;">Chronogramme</label>
	    		<textarea name="Incident_chronogramme" id="Incident_chronogramme"><?php getVar('Incident_chronogramme'); ?></textarea>

	    		</div>
    		</div>
    	</fieldset>  		
		<input type="submit" value="Sauvegarder" name="submit" />

	</div>

</div>

</form>

<?php 
$impacte= new Impact();
if ($idIncident) {
	$impacte->chargerFirstIncident($idIncident);
	$application= new Application();
	$application->SelectAppliById($impacte->getApplicationId());
require_once('../inc/commachaud.inc.php');
}
require_once('../inc/footer.inc.php');
?>