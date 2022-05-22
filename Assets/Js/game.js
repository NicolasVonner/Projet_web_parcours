let mainPanel = document.getElementsByClassName("main-panel")[0];
let gametype = document.getElementById("gametype");
let gameproblem = document.getElementById("gameproblem");
let choices = document.getElementById("choices");
let indice = document.getElementById("indice");
let valideStep = document.getElementById("valideStep");


let accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
let gameObject = null;

//
let step = null;
let currentStep = null;
let actStep = null;

let spotCount = 0;
//geoloc();

let map = L.map('map').setView([51.505, -0.09], 13);
L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${accessToken}`, {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(map);
let markerGroup = L.layerGroup().addTo(map);
let lineGroup = L.layerGroup().addTo(map);

// function geoloc(){ // ou tout autre nom de fonction
//     var geoSuccess = function(position) { // Ceci s'exécutera si l'utilisateur accepte la géolocalisation
//         startPos = position;
//         userlat = startPos.coords.latitude;
//         userlon = startPos.coords.longitude;
//         console.log("lat: "+userlat+" - lon: "+userlon);
//     };
//     var geoFail = function(){ // Ceci s'exécutera si l'utilisateur refuse la géolocalisation
//         console.log("refus");
//     };
//     // La ligne ci-dessous cherche la position de l'utilisateur et déclenchera la demande d'accord
//     navigator.geolocation.getCurrentPosition(geoSuccess,geoFail);
// }

const displayGamePoints = () =>{
    let localStep = currentStep == null? step : currentStep;
    localStep ++;
    gameObject.positions.slice(0, localStep).forEach((element, index) => {
        let lat = element.coord[0];
        let lon = element.coord[1];
    
        fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lon},${lat}.json?access_token=${accessToken}`)
        .then(res => res.json())
        .then(res => {
            const regex = /,( )+/gm;
            // var myIcon = L.icon({
            //     iconUrl: iconBase + "autres.png",
            //     iconSize: [50, 50],
            //     iconAnchor: [25, 50],
            //     popupAnchor: [-3, -76],
            // });
            if(currentStep != null){
                L.marker(element.coord).addTo(markerGroup).bindPopup(element.nomPo + "<br>" + `spot n°${step + spotCount}`).on('click',(e)=>{displaySpotInfo(index)});
            displaySpotInfo(index);
                spotCount ++;
            }else{
                L.marker(element.coord).addTo(markerGroup).bindPopup(element.nomPo + "<br>" + `spot n°${index+1}`).on('click',(e)=>{displaySpotInfo(index)});
                displaySpotInfo(index);
            }    
        })
        if (index > 0 && index == localStep - 1) {
            L.polyline([gameObject.positions[index-1].coord,gameObject.positions[index].coord], {color: 'orange'}).addTo(lineGroup);
        }else if(index > 0){
            L.polyline([gameObject.positions[index-1].coord,gameObject.positions[index].coord], {color: 'green'}).addTo(lineGroup);
        }
    });
};
    
    //todo vérifier si la reponse à l'activité est ok, si oui afficher message et suite si non afficher alert et toz.
    //todo verifier si il y a une autre acitivite, afficher -> appeler la methode d'affichage de la prochaine activité (creer methode).
    //todo si c'est ok, insérer dans historique activité et parcour.
    //todo incrémenter la session['game'] en ajax et le surrent step.
    //todo appeler displayGamePoints.

const openGamePoints = () =>{
    //if(joueur est sur le point){}
    //Si il n'y à pas d'activité sur la position on passe au point d'aprés. //todo fonction à appeler sur listener click d'arrivé ou géolocalisation.
    if(actStep == null){
        validGamePoints();
    }else{
        displayActivity();
    }
};

//L'utilisateur valide 
valideStep.addEventListener("click", (e)=>{
    openGamePoints();
});

//On affiche la prochaine activité.
const displayActivity = () => { 
    //Element qui vas populer le front.
    let out  = [];
    //Compteur pour l'affichage d'un séparateur.
    let countSparator = 0;
    //On récupère notre index en fonction de si on est sur un début de game normal ou une reprise.
    let localStep = currentStep == null? step : currentStep;

    //On affiche l'activité avec l'index que l'on à sauvegardé.
        gametype.textContent = gameObject.positions[localStep].activites[actStep].nomAc; 
        gameproblem.textContent = gameObject.positions[localStep].activites[actStep].devinette; //todo stocker le numéro de l'activité dans une session ? 
        //On crée les bouttons de réponse en fonction du nombre de choix.
        for(var key in  gameObject.positions[localStep].activites[actStep]){
            //On récupère l'élément, on veux afficher que les 'choix_...'.
                let element =  gameObject.positions[localStep].activites[actStep][key];
            if(key.split('_').length > 1 && key.split('_')[0] == "choix"){
                //On met un séparateur tout les deux bouttons.
                if(countSparator == 2){
                    out += '<div class="w-100"></div>';
                }
                if(element != null && element != ""){
                    out += '<div class="col"><button type="button" class="btn btn-primary" value="'+element+'">'+element+'</button></div>';
                    countSparator ++;
                }
            }   
        };
        //On inject le html et ajoute les listeners sur chaque composants.
        if(out.length >1){
            choices.innerHTML = out;
            activListenerActivity(localStep);
        }
};

