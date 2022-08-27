<?php
    if ($_SESSION["Orders.TotalOrders"] > 0) {
        for ($i=0; $i < $_SESSION["Orders.TotalOrders"]; $i++) {
            ?>
            <tr>
                <td>
                    <?php
                        echo $_SESSION["Orders.OrderID".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders.EventName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders.TicketName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders.TicketsOrdered".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders.AmountSpent".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders.OrderDate".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders-FirstName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders-LastName".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders-EmailAddress".$i];
                    ?>
                </td>
                <td>
                    <?php
                        echo $_SESSION["Orders-PhoneNumber".$i];
                    ?>
                </td>
                <td class="OrderStatusColour">
                    <?php
                        echo $_SESSION["Orders-OrderStatus".$i];
                    ?>
                </td>
            </tr>
            <?php
        }
    }