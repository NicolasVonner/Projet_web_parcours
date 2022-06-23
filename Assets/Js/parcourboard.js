
//SEARCHBAR listener.
document.getElementById("searchbar").addEventListener("keyup", (e)=>{
    search_parcour(e.currentTarget.value) ;
})

//REDIMENTIONNEMENT du contenu des bouttons.
//Pour le démarrage de l'appli.
verifySize()
window.addEventListener('resize', verifySize); //todo faire pour activer / désactiver

//Functions

function search_parcour(value) {
    value=value.toLowerCase();
    let x =  document.getElementById('list');
    //console.log("Le nom du parcour dans cette enfant est =>"+x.children[0].getElementsByTagName('h6')[0].textContent);
    for (i = 0; i < x.children.length; i++) { 
        if (!x.children[i].getElementsByTagName('h6')[0].textContent.toLowerCase().includes(value)) {
            x.children[i].style.display="none";
        }
        else {
            x.children[i].style.display="flex";                 
        }
    }
}

function verifySize(){
    let x =  document.getElementById('list');
    if(window.innerWidth < 780){
        for (i = 0; i < x.children.length; i++) { 
            x.children[i].getElementsByTagName('button')[0].innerHTML = '<i class="mdi mdi-play btn-icon-prepend"></i>';
            x.children[i].getElementsByTagName('button')[1].innerHTML = '<i class="mdi mdi-crown btn-icon-prepend"></i>';
            if(x.children[i].getElementsByTagName('button')[2] != undefined){ //Si il y a un edit il y a un activate/desactivate.
                x.children[i].getElementsByTagName('button')[2].innerHTML = '<i class="mdi mdi-border-color btn-icon-prepend"></i>';
                let nature = x.children[i].getElementsByTagName('button')[3].textContent;
                if(nature == "Désactiver")
                    x.children[i].getElementsByTagName('button')[3].innerHTML = '<i class="mdi mdi-eye-off btn-icon-prepend"></i>';
                else 
                    x.children[i].getElementsByTagName('button')[3].innerHTML = '<i class="mdi mdi-eye btn-icon-prepend"></i>'; 
            }
        }
    }else{
        for (i = 0; i < x.children.length; i++) { 
            x.children[i].getElementsByTagName('button')[0].innerHTML = '<i class="mdi mdi-play btn-icon-prepend"></i>Jouer';
            x.children[i].getElementsByTagName('button')[1].innerHTML = '<i class="mdi mdi-crown btn-icon-prepend"></i>Rank';
           if(x.children[i].getElementsByTagName('button')[2] != undefined){
            x.children[i].getElementsByTagName('button')[2].innerHTML = '<i class="mdi mdi-border-color btn-icon-prepend"></i>Edit';
                let nature = x.children[i].getElementsByTagName('button')[3].textContent;
                if(nature == "Désactiver")
                    x.children[i].getElementsByTagName('button')[3].innerHTML = '<i class="mdi mdi-eye-off btn-icon-prepend"></i>Désactiver';
                else 
                    x.children[i].getElementsByTagName('button')[3].innerHTML = '<i class="mdi mdi-eye btn-icon-prepend"></i>Activer'; 
           }
        }
    }
}

//Les notes du parcourboard.
let p = document.getElementsByClassName('average-notes');
if(document.querySelector("div.average-notes") != undefined){
    document.querySelector("div.average-notes").addEventListener("mouseover", (e)=>{
        console.log("La note est :"+e.currentTarget.id); //TODO faire une info bulle.
    });
};
for (i = 0; i < p.length; i++)
{
    p[i].addEventListener('click', (e)=>{
        let codePa = e.currentTarget.id;
        // window.alert("ID====>"+codePa);
        sendParams(RACINE+'Review/Review_controller/displayReviewPage/', {codePa: codePa});
    });
}