//On vide l'espace d'affichage de enigmes.
const cleanActivityZone = () => { 
    choices.innerHTML = "";
    indice.textContent = "";
    gametype.textContent = "";
    gameproblem.textContent = "";
}

//On active les listeners sur les boutons de réponse.
const activListenerActivity = (localStep) => { 
            document.querySelectorAll('#choices .btn').forEach(item => {
                item.addEventListener('click', event => {
                  console.log("L'utilisateur viens d'envoyer une reponse =>"+event.target.value);
                  if(verifyActivity(event.target.value)){
                    if(gameObject.positions[localStep].activites[actStep + 1] != undefined){
                        alert("Bravo, vous avez trouvé, passez à l'activité suivante"); //todo la on passe à la prochaine activité ou on valide.
                        //On incrémente actStep et on rappel la fonciton d'affichage
                        actStep ++;
                        displayActivity();
                        return;
                    }else{
                        actStep = null;
                        //On vide l'espace d'affichage de enigmes.
                        cleanActivityZone();
                        alert("Pallié suivant débloqué, enjoy !!! ");
                        validGamePoints();
                    }
                  }else{//Si l'utilisateur donne une mauvaise réponse.
                    //On vérifie si il y a déja un indice qui est affiché.
                    if(indice.textContent == ""){
                        let resultIndice =  confirm("Mauvaise réponse, voulez vous un petit indice ?");
                        if(resultIndice){
                           indice.textContent = 'Indice : '+gameObject.positions[localStep].activites[actStep].indice;
                        }
                    }else{
                        alert("Mauvais reponse, réessayez");
                    }
                  }
                })
            });
}

//On vérifie si la réponse de l'utilisateur correspond avec la bonne réponse de l'activité.
const verifyActivity = (response) => {
    //Todo on enregistre la réponse dans la bdd historique_activ en ajax. 
    let localStep = currentStep == null? step : currentStep;
    let rep = gameObject.positions[localStep].activites[actStep].reponse;
    return rep == response? true:false;
};


//On valide le point, vérifie si c'est la fin de parcour ou affiche le prochain point.
const validGamePoints = () =>{
    step ++;
    
    //On récupère l'index de parcour.
    let localStep = currentStep == null? step : currentStep;

    //On construit l'objet à envoyer à historique parcour.
    let game = new Object();
    game.step = step;
    game.parcour = gameObject.codePa;
    game.position = currentStep == null? gameObject.positions[localStep-1].codePo:gameObject.positions[localStep].codePo;
        //On ajoute le step à historique parcour et incremente la session de jeu.
        $.post(RACINE+'Game/Game_controller/incrementStepSession',"gameStep="+JSON.stringify(game) , function(result){
            console.log("Le step courant à été incrémenté : " + result);
        }).then(res => { //On implémente la vue et initialise le step activité.
            //On vérifie si on à gagné
            //SI on est en debut de partie on verifie si step + 1 
            if(currentStep == null){
                if(localStep == gameObject.positions.length){
                    alert("C'est la fin du parcour, bien joué, vous allez être redirigé vers l'acceuil");//todo Système de note parcour.
                    location.href = RACINE;
                    return;
                }
                actStep = gameObject.positions[step].activites.length != 0? 0 : null;//Si on est sur un début de game.
                document.querySelector("#nextStep").textContent = step  == gameObject.positions.length? "Arrivée" : step; 
                console.log("===>On est sur un debut de game classique avec Step =>"+step);

            }else{// if(currentStep != null)
                if(localStep+1 == gameObject.positions.length){
                    alert("C'est la fin du parcour, bien joué, vous allez être redirigé vers l'acceuil");//todo Système de note parcour.
                    location.href = RACINE;
                    return;
                }
                currentStep ++;
                actStep = gameObject.positions[currentStep].activites.length != 0? 0 : null; //Si on est sur un reprise et que la partie continue.
                document.querySelector("#nextStep").textContent = currentStep + 1 == gameObject.positions.length? "Arrivée" : currentStep;
            }
            displayGamePoints();
        });
        delete(game);
};

