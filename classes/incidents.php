<?php
 class incidents extends Impact
{
	private $_numero;
	
	private $_titre;
	private $_departement;
	private $_statut;
	private $_priorite;
	private $_utilisImpacte;
	private $_dateDebut;
	private $_dateFin;
	private $_duree;
	private $_descripIncident;
	private $_risqueAggravation;
	private $_cause;
	private $_connexe;
	private $_probleme;
	private $_retablissement;
	private $_responsabilite;
	private $_acteur;
	private $_localisation;
	private $_actionUtlisateur;
	private $_dateCreci;
	private $_commentaire;	
	private $_dejaApparu;
	private $_previsible;
	

	public function CreateIncident()
	{
		// Insertion du partie commun d'un incidents
		$rq="INSERT INTO ".SCHEMA.".INCIDENT (INCIDENT,TITRE,DEPARTEMENT,STATUT,PRIORITE,AFFECTEDUSER,DATEDEBUT,DATEFIN,DUREE,DESCRIPTION,RISQUEAGGRAVATION,CAUSE,INCIDENTSCONNEXES,PROBLEME,RETABLISSEMENT,RESPONSABILITE,SERVICEACTEUR,LOCALISATION,USERACTION,DATEPUBLICATION,COMMENTAIRE,DEJAAPPARU,PREVISIBLE,CREATED,UPDATED)";
		$rq.=" VALUES ('".$this->getTitre().rand()."','".$this->getTitre()."','".$this->getDepartement()."','".$this->getStatut()."','".$this->getPriorite()."','".$this->getUtilisImpacte()."','".$this->getDateDebut()."','".$this->getDateFin()."','".$this->getDuree()."',";
		$rq.="'".str_replace("'","", $this->getDescripIncident())."',".$this->getRisqueAggravation().",'".addslashes($this->getCause())."','".$this->getConnexe()."','".addslashes($this->getProbleme())."','".addslashes($this->getRetablissement())."','".$this->getResponsabilite()."','".$this->getActeur()."','".addslashes($this->getLocalisation())."','".addslashes($this->getActionUtlisateur())."',TO_TIMESTAMP('".$this->getDateCreci()."','YYYY-MM-DD'),'".addslashes($this->getCommentaire())."',".$this->getDejaApparu().",".$this->getPrevisible().",sysdate,sysdate)";
        // Insertion de l'application impactée
        //$rq.=parent::creer();
     /*   try
            {
                // connexion à la base Oracle et création de l'objet
                $connexion = new PDO(LIEN_BASE, SCHEMA_LOGIN, SCHEMA_PASS);
            }
            catch (PDOException $erreur)
            {
                echo $erreur->getMessage();
            }*/

       //     $voiture = $connexion->query($rq);
         //   debug($voiture);
		
		$db = new db();
		$db->db_connect();
		$db->db_query($rq);
        // Recuperation de ID de l'incident
        $req="SELECT MAX(ID) FROM ".SCHEMA.".INCIDENT";
        $db->db_query($req); 
		$res=$db->db_fetch_array();
        $id_incident=$res[0][0];
		return $id_incident;

	}
	

