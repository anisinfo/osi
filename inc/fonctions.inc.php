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
