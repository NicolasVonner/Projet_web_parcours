<?php 
 class Index_controller{
     function verifyConnection(){
        session_start();
        if(!isset($_SESSION['login'])){
            require('Views/Main/mainpage_view.php');
            // require('Views/Login/formconnection_vue.php');
        }else {
            require('Views/Main/mainpage_view.php');
            // require('Views/Main/main_vue.php'); 
            // require('Views/Login/butdeconnection_vue.php');
        }
     }
 }
