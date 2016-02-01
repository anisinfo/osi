<?php
set_time_limit(0);
function setBgColor($cells,$color){
    global $sheet;

    $sheet->getStyle($cells)->getFill()->applyFromArray(array(
        'type' => PHPExcel_Style_Fill::FILL_SOLID,
        'startcolor' => array( 'rgb' => $color )
    ));
}

function save_sheet($xls_obj, $dirTemp, $titre){
	// Nom de l'onglet courant
	$xls_obj->getActiveSheet() ->setTitle("$titre");

	// if(isset($_POST['date1']) && $_POST['date1'] && isset($_POST['date2']) && $_POST['date2']){
		// $d1 = $_POST['date1'];
		// $d2 = $_POST['date2'];
		// $d1f = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/","$3$2$1",$d1);
		// $d2f = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/","$3$2$1",$d2);

		// $filename=  "$dirTemp" . "$titre$d1f".'_'. "$d2f.xlsx";

	// }else{
		// $filename=  "$dirTemp" . mt_rand(1,100000).'.xlsx';
	// }

	$filename=  "$dirTemp" . mt_rand(1,100000).'.xlsx';

	$objWriter = PHPExcel_IOFactory::createWriter($xls_obj, 'Excel2007');
	$objWriter->save($filename);

	header('Pragma: public');
	header('Expires: 0');
	header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
	header('Content-Type: application/force-download');
	header('Content-Type: application/octet-stream');
	header('Content-Type: application/download');
	header("Content-Disposition: attachment;filename=$filename");
	header('Content-Transfer-Encoding: binary');

	$objWriter->save('php://output');
	unlink($filename);
}

function getSQL_incidents($date1, $date2, $type_data){
	require_once INC_GESTION_OSI."/requetes.inc.php";

	$date1f = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/","$3-$2-$1",$date1);
	$date2f = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/","$3-$2-$1",$date2);
	$cmp_req_creci  =  '';
	// $cmp_req = "where imp.datestart between '$date1f' and '$date2f'";
	 $cmp_req = "where imp.datestart between TO_DATE('$date1f','YYYY-MM-DD') and TO_DATE('$date2f','YYYY-MM-DD')";//oracle
		 $cmp_req_creci = "where inc.datepublication > TO_DATE('$date1f','YYYY-MM-DD') and inc.datepublication <= TO_DATE('$date2f','YYYY-MM-DD')";//oracle

	$select['tout'] = $req['tout'] . " $cmp_req ORDER BY date_start ASC";

	$select['creci'] = $req['creci'] . " $cmp_req_creci ORDER BY date_start ASC"; 
	if (isset($_POST['req_sql']) && $_POST['req_sql'] ) $select['sql'] = $_POST['req_sql'];

	// $max_l = false;
	// if(isset($_POST['limit'])  && $_POST['limit']  ) {
		// $max_l = $_POST['limit'];
	// }

	// if ($max_l) {
	//postgresql
	// if (isset($_POST['req_sql']) && $_POST['req_sql'] && !preg_match("/\s+limit\s+/i", $select['sql'])) $select['sql'] .= " limit  $max_l " ;
	
	//oracle
	// if (isset($_POST['req_sql']) && $_POST['req_sql'] && !preg_match("/\s+rownum\s*/i", $select['sql'])) {
		// if (preg_match("/\s*where\s*/i", $select['sql'])) {
			 // $select['sql'] .= " AND ROWNUM <= $max_l";
		// } else {
			 // $select['sql'] .= " WHERE ROWNUM <= $max_l";
		// }
	// }
	// }

	return $select["$type_data"];
}

