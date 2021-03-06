<div class="row">
              <div class="col-12 col-sm-12 col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4>ajouter un nouveau membre</h4>
                    </div>
                    <ul class="navbar-nav" >
                      <li class="nav-item">
                        <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                          <input type="text" id="searchbar" class="form-control" placeholder="chercher un nouveau membre">
                        </form>
                      </li>
                    </ul>
                    <div class="row">
                      <div class="col-12" style="margin-bottom: 0; overflow: auto; height: 400px;">
                        <div class="preview-list" id="list">
                          <?php foreach($utilisateursToInivite as $value){
                                    echo '
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon">
                                              <img class="img-xs rounded-circle" src="'.'http://fastadventure/Assets/Images/faces/'.$value->getAvatar().'" alt="photo_profile">
                                              </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">';

                                              echo '
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->getUsername().'</h6>
                                                <p class="text-muted mb-0">Prenom : '.$value->getPrenomM().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <p class="text-muted">Date d\'Inscription : '.$value->getDateInscription().'</p>
                                              </div>
                                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                              <button type="button" id='.$value->getUsername().'-ajouter name="ajouterAEquipe" value="'.$value->getCodeM().'|'.$utilisateur->getEquipe().'" class="btn btn-outline-success btn-icon-text ajouter-membre" style="margin-bottom: 3%;"><i class="mdi mdi mdi-account-plus"></i>Ajouter</button';
                                            
                                    echo '</div>
                                              </div>
                                            </div>
                                        </div>
                                    ';
                                }
                          ?>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</div>