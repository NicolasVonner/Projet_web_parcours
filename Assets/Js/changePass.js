const BORDER_BASE = "black";
const BORDER_FOCUS = "darkorange";
const BORDER_ERROR = "red";
const BORDER_OK = "#2c2e33";

let errorMsg = document.querySelector('#err');

//PASSWORD listener.
//TODO Faire en sorte que les entrées espace ne passent pas, désactiver la touche space.
document.getElementById("password").addEventListener("keyup", (e)=>{
    e.target.value != undefined ? managePasswordInput(e.target.value, 0) : console.log("Password form undefined");
    
});

//PASSWORD CONFIRM listener.
//TODO Faire en sorte que les entrées espace ne passent pas, désactiver la touche space.
document.getElementById("passwordConfirm").addEventListener("keyup", (e)=>{
    e.target.value != undefined ? managePasswordInput(e.target.value, 1) : console.log("Password form undefined");
});
//todo afficher avec js en temps réel si les mots de passe ne sont pas les mêmes.

//ERROR MESSAGE cleanner
setInterval(()=> errorMsg.innerHTML = "", 4000);



//#Functions.
function managePasswordInput(value, wich){
    let id = wich == 0?'password':'passwordConfirm';
    let idError = wich == 0?'password-error':'password-error_confirm';
    let errors = checkPasswordValidation(value);
    injectErrors(idError, errors);
    document.getElementById(id).style.borderColor = changeInputColor(errors.length, value);
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

