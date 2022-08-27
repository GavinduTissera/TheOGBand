

<?php
    if ($_SESSION["Events.AllTotalEvents"] > 0) {
        for ($i=0; $i < $_SESSION["Events.AllTotalEvents"]; $i++) {
            ?>
            <tr>
                <td>
                    <?php
                        echo $_SESSION["Events.AllEventID".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.AllEventName".$i];
                    ?>
                </td>
                <td>
                    <!-- Cutting the string to 10 characters to remove the time section from the datetime -->
                    <?php
                        echo substr($_SESSION["Events.AllEventDateTime".$i], 0, 10);
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.AllEventDescription".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-AllVenue.VenueName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-AllEventsDateTime.StartTime".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.AllTotalTicketsBought".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-AllVenue.MaxCapacity".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-AllVenue.Address".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-AllVenue.Postcode".$i];
                    ?>
                </td>
            </tr>
            <?php
        }
    }
                    