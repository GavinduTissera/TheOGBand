class DisplayInformationOnclick
{
    #listElements
    #table

    constructor() {
        this.#listElements = document.querySelectorAll(".VenueRow")
        this.#table = document.querySelector(".VenueInformationTable")
    }

    getListElements() {
        return this.#listElements
    }

    getTable() {
        return this.#table
    }

    getInformationOnClick() {
        var table = this.getTable()
        this.getListElements().forEach(element => {
            element.addEventListener("click", function() {
                table.classList.replace("hide", "show")
            })
        });
    }
}

const xmlhttp = new XMLHttpRequest();
xmlhttp.onload = function() {
    const myObj = JSON.parse(this.responseText);
    console.log("hi")
    document.getElementById("demo").innerHTML = myObj.VenueAddress[1];
}
console.log("hihi")
xmlhttp.open("GET", "../../../Assets/Classes/ReturnVenuesClasses.php");
xmlhttp.send();

var information = new DisplayInformationOnclick
information.getInformationOnClick()