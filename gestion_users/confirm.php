<?php
session_start();

$login=$_POST['Username'];
$pass=$_POST['Userpasswd'];
if (isset($login) && $login && isset($pass) && $pass){
	require_once('../inc/config.inc.php');
	require_once('../classes/db.php');
	require_once('../inc/fonctions.inc.php');
	$rq="SELECT ID,NOM,PRENOM,MAIL,LOGIN,PASSWD,PROFIL FROM ".SCHEMA.".UTILISATEURS_OSI WHERE LOGIN='".$login."'";
		 
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->db_fetch_array();
			$total=$SCHEMA->total_record();

			
			if($res[0]){
				if(password_verify($pass,$res[0][5])){
					
					$_SESSION['auth']=$res[0];
					unset($_SESSION['flash']);
					$_SESSION['flash']['success']="Vous êtes connecté.";
					$contenu_fichier_json=file_get_contents('../inc/TraceFiche.json');
					$tr = json_decode($contenu_fichier_json, true);
					if (is_array($tr))
					{
						foreach ($tr as $key => $value)
						{
							if ($value['user']==$userConnected)
							{
							unset($tr[$key]);
							}
						}
					}
					$json=json_encode($tr);
					file_put_contents('../inc/TraceFiche.json', $json);
					header('Location:../gestion_incidents/');
				}else{
					$_SESSION['flash']['danger']="Mot de passe incorrecte";
					header('Location:index.php');
				}
				
				
			}else {
				$_SESSION['flash']['danger']= "Le pseudo utlisé n'est pas dans notre SCHEMA";
				header('Location:index.php');
			}

}else{
	$_SESSION['flash']['danger']="Merci de mettre votre login et mot de passe*";
	header('Location:index.php');
}
?>