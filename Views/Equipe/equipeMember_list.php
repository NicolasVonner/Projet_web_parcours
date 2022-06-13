<div class="row">
              <div class="col-12 col-sm-12 col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4>Membre de votre équipe:</h4>
                      <p class="text-muted mb-1"><button id="delete-equipe" value="<?php echo $utilisateur->getEquipe()?>" type="button" class="btn btn-outline-danger"> <i class="mdi mdi-delete-forever"></i>Supprimer l\'équipe</button></p>
                    </div>
                    <div class="row">
                      <div class="col-12" style="margin-bottom: 0; overflow: auto; height: 400px;">
                        <div class="preview-list" id="list-equipe-<?php echo $utilisateur->getEquipe() ?>">

                        <?php foreach($utilisateursInTheTeam as $value){
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
                                                <p class="text-muted mb-0">Prénom : '.$value->getPrenomM().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <p class="text-muted">Date d\'Inscription : '.$value->getDateInscription().'</p>
                                              </div>
                                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                              <button type="button" id='.$value->getCodeM().'-exclude name="excludeUserID" value="'.$value->getCodeM().'" class="btn btn-outline-warning btn-icon-text exclude-utilisateur" style="margin-bottom: 3%;"><i class="mdi mdi-account-remove"></i>Exclure</button';
                                            
                                    echo '</div>
                                              </div>
                                            </div>
                                        </div>';
                                          }
                     ?>
  

                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</div>