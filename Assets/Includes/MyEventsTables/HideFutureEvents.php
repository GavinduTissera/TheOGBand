
<?php
    if ($_SESSION["Events.HFETotalEvents"] > 0) {
        for ($i=0; $i < $_SESSION["Events.HFETotalEvents"]; $i++) {
            ?>
            <tr>
                <td>
                    <?php
                        echo $_SESSION["Events.HFEEventID".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.HFEEventName".$i];
                    ?>
                </td>
                <td>
                    <!-- Cutting the string to 10 characters to remove the time section from the datetime -->
                    <?php
                        echo substr($_SESSION["Events.HFEEventDateTime".$i], 0, 10);
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.HFEEventDescription".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HFEVenue.VenueName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HFEEventsDateTime.StartTime".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events.HFETotalTicketsBought".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HFEVenue.MaxCapacity".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HFEVenue.Address".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Events-HFEVenue.Postcode".$i];
                    ?>
                </td>
            </tr>
            <?php
        }
    }