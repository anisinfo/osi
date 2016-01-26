<?php
// Severite --> Criticite 
class Impact
{
	private $_id;
	private $_incidentId;
	private $_applicationId;
	private $_complementApplication;
	private $_applicationNature;
	private $_description;
	private $_dateDebut;
	private $_dateFin;
	private $_dureeReelle;
	private $_dureePubliee;
	private $_impact;
	private $_impactMetier;
	private $_sla;
	private $_severite;
	private $_created;
	private $_updated;
	private $_jourHomme;


	public function setParam($id,$incidentId,$applicationId,$dateDebut,$dateFin,$dureeReelle,$jourHomme,$impactMetier,$impact,$sla,$severite,$description)
	{
		$this->_setId($id);
		$this->_setIncidentId($incidentId);
		$this->_setApplicationId($applicationId);
		$this->_setDateDebut($dateDebut);
		$this->_setDateFin($dateFin);
		$this->_setDureeReelle($dureeReelle);
		$this->_setJourHomme($jourHomme);
		$this->_setImpactMetier($impactMetier);
		$this->_setImpact($impact);
		$this->_setSla($sla);
		$this->_setSeverite($severite);
		$this->_setDescription($description);
	return $this;
	}

	public function creer()
	{
		$rq="INSERT INTO ".SCHEMA.".IMPACT (INCIDENT_ID,APPLICATION_ID,DATESTART,DATEEND,DUREEREELLE,JOURHOMME,IMPACTMETIER,IMPACT,SLA,SEVERITE,DESCRIPTION,CREATED,UPDATED)";
		$rq.=" VALUES (".$this->getIncidentId().",".$this->getApplicationId().",TO_TIMESTAMP('".$this->getDateDebut()."','DD/MM/YYYY HH24:MI'),TO_TIMESTAMP('".$this->getDateFin()."','DD/MM/YYYY HH24:MI'),'".htmlentities($this->getDureeReelle(),ENT_QUOTES | ENT_IGNORE, "UTF-8")."','".htmlentities($this->getJourHomme(),ENT_QUOTES | ENT_IGNORE, "UTF-8")."','".$this->getImpactMetier()."','".$this->getImpact()."','".$this->getSla()."','".$this->getSeverite()."','".htmlentities($this->getDescription(),ENT_QUOTES | ENT_IGNORE, "UTF-8")."',sysdate,sysdate)";
	   echo $rq;
		$db = new db();
		$db->db_connect();
		$db->db_query($rq);
        $db->close();
	}


	public function modifier()
	{
		$rq="UPDATE ".SCHEMA.".IMPACT SET ";
		$rq.="APPLICATION_ID='".$this->getApplicationId()."',";
		$rq.="DATESTART=TO_TIMESTAMP('".$this->getDateDebut()."','DD/MM/YYYY HH24:MI'),";
		$rq.="DATEEND=TO_TIMESTAMP('".$this->getDateFin()."','DD/MM/YYYY HH24:MI'),";
		$rq.="DUREEREELLE='".htmlentities($this->getDureeReelle(),ENT_QUOTES | ENT_IGNORE, "UTF-8")."',";
		$rq.="JOURHOMME='".htmlentities($this->getJourHomme(),ENT_QUOTES | ENT_IGNORE, "UTF-8")."',";
		$rq.="IMPACTMETIER='".$this->getImpactMetier()."',";
		$rq.="IMPACT='".$this->getImpact()."',";
		$rq.="SLA='".$this->getSla()."',";
		$rq.="SEVERITE='".$this->getSeverite()."',";
		$rq.="DESCRIPTION='".htmlentities($this->getDescription(),ENT_QUOTES | ENT_IGNORE, "UTF-8")."',";
		$rq.="UPDATED=sysdate";

		$rq.=" WHERE ID=".$this->getId();
		$db = new db();
		$db->db_connect();
		$db->db_query($rq);
         $db->close();

	}

	public function supprimer($id)
	{
		$rq="DELETE  FROM ".SCHEMA.".IMPACT  ";
		$rq.="WHERE ID=".$id;

		$db = new db();
		$db->db_connect();
		$db->db_query($rq);
        $db->close();
	}
        public function supprimerTout()
    {
        $rq="DELETE  FROM ".SCHEMA.".IMPACT  ";
        $rq.="WHERE INCIDENT_ID=".$this->getIncidentId();

        $db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $db->close();
    }