const displaySpotInfo = (index) => { 
    let marker = gameObject.positions[index];
    // displayMarkerInfo(marker);
    map.setView(marker.coord, 13);
    if ($(".spot.bg-primary").length > 0) {$(".spot.bg-primary").toggleClass("bg-secondary").toggleClass("bg-primary");}
    $('.spot:eq('+index+')').toggleClass("bg-secondary").toggleClass("bg-primary");
};

    //On contruit le jeu 
    if(mainPanel.id !== ""){

        let idGame = mainPanel.id;
        let hash = null;
        let codePa = null;
        let typeId = idGame.split('_')[0];
        let valueId = idGame.split('_')[1];
        let id = null;

        //On récupère le code Parcour ou le code hash qui à mené au jeu.
        if(typeId == 'codePa'){
            codePa = typeId+'_'+valueId;
            id = codePa;
        }else{
            hash = typeId+'_'+valueId;
            id = hash;
        }

        //On récupère le step si c'est une reprise de parcour, ceci est la vraie étape selon tout le parcour mais nous recevons que le bout qui nous interesse.
        step = idGame.split('_')[2] != undefined? parseInt(idGame.split('_')[2], 10) : null;

        //todo amener les anciens points pour les afficher.
        //Si on commence dés le début, le step est égal à 1 car c'est le step 1.
        if(step == null){
                $.ajax({url: RACINE+'Game/Game_controller/buildGameObject/'+id, async: false, success: function(value){
                    gameObject = JSON.parse(value);     
                }})
                //Si c'est nul on est au premier step.
                step = 0;
        }else{//Si on commence à une position précise, le step à la valeur de la position a partie de laquelle on repart. Nous n'avons pas les positions avant celle-ci.
            $.ajax({url: RACINE+'Game/Game_controller/buildGameObject/'+id+'/'+step, async: false, success: function(value){
                gameObject = JSON.parse(value);       
            }});           
            //Si on commence une nouvelle partie, on est au step 1 (0 pour incrémentation et possible première activité).
            //Si on est en reprise de partie, step est le vrai step général du parcour et currentApp est un step interne pour suivre la lecture, du morceau d'information que l'on reçois.
            currentStep = 1;
        }

        console.log("On à récupéré la game dans => "+JSON.stringify(gameObject));
        console.log("On est au step ==>"+step);

        //On implémente la vue pour le démarrage du jeu.  

        var today = new Date();
        var time = today.getHours() + ":" + today.getMinutes() + ":" + today.getSeconds();
        if(currentStep == null){ //Si c'est un début de partie normal.
            document.querySelector("#nextStep").textContent = step + 1 == gameObject.positions.length? "Arrivée" : "Départ"; 
        }else{//si c'est une reprise de partie, on se base sur la taille du morceau de tableau que l'on reçois.
            document.querySelector("#nextStep").textContent = currentStep + 1 == gameObject.positions.length? "Arrivée" : step + 1; 
        } 
        document.querySelector("#time").textContent = time;
        document.querySelector("#parcourName").textContent = gameObject.nomPa;
        document.querySelector("#parcourDescription").textContent = gameObject.descriptionPa;

        displayGamePoints();

        //Les activités

        //Si c'est un début de partie, il peut y avoir le premier step à valider, on regarde si il y à une activité à lancer, car nous sommes normalement déjà à la position de départ.
        if(step == 0 && gameObject.positions[step].activites.length != 0){//Si il y à une activité on la lance.
            //On récupère en globale l'index de l'activité à afficher.
            actStep = 0;
            displayActivity();
        }else if(step == 0 && gameObject.positions[step].activites.length == 0){
            validGamePoints()
        }else{
            //On récupère l'indice activité de la prochaine game pour la reprise.
            if(gameObject.positions[currentStep].activites.length != 0){
                //On récupère en globale l'index de l'activité à afficher.
                actStep = 0;
            }

        }
        //actStep = gameObject.positions[currentStep].activites.length > 1?1:null;//todo normalement c'est géré avec la bdd pour l'instant c'est comme ça.
        //Si c'est le départ on lance le jeux du départ durectement, si non on à déja validé le jeu du step 
    }

    //TODO On enregistre la session pour dernier step mais quand on reprend, c'est la merde, pas possible de reprendre dernier step.
    //TODO Afficher les parcour d'avant et pas que les n derniers?
    //TODO quand c'est le dernier ne pas enregistrer

//TODO pour les Reprise prendre le tuple avec la date la plus vieille.