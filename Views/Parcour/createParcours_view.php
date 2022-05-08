<?php define("RACINE", "http://fastadventure/");?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Corona Admin</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <!-- endinject -->
    <!-- Layout styles -->
    <link rel="stylesheet" href="../../template/assets/css/style.css">
    <link rel="stylesheet" href="../../Assets/Css/parcour.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../template/assets/images/favicon.png" />
    <link rel="stylesheet" href="https://unpkg.com/leaflet@1.7.1/dist/leaflet.css"
    integrity="sha512-xodZBNTC5n17Xt2atTPuE1HxjVMSvLVW9ocqUKLsCC5CXdbqCmblAshOMAS6/keqq/sMZMZ19scR4PsZChSR7A=="
    crossorigin=""/>
    <script src="https://unpkg.com/leaflet@1.7.1/dist/leaflet.js"
   integrity="sha512-XQoYMqMTK8LvdxXYG3nZ448hOEQiglfqkJs1NOQV44cWnUrBc8PkAOcXy20w0vlaXaVUearIOBhiXZ5V3ynxwA=="
   crossorigin=""></script>
  </head>
  <body>
    <div class="container-scroller">
      <?php include './Views/navSide.php';?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <?php include './Views/userNavBar.php';?>
        <!-- partial -->
        <div class="main-panel">
           <?php include './Views/Parcour/createParcoursCenter.php';?>
        </div>

      </div>

    </div>   
    <script src="../../template/assets/vendors/js/vendor.bundle.base.js"></script>
    <script src="../../template/assets/js/misc.js"></script>
    <!-- endinject -->
    <script src="../../Assets/Js/parcour.js" ></script>
    <script src="../../Assets/Js/activity.js" ></script>
  </body>
</html>