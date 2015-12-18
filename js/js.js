function supprimer(adresse){
	if(confirm('Vous êtes sûr de vouloir supprimer?')){
		window.location=adresse;
	}
}

var options = {

  url: "../inc/applications.json.php?name=appli",

  getValue: "NAME",

  list: {	
    match: {
      enabled: true
    }
  },

  theme: "square"
};

$("#Incident_Impact_application_libelle").easyAutocomplete(options);

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
        out += '<tr>' + '<td id="TdName_'+arr[i].ID+'">' + arr[i].NAME + '</td>' + '<td id="TdEnseigne_'+arr[i].ID+'">' + arr[i].ENSEIGNE + '</td>' + '<td id="TdIrt_'+arr[i].ID+'">' + arr[i].IRT + '</td>' + '<td id="TdTrigramme_'+arr[i].ID+'">' + arr[i].TRIGRAMME + '</td><td><a class="b-close btn-ajout"><img width="20px" height="20px" src="../img/add.png" Onclick="RemplirAppli('+arr[i].ID+')" /></a></td></tr>'
       
    }}else
    {
      out='<tr><td colspan="3">Pas de résultats</td></tr>';
    }

    out +='</tbody>';
    document.getElementById('TabResultats').innerHTML='';
    document.getElementById('TabResultats').innerHTML=out;
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

//  alert(id);

//dest
  $('#IdAppli').val(id);
  $('#Incident_Impact_application_libelle').val(nom_search);
  $('#Incident_Impact_application_enseigne').val(enseigne_search);
  $('#Incident_Impact_application_irt').val(irt_search);
  $('#Incident_Impact_application_trigramme').val(trigramme_search);
  document.getElementById('CalendarNomAppli').innerHTML=nom_search;
  $('#ImgCalendar').css('visibility','visible');
  $('#infoAjout').show();
}   
