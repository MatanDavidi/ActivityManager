$(document).ready(() => {

    $("form").validate({
        rules: {
            nome: {
                required: true
            },
            data_inizio: {
                required: true
            },
            data_consegna: {
                required: true
            },
            ore: {
                required: true
            },
            note: {

            }
        }
    });

});