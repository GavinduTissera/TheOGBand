// Getting the data from the form and putting it in a javascript object

//Setting constants of elements
const form = document.querySelector(".AddNewTicketForm")
const SubmitButton = document.querySelector(".SubmitTicket")
const NoneCreatedAlert = document.querySelector(".NoneCreatedAlert")
const ActiveTicketsList = document.querySelector(".ActiveTickets")
const TicketHeaders = document.querySelector(".TicketHeaders")
const SubmitForm = document.querySelector(".SubmitButton")
const errorMessage = document.getElementById("errorMessageTwo")
const nameErrorMessage = document.getElementById("errorMessageName")
const DatabaseDataInput = document.querySelector(".TicketObjects")
const CreatedTicketsHeader = document.querySelector(".CreatedTicketsHeader")
var CopyTickets = document.querySelectorAll(".CopyTicket")
var DeleteTickets = document.querySelectorAll(".DeleteTicket")

//Setting the total amount of tickets that can be sold into the header
//Getting Capacity from the URL
let params = new URLSearchParams(location.search)
var Capacity = params.get("Capacity")
CreatedTicketsHeader.innerHTML = "TOTAL CAPACITY: " + Capacity

//Putting a count to see how many tickets have been created
var count = 0
var TotalTicketsUsed = 0
var value = Object
var TicketArray = []
console.log(SubmitButton)
console.log(TicketArray)
form.addEventListener("submit", function(event) {
    //Stops the form from submitting if there are no tickets and displays an error message
    if (count == 0) {
        event.stopImmediatePropagation()
        event.preventDefault()
        errorMessage.classList.replace("hide", "show")
    }
    //Sets the invisible databasedata input to the JSON text representing the tickets
    DatabaseDataInput.setAttribute("value", JSON.stringify(TicketArray))
})
//Checking to see if the Add ticket button has been pressed
SubmitButton.addEventListener("click", function() {
    //Getting the form data and putting it in a javscript object called value
    const formData = new FormData(document.querySelector(".AddNewTicketForm"))
    value = Object.fromEntries(formData.entries());
    //Stops the ticket from being included if it doesn't have a name (the required attribute doesn't work as technically the form isn't being submitted)
    if (value.ticketNameInput == "") {
        nameErrorMessage.classList.replace("hide", "show")
    } else {
        NoneCreatedAlert.classList.replace("show", "hide")
        errorMessage.classList.replace("show", "hide")
        nameErrorMessage.classList.replace("show", "hide")
        TicketHeaders.classList.replace("hide", "show")
        SubmitForm.classList.replace("hide", "show")
        //Adds an element to the table above the  form
        CreateListElement(value)
        //Updates the copytickets and deletetickets queryselectors
        CopyTickets = document.querySelectorAll(".CopyTicket")
        DeleteTickets = document.querySelectorAll(".DeleteTicket")
        console.log(value)
        
    }
    
})




function CreateListElement(value) {
    count +=1
    value.count = count
    //Creates a list element
    liElement = document.createElement("li")
    //Creates the div that fits the ticket number inside, and adds the class name
    TicketTypeNumberDiv = document.createElement("div")
    TicketTypeNumber = document.createTextNode(value.count)
    TicketTypeNumberDiv.classList.add("TicketTypeNumber")
    TicketTypeNumberDiv.appendChild(TicketTypeNumber)

    //Creates the div that fits the ticket name inside, and adds the class name TicketNameDiv
    TicketNameDiv = document.createElement("div")
    TicketName = document.createTextNode(value.ticketNameInput)
    TicketNameDiv.classList.add("TicketNameDiv")
    //Appends the ticketName to the div box
    TicketNameDiv.appendChild(TicketName)

    //Creates the div that fits the ticket quantity inside, and adds the class name
    TicketAmountDiv = document.createElement("div")
    //If the amount of tickets isn't set, then it sets the amount of tickets to unlimited
    if (value.AmountOfTicketsInput == "") {
        TicketAmount = document.createTextNode("Unlimited")
    } else {
        TicketAmount = document.createTextNode(Math.round(value.AmountOfTicketsInput))
    }
    TicketAmountDiv.classList.add("TicketAmount")
    TicketAmountDiv.appendChild(TicketAmount)

    //Creates the div that fits the ticket Price inside, and adds the class name
    TicketPriceDiv = document.createElement("div")
    //If the amount of tickets isn't set, then it sets the amount of tickets to unlimited
    if (value.TicketPriceInput == "") {
        TicketPrice = document.createTextNode("£0.00")
    } else {
        var TicketPriceInput = Number(value.TicketPriceInput).toFixed(2)
        TicketPrice = document.createTextNode("£" + TicketPriceInput)
    }
    TicketPriceDiv.classList.add("TicketPrice")
    TicketPriceDiv.appendChild(TicketPrice)

    //adding the copy icon
    CopyIconDiv = document.createElement("div")
    Icon = document.createElement("i")
    Icon.classList.add("uil", "uil-copy")
    CopyIconDiv.classList.add("CopyTicket")
    CopyIconDiv.appendChild(Icon)

    //Adding the delete icon
    DeleteIconDiv = document.createElement("div")
    Icon = document.createElement("i")
    Icon.classList.add("uil", "uil-trash-alt")
    DeleteIconDiv.classList.add("DeleteTicket")
    DeleteIconDiv.appendChild(Icon)

    //Appends the div boxes to the list element
    liElement.appendChild(TicketTypeNumberDiv)
    liElement.appendChild(TicketNameDiv)
    liElement.appendChild(TicketAmountDiv)
    liElement.appendChild(TicketPriceDiv)
    liElement.appendChild(CopyIconDiv)
    liElement.appendChild(DeleteIconDiv)
    //Adds the class name TicketElement and the count to the list
    liElement.classList.add("TicketElement", count)
    TicketArray.push(value)

    //Adding the event listener for the copy button
    CopyIconDiv.addEventListener("click", function(copy) {
        //Gets the path of the pointer event that leads to the li element, gets the classname and removes the "ticketelement" part to leave the id number
        var listNumber = copy.path[2].className.substring(14)
        CreateListElement(TicketArray[listNumber-1]) 
    })

    //Adding event listener for delete button
    DeleteIconDiv.addEventListener("click", function(del) {
        var TicketIdElement = document.querySelectorAll(".TicketTypeNumber")
        //Gets the number of the list from the class name
        var listNumber = del.path[2].className.substring(14)
        //Removes the list element from the screen and the ticket array 
        TicketArray.splice(listNumber-1, 1)
        del.path[2].remove()
        //Subtracts 1 from the count
        count -=1
        console.log({TicketIdElement})
        console.log(listNumber)
        console.log(count)
        if (listNumber <= count) {
            for (let i = listNumber-1; i <= count; i++) {
                console.log(i)
                if (i != 0) {
                    listItemToChange = del.path[3].children[i-1]
                    console.log(listItemToChange)
                    listItemToChange.removeAttribute("class")
                    listItemToChange.classList.add("TicketElement", i)
                    TicketIdElement[i].textContent -=1
                }
                

            }
        } 
    })
    //Appends the liElement to the ActiveTicketsList
    ActiveTicketsList.appendChild(liElement)

}