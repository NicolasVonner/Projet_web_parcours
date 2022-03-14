<?php 
 class Auth_controller{
     function displaySignin(){
        require('Views/Authentification/signin_view.php');
     }
     function displaySignup(){
        require('Views/Authentification/signup_view.php');
     }
    //  function DisplayLogin(){
    //     require('Views/Main/login_view.php');
    //  }
 }
