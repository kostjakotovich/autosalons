<?php

    $totalPrice = $order['price'] + $order['color_price'] + $order['transmission_price'];

    echo "<tr>";
    echo "<td>".$order['orderID']."</td>";
    echo "<td>".$order['orderDate']."</td>";
    echo "<td>".$order['name']."</td>";
    echo "<td>".$order['surname']."</td>";
    echo "<td>".$order['telephone']."</td>";    
    echo "<td>".$order['username']."</td>";
    echo "<td>".$order['email']."</td>";
    echo "<td>".$order['manufacturer']."</td>";
    echo "<td>".$order['type']."</td>";
    echo "<td>".$order['yearOfManufacture']."</td>";
    echo "<td>".$order['body_type']."</td>";
    echo "<td>".$order['transmission_type']."</td>";
    echo "<td>".$order['color']."</td>";
    echo "<td>".$order['price']." €</td>";
    echo "<td>".$order['transmission_price']." €</td>";
    echo "<td>".$order['color_price']." €</td>";
    echo "<td>".$totalPrice." €</td>";
    echo "<td>
        <select name='status[$order[orderID]]'>
            <option value='New'" . ($order['status'] == 'New' ? ' selected' : '') . ">New</option>
            <option value='In progress'" . ($order['status'] == 'In progress' ? ' selected' : '') . ">In progress</option>
            <option value='Done'" . ($order['status'] == 'Done' ? ' selected' : '') . ">Done</option>
        </select>
                        
    </td>";
    echo "<td>
        <form method='post' class='delete-order-form'>
            <input type='hidden' name='orderID' value='" . $order['orderID'] . "'>
            <button type='submit' name='deleteOrder' class='btn btn-danger btn-sm'>Delete</button>
        </form>
    </td> ";
    echo "</tr>";

?>