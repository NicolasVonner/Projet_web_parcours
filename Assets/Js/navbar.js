//On appel la fonction pour la premiere fois
verifySize();
window.addEventListener('resize', verifySize);

function verifySize(){
    window.innerWidth < 780?
        document.getElementById('playButton').innerHTML  = "<i class='mdi mdi-play'></i>":
        document.getElementById('playButton').innerHTML = "<i style='margin-top: 20px;' class='mdi mdi-play'></i> Play";
}

