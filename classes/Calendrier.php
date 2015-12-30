<?php
class Calendrier
{
	private $_id;
	private $_idApplication;
	private $_LundiOuvert;
	private $_LundiFermer;
	private $_MardiOuvert;
	private $_MardiFermer;
	private $_MercrediOuvert;
	private $_MercrediFermer;
	private $_JeudiOuvert;
	private $_JeudiFermer;
	private $_VendrediOuvert;
	private $_VendrediFermer;
	private $_SamediOuvert;
	private $_SamediFermer;
	private $_DimancheOuvert;
	private $_DimancheFermer;
	private $_JourFerierOuvert;
	private $_JourFerierFermer;
	private $_CalendrierCat;

	


     /**
     * Set Parametre de lobjet Calendrier.
     *
     * @return $this
     */

	public function setParam($id,$idApplication,$LundiOuvert,$LundiFermer,$MardiOuvert,$MardiFermer,$MercrediOuvert,$MercrediFermer,$JeudiOuvert,$JeudiFermer,$VendrediOuvert,$VendrediFermer,$SamediOuvert,$SamediFermer,$DimancheOuvert,$DimancheFermer,$JourFerierOuvert,$JourFerierFermer)
	{
		$this->_setId($id);
		$this->_setIdApplication($idApplication);
		$this->_setLundiOuvert($LundiOuvert);
		$this->_setLundiFermer($LundiFermer);
		$this->_setMardiOuvert($MardiOuvert);
		$this->_setMardiFermer($MardiFermer);
		$this->_setMercrediOuvert($MercrediOuvert);
		$this->_setMercrediFermer($MercrediFermer);
		$this->_setJeudiOuvert($JeudiOuvert);
		$this->_setJeudiFermer($JeudiFermer);
		$this->_setVendrediOuvert($VendrediOuvert);
		$this->_setVendrediFermer($VendrediFermer);
		$this->_setSamediOuvert($SamediOuvert);
		$this->_setSamediFermer($SamediFermer);
		$this->_setDimancheOuvert($SamediOuvert);
		$this->_setDimancheFermer($SamediFermer);
		$this->_setJourFerierOuvert($JourFerierOuvert);
		$this->_setJourFerierFermer($JourFerierFermer);

		return $this;
	}

     /**
     * Selectionner un objet avec son $id.
     *
     * @return mixed
     */
     public function selectById($id)
     {
        $rq="SELECT ID,APPLICATION_ID,LUNDIOUVERTURE,LUNDIFERMETURE,MARDIOUVERTURE,MARDIFERMETURE,MERCREDIOUVERTURE,MERCREDIFERMETURE,JEUDIOUVERTURE,JEUDIFERMETURE,VENDREDIOUVERTURE,VENDREDIFERMETURE,SAMEDIOUVERTURE,SAMEDIFERMETURE,DIMANCHEOUVERTURE,DIMANCHEFERMETURE,FERIESOUVERTURE,FERIESFERMETURE";
        $rq.=" FROM ".SCHEMA.".CALENDRIER";
        $rq.=" WHERE  APPLICATION_ID=".$id;

        $db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $res=$db->db_fetch_array();
      //  debug($res);
        $db->close();
        $tab = array();
        $valeur=$res[0];
        $this->setParam($valeur[0],$valeur[1],$valeur[2],$valeur[3],$valeur[4],$valeur[5],$valeur[6],$valeur[7],$valeur[8],$valeur[9],$valeur[10],$valeur[11],$valeur[12],$valeur[13],$valeur[14],$valeur[15],$valeur[16],$valeur[17]);  
        return $this;
     }

