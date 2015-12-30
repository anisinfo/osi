<?php
class Chronogramme
{
	private $_id;
	private $_incidentId;
	private $_actionDate;
	private $_description;
	private $_dateCrea;
	private $_dateModif;

	public function setParam($id,$incidentId,$actionDate,$description)
	{
		$this->_setId($id);
		$this->_setIncidentId($incidentId);
		$this->_setActionDate($actionDate);
		$this->_setDescription($description);

	}
	public function getChronogrammeByIncidentId($id)
	{
		$rq="SELECT ID,INCIDENT_ID,ACTIONDATE,DESCRIPTION ";
		$rq.="FROM ".SCHEMA.".CHRONOGRAMME ";
		$rq.="WHERE INCIDENT_ID=".$id;

		$db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $res=$db->db_fetch_array();
        $db->close();
        $tab = array();
        foreach ($res as $value) {
            $obj= new Chronogramme();
        	$obj->setParam($value[0],$value[1],$value[2],$value[3]);
        	array_push($tab, $obj);
        }
       return $tab;
	}


	public function getChronogrammeBytId($id)
	{
		$rq="SELECT ID,INCIDENT_ID,ACTIONDATE,DESCRIPTION ";
		$rq.="FROM ".SCHEMA.".CHRONOGRAMME ";
		$rq.="WHERE ID=".$id;

		$db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $res=$db->db_fetch_array();
        $db->close();
        return $this->setParam($value[0],$value[1],$value[2],$value[3]);   
	}


	public function Creer()
	{
		$rq="INSERT INTO ".SCHEMA.".CHRONOGRAMME (INCIDENT_ID,ACTIONDATE,DESCRIPTION,CREATED,UPDATED) VALUES ";
		$rq.="(".$this->getIncidentId().",TO_TIMESTAMP('2015-12-22 ".$this->getActionDate()."','YYYY-MM-DD HH24:MI'),'".$this->getDescription()."',sysdate,sysdate)";
        $req="SELECT max(ID) FROM ".SCHEMA.".CHRONOGRAMME";
		$db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $db->db_query($req);
        $res=$db->db_fetch_array();
        $db->close();
        return $res;
       
	}


	public function Modifier($id)
	{
		$rq="UPDATE ".SCHEMA.".CHRONOGRAMME SET ";
		$rq.="ACTIONDATE=TO_TIMESTAMP('2015-12-22 ".$this->getActionDate()."','YYYY-MM-DD HH24:MI'),";
		$rq.="DESCRIPTION='".$this->getDescription()."',";
		$rq.="UPDATED=sysdate ";
		$rq.="WHERE ID=".$id;

		$db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $db->close();
	}


	public function Supprimer($id)
	{
		$rq="DELETE FROM ".SCHEMA.".CHRONOGRAMME    ";
		$rq.="WHERE ID=".$id;

		$db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $db->close();
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
    private function _setIncidentId($incidentId)
    {
        $this->_incidentId = $incidentId;

        return $this;
    }

    /**
     * Gets the value of _actionDate.
     *
     * @return mixed
     */
    public function getActionDate()
    {
        return $this->_actionDate;
    }

    /**
     * Sets the value of _actionDate.
     *
     * @param mixed $_actionDate the action date
     *
     * @return self
     */
    private function _setActionDate($actionDate)
    {
        $this->_actionDate = $actionDate;

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
     * Gets the value of _dateCrea.
     *
     * @return mixed
     */
    public function getDateCrea()
    {
        return $this->_dateCrea;
    }

    /**
     * Sets the value of _dateCrea.
     *
     * @param mixed $_dateCrea the date crea
     *
     * @return self
     */
    private function _setDateCrea($dateCrea)
    {
        $this->_dateCrea = $dateCrea;

        return $this;
    }

    /**
     * Gets the value of _dateModif.
     *
     * @return mixed
     */
    public function getDateModif()
    {
        return $this->_dateModif;
    }

    /**
     * Sets the value of _dateModif.
     *
     * @param mixed $_dateModif the date modif
     *
     * @return self
     */
    private function _setDateModif($dateModif)
    {
        $this->_dateModif = $dateModif;

        return $this;
    }
}
?>