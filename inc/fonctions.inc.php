<?php
function debug($err){
	echo '<pre>'.print_r($err,true).'</pre>';
}

/*
*  Fonctions pour la page ajout 
*/
function getVar($var){
	echo (isset($_POST[$var]))?$_POST[$var]:'';
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
    $retour = array();
 
    $tmp = $diff;
    $re = $tmp % 60;
 
    $tmp = floor( ($tmp - $re) /60 );
    $retour['Minutes'] = $tmp % 60;
 
    $tmp = floor( ($tmp - $retour['Minutes'])/60 );
    $retour['Heures'] = $tmp % 24;
 
    $tmp = floor( ($tmp - $retour['Heures'])  /24 );
    $day=($tmp > 1)?'Jours':'Jour';
    $retour[$day] = $tmp;
    $retour2=array_reverse($retour);
    $sr="";
      foreach ($retour2 as $key => $value) {
          $sr.=($value)?$value.' '.$key.' ':'';
      }
    return $sr;
}



function dateDiffImp($date1,$date2,$idAppli){
  require_once('fonctions.temps.inc.php');
  $nDate= new DateTime();
  $nDate::createFromFormat();
$db = new db();
$db->db_connect();
$conn=$db->connection;
return calc_impact($date1, $date2, $idAppli,$conn);
}

/*
*  Fonctions pour la page modification
*/

function getVarUpdate($var,$obj)
{
	echo (isset($_POST[$var]))?$_POST[$var]:$obj;
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
