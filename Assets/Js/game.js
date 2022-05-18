let accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';

let map = L.map('map').setView([51.505, -0.09], 13);
L.tileLayer(`https://api.mapbox.com/styles/v1/{id}/tiles/{z}/{x}/{y}?access_token=${accessToken}`, {
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/copyright">OpenStreetMap</a> contributors, Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    maxZoom: 18,
    id: 'mapbox/streets-v11',
    tileSize: 512,
    zoomOffset: -1,
    accessToken: 'your.mapbox.access.token'
}).addTo(map);

let mainPanel = document.getElementsByClassName("main-panel")[0];
if(mainPanel.id !== ""){
    let gameObject = null;
    let idGame = mainPanel.id;
    let hash = null;
    let codePa = null;
    let typeId = idGame.split('_')[0];
    let valueId = idGame.split('_')[1];
    let id = null;
    if(typeId == 'codePa'){
        codePa = typeId+'_'+valueId;
        id = codePa;
    }else{
        hash = typeId+'_'+valueId;
        id = hash;
    }
    //On récupère le step
    let step = idGame.split('_')[2] != undefined?idGame.split('_')[2] : null;
    if(step == null){
            $.ajax({url: RACINE+'Game/Game_controller/buildGameObject/'+id, async: false, success: function(value){
                gameObject = JSON.parse(value);     
            }})
    }else{
        $.ajax({url: RACINE+'Game/Game_controller/buildGameObject/'+id+'/'+step, async: false, success: function(value){
            gameObject = JSON.parse(value);       
        }});
    }
    console.log("On à récupéré la game dans => "+JSON.stringify(gameObject)); 
    //TODO C'EST ICI QUI A L'OBJET QUI CONTIENT LES INFOS DE LA GAME => gameObject (oui juste au dessus la )
    //TODO REGARDER DANS MODIFIER POUR LA MAP, PAREIL
}
