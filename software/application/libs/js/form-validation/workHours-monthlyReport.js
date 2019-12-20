$(document).ready(function () {
    let todayDate = new Date();
    $("form").validate({
        rules: {
            mese: {
                required: true,
                pattern: {
                    param: /^\d{4}\-\d{1,2}$/
                },
                max: {
                    param: todayDate.toISOString()
                }
            }
        },
        messages: {
            mese: {
                date: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                dateISO: "Inserire una data valida nel seguente formato: YYYY-mm-dd",
                pattern: "Inserire un mese valido nel seguente formato: YYYY-mm",
                required: "Inserire un mese di cui ottenere il resoconto delle ore di lavoro",
                max: "Il mese di lavoro non può essere maggiore di quello corrente. " +
                    "Inserire un valore minore o uguale a " + `${todayDate.getFullYear()}-${todayDate.getMonth()}`
            },
            risorsa: {
                required: "Selezionare una risorsa"
            }
        }
    });
});