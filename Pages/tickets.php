<?php
include "../Assets/Classes/dbConnectorClasses.php";
session_start()
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../CSS/reset.css">
    <link rel="stylesheet" href="../CSS/styles.css">
    <link rel="stylesheet" href="../CSS/PagesCSS/tickets.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script src="https://kit.fontawesome.com/62b71b12cb.js" crossorigin="anonymous"></script>
    <!-- === Link to javascript scroll reveal library === -->
    <script src="https://unpkg.com/scrollreveal@4"></script>
    <script src="https://maps.googleapis.com/maps/api/js?key=AIzaSyDEC7ZFii8nU71mliEGeU8YhoclN8eoJgs"></script>
    <script>
        ScrollReveal({
            distance: "100px",
            duration: 1500,
            delay: 200
        })
    </script>
    <!--Document title-->
    <title>The OG Band</title>
</head>

<body>
    <div class="Wrapper">
        <!--======NAV BAR======-->
        <header>
            <nav class="NavBar">
                <!--Text that goes to home screen when clicked-->
                <a class="LogoNavBar" href="../index.php#TopOfPage">THE OG BAND</a>
                <ul class="NavBarList">
                    <!--Options that form the navigation bar-->
                    <li><a class="NavBarHome" href="../index.php#TopOfPage">HOME</a></li>
                    <li><a class="NavBarAbout" href="../index.php#AboutUsSection">ABOUT</a></li>
                    <li><a class="NavBarTour" href="tour.php">BOOK TICKETS</a></li>
                    <!-- === CONTENT THAT CHANGES DEPENDENT ON LOGIN STATUS === -->
                    <!-- If user is admin, then they get access to the dashboard when they are logged in-->
                    <?php
                    if (isset($_SESSION["userid"])) {
                        if ($_SESSION["userisadmin"] === 1) {
                            echo "<li><a class='NavBarAdminDashboard' href='Admin/Dashboard.php'>DASHBOARD</a></li>";
                        }
                        /* If user is not an  admin, then they get access to logout and profile but not dashboard */
                    ?>
                        <div class="DropdownProfileMenu">
                            <li><a class='NavBarProfile' href='../index.php'>
                                    <?php
                                    //echo's out the name of the user. If it is longer than 10 characters it is truncated to not overfill the screen
                                    if (strlen($_SESSION["userfirstname"]) >= 10) {
                                        echo substr($_SESSION["userfirstname"], 0, 10) . "...";
                                    } else {
                                        echo $_SESSION["userfirstname"];
                                    }

                                    ?>
                                </a></li>
                            <div class="DropdownContent">
                                <li><a class="MyProfileDropdown" href="MyProfile">MY PROFILE</a></li>
                                <li><a class="MyTicketsDropdown" href="MyTickets">MY TICKETS</a></li>
                                <li><a class="SettingsDropdown" href="Settings">SETTINGS</a></li>
                                <li class="LogoutButton"><a class="LogoutDropdown" href='../Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                            </div>
                        </div>

                    <?php
                        /* If user is not logged in, they get login&signup */
                    } else {

                        echo "<li><a class='NavBarLoginSignup' href='login.php'>LOGIN&SIGNUP</a></li>";
                    }
                    ?>
                </ul>
            </nav>
            <hr>
        </header>
        <div class="BuyTicketsPopup">
            <div class="PopupBox">
                <!-- Used as close button -->
                <i class="fa-solid fa-xmark closeButton"></i>
                <div class="ProgressBar">
                    <!-- Shows the stages of buying the ticket -->
                    <ul class="ProgressList">
                        <div class="TopBar">
                            <li class="One">
                                <i class="fa-solid fa-1"></i>
                                <h4 class="ProgressBarText Basics">SELECT TICKETS</h4>
                            </li>
                            <li class="Two">
                                <i class="fa-solid fa-2"></i>
                                <h4 class="ProgressBarText Basics">PAYMENT</h4>
                            </li>
                        </div>
                    </ul>
                    <div class="ProgressBarContainer">
                        <div class="Bar"></div>
                    </div>
                </div>
                <div class="RestOfTicketContent">
                <h2 class="ChooseTicketTypeTitle">CHOOSE YOUR TICKET TYPE</h2>
                    <div class="TicketTypeSelector">
                        <div class="TicketArea"></div>
                        <div class="TicketInformationArea"></div>
                    </div>
                    <div class="verticalDivider"></div>
                </div>
            </div>
        </div>
        <main>
            <div class="mainPoster">
                <img class="bandPicturePosterbig" src="../Images/BestBandPictures/fullbandbanner.png" alt="Band Picture">
                <div class="posterPicture">
                    <img class="bandPicturePoster" src="../Images/BestBandPictures/fullbandbanner.png" alt="Band Picture">
                </div>
            </div>
            <div class="Title">
                <h2 class="eventName"></h2>
                <div class="Date">
                    <i class="fa-regular fa-calendar"></i>
                    <h3 class="eventDateTime"></h3>
                </div>
                <div class="Address">
                    <i class="fa-solid fa-location-dot"></i>
                    <h3 class="eventLocation"></h3>
                </div>
            </div>

            <div class="RestSection">
                <div class="Description">
                    <h2 class="Heading descriptionHeader">EVENT DESCRIPTION</h2>
                    <h3 class="eventDescription"></h3>
                </div>
                <button>
                    <div class="BuyTickets">
                        <h3 class="BuyTicketsText">BUY TICKETS</h3>
                    </div>
                </button>

                <div class="Divider dividerOne"></div>
                <div class="DateTime">
                    <h2 class="Heading dateTimeHeader">DATE AND TIME</h2>
                    <div class="EventTimes">
                        <div class="eventStartTime">
                            <i class="fa-solid fa-hourglass-start"></i>
                            <h3 class="eventStartTimeText"></h3>
                        </div>
                        <h3 class="timeDivider">TO</h3>
                        <div class="eventEndTime">
                            <i class="fa-solid fa-hourglass-end"></i>
                            <h3 class="eventEndTimeText"></h3>
                        </div>

                    </div>
                </div>
                <div class="Divider"></div>
                <div class="Location">
                    <h2 class="Heading locationHeader">LOCATION</h2>
                    <div class="venueInformation">
                        <div class="venueNameDiv">
                            <i class="fa-solid fa-thumbtack"></i>
                            <h3 class="venueName"></h3>
                        </div>
                        <div class="venueAddressDiv">
                            <i class="fa-solid fa-location-dot"></i>
                            <h3 class="venueAddress"></h3>
                        </div>
                    </div>
                    <div class="googleMaps"></div>
                    <div id="infowindowContent">
                        <span id="place-address" class="placeAddress "></span>
                    </div>
                </div>
                <div class="Divider"></div>
            </div>
        </main>
    </div>
    <script>
        //Gets the ID from the URL
        let params = new URLSearchParams(location.search)
        var id = params.get("id")
        //Generates a new request 
        xmlhttp = new XMLHttpRequest();
        //When the page is loaded, it takes the information from the php file "showConcertDatesClasses.php" and then gets the json data from that.
        xmlhttp.onload = function() {
            console.log(this.responseText)
            //Parses the JSOn data and then for each event, creates a new row 
            JSONResponse = JSON.parse(this.responseText)
            //Puts the correct data within the containers
            var eventName = document.querySelector(".eventName")
            eventName.innerHTML = JSONResponse[0][1][0]["EventName"]
            var eventDateTime = document.querySelector(".eventDateTime")
            eventDateTime.innerHTML = JSONResponse[0][1][0]["EventDateTime"]
            var eventLocation = document.querySelector(".eventLocation")
            var fullLocation = JSONResponse[0][1][0]["EventLocation"]
            //If the location is too long, it gets truncated. The full location will be seen below
            if (fullLocation.length > 60) {
                fullLocation = fullLocation.slice(0, 60) + "..."
            }
            eventLocation.innerHTML = fullLocation
            var eventDescription = document.querySelector(".eventDescription")
            eventDescription.innerHTML = JSONResponse[0][1][0]["EventDescription"]
            var eventStartTime = document.querySelector(".eventStartTimeText")
            eventStartTime.innerHTML = JSONResponse[0][1][0]["EventStartTime"]
            var eventEndTime = document.querySelector(".eventEndTimeText")
            eventEndTime.innerHTML = JSONResponse[0][1][0]["EventEndTime"]
            var venueName = document.querySelector(".venueName")
            venueName.innerHTML = JSONResponse[0][1][0]["VenueName"]
            var venueAddress = document.querySelector(".venueAddress")
            venueAddress.innerHTML = JSONResponse[0][1][0]["Address"]

            //GOOGLE MAPS
            function initMap() {
                //Getting the geocoded map data, and formatting it so I get the specific latitude and longditude
                var locationData = JSONResponse[0][1][0]["LocationData"]
                var fulllatlng = locationData.replace(/[()]/g, "")
                const latlngStr = fulllatlng.split(",", 2);
                const latlng = {
                    lat: parseFloat(latlngStr[0]),
                    lng: parseFloat(latlngStr[1]),
                };
                // Putting the map in the correct div, and setting parameters
                const map = new google.maps.Map(document.querySelector(".googleMaps"), {
                    zoom: 8,
                    center: {
                        lat: latlng.lat,
                        lng: latlng.lng
                    },
                });
                const geocoder = new google.maps.Geocoder();
                const infowindow = new google.maps.InfoWindow();
                //Sets the geocoded address to be the one set by the admin so users don't get confused in case there is a slight change in address
                var geocodedAddress = JSONResponse[0][1][0]["Address"]
                console.log(geocodedAddress)
                geocodeLatLng(geocoder, map, infowindow, latlng, geocodedAddress);
            }

            function geocodeLatLng(geocoder, map, infowindow, latlngObject, geocodedAddress) {
                geocoder
                    .geocode({
                        location: latlngObject
                    })
                    //If it gets geocoded properly, then it adds a marker with the address on it as an infowindow
                    .then((response) => {
                        if (response.results[0]) {
                            map.setZoom(11);

                            const marker = new google.maps.Marker({
                                position: latlngObject,
                                map: map,
                            });
                            var InfoWindowContent = document.getElementById("infowindowContent")
                            InfoWindowContent.children["place-address"].textContent = geocodedAddress
                            infowindow.setContent(InfoWindowContent);
                            infowindow.open(map, marker);
                        } else {
                            window.alert("No results found");
                        }
                    })
                    .catch((e) => window.alert("Geocoder failed due to: " + e));
            }

            window.initMap = initMap()

            //TICKETS POPUP BOX
            const BuyTicketsPopup = document.querySelector(".BuyTicketsPopup")
            const BuyTicketsButton = document.querySelector(".BuyTickets")
            const CloseButton = document.querySelector(".closeButton")
            //Opens the popup screen when the buy tickets button is clicked and remove it when it is closed
            BuyTicketsButton.addEventListener("click", function() {
                BuyTicketsPopup.classList.add("active")
            })

            CloseButton.addEventListener("click", function() {
                BuyTicketsPopup.classList.remove("active")
            })

            //Getting the tickets into the right place
            const TicketsArea = document.querySelector(".TicketArea")
            const TicketsInformationArea = document.querySelector(".TicketInformationArea")
            var amountOfTickets = JSONResponse[1][0].length
            for (let i = 0; i < amountOfTickets; i++) {
                CreateTicket(i, TicketsArea)    
            }

            //Creates a new ticket row
            function CreateTicket(ticketNum, TicketsArea) {
                //Uses dom manipulation to create elements, add their classnames and text content, and put them all within the ticketArea box
                var TicketBox = document.createElement("div")
                var TicketNameDiv = document.createElement("div")
                var TicketPriceDiv = document.createElement("div")
                var TicketDivider = document.createElement("div")
                
                var TicketName = document.createElement("h2")
                var TicketPrice = document.createElement("h2")
                TicketName.innerText = JSONResponse[1][1][ticketNum]["TicketName"]
                TicketPrice.innerText = "£ "+JSONResponse[1][1][ticketNum]["TicketPrice"]
                var isTicketAvailable = JSONResponse[1][1][ticketNum]["TicketAvailability"]
                //Gets the boolean value of TicketAvailability and converts it into text
                if (isTicketAvailable == 0) {
                    TicketBox.classList.add("Unavailable")
                    TicketPrice.innerText = "SOLD OUT"
                    TicketBox.style.pointerEvents = "none"
                    TicketBox.style.cursor = "not-allowed"
                } else {
                    TicketBox.classList.add("Available")
                    TicketBox.addEventListener("click", function() {
                        DisplayTicketContent(ticketNum)
                    })
                }
                
                TicketBox.classList.add("TicketBox", ticketNum)
                TicketNameDiv.classList.add("TicketNameDiv")
                TicketPriceDiv.classList.add("TicketPriceDiv")
                TicketName.classList.add("TicketName")
                TicketPrice.classList.add("TicketPrice")
                TicketDivider.classList.add("TicketDivider")
                TicketNameDiv.append(TicketName)
                TicketPriceDiv.append(TicketPrice)
                TicketBox.append(TicketNameDiv, TicketPriceDiv)
                TicketsArea.append(TicketBox, TicketDivider)
            }

            function DisplayTicketContent(ticketNum) {
                console.log(ticketNum)

                if (document.contains(document.querySelector(".TicketInfoBox"))) {
                    document.querySelector(".TicketInfoBox").remove()
                }
                var TicketInfoBox = document.createElement("div")
                var TicketNameDiv = document.createElement("div")
                var TicketPriceDiv = document.createElement("div")
                var TicketDescriptionDiv = document.createElement("div")
                var TicketsLeftDiv = document.createElement("div")
                var TicketSelectorDiv = document.createElement("div")
                var SubmitDiv = document.createElement("div")

                var TicketName = document.createElement("h2")
                var TicketPrice = document.createElement("h2")
                var TicketDescription = document.createElement("h2")
                var TicketsLeft = document.createElement("h2")
                var TicketSelector = document.createElement("select")

                TicketName.innerText = JSONResponse[1][1][ticketNum]["TicketName"]
                TicketPrice.innerText = "£ "+JSONResponse[1][1][ticketNum]["TicketPrice"]
                TicketDescription.innerText = JSONResponse[1][1][ticketNum]["TicketDescription"]


                //TotalTicketsLeft is the amount of tickets the event has left to sell. TicketsLeftNum is the total amount of tickets that the particular ticket type has left to sell. Max Tickets is the restriction of the amount of tickets someone can buy at a time
                var TotalVenueCapacity = JSONResponse[0][1][0]["MaxCapacity"]
                var TotalTicketsSold = JSONResponse[0][1][0]["TotalTicketsBought"]
                var TotalTicketsLeft = TotalVenueCapacity-TotalTicketsSold
                var TicketQuantity = JSONResponse[1][1][ticketNum]["TicketQuantity"]
                var TicketsSold = JSONResponse[1][1][ticketNum]["TicketsSold"]
                var TicketsLeftNum = TicketQuantity-TicketsSold
                MaxTickets = JSONResponse[1][1][ticketNum]["MaxTickets"]
                if (TicketsLeftNum < TotalTicketsLeft) {
                    TicketsLeft.innerText = "There are "+TicketsLeftNum+" tickets left"
                    var lowerAmount = TicketsLeftNum
                } else {
                    TicketsLeft.innerText = "There are "+TotalTicketsLeft+" tickets left"
                    var lowerAmount = TotalTicketsLeft
                }
                

                TicketSelector.setAttribute("onfocus", "this.size=5;")
                TicketSelector.setAttribute("onblur", "this.size=1;")
                TicketSelector.setAttribute("onchange", "this.size=1; this.blur();")

                //This just checks for the lowest amount among 50 (since thats the hard limit on amount of tickets someone should buy at a time), Amount of tickets left for the ticket type, and amount of tickets left for the venue
                if (MaxTickets >= 50 && lowerAmount >= 50) {
                    for (let i = 0; i <= 50; i++) {
                        CreateTicketOption(i, TicketSelector)

                    }
                } else if (MaxTickets < lowerAmount) {
                    for (let i = 0; i <= MaxTickets; i++) {
                        CreateTicketOption(i, TicketSelector)
                    }
                } else if (MaxTickets >= lowerAmount){
                    for (let i = 0; i <= lowerAmount; i++) {
                        CreateTicketOption(i, TicketSelector)
                    }
                }

                //Adds all of the classes and appends them in the correct spaces
                TicketInfoBox.classList.add("TicketInfoBox")
                TicketNameDiv.classList.add("InfoTicketNameDiv")
                TicketPriceDiv.classList.add("InfoTicketPriceDiv")
                TicketDescriptionDiv.classList.add("InfoTicketDescriptionDiv")
                TicketsLeftDiv.classList.add("InfoTicketsLeftDiv")
                TicketSelectorDiv.classList.add("TicketSelectorDiv")
                SubmitDiv.classList.add("SubmitDiv")
                TicketName.classList.add("TicketName")
                TicketPrice.classList.add("TicketPrice")
                TicketDescription.classList.add("TicketDescription")
                TicketsLeft.classList.add("TicketsLeft")
                TicketSelector.classList.add("TicketSelector")
                TicketNameDiv.append(TicketName)
                TicketPriceDiv.append(TicketPrice)
                TicketDescriptionDiv.append(TicketDescription)
                TicketsLeftDiv.append(TicketsLeft)
                TicketSelectorDiv.append(TicketSelector)
                TicketInfoBox.append(TicketNameDiv, TicketPriceDiv, TicketDescriptionDiv, TicketsLeftDiv, TicketSelectorDiv, SubmitDiv)
                TicketsInformationArea.append(TicketInfoBox)
            }

            //Creates an option under the TicketSelector, given a ticketNumber (aka i)
            function CreateTicketOption(ticketNumber, TicketSelector) {
                var TicketOption = document.createElement("option")
                TicketOption.value = ticketNumber
                TicketOption.classList.add(ticketNumber, "ticketOption")      
                TicketOption.innerText = ticketNumber
                TicketSelector.append(TicketOption)
            }
        }
        xmlhttp.open("GET", '../Assets/Classes/GetEventDetailsClasses.php?id=' + id);
        xmlhttp.send();
    </script>

</body>

</html>