function getInc($champs){

	$nb_cles = count($champs);

	$date1 = '';
	$date2 = '';

	if( isset($_POST['date1']) && $_POST['date1'] )  $date1 = $_POST['date1'];
	if( isset($_POST['date2']) && $_POST['date2'] )  $date2 = $_POST['date2'];


	$sql_incidents = getSQL_incidents($date1, $date2, $_POST['type_data']);
	//champs qui ne sont pas concernés par l'extraction excel
	// $cles_supprimes = array('saisie_id', 'formulaire_id');

	$dbcnx = connex_db();

	$incidents0 = res_sel($sql_incidents, $dbcnx)['res'];

	$j = 0;
	$incidents = array();

	$creci = 0;
	if( isset($_POST['type_data']) && $_POST['type_data'] === 'creci') {
		$creci = 1;
	}

	$tout = 0;
	if( isset($_POST['type_data']) && $_POST['type_data'] === 'tout') {
		$tout = 1;
	}

	$nb_incidents = 0;
	$k = -1;
	foreach ($incidents0 as $cle => $v1) {
		foreach ($v1 as $k => $col_value) {
			if( $nb_cles > 0){
				if (in_array($cle, $champs)) {
					$incidents[$cle][$k] = $incidents0[$cle][$k];
				}
			}else{
				$incidents[$cle][$k] = $incidents0[$cle][$k];
			}

			if($creci || $tout){
				$date1_fr = null;
				$date2_fr = null;
				if($incidents0['date_start'][$k]){
					$date1_fr = date("d/m/Y H:i:s", strtotime($incidents0['date_start'][$k]));
				}

				if($incidents0['date_end'][$k]){
					$date2_fr = date("d/m/Y H:i:s", strtotime($incidents0['date_end'][$k]));
				}

				$incidents['duree_impact'][$k] = null;

				if($incidents0['date_end'][$k]){
					$idApp = null;
					if( isset($incidents0['app_id'][$k]) && $incidents0['app_id'][$k]){
						$idApp = $incidents0['app_id'][$k];
					}
					$incidents['duree_impact'][$k] = calc_impact($incidents0['date_start'][$k], $incidents0['date_end'][$k], $idApp, $dbcnx);
				}


				if( isset($incidents0['refchangement'][$k]) && $incidents0['refchangement'][$k]){
			         	$incidents['due_to_change'][$k] = 'Yes';
                                        if ($creci) $incidents['due_to_change'][$k] = 'Oui';
				}else{
					$incidents['due_to_change'][$k] = 'No';
                                        if ($creci) $incidents['due_to_change'][$k] = 'Non';
				}
			}

			if($tout) {
				$incidents['date_start'][$k] = $date1_fr;
				$incidents['date_end'][$k] = $date2_fr;
				if(!isset($incidents['serviceacteur'][$k])) $incidents['serviceacteur'][$k] = 'Other';
				$incidents['serviceacteur'][$k] = (strlen(trim($incidents['serviceacteur'][$k])) === 0) ? 'Other' : $incidents['serviceacteur'][$k];
				$incidents['powerprod'][$k] = (! isset($incidents['powerprod'][$k]) || $incidents['powerprod'][$k] === null) ? 'No' : $incidents['powerprod'][$k];
				$incidents['legacy'][$k] = (! isset($incidents['legacy'][$k]) || $incidents['legacy'][$k] === null) ? 'No' : $incidents['legacy'][$k];
				$arr_zone = array ('france', 'amer', 'asia', 'we', 'emea');
				$zoneg = null;
				// $incidents0['zonegeographique'][$k] = 'amer, france';//test
				$zoneg = 'france';//val par défaut
				if(isset($incidents0['zonegeographique'][$k] ) && $incidents0['zonegeographique'][$k] ) $zoneg = $incidents0['zonegeographique'][$k];
				foreach($arr_zone  as $z){
					if (preg_match("/$z/i", $zoneg)) {
						$incidents[$z][$k] = 'Yes';
					}else{
						$incidents[$z][$k] = 'No';
					}
				}
			}

			if($creci ) {
					if($incidents0['date_end'][$k]){
						$incidents0['statut_inc'][$k] = 'RÉSOLU';
					}else{
						$incidents0['statut_inc'][$k] = 'EN COURS';
					}

				$incidents['dates_creci'][$k] = $date1_fr .'%S%'. $date2_fr .'%S%'.$incidents0['statut_inc'][$k];
				$incidents['description_creci'][$k] = $incidents0['description_inc'][$k] .'%S%'. $incidents0['cause'][$k] .'%S%'.$incidents0['retablissement'][$k];
				$incidents['priorite_enseigne_creci'][$k] =  $incidents0['inc_priorite'][$k] . '/' .  $incidents0['app_enseigne'][$k];

				$incidents['resp_svacteur'][$k] =  $incidents0['responsabilite'][$k] . '/' .  $incidents0['serviceacteur'][$k];
			}
		}

		$j++;
	}

	$nb_incidents = $k+1;
	// echo "b_incidents  :::$k: $nb_incidents <br>";

	// pg_close($dbcnx);
	oci_close($dbcnx);//oracle

	$new_arrInc = $incidents;
	//modifier l'ordre des elements du tableau
	if($nb_incidents > 0){
		if($creci || $tout) {
			$new_arrInc = array();
			foreach ($champs as $c) {
				$new_arrInc[$c] = $incidents[$c];
			}
		}
	}
	return array($nb_incidents, $new_arrInc);
}


