<?php use Projet_Web_parcours\Assets\settings\Settings;?>
<div class="content-wrapper">           
                      <?php
                          if(!isset($utilisateur) || empty($utilisateur)){
                            echo'
                              <div class="row">
                                <div class="col-12 col-sm-12 col-lg-12 grid-margin">
                                  <div class="card">
                                    <!-- Enlever juste la sucharge du .card .card-body sur le .card-body -->
                                    <div class="card-body" style="padding: 1rem 1rem;">
                                      <div class="row">
                                        <div class="col-9"><h1 class="card-title">Bienvenue</h1>
                                          <p>Lorem Ipsum is simply dummy text of the printing and typesetting industry. Lorem Ipsum has been the industry s standard 
                                            dummy text ever since the 1500s, when an unknown printer took a galley of type and scrambled it to make a type specimen book. 
                                            It has survived not only five centuries, but also the leap into electronic typesetting, remaining essentially unchanged. It was
                                            popularised in the 1960s with the release of Letraset sheets containing Lorem Ipsum passages, and more recently with desktop publishing 
                                            software like Aldus PageMaker including versions of Lorem Ipsum.
                                          </p>
                                        </div>
                                      </div>
                                      <h6 class="text-muted font-weight-normal"></h6>
                                    </div>
                                  </div>
                                </div>
                              </div>';
                          }              
                          include './Views/Acceuil/parcourBoard.php';
                        if(isset($utilisateur) && !$gameSearch || !empty($utilisateur) && !$gameSearch){
                          echo '
                            <div class="row">
                                  <div class="col-2 col-sm-2 col-lg-2 grid-margin"></div>
                                  <div class="col-8 col-sm-8 col-lg-8 grid-margin"></div>
                                  <div class="col-8 col-sm-8 col-lg-8 grid-margin"></div>
                                  <div class="col-2 col-sm-2 col-lg-2 grid-margin"><a class="nav-link btn btn-success create-new-button" id="addButton" href="'.Settings::RACINE.'Parcour/Parcour_controller/displayParcourCreatePage">+ Add parcour </i></a></div>
                            </div>';
                        }  
                      ?>                
</div>