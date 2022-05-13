
//SEARCHBAR listener
document.getElementById("searchbar").addEventListener("keyup", (e)=>{
    search_parcour(e.target.value) ;
});
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