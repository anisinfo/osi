<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
	}

$idIncident=(isset($_GET['idIncident']))?$_GET['idIncident']:'';
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	

if ($idIncident=='') {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";
}

define('TITLE',"Modification de stat N°:' ".$idIncident);

require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Stat.php');
require_once('../classes/incidents.php');

if (!empty($_POST)) {
	$errors=array();
	/*
	Contrôle des champs obligatoire
	*/
	if(empty($_POST['refchangement'])){
		$errors['refchangement']="Vous devez remplir le champ reférencement changement!";
	}
	if (empty($errors)) {
	$listeCheck='';
	for($i=0;$i< count($STATGEOL);$i++)
	{
		
		if(isset($_POST['stat_zonegeo_'.$i]))
		{
			$listeCheck.=$i.',';
		}

	}

	$stat= new Stat();
    $stat->SetParam(NULL,$idIncident,$_POST['refchangement'],$_POST['stat_publicationIR'],$_POST['stat_publicationPM'],$_POST['stat_typecause'],$_POST['stat_typecause_second'],$_POST['stat_typologiegts'],$_POST['stat_kindImpact'],$_POST['stat_equipeResp'],$_POST['fournisseurResp'],$_POST['statPowerprod'],$_POST['statLegacy'],$_POST['stat_Composant'],$_POST['Composant_complement'],$listeCheck);
    $idStat=$stat->Creer();
    $_SESSION['flash']['success']="Le stat est Bien Ajouté !";
    header('Location:modifStat.php?idStat='.$idStat.'&idIncident='.$idIncident);
	}
}else
{

$incident= new incidents();
$incident->_setUser($userConnected);
$incident->chargerIncident($idIncident);

//debug($Impacte);	
}

require_once('../inc/header.inc.php');
?>
<h1>Statistique</h1>


<form action="" method="POST">
	<div class="bloc">
	<div class="bloc">
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">Edition de l'incident N° <strong> <?=$incident->getIncident(); ?></strong></span>
	<span class="lib" style="float:left; margin-left:25px; line-height:2.5;">Titre comm <strong><?= $incident->getTitre(); ?> </strong> </span>
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
                <?php getCheckListe('stat_zonegeo',$STATGEOL); ?>
    		</div>

    		</div>

    		

    	<input type="submit" value="Soumettre la requête" name="submit" />
    	<input type="button" value="Annuler" onclick="javascript:document.location.href='modif.php?id=<?= $_GET['idIncident'];?>'" />
	</div>
	</div>

</form>
	<?php 
require_once('../inc/footer.inc.php');
?>