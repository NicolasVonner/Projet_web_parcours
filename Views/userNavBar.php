<?php 
use Projet_Web_parcours\Assets\settings\Settings;
           echo'      
            <nav class="navbar p-0 fixed-top flex-row">
                  <div class="navbar-brand-wrapper d-flex d-lg-none align-items-center justify-content-center">
                    <a class="navbar-brand brand-logo-mini" href="'.Settings::RACINE.'"><img src="#" alt="logo" /></a>
                  </div>
                  <div class="navbar-menu-wrapper flex-grow d-flex align-items-stretch">
                    <button class="navbar-toggler navbar-toggler align-self-center" type="button" data-toggle="minimize">
                      <span class="mdi mdi-menu"></span>
                    </button>
                    <ul class="navbar-nav w-100" id="nav">
                      <!-- <li class="nav-item w-100">
                        <form class="nav-link mt-2 mt-md-0 d-none d-lg-flex search">
                          <input type="text" class="form-control" placeholder="Search products">
                        </form>
                      </li> -->
                    </ul>
                    <ul class="navbar-nav navbar-nav-right">';
                    if(!isset($utilisateur) || empty($utilisateur)){
                      echo'
                      <li class="nav-item"> 
                        <form action="'.Settings::RACINE.'Authentification/Authentification_controller/displaySignup">
                          <button type="submit" class="btn btn-outline-light btn-fw" id="signUp" style="border: none;min-width: auto;">Sign Up </button>
                        </form>
                      </li>
                      <li class="nav-item"> 
                        <form action="'.Settings::RACINE.'Authentification/Authentification_controller/displaySignin">
                          <button type="submit" class="btn btn-outline-light btn-fw" id="signIn" style="border: none;min-width: auto;">Sign In</button>
                        </form>
                      </li>';
                    }else{
                      echo'
                        <li class="nav-item dropdown">
                                        <a class="nav-link btn btn-success create-new-button" id="playButton" data-bs-toggle="dropdown" aria-expanded="false" href="#"><i class="mdi mdi-play"></i> Play</a>
                                        <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="createbuttonDropdown">
                                          <h6 class="p-3 mb-0">Projects</h6>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item preview-item" id="searchGame">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon bg-dark rounded-circle">
                                                <i class=" mdi mdi-view-list text-primary"></i>
                                              </div>
                                            </div>
                                            <div class="preview-item-content">
                                              <p class="preview-subject ellipsis mb-1">Search parcour</p>
                                            </div>
                                          </a>
                                          <div class="dropdown-divider"></div>
                                          <a class="dropdown-item preview-item" id="searchHashGame">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon bg-dark rounded-circle">
                                                <i class="mdi mdi-qrcode text-info"></i>
                                              </div>
                                            </div>
                                            <div class="preview-item-content">
                                              <p class="preview-subject ellipsis mb-1">Enter code</p>
                                            </div>
                                          </a>
                                          <div class="dropdown-divider"></div>
                                          <p class="p-3 mb-0 text-center">Live your best adventure</p>
                                        </div>
                        </li>
                        <li class="nav-item dropdown">
                          <a class="nav-link" id="profileDropdown" href="#" data-bs-toggle="dropdown">
                            <div class="navbar-profile">
                              <img class="img-xs rounded-circle" src="'.Settings::RACINE.'Assets/Images/faces/'.$utilisateur->getAvatar().'" alt="">
                              <p class="mb-0 d-none d-sm-block navbar-profile-name">'.$utilisateur->getUsername().'</p>
                              <i class="mdi mdi-menu-down d-none d-sm-block"></i>
                            </div>
                          </a>
                          <div class="dropdown-menu dropdown-menu-right navbar-dropdown preview-list" aria-labelledby="profileDropdown">
                            <h6 class="p-3 mb-0">Profile</h6>
                            <div class="dropdown-divider"></div>
                            <a id="settings" class="dropdown-item preview-item">
                              <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                  <i class="mdi mdi-settings text-success"></i>
                                </div>
                              </div>
                              <div class="preview-item-content">
                                <p class="preview-subject mb-1">Settings</p>
                              </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <a class="dropdown-item preview-item" href="'.Settings::RACINE.'Main/Index_controller/logout">
                              <div class="preview-thumbnail">
                                <div class="preview-icon bg-dark rounded-circle">
                                  <i class="mdi mdi-logout text-danger"></i>
                                </div>
                              </div>
                              <div class="preview-item-content">
                                <p class="preview-subject mb-1">Log out</p>
                              </div>
                            </a>
                            <div class="dropdown-divider"></div>
                            <p class="p-3 mb-0 text-center">Advanced settings</p>
                          </div>
                        </li>';
                    }
                    echo '
                    </ul>
                  </div>
            </nav>        
            <script src="'.Settings::RACINE.'/Assets/Js/navbar.js"></script>'; 
?>      