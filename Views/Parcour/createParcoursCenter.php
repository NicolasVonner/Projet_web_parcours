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
                    <p contenteditable="true" id="parcourDescription">Lorem ipsum dolor sit amet, consectetur adipiscing elit. Praesent accumsan urna a hendrerit sagittis. Curabitur ultricies mi ac leo varius scelerisque. Aliquam vel lectus et nulla mattis efficitur in sit amet justo. Nunc sit amet nunc vitae massa aliquam dictum. Nulla eget nisl quis ligula consectetur accumsan in non nibh. Nunc egestas tellus sit amet quam pharetra, at sagittis ligula faucibus. Nulla tristique, sem vitae lacinia accumsan, erat eros sagittis erat, eget pellentesque elit justo at enim. Nam euismod odio at dui interdum, vel condimentum leo viverra. Pellentesque commodo lobortis orci non suscipit. Ut ac metus id libero sollicitudin commodo non at orci. Cras sapien odio, feugiat ac vestibulum sed, commodo non turpis. Integer consequat cursus convallis. Aliquam eget pharetra mauris, non sodales magna. Phasellus feugiat erat vitae pretium fringilla. Sed dignissim arcu urna, vitae sollicitudin ex lacinia nec. Sed vel tortor nec lectus ultrices rutrum.</p>
                  </div>
                </div>
              </div>
            </div>
            <div class="row">
              <div class="col grid-margin stretch-card">
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
              <div class="col grid-margin stretch-card">
                <div class="card edit-box">
                  <div class="card-body text-center">
                    <h1>Data of the point</h1>
                    <p id="adress"></p>
                    <div class="d-flex justify-content-between">
                      <p>Latitude: <span id="latitude"></span></p>
                      <p>Longitude: <span id="longitude"></span></p>
                    </div>
                    <div class="d-flex justify-content-center">
                      <button id="add-activity" type="button" class="btn btn-success text-center" disabled>+ Add Activity</button>
                      <div id="myModal" class="modalConfig">
                        <!-- Modal content -->
                        <div class="modalConfig-content">
                          <div class="modalConfig-header text-center">
                            <div class="closeModal d-flex justify-content-end"><button type="button" class="btn btn-outline-secondary btn-sm">X</button></div>
                            <h2>Add new Activity</h2>
                            <div class="dropdown">
                              <button class="btn btn-outline-white dropdown-toggle" type="button" id="select-activity" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false"> Activities </button>
                              <div id="activity-choice" class="dropdown-menu" aria-labelledby="dropdownMenuButton1"></div>
                            </div>
                          </div>
                          <div class="modalConfig-body text-center">
                            <div class="container">
                              <form class="row forms-sample"></form>
                            </div>
                          </div>
                          <div class="text-center">
                            <button id="create-activity" type="button" onclick="sendActivityData()" class="closeModal btn btn-primary btn-fw m-1">Create</button>
                          </div>
                        </div> 
                      </div>
                    </div>
                    <div class="row">
                      <div class="col grid-margin stretch-card d-flex justify-content-center">
                        <div class="card-body text-center">
                          <h1 contenteditable="true">Activity List</h1>
                          <div id="activity-list" class="list-group">
      
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
                    <h1 contenteditable="true">Spots List</h1>
                    <div id="parcours-list" class="list-group"></div>
                  </div>
                </div>
              </div>
            </div>
            <div class="text-center">
              <button id="create-parcours" type="button" class="btn btn-primary text-center">Finish</button>
            </div>
            <?php include './Views/footer.php';?>
</div>