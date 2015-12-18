<?php
require_once('inc/config.inc.php');
require_once('inc/fonctions.inc.php');
try
{
	// connexion à la base Oracle et création de l'objet
	$connexion = new PDO(LIEN_BASE, SCHEMA_LOGIN, SCHEMA_PASS);
}
catch (PDOException $erreur)
{
	echo $erreur->getMessage();
}

$voiture = $connexion->query("SELECT * FROM ".SCHEMA.".INCIDENT WHERE ID = ".$connexion->quote(1)."")->fetch();
debug($voiture);
?>
