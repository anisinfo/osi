<?php
class Utilisateurs{
		private $id;
		private  $_nom="";
		private  $_prenom="";
		private  $_login="";
		private  $_passwd="";
		private  $_mail="";
		private  $_profil=0;
		public  $_ADMIN="Administrateur";
		public  $_NORMAL="Gestionnaire";

		/* Fonction permettant la création d'un utilisateur
		*/
			public function Creer(){
				$rq="INSERT INTO ".SCHEMA.".UTILISATEURS_OSI (NOM,PRENOM,LOGIN,PASSWD,MAIL,PROFIL) VALUES ('".$this->getNom()."','".$this->getPrenom();
				$rq.="','".$this->getLogin()."','".password_hash($this->getPasswd(),PASSWORD_BCRYPT)."','".$this->getMail()."',".$this->getProfil().")";		
				
				$SCHEMA = new db();
				$SCHEMA->db_connect();
				$res=$SCHEMA->db_query($rq);
			//	oci_free_statement($this->sid);
	        //	oci_close($this->$connection);
	        	return $res;
			}


			public function Modifier(){
				$rq="UPDATE ".SCHEMA.".UTILISATEURS_OSI SET NOM='".$this->getNom()."',PRENOM='".$this->getPrenom()."',LOGIN='".$this->getLogin()."'";
				$rq.=($this->getPasswd())?",PASSWD='".password_hash($this->getPasswd(),PASSWORD_BCRYPT)."'":'';
				$rq.=",MAIL='".$this->getMail()."',PROFIL='".$this->getProfil()."'";
				$rq.="WHERE ID=".$this->getId();
		
				$SCHEMA= new db();
				$SCHEMA->db_connect();
				$SCHEMA->db_query($rq);
			}


			public function Lister(){
				$rq="SELECT ID,NOM,PRENOM,MAIL,LOGIN,PASSWD,PROFIL FROM ".SCHEMA.".UTILISATEURS_OSI ORDER BY NOM";
				$SCHEMA= new db();
				$SCHEMA->db_connect();
				$SCHEMA->db_query($rq);
				$res=$SCHEMA->db_fetch_array();
			    return $res;
			}


		/*Fonction qi permet de charger un utlisateurs
		*/
		public function chargerUtilisateur($id){
			$rq="SELECT ID,NOM,PRENOM,MAIL,LOGIN,PASSWD,PROFIL FROM ".SCHEMA.".UTILISATEURS_OSI WHERE ID=".$id;	 
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
			$res=$SCHEMA->db_fetch_array();
			$this->setId($res[0][0]);
			$this->setNom($res[0][1]);
			$this->setPrenom($res[0][2]);
			$this->setMail($res[0][3]);
			$this->setLogin($res[0][4]);
			$this->setPasswd($res[0][5]);
			$this->setProfil($res[0][6]);
		   
		}

		/*Fonction qi permet de remplir un utlisateur
		*/
		public function SetUtilisateurParam($id,$nom,$prenom,$mail,$login,$passwd,$profil){
			$this->setId($id);
			$this->setNom($nom);
			$this->setPrenom($prenom);
			$this->setMail($mail);
			$this->setLogin($login);
			$this->setPasswd($passwd);
			$this->setProfil($profil);   
		}


		/*Fonction qi permet de suppprimer un utulisateur 
			@param: $id
		*/

		public function SupprimerUtilisateur($id){
			$rq="DELETE FROM ".SCHEMA.".UTILISATEURS_OSI WHERE ID=".$id;
			$SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($rq);
		    
		}
//Setteurs et GeTTeurs	

	public function setId($id){
	$this->_id=$id;
	}
	public function getId(){
	return $this->_id;
	}

	public function setNom($nom){
	$this->_nom=$nom;
	}
	public function getNom(){
	return $this->_nom;
	}

	public function setPrenom($prenom){
	$this->_prenom=$prenom;
	}
	public function getPrenom(){
	return $this->_prenom;
	}

	public function setLogin($login){
	$this->_login=$login;
	}
	public function getLogin(){
	return $this->_login;
	}

	public function setPasswd($passwd){
	$this->_passwd=$passwd;
	}
	public function getPasswd(){
	return $this->_passwd;
	}


	public function setMail($mail){
	$this->_mail=$mail;
	}
	public function getMail(){
	return $this->_mail;
	}

	public function setProfil($profil){
	$this->_profil=$profil;
	}
	public function getProfil(){
	return $this->_profil;
	}
}
?>