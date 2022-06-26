<div class="content-wrapper">
            <!-- Map -->
            <div class="row">
              <div class="col grid-margin stretch-card">
                <div class="card">
                  <?php echo isset($editId)?'<div>
                                              <button id="delete-parcours" type="button" class="btn btn-outline-danger">Supprimer</button>
                                            </div>':"";
                  ?>
                  <div class="card-body text-center">
                    <h1 contenteditable="true" id="parcourName">Nom du parcours</h1>
                    <p contenteditable="true" id="parcourDescription">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent accumsan urna a hendrerit sagittis.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col-12 col-sm-7 col-lg-7 grid-margin">
                <div class="card edit-box">
                  <div class="card-body">
                    <div class="input-group mb-3">
                      <input id="searchAdress" type="text" class="form-control" aria-label="Default" placeholder="City" aria-describedby="inputGroup-sizing-default">
                    </div>
                    <div id="map">
                    </div>
                  </div>
                </div>
              </div>
              <div class="col-12 col-sm-5 col-lg-5 grid-margin">
                <div class="card edit-box">
                  <div class="card-body text-center">
                    <h2>Infos de l'étape</h2>
                    <p id="adress"></p>
                    <div class="d-flex justify-content-between">
                      <p>Latitude: <span id="latitude"></span></p>
                      <p>Longitude: <span id="longitude"></span></p>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button id="add-activity" type="button" class="btn btn-success text-center" disabled>+ Ajout activité</button>
                      <div id="myModal" class="modalConfig">
                        <!-- Modal content -->
                        <div class="modalConfig-content">
                          <div class="modalConfig-header text-center">
                            <div class="closeModal d-flex justify-content-end"><button type="button" class="btn btn-outline-secondary btn-sm">X</button></div>
                            <h2>Ajouter une activité</h2>
                            <div class="dropdown">
                              <button class="btn btn-outline-white dropdown-toggle" type="button" id="select-activity" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Activités </button>
                              <div id="activity-choice" class="dropdown-menu" aria-labelledby="dropdownMenuButton1"></div>
                            </div>
                          </div>
                          <div class="modalConfig-body text-center">
                            <div class="container">
                              <form class="row forms-sample"></form>
                            </div>
                          </div>
                          <div class="text-center">
                            <button id="create-activity" type="button" class="closeModal btn btn-primary btn-fw m-1">Créer</button>
                          </div>
                        </div> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col grid-margin stretch-card d-flex justify-content-center">
                        <div class="card-body text-center">
                          <h3>Liste d'activités</h3>
                          <div class = "row">
                              <!-- <div class="col-12" style="margin-bottom: 0; overflow: auto; height: 200px;"></div> -->
                              <div id="activity-list" class=" col-12 list-group"></div>
                          </div>
                        </div>
                      </div>
                    </div>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col grid-margin stretch-card">
                <div class="card">
                  <div class="card-body text-center">
                    <h2>Les étapes</h2>
                    <div id="parcours-list" class="list-group"></div>
                  </div>
                </div>
              </div>
            </div>
            <!-- <div class="row">
<div class="col grid-margin stretch-card">
                <div class="card">
            <div class="card-body text-center">
    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<div  class="chart-container" style="position: relative; height:40vh; width:80vw">
  <canvas id="pie-chart"  ></canvas>
</div>
</div>
</div>
</div>
</div> -->
            <div class="text-center">
              <button id="create-parcours" type="button" class="btn btn-primary text-center">Finish</button>
            </div>
            <?php include './Views/footer.php';?>
</div>
