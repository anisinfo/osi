<?php
function debug($err){
	echo '<pre>'.print_r($err,true).'</pre>';
}

/*
*  Fonctions pour la page ajout 
*/
function getVar($var){
	echo htmlentities(trim((isset($_POST[$var]))?$_POST[$var]:''));
	}

function Select($var,$arr)
{
	$option='';
	foreach ($arr as $key => $value) {
    $selected=(isset($_POST[$var]) &&  ($_POST[$var]==$key))?'selected':'';
    $option.='<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
  }
  	echo $option;
  	
}	

function Check($var)
{
	echo (isset($_POST[$var]) && $_POST[$var])?'checked':'';
}

function getCheckListe($var,$arr)
{

  $option='';
  foreach ($arr as $key => $value) {
    $selected=(isset($_POST[$var.'_'.$key]) &&  ($_POST[$var.'_'.$key]==$key))?'checked':'';
    $option.='<input type= "checkbox" name="'.$var.'_'.$key.'" value="'.$key.'" '.$selected.'><label>'.$value.'</label>  ';
  }
    echo $option;

}

function Radio($var,$arr)
{

$option='';
  foreach ($arr as $key => $value) {
    $selected=(isset($_POST[$var]) &&  ($_POST[$var]==$key))?'checked':'';
    $option.='<input type= "radio" name="'.$var.'" value="'.$key.'" '.$selected.'><label>'.$value.'</label>';
  }
    echo $option;
}
function dateDiff($date1,$date2){
      $td1=explode('/',$date1);
      $td2=explode('/',$date2);
      $date1=$td1[1].'/'.$td1[0].'/'.$td1[2];
      $date2=$td2[1].'/'.$td2[0].'/'.$td2[2];

    $date1=strtotime($date1);
    $date2=strtotime($date2);
    $diff = abs($date1 - $date2); // abs pour avoir la valeur absolute, ainsi éviter d'avoir une différence négative

return   printDateFormat($diff);
}

function printDateFormat($diff)
{
    $retour = array();
 
    $tmp = $diff;
    $re = $tmp % 60;
 //echo $diff;
    $tmp = floor( ($tmp - $re) /60 );
    $retour['min.'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['min.'])/60 );
    $retour['h.'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['h.'])  /24 );
    $day=($tmp > 1)?'j.':'j.';
    $retour[$day] = $tmp;
    $retour2=array_reverse($retour);
    $sr="";
      foreach ($retour2 as $key => $value) {
          $sr.=($value)?$value.''.$key.' ':'';
      }
    return $sr;
}

function calc_impactDiff($t1, $t2, $id_application, $dbcnx){

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

  return printDateFormat($impact);
}



/*
*  Fonctions pour la page modification
*/

function getVarUpdate($var,$obj)
{
	echo htmlentities(trim((isset($_POST[$var]))?$_POST[$var]:$obj));
}

function SelectUpdate($var,$obj,$arr)
{
	$option='';
  foreach ($arr as $key => $value) {
  $selected=((isset($_POST[$var]) && $_POST[$var]==$key) || ($obj== $key))?'selected':'';
  $option.='<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
  }
  	echo $option;
  	
}
function getCheckListeUpdate($var,$obj,$arr)
{

  $option='';
  foreach ($arr as $key => $value) {
    $lobj=explode(',',$obj);
    $selected=(isset($_POST[$var.'_'.$key]) || in_array($key,$lobj))?'checked':'';
    $option.='<input type= "checkbox" name="'.$var.'_'.$key.'" value="'.$key.'" '.$selected.'><label>'.$value.'</label>  ';  
  }
  echo $option;

}	

function CheckUpdate($var,$obj)
{
	echo (isset($_POST[$var]) && $_POST[$var])?'checked':($obj)?'checked':'';
}
function dmYdatetoYmd($date)
{
$ligneDate=explode('/', $date);
// Y-m-d H:i:s
$dateReturn=$ligneDate[2].'-'.$ligneDate[1].'-'.$ligneDate[0];
return  $dateReturn;
}

function getVarDate($var,$d)
{
  if ($d==1) {
     echo (isset($_POST[$var]))?$_POST[$var]:'00:00';
  }
  else  echo (isset($_POST[$var]))?$_POST[$var]:'23:59';
 

}

function getVarDateUpdate($var,$obj,$d)
{ 
   if ($d==1) {
   //  echo (isset($_POST[$var]))?$_POST[$var]:($obj)?$obj:'00:00';
     echo (isset($_POST[$var]))?$_POST[$var]:$obj;
  }
  else  echo (isset($_POST[$var]))?$_POST[$var]:$obj;//echo (isset($_POST[$var]))?$_POST[$var]:($obj)?$obj:'23:59';
 
}
function RadioUpdate($var,$obj,$arr)
{
  $option='';
  foreach ($arr as $key => $value) {
     $selected=((isset($_POST[$var]) && $_POST[$var]==$key) || ($obj == $key))?'checked':'';
    $option.='<input type= "radio" name="'.$var.'" value="'.$key.'" '.$selected.'><label>'.$value.'</label>'; 
  }
    echo $option;
    
}
function isInteger($input){
    return(ctype_digit(strval($input)));
} 
function oci_escape_string($str) {
  return str_replace("'","''", $str);
}
function getIdVar($var,$tabVar)
{
  foreach ($tabVar as $k => $v)
    {
      if (strtoupper($v) == strtoupper($var))
      {
        return $k;
      }

    }
}

function EcritureCommachaud($text)
{
return mb_convert_encoding(str_replace( array("\r\n", "\r", "\n"), '<br />',str_replace('"', '""', $text)), 'windows-1252', 'utf-8');
}

