<?php
    include "Assets/Classes/dbConnectorClasses.php";
    session_start()
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
    <!-- === Link to javascript scroll reveal library === -->
    <script src="https://unpkg.com/scrollreveal@4"></script>
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
                            if($_SESSION["userisadmin"] === 1) {
                                echo "<li><a class='NavBarAdminDashboard' href='Pages/Admin/Dashboard.php'>DASHBOARD</a></li>";
                            }
                            /* If user is not an  admin, then they get access to logout and profile but not dashboard */
                            ?>
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
                                    <li><a class="MyProfileDropdown" href="Pages/MyProfile">MY PROFILE</a></li>
                                    <li><a class="MyTicketsDropdown" href="Pages/MyTickets">MY TICKETS</a></li>
                                    <li><a class="SettingsDropdown" href="Pages/Settings">SETTINGS</a></li>
                                    <li class="LogoutButton"><a class="LogoutDropdown" href='Assets/Includes/logoutInc.php'>LOGOUT</a></li>
                                </div>
                            </div>
                            
                    <?php
                    /* If user is not logged in, they get login&signup */
                        } else {      

                            echo "<li><a class='NavBarLoginSignup' href='Pages/login.php'>LOGIN&SIGNUP</a></li>";
                        }
                    ?>
                </ul>
            </nav>
            <hr>
        </header>

        
        <main class="MainContent">
            <section class="OpeningContent" id="OpeningContent">
                <!-- Used as an anchor so the back to top button works-->
                <a id="TopOfPage"></a>
                <!--Text that appears over the title page-->
                <div class="MainLogo">
                    <h1 class="MainTextLogo">
                        <span>The OG<br></span> 
                        <span>Band</span> 
                    </h1>
                </div>
                <!--The opening video for the OG band-->
                <div class="OpeningVideo" id="OpeningVideo" >
                    <div class="VideoBandgrad"></div>
                    <video class="VideoBand" autoplay muted loop >
                        <source src="Images/BandVideos/OGBandVideoMP4.mp4" type="video/mp4">
                    </video>
                </div>
                <!--Text that appears beside the book tickets button-->
                <div class="CallToActionText">
                    <h2 class="SeeUsLiveText">SEE US LIVE</h2>
                    <button type="button" class="BookTickets" href="Pages/tour.php">
                        VIEW TOUR DATES HERE
                    </button>
                </div>
            </section>
            
            
            

            <!--=======MUSIC SECTION=======-->

            <section class="MusicSection" >
            <div class="VideoBandRevgrad"></div>
                <div class="MusicBackgroundImage">
                    <img class="MusicBackground" src="Images/OtherPhotos/chalkboardbackground.jpg" alt="" >
                </div>
                <div class="MusicContent">
                    <h3 class="header Music">MUSIC</h3>
                    <div class="SpotifyPlaylists">
                        <iframe class="PlaylistOne" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/2k9WGCD9GxTUsdYtIDnZhG?utm_source=generator" width="30%" height="450" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                        <iframe class="PlaylistTwo" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/37i9dQZF1DX0E9XMGembJo?utm_source=generator" width="30%" height="450" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                        <iframe class="PlaylistThree" style="border-radius:12px" src="https://open.spotify.com/embed/playlist/37i9dQZF1DWWEcRhUVtL8n?utm_source=generator" width="30%" height="450" frameBorder="0" allowfullscreen="" allow="autoplay; clipboard-write; encrypted-media; fullscreen; picture-in-picture"></iframe>
                    </div>
                </div>
                
            </section>

            <!--=======ABOUT US SECTION=======-->

            <section class="AboutUsSection">
                <a id="AboutUsSection"></a>
                <div class="TexturedBackground"></div>
                <div class="AboutUsContent">
                    <h3 class="header AboutUs">ABOUT US</h3>
                    <div class="BandImages">
                        <div class="BandImageOne"></div>
                        <div class="BandImageTwo"></div>
                    </div>
                    <div class="AboutMeText">
                        <div class="TapeImage One"></div>
                        <div class="ParagraphOneBox">
                            <p class="ParagraphOne">
                                The OG Band is a group of 16-17 year olds who play all kinds of music, from Pop and Rock, to Jazz. First coming together to play in school events, they are now looking to escape and play together, outside of school. 
                            </p>
                        </div>
                        <div class="TapeImage Two"></div>
                        <div class="ParagraphTwoBox">
                            <p class="ParagraphTwo">
                                I really don't have much else to say so I'm going to fill this paragraph up with waffle so the parallax scrolling transition thing works properly. I probably could've used lipsum text but I think this works better, since I'm already very bored. I wonder if anyone will actually read this. I hope not. 
                            </p>
                        </div>
                        
                    </div>
                </div>
                

            </section>
            

            <!--=======GALLERY SECTION=======-->


            <section class="GallerySection" >
                <div class="TexturedBackground Two"></div>
                <div class="GalleryContent">
                    <!--Header for gallery section-->
                    <h3 class="header Gallery">GALLERY</h3>         
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
                </div>
                
        
                
            </section>


            <section class="MailingList">
                <div class="TexturedBackground Three"></div>
                <div class="MailingListContent">
                    <h3 class="header GetInTouch">GET IN TOUCH</h3>
                    <p class="CallToSubscribe">Subscribe to our mailing list and get notified of new music, tickets, news and more!</p>
                    <div class="SubmissionForm">
                        <form class="MailingListForm" action="Assets/Includes/mailingList.php" method="post">
                            <h5 class="Emails">Email Address</h5>
                            <div class="Input Email">
                                <i class="uil uil-envelope-alt"></i>
                                <input type="email" name="email" placeholder="E-Mail" required>
                            </div>
                            <h5 class="Forename">Forename</h5>
                            <div class="Input Forename">
                                <i class="uil uil-user"></i>
                                <input type="text" name="firstname" placeholder="First Name" required>
                            </div>
                            <h5 class="Surname">Surname</h5>
                            <div class="Input Surname">
                                <i class="uil uil-user-plus"></i>
                                <input type="text" name="surname" placeholder="Surname" required>
                            </div>
                            <h5 class="Country">Country</h5>
                            <div class="Input Country">
                                <i class="uil uil-map-marker-alt"></i>
                                <input type="text" name="country" placeholder="Country" required>
                            </div>
                            <h5 class="DateOfBirth">Date Of Birth</h5>
                            <div class="Input DateOfBirth">
                                <i class="uil uil-calendar-alt"></i>
                                <input type="date" name="dateofbirth" id="dateofbirth" placeholder="Birth Date" min="1899-01-01" max="" required>
                            </div>
                            <button class="SubmitButton" type="submit" name="submit">SUBSCRIBE</button>
                        </form>
                    </div>
                </div>      
            </section>       
        </main>


        <footer>
            <div class="TexturedBackground Four"></div>
            <div class="FooterContent">
            <i class="FooterIcon One uil uil-twitter-alt"></i>
            <i class="FooterIcon Two uil uil-instagram"></i>
            <i class="FooterIcon Three uil uil-youtube"></i>
        </footer>   
    </div>

    <script>
        //Scroll reveal for opening book tickets call to action 
        ScrollReveal().reveal('.SeeUsLiveText', {delay: 100, distance: "100px", origin: "top"})
        ScrollReveal().reveal('.BookTickets', {origin: "left"})
        
        //Scroll reveal for spotify playlists
        ScrollReveal().reveal('.PlaylistOne', {delay: 200, distance: "100px", origin: "left"})
        ScrollReveal().reveal('.PlaylistTwo', {delay: 200, distance: "100px", origin: "bottom"})
        ScrollReveal().reveal('.PlaylistThree', {delay: 200, distance: "100px", origin: "right"})

        // Scroll reveal for About me section 
        ScrollReveal().reveal('.BandImageOne', {delay: 100, distance: "50px", origin: "left"})
        ScrollReveal().reveal('.BandImageTwo', {delay: 100, distance: "50px", origin: "right"})
        ScrollReveal().reveal('.TapeImage.One', {delay: 400, distance: "100px", origin: "left"})
        ScrollReveal().reveal('.TapeImage.Two', {delay: 400, distance: "100px", origin: "right"})
        ScrollReveal().reveal('.ParagraphOneBox', {delay: 500, distance: "400px", origin: "right"})
        ScrollReveal().reveal('.ParagraphTwoBox', {delay: 500, distance: "400px", origin: "left"})
        //Scroll reveal for headers
		ScrollReveal().reveal('.header', {origin: "left"})
        ScrollReveal().reveal('.Music', {origin: "bottom", distance: "150px"})
		ScrollReveal().reveal('.Gallery', { origin: "right"})
        
	</script>
    <!--Loading react.js -->
    <script src="https://unpkg.com/react@18/umd/react.development.js" crossorigin></script>
    <script src="https://unpkg.com/react-dom@18/umd/react-dom.development.js" crossorigin></script>
    <!--Loading script files-->
    <script type="text/javascript" src="javascript/homepage.js"></script>
    <script type="text/javascript" src="Javascript/gallery.js"></script>
    <script type="text/javascript" src="Javascript/date.js"></script>
</body>
</html>
