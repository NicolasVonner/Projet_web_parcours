let inputList = $(".rate input");
let note = "";

window.onload = () => {
    //$("#open-modal").on("click",openRankModal);
    $("#close-modal").on("click",closeRankModal);
    $("#send-rating").on("click",sendRank);
}

// permet d'ouvrir le modal
const openRankModal = () => {
    $("#modal").addClass("show");
    $(".modal-overlay").addClass("show");
};

// permet de fermer le modal
const closeRankModal = () => {
    $("#modal").removeClass("show");
    $(".modal-overlay").removeClass("show");
    location.href = RACINE;
    return;
};

// permet de changer la couleur du label (étoile) en fonction de conditions
const changeColorStar = (input,mouseover) => {
    // on récupére le label correspondant à l'input en paramètre
    let star = $("label[for='" + input.attr('id') + "']");
    
    if (mouseover) { // si la souris survole le label
        // si aucun input n'a été checké alors on met une color jaune sinon une couleur légérement orange.
        if ($(".rate input:checked").length <= 0) {
            star.css("color","#ffc700"); // jaune
        }
        else {
            star.css("color","#deb217"); // légérement orange
        }
    }
    else { // sinon 
        // si un input a été checké et que la valeur de l'input actuelle est inférieur à celui checké soit avant l'étoile checké
        if ($(".rate input:checked").length > 0 && input.val()  <=  $(".rate input:checked").val())
        {
            star.css("color","#ffc700"); // jaune
        }
        else {
            star.css("color","#ccc"); // gris
        }
    }
}

// permet de changer la couleur de tous les étoiles avant celui référencer en paramètre et aussi celui en paramètre
const fillPreviousStars = (val, mouseover) => {
    // si on change la couleur de l'étoile n°3 alors on va aussi changer la couleur des deux premières étoiles
    for (let i = 1; i <= val; i++)
    {
        changeColorStar($(`input[id='star${i}']`),mouseover);
    }
}

// si la souris survole un label alors
$(".rate label").on("mouseover",function () {
    // on récupére l'input correspondant au label survolé
    let input = $("input[id='" + $(this).attr('for') + "']");
    // on appelle la fonction fillPreviousStars avec en tête qu'on de survole le label (true)
    fillPreviousStars(input.val(), true);
});

// si on clique dans un input
$(".rate input").on("click",function () {
    // si on clique dans un input, on survole le label donc true
    fillPreviousStars($(this).val(), true);
});

// si on arrête de survoler un label alors
$(".rate label").on("mouseout",function () {
    // on récupére l'input correspondant au label survolé
    let input = $("input[id='" + $(this).attr('for') + "']");
    // on appelle la fonction fillPreviousStars avec en tête qu'on arrête de survoler le label (false)
    fillPreviousStars(input.val(), false);
});

const sendRank = () => {
    // on nettoie le texte d'erreur
    $("#errorText").html("");
    let inputChecked = $(".rate input:checked"); // on récupére l'input checké
    // si un input a été checké alors
    if (inputChecked.length > 0)
    {
        let stars = new Object(); // on crée un objet stars avec des données comme le code parcours, la note et le commentaire
        stars.codePa = gameObject.codePa;
        stars.note = +inputChecked.val();
        stars.commentaire = $("#text-zone textarea").val();
        // on dechecked l'input checké
        inputChecked.prop("checked", false);
        // on change toutes les étoiles en gris
        fillPreviousStars(5, false);
        // on envoie l'objet stars au Game_controller
        $.post(RACINE+"Game/Game_controller/addNoteToParcours","stars="+JSON.stringify(stars) , function(result){
            // si le résultat est autre que sended, ça veut dire qu'on a déjà envoie une note dans ce parcours
            if (result != "sended") {
                alert("Erreur, tu a déjà laissé une note dans ce parcours!");
            }
        });
        closeRankModal(); // on ferme le modal
    }
    else { // sinon on affiche un message d'erreur dans le texte
        $("#error-text").text("Please rate by selecting a star.");
    }
}