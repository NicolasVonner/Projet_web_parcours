document.getElementById('signIn').addEventListener('click', getAuthIn_controller => location = "/Authentification/Auth_controller/displaySignin");
document.getElementById('signUp').addEventListener('click', getAuthUp_controller => location.href = "/Authentification/Auth_controller/displaySignup");
document.getElementById('guest').addEventListener('click', getGameG_controller => location.href = "/Game/Game_controller/createGuest");

verifySize();
window.addEventListener('resize', verifySize);

function verifySize(){
    window.innerWidth < 780 ? document.getElementById('createbuttonDropdown').textContent = "+": 
    document.getElementById('createbuttonDropdown').textContent = "+ Nouveau parcour";
    if(window.innerWidth < 780)
    document.getElementById('sign').innerHTML ="<a nav-link count-indicator dropdown-toggle href='./dashboard.html'><i class='mdi mdi-account-key '></i></a>";
    else document.getElementById('sign').innerHTML = "<button type='button' class='btn btn-light btn-rounded btn-fw' style='min-width: auto;'>Sign in</button></a>";
}