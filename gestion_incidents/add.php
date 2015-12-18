<?php
session_start();
define('TITLE','Ajouter un incident');
require_once('../inc/config.inc.php');
require_once('../classes/Impact.php');
require_once('../classes/incidents.php');
require_once('../classes/db.php');
//$dbc = new PDO('oci:dbname='.HOST.':'.PORT.'/'.SCHEMA.';charset=CL8MSWIN1251', SCHEMA_LOGIN, SCHEMA_PASS);
if(!empty($_POST)){
	$errors=array();

	$_POST['Incident_risqueAggravation'] = (isset($_POST['Incident_risqueAggravation']))?1:0;
	$_POST['Incident_dejaApparu'] = (isset($_POST['Incident_dejaApparu']))?1:0; 
	$_POST['Incident_previsible'] = (isset($_POST['Incident_previsible']))?1:0;
	$_POST['calender_sogessur_jf'] = (isset($_POST['calender_sogessur_jf']))?1:0;

	$_POST['calender_sogessur_lu'] = (isset($_POST['calender_sogessur_lu']))?1:0;
	$_POST['calender_sogessur_mar'] = (isset($_POST['calender_sogessur_mar']))?1:0;
	$_POST['calender_sogessur_mer'] = (isset($_POST['calender_sogessur_mer']))?1:0;
	$_POST['calender_sogessur_jeu'] = (isset($_POST['calender_sogessur_jeu']))?1:0;
	$_POST['calender_sogessur_ven'] = (isset($_POST['calender_sogessur_ven']))?1:0;
	$_POST['calender_sogessur_sam'] = (isset($_POST['calender_sogessur_sam']))?1:0;
	$_POST['calender_sogessur_dim'] = (isset($_POST['calender_sogessur_dim']))?1:0;

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
	$incident = new incidents();
	$incident->setIncident(NULL,$_POST['titreincident'],$_POST['Incident_departement'],$_POST['Incident_statut'],$_POST['Incident_priorite'],$_POST['incidentuserimpacte'],$_POST['debutincident'],$_POST['finincident'],$_POST['Incident_duree'],$_POST['IncImpact_description'],$_POST['Incident_risqueAggravation'],$_POST['Incident_cause'],$_POST['incidentConnex'],$_POST['incidentprobleme'],$_POST['Incident_retablissement'],$_POST['incidentresponsabilite'],$_POST['incidentserviceacteur'],$_POST['Incident_localisation'],$_POST['Incident_useraction'],$_POST['incidentdatecreci'],$_POST['Incident_commentaire'],$_POST['Incident_dejaApparu'],$_POST['Incident_previsible']);
	$id_incident=$incident->sauvegarder();
	$_SESSION['flash']['success'] =" L'incident est bien ajouté."; 
	 // Ajoutde l'impact
	$imp = new Impact();
	$imp->setParam(NULL,$id_incident,$_POST['IdAppli'],$_POST['Incident_Impact_datedebut'],$_POST['Incident_Impact_datefin'],$_POST['Incident_Impact_dureereelle'],$_POST['Incident_Impact_jourhommeperdu'],$_POST['Incident_Impact_impactmetier'],$_POST['Incident_Impact_impact'],$_POST['Incident_Impact_sla'],$_POST['Incident_Impact_criticite'],$_POST['Incident_Impact_description']);
	$imp->creer();

	//AJout de calendrier

	// AJout de chronogramme

	$_SESSION['flash']['success'] =" L'impacte de l'incident est bien ajouté."; 

	header('Location:index.php');
//	die();
	# code...
	}
}
require_once('../inc/header.inc.php');
?>
<h1>Ajouter un incident</h1>
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
  					<label  class="lib" for="debutincident"> Début Incident</label> 
  					<input type="datetime" name="debutincident"  id="debutincident" value="<?php getVar('debutincident'); ?>">
  				</div>
  				<div class=" width50 right">
  					<label  class="lib"  for="finincident"> Fin Incident</label> 
  					<input type="datetime" name="finincident" id="finincident"  value="<?php getVar('finincident'); ?>">
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
	  			<label  class="lib" for="incidentdatecreci"> Date du Creci</label> 
	  			<input type="date"  name="incidentdatecreci" id="incidentdatecreci" value="<?php getVar('incidentdatecreci'); ?>" >
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
  				<label class="lib" for="Incident_IncImpact_description">Description de l'incident*</label>
  				<textarea  rows="3" id="IncImpact_description" name="IncImpact_description" required><?php getVar('IncImpact_description'); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_cause">Cause*</label>
  				<textarea  rows="3" id="Incident_cause" name="Incident_cause" required><?php getVar('Incident_cause'); ?></textarea>
  			</div>

  			<div class="width100">
  				<label class="lib" for="Incident_retablissement">Retablissement</label>
  				<textarea  rows="3" id="Incident_retablissement" name="Incident_retablissement"><?php getVar('Incident_retablissement'); ?></textarea>
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

  		<fieldset>
    		<legend>Application Impactée</legend>
    		<div class=" width50 mr_35"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_application_libelle"> Application</label> 
		    		<input type="text" disabled name="Incident_Impact_application_libelle" id="Incident_Impact_application_libelle"  value="<?php getVar('Incident_Impact_application_libelle'); ?>" >
	    		<input id="IdAppli" name="IdAppli" type="hidden" value="<?php getVar('IdAppli'); ?>" />
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_datedebut"> Début impact *</label> 
		    			<input type="date" name="Incident_Impact_datedebut" id="Incident_Impact_datedebut" value="<?php getVar('Incident_Impact_datedebut'); ?>" required>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact </label> 
		    			<input type="date" name="Incident_Impact_datefin" id="Incident_Impact_datefin"  value="<?php getVar('Incident_Impact_datefin'); ?>">
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
	    				<label  class="lib"  for="Incident_Impact_impact"> Impact</label> 
		    			<select id="Incident_Impact_impact" name="Incident_Impact_impact">
		    			<?php
		    			Select('Incident_Impact_impact',$INCIDENTIMPACTMETIER);
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

    				<div class="width12 mr_7" id="ImgCalendar" style="visibility: hidden">
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
		    			<input type="text" name="Incident_Impact_dureereelle" id="Incident_Impact_dureereelle" value="<?php getVar('Incident_Impact_dureereelle'); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_jourhommeperdu"> Jour homme perdu</label> 
		    			<input type="text" name="Incident_Impact_jourhommeperdu" id="Incident_Impact_jourhommeperdu" value="<?php getVar('Incident_Impact_jourhommeperdu'); ?>" >
	    			</div>	    			
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_sla"> SLA *</label> 
		    			<select id="Incident_Impact_sla" name="Incident_Impact_sla" required>
		    			<?php
		    			Select('Incident_Impact_sla',$SLA);
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

    		<div class="width100">
                <label class="lib" for="Incident_Impact_description">Description de l'impact *</label>
                <textarea id="Incident_Impact_description" name="Incident_Impact_description" required maxlength="4000"><?php getVar('Incident_Impact_description'); ?></textarea>
    		</div>
    	</fieldset>

		<input type="submit" value="Sauvegarder" name="submit" />
	</div>

</div>

</form>

<?php 
require_once('../inc/footer.inc.php');
?>