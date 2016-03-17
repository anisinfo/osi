
    		<legend>Application Impactée</legend>
    		<div class=" width50 fl-left"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_application_libelle"> Application *</label> 
		    		<input type="text"  id="Incident_Impact_application_libelleb"  value="<?php getVarUpdate('Incident_Impact_application_libelle',$appli->getName()); ?>" disabled required >
		    		<input type="hidden" name="Incident_Impact_application_libelle" id="Incident_Impact_application_libelle"  value="<?php getVarUpdate('Incident_Impact_application_libelle',$appli->getName()); ?>">
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
	    				<label  class="lib"  for="Incident_Impact_datefin"> Fin impact</label> 
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

    		<div class=" width50 right">

    			<div class="width100">

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_enseigne" class="lib">Enseigne</label>
    					<input type="text" id="Incident_Impact_application_enseigneb" value="<?php getVarUpdate('Incident_Impact_application_enseigne',$appli->getEnseigne()); ?>" disabled>
    					<input type="hidden" id="Incident_Impact_application_enseigne" name="Incident_Impact_application_enseigne" value="<?php getVarUpdate('Incident_Impact_application_enseigne',$appli->getEnseigne()); ?>" >
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_irt" class="lib">Code IRT</label>
    					<input   type="text" id="Incident_Impact_application_irtb" value="<?php getVarUpdate('Incident_Impact_application_irt',$appli->getIrt()); ?>" disabled>
    					<input   type="hidden" id="Incident_Impact_application_irt" name="Incident_Impact_application_irt" value="<?php getVarUpdate('Incident_Impact_application_irt',$appli->getIrt()); ?>">
    				</div>

    				<div class="width20 mr_7">
    					<label for="Incident_Impact_application_trigramme" class="lib">Trigramme</label>
    					<input   type="text" id="Incident_Impact_application_trigrammeb"  value="<?php getVarUpdate('Incident_Impact_application_trigramme',$appli->getTrigramme()); ?>" disabled>
    					<input   type="hidden" id="Incident_Impact_application_trigramme" name="Incident_Impact_application_trigramme" value="<?php getVarUpdate('Incident_Impact_application_trigramme',$appli->getTrigramme()); ?>">
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
					Recherche application

						<div id="infoAjout" style="display:none;" class="alert alert-success" >L'application est bien ajoutée</div>
					
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
					Calendrier pour l'application <span id="CalendarNomAppli"><?php getVarUpdate('Incident_Impact_application_libelle',$appli->getName()); ?></span>
						<div id="infoDate" style="display:none;" class="alert alert-danger">Veuillez mettre les zones textes entourer en rouge en format HH:MM</div>
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
	                    <input type="button" value="Valider" class="b-close b-close2" onclick="SauvegarderCal();" /> 	
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
	    				<label  class="lib"  for="Incident_Impact_sla"> SLA</label> 
		    			<select id="Incident_Impact_sla" name="Incident_Impact_sla">
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

    	