function getDateLastThursday(){
    $lastTh = date('d/m/Y', strtotime('next thursday'));
    $lastThLessWK = date('d/m/Y', strtotime('last thursday'));

	if (date('N', time()) == 4){
		$lastTh = date('d/m/Y');
		$lastThLessWK = date('d/m/Y', strtotime('-7 days'));
	}

	return array($lastTh, $lastThLessWK);
}

function duree($date1, $date2){

	$nb_sec = strtotime("$date2") - strtotime("$date1");

	// $format = '%a jour(s) %h heure(s) %i minute(s) %s seconde(s)';
	$format = '%a jour(s) %h heure(s) %i minute(s)';
	if($nb_sec < 60)
	$format = '%s seconde(s)';
	if($nb_sec >= 60 && $nb_sec < 60*60)
		$format = '%i minute(s)';

	if($nb_sec >= 60*60 && $nb_sec < 24*60*60)
		$format = '%h heure(s) %i minute(s)';

	$t1 = new DateTime($date1);
	$t2 = new DateTime($date2);
	$interval = $t2->diff($t1);

	return $interval->format($format);
}


function dureeSec($date1, $date2){
	$nb_sec = strtotime("$date2") - strtotime("$date1");
	return $nb_sec;
}

function setForSpec($obj_xl, $cel, $t1, $v1, $t2, $v2, $t3, $v3){

	$objRichText = new PHPExcel_RichText();
	$objBold = $objRichText->createTextRun("$t1\n");
	$objBold->getFont()->setBold(true);
	$objRichText->createText($v1);

	$objBold2 = $objRichText->createTextRun("$t2\n");
	$objBold2->getFont()->setBold(true);
	$objRichText->createText($v2);

	$objBold3 = $objRichText->createTextRun("$t3\n");
	$objBold3->getFont()->setBold(true);
	// $objRichText->createText($v3);
	$objBold3b = $objRichText->createTextRun("$v3\n");
	if(!$t3) $objBold3b->getFont()->setBold(true);

	$obj_xl->getCell($cel)->setValue($objRichText);
}


function setDataWithStyle($obj_xls, $c1, $c2, $cl_bg, $style, $data){

	$obj_xls->setCellValue("$c1", "$data");
	setBgColor("$c1:$c2", "$cl_bg");
	$obj_xls->getStyle("$c1:$c2")->applyFromArray($style);
	$obj_xls->getStyle("$c1:$c2")->getBorders()->getAllBorders()->setBorderStyle(PHPExcel_Style_Border::BORDER_MEDIUM);
	$obj_xls->mergeCells("$c1:$c2");
}

$arrcal = array();

function dispo_app($id_app, $dbcnx){

	global $arrcal;
	require "requetes.inc.php";

	if(!$dbcnx) return null;

	if (count($arrcal) === 0) {
		$sel = $req['disp_applis']; // . " where application_id='$id_app'";

		// $sel = "select * from strosi.calendrier where application_id='$id_app'";
		$r = res_sel($sel, $dbcnx)['res'];
		$disp_app = array();
		$key = $r['application_id'];
		foreach ($key as $k => $i) {
			foreach ($r as $c2 => $v2) {
				$disp_app[$i][$c2] = $v2[$k];
			}
		}
		$arrcal = $disp_app;
	}
	return (array_key_exists($id_app, $arrcal)) ? $arrcal[$id_app] : null;
}


