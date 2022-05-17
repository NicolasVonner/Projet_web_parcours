<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Sign up</title>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."template/assets/vendors/mdi/css/materialdesignicons.min.css"?>>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."template/assets/css/style.css"?>>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."Assets/Css/signup.css"?>>
    <link rel="shortcut icon" href= <?php echo Settings::RACINE."template/assets/images/favicon.png"?>/>
  </head>
  <body>
    <?php include './Views/Authentification/signupCenter.php';?>
  </body>
</html>