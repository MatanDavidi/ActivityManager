$(document).ready(function() {

    const todayDate = new Date();

    let form = $("form");

    let selectIDs = ["#lavoro", "#risorsa"];
    let validator = new SelectValidation(selectIDs);

    form.validate({
        rules: {
            data: {
                required: true,
                max: todayDate.toISOString()
            },
            numeroOre: {
                required: true,
                min:
                    1
            }
        },
        messages: {
            data: {
                required: "Inserire una data valida",
                max:
                    "La data di lavoro non può essere maggiore di quella di oggi. " +
                    "Inserire un valore minore o uguale a " + todayDate.toLocaleDateString()
            }
            ,
            numeroOre: {
                required: "Inserire un numero di ore valido",
                min:
                    "Inserire un numero di ore maggiore di 0"
            }
        }
    });

    form.on("submit", function() {

        //The value of the activity is valid when it is equal to the value passed by
        // the controller, so it must not be changed from page loading to submit.
        let isLavoroValid = validator.isValueSameAsOriginal(selectIDs[0]);

        // Boolean variable that indicates if the value that will be passed for the registration
        // is contained within the original options defined after loading the page.
        // Also, a value needs to be specified for it to be valid.
        let isRisorsaValid = validator.isValueInOptions(selectIDs[1]) &&
            $("#risorsa").val().trim().length > 0;

        let lavoroErrorLabel = $("#lavoroSelect label.error");

        if (isLavoroValid) {

            //If an error message has been found, it is hidden because the value of the work is valid
            if (lavoroErrorLabel.length > 0) {

                lavoroErrorLabel.hide();

            }

            //If the value is invalid, add an error message
        } else {

            //If an error message is not found, add it
            if (lavoroErrorLabel.length === 0) {

                let lavoroErrorMessage = "Selezionare una lavoro valido";
                let errorLabel = $("<label for='lavoro' class='error'>" + lavoroErrorMessage + "</label>");

                $("#lavoroSelect").find(".error-container").append(errorLabel);

            } else {

                //Otherwise, simply show it
                lavoroErrorLabel.show();

            }

        }

        let risorsaErrorLabel = $("#risorsaSelect label.error");

        // Regardless of whether the value entered in the Activity field is valid or not, if the
        // one entered in the Resource field is valid, remove any error messages associated to it.
        if (isRisorsaValid) {

            //If an error message is found, hide it
            if (risorsaErrorLabel.length > 0) {

                risorsaErrorLabel.hide();

            }

            //If, however, it is not valid
        } else {

            //See if there's an error message. If not, add it
            if (risorsaErrorLabel.length === 0) {

                let risorsaErrorMessage = "Selezionare una risorsa valida";
                let errorLabel = $("<label for='risorsa' class='error'>" + risorsaErrorMessage + "</label>");

                $("#risorsaSelect").find(".error-container").append(errorLabel);

            } else {

                //Otherwise, show it
                risorsaErrorLabel.show();

            }

        }

        //The form is valid if both the value for field Activity and the value for field Resource are valid.
        return isLavoroValid && isRisorsaValid;

    });

});