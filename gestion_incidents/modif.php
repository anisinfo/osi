<?php
session_start();

if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
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

	if(empty($_POST['finincident'])){
		$errors['finincident']="Vous devez remplir le champ date fin incident!";
	}

	if (!$_POST['Incident_statut']) {
		$errors['Incident_statut']="Le Statut n'est pas valide!";
	}


	if(empty($_POST['Incident_cause'])){
		$errors['Incident_cause']="Vous devez remplir le champ cause!";
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
	$duree= dateDiff($_POST['debutincident'],$_POST['finincident']);
	$_POST['Incident_duree']=$duree;	
	$incident->setIncident($numero,'',$_POST['IdIncident'],$_POST['titreincident'],$_POST['Incident_departement'],$_POST['Incident_statut'],$_POST['Incident_priorite'],$_POST['incidentuserimpacte'],$_POST['debutincident'],$_POST['finincident'],$_POST['Incident_duree'],$_POST['IncImpact_description'],$_POST['Incident_risqueAggravation'],$_POST['Incident_cause'],$_POST['incidentConnex'],$_POST['incidentprobleme'],$_POST['Incident_retablissement'],$_POST['incidentresponsabilite'],$_POST['incidentserviceacteur'],$_POST['Incident_localisation'],$_POST['Incident_useraction'],$_POST['incidentdatecreci'],$_POST['Incident_commentaire'],$_POST['Incident_dejaApparu'],$_POST['Incident_previsible'],$userConnected,false);
	$incident->sauvegarder();

	//AJout de calendrier
	if (!empty($_POST['IdAppli'])) {

	$calendrier->setParam($_POST['IdCalend'],$_POST['IdAppli'],$_POST['Edit_OuvertLu'],$_POST['Edit_FermerLu'],$_POST['Edit_OuvertMa'],$_POST['Edit_FermerMa'],$_POST['Edit_OuvertMe'],$_POST['Edit_FermerMe'],$_POST['Edit_OuvertJe'],$_POST['Edit_FermerJe'],$_POST['Edit_OuvertVe'],$_POST['Edit_FermerVe'],$_POST['Edit_OuvertSa'],$_POST['Edit_FermerSa'],$_POST['Edit_OuvertDi'],$_POST['Edit_FermerDi'],$_POST['Edit_OuvertJf'],$_POST['Edit_FermerJf']);
	$calendrier->creer();
	$dureeImp= dateDiffImp($_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$calendrier);	
	}else
	$dureeImp= dateDiff($_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin']);
	// Impacte

	
	$_POST['Incident_Impact_dureereelle']=$dureeImp;
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

$incident->_setUser($userConnected);
$incident->chargerIncident($numero);
if (empty($incident->getNumero())) {
	$_SESSION['flash']['success'] =" Ce Numéro d'incident n'existe pas!"; 
	header('Location:index.php');
}
//debug($incident);
$impacte->chargerFirstIncident($numero);
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
<?php 
require_once('../inc/search.inc.php'); ?>
	<script type="text/javascript">
		 function EnvoyerMail(id)
      {
        try
        {
          var outlookApp = new ActiveXObject("Outlook.Application");
          var nameSpace = outlookApp.getNameSpace("MAPI");
          mailFolder = nameSpace.getDefaultFolder(6);
          mailItem = mailFolder.Items.add('IPM.Note.FormA');
          mailItem.Subject="Comme a chaud pour l'incident N° :"+id;
          mailItem.To = "";
          mailItem.HTMLBody = $('#corp').val();;
          mailItem.display (0); 
        }
        catch(e)
        {
          alert(e);
        }
      }
   
	</script>
	 <a class="btn btn-success"  href="add.php">Ajouter Incident</a>
	 <a class="btn btn-success" href="ListeImpact.php?idIncident=<?php echo $_GET['id']; ?>">Liste des impactes</a>
	 <?php
	 $statLink=($incident-> getIdStat())?'modifStat.php?idIncident='.$_GET['id'].'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$_GET['id'];
	 ?>
	  <a class="btn btn-success" href="<?php echo $statLink; ?>">Stat</a>
	<!-- <a class="btn btn-success" href="commachaud.php?idIncident=<?php echo $_GET['id']; ?>">Commachaud</a>-->
	  <a  class="btn btn-success" href="javascript:EnvoyerMail('<?= $incident->getIncident();?>')" >Commachaud</a>
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
	    			<input id="IdCalend" name="IdCalend" type="hidden" value="<?php getVarUpdate('IdCalend',$calendrier->getId()); ?>" />
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_datedebut"> Début impact *</label> 
		    			<input type="text" name="Incident_Impact_datedebut" id="Incident_Impact_datedebut" value="<?php getVarUpdate('Incident_Impact_datedebut',$impacte->getDateDebut()); ?>" required>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact *</label> 
		    			<input type="text" name="Incident_Impact_datefin" id="Incident_Impact_datefin"  value="<?php getVarUpdate('Incident_Impact_datefin',$impacte->getDateFin()); ?>" required>
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
                        	<img  width="50px" height="50px" alt="calendrier" src="../img/calendar.png">
                    	</a>
                    </div>

                    <div class="width12">
	                    <a class="btn_info" id="my-button" href="#" title="informations">
	                        <img  width="50px" height="50px" alt="Informations sur l'application" src="../img/search.png">
	                    </a>
	                </div>


    			</div>

    			<div id="element_to_pop_up">
    					<a class="b-close">x</a>
					Ajout d'une application

						<div id="infoAjout" style="display:none;" class="alert alert-success" >L'application est bien ajoutée</div>
					
    					<label for="NomSearch" class="lib">Nom de l'application</label>
    					<input type="text" id="NomSearch" name="NomSearch" >
    				

    				
    					<label for="EnseigneSearch" class="lib">Enseigne</label>
    					<input type="text" id="EnseigneSearch" name="EnseigneSearch" >
    			
    					<label for="IrtSearch" class="lib">Code IRT</label>
    					<input type="text" id="IrtSearch" name="IrtSearch" >
    				
    					<label for="TrigrammeSearch" class="lib">Trigramme</label>
    					<input  type="text" id="TrigrammeSearch" name="TrigrammeSearch" >
    				
	                     <button class="btn btn-success" type="button" onclick="ChercherAppli();">Rechercher</button>
	                     <br />

	                     <br />
	                     <br />	<table class="table"  id="TabResultats">
	                     		
	                     	</table>
    				</div>

    				<div id="element_to_pop_up2">
    					<a class="b-close">x</a>
					Calendrier pour l'application <span id="CalendarNomAppli"></span>

							<table class="table"  id="calendar-sogessur">
									<tr>
										<td align="center"><label class="lib"> JF</label></td>
										<td align="center"><label class="lib"> L<br/></label></td>
					           			<td align="center"><label class="lib"> M<br/></label></td>
					           			<td align="center"><label class="lib"> M<br/></label></td>
					           			<td align="center"><label class="lib"> J<br/></label></td>
					           			<td align="center"><label class="lib"> V<br/></label></td>
					           			<td align="center"><label class="lib"> S<br/></label></td>
					           			<td align="center"><label class="lib"> D<br/></label></td>
									</tr>
			                     	<tr>
										<td align="center"><input type="text" id="Edit_O_Jf" name="Edit_OuvertJf" value="<?php getVarDateUpdate('Edit_OuvertJf',$calendrier->getJourFerierOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Lu" name="Edit_OuvertLu" value="<?php getVarDateUpdate('Edit_OuvertLu',$calendrier->getLundiOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Ma" name="Edit_OuvertMa" value="<?php getVarDateUpdate('Edit_OuvertMa',$calendrier->getMardiOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Me" name="Edit_OuvertMe" value="<?php getVarDateUpdate('Edit_OuvertMe',$calendrier->getMercrediOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Je" name="Edit_OuvertJe" value="<?php getVarDateUpdate('Edit_OuvertJe',$calendrier->getJeudiOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Ve" name="Edit_OuvertVe" value="<?php getVarDateUpdate('Edit_OuvertVe',$calendrier->getVendrediOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Sa" name="Edit_OuvertSa" value="<?php getVarDateUpdate('Edit_OuvertSa',$calendrier->getSamediOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_O_Di" name="Edit_OuvertDi" value="<?php getVarDateUpdate('Edit_OuvertDi',$calendrier->getDimancheOuvert(),1);?>" style="width:53px;" placeholder="HH:MM" /></td>
									</tr>
									<tr>
										<td align="center"><input type="text" id="Edit_Jf" name="Edit_FermerJf" value="<?php getVarDateUpdate('Edit_FermerJf',$calendrier->getJourFerierFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Lu" name="Edit_FermerLu" value="<?php getVarDateUpdate('Edit_FermerLu',$calendrier->getLundiFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Ma" name="Edit_FermerMa" value="<?php getVarDateUpdate('Edit_FermerMa',$calendrier->getMardiFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Me" name="Edit_FermerMe" value="<?php getVarDateUpdate('Edit_FermerMe',$calendrier->getMercrediFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Je" name="Edit_FermerJe" value="<?php getVarDateUpdate('Edit_FermerJe',$calendrier->getJeudiFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Ve" name="Edit_FermerVe" value="<?php getVarDateUpdate('Edit_FermerVe',$calendrier->getVendrediFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Sa" name="Edit_FermerSa" value="<?php getVarDateUpdate('Edit_FermerSa',$calendrier->getSamediFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
										<td align="center"><input type="text" id="Edit_Di" name="Edit_FermerDi" value="<?php getVarDateUpdate('Edit_FermerDi',$calendrier->getDimancheFermer(),'');?>" style="width:53px;" placeholder="HH:MM" /></td>
									</tr>	
	                     	</table>
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

    		<div class="width50 mr_35">
                <label class="lib" for="Incident_Impact_description">Description de l'impact *</label>
                <textarea id="Incident_Impact_description" name="Incident_Impact_description" required maxlength="4000"><?php getVarUpdate('Incident_Impact_description',$impacte->getDescription()); ?></textarea>
    		</div>

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

<?php 
require_once('../inc/footer.inc.php');
?>