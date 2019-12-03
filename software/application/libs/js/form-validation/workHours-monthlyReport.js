$(document).ready(function () {
    $("form").validate({
        rules: {
            mese: {
                required: true,
                pattern: {
                    param: /^\d{4}\-\d{1,2}$/
                }
            }
        },
        messages: {
            mese: {
                required: "Inserire un mese di cui ottenere il resoconto delle ore di lavoro",
                pattern: "Il mese deve seguire questo formato: YYYY-MM"
            }
        }
    });
});