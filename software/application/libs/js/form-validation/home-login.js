$(document).ready(function () {

    $("form").validate({
        rules: {
            nome: {
                required: true,
                maxlength: {
                    param: 255
                }
            },
            password: {
                required: true,
                maxlength: {
                    param: 255
                }
            }
        },
        messages: {
            nome: {
                required: "Inserire un nome utente",
                maxlength: "Inserire un nome utente più corto di 256 caratteri"
            },
            password: {
                required: "Inserire una password",
                maxlength: "Inserire una password più corta di 256 caratteri"
            }
        }
    });

});