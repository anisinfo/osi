
var tabCal=[];

function ChangeHeure(J,h)
{
  $('#heure_'+J).text(h);

}

function supprimer(adresse){
	if(confirm('Vous êtes sûr de vouloir supprimer?')){
		window.location=adresse;
	}
}

//var options = {

 // url: "../inc/applications.json.php?name=appli",

//  getValue: "NAME",

//  list: {	
//    match: {
//      enabled: true
//    }
//  },

//  theme: "square"
//};

//$("#Incident_Impact_application_libelle").easyAutocomplete(options);

// Semicolon (;) to ensure closing of earlier scripting
    // Encapsulation
    // $ is assigned to jQuery
    ;(function($) {
        $(function() {
            $('#my-button').bind('click', function(e) {
                e.preventDefault();
                $('#element_to_pop_up').bPopup({
                   follow: [false, false]
                    , appendTo: 'form'
                    , zIndex: 2
                    , modalClose: false
                });
            });
         });
     })(jQuery);

     ;(function($) {
        $(function() {
            $('#btn_calendrier').bind('click', function(e) {
                e.preventDefault();
                $('#element_to_pop_up2').bPopup({
                   //follow: [false, false]
                   appendTo: 'form'
                    , zIndex: 2
                    , modalClose: false
                });
            });
         });
     })(jQuery);

     ;(function($) {
        $(function() {
            $('#btn_chrono').bind('click', function(e) {
                e.preventDefault();
                $('#element_to_pop_up3').bPopup({
                   //follow: [false, false]
                   appendTo: 'form'
                    , zIndex: 2
                    , modalClose: false
                });
            });
         });
     })(jQuery);

     (function($) {
        $(function() {
            $('#button_chrono_modif').bind('click', function(e) {
                e.preventDefault();
                $('#element_to_pop_up3').bPopup({
                   //follow: [false, false]
                   appendTo: 'form'
                    , zIndex: 2
                    , modalClose: false
                });
            });
         });
     })(jQuery);

function myFunction(arr) {
  var out ='<thead>';
      out +='<th>Nom</th>';
      out +='<th>Enseigne</th>';
      out +='<th>IRT</th>';
      out +='<th>TRIGRAMME</th>';
      out +='<th></th>';
      out +='</thead>';
      out +='<tbody>';
      
    var i;
    if(arr.length){
    for(i = 0; i < arr.length; i++) {

        tabCal[arr[i].ID]=arr[i].CAL;
        out += '<tr>' + '<td id="TdName_'+arr[i].ID+'">' + arr[i].NAME + '</td>' + '<td id="TdEnseigne_'+arr[i].ID+'">' + arr[i].ENSEIGNE + '</td>' + '<td id="TdIrt_'+arr[i].ID+'">' + arr[i].IRT + '</td>' + '<td id="TdTrigramme_'+arr[i].ID+'">' + arr[i].TRIGRAMME + '</td><td><a class="b-close btn-ajout"><img width="20px" height="20px" src="../img/add.png" Onclick="RemplirAppli('+arr[i].ID+')" /></a></td></tr>'
       
    }}else
    {
      out='<tr><td colspan="3">Pas de résultats</td></tr>';
    }

    out +='</tbody>';
    $('#TabResultats').append(out);

   
  //  document.getElementById("id01").innerHTML = out;
}

function ChercherAppli()
{
  var nom_search=$('#NomSearch').val();
  var enseigne_search=$('#EnseigneSearch').val();
  var irt_search=$('#IrtSearch').val();
  var trigramme_search=$('#TrigrammeSearch').val();


  var xmlhttp = new XMLHttpRequest();
  var url = "../inc/applications.json.php?name="+nom_search+"&enseigne="+enseigne_search+"&irt="+irt_search+"&trigramme="+trigramme_search;

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        myFunction(myArr);

    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();
} 


