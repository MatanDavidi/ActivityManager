$(document).ready(() => {

    let form = $("form");
    form.validate({
        rules: {
            nome: {
                required: true,
                maxlength: {
                    param: 255
                }
            },
            costo: {
                required: true,
                min: {
                    depends: (element) => {
                        return (element.value * 1) < 0;
                    }
                }
            },
            password: {
                maxlength: {
                    param: 255
                }
            }
        },
        messages: {
            nome: {
                required: "Inserire un nome valido",
                maxlength: "Inserire un nome più corto di 256 caratteri"
            },
            costo: {
                required: "Inserire un costo valido",
                min: "Inserire un costo maggiore o uguale a 0"
            },
            password: {
                maxlength: "Inserire una password più corta di 256 caratteri"
            }
        }
    });

    //Variable that defines if the role has been validated with negative result (therefore it already contains an error message)
    var isRuoloValid = true;

    form.on("submit", (evt) => {

        //Get the value of the selected radio button:
        //Get all the radio buttons related to the role
        let ruoloRadios = $("input[name='ruolo']");
        //Instantiate the variable that will contain the value of the role
        let ruoloInput = "";

        for (let i = 0; i < ruoloRadios.length; ++i) {

            let ruoloRadio = ruoloRadios[i];

            //Loop through each radio button in search of the selected one
            if (ruoloRadio.checked) {

                ruoloInput = ruoloRadio.value.trim();

            }

        }

        let radioDiv = $("#ruolo");
        //Check if the password has been set
        if ($("#password").val().trim().length > 0) {

            //If a value for the role has been selected
            if (ruoloInput.length > 0) {

                //If there's an error message because the role is invalid
                if (!isRuoloValid) {

                    //Remove it
                    radioDiv.find("label.error").remove();

                }
                isRuoloValid = true;

            } else {

                //A value has not been set!
                //Add an error message for the role
                let ruoloMsg = "Specificare un ruolo per l'utente";
                let errorLabel = $("<label for=\"ruolo\" class=\"error\">" + ruoloMsg + "</label>");
                radioDiv.append(errorLabel);

                //DO NOT SUBMIT THE FORM!
                evt.preventDefault();
                isRuoloValid = false;

            }

        } else {

            //The password has not been specified: no controls here
            isRuoloValid = true;

        }

        //Concretely, it only returns false if the form is invalid,
        //this prevents the form from submitting and changing pages
        return isRuoloValid;

    });

});