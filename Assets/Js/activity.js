let addActivityButton = document.getElementById("add-activity");
// import {RACINE} from '../settings/Settings.js';
let inputType = new Map([
    ['varchar', 'text'],
    ['int', 'number'],
]);
let configData;

$.ajax({url: RACINE+"Parcour/Parcour_controller/buildListActivity", success: function(gamedetails){
    configData = JSON.parse(gamedetails);
    configData.forEach((activity)=>{
        $('<a>', {
            text: activity.nomAc,
            class: "dropdown-item",
            click: function() {openConfig({props : activity.attibuts, nomAc: activity.nomAc},true)}
        }).appendTo("#activity-choice");
    });
}});

//On affiche la fenêtre 
$(document).on('click', '#add-activity', function() { // show modal
    $("#myModal").css("display", "block");
    $("html").css("overflow","hidden");
    $("#select-activity").html(" Activities ");
    $("#select-activity").prop("disabled",false);
    $("form").empty();
    $("#create-activity").show();
    $("#create-activity").html("Create");
    $('#create-activity').attr("onclick",`sendActivityData()`);
    $("#create-activity").prop("disabled",true);
});

const viewActivity = (actIndex) => {
    $("#myModal").css("display", "block");
    $("html").css("overflow","hidden");
    $("#select-activity").prop("disabled",true);
    openConfig({props :parcour.positions[spotIndex].activites[actIndex], nomAc: parcour.positions[spotIndex].activites[actIndex].nomAc},false);
    $("#create-activity").hide();
};

const editActivity = (actIndex) => {
    $("#myModal").css("display", "block");
    $("html").css("overflow","hidden");
    $("#select-activity").prop("disabled",false);
    openConfig({props : parcour.positions[spotIndex].activites[actIndex], nomAc: parcour.positions[spotIndex].activites[actIndex].nomAc},true);
    $("#create-activity").show();
    $("#create-activity").html("Edit");
    $('#create-activity').attr("onclick",'sendActivityData(\''+parcour.positions[spotIndex].activites[actIndex].id+'\')');
    $("#create-activity").prop("disabled",false);
};

$(document).on('click', '.closeModal', function() { // close modal
    $("#myModal").css("display", "none");
    $("html").css("overflow","auto");
});

const getInputType = (type) => {
    for (const [typeDB, value] of inputType.entries()) {
        if (type.includes(typeDB))
            return inputType.get(typeDB);
    }
};

const listenActivForm = (prop) =>{
    //todo mettre un listener sur les inputs, faire la vérification coté back.

    document.getElementById(prop).addEventListener('keyup', (e) => {
        let devinette = document.getElementById('devinette');
        let response = document.getElementById('reponse');
        let indice = document.getElementById('indice');
        let choix_1 = document.getElementById('choix_1');
        let choix_2 = document.getElementById('choix_2');
        let choix_3 = document.getElementById('choix_3');
        let choix_4 = document.getElementById('choix_4');
        let submit = document.getElementById('create-activity'); //TODO ...............
        //On vérifie si on peux débloquer le create
        if(devinette.value != "" && response.value != ""){
            console.log("On est dans le premier step");
                if(choix_1.value === response.value ||
                    choix_2.value === response.value ||
                    choix_3.value === response.value ||
                    choix_4.value === response.value){
                        console.log("On est dans le deuxieme step");
                        if(choix_1.value != "" &&  choix_2.value!= "" || 
                        choix_1.value != "" &&  choix_3.value!= "" ||
                        choix_1.value != "" &&  choix_4.value!= "" ||
                        choix_2.value != "" &&  choix_3.value!= "" ||
                        choix_2.value != "" &&  choix_4.value!= "" ||
                        choix_3.value != "" &&  choix_4.value!= ""){
                            submit.disabled = false;
                        }else {
                            submit.disabled = true; 
                        }
                }else{
                    submit.disabled = true; 
                }
        }else{
            submit.disabled = true; 
        }
        
    });
};

