<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Classement</title>
    <!-- plugins:css -->
    <link rel="stylesheet" href= <?php echo Settings::RACINE."template/assets/vendors/mdi/css/materialdesignicons.min.css"?>>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."template/assets/css/style.css"?>>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."Assets/Css/navbar.css"?>>
    <!-- End layout styles -->
    <link rel="shortcut icon" href= <?php echo Settings::RACINE."template/assets/images/favicon.png"?>/>
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
     <?php include './Views/Review/review_center.php';?>
     <script src= <?php echo Settings::RACINE."Assets/settings/Settings.js"?>></script>
     <script src= <?php echo Settings::RACINE."Assets/Js/acceuil.js"?>></script>
  </body>
</html>