      /**
     *  Création d'un objet
     *
     * @return mixed
     */
     public function creer()
     {
        $rq="INSERT INTO ".SCHEMA.".CALENDRIER ";
        $rq.="(APPLICATION_ID,LUNDIOUVERTURE,LUNDIFERMETURE,MARDIOUVERTURE,MARDIFERMETURE,MERCREDIOUVERTURE,MERCREDIFERMETURE,JEUDIOUVERTURE,JEUDIFERMETURE,VENDREDIOUVERTURE,VENDREDIFERMETURE,SAMEDIOUVERTURE,SAMEDIFERMETURE,DIMANCHEOUVERTURE,DIMANCHEFERMETURE,FERIESOUVERTURE,FERIESFERMETURE) VALUES (";
        $rq.=$this->getIdApplication().",";
        $rq.="TO_DATE('2015-12-22 ".$this->getLundiOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getLundiFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getMardiOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getMardiFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getMercrediOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getMercrediFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getJeudiOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getJeudiFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getVendrediOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getVendrediFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getSamediOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getSamediFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getDimancheOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getDimancheFermer()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getJourFerierOuvert()."', 'YYYY-MM-DD HH24:MI'),";
        $rq.="TO_DATE('2015-12-22 ".$this->getJourFerierFermer()."', 'YYYY-MM-DD HH24:MI'))";

        $db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $db->close();
     }


    /**
     *  Modifier d'un objet
     *
     * @return mixed
     */
     public function modifier($id)
     {
        $rq="UPDATE ".SCHEMA.".CALENDRIER ";
        $rq.="SET ";
        $rq.="APPLICATION_ID=".$this->getIdApplication().",";
        $rq.="LUNDIOUVERTURE='".$this->getLundiOuvert()."',";
        $rq.="LUNDIFERMETURE='".$this->getLundiFermer()."',";
        $rq.="MARDIOUVERTURE='".$this->getMardiOuvert()."',";
        $rq.="MARDIFERMETURE='".$this->getMardiFermer()."',";
        $rq.="MERCREDIOUVERTURE='".$this->getMercrediOuvert()."',";
        $rq.="MERCREDIFERMETURE='".$this->getMercrediFermer()."',";
        $rq.="JEUDIOUVERTURE='".$this->getJeudiOuvert()."',";
        $rq.="JEUDIFERMETURE='".$this->getJeudiFermer()."',";
        $rq.="VENDREDIOUVERTURE='".$this->getVendrediOuvert()."',";
        $rq.="VENDREDIFERMETURE='".$this->getVendrediFermer()."',";
        $rq.="SAMEDIOUVERTURE='".$this->getSamediOuvert()."',";
        $rq.="SAMEDIFERMETURE='".$this->getSamediFermer()."',";
        $rq.="DIMANCHEOUVERTURE='".$this->getDimancheOuvert()."',";
        $rq.="DIMANCHEFERMETURE='".$this->getDimancheFermer()."',";
        $rq.="FERIESOUVERTURE='".$this->getJourFerierOuvert()."',";
        $rq.="FERIESFERMETURE='".$this->getJourFerierFermer()."'";

        $rq.=" WHERE APPLICATION_ID=".$id;

        $db = new db();
        $db->db_connect();
        $db->db_query($rq);
        $db->close();
     }


