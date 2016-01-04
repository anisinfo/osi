<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
			 	 die();
	}
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	
$IdImpact=(isset($_GET['IdImpact']))?$_GET['IdImpact']:'';
if (!$IdImpact) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	echo $IdImpact;
	header('Location:index.php');
	die();
}
define('TITLE',"Modification de l'impacte N°:' ".$IdImpact);

require_once('../classes/db.php');
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
require_once('../classes/incidents.php');

$Impacte= new Impact();
$Impacte->chargerImpact($IdImpact);


if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	/*
	Contrôle des champs obligatoire
	*/
	if(empty($_POST['Incident_Impact_datedebut'])){
		$errors['Incident_Impact_datedebut']="Vous devez remplir le champ début impact!";
	}

	if(empty($_POST['Incident_Impact_datefin'])){
		$errors['Incident_Impact_datefin']="Vous devez remplir le champ fin impact!";
	}


	if (!$_POST['Incident_Impact_impactmetier']) {
		$errors['Incident_Impact_impactmetier']="L'Impact métier n'est pas valide!";
	}

	if (!$_POST['Incident_Impact_sla']) {
		$errors['Incident_Impact_sla']="Le SLA n'est pas valide!";
	}

	if(empty($_POST['Incident_Impact_description'])){
		$errors['Incident_Impact_description']="Vous devez remplir le champ Description de l'impact!";
	}


	if(empty($errors))
	{

	// Impacte
	$impacte=new Impact();
	$dureeImp= dateDiff($_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin']);
	$_POST['Incident_Impact_dureereelle']=$dureeImp;
	$impacte->setParam($IdImpact,$Impacte->getIncidentId(),$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->modifier();

	$_SESSION['flash']['success'] =" L'incident est bien modifié."; 
		header('Location:index.php');
	
	}
}else
{
$incident =new incidents();
$incident->_setUser($userConnected);
$incident->chargerIncident($Impacte->getIncidentId());

$idAppli=$Impacte->getApplicationId();
$appli= new Application();
$appli->SelectAppliById($idAppli);

}
require_once('../inc/header.inc.php');
?>
<h1>Modification d'un impacte</h1>

<form action="" method="POST">
	<div class="bloc">
	<?php
	require_once('../inc/search.inc.php'); ?>
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">Edition de l'incident N° <strong> <?=$Impacte->getIncidentId(); ?></strong></span>
	<span class="lib" style="float:left; margin-left:25px; line-height:2.5;">Titre comm <strong><?= $incident->getTitre(); ?> </strong> </span>
	</div>
	<div class="width100 bcg">
	<fieldset>
    		<legend>Application Impactée par l'incident : <?= $incident->getIncident(); ?></legend>
    		<div class=" width50 mr_35"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_application_libelle"> Application</label> 
		    		<input type="text" name="Incident_Impact_application_libelle" id="Incident_Impact_application_libelle"  value="<?php getVarUpdate('Incident_Impact_application_libelle',$appli->getName()); ?>" >
	    		<input id="IdAppli" name="IdAppli" type="hidden" value="<?php getVarUpdate('IdAppli',$appli->getId()); ?>" />
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_datedebut"> Début impact *</label> 
		    			<input type="text" name="Incident_Impact_datedebut" id="Incident_Impact_datedebut" value="<?php getVarUpdate('Incident_Impact_datedebut',$Impacte->getDateDebut()); ?>" required>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact *</label> 
		    			<input type="text" name="Incident_Impact_datefin" id="Incident_Impact_datefin"  value="<?php getVarUpdate('Incident_Impact_datefin',$Impacte->getDateFin()); ?>">
	    			</div>	    			
	    		</div>

	    		<div class="width100">

	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_impact"> Impact</label> 
		    			<select id="Incident_Impact_impact" name="Incident_Impact_impact">
		    			<?php
		    			SelectUpdate('Incident_Impact_impact',$Impacte->getImpact(),$INCIDENTIMPACTMETIER);
		    			?>
		    			</select>
	    			</div>	
	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_criticite"> Criticité</label> 
		    			<select id="Incident_Impact_criticite" name="Incident_Impact_criticite">
		    			<?php
		    			SelectUpdate('Incident_Impact_criticite',$Impacte->getSeverite(),$CRITICITE);
		    			?>
		    			</select>
	    			</div>	
    			
	    		</div>
    		</div>

    		<div class=" width50">

    			<div class="width100">

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_enseigne" class="lib">Enseigne</label>
    					<input disabled="" type="text" id="Incident_Impact_application_enseigne" name="Incident_Impact_application_enseigne" value="<?php getVarUpdate('Incident_Impact_application_enseigne',$appli->getEnseigne( )); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_irt" class="lib">Code IRT</label>
    					<input disabled="" type="text" id="Incident_Impact_application_irt" name="Incident_Impact_application_irt" value="<?php getVarUpdate('Incident_Impact_application_irt',$appli->getIrt()); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_trigramme" class="lib">Trigramme</label>
    					<input disabled="" type="text" id="Incident_Impact_application_trigramme" name="Incident_Impact_application_trigramme" value="<?php getVarUpdate('Incident_Impact_application_trigramme',$appli->getTrigramme()); ?>">
    				</div>

    				<div class="width12 mr_7" id="ImgCalendar">
    					<a class="btn_calendrier" id="btn_calendrier" href="#" title="calendrier">
                        	<img width="50px" height="50px" alt="calendrier" src="../img/calendar.png">
                    	</a>
                    </div>

                    <div class="width12" >
	                    <a class="btn_info" id="my-button" href="#" title="informations">
	                        <img  width="50px" height="50px" alt="Informations sur l'application" src="../img/search.png">
	                    </a>
	                </div>


    			</div>
    			
    				<div id="element_to_pop_up">
    					<a class="b-close">x</a>
					Ajout d'une application

						<div id="infoAjout" class="alert alert-success" >L'application est bien ajoutée</div>
					
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
								<td align="center"><label class="lib"> JF
								<br/>
  						<input type="checkbox" id="calender_sogessur_jf" name="calender_sogessur_jf" value="0"  <?php Check('calender_sogessur_jf'); ?>>
                        
           			</label></td>
								<td align="center"><label class="lib"> L<br/>
  						<input type="checkbox" id="calender_sogessur_lu" name="calender_sogessur_lu" value="0" <?php Check('calender_sogessur_lu'); ?>>
                        
           			</label></td>
           			<td align="center"><label class="lib"> M<br/>
  						<input type="checkbox" id="calender_sogessur_mar" name="calender_sogessur_mar" value="0" <?php Check('calender_sogessur_mar'); ?>>
                        
           			</label></td>
           			<td align="center"><label class="lib"> M<br/>
  						<input type="checkbox" id="calender_sogessur_mer" name="calender_sogessur_mer" value="0" <?php Check('calender_sogessur_mer'); ?>>
                        
           			</label></td>
           			<td align="center"><label class="lib"> J<br/>
  						<input type="checkbox" id="calender_sogessur_jeu" name="calender_sogessur_jeu" value="0" <?php Check('calender_sogessur_jeu'); ?>>
                        
           			</label></td>
           			<td align="center"><label class="lib"> V<br/>
  						<input type="checkbox" id="calender_sogessur_ven" name="calender_sogessur_ven" value="0" <?php Check('calender_sogessur_ven'); ?>>
                        
           			</label></td>
           			<td align="center"><label class="lib"> S<br/>
  						<input type="checkbox" id="calender_sogessur_sam" name="calender_sogessur_sam" value="0" <?php Check('calender_sogessur_sam'); ?>>
                        
           			</label></td>
           			<td align="center"><label class="lib"> D<br/>
  						<input type="checkbox" id="calender_sogessur_dim" name="calender_sogessur_dim" value="0" <?php Check('calender_sogessur_dim'); ?>>
                        
           			</label></td>
							</tr>
	                     	<tr>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
								<td align="center">00:00</td>
							</tr>
							<tr>
								<td align="center">23:59</td>
								<td align="center">23:59</td>
								<td align="center">23:59</td>
								<td align="center">23:59</td>
								<td align="center">23:59</td>
								<td align="center">23:59</td>
								<td align="center">23:59</td>
								<td align="center">23:59</td>

							</tr>	
	                     	</table>
    				</div>
    			

    			<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_dureereelle"> Durée réelle </label> 
		    			<input type="text" name="Incident_Impact_dureereelle" id="Incident_Impact_dureereelle" value="<?php getVarUpdate('Incident_Impact_dureereelle',$Impacte->getJourHomme()); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_jourhommeperdu"> Jour homme</label> 
		    			<input type="text" name="Incident_Impact_jourhommeperdu" id="Incident_Impact_jourhommeperdu" value="<?php getVarUpdate('Incident_Impact_jourhommeperdu',$Impacte->getJourHomme()); ?>" >
	    			</div>	    			
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_impactmetier"> Impact métier *</label> 
		    			<select id="Incident_Impact_impactmetier" name="Incident_Impact_impactmetier" required>
		    			<?php
		    			SelectUpdate('Incident_Impact_impactmetier',$Impacte->getImpactMetier(),$IMPACTMETIER);
		    			?>
		    			</select>
	    			</div>
	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_sla"> SLA *</label> 
		    			<select id="Incident_Impact_sla" name="Incident_Impact_sla" required>
		    			<?php
		    			SelectUpdate('Incident_Impact_sla',$Impacte->getSla(),$SLA);
		    			?>
		    			</select>
	    			</div>

	    			    			
	    		</div>

    		</div>

    		<div class="width100">
                <label class="lib" for="Incident_Impact_description">Description de l'impact *</label>
                <textarea id="Incident_Impact_description" name="Incident_Impact_description" required maxlength="4000"><?php getVarUpdate('Incident_Impact_description',$Impacte->getDescription()); ?></textarea>
    		</div>
    	</fieldset>

    	<input type="submit" value="Sauvegarder" name="submit" /> <input type="button" value="Annuler" name="button" />
	</div>
	</div>

</form>
	<?php 
require_once('../inc/footer.inc.php');
?>

