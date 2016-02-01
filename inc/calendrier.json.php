<?php
require_once('config.inc.php');
require_once('fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/Calendrier.php');
$errors=[];
$reg='/^[0-2]?[0-9]:[0-5][0-9]$/';

	if(!preg_match($reg,$_GET['Edit_OuvertJf']))
		{$errors['Edit_OuvertJf']="Le format d'heure d'ouverture de Jour Férier n'est pas valide";}

	if(!preg_match($reg,$_GET['Edit_FermerJf']))
		{$errors['Edit_FermerJf']="Le format d'heure de fermiture de Jour Férier n'est pas valide";}

	if(!preg_match($reg,$_GET['Edit_OuvertLu']))
		{$errors['Edit_OuvertLu']="Le format d'heure d'ouverture de Lundi n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerLu']))
		{$errors['Edit_FermerLu']="Le format d'heure de fermiture de Lundi n'est pas valide";}

	if(!preg_match($reg,$_GET['Edit_OuvertMa']))
		{$errors['Edit_OuvertMa']="Le format d'heure d'ouverture de Mardi n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerMa']))
		{$errors['Edit_FermerMa']="Le format d'heure de fermiture de Mardi n'est pas valide".$_GET['Edit_FermerMa'];}

	if(!preg_match($reg,$_GET['Edit_OuvertMe']))
		{$errors['Edit_OuvertMe']="Le format d'heure d'ouverture de Mercredi n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerMe']))
		{$errors['Edit_FermerMe']="Le format d'heure de fermiture de Mercredi n'est pas valide";}
		
	if(!preg_match($reg,$_GET['Edit_OuvertJe']))
		{$errors['Edit_OuvertJe']="Le format d'heure d'ouverture de Jeudi n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerJe']))
		{$errors['Edit_FermerJe']="Le format d'heure de fermiture de Jeudi n'est pas valide";}

	if(!preg_match($reg,$_GET['Edit_OuvertVe']))
		{$errors['Edit_OuvertVe']="Le format d'heure d'ouverture de Vendredi n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerVe']))
		{$errors['Edit_FermerVe']="Le format d'heure de fermiture de Vendredi n'est pas valide";}
		
	if(!preg_match($reg,$_GET['Edit_OuvertSa']))
		{$errors['Edit_OuvertSa']="Le format d'heure d'ouverture de Samedi n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerSa']))
		{$errors['Edit_FermerSa']="Le format d'heure de fermiture de Samedi n'est pas valide";}
		
	if(!preg_match($reg,$_GET['Edit_OuvertDi']))
		{$errors['Edit_OuvertDi']="Le format d'heure d'ouverture de Dimanche n'est pas valide";}	

	if(!preg_match($reg,$_GET['Edit_FermerDi']))
		{$errors['Edit_FermerDi']="Le format d'heure de fermiture de Dimanche n'est pas valide";}
	$message='';
		if (count($errors)) {
			
				foreach ($errors as $key => $value) {
					$message.=$value."\n";
				}
			}else
			{
			$calendrier= new Calendrier();
			$calendrier->setParam(NULL,$_GET['IdAppli'],$_GET['Edit_OuvertLu'],$_GET['Edit_FermerLu'],$_GET['Edit_OuvertMa'],$_GET['Edit_FermerMa'],$_GET['Edit_OuvertMe'],$_GET['Edit_FermerMe'],$_GET['Edit_OuvertJe'],$_GET['Edit_FermerJe'],$_GET['Edit_OuvertVe'],$_GET['Edit_FermerVe'],$_GET['Edit_OuvertSa'],$_GET['Edit_FermerSa'],$_GET['Edit_OuvertDi'],$_GET['Edit_FermerDi'],$_GET['Edit_OuvertJf'],$_GET['Edit_FermerJf']);
			$calendrier->creer();

			}
$json = json_encode($message);
header('Content-Type: application/json');
echo $json;			
?>