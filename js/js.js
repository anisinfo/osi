
var tabCal={};

function ChangeHeure(J,h)
{
  $('#heure_'+J).text(h);

}

function supprimerIncident(adresse){
	if(confirm('Vous êtes sûr de vouloir supprimer?')){
		window.location=adresse;
	}
}
function AjouterIncident(adresse)
{
 window.location=adresse; 
}
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
      out +='<th>Libellé court</th>';
      out +='<th>Enseigne</th>';
      out +='<th>IRT</th>';
      out +='<th>TRIGRAMME</th>';
      out +='<th></th>';
      out +='</thead>';
      out +='<tbody>';
      
    var i;
    if(arr.length)
    {
    for(i = 0; i < arr.length; i++)
      {
        tabCal[arr[i].ID]=arr[i].CAL;
      //  alert(arr[i].CAL);
        out += '<tr>' + '<td id="TdName_'+arr[i].ID+'">' + arr[i].NAME + '</td>' + '<td id="TdEnseigne_'+arr[i].ID+'">' + arr[i].ENSEIGNE + '</td>' + '<td id="TdIrt_'+arr[i].ID+'">' + arr[i].IRT + '</td>' + '<td id="TdTrigramme_'+arr[i].ID+'">' + arr[i].TRIGRAMME + '</td><td><a class="b-close btn-ajout"><img width="20px" height="20px" src="../img/add.png" Onclick="RemplirAppli('+arr[i].ID+')" /></a></td></tr>';   
      }
    }else
    {
      out='<tr><td colspan="3">Pas de résultats</td></tr>';
    }

    out +='</tbody>';
    $('#TabResultats').html('');
    $('#TabResultats').append(out);
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
$('#infoAjout').hide();
} 


function CalculeDuree()
{
  var dateDeb=$('#Incident_Impact_datedebut').val();
  var dateFin=$('#Incident_Impact_datefin').val();
  var idAppli=$('#IdAppli').val();
  var xmlhttp = new XMLHttpRequest();
  var url = "../inc/duree.inc.php?td1="+dateDeb+"&td2="+dateFin+"&idappli="+idAppli;
  var duree=dateTime(dateFin)-dateTime(dateDeb);
/*  if (dateFin =='' && dateDeb !='')
    {
       $('#Incident_Impact_datefin').datetimepicker({format:'d/m/Y H:i',minDate:dateDeb.substring(0,10),defaultTime:dateDeb.substring(11,16)});
    }
    else if (dateFin =='') 
    {
    $('#Incident_Impact_datefin').datetimepicker({format:'d/m/Y H:i',minDate:dateDeb.substring(0,10),defaultTime:dateDeb.substring(11,16)});
    }
    else */
  if (dateDeb!="" && dateFin!="" && idAppli!="")
  {
    if (duree < 0) {
      alert('Veuillez choisir une date aprés la date de début');
      $('#Incident_Impact_datefin').val('');
      $('#Incident_Impact_datefin').datetimepicker({format:'d/m/Y H:i'});
    }
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        $('#Incident_Impact_dureereelle').val(myArr);
    }
};
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
 }
} 

function dateTime(dat)
{
  var d1J= dat.substring(0,2);
  var d1M= dat.substring(3,5);
  var d1A= dat.substring(6,10);
  var d1H= dat.substring(11,13);
  var d1M= dat.substring(14,16);

  d1 = new Date(d1A,d1M,d1J,d1H,d1M);
  return d1.getTime();
}

function CalculeDureeIncident()
{
  var dateDeb=$('#debutincident').val();
  var dateFin=$('#finincident').val();
  var xmlhttp = new XMLHttpRequest();
  var url = "../inc/duree.inc.php?td1="+dateDeb+"&td2="+dateFin;
  var reg="^(3[01]|[2][0-9]|0)/(1[0-2]|0[1-9])/{4} [0-2]?[0-3]:[0-5][0-9]$";
  var duree=dateTime(dateFin)-dateTime(dateDeb);

/*  if (dateFin =="" && dateDeb !="")
    {
       console.log(dateDeb.substring(0,10))
       $('#finincident').datetimepicker({format:'d/m/Y H:i',minDate:'10/01/2016',minTime:dateDeb.substring(11,16)});           
    }
    else */
  if (dateDeb!="" && dateFin!="")
  {
    if (duree < 0) {
      alert('Veuillez choisir une date aprés la date de début');
      $('#finincident').val('');
      $('#finincident').datetimepicker({format:'d/m/Y H:i'});
    }
    xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        $('#Incident_duree').val(myArr);
      }
    };
  xmlhttp.open("GET", url, true);
  xmlhttp.send();
  }
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

  $('#Incident_Impact_application_libelleb').val(nom_search);
  $('#Incident_Impact_application_enseigneb').val(enseigne_search);
  $('#Incident_Impact_application_irtb').val(irt_search);
  $('#Incident_Impact_application_trigrammeb').val(trigramme_search);

  document.getElementById('CalendarNomAppli').innerHTML=nom_search;
  $('#ImgCalendar').css('visibility','visible');
  $('#infoAjout').show();

    if(tabCal[id])
    {

      $('#Edit_O_Jf').val(tabCal[id].JFO);
       $('#Edit_Jf').val(tabCal[id].JFF);

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

function SauvegarderCal()
{
var url='../inc/calendrier.json.php?Edit_OuvertJf='+$('#Edit_O_Jf').val()+'&Edit_OuvertLu='+$('#Edit_O_Lu').val()+'&Edit_OuvertMa='+$('#Edit_O_Ma').val();
    url+='&Edit_OuvertMe='+$('#Edit_O_Me').val()+'&Edit_OuvertJe='+$('#Edit_O_Je').val()+'&Edit_OuvertVe='+$('#Edit_O_Ve').val();
    url+='&Edit_OuvertSa='+$('#Edit_O_Sa').val()+'&Edit_OuvertDi='+$('#Edit_O_Di').val();
    url+='&Edit_FermerJf='+$('#Edit_Jf').val()+'&Edit_FermerLu='+$('#Edit_Lu').val()+'&Edit_FermerMa='+$('#Edit_Ma').val();
    url+='&Edit_FermerMe='+$('#Edit_Me').val()+'&Edit_FermerJe='+$('#Edit_Je').val()+'&Edit_FermerVe='+$('#Edit_Ve').val();
    url+='&Edit_FermerSa='+$('#Edit_Sa').val()+'&Edit_FermerDi='+$('#Edit_Di').val()+'&IdAppli='+$('#IdAppli').val();
var xmlhttp = new XMLHttpRequest(); 
xmlhttp.onreadystatechange = function() {
    if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
        var myArr = JSON.parse(xmlhttp.responseText);
        if (myArr) {alert(myArr);}else CalculeDuree();
      }
    };
  xmlhttp.open("GET", url, true);
  xmlhttp.send();   
}   

