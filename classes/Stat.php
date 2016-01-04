<?php
class Stat
{
 private $_Id;
 private $_RefChangement;
 private $_DatePublicationIr;
 private $_DatePublicationPm;
 private $_TypeCause;
 private $_TypeCauseSecondaire;
 private $_TypologieGts;
 private $_KindOfImpact;
 private $_EquipeResponsable;
 private $_FournisseurResponsable;
 private $_PowerProd;
 private $_Legacy;
 private $_Composant;
 private $_ComposantComplement;
 private $_ZoneGeographique;
 private $_IdIncident;

	

 	/**
     * Set Params de l'objet
     *
     * @return $this
     */
	public function SetParam($Id,$IdIncident,$RefChangement,$DatePublicationIr,$DatePublicationPm,$TypeCause,$TypeCauseSecondaire,$TypologieGts,$KindOfImpact,$EquipeResponsable,$FournisseurResponsable,$PowerProd,$Legacy,$Composant,$ComposantComplement,$ZoneGeographique)
	{
	  	
        $this->_setId($Id);
        $this->_setIdIncident($IdIncident);
	  	$this->_setRefChangement($RefChangement);
	  	$this->_setDatePublicationIr($DatePublicationIr);
	  	$this->_setDatePublicationPm($DatePublicationPm);
	  	$this->_setTypeCause($TypeCause);
	  	$this->_setTypeCauseSecondaire($TypeCauseSecondaire);
	  	$this->_setTypologieGts($TypologieGts);
	  	$this->_setKindOfImpact($KindOfImpact);
	  	$this->_setEquipeResponsable($EquipeResponsable);
	  	$this->_setFournisseurResponsable($FournisseurResponsable);
	  	$this->_setPowerProd($PowerProd);
	  	$this->_setLegacy($Legacy);
	  	$this->_setComposant($Composant);
	  	$this->_setComposantComplement($ComposantComplement);
	  	$this->_setZoneGeographique($ZoneGeographique);
//debug($this->getIdIncident());
     //   debug($this);
		return $this;  	

	}


	/**
     * Création d'un objet dans la base des données
     *
     * @return $this
     */
	public function Creer()
	{
      //  debug($this);
		$requette="INSERT INTO ".SCHEMA.".STATISTIQUE ";
		$requette.="(REFCHANGEMENT,DATEPUBIR,DATEPUBPM,TYPECAUSE,TYPECAUSESECONDAIRE,TYPOLIGYGTS,KINDIMPACT,RESPONSIBLETEAM,FOURNISSEURRESPONSIBLE,POWERPROD,LEGACY,COMPOSANT,COMPOSANTCOMPLEMENT,ZONEGEOGRAPHIQUE,CREATED,UPDATED) ";
		$requette.="VALUES(";
		$requette.="'".$this->getRefChangement()."',";
	  	$requette.="TO_TIMESTAMP('".$this->getDatePublicationIr()."','DD/MM/YYYY'),";
	  	$requette.="TO_TIMESTAMP('".$this->getDatePublicationPm()."','DD/MM/YYYY'),";
	  	$requette.="'".$this->getTypeCause()."',";
	  	$requette.="'".$this->getTypeCauseSecondaire()."',";
	  	$requette.="'".$this->getTypologieGts()."',";
	  	$requette.="'".$this->getKindOfImpact()."',";
	  	$requette.="'".$this->getEquipeResponsable()."',";
	  	$requette.="'".$this->getFournisseurResponsable()."',";
	  	$requette.="'".$this->getPowerProd()."',";
	  	$requette.="'".$this->getLegacy()."',";
	  	$requette.="'".$this->getComposant()."',";
	  	$requette.="'".$this->getComposantComplement()."',";
	  	$requette.="'".$this->getZoneGeographique()."',";
		$requette.="sysdate,";
		$requette.="sysdate)";
		$db = new db();
		$db->db_connect();
		$db->db_query($requette);

        $reqId="SELECT MAX(ID) FROM ".SCHEMA.".STATISTIQUE ";
        // Recuperation de l'id de stat
        $db->db_query($reqId);
        $res=$db->db_fetch_array();

        // Update de Id Stat
        $req="UPDATE ".SCHEMA.".INCIDENT SET STATISTIQUE_ID=".$res[0][0];
        $req.=" WHERE ID =".$this->getIdIncident();

        $db->db_query($req);

		$db->close();


	}


