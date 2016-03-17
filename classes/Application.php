<?php
class Application
{
	private $_id;
	private $_name;
	private $_enseigne;
	private $_irt;
	private $_trigramme;


	public function SelectAppliById($id)
	{
		$rq="SELECT ID,LIBELLE,ENSEIGNE,IRT,TRIGRAMME FROM ".SCHEMA.".APPLICATION ";
		$rq.="WHERE ID=".$id;

		$db= new db();
		$db->db_connect();
		$db->db_query($rq);
		$res=$db->db_fetch_array();
         if (isset($res[0])) {
		$this->SetAppliParam($res[0][0],$res[0][1],$res[0][2],$res[0][3],$res[0][4]);
    }
	}

	public function SelectAppliByName()
	{
		$rq="SELECT ID,LIBELLE  FROM ".SCHEMA.".APPLICATION ";
		$rq.="WHERE UPPER(REPLACE(LIBELLE,' ','')) LIKE '%".strtoupper(str_replace(' ','',$this->getName()))."%' ORDER BY LIBELLE";

		$db= new db();
		$db->db_connect();
		$db->db_query($rq);
		$res=$db->db_fetch_array();
		return $res;
	}

    public function SelectAppliSearch($name,$enseigne,$irt,$trigramme)
    {
        $tabParam=array();
        if ($name) {
           $tabParam['libelle']=$name;
        }
        if ($enseigne) {
           $tabParam['enseigne']=$enseigne;
        }
        if ($irt) {
           $tabParam['irt']=$irt;
        }
        if ($trigramme) {
           $tabParam['trigramme']=$trigramme;
        }

        $rq="SELECT ID,LIBELLE,ENSEIGNE,IRT,TRIGRAMME  FROM ".SCHEMA.".APPLICATION ";
        $rq.="WHERE ";
        $l=1;
           foreach ($tabParam as $key => $value) {
                $or= ($l != count($tabParam))?" AND":"";          
                $rq.="UPPER(REPLACE($key,' ','')) LIKE '%".strtoupper(str_replace(' ','',$value))."%' ".$or;
                $l++;
            }
        
        $rq.=" ORDER BY NAME";

        $db= new db();
        $db->db_connect();
        $db->db_query($rq);
        $res=$db->db_fetch_array();
        return $res;
    }
	

	public function SetAppliParam($id,$name,$enseigne,$irt,$trigramme)
	{

		$this->_setId($id);
		$this->_setName($name);
		$this->_setEnseigne($enseigne);
		$this->_setIrt($irt);
		$this->_setTrigramme($trigramme);

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
     * Gets the value of _name.
     *
     * @return mixed
     */
    public function getName()
    {
        return $this->_name;
    }

    /**
     * Sets the value of _name.
     *
     * @param mixed $_name the name
     *
     * @return self
     */
    public function _setName($name)
    {
        $this->_name = $name;

        return $this;
    }

    /**
     * Gets the value of _enseigne.
     *
     * @return mixed
     */
    public function getEnseigne()
    {
        return $this->_enseigne;
    }

    /**
     * Sets the value of _enseigne.
     *
     * @param mixed $_enseigne the enseigne
     *
     * @return self
     */
    private function _setEnseigne($enseigne)
    {
        $this->_enseigne = $enseigne;

        return $this;
    }

    /**
     * Gets the value of _irt.
     *
     * @return mixed
     */
    public function getIrt()
    {
        return $this->_irt;
    }

    /**
     * Sets the value of _irt.
     *
     * @param mixed $_irt the irt
     *
     * @return self
     */
    private function _setIrt($irt)
    {
        $this->_irt = $irt;

        return $this;
    }

    /**
     * Gets the value of _trigramme.
     *
     * @return mixed
     */
    public function getTrigramme()
    {
        return $this->_trigramme;
    }

    /**
     * Sets the value of _trigramme.
     *
     * @param mixed $_trigramme the trigramme
     *
     * @return self
     */
    private function _setTrigramme($trigramme)
    {
        $this->_trigramme = $trigramme;

        return $this;
    }
}
?>