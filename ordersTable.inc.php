<?php
    require_once 'connection.php';


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
    echo "<td>".$order['price']." $</td>";
    echo "<td>
        <select name='status[$order[orderID]]'>
            <option value='New'" . ($order['status'] == 'New' ? ' selected' : '') . ">New</option>
            <option value='In progress'" . ($order['status'] == 'In progress' ? ' selected' : '') . ">In progress</option>
            <option value='Done'" . ($order['status'] == 'Done' ? ' selected' : '') . ">Done</option>
        </select>
                        
    </td>";
    echo "</tr>";

?>