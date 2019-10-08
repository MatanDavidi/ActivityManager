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

                lavoroErrorLabel.remove();

            }

            //Se il valore non è valido, aggiungi un messaggio di errore
        } else {

            //Se non viene trovato un messaggio di errore, aggiungilo
            if (lavoroErrorLabel.length === 0) {

                let lavoroErrorMessage = "Selezionare una lavoro valido";
                let errorLabel = $("<label for='lavoro' class='error'>" + lavoroErrorMessage + "</label>");

                $("#lavoroSelect").find(".error-container").append(errorLabel);

            }

        }

        let risorsaErrorLabel = $("#risorsaSelect label.error");

        //Indipendentemente dalla validità o meno del valore inserito all'interno del campo Lavoro,
        //se quello inserito nel campo Risorsa è valido, rimuovi gli eventuali messaggi di errore.
        if (isRisorsaValid) {

            //Se viene trovato un messaggio di errore, rimuovilo
            if (risorsaErrorLabel.length > 0) {

                risorsaErrorLabel.remove();

            }

            //Se invece non dovesse essere valido
        } else {

            //Cerca se è presente un messaggio di errore. In caso negativo, aggiungilo
            if (risorsaErrorLabel.length === 0) {

                let risorsaErrorMessage = "Selezionare una risorsa valida";
                let errorLabel = $("<label for='risorsa' class='error'>" + risorsaErrorMessage + "</label>");

                $("#risorsaSelect").find(".error-container").append(errorLabel);

            }

        }

        return isLavoroValid && isRisorsaValid;

    });

    // $("form").on("submit", () => {
    //
    //     //Salvo il select del lavoro e il suo valore per non doverlo cercare due volte
    //     let lavoroValue = $("#lavoro").val().trim();
    //
    //     // Variabile booleana che indica se il valore che verrà passato per la registrazione
    //     // è uguale a quello inserito dall'applicazione
    //     let isLavoroValid = false;
    //
    //     //Salvo il select delle risorse e il suo valore per non doverlo cercare due volte
    //     let risorsaValue = $("#risorsa").val().trim();
    //
    //     // Variabile booleana che indica se il valore che verrà passato per la registrazione
    //     // è contenuto all'interno delle opzioni originali definita dopo il caricamento della pagina
    //     let isRisorsaValid;
    //
    //     //Se non è stato specificato un valore per la risorsa, esso non è valido (ovviamente), dopodiché
    //     //controllo se il valore della risorsa che verrà passato è contenuto nelle opzioni originali
    //     isRisorsaValid = risorsaValue.length > 0 && optionsContain(risorsaOptions, risorsaValue);
    //
    //     let lavoroErrorLabel = $("#lavoroSelect label.error");
    //
    //     //Il valore del lavoro è valido quando è uguale a quello passato dal controller,
    //     // quindi non deve essere cambiato dal caricamento al submit
    //     if (lavoroValue === originalLavoroValue) {
    //
    //         //Se è stato trovato un messaggio d'errore, lo si elimina perché il valore del lavoro è valido
    //         if (lavoroErrorLabel.length > 0) {
    //
    //             lavoroErrorLabel.remove();
    //
    //         }
    //
    //         isLavoroValid = true;
    //
    //         //Se il valore non è valido, aggiungi un messaggio di errore
    //     } else {
    //
    //         //Se non viene trovato un messaggio di errore, aggiungilo
    //         if (lavoroErrorLabel.length === 0) {
    //
    //             let errorLabel = $("<label for='lavoro' class='error'>" + LAVORO_ERROR_MESSAGE + "</label>");
    //
    //             $("#lavoroSelect").find(".error-container").append(errorLabel);
    //
    //         }
    //
    //     }
    //
    //     let risorsaErrorLabel = $("#risorsaSelect label.error");
    //
    //     //Indipendentemente dalla validità o meno del valore inserito all'interno del campo Lavoro,
    //     //se quello inserito nel campo Risorsa è valido, rimuovi gli eventuali messaggi di errore.
    //     if (isRisorsaValid) {
    //
    //         //Se viene trovato un messaggio di errore, rimuovilo
    //         if (risorsaErrorLabel.length > 0) {
    //
    //             risorsaErrorLabel.remove();
    //
    //         }
    //
    //         //Se invece non dovesse essere valido
    //     } else {
    //
    //         //Cerca se è presente un messaggio di errore. In caso negativo, aggiungilo
    //         if (risorsaErrorLabel.length === 0) {
    //
    //             let errorLabel = $("<label for='risorsa' class='error'>" + RISORSA_ERROR_MESSAGE + "</label>");
    //
    //             $("#risorsaSelect").find(".error-container").append(errorLabel);
    //
    //         }
    //
    //     }
    //
    //     return isLavoroValid && isRisorsaValid;
    //
    // });

    /**
     * Controlla se un valore è contenuto all'interno delle opzioni di un select.
     * @param array Un array contenente i tag <option> di un input di tipo select.
     * È all'interno di questo array che viene cercata una corrispondenza.
     * @param value Il valore da ricercare all'interno dell'array.
     * @returns {boolean} Un valore booleano che corrisponde alla corrispondenza del valore all'interno dell'array di opzioni.
     * In parole povere, viene ritornato true se è stata trovata una corrispondenza e false in tutti gli altri casi.
     */
    function optionsContain(array, value) {

        for (let i = 0; i < array.length; ++i) {

            let option = array[i];
            if (value === option.value) {

                return true;

            }

        }

        return false;

    }

});