	/**
     * Modification d'un objet dans la base des données
     *
     * @return $none
     */
	public function Modifier()
	{
		
		$requette="UPDATE ".SCHEMA.".STATISTIQUE SET ";
		$requette.="REFCHANGEMENT='".$this->getRefChangement()."',";
	  	$requette.="DATEPUBIR=TO_TIMESTAMP('".$this->getDatePublicationIr()."','DD/MM/YYYY'),";
	  	$requette.="DATEPUBPM=TO_TIMESTAMP('".$this->getDatePublicationPm()."','DD/MM/YYYY'),";
	  	$requette.="TYPECAUSE='".$this->getTypeCause()."',";
	  	$requette.="TYPECAUSESECONDAIRE='".$this->getTypeCauseSecondaire()."',";
	  	$requette.="TYPOLIGYGTS='".$this->getTypologieGts()."',";
	  	$requette.="KINDIMPACT='".$this->getKindOfImpact()."',";
	  	$requette.="RESPONSIBLETEAM='".$this->getEquipeResponsable()."',";
	  	$requette.="FOURNISSEURRESPONSIBLE='".$this->getFournisseurResponsable()."',";
	  	$requette.="POWERPROD='".$this->getPowerProd()."',";
	  	$requette.="LEGACY='".$this->getLegacy()."',";
	  	$requette.="COMPOSANT='".$this->getComposant()."',";
	  	$requette.="COMPOSANTCOMPLEMENT='".$this->getComposantComplement()."',";
	  	$requette.="ZONEGEOGRAPHIQUE='".$this->getZoneGeographique()."',";
		$requette.="UPDATED=sysdate";

		$requette.=" WHERE ID=".$this->getId();
		
		$db = new db();
		$db->db_connect();
		$db->db_query($requette);
		$db->close();


	}

		/**
     * Suppression d'un objet de la base des données 
     * @param $id
     * @return $none
     */
	public function Supprimer()
	{
		
		$requette="DELETE FROM ".SCHEMA.".STATISTIQUE ";		
		$requette.=" WHERE ID=".$this->getId();
		
		$db = new db();
		$db->db_connect();
		$db->db_query($requette);
		$db->close();


	}

	/**
     * Selectionnez un incident
     *
     * @return $none
     */
	public function SelectStatById($id,$IdIncident)
	{
		$requette="SELECT REFCHANGEMENT,TO_CHAR(DATEPUBIR,'DD/MM/YYYY'),TO_CHAR(DATEPUBPM,'DD/MM/YYYY'),TYPECAUSE,TYPECAUSESECONDAIRE,TYPOLIGYGTS,KINDIMPACT,RESPONSIBLETEAM,FOURNISSEURRESPONSIBLE,POWERPROD,LEGACY,COMPOSANT,COMPOSANTCOMPLEMENT,ZONEGEOGRAPHIQUE ";
		$requette.=" FROM  ".SCHEMA.".STATISTIQUE ";
        $requette.=" WHERE ID=".$id;
	
		
		$db = new db();
		$db->db_connect();
		$db->db_query($requette);
		$res=$db->db_fetch_array();
		$db->close();
		$valeur=$res[0];
		$this->SetParam($id,$IdIncident,$valeur[0],$valeur[1],$valeur[2],$valeur[3],$valeur[4],$valeur[5],$valeur[6],$valeur[7],$valeur[8],$valeur[9],$valeur[10],$valeur[11],$valeur[12],$valeur[13]);

		return $this;
	}


