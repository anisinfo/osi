<?php
session_start();
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:../index.php');
			 	 die();
	}

$idIncident=(isset($_GET['idIncident']))?$_GET['idIncident']:'';

$idStat=(isset($_GET['idStat']))?$_GET['idStat']:'';
$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	

if (!$idIncident) {
	$_SESSION['flash']['erreur']="Pas de numéro d'incident passé !";	
	die();
}

if (!$idStat) {
	$_SESSION['flash']['erreur']="Pas de numéro de stat passé !";	
	die();
}

define('TITLE',"Modification de stat N°:".$idIncident);

require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Stat.php');
require_once('../classes/incidents.php');
require_once('../classes/Impact.php');
require_once('../classes/Application.php');

if (!empty($_POST)) {
	$errors=array();
	/*
	Contrôle des champs obligatoire
	
	if(empty($_POST['refchangement'])){
		$errors['refchangement']="Vous devez remplir le champ reférencement changement!";
	}
	*/
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
	$statLegacy=(isset($_POST['statLegacy']))?$_POST['statLegacy']:'';
    $stat->SetParam($idStat,$idIncident,$_POST['refchangement'],$_POST['stat_publicationIR'],$_POST['stat_publicationPM'],$_POST['stat_typecause'],$_POST['stat_typecause_second'],$_POST['stat_typologiegts'],$_POST['stat_equipeResp'],$_POST['fournisseurResp'],$_POST['statPowerprod'],$statLegacy,$_POST['stat_Composant'],$_POST['Composant_complement'],$listeCheck);
    $stat->Modifier();
    $_SESSION['flash']['success']="Le Stat est bien modifié!";
	}
}

$incident= new incidents();
$incident->_setUser($userConnected);
$incident->chargerIncident($idIncident);
$impacte= new Impact();
$impacte->chargerFirstIncident($idIncident);
$application= new Application();
$application->SelectAppliById($impacte->getApplicationId());
$stat = new Stat();
$stat->SelectStatById($idStat,$idIncident);	

require_once('../inc/header.inc.php');
?>
<h1>Statistique</h1>


<form action="" method="POST">
	
	<div class="bloc">
	<?php
	$link="Stat";
	require_once('../inc/search.inc.php');
	?>
	<div class="width100 input-group-addon">
	<span class="fl-left" style=" line-height:2.5;">Edition de l'incident N° <strong> <?=$incident->getIncident(); ?></strong></span>
	<span class="lib" style="float:left; margin-left:25px; line-height:2.5;">Titre comm <strong><?= $incident->getTitre(); ?> </strong> </span>
	</div>
	<div class="width100 bcg">
    		<div class=" width50 fl-left"> 
    			<div class="width50">
		    		<label  class="lib"  for="Incident_Impact_stat_refchangement"> Ref changement</label> 
		    		<input type="text"  name="refchangement"  value="<?php getVarUpdate('refchangement',$stat->getRefChangement()); ?>" >
	    		</div>

	    		
	    		<div class="width100">

	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="stat_typecause"> Type de cause</label> 
		    			<select id="stat_typecause" name="stat_typecause">
		    			<?php
		    			SelectUpdate('stat_typecause',$stat->getTypeCause(),$STATTYPECAUSE);
		    			?>
		    			</select>
	    			</div>	
	    			<div class=" width50">
	    				<label  class="lib"  for="typecause_second"> Type de cause secondaire</label> 
		    			<input type="text"  name="stat_typecause_second" id="stat_typecause_second"  value="<?php getVarUpdate('stat_typecause_second',$stat->getTypeCauseSecondaire()); ?>" >
	    			</div>	
    			
	    		</div>
	    		<div class="width100">
	    		<div class=" width50 mr_10">
	    				<label  class="lib"  for="stat_equipeResp"> Equipe responsable</label> 
		    			<input type="text" name="stat_equipeResp" id="stat_equipeResp" value="<?php getVarUpdate('stat_equipeResp',$stat->getEquipeResponsable()); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="stat_fournisseurResp"> Fournisseur responsable </label> 
		    			<input type="text" name="fournisseurResp" id="fournisseurResp"  value="<?php getVarUpdate('fournisseurResp',$stat->getFournisseurResponsable()); ?>">
	    			</div>
	    		</div>
	    		<div class="width100">

	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="Incident_Impact_stat_Composant"> Composant</label> 
		    			<select id="stat_Composant" name="stat_Composant">
		    			<?php
		    			SelectUpdate('stat_Composant',$stat->getComposant(),$STATCOMPOSANT);
		    			?>
		    			</select>
	    			</div>	
	    			<div class=" width50">
	    				<label  class="lib"  for="Composant_complement"> Composant complément</label> 
		    			<input type="text"  name="Composant_complement" id="Composant_complement"  value="<?php getVarUpdate('Composant_complement',$stat->getComposantComplement());?>" >
	    			</div>	
    			
	    		</div>
    		</div>

    		<div class=" width50 right">

    			<div class="width100">

    				
	    			<div class=" width50 mr_10">
	    				<label  class="lib"  for="tat_publicationIR"> Publication IR</label> 
		    			<input type="text" name="stat_publicationIR" id="stat_publicationIR" value="<?php getVarUpdate('stat_publicationIR',$stat->getDatePublicationIr()); ?>" >
	    			</div>

	    			<div class=" width50">
	    				<label  class="lib"  for="stat_publicationPM"> Publication PM </label> 
		    			<input type="text" name="stat_publicationPM" id="stat_publicationPM"  value="<?php getVarUpdate('stat_publicationPM',$stat->getDatePublicationPm()); ?>">
	    			</div>	    			
	    		</div>

    			
    			
    				    			

    			<div class="width100">
    				<div class=" width50">
	    				<label  class="lib"  for="Incident_Impact_stat_typologiegts"> Typologie GTS</label> 
		    			<select id="stat_typologiegts" name="stat_typologiegts">
		    			<?php
		    			SelectUpdate('stat_typologiegts',$stat->getTypologieGts(),$STATTYPOGTS);
		    			?>
		    			</select>
	    			</div>
    			
	    			<div class=" width50 right">
	    				<label  class="lib"  for="statPowerprod"> Powerprod</label> 
		    			<select id="statPowerprod" name="statPowerprod" >
		    			<?php
		    			SelectUpdate('statPowerprod',$stat->getPowerProd(),$STATPOWERPROD);
		    			?>
		    			</select>
	    			</div>
	    			<div class=" width50">
	    				<label  class="lib"> Legacy</label> 
		    			<div style=" font-size:12px;">
						<?php
						RadioUpdate('statLegacy',$stat->getLegacy(),$STATLEGACY);
						?>
						</div>
	    			</div>

	    			    			
	    		</div>
	    		<div class="width100">
                <label class="lib" for="stat_zonegeo">Zone géographique</label>
               <?php
               getCheckListeUpdate('stat_zonegeo',$stat->getZoneGeographique(),$STATGEOL); 
               ?>
    		</div>

    		</div>

    		

    	<input type="submit" value="Sauvegarder" name="submit" />
	</div>
</form>
<?php
require_once('../inc/commachaud.inc.php');
require_once('../inc/footer.inc.php');
?>