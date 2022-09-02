var arr = []
var OptionCreate

export function MinutesOptionCreator() {
    arr = []
    // Sets a for loop, that goes from 0 to 55 in incremenets of 5. It creates the option with that number, and pushes it to an array
    for (let i = 0; i <= 55; i+=5) {
        OptionCreate = OptionCreator(i)
        arr.push(OptionCreate)
    }
    //The array is then returned
    return arr
}
export function HoursOptionCreator() {
    arr = []
    // Sets a for loop, that goes from 0 to 24. It creates the option with that number, and pushes it to an array
    for (let i = 0; i <= 23; i++) {
        OptionCreate = OptionCreator(i)
        arr.push(OptionCreate)
    }
    //The array is then returned
    return arr
}

function OptionCreator(num) {
    // Creates a HTML option element
    let OptionElement = document.createElement("option")
    //Adds an extra 0 if the num is less than 10 to make sure all numbers have 2 digits
    let NewNumber = num.toString().padStart(2,"0");
    // Adds the text to the option element, Then adds a value of the number chosen
    let OptionInnerText = document.createTextNode(NewNumber)
    OptionElement.appendChild(OptionInnerText)
    OptionElement.value = (num.toString().padStart(2,"0"))
    return OptionElement
}

