<?php
//session_start();
define('TITLE', 'Page de connexion');
if (isset($_SESSION['auth'])) {
	 $_SESSION['flash']['danger']="Vous n'";
	// Si connecté
	if ($_SESSION['auth'][6]==1) {

		 header('Location:liste_users.php');
		# code...
	}else{
	 $_SESSION['flash']['danger']="Vous n'avez pas les droits nécessaire pour accéder à la gestion utilisateurs!";	
	 header('Location:../gestion_incidents/');
	}
	# code...
}
require ('../inc/config.inc.php');
require ('../inc/fonctions.inc.php');
require ('../inc/header.inc.php');
?>
<h1>Se connecter</h1>
<form action="confirm.php" method="POST">
	<div class="form-group">
	</div>
	<label for="">Pseudo :</label>
	<input type="text" name="Username" class="form-control" required/>
	<label for="">Mot de passe :</label>
	<input type="password" name="Userpasswd" class="form-control" required/>
	<br />
	<br />
	<button type="submit" class="btn btn-primary">Se connecter</button>
	
</form>
<?php 
require ('../inc/footer.inc.php');
?>