function getRowNbSel($from, $dbcnx){

	if(!$dbcnx) return null;

	// $req = pg_query($sql_count) or die('echec sql : ' . pg_last_error());
	// $req = pg_query($sql_count);
	$sql_count = "select count(*) NUMBER_OF_ROWS FROM $from";
	$req  = ociparse($dbcnx,$sql_count);  // oracle

	oci_define_by_name($req, 'NUMBER_OF_ROWS', $number_of_rows);

	if(!oci_execute($req, OCI_DEFAULT)){
		oci_rollback($dbcnx);
		$e = oci_error($req);
		print "<pre><font color='red'>". $e['sqltext'].': '. $e['message'] .'</font></pre>';
		$_url = "../index.php?ong=".$_POST['ong'];
		echo  "<br><br><b><a href=$_url>Retour</a></b>";
		die;
	}

	oci_fetch($req);

	return $number_of_rows;
}

function res_sel($sel, $dbcnx){

	if(!$dbcnx) return null;

	// $req = pg_query($sel) or die('echec sql : ' . pg_last_error());
	// $req = pg_query($sel);

	$req  = ociparse($dbcnx,$sel);  // oracle
	
	if(!oci_execute($req, OCI_DEFAULT)){    
		oci_rollback($dbcnx);
		$e = oci_error($req);
		print "<pre><font color='red'>". $e['sqltext'].': '. $e['message'] .'</font></pre>';
		$_url = "../index.php?ong=".$_POST['ong'];
		echo  "<br><br><b><a href=$_url>Retour</a></b>";
		die;
	}

	$res = array();
	$i =0;

	while($line= oci_fetch_array($req, OCI_ASSOC+OCI_RETURN_NULLS)){  // oracle
	// while ($line = pg_fetch_array($req, null, PGSQL_ASSOC)) {
		foreach ($line as $cle => $col_value) {
			$res[strtolower($cle)][$i] = $col_value;
		}
		$i++;
	}
	$total_lignes = $i;

	// pg_free_result($req);
	oci_free_statement($req);//oracle

	// return list($res, $total_lignes);
	return array('res' => $res, 'total_lignes' => $total_lignes);;
}

