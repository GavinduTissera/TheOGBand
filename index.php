<?php
    session_start();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="CSS/reset.css">
    <link rel="stylesheet" href="CSS/styles.css">
    <link rel="stylesheet" href="https://unicons.iconscout.com/release/v4.0.0/css/line.css">
    <!-- === Link to javascript === -->
    
    <!--Document title-->
    <title>The OG Band</title>
</head>
<body>


    <!--======NAV BAR======-->
    <header>
        <nav class="NavBar">
            <!--Text that goes to home screen when clicked-->
            <a class="LogoNavBar" href="index.php#TopOfPage">THE OG BAND</a>
            <ul class="NavBarList">
                <!--Options that form the navigation bar-->
                <li><a class="NavBarHome" href="index.php#TopOfPage">HOME</a></li>
                <li><a class="NavBarAbout" href="index.php#AboutUsSection">ABOUT</a></li>
                <li><a class="NavBarTour" href="Pages/tour.php">BOOK TICKETS</a></li>
                <!-- === CONTENT THAT CHANGES DEPENDENT ON LOGIN STATUS === -->
                <!-- If user is admin, then they get access to the dashboard when they are logged in-->
                <?php
                    if (isset($_SESSION["userid"])) {
                        echo "userid";
                        if($_SESSION["userisadmin"]) {
                ?>
                            <li><a class="NavBarAdminDashboard" href="Pages/Admin/Dashboard.php">DASHBOARD</a></li>
                <!-- If user is not an  admin, then they get access to logout and profile but not dashboard-->
                <?php
                        }
                ?>
                        <li><a class="NavBarLogout" href="Pages/index.php">LOGOUT</a></li>
                        <li><a class="NavBarProfile" href="">
                            <?php 
                                $_SESSION["userfirstname"]
                            ?>
                        </a></li>
                <!-- If user is not logged in, they get login and signup-->
                <?php
                    } else {      
                ?>
                        <li><a class="NavBarLoginSignup" href="Pages/login.php">LOGIN&SIGNUP</a></li>
                
                <?php
                    }
                ?>
                
            </ul>
        </nav>
        <hr>
    </header>

    
    <main class="MainContent">
        <!-- Used as an anchor so the back to top button works-->
        <a id="TopOfPage"></a>
        <!--Text that appears over the title page-->
        <div class="MainLogo">
            <h1>The OG Band</h1>
        </div>
        
        <!--Image that is beneath the book tickets button-->
        <img src="Images/chalkboardbackground.jpg" alt="">
        <img src="Images/BandBackground.png" alt="The OG Band photo">
        <!--Text that appears beside the book tickets button-->
        <h2>SEE US LIVE</h2>
        <button type="button" class="bookTickets">
            VIEW TOUR DATES HERE
        </button>



        <section class="MusicSection">
            <h3 class="header">MUSIC</h3>

        </section>
        
        <!--=======ABOUT US SECTION=======-->

        <section class="AboutUsSection" id="AboutUsSection">
            <h3 class="header">ABOUT US</h3>
            <div class="BandImage"></div>
            <div class="AboutMeText">
                <p class="ParagraphOne">
                    The OG Band is a group of 16-17 year olds who play all kinds of music, from Pop and Rock, to Jazz. First coming together to play in school events, they are now looking to escape and play together, outside of school. 
                </p>
                <p class="ParagraphTwo">
                    I really don't have much else to say so I'm going to fill this paragraph up with waffle so the parallax scrolling transition thing works properly. I probably could've used lipsum text but I think this works better, since I'm already very bored. I wonder if anyone will actually read this. I hope not. 
                </p>
            </div>

        </section>


        <!--=======GALLERY SECTION=======-->


        <section class="GallerySection">
            <!--Header for gallery section-->
            <h3 class="header">GALLERY</h3>         
            <!--Carousel-->
            <div class="carousel">   
                <div class="radioandslides">
                    <!--Left and right buttons-->  
                    <button onclick="DecrementCounter()" class="prev -button" id="prev-button">&#10229;</button>
                    <button onclick="IncrementCounter()" class="next -button" id="next-button">&#10230;</button>
                    <!--Radio Buttons-->
                    <input type="radio" name="radioselectors" id="radio1">
                    <input type="radio" name="radioselectors" id="radio2">
                    <input type="radio" name="radioselectors" id="radio3">
                    <input type="radio" name="radioselectors" id="radio4">
                    <input type="radio" name="radioselectors" id="radio5">
                    <!--Pictures in the gallery-->
                    <div class="slide first">
                        <img src="Images/BestBandPictures/basscloseup.png" alt="">
                    </div>
                    <div class="slide">
                        <img src="Images/BestBandPictures/fullband.png" alt="">
                    </div>
                    <div class="slide">
                        <img src="Images/BestBandPictures/fullbandotherside.png" alt="">
                    </div>
                    <div class="slide">
                        <img src="Images/BestBandPictures/jasvirdrums2.png" alt="">
                    </div>
                    <div class="slide">
                        <img src="Images/BestBandPictures/singers2.png" alt="">
                    </div>
                    <!--Auto Navigation-->
                    <div class="AutoNavigation">
                        <div class="Autobtn1"></div>
                        <div class="Autobtn2"></div>
                        <div class="Autobtn3"></div>
                        <div class="Autobtn4"></div>
                        <div class="Autobtn5"></div>
                    </div>
                </div>
                    <!--Manual Navigation-->
                <div class="ManualNavigation">
                    <label for="radio1" class="Manualbtn" id="Manualbtn"></label>
                    <label for="radio2" class="Manualbtn" id="Manualbtn"></label>
                    <label for="radio3" class="Manualbtn" id="Manualbtn"></label>
                    <label for="radio4" class="Manualbtn" id="Manualbtn"></label>
                    <label for="radio5" class="Manualbtn" id="Manualbtn"></label>
                </div>
            </div>
    
            
        </section>


        <section class="MailingList">
            <h3 class="header">GET IN TOUCH</h3>
            <p>Subscribe to our mailing list and get notified of new music, tickets, news and more!</p>
            <div class="SubmissionForm">
                <h5>EMAIL ADDRESS</h5>
                <h5>FIRST NAME</h5>
                <h5>SURNAME</h5>
                <h5>COUNTRY</h5>
                <h5>DATE OF BIRTH</h5>
            </div>
        </section>
        
    </main>


    <footer>
        <img src="Images/Icons/brand-twitter.ico" alt="twitter OG Band">
        <img src="Images/Icons/brand-instagram.ico" alt="instagram OG Band">
        <img src="Images/Icons/brand-youtube.ico" alt="youtube OG Band">
        <button><a href="#TopOfPage">Get back to the top</a></button>
    </footer>
</body>
<script type="text/javascript" src="Javascript/gallery.js"></script>
<script type="text/javascript" src="Javascript/navbar.js"></script>
</html>