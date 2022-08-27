<?php
    include "../../Assets/Classes/dbConnectorClasses.php";
    session_start();
    // Doesn't allow non admins by checking in the database if they are admin
    if ($_SESSION["userisadmin"] !== 1) {
        header("location: ../../Pages/login.php?error=InvalidPermissions");
    }
    include "../../Assets/Includes/adminDashboardInc.php";
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="icon" type="image/x-icon" href="../../Images/Icons/TheOGBandLogoHD.png">
    <link rel="stylesheet" href="../../CSS/reset.css">
    <link rel="stylesheet" href="../../CSS/styles.css">
    <link rel="stylesheet" href="../../CSS/PagesCSS/dashboard.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
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
                <li><a class="NavBarHome" href="../../index.php#TopOfPage">USER HOME</a></li>
                <li><a class="NavBarAbout" href="Dashboard.php">DASHBOARD</a></li>
                <li><a class="NavBarTour" href="CreateConcert/1.php">CREATE CONCERT</a></li>
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
                        <li><a class="MyProfileDropdown" href="../../Pages/MyProfile">MY PROFILE</a></li>
                        <li><a class="MyTicketsDropdown" href="../../Pages/MyTickets">MY TICKETS</a></li>
                        <li><a class="SettingsDropdown" href="../../Pages/Settings">SETTINGS</a></li>
                        <li class="LogoutButton"><a class="LogoutDropdown" href='../../Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                    </div>
                </div>
            </ul>
        </nav>
        <hr>
    </header>

    <!-- top selector content  -->

    <div class="Sidebar">
        <ul class="SideBarList">
            <!-- Boxes for the main statistics for overview section  -->
            <div class="OverviewBox">
                <li><a href="Dashboard.php" class="SideBarOverview">
                    <i class="uil uil-chart-bar"></i>
                    <h4 class="SideBarText Overview">OVERVIEW</h4>
                </a></li>
            </div>
            <div class="MyEventsBox"> 
                <li><a href="MyEvents.php" class="SideBarMyEvents">
                    <i class="uil uil-headphones"></i>
                    <h4 class="SideBarText MyEvents">MY EVENTS</h4>
                </a></li>
            </div>
            <div class="MyOrdersBox"> 
                <li><a href="MyOrders.php" class="SideBarMyEvents">
                <i class="uil uil-shopping-basket"></i>
                    <h4 class="SideBarText MyOrders">MY ORDERS</h4>
                </a></li>
            </div>
            <div class="AnalyticsBox">
                <li><a href="Analytics.php" class="SideBarAnalytics">
                    <i class="uil uil-chart-line"></i>
                    <h4 class="SideBarText Analytics">ANALYTICS</h4>
                </a></li>
            </div>
            <div class="SettingsBox">
                <li><a href="Settings.php" class="SideBarSettings">
                    <i class="uil uil-setting"></i>
                    <h4 class="SideBarText Settings">SETTINGS</h4>
                </a></li>
            </div>
        </ul>
        <div class="Search">
                <div class="searchButton">
                    <i class="uil uil-search"></i>
                </div>
            <input class="SearchBox" type="text" placeholder="Search...">
        </div>
    </div>

    <!-- Page content -->
    <section class="OverviewPage">
        <div class="BackgroundImage"></div>
        <!-- header -->
        <h2 class="OverviewText">OVERVIEW</h2>
        <!-- radio buttons that determine the dates that the sql commands are searched from -->
        <div class="OverviewTimeButtons">
            <div class="TimeButtons">
                <form action="../../Assets/Includes/adminDashboardInc.php" method="POST" id="TimeFrameSet">
                    <button type="submit" name="TimeButtonSAT" value="AllTime" id="AllTime" class="TimeButton 
                    <?php 
                        if ($_SESSION["ShowAllTime"] === true) {
                            echo "selected";
                        } else {
                            echo "deselected";
                        }
                    ?>">ALL TIME</button>
                    <button type="submit" name="TimeButtonSLM" value="LastMonth" id="LastMonth" class="TimeButton 
                    <?php 
                        if ($_SESSION["ShowLastMonth"] === true) {
                            echo "selected";
                        } else {
                            echo "deselected";
                        }
                    ?>">LAST MONTH</button>
                    <button type="submit" name="TimeButtonsSLW" value="LastWeek" id="LastWeek" class="TimeButton 
                    <?php 
                        if ($_SESSION["ShowLastWeek"] === true) {
                            echo "selected";
                        } else {
                            echo "deselected";
                        }
                    ?>">LAST WEEK</button>
                </form>
                <button name="TimeButtonsSCD" id="ShowCustomDates" value="CustomDate" class="TimeButtonCustom 
                <?php 
                    if ($_SESSION["ShowCustomDates"] === true) {
                        echo "selected";
                    } else {
                        echo "deselected";
                    }
                ?>">SHOW CUSTOM DATES</button>
                <form action="../../Assets/Includes/adminDashboardInc.php" method="POST" id="ShowCustomDateDashboardForm">
                    <div class="DateOne">
                        <label for="StartDate" class="DateLabel hidden">START DATE:</label>
                        <input type="date" name="StartDateDashboard" id="StartDate" class="Dates hidden" required>
                    </div>
                    <div class="DateTwo">
                        <label for="EndDate" class="DateLabel hidden">END DATE:</label>
                        <input type="date" name="EndDateDashboard" id="EndDate" class="Dates hidden" required>
                    </div>
                    <!-- When the button is pressed the form sends  -->
                    <button type="submit" name="SCDsubmit" class="ShowCustomDatesSubmit hidden">SUBMIT</button>
                </form>
            </div>
        </div>
        <!-- class that surrounds the overview boxes -->
        <div class="OverviewBoxes">
            <!-- every "i" represents an icon used -->
            <i class="uil uil-money-stack"></i>
            <div class="Revenue Box">    
                <!-- header of the box -->
                <h3 class="Topic Revenue">TOTAL REVENUE</h3>
                <p class="Text TotalRevenue">
                    <?php
                        // taking the information from the database
                        echo "£".$_SESSION["Sales.NetEarnings"];
                    ?>
                </p>
            </div>
            <i class="uil uil-ticket"></i>
            <div class="TicketsSold Box">
                <h3 class="Topic Attendees">TOTAL TICKETS SOLD</h3>
                <p class="Text TotalTicketsSold">
                    <?php
                        echo $_SESSION["Sales.TotalAttendees"];
                    ?>
                </p>
            </div>
            <i class="uil uil-shop"></i>
            <div class="TotalOrders Box">
                <h3 class="Topic Orders">TOTAL COMPLETE ORDERS</h3>
                <p class="Text TotalOrders">
                    <?php
                        echo $_SESSION["Sales.TotalOrders"];
                    ?>
                </p>
            </div>
        </div>
        <!-- similar to the boxes before except there are 5 and they are of smaller size -->
        <div class="SmallBoxes">
            <div class="TotalUsers SmallBox">
                <h3 class="SmallTopic UserTotal">TOTAL USERS SIGNUP</h3>
                <p class="SmallText TotalUsersText">
                    <?php
                        echo $_SESSION["Sales.TotalUsers"];
                    ?>
                </p>
            </div>
            <div class="TotalRefunds SmallBox">
                <h3 class="SmallTopic Refunds">TOTAL REFUNDS</h3>
                <p class="SmallText TotalRefundsText">
                    <?php
                        echo $_SESSION["Sales.TotalRefunded"];
                    ?>
                </p>
            </div>
            <div class="TotalOrdersRef SmallBox">
                <h3 class="SmallTopic TotalOrdersInc">INCOMPLETE ORDERS</h3>
                <p class="SmallText TotalOrdersRefText">
                    <?php
                        echo $_SESSION["Sales.TotalOrdersInc"];
                    ?>
                </p>
            </div>
            <div class="AvgTicketsPerOrder SmallBox">
                <h3 class="SmallTopic AvgTickets">AVG TICKETS PER ORDER</h3>
                <p class="SmallText AvgTicketsText">
                    <?php
                        echo $_SESSION["Sales.AvgTicketsPerOrder"];
                    ?>
                </p>
            </div>
            <div class="AvgTicketPrice SmallBox">
                <h3 class="SmallTopic TicketPrice">AVERAGE TICKET PRICE</h3>
                <p class="SmallText TicketPriceText">
                    <?php
                        echo "£".$_SESSION["Sales.AvgTicketPrice"];
                    ?>
                </p>
            </div>
        </div>
        <!-- === EVENT SECTION === -->
        <!-- purpose is to display the next 5 events that are to happen -->
        <div class="MyEventsSection">
            <h3 class="MyEventsText">NEXT EVENTS</h3>
            <div class="MyEventsTable">
                <!-- displays information for event 1 -->
                <?php
                // only displays event information if the event exists
                if (isset($_SESSION["Events-EventsDateTime.EventMonth0"])) {
                    ?>
                    <div class="EventsTableRow One">
                        <!-- date and month go into special div to contain them -->
                        <div class="DayAndMonthBox">
                            <h4 class="EventMonth">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventMonth0"];
                                ?>
                            </h4>
                            <h3 class="EventDay">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventDay0"];
                                ?>
                            </h3>
                        </div>
                        <div class="RestOfEventContent">
                            <h3 class="EventName">
                                <?php
                                    echo $_SESSION["Events.EventName0"];
                                ?>
                            </h3>
                            <div class="TimeAndCity">
                                <h4 class="EventTime">
                                    <i class="uil uil-clock"></i>
                                    <?php
                                        echo "Start time: ".$_SESSION["Events-EventsDateTime.StartTime0"];
                                    ?>
                                </h3>
                                <h4 class="EventVenueNameCity">
                                    <i class="uil uil-location-pin-alt"></i>
                                    <?php
                                        echo $_SESSION["Events-Venue.VenueName0"].", ". $_SESSION["Events-Venue.City0"];
                                    ?>
                                </h4>
                            </div>
                            <!-- buttons are used to redirect to the event page and event  -->
                            <div class="Buttons">
                                <div class="MoreDetailsButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="EventMoreDetails">
                                            <i class="uil uil-ellipsis-h"></i>
                                            MORE DETAILS
                                        </button>
                                    </a>  
                                </div>
                                <div class="ViewTicketPageButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="ViewTicketPage">
                                            <i class="uil uil-external-link-alt"></i>
                                            VIEW TICKET PAGE
                                        </button>
                                    </a>  
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                <?php
                }
                ?>
                <!-- displays information for event 2 -->
                <?php
                if (isset($_SESSION["Events-EventsDateTime.EventMonth1"])) {
                    ?>
                    <div class="EventsTableRow Two">
                        <div class="DayAndMonthBox">
                            <h4 class="EventMonth">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventMonth1"];
                                ?>
                            </h4>
                            <h3 class="EventDay">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventDay1"];
                                ?>
                            </h3>
                        </div>
                        <div class="RestOfEventContent">
                            <h3 class="EventName">
                                <?php
                                    echo $_SESSION["Events.EventName1"];
                                ?>
                            </h3>
                            <div class="TimeAndCity">
                                <h4 class="EventTime">
                                    <i class="uil uil-clock"></i>
                                    <?php
                                        echo "Start time: ".$_SESSION["Events-EventsDateTime.StartTime1"];
                                    ?>
                                </h3>
                                <h4 class="EventVenueNameCity">
                                    <i class="uil uil-location-pin-alt"></i>
                                    <?php
                                        echo $_SESSION["Events-Venue.VenueName1"].", ". $_SESSION["Events-Venue.City1"];
                                    ?>
                                </h4>
                            </div>
                            <div class="Buttons">
                                <div class="MoreDetailsButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="EventMoreDetails">
                                            <i class="uil uil-ellipsis-h"></i>
                                            MORE DETAILS
                                        </button>
                                    </a>  
                                </div>
                                <div class="ViewTicketPageButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="ViewTicketPage">
                                            <i class="uil uil-external-link-alt"></i>
                                            VIEW TICKET PAGE
                                        </button>
                                    </a>  
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                <?php
                }
                ?>
                <!-- displays information for event 3 -->
                <?php
                if (isset($_SESSION["Events-EventsDateTime.EventMonth2"])) {
                    ?>
                    <div class="EventsTableRow Three">
                        <div class="DayAndMonthBox">
                            <h4 class="EventMonth">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventMonth2"];
                                ?>
                            </h4>
                            <h3 class="EventDay">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventDay2"];
                                ?>
                            </h3>
                        </div>
                        <div class="RestOfEventContent">
                            <h3 class="EventName">
                                <?php
                                    echo $_SESSION["Events.EventName2"];
                                ?>
                            </h3>
                            <div class="TimeAndCity">
                                <h4 class="EventTime">
                                    <i class="uil uil-clock"></i>
                                    <?php
                                        echo "Start time: ".$_SESSION["Events-EventsDateTime.StartTime2"];
                                    ?>
                                </h3>
                                <h4 class="EventVenueNameCity">
                                    <i class="uil uil-location-pin-alt"></i>
                                    <?php
                                        echo $_SESSION["Events-Venue.VenueName2"].", ". $_SESSION["Events-Venue.City2"];
                                    ?>
                                </h4>
                            </div>
                            <div class="Buttons">
                                <div class="MoreDetailsButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="EventMoreDetails">
                                            <i class="uil uil-ellipsis-h"></i>
                                            MORE DETAILS
                                        </button>
                                    </a>  
                                </div>
                                <div class="ViewTicketPageButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="ViewTicketPage">
                                            <i class="uil uil-external-link-alt"></i>
                                            VIEW TICKET PAGE
                                        </button>
                                    </a>  
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                <?php
                }
                ?>
                <!-- displays information for event 4 -->
                <?php
                if (isset($_SESSION["Events-EventsDateTime.EventMonth3"])) {
                    ?>
                    <div class="EventsTableRow Four">
                        <div class="DayAndMonthBox">
                            <h4 class="EventMonth">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventMonth3"];
                                ?>
                            </h4>
                            <h3 class="EventDay">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventDay3"];
                                ?>
                            </h3>
                        </div>
                        <div class="RestOfEventContent">
                            <h3 class="EventName">
                                <?php
                                    echo $_SESSION["Events.EventName3"];
                                ?>
                            </h3>
                            <div class="TimeAndCity">
                                <h4 class="EventTime">
                                    <i class="uil uil-clock"></i>
                                    <?php
                                        echo "Start time: ".$_SESSION["Events-EventsDateTime.StartTime3"];
                                    ?>
                                </h3>
                                <h4 class="EventVenueNameCity">
                                    <i class="uil uil-location-pin-alt"></i>
                                    <?php
                                        echo $_SESSION["Events-Venue.VenueName3"].", ". $_SESSION["Events-Venue.City3"];
                                    ?>
                                </h4>
                            </div>
                            <div class="Buttons">
                                <div class="MoreDetailsButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="EventMoreDetails">
                                            <i class="uil uil-ellipsis-h"></i>
                                            MORE DETAILS
                                        </button>
                                    </a>  
                                </div>
                                <div class="ViewTicketPageButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="ViewTicketPage">
                                            <i class="uil uil-external-link-alt"></i>
                                            VIEW TICKET PAGE
                                        </button>
                                    </a>  
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                <?php
                }
                ?>
                <!-- displays information for event 5 -->
                <?php
                if (isset($_SESSION["Events-EventsDateTime.EventMonth4"])) {
                    ?>
                    <div class="EventsTableRow Five">
                        <div class="DayAndMonthBox">
                            <h4 class="EventMonth">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventMonth4"];
                                ?>
                            </h4>
                            <h3 class="EventDay">
                                <?php
                                    echo $_SESSION["Events-EventsDateTime.EventDay4"];
                                ?>
                            </h3>
                        </div>
                        <div class="RestOfEventContent">
                            <h3 class="EventName">
                                <?php
                                    echo $_SESSION["Events.EventName4"];
                                ?>
                            </h3>
                            <div class="TimeAndCity">
                                <h4 class="EventTime">
                                    <i class="uil uil-clock"></i>
                                    <?php
                                        echo "Start time: ".$_SESSION["Events-EventsDateTime.StartTime4"];
                                    ?>
                                </h3>
                                <h4 class="EventVenueNameCity">
                                    <i class="uil uil-location-pin-alt"></i>
                                    <?php
                                        echo $_SESSION["Events-Venue.VenueName4"].", ". $_SESSION["Events-Venue.City4"];
                                    ?>
                                </h4>
                            </div>
                            <div class="Buttons">
                                <div class="MoreDetailsButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="EventMoreDetails">
                                            <i class="uil uil-ellipsis-h"></i>
                                            MORE DETAILS
                                        </button>
                                    </a>  
                                </div>
                                <div class="ViewTicketPageButton">
                                    <a href="EDITTHISLATER.php">
                                        <button class="ViewTicketPage">
                                            <i class="uil uil-external-link-alt"></i>
                                            VIEW TICKET PAGE
                                        </button>
                                    </a>  
                                </div>
                            </div>
                            
                        </div>
                        
                    </div>
                <?php
                }
                ?>

            </div>       
        </div>
    </section>

    <script>
        // Gets the button that says "SHOW CUSTOM DATES"
        const CustomDatesButton = document.getElementById("ShowCustomDates");
        // adds an event listener that checks when it is clicked
        CustomDatesButton.addEventListener("click", function() {
            // when the button is clicked, it gets all elements that have a class name of hidden or active. It iterates through them and it changes hidden to active and vice versa
            const hiddenElements = document.querySelectorAll(".hidden, .active");
            hiddenElements.forEach(element => {
                if (element.classList.contains("hidden")) {
                    element.classList.remove("hidden");
                    element.classList.add("active");
                } else {
                    element.classList.remove("active");
                    element.classList.add("hidden");
                }
            });
        });
    </script>
</body>
</html>