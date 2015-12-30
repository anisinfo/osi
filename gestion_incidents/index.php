<?php
require_once('../inc/config.inc.php');
require_once('../inc/fonctions.inc.php');
require_once('../classes/db.php');


$req="SELECT MAX(ID) FROM ".SCHEMA.".INCIDENT";

 $db= new db();
 $db->db_connect();
 $db->db_query($req);
 $res=$db->db_fetch_array();
 if (empty($res[0][0])) {
 	require_once('../inc/header.inc.php');
 	?>
<h1>Pas d'incidents</h1>
 	<?php 
 	require_once('../inc/footer.inc.php');

 	
 }else
 header('Location:modif.php?id='.$res[0][0]);

?>