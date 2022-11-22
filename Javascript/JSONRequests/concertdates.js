
//Generates a new request 
xmlhttp = new XMLHttpRequest();
//When the page is loaded, it takes the information from the php file "showConcertDatesClasses.php" and then gets the json data from that.
xmlhttp.onload = function() {
    //Parses the JSOn data and then for each event, creates a new row 
    JSONResponse = JSON.parse(this.responseText)
    console.log(JSONResponse)
    
    //Creates a new row for each event. Fill it with the event details
    for (let i = 0; i < JSONResponse[3]; i++) {
        console.log(i)
        var EventsTableRow = createNewElement(i)
        EventsTable.append(EventsTableRow)
    }
}
xmlhttp.open("GET",'../Assets/Classes/showConcertDatesClasses.php');
xmlhttp.send();


const EventsTable = document.querySelector(".MyEventsTable")

function createNewElement(i) {

    // This function dynamically creates a new row based on the json data given. It creates all the text nodes individually and combines them in the right order with the right data.
    // DAY AND MONTH BOX 
    var EventsTableRow = document.createElement("div")
    EventsTableRow.className = "EventsTableRow"

    var DayAndMonthBox = document.createElement("div")
    DayAndMonthBox.className = "DayAndMonthBox"

    var EventMonth = document.createElement("h4")
    EventMonth.className = "EventMonth"
    var EventMonthText = document.createTextNode((JSONResponse[1][i]["MONTHNAME(EventStartTime)"]).slice(0,3).toUpperCase())
    EventMonth.append(EventMonthText)

    var EventDay = document.createElement("h3")
    EventDay.className = "EventDay"
    var EventDayText = document.createTextNode(JSONResponse[1][i]["DAY(EventStartTime)"])
    EventDay.append(EventDayText)

    DayAndMonthBox.append(EventMonth)
    DayAndMonthBox.append(EventDay)

    // REST OF EVENT CONTENT
    var RestOfEventContent = document.createElement("div")
    RestOfEventContent.className = "RestOfEventContent"

    var EventName = document.createElement("h3")
    EventName.className = "EventName"
    var EventNameText = document.createTextNode(JSONResponse[1][i]["EventName"])
    EventName.append(EventNameText)

    var TimeAndCity = document.createElement("div")
    TimeAndCity.className = "TimeAndCity"

    var EventTime = document.createElement("h4")
    EventTime.className = "EventTime"
    //Slices to remove the seconds from the Time format.
    var EventTimeText = document.createTextNode("Start Time: " + (JSONResponse[1][i]["TIME(EventStartTime)"]).slice(0,5))
    var clockIcon = document.createElement("i")
    clockIcon.className = "uil uil-clock"
    EventTime.append(clockIcon)
    EventTime.append(EventTimeText)

    var EventVenueNameCity = document.createElement("h4")
    EventVenueNameCity.className = "EventVenueNameCity"
    var EventVenueNameCityText = document.createTextNode(JSONResponse[1][i]["VenueName"])
    var locationIcon = document.createElement("i")
    locationIcon.className = "uil uil-location-pin-alt"
    EventVenueNameCity.append(locationIcon)
    EventVenueNameCity.append(EventVenueNameCityText)

    TimeAndCity.append(EventTime)
    TimeAndCity.append(EventVenueNameCity)

    // BUTTONS
    var Buttons = document.createElement("div")
    Buttons.className = "Buttons"


    var ViewTicketPageButton = document.createElement("div")
    ViewTicketPageButton.className = "ViewTicketPageButton"
    var ButtonLinkTwo = document.createElement("a") 
    console.log(JSONResponse[1][i]["EventID"])
    //Adds a link to the button that goes to the correctID
    ButtonLinkTwo.href = "../Pages/tickets.php?id=" + JSONResponse[1][i]["EventID"]
    var ViewTicketPage = document.createElement("button")
    ViewTicketPage.className = "ViewTicketPage"
    var ViewTicketPageTextNode = document.createElement("h4")
    ViewTicketPageTextNode.className = "ViewTicketPageText"
    var ViewTicketPageText = document.createTextNode("TICKETS")
    ViewTicketPageTextNode.append(ViewTicketPageText)
    ViewTicketPage.append(ViewTicketPageTextNode)
    ButtonLinkTwo.append(ViewTicketPage)
    ViewTicketPageButton.append(ButtonLinkTwo)
    Buttons.append(ViewTicketPageButton)

    var maxCapacity = JSONResponse[2][1][i]["MaxCapacity"]
    var TotalTicketsBought = JSONResponse[2][1][i]["TotalTicketsBought"]
    //Checks to see if the concert is sold out. If it is then doesn't allow the user to click on it and changes the text
    if (TotalTicketsBought >= maxCapacity ) {
        console.log("capacity reached")
        ViewTicketPageText.textContent = "SOLD OUT"
        ViewTicketPageButton.style.pointerEvents = "none"
        ViewTicketPageButton.style.cursor = "not-allowed"
        ViewTicketPage.disabled = true
    }
    RestOfEventContent.append(EventName)
    RestOfEventContent.append(TimeAndCity)
    RestOfEventContent.append(Buttons)

    EventsTableRow.append(DayAndMonthBox)
    EventsTableRow.append(RestOfEventContent)
    return EventsTableRow
}