<?php
    if ($_SESSION["Events.CDTotalEvents"] > 0) {
        for ($i=0; $i < $_SESSION["Events.CDTotalEvents"]; $i++) {
            ?>
            <tr>
                <td>
                    <?php
                        echo $_SESSION["Events.CDEventID".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.CDEventName".$i];
                    ?>
                </td>
                <td>
                    <!-- Cutting the string to 10 characters to remove the time section from the datetime -->
                    <?php
                        echo substr($_SESSION["Events.CDEventDateTime".$i], 0, 10);
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.CDEventDescription".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-CDVenue.VenueName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-CDEventsDateTime.StartTime".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.CDTotalTicketsBought".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-CDVenue.MaxCapacity".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-CDVenue.Address".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-CDVenue.Postcode".$i];
                    ?>
                </td>
            </tr>
            <?php
        }
    }