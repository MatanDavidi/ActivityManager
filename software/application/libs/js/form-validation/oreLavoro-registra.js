$(document).ready(() => {

    const todayDate = new Date();

    $("form").validate({
        rules: {
            data: {
                required: true,
                max: todayDate.toISOString()
            },
            numeroOre: {
                required: true,
                min:
                    1
            }
        },
        messages: {
            data: {
                required: "Inserire una data valida",
                max:
                    "La data di lavoro non può essere maggiore di quella di oggi. " +
                    "Inserire un valore minore o uguale a " + todayDate.toLocaleDateString()
            }
            ,
            numeroOre: {
                required: "Inserire un numero di ore valido",
                min:
                    "Inserire un numero di ore maggiore di 0"
            }
        }
    })
    ;

});