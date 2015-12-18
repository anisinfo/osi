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

/*
*  Fonctions pour la page modification
*/

function getVarUpdate($var,$obj){
	echo (isset($_POST[$var]))?$var:$obj;
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
debug($date);
// Y-m-d H:i:s
$dateReturn=$ligneDate[2].'-'.$ligneDate[1].'-'.$ligneDate[0];
return  $dateReturn;
}