		/**
     * Selectionnez la liste des stats
     *
     * @return $none
     */
	public function SelectStat()
	{
		$requette="SELECT ID,REFCHANGEMENT,DATEPUBIR,DATEPUBPM,TYPECAUSE,TYPECAUSESECONDAIRE,TYPOLIGYGTS,KINDIMPACT,RESPONSIBLETEAM,FOURNISSEURRESPONSIBLE,POWERPROD,LEGACY,COMPOSANT,COMPOSANTCOMPLEMENT,ZONEGEOGRAPHIQUE ";
		$requette="FROM  ".SCHEMA.".STATISTIQUE ";
	
		
		$db = new db();
		$db->db_connect();
		$db->db_query($requette);
		$res=$db->db_fetch_array();
		$db->close();
		$tab = array();
		for ($i=0; $i < count($res) ; $i++) 
		{ 
		$valeur=$res[$i];
		array_push($tab, $this->SetParam($valeur[0],$valeur[1],$valeur[2],$valeur[3],$valeur[4],$valeur[5],$valeur[6],$valeur[7],$valeur[8],$valeur[9],$valeur[10],$valeur[11],$valeur[12],$valeur[13],$valeur[14]));
		} 
	
		return $tab;
	}

    /**
     * Gets the value of _Id.
     *
     * @return mixed
     */
    public function getId()
    {
        return $this->_Id;
    }

    /**
     * Sets the value of _Id.
     *
     * @param mixed $_Id the id
     *
     * @return self
     */
    private function _setId($Id)
    {
        $this->_Id = $Id;

        return $this;
    }

    /**
     * Gets the value of _RefChangement.
     *
     * @return mixed
     */
    public function getRefChangement()
    {
        return $this->_RefChangement;
    }

    /**
     * Sets the value of _RefChangement.
     *
     * @param mixed $_RefChangement the ref changement
     *
     * @return self
     */
    private function _setRefChangement($RefChangement)
    {
        $this->_RefChangement = $RefChangement;

        return $this;
    }

    /**
     * Gets the value of _DatePublicationIr.
     *
     * @return mixed
     */
    public function getDatePublicationIr()
    {
        return $this->_DatePublicationIr;
    }

    /**
     * Sets the value of _DatePublicationIr.
     *
     * @param mixed $_DatePublicationIr the date publication ir
     *
     * @return self
     */
    private function _setDatePublicationIr($DatePublicationIr)
    {
        $this->_DatePublicationIr = $DatePublicationIr;

        return $this;
    }

    /**
     * Gets the value of _DatePublicationPm.
     *
     * @return mixed
     */
    public function getDatePublicationPm()
    {
        return $this->_DatePublicationPm;
    }

    /**
     * Sets the value of _DatePublicationPm.
     *
     * @param mixed $_DatePublicationPm the date publication pm
     *
     * @return self
     */
    private function _setDatePublicationPm($DatePublicationPm)
    {
        $this->_DatePublicationPm = $DatePublicationPm;

        return $this;
    }

    /**
     * Gets the value of _TypeCause.
     *
     * @return mixed
     */
    public function getTypeCause()
    {
        return $this->_TypeCause;
    }

    /**
     * Sets the value of _TypeCause.
     *
     * @param mixed $_TypeCause the type cause
     *
     * @return self
     */
    private function _setTypeCause($TypeCause)
    {
        $this->_TypeCause = $TypeCause;

        return $this;
    }

    /**
     * Gets the value of _TypeCauseSecondaire.
     *
     * @return mixed
     */
    public function getTypeCauseSecondaire()
    {
        return $this->_TypeCauseSecondaire;
    }

    /**
     * Sets the value of _TypeCauseSecondaire.
     *
     * @param mixed $_TypeCauseSecondaire the type cause secondaire
     *
     * @return self
     */
    private function _setTypeCauseSecondaire($TypeCauseSecondaire)
    {
        $this->_TypeCauseSecondaire = $TypeCauseSecondaire;

        return $this;
    }

    /**
     * Gets the value of _TypologieGts.
     *
     * @return mixed
     */
    public function getTypologieGts()
    {
        return $this->_TypologieGts;
    }

    /**
     * Sets the value of _TypologieGts.
     *
     * @param mixed $_TypologieGts the typologie gts
     *
     * @return self
     */
    private function _setTypologieGts($TypologieGts)
    {
        $this->_TypologieGts = $TypologieGts;

        return $this;
    }