	public function setIncident($id,$titre,$departement,$statut,$priorite,$affectesuser,$datedebut,$datefin,$duree,$description,$risqueAggravation,$cause,$incidentsconnexes,$probleme,$retablissement,$responsabilite,$serviceacteur,$localisation,$useraction,$creci,$commentaire,$dejaApparu,$previsible)
	{
		$this->_setNumero($id);
		$this->_setTitre($titre);
		$this->_setDepartement($departement);
		$this->_setStatut($statut);
		$this->_setPriorite($priorite);
		$this->_setUtilisImpacte($affectesuser);
		$this->_setDateDebut($datedebut);
		$this->_setDateFin($datefin);
		$this->_setDuree($duree);
		$this->_setDescripIncident($description);
		$this->_setRisqueAggravation($risqueAggravation);
		$this->_setCause($cause);
		$this->_setConnexe($incidentsconnexes);
		$this->_setProbleme($probleme);
		$this->_setRetablissement($retablissement);
		$this->_setResponsabilite($responsabilite);
		$this->_setActeur($serviceacteur);
		$this->_setLocalisation($localisation);
		$this->_setActionUtlisateur($useraction);
		$this->_setDateCreci($creci);
		$this->_setCommentaire($commentaire);
		$this->_setDejaApparu($dejaApparu);
		$this->_setPrevisible($previsible);

return $this;
	}
    /*
    * Fonction qui permet de charger les informations conçernant un incident avec son id
    * @param: $id de l'incident en question
    * return : l'objet incident rempli
    */
    public function chargerIncident($id)
    {
        $req="SELECT ID,TITRE,DEPARTEMENT,STATUT,PRIORITE,AFFECTEDUSER,DATEDEBUT,DATEFIN,DUREE,DESCRIPTION,RISQUEAGGRAVATION,CAUSE,INCIDENTSCONNEXES,PROBLEME,RETABLISSEMENT,RESPONSABILITE,SERVICEACTEUR,LOCALISATION,USERACTION,DATEPUBLICATION,COMMENTAIRE,DEJAAPPARU,PREVISIBLE FROM ".SCHEMA.".INCIDENT WHERE ID=".$id;
      //  $req="SELECT * FROM ".SCHEMA.".INCIDENT WHERE ID=".$id;
  
       $SCHEMA= new db();
			$SCHEMA->db_connect();
			$SCHEMA->db_query($req);
			$res=$SCHEMA->db_fetch_array();
			  $this->setIncident($res[0][0],$res[0][1],$res[0][2],$res[0][3],$res[0][4],$res[0][5],$res[0][6],$res[0][7],$res[0][8],$res[0][9],$res[0][10],$res[0][11],$res[0][12],$res[0][13],$res[0][14],$res[0][15],$res[0][16],$res[0][17],$res[0][18],$res[0][19],$res[0][20],$res[0][21],$res[0][22]);
			//debug($res[0]);


 
         return $this; 
              
    }

	public function Modifier()
	{
		$rq="UPDATE ".SCHEMA.".INCIDENT SET ";
		$rq.="TITRE='".$this->getTitre()."',";
		$rq.="DEPARTEMENT='".$this->getDepartement()."',";
		$rq.="STATUT='".$this->getStatut()."',";
		$rq.="PRIORITE='".$this->getPriorite()."',";
		$rq.="AFFECTEDUSER='".$this->getUtilisImpacte()."',";
		$rq.="DATEDEBUT='".$this->getDateDebut()."',";
		$rq.="DATEFIN='".$this->getDateFin()."',";
		$rq.="DUREE='".$this->getDuree()."',";
		$rq.="DESCRIPTION='".$this->getDescripIncident()."',";
		$rq.="RISQUEAGGRAVATION='".$this->getRisqueAggravation()."',";
		$rq.="CAUSE='".$this->getCause()."',";
		$rq.="INCIDENTSCONNEXES='".$this->getConnexe()."',";
		$rq.="PROBLEME='".$this->getProbleme()."',";
		$rq.="RETABLISSEMENT='".$this->getRetablissement()."',";
		$rq.="RESPONSABILITE='".$this->getResponsabilite()."',";
		$rq.="SERVICEACTEUR='".$this->getActeur()."',";
		$rq.="LOCALISATION='".$this->getLocalisation()."',";
		$rq.="USERACTION='".$this->getActionUtlisateur()."',";
		$rq.="CRECI='".$this->getDateCreci()."',";
		$rq.="COMMENTAIRE='".$this->getCommentaire()."',";
		$rq.="DEJAAPPARU='".$this->getDejaApparu()."',";
		$rq.="PREVISIBLE='".$this->getPrevisible()."',";
		$rq.="UPDATED=sysdate";

		$rq.=" WHERE ID=".$this->getNumero();


		$base= new db();
		$base->db_connect();
		$base->db_query($rq);
	}
	public function sauvegarder()
	{
		if ($this->getNumero() == NULL) 
			return $this->CreateIncident();
		else
			return $this->Modifier();			
	}

    /**
     * Gets the value of _numero.
     *
     * @return mixed
     */
    public function getNumero()
    {
        return $this->_numero;
    }

    /**
     * Sets the value of _numero.
     *
     * @param mixed $_numero the numero
     *
     * @return self
     */
    private function _setNumero($numero)
    {
        $this->_numero = $numero;

        return $this;
    }

    /**
     * Gets the value of _titre.
     *
     * @return mixed
     */
    public function getTitre()
    {
        return $this->_titre;
    }

