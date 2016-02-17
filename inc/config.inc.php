<?php
define("SCHEMA","STROSI");
define("PORT","1521");
define("HOST","localhost");
define("SCHEMA_LOGIN","strosi");
define("SCHEMA_PASS","admin");
define("SERVICE", "XE");
define("RACINE","http://127.0.0.1/Hosifosi_data/");
define("LIEN_BASE","oci:dbname=(DESCRIPTION =(ADDRESS_LIST =(ADDRESS =(PROTOCOL = TCP)(Host = ".HOST .")(Port = ".PORT.")))(CONNECT_DATA = (SERVICE_NAME = ".SERVICE.")))");
define("DUREE", 60*60);// En Secondes

$STATUT =array(''=>'--',1=>'Nouveau',2=>'En Cours',3=>'Résolu');
$STATUTCOMMACHAUD=array(''=>'--',1=>'Nouveau / New',2=>'En Cours / In Progress',3=>'Résolu / Resolved');
$STATUTCOLOR =array(1=>'#FB0000',2=>'#ED7F10',3=>'#24B500');
$PRIORITE =array(''=>'--',1=>'P1',2=>'P2',3=>'P3');
$RESPONSABILITE=array(''=>'--',1=>'GTS',2=>'CLIENT',3=>'AUTRE');
$SERVICEACTEUR=array(''=>'--',1=>'RET',2=>'TFO',3=>'EUS',4=>'ENSEIGNE',5=>'PARTENAIRE',6=>'AUTRE');
$IMPACTMETIER=array(''=>'--',1=>'Indisponibilité',2=>'Fraîcheur Infos',3=>'Dégradation Perf');
$INCIDENTIMPACTMETIER=array(''=>'--',1=>'Low',2=>'High',3=>'Medium',4=>'Non communiqué');
$SLA=array(1=>'Non définie',2=>'Respecté',3=>'Non Respecté');
$CRITICITE=array(''=>'--',1=>'Mineur',2=>'Majeur',3=>'Significatif');
$SUIVI=array(''=>'--',1=>'Lead',2=>'Suivi',3=>'Informé',4=>'Pas suivi/Pas informé');

//Statistique 
$STATTYPECAUSE=array(''=>'--',1=>'Application',2=>'Hardware');
$STATCOMPOSANT=array(''=>'--',1=>'saturation FS',2=>'transfert',3=>'base de données',4=>'middleware',5=>'mainframe');
$STATTYPOGTS=array(''=>'--',1=>'Technical Issue',2=>'Other');
$STATKINDIMPACT=array(''=>'--',1=>'Unavailability',2=>'Service degradation',3=>'Data delayed');
$STATPOWERPROD=array(''=>'--',1=>'Yes',2=>'No');
$STATLEGACY= array(1=>'None',2=>'Oui',3=>'Non');
$STATGEOL= array(1=>'FRANCE',2=>'AMER',3=>'ASIA',4=>'WE');

//Comm a chaud
define("DESTINATAIRE","test@test.fr");
define("DESTINATAIRECC","test2@test.fr");
define("DESTINATAIREBCC","test3@test.fr");
define("TELCOMMACHAUD","01234567890");
define("MAILCOMMACHAUD", "test@test.com");

//Migration 
//array('ColonneExcel','ChampsBase','TableBase','TypeChamp',(UNique=TRUE or False))
$CORRESPONDANCE= array(
	'STATISTIQUE'=>array(
		array('ZONEGEOGRAPHIQUE',array('France','AMER','ASIA','WE'),'CHECKLISTE',False),
		array('TYPOLIGYGTS','Typology GTS','TEXTE',False))
		,
	'APPLICATION'=>array(
		array('LIBELLE','Impacted application','TEXTE',False)
		),	
	'INCIDENT'=>array(
		array('INCIDENT','Ticket number','TEXTE',True),
		array('DATEDEBUT','Start','DATE',False),
		array('DATEFIN','End','DATE',False),
		array('DESCRIPTION','Incident description','TEXTE',False),
		array('CAUSE','Cause','TEXTE',False)
		),
	'IMPACT'=>array(
		array('DESCRIPTION','Technical impact description','TEXTE',False),
		array('DUREEREELLE','Impact duration','INT',False),
		array('DESCRIPTION','Incident description','TEXTE',False),
		array('DATESTART','Start','DATE',False)
		)
	);
?>