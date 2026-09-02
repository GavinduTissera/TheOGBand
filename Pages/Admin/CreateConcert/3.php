<?php
    include "../../../Assets/Classes/dbConnectorClasses.php";
    session_start();
    // Doesn't allow non admins by checking in the database if they are admin
    if ($_SESSION["userisadmin"] !== 1) {
        header("location: ../../../Pages/login.php?error=InvalidPermissions");
    }
    include "../../../Assets/Includes/adminDashboardInc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../../CSS/reset.css">
    <link rel="stylesheet" href="../../../CSS/styles.css">
    <link rel="stylesheet" href="../../../CSS/PagesCSS/createconcert.css">
    <link rel="stylesheet" href="../../../CSS/PagesCSS/createConcertPages/concert3.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <script type="module" src="./../../../Javascript/adminmaps.js"></script>
    <script src="https://kit.fontawesome.com/62b71b12cb.js" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.0.2/dist/js/bootstrap.bundle.min.js"></script>
    <!-- === Link to javascript === -->
    
    <!--Document title-->
    <title>The OG Band Admin</title>
</head>
<body>


    <!--======NAV BAR======-->
    <header>
        <nav class="NavBar">
            <!--Text that goes to home screen when clicked-->
            <a class="LogoNavBar" href="Dashboard.php">THE OG BAND ADMIN</a>
            <ul class="NavBarList">
                <!--Options that form the navigation bar-->
                <li><a class="NavBarHome" href="../../../index.php#TopOfPage">USER HOME</a></li>
                <li><a class="NavBarAbout" href="../Dashboard.php">DASHBOARD</a></li>
                <li><a class="NavBarTour" href="../CreateConcert/1.php">CREATE CONCERT</a></li>
                <div class="DropdownProfileMenu">
                    <li><a class='NavBarProfile' href='index.php'>
                        <?php
                        //echo's out the name of the user. If it is longer than 10 characters it is truncated to not overfill the screen
                        if (strlen($_SESSION["userfirstname"]) >= 10) {
                            echo substr($_SESSION["userfirstname"],0,10)."...";
                        } else {
                            echo $_SESSION["userfirstname"];
                        }
                        
                        ?>
                    </a></li>
                    <div class="DropdownContent">
                        <li><a class="MyProfileDropdown" href="../../../Pages/MyProfile">MY PROFILE</a></li>
                        <li><a class="MyTicketsDropdown" href="../../../Pages/MyTickets">MY TICKETS</a></li>
                        <li><a class="SettingsDropdown" href="../../../Pages/Settings">SETTINGS</a></li>
                        <li class="LogoutButton"><a class="LogoutDropdown" href='../../../Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                    </div>
                </div>
            </ul>
        </nav>
        <hr>
    </header>

    <main>
        <!-- The progress bar visible at the top with the 4 stages. -->
        <div class="ProgressBar">
            <ul class="ProgressList">
                <div class="TopBar">
                    <li><a href="1.php" class="SideBarOverview One">
                        <i class="fa-solid fa-check"></i>
                        <h4 class="ProgressBarText Basics">EVENT BASICS</h4>
                    </a></li>
                    <li><a href="2.php" class="SideBarOverview Two">
                        <i class="fa-solid fa-check"></i>
                        <h4 class="ProgressBarText DateTime">DATE AND TIME</h4>
                    </a></li>
                    <li><a href="3.php" class="SideBarOverview Three">
                        <i class="fa-solid fa-3"></i>
                        <h4 class="ProgressBarText Location">LOCATION</h4>
                    </a></li>
                    <li><a href="4.php" class="SideBarOverview Four">
                        <i class="fa-solid fa-4"></i>
                        <h4 class="ProgressBarText Tickets">TICKETS</h4>
                    </a></li>
                </div>
            </ul>
            <div class="ProgressBarContainer">
                <div class="Bar"></div>
            </div>
        </div>

        <!-- MAIN CONTENT -->
        <h2 class="CreateConcertTitle">LOCATION</h1>
        <div class="MainForm">
            <div class="FormInformation">
                <form action="../../../Assets/Includes/createEventInc.php" method="post">
                    <h3 class="shortDescription"> Do you want to...</h3>
                    <div class="SelectOption">
                        <!-- Choosing between adding a new venue and searching for and selecting an existing one -->
                        <div class="AddNewVenue Option">
                            <button type="button" id="AddNewVenueButton" class="AddNewVenue Button deselected">
                                ADD NEW VENUE
                            </button>
                        </div>
                        <div class="SeperatorBar deselected" id="SeperatorBar"></div>
                        <div class="UseExistingVenue Option">
                            <button type="button" id="UseExistingVenueButton" class="UseExistingVenue Button deselected">
                                USE EXISTING VENUE
                            </button>
                        </div>
                    </div>
                    <!-- If add new venue is chosen, then these elements are displayed -->
                    <div class="AddNewVenueContent hide" id="AddNewVenue">
                        <div class="OneLineSubmission">
                            <!-- Error messages -->
                            <h4 class="errorMessage hide" id="errorMessage">The place you searched for doesn't exist</h4>
                            <label for="addressInput" class="FormText">
                                <h4 class="VenueAddressName">What is the address of your venue?</h4>
                                <h6 class="requiredStar">*</h6>
                            </label>
                            <input type="text" name="addressInput" id="addressInput" class="addressInput" placeholder="Enter a location" required>
                        </div>
                        <div class="OneLineSubmissions">
                            <div class="OneLineSubmission half submissionOne">
                                <label for="VenueNameInput" class="FormText">
                                    <h4 class="VenueName">What is the name of your venue?</h4>
                                    <h6 class="requiredStar">*</h6>
                                </label>
                                <input type="text" name="nameInput" id="VenueNameInput" class="VenueNameInput" value="" placeholder="Enter a name" required>
                            </div>
                            <div class="SeperatorBar"></div>
                            <div class="OneLineSubmission half submissionTwo">
                                <label for="MaxCapacityInput" class="FormText">
                                    <h4 class="MaxCapacity">Maximum amount of tickets you can sell?</h4>
                                    <h6 class="requiredStar">*</h6>
                                </label>
                                <input type="number" name="MaxCapacity" id="MaxCapacityInput" class="MaxCapacityInput" value="" placeholder="Enter a number" required>
                            </div>
                        </div>
                        
                        <div id="GoogleMapsVenue" class="GoogleMapsVenue"></div>
                        <div id="infowindowContent">
                            <span id="place-name" class="placeName title"></span><br>
                            <span id="place-address" class="placeAddress "></span>
                        </div>
                        <!-- Database data that is hidden from the user. It contains latitude/longitude data which is autofilled when the place is searched for -->
                        <div class="DatabaseData hide">
                            <input type="text" name="locationData" id="locationData" class="locationData" value="" required>
                        </div>
                        <!-- The submit buttons for page 3 have different names, so when submitted do different things according to what the data is.  -->
                        <button class="SubmitButton" id="SubmitButton" type="submit" name="submitPageThreeAddNew">
                            <span class="submitting">
                                SUBMIT
                            </span>  
                        </button>
                    </div>
                </form>
                <form action="../../../Assets/Includes/createEventInc.php" method="post">
                    <!-- If use existing venue option is chosen then these elements are displayed -->
                    <div class="UseExistingVenueContent One hide" id="UseExistingVenue">
                        <div class="OneLineSubmission">
                            <!-- Error message -->
                            <h4 class="errorMessage hide" id="errorMessage">The place you searched for doesn't exist. Try to add a new venue.</h4>
                            <label for="VenueNameInputSearch" class="FormText">
                                <!-- Searches for a venue name, every input button gets a refresh -->
                                <h4 class="VenueAddressName">Enter a venue name, and click on a venue from the dropdown to show more information</h4>
                            </label>
                            <input type="text" name="VenueNameInputSearch" id="VenueNameInputSearch" class="VenueNameInputSearch" placeholder="Venue name">
                        </div>
                        <div class="VenueNameList">
                            <!-- The venue rows are going to be placed here -->
                            <ul class="VenueNames" id="VenueNames"></ul>
                        </div>
                        <h3 class="HeaderVenueInformation">VENUE INFORMATION</h3>
                        <div class="VenueTable">
                            <table class="VenueInformationTable hide">
                                <thead>
                                    <tr class="row1">
                                        <th class="ID smallSize headerTable none" id="0">
                                            <div class="ColumnID ColumnBox">
                                                <div class="tooltip">
                                                    Venue ID
                                                    <h5 class="Tooltiptext">Unique Identification for every venue</h5>
                                                </div>
                                            </div>
                                        </th>
                                        <th class="EventNames headerTable none" id="1">
                                            <div class="ColumnID ColumnBox">
                                                Venue Name
                                            </div>
                                        </th>
                                        <th class="TicketName1 longSize headerTable none" id="2">
                                            <div class="ColumnID ColumnBox">
                                                Address
                                            </div>
                                        </th>
                                        <th class="TicketsBought smallSize headerTable none" id="3">
                                            <div class="ColumnID ColumnBox">
                                                Max Capacity
                                            </div>
                                        </th>
                                    </tr>
                                    <tr>
                                        <!-- Javascript fills out the table data -->
                                        <td id="VenueIDOutput"></td>
                                        <td id="VenueNameOutput"></td>
                                        <td id="VenueAddressOutput"></td>
                                        <td id="VenueMaxCapacityOutput"></td>
                                    </tr>
                                </thead>
                            </table>
                        </div>

                        <div class="DatabaseData hide">
                        <!-- Database data that is hidden from the user. It contains the venueID which is autofilled when the place is searched for -->
                            <input type="text" name="venueID" id="venueID" class="venueID" value="" required>
                        </div>
                        <button class="SubmitButton hide" id="SubmitButtonTwo" type="submit" name="submitPageThreeUseExisting">
                            <span class="submitting">
                                SUBMIT
                            </span>  
                        </button>
                    </div>
                    
                    <div class="BottomText">
                        <div class="FormText">
                            <h6 class="requiredStar">* </h6>
                            <h5 class="SmallText"> - Required</h6>
                        </div> <br>
                        <h5 class="SmallText FormText">New events are automatically set as unlisted until made public in the events menu</h5>
                    </div>
                    
                </div>
            </form>
        </div>
    </main>
    <!-- This script introduces the google maps api with places library enabled -->
    <script src="https://maps.googleapis.com/maps/api/js?key=APIKEY&callback=initMap&libraries=places" defer></script>
    <script src="../../../Javascript/displayVenueOnClick.js" async defer></script>
    <script src="../../../Javascript/CreateConcertButtons.js"async defer></script>
    <script src="../../../Javascript/listLinearSearch.js"async="false" defer></script>
    
</body>
</html>
