<?php
require_once('../inc/header.inc.php');
require_once('../classes/db.php');
require_once('../classes/Stat.php');
if (!empty($_POST)) {
	$stat= new Stat();
    $stat->SetParam(NULL,$_POST['refchangement'],$_POST['stat_publicationIR'],$_POST['stat_publicationPM'],$_POST['stat_typecause'],$_POST['stat_typecause_second'],$_POST['stat_typologiegts'],$_POST['stat_kindImpact'],$_POST['stat_equipeResp'],$_POST['fournisseurResp'],$_POST['statPowerprod'],$_POST['statLegacy'],$_POST['stat_Composant'],$_POST['Composant_complement'],$_POST['stat_zonegeo']);
    $stat->Creer();
}


?>
<h1>Statistique</h1>


<form action="" method="POST">
	<div class="bloc">
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">
	      Edition de l'incident N° <strong> 012345</strong>
	    </span>
		
		<label class="lib" style="float:left; margin-left:25px; line-height:2.5;"> Titre comm </label>
		<input type="number" name="titreincident" size="12" style=" display:inline-block; margin-left:25px; " value="<?php getVar('titreincident');?>"> 
		
	      <button class="btn btn-success" type="button">Actualiser</button>
	    
		
		
	      <button class="btn btn-success" type="button">Ajouter</button>
	    </div>
	<div class="width100 bcg">
    		<div class=" width50 mr_35"> 
    			<div class="width100">
		    		<label  class="lib"  for="Incident_Impact_stat_refchangement"> Ref changement</label> 
		    		<input type="text"  name="refchangement"  value="<?php getVar('refchangement'); ?>" >
	    		</div>

	    		
	    		<div class="width100">

	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="stat_typecause"> Type de cause</label> 
		    			<select id="stat_typecause" name="stat_typecause">
		    			<?php
		    			Select('stat_typecause',$STATTYPECAUSE);
		    			?>
		    			</select>
	    			</div>	
	    			<div class=" width50">
	    				<label  class="lib"  for="typecause_second"> Type de cause secondaire</label> 
		    			<input type="text"  name="stat_typecause_second" id="stat_typecause_second"  value="<?php getVar('stat_typecause_second'); ?>" >
	    			</div>	
    			
	    		</div>
	    		<div class="width100">
	    		<div class=" width50 mr_10">
	    				<label  class="lib"  for="stat_equipeResp"> Equipe responsable</label> 
		    			<input type="text" name="stat_equipeResp" id="stat_equipeResp" value="<?php getVar('stat_equipeResp'); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="stat_fournisseurResp"> Fournisseur responsable </label> 
		    			<input type="text" name="fournisseurResp" id="fournisseurResp"  value="<?php getVar('fournisseurResp'); ?>">
	    			</div>
	    		</div>
	    		<div class="width100">

	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_stat_Composant"> Composant</label> 
		    			<select id="stat_Composant" name="stat_Composant">
		    			<?php
		    			Select('stat_Composant',$STATCOMPOSANT);
		    			?>
		    			</select>
	    			</div>	
	    			<div class=" width50">
	    				<label  class="lib"  for="Composant_complement"> Composant complément</label> 
		    			<input type="text"  name="Composant_complement" id="Composant_complement"  value="<?php getVar('Composant_complement');?>" >
	    			</div>	
    			
	    		</div>
    		</div>

    		<div class=" width50">

    			<div class="width100">

    				
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="tat_publicationIR"> Publication IR</label> 
		    			<input type="text" name="stat_publicationIR" id="stat_publicationIR" value="<?php getVar('stat_publicationIR'); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="stat_publicationPM"> Publication PM </label> 
		    			<input type="text" name="stat_publicationPM" id="stat_publicationPM"  value="<?php getVar('stat_publicationPM'); ?>">
	    			</div>	    			
	    		</div>

    			
    			
    				    			

    			<div class="width100">
    				<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_stat_typologiegts"> Typologie GTS</label> 
		    			<select id="stat_typologiegts" name="stat_typologiegts">
		    			<?php
		    			Select('stat_typologiegts',$STATTYPOGTS);
		    			?>
		    			</select>
	    			</div>

	    			<div class=" width50">
	    			
	    				<label  class="lib"  for="stat_kindImpact"> Kind of impact</label> 
		    			<select id="stat_kindImpact" name="stat_kindImpact">
		    			<?php
		    			Select('stat_kindImpact',$STATKINDIMPACT);
		    			?>
		    			</select>
	    			</div>	    			
	    		</div>

	    		<div class="width100">
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="statPowerprod"> Powerprod</label> 
		    			<select id="statPowerprod" name="statPowerprod" >
		    			<?php
		    			Select('statPowerprod',$STATPOWERPROD);
		    			?>
		    			</select>
	    			</div>
	    			<div class=" width50">
	    				<label  class="lib"> Legacy</label> 
		    			<div style=" font-size:12px;">
						<?php
						Radio('statLegacy',$STATLEGACY);
						?>
						</div>
	    			</div>

	    			    			
	    		</div>
	    		<div class="width100">
                <label class="lib" for="stat_zonegeo">Zone géographique</label>
                <textarea id="stat_zonegeo" name="stat_zonegeo"  maxlength="4000"><?php getVar('stat_zonegeo'); ?></textarea>
    		</div>

    		</div>

    		

    	<input type="submit" value="Soumettre la requête" name="submit" />
	</div>
	</div>

</form>
	<?php 
require_once('../inc/footer.inc.php');
?>