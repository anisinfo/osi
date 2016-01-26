<?php
session_start();
if(!isset($_SESSION['auth'])){
		header('Location:gestion_users/');
	
	}else header('Location:gestion_incidents/');
//require ('inc/header.inc.php');

//require ('inc/footer.inc.php');
?>