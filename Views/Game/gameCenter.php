<div id="play-bg" class="content-wrapper">
  <div class="row">
      <div class="col grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center map-bg rounded p-2"> 
                <div class="card-body text-center pos-bg rounded">
                    <h1 id="parcourName"></h1>
                    <p id="parcourDescription"></p>
                    <div class="d-flex justify-content-around">
                        <p>Next step : <span id="nextStep"></span></p>
                        <p>Start time : <span id="time"></span></p>
                    </div>
                </div>
                <div id="map">
                </div>
            </div>
        </div>
      </div>
  </div>
  <div class="row">
    <div class="text-center">
        <div class="col"><button type="button" class="btn btn-primary" id="valideStep" >Valide step</button></div>
    </div>
  </div>
  <div class="row">
      <div class="col grid-margin stretch-card">
        <div class="card">
            <div class="card-body text-center">
                <div class="text-center">
                    <h2 id="gametype"></h2>
                    <p id="gameproblem"></p>
                </div>
                <div class="text-center">
                    <p id="indice"></p>
                </div>
                <div class="text-center">
                    <!-- <h4>Indice</h4>
                    <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit.</p> -->
                </div>
                <div class="row gy-2" id="choices">
                    <!-- <div class="col"><button type="button" class="btn btn-primary">Choix 1</button></div>
                    <div class="col"><button type="button" class="btn btn-primary">Choix 2</button></div>
                    <div class="w-100"></div>
                    <div class="col"><button type="button" class="btn btn-primary">Choix 3</button></div>
                    <div class="col"><button type="button" class="btn btn-primary">Choix 4</button></div> -->
                </div>
            </div>
        </div>
      </div>
  </div>
  <div class="row">
        <div class="col grid-margin stretch-card">

            <div class="text-center">
            <div class="col"><button type="button" class="btn btn-danger" id="quitGame" >Quit</button></div>
            </div>
        </div>
  </div>
  <?php include './Views/footer.php';?>
</div>