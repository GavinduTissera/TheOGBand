<?php



if ($_SESSION["Venues.TotalVenues"] > 0) {
    for ($i=0; $i < $_SESSION["Venues.TotalVenues"]; $i++) {
        ?>
        <div class="SeperatingBar show"></div>
        <li class="VenueRow show" id="<?php echo $i ?>">
            <h4 class="VenueNameOne">
                <?php
                    echo $_SESSION["Venues.VenueName".$i]
                ?>
            </h4>
            <h5 class="VenueNameTwo">
                <?php
                    echo $_SESSION["Venues.Address".$i]
                ?>
            </h5>
        </li>
        <?php
    }
    
} 

            