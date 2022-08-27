

<?php
    if ($_SESSION["Events.HPETotalEvents"] > 0) {
        for ($i=0; $i < $_SESSION["Events.HPETotalEvents"]; $i++) {
            ?>
            <tr>
                <td>
                    <?php
                        echo $_SESSION["Events.HPEEventID".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.HPEEventName".$i];
                    ?>
                </td>
                <td>
                    <!-- Cutting the string to 10 characters to remove the time section from the datetime -->
                    <?php
                        echo substr($_SESSION["Events.HPEEventDateTime".$i], 0, 10);
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.HPEEventDescription".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HPEVenue.VenueName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HPEEventsDateTime.StartTime".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.HPETotalTicketsBought".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HPEVenue.MaxCapacity".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HPEVenue.Address".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HPEVenue.Postcode".$i];
                    ?>
                </td>
            </tr>
            <?php
        }
    }