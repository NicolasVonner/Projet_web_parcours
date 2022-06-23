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
                          //TODO mettre value et pas id pour le numéro n du parcour.
                          foreach($parcour_board as $key => $value){
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
                                              <div class="flex-grow" style="margin-right: 10px;">';
                                                echo '<p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted">Créateur : '; 
                                                echo $value->parcour->getCreateur() == $utilisateur->getUsername()? "Moi":$value->parcour->getCreateur();
                                                echo'</p>
                                                <p class="text-muted">Etapes : '.$value->steps.'</p>';
                                                echo $value->parcour->getCreateur() == $utilisateur->getUsername()? "<p class='text-muted'>Hash code : ".$value->parcour->getHashCode()."</p>":"";
                                                if($value->averageNotes != null){     
                                                  for($i = 0; $i < intval($value->averageNotes); $i++){
                                                    echo '<i class="mdi mdi-star"></i>';
                                                  }
                                                }else {
                                                  echo '<i class="mdi mdi-star-off"></i>';
                                                }
                                                echo ' </div>
                                                  <div class="me-auto text-sm-right pt-2 pt-sm-0">';
                                              echo intval($value->parcour->getActivation()) == 0?
                                              '<button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;" disabled><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>'
                                              :
                                             ' <button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>'
                                              ;                      
                                                echo '<button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-info btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-crown btn-icon-prepend"></i>Ranking</button>';
                                                echo $value->parcour->getCreateur() == $utilisateur->getUsername()? '<button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-warning btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-border-color btn-icon-prepend"></i>Edit</button>':'';
                                                if($value->parcour->getCreateur() == $utilisateur->getUsername() && $value->parcour->getActivation() == 0) {
                                                  echo '<button type="button" id='.$key.' value='.$value->parcour->getCodePa().' class="btn btn-outline-success btn-icon-text' .$value->parcour->getCodePa().'" style="margin-bottom: 3%;"><i class="mdi mdi-eye-off btn-icon-prepend"></i>Activer</button>';
                                                }elseif($value->parcour->getCreateur() == $utilisateur->getUsername() && $value->parcour->getActivation() == 1){
                                                  echo '<button type="button" id='.$key.' value='.$value->parcour->getCodePa().' class="btn btn-outline-danger btn-icon-text' .$value->parcour->getCodePa().'" style="margin-bottom: 3%;"><i class="mdi mdi-eye-off btn-icon-prepend"></i>Désactiver</button>';
                                                }

                                            }else if(isset($utilisateur) && !$gameSearch){
                                              echo '
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->parcour->getNomPa().'</h6>
                                                <p class="text-muted mb-0">Départ : '.$value->position->getNomPo().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">';
                                                echo '<p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted">Etapes : '.$value->steps.'</p>
                                                <p class="text-muted">Hash code : '.$value->parcour->getHashCode().'</p>';
                                                if($value->averageNotes != null){     
                                                  for($i = 0; $i < intval($value->averageNotes); $i++){
                                                    echo '<i class="mdi mdi-star"></i>';
                                                  }
                                                }else {
                                                  echo '<i class="mdi mdi-star-off"></i>';
                                                }
                                              echo '</div>
                                                <div class="me-auto text-sm-right pt-2 pt-sm-0">';
                                              echo intval($value->parcour->getActivation()) == 0?
                                              '<button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;" disabled><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>'
                                              :
                                             ' <button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>'
                                              ;
                                                echo '<button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-info btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-crown btn-icon-prepend"></i>Ranking</button>
                                                <button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-warning btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-border-color btn-icon-prepend"></i>Edit</button>';
                                               echo $value->parcour->getActivation() == 0? '<button type="button" id = '.$key.' value ='.$value->parcour->getCodePa().' class="btn btn-outline-success btn-icon-text '.$value->parcour->getCodePa().'" style="margin-bottom: 3%;"><i class="mdi mdi-eye btn-icon-prepend"></i>Activer</button>':
                                                '<button type="button" id = '.$key.' value='.$value->parcour->getCodePa().' class="btn btn-outline-danger btn-icon-text '.$value->parcour->getCodePa().'" style="margin-bottom: 3%;"><i class="mdi mdi-eye-off btn-icon-prepend"></i>Désactiver</button>';
                                            }else{
                                              echo '
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->parcour->getNomPa().'</h6> 
                                                <p class="text-muted mb-0">Départ : '.$value->position->getNomPo().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">';
                                                echo '<p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted mb-0">Etapes : '.$value->steps.'</p>';
                                                if($value->averageNotes != null){     
                                                  for($i = 0; $i < intval($value->averageNotes); $i++){
                                                    echo '<i class="mdi mdi-star"></i>';
                                                  }
                                                }else {
                                                  echo '<i class="mdi mdi-star-off"></i>';
                                                }
                                                echo'
                                                </div>
                                                <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                  <button type="button" class="btn btn-outline-primary btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-play btn-icon-prepend"></i>Jouer</button>
                                                  <button type="button" value='.$value->parcour->getCodePa().' class="btn btn-outline-info btn-icon-text" style="margin-bottom: 3%;"><i class="mdi mdi-crown btn-icon-prepend"></i>Ranking</button>';
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