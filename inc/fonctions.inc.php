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
	$option='<option value="">--</option>';
	for($i=0;$i<count($arr);$i++)	
  	{
  	$selected=(isset($_POST[$var]) &&  ($_POST[$var]==($i+1)))?'selected':'';
  	$option.='<option value="'.($i+1).'" '.$selected.'>'.$arr[$i].'</option>';	
  	}
  	echo $option;
  	
}	

function Check($var)
{
	echo (isset($_POST[$var]))?'selected':'';
}

function Radio($var,$arr)
{

$option='';
  for($i=0;$i<count($arr);$i++) 
    {
    $selected=(isset($_POST[$var]) &&  ($_POST[$var]==$i))?'checked':'';
    $option.='<input type= "radio" name="'.$var.'" value="'.$i.'" '.$selected.'><label>'.$arr[$i].'</label>';  
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

function verifFeries($date) {

  $ferie = 0;
  $tab_feries  =  array();
 // $date = strtotime($t);

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

function dateDiffImp($date1,$date2,$idAppli){
      $td1=explode('/',$date1);
      $td2=explode('/',$date2);
      $date1=$td1[1].'/'.$td1[0].'/'.$td1[2];
      $date2=$td2[1].'/'.$td2[0].'/'.$td2[2];

    $date1=strtotime($date1);
    $date2=strtotime($date2);
    // verifFeries($date1)
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

/*
*  Fonctions pour la page modification
*/

function getVarUpdate($var,$obj)
{
	echo (isset($_POST[$var]))?$_POST[$var]:$obj;
}

function SelectUpdate($var,$obj,$arr)
{
	$option='<option value="">--</option>';
	for($i=0;$i<count($arr);$i++)	
  	{
  	$selected=((isset($_POST[$var]) && $_POST[$var]==($i+1)) || ($obj== ($i+1)))?'selected':'';
  	$option.='<option value="'.($i+1).'" '.$selected.'>'.$arr[$i].'</option>';	
  	}
  	echo $option;
  	
}	

function CheckUpdate($var,$obj)
{
	echo (isset($_POST[$var]))?'selected':($obj)?'selected':'';
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
     echo (isset($_POST[$var]))?$_POST[$var]:($obj)?$obj:'00:00';
  }
  else  echo (isset($_POST[$var]))?$_POST[$var]:($obj)?$obj:'23:59';
 
}
function RadioUpdate($var,$obj,$arr)
{
  $option='';
  for($i=0;$i<count($arr);$i++) 
    {
    $selected=((isset($_POST[$var]) && $_POST[$var]==$i) || ($obj == $i))?'checked':'';
    $option.='<input type= "radio" name="'.$var.'" value="'.$i.'" '.$selected.'><label>'.$arr[$i].'</label>'; 
    }
    echo $option;
    
} 
