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
$PRIORITE =array('P1','P2');
$RESPONSABILITE=array('res1','res2');
$SERVICEACTEUR=array('Service1','Service2');
$IMPACTMETIER=array('Indisponibilité','Im2','Im3');
$INCIDENTIMPACTMETIER=array('High','I2','I3');
$SLA=array('Sl1','Sl2','SL3');
$CRITICITE=array('Mineur','Majeur','Significatif');
$STATTYPECAUSE=array('Hj');
$STATCOMPOSANT=array('AZ');
$STATTYPOGTS=array('test');
$STATKINDIMPACT=array('test');
$STATPOWERPROD=array('test');
$STATLEGACY= array('None','Oui','Non');
?>