let x =  document.getElementById('list');
for (i = 0; i < x.children.length; i++) { 
    //Le boutton play de chaque ligne du tableau de parcour.
    x.children[i].getElementsByTagName('button')[0].addEventListener('click', (e)=> {
        if(e.currentTarget.value == ""){//Si le non membre veux jouer à un parcour du board
            let singupInvit = confirm("Seul les membres peuvent lancer un parcour, voulez vous être rediriger vers le menu d'authentification?");
            singupInvit? location.href = RACINE+'Authentification/Authentification_controller/displaySignin' : false;
        }else{//Si le membre veux jouer à un parcour du board
                var codePa = "codePa_" + e.currentTarget.value;
                $.ajax({url: RACINE+'Game/Game_controller/verifyParcourStep/'+codePa, success: function(histo){
                    console.log("=====>"+histo);
                    if(histo == "non exist"){
                        alert("Aucun parcour ne correspond à votre hascode, veuillez réessayer");//todo afficher un message sur le formulaire.
                        inputHash.value = "";
                        return;
                    }else if(histo == false){
                        console.log("L'utilisateur doit commencer dès le début");
                        sendParams(RACINE+'Game/Game_controller/displayGame', {codePa: codePa})
                    }else{
                        var histoData = JSON.parse(histo); 
                        let response  = confirm("Une partie pour le parcour "+ histoData.nomPa +" datant du "+histoData.time+" est déjà en cour. Voulez vous reprendre à l'étape "+histoData.step+ " : " +histoData.nomPo);
                        if(response){
                            sendParams(RACINE+'Game/Game_controller/displayGame', {codePa: codePa, step: histoData.step})
                        }else{
                            sendParams(RACINE+'Game/Game_controller/displayGame', {codePa: codePa})
                        }
                    }
                }}); 
        }
    });
    //Le boutton Edit  et activate de chaque ligne du tableau de parcour.
    if(x.children[i].getElementsByTagName('button')[2] != null){
        x.children[i].getElementsByTagName('button')[2].addEventListener('click', (e)=>{
            let id = e.currentTarget.value;
            let editInvit = confirm("Êtes vous sur de vouloir modifier le parcour "+id+" ?");
            if(editInvit){  
                sendParams(RACINE+'Parcour/Parcour_controller/displayParcourCreatePage/', {idParcour: id});
            }
        });
        //Activate.
        x.children[i].getElementsByTagName('button')[3].addEventListener('click', (e)=>{
            let id = e.currentTarget.value;
            let nature = e.currentTarget.textContent;
            let confirmActiv;
            let elem = e.currentTarget;
            let flagactiv;
            let buttonPlacement = elem.id;
            console.log("Activ-Desactiv ==>"+nature +" Id ===>"+buttonPlacement);
            if(nature == "Désactiver"){
                confirmActiv = confirm("Êtes vous sur de vouloir désactiver le parcour "+id+" ?");
                flagactiv = 0;       
            }else{
                confirmActiv = confirm("Êtes vous sur de vouloir activer le parcour "+id+" ?");
                flagactiv = 1;
            }
            //Confirmation activation ou désactivation.
            if(confirmActiv){
                $.ajax({url: RACINE+'Parcour/Parcour_controller/disableParcour/',type: "post",
                data: {idParcour: id, flag: flagactiv }, success: function(resp, status){
                      if(flagactiv == 0){
                        $('.btn-outline-danger.'+id).removeClass('btn-outline-danger').addClass('btn-outline-success');
                        elem.innerHTML = "<i class='mdi mdi-eye btn-icon-prepend'></i>Activer";
                        x.children[buttonPlacement].getElementsByTagName('button')[0].disabled = true;
                      }else{
                        $('.btn-outline-success.'+id).addClass('btn-outline-danger').removeClass('btn-outline-success');
                        elem.innerHTML = "<i class='mdi mdi-eye-off btn-icon-prepend'></i>Désactiver";
                        x.children[buttonPlacement].getElementsByTagName('button')[0].disabled = false;
                      } 
             }});
            }else{
                return;
            } 
        });
    } 
    //Le boutton Rank de chaque ligne du tableau de parcour.
            x.children[i].getElementsByTagName('button')[1].addEventListener('click', (e)=>{
                let id = e.currentTarget.value;
                let editInvit = confirm("Êtes vous sur de vouloir consulter le classement du parcour "+id+" ?");
                if(editInvit){  
                    sendParams(RACINE+'Classement/Classement_controller/displayRankingPage/', {idParcour: id});
                }
            });    
}


function sendParams(path, parameters, method='post') {

    const form = document.createElement('form');
    form.method = method;
    form.action = path;
    document.body.appendChild(form);
  
    for (const key in parameters) {
        const formField = document.createElement('input');
        formField.type = 'hidden';
        formField.name = key;
        formField.value = parameters[key];
  
        form.appendChild(formField);
    }
    form.submit();
}