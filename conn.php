<?php
require_once('inc/config.inc.php');
require_once('inc/fonctions.inc.php');
try
{
	// connexion à la base Oracle et création de l'objet
 $dbc = new PDO('oci:dbname='.HOST.':'.PORT.'/'.SERVICE.';charset=CL8MSWIN1251', SCHEMA_LOGIN, SCHEMA_PASS);
 $sql='SELECT * FROM STROSI.CALENDRIER WHERE  APPLICATION_ID=1';
 debug($dbc->query($sql));
}
catch (PDOException $erreur)
{
	echo $erreur->getMessage();
}

//$voiture = $connexion->query("SELECT * FROM ".SCHEMA.".INCIDENT WHERE ID = ".$connexion->quote(1)."")->fetch();
//debug($voiture);
?>
