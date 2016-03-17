<?php
$dir_osi = dirname($_SERVER["DOCUMENT_ROOT"]);
$dir_osi='C:/Users/AAO11365/Desktop/sg';
$configdb = $dir_osi."/config/db_params.ini";

$iniDB = parse_ini_file ($configdb,TRUE);

$paramsDB = $iniDB['params'];

$host = $paramsDB['database_host'];
$instance = $paramsDB['database_instance'];
$db   = $paramsDB['database_name'];
$user = $paramsDB['database_user'];
$pwd  = $paramsDB['database_password'];
$port = $paramsDB['database_port'];

$racine = $_SERVER["REQUEST_SCHEME"].'://'. $_SERVER['HTTP_HOST'].'/';
$racine= "http://127.0.0.1/Hosifosi_data/";

define("HOST","$host");
define("SCHEMA","$instance");
define("BASE","$db");
define("SERVICE", $instance);
define("PORT","$port");
define("SCHEMA_LOGIN","$user");
define("SCHEMA_PASS","$pwd");
define("RACINE","$racine");


define("LIEN_BASE","oci:dbname=(DESCRIPTION =(ADDRESS_LIST =(ADDRESS =(PROTOCOL = TCP)(Host = ".HOST .")(Port = ".PORT.")))(CONNECT_DATA = (SERVICE_NAME = ".SERVICE.")))");
define("DUREE", 60*60);// En Secondes

$STATUT =array(''=>'--',1=>'Nouveau',2=>'En Cours',3=>'Résolu');
$STATUTCOMMACHAUD=array(''=>'--',1=>'Nouveau / New',2=>'En Cours / In Progress',3=>'Résolu / Resolved');
$STATUTCOLOR =array(1=>'#FB0000',2=>'#ED7F10',3=>'#24B500');
$PRIORITE =array(''=>'--',1=>'P1',2=>'P2',3=>'P3');
$RESPONSABILITE=array(''=>'Other',1=>'GTS',2=>'CLIENT');
$SERVICEACTEUR=array(''=>'Other',1=>'RET',2=>'TFO',3=>'EUS',4=>'ENSEIGNE',5=>'PARTENAIRE');
$IMPACTMETIER=array(''=>'Other',1=>'Indisponibilité',2=>'Fraîcheur Infos',3=>'Dégradation Perf');
$INCIDENTIMPACTMETIER=array(''=>'--',1=>'Low',2=>'High',3=>'Medium',4=>'Non communiqué');
$SLA=array(1=>'Non définie',2=>'Respecté',3=>'Non Respecté');
$CRITICITE=array(''=>'--',1=>'Mineur',2=>'Majeur',3=>'Significatif');
$CRITICITE2=array(''=>'--',1=>'MIN',2=>'MAJ',3=>'SIGR');
$SUIVI=array(''=>'--',1=>'Lead',2=>'Suivi',3=>'Informé',4=>'Pas suivi/Pas informé');

//Statistique 
$STATTYPECAUSE=array(''=>'--',1=>'Application',2=>'Hardware');
$STATCOMPOSANT=array(''=>'--',1=>'saturation FS',2=>'transfert',3=>'base de données',4=>'middleware',5=>'mainframe');
$STATTYPOGTS=array(''=>'--',1=>'Technical Issue',2=>'Other');
$STATKINDIMPACT=array(''=>'--',1=>'Unavailability',2=>'Service degradation',3=>'Data delayed');
$STATPOWERPROD=array(''=>'--',1=>'Yes',2=>'No');
$STATLEGACY= array(1=>'None',2=>'Oui',3=>'Non');
$STATGEOL= array(1=>'FRANCE',2=>'AMER',3=>'ASIA',4=>'WE',5=>'EMEA');

//Comm a chaud
define("DESTINATAIRE","test@test.fr");
define("DESTINATAIRECC","");
$DESTINATAIREBCC = array('GBIS'=>"test3@test.fr",'CDN'=>"test4@test.fr",'BDDF'=>'testabra@gmail.com');
define("TELCOMMACHAUD","01 64 85 76 66 ou 57 666");
define("MAILCOMMACHAUD", "for-retail.quality-of-service-gts@socgen.com");
define("FROMMAIL","QUALITY OF SERVICE GTS For-Retail ResgGtsRetOpmTig");

//Migration 
//array('NomTable',array('ChampsTable','ChampExcel','TypeChamp','Liste des valeurs possible'))
$CORRESPONDANCE= array(
	'STATISTIQUE'=>array(
		array('ZONEGEOGRAPHIQUE',array('France','AMER','ASIA','WE'),'LISTE',$STATGEOL),
		array('TYPOLIGYGTS','Typology GTS','CHECK',$STATTYPOGTS),
		array('REFCHANGEMENT','Change ID','TEXTE'),
		array('typecause','LINCIDSOURCE','CHECK',$STATTYPECAUSE),
		array('DATEPUBIR','Post-Mortem Publication Date (Draft version)','DATE'),
		array('DATEPUBPM','Post-Mortem Publication Date (Final version)','DATE'),
		array('LEGACY','Legacy','CHECK',$STATLEGACY),
		array('POWERPROD','Powerprod','CHECK',$STATPOWERPROD),
	//	array('KINDOFIMPACT','Kind of impact','CHECK',$STATKINDIMPACT),
		array('FOURNISSEURRESPONSIBLE','Responsible','TEXTE')
		)
		,
	'APPLICATION'=>array(
		array('LIBELLE','Impacted application','TEXTE'),
		array('ENSEIGNE','Client','TEXTE'),
		array('maitrise_oeuvre','MOE / Business Line','TEXTE')
		),	
	'INCIDENT'=>array(
		array('INCIDENT','Ticket number','TEXTE'),
		array('DATEDEBUT','Start','DATE'),
		array('DATEFIN','End','DATE'),
		array('DESCRIPTION','Incident description','TEXTE'),
		array('CAUSE','Cause','TEXTE'),
		array('RESPONSABILITE','Responsible','CHECK',$RESPONSABILITE),
		array('SERVICEACTEUR','Accountability','CHECK',$SERVICEACTEUR),
		array('PROBLEME','Problem ID','TEXTE'),
		array('DATEPUBLICATION','DINCIDPUBLI','DATE'),
		array('creci','QIMPACTVALIDATION','CHECK',$CRITICITE),
		array('COMMENTAIRE','LINCIDCOMM','TEXTE'),
		array('DESCRIPTION','Incident description','TEXTE'),
		),
	'IMPACT'=>array(
		array('DESCRIPTION','Technical impact description','TEXTE'),
		array('DATESTART','Start','DATE'),
		array('DUREEREELLE','Impact duration','DUREE'),
		array('JOURHOMME','Lost man-days','TEXTE'),
		array('IMPACTMETIER','Business Impact','CHECK',$IMPACTMETIER)
		
		)
	);
?>