<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<!DOCTYPE html>
<html lang="fr">
  <head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <title>Equipe</title>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."template/assets/vendors/mdi/css/materialdesignicons.min.css"?>>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."template/assets/css/style.css"?>>
    <link rel="stylesheet" href= <?php echo Settings::RACINE."Assets/Css/equipe.css"?>>
    <link rel="shortcut icon" href= <?php echo Settings::RACINE."template/assets/images/favicon.png"?>/>
   
  </head>
  <body>

 
</script>

<div class="container-scroller">
      <?php include './Views/navSide.php';?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <?php include './Views/userNavBar.php';?>
        </div>

        </div> 
    <?php 
    if($utilisateur->getEquipe()!= null){ //si le jouers est dans une équipe
     include('./Views/Equipe/equipeMember_list.php'); //il voit son équipe et la liste de membre
     //tous les joueurs voient la liste des équipe même s'il ne peut qu'en rejoindre un seul
      include './Views/Equipe/equipeBoard.php';
    } else{ //sinon le joueurs peut crée une équipe
      include './Views/Equipe/equipeCenter.php';
    }
    
    
    ?>
      
    <script src=<?php echo Settings::RACINE."template/assets/vendors/js/vendor.bundle.base.js"?>></script>
    <script src=<?php echo Settings::RACINE."template/assets/js/misc.js"?>></script>
    <script src=<?php echo Settings::RACINE."Assets/settings/Settings.js"?>></script>
    <script src= <?php echo Settings::RACINE."assets/chart.js/Chart.min.js"?>> </script>
    <script src= <?php echo Settings::RACINE."assets/Js/equipe.js"?>> </script>
  </body>
  
</html>