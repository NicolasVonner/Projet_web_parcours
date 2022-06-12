<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Game</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href=<?php echo Settings::RACINE."template/assets/vendors/mdi/css/materialdesignicons.min.css"?>>
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href=<?php echo Settings::RACINE."template/assets/css/style.css"?>>
    <link rel="stylesheet" href=<?php echo Settings::RACINE."Assets/Css/game.css"?>>
    <!-- End layout styles -->
    <link rel="shortcut icon" href=<?php echo Settings::RACINE."template/assets/images/favicon.png" ?>/>
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
  </head>
  <body>
    <div class="container-scroller">
      <!-- partial -->
      <div class="container-fluid">
        <?php // include './Views/userNavBar.php';?>
        <!-- partial -->
        <div class="main-panel" id=<?php echo isset($gameParam)?$gameParam:""?>>
           <?php include './Views/Game/gameCenter.php';?>
        </div>
      </div>
    </div>   
    <script src=<?php echo Settings::RACINE."template/assets/vendors/js/vendor.bundle.base.js"?>></script>
    <script src=<?php echo Settings::RACINE."template/assets/js/misc.js"?>></script>
    <!-- endinject -->
    <script src=<?php echo Settings::RACINE."Assets/settings/Settings.js"?>></script>
    <script src=<?php echo Settings::RACINE."Assets/Js/game.js"?>></script>
    <script src=<?php echo Settings::RACINE."Assets/Js/notes.js"?>></script>
  </body>
</html>
