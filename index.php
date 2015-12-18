<?php
if(!isset($_SESSION['auth'])){
		header('Location:gestion_users/');
	
	}
require ('inc/header.inc.php');

require ('inc/footer.inc.php');
?>