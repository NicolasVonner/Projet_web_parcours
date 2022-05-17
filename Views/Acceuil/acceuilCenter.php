<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<div class="container-scroller">
      <?php include './Views/navSide.php';?>
      <!-- partial -->
      <div class="container-fluid page-body-wrapper">
        <!-- partial:partials/_navbar.html -->
        <?php include './Views/userNavBar.php';?>
        <!-- partial -->
        <div class="main-panel">
        <?php include './Views/Acceuil/acceuilMainContent.php';?>
          <!-- content-wrapper ends -->
          <!-- partial:partials/_footer.html -->
          <footer class="footer">
            <div class="d-sm-flex justify-content-center justify-content-sm-between">
              <span class="text-muted d-block text-center text-sm-left d-sm-inline-block">Copyright ©</span>
              <span class="float-none float-sm-right d-block mt-1 mt-sm-0 text-center"> Programmation web </span>
            </div>
          </footer>
          <!-- partial -->
        </div>
        <!-- main-panel ends -->
      </div>
      <!-- page-body-wrapper ends -->
    </div>
    <script src= <?php echo Settings::RACINE."template/assets/vendors/js/vendor.bundle.base.js"?>></script>
    <script src= <?php echo Settings::RACINE."template/assets/js/misc.js"?>></script>
    