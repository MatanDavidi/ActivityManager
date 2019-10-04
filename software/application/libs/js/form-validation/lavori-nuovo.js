$(document).ready(() => {

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
                min: () => {
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
        }
    });

});