function calc_impact($t1, $t2, $id_application, $dbcnx){

	$no = 0;

	$date1 = null;
	$date2 = null;
	$heure1 = null;
	$heure2 = null;

	$dt1 = date("Y-m-d H:i:s", strtotime($t1));
	$dt2 = date("Y-m-d H:i:s", strtotime($t2));

	if(!$id_application){
		$dur_imp = dureeSec($t1, $t2);
		return printf_date($dur_imp);
	}

	$disp = dispo_app($id_application, $dbcnx);

	if (preg_match("/(\d{4}\-\d{2}\-\d{2}) (\d{2}:\d{2}:\d{2})/",$dt1, $matches1)){
		$date1 = $matches1[1];
		$heure1 = $matches1[2];
	}

	if (preg_match("/(\d{4}\-\d{2}\-\d{2}) (\d{2}:\d{2}:\d{2})/",$dt2, $matches2)){
		$date2 = $matches2[1];
		$heure2 = $matches2[2];
	}

	$tab_jours = array('lundi' => 1, 'mardi' => 2, 'mercredi' => 3, 'jeudi' => 4, 'vendredi' => 5, 'samedi' => 6, 'dimanche' => 7);
	$flip_j = array_flip($tab_jours);

	$nb_jours['feries'] = nbJ_parNom($date1, $date2, $tab_jours, null, 'f');

	foreach (array_keys($tab_jours) as $v){
		$nb_jours[$v] = nbJ_parNom($date1, $date2, $tab_jours, $v, null);

		if(!isset( $disp[$v.'ouverture' ] )){
		  $disp[$v.'ouverture' ] = '00:00:00';
		}
		if(!isset( $disp[$v.'fermeture' ] )){
		  $disp[$v.'fermeture' ] = '23:59:59';
		}
	}

	if(!isset( $disp['feriesouverture' ] )){
		$disp['feriesouverture' ] = '00:00:00';
	}
	if(!isset( $disp['feriesfermeture' ] )){
		 $disp['feriesfermeture' ] = '23:59:59';
	}

	$diff_jours = diffJours($date1,$date2);

	$deb = new DateTime(date('d-m-Y', strtotime($date1)) );
	$j_deb = $flip_j[$deb ->format('N')];

	$fin = new DateTime(date('d-m-Y', strtotime($date2)) );
	$j_fin = $flip_j[$fin ->format('N')];

	if(verifFeries($date1)){
		$j_deb = 'feries';
	}

	if(verifFeries($date2)){
		$j_fin = 'feries';
	}

	$impact = 0;
	if($diff_jours == 0){
		if( strtotime($heure1) <  strtotime($disp[$j_deb.'ouverture' ]) &&  strtotime($heure2) <  strtotime($disp[$j_deb.'fermeture' ] ) ){
			$impact = dureeSec($disp[$j_deb.'ouverture'], $heure2);
		}
		elseif( strtotime($heure1) >  strtotime($disp[$j_deb.'ouverture' ]) &&  strtotime($heure2) <  strtotime($disp[$j_deb.'fermeture' ] ) ){
			$impact = dureeSec($heure1, $heure2);
		}
		elseif( strtotime($heure1) >  strtotime($disp[$j_deb.'ouverture' ]) &&  strtotime($heure2) >  strtotime($disp[$j_deb.'fermeture' ] ) ){
			$impact = dureeSec($heure1, $disp[$j_deb.'fermeture' ]);
		}
		else{
			$impact = dureeSec($disp[$j_deb.'ouverture' ], $disp[$j_deb.'fermeture' ] );
		}
	}else{
		$impact_deb = 0;
		$impact_fin = 0;

		if( strtotime($heure1) <  strtotime($disp[$j_deb.'ouverture' ]) ){
			$impact_deb  = dureeSec($disp[$j_deb.'ouverture' ], $disp[$j_deb.'fermeture' ] );
		}
		elseif( strtotime($heure1) >  strtotime($disp[$j_deb.'ouverture' ])  &&   strtotime($heure1) < strtotime($disp[$j_deb.'fermeture' ])  ){
			$impact_deb  = dureeSec($heure1, $disp[$j_deb.'fermeture' ]);
		}

		if( strtotime($heure2) > strtotime($disp[$j_fin.'ouverture' ])   &&   strtotime($heure2) < strtotime($disp[$j_fin.'fermeture' ])  ){
			$impact_fin  = dureeSec($disp[$j_fin.'ouverture' ], $heure2);
		}
		elseif( strtotime($heure2) >  strtotime($disp[$j_fin.'fermeture' ])   ){
			$impact_fin  =  dureeSec($disp[$j_fin.'ouverture' ], $disp[$j_fin.'fermeture' ]);
		}

		if( $diff_jours == 1){
			$impact = $impact_deb + $impact_fin;
		}
		elseif( $diff_jours > 1){
			foreach ($nb_jours as $j => $n){
				$impact += $n*dureeSec($disp[$j.'ouverture' ], $disp[$j.'fermeture' ] );
			}
			$impact += ($impact_deb + $impact_fin);
		}
	}

	return printf_date($impact);
}

function printf_date($time){
	// $tab_unit = array("jours" => 86400, "heures" => 3600, "minutes" => 60, "secondes" => 1);
	$tab_unit = array("Jours" => 86400, "Heures" => 3600, "Minutes" => 60);

	$format_tout = 0;
	$format_creci = 0;
	if( isset($_POST['type_data']) && $_POST['type_data'] === 'tout') $format_tout = 1;
	if( isset($_POST['type_data']) && $_POST['type_data'] === 'creci') $format_creci = 1;

	if($format_tout) $tab_unit = array( "Minutes" => 60);
	if($format_creci) $tab_unit = array("j " => 86400, ":" => 3600, "" => 60);

	$dt_fm = null;
	foreach($tab_unit as $uniteT => $nbSecsDansUnite) {
		$$uniteT = floor($time/$nbSecsDansUnite);
		if($format_creci && ($nbSecsDansUnite == 3600 or $nbSecsDansUnite == 60)) $$uniteT =sprintf("%02d", $$uniteT);
		$time = $time%$nbSecsDansUnite;
		if($$uniteT > 0 || !empty($dt_fm))
			if($format_tout){
				$dt_fm .= $$uniteT;
			}else{
				$dt_fm .= $$uniteT." $uniteT ";
			}
	}

	if( !$format_tout && preg_match('/^\d{2}$/', trim($dt_fm) )){
			$dt_fm = '00:'.$dt_fm;
	}


	if(! $dt_fm) return 0;
	else return $dt_fm;
}

