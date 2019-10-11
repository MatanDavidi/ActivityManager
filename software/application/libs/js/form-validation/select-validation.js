/**
 * Allows you to validate one or more selections within an HTML page.
 */
class SelectValidation {

    /**
     * The unique identifiers of the selects you want to validate.
     * They don't have to be values of the 'id' attribute of an HTML tag, as long as they are unique.
     * Example:
     * ["#select1", ".container select[name='select2']"]
     * @type {Array}
     */
    selectIDs = [];

    /**
     * An array containing all the values that were selected in the selections defined
     * by the identifiers contained within 'selectIDs' the moment the page was loaded.
     * Example:
     * ["Select1Default", "select_2_default", "--- CHOOSE ---"]
     * @type {Array}
     */
    originalSelectsValues = [];

    /**
     * A two-dimensional array containing all the values of all the options that were available in the
     * selects defined by the identifiers contained within 'selectIDs' the moment the page was loaded.
     * Example:
     * [
     *  ["Select1Default", "Select1Value1", "Select1Value2"],
     *  ["select_2_default", "select_2_value_1", "select_2_value_2"]
     *  ["--- CHOOSE ---", "Bill Gates", "Steve Jobs"]
     * ]
     * @type {Array}
     */
    originalOptionsValues = [];

    /**
     * Instantiates new objects of type SelectValidation.
     * @param selectIDs An array containing a unique identifier of a select for each element within it.
     * These identifiers do not necessarily have to be values of the 'id' attribute of an HTML tag, as long as they are unique.
     */
    constructor(selectIDs) {
        this.selectIDs = selectIDs;
        this.getSelectValues();
    }

    /**
     * Assigns the values that are present on the page at the time of calling the
     * function to the 'originalSelectsValue' and 'originalOptionsValues' arrays.
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
     * Verifies that all selected values of all selections are present within their respective options.
     * @returns {boolean} true if the selected value of all selections specified by an identifier contained
     * in the 'selectIDs' field is present in its options, false otherwise.
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
     * Verifies that the selected value of a single select is present within its options.
     * @param selectId The unique identifier corresponding to the select you want to validate.
     * It must be contained within the 'selectIDs' field. This identifier does not necessarily
     * have to correspond to the value of the 'id' attribute of an HTML tag, as long as it is unique.
     * @returns {boolean} true if the selected value of the select input identified
     * by the identifier specified as parameter is present within its available options.
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
     * Checks whether the current selected value of a select is the same as that which was selected when the page was loaded.
     * @param selectID The unique identifier of the select you want to check.
     * It doesn't have to be a value of the 'id' attribute of an HTML tag, as long as it is unique.
     * @returns {boolean} true if the current value is the same as it was when the page was loaded.
     */
    isValueSameAsOriginal(selectID) {

        if (this.selectIDs.indexOf(selectID) > -1) {

            let originalSelectValue = this.originalSelectsValues[this.selectIDs.indexOf(selectID)].trim();
            return $(`${selectID}`).val().trim() === originalSelectValue;

        }

        return false;

    }

}