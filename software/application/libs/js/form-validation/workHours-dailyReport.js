$(document).ready(function () {

    let form = $("form");

    let selectIDs = ["#risorsa"];

    let todayDate = new Date();

    form.validate({
        rules: {
            data: {
                required: true,
                pattern: {
                    param: /^\d{4}\-\d{1,2}\-\d{1,2}$/
                },
                max: {
                    param: todayDate.toISOString()
                }
            }
        },
        messages: {
            data: {
                date: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                dateISO: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                pattern: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                required: "Inserire una data di cui ottenere il resoconto delle ore di lavoro",
                max: "La data di lavoro non può essere maggiore di quella di oggi. " +
                    "Inserire un valore minore o uguale a " + todayDate.toLocaleDateString()
            },
            risorsa: {
                required: "Selezionare una risorsa"
            }
        }
    });

    let validator = new SelectValidation(selectIDs);

    form.on("submit", function () {

        // Boolean variable that indicates if the value that will be passed for the registration
        // is contained within the original options defined after loading the page.
        // Also, a value needs to be specified for it to be valid.
        let isRisorsaValid = validator.isValueInOptions(selectIDs[0]) &&
            $("#risorsa").val().trim().length > 0;

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

        return isRisorsaValid;

    });

});