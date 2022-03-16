<?php 

include('./Controllers/Access/Access_controller.php');
// use Controllers\Access\Access_controller;

 class Index_controller{
    function rootDirection(){
        if(!Access_controller::verifyConnection()){
            require('Views/Main/mainpage_view.php');
            return true;
        }
    }
 }