<?php
session_start();
define('TITLE', "Modification d'un Utilisateur");
if(!isset($_SESSION['auth'])){
		
			 	 $_SESSION['flash']['danger'] ="Vous devez être connecté!"; 
			 	 header('Location:index.php');
			 	 die();
			 

	}

require_once('../inc/config.inc.php');
require_once('../classes/db.php');
require_once('../classes/Utilisateurs.php');
$us = new Utilisateurs();
$id=$_GET['id'];
$us->chargerUtilisateur($_GET['id']);

if(!empty($_POST)){
	$errors=array();

	if(empty($_POST['Usernom'])){
		$errors['Usernom']="Votre Nom n'est pas valide";
	}

	if(empty($_POST['Userprenom'])){
		$errors['Userprenom']="Votre Prénom n'est pas valide";
	}

	if(empty($_POST['Username'])){
		$errors['Username']="Votre Pseudo n'est pas valide";
	}else{
		require_once('../classes/db.php');
		$rq="SELECT ID FROM ".SCHEMA.".UTILISATEURS_OSI WHERE LOGIN='".$_POST['Username']."'";	 
		$rq.=" AND ID !='".$id."'";
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->total_record();
			if($res){
				$errors['Username']="Ce Pseudo est déjà utlisé";
			}
	}


	if(empty($_POST['Usermail']) || !filter_var($_POST['Usermail'], FILTER_VALIDATE_EMAIL)){
		$errors['Usermail']="Votre Mail n'est pas valide";
	}else{
		require_once('../classes/db.php');
		$rq="SELECT ID FROM ".SCHEMA.".UTILISATEURS_OSI WHERE MAIL='".$_POST['Usermail']."'";	 
		$rq.=" AND ID !='".$id."'";
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->total_record();
			if($res){
				$errors['Usermail']="Cette adresse mail  est déjà utlisé";
			}
	}

	if(empty($_POST['Userpasswd'])){
		$pass=false;
	}else if($_POST['Userpasswd'] != $_POST['Userpasswd_confirm']){
		$errors['Userpasswd']="Votre Mot de passe n'est pas valide";
		
	}else $pass=true;

	

	if(empty($errors)){
		require_once('../classes/Utilisateurs.php');
		$us= new Utilisateurs();
		if ($_SESSION['auth'][6]==2) {
			$_POST['UserProfil']=2;
		}
	
		$us->SetUtilisateurParam($_GET['id'],$_POST['Usernom'],$_POST['Userprenom'],$_POST['Usermail'],$_POST['Username'],$_POST['Userpasswd'],$_POST['UserProfil']);
		$us->Modifier();
		if ($_GET['id']==$_SESSION['auth'][0]) {
			unset($_SESSION['auth']);
		$_SESSION['auth']=[$_GET['id'],$_POST['Usernom'],$_POST['Userprenom'],$_POST['Usermail'],$_POST['Username'],$_POST['Userpasswd'],$_POST['UserProfil']];
		}
		
		$_SESSION['flash']['success']="Modification avec succés";
	}
}
require ('../inc/header.inc.php');
?>
<h1>Modifier un utlisateur</h1>
<?php
if(!empty($errors)){?>
	<div class="alert alert-danger">
	<ul>
	<p>Vous avez des erreurs dans le remplissage de votre formulaire</p>
		<?php
		foreach ($errors as $error) {
			echo '<li>'.$error.'</li>';
		}
		?>
		</ul>
	</div>

<?php }
?>
<form action="" method="POST">
	<div class="form-group">
	</div>
	<label for="">Nom :</label>
	<input type="text" name="Usernom" class="form-control" value="<?php echo (isset($_POST['Usernom']))?$_POST['Usernom']:$us->getNom();?>" required/>

	<label for="">Prénom :</label>
	<input type="text" name="Userprenom" class="form-control" value="<?php  echo (isset($_POST['Userprenom']))?$_POST['Userprenom']:$us->getPrenom();?>" required/>

	<label for="">Mail :</label>
	<input type="email" name="Usermail" class="form-control"  value="<?php  echo (isset($_POST['Usermail']))?$_POST['Usermail']:$us->getMail();?>" required/>

	<label for="">Pseudo :</label>
	<input type="text" name="Username" class="form-control"  value="<?php  echo (isset($_POST['Username']))?$_POST['Username']:$us->getLogin();?>" required/>

	<label for="">Mot de passe :</label>
	<input type="password" name="Userpasswd" class="form-control" placeholder="Changer le mot de passe" />

	<label for="">Confirmation de mot de passe :</label>
	<input type="password" name="Userpasswd_confirm" class="form-control" placeholder="Confirmer le mot de passe"/>

	<label for="">Profil :</label>
	<select  name="UserProfil" class="form-control" required <?php echo ($_SESSION['auth'][6]== 2)?'disabled="true"':''; ?>>
		<option value="1" <?php echo ((isset($_POST['UserProfil']) && $_POST['UserProfil']==1) || ($us->getProfil()== 1))?'selected':''; ?>>Administrateur</option>
		<option value="2" <?php echo ((isset($_POST['UserProfil']) && $_POST['UserProfil']==2) || ($us->getProfil()== 2))?'selected':''; ?>>Gestionnaire</option>
	</select>
	<br />
	<br />
	<button type="submit" class="btn btn-primary">Modifier</button>
	
</form>
<?php 
require ('../inc/footer.inc.php');
?>