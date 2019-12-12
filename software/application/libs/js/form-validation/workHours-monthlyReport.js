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
                date: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                dateISO: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                pattern: "Inserire un mese valido nel seguente formato: YYYY-mm",
                required: "Inserire un mese di cui ottenere il resoconto delle ore di lavoro"
            },
            risorsa: {
                required: "Selezionare una risorsa"
            }
        }
    });
});