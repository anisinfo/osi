<?php
define('TITLE', 'Liste des utilisateurs');
require ('../inc/header.inc.php');
require_once('../inc/config.inc.php');
require_once('../classes/db.php');
require_once('../classes/Utilisateurs.php');

$us= new Utilisateurs();
$liste =$us->Lister();	
if(isset($_SESSION['auth'])){
	if($_SESSION['auth'][6]==2){
		$_SESSION['flash']['danger'] ="Vous devez étre connecté en tant que Administrateur"; 
			 	 header('Location:../gestion_incidents/index.php');
			 	 die();

	}
	?>
	<table class="table" >
	<thead>
	<tr>
		<th>Nom</th>
		<th>Prenom</th>
		<th>Mail</th>
		<th>Login</th>
		<th>Profil</th>
		<th></th>
		<th></th>
		</tr>
	</thead>
	<tbody>	
<?php 
	foreach($liste as $ligne){
		$profil=($ligne[6]==1)?$us->_ADMIN:$us->_NORMAL;
		echo "<tr>";
		echo "<td>".$ligne[1]."</td>";
		echo "<td>".$ligne[2]."</td>";
		echo "<td>".$ligne[3]."</td>";
		echo "<td>".$ligne[4]."</td>";
		echo "<td>".$profil."</td>";
		echo '<td><a href="'.RACINE.'gestion_users/modif.php?id='.$ligne[0].'">Modifier</a></td>';
		echo '<td><a onclick="supprimer(\''.RACINE.'gestion_users/delete.php?id='.$ligne[0].'\')">Supprimer</a></td>';
		echo "</tr>";
		
	}
	?>
	</tbody>
	</table>
	<?php 
	}else{

		$_SESSION['flash']['danger'] ="Vous devez étre connecté!"; 
		header('Location:index.php');
		die();
	 } 
require ('../inc/footer.inc.php');
?>