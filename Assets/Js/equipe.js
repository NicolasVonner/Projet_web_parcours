let avatars = document.getElementsByClassName("avatar");
for(element of avatars){
    element.addEventListener("mouseover",(e)=>{
        e.target.style.borderColor = BORDER_FOCUS;
    })
    element.addEventListener("mouseout",(e)=>{
        e.target.style.borderColor = BORDER_BASE;
    })
    element.addEventListener("click",(e)=>{
        document.getElementById("avatar-preview").src = e.target.src;
        document.getElementById("form-avatar").value = e.target.src.split('/')[6];
    })
}


$(document).on('click', '.exclude-utilisateur', function(e) {
    let response  = confirm("Etes vous sur de bien vouloir  exclure  cette utilisateur de votre équipe ? Votre score baissera car tous les point associé a ce joueurs seront retirer de votre équipe");
    if(response)
        sendExclude(RACINE+'Equipe/Equipe_controller/removeUserToEquipe/', {idDeleteMembre: e.target.value})
        
});

$(document).on('click', '#delete-equipe', function(e) {
    let response  = confirm("Etes vous sur de bien vouloir  suprimer votre équipe  tous les données associé a cette équipe seront suprimer de manière définitive");
    if(response)
        sendExclude(RACINE+'Equipe/Equipe_controller/deleteEquipe/', {idDeleteEquipe: e.target.value})
        
});

$(document).on('click', '.ajouter-membre', function(e) {
    console.log("on a cliquer"+e.target.value);
    let response  = confirm("Etes vous sur de bien vouloir ajouter cette personne a votre équipe il recevra une notificaiton par email");
    if(response){
        data=e.target.value.split("|");
        sendExclude(RACINE+'Equipe/Equipe_controller/addUserToEquipe/', {idUtilisateur:data[0], idEquipe: data[1]})
    }
       
        
});


//traiment des données
//envoi des donnée user
function sendExclude(path, parameters, method='post') {

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


document.getElementById("searchbar").addEventListener("keyup", (e)=>{
    
    search_user(e.currentTarget.value) ;
})

function search_user(value) {
    value=value.toLowerCase();
    let x =  document.getElementById('list');
    console.log("fuck");
    console.log(x);
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