    /**
     * Sets the value of _titre.
     *
     * @param mixed $_titre the titre
     *
     * @return self
     */
    private function _setTitre($titre)
    {
        $this->_titre = $titre;

        return $this;
    }

    /**
     * Gets the value of _departement.
     *
     * @return mixed
     */
    public function getDepartement()
    {
        return $this->_departement;
    }

    /**
     * Sets the value of _departement.
     *
     * @param mixed $_departement the departement
     *
     * @return self
     */
    private function _setDepartement($departement)
    {
        $this->_departement = $departement;

        return $this;
    }

    /**
     * Gets the value of _statut.
     *
     * @return mixed
     */
    public function getStatut()
    {
        return $this->_statut;
    }

    /**
     * Sets the value of _statut.
     *
     * @param mixed $_statut the statut
     *
     * @return self
     */
    private function _setStatut($statut)
    {
        $this->_statut = $statut;

        return $this;
    }

    /**
     * Gets the value of _priorite.
     *
     * @return mixed
     */
    public function getPriorite()
    {
        return $this->_priorite;
    }

    /**
     * Sets the value of _priorite.
     *
     * @param mixed $_priorite the priorite
     *
     * @return self
     */
    private function _setPriorite($priorite)
    {
        $this->_priorite = $priorite;

        return $this;
    }

    /**
     * Gets the value of _utilisImpacte.
     *
     * @return mixed
     */
    public function getUtilisImpacte()
    {
        return $this->_utilisImpacte;
    }

    /**
     * Sets the value of _utilisImpacte.
     *
     * @param mixed $_utilisImpacte the utilis impacte
     *
     * @return self
     */
    private function _setUtilisImpacte($utilisImpacte)
    {
        $this->_utilisImpacte = $utilisImpacte;

        return $this;
    }

    /**
     * Gets the value of _dateDebut.
     *
     * @return mixed
     */
    public function getDateDebut()
    {
        return $this->_dateDebut;
    }

    /**
     * Sets the value of _dateDebut.
     *
     * @param mixed $_dateDebut the date debut
     *
     * @return self
     */
    private function _setDateDebut($dateDebut)
    {
        $this->_dateDebut = $dateDebut;

        return $this;
    }

    /**
     * Gets the value of _dateFin.
     *
     * @return mixed
     */
    public function getDateFin()
    {
        return $this->_dateFin;
    }

    /**
     * Sets the value of _dateFin.
     *
     * @param mixed $_dateFin the date fin
     *
     * @return self
     */
    private function _setDateFin($dateFin)
    {
        $this->_dateFin = $dateFin;

        return $this;
    }

    /**
     * Gets the value of _duree.
     *
     * @return mixed
     */
    public function getDuree()
    {
        return $this->_duree;
    }

    /**
     * Sets the value of _duree.
     *
     * @param mixed $_duree the duree
     *
     * @return self
     */
    private function _setDuree($duree)
    {
        $this->_duree = $duree;

        return $this;
    }

    /**
     * Gets the value of _descripIncident.
     *
     * @return mixed
     */
    public function getDescripIncident()
    {
        return $this->_descripIncident;
    }

    /**
     * Sets the value of _descripIncident.
     *
     * @param mixed $_descripIncident the descrip incident
     *
     * @return self
     */
    private function _setDescripIncident($descripIncident)
    {
        $this->_descripIncident = $descripIncident;

        return $this;
    }

    /**
     * Gets the value of _risqueAggravation.
     *
     * @return mixed
     */
    public function getRisqueAggravation()
    {
        return $this->_risqueAggravation;
    }

    /**
     * Sets the value of _risqueAggravation.
     *
     * @param mixed $_risqueAggravation the risque aggravation
     *
     * @return self
     */
    private function _setRisqueAggravation($risqueAggravation)
    {
        $this->_risqueAggravation = $risqueAggravation;

        return $this;
    }

    /**
     * Gets the value of _cause.
     *
     * @return mixed
     */
    public function getCause()
    {
        return $this->_cause;
    }

    /**
     * Sets the value of _cause.
     *
     * @param mixed $_cause the cause
     *
     * @return self
     */
    private function _setCause($cause)
    {
        $this->_cause = $cause;

        return $this;
    }

    /**
     * Gets the value of _connexe.
     *
     * @return mixed
     */
    public function getConnexe()
    {
        return $this->_connexe;
    }