function TestHeure()
{
  reg = new RegExp("^[0-2]?[0-3]:[0-5][0-9]$","g");
  var TabIdResultat= [];
  if (reg.test($('#Edit_O_Jf').val())) {$('#Edit_O_Jf').css('border-color','#cccccc');}else{$('#Edit_O_Jf').css('border-color','red');}
  if (reg.test($('#Edit_O_Lu').val())) {$('#Edit_O_Lu').css('border-color','#cccccc');}else{$('#Edit_O_Lu').css('border-color','red');}
  if (reg.test($('#Edit_O_Ma').val())) {$('#Edit_O_Ma').css('border-color','#cccccc');}else{$('#Edit_O_Ma').css('border-color','red');}
 
  if (reg.test($('#Edit_O_Me').val())) {$('#Edit_O_Me').css('border-color','#cccccc');}else{$('#Edit_O_Me').css('border-color','red');}
  if (reg.test($('#Edit_O_Je').val())) {$('#Edit_O_Je').css('border-color','#cccccc');}else{$('#Edit_O_Je').css('border-color','red');}
  if (reg.test($('#Edit_O_Ve').val())) {$('#Edit_O_Ve').css('border-color','#cccccc');}else{$('#Edit_O_Ve').css('border-color','red');}

  if (reg.test($('#Edit_O_Sa').val())) {$('#Edit_O_Sa').css('border-color','#cccccc');}else{$('#Edit_O_Sa').css('border-color','red');}
  if (reg.test($('#Edit_O_Di').val())) {$('#Edit_O_Di').css('border-color','#cccccc');}else{$('#Edit_O_Di').css('border-color','red');}
  if (reg.test($('#Edit_Jf').val())) {$('#Edit_Jf').css('border-color','#cccccc');}else{$('#Edit_Jf').css('border-color','red');}

  if (reg.test($('#Edit_Lu').val())) {$('#Edit_Lu').css('border-color','#cccccc');}else{$('#Edit_Lu').css('border-color','red');}
  if (reg.test($('#Edit_Ma').val())) {$('#Edit_Ma').css('border-color','#cccccc');}else{$('#Edit_Ma').css('border-color','red');}
  if (reg.test($('#Edit_Me').val())) {$('#Edit_Me').css('border-color','#cccccc');}else{$('#Edit_Me').css('border-color','red');}

  if (reg.test($('#Edit_Je').val())) {$('#Edit_Je').css('border-color','#cccccc');}else{$('#Edit_Je').css('border-color','red');}
  if (reg.test($('#Edit_Ve').val())) {$('#Edit_Ve').css('border-color','#cccccc');}else{$('#Edit_Ve').css('border-color','red');}
  if (reg.test($('#Edit_Sa').val())) {$('#Edit_Sa').css('border-color','#cccccc');}else{$('#Edit_Sa').css('border-color','red');}
  if (reg.test($('#Edit_Di').val())) {$('#Edit_Di').css('border-color','#cccccc');}else{$('#Edit_Di').css('border-color','red');}
  /*for (var i =0;i< TabIdDate.length; i++)
  {
     valeur=$('#'+TabIdDate[i]).val();
    
    // console.log(valeur+'/'+reg.test(valeur));
       if (reg.test(valeur) === false)
        {
          $('#'+TabIdDate[i]).css('border-color','#cccccc'); 
        }
        else
        {
           TabIdResultat.push(TabIdDate[i]);
          $('#'+TabIdDate[i]).css('border-color','red');
        }
    
  } */
 // console.log(TabIdResultat);
}
function EditCalendrier(val)
{
  $('#heure_'+val).hide();
  $('#Edit_'+val).show();
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

function supprimerUser(adresse)
{
  document.location.href=adresse;
}
