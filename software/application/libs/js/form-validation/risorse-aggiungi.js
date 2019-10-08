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

    //Variabile che dice se il ruolo è stato validato con esito negativo (quindi contiene già un messaggio di errore)
    var isRuoloValid = true;

    form.on("submit", (evt) => {

        //Ottieni il valore del radio button selezionato:
        //Prendi tutti i radio button del ruolo
        let ruoloRadios = $("input[name='ruolo']");
        //Istanzia la variabile che conterrà il valore
        let ruoloInput = "";

        for (let i = 0; i < ruoloRadios.length; ++i) {

            let ruoloRadio = ruoloRadios[i];

            //Cicla tutti i radio button e trova quello selezionato
            if (ruoloRadio.checked) {

                ruoloInput = ruoloRadio.value.trim();

            }

        }

        let radioDiv = $("#ruolo");
        //Controlla se la password è stata assegnata
        if ($("#password").val().trim().length > 0) {

            //Se è stato selezionato un valore per il ruolo
            if (ruoloInput.length > 0) {

                //Se c'è un messaggio di errore perché il ruolo non è valido
                if (!isRuoloValid) {

                    //Rimuovilo
                    radioDiv.find("label.error").remove();

                }
                isRuoloValid = true;

            } else {

                //Non è stato assegnato un valore!
                //Aggiungi un messaggio di errore
                let ruoloMsg = "Specificare un ruolo per l'utente";
                let errorLabel = $("<label for=\"ruolo\" class=\"error\">" + ruoloMsg + "</label>");
                radioDiv.append(errorLabel);

                //NON SUBMITTARE IL FORM
                evt.preventDefault();
                isRuoloValid = false;

            }

        } else {

            //La password non è stata specificata: nessun controllo
            isRuoloValid = true;

        }

        //Concretamente, ritorna falso solo se il form non è valido, questo evita che il form submitti e cambi pagina
        return isRuoloValid;

    });

});