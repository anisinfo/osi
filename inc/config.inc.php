<?php
define("SCHEMA","STROSI");
define("PORT","1521");
define("HOST","localhost");
define("SCHEMA_LOGIN","strosi");
define("SCHEMA_PASS","admin");
define("SERVICE", "XE");
define("RACINE","http://127.0.0.1/Hosifosi_data/");
define("LIEN_BASE","oci:dbname=(DESCRIPTION =(ADDRESS_LIST =(ADDRESS =(PROTOCOL = TCP)(Host = ".HOST .")(Port = ".PORT.")))(CONNECT_DATA = (SERVICE_NAME = ".SERVICE.")))");


$STATUT =array('Nouveau','En Cours','Résolu');
$PRIORITE =array('P1','P2','P3');
$RESPONSABILITE=array('GTS','CLIENT','AUTRE');
$SERVICEACTEUR=array('RET','TFO','EUS','ENSEIGNE','PARTENAIRE','AUTRE');
$IMPACTMETIER=array('Indisponibilité','Fraîcheur Infos','Dégradation Perf');
$INCIDENTIMPACTMETIER=array('Low','High','Medium','Non communiqué');
$SLA=array('Non définie','Respecté','Non Respecté');
$CRITICITE=array('Mineur','Majeur','Significatif');

//Statistique 
$STATTYPECAUSE=array('Hj');
$STATCOMPOSANT=array('AZ');
$STATTYPOGTS=array('test');
$STATKINDIMPACT=array('test');
$STATPOWERPROD=array('test');
$STATLEGACY= array('None','Oui','Non');
?>