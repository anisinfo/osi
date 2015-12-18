<?php
define('TITLE','Ajouter un incident');
require_once('../inc/header.inc.php');?>
<h1>Ajouter un incident</h1>

<form class="form-horizontal">
  <fieldlist>
	  <div class="form-group">
	  <div class="input-group"  style="width:50%">
	  <span class="input-group-addon">N° Incident</span>
	    <input type="text" class="form-control">
	    <span class="input-group-btn">
	      <button class="btn btn-success" type="button">Ajouter</button>
	      <button class="btn btn-danger" type="button">Supprimer</button>
	    </span>
	  </div>
  	</div>


  	<table class="table table-striped table-hover " align="left">
 
  <tbody>
    <tr>
      <td width="16.6%">
	      <label><b>Incidents connexes</b></label>
	      <div class="col-lg-10" >
	        <input type="text" class="form-control" id="incidentConnex">       
	      </div>
      </td>
      <td  width="16.6%">
	      <label><b>Probleme</b></label>
	      <div class="col-lg-10">
	        <input type="text" class="form-control" id="incidentConnex">
	      </div>
      </td>
      <td  width="16.6%">
	      <label><b>Responsabilité</b></label>
	      <div class="col-lg-10">
	        <select>
	        	<option>GTS</option>
	        	<option>GTS</option>
	        </select>
	      </div>
      </td>
      <td  width="16.6%">
	       <label><b>Service acteur</b></label>
	      <div class="col-lg-10">
	        <select>
	        	<option>GTS</option>
	        	<option>GTS</option>
	        </select>
	      </div>
      </td>
      <td  width="16.6%">
	      <label><b>Date publication</b></label>
	      <div class="col-lg-10">
	        <input type="date" />
	      </div>
      </td>
      <td  width="16.6%">
       <div class="checkbox">
          <label>
            <input type="checkbox"> Risque aggravation
          </label>
           <label>
            <input type="checkbox"> Déjà apparu
          </label>
           <label>
            <input type="checkbox"> Previsible
          </label>

        </div>
      </td>
      </tr>
      <tr>
      <td colspan="3" width="50%">
      	<span class="label label-default">Application impactés</span>
      </td>
      <td colspan="3">
      	<div class="form-group">
	      <label><b>Description de l'incident*</b></label><br/>
	      <div class="col-lg-10">
	        <textarea class="form-control" rows="3" id="textArea"></textarea>
	      </div>
	       </div>
	    <div class="form-group">
	       <label><b>Cause*</b></label>
	      <div class="col-lg-10">
	        <textarea class="form-control" rows="3" id="textArea"></textarea>
	      </div>
	      </div>
	      <div class="form-group">
	       <label><b>Rétablissement*</b></label>
	      <div class="col-lg-10">
	        <textarea class="form-control" rows="3" id="textArea"></textarea>
	      </div>      
       </div>
      </td>
    
    </tr>
    </tbody></table>
</form>

<?php 
require_once('../inc/footer.inc.php');
?>