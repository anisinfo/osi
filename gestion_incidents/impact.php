<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
			 	 die();
	}
$numincident=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	

if (!$numincident) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
	header('Location:index.php');
	die();
}
define('TITLE',"Modification de l'impacte N°:' ".$numincident);
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');

require_once('../classes/db.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');
require_once('../classes/incidents.php');

$Impacte= new Impact();



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
		$errors['Incident_Impact_datefin']="Vous devez remplir le champ date fin impact!";
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
	$impacte->setParam(NULL,$numincident,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$impacte->creer();

	$_SESSION['flash']['success'] =" L'incident est bien modifié."; 
	//	header('Location:ListeImpact.php');
	
	}
}else
{
$incident =new incidents();
$incident->_setUser($userConnected);
$incident->chargerIncident($numincident);
}
require_once('../inc/header.inc.php');
?>
<h1>Ajout d'un impacte</h1>

<form action="" method="POST">
	<div class="bloc">
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">
	      Ajout pour l'incident N°:<strong><?= $incident->getIncident() ?></strong>
	    </span>
		
		<span class="lib" style="float:left; margin-left:25px; line-height:2.5;"> Titre comm :
		<strong><?php getVarUpdate('numincident',$incident->getTitre()); ?> </strong> 
		</span>
		
	    </div>
	<div class="width100 bcg">
	<fieldset>
    		<legend>Application Impactée par l'incident : <?= $incident->getIncident(); ?></legend>
    		<div class=" width50 mr_35"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_application_libelle"> Application</label> 
		    		<input type="text" name="Incident_Impact_application_libelle" id="Incident_Impact_application_libelle"  value="<?php getVar('Incident_Impact_application_libelle'); ?>" >
	    		<input id="IdAppli" name="IdAppli" type="hidden" value="<?php getVar('IdAppli'); ?>" />
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_datedebut"> Début impact *</label> 
		    			<input type="text" name="Incident_Impact_datedebut" id="Incident_Impact_datedebut" value="<?php getVar('Incident_Impact_datedebut'); ?>" required>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact *</label> 
		    			<input type="text" name="Incident_Impact_datefin" id="Incident_Impact_datefin"  value="<?php getVar('Incident_Impact_datefin'); ?>">
	    			</div>	    			
	    		</div>

	    		<div class="width100">

	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_impact"> Impact</label> 
		    			<select id="Incident_Impact_impact" name="Incident_Impact_impact">
		    			<?php
		    			Select('Incident_Impact_impact',$INCIDENTIMPACTMETIER);
		    			?>
		    			</select>
	    			</div>	
	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_criticite"> Criticité</label> 
		    			<select id="Incident_Impact_criticite" name="Incident_Impact_criticite">
		    			<?php
		    			Select('Incident_Impact_criticite',$CRITICITE);
		    			?>
		    			</select>
	    			</div>	
    			
	    		</div>
    		</div>

    		<div class=" width50">

    			<div class="width100">

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_enseigne" class="lib">Enseigne</label>
    					<input disabled="" type="text" id="Incident_Impact_application_enseigne" name="Incident_Impact_application_enseigne" value="<?php getVar('Incident_Impact_application_enseigne'); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_irt" class="lib">Code IRT</label>
    					<input disabled="" type="text" id="Incident_Impact_application_irt" name="Incident_Impact_application_irt" value="<?php getVar('Incident_Impact_application_irt'); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_trigramme" class="lib">Trigramme</label>
    					<input disabled="" type="text" id="Incident_Impact_application_trigramme" name="Incident_Impact_application_trigramme" value="<?php getVar('Incident_Impact_application_trigramme'); ?>">
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
								<td align="center"><label class="lib"> JF </label></td>
								<td align="center"><label class="lib"> L<br/></label></td>
			           			<td align="center"><label class="lib"> M<br/></label></td>
			           			<td align="center"><label class="lib"> M<br/></label></td>
			           			<td align="center"><label class="lib"> J<br/></label></td>
			           			<td align="center"><label class="lib"> V<br/></label></td>
			           			<td align="center"><label class="lib"> S<br/></label></td>
			           			<td align="center"><label class="lib"> D<br/></label></td>
							</tr>
	                     	<tr>
								<td align="center"><input type="text" id="Edit_O_Jf" name="Edit_OuvertJf" value="<?php getVarDate('Edit_OuvertJf',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Lu" name="Edit_OuvertLu" value="<?php getVarDate('Edit_OuvertLu',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Ma" name="Edit_OuvertMa" value="<?php getVarDate('Edit_OuvertMa',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Me" name="Edit_OuvertMe" value="<?php getVarDate('Edit_OuvertMe',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Je" name="Edit_OuvertJe" value="<?php getVarDate('Edit_OuvertJe',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Ve" name="Edit_OuvertVe" value="<?php getVarDate('Edit_OuvertVe',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Sa" name="Edit_OuvertSa" value="<?php getVarDate('Edit_OuvertSa',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_O_Di" name="Edit_OuvertDi" value="<?php getVarDate('Edit_OuvertDi',1);?>" style="width:53px;" placeholder="HH:MM" /></td>
							</tr>
							<tr>
								<td align="center"><input type="text" id="Edit_Jf" name="Edit_FermerJf" value="<?php getVarDate('Edit_FermerJf','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Lu" name="Edit_FermerLu" value="<?php getVarDate('Edit_FermerLu','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Ma" name="Edit_FermerMa" value="<?php getVarDate('Edit_FermerMa','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Me" name="Edit_FermerMe" value="<?php getVarDate('Edit_FermerMe','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Je" name="Edit_FermerJe" value="<?php getVarDate('Edit_FermerJe','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Ve" name="Edit_FermerVe" value="<?php getVarDate('Edit_FermerVe','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Sa" name="Edit_FermerSa" value="<?php getVarDate('Edit_FermerSa','');?>" style="width:53px;" placeholder="HH:MM" /></td>
								<td align="center"><input type="text" id="Edit_Di" name="Edit_FermerDi" value="<?php getVarDate('Edit_FermerDi','');?>" style="width:53px;" placeholder="HH:MM" /></td>
							</tr>	
	                     	</table>
    				</div>
    			

    			

    			<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_dureereelle"> Durée réelle </label> 
		    			<input type="text" name="Incident_Impact_dureereelle" id="Incident_Impact_dureereelle" value="<?php getVar('Incident_Impact_dureereelle'); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_jourhommeperdu"> Jour homme</label> 
		    			<input type="text" name="Incident_Impact_jourhommeperdu" id="Incident_Impact_jourhommeperdu" value="<?php getVar('Incident_Impact_jourhommeperdu'); ?>" >
	    			</div>	    			
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_impactmetier"> Impact métier *</label> 
		    			<select id="Incident_Impact_impactmetier" name="Incident_Impact_impactmetier" required>
		    			<?php
		    			Select('Incident_Impact_impactmetier',$IMPACTMETIER);
		    			?>
		    			</select>
	    			</div>
	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_sla"> SLA *</label> 
		    			<select id="Incident_Impact_sla" name="Incident_Impact_sla" required>
		    			<?php
		    			Select('Incident_Impact_sla',$SLA);
		    			?>
		    			</select>
	    			</div>

	    			    			
	    		</div>

    		</div>

    		<div class="width100">
                <label class="lib" for="Incident_Impact_description">Description de l'impact *</label>
                <textarea id="Incident_Impact_description" name="Incident_Impact_description" required maxlength="4000"><?php getVar('Incident_Impact_description'); ?></textarea>
    		</div>
    	</fieldset>

    	<input type="submit" value="Sauvegarder" name="submit" /> <input type="button" value="Annuler" name="button" />
	</div>
	</div>

</form>
	<?php 
require_once('../inc/footer.inc.php');
?>