    /**
     * Sets the value of _connexe.
     *
     * @param mixed $_connexe the connexe
     *
     * @return self
     */
    private function _setConnexe($connexe)
    {
        $this->_connexe = $connexe;

        return $this;
    }

    /**
     * Gets the value of _probleme.
     *
     * @return mixed
     */
    public function getProbleme()
    {
        return $this->_probleme;
    }

    /**
     * Sets the value of _probleme.
     *
     * @param mixed $_probleme the probleme
     *
     * @return self
     */
    private function _setProbleme($probleme)
    {
        $this->_probleme = $probleme;

        return $this;
    }

    /**
     * Gets the value of _retablissement.
     *
     * @return mixed
     */
    public function getRetablissement()
    {
        return $this->_retablissement;
    }

    /**
     * Sets the value of _retablissement.
     *
     * @param mixed $_retablissement the retablissement
     *
     * @return self
     */
    private function _setRetablissement($retablissement)
    {
        $this->_retablissement = $retablissement;

        return $this;
    }

    /**
     * Gets the value of _responsabilite.
     *
     * @return mixed
     */
    public function getResponsabilite()
    {
        return $this->_responsabilite;
    }

    /**
     * Sets the value of _responsabilite.
     *
     * @param mixed $_responsabilite the responsabilite
     *
     * @return self
     */
    private function _setResponsabilite($responsabilite)
    {
        $this->_responsabilite = $responsabilite;

        return $this;
    }

    /**
     * Gets the value of _acteur.
     *
     * @return mixed
     */
    public function getActeur()
    {
        return $this->_acteur;
    }

    /**
     * Sets the value of _acteur.
     *
     * @param mixed $_acteur the acteur
     *
     * @return self
     */
    private function _setActeur($acteur)
    {
        $this->_acteur = $acteur;

        return $this;
    }

    /**
     * Gets the value of _localisation.
     *
     * @return mixed
     */
    public function getLocalisation()
    {
        return $this->_localisation;
    }

    /**
     * Sets the value of _localisation.
     *
     * @param mixed $_localisation the localisation
     *
     * @return self
     */
    private function _setLocalisation($localisation)
    {
        $this->_localisation = $localisation;

        return $this;
    }

    /**
     * Gets the value of _dateCreci.
     *
     * @return mixed
     */
    public function getDateCreci()
    {
        return $this->_dateCreci;
    }

    /**
     * Sets the value of _dateCreci.
     *
     * @param mixed $_dateCreci the date creci
     *
     * @return self
     */
    private function _setDateCreci($dateCreci)
    {
        $this->_dateCreci = $dateCreci;

        return $this;
    }

    /**
     * Gets the value of _commentaire.
     *
     * @return mixed
     */
    public function getCommentaire()
    {
        return $this->_commentaire;
    }

    /**
     * Sets the value of _commentaire.
     *
     * @param mixed $_commentaire the commentaire
     *
     * @return self
     */
    private function _setCommentaire($commentaire)
    {
        $this->_commentaire = $commentaire;

        return $this;
    }

    /**
     * Gets the value of _dejaApparu.
     *
     * @return mixed
     */
    public function getDejaApparu()
    {
        return $this->_dejaApparu;
    }

    /**
     * Sets the value of _dejaApparu.
     *
     * @param mixed $_dejaApparu the deja apparu
     *
     * @return self
     */
    private function _setDejaApparu($dejaApparu)
    {
        $this->_dejaApparu = $dejaApparu;

        return $this;
    }

    /**
     * Gets the value of _previsible.
     *
     * @return mixed
     */
    public function getPrevisible()
    {
        return $this->_previsible;
    }

    /**
     * Sets the value of _previsible.
     *
     * @param mixed $_previsible the previsible
     *
     * @return self
     */
    private function _setPrevisible($previsible)
    {
        $this->_previsible = $previsible;

        return $this;
    }

    /**
     * Gets the value of _actionUtlisateur.
     *
     * @return mixed
     */
    public function getActionUtlisateur()
    {
        return $this->_actionUtlisateur;
    }

    /**
     * Sets the value of _actionUtlisateur.
     *
     * @param mixed $_actionUtlisateur the action utlisateur
     *
     * @return self
     */
    private function _setActionUtlisateur($actionUtlisateur)
    {
        $this->_actionUtlisateur = $actionUtlisateur;

        return $this;
    }
}
?>