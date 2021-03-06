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
     public function __construct()
     {
        $this->_setId('');
        $this->_setIdApplication('');
        $this->_setLundiOuvert('');
        $this->_setLundiFermer('');
        $this->_setMardiOuvert('');
        $this->_setMardiFermer('');
        $this->_setMercrediOuvert('');
        $this->_setMercrediFermer('');
        $this->_setJeudiOuvert('');
        $this->_setJeudiFermer('');
        $this->_setVendrediOuvert('');
        $this->_setVendrediFermer('');
        $this->_setSamediOuvert('');
        $this->_setSamediFermer('');
        $this->_setDimancheOuvert('');
        $this->_setDimancheFermer('');
        $this->_setJourFerierOuvert('');
        $this->_setJourFerierFermer('');

     }

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
        $rq="SELECT ID,APPLICATION_ID,TO_CHAR(LUNDIOUVERTURE,'HH24:MI'),TO_CHAR(LUNDIFERMETURE,'HH24:MI'),TO_CHAR(MARDIOUVERTURE,'HH24:MI'),TO_CHAR(MARDIFERMETURE,'HH24:MI'),TO_CHAR(MERCREDIOUVERTURE,'HH24:MI'),TO_CHAR(MERCREDIFERMETURE,'HH24:MI'),TO_CHAR(JEUDIOUVERTURE,'HH24:MI'),TO_CHAR(JEUDIFERMETURE,'HH24:MI'),TO_CHAR(VENDREDIOUVERTURE,'HH24:MI'),TO_CHAR(VENDREDIFERMETURE,'HH24:MI'),TO_CHAR(SAMEDIOUVERTURE,'HH24:MI'),TO_CHAR(SAMEDIFERMETURE,'HH24:MI'),TO_CHAR(DIMANCHEOUVERTURE,'HH24:MI'),TO_CHAR(DIMANCHEFERMETURE,'HH24:MI'),TO_CHAR(FERIESOUVERTURE,'HH24:MI'),TO_CHAR(FERIESFERMETURE,'HH24:MI')";
        $rq.=" FROM ".SCHEMA.".CALENDRIER";
        $rq.=" WHERE  APPLICATION_ID=".$id;
   
        $db= new db();
        $db->db_connect();
        $db->db_query($rq);
        $res=$db->db_fetch_array();
        if (isset($res[0])) {
        $valeur=$res[0];
        $this->setParam($valeur[0],$valeur[1],$valeur[2],$valeur[3],$valeur[4],$valeur[5],$valeur[6],$valeur[7],$valeur[8],$valeur[9],$valeur[10],$valeur[11],$valeur[12],$valeur[13],$valeur[14],$valeur[15],$valeur[16],$valeur[17]);  
        }else $this->__construct();
       
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
        $rq.="TO_DATE('".$this->getLundiOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getLundiFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getMardiOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getMardiFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getMercrediOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getMercrediFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getJeudiOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getJeudiFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getVendrediOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getVendrediFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getSamediOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getSamediFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getDimancheOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getDimancheFermer().":59','HH24:MI:SS'),";
        $rq.="TO_DATE('".$this->getJourFerierOuvert()."','HH24:MI'),";
        $rq.="TO_DATE('".$this->getJourFerierFermer().":59','HH24:MI:SS'))";
        
        $req="SELECT ID FROM ".SCHEMA.".CALENDRIER ";
        $req.="WHERE APPLICATION_ID=".$this->getIdApplication();
      
        $db = new db();
        $db->db_connect();
        $db->db_query($req);
        $res=$db->db_fetch_array();
        if (isset($res[0])) {        
            $this->modifier($res[0][0]);
        }else{
        $db->db_query($rq);   
        }
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
        $rq.="LUNDIOUVERTURE=TO_DATE('".$this->getLundiOuvert()."','HH24:MI'),";
        $rq.="LUNDIFERMETURE=TO_DATE('".$this->getLundiFermer().":59','HH24:MI:SS'),";
        $rq.="MARDIOUVERTURE=TO_DATE('".$this->getMardiOuvert()."','HH24:MI'),";
        $rq.="MARDIFERMETURE=TO_DATE('".$this->getMardiFermer().":59','HH24:MI:SS'),";
        $rq.="MERCREDIOUVERTURE=TO_DATE('".$this->getMercrediOuvert()."','HH24:MI'),";
        $rq.="MERCREDIFERMETURE=TO_DATE('".$this->getMercrediFermer().":59','HH24:MI:SS'),";
        $rq.="JEUDIOUVERTURE=TO_DATE('".$this->getJeudiOuvert()."','HH24:MI'),";
        $rq.="JEUDIFERMETURE=TO_DATE('".$this->getJeudiFermer().":59','HH24:MI:SS'),";
        $rq.="VENDREDIOUVERTURE=TO_DATE('".$this->getVendrediOuvert()."','HH24:MI'),";
        $rq.="VENDREDIFERMETURE=TO_DATE('".$this->getVendrediFermer().":59','HH24:MI:SS'),";
        $rq.="SAMEDIOUVERTURE=TO_DATE('".$this->getSamediOuvert()."','HH24:MI'),";
        $rq.="SAMEDIFERMETURE=TO_DATE('".$this->getSamediFermer().":59','HH24:MI:SS'),";
        $rq.="DIMANCHEOUVERTURE=TO_DATE('".$this->getDimancheOuvert()."','HH24:MI'),";
        $rq.="DIMANCHEFERMETURE=TO_DATE('".$this->getDimancheFermer().":59','HH24:MI:SS'),";
        $rq.="FERIESOUVERTURE=TO_DATE('".$this->getJourFerierOuvert()."','HH24:MI'),";
        $rq.="FERIESFERMETURE=TO_DATE('".$this->getJourFerierFermer().":59','HH24:MI:SS')";

        $rq.=" WHERE APPLICATION_ID=".$this->getIdApplication();

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