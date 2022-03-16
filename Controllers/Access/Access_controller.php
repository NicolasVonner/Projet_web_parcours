<?php 
// namespace App\Controllers;
 class Access_controller{    
    public static function verifyConnection(){
       session_start();
       return !isset($_SESSION['login'])? require('Views/Main/mainpage_view.php') : true;
    }
 }
?>