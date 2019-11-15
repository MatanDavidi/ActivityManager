$(document).ready(function () {

    $("form").validate({
        rules: {
            nome: {
                required: true,
                maxlength: {
                    param: 255
                },
                pattern: {
                    param: /^[a-zàéèìòùäëïöüâêîôûßñç&@0-9,.\-_' ]+$/i
                }
            },
            data_inizio: {
                required: true,
                pattern: {
                    param: /^\d{4}\-\d{1,2}\-\d{1,2}$/
                }
            },
            data_consegna: {
                required: true,
                min: function () {
                    return $("#data_inizio").val();
                },
                pattern: {
                    param: /^\d{4}\-\d{1,2}\-\d{1,2}$/
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
                },
                pattern: {
                    param: /^[a-zàéèìòùäëïöüâêîôûßñç&@0-9,._':?! ]+$/i
                }
            }
        },
        messages: {
            nome: {
                required: "Inserire un nome valido",
                maxlength: "Inserire un nome più corto di 256 caratteri",
                pattern: "Il nome utente inserito contiene caratteri non validi"
            },
            ore: {
                required: "Inserire un numero di ore preventivate valido",
                min: "Inserire un numero di ore preventivate maggiore di 0"
            },
            data_inizio: {
                date: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                dateISO: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                pattern: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                required: "Inserire una data di inizio"
            },
            data_consegna: {
                date: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                dateISO: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                pattern: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                required: "Inserire una data di consegna",
                min: "La data di consegna non può precedere la data di inizio. Posticipare la data di consegna fino a oltre la data {0}"
            },
            note: {
                maxlength: "Inserire delle note per un totale di meno di 256 caratteri",
                pattern: "Le note inserite contengono caratteri non validi"
            }
        }
    });

});