function RemplirAppli(id)
{

  var nom_search=$('#TdName_'+id).text();
  var enseigne_search=$('#TdEnseigne_'+id).text();
  var irt_search=$('#TdIrt_'+id).text();
  var trigramme_search=$('#TdTrigramme_'+id).text();

//dest
  $('#IdAppli').val(id);
  $('#Incident_Impact_application_libelle').val(nom_search);
  $('#Incident_Impact_application_enseigne').val(enseigne_search);
  $('#Incident_Impact_application_irt').val(irt_search);
  $('#Incident_Impact_application_trigramme').val(trigramme_search);
  document.getElementById('CalendarNomAppli').innerHTML=nom_search;
  $('#ImgCalendar').css('visibility','visible');
  $('#infoAjout').show();
    if(tabCal[id])
    {

      $('#Edit_O_Jf').val(tabCal[id].JFO);
       $('#Edit_Jf').val(tabCal[id].JFO);

      $('#Edit_O_Lu').val(tabCal[id].LO);
       $('#Edit_Lu').val(tabCal[id].LF);

      $('#Edit_O_Ma').val(tabCal[id].MAO);
       $('#Edit_Ma').val(tabCal[id].MAF);
       
      $('#Edit_O_Me').val(tabCal[id].MEO);
       $('#Edit_Me').val(tabCal[id].MEF);

      $('#Edit_O_Je').val(tabCal[id].JO);
       $('#Edit_Je').val(tabCal[id].JF);

      $('#Edit_O_Ve').val(tabCal[id].VO);
       $('#Edit_Ve').val(tabCal[id].VF);
       
      $('#Edit_O_Sa').val(tabCal[id].SO);
       $('#Edit_Sa').val(tabCal[id].SF);

      $('#Edit_O_Di').val(tabCal[id].DO);
       $('#Edit_Di').val(tabCal[id].DF);  
    
    }else
    {
      var hD="00:00";
      var hF="23:59";

        $('#Edit_O_Jf').val(hD);
       $('#Edit_Jf').val(hF);

      $('#Edit_O_Lu').val(hD);
       $('#Edit_Lu').val(hF);

      $('#Edit_O_Ma').val(hD);
       $('#Edit_Ma').val(hF);
       
      $('#Edit_O_Me').val(hD);
       $('#Edit_Me').val(hF);

      $('#Edit_O_Je').val(hD);
       $('#Edit_Je').val(hF);

      $('#Edit_O_Ve').val(hD);
       $('#Edit_Ve').val(hF);
       
      $('#Edit_O_Sa').val(hD);
       $('#Edit_Sa').val(hF);

      $('#Edit_O_Di').val(hD);
       $('#Edit_Di').val(hF);  

    }

}   

function TestHeure()
{
  reg = new RegExp("^[0-2]?[0-3]:[0-5][0-9]$","g");
  $( "input[id^='Edit_']" ).each(function( index ) {
     if (!reg.test( $(this).val())) {
    $(this).css('border-color','red');
    
  }
 // console.log( index + ": " + $( this ).text() );
});

 
}
function EditCalendrier(val)
{
  $('#heure_'+val).hide();
  $('#Edit_'+val).show();
}

function ajoutChrono(idIncident,id)
{
  var date=$('#dateChrono').val();
  var activite=$('#ativiteChrono').val();
 
  var xmlhttp = new XMLHttpRequest();
  var url = "../gestion_incidents/chronoaction.php?date="+date+"&activite="+activite+"&id_incident="+idIncident+"&id="+id;

xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        if (id) {
          //modification
            trLigne='<td id="date_'+id+'">'+date+'</td><td id="activite_'+id+'">'+activite+'</td><td><input type="button" value="Modifier" Onclick="ajoutChrono('+idIncident+','+myArr[0][0]+')"/></td>';
          $("#tr_chrono_"+id).append(trLigne);
        }else
        {

          trLigne='<tr id="tr_chrono'+id+'"><td id="date_'+id+'">'+date+'</td><td id="activite_'+id+'">'+activite+'</td><td><input type="button" value="Modifier" Onclick="ajoutChrono('+idIncident+','+myArr[0][0]+')"/></td></tr>';
          $("#table-chrono" ).append(trLigne);
        
        }
        
    }
};
xmlhttp.open("GET", url, true);
xmlhttp.send();
} 

function ModiftChrono(idIncident,id)
{

  //recuperation des donnes
 date_origin=$("#date_"+id).text();
 activ_origin=$("#date_"+id).text();
  //console.log(date_origin+activ_origin);

 //repmissage des champs
 $("#dateChrono").val(date_origin);
 $("#ativiteChrono").val(activ_origin);

}