const openConfig = (activity, canEdit) => {
    let params = new Array();
    let values = new Array();

    $("#select-activity").html(activity.nomAc);//TODO ajouter le nomAc plus tôt !!!
    $("#submit-activity").prop("disabled",false);
    $('form').empty();

    params = !isNaN(Object.keys(activity.props)[0])? activity.props : Object.keys(activity.props);
    values = !isNaN(Object.keys(activity.props)[0])? null : Object.values(activity.props);

    //On crée les inputs selon le nombre de paramètres du jeu.
    if (!params.includes("id")){
        params.forEach((prop)=>{
            if(prop !== 'id' && prop !== 'nomAc') {
                $('form').append(`
                    <div class="form-group col-sm-6">
                        <label for="${prop}">${prop}</label>
                        <input type="text" class="form-control" id="${prop}" placeholder="${prop}" ${canEdit ? "" : "readonly"}>
                    </div>
                `);
                //On écoutes les changements du formulaire.
                listenActivForm(prop);
            }
        });
    }else{
        params.forEach((prop, index)=>{
            if(prop !== 'id' && prop !== 'nomAc') {
                $('form').append(`
                    <div class="form-group col-sm-6">
                        <label for="${prop}">${prop}</label>
                        <input type="text" value="${values[index]}" class="form-control" id="${prop}" placeholder="${prop}" ${canEdit ? "" : "readonly"}>
                    </div>
                `);
            //On écoutes les changements du formulaire.
            listenActivForm(prop);
            }

        });
    } 
};

const sendActivityData = (id) => {

    //On récupère l'id sous la bonne forme
    id = isNaN(parseInt(id))?id:parseInt(id);    
    gameFieldInfo= new Object();
    gameFieldInfo.nomAc = $("#select-activity").text();
    $("form").find(':input').toArray().map((input)=>{
        gameFieldInfo[input.id] = input.value;
    });
    console.log("Les valeurs d'input sont ( SendActivityData() ) =>"+JSON.stringify(gameFieldInfo));
    
    // //Vérification de l'existance d'une vraie réponse -> useless car nouvelle fonctionnalité
    // let response = gameFieldInfo["reponse"];
    // let flagResp = false;
    // let allFilled = Object.keys(gameFieldInfo).forEach((key) => {
    //     console.log("La clefs est =>"+key+ "La valeur est =>"+gameFieldInfo[key]);
    //     let splitKey = key.split('_');
    //     if(splitKey.length == 2 && splitKey[0] == "choix"){
    //         if(gameFieldInfo[key] == response){
    //             flagResp = true;
    //         }
    //     }
    // });

    // //Si le user n'as pas entré de solution possible.
    // if(!flagResp){
    //     alert("Aucuns choix ne correpond à la réponse saisie");
    //     return;
    // }

    //console.log("====>gameFieldInfo"+JSON.stringify(gameFieldInfo));
    allFilled = true;

    if (allFilled) {
        let currentSpotIndex = parcour.positions.findIndex((element)=>element.nomPo === adress.innerText);
        if (currentSpotIndex != -1)
        {
            if (id !== undefined) // si le paramètre id existe bel et bien alors on modifie l'activité.
            {

                console.log("C'est une modification de l'activité "+ id +" de la position => "+currentSpotIndex);
                let currentActivityIndex = parcour.positions[currentSpotIndex].activites.findIndex((activity)=>activity.id == id);
                gameFieldInfo.id = id;//todo ->le but ?
                parcour.positions[currentSpotIndex].activites[currentActivityIndex] = gameFieldInfo;
            }
            else
            {
                gameFieldInfo.id = "p_"+Math.floor(Math.random() * 100000).toString();
                console.log("ID test===>"+gameFieldInfo.id);
                parcour.positions[currentSpotIndex].activites.push(gameFieldInfo);
            }
            displayActivityList(parcour.positions[currentSpotIndex].activites);
            $("form").find("input[type=text], textarea").val("");
        }
    }
    else
    {
        console.log("Il y à des champs vide, vous voulez que je m'énerve c'est ça ?");
    }
    delete(gameFieldInfo);
};

