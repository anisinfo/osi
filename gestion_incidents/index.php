<?php
session_start();
define('TITLE',"Pas d'incidents");
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');
require_once('../classes/incidents.php');
require_once('../classes/Impact.php');
require_once('../classes/Stat.php');

if(isset($_GET['supprimer']))
{
	$incidents = new incidents();
	$userConnected=$_SESSION['auth'][2].' '.$_SESSION['auth'][1];	
	$incidents->_setUser($userConnected);
	$incidents->chargerIncident($_GET['id']);
	if($incidents->getIdStat())
	{
		$stat= new Stat();
		$stat->_setId($incidents->getIdStat());
		$stat->Supprimer();
	}

	$impact = new Impact();
	$impact->_setIncidentId($_GET['id']);
	$impact->supprimerTout();

	$incidents->Supprimer();
	$_SESSION['flash']['success']="L'incident est supprimé!";

	
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