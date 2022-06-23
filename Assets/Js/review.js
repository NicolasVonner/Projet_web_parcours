
//SEARCHBAR listener.
document.getElementById("searchbar").addEventListener("keyup", (e)=>{
    search_parcour(e.currentTarget.value) ;
})

//Functions

function search_parcour(value) {
    value = value.toLowerCase();
    let x =  document.getElementById('list');
    // console.log(x.children[0].getElementsByTagName('td')[1].textContent);
    // console.log("Le nom du parcour dans cette enfant est =>"+x.children[0].getElementsByTagName('h6')[0].textContent);
    for (i = 0; i < x.children.length; i++) { 
        if (!x.children[i].getElementsByTagName('td')[1].textContent.toLowerCase().includes(value)) {
            x.children[i].style.visibility="hidden";
        }
        else {
            x.children[i].style.visibility="visible";                 
        }
    }
}
