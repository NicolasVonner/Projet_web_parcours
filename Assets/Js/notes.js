let inputList = $(".rate input");
let note = "";

window.onload = () => {
    //$("#open-modal").on("click",openRankModal);
    $("#close-modal").on("click",closeRankModal);
    $("#send-rating").on("click",sendRank);
}


const openRankModal = () => {
    $("#modal").addClass("show");
    $(".modal-overlay").addClass("show");
};

const closeRankModal = () => {
    $("#modal").removeClass("show");
    $(".modal-overlay").removeClass("show");
    location.href = RACINE;
    return;
};

const changeColorStar = (input,mouseover) => {
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
    else { // sinon l'étoile redevient grise
        if ($(".rate input:checked").length > 0 && input.val()  <=  $(".rate input:checked").val())
        {
            star.css("color","#ffc700"); // jaune
        }
        else {
            star.css("color","#ccc");
        }
    }
}

const fillPreviousStars = (val, mouseover) => {
    for (let i = 1; i <= val; i++)
    {
        changeColorStar($(`input[id='star${i}']`),mouseover);
    }
}

$(".rate label").on("mouseover",function () {
    let input = $("input[id='" + $(this).attr('for') + "']");
    fillPreviousStars(input.val(), true);
});

$(".rate input").on("click",function () {
    fillPreviousStars($(this).val(), true);
});

$(".rate label").on("mouseout",function () {
    let input = $("input[id='" + $(this).attr('for') + "']");
    fillPreviousStars(input.val(), false);
});

const sendRank = () => {
    $("#errorText").html("");
    let inputChecked = $(".rate input:checked");
    if (inputChecked.length > 0)
    {
        let stars = new Object();
        stars.codePa = gameObject.codePa;
        stars.note = +inputChecked.val();
        stars.commentaire = $("#text-zone textarea").val();
        inputChecked.prop("checked", false);
        fillPreviousStars(5, false);
        $.post(RACINE+"Game/Game_controller/addNoteToParcours","stars="+JSON.stringify(stars) , function(result){
            console.log(result);
            if (result != "sended") {
                alert("Erreur, tu a déjà laissé une note dans ce parcours!");
            }
        });
        closeRankModal();
    }
    else {
        $("#error-text").text("Please rate by selecting a star.");
    }
}