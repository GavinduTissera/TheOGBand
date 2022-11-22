<?php
include "../../Assets/Classes/dbConnectorClasses.php";
session_start();
// Doesn't allow non admins by checking in the database if they are admin
if ($_SESSION["userisadmin"] !== 1) {
    header("location: ../../Pages/login.php?error=InvalidPermissions");
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
    <link rel="stylesheet" href="../../CSS/PagesCSS/myorders.css">
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
                                echo substr($_SESSION["userfirstname"], 0, 10) . "...";
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
        <section class="OrdersTableSection MainTableSection">

            <h2 class="OverviewText">MY ORDERS</h2>
            <div class="SelectRowsGroup">
                <h2 class="SelectTitle">Select the amount of rows per page: </h2>
                <select name="rowspicker" id="rowspicker" class="ChooseAmountOfRows" >
                    <div class="options">
                        <option value="5000">Show All Rows</option>
                        <option value="5">5</option>
                        <option value="10">10</option>
                        <option value="20">20</option>
                        <option value="25">25</option>
                        <option value="50">50</option>
                        <option value="75">75</option>
                        <option value="100">100</option>
                    </div>
                </select>
            </div>
            <!-- Actual table that includes the orders -->
            <div class="TableContainer">
                <!-- The only reason this is called event table is because the merge sort algorithm only works on tables named EventTable -->
                <table class="EventTable" id="EventTable">
                    <!-- Headers for the table  -->
                    <thead>
                        <tr class="row1">
                            <th class="ID smallSize headerTable none" id="0">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Order ID
                                        <h5 class="Tooltiptext">Unique Identification for every order</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="EventNames headerTable none" id="1">
                                <div class="ColumnID ColumnBox">
                                    Event Name
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="TicketName1 headerTable none" id="2">
                                <div class="ColumnID ColumnBox">
                                    Ticket Name
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="TicketsBought smallSize headerTable none" id="3">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Tickets Ordered
                                        <h5 class="Tooltiptext">Total number of tickets bought from the order</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="AmountSpent smallSize headerTable none" id="4">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Amount Spent
                                        <h5 class="Tooltiptext">Amount of money spent on tickets by the user</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="OrderDate headerTable none" id="5">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Order Date
                                        <h5 class="Tooltiptext">If Order Status is waiting, this is the date and time at which the order was started. When the order is completed, this column gets updated.</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="FirstName headerTable none" id="6">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        First Name
                                        <h5 class="Tooltiptext">NOTICE: This is the first name of the cardholder. This doesn't detail the names of the people who are coming to the concert</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="LastName headerTable none" id="7">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Last Name
                                        <h5 class="Tooltiptext">Last name of cardholder</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="Email headerTable none" id="8">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Email Address
                                        <h5 class="Tooltiptext">Email address of cardholder</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="PhoneNumber headerTable none" id="9">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Phone Number
                                        <h5 class="Tooltiptext">Phone number of Cardholder</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                            <th class="OrderStatus headerTable none" id="10">
                                <div class="ColumnID ColumnBox">
                                    <div class="tooltip">
                                        Order Status
                                        <h5 class="Tooltiptext">Displays stage of ordering. If set to "waiting", then the user is still either in payment screen or payment is processing</h5>
                                    </div>
                                    <i class="uil uil-sort shown"></i>
                                    <i class="uil uil-sort-amount-up notshown"></i>
                                    <i class="uil uil-sort-amount-down notshown"></i>
                                </div>
                            </th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        include_once "../../Assets/Includes/MyOrdersTable/AllOrders.php";
                        ?>
                    </tbody>
                </table>
            </div>
            <div class="PaginationBox">
                <nav>
                    <ul class="pagination">
                        <!-- Uses data- elements to for ease of use -->
                        <li data-pagination="start" class="start">
                            <span><<<</span>
                        </li>
                        <li data-pagination="prev" class="prev">
                            <span><</span>
                        </li>
                        <div class="DataRows">

                        </div>
                        <!-- Pagination elements added here-->
                        <li data-pagination="next" class="next">
                            <span>></span> 
                        </li>
                        <li data-pagination="end" class="end">
                            <span>>>></span>
                        </li>
                    </ul>
                </nav>
            </div>

        </section>
    </main>


    <script>
        const OrderStatusCheck = document.querySelectorAll(".OrderStatusColour");
        console.log(OrderStatusCheck)
        OrderStatusCheck.forEach(element => {
            InnerStatus = element.textContent.trim()
            if (InnerStatus === "Completed") {
                element.parentNode.classList.remove("Completed", "Waiting", "Refunded");
                element.parentNode.classList.add("Completed");
            } else if (InnerStatus === "Waiting") {
                element.parentNode.classList.remove("Completed", "Waiting", "Refunded");
                element.parentNode.classList.add("Waiting");
            } else {
                element.parentNode.classList.remove("Completed", "Waiting", "Refunded");
                element.parentNode.classList.add("Refunded");
            }
        });
    </script>

    <!-- Script that initiates the sorting of the table -->
    <script type="module">
        // This script makes an event listener that checks if a header has been clicked. If it has then it updates the class name of the clicked element, and sends that along with the column number (id) to sort the table from that column
        import {
            initiateSort
        } from "./../../Javascript/tableMergeSort.js"
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
            headers.forEach(header => {
                header.classList.remove("none", "asc", "desc")
                header.classList.add("none")
            })
            // The uil elements are used to display the correct icon depending on whether its not sorted, ascending or descending
            AllUilElements.forEach(uilElement => {
                uilElement.classList.remove("shown", "notshown")
                uilElement.classList.add("notshown")
            })
            // Shows the unsorted icon for every header
            unsortedIcon.forEach(icons => {
                icons.classList.replace("notshown", "shown")
            })
        }

        // import {
        //     initiatePagination
        // } from "../../Javascript/tablePagination.js"
        // const rowspicker = document.getElementById("rowspicker")
        // rowspicker.addEventListener("change", function() {
        //     //getting variables to pass into the pagination class
        //     var AmountOfRows = parseInt(rowspicker.options[rowspicker.selectedIndex].value)
        //     var TotalRows = (document.getElementsByTagName("tr").length -1)
        //     var PagesNeeded = Math.ceil(TotalRows/AmountOfRows)
        //     var selectedPage = 1
        //     new initiatePagination(AmountOfRows, TotalRows, PagesNeeded, selectedPage)
        // })
    </script>
    <script src="../../Javascript/tablePagination.js"></script>
</body>

</html>