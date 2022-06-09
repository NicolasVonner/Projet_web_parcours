<div class="row">
              <div class="col-12 col-sm-12 col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4><?php echo isset($utilisateur) && !$gameSearch? 'Mes parcours': 'Trouver un parcour'?></h4>
                      <p class="text-muted mb-1">Your data status</p>
                    </div>
                    <ul class="navbar-nav" >
                      <li class="nav-item">
                        <form class="nav-link mt-2 mt-md-0 d-lg-flex search">
                          <input type="text" id="searchbar" class="form-control" placeholder="Search parcour">
                        </form>
                      </li>
                    </ul>
                    <div class="row">
                      <div class="col-12" style="margin-bottom: 0; overflow: auto; height: 400px;">
                        <div class="preview-list" id="list">
                          <?php
                          foreach($parcour_board as $value){
                                    echo '
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon bg-primary">
                                                <i class="mdi mdi-terrain "></i>
                                              </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">';

                                            if(isset($utilisateur) && $gameSearch){
                                              echo '
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->parcour->getNomPa().'</h6>
                                                <p class="text-muted mb-0">Départ : '.$value->position->getNomPo().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted">Créateur : '; 
                                                echo $value->parcour->getCreateur() == $utilisateur->getUsername()? "Moi":$value->parcour->getCreateur();
                                                echo'</p>
                                                <p class="text-muted mb-0">'.$value->steps.' étapes</p>
                                              </div>
                                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                <button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>';                          
                                                echo '<button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-info btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-crown btn-icon-prepend"></i>Ranking</button>';
                                                echo $value->parcour->getCreateur() == $utilisateur->getUsername()? '<button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-warning btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-border-color btn-icon-prepend"></i>Edit</button>':'';
                                            }else if(isset($utilisateur) && !$gameSearch){
                                              echo '
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->parcour->getNomPa().'</h6>
                                                <p class="text-muted mb-0">Départ : '.$value->position->getNomPo().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted mb-0">'.$value->steps.' étapes</p>
                                              </div>
                                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                <button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>
                                                <button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-info btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-crown btn-icon-prepend"></i>Ranking</button>
                                                <button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-warning btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-border-color btn-icon-prepend"></i>Edit</button>';
                                            }else{
                                              echo '
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->parcour->getNomPa().'</h6>
                                                <p class="text-muted mb-0">Départ : '.$value->position->getNomPo().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted mb-0">'.$value->steps.' étapes</p>
                                              </div>
                                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                <button type="button" class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>
                                                <button type="button" id='.$value->parcour->getCodePa().' class="btn btn-outline-info btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-crown btn-icon-prepend"></i>Ranking</button>';
                                            }
                                    echo '
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