const removeActivity = (index) => {
    let codePoDel = parcour.positions[spotIndex].codePo != null? parcour.positions[spotIndex].codePo : null;
    let codeActDel = null;
    //On vérifie qu'on souhaite supprimer une activité déjà dans la base.
   if(parcour.positions[spotIndex].activites[index].id != null && String(parcour.positions[spotIndex].activites[index].id).split("")[0] !== "p"){
        codeActDel =  parcour.positions[spotIndex].activites[index].id;
   } 

    if(codePoDel != null && codeActDel!= null){
        if(parcour.rem != undefined){
            let flag = false;
            parcour.rem.forEach((element)=>{
                if(element.codePo == codePoDel){
                    let act = new Object();
                    act.id = codeActDel;
                    act.nomAc = parcour.positions[spotIndex].activites[index].nomAc;
                    element.activites.push(act);
                    flag = true;
                }
            });
            if(!flag){
                //Si l'objet n'existe pas 
                let parc = new Object();               
                let act = new Object();
                parc.codePo = codePoDel;
                parc.delete = false;
                parc.activites = new Array();
                act.id = codeActDel;
                act.nomAc = parcour.positions[spotIndex].activites[index].nomAc;
                parc.activites.push(act);
                parcour.rem.push(parc);
            }
        }else{
                 //Si l'objet n'existe pas 
                 let parc = new Object();
                 let act = new Object();
                 parc.codePo = codePoDel;
                 parc.delete = false;
                 parc.activites = new Array();
                 act.id = codeActDel;
                 act.nomAc = parcour.positions[spotIndex].activites[index].nomAc;
                 parc.activites.push(act);
                 parcour.rem = new Array();
                 parcour.rem.push(parc);
        }
    }

    activityList.removeChild(activityList.children[index]);
    parcour.positions[spotIndex].activites.splice(index,1);
    for (let i = 0; i < parcour.positions[spotIndex].activites.length; i++)
    {
        let activityElement = activityList.children[i];
        console.log(activityElement);
        activityElement.firstElementChild.onclick = function() {viewActivity(i)};
        activityElement.lastElementChild.firstElementChild.onclick = function() {editActivity(i)};
        activityElement.lastElementChild.lastElementChild.onclick = function() {removeActivity(i)};
        activityElement.firstElementChild.firstElementChild.innerText = i+1;
    }
    displayAddGamesButton();
};

const displayActivityList = (actList) => { // affiche les activités dans la page <p class="m-1">${actList[i].nomAc} - ${actList[i].id}</p>
    console.log("On souhaite afficher la liste des activités de la position => Et c'est ======>"+JSON.stringify(actList));
    //On vérifie si il y à déja trop d'activité sur l'étape
    verifyActivSize(actList.length);
    activityList.innerHTML = "";
    for (let i = 0; i < actList.length; i++)
    {
        let div = document.createElement("div");
        div.className = "activity d-flex justify-content-between align-items-center bg-secondary rounded-3 mt-1 mb-1";
        div.innerHTML = `
            <div class="d-flex justify-content-between w-100 h-100" onclick="viewActivity(${i})">
                <p class="font-weight-bold m-1">${i + 1}.</p>
                <p class="m-1">${actList[i].nomAc}</p>
            </div>
            <div class="d-flex justify-content-center h-100">
                <button type="button" class="btn btn-warning text-center" onclick="editActivity(${i})"><i class="mdi mdi-border-color m-0"></i></button>
                <button type="button" class="btn btn-danger text-center" onclick="removeActivity(${i})"><i class="mdi mdi-delete m-0"></i></button>
            </div>
        `;
        activityList.appendChild(div);
    }
};

//On vérifie si il n'y à pas déjà trop d'activités pour une étape
const verifyActivSize = (size) => {
    console.log("SALUT lES GARS"+size);
if(size >= 4){
    addActivityButton.disabled = true;
}else{
    addActivityButton.disabled = false;
}


};