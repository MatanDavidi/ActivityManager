$(document).ready(() => {

    let selectIDs = ["#lavoro", "#risorsa"];
    let validator = new SelectValidation(selectIDs);

    $("form").on("submit", () => {

        //Il valore del lavoro è valido quando è uguale a quello passato dal controller,
        // quindi non deve essere cambiato dal caricamento al submit
        let isLavoroValid = validator.isValueSameAsOriginal(selectIDs[0]);

        // Variabile booleana che indica se il valore che verrà passato per la registrazione
        // è contenuto all'interno delle opzioni originali definite dopo il caricamento della pagina
        let isRisorsaValid = validator.isValueInOptions(selectIDs[1]) &&
            $("#risorsa").val().trim().length > 0;

        let lavoroErrorLabel = $("#lavoroSelect label.error");

        if (isLavoroValid) {

            //Se è stato trovato un messaggio d'errore, lo si elimina perché il valore del lavoro è valido
            if (lavoroErrorLabel.length > 0) {

                lavoroErrorLabel.hide();

            }

            //Se il valore non è valido, aggiungi un messaggio di errore
        } else {

            //Se non viene trovato un messaggio di errore, aggiungilo
            if (lavoroErrorLabel.length === 0) {

                let lavoroErrorMessage = "Selezionare una lavoro valido";
                let errorLabel = $("<label for='lavoro' class='error'>" + lavoroErrorMessage + "</label>");

                $("#lavoroSelect").find(".error-container").append(errorLabel);

            } else {

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