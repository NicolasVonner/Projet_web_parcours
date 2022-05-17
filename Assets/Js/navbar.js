let searchGameButton = document.getElementById('searchGame');
let searchHashGameButton = document.getElementById('searchHashGame');
//On appel la fonction pour la premiere fois
verifySize();
window.addEventListener('resize', verifySize);

function verifySize(){
    if(document.getElementById('playButton') != null){
        window.innerWidth < 780?
            document.getElementById('playButton').innerHTML  = "<i class='mdi mdi-play'></i>":
            document.getElementById('playButton').innerHTML = "<i style='margin-top: 20px;' class='mdi mdi-play'></i> Play";
    }
}
//Listener mode de recherche de parcour.
if(searchGameButton!= null && searchHashGameButton != null) {
    searchGameButton.addEventListener('click', (e)=>{     
        sendData(RACINE, {gameSearch: 'true'});    
  })
  searchHashGameButton.addEventListener('click', (e)=>{     
    location.href = RACINE+"Game/Game_controller/displayHashForm";  
})
}

//TODO modifier la fonction et les envoies.
function sendData(path, parameters, method='post') {

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