function list_joursFeries($t1, $t2) {

	$list_feries =  array();
	$tab_feries  =  array();
	$date_debut = strtotime($t1);
	$date_fin = strtotime($t2);

	$diff_annee = date('Y', $date_fin) - date('Y', $date_debut);

	for ($i = 0; $i <= $diff_annee; $i++) {

		$annee = (int)date('Y', $date_debut) + $i;
		$tab_feries[] = '01-01-'.$annee;
		$tab_feries[] = '01-05-'.$annee;
		$tab_feries[] = '08-05-'.$annee;
		$tab_feries[] = '14-07-'.$annee;
		$tab_feries[] = '15-08-'.$annee;
		$tab_feries[] = '01-11-'.$annee;
		$tab_feries[] = '11-11-'.$annee;
		$tab_feries[] = '25-12-'.$annee;

		// Récupération de paques. Permet ensuite d'obtenir le jour de l'ascension et celui de la pentecote
		$easter = easter_date($annee);
		$tab_feries[] = date('d-m-'.$annee, $easter + 86400); // Paques
		$tab_feries[] = date('d-m-'.$annee, $easter + (86400*39)); // Ascension
		$tab_feries[] = date('d-m-'.$annee, $easter + (86400*50)); // Pentecote
	}

	$nb_feries = 0;
	while ($date_debut < $date_fin) {
		if (in_array(date('d-m-'.date('Y', $date_debut), $date_debut), $tab_feries)) {
				array_push($list_feries, date('Y-m-d', $date_debut) );
				$nb_feries++;
		}
		$date_debut = mktime(date('H', $date_debut), date('i', $date_debut), date('s', $date_debut), date('m', $date_debut), date('d', $date_debut) + 1, date('Y', $date_debut));
	}
	return $list_feries;
}

function verifFeries($t) {

	$ferie = 0;
	$tab_feries  =  array();
	$date = strtotime($t);

	$annee = date('Y', $date);

	$tab_feries = array('01-01-'.$annee, '01-05-'.$annee, '08-05-'.$annee, '14-07-'.$annee, '15-08-'.$annee, '01-11-'.$annee, '11-11-'.$annee, '25-12-'.$annee);
	$easter = easter_date($annee);

	$tab_feries[] = date('d-m-'.$annee, $easter + 86400); // Paques
	$tab_feries[] = date('d-m-'.$annee, $easter + (86400*39)); // Ascension
	$tab_feries[] = date('d-m-'.$annee, $easter + (86400*50)); // Pentecote

	if(in_array(date('d-m-Y', $date), $tab_feries)){
		return 1;
	}else{
		return 0;
	}
}

function nbJ_parNom($date1, $date2, $jours, $nomJour, $typej){
	//nombre d'une journée de la semaine dans un intervalle de temps:
	// exemple nombre de lundi du 01 au 20 fevrier (sans compter le 01 et le dernier jour de lintervalle)

	// $jours = array('lundi' => 1, 'mardi' => 2, 'mercredi' => 3, 'jeudi' => 4, 'vendredi' => 5, 'samedi' => 6, 'dimanche' => 7);
	$feries = list_joursFeries($date1, $date2) ;

	$no = 0;
	$start = new DateTime(date('Y-m-d', strtotime($date1.' + 1 DAY')) );
	$end   = new DateTime($date2);
	$interval = DateInterval::createFromDateString('1 day');
	$period = new DatePeriod($start, $interval, $end);

	foreach ($period as $dt){
		if($typej === 'f'){#jours feries
			if (in_array($dt->format('Y-m-d'), $feries) ){
				$no++;
			}
		}
		else{
			if($nomJour){
				if ($dt->format('N') == $jours[$nomJour] && !in_array($dt->format('Y-m-d'), $feries)){
					// echo $dt->format('N D d-m-Y'), "<br>";
					$no++;
				}
			}else{//tous (sauf les feriés)
				$no++;
			}
		}
	}
	return $no;
}

