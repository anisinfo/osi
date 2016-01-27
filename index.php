<?php
session_start();
//session_start();
define('TITLE', 'Page de connexion');
if (isset($_SESSION['auth'])) {
	// Si connecté
	header('Location:gestion_incidents/');
	# code...
}
require ('inc/config.inc.php');
require ('inc/fonctions.inc.php');
require ('inc/header.inc.php');
?>
<h1>Se connecter</h1>
<form action="gestion_users/confirm.php" method="POST">
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
require ('inc/footer.inc.php');
?>