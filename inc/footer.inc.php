
</div>
<script>
        $.datetimepicker.setLocale('fr');

        $('#debutincident').datetimepicker({format:'d/m/Y H:i'});
     //   var debDate=$('#debutincident').val();
    //    var finDate=$('#finincident').val();
     //   if (finDate !='' && finDate!=undefined) {
             $('#finincident').datetimepicker({format:'d/m/Y H:i'});
     //   };
       

        $('#Incident_Impact_datedebut').datetimepicker({format:'d/m/Y H:i'});
        // var finImpact=$('#Incident_Impact_datefin').val();
        // var debImpact=$('#Incident_Impact_datedebut').val();
       //   if (finImpact !='' && finImpact!=undefined) {
             $('#Incident_Impact_datefin').datetimepicker({format:'d/m/Y H:i'});
      //  };
      //  $('#incidentdatecreci').datetimepicker({format:'d/m/Y',timepicker:false});

        $('#dateChrono').datetimepicker({format:'d/m/Y H:i'});

        $('#incidentdatedecision').datetimepicker({format:'d/m/Y H:i'});


         $('#stat_publicationIR').datetimepicker({format:'d/m/Y',timepicker:false});
         $('#stat_publicationPM').datetimepicker({format:'d/m/Y',timepicker:false});

         $("#Incident_Impact_datedebut").change(function(){ CalculeDuree();});

        $("#Incident_Impact_datefin").change(function(){CalculeDuree();});
        $("#debutincident").change(function(){CalculeDureeIncident();});
        $("#finincident").change(function(){CalculeDureeIncident();});      
    </script>
</body>
</html>