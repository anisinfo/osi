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


if (isset($_GET['NumeroIncident'])) {
	$rq="SELECT ID FROM ".SCHEMA.".INCIDENT WHERE INCIDENT='".htmlentities($_GET['NumeroIncident'],ENT_QUOTES | ENT_IGNORE, "UTF-8")."'";	 
			$db= new db();
			$db->db_connect();
			$db->db_query($rq);
			$res=$db->db_fetch_array();
			if(isset($res[0])){
				header('Location:modif.php?id='.$res[0][0]);
				die();
			}else
			{
				$_SESSION['flash']['danger']="Le numéro de l'incident n'est pas dans la base!";
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
//Récupération de contenu du fichier Json
$contenu_fichier_json=file_get_contents('../inc/TraceFiche.json');
$tr = json_decode($contenu_fichier_json, true);
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
		{$errors['Edit_FermerMa']="Le format d'heure de fermiture de Mardi n'est pas valide";}

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
	$incident->setIncident($numero,'',$_POST['IdIncident'],$_POST['titreincident'],$_POST['Incident_departement'],$_POST['Incident_statut'],$_POST['Incident_priorite'],$_POST['incidentuserimpacte'],$_POST['debutincident'],$_POST['finincident'],$_POST['Incident_duree'],$_POST['IncImpact_description'],$_POST['Incident_risqueAggravation'],$_POST['Incident_cause'],$_POST['incidentConnex'],$_POST['incidentprobleme'],$_POST['Incident_retablissement'],$_POST['incidentresponsabilite'],$_POST['incidentserviceacteur'],$_POST['Incident_localisation'],$_POST['Incident_useraction'],$_POST['incidentdatecreci'],$_POST['Incident_commentaire'],$_POST['Incident_dejaApparu'],$_POST['Incident_previsible'],$_POST['Incident_suivi'],$_POST['incidentdatedecision'],$_POST['Incident_chronogramme']);
	$incident->sauvegarder();

	//AJout de calendrier
	if (!empty($_POST['IdAppli']))
	{
	$calendrier->setParam($_POST['IdCalend'],$_POST['IdAppli'],$_POST['Edit_OuvertLu'],$_POST['Edit_FermerLu'],$_POST['Edit_OuvertMa'],$_POST['Edit_FermerMa'],$_POST['Edit_OuvertMe'],$_POST['Edit_FermerMe'],$_POST['Edit_OuvertJe'],$_POST['Edit_FermerJe'],$_POST['Edit_OuvertVe'],$_POST['Edit_FermerVe'],$_POST['Edit_OuvertSa'],$_POST['Edit_FermerSa'],$_POST['Edit_OuvertDi'],$_POST['Edit_FermerDi'],$_POST['Edit_OuvertJf'],$_POST['Edit_FermerJf']);
	$calendrier->creer();	
	}
	// Impacte
	$impacte->setParam($_POST['IdImpacte'],$numero,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->modifier();
	$_SESSION['flash']['success'] =" L'incident est bien modifié."; 	
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

// Tester l'existance de la fiche
if (isset($tr[$numero])) {
	$dureeR=time()-$tr[$numero]['date_ouverture'];
	if (is_array($tr)) {
	foreach ($tr as $key => $value)
	{
	if ($value['user']==$userConnected && $key != $numero) {
		unset($tr[$key]);
	}
	}
	}
	if($dureeR >= DUREE)
	{
		$tr[$numero]['user'] = $userConnected;
		$tr[$numero]['date_ouverture']=time();
		$incident->_setEstOuvert(false);

	}else
	{
		if ($tr[$numero]['user'] == $userConnected)
		{
		$tr[$numero]['date_ouverture']=time();
		$incident->_setEstOuvert(false);		
		}else
		{
		$incident->_setUser($tr[$numero]['user']);
		$incident->_setEstOuvert(true);
		}	

	}
}else
{
	if (is_array($tr)) {
	foreach ($tr as $key => $value)
	{
	if ($value['user']==$userConnected) {
		unset($tr[$key]);
	}
	}
	}
	$tr[$numero]['date_ouverture']=time();
	$tr[$numero]['user'] = $userConnected;
	$incident->_setEstOuvert(false);
}
$json=json_encode($tr);
file_put_contents('../inc/TraceFiche.json', $json);
}

require_once('../inc/header.inc.php');
if ($incident->getEstOuvert()) {?>
<div class="alert alert-danger">
<?="Cet Incident est ouvert par ".$incident->getUser()." depuis le ".date("d/m/Y à H:i:s",$tr[$numero]['date_ouverture']);?>

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
$link="Incident";
require_once('../inc/search.inc.php');
?>	
	<div class="width100 bcg">
		
		<div class=" width50 mr_35">
		<div class="width100">
		    	<label  class="lib"  for="titreincident"> Incident *</label> 
		    	<input type="text" name="IdIncident" id="IdIncident" value="<?php getVarUpdate('IdIncident',$incident->getIncident()); ?>"  required>
	    	 
	    	</div>
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
	  			<label  class="lib" for="incidentdatedecision"> Date du prise de décision</label> 
	  			<input type="text"  name="incidentdatedecision" id="incidentdatedecision" value="<?php getVarUpdate('incidentdatedecision',$incident->getDateDecision()); ?>" >
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
  				<label class="lib" for="Incident_retablissement" >Retablissement</label>
  				<textarea id="Incident_retablissement" name="Incident_retablissement"><?php getVarUpdate('Incident_retablissement',$incident->getRetablissement()); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_suivi" >Suivi *</label>
  				<select id="Incident_suivi" name="Incident_suivi" required>
  				<?php SelectUpdate('Incident_suivi',$incident->getSuivi(),$SUIVI); ?>
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
	    		<textarea name="Incident_chronogramme" id="Incident_chronogramme" rows="70" cols="50"><?php getVarUpdate('Incident_chronogramme',$incident->getChronogramme()); ?></textarea>
	    	</div>
	    		<div class="width100">
				<input type="submit" value="Sauvegarder" name="submit" />
				</div>
    		</div>
    	

	</div>
</fieldset>
</div>
</form>

<?php 
$idIncident=$numero;
$application=$appli;
require_once('../inc/commachaud.inc.php');
require_once('../inc/footer.inc.php');
?>