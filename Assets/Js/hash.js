let searchHashButton = document.getElementById("searchHash"); //todo
let inputHash = document.getElementById("inputHash");

//On implémente l'id du main component game.
searchHashButton.addEventListener('click', (e)=>{
    let hash = inputHash.value;
    hash = "hash_"+hash;
    if(hash != ""){
        $.ajax({url: RACINE+'Game/Game_controller/verifyParcourStep/'+hash, success: function(histo){
            // console.log("=====>"+histo);
            if(histo == "non exist"){
                alert("Aucun parcour ne correspond à votre hascode, veuillez réessayer");//todo afficher un message sur le formulaire.
                inputHash.value = "";
                return;
            }else if(histo == false){
                // console.log("L'utilisateur doit commencer dès le début");
                sendBeginparcour(RACINE+'Game/Game_controller/displayGame', {hashcode: hash})
            }else{
                var histoData = JSON.parse(histo); 
                let response  = confirm("Une partie pour le parcour "+ histoData.nomPa +" datant du "+histoData.time+" est déjà en cour. Voulez vous reprendre à l'étape "+histoData.step+ " : " +histoData.nomPo);
                if(response){
                    sendBeginparcour(RACINE+'Game/Game_controller/displayGame', {hashcode: hash, step: histoData.step})
                }else{
                    sendBeginparcour(RACINE+'Game/Game_controller/displayGame', {hashcode: hash})
                }
            }
        }}); 
    }else{
        console.log("Veuillez saisir un hascode");//todo afficher un message sur le formulaire.
    }
});


function sendBeginparcour(path, parameters, method='post') {
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