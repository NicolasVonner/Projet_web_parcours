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
    <!--<button id="open-modal">Open modal</button>-->
    <div id="modal" role="dialog" aria-modal="true" aria-labelledby="add-review-header" class="">
        <div class="float-end"><button id="close-modal" class="btn btn-light" aria-label="close" title="Close">X</button></div>
        <div id="review-form-container">
            <h2 id="add-review-header">Do you want to rate this parcours?</h2>
            <div class="fieldset">
                <label>Give us your rates</label>
                <div class="rate">
                    <input type="radio" id="star1" name="rate" value="1" />
                    <label for="star1" title="1 start">&#9733;</label>
                    <input type="radio" id="star2" name="rate" value="2" />
                    <label for="star2" title="2 starts">&#9733;</label>
                    <input type="radio" id="star3" name="rate" value="3" />
                    <label for="star3" title="3 starts">&#9733;</label>
                    <input type="radio" id="star4" name="rate" value="4" />
                    <label for="star4" title="4 starts">&#9733;</label>
                    <input type="radio" id="star5" name="rate" value="5" />
                    <label for="star5" title="5 starts">&#9733;</label>
                </div>
            </div>
            <div id="text-zone">
                <label for="commentaire">Leave a comment:</label>
                <textarea id="commentaire" name="commentaire"></textarea>
            </div>
            <div class="rate">
                <button id="send-rating" class="btn btn-warning m-1">Send ratings</button>
            </div>
            <p id="error-text"></p>
        </div>
    </div>
    <div class="modal-overlay"></div>
    <?php include './Views/footer.php';?>
</div>