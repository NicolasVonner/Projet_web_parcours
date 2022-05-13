<div class="row">
              <div class="col-12 col-sm-12 col-lg-12 grid-margin">
                <div class="card">
                  <div class="card-body">
                    <div class="d-flex flex-row justify-content-between">
                      <h4><?php echo isset($utilisateur)? 'Mes parcours': 'Trouver un parcour'?></h4>
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
                          <?php foreach($parcour_board as $value){
                                    echo '
                                        <div class="preview-item border-bottom">
                                            <div class="preview-thumbnail">
                                              <div class="preview-icon bg-primary">
                                                <i class="mdi mdi-terrain "></i>
                                              </div>
                                            </div>
                                            <div class="preview-item-content d-sm-flex flex-grow">
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <h6 class="preview-subject">'.$value->parcour->getNomPa().'</h6>
                                                <p class="text-muted mb-0">Départ : '.$value->position->getNomPo().'</p>
                                              </div>
                                              <div class="flex-grow" style="margin-right: 10px;">
                                                <p class="text-muted">Publié le : '.$value->parcour->getDateCreation().'</p>
                                                <p class="text-muted mb-0">'.$value->steps.' étapes</p>
                                              </div>
                                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                                <button type="button" id="$parcour->getId()" class="btn btn-inverse-primary btn-fw">Jouer</button>
                                              </div>
                                            </div>
                                        </div>
                                    ';
                                }
                          ?>
                          <!-- <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-primary">
                                <i class="mdi mdi-file-document"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow" style="margin-right: 10px;">
                                <h6 class="preview-subject">Super_parcour</h6>
                                <p class="text-muted mb-0">Toulon</p>
                              </div>
                              <div class="flex-grow" style="margin-right: 10px;">
                                <p class="text-muted">Estimation : 2h</p>
                                <p class="text-muted mb-0">30 km, 50 enigmes </p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <button type="button" class="btn btn-inverse-primary btn-fw">Jouer</button>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-primary">
                                <i class="mdi mdi-file-document"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow" style="margin-right: 10px;">
                                <h6 class="preview-subject">Super_parcour</h6>
                                <p class="text-muted mb-0">Toulon</p>
                              </div>
                              <div class="flex-grow" style="margin-right: 10px;">
                                <p class="text-muted">Estimation : 2h</p>
                                <p class="text-muted mb-0">30 km, 50 enigmes </p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <button type="button" class="btn btn-primary btn-rounded btn-icon">
                                  <i class="mdi  mdi mdi-play "></i>
                                </button>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-info">
                                <i class="mdi mdi-clock"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">Project meeting</h6>
                                <p class="text-muted mb-0">New project discussion</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">35 minutes ago</p>
                                <p class="text-muted mb-0">15 tasks, 2 issues</p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item border-bottom">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-danger">
                                <i class="mdi mdi-email-open"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">Broadcast Mail</h6>
                                <p class="text-muted mb-0">Sent release details to team</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">55 minutes ago</p>
                                <p class="text-muted mb-0">35 tasks, 7 issues </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-warning">
                                <i class="mdi mdi-chart-pie"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">UI Design</h6>
                                <p class="text-muted mb-0">New application planning</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">50 minutes ago</p>
                                <p class="text-muted mb-0">27 tasks, 4 issues </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-warning">
                                <i class="mdi mdi-chart-pie"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">UI Design</h6>
                                <p class="text-muted mb-0">New application planning</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">50 minutes ago</p>
                                <p class="text-muted mb-0">27 tasks, 4 issues </p>
                              </div>
                            </div>
                          </div>
                          <div class="preview-item">
                            <div class="preview-thumbnail">
                              <div class="preview-icon bg-warning">
                                <i class="mdi mdi-chart-pie"></i>
                              </div>
                            </div>
                            <div class="preview-item-content d-sm-flex flex-grow">
                              <div class="flex-grow">
                                <h6 class="preview-subject">UI Design</h6>
                                <p class="text-muted mb-0">New application planning</p>
                              </div>
                              <div class="me-auto text-sm-right pt-2 pt-sm-0">
                                <p class="text-muted">50 minutes ago</p>
                                <p class="text-muted mb-0">27 tasks, 4 issues </p>
                              </div>
                            </div>
                          </div> -->
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
</div>