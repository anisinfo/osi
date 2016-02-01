<?php
$tbSearch=$incident->getIdSearch();
$numero=$incident->getNumero();
$statLink=($incident->getIdStat())?'modifStat.php?idIncident='.$numero.'&idStat='.$incident->getIdStat():'stat.php?idIncident='.$numero;
if($numero){
?>
<div class="width100 input-group-addon">
		<label class="lib width50"> N°Incident </label>
		<input type="text" name="numincident"  id="numincident" style="width:300px;" size="12" >
		<input type="button" value="Rechercher" onclick="search()">
		<input type="button" value="<" style="display:<?= ($tbSearch['Prec'])?'block':'none'; ?>" onclick="go(<?= $tbSearch['Prec']; ?>)"> 
		<input type="button" value=">" style="display:<?= ($tbSearch['Next'])?'block':'none'; ?>" onclick="go(<?= $tbSearch['Next']; ?>)">
		<input type="button" style="display:<?= ($tbSearch['Last'])?'block':'none'; ?>" value=">>" onclick="go(<?= $tbSearch['Last']; ?>)">
		<input type="button" style="margin-left:80px;" class="btn btn-success"  onclick="javascript:AjouterIncident('add.php?IdIncident=<?= $numero;?>')" value="Ajouter Incident">
</div>
<a class="btn btn-success <?php echo (isset($link) && $link=="Incident")?"active focus":"";?>" href="modif.php?id=<?= $numero;?>">Incident actif</a>
<a class="btn btn-success <?php echo (isset($link) && $link=="Impact")?"active focus":"";?>" href="ListeImpact.php?idIncident=<?= $numero;?>">Impacts</a>
<a class="btn btn-success <?php echo (isset($link) && $link=="Stat")?"active focus":"";?>" href="<?php echo $statLink; ?>">Stat</a>
<a  class="btn btn-success <?php echo (isset($link) && $link=="Comm")?"active focus":"";?>" href="javascript:EnvoyerMail('<?= $numero;?>')" >Comm à chaud</a>
<a class="btn btn-danger <?php echo (isset($link) && $link=="Supprimer")?"active focus":"";?>" href="javascript:supprimerIncident('index.php?id=<?= $numero;?>&supprimer')" >Supprimer l'incident</a>
<?php
}
?>