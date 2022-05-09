import {RACINE} from '../settings/Settings.js';
let adress = document.getElementById("adress");
let longitude = document.getElementById("longitude");
let altitude = document.getElementById("latitude");
let msg = document.getElementById("msg");
let parcoursList = document.getElementById("parcours-list");
let activityList = document.getElementById("activity-list");
let gameButton = document.getElementById("add-activity");
let accessToken = 'pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw';
let markerList = [];
//Objet qui vas etre envoyé au serveur
let parcour = new Object();
parcour.positions = new Array();
let spotIndex;


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


map.on('click',function(e){
	let lat = e.latlng.lat;
	let lon = e.latlng.lng;

    fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${lon},${lat}.json?access_token=${accessToken}`)
    .then(res => res.json())
    .then(res => {
        const regex = /,( )+/gm;
        //Récupération des informations du ping
        //TODO Pour United kingdom et USA mettre le pays et l'etat exact. Voir avec features[0].context, pas constant.
        let placeName = res.features[0].place_name.split(",");
        let country = placeName.pop();
        let coordTab = [lat.toFixed(5),lon.toFixed(5)];
        let markerData = {
            "nomPo":placeName.toString(),
            "pays":country,
            "coord":coordTab,
            //TODO Remplir ce tableau de cette position dans cette objet, quand on ajoute des activités.
            "activity": []
        };
        markerList.push(markerData);
        //On ajoute les positions à l'objet
        parcour.positions = markerList;

        //Add a marker to show where you clicked.
        let index = parcour.positions.length-1;
        L.marker(coordTab).addTo(markerGroup).bindPopup(placeName + "<br>" + `spot n°${parcour.positions.length}`).on('click',(e)=>{displaySpotInfo(index)});
        displayMarkersList(parcour.positions);
        displaySpotInfo(index);
        displayAddGamesButton();
    })
});

const displaySpotInfo = (index) => { 
    spotIndex = index;
    let marker = parcour.positions[index];
    displayMarkerInfo(marker);
    map.setView(marker.coord, 13);
    if ($(".spot.bg-primary").length > 0) {$(".spot.bg-primary").toggleClass("bg-secondary").toggleClass("bg-primary");}
    $('.spot:eq('+index+')').toggleClass("bg-secondary").toggleClass("bg-primary");
    displayActivityList(parcour.positions[spotIndex].activity);
};

const displayMarkerInfo = (marker) => { // affiche dans la partie droite les infos du marker
    adress.innerHTML = marker.nomPo;
    altitude.innerHTML = marker.coord[0];
	longitude.innerHTML = marker.coord[1];
};

const removeMarker = (index) => { // permet d'enlever un marker quand on click dans la croix d'un élément d'une liste
    if (index == spotIndex) {spotIndex = -1;}
    parcoursList.removeChild(parcoursList.children[index]);
    if (parcour.positions[index].nomPo == adress.innerHTML)
    {
        adress.innerHTML = "";
        altitude.innerHTML = "";
        longitude.innerHTML = "";
    }
    parcour.positions.splice(index,1);
    markerGroup.clearLayers();
    lineGroup.clearLayers();
    for (let i = 0; i < markerList.length; i++)
    {
        //console.log(`index: ${i} | placeName: ${markerList[i].placeName}`);
        L.marker(parcour.positions[i].coord).addTo(markerGroup).bindPopup(parcour.positions[i].nomPo + "<br>" + `spot n°${i+1}`).on('click',(e)=>{displayMarkerInfo(parcour.positions[i])});;
        if (i > 0) {
            L.polyline([parcour.positions[i-1].coord,parcour.positions[i].coord], {color: 'red'}).addTo(lineGroup);
        }
        let spotElement = parcoursList.children[i];
        spotElement.firstElementChild.onclick = function() {displaySpotInfo(i)};
        spotElement.lastElementChild.onclick = function() {removeMarker(i)};
        spotElement.firstElementChild.firstElementChild.innerText = i+1;
    }
    console.log("===>"+JSON.stringify(parcour));
    displayAddGamesButton();
};


const displayMarkersList = (markerList) => {
    let index = parcour.positions.length-1;
    spotIndex = index;
    let div = document.createElement("div");
    div.className = "spot d-flex justify-content-between align-items-center bg-secondary rounded-3 mt-1 mb-1";
    div.innerHTML = `
        <div onclick="displaySpotInfo(${index})" class="d-flex justify-content-between w-100">
            <p class="font-weight-bold m-1">${index + 1}.</p>
            <p class="m-1">${parcour.positions[index].nomPo}   (${parcour.positions[index].pays})</p>
        </div>
        <button type="button" class="btn btn-danger text-center" onclick="removeMarker(${index})">X</button>
    `;
    parcoursList.appendChild(div);
    if (parcour.positions.length > 1) {
        L.polyline([parcour.positions[index-1].coord,parcour.positions[index].coord], {color: 'red'}).addTo(lineGroup);
    }
};

const search = document.getElementById('searchAdress');
search.addEventListener('keydown', function onEvent(event) {
    if (event.key === "Enter") {
		fetch(`https://api.mapbox.com/geocoding/v5/mapbox.places/${event.target.value}.json?access_token=${accessToken}`)
		.then(res => res.json())
		.then(res => {
			if (res.features.length > 0)
			{
				map.setView(res.features[0].center.reverse(), 13);
			}
		})
    }
});

const displayAddGamesButton = () => {
    gameButton.disabled = parcour.positions.length < 1;
};

$(document).on('click', '#create-parcours', function() { // close modal
    if(parcour.positions.length == 0){
        let retour  = confirm("Ajouter un parcour sans étapes n'est pas autorisé, voulez vous continuer la contruction de votre parcour ?");
        if(!retour) location.href = RACINE;
        return;
    }
    //On récupère le nom du parcour
    parcour.nomPa = document.querySelector("#parcourName").textContent;
    parcour.descriptionPa = document.querySelector("#parcourDescription").textContent;
    parcour.descriptionPa = parcour.descriptionPa.substr(0, 64000);
    let response = confirm("Etes vous sur de vouloir envoyer : "+ JSON.stringify(parcour));
    if(response){
        $.post(RACINE+"Parcour/Parcour_controller/createParcour","parcours="+JSON.stringify(parcour) , function(result){
            console.log(result);
            location.href = RACINE;
        });
    }
});