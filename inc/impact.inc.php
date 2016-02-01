
    		<legend>Application Impactée</legend>
    		<div class=" width50 fl-left"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_application_libelle"> Application *</label> 
		    		<input type="text"  value="<?php getVar('Incident_Impact_application_libelle'); ?>" id="Incident_Impact_application_libelleb" required disabled>
	    			<input id="IdAppli" name="IdAppli" type="hidden" value="<?php getVar('IdAppli'); ?>" />
	    			<input id="Incident_Impact_application_libelle" name="Incident_Impact_application_libelle" type="hidden" value="<?php getVar('Incident_Impact_application_libelle'); ?>" />
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_datedebut"> Début impact *</label> 
		    			<input type="text" name="Incident_Impact_datedebut" id="Incident_Impact_datedebut" value="<?php getVar('Incident_Impact_datedebut'); ?>" required>
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact</label> 
		    			<input type="text" name="Incident_Impact_datefin" id="Incident_Impact_datefin"  value="<?php getVar('Incident_Impact_datefin'); ?>">
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
    		<div class=" width50 right">

    			<div class="width100">

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_enseigne" class="lib">Enseigne</label>
    					<input  type="text" id="Incident_Impact_application_enseigneb" value="<?php getVar('Incident_Impact_application_enseigne'); ?>" disabled>
    					<input  type="hidden" id="Incident_Impact_application_enseigne" name="Incident_Impact_application_enseigne" value="<?php getVar('Incident_Impact_application_enseigne'); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_irt" class="lib">Code IRT</label>
    					<input type="text" id="Incident_Impact_application_irtb" value="<?php getVar('Incident_Impact_application_irt'); ?>" disabled>
    					<input type="hidden" id="Incident_Impact_application_irt" name="Incident_Impact_application_irt" value="<?php getVar('Incident_Impact_application_irt'); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_trigramme" class="lib">Trigramme</label>
    					<input type="text" id="Incident_Impact_application_trigrammeb" value="<?php getVar('Incident_Impact_application_trigramme'); ?>" disabled>
    					<input type="hidden" id="Incident_Impact_application_trigramme" name="Incident_Impact_application_trigramme" value="<?php getVar('Incident_Impact_application_trigramme'); ?>">
    				</div>

    				<div class="width12 mr_7" id="ImgCalendar" style="<?php if (!isset($_POST['IdAppli'])) echo 'visibility: hidden';?>">
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
						<h2>Recherche application</h2>

						<div id="infoAjout" class="alert alert-success" style="display:none;">L'application est bien ajoutée</div>
					
    					<label for="NomSearch" class="lib">Libellé court</label>
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
	                     	<input type="button" value="Valider" class="b-close b-close2" onclick="SauvegarderCal();" />
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
	    				<label  class="lib"  for="Incident_Impact_sla"> SLA</label> 
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
	    		