	  public function chargerFirstIncident($id)
    {
        $req="SELECT ID,INCIDENT_ID,APPLICATION_ID,TO_CHAR(DATESTART,'DD/MM/YYYY HH24:MI'),TO_CHAR(DATEEND,'DD/MM/YYYY HH24:MI'),DUREEREELLE,JOURHOMME,IMPACTMETIER,IMPACT,SLA,SEVERITE,DESCRIPTION,CREATED,UPDATED ";
        $req.="FROM ".SCHEMA.".IMPACT WHERE INCIDENT_ID=".$id." ";
        $req.="ORDER BY ID ASC";

        $base= new db();
        $base->db_connect();
        $base->db_query($req);
        $res=$base->db_fetch_array();
        $base->close();
        $this->setParam($res[0][0],$res[0][1],$res[0][2],$res[0][3],$res[0][4],$res[0][5],$res[0][6],$res[0][7],$res[0][8],$res[0][9],$res[0][10],$res[0][11],$res[0][12],$res[0][13]);
        
        return $this;           
    }


      public function chargerIncident($id)
    {
        $req="SELECT ID,INCIDENT_ID,APPLICATION_ID,TO_CHAR(DATESTART,'DD/MM/YYYY HH24:MI'),TO_CHAR(DATEEND,'DD/MM/YYYY HH24:MI'),DUREEREELLE,JOURHOMME,IMPACTMETIER,IMPACT,SLA,SEVERITE,DESCRIPTION ";
        $req.="FROM ".SCHEMA.".IMPACT WHERE INCIDENT_ID=".$id." ";
        $req.="ORDER BY ID ASC";

        $base= new db();
        $base->db_connect();
        $base->db_query($req);
        $res=$base->db_fetch_array();
        $base->close();
        return $res;           
    }


      public function chargerImpact($id)
    {
        $req="SELECT ID,INCIDENT_ID,APPLICATION_ID,TO_CHAR(DATESTART,'DD/MM/YYYY HH24:MI'),TO_CHAR(DATEEND,'DD/MM/YYYY HH24:MI'),DUREEREELLE,JOURHOMME,IMPACTMETIER,IMPACT,SLA,SEVERITE,DESCRIPTION,CREATED,UPDATED ";
        $req.="FROM ".SCHEMA.".IMPACT WHERE ID=".$id." ";
        $req.="ORDER BY ID ASC";

        $base= new db();
        $base->db_connect();
        $base->db_query($req);
        $res=$base->db_fetch_array();
        $base->close();
        $this->setParam($res[0][0],$res[0][1],$res[0][2],$res[0][3],$res[0][4],$res[0][5],$res[0][6],$res[0][7],$res[0][8],$res[0][9],$res[0][10],$res[0][11],$res[0][12],$res[0][13]);
        return $this;           
    }


    /**
     * Gets the value of _id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->_id;
    }

    /**
     * Sets the value of _id.
     *
     * @param mixed $_id the id
     *
     * @return self
     */
    private function _setId($id)
    {
        $this->_id = $id;

        return $this;
    }

    /**
     * Gets the value of _incidentId.
     *
     * @return mixed
     */
    public function getIncidentId()
    {
        return $this->_incidentId;
    }

    /**
     * Sets the value of _incidentId.
     *
     * @param mixed $_incidentId the incident id
     *
     * @return self
     */
    public function _setIncidentId($incidentId)
    {
        $this->_incidentId = $incidentId;

        return $this;
    }

    /**
     * Gets the value of _applicationId.
     *
     * @return mixed
     */
    public function getApplicationId()
    {
        return $this->_applicationId;
    }

    /**
     * Sets the value of _applicationId.
     *
     * @param mixed $_applicationId the application id
     *
     * @return self
     */
    private function _setApplicationId($applicationId)
    {
        $this->_applicationId = $applicationId;

        return $this;
    }

    /**
     * Gets the value of _complementApplication.
     *
     * @return mixed
     */
    public function getComplementApplication()
    {
        return $this->_complementApplication;
    }

    /**
     * Sets the value of _complementApplication.
     *
     * @param mixed $_complementApplication the complement application
     *
     * @return self
     */
    private function _setComplementApplication($complementApplication)
    {
        $this->_complementApplication = $complementApplication;

        return $this;
    }

