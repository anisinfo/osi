<?php
if(session_status() == PHP_SESSION_NONE){
session_start();
}
?>
<html lang="fr" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title>
    <?php 
    if(TITLE !== NULL){
      echo TITLE;
      } ?>
    </title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo RACINE; ?>css/bootstrap.css" rel="stylesheet">
     <link rel="stylesheet" href="<?php echo RACINE; ?>css/custom.min.css">
     <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>datetimepicker/jquery.datetimepicker.css"/>

    <!-- Custom styles for this template jquery-1.11.2.min.js-->
    <script type="text/javascript">
    var Destinataire="<?= DESTINATAIRE;?>";
    var DestinataireCc="<?= DESTINATAIRECC;?>";
    var DestinataireBcc="<?= DESTINATAIREBCC;?>";
    function EnvoyerMail(id)
      {
          var userAgent= window.navigator.userAgent;       
          if((userAgent.indexOf('MSI') != -1) || (userAgent.indexOf('Trident') != -1))
      {
        try
              {
                
                var outlookApp = new ActiveXObject("Outlook.Application");
                var nameSpace = outlookApp.getNameSpace("MAPI");
                var contenu = document.getElementById('corp').value;
                var sujet= document.getElementById('sujet').value;
                mailFolder = nameSpace.getDefaultFolder(6);
                mailItem = mailFolder.Items.add('IPM.Note.FormA');
                mailItem.Subject=objet;
                mailItem.To = Destinataire;
                mailItem.Cc = DestinataireCc;
                mailItem.BCC = DestinataireBcc;
                mailItem.HTMLBody = "<b>contenux</b>";
                mailItem.display (0); 
              }
            catch(e)
            {
            //  alert(e);
            document.location.href ="commachaud.php?idIncident="+id;
            }
      }
      else
      {
        document.location.href ="commachaud.php?idIncident="+id;
      }
      }
    </script>
    <script src="<?php echo RACINE; ?>js/jquery-1.11.3.min.js"></script>
    
    <script src="<?php echo RACINE; ?>js/bootstrap.js"></script>
    <script src="<?php echo RACINE; ?>js/rem.min.js"></script>
    <script src="<?php echo RACINE; ?>js/rem.js"></script>
    <script src="<?php echo RACINE; ?>js/js.js"></script>

    <script src="<?php echo RACINE; ?>datetimepicker/build/jquery.datetimepicker.full.js"></script>
  <!--  <script src="<?php echo RACINE; ?>js/tinymce/js/tinymce/tinymce.min.js"></script> -->
    
    <script src="<?php echo RACINE; ?>js/jquery.bpopup.min.js"></script>
    <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/foundation.css" />
  <!-- Standard CSS with some REM values, media queries are ignored -->
  <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/general.css" />
  <!-- CSS containing @import lines, test importing of additional sheets -->
  <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/importer.css" />
  <!-- ignore.css shows in normal browsers, but ones where we expect the REM.js to 
       run then the REM rules should not get parsed.
   -->
  <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/ignore.css" data-norem />
    <!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
    <!--[if lt IE 9]>
      <script src="<?php echo RACINE; ?>js/html5shiv.min.js"></script>
      <script src="<?php echo RACINE; ?>js/respond.min.js"></script>
    <![endif]-->

  </head>

  <body>

    <nav class="navbar navbar-inverse">
      <div class="container">
        <div class="navbar-header">
          <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Gestion utilisateurs</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </button>
          <a class="navbar-brand" href="<?= RACINE; ?>">Osi SG</a>
        </div>
        <div id="navbar" class="collapse navbar-collapse">
          <ul class="nav navbar-nav">
          <?php if(isset($_SESSION['auth'])){ ?>
             <li><a href="<?= RACINE; ?>gestion_incidents/">Incidents</a></li>
             <li><a href="<?= RACINE; ?>gestion_osi/index.php">Rapports & Gestion</a></li>
            <?php  if($_SESSION['auth'][6]==1){?>
             <li><a href="<?= RACINE; ?>gestion_users/liste_users.php">Utilisateurs</a></li>
            <?php  }?>
              <li><a href="<?= RACINE; ?>gestion_users/modif.php?id=<?php echo $_SESSION['auth'][0]; ?>">Mes données</a></li>
            <li><a href="<?= RACINE; ?>gestion_users/logout.php">Déconnexion</a></li>
          <?php   
         }else {  ?>
            <li><a href="<?= RACINE; ?>gestion_users/index.php">Se connecter</a></li>
            <?php }?> 
          </ul>
        </div><!--/.nav-collapse -->
<?php
//debug($_SESSION);
?>
      </div>
    </nav>

    <div class="container">
    <?php if(isset($_SESSION['flash']))
    {
      foreach($_SESSION['flash'] as $type=>$message){?>
      <div class="alert alert-<?= $type; ?>">
      <?php echo $message; ?>
      </div>

    <?php  }
    unset($_SESSION['flash']);
    } ?>
    <?php if(isset($_SESSION['auth'])){ ?>
 
<h5>Bonjour <?php echo $_SESSION['auth'][2].' '.$_SESSION['auth'][1];?></h5>
<?php } ?>