    /**
     * Gets the value of _KindOfImpact.
     *
     * @return mixed
     */
    public function getKindOfImpact()
    {
        return $this->_KindOfImpact;
    }

    /**
     * Sets the value of _KindOfImpact.
     *
     * @param mixed $_KindOfImpact the kind of impact
     *
     * @return self
     */
    private function _setKindOfImpact($KindOfImpact)
    {
        $this->_KindOfImpact = $KindOfImpact;

        return $this;
    }

    /**
     * Gets the value of _EquipeResponsable.
     *
     * @return mixed
     */
    public function getEquipeResponsable()
    {
        return $this->_EquipeResponsable;
    }

    /**
     * Sets the value of _EquipeResponsable.
     *
     * @param mixed $_EquipeResponsable the equipe responsable
     *
     * @return self
     */
    private function _setEquipeResponsable($EquipeResponsable)
    {
        $this->_EquipeResponsable = $EquipeResponsable;

        return $this;
    }

    /**
     * Gets the value of _FournisseurResponsable.
     *
     * @return mixed
     */
    public function getFournisseurResponsable()
    {
        return $this->_FournisseurResponsable;
    }

    /**
     * Sets the value of _FournisseurResponsable.
     *
     * @param mixed $_FournisseurResponsable the fournisseur responsable
     *
     * @return self
     */
    private function _setFournisseurResponsable($FournisseurResponsable)
    {
        $this->_FournisseurResponsable = $FournisseurResponsable;

        return $this;
    }

    /**
     * Gets the value of _PowerProd.
     *
     * @return mixed
     */
    public function getPowerProd()
    {
        return $this->_PowerProd;
    }

    /**
     * Sets the value of _PowerProd.
     *
     * @param mixed $_PowerProd the power prod
     *
     * @return self
     */
    private function _setPowerProd($PowerProd)
    {
        $this->_PowerProd = $PowerProd;

        return $this;
    }

    /**
     * Gets the value of _Legacy.
     *
     * @return mixed
     */
    public function getLegacy()
    {
        return $this->_Legacy;
    }

    /**
     * Sets the value of _Legacy.
     *
     * @param mixed $_Legacy the legacy
     *
     * @return self
     */
    private function _setLegacy($Legacy)
    {
        $this->_Legacy = $Legacy;

        return $this;
    }

    /**
     * Gets the value of _Composant.
     *
     * @return mixed
     */
    public function getComposant()
    {
        return $this->_Composant;
    }

    /**
     * Sets the value of _Composant.
     *
     * @param mixed $_Composant the composant
     *
     * @return self
     */
    private function _setComposant($Composant)
    {
        $this->_Composant = $Composant;

        return $this;
    }

    /**
     * Gets the value of _ComposantComplement.
     *
     * @return mixed
     */
    public function getComposantComplement()
    {
        return $this->_ComposantComplement;
    }

    /**
     * Sets the value of _ComposantComplement.
     *
     * @param mixed $_ComposantComplement the composant complement
     *
     * @return self
     */
    private function _setComposantComplement($ComposantComplement)
    {
        $this->_ComposantComplement = $ComposantComplement;

        return $this;
    }

    /**
     * Gets the value of _ZoneGeographique.
     *
     * @return mixed
     */
    public function getZoneGeographique()
    {
        return $this->_ZoneGeographique;
    }

    /**
     * Sets the value of _ZoneGeographique.
     *
     * @param mixed $_ZoneGeographique the zone geographique
     *
     * @return self
     */
    private function _setZoneGeographique($ZoneGeographique)
    {
        $this->_ZoneGeographique = $ZoneGeographique;

        return $this;
    }

    /**
     * Gets the value of _IdIncident.
     *
     * @return mixed
     */
    public function getIdIncident()
    {
        return $this->_IdIncident;
    }

    /**
     * Sets the value of _IdIncident.
     *
     * @param mixed $_IdIncident the id incident
     *
     * @return self
     */
    private function _setIdIncident($IdIncident)
    {
        $this->_IdIncident = $IdIncident;

        return $this;
    }
}
?>