function diffJours($debut, $fin) {
    $debut_t = strtotime($debut);
    $fin_t = strtotime($fin);
    $diff = $fin_t - $debut_t;
    return round($diff / (60*60*24) );
}

function echo_val($cle, $tab, $val_def){
	if(isset($tab["$cle"]) && $tab["$cle"]){
	    echo $tab["$cle"];
	}else{
		if($val_def) echo $val_def;
	}
}

function els_formRech(){

	$dbcnx = connex_db();
	
	$arr_opt1 = ['priorite', 'responsabilite', 'serviceacteur'];
	foreach($arr_opt1 as $c){
		$sql[$c] = "select distinct $c from strosi.incident where $c is not null order by $c asc";
	}
	
	$arr_opt2 = ['sensibilite', 'grand_client', 'etat', 'domaine', 'enseigne', 'maitrise_ouvrage', 'bt', 'groupe_ism', 'me'];
	foreach($arr_opt2 as $c){
		$sql[$c] = "select distinct $c from strosi.application where $c is not null order by $c asc";
	}
	
	$sql['severite'] =  "select distinct severite from strosi.impact where severite is not null order by severite asc";
	$sql['cause'] =  "select distinct typecause from strosi.statistique where typecause is not null order by typecause asc";
	// $sql['client'] =  "select distinct enseigne from strosi.application where enseigne is not null order by enseigne asc";

	$list = array();
	foreach (array_keys($sql) as $e){
		$r = res_sel($sql[$e], $dbcnx)['res'];
		$list[$e] = array();
		foreach ($r as $v1) {
			foreach ($v1 as $v2) {
				if(!preg_match('/^\s*$/', $v2))
					// $list[$e][] =  ucwords(strtolower($v2));
					$list[$e][] = $v2;
			}
		}
		$list[$e] = array_unique($list[$e]);
	}

	// pg_close($dbcnx);
	oci_close($dbcnx);//oracle
	return $list;
}

function print_op($c, $tab){
	foreach ($tab as $op){
		if(isset($_POST[$c]) && $_POST[$c] === $op){
			echo "<option selected >$op";
		}
		else{
			echo "<option>$op";
		}
	}
}

