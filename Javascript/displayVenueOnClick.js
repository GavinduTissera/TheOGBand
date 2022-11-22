class DisplayInformationOnclick
{
    // This class is responsible for showing the table and submit button, when a list element is clicked
    #listElements
    #table
    #submitButton

    //Constructor
    constructor() {
        this.#listElements = document.querySelectorAll(".VenueRow")
        this.#table = document.querySelector(".VenueInformationTable")
        this.#submitButton = document.getElementById("SubmitButtonTwo")
    }

    //Getters
    getListElements() {
        return this.#listElements
    }

    getTable() {
        return this.#table
    }

    getSubmitButton() {
        return this.#submitButton
    }

    //When a list element is clicked, display the table and the submit button.Doesn't remove the shown elements after
    getInformationOnClick() {
        var table = this.getTable()
        var SubmitButton = this.getSubmitButton()
        console.log(this.getListElements())
        this.getListElements().forEach(element => {
            element.addEventListener("click", function() {
                table.classList.replace("hide", "show")
                SubmitButton.classList.replace("hide", "show")
            })
        });
    }
}


//Creates an xmlHttpRequest, sets the venue rows and seperators
const xmlhttp = new XMLHttpRequest();
const VenueList = document.querySelector(".VenueNames")
const Seperators = document.querySelectorAll(".SeperatingBar")
//When the xmlhttprequest is loaded, it parses the json into object form from a string
xmlhttp.onload = function() {
    const myObj = JSON.parse(this.responseText);
    //The total amount of venues stored in the database
    var totalVenues = myObj.AmountOfVenues
    console.log(totalVenues)
    if (totalVenues > 0) {
        //Adds a new venue element for the table in UseExistingVenue
        for (let i = 0; i < totalVenues; i++) {
            SeperatingDiv = document.createElement("div")
            SeperatingDiv.classList.add("SeperatingBar", "show")
            VenueList.appendChild(SeperatingDiv)

            ListRow = document.createElement("li")
            ListRow.classList.add("VenueRow", "show")
            ListRow.id = i

            h4Tag = document.createElement("h4")
            h4Tag.classList.add("VenueNameOne")
            h4Content = document.createTextNode(myObj.VenueName[i])
            h4Tag.appendChild(h4Content)

            h5Tag = document.createElement("h5")
            h5Tag.classList.add("VenueNameTwo")
            if (myObj.VenueAddress[i].length > 40) {
                h5Content = document.createTextNode((myObj.VenueAddress[i]).substring(0,40)+"...")
            } else {
                h5Content = document.createTextNode((myObj.VenueAddress[i]))
            }
            
            h5Tag.appendChild(h5Content)

            ListRow.appendChild(h4Tag)
            ListRow.appendChild(h5Tag)
            VenueList.appendChild(ListRow)
        }        
    }
    //It then opens up the table and submit button when one of the list elements is clicked
    var information = new DisplayInformationOnclick
    information.getInformationOnClick()
    //Now that the venue rows have been created, it can now be set
    const VenueRows = document.querySelectorAll(".VenueRow")
    console.log(VenueList)
    // It then iterates through the rows in the table, adding an event listener to each, and then setting the values in the table to what venue was clicked
    VenueRows.forEach((element, index) => {
        element.addEventListener("click", function() {
            document.getElementById("VenueIDOutput").innerHTML = myObj.VenueID[index];
            document.getElementById("VenueNameOutput").innerHTML = myObj.VenueName[index];
            document.getElementById("VenueAddressOutput").innerHTML = myObj.VenueAddress[index];
            document.getElementById("VenueMaxCapacityOutput").innerHTML = myObj.VenueMaxCapacity[index];
            document.getElementById("venueID").value = myObj.VenueID[index];
        })
    }); 
    
}
//Makes sure that this is dynamic and won't refresh the page every time a new list element is clicked
xmlhttp.open("GET", "../../../Assets/Classes/ReturnVenuesClasses.php");
xmlhttp.send();

