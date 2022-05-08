//Formulaire signUp

//Password
//var strongRegex = new RegExp("((?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[!@#\$%\^&\*])(?!.*[;]).{8,40})");

//TODO Faire en sorte que les entrées espace ne passent
document.getElementById("password").addEventListener("keyup", (e)=>{
    // console.log("code" + e.code);
    console.log("valeur =>" + e.target.value);
    // if (e.code === 'Space') {
    //     e.code = "";
    // }
    checkPasswordValidation(e.target.value);
});

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
        out += "<p class='error'>Password must contain at least one Special Symbol.</p>";
    }

    const notContainsSymbol = /^(?=.*[;])/;
  if (notContainsSymbol.test(value)) {
      out += "<p class='error'>Password must not contain ;.</p>";
  }


    const isValidLength = /^.{8,40}$/;
    if (!isValidLength.test(value)) {
        out += "<p class='error'>Password must be 8-40 Characters Long.</p>";
    }

    displayErrorsPassword(out);
console.log("La  bordure est ===>" + document.getElementById("password").style.borderColor);
    //On chage dynamiquement la couleur de l'input.
    document.getElementById("password").style.borderColor = out.length !== 0  ? "red" : "darkgreen";
};

function displayErrorsPassword(message){
document.getElementById("pass-error").innerHTML = message;
}

                //Password regex
                /*(           # Start of group
                    (?=.*\d)      #   must contains one digit from 0-9
                    (?=.*[a-z])       #   must contains one lowercase characters
                    (?=.*[A-Z])       #   must contains one uppercase characters
                    (?=.*[!@#\$%\^&\*=])      #   must contains one special symbols in the list "@#$%"
                                .     #     match anything with previous condition checking
                                  {8,40}  #        length at least 8 characters and maximum of 40 
                                  (?!.*[;])#        ; is exlude
                  )  */  
//Username