function list_incidents(){

	require_once "requetes.inc.php";

	$iniFile = parse_ini_file (CONFIG.'/conf_incidents.ini',TRUE);

	$champs1['priorite'] = 'inc.priorite';
	$champs1['responsabilite'] = 'inc.responsabilite';
	$champs1['serviceacteur'] = 'inc.serviceacteur';
	$champs1['severite'] = 'imp.severite';

	$champs2['trigramme'] = 'app.trigramme';
	$champs2['impact'] = 'imp.description';
	$champs2['enseigne'] = 'app.enseigne';
	$champs2['cause'] = 'stat.typecause';
	$champs2['application'] = 'app.libelle';
	$champs2['n_incident'] = array('inc.incident', 'inc.incidentsConnexes');

	$addSql = null;

	foreach(array_keys($champs1) as $champ){
		$addSql .= add_sql($champ, $champs1[$champ], $_POST, 'eq');
	}

//	if(isset($_POST['application']) && $_POST['application'] ){
//		$addSql .= " and (lower(app.libelle) like '%". strtolower($_POST['application']) ."%'";
//	}

	foreach(array_keys($champs2) as $champ){
		$addSql .= add_sql($champ, $champs2[$champ], $_POST, null);
	}

	$date1 = '';
	$date2 = '';

	if( isset($_POST['date_1']) && $_POST['date_1'] )  $date1 = $_POST['date_1'];
	if( isset($_POST['date_2']) && $_POST['date_2'] )  $date2 = $_POST['date_2'];

	$date1f = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/","$3-$2-$1",$date1);
	$date2f = preg_replace("/(\d{2})\/(\d{2})\/(\d{4})/","$3-$2-$1",$date2);

	//$reqDates = "where imp.datestart between '$date1f' and '$date2f'";
	$reqDates = "where imp.datestart between TO_DATE('$date1f','YYYY-MM-DD') and TO_DATE('$date2f','YYYY-MM-DD')";//oracle

	$select = $req['tout'] . " $reqDates $addSql order by date_start DESC";
	
        $dbcnx = connex_db();

	$rech = res_sel($select, $dbcnx)['res'];
	// pg_close($dbcnx);
	oci_close($dbcnx);//oracle

	$arrInc = array();
	foreach (array_keys($iniFile) as $c) {
		if($c != 'duree_impact' && isset( $rech[$c]))
			$arrInc[$c] = $rech[$c];
	}

	$html = "<meta charset='UTF-8'>";
	$html .= "<table style='width: 3000px; table-layout:fixed;' id='tab_inc' border='1' cellspacing='0' cellpadding='3' ><thead><TR>";
	foreach (array_keys($arrInc) as $c) {
		$t = $c;
		if (in_array($c, array_keys($iniFile))) {
			$t = $iniFile[$c];
		}

		if($c === 'incident'){
			$hrf =  "href=javascript:SortTable(0,'T','tab_inc');";
			$html .= "<TH style='min-width: 150px; width: 150px;'><a $hrf >$t</a></TH>";
		}elseif($c === 'date_start' or $c === 'date_end'){
			$hrf =  "href=javascript:SortTable(1,'D','tab_inc');";
			$html .= "<TH  style='min-width: 150px; width: 150px;'><a $hrf >$t</a></TH>";
		}elseif(in_array($c, array('description_inc', 'cause', 'description_imp'))){
            $html .= "<TH style='min-width: 350px; width: 350px;'>$t</TH>";
        }
        else{
			$html .= "<TH  style='min-width: 180px; width: 180px;'>$t</TH>";
		}

	}
	$html .= "</TR></THEAD><TBODY>";

	$tab = array();
	// $j = 0;
	$l = -1;
	foreach ($arrInc as $c => $v1) {
		foreach ($v1 as $l => $v2) {
			$tab[$l][$c] = $v2;
		}
		// $j++;
	}
	$nb = $l+1;

	if($nb == 0){
		$html = null;
	}else{
		for($i=0; $i < $nb; $i++ ){
			$html .= "<TR>";
			foreach (array_keys($arrInc) as $c) {
                $vtd = '&nbsp;';
                if($tab[$i][$c] ) $vtd =  $tab[$i][$c];

                if($c == 'incident') {
					$html .= "<TD style='white-space:nowrap'><a href='/edit/".$rech['id_incident'][$i] ."' target='_parent'>".$vtd ."</a></TD>";
				} elseif (in_array($c, array('date_start', 'date_end', 'datepublication'))) {
					$html .= "<TD style='white-space: nowrap'>".$vtd ."</TD>";
				} 
				else {
					$html .= "<TD>".$vtd ."</TD>";
				}
			}
			$html .= "</TR>";
		}

		$html .= "</tbody></TABLE>";
		$html = "<B> $nb incidents </B><br> $html";
	}
	return $html ;
}

function add_sql($v, $ch, $tab, $opt_eq){
       $r = null;
       if(isset($tab[$v]) && $tab[$v]){
          if ( false === is_array($ch) ) {
              if($opt_eq == 'eq'){
                      $r = " and lower($ch)='". strtolower($tab[$v]) ."'";
              }else{
                      $r = " and lower($ch) like '%". strtolower($tab[$v]) ."%'";
              }
          } else {
              $r = ' and ( ';
              foreach ($ch as $i => $_ch) {
                  if ($i > 0 && $i < count($ch)) $r .= ' or ';
                  if($opt_eq == 'eq'){
                      $r .= "lower($_ch)='". strtolower($tab[$v]) ."'";
                  }else{
                      $r .= "lower($_ch) like '%". strtolower($tab[$v]) ."%'";
                  }
              }
              $r .= ' )';
          }
       }
	return $r;
}

function echo_post($ch){
	if(isset($_POST[$ch]) && $_POST[$ch]) echo $_POST[$ch];
}

function showMsgWait(){
	
	echo str_pad('',4096)."\n";   
	echo "<script>";
	echo "document.getElementById('message').style.display = \"block\";";
	echo "</script>";
    ob_flush();
    flush();
}

function hideMsgWait(){
	echo "<script>";
	echo "document.getElementById('message').style.display = \"none\";";
	echo "</script>"; 
	ob_end_flush();
}


?>
