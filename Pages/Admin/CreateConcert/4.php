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
    <link rel="stylesheet" href="../../../CSS/PagesCSS/createConcertPages/concert4.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
                        <i class="fa-solid fa-check"></i>
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
        <h2 class="CreateConcertTitle">TICKETS</h1>
        <div class="MainForm">
            <div class="FormInformation">
                <h3 class="shortDescription">Create your ticket types here</h3>
                <h3 class="CreatedTicketsHeader">TICKETS IN THIS EVENT</h3>
                <div class="ActiveTicketsTable">
                    <h4 class="NoneCreatedAlert show">No tickets have been made yet. <br> Press the Add Tickets button to create a ticket type</h4>
                    <div class="TicketHeaders hide">
                        <h4 class="TicketID">ID</h4>
                        <h4 class="TicketName">Name</h4>
                        <h4 class="TicketQuantity">Quantity</h4>
                        <h4 class="TicketPrice">Price</h4>
                        <h4 class="Actions">Actions</h4>
                    </div>
                    <ul class="ActiveTickets">
                        
                    </ul>
                </div>
                <div class="AddNewTicketType Option">
                <h3 class="AddNewTicketHeader">ADD NEW TICKET TYPE</h3>
                </div>
                <div class="CreateTicketType">
                    <form class="AddNewTicketForm" action="../../../Assets/Includes/createEventInc.php" method="post">
                        <div class="OneLineSubmission">
                            <h4 class="errorMessage hide" id="errorMessage">There is an error somewhere in your submission.</h4>
                            <h4 class="errorMessage hide" id="errorMessageTwo">Make sure to create at least 1 ticket type before submitting the form.<br> Click the add ticket button to add a ticket type.</h4>
                            <h4 class="errorMessage hide" id="errorMessageName">Make sure that your ticket has a name.</h4>
                            <label for="TicketNameInput" class="FormText">
                                <h4 class="TicketName">What is the name of the ticket?</h4>
                                <h6 class="requiredStar">*</h6>
                            </label>
                            <input type="text" name="ticketNameInput" id="ticketNameInput" class="ticketNameInput" placeholder="e.g. Standing Ticket" required>
                        </div>
                        <div class="OneLineSubmissions">
                            <div class="OneLineSubmission half submissionOne">
                                <label for="AmountOfTicketsInput" class="FormText">
                                    <div class="tooltip">
                                        <h4 class="AmountOfTickets">Amount of tickets for sale</h4>
                                        <h5 class="Tooltiptext">If left blank, there will be an unlimited amount of tickets of this type for sale.</h5>
                                    </div>
                                </label>
                                <!-- The onkeydown stops decimal points from being included -->
                                <input type="number" min="1" onkeydown="if(event.key == '.' || event.key == 'e'){event.preventDefault();}" name="AmountOfTicketsInput" id="AmountOfTicketsInput" class="AmountOfTicketsInput" value="" placeholder="No Limit">
                            </div>
                            <div class="SeperatorBar"></div>
                            <div class="OneLineSubmission half">
                                <label for="TicketPriceInput" class="FormText">
                                    <div class="tooltip">
                                        <h4 class="TicketPrice">Price of Ticket</h4>
                                        <h5 class="Tooltiptext">If left blank, this ticket type would be free. Any number would be shortened to 2dp</h5>
                                    </div>
                                </label>
                                <div class="CurrencyInput">
                                    <h3 class="PoundSymbol">£</h3>
                                    <input type="number" min="0.00" max="10000.00" step="any" name="TicketPriceInput" id="TicketPriceInput" class="TicketPriceInput" value="" placeholder="0.00">
                                </div> 
                            </div>
                        </div>
                        <div class="LongTextSubmission ">
                            <label for="ConcertDescriptionInput" class="FormText">
                                <h4 class="ConcertDescription">
                                    <div class="tooltip">
                                        <h4 class="TicketDescription">Ticket Description</h4>
                                        <h5 class="Tooltiptext">When the ticket is hovered over, this description comes up</h5>
                                    </div>
                                </h4>
                            </label>
                            <textarea name="ConcertDescriptionInput" id="ConcertDescriptionInput"></textarea>
                        </div>
                        <div class="OneLineSubmission">
                            <label for="MaxTicketBoughtInput" class="FormText">
                                <div class="tooltip">
                                    <h4 class="TicketName">Maximum amount of tickets per person</h4>
                                    <h5 class="Tooltiptext">This is the maximum amount of tickets a person can buy at a time. If left blank, a customer can buy an unlimited amount of tickets</h5>
                                </div>
                            </label>
                            <!-- The onkeydown stops decimal points from being included -->
                            <input type="number" min="1" onkeydown="if(event.key == '.' || event.key == 'e'){event.preventDefault();}" name="MaxTicketBoughtInput" id="MaxTicketBoughtInput" class="MaxTicketBoughtInput" placeholder="Unlimited">
                        </div>
                        <div class="SubmitTicket Option">
                            <button type="button" name="AddTicketButton" id="SubmitTicketButton" class="SubmitTicket Button selected">
                                ADD TICKET
                            </button>
                        </div>
                        <div class="DatabaseData hide">
                            <input type="text" name="TicketObjects" id="TicketObjects" class="TicketObjects" value="">
                        </div>
                        <button class="SubmitButton hide" id="SubmitButton" type="submit" name="submitPageFour">
                            <span class="submitting">
                                SUBMIT AND FINISH
                            </span>  
                        </button>
                    </form>
                </div>    
            </div>
        </div>
    </main>
    <!-- This script introduces the google maps api with places library enabled -->
    <script src="../../../Javascript/addticket.js"></script>
</body>
</html>