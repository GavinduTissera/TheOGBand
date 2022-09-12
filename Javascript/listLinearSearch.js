class LinearSearch {

    // This class takes a list of venues and on ever keystroke, removes items that don't fit with what is typed. It uses a linear search method to do this, except it returns all rows that fit the input.

    #inputField
    #fullList
    #listElements
    #venueName
    #separators
    #activeListElement
    // Class constructor. Sets document details
    constructor() {
        this.#inputField = document.getElementById("VenueNameInputSearch")
        this.#fullList = document.getElementById("VenueNames")
        this.#listElements = document.querySelectorAll(".VenueRow")
        this.#venueName = document.querySelectorAll(".VenueNameOne")
        this.#separators = document.querySelectorAll(".SeperatingBar")
        this.#activeListElement = document.querySelectorAll(".VenueRow.show")
    }

    // Getters
    getInputField() {
        return this.#inputField;
    }

    getFullList() {
        return this.#fullList;
    }

    getListElements() {
        return this.#listElements;
    }

    getVenueNames() {
        return this.#venueName;
    }

    getSeperators() {
        return this.#separators;
    }

    getActiveListElements() {
        return this.#activeListElement;
    }

    setActiveListElements() {
        let ActiveList = document.querySelectorAll(".VenueRow.show")
        this.#activeListElement = ActiveList
    }

    //Gets the value from the input box and converts it to uppercase to make it case insensitive
    getInputValue() {
        let temp = this.getInputField().value.toUpperCase()
        return temp 
    }

    // Get the venue name for that index passed to the function
    getVenueFromVenueNames(num) {
        let InnerVenueName = this.getVenueNames()[num]
        return InnerVenueName.innerHTML
    }

    // Get the list element that corresponds to the index passed to the function
    getListFromListElements(num) {
        return this.getListElements()[num]
    }

    getSeperatorFromSeperators(num) {
        return this.getSeperators()[num]
    }
        
    getActiveListFromListElements(num) {
        return this.getActiveListElements()[num]
    }


    // This is the search algorithm. It iterates through the length of the list elements.
    searchAlgorithm(inputValue) {
        for (let i = 0; i < this.getListElements().length; i++) {
            // It gets the venue names for each index, and compares it to the input value. If indexOf returns -1, the text in the input doesn't exist in the venue name so it is removed
            let TextVenueName = this.getVenueFromVenueNames(i).trim()
            if (TextVenueName.toUpperCase().indexOf(inputValue) > -1) {
                // This line is necessary in case the text in the input field is removed. Also removes the seperators
                this.getListFromListElements(i).classList.remove("hide", "show")
                this.getSeperatorFromSeperators(i).classList.remove("hide", "show")
                this.getListFromListElements(i).classList.add("show")
                this.getSeperatorFromSeperators(i).classList.add("show")
            } else {
                this.getListFromListElements(i).classList.replace("show", "hide")
                this.getSeperatorFromSeperators(i).classList.replace("show", "hide")
            }
               
        }
    }

    removeExcessListElements(ActLength) {
        if (ActLength > 5) {
            for (let i = 5; i < ActLength; i++) {
                this.getActiveListFromListElements(i).classList.replace("show", "hide")
                this.getSeperatorFromSeperators(i).classList.replace("show", "hide")
            }
        }  
    }
}

class initiateSearch{

    startSearch() {
        // every time a key is pressed 
        search.getInputField().addEventListener("input", function() {
            var search = new LinearSearch()
            var newValue = search.getInputValue().toUpperCase()
            search.searchAlgorithm(newValue)
            search.setActiveListElements()
            var ActiveElementslength = search.getActiveListElements().length
            search.removeExcessListElements(ActiveElementslength)
        })
    }
}
var inisearch = new initiateSearch
var search = new LinearSearch
var ActiveElementslength = search.getActiveListElements().length
search.removeExcessListElements(ActiveElementslength)
inisearch.startSearch()
