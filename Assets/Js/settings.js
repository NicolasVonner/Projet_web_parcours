const BORDER_BASE = "black";
const BORDER_FOCUS = "darkorange";
const BORDER_ERROR = "red";
const BORDER_OK = "#2c2e33";

//PASSWORD listener
//TODO Faire en sorte que les entrées espace ne passent pas, désactiver la touche space.
document.getElementById("password").addEventListener("keyup", (e)=>{
    e.target.value != undefined ? managePasswordInput(e.target.value) : console.log("Password form undefined");
    
});

//USERNAME listener
document.getElementById("username").addEventListener("keyup", (e)=>{
    e.target.value != undefined ? manageUsernameInput(e.target.value) : console.log("Username form undefined");
});

//AVATAR
let avatars = document.getElementsByClassName("avatar");

for(element of avatars){
    element.addEventListener("mouseover",(e)=>{
        e.target.style.borderColor = BORDER_FOCUS;
    })
    element.addEventListener("mouseout",(e)=>{
        e.target.style.borderColor = BORDER_BASE;
    })
    element.addEventListener("click",(e)=>{
        document.getElementById("avatar-preview").src = e.target.src;
        document.getElementById("form-avatar").value = e.target.src.split('/')[6];
    })
}

//#Functions
function managePasswordInput(value){
    let errors = checkPasswordValidation(value);
    injectErrors("password-error", errors);
    document.getElementById("password").style.borderColor = changeInputColor(errors.length, value);
}

function manageUsernameInput(value){
    let errors = checkUsernameValidation(value);
    injectErrors("username-error", errors);
    document.getElementById("username").style.borderColor = changeInputColor(errors.length, value);
}

// Vérifie si la valeur du password entrée par l'utilisateur en temps réel respecte le regex.
function checkPasswordValidation(value) {
    let out = [];

    const isWhitespace = /^(?=.*\s)/;
    if (isWhitespace.test(value)) {
      out += "<p class='error'>Password must not contain Whitespaces.</p>";
    }


    const isContainsUppercase = /^(?=.*[A-Z])/;
    if (!isContainsUppercase.test(value)) {
        out += "<p class='error'>Password must have at least one Uppercase Character.</p>";
    }


    const isContainsLowercase = /^(?=.*[a-z])/;
    if (!isContainsLowercase.test(value)) {
        out += "<p class='error'>Password must have at least one Lowercase Character.</p>";
    }


    const isContainsNumber = /^(?=.*[0-9])/;
    if (!isContainsNumber.test(value)) {
        out += "<p class='error'>Password must contain at least one Digit.</p>";
    }


    const isContainsSymbol =/^(?=.*[!@#\$%\^&\*=])/;
      ///^(?=.*[~`!@#$%^&*()--+={}\[\]|\\:;"'<>,.?/_₹])/;
    if (!isContainsSymbol.test(value)) {
        out += "<p class='error'>Password must contain at least one Special Symbol.(!@#$%^&*)</p>";
    }

        const notContainsSymbol = /^(?=.*[()--+={}\[\]|\\:;"'<>,.?/_₹~`])/;
    if (notContainsSymbol.test(value)) {
        out += "<p class='error'>Password must not contain .(()--+={}[]|:;\"'<>,.?\\/_₹~`)</p>";
    }


    const isValidLength = /^.{8,40}$/;
    if (!isValidLength.test(value)) {
        out += "<p class='error'>Password must be 8-40 Characters Long.</p>";
    }

    return out;
};

// Vérifie si la valeur de l'username entrée par l'utilisateur en temps réel respecte le regex.
function checkUsernameValidation(value) {
    let out = [];

    const isWhitespace = /^(?=.*\s)/;
    if (isWhitespace.test(value)) {
      out += "<p class='error'>Username must not contain Whitespaces.</p>";
    }

    const notContainsSymbol =/^(?=.*[!@#\$%\^&\*()--+={}\[\]|"\\:;'<>,.?/_₹~`])/;
    if (notContainsSymbol.test(value)) {
        out += "<p class='error'>Username must not contain specials Symbols (=!@#$%^&*()--+={}[]|:;'<>,.?\\/_₹=).</p>";
    }

    const isValidLength = /^.{3,20}$/;
    if (!isValidLength.test(value)) {
        out += "<p class='error'>Password must be 3-20 Characters Long.</p>";
    }

    return out;
};

//Inject les erreurs dans la vue.
function injectErrors(idTarget, message){
    document.getElementById(idTarget).innerHTML = message;
}
    
//Retourne une couleur en fonction des erreurs que le système dectecte lorsque de l'utilisateur tape au clavier.
function changeInputColor(messageSize, currentValue){
    if(messageSize !== 0){
        return currentValue == "" ? BORDER_OK : BORDER_ERROR;
    }
    return BORDER_OK;
}


//suprimer sont propre sont compte
$(document).on('click', '#delete-user', function(e) {
    let response  = confirm("Etes vous sur de bien vouloir suprimer votre comptes  tous les données associé score, parcours, équipe seront suprimer de manière définitive");
    if(response)
    sendDelete(RACINE+'Settings/Settings_controller/deleteOurOwnAcount/', {idDeleteUser: e.target.value})
        
});

function sendDelete(path, parameters, method='post') {

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

