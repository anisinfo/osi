<?php
 class incidents 
{
	private $_numero;
	private $_idStat;
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
    private $_incident;
    private $_user;
    private $_estOuvert=false;
    private $_suivi;
    private $_dateDecision;
    private $_chronogramme;
	

	public function CreateIncident()
	{
		// Insertion du partie commun d'un incidents
		$rq="INSERT INTO ".SCHEMA.".INCIDENT (INCIDENT,TITRE,DEPARTEMENT,STATUT,PRIORITE,AFFECTEDUSER,DATEDEBUT,DATEFIN,DUREE,DESCRIPTION,RISQUEAGGRAVATION,CAUSE,INCIDENTSCONNEXES,PROBLEME,RETABLISSEMENT,RESPONSABILITE,SERVICEACTEUR,LOCALISATION,USERACTION,DATEPUBLICATION,COMMENTAIRE,DEJAAPPARU,PREVISIBLE,CREATED,UPDATED,SUIVI,DATE_DECISION,CHRONOGRAMME)";
		$rq.=" VALUES ('".oci_escape_string(html_entity_decode($this->getIncident()))."','".oci_escape_string(html_entity_decode($this->getTitre()))."','".oci_escape_string(html_entity_decode($this->getDepartement()))."','".$this->getStatut()."','".$this->getPriorite()."','".oci_escape_string(html_entity_decode($this->getUtilisImpacte()))."',TO_TIMESTAMP('".$this->getDateDebut()."','DD/MM/YYYY HH24:MI'),TO_TIMESTAMP('".$this->getDateFin()."','DD/MM/YYYY HH24:MI'),'".$this->getDuree()."',";
		$rq.="'".oci_escape_string(html_entity_decode($this->getDescripIncident()))."',".$this->getRisqueAggravation().",'".oci_escape_string(html_entity_decode($this->getCause()))."','".$this->getConnexe()."','".oci_escape_string(html_entity_decode($this->getProbleme()))."','".oci_escape_string(html_entity_decode($this->getRetablissement()))."','".$this->getResponsabilite()."','".$this->getActeur()."','".oci_escape_string(html_entity_decode($this->getLocalisation()))."','".oci_escape_string(html_entity_decode($this->getActionUtlisateur()))."',TO_TIMESTAMP('".$this->getDateCreci()."','DD/MM/YYYY'),'".oci_escape_string(html_entity_decode($this->getCommentaire()))."',".$this->getDejaApparu().",".$this->getPrevisible().",sysdate,sysdate,".$this->getSuivi().",TO_TIMESTAMP('".$this->getDateDecision()."','DD/MM/YYYY HH24:MI'),'".oci_escape_string(html_entity_decode($this->getChronogramme()))."')";
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
	

	public function setIncident($id,$idStat,$incident,$titre,$departement,$statut,$priorite,$affectesuser,$datedebut,$datefin,$duree,$description,$risqueAggravation,$cause,$incidentsconnexes,$probleme,$retablissement,$responsabilite,$serviceacteur,$localisation,$useraction,$creci,$commentaire,$dejaApparu,$previsible,$suivi,$dateDecision,$chronogramme)
	{
		$this->_setNumero($id);
        $this->_setIdStat($idStat);
        $this->_setIncident($incident);
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
        $this->_setSuivi($suivi);
        $this->_setDateDecision($dateDecision);
        $this->_setChronogramme($chronogramme);

return $this;
	}
    /*
    * Fonction qui permet de charger les informations conçernant un incident avec son id
    * @param: $id de l'incident en question
    * return : l'objet incident rempli
    */
    public function chargerIncident($id)
    {
        $req="SELECT ID,STATISTIQUE_ID,INCIDENT,TITRE,DEPARTEMENT,STATUT,PRIORITE,AFFECTEDUSER,TO_CHAR(DATEDEBUT,'DD/MM/YYYY HH24:MI'),TO_CHAR(DATEFIN,'DD/MM/YYYY HH24:MI'),DUREE,DESCRIPTION,RISQUEAGGRAVATION,CAUSE,INCIDENTSCONNEXES,PROBLEME,RETABLISSEMENT,RESPONSABILITE,SERVICEACTEUR,LOCALISATION,USERACTION,TO_CHAR(DATEPUBLICATION,'DD/MM/YYYY'),COMMENTAIRE,DEJAAPPARU,PREVISIBLE,SUIVI,TO_CHAR(DATE_DECISION,'DD/MM/YYYY HH24:MI'),CHRONOGRAMME FROM ".SCHEMA.".INCIDENT ";
        $req.="WHERE ID=".$id;
      
       $db= new db();
	   $db->db_connect();
	   $db->db_query($req);
	   $res=$db->db_fetch_array();
	   $this->setIncident($res[0][0],$res[0][1],$res[0][2],$res[0][3],$res[0][4],$res[0][5],$res[0][6],$res[0][7],$res[0][8],$res[0][9],$res[0][10],$res[0][11],$res[0][12],$res[0][13],$res[0][14],$res[0][15],$res[0][16],$res[0][17],$res[0][18],$res[0][19],$res[0][20],$res[0][21],$res[0][22],$res[0][23],$res[0][24],$res[0][25],$res[0][26],$res[0][27]);
        $db->close();
        return $this; 
              
    }



    public function getIdSearch()
    {
        $tSearch= array('Prec'=>'','Next'=>'','Last'=>'');
        $db = new db();
        $db->db_connect();

        //Prec
        if ($this->getNumero()) {
                $rq="SELECT ID FROM ".SCHEMA.".INCIDENT ";
                $rq.="WHERE ID < ".$this->getNumero();
                $rq.=" ORDER BY ID DESC";
                $db->db_query($rq);
            $res = $db->db_fetch_array();
            if (isset($res[0][0])) 
            {
              $tSearch['Prec']=$res[0][0];
            }
        
    //Next
        $rq="SELECT ID FROM ".SCHEMA.".INCIDENT ";
        $rq.="WHERE ID > ".$this->getNumero();
        $rq.=" ORDER BY ID ASC";
        $db->db_query($rq);
        $res = $db->db_fetch_array();
        if (isset($res[0][0])) {
          $tSearch['Next']=$res[0][0];
        }
        }
        
        //Max
        $rq="SELECT MAX(ID) FROM ".SCHEMA.".INCIDENT ";
        $db->db_query($rq);
        $res = $db->db_fetch_array();
        if (isset($res[0][0])) {
          $tSearch['Last']=$res[0][0];
        }
        
        $db->close();
       return $tSearch; 
    }

	public function Modifier()
	{
		$rq="UPDATE ".SCHEMA.".INCIDENT SET ";
		$rq.="TITRE='".oci_escape_string(html_entity_decode($this->getTitre()))."',";
        $rq.="INCIDENT='".oci_escape_string(html_entity_decode($this->getIncident()))."',";
		$rq.="DEPARTEMENT='".oci_escape_string(html_entity_decode($this->getDepartement()))."',";
		$rq.="STATUT='".$this->getStatut()."',";
		$rq.="PRIORITE='".$this->getPriorite()."',";
		$rq.="AFFECTEDUSER='".$this->getUtilisImpacte()."',";
		$rq.="DATEDEBUT=TO_TIMESTAMP('".$this->getDateDebut()."','DD/MM/YYYY HH24:MI'),";
		$rq.="DATEFIN=TO_TIMESTAMP('".$this->getDateFin()."','DD/MM/YYYY HH24:MI'),";
		$rq.="DUREE='".$this->getDuree()."',";
		$rq.="DESCRIPTION='".oci_escape_string(html_entity_decode($this->getDescripIncident()))."',";
		$rq.="RISQUEAGGRAVATION='".$this->getRisqueAggravation()."',";
		$rq.="CAUSE='".oci_escape_string(html_entity_decode($this->getCause()))."',";
		$rq.="INCIDENTSCONNEXES='".oci_escape_string(html_entity_decode($this->getConnexe()))."',";
		$rq.="PROBLEME='".oci_escape_string(html_entity_decode($this->getProbleme()))."',";
		$rq.="RETABLISSEMENT='".oci_escape_string(html_entity_decode($this->getRetablissement()))."',";
		$rq.="RESPONSABILITE='".$this->getResponsabilite()."',";
		$rq.="SERVICEACTEUR='".$this->getActeur()."',";
		$rq.="LOCALISATION='".oci_escape_string(html_entity_decode($this->getLocalisation()))."',";
		$rq.="USERACTION='".oci_escape_string(html_entity_decode($this->getActionUtlisateur()))."',";
		$rq.="DATEPUBLICATION=TO_TIMESTAMP('".$this->getDateCreci()."','DD/MM/YYYY'),";
		$rq.="COMMENTAIRE='".oci_escape_string(html_entity_decode($this->getCommentaire()))."',";
		$rq.="DEJAAPPARU='".$this->getDejaApparu()."',";
		$rq.="PREVISIBLE='".$this->getPrevisible()."',";
        $rq.="SUIVI=".$this->getSuivi().",";
        $rq.="DATE_DECISION=TO_TIMESTAMP('".$this->getDateDecision()."','DD/MM/YYYY HH24:MI'),";
        $rq.="CHRONOGRAMME='".oci_escape_string(html_entity_decode($this->getChronogramme()))."',";
		$rq.="UPDATED=sysdate";

		$rq.=" WHERE ID=".$this->getNumero();

       // debug($rq);
		$base= new db();
		$base->db_connect();
		$base->db_query($rq);
        $base->close();
	}
	public function sauvegarder()
	{
		if ($this->getNumero() == NULL) 
			return $this->CreateIncident();
		else
			return $this->Modifier();			
	}

     public function Supprimer()
    {
        $base= new db();
        $base->db_connect();

        //Suppression de Stat
        if ($this->getIdStat()) {
        $rq="DELETE FROM ".SCHEMA.".STATISTIQUE ";       
        $rq.="WHERE ID=".$this->getIdStat();
        $base->db_query($rq);
        }

        //Suppression d'impact
        $rq="DELETE  FROM ".SCHEMA.".IMPACT ";
        $rq.="WHERE INCIDENT_ID=".$this->getNumero();
        $base->db_query($rq);

        // SUppression de l'incident
        $rq="DELETE FROM ".SCHEMA.".INCIDENT ";
        $rq.="WHERE ID=".$this->getNumero();
        $base->db_query($rq);

        $base->close();
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

    /**
     * Gets the value of _incident.
     *
     * @return mixed
     */
    public function getIncident()
    {
        return $this->_incident;
    }

    /**
     * Sets the value of _incident.
     *
     * @param mixed $_incident the incident
     *
     * @return self
     */
    private function _setIncident($incident)
    {
        $this->_incident = $incident;

        return $this;
    }

    /**
     * Gets the value of _user.
     *
     * @return mixed
     */
    public function getUser()
    {
        return $this->_user;
    }

    /**
     * Sets the value of _user.
     *
     * @param mixed $_user the user
     *
     * @return self
     */
    public function _setUser($user)
    {
        $this->_user = $user;

        return $this;
    }

    /**
     * Gets the value of _estOuvert.
     *
     * @return mixed
     */
    public function getEstOuvert()
    {
        return $this->_estOuvert;
    }

    /**
     * Sets the value of _estOuvert.
     *
     * @param mixed $_estOuvert the est ouvert
     *
     * @return self
     */
    public function _setEstOuvert($estOuvert)
    {
        $this->_estOuvert = $estOuvert;

        return $this;
    }

    /**
     * Gets the value of _idStat.
     *
     * @return mixed
     */
    public function getIdStat()
    {
        return $this->_idStat;
    }

    /**
     * Sets the value of _idStat.
     *
     * @param mixed $_idStat the id stat
     *
     * @return self
     */
    private function _setIdStat($idStat)
    {
        $this->_idStat = $idStat;

        return $this;
    }

    /**
     * Gets the value of _suivi.
     *
     * @return mixed
     */
    public function getSuivi()
    {
        return $this->_suivi;
    }

    /**
     * Sets the value of _suivi.
     *
     * @param mixed $_suivi the suivi
     *
     * @return self
     */
    private function _setSuivi($suivi)
    {
        $this->_suivi = $suivi;

        return $this;
    }

    /**
     * Gets the value of _dateDecision.
     *
     * @return mixed
     */
    public function getDateDecision()
    {
        return $this->_dateDecision;
    }

    /**
     * Sets the value of _dateDecision.
     *
     * @param mixed $_dateDecision the date decision
     *
     * @return self
     */
    private function _setDateDecision($dateDecision)
    {
        $this->_dateDecision = $dateDecision;

        return $this;
    }

    /**
     * Gets the value of _chronogramme.
     *
     * @return mixed
     */
    public function getChronogramme()
    {
        return $this->_chronogramme;
    }

    /**
     * Sets the value of _chronogramme.
     *
     * @param mixed $_chronogramme the chronogramme
     *
     * @return self
     */
    private function _setChronogramme($chronogramme)
    {
        $this->_chronogramme = $chronogramme;

        return $this;
    }
}
?>