function CreateActivite()
{
 
  var dateActiv=$('#dateChrono').val();
  var LibelleActiv=$('#ativiteChrono').val();
  var id=$('#ChronosLignes >tr').length; 
  var ligne='<tr id="ligne_'+id+'">';
     ligne+='<td><span id="chrono_date_'+id+'">'+dateActiv+'</span>';
     ligne+='<input type="text" id="chrono_input_date_'+id+'" name="chrono_input_date_'+id+'" value="'+dateActiv+'" style="display:none;" />';
     ligne+='</td><td>';
     ligne+='<span id="chrono_activite_'+id+'">'+LibelleActiv+'</span>';
     ligne+='<textarea  id="chrono_input_activite_'+id+'" name="chrono_input_activite_'+id+'" style="display:none;" >'+LibelleActiv+'</textarea>';
     ligne+='</td>';
     ligne+='<td>';
     ligne+='<input type="button" value="Modifier" id="chrono_modif_'+id+'" Onclick="Modifier('+id+')"/>';     
     ligne+='<input type="button" value="Valider" style="display:none;" id="chrono_valid_'+id+'" Onclick="Valider('+id+')"/></td>';

     ligne+='<td><input type="button" value="Supprimer" id="chrono_suppri_'+id+'" Onclick="Supprimer('+id+')"/>';
     ligne+='<input type="button" value="Annuler"  style="display:none;" id="chrono_annul_'+id+'" Onclick="Annuler('+id+')"/>';
     ligne+='</td>';
     ligne+='</tr>';


     $('#ChronosLignes').append(ligne);

     ListeId=$('#ListeId').val();
     $('#ListeId').val(ListeId+','+id);

}

function Supprimer(idLigne)
{

  var ListeId=$('#ListeId').val();
  var reg=new RegExp("(,"+idLigne+")", "g");
  $('#ListeId').val(ListeId.replace(reg,''));
    $('#ligne_'+idLigne).remove();
}


function Modifier(id)
{

$("#chrono_date_"+id).css('display','none');
$("#chrono_activite_"+id).css('display','none');
$("#chrono_modif_"+id).css('display','none');
$("#chrono_suppri_"+id).css('display','none');

$("#chrono_input_date_"+id).css('display','inline');
$("#chrono_input_activite_"+id).css('display','inline');
$("#chrono_valid_"+id).css('display','inline');
$("#chrono_annul_"+id).css('display','inline');

}

function Annuler(id)
{

$("#chrono_date_"+id).css('display','inline');
$("#chrono_activite_"+id).css('display','inline');
$("#chrono_modif_"+id).css('display','inline');
$("#chrono_suppri_"+id).css('display','inline');

$("#chrono_input_date_"+id).css('display','none');
$("#chrono_input_activite_"+id).css('display','none');
$("#chrono_valid_"+id).css('display','none');
$("#chrono_annul_"+id).css('display','none');

}
function Valider(id)
{
  nouveauDate=$('#chrono_input_date_'+id).val();
  nouveauActivite=$('#chrono_input_activite_'+id).val();
  $("#chrono_date_"+id).text(nouveauDate);
  $("#chrono_activite_"+id).text(nouveauActivite);
  Annuler(id);
}

function dateDiff(date1, date2){
    var diff = {}                           // Initialisation du retour
    var tmp = date2 - date1;
 
    tmp = Math.floor(tmp/1000);             // Nombre de secondes entre les 2 dates
    diff.sec = tmp % 60;                    // Extraction du nombre de secondes
 
    tmp = Math.floor((tmp-diff.sec)/60);    // Nombre de minutes (partie entière)
    diff.min = tmp % 60;                    // Extraction du nombre de minutes
 
    tmp = Math.floor((tmp-diff.min)/60);    // Nombre d'heures (entières)
    diff.hour = tmp % 24;                   // Extraction du nombre d'heures
     
    tmp = Math.floor((tmp-diff.hour)/24);   // Nombre de jours restants
    diff.day = tmp;
     
    return diff;
}
function go(id)
{
  if (id != '') {
    document.location.href="modif.php?id="+id;
  }else
  alert("Veuillez Inserer un numéro d'incident valide !");
  
}
function search()
{
  var id= $('#numincident').val();
  document.location.href="modif.php?NumeroIncident="+id;
}