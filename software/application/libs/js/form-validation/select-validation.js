class SelectValidation {

    selectIDs = [];

    originalSelectsValues = [];

    originalOptionsValues = [];

    constructor(selectIDs) {
        this.selectIDs = selectIDs;
        this.getOriginalValues();
    }

    getOriginalValues() {

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

    isValueSameAsOriginal(selectID) {

        if (this.selectIDs.indexOf(selectID) > -1) {

            let originalSelectValue = this.originalSelectsValues[this.selectIDs.indexOf(selectID)].trim();
            return $(`${selectID}`).val().trim() === originalSelectValue;

        }

        return false;

    }

}