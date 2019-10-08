/**
 * Permette di validare uno o più select presenti all'interno di una pagina HTML.
 */
class SelectValidation {

    /**
     * Gli identificatori univoci dei select che si vuole validare.
     * Non devono necessariamente essere valori dell'attributo 'id' di un tag HTML, basta che siano univoci.
     * @type {Array}
     */
    selectIDs = [];

    /**
     * Un array contenente tutti i valori che erano selezionati al caricamento della pagina
     * nei select definiti dagli identificatori contenuti all'interno di 'selectIDs'.
     * @type {Array}
     */
    originalSelectsValues = [];

    /**
     * Un array contenente tutti i valori di tutte le opzioni che erano disponibili al caricamento della pagina
     * nei select definiti dagli identificatori contenuti all'interno di 'selectIDs'.
     * @type {Array}
     */
    originalOptionsValues = [];

    /**
     * Istanzia nuovi oggetti di tipo SelectValidation.
     * @param selectIDs Un array contenente un identificatore univoco di un select per ogni elemento al suo interno.
     * Questi identificatori non devono necessariamente essere valori dell'attributo 'id' di un tag HTML, basta che siano univoci.
     */
    constructor(selectIDs) {
        this.selectIDs = selectIDs;
        this.getSelectValues();
    }

    /**
     * Assegna i valori che sono presenti sulla pagina al momento della chiamata al metodo
     * agli array 'originalSelectsValue' e 'originalOptionsValues'.
     */
    getSelectValues() {

        if (this.originalOptionsValues.length < this.selectIDs.length) {

            for (let i = 0; i < this.selectIDs.length; ++i) {

                this.originalSelectsValues[i] = $(`${this.selectIDs[i]}`).val();

                this.originalOptionsValues[i] = [];
                let currentSelect = $(`${this.selectIDs[i]} option`);

                for (let j = 0; j < currentSelect.length; j++) {

                    this.originalOptionsValues[i][j] = currentSelect[j].value;

                }

            }

        }

    }

    /**
     * Verifica che tutti i valori selezionati di tutti i select siano presenti all'interno delle rispettive opzioni.
     * @returns {boolean} true se il valore selezionato di tutti i select specificati da un identificatore presente
     * all'interno del campo 'selectIDs' è presente nelle proprie opzioni, false altrimenti.
     */
    areValuesInOptions() {

        let isValid = true;

        for (let i = 0; i < this.selectIDs.length; i++) {

            let currentValue = $(`${this.selectIDs[i]}`).val().trim();

            let optionsContain = false;

            for (let j = 0; !optionsContain && j < this.originalOptionsValues[i].length; j++) {

                if (this.originalOptionsValues[i][j] === currentValue) {

                    optionsContain = true;

                }

            }

            if (!optionsContain) {

                isValid = false;

            }

        }

        return isValid;


    }

    /**
     * Verifica che il valore selezionato di un singolo select sia presente all'interno delle sue opzioni.
     * @param selectId L'identificatore univoco corrispondente al select che si vuole validare. Deve essere presente
     * all'interno del campo 'selectIDs'. Questo identificatore non deve necessariamente corrispondere al valore
     * dell'attributo 'id' del tag HTML, basta che sia univoco.
     * @returns {boolean} true se il valore selezionato del select identificato dall'identificatore passato come parametro è presente all'interno delle opzioni disponibile dello stesso select.
     */
    isValueInOptions(selectId) {

        if (this.selectIDs.indexOf(selectId) > -1) {

            let isValid = true;

            let currentValue = $(`${selectId}`).val().trim();

            let optionsContain = false;

            let selectIdIndex = this.selectIDs.indexOf(selectId);

            for (let i = 0; !optionsContain && i < this.originalOptionsValues[selectIdIndex].length; i++) {

                if (this.originalOptionsValues[selectIdIndex][i] === currentValue) {

                    optionsContain = true;

                }

            }

            if (!optionsContain) {

                isValid = false;

            }

            return isValid;

        }

        return false;

    }

    /**
     * Controlla se il valore corrente selezionato di un select sia uguale a quello che era selezionato inizialmente.
     * @param selectID L'identificatore univoco del select che si vuole controllare.
     * Non deve necessariamente essere un valore per l'attributo 'id', basta che sia univoco.
     * @returns {boolean} true se il valore corrente è uguale a quello che aveva quando è stata caricata la pagina.
     */
    isValueSameAsOriginal(selectID) {

        if (this.selectIDs.indexOf(selectID) > -1) {

            let originalSelectValue = this.originalSelectsValues[this.selectIDs.indexOf(selectID)].trim();
            return $(`${selectID}`).val().trim() === originalSelectValue;

        }

        return false;

    }

}