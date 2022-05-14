// document.getElementById('signIn').addEventListener('click', getAuthIn_controller => location.href = "http://fastadventure/Authentification/Authentification_controller/displaySignin");
// document.getElementById('signUp').addEventListener('click', getAuthiUp_controller => location.href = "http://fastadventure/Authentification/Authentification_controller/displaySignup");
// document.getElementById('guest').addEventListener('click', getGameG_controller => location.href = "http://fastadventure/Game/Game_controller/createGuest");


//Pour le démarrage de l'appli.
verifySize()
window.addEventListener('resize', verifySize);

function verifySize(){
    if(document.getElementById('addButton') != null){
        window.innerWidth < 780?
        document.getElementById('addButton').innerHTML  = "+":
        document.getElementById('addButton').innerHTML = "+ Add parcour";
    }

}


// document.getElementById("logout").addEventListener("click", (e)=>{
//     console.log("TAK");
//     let reponse = confirm("Vous êtes sur le point de vous déconnecter. Voulez vous vraiment continuer ?");
//     if(reponse){
//         location.href = "http://fastadventure/Main/Index_controller/logout";
//     }
//     return false;
// })