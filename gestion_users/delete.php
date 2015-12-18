<?php
session_start();
if (!isset($_SESSION['auth'])) {
	$_SESSION['flash']['danger']="Vous devez être connecté!";
	 header('Location:index.php');
	 die();
	# code...
}elseif ($_SESSION['auth'][6]==2) {
	$_SESSION['flash']['danger']="Vous n'avez pas les droits nécissaires!";
	 header('Location:index.php');
	 die();
}
if(!isset($_GET['id'])){
	$_SESSION['flash']['danger']="Erreur de l'id de l'utilisateur à supprimé!";
	 header('Location:liste_users.php');
	 die();
}
$id=$_GET['id'];

if ($id){
	require_once('../inc/config.inc.php');
	require_once('../classes/db.php');
	require_once('../classes/Utilisateurs.php');
	require_once('../inc/fonctions.inc.php');
	$us = new Utilisateurs();
	$res =$us->SupprimerUtilisateur($id);
			
	if ($id==$_SESSION['auth'][0]) {
			unset($_SESSION['auth']);
			$_SESSION['flash']['success']="Votre compte est Supprimé, Vous n'etes plus connecté!";
			header('Location:index.php');	
					}else {
				$_SESSION['flash']['success']="Utilisateur Supprimé";					
				header('Location:liste_users.php');			
					}
						
}
?>