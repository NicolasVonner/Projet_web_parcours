verifySize();

window.addEventListener('resize', verifySize);

//console.log(nav);
//nav.style.display = "none";


function verifySize(){
    window.innerWidth < 780 ? document.getElementById('createbuttonDropdown').textContent = "+": 
document.getElementById('createbuttonDropdown').textContent = "+ Nouveau parcour";
if(window.innerWidth < 780)
document.getElementById('sign').innerHTML ="<a nav-link count-indicator dropdown-toggle href='./dashboard.html'><i class='mdi mdi-account-key '></i></a>";
else document.getElementById('sign').innerHTML = "<button type='button' class='btn btn-light btn-rounded btn-fw' style='min-width: auto;'>Sign in</button></a>";
}