<?php
session_start();
define('TITLE',"Pas d'incidents");
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/incidents.php');

if(isset($_GET['supprimer']))
{
	$incidents = new incidents();
	$incidents->chargerIncident($_GET['id']);
	$incidents->Supprimer();

	$contenu_fichier_json=file_get_contents('../inc/TraceFiche.json');
	$tr = json_decode($contenu_fichier_json, true);
	unset($tr[$_GET['id']]);
	$json=json_encode($tr);
	file_put_contents('../inc/TraceFiche.json', $json);
	
	$_SESSION['flash']['success']="L'incident est bien supprimé!";	
}
$req="SELECT ID,INCIDENT FROM ".SCHEMA.".INCIDENT";
$req.=" ORDER BY ID DESC";

 $db= new db();
 $db->db_connect();
 $db->db_query($req);
 $res=$db->db_fetch_array();
 if (!isset($res[0][0])) {
 	require_once('../inc/header.inc.php');
 	?>
<h1>Pas d'incidents</h1>
<a class="btn btn-success"  href="add.php">Ajouter Incident</a>
 	<?php 
 	require_once('../inc/footer.inc.php');

 	
 }else header('Location:modif.php?id='.$res[0][0]);
//debug($res);
?>