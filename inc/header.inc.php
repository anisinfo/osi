<?php
if(session_status() == PHP_SESSION_NONE){
session_start();
}
require('fonctions.inc.php');
require_once('config.inc.php');
?>
<!DOCTYPE html>
<html lang="fr" >
  <head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- The above 3 meta tags *must* come first in the head; any other head content must come *after* these tags -->
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="">

    <title><?= TITLE; ?></title>

    <!-- Bootstrap core CSS -->
    <link href="<?php echo RACINE; ?>css/bootstrap.css" rel="stylesheet">
     <link rel="stylesheet" href="<?php echo RACINE; ?>css/custom.min.css">
     <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>datetimepicker/jquery.datetimepicker.css"/>

    <!-- Custom styles for this template jquery-1.11.2.min.js-->
    
    <script src="<?php echo RACINE; ?>js/jquery-1.11.3.min.js"></script>
    
    <script src="<?php echo RACINE; ?>js/bootstrap.js"></script>
    <script src="<?php echo RACINE; ?>js/rem.min.js"></script>
    <script src="<?php echo RACINE; ?>js/rem.js"></script>
    <script src="<?php echo RACINE; ?>js/js.js"></script>

    <script src="<?php echo RACINE; ?>datetimepicker/build/jquery.datetimepicker.full.js"></script>
    
    <script src="<?php echo RACINE; ?>js/jquery.bpopup.min.js"></script>
   
    <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/easy-autocomplete.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/easy-autocomplete.themes.min.css" />
    <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/foundation.css" />
  <!-- Standard CSS with some REM values, media queries are ignored -->
  <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/general.css" />
  <!-- CSS containing @import lines, test importing of additional sheets -->
  <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/importer.css" />
  <!-- ignore.css shows in normal browsers, but ones where we expect the REM.js to 
       run then the REM rules should not get parsed.
   -->
  <link rel="stylesheet" type="text/css" href="<?php echo RACINE; ?>css/ignore.css" data-norem />

     <!--   Définition des styles; à copier dans un fichier css  -->
      <STYLE type="text/css">
      #element_to_pop_up, #element_to_pop_up2, #element_to_pop_up3 { 
    background-color:#fff;
    border-radius:15px;
    color:#000;
    display:none; 
    padding:20px;
    min-width:700px;
    min-height: 180px;
}
.b-close{
    cursor:pointer;
    position:absolute;
    right:10px;
    top:5px;
}
.btn-ajout{

  position: relative;

}

      .bloc{ width:94%; margin:0 auto; overflow:hidden;}
      .bloc label.lib{text-align: left; float: none; font-weight: bold;}
      .fl-left{ float: left;}
       .fl-left .btn{   padding: 4px 12px;}
      .width100{width:100%; float: left;    margin: 5px 0; padding: 5px;}
      .bcg{ background: whitesmoke;border: 1px solid #ccc;
    border-radius: 4px;}
      .width50{width:48%; float:left;}
      .width12{width:12%; float:left; overflow: hidden;height: 50px;}
      .width20{width:23%; float:left;}
      .bloc>.width50{width:46%; float:left; margin:0 2%;}
      .bloc input[type="text"], .bloc input[type="password"],
      .bloc input[type="date"], .bloc input[type="datetime"], 
      .bloc input[type="datetime-local"], .bloc input[type="month"], 
      .bloc input[type="week"], .bloc input[type="email"],
       .bloc input[type="number"], .bloc input[type="search"], .bloc input[type="button"],
       .bloc input[type="submit"], .bloc input[type="tel"], .bloc input[type="time"], 
       .bloc input[type="url"], textarea, .bloc select { float:left; margin-right: 5px;  height: 30px; margin-bottom: 0;}
       .bloc input[type="number"]{ width:48%; margin-right: 35px;}
       .mr_35{margin-right: 30px;}
       .mr_10{margin-right: 14px;}
       .mr_7{margin-right: 5px;}
       .bloc input[type="number"],.bloc select{ padding:0;}
       .bloc fieldset{ padding: 5px 0;    width: 98%; margin-left: 10px; background: #e7e7e7;}
       .bloc .fl-right{ float: right; margin-right: 25px;}
       .bloc .fl-right span{ margin-right: 20px;}
       .right{ float: right;}
       .bloc fieldset span{ font-size: 11px}
       input[type="button"].btn-plus{    float: left;    height: 20px;    margin-left: 25px;}
       .bloc fieldset legend{ font-size: 14px; border: 1px solid #d3d3d3;; background: #eee; text-align: center;border-bottom: none;padding: 10px;}
  
      </STYLE>

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
             <li><a href="<?= RACINE; ?>gestion_rapports/">Gestion des rapports</a></li>
            <?php  if($_SESSION['auth'][6]==1){?>
             <li><a href="<?= RACINE; ?>gestion_users/liste_users.php">Utilisateurs</a></li>
            <?php  }?>
          <!--  <li  class="dropdown open">
            <a class="dropdown-toggle" data-toggle="dropdown" role="button" aria-expanded="true" href="#">Gestion OSI<b class="caret"></b>                  </a>
                <ul class="dropdown-menu" role="menu">
                  <li><a href="">test</a></li>
                </ul>
            </li>
           -->
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