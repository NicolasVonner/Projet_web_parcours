<?php

use Projet_Web_parcours\Entities\User;
use Projet_Web_parcours\Entities\Session;
use Projet_Web_parcours\Controllers\Game\Game; //TODO éclaircir pour les vues 
use Projet_Web_parcours\Models\Utilisateur;
use Projet_Web_parcours\Assets\enums\request\Join;
use Projet_Web_parcours\Assets\enums\request\Operator;
use Projet_Web_parcours\Assets\enums\request\Fetch;
use Projet_Web_parcours\Assets\settings\Settings;


//on affiche tous les utilisateur sauf le super admin.

//use Projet_Web_parcours\Controllers\Index_controller;
require('Controllers/Main/Index_controller.php');

 class Api_controller extends Index_controller {

     $_GET[]=; //récuper les paramètre de L'URL
    
     function displayApi(){   
        
        headerApiDemande="GET /utilisateurs/12345/ HTTP/1.1
        Host: fastadventure.com
        Accept: application/json";
      
         //convertir le info en json
        //fetchArray()
        $response=fetch;
        json_encode();
    
        $value=json_encode($response, JSON_PRETTY_PRINT);
        header("Content-Type: application/json, Content-Length:".strlen($response));
        
    '}
    ';
        header();
        

        headerApiReponse+="<table>
        <tr>
          <th> nomM </th> 
          <th> prenomM </th>  
          <th>username </th> 
          <th>adresseMail </th> 
          <th> password</th> 
          <th> dateInscription</th> 
          <th> dateNaissance </th> 
          <th> avatar </th> 
          <th> equipe </th>
        </tr>"
        data=["A","B",'C'];
        foreach($data as $value){
            headerApiReponse+="<tr>
            <td>$value</td>
            <td>$value</td>
            <td>$value</td>
          </tr>"
        }       
        headerApiReponse+="</table>";
      
      
     }

     


   
 }
?>