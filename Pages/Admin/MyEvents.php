<?php
    include "../../Assets/Classes/dbConnectorClasses.php";
    session_start();
    // Doesn't allow non admins by checking in the database if they are admin
    if ($_SESSION["userisadmin"] !== 1) {
        header("location: ../../Pages/login.php?error=InvalidPermissions");
    }

    if (!isset($_SESSION["UpdateEventsTable"])) {
        $_SESSION["UpdateEventsTable"] = false;
    }
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="../../CSS/reset.css">
    <link rel="stylesheet" href="../../CSS/styles.css">
    <link rel="stylesheet" href="../../CSS/PagesCSS/dashboard.css">
    <link rel="stylesheet" href="../../CSS/PagesCSS/myevents.css">
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
                    <!-- i represents the icons used  -->
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

    <main>
        <section class="EventsTableSection MainTableSection">
            
            <h2 class="OverviewText">MY EVENTS</h2>
            <div class="Checkboxes">
                <!-- these forms go to adminDashboardInc to change the query that is used -->
                <form action="../../Assets/Includes/adminDashboardInc.php" method="POST" id="HideEventsForm">
                    <!-- Whenever a button is pressed, it automatically goes to adminDashboardInc. Depending on the button the query is then changed. The 3 letters before checkbox are used as acronyms -->
                    <!-- PHP script is needed to check if the session variable is true, and if it is then it adds "selected" to the class name which is then used in css to change background colour when pressed -->
                    <button type="submit" name="SALcheckbox" value="ShowAllEvents" id="ShowAllEvents" class="HideMain 

                    <?php 
                        if ($_SESSION["ShowAllEvents"] === true) {
                            echo "selected";
                        } else {
                            echo "deselected";
                        }
                    ?>">SHOW ALL EVENTS</button>
                    <button type="submit" name="HPEcheckbox" value="HidePastEvents" id="HidePastEvents" class="HideMain 
                    <?php 
                        if ($_SESSION["HidePastEvents"] === true) {
                            echo "selected";
                        } else {
                            echo "deselected";
                        }
                    ?>">HIDE PAST EVENTS</button>
                    <button type="submit" name="HFEcheckbox" value="HideFutureEvents" id="HideFutureEvents" class="HideMain 
                    <?php 
                        if ($_SESSION["HideFutureEvents"] === true) {
                            echo "selected";
                        } else {
                            echo "deselected";
                        }
                    ?>">HIDE FUTURE EVENTS</button>
                </form>
                <!-- This button is used to show or hide the form below -->
                <button name="CustomDatecheckbox" value="ShowCustomDateEvents" id="ShowCustomDateEvents" class="HideCustom 
                <?php 
                    if ($_SESSION["ShowCustomEvents"] === true) {
                        echo "selected";
                    } else {
                        echo "deselected";
                    }
                ?>">SHOW CUSTOM DATES</button>
                <form action="../../Assets/Includes/adminDashboardInc.php" method="POST" id="ShowCustomDateForm">
                    <div class="DateOne">
                        <label for="StartDate" class="DateLabel hidden">START DATE:</label>
                        <input type="date" name="StartDate" id="StartDate" class="Dates hidden" required>
                    </div>
                    <div class="DateTwo">
                        <label for="EndDate" class="DateLabel hidden">END DATE:</label>
                        <input type="date" name="EndDate" id="EndDate" class="Dates hidden" required>
                    </div>
                    <!-- When the button is pressed the form sends  -->
                    <button type="submit" name="SCEsubmit" class="HideSubmit hidden">SUBMIT</button>
                </form>
                
            </div>
            <!-- Actual table that includes the events -->
            <div class="TableContainer">
                <table class="EventTable MainTable" id="EventTable">
                    <!-- Headers for the table  -->
                    <thead>
                        <tr class="row1">
                            <th class="ID headerTable none" id="0">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Creation ID
                                        <h5 class="Tooltiptext ToolFirst">This is the unique ID generated when the events are created</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="Name headerTable none" id="1">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Name
                                        <h5 class="Tooltiptext">Name Of Event</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="Date headerTable none" id="2">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Date
                                        <h5 class="Tooltiptext">Date Of Event</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="Description headerTable none" id="3">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Description
                                        <h5 class="Tooltiptext">This is the description of the event found on the event page next to the name</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="VenueName headerTable none" id="4">
                                <div class="ColumnID ColumnBox">
                                    Venue Name
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="StartTime headerTable none" id="5">
                                <div class="ColumnID ColumnBox">
                                    Start Time
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="EndTime headerTable none" id="6">
                                <div class="ColumnID ColumnBox">
                                    End Time
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="TicketsBought headerTable none" id="7">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Tickets Bought
                                        <h5 class="Tooltiptext">Total Amount Of Tickets Bought. Doesn't include waiting or refunded orders.</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="Capacity headerTable none" id="8">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Capacity
                                        <h5 class="Tooltiptext">Maximum capacity of the venue</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="Address headerTable none" id="9">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Address
                                        <h5 class="Tooltiptext">Venue Address</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="LocationData headerTable none" id="10">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Location Data
                                        <h5 class="Tooltiptext last">This is the latitude and the longitude of the venue. Used to show the exact location on google maps when the user views the venue</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    
                    <?php
                    include_once "../../Assets/Includes/MyEventsTables/AllEvents.php";
                    if ($_SESSION["UpdateEventsTable"] == true) {
                        include_once "../../Assets/Includes/MyEventsTables/AllEvents.php";
                        $_SESSION["UpdateEventsTable"] = false;
                    }

                    ?>
                    
                </table>
            </div>
            
        </section>
    </main>
    
    <!-- Script that shows or hides extra information when the "SHOW EVENTS AT CUSTOM DATES" button is clicked -->
    <script>
        // Gets the button that says "SHOW CUSTOM DATES"
        const CustomDateEventsButton = document.getElementById("ShowCustomDateEvents");
        // adds an event listener that checks when it is clicked
        CustomDateEventsButton.addEventListener("click", function() {
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

    <!-- Script that initiates the sorting of the table -->
    <script type="module">
        // This script makes an event listener that checks if a header has been clicked. If it has then it updates the class name of the clicked element, and sends that along with the column number (id) to sort the table from that column
        import {initiateSort} from "./../../Javascript/tableMergeSort.js"
        // Gets all headers from the table (as all table headers have a class of .headerTable)
        const table = document.getElementById("EventTable")
        const headers = table.querySelectorAll(".headerTable");
        // Iterates through every header and adds an event listener to each one
        headers.forEach(element => {
            element.addEventListener("click", function() {
                // The ID has the number of the column in it, so this fetches the id to use when calling the sort class
                var columnNo = element.id;
                var AllUilElements = table.querySelectorAll(".uil")
                var uilElements = element.querySelectorAll(".uil")
                var unsortedIcon = table.querySelectorAll(".uil-sort")
                var uilUnsortedElement = element.querySelector(".uil-sort")
                console.log(uilUnsortedElement)
                console.log(AllUilElements)

                console.log(element.classList)
                // None means unsorted. If an unsorted list is clicked, then it goes to ascending. If clicked again it goes to descending and repeats between ascending and descending. If another column is clicked all columns apart from the clicked one are reset to unsorted.
                if (element.classList.contains("none")) {
                    ResetAllElements(headers, AllUilElements, unsortedIcon)
                    var sortAscIcon = uilElements[0].parentNode.querySelector(".uil-sort-amount-up")
                    sortAscIcon.classList.replace("notshown", "shown")
                    element.classList.replace("none", "asc");
                    uilUnsortedElement.classList.replace("shown", "notshown")
                    // Calls initiate sort to start the merge sort. the column number and direction are used as parameters
                    new initiateSort(columnNo, "asc")

                } else if (element.classList.contains("asc")) {
                    ResetAllElements(headers, AllUilElements, unsortedIcon)
                    var sortAscIcon = uilElements[0].parentNode.querySelector(".uil-sort-amount-down")
                    sortAscIcon.classList.replace("notshown", "shown")
                    element.classList.remove("asc", "none");
                    element.classList.add("desc");
                    uilUnsortedElement.classList.replace("shown", "notshown")
                    new initiateSort(columnNo, "desc")

                } else if (element.classList.contains("desc")) {
                    ResetAllElements(headers, AllUilElements, unsortedIcon)
                    var sortAscIcon = uilElements[0].parentNode.querySelector(".uil-sort-amount-up")
                    sortAscIcon.classList.replace("notshown", "shown")
                    element.classList.remove("desc", "none");
                    element.classList.add("asc");
                    uilUnsortedElement.classList.replace("shown", "notshown")
                    new initiateSort(columnNo, "asc")
                }
                console.log(element.classList)
                if (element.classList.contains("none")) {
                    unsortedIcon.forEach(icon => {
                        icon.classList.replace("notshown", "shown")
                    })
                }
            })
        });

        function ResetAllElements(headers, AllUilElements, unsortedIcon) {
            headers.forEach(elementTwo => {
                elementTwo.classList.remove("none", "asc", "desc")
                elementTwo.classList.add("none")
            })
            // The uil elements are used to display the correct icon depending on whether its not sorted, ascending or descending
            AllUilElements.forEach(uilElement => {
                uilElement.classList.remove("shown", "notshown")
                uilElement.classList.add("notshown")
            })

            unsortedIcon.forEach(icons => {
                icons.classList.replace("notshown", "shown")
            })
        }

        // function putUnsortedIcon(params) {
            
        // }

    </script>
</body>
</html>
