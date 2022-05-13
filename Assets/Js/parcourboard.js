
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
            x.children[i].getElementsByTagName('button')[1].innerHTML = '<i class="mdi mdi-border-color btn-icon-prepend"></i>';
        }
    }else{
        for (i = 0; i < x.children.length; i++) { 
            x.children[i].getElementsByTagName('button')[0].innerHTML = '<i class="mdi mdi-play btn-icon-prepend"></i>Jouer';
            x.children[i].getElementsByTagName('button')[1].innerHTML = '<i class="mdi mdi-border-color btn-icon-prepend"></i>Edit';
        }
    }

}
let x =  document.getElementById('list');
x.children[0].getElementsByTagName('button')[0].addEventListener('click', (e)=>{
console.log("L'ID est ====>"+e.target.id)
//Appeler la fonciton launch play game avec id du parcour.
});