$(document).ready(function () {

    $("form").validate({
        rules: {
            nome: {
                required: true,
                maxlength: {
                    param: 255
                }
            },
            data_inizio: {
                required: true
            },
            data_consegna: {
                required: true,
                min: function () {
                    return $("#data_inizio").val();
                }
            },
            ore: {
                required: true,
                min: {
                    param: 1
                }
            },
            note: {
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
            ore: {
                required: "Inserire un numero di ore preventivate valido",
                min: "Inserire un numero di ore preventivate maggiore di 0"
            },
            data_inizio: {
                required: "Inserire una data di inizio"
            },
            data_consegna: {
                required: "Inserire una data di consegna",
                min: "La data di consegna non può eccedere la data di inizio. Anticipare la data di consegna fino a prima della data {0}"
            },
            note: {
                maxlength: "Inserire delle note per un totale di meno di 256 caratteri"
            }
        }
    });

});