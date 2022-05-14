<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Acceuil</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href="../../template/assets/vendors/mdi/css/materialdesignicons.min.css">
    <link rel="stylesheet" href="../../template/assets/css/style.css">
    <!-- End layout styles -->
    <link rel="shortcut icon" href="../../template/assets/images/favicon.png" />
    <style>   
      #dropdown {
        position: relative;
        display: inline-block;
      }
      
      .dropdown-content {
        display: none;
        position: absolute;
        background-color: #f1f1f1;
        min-width: 160px;
        box-shadow: 0px 8px 16px 0px rgba(0,0,0,0.2);
        z-index: 1;
      }
      
      .dropdown-content a {
        color: black;
        padding: 12px 16px;
        text-decoration: none;
        display: block;
      }
      
      .dropdown-content a:hover {background-color: #ddd;}
      
      .dropdown:hover .dropdown-content {display: block;}
      
      .dropdown:hover .dropbtn {background-color: #3e8e41;}
      </style>
  </head>
  <body>
     <?php include './Views/Acceuil/acceuilCenter.php';?>
     <script src="../../Assets/settings/Settings.js"></script>
     <script src="../../Assets/Js/parcourboard.js"></script>
     <script src="../../Assets/Js/acceuil.js"></script>
  </body>
</html>