    /**
     * Gets the value of _applicationNature.
     *
     * @return mixed
     */
    public function getApplicationNature()
    {
        return $this->_applicationNature;
    }

    /**
     * Sets the value of _applicationNature.
     *
     * @param mixed $_applicationNature the application nature
     *
     * @return self
     */
    private function _setApplicationNature($applicationNature)
    {
        $this->_applicationNature = $applicationNature;

        return $this;
    }

    /**
     * Gets the value of _description.
     *
     * @return mixed
     */
    public function getDescription()
    {
        return $this->_description;
    }

    /**
     * Sets the value of _description.
     *
     * @param mixed $_description the description
     *
     * @return self
     */
    private function _setDescription($description)
    {
        $this->_description = $description;

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
     * Gets the value of _dureeReelle.
     *
     * @return mixed
     */
    public function getDureeReelle()
    {
        return $this->_dureeReelle;
    }

    /**
     * Sets the value of _dureeReelle.
     *
     * @param mixed $_dureeReelle the duree reelle
     *
     * @return self
     */
    private function _setDureeReelle($dureeReelle)
    {
        $this->_dureeReelle = $dureeReelle;

        return $this;
    }

    /**
     * Gets the value of _dureePubliee.
     *
     * @return mixed
     */
    public function getDureePubliee()
    {
        return $this->_dureePubliee;
    }

    /**
     * Sets the value of _dureePubliee.
     *
     * @param mixed $_dureePubliee the duree publiee
     *
     * @return self
     */
    private function _setDureePubliee($dureePubliee)
    {
        $this->_dureePubliee = $dureePubliee;

        return $this;
    }

    /**
     * Gets the value of _impact.
     *
     * @return mixed
     */
    public function getImpact()
    {
        return $this->_impact;
    }

    /**
     * Sets the value of _impact.
     *
     * @param mixed $_impact the impact
     *
     * @return self
     */
    private function _setImpact($impact)
    {
        $this->_impact = $impact;

        return $this;
    }

    /**
     * Gets the value of _impactMetier.
     *
     * @return mixed
     */
    public function getImpactMetier()
    {
        return $this->_impactMetier;
    }

    /**
     * Sets the value of _impactMetier.
     *
     * @param mixed $_impactMetier the impact metier
     *
     * @return self
     */
    private function _setImpactMetier($impactMetier)
    {
        $this->_impactMetier = $impactMetier;

        return $this;
    }

    /**
     * Gets the value of _sla.
     *
     * @return mixed
     */
    public function getSla()
    {
        return $this->_sla;
    }

    /**
     * Sets the value of _sla.
     *
     * @param mixed $_sla the sla
     *
     * @return self
     */
    private function _setSla($sla)
    {
        $this->_sla = $sla;

        return $this;
    }

    /**
     * Gets the value of _severite.
     *
     * @return mixed
     */
    public function getSeverite()
    {
        return $this->_severite;
    }

    /**
     * Sets the value of _severite.
     *
     * @param mixed $_severite the severite
     *
     * @return self
     */
    private function _setSeverite($severite)
    {
        $this->_severite = $severite;

        return $this;
    }

    /**
     * Gets the value of _created.
     *
     * @return mixed
     */
    public function getCreated()
    {
        return $this->_created;
    }

    /**
     * Sets the value of _created.
     *
     * @param mixed $_created the created
     *
     * @return self
     */
    private function _setCreated($created)
    {
        $this->_created = $created;

        return $this;
    }

    /**
     * Gets the value of _updated.
     *
     * @return mixed
     */
    public function getUpdated()
    {
        return $this->_updated;
    }

    /**
     * Sets the value of _updated.
     *
     * @param mixed $_updated the updated
     *
     * @return self
     */
    private function _setUpdated($updated)
    {
        $this->_updated = $updated;

        return $this;
    }

    /**
     * Gets the value of _jourHomme.
     *
     * @return mixed
     */
    public function getJourHomme()
    {
        return $this->_jourHomme;
    }

    /**
     * Sets the value of _jourHomme.
     *
     * @param mixed $_jourHomme the jour homme
     *
     * @return self
     */
    private function _setJourHomme($jourHomme)
    {
        $this->_jourHomme = $jourHomme;

        return $this;
    }
}
?>