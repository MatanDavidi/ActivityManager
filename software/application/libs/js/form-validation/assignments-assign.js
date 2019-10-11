$(document).ready(() => {

    let selectIDs = ["#lavoro", "#risorsa"];
    let validator = new SelectValidation(selectIDs);

    $("form").on("submit", () => {

        //The value of the work is valid when it is the same as the one passed by
        // the controller, so it must not be changed from the page's loading to submit
        let isLavoroValid = validator.isValueSameAsOriginal(selectIDs[0]);

        // Boolean variable that indicates if the value that will be passed for
        // the recording is contained within the original options defined after loading the page
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

            //If an error message can not be found, it is added
            if (lavoroErrorLabel.length === 0) {

                let lavoroErrorMessage = "Selezionare una lavoro valido";
                let errorLabel = $("<label for='lavoro' class='error'>" + lavoroErrorMessage + "</label>");

                $("#lavoroSelect").find(".error-container").append(errorLabel);

            } else {

                //Otherwise it is simply shown
                lavoroErrorLabel.show();

            }

        }

        let risorsaErrorLabel = $("#risorsaSelect label.error");

        //Indipendentemente dalla validità o meno del valore inserito all'interno del campo Lavoro,
        //se quello inserito nel campo Risorsa è valido, rimuovi gli eventuali messaggi di errore.
        if (isRisorsaValid) {

            //Se viene trovato un messaggio di errore, rimuovilo
            if (risorsaErrorLabel.length > 0) {

                risorsaErrorLabel.hide();

            }

            //Se invece non dovesse essere valido
        } else {

            //Cerca se è presente un messaggio di errore. In caso negativo, aggiungilo
            if (risorsaErrorLabel.length === 0) {

                let risorsaErrorMessage = "Selezionare una risorsa valida";
                let errorLabel = $("<label for='risorsa' class='error'>" + risorsaErrorMessage + "</label>");

                $("#risorsaSelect").find(".error-container").append(errorLabel);

            } else {

                risorsaErrorLabel.show();

            }

        }

        return isLavoroValid && isRisorsaValid;

    });

});