       /**
     *  Modification d'un objet
     *
     * @return mixed
     */
     public function Supprimer($id)
     {
        $rq="DELETE FROM ".SCHEMA.".CALENDRIER";
        $rq.=" WHERE ID=".$id;

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
     * Gets the value of _idApplication.
     *
     * @return mixed
     */
    public function getIdApplication()
    {
        return $this->_idApplication;
    }

    /**
     * Sets the value of _idApplication.
     *
     * @param mixed $_idApplication the id application
     *
     * @return self
     */
    private function _setIdApplication($idApplication)
    {
        $this->_idApplication = $idApplication;

        return $this;
    }

    /**
     * Gets the value of _LundiOuvert.
     *
     * @return mixed
     */
    public function getLundiOuvert()
    {
        return $this->_LundiOuvert;
    }

    /**
     * Sets the value of _LundiOuvert.
     *
     * @param mixed $_LundiOuvert the lundi ouvert
     *
     * @return self
     */
    private function _setLundiOuvert($LundiOuvert)
    {
        $this->_LundiOuvert = $LundiOuvert;

        return $this;
    }

    /**
     * Gets the value of _LundiFermer.
     *
     * @return mixed
     */
    public function getLundiFermer()
    {
        return $this->_LundiFermer;
    }

    /**
     * Sets the value of _LundiFermer.
     *
     * @param mixed $_LundiFermer the lundi fermer
     *
     * @return self
     */
    private function _setLundiFermer($LundiFermer)
    {
        $this->_LundiFermer = $LundiFermer;

        return $this;
    }

    /**
     * Gets the value of _MardiOuvert.
     *
     * @return mixed
     */
    public function getMardiOuvert()
    {
        return $this->_MardiOuvert;
    }

    /**
     * Sets the value of _MardiOuvert.
     *
     * @param mixed $_MardiOuvert the mardi ouvert
     *
     * @return self
     */
    private function _setMardiOuvert($MardiOuvert)
    {
        $this->_MardiOuvert = $MardiOuvert;

        return $this;
    }

    /**
     * Gets the value of _MardiFermer.
     *
     * @return mixed
     */
    public function getMardiFermer()
    {
        return $this->_MardiFermer;
    }

    /**
     * Sets the value of _MardiFermer.
     *
     * @param mixed $_MardiFermer the mardi fermer
     *
     * @return self
     */
    private function _setMardiFermer($MardiFermer)
    {
        $this->_MardiFermer = $MardiFermer;

        return $this;
    }

    /**
     * Gets the value of _MercrediOuvert.
     *
     * @return mixed
     */
    public function getMercrediOuvert()
    {
        return $this->_MercrediOuvert;
    }

    /**
     * Sets the value of _MercrediOuvert.
     *
     * @param mixed $_MercrediOuvert the mercredi ouvert
     *
     * @return self
     */
    private function _setMercrediOuvert($MercrediOuvert)
    {
        $this->_MercrediOuvert = $MercrediOuvert;

        return $this;
    }

    /**
     * Gets the value of _MercrediFermer.
     *
     * @return mixed
     */
    public function getMercrediFermer()
    {
        return $this->_MercrediFermer;
    }

    /**
     * Sets the value of _MercrediFermer.
     *
     * @param mixed $_MercrediFermer the mercredi fermer
     *
     * @return self
     */
    private function _setMercrediFermer($MercrediFermer)
    {
        $this->_MercrediFermer = $MercrediFermer;

        return $this;
    }

    /**
     * Gets the value of _JeudiOuvert.
     *
     * @return mixed
     */
    public function getJeudiOuvert()
    {
        return $this->_JeudiOuvert;
    }

    /**
     * Sets the value of _JeudiOuvert.
     *
     * @param mixed $_JeudiOuvert the jeudi ouvert
     *
     * @return self
     */
    private function _setJeudiOuvert($JeudiOuvert)
    {
        $this->_JeudiOuvert = $JeudiOuvert;

        return $this;
    }

    /**
     * Gets the value of _JeudiFermer.
     *
     * @return mixed
     */
    public function getJeudiFermer()
    {
        return $this->_JeudiFermer;
    }

    /**
     * Sets the value of _JeudiFermer.
     *
     * @param mixed $_JeudiFermer the jeudi fermer
     *
     * @return self
     */
    private function _setJeudiFermer($JeudiFermer)
    {
        $this->_JeudiFermer = $JeudiFermer;

        return $this;
    }

    /**
     * Gets the value of _VendrediOuvert.
     *
     * @return mixed
     */
    public function getVendrediOuvert()
    {
        return $this->_VendrediOuvert;
    }

    /**
     * Sets the value of _VendrediOuvert.
     *
     * @param mixed $_VendrediOuvert the vendredi ouvert
     *
     * @return self
     */
    private function _setVendrediOuvert($VendrediOuvert)
    {
        $this->_VendrediOuvert = $VendrediOuvert;

        return $this;
    }

    /**
     * Gets the value of _VendrediFermer.
     *
     * @return mixed
     */
    public function getVendrediFermer()
    {
        return $this->_VendrediFermer;
    }

    /**
     * Sets the value of _VendrediFermer.
     *
     * @param mixed $_VendrediFermer the vendredi fermer
     *
     * @return self
     */
    private function _setVendrediFermer($VendrediFermer)
    {
        $this->_VendrediFermer = $VendrediFermer;

        return $this;
    }

    /**
     * Gets the value of _SamediOuvert.
     *
     * @return mixed
     */
    public function getSamediOuvert()
    {
        return $this->_SamediOuvert;
    }

    /**
     * Sets the value of _SamediOuvert.
     *
     * @param mixed $_SamediOuvert the samedi ouvert
     *
     * @return self
     */
    private function _setSamediOuvert($SamediOuvert)
    {
        $this->_SamediOuvert = $SamediOuvert;

        return $this;
    }

    /**
     * Gets the value of _SamediFermer.
     *
     * @return mixed
     */
    public function getSamediFermer()
    {
        return $this->_SamediFermer;
    }

    /**
     * Sets the value of _SamediFermer.
     *
     * @param mixed $_SamediFermer the samedi fermer
     *
     * @return self
     */
    private function _setSamediFermer($SamediFermer)
    {
        $this->_SamediFermer = $SamediFermer;

        return $this;
    }

    /**
     * Gets the value of _DimancheOuvert.
     *
     * @return mixed
     */
    public function getDimancheOuvert()
    {
        return $this->_DimancheOuvert;
    }

    /**
     * Sets the value of _DimancheOuvert.
     *
     * @param mixed $_DimancheOuvert the dimanche ouvert
     *
     * @return self
     */
    private function _setDimancheOuvert($DimancheOuvert)
    {
        $this->_DimancheOuvert = $DimancheOuvert;

        return $this;
    }

    /**
     * Gets the value of _DimancheFermer.
     *
     * @return mixed
     */
    public function getDimancheFermer()
    {
        return $this->_DimancheFermer;
    }

    /**
     * Sets the value of _DimancheFermer.
     *
     * @param mixed $_DimancheFermer the dimanche fermer
     *
     * @return self
     */
    private function _setDimancheFermer($DimancheFermer)
    {
        $this->_DimancheFermer = $DimancheFermer;

        return $this;
    }

    /**
     * Gets the value of _JourFerierOuvert.
     *
     * @return mixed
     */
    public function getJourFerierOuvert()
    {
        return $this->_JourFerierOuvert;
    }

    /**
     * Sets the value of _JourFerierOuvert.
     *
     * @param mixed $_JourFerierOuvert the jour ferier ouvert
     *
     * @return self
     */
    private function _setJourFerierOuvert($JourFerierOuvert)
    {
        $this->_JourFerierOuvert = $JourFerierOuvert;

        return $this;
    }

    /**
     * Gets the value of _JourFerierFermer.
     *
     * @return mixed
     */
    public function getJourFerierFermer()
    {
        return $this->_JourFerierFermer;
    }

    /**
     * Sets the value of _JourFerierFermer.
     *
     * @param mixed $_JourFerierFermer the jour ferier fermer
     *
     * @return self
     */
    private function _setJourFerierFermer($JourFerierFermer)
    {
        $this->_JourFerierFermer = $JourFerierFermer;

        return $this;
    }

    /**
     * Gets the value of _CalendrierCat.
     *
     * @return mixed
     */
    public function getCalendrierCat()
    {
        return $this->_CalendrierCat;
    }

    /**
     * Sets the value of _CalendrierCat.
     *
     * @param mixed $_CalendrierCat the calendrier cat
     *
     * @return self
     */
    private function _setCalendrierCat($CalendrierCat)
    {
        $this->_CalendrierCat = $CalendrierCat;

        return $this;
    }
}
?>