
//SEARCHBAR listener.
document.getElementById("searchbar").addEventListener("keyup", (e)=>{
    search_parcour(e.target.value) ;
})

//REDIMENTIONNEMENT du contenu des bouttons.
//Pour le démarrage de l'appli.
verifySize()
window.addEventListener('resize', verifySize);

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
            if(x.children[i].getElementsByTagName('button')[1] != undefined) x.children[i].getElementsByTagName('button')[1].innerHTML = '<i class="mdi mdi-border-color btn-icon-prepend"></i>';
        }
    }else{
        for (i = 0; i < x.children.length; i++) { 
            x.children[i].getElementsByTagName('button')[0].innerHTML = '<i class="mdi mdi-play btn-icon-prepend"></i>Jouer';
           if(x.children[i].getElementsByTagName('button')[1] != undefined) x.children[i].getElementsByTagName('button')[1].innerHTML = '<i class="mdi mdi-border-color btn-icon-prepend"></i>Edit';
        }
    }

}
let x =  document.getElementById('list');
for (i = 0; i < x.children.length; i++) { 
    //Le boutton PLay de chaque ligne du tableau de parcour.
    x.children[i].getElementsByTagName('button')[0].addEventListener('click', (e)=>{
        if(e.target.id == ""){//Si le non membre veux jouer à un parcour du board
            let singupInvit = confirm("Seul les membres peuvent lancer un parcour, voulez vous être rediriger vers le menu d'authentification?");
            singupInvit? location.href = RACINE+'Authentification/Authentification_controller/displaySignin' : false;
        }else{//Si le membre veux jouer à un parcour du board
                location.href = RACINE+'Game/Game_controller/launchParcourGame/'+e.target.id;
        }
    });
    //Le boutton Edit de chaque ligne du tableau de parcour.
    if(x.children[i].getElementsByTagName('button')[1] != null){
        x.children[i].getElementsByTagName('button')[1].addEventListener('click', (e)=>{
                let editInvit = confirm("Êtes vous sur de vouloir modifier le parcour "+e.target.id+" ?");
                // editInvit? location.href = RACINE+'Parcour/Parcour_controller/displayParcourCreatePage/'+e.target.id : false; //TODO
                if(editInvit){  
                    sendParams(RACINE+'Parcour/Parcour_controller/displayParcourCreatePage/', {idParcour: e.target.